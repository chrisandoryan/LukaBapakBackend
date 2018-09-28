<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PromoResource;
use App\HeaderPromotion;
use App\DetailPromotion;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // dd(DetailPromotion::with(['headerPromotion', 'product'])->get());
        // return PromoResource::collection(DetailPromotion::with(['headerPromotion', 'product'])->get());
        // dd(HeaderPromotion::find(1)->get()->detailPromotion());
        return PromoResource::collection(HeaderPromotion::all());
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
        if ($request->has('promo_name')) {
            // var_dump($request->promo_name);
            $promo = HeaderPromotion::create([
                'name' => $request->promo_name,
            ]);
        }
        else if ($request->has('promo_id') && $request->has('product_uuid')) {
            // dd($request->product_uuid);
            $promo = DetailPromotion::create([
                'header_id' => $request->promo_id,
                'product_uuid' => $request->product_uuid,
            ]);
            return response()->json(['message' => 'OK']);
        }
        return new PromoResource($promo);
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
