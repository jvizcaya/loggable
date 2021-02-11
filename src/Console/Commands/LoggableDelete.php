<?php

namespace Jvizcaya\Loggable\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LoggableDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
     protected $signature = 'loggable:delete {days? : Delete register after days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete the users activities logs';

    /**
     * The time in days that the log records are out of the delete process.
     *
     * @var numeric
     */
     public $days;


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
     * @return mixed
     */
    public function handle()
    {

          $this->days = is_numeric($this->argument('days')) ? $this->argument('days') : config('loggable.logs_time');

          DB::table(config('loggable.table'))->where('log_at', '<=', now()->subDay($this->days)->toDateTimeString())->delete();

          $this->info('The users activities logs has been deleted.');

    }


}
