<?php

namespace App\Repositories;

use App\Interfaces\MoviesRepositoryInterface;
use GuzzleHttp\Client;

class ImdbRepository implements MoviesRepositoryInterface
{
    public function getMovies(string $searchTerm)
    {
        $client = new Client();
        $response = $client->get("https://api.collectapi.com/imdb/imdbSearchByName?query=$searchTerm" ,[
            'headers' => [
                "authorization" => "apikey ".env("COLLECTAPI_KEY"),
                "cache-control" => "no-cache",
                "content-type" => "application/json",
            ]
        ]);
        return $response->getBody()->getContents();
    }

    public function getMovieDetails(string $movieId)
    {
        $client = new Client();
        $response = $client->get("https://api.collectapi.com/imdb/imdbSearchById?movieId=$movieId" ,[
            'headers' => [
                "authorization" => "apikey ".env("COLLECTAPI_KEY"),
                "cache-control" => "no-cache",
                "content-type" => "application/json",
            ]
        ]);
        return $response->getBody()->getContents();
    }
}
