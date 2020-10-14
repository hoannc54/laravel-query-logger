# Slow Query Logger for Laravel

## Quickstart

```
composer require hoannc54/laravel-query-logger
```

Look into your `laravel.log` file to see your messy queries.

## Installation

Add to your composer.json following lines

	"require": {
		"hoannc54/laravel-query-logger": "^1.*"
	}

Run `php artisan vendor:publish --provider="Workable\QueryLogger\QueryLoggerProvider"`

## Configuration

### `enabled`

Enable the slow queries logger.

You can set this value through environment variable `LARAVEL_SLOW_QUERY_LOGGER_ENABLED`. It is `false` by default.

### `channel`

Sets the channel to log in.

You can set this value through environment variable `LARAVEL_SLOW_QUERY_LOGGER_CHANNEL`. It is `single` by default.

### `log-level`

Set the log-level for logging the slow queries.

You can set this value through environment variable `LARAVEL_SLOW_QUERY_LOGGER_LOG_LEVEL`. It is `debug` by default.

### `time-to-log`

Only log queries longer than this value in microseconds.

You can set this value through environment variable `LARAVEL_SLOW_QUERY_LOGGER_TIME_TO_LOG`. It is `0.7` by default.

## Usage

Start your application and look into your logs to identify the slow queries.