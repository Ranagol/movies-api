<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use Illuminate\Http\JsonResponse;
use Validator;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //example for a  url request: /movies?take=10&skip=5&title=night
        $title = request()->input('title');//take the title from the url request
        $skip = request()->input('skip', 0);//take the skip value from the url request
        $take = request()->input('take', Movie::count());//take the take value from the url request

        if ($title) {//if title exists in url...
            return Movie::search($title, $skip, $take);//...search by title, return pagination
        } else {
            return Movie::skip($skip)->take($take)->get();//...or return paginated response
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
        $validatedData = $request->validate([
            'title' => 'required|unique:movies|max:255',
            'director' => 'required',
            'duration' => 'required|integer|min:1|max:500',
            'releaseDate' => 'required|unique:movies',
            'imageUrl' => 'required|url',
        ]);

        $movie = new Movie();
        $movie->title = $request->title;
        $movie->director = $request->director;
        $movie->imageUrl = $request->imageUrl;
        $movie->duration = $request->duration;
        $movie->releaseDate = $request->releaseDate;
        $movie->genre = $request->genre;
        $movie->save();
        return $movie;
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Movie::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $validatedData = $request->validate([
            'title' => 'required|unique:movies|max:255',
            'director' => 'required',
            'duration' => 'required|integer|min:1|max:500',
            'releaseDate' => 'required|unique:movies',
            'imageUrl' => 'required|url',
        ]);

        $movie = Movie::findOrFail($id);
        $movie->title = $request->title;
        $movie->director = $request->director;
        $movie->imageUrl = $request->imageUrl;
        $movie->duration = $request->duration;
        $movie->releaseDate = $request->releaseDate;
        $movie->genre = $request->genre;
        $movie->save();
        return $movie;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        $movie->delete();
        return new JsonResponse(true);
    }
}
