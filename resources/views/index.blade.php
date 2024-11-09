@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <form action="" method="GET">
                <select class="custom-select custom-select" name="sort" onchange="this.form.submit()">
                    <option selected>Product Sorting</option>
                    <option value="name">Sort By Name</option>
                    <option value="price">Sort By Price</option>
                </select>
            </form>
        </div>
        <div class="col-md-6">
            <div>
                <form action="" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" placeholder="Search Products" aria-label="" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary" type="button">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6 my-auto">
                    <h6>Product List</h6>
                </div>
                <div class="col-md-6">
                    <a href="{{url('products/create')}}" class="btn btn-success float-right">Create</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <!-- Responsive table -->
            <div class="table-responsive">
                <table class="table m-0 table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Product ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Image</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->product_id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('uploads/' . $product->image) }}" alt="Product Image" width="50" height="50">
                                @else
                                    <span>No Image</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-light btn-sm">View</a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

@endsection
