<?php

namespace FrontFiles\Jobs\FileTypes;

use FrontFiles\File;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use FrontFiles\Jobs\Interfaces\FileProcessInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Video implements FileProcessInterface
{
    /**
     * The file to be processed.
     *
     * @var File
     */
    protected $file;

    /**
     * The file's temporary pre-processing name.
     *
     * @var string
     */
    protected $pre_name;

    /**
     * The file's temporary name.
     *
     * @var string
     */
    protected $tmp_name;

    /**
     * The file's new name.
     *
     * @var string
     */
    protected $processed_name;

    /**
     * Method to process the file.
     *
     * @param File $file
     */
    public function process(File $file)
    {
        $this->file             = $file;
        $name                   = $this->file->short_id.'.mp4';
        $this->pre_name         = 'pre_'.$name;
        $this->tmp_name         = 'tmp_'.$name;
        $this->processed_name   = 'processed_'.$name;

        //General
        $ffmpeg                 = env('FFMPEG');
        $source_file            = public_path('userFiles/').$this->file->name;
        $output_pre             = public_path('userFiles/').$this->pre_name;
        $output_tmp             = public_path('userFiles/').$this->tmp_name;
        $output_processed       = public_path('userFiles/').$this->processed_name;
        //Text
        $font                   = public_path('watermarks/arial_narrow.ttf');
        $text_options           = 'fontsize=20:fontcolor=White';
        //Text id
        $text_id                = 'ID\: '.$this->file->short_id;
        $text_id_position       = 'x=(w-text_w-10):y=(text_h+31)';
        //Text author
        $text_author            = $this->file->owner->fullName();
        $text_author_position   = 'x=(w-text_w-10):y=(text_h)+54';
        //Watermark + resizing + encoding + bitrate
        $watermark              = public_path('watermarks/watermark.png');
        $watermark_position     = 'main_w-overlay_w-10:10';
        $encoding               = 'libx264';
        $bitrate                = '192k';
        $scale                  = '-2:720';

        $preprocess = new Process(
            "{$ffmpeg} -i {$source_file} -lavfi '[0:v]scale=ih*16/9:-2,boxblur=luma_radius=min(h\,w)/20:luma_power=1:chroma_radius=min(cw\,ch)/20:chroma_power=1[bg];[bg][0:v]overlay=(W-w)/2:(H-h)/2,crop=h=iw*9/16' {$output_pre}"
        );
        $preprocess->setTimeout(0);
        $preprocess->run();

        if(!$preprocess->isSuccessful())
        {
            $this->clearFiles();
            throw new ProcessFailedException($preprocess);
        }

        $process1 = new Process(
            "{$ffmpeg} -i {$output_pre} -i {$watermark} -c:v {$encoding} -b:v {$bitrate} -bufsize {$bitrate} -filter_complex \"[0:v]scale={$scale}[bg];[bg][1:v]overlay={$watermark_position}\" -strict -2 {$output_tmp}"
        );
        $process1->setTimeout(0);
        $process1->run();

        if(!$process1->isSuccessful())
        {
            $this->clearFiles();
            throw new ProcessFailedException($process1);
        }

        $process2 = new Process(
            "{$ffmpeg} -i {$output_tmp} -vf \"[in]drawtext={$text_options}:fontfile='{$font}':text='{$text_id}':{$text_id_position},drawtext={$text_options}:fontfile='{$font}':text='{$text_author}':{$text_author_position}[out]\" -y -strict -2 {$output_processed}"
        );
        $process2->setTimeout(0);
        $process2->run();

        if(!$process2->isSuccessful())
        {
            $this->clearFiles();
            throw new ProcessFailedException($process2);
        }

        //Save to the blob storage
        if(config('filesystems.default') === 'azure')
            $this->sendToAzureBlobStorage();

        //Updates the file
        $this->updateFile();

        //Deletes the files locally
        $this->clearFiles();
    }

    /**
     * Saves the processed file on the blob storage.
     */
    protected function sendToAzureBlobStorage()
    {
        $processed_file = Storage::disk('local')->get($this->processed_name);

        Storage::disk('azure')->put('user-files/'.$this->processed_name, $processed_file);
    }

    /**
     * Updates the file with the URL for the preview and the processed option as true.
     */
    protected function updateFile()
    {
        $this->file->update([
            'azure_url'         => 'https://ffcontents.blob.core.windows.net/user-files/'.$this->processed_name,
            'processed_name'    => $this->processed_name,
            'processed'         => true,
        ]);
    }

    /**
     * Removes the files
     */
    protected function clearFiles()
    {
        Storage::disk('local')->delete($this->file->name);
        Storage::disk('local')->delete($this->pre_name);
        Storage::disk('local')->delete($this->tmp_name);
        Storage::disk('local')->delete($this->processed_name);
    }
}