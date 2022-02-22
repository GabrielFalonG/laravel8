@section('css')

    <style>
        #new-img {
            outline: none;
            float: left;
            margin-left: 10px;
        }
        #current-img {
            outline: none;
            float: left;
        }
    </style>

@endsection

    <div class="form-group row">
        <div class="col-md-9">
            <div class="form-group">
                {!! Form::label('name', 'Name *', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-md-10">
                    {!! Form::text('name', null, array("class" => "form-control" . ($errors->has('name') ? ' is-invalid' : '')))  !!}
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row mt-3">
        <div class="col-md-9">
            <div class="form-group">
                {!! Form::label('description', 'Description', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-md-10">
                    {!! Form::textarea('description', null, array("class" => "form-control" . ($errors->has('description') ? ' is-invalid' : '')))  !!}
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row mt-3">
        <div class="col-md-9">
            <div class="form-group">
                {!! Form::label('price', 'Price *', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-md-10">
                    {!! Form::input('number', 'price', null, array('class' => "form-control" . ($errors->has('price') ? ' is-invalid' : ''), 'step' => '0.01', 'min' => '0'))  !!}
                    @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row mt-3">
        <div class="col-md-9">
            <div class="form-group">
                {!! Form::label('photo', 'Photo', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-md-10">
                    {!! Form::file('photo', null, array("class" => "form-control" . ($errors->has('photo') ? ' is-invalid' : '')))  !!}
                    @error('photo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            @if(isset($product))

                <div class="form-group mt-3">

                    <button type="button" id="current-img" class="btn btn-outline-success inner">
                        Current photo
                    </button>

                    <button type="button" id="new-img" class="btn btn-outline-success inner" style="display: none">
                        New photo
                    </button>
                    <br><br>
                </div>

            @elseif(isset($creating) && $creating == true)

                <div class="form-group">
                    <button type="button" id="new-img" class="btn btn-outline-success inner" style="display: none">
                        New photo
                    </button>
                    <br><br>
                </div>

            @endif

        </div>
    </div>

    <div class="row text-right">
        <div class="form-group mt-2">
            <div class="col-sm-offset-2 col-sm-5">
                <a href="{{ route('product.index') }}" class="btn btn-danger" ><span class="fa fa-arrow-left" aria-hidden="true"></span> @lang('Cancel')</a>
                <button type="submit" class="btn btn-primary">@lang($btn)</button>
            </div>
        </div>
    </div>

@section('js')
    <script>
        document.getElementById("photo").onchange = function(e) {

            let reader = new FileReader();
            reader.readAsDataURL(e.target.files[0]);
            reader.onload = function(){
                document.getElementById("new-img").style.display = "block";
                
                document.getElementById("new-img").onclick = function() {
                    Swal.fire({
                        // title: 'Sweet!',
                        // text: 'Modal with a custom image.',
                        imageUrl: reader.result,
                        imageWidth: 400,
                        imageHeight: 300,
                        imageAlt: 'Custom image',
                    })
                }
            };
        }

        
        @if(isset($product))
        document.getElementById("current-img").onclick = function() {

                const url = {!! json_encode($product->photo) !!};

                Swal.fire({
                    // title: 'Sweet!',
                    // text: 'Modal with a custom image.',
                    imageUrl: url,
                    imageWidth: 400,
                    imageHeight: 300,
                    imageAlt: 'Custom image',
                });
        }
        @endif

    </script>
@endsection