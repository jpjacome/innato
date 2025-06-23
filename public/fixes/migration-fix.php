<?php
   // Fix migration tracking
   require_once __DIR__ . '/../vendor/autoload.php';
   $app = require_once __DIR__ . '/../bootstrap/app.php';
   $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
   
   use Illuminate\Support\Facades\DB;
   use Illuminate\Support\Facades\Schema;
   
   // Create migrations table if it doesn't exist
   if (!Schema::hasTable('migrations')) {
       Schema::create('migrations', function ($table) {
           $table->id();
           $table->string('migration');
           $table->integer('batch');
       });
       echo "Created migrations table\n";
   }
   
   // Mark core migrations as complete
   $coreMigrations = [
       '0001_01_01_000000_create_users_table',
       '0001_01_01_000000_create_password_resets_table',
       '2019_08_19_000000_create_failed_jobs_table',
       '2019_12_14_000001_create_personal_access_tokens_table',
       // Add any other migrations that might exist in your database
   ];
   
   $batch = 1;
   foreach ($coreMigrations as $migration) {
       if (!DB::table('migrations')->where('migration', $migration)->exists()) {
           DB::table('migrations')->insert([
               'migration' => $migration,
               'batch' => $batch
           ]);
           echo "Marked $migration as complete\n";
       }
   }
   
   echo "Now run: php artisan migrate --path=vendor/laravel/telescope/database/migrations\n";