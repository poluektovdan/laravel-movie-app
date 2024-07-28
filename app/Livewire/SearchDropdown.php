<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SearchDropdown extends Component
{
    public $search = '';

    public function render()
    {
        $search_results = [];

        if (strlen($this->search) >= 2) {
            $search_results = Http::withToken(config('services.tmdb.token'))
                ->get("https://api.themoviedb.org/3/search/movie?query={$this->search}")
                ->json()['results'];
        }

        return view('livewire.search-dropdown', [
            'searchResults' => collect($search_results)->take(7),
        ]);
    }
}
