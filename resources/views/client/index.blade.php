@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.13.0/css/all.css">
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
    <div class="row justify-content-center">
        <div class="col-11">
            <h1 class="text-secondary"><strong>My Cart</strong></h1>
            <table class="table table-responsive table-dark table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Image</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-secondary">
                    @foreach ($cart_app as $item)
                    <tr id="{{ $item->id }}">
                        <th>{{ $item->id }}</th>
                        <th>{{ $item->name }}</th>
                        <th class="w-25">
                            <img src="{{ asset('images/' .$item->image_src)  }}" class="img-fluid img-thumbnail" alt="example">
                        </th>
                        <th>{{ $item->price }}</th>
                        <th>
                            <button class="btn btn-danger removeBuy" data-id="{{ $item->id }}" >
                                <i class="fas fa-trash-alt"></i>
                                delete
                            </button>
                        </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="col-11">
            <h2><strong>My wish list</strong></h2>
            <table id="table-wish-list" class="table table-responsive table-dark table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Image</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wish_list_app as $item2)
                    <tr data-id="{{ route('client.appdetail',$item2->id) }}">
                        <th>{{ $item2->id }}</th>
                        <th>
                            {{ $item2->name }}
                        </th>
                        <th class="w-25">
                            <img src="{{ asset('images/' .$item2->image_src)  }}" class="img-fluid img-thumbnail" alt="example">
                        </th>
                        <th>{{ $item2->price }}</th>
                        <th>
                            <form method="POST" action="{{ route('client.delete.wish') }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="application_id" value="{{ $item2->id }}">
                            <button class="btn btn-danger" type="submit">
                                <i class="fas fa-trash-alt"></i>
                                delete
                            </button>
                            </form>
                        </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection


@section('script')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.rawgit.com/rikmms/progress-bar-4-axios/0a3acf92/dist/index.js"></script>

<script type="text/javascript">
    loadProgressBar();
    $( "body" ).on( "click", "#table-wish-list tbody tr", function(e) {
        window.location.href = e.currentTarget.dataset.id;
    });

    const removeBuyApp = async (e) => {
        try {
            let res = await axios.delete("{{ route('client.delete.buy') }}", {
            data:
            {
                application_id: e.target.dataset.id
            }});

            console.log(res.data);
            container = document.getElementById("container-msj");
            container.hidden =false;
            container.lastElementChild.textContent = res.data;
            document.getElementById(e.target.dataset.id).remove();
        } catch (error) {
            console.log(error);
        }
    }
    
    $( ".removeBuy" ).click(removeBuyApp);
</script>
    
@endsection
