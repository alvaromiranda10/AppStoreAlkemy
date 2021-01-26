@extends('layouts.app')

@section('content')
<div class="card">

    <div class="card-header text-white bg-primary">
        <h1 class="text-center"><strong>Edit Application</strong></h1>
    </div>

    <div class="card-body row">

        <div class="col-md-6 col-sm-12 col-xs-12">
                <img src="{{ asset('images/' .$application->image_src)  }}" class="card-img" alt="{{ $application->name }}">
        </div>

        <div class="col-md-6 col-sm-12 col-xs-12">
            <form method="POST" action="{{ route('developer.update', $application->id)}}" class="needs-validation" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="Name:"><strong></strong></label>
                    <input type="text" name="name" class="form-control text-center" id="name" disabled value="{{ $application->name }}">
                    <small class="form-text text-muted">The name of the app cannot be updated after creating it.</small>
                </div>
                <hr>
                <div class="form-group">
                    <label for="Categorie"><strong></strong></label>
                    <input type="text" name="category_id" class="form-control  text-center" id="category_id" disabled value={{ $application->categories->name }}>
                    <small class="form-text text-muted">The category of the app cannot be updated after creating it.</small>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="price" class="col-sm-5 col-form-label">
                        <strong class="text-muted">Enter a price:</strong>
                    </label>
                    <div class="col-sm-7">
                        <input type="number" name="price" step=".01" min="0.01" max="9999.99" class="form-control" id="price" value="{{ $application->price}}" required>
                        <div class="invalid-feedback">
                            Ingresar un precio.
                        </div>
                    </div>
                    <div>
                        @if($errors->has('price'))
                        <label class="mt-2 alert alert-warning"><strong>{{ $errors->first('price') }}</strong></label>
                        @endif
                    </div>
                </div>
                
                <hr>
                <div class="custom-file">
                    <input class="custom-file-input" type="file" name="image_src" id="image_src">
                    <label class="custom-file-label" for="image_src">Upload app image</label>
                    <div>
                        @if($errors->has('image_src'))
                        <label class="mt-2 alert alert-warning"><strong>{{ $errors->first('image_src') }}</strong></label>
                        @endif
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">UPDATE</button>
                <a href="{{ route('developer.index') }}" class="btn btn-danger">CANCEL</a>
            </form>
        </div>
    </div>
</div>

@endsection

    @section('script')
    <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
        });
    }, false);
    })();

        $('input[name=image_src]').on('click',function(){
            $(this).val('');
            $(this).next('.custom-file-label').html("Upload app image");
        });

         $('input[name=image_src]').on('change',function(){
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

    </script>
@endsection