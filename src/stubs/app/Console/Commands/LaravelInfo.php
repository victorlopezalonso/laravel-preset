<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LaravelInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows the environment information';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $vars = [
            'APP_NAME' => '',
            'APP_KEY'  => '',
            'APP_HASH' => '',
            'APP_URL'  => '',
        ];

        foreach ($vars as $key => $value) {
            $vars[$key] = env($key);
        }

        $this->table(array_keys($vars), [$vars]);
    }
}
