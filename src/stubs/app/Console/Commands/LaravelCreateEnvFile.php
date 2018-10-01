<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LaravelCreateEnvFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel:create-env-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a copy of the .env.example file';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        copy('.env.example', '.env');

        $this->line('.env file successfully created');
    }
}
