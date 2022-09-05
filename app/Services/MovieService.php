<?php

namespace App\Services;
use App\Repositories\MoviesRepository;
use App\Repositories\RatingRepository;
use App\Jobs\calculateRating;

class MovieService
{
    protected $moviesRepository, $ratingRepository;

    public function __construct(MoviesRepository $moviesRepository, RatingRepository $ratingRepository)
    {
        $this->moviesRepository=$moviesRepository;
        $this->ratingRepository=$ratingRepository;
    }

    /**
     * Create or update movie in db
     * @param array $data
     */
    public function updateOrCreateMovie(array $data){
        return $this->moviesRepository->updateOrCreateMovie($data);
    }

    /**
     * create or update rating in db
     * @param array $data
     */
    public function updateorCreateRating(array $where, array $data){
        $rating=$this->ratingRepository->updateOrCreateRating($where,$data);
        calculateRating::dispatch($rating->movieId);
    }

    public function getMovieRating($movieId){
        $movie=$this->moviesRepository->findMovie($movieId);
        if($movie){
            return $movie->rating;
        }
        return false;
    }

    public function getUserMovieRating($movieId,$sessionId){
        $movie=$this->moviesRepository->findMovie($movieId);
        if($movie){
            $rating=$this->ratingRepository->getUserRating($movie->id,$sessionId);
            if($rating){
                return $rating->rating;
            }
        }
        return false;
    }

    public function calculateRating($movieId){
        $rating = $this->ratingRepository->getMovieRatings($movieId);
        $this->moviesRepository->updateRating($movieId,$rating);
    }

    public function recalculateAllMovies(){
        $movies = $this->moviesRepository->get();
        foreach($movies as $movie){
            $this->calculateRating($movie->id);
        }
    }
}
