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
            <h3 class="panel-title">Edit Category</h3>
        </div>
        <div class="panel-body">
            <br />
            @foreach($data as $element)
            <form method="post" action="{{ route('categories.update', [$element->id]) }}" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Name</label>
                        <div class="col-md-4">
                            <input type="text" name="name" value="{{$element->name}}" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Name (Arabic)</label>
                        <div class="col-md-4">
                            <input type="text" name="name_ar" value="{{$element->name_ar}}" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Sort Order</label>
                        <div class="col-md-4">
                            <input type="text" name="sortOrder" value="{{$element->sortOrder}}" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Parent</label>
                        <div class="col-md-4">
                            <select name="parent" class="custom-select">
                                @if(isset($element->parent))
                                <option value="{{$element->parentId}}" selected>{{$element->parentName}}</option>
                                @else
                                <option value="NULL" selected>Select Parent</option>
                                @endif
                                @foreach($cats as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                                @if(isset($element->parent))
                                <option value="NULL">Remove Parent</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Upload Image</label>
                        <div class="col-md-4">
                            <input type="file" name="image" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            @endforeach
        </div>
    </div>

</div>
@endsection