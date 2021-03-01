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
            <h3 class="panel-title">Edit Store Settings</h3>
        </div>
        <div class="panel-body">
            <br />
            <form method="post" action="{{ route('storeSettings.update', [$data->id]) }}" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <div class="form-group">
                    <div class="row border-bottom">
                        <h5>Store Logo</h5>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2 d-flex align-items-center" align="right">Upload Image</label>
                        <div class="col-md-4 d-flex align-items-center">
                            <input type="file" name="store_logo" />
                        </div>
                        <div class="col-md-6">
                            @if(isset($data->store_logo))
                            <img src="{{route('storeSettings.show', [$data->id])}}" class="img-thumbnail" width="200" />
                            @else
                            <img src="{{asset('img/placeholder.png')}}" class="img-thumbnail" width="200" />
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row border-bottom">
                        <h5>Store Info</h5>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Store Name</label>
                        <div class="col-md-10">
                            <input type="text" name="store_name" value="{{$data->store_name}}" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Address</label>
                        <div class="col-md-10">
                            <input type="text" name="address" value="{{$data->address}}" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Email</label>
                        <div class="col-md-4">
                            <input type="email" name="email" value="{{$data->email}}" class="form-control" required />
                        </div>
                        <label class="col-md-2" align="right">Phone</label>
                        <div class="col-md-4">
                            <input type="text" name="phone" value="{{$data->phone}}" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row border-bottom">
                        <h5>Social Media</h5>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Facebook</label>
                        <div class="col-md-4">
                            <input type="text" name="facebook" value="{{$data->facebook}}" class="form-control" />
                        </div>
                        <label class="col-md-2" align="right">Twitter</label>
                        <div class="col-md-4">
                            <input type="text" name="twitter" value="{{$data->twitter}}" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Whatsapp</label>
                        <div class="col-md-4">
                            <input type="text" name="whatsapp" value="{{$data->whatsapp}}" class="form-control" />
                        </div>
                        <label class="col-md-2" align="right">Instagram</label>
                        <div class="col-md-4">
                            <input type="text" name="instagram" value="{{$data->instagram}}" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">LinkedIn</label>
                        <div class="col-md-4">
                            <input type="text" name="linkedin" value="{{$data->linkedin}}" class="form-control" />
                        </div>
                        <label class="col-md-2" align="right">Youtube</label>
                        <div class="col-md-4">
                            <input type="text" name="youtube" value="{{$data->youtube}}" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row border-bottom">
                        <h5>Shipping</h5>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2" align="right">Flat Shipping</label>
                        <div class="col-md-4">
                            <input type="text" name="flat_shipping" value="{{$data->flat_shipping}}" class="form-control" required />
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