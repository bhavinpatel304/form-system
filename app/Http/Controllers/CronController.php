<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CronController extends Controller
{
    public function index()
    {
        echo "CronController is Called Successfully";
        phpinfo();
    }
    public function updateSurveyStatus()
    {
        mail('amit@technobrave.com', 'updateSurveyStatus', date('Y-m-d H:i:s'));
        DB::table('surveys')
            ->where('status', 1)
            ->whereDate('end_date', '<', DB::raw('CURDATE()'))
            ->update(['status' => 2]);

        DB::table('surveys')
            ->where('status', 2)
            ->whereDate('start_date', DB::raw('CURDATE()'))
            ->update(['status' => 1]);
    }
    public function closeWindow()
    {
        return '<a href="javascript:window.top.close();">CLOSE WINDOW</a>';
    }
}
