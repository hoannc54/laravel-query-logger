<?php
/**
 * Created by PhpStorm.
 * User: conghoan
 * Date: 10/13/20
 * Time: 14:41
 */
namespace Workable\QueryLogger\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class SqlLogController extends Controller
{
    public function index(){
        $sql_logs = DB::table('sql_logs')
            ->orderBy('created_at', 'desc')->paginate(10);
        return view('sql-log::sql-log', [
            'sql_logs' => $sql_logs
        ]);
    }
}