@extends('layouts.app')

@section('content')
	<div class="container profile">

		<div class="row info">
			<h1 class="title">{{ $user->name }}</h1>
		</div>
		<div class="errors">
			@if(count($errors))
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
		</div>

		<div class="row storage">
			<ul>
				<li class="box">
					<img  class="logo" src="/images/googledrive.png" alt="">
					<h3 class="title">Google Drive</h3>
					<form method="POST" action="{{ route('profile.update') }}">

						{!! method_field('patch') !!}

						{{ csrf_field() }}

						Follow this <a href="https://gist.github.com/ivanvermeyen/cc7c59c185daad9d4e7cb8c661d7b89b#setup-a-laravel-storage-driver-with-google-drive-api" target="_blank">tutorial</a>

						<div class="form-group">
							<input type="text" name="clientId" class="form-control" placeholder="Client ID" value="{{ old('clientId') }}">
						</div>

						<div class="form-group">
							<input type="text" name="clientSecret" class="form-control" placeholder="Client Secret" value="{{ old('clientSecret') }}">
						</div>

						<div class="form-group">
							<input type="text" name="refreshToken" class="form-control" placeholder="Refresh Token" value="{{ old('refreshToken') }}">
						</div>

						<div class="form-group">
							<input type="text" name="folderId" class="form-control" placeholder="Folder ID" value="{{ old('folderId') }}">
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</form>
				</li>
				<li class="box">
					<img  class="logo" src="/images/dropbox_glyph_blue.svg" alt="">
					<h3 class="title">Dropbox</h3>
						<form method="POST" action="{{ route('profile.update') }}">

							{!! method_field('patch') !!}

							{{ csrf_field() }}

							 Follow this <a href="http://www.iperiusbackup.net/en/create-dropbox-app-get-authentication-token" target="_blank">tutorial</a>
							
							<div class="form-group">
								<input type="text" name="token" class="form-control" placeholder="Token" value="{{ old('token') }}">
							</div>

							<div class="form-group">
								<input type="text" name="app_name" class="form-control" placeholder="App Name" value="{{ old('app_name') }}">
							</div>

							<hr>

							<div class="form-group">
								<button type="submit" class="btn btn-primary">Save</button>
							</div>
							
					</form>
					
				</li>
			</ul>
			
			
		</div>

	</div>

@endsection