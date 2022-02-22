@extends('layouts.app')

@section('title', 'Create product')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Creating new product</h2>
                    </div>

                    <div class="card-body">
                        {!! Form::open(array('route' => 'product.store', 'class' => 'form-horizontal', 'files' => true)) !!}
                            @include('product.shared.form', ['btn' => 'Save', 'creating' => true])
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection