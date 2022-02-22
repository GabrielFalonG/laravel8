@extends('layouts.app')

@section('title', 'Product list')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @include('layouts.messages')

                <div class="card">
                    <div class="card-header">Products</div>

                    <div class="card-body">
                          
                        <table class="table">
                            <thead class="thead-light">
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th class="text-center" scope="col">Description</th>
                                <th scope="col">Price</th>
                                <th class="text-center" scope="col">Photo</th>
                                <th scope="col">Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <th scope="row">{{ $product->id }}</th>
                                        <td>{{ $product->name }}</td>
                                        <td class="text-center">{{ $product->description ?: '-' }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td class="text-center">
                                            @if ($product->photo)
                                                <img src="{{ asset($product->photo) }}" width="50" height="50">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @include('product.shared.actions', ['product' => $product])
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%">
                                            <center>No results.</center>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                          </table>
                          <div class="text-center">
                            {!! $products->appends(Request::except('page'))->render() !!}
                          </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection