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
            <h3 class="panel-title">Edit Order</h3>
        </div>
        <div class="panel-body">
            <br />

            <div class="form-group">
                <div class="row">
                    <h5>Order Tracking</h5>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="container px-1 px-md-4 py-5 mx-auto">
                        <div class="card">
                            <div class="row d-flex justify-content-between px-3 top">
                                <div class="d-flex">
                                    <h5>ORDER <span class="text-primary font-weight-bold">#{{$data->id}}</span></h5>
                                </div>
                                <div class="d-flex flex-column text-sm-right">
                                </div>
                            </div> <!-- Add class 'active' to progress -->
                            <div class="row d-flex justify-content-center">
                                <div class="col-12">
                                    <ul id="progressbar" class="text-center">
                                        <?php
                                        $lastStatus = 0;
                                        ?>
                                        @foreach($orderStatus as $status)
                                        <?php
                                        $lastStatus = $status->ordering;
                                        ?>
                                        @if($status->success)
                                        <li class="active step0"></li>
                                        @else
                                        <li class="fail step0"></li>
                                        @endif
                                        @endforeach
                                        @foreach ($statusTemplate as $temp)
                                        <li class="step0"></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                            <form method="POST" action="{{route('orders.changeStatus', $data->id)}}">
                                <div class="row justify-content-between top">
                                    <div class="row d-flex icon-content">
                                        <div class="d-flex flex-column">
                                            <p class="font-weight-bold">Order<br>Processed</p>
                                        </div>
                                    </div>
                                    @csrf
                                    <div class="row d-flex icon-content">
                                        <div class="d-flex flex-column">
                                            <p class="font-weight-bold">Order<br>Shipped</p>
                                            <br>

                                        </div>

                                    </div>
                                    <div class="row d-flex icon-content">
                                        <div class="d-flex flex-column">
                                            <p class="font-weight-bold">Order<br>En Route</p>
                                            <br>


                                        </div>
                                    </div>
                                    <div class="row d-flex icon-content">
                                        <div class="d-flex flex-column">
                                            <p class="font-weight-bold">Order<br>Delivered</p>
                                            <br>

                                        </div>
                                    </div>

                                </div>
                                <div class="row top">

                                    @if ($lastStatus == 0)
                                    <button class="btn btn-sm btn-primary">Mark as Shipped</button>
                                    <div class="col-md p-3">
                                        <input placeholder="Message" name="message" class="form-control" type="text" required>
                                    </div>
                                    @endif
                                    @if ($lastStatus == 1)
                                    <button class="btn btn-sm btn-primary">Mark as EnRoute</button>
                                    <div class="col-md p-3">
                                        <input placeholder="Message" name="message" class="form-control" type="text" required>
                                    </div>
                                    @endif
                                    @if ($lastStatus == 2)
                                    <button class="btn btn-sm btn-primary">Mark as Delivered</button>
                                    <div class="col-md p-3">
                                        <input placeholder="Message" name="message" class="form-control" type="text" required>
                                    </div>
                                    @endif
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <h5>Customer Data</h5>
                </div>
            </div>
            <div class="container px-1 px-md-4 py-5 mx-auto">
                <div class="card p-4">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2" align="right">First Name:</label>
                            <div class="col-md-4">
                                {{$data->first_name}}
                            </div>
                            <label class="col-md-2" align="right">Last Name:</label>
                            <div class="col-md-4">
                                {{$data->last_name}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2" align="right">Email:</label>
                            <div class="col-md-4">
                                {{$data->email}}
                            </div>
                            <label class="col-md-2" align="right">Phone:</label>
                            <div class="col-md-4">
                                {{$data->phone}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2" align="right">City:</label>
                            <div class="col-md-4">
                                {{$data->city}}
                            </div>
                            <label class="col-md-2" align="right">Address:</label>
                            <div class="col-md-4">
                                {{$data->address}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <h5>Order Details</h5>
                </div>
            </div>
            <div class="container px-1 px-md-4 py-5 mx-auto">
                <div class="card p-4">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2" align="right">Order Sub Total:</label>
                            <div class="col-md-4">
                                {{$data->sub_total}}
                            </div>
                            <label class="col-md-2" align="right">Order Total:</label>
                            <div class="col-md-4">
                                {{$data->total}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2" align="right">Order Shipping:</label>
                            <div class="col-md-4">
                                {{$data->shipping_fees}}
                            </div>
                            <label class="col-md-2" align="right">Order Quantity:</label>
                            <div class="col-md-4">
                                {{$data->quantity}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2" align="right">Payment Method:</label>
                            <div class="col-md-4">
                                {{$data->payment_method}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4" align="right">Customer Message:</label>
                            <div class="col-md-8">
                                {{$data->customer_message}}
                            </div>
                        </div>
                    </div>
                    <form method="post" action="{{ route('orders.update', [$data->id]) }}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2" align="right">Staff Message:</label>
                                <div class="col-md-10">
                                    <input name="staff_notes" value="{{$data->staff_notes}}" class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <h5>Products</h5>
                </div>
            </div>
            <div class="container px-1 px-md-4 py-5 mx-auto">
                <div class="card p-4">
                    <table class="table">
                        <thead>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Selling Price</th>
                            <th>Quantity</th>
                        </thead>
                        <tbody>
                            @foreach ($data->products as $product)
                            <tr>
                                <td>{{isset($product->name)?$product->name:''}}</td>
                                <td>{{$product->price}}</td>
                                <td>
                                    @if(isset($product->final_price))
                                    {{$product->final_price}}
                                    @else
                                    {{$product->price}}
                                    @endif
                                </td>
                                <td>{{$product->quantity}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<link rel="stylesheet" href="{{asset('css/orderTracking.css')}}">

@endsection