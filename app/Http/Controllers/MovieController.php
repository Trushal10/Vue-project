<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieCreateRequest;
use App\Http\Requests\MovieEditRequest;
use App\Models\Movie;
use App\Helper\CommonHelper;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;


class MovieController extends Controller
{
    public function index()
    {
        return inertia('Movie/Index', [
            'movies' => Movie::get(),
        ]);
    }
    public function store(MovieCreateRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        if ($request->file('image')) {
            $data['image'] = CommonHelper::uploadFile($request->file('image'), 'movie');
        }
        Movie::create($data);
        return redirect()
            ->route('movie.index')
            ->with('message', 'Movies created successfully');
    }
    public function edit(Movie $movie) {
        // $movie = Movie::find($id);
        return response()->json($movie);
    }

    public function update(MovieCreateRequest $request, Movie $movie)
    {
        $data = $request->validated();
        // Handle multiple file uploads
        if ($request->file('image')) {
            $data['image'] = CommonHelper::uploadFile($request->file('image'),'movie', $movie->image);
        }
        $movie->update($data);
        return redirect()->route('movie.index')->with('message', 'Movie updated successfully');
    }

    public function destroy(Movie $movie)
    {
        CommonHelper::removeOldFile('public/movie/' . $movie->image);
        $movie->delete();
        return redirect()->route('movie.index')->with('message', 'Movie updated successfully');
    }
}
