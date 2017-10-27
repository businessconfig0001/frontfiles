<?php

namespace FrontFiles\Jobs\FileTypes;

use FrontFiles\File;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use FrontFiles\Jobs\Interfaces\FileProcessInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Image implements FileProcessInterface
{
    /**
     * The file to be processed.
     *
     * @var File
     */
    protected $file;

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
     * @throws \Symfony\Component\Process\Exception\LogicException
     * @throws \Symfony\Component\Process\Exception\RuntimeException
     * @throws \Symfony\Component\Process\Exception\ProcessFailedException
     * @throws \Symfony\Component\Process\Exception\InvalidArgumentException
     */
    public function process(File $file)
    {
        $this->file = $file;
        $this->new_name = 'processed_' . $this->file->name;

        //General
        $imagemagick            = env('IMAGEMAGICK');
        $source_file            = public_path('userFiles/').$this->file->name;
        $output_final           = public_path('userFiles/').$this->new_name;
        //Text
        $font                   = public_path('watermarks/arial_narrow.ttf');
        //Text id
        $text_id                = 'ID\: '.$this->file->short_id;
        $text_id_position       = '+10+45';
        //Text author
        $text_author            = $this->file->owner->fullName();
        $text_author_position   = '10,73';
        //Watermark + resizing
        $watermark              = public_path('watermarks/watermark.png');
        $scale                  = '1280x720';

        $process = new Process(
            "{$imagemagick} {$source_file} -scale {$scale} -background gray30 -gravity center -extent {$scale} -background transparent {$watermark} -gravity northeast -geometry +10+10 -composite -background transparent -pointsize 20 -font {$font} -fill white label:'{$text_id}' -gravity northeast -geometry {$text_id_position} -draw \"font '{$font}' gravity northeast fill white text {$text_author_position} '{$text_author}'\" -composite {$output_final}"
        );
        $process->setTimeout(0);
        $process->run();

        if(!$process->isSuccessful())
        {
            $this->clearFiles();
            throw new ProcessFailedException($process);
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
        $processed_file = Storage::disk('local')->get($this->new_name);

        Storage::disk('azure')->put('user-files/'.$this->new_name, $processed_file);
    }

    /**
     * Updates the file with the URL for the preview and the processed option as true.
     */
    protected function updateFile()
    {
        $this->file->update([
            'azure_url'         => 'https://ffcontents.blob.core.windows.net/user-files/' . $this->new_name,
            'processed_name'    => $this->new_name,
            'processed'         => true,
        ]);
    }

    /**
     * Removes the files
     */
    protected function clearFiles()
    {
        Storage::disk('local')->delete([
            $this->file->name,
            $this->new_name,
        ]);
    }
}