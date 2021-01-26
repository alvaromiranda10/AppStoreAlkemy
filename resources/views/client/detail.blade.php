@extends('layouts.app')

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/rikmms/progress-bar-4-axios/0a3acf92/dist/nprogress.css" />
<style>
    #nprogress .bar {
    background: green !important;
    height: 5px !important;
    }

    #nprogress .peg {
        box-shadow: 0 0 10px green, 0 0 5px green !important;
    }

    #nprogress .spinner-icon {
        border-top-color: green !important;
        border-left-color: green !important;
    }
</style>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('client.categories')}}">Categories</a></li>
      <li class="breadcrumb-item"><a href="{{ route('client.appcategory', $application->category_id) }}">{{ $application->categories->name }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $application->name }}</li>
    </ol>
</nav>
    @if(!empty(Session::get('msj')))
    <div class="alert alert-dismissable alert-info fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>
            {{ Session::get('msj') }}
        </strong>
    </div>
    @endif
    <div id="container-msj" class="alert alert-dismissable alert-info fade show" role="alert" hidden>
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
                        @auth
                            @if ( empty($verifyBuy->cart_app->id) && empty($verifyWish->wish_list_app->id) )
                            <button data-id="{{ $application->id }}" id="buy" type="button" class="btn btn-primary" >Buy</button>
                            <form id="wish" method="POST" action="{{ route('client.wish') }}">
                                @csrf
                                <input type="hidden" name="application_id" value="{{ $application->id }}">
                                <button class="ml-2 btn btn-secondary" type="submit">
                                    Add to wish
                                </button>
                            </form>
                            @elseif ( empty($verifyBuy->cart_app->id) )
                            <button data-id="{{ $application->id }}" id="buy" type="button" class="btn btn-primary" >Buy</button>
                            @else
                            <div class="alert alert-success" role="alert">
                                Purchased
                            </div>
                            @endif
                        @endauth
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

@section('script')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.rawgit.com/rikmms/progress-bar-4-axios/0a3acf92/dist/index.js"></script>
<script type="text/javascript">
    loadProgressBar();

    const buyApp = async (e) => {

        try {
            let res = await axios.post("{{ route('client.buy')}}", {
                application_id: e.target.dataset.id
            });

            e.target.disabled = true;
            container = document.getElementById("container-msj");
            container.hidden =false;
            container.lastElementChild.textContent = res.data;
            if(document.getElementById("wish") != null){
                document.getElementById("wish").remove();
            }

        } catch (error) {
            console.log(error);
        }
    }
    
    $( "#buy" ).click(buyApp);
</script>
    
@endsection