<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\CartDetail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CartExport;

class CartController extends Controller
{
    public function export()
    {
        $user = auth()->userOrFail();
        return Excel::download(new CartExport($user), 'users.xlsx');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = auth()->userOrFail();
        return CartResource::collection(CartDetail::where('user_uuid', $user->uuid)->with('product')->with('product.user')->paginate(15));

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
        // $favoriteHeader = HeaderFavorite::create([
        //     'user_uuid' => $user->uuid,
        // ]);
        $cart = CartDetail::create([
            'user_uuid' => $user->uuid,
            'product_uuid' => $request->product_uuid,
            'amount' => $request->amount,            
        ]);
        
        return new CartResource($cart);
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
