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
    protected $signature = 'request-logs:clean {--days=30}';
    protected $description = 'Delete request logs older than given days (default: 30)';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $days = (int) $this->option('days');
        $deleted = RequestLogEntry::where('created_at', '<', Carbon::now()->subDays($days))->delete();
        $this->info("Deleted {$deleted} old logs.");
    }
}
