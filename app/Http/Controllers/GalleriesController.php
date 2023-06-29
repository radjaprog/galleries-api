<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Gallery;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

class GalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::all();

        return $galleries;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(CreateGalleryRequest $request)
    {

        $validatedData = $request->validated();

        $gallery = Gallery::create([
            'name' => $validatedData['name'],
            'content' => $validatedData['content'],
            'user_id' => auth()->id()
        ]);

        return $gallery;
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);

        return $gallery;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryRequest $request, $id)
    {
        $validatedData = $request->validated();

        $gallery = Gallery::find($id);

        if ($gallery === null) {
            return response("Please enter valid id, id{$id} does not exist, Response::HTTP_NOT_FOUND");
        } else {
            $gallery->update([
                'name' => $validatedData['name'],
                'content' => $validatedData['content'],
                'user_id' => auth()->id()
            ]);
        };
        $gallery->save();

        return $gallery;
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $gallery = Gallery::findOrFail($id);
        // $gallery->delete();

        // return
        //     response()->json([
        //         "status" => "success",
        //     ]);

        return response()->json(Gallery::findOrFail($id)->delete());
    }
}
