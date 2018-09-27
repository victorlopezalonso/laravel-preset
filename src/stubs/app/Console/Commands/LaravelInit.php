<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Classes\Console;
use Laravel\Passport\Client;
use Illuminate\Console\Command;

class LaravelInit extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install or update the project';

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle()
    {
        $this->welcome();

        $this->generateAppKey();

        $this->askForConfiguration();

        $this->setUpAdminAccount();

        $this->storageLink();

        $this->initPassport();

        $this->compileFrontEnd();
    }

    /**
     * Welcome message
     */
    protected function welcome()
    {
        system('clear');
        $this->comment('Attempting to install the project.');
    }

    /**
     * Generate the app key and hash
     *
     * @throws \Exception
     */
    protected function generateAppKey()
    {
        if (strlen(config('app.key')) === 0) {
            $this->info('Generating app key...');
            $this->call('key:generate');
        }

        if (!env('APP_HASH')) {
            $this->info('Generating app secret...');
            $hash = base64_encode(random_bytes(10));
            Console::updateEnvironmentFile(['APP_HASH' => $hash]);
        }
    }

    /**
     * Ask the user for the DB configuration and updates the .env file
     */
    private function askForConfiguration()
    {
        if (env('APP_ENV')) {
            $this->migrate();
            return;
        }

        $config = [];

        do {
            system('clear');
            $this->info("Database configuration.");

            $config['APP_ENV'] = $this->choice('Environment', [
                LOCAL_ENVIRONMENT       => LOCAL_ENVIRONMENT,
                DEVELOPMENT_ENVIRONMENT => DEVELOPMENT_ENVIRONMENT,
                STAGING_ENVIRONMENT     => STAGING_ENVIRONMENT,
                PRODUCTION_ENVIRONMENT  => PRODUCTION_ENVIRONMENT,
            ], LOCAL_ENVIRONMENT);

            $config['APP_DEBUG'] = $config['APP_ENV'] !== PRODUCTION_ENVIRONMENT;

            $config['APP_NAME'] = '"' . $this->ask('Name of the app') . '"';
            $config['APP_URL'] = $this->ask('Public url');

            $config['DB_CONNECTION'] = $this->choice('Database driver', [
                'mysql'      => 'MySQL/MariaDB',
                'pgsql'      => 'PostgreSQL',
                'sqlsrv'     => 'SQL Server',
                'sqlite-e2e' => 'SQLite',
            ], 'mysql');

            if ($config['DB_CONNECTION'] === 'sqlite-e2e') {
                $config['DB_DATABASE'] = $this->ask('Absolute path to the DB file');
            } else {
                $config['DB_HOST'] = $this->ask('DB host', 'localhost');
                $config['DB_PORT'] = $this->ask('DB port', '3306');
                $config['DB_DATABASE'] = $this->ask('DB name');
                $config['DB_USERNAME'] = $this->ask('DB user', 'root');
                $config['DB_PASSWORD'] = (string)$this->secret('DB password', false);
            }

            $config['MAIL_FROM_NAME'] = (string)$this->ask('Mail from name', $config['APP_NAME']);
            $config['MAIL_FROM_ADDRESS'] = $this->ask('Mail from address');
            $config['MAIL_DRIVER'] = $this->ask('Mail driver', 'smtp');
            $config['MAIL_HOST'] = $this->ask('Mail host', 'smtp.mailtrap.io');
            $config['MAIL_PORT'] = $this->ask('Mail port', '2525');
            $config['MAIL_ENCRYPTION'] = $this->choice('Mail encryption', [
                'ssl'           => 'ssl',
                'tls'           => 'tls',
                'no encryption' => null
            ], 'ssl');

            $config['MAIL_USERNAME'] = (string)$this->ask('Mail username');
            $config['MAIL_PASSWORD'] = (string)$this->secret('Mail password', false);

            $config['DEPLOY_MODE'] = ($config['APP_ENV'] === PRODUCTION_ENVIRONMENT) ? WEBHOOK_DEPLOY : AUTO_DEPLOY;

            $this->table(array_keys($config), [$config]);

        } while (!$this->confirm('Proceed with this configuration?'));

        //Set the config so that the next DB attempt uses refreshed credentials
        config([
            'database.default'                                         => $config['DB_CONNECTION'],
            "database.connections.{$config['DB_CONNECTION']}.host"     => $config['DB_HOST'],
            "database.connections.{$config['DB_CONNECTION']}.port"     => $config['DB_PORT'],
            "database.connections.{$config['DB_CONNECTION']}.database" => $config['DB_DATABASE'],
            "database.connections.{$config['DB_CONNECTION']}.username" => $config['DB_USERNAME'],
            "database.connections.{$config['DB_CONNECTION']}.password" => $config['DB_PASSWORD'],
        ]);

        Console::updateEnvironmentFile($config);

        $this->migrate();

        $this->info('Seeding initial data');
        $this->call('db:seed', ['--force' => true]);

        $this->info('Enter your admin password to set the storage folder permissions and supervisor configuration');
        Console::exec('sudo chmod -R 775 storage');

        $this->configureSupervisor();
    }

    /**
     * Create the supervisor .conf file and start to listen
     */
    protected function configureSupervisor()
    {
        switch (env('APP_ENV')) {
            case DEVELOPMENT_ENVIRONMENT:
                $numProcesses = 2;
                break;
            case STAGING_ENVIRONMENT:
                $numProcesses = 3;
                break;
            case PRODUCTION_ENVIRONMENT:
                $numProcesses = 10;
                break;
            default:
                return;
        }

        $path = base_path();
        $appName = preg_replace('/\s+/', '', env('APP_NAME')) . ucwords(env('APP_ENV'));

        $file = "[program: $appName]" . PHP_EOL .
            "process_name=%(program_name)s_%(process_num)02d" . PHP_EOL .
            "command=php $path/artisan queue:work --tries=100" . PHP_EOL .
            "autostart=true" . PHP_EOL .
            "autorestart=true" . PHP_EOL .
            "user=" . get_current_user() . PHP_EOL .
            "numprocs=$numProcesses" . PHP_EOL .
            "redirect_stderr=true" . PHP_EOL .
            "stdout_logfile=$path/storage/logs/worker$appName.log";

        $filePath = "/etc/supervisor/conf.d/$appName.conf";

        system("echo " . escapeshellarg($file) . " | sudo tee -a $filePath");

        Console::exec([
            "sudo supervisorctl reread",
            "sudo supervisorctl update",
            "sudo supervisorctl start $appName:*"
        ]);
    }

    /**
     * Run the migrations
     */
    protected function migrate()
    {
        $this->info('Migrating database');
        $this->call('migrate', ['--force' => true]);
    }

    /**
     * Set up the admin account.
     */
    private function setUpAdminAccount()
    {
        if (!User::count()) {
            $this->call('laravel:create-admin-user');
        }
    }

    /**
     * Create the public link to the storage/public folder
     */
    protected function storageLink()
    {
        $this->call('storage:link');
    }

    /**
     * Install passport
     */
    private function initPassport()
    {
        if (!env('OAUTH_EXPIRING_CLIENT_ID') || !env('OAUTH_EXPIRING_CLIENT_SECRET')) {

            $this->call('passport:keys', ['--force' => true]);
            $this->call("passport:install", ['--force' => true]);

            //Password client for expiring tokens
            $client = Client::where('password_client', true)->first();

            Console::setEnvironmentValue('OAUTH_EXPIRING_CLIENT_ID', $client->id);
            Console::setEnvironmentValue('OAUTH_EXPIRING_CLIENT_SECRET', $client->secret);

            //personal client for no expiring tokens
            $client = Client::where('password_client', false)->first();

            Console::setEnvironmentValue('OAUTH_NO_EXPIRING_CLIENT_ID', $client->id);
            Console::setEnvironmentValue('OAUTH_NO_EXPIRING_CLIENT_SECRET', $client->secret);

            $this->info('.env file updated with oauth client credentials');
        }
    }

    /**
     * Compile the front end files
     */
    protected function compileFrontEnd()
    {
        $this->info('Compiling front-end stuff');
        system('yarn install');
    }
}
