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
        App\Models\Copy::insertMany(config('copies.server'), ['type' => SERVER_COPY]);
        App\Models\Copy::insertMany(config('copies.client'), ['type' => CLIENT_COPY]);
        App\Models\Copy::insertMany(config('copies.admin'), ['type' => ADMIN_COPY]);
    }

}
