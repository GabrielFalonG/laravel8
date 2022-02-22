@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="font-size: 20px">
                    Welcome
                </div>

                <div class="card-body">
                    <div style="font-size: 50px">
                        <b> {{ \Auth::user()->name }} </b>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
