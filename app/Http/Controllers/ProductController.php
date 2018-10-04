<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Category;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->has('category')) {
            try {
                $category = Category::find($request->category);
                $products = Product::where('category_uuid', $category->uuid)->paginate(15);

                return ProductResource::collection($products);
            }
            catch (\Exception $e) {
                return response()->json(['message' => $e]);
            }
            //get products by search keyword
        } else {
            //return paginated products
            return ProductResource::collection(Product::with('category')->with('user.city')->paginate(15));
        }
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
        $product = Product::create([
            'category_id' => $request->category_id,
            'user_id' => $request->user()->id,
            'sold_count' => $request->sold_count,
            'video_url' => $request->video_url,
            'assurance' => $request->assurance,
            'bl_id' => $request->bl_id,
            'url' => $request->url,
            'name' => $request->name,
            'city' => $request->city,
            'province' => $request->province,
            'price' => $request->price,
            'weight' => $request->weight,
            'description' => $request->description,
            'product_condition' => $request->product_condition,
            'stock' => $request->stock,
            'view_count' => $request->view_count,
        ]);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        if ($request->user()->id !== $product->user_id) {
            return response()->json(['error' => 'You can only edit your own products.'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();

        return response()->json(null, 204);
    }
}
