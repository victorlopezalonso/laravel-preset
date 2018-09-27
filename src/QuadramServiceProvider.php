<?php

namespace Quadram\LaravelPreset;

use Illuminate\Foundation\Console\PresetCommand;
use Illuminate\Support\ServiceProvider;

class QuadramServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        PresetCommand::macro('Quadram', function ($command) {
            Preset::install();

            $command->info('All finished! Please run <yarn (or npm run) laravel:init> to set up your configuration');
        });
    }
}
