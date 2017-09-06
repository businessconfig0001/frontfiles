<?php

namespace Tests\Feature;

use Tests\Utilities\DatabaseTestCase;

class ManageFilesTest extends DatabaseTestCase
{
    /** @test */
    public function guests_may_not_create_files()
    {
        //Activate exception handling
        $this->withExceptionHandling();

        //When a guest tries to see the file, it's expected to get redirected to the login page
        $this->get(route('files'))
            ->assertRedirect(route('auth.login'));

        //When a guest tries to post a new file, it's expected to get redirected to the login page
        $this->post(route('files'))
            ->assertRedirect(route('auth.login'));
    }

    /** @test */
    public function guests_may_not_see_files()
    {
        //Activate exception handling
        $this->withExceptionHandling();

        //When a guest tries to upload a file, it's expected to get redirected to the login page
        $this->get(route('files.upload'))
            ->assertRedirect(route('auth.login'));
    }

    /** @test */
    public function an_authenticated_user_can_upload_new_files()
    {
        //Creates a user (and logs in the user)
        $this->signIn();

        //Now the user can see the file related pages
        $this->get(route('files'))
            ->assertStatus(200);
        $this->get(route('files.upload'))
            ->assertStatus(200);
    }

    /** @test */
    public function unauthorized_users_may_not_delete_files()
    {
        //Activate exception handling
        $this->withExceptionHandling();

        //Creates a thread.
        $file = create('FrontFiles\File');

        //Submit json request to the proper endpoint.
        $this->delete($file->realPath())
            ->assertRedirect(route('auth.login'));

        //Creates and logs in a user and then submit json request to the proper endpoint.
        $this->signIn();
        $this->delete($file->realPath())
            ->assertStatus(403);
    }
}