@extends('backend.layouts.app')

@section('content')

    <br><br>

    <h2>Welcome back, {{ $user->fullName() }}!</h2>

    <br>

    <table class="table table-bordered table-striped table-hover table-sm">
        <thead>
        <tr>
            <th>ID</th>
            <th>Uploaded at</th>
            <th>Name</th>
            <th>Type</th>
            <th>Processed</th>
            <th>Where</th>
            <th>When</th>
            <th>Owner</th>
        </tr>
        </thead>
        <tbody>

            @forelse($files as $file)
                <tr>
                    <th scope="row">{{ $file->id }}</th>
                    <td>{{ $file->created_at }}</td>
                    <td><a href="{{ $file->path() }}" target="_blank">{{ $file->name }}</a></td>
                    <td>{{ $file->type }}</td>
                    <td>{{ $file->processed ? 'Yes' : 'No' }}</td>
                    <td>{{ $file->where }}</td>
                    <td>{{ $file->when }}</td>
                    <td><a href="{{ $file->owner->path() }}" target="_blank">{{ $file->owner->fullName() }}</a></td>
                </tr>
            @empty
                <tr>There are no results to display at the moment.</tr>
            @endforelse

        </tbody>
    </table>

    {{ $files->links() }}

@endsection