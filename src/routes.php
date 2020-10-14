<?php
/**
 * Created by PhpStorm.
 * User: conghoan
 * Date: 10/13/20
 * Time: 14:40
 */

Route::get('log/sql', [
    'as' => 'log.sql.index',
    'uses' => 'Workable\QueryLogger\Controllers\SqlLogController@index'
]);