<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HeaderTransaction;
use App\DetailTransaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
    public function addHeader(Request $request) 
    {
        $user = auth()->userOrFail();
        // var_dump($request->seller_id);
        $header = HeaderTransaction::create([
            'seller_uuid' => $request->seller_id,
            'buyer_uuid' => $user->uuid,
            'status_id' => 0,
            'delivery_address' => $request->address,
        ]);

        return response()->json($header);
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
        $user = auth()->userOrFail();
    
        $detail = DetailTransaction::create([
            'header_id' => $request->header_id,
            'product_uuid' => $request->product_id,
            'amount' => $request->amount,
        ]);
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
    }
}
