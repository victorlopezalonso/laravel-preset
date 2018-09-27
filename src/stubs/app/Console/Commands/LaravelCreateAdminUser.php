<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class LaravelCreateAdminUser extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel:create-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Admin user';

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

        $permissionsList = [
            'Root'       => ROOT_USER,
            'Admin'      => ADMIN_USER,
            'Consultant' => CONSULTANT_USER
        ];

        system('clear');
        $this->info("Let's create a new admin account.");

        $name  = $this->ask('Name');
        $email = $this->ask('Email address');

        $permissions = $this->choice('Set the user permissions', [
            ROOT_USER       => 'Root',
            ADMIN_USER      => 'Admin',
            CONSULTANT_USER => 'Consultant'
        ], ROOT_USER);

        $permissions = $permissionsList[$permissions];

        do {

            $password     = $this->secret('Password');
            $confirmation = $this->secret('Again, just to make sure');

            if ($confirmation !== $password) {
                $this->error('That doesn\'t match. Let\'s try again.');
            }

        } while ($confirmation !== $password);

        $password = encryptWithAppSecret($password);

        User::create([
            'name'        => $name,
            'email'       => $email,
            'password'    => $password,
            'is_admin'    => true,
            'permissions' => $permissions,
            'verified'    => true,
        ]);

        $this->info('Admin user created!');
    }
}
