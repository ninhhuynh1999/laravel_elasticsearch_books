<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FastSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fast-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $descriptionProcOpen = [
            ["pipe", "r"],
            ["pipe", "r"],
        ];

        proc_open("php " . base_path() . "/artisan db:seed", $descriptionProcOpen, $pipes);
        proc_open("php " . base_path() . "/artisan db:seed", $descriptionProcOpen, $pipes);
        proc_open("php " . base_path() . "/artisan db:seed", $descriptionProcOpen, $pipes);
        proc_open("php " . base_path() . "/artisan db:seed", $descriptionProcOpen, $pipes);
        proc_open("php " . base_path() . "/artisan db:seed", $descriptionProcOpen, $pipes);
    }
}
