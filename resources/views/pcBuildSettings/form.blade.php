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
            <h3 class="panel-title">Edit PC Build Settings</h3>
        </div>
        <div class="panel-body">
            <br />
            <form method="post" action="{{ route('pcBuildSettings.update', [$data->id]) }}" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}

                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">Processor</label>
                        <div class="col-md-8">
                            <select class="form-control" id="processors" name="processor">
                                <option value="0">None</option>

                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($category->id == $data->processor)selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">Motherboard</label>
                        <div class="col-md-8">
                            <select class="form-control" id="motherboards" name="motherboard">
                                <option value="0">None</option>

                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($category->id == $data->motherboard)selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">Ram</label>
                        <div class="col-md-8">
                            <select class="form-control" id="rams" name="ram">
                                <option value="0">None</option>

                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($category->id == $data->ram)selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">Primary Storage</label>
                        <div class="col-md-8">
                            <select class="form-control" id="primary_storage" name="primary_storage">
                                <option value="0">None</option>

                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($category->id == $data->primary_storage)selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">Secondary Storage</label>
                        <div class="col-md-8">
                            <select class="form-control" id="secondary_storage" name="secondary_storage">
                                <option value="0">None</option>

                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($category->id == $data->secondary_storage)selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">Graphics Card</label>
                        <div class="col-md-8">
                            <select class="form-control" id="gpu" name="gpu">
                                <option value="0">None</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($category->id == $data->gpu)selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">PC Case</label>
                        <div class="col-md-8">
                            <select class="form-control" id="tower" name="tower">
                                <option value="0">None</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($category->id == $data->tower)selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">Case Cooler</label>
                        <div class="col-md-8">
                            <select class="form-control" id="tower_cooler" name="tower_cooler">
                                <option value="0">None</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($category->id == $data->tower_cooler)selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">Optical Drive (CD ROM)</label>
                        <div class="col-md-8">
                            <select class="form-control" id="optical_drive" name="optical_drive">
                                <option value="0">None</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($category->id == $data->optical_drive)selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">CPU Cooler</label>
                        <div class="col-md-8">
                            <select class="form-control" id="cpu_cooler" name="cpu_cooler">
                                <option value="0">None</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($category->id == $data->cpu_cooler)selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">Power Supply</label>
                        <div class="col-md-8">
                            <select class="form-control" id="power_supply" name="power_supply">
                                <option value="0">None</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($category->id == $data->power_supply)selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">Monitor</label>
                        <div class="col-md-8">
                            <select class="form-control" id="monitor" name="monitor">
                                <option value="0">None</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($category->id == $data->monitor)selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">Keyboard</label>
                        <div class="col-md-8">
                            <select class="form-control" id="keyboard" name="keyboard">
                                <option value="0">None</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($category->id == $data->keyboard)selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">Mouse</label>
                        <div class="col-md-8">
                            <select class="form-control" id="mouse" name="mouse">
                                <option value="0">None</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($category->id == $data->mouse)selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4" align="right">Headphone</label>
                        <div class="col-md-8">
                            <select class="form-control" id="headphone" name="headphone">
                                <option value="0">None</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($category->id == $data->headphone)selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
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