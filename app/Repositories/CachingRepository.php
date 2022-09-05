<?php
namespace App\Repositories;

use App\Interfaces\MoviesRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use App\Events\MovieFetchedFromCache;

class CachingRepository implements MoviesRepositoryInterface
{

    protected $movies;

    public function __construct(MoviesRepositoryInterface $movies)
    {
        $this->movies = $movies;
    }

    public function getMovies(string $searchTerm)
    {
        return Cache::remember("search.{$searchTerm}", env('CACHE_LIMIT',60), function () use ($searchTerm) {
            //Cache & increment api limit counter so we dont hit api more than the limit set in .env file
            Cache::add('api.limit', 0, 86400);
            //Increment api limit on each request
            Cache::increment('api.limit', 1);

            //If api limit is not reached then fetch from api otherwise return null
            if(env('API_LIMIT',1000)>=Cache::get('api.limit')) {
                return $this->movies->getMovies($searchTerm);
            }
            return null;
        });
    }

    public function getMovieDetails(string $movieId)
    {
        if (Cache::has("movie.{$movieId}")) {
            MovieFetchedFromCache::dispatch($movieId);
        }
        return Cache::remember("movie.{$movieId}", env('CACHE_LIMIT',60), function () use ($movieId) {
            //Cache & increment api limit counter so we dont hit api more than the limit set in .env file
            Cache::add('api.limit', 0, 86400);
            //Increment api limit on each request
            Cache::increment('api.limit', 1);

            //If api limit is not reached then fetch from api otherwise return null
            if(env('API_LIMIT',1000)>=Cache::get('api.limit')) {
                return $this->movies->getMovieDetails($movieId);
            }
            return null;
        });
    }

}
