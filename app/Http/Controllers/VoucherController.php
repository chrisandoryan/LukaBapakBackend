<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Img;
use App\Http\Resources\VoucherResource;
use App\Voucher;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return VoucherResource::collection(Voucher::all());
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
        $image = $request->get('image');
        $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        Img::make($image)->save(public_path('vouchers/').$name);

        $voucher = Voucher::create([
            'code' => $request->code,
            'name' => $request->name,
            'price_cut' => $request->price_cut,
            'image_url' => $name,
        ]);

        return VoucherResource::collection($voucher->get());
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
    
    public function checkVoucher($code) {
        $status = true;
        $message = "";
        $voucher = Voucher::where('code', $code)->first();
        if (!$voucher) {
            $message = "Voucher not available";
            $status = false;
        }
        return response()->json(['message' => $message, 'status' => $status, 'voucher' => $voucher]);
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
        // dd($request->new_price);
        $voucher = Voucher::find($id);
        $voucher->price_cut = $request->new_price;
        $voucher->save();
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
        $voucher = Voucher::where('uuid', $id);
        $voucher->delete();
        return response()->json(['message' => 'OK']);
    }
}
