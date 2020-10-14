<?php
/**
 * Created by PhpStorm.
 * User: conghoan
 * Date: 10/13/20
 * Time: 16:52
 */
namespace Workable\QueryLogger\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearSqlLogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sql-log:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Sql log';

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
        try{
            $time = Carbon::now()->addDays(-7);
            $number = DB::table('sql_logs')->where('created_at', '<', $time)->delete();
            $this->info("Clear $number Sql log success");
        }catch (\Exception $exception){
            $this->warn("Clear Sql log Fail: " . $exception->getMessage());
        }
    }
}