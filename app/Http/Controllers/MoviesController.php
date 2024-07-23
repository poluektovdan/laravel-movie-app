<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $popular_movies = Http::withToken(config('services.tmdb.token'))
            ->get("https://api.themoviedb.org/3/movie/popular")
            ->json()['results'];

        $now_playing_movies = Http::withToken(config('services.tmdb.token'))
            ->get("https://api.themoviedb.org/3/movie/now_playing")
            ->json()['results'];
        
        $genres_array = Http::withToken(config('services.tmdb.token'))
            ->get("https://api.themoviedb.org/3/genre/movie/list")
            ->json()['genres'];

        $genres = collect($genres_array)->mapWithKeys(function ($genre){
            return [$genre['id'] => $genre['name']];
        });

        return view("index", [
            "popularMovies"=> $popular_movies,
            "nowPlayingMovies"=> $now_playing_movies,
            "genres"=> $genres
        ]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $movie= Http::withToken(config('services.tmdb.token'))
            ->get("https://api.themoviedb.org/3/movie/{$id}?append_to_response=credits,videos,images")
            ->json();

        return view("show",[
            'movie'=>$movie
        ]);
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
    public function destroy(string $id)
    {
        //
    }
}
