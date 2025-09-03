<?php

namespace iMi\LaravelRequestLogger;

use Illuminate\Console\Command;
use Carbon\Carbon;

/**
 * Class CleanOldLogs
 *
 * Artisan command to delete old request logs from the database.
 *
 * Usage:
 *   php artisan request-logs:clean            // deletes logs older than 30 days (default)
 *   php artisan request-logs:clean --days=60  // deletes logs older than 60 days
 *
 * @package iMi\LaravelRequestLogger
 */
class CleanOldLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request-logs:clean {--days=30}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete request logs older than given days (default: 30)';

    /**
     * Execute the console command.
     *
     * Deletes all request logs older than the specified number of days.
     *
     * @return void
     */
    public function handle(): void
    {
        // Get the number of days from the --days option (default is 30)
        $days = (int) $this->option('days');

        // Delete all logs older than the specified number of days
        $deleted = RequestLogEntry::where('created_at', '<', Carbon::now()->subDays($days))->delete();

        // Output the result to the console
        $this->info("Deleted {$deleted} old logs.");
    }
}
