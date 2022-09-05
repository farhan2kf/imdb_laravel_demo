<?php

namespace App\Repositories;

use App\Models\Movies;

class MoviesRepository{

    /**
     * @var movies
     */
    protected $movies;

    /**
     * MoviesRepository constructor.
     * @param Movies $movies
     */
    public function __construct(Movies $movies)
    {
        $this->movies=$movies;
    }

    public function findMovie($movieId){
        return $this->movies::where("imdbId",$movieId)->first();
    }

    public function updateOrCreateMovie($data){
        return $this->movies::updateOrCreate($data);
    }


    public function updateRating($movieId,$rating){
        $movie=$this->movies::find($movieId);
        if($movie){
            $movie->update(['rating'=>$rating]);
        }
    }

    public function get(){
        return $this->movies::get();
    }

}
