@extends('base')

@section('main')
<div class="container">
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
    <br />

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Edit Featured Category</h3>
        </div>
        <div class="panel-body">
            <br />
            <form method="post" action="{{ route('featuredCategories.update', [$data->id]) }}" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Category</label>
                        <div class="col-md-4">
                            <select onchange="getProducts(this.value)" class="form-control" id="categories" name="category" required>
                                <option value="">Select</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($category->id == $data->category)selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Featured Product</label>
                        <div class="col-md-4">
                            <select class="form-control" id="featured_products" name="featured_product">
                                <option value="">Select</option>
                                @foreach($products as $product)
                                <option value="{{$product->id}}" @if($product->id == $data->featured_product)selected @endif>{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Products Limit</label>
                        <div class="col-md-4">
                            <input value="{{$data->products_limit}}" type="number" name="products_limit" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Sort Order</label>
                        <div class="col-md-4">
                            <input value="{{$data->sortOrder}}" type="number" name="sortOrder" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Upload Banner</label>
                        <div class="col-md-4">
                            <input type="file" name="banner" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Upload Featured Image</label>
                        <div class="col-md-4">
                            <input type="file" name="featured_img" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection