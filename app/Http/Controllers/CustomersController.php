<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(Request $request)
    {
        if ($request->query('search_key')) {
            $data = (new Customer())->search($request->query('search_key'))->sortable()->paginate(10)->withQueryString();
        } else {
            $data = Customer::sortable()->paginate(10)->withQueryString();
        }
        return view('customers.list', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email'  => 'required|unique:customers',
            'password'  => 'required|min:6|regex:/^(?=.*[A-Za-z])(?=.*\d)[a-zA-Z\d@$!%*?&]{6,}$/|confirmed',
        ]);
        $form_data = array(
            'name'  => $request->name,
            'email'  => $request->email,
            'password'  => Hash::make($request->password),
        );
        Customer::create($form_data);
        return redirect()->back()->with('success', 'Customer Created Successfully');
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
        $data = Customer::findOrFail($id);
        return view('customers.edit', compact('data'));
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
            'name'  => 'required',
            'password'  => 'min:6|regex:/^(?=.*[A-Za-z])(?=.*\d)[a-zA-Z\d@$!%*?&]{6,}$/|confirmed',
        ]);
        $customer = Customer::findOrFail($id);
        $customer->name = $request->name;
        if (isset($request->password)) {
            $customer->password = Hash::make($request->password);
        }
        $customer->save();
        return redirect('/customers')->with('success', 'Customer Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        $customer->delete();
        return redirect('/customers')->with('success', 'Customer Updated Successfully');
    }
}
