@extends('layouts.app')

@section('content')
    <file-detail :file="{{$file}}"></file-detail>
@endsection