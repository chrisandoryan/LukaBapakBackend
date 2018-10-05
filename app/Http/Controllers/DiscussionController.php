<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HeaderDiscussion;
use App\Http\Resources\DiscussionResource;
use App\DetailDiscussion;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $discussions = HeaderDiscussion::where('product_uuid', $request->product_uuid)
                                            ->with('detailDiscussion')
                                            ->with('detailDiscussion.user')
                                            ->with('detailDiscussion.child')
                                            ->with('detailDiscussion.child.user')->get();

        return DiscussionResource::collection($discussions);
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
        $header = HeaderDiscussion::where('product_uuid', $request->product_uuid)->first();
        if (!$header) {
            $header = HeaderDiscussion::create([
                'product_uuid' => $request->product_uuid,
            ]);
        }
        $user = auth()->userOrFail();
        // dd($request->message);
        $detail = DetailDiscussion::create([
            'header_id' => $header->id,
            'user_uuid' => $user->uuid,
            'parent_id' => $request->parent_id != "null" ? $request->parent_id : null,
            'message' => $request->message,
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
