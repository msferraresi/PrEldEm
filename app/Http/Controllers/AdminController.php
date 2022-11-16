<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsTeams;
use App\Models\File;
use App\Models\TypeFile;
use App\Models\Team;
use App\Models\Membership;
use App\Models\CompanyAreas;
use App\Models\CompanyAreasUser;
use DB;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
    }

    //-----------------------------------------------------------------INICIO ACTIVITIES
    public function index_activities(Request $request)
    {
        //dd($request);
        $log_selected = $request->log_names;
        $query = 'SELECT al.id, log_name, description, event, subject_type "where", causer_type "who", u.name AS user_name FROM activity_log al INNER JOIN users u ON al.causer_id = u.id';

        if ($log_selected != 'all') {
            $query .= ' AND al.log_name = ?';
            $logs = DB::select($query, [$log_selected]);
        }else{
            $logs = DB::select($query);
        }

        $log_names = DB::select('select distinct log_name from activity_log;');

        return view('admin.activities.index', compact('logs', 'log_names', 'log_selected'));
    }
    //-----------------------------------------------------------------FIN ACTIVITIES
}
