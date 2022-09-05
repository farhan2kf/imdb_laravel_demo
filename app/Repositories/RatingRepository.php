<?php

namespace App\Repositories;

use App\Models\Rating;

class RatingRepository{

    /**
     * @var rating
     */
    protected $rating;

    /**
     * RatingRepository constructor.
     * @param Rating $rating
     */
    public function __construct(Rating $rating)
    {
        $this->rating=$rating;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function updateOrCreateRating($where, $data){
        return $this->rating::updateOrCreate($where,$data);
    }

    public function getMovieRatings($id){
        return $this->rating::where('movieId',$id)->avg('rating');
    }

    public function getUserRating($movieId,$sessionId){
        return $this->rating::where('movieId',$movieId)->where('sessionId',$sessionId)->first();
    }

}
