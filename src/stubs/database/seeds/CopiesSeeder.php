<?php

use Illuminate\Database\Seeder;

class CopiesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Copy::insertMany(config('copies.server'), ['server' => true]);
        App\Models\Copy::insertMany(config('copies.client'));
    }

}
