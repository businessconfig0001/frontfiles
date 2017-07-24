<?php

namespace Tests\Unit;

use FrontFiles\Inspections\AvailableSpace\AvailableSpace;
use Tests\Utilities\DatabaseTestCase;

class StorageSpaceTest extends DatabaseTestCase
{
    /**
     * File inspector.
     *
     * @var AvailableSpace
     */
    protected $available_space;

    public function setUp()
    {
        parent::setUp();
        $this->available_space = new AvailableSpace();
    }

    /** @test */
    public function a_new_user_should_have_10GiB_of_space()
    {
        //Create a user
        $user = create('FrontFiles\User');

        //Checks if the default value is 10GiB
        $this->assertEquals(10737418240, $user->allowed_space);

        //Since this user doesn't have any files, he should have the initial 10GiB
        $this->assertEquals(10737418240, $user->amountOfSpaceLeft());
    }

    /** @test */
    public function a_user_can_only_upload_files_as_long_as_he_has_enough_free_space_to_1()
    {
        //Creates a user (and logs in the user) and a file
        $this->signIn();
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 10737418237]);

        //Should return true
        $this->assertTrue($this->available_space->check(1));
        //Should return true
        $this->assertTrue($this->available_space->check(2));
        //Should return true
        $this->assertTrue($this->available_space->check(3));

        //Should throw an exception
        $this->expectException('Exception');
        $this->available_space->check(4);
    }

    /** @test */
    public function a_user_can_only_upload_files_as_long_as_he_has_enough_free_space_to_2()
    {
        //Creates a user (and logs in the user) and a few files
        $this->signIn();
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 2147483648]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 2147483647]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 2147483648]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 2147483648]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 2147483648]);

        //Should return true
        $this->assertTrue($this->available_space->check(1));

        //Should throw an exception
        $this->expectException('Exception');
        $this->available_space->check(2);
    }

    /** @test */
    public function a_user_can_only_upload_files_as_long_as_he_has_enough_free_space_to_3()
    {
        //Creates a user (and logs in the user) and a few files
        $this->signIn();
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 2147483648]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 2147483648]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 2147483648]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 2147483648]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 2147483648]);

        //Should throw an exception
        $this->expectException('Exception');
        $this->available_space->check(1);
    }

    /** @test */
    public function a_user_can_only_upload_files_as_long_as_he_has_enough_free_space_to_4()
    {
        //Creates a user (and logs in the user) and a few files
        $this->signIn();
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 15000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 1500000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 1500000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 1500000000]);
        create('FrontFiles\File', ['user_id' => auth()->user()->id, 'size' => 1500000000]);

        //Should return true
        $this->assertTrue($this->available_space->check(15000000));
        //Should return true
        $this->assertTrue($this->available_space->check(150000000));

        //Should throw an exception
        $this->expectException('Exception');
        $this->available_space->check(15737418240);
    }
}