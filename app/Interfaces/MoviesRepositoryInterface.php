<?php

namespace App\Interfaces;

interface MoviesRepositoryInterface
{
    public function getMovies(string $searchTerm);
    public function getMovieDetails(string $movieId);
}
