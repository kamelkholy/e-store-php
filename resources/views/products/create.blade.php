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
            <h3 class="panel-title">Add Product</h3>
        </div>
        <div class="panel-body">
            <br />
            <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Name</label>
                        <div class="col-md-4">
                            <input type="text" name="name" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Name (Arabic)</label>
                        <div class="col-md-4">
                            <input type="text" name="name_ar" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Sort Order</label>
                        <div class="col-md-4">
                            <input type="text" name="sortOrder" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Brand</label>
                        <div class="col-md-4">
                            <select class="form-control" id="brands" name="brand">
                                @foreach($brands as $brand)
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Category</label>
                        <div class="col-md-4">
                            <select class="form-control" id="categories" name="category">
                                @foreach($categories as $category)
                                {{$category->level}}
                                <option value="{{$category->id}}">
                                    @if($category->level == 0)
                                    {{$category->name}}
                                    @else
                                    {{$categoriesNames[$category->id]}}
                                    @endif
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Type</label>
                        <div class="col-md-4">
                            <select class="form-control" id="brands" name="brand">
                                @foreach($types as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">
                            <h5>Specifications</h5>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <thead style="white-space: nowrap;">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Value *</th>
                                    </tr>
                                </thead>
                                <tbody id="specifications" class="text-center">
                                    <tr>
                                        <td colspan="2"> Select a Type</td>
                                    </tr>
                                </tbody>
                            </table>
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