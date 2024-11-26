<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Helper\CommonHelper;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class MovieController extends Controller
{
    public function index()
    {
        return inertia('Movie/Index', [
            'movies' => Movie::get(),
        ]);
    }
    public function upload($file, $path)
    {
        return $file;
    }
    public function store(Request $request)
    {
        // Validate the incoming data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'release_date' => 'required|date',
            'price' => 'required|numeric',
            'number' => 'required|integer',
            'image' => 'required|max:2048', // Validate each file in the array
            'description' => 'required|string',
            'status' => 'required|boolean',
        ]);
        dd($data);
        // Handle multiple file uploads
        if ($request->file('image')) {
            $data['image'] = CommonHelper::uploadFile($request->file('image'), 'movie');
        }

        // Save to the database
        Movie::create($data);

        return redirect()
            ->route('movie.index')
            ->with('message', 'Movies created successfully');
    }


    public function edit($id)
    {
        $movie = Movie::find($id);
        return response()->json($movie);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'release_date' => 'required',
            'price' => 'required',
            'number' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $movie = Movie::find($id);
        $movie->update($request->all());
        return redirect()->route('movie.index')->with('message', 'Movie updated successfully');
    }

    public function destroy($id)
    {
        Movie::find($id)->delete();
        return redirect()->route('movie.index')->with('message', 'Movie updated successfully');
    }
}
