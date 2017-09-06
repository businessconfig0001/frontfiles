<?php

namespace FrontFiles\Jobs\FileTypes;

use FrontFiles\File;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use FrontFiles\Jobs\Interfaces\FileProcessInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Videos implements FileProcessInterface
{
    /**
     * The file to be processed.
     *
     * @var File
     */
    protected $file;

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
    protected $new_name;

    /**
     * Method to process the file.
     *
     * @param File $file
     * @param string $tmp_name
     * @param string $new_name
     */
    public function process(File $file, string $tmp_name, string $new_name)
    {
        $this->file = $file;
        $this->tmp_name = $tmp_name;
        $this->new_name = $new_name;

        //General
        $ffmpeg                 = env('FFMPEG');
        $source_file            = public_path('userFiles/').$file->name;
        $output_temp            = public_path('userFiles/').$tmp_name;
        $output_final           = public_path('userFiles/').$new_name;
        //Text
        $font                   = public_path('watermarks/arial_narrow.ttf');
        $text_options           = 'fontsize=10:fontcolor=White';
        //Text author
        $text_author            = $file->owner->fullName();
        $text_author_position   = 'x=(w-text_w-10):y=(text_h)+20';
        //Text id
        $text_id                = 'ID\: '.$file->short_id;
        $text_id_position       = 'x=(w-text_w-10):y=(text_h+35)';
        //Watermark + resizing + encoding + bitrate
        $watermark              = public_path('watermarks/watermark.png');
        $watermark_position     = 'main_w-overlay_w-10:10';
        $encoding               = 'libx264';
        $bitrate                = '192k';
        $scale                  = '-1:360';

        $process1 = new Process(
            "{$ffmpeg} -i {$source_file} -i {$watermark} -c:v {$encoding} -b:v {$bitrate} -bufsize {$bitrate} -filter_complex \"[0:v]scale={$scale}[bg];[bg][1:v]overlay={$watermark_position}\" -strict -2 {$output_temp}"
        );
        $process1->run();

        if(!$process1->isSuccessful())
        {
            $this->clearFiles();
            throw new ProcessFailedException($process1);
        }

        $process2 = new Process(
            "{$ffmpeg} -i {$output_temp} -vf \"[in]drawtext={$text_options}:fontfile='{$font}':text='{$text_author}':{$text_author_position},drawtext={$text_options}:fontfile='{$font}':text='{$text_id}':{$text_id_position}[out]\" -y -strict -2 {$output_final}"
        );
        $process2->run();

        if(!$process2->isSuccessful())
        {
            $this->clearFiles();
            throw new ProcessFailedException($process2);
        }
    }

    /**
     * Removes the files
     */
    protected function clearFiles()
    {
        Storage::disk('local')->delete($this->file->name);
        Storage::disk('local')->delete($this->new_name);
        Storage::disk('local')->delete($this->tmp_name);
    }
}