<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HeaderFavorite;
use App\DetailFavorite;
use App\Http\Resources\FavoriteProductResource;

class FavoriteProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = auth()->userOrFail();
        $faves = DetailFavorite::where('user_uuid', $user->uuid)->with('product')->paginate(15);
        return FavoriteProductResource::collection($faves);
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
        // var_dump($request->product_uuid);
        $user = auth()->userOrFail();
        // $favoriteHeader = HeaderFavorite::create([
        //     'user_uuid' => $user->uuid,
        // ]);
        $favoriteDetail = DetailFavorite::create([
            'user_uuid' => $user->uuid,
            'product_uuid' => $request->product_uuid,            
        ]);
        
        return new FavoriteProductResource($favoriteDetail);
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
        // $toUpdate = Product::find($id);
        // $toUpdate->name = $request->name;
        // $toUpdate->save();
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
