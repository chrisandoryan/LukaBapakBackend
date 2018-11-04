<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HeaderTransaction;
use App\DetailTransaction;
use App\Http\Resources\TransactionResource;
use App\CartHeader;
use App\CartDetail;
use App\Product;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addResi(Request $request, $id)
    {
        $header = HeaderTransaction::where('id', $id)->first();
        // dd($request->resi);
        $header->resi = $request->resi;
        $header->save();
        return response()->json($header);
    }

    public function index()
    {
        //
        $user = auth()->userOrFail();
        $orders = HeaderTransaction::where('seller_uuid', $user->uuid)->where('status_id', '=', null)
            ->with('detailTransactions')
            ->with('detailTransactions.product')
            ->with('user')
            ->get();

        return TransactionResource::collection($orders);
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

        $cart = CartDetail::where('user_uuid', $user->uuid)->delete();
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

        $product = Product::where('uuid', $request->product_id)->first();
        $product->stock = $product->stock - $request->amount;
        $product->save();

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
        $header = HeaderTransaction::where('id', $id)->first();
        // dd($request->status);
        $header->status_id = $request->status;
        $header->save();
    }

    public function getOrders()
    {
        $user = auth()->userOrFail();
        $orders = HeaderTransaction::where('seller_uuid', $user->uuid)
            ->where('status_id', '>', 0)
            ->with('detailTransactions')
            ->with('detailTransactions.product')
            ->with('user')
            ->get();

        return TransactionResource::collection($orders);
    }

    public function getOngoingTransactions()
    {
        $user = auth()->userOrFail();
        $trans = HeaderTransaction::where('buyer_uuid', $user->uuid)
            ->where('status_id', '>', 0) //-2 adalah selesai, -1 adalah ditolak
            ->orWhere('status_id', '=', null)
            ->with('detailTransactions')
            ->with('detailTransactions.product')
            ->with('seller')
            ->with('user')
            ->get();

        return TransactionResource::collection($trans);
    }

    public function getFinishedTransactions() 
    {
        $user = auth()->userOrFail();
        $trans = HeaderTransaction::where('buyer_uuid', $user->uuid)
            ->where('status_id', '<=', 0) //-2 adalah selesai, -1 adalah ditolak
            ->with('detailTransactions')
            ->with('detailTransactions.product')
            ->with('seller')
            ->with('user')
            ->get();

        return TransactionResource::collection($trans);
    }

    public function updateOrders()
    {

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
