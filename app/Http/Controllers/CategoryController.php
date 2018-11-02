<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\ReverseCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function allCategories() 
    {
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }
    public function index()
    {
        //
        $categories = Category::where('parent_uuid', null)->get();

        return CategoryResource::collection($categories);
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
        if ($request->parent_uuid == "null") {
            $category = Category::create([
                'parent_uuid' => null,
                'name' => $request->category_name,
            ]);
        } else {
            $category = Category::create([
                'parent_uuid' => $request->parent_uuid,
                'name' => $request->category_name,
            ]);
        }
        return new CategoryResource($category);
    }

    public function getNested(Request $request) {
        $id = $request->leaf;
        return ReverseCategory::where('uuid', $id)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        // $voucher = Voucher::where('uuid', $id);
        $category->delete();
        return response()->json(['message' => 'OK']);
    }
}
