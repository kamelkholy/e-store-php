<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderStatus;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(Request $request)
    {
        if ($request->query('search_key')) {
            $data = (new Order())->search($request->query('search_key'))->sortable()->paginate(10)->withQueryString();
        } else {
            $data = Order::sortable()->paginate(10)->withQueryString();
        }
        return view('orders.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->back()->with('success', 'Order Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Order::findOrFail($id);
        $data->products = json_decode($data->products);
        $orderStatus = OrderStatus::where('order', $data->id)->orderBy('ordering')->get();
        $statusTemplate = array_fill(0, 4 - count($orderStatus), '');
        return view('orders.edit', ['data' => $data, 'orderStatus' => $orderStatus, 'statusTemplate' => $statusTemplate]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'staff_notes'  => 'required',
        ]);
        $order = Order::findOrFail($id);
        $order->staff_notes = $request->staff_notes;
        $order->save();
        return redirect()->route('orders.index')->with('success', 'Order Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $order = Order::findOrFail($id);
        // $order->delete();
        // return redirect()->route('orders.index')->with('success', 'Order Updated Successfully');
    }
    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'message'  => 'required',
        ]);
        $order = Order::findOrFail($id);
        $orderStatus = OrderStatus::where('order', $id)->orderBy('ordering')->get();
        $ordering = 0;
        $status = '';
        foreach ($orderStatus as $key => $value) {
            $ordering = $value->ordering;
        }
        $ordering += 1;
        switch ($ordering) {
            case 1:
                $status = 'shipped';
                break;
            case 2:
                $status = 'enroute';
                break;
            case 3:
                $status = 'delivered';
                break;
        }
        $order->status = $status;
        $order->save();
        $orderStatusData = array(
            'status' => $status,
            'success' => true,
            'ordering' => $ordering,
            'order' => $id,
            'message' => $request->message,
        );
        OrderStatus::create($orderStatusData);
        return redirect()->route('orders.index')->with('success', 'Order Updated Successfully');
    }
}
