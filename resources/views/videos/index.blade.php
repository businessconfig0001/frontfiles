@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">

            @forelse($videos as $video)
                <div class="vid">
                    <p>Title: {{ $video->title }}</p>
                    <p>Filename: {{ $video->filename }}</p>
                </div>
            @empty
                <p>There are no relevant results at this time.</p>
            @endforelse

        </div>
    </div>

@endsection
