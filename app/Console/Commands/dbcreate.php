<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class dbcreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create new Mysql';

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
     *
     * @return int
     */
    public function handle()
    {
        $schemaName ='blog';

        $charset = config('database.connections.mysql.charsert', 'utf8mb4');

        $collation = config('database.connections.mysql.collation', 'utf8_general_ci');

        config(['database.connections.mysql.database'=> null]);

        $query = "DROP DATABASE IF EXISTS $schemaName;";
        DB::statement($query);

        $query = " CREATE DATABASE IF NOT EXISTS $schemaName CHARACTER SET $charset 
        COLLATE $collation;";
        DB::statement($query);

        echo "Database $schemaName created successfully";

         config(['database.connections.mysql.database'=> $schemaName]);

    }
}
