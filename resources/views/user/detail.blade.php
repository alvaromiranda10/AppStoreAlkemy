@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb ">
      <li class="breadcrumb-item"><a href="{{ route('user.categories')}}">Categories</a></li>
      <li class="breadcrumb-item"><a href="{{ route('user.appcategory', $application->category_id) }}">{{ $application->categories->name }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $application->name }}</li>
    </ol>
</nav>
    <div id="container-msj" class="alert alert-dismissable alert-info" hidden>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>
        </strong>
    </div>
    <div class="card mb-3" style="max-width: 100%;">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="{{ asset('images/' .$application->image_src) }}" class="card-img" alt="{{ $application->name }}">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                        <h4 class="card-title">{{ $application->name }}</h4>
                    <hr>                    
                    <div class="row align-items-center">
                        <div class="col-12">
                            <p class="text-muted">PRICE: <strong class="text-dark">${{ $application->price }}</strong></p>
                        </div>
                        <div class="col-4">
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="5"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">245</small>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="btn-group">
                        @guest
                        <a href="{{ route('register')}}" class="btn btn-primary">Register</a>
                        <a href="{{ route('login')}}" class="ml-2 btn btn-secondary">Login</a>    
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection