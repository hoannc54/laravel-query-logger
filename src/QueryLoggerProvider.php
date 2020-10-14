<?php

namespace Workable\QueryLogger;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Workable\QueryLogger\Console\Commands\ClearSqlLogCommand;

class QueryLoggerProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 */
	public function boot()
	{
		if ($this->app->runningInConsole()) {
			$this->publishes([
				__DIR__ . '/../config/slow-query-logger.php' => config_path('slow-query-logger.php'),
			], 'config');
            $this->commands([
                ClearSqlLogCommand::class
            ]);
		}
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadMigrationsFrom(__DIR__. '/Databases/migrations');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'sql-log');
		$this->setupListener();
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(
			__DIR__ . '/../config/slow-query-logger.php', 'slow-query-logger'
		);
	}

	/**
	 * setting up listener
	 */
	private function setupListener()
	{
		if (!config('slow-query-logger.enabled')) {
			return;
		}

		DB::listen(function (QueryExecuted $queryExecuted) {
			$sql = $queryExecuted->sql;
			if (strpos($sql, 'sql_logs') !== false){
			    return;
            }
			$bindings = $queryExecuted->bindings;
			$time = $queryExecuted->time;
			$logSqlQueriesSlowerThan = (float)config('slow-query-logger.time-to-log', -1);
			if ($logSqlQueriesSlowerThan < 0 || $time < $logSqlQueriesSlowerThan) {
				return;
			}

			$level = config('slow-query-logger.log-level', 'debug');
			try {
                $url = app('request')->url();

                foreach ($bindings as $val) {
                    $sql = preg_replace('/\?/', "'{$val}'", $sql, 1);
                }
                if (config('slow-query-logger.channel', 'single') == 'database'){
                    $this->logDb($time, $sql, $url);
                }else{
                    Log::channel('single')->log($level, $time . '  ' . $sql . ' ' . $url);
                }
			} catch (Exception $e) {
				//  be quiet on error
			}
		});
	}

    private function logDb($time, $sql, $url = '')
    {
        DB::table('sql_logs')->insert([
            'time'       => $time,
            'sql'        => $sql,
            'url'        => $url,
            'created_at' => Carbon::now()
        ]);
    }
}
