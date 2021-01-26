@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.13.0/css/all.css">
    <style>
        .card:hover{
            box-shadow: 0 25px 20px 0 rgba(0,0,0,.16), 0 -1px 2px 0 rgba(0,0,0,.1);
        }

        .text-lowercase:first-letter{
            text-transform: uppercase;
        }
        
        .card-img{
            height: 200px;
        }
        
        .card-footer{
            border-top:0;
        }
        
        @media (max-width: 575.98px) { 
            .container{
                padding-left: 40px;
                padding-right: 40px;
            }
            
            .card-img{
                height: 250px;
            }
            
        }
    </style>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('client.categories')}}">Categories</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
    </ol>
</nav>
    <div class="row justify-content-center">
        @foreach ($applications as $application)
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-3">
            <div class="card">
                <div class="card-img">
                    <img class="card-img-top img-fluid h-100" src="{{ asset('images/' .$application->image_src)  }}" alt="Card image cap">
                </div>
                <div class="card-header">
                    <h4 class="text-center text-lowercase">{{ $application->name }}</h4>       
                </div>
                <div class="card-body">
                    <h6 class="card-title text-secondary">$ {{ $application->price }}</h6>
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="5"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <small class="text-muted">245</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('client.appdetail' ,$application->id) }}" class="btn btn-info stretched-link">Ver detalle</a>
                </div>
            </div>
        </div>
        @endforeach
        
    </div>
    <div class="d-flex justify-content-center">
        {{ $applications->links() }}
    </div>
@endsection