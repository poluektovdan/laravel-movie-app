<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\ViewModels\MoviesViewModel;
use App\ViewModels\MovieViewModel;

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
        
        $genres = Http::withToken(config('services.tmdb.token'))
            ->get("https://api.themoviedb.org/3/genre/movie/list")
            ->json()['genres'];

        $viewModel = new MoviesViewModel(
            $popular_movies,
            $now_playing_movies,
            $genres,
        );

        return view("index", $viewModel);
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

        $viewModel = new MovieViewModel($movie);

        return view('show', $viewModel);
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
