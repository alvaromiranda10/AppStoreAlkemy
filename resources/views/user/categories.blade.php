@extends('layouts.app')
@section('style')
    <style>
        .btn-lg{
            font-size: 1.3rem;
        }
    </style>
@endsection

@section('content')
        @foreach($categories as $category)
        <a href="{{ route('user.appcategory', $category->id)}}" class="btn btn-outline-primary btn-lg">
            {{ $category->name }} <span class="badge badge-primary">{{ $category->applications_count }}</span>
        </a>
        @endforeach
@endsection