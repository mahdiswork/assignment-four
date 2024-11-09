@extends('layouts.app')

@section('content')
    <div>
        <div class="form-group">
            <label for="product_id">Product ID</label>
            <input type="text" class="form-control" id="product_id" name="product_id" value="{{ $product->product_id }}" disabled>
        </div>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" disabled>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" disabled>{{ $product->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" disabled>
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" disabled>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            @if($product->image)
                <div class="mt-2">
                    <img src="{{ asset('uploads/' . $product->image) }}" alt="Product Image" width="100">
                </div>
            @endif
        </div>
        <div class="mt-2">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection
