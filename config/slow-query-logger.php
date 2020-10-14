<?php

return [
	/**
	 * log when you are on these environments
	 */
	'enabled' => env('LARAVEL_SLOW_QUERY_LOGGER_ENABLED', false),

	/**
	 * log when you are on these environments: single, database
	 */
	'channel' => env('LARAVEL_SLOW_QUERY_LOGGER_CHANNEL', 'database'),

	/**
	 * level to log
	 */
	'log-level' => env('LARAVEL_SLOW_QUERY_LOGGER_LOG_LEVEL', 'debug'),

	/**
	 * log all sql queries that are slower than X seconds
	 * laravel measures at a precision of 2 digits, so 0.7134 will be logged as 0.71
	 */
	'time-to-log' => env('LARAVEL_SLOW_QUERY_LOGGER_TIME_TO_LOG', 0.7),
];