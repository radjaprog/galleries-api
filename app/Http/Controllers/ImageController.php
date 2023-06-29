<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateImageRequest;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = Image::all();

        return $images;
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
    public function store(CreateImageRequest $request)
    {
        $validatedData = $request->validated();

        $user = auth()->user();
        if (!$user->gallery) {
            return response()->json(["message" => "User does not have a gallery!"], 422);
        }

        $image = Image::create([
            'image_url' => $validatedData['image_url'],
            'gallery_id' => $user->gallery->id
        ]);

        return $image;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $image = Image::findOrFail($id);

        return $image;
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        return response()->json(Image::findOrFail($id)->delete());
    }
}
