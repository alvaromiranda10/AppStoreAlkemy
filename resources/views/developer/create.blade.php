@extends('layouts.app')

@section('style')
<style>
    .custom-file-input:lang(en) ~ .custom-file-label::after {
        content: "Choose" !important;
    }
</style>
@endsection

@section('content')
    <div class="row justify-content-center">
    <div class="col-sm-8">
    <div class="card">
        <div class="card-header text-white bg-primary">
            <h1 class="text-center"><strong>Add Application</strong></h1>
        </div>
        <div class="card-body bg-light">
                    <form method="POST" action="{{ route('developer.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="name"><strong>APP NAME:</strong></label>
                            <input type="text" name="name" class="form-control" id="name" aria-describedby="nameHelp" required>
                            <small class="form-text text-muted">Remember that once the application is created, you will not be able to change its name</small>
                            <div class="invalid-feedback">
                                Enter a name.
                            </div>
                            <div>
                                @if($errors->has('name'))
                                <label class="mt-2 alert alert-warning"><strong>{{ $errors->first('name') }}</strong></label>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="category_id"><strong>SELECT A CATEGORY:</strong></label>
                            <small class="form-text text-muted mb-1">Remember that by selecting the category, you will not be able to modify it in the future</small>
                            <select class="custom-select" name="category_id" required>
                                
                                <option selected value="0" disabled="disabled">{{ __('Seleccione una opcion')}}</option>

                                @foreach($categories as $category)
                                <option value={{ $category->id }}>{{ $category->name }}</option>
                                @endforeach

                            </select>
                            <div class="invalid-feedback">
                                Select a category.
                            </div>
                            <div>
                                @if($errors->has('category_id'))
                                <label class="mt-2 alert alert-warning"><strong>{{ $errors->first('category_id') }}</strong></label>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="price">
                                <strong>ENTER A PRICE:</strong>
                            </label>
                            <input type="number" name="price" step=".01" min="0.01" max="9999.99" class="form-control" id="price" required>
                            <div class="invalid-feedback">
                                Enter a price.
                            </div>
                            <div>
                                @if($errors->has('price'))
                                <label class="mt-2 alert alert-warning"><strong>{{ $errors->first('price') }}</strong></label>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="custom-file">
                            <input class="custom-file-input" type="file" name="image_src" id="image_src" required>
                            <label class="custom-file-label" for="image_src">Upload app image</label>
                            <div class="invalid-feedback">
                                Upload an image.
                            </div>
                            <div>
                                @if($errors->has('image_src'))
                                <label class="mt-2 alert alert-warning"><strong>{{ $errors->first('image_src') }}</strong></label>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary">CREATE</button>
                        {{-- <a href="{{ url()->previous() }}" class="btn btn-danger">CANCEL</a> --}}
                        <a href="{{ route('developer.index') }}" class="btn btn-danger">CANCEL</a>
                    </form>
                </div>
            </div>
        </div>
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