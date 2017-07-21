<?php

namespace Tests\Unit;

use Tests\Utilities\DatabaseTestCase;

class UserTest extends DatabaseTestCase
{
    /**
     * User.
     *
     * @var \FrontFiles\User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = create('FrontFiles\User');
    }

    /** @test */
    public function a_user_has_files()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->files);
    }
}