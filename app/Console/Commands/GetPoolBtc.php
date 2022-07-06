<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetPoolBtc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:pool:btc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get BTC data workers';

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
        \App\Jobs\GetPoolBtc::dispatch()->onQueue('pool:btc');
    }
}
