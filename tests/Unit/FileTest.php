<?php

namespace Tests\Unit;

use Tests\Utilities\DatabaseTestCase;

class FileTest extends DatabaseTestCase
{
    /**
     * File.
     *
     * @var \FrontFiles\File
     */
    protected $file;

    public function setUp()
    {
        parent::setUp();
        $this->file = create('FrontFiles\File');
    }

    /** @test */
    public function a_file_has_a_creator()
    {
        $this->assertInstanceOf('FrontFiles\User', $this->file->owner);
    }

    /** @test */
    public function a_file_can_make_a_string_path()
    {
        $this->assertEquals(
            url("/files/{$this->file->short_id}"),
            $this->file->path()
        );

        $this->assertEquals(
            url("/files/{$this->file->id}"),
            $this->file->realPath()
        );
    }
}