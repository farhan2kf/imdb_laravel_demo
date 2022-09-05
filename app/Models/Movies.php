<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movies extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'movies';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['imdbId','rating'];

    /**
     * Get the ratings for the movie.
     */
    public function Ratings()
    {
        return $this->hasMany(\App\Models\Rating::class,'movieId','id');
    }

    /**
     * Re calculate and update avg vote rate
     * @param $movieId
     */
    public static function calculateRating($movieId){

    }
}
