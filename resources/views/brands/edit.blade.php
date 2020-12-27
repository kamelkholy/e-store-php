@extends('base')

@section('main')
<div align="center" class="container">
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
            <h3 class="panel-title">Edit Brand</h3>
        </div>
        <div class="panel-body">
            <br />
            @foreach($data as $element)
            <form method="post" action="{{ route('brands.update', [$element->id]) }}" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">Name</label>
                        <div class="col-md-8">
                            <input type="text" name="name" value="{{$element->name}}" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">Sort Order</label>
                        <div class="col-md-8">
                            <input type="text" name="sortOrder" value="{{$element->sortOrder}}" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">Upload Image</label>
                        <div class="col-md-8">
                            <input type="file" name="image" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary-outline">Submit</button>
                </div>
            </form>
            @endforeach
        </div>
    </div>

</div>
@endsection