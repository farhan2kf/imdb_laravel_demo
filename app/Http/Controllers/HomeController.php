<?php

namespace App\Http\Controllers;

use App\Interfaces\MoviesRepositoryInterface;
use App\Services\MovieService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private MoviesRepositoryInterface $moviesRepository;

    public function __construct(MoviesRepositoryInterface $moviesRepository)
    {
        $this->moviesRepository = $moviesRepository;
    }

    /**
     * Show the IMDB search form
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Search IMDb API for the movie name searched by user and return results
     * @param $request
     * @return json response
     */
    public function search(Request $request): JsonResponse{
        $term = $request->post("search");

        return response()->json([
            'data' => $this->moviesRepository->getMovies($term)
        ]);
    }

    /**
     * Search IMDb API for the movie name searched by user and return results
     * @param $request
     * @return json response
     */
    public function autocomplete(Request $request): JsonResponse{
        $term = $request->get('term');
        $result=$this->moviesRepository->getMovies($term);
        $output=[];
        if($result){
            $results=json_decode($result)->result;
            $i=0;
            foreach($results as $row){
                if($i==3){
                    break;
                }
                $temp_array = [];
                $temp_array['value'] = $row->Title;
                $temp_array['label'] = '<a href="'.url('title/'.$row->imdbID).'"><img src="'.$row->Poster.'" width="50" />&nbsp;&nbsp;&nbsp;'.$row->Title.'</a><br>'.$row->Year;
                $output[] = $temp_array;
            $i++;}

            $temp_array = [];
            $temp_array['value'] = '';
            $temp_array['label'] = '<a href="javascript:void(0)" onClick="return viewAll()">View All</a>';
            $output[]=$temp_array;
        }else{
            $output['value'] = '';
            $output['label'] = 'No Record Found';
        }

        return response()->json($output);
    }

    /**
     * Show details of the movie id passed in url
     * @param $movieId
     */
    public function details(MovieService $movieService,$imdbId){
        $details=$this->moviesRepository->getMovieDetails($imdbId);
        if($details==""){
            return "Movie details not available, please try again later.";
        }
        $data['movieId']=$imdbId;
        $data["details"]=json_decode($details);
        $data['movieRating']=$movieService->getMovieRating($imdbId);
        $data['userRating']=$movieService->getUserMovieRating($imdbId,session()->getId());
        return view('detail',$data);
    }

    /**
     * save rating given by user on movie
     * @param $movieId
     * @param $rating
     */
    public function saveRating(MovieService $movieService, $movieId, $rating) :JsonResponse{

        $movie=$movieService->updateOrCreateMovie(
            ['imdbId' => $movieId]
        );
        $movieService->updateorCreateRating(
            ['movieId' => $movie->id, 'sessionId' => session()->getId()],
            ['rating' => (int) $rating]
        );

        return response()->json([
            'status' => "success"
        ]);
    }

}
