<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\MovieService;

class calculateRating implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $movieId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($movieId)
    {
        $this->movieId=$movieId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(MovieService $movieService)
    {
        $movieService->calculateRating($this->movieId);
        return true;
    }
}
