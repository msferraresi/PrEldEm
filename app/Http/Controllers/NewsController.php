<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use DB;

class NewsController extends Controller
{
    public function index(Request $request)
    {


        $team_selected = $request->team_id;
        $id_user = $request->id_user;


        //dd($team_selected .' --- '. $id_user);

        $area_id = 0;
        $query = 'SELECT DISTINCT n.id, n.tittle, SUBSTRING(n.description ,1,100) description, n.user_id FROM news n INNER JOIN news_teams nt ON n.id = nt.news_id INNER JOIN company_areas ca ON nt.company_area_id = ca.id WHERE n.deleted_at IS NULL AND ca.team_id = ?';

        if ($area_id > 0) {
            $query .= ' AND nt.company_area_id = ?';
        }else {
            $query .= ' AND 0 = ?';
        }

        $news = DB::select($query, [$team_selected, $area_id]);
        return view('news.index', compact('news'));
    }

    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }
}
