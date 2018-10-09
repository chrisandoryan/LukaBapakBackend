<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Category;
use Intervention\Image\Facades\Image as Img;
use App\Image;

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
        } else if ($request->has('search')) {
            $products = Product::searchByQuery(array('match' => array('name' => $request->search)));
            return ProductResource::collection($products);
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
        $user = auth()->userOrFail();
        Product::unguard();
        $product = Product::create([
            'id' => 999,
            'user_id' => 999,
            'category_uuid' => $request->category_id,
            'user_uuid' => $user->uuid,
            'sold_count' => 0,
            'video_url' => 'https://youtube.com/dmaumdshai',
            'assurance' => 1,
            'bl_id' => 'aaa',
            'url' => 'uuu',
            'name' => $request->name,
            'city' => $request->city,
            'province' => $request->province,
            'price' => $request->price,
            'weight' => $request->weight,
            'description' => $request->description,
            'product_condition' => $request->condition,
            'stock' => $request->stock,
            'view_count' => 0,
        ]);

        Product::reguard();

        $image = $request->get('image');
        $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        Img::make($image)->save(public_path('images/').$name);

        $upload = Image::create([
            'product_uuid' => $product->uuid,
            'product_id' => 999,
            'url' => "http://localhost:8000/api/images/" . $name,
            'filename' => $name,
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
        // $product->visit();
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
