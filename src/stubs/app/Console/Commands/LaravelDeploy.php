<?php

namespace App\Console\Commands;

use App\Classes\Console;
use Illuminate\Console\Command;

class LaravelDeploy extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy the project if there is a new commit or a webhook call is executed';

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
     */
    public function handle()
    {
        switch (env('DEPLOY_MODE')) {

            case WEBHOOK_DEPLOY:

                if (env('DEPLOY')) {
                    Console::setEnvironmentValue('DEPLOY', 0);
                    $this->deploy();
                }

                break;

            case AUTO_DEPLOY:

                Console::exec(['git fetch']);

                $currentCommit = intval(env('DEPLOY') ?: 0);
                $lastCommit    = intval(Console::exec(['git --no-pager log --all -1 --format=%ct']));

                if ($lastCommit > $currentCommit) {
                    Console::setEnvironmentValue('DEPLOY', $lastCommit);
                    $this->deploy();
                }

                break;
            default:
                // do nothing
        }

    }

    /**
     * Execute the deploy routine
     */
    public function deploy()
    {
        $composer = Console::exec('which composer');

        Console::exec([
            'git reset --hard',
            'git pull',
        ]);

        $this->call('cache:clear');

        Console::exec([
            "$composer dump-autoload",
            "$composer install",
        ]);

        $this->call('migrate', ['--force' => true]);

        $this->call('queue:restart');
    }

}