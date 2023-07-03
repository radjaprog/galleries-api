<?php

namespace App\Http\Controllers;

// namespace Illuminate\Contracts\Auth;

use App\Http\Requests\CreateGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Gallery;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

class GalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Gallery::with('images');
        $page = $request->query('page', 1);

        return Gallery::with('images')->paginate(Gallery::PER_PAGE, ['*'], 'page', $page);
    }

    public function getMyGalleries(Request $request)
    {
        if (!auth()->user()) {
            return response()->json([
                'message' => 'Must be logged in'
            ], 401);
        }
        $page = $request->query('page', 1);

        return Gallery::with(['comments'])->where('user_id', auth()->user()->id)->paginate(Gallery::PER_PAGE, ['*'], 'page', $page);
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
            'user_id' => Auth::id()
        ]);

        if (isset($validatedData['images'])) {
            $images = [];

            foreach ($validatedData['images'] as $imageData) {
                $image = Image::create([
                    'image_url' => $imageData['image_url'],
                    'gallery_id' => $gallery->id,
                ]);

                $images[] = $image;
            }

            $gallery->images()->saveMany($images);
        }

        return $gallery;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Gallery::with(['images', 'comments', 'user'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryRequest $request, $id)
    {
        $validatedData = $request->validated();

        $gallery = Gallery::find($id);
        if ($gallery === null) {
            return response()->json([
                'message' => 'Please enter valid ID, {$id} does not exist'
            ], 404);
        } else {
            $gallery->update([
                'name' => request('name'),
                'content' => request('content'),
                'image_url' => request('image_url'),
                'user_id' => Auth::id()
            ]);

            if (isset($validatedData['images'])) {
                $images = [];

                foreach ($validatedData['images'] as $imageData) {
                    $image = Image::create([
                        'image_url' => $imageData['image_url'],
                        'gallery_id' => $gallery->id,
                    ]);

                    $images[] = $image;
                }

                $gallery->images()->saveMany($images);
            }

            $gallery->save();

            return $gallery;
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return response()->json(Gallery::findOrFail($id)->delete());
    }
}
