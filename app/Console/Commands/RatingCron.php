<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MovieService;

class RatingCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rating:recalculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate avg rating of all movies twice a day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(MovieService $movieService)
    {
        $movieService->recalculateAllMovies();
        return 0;
    }
}
