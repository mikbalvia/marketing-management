<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\User;
use App\Models\Status;
use App\Models\StatusCustomer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::user()->role=='admin') {
            $customer = Customer::all();
        }else{
            $customer = Customer::where('agent_id',Auth::user()->id)->get();
        }

        return view('index', compact('customer'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $agent= User::where('role','agent')->get();
        return view('create', compact('agent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'agent_id' => ['required','numeric'],
            'name' => ['required'],
            'email' => ['required', 'unique:customers'],
            'phone' => ['required','numeric'],

        ]);

        if ($validator->fails()) {
            return redirect('customer/create')
                ->withErrors($validator)
                ->withInput();
        }else{
            Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'agent_id' => $request->agent_id
            ]);

            return back()->with('success','You have successfully created customer.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $status=Status::all();
        $agent= User::where('role','agent')->get();
        $customer=Customer::find($id);
        $statusCustomer=StatusCustomer::where('customer_id',$id)->with('statusDetail')->orderBy('created_at', 'desc')->get();
        //return $statusCustomer;
        return view('edit', compact('agent','customer','status','statusCustomer'));
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
        //
        $isAdmin=false;
        if (Auth::user()->role=='admin') {
            $isAdmin=true;
        }
        $validator = Validator::make($request->all(), [
            'agent_id' => $isAdmin ? ['required','numeric'] : [],
            'name' => $isAdmin ? ['required'] : [],
            'email' => $isAdmin ? ['required', 'unique:customers,email,'.$id] : [],
            'phone' => $isAdmin ? ['required','numeric'] : [],
            'status_follow_up'=>$isAdmin ? [] : ['required'],
            'remark' => $isAdmin ? [] : ['required']

        ]);

        if ($validator->fails()) {
            return redirect('customer/'.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        }else{
            if ($isAdmin) {
                $customer=Customer::find($id);
                $customer->name = $request->name;
                $customer->email = $request->email;
                $customer->phone = $request->phone;
                $customer->agent_id = $request->agent_id;
                $customer->save();
            }else{
                StatusCustomer::create([
                    'customer_id' => $id,
                    'status_id' => $request->status_follow_up,
                    'remark' => $request->remark
                ]);
            }




            return back()->with('success','You have successfully update customer.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Customer::destroy($id);
        return back()->with('success','You have successfully delete customer.');
    }
}
