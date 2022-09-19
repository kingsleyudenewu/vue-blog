<?php

namespace App\Console\Commands;

use App\Services\ExternalPostService;
use Illuminate\Console\Command;

class ImportExternalPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'external-post:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import external post from the admin user other blogs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new ExternalPostService())->execute();
    }
}
