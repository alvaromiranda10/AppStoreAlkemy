@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.13.0/css/all.css">
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- TEST begin --}}
            @if(!empty(Session::get('success')))
            <div class="alert alert-dismissable alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>
                    {{ Session::get('success') }}
                </strong>
            </div>
            {{-- <div class="alert alert-success"> {{ Session::get('success') }}</div> --}}
            @endif
            {{-- TEST end --}}
            <div class="card">
                <div class="card-header d-flex">
                    <strong class="mr-auto p-2">{{ __('Dashboard:') }}</strong>
                    <a class="btn btn-primary" href="{{ Route('developer.create')}}">Create</a>
                </div>
                <div class="card-body">
                    <table class="table table-responsive">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">nombre</th>
                                <th scope="col">imagen</th>
                                <th scope="col">categoria</th>
                                <th scope="col">precio</th>
                                <th scope="col">votos</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applications as $application)
                                
                            <tr>
                                <th>{{ $application->id }}</th>
                                <th>{{ $application->name }}</th>
                                <th class="w-25">
                                    <a href="#" class="pop">
                                        <img src="{{ asset('images/' .$application->image_src)  }}" class="img-fluid img-thumbnail" alt="example">
                                    </a>
                                </th>
                                <th>{{ $application->categories->name }}</th>
                                <th>{{ $application->price }}</th>
                                <th>{{ $application->votes }}</th>
                                <th>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Actions
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item text-secondary" href="{{ route('developer.edit' , $application->id) }}">
                                                <i class="fas fa-edit"></i>
                                                edit
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form method="POST" action="{{ route('developer.destroy' , $application->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item text-danger" type="submit">
                                                <i class="fas fa-trash-alt"></i>
                                                delete
                                            </button>
                                            </form>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    
                    
                </div>
            </div>

        </div>
    </div>


     <!-- MODAL VIEW IMAGEN -->
     <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">              
              <img src="" class="imagepreview" style="width: 100%;" >
          </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.pop').on('click', function() {
			$('.imagepreview').attr('src', $(this).find('img').attr('src'));
			$('#imagemodal').modal('show');   
	});
    </script>
@endsection
