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


class RrhhController extends Controller
{

    public function index()
    {
        return view('rrhh.index');
    }

    public function index_news(Request $request)
    {
        //if($request->method() == 'POST') dd($request);

        /*
            debe saber que teams puede ver el usuario
            ==
            si team_id = 0 entonces tiene que buscar todas las novedades de los equipos a los que el usuario pertenezca
            Si team_id <> 0 entonces solo debe buscar las novedades de el team indicado
        */

        //$teams = DB::select('select * from users where active = ?', [1])

        $user_id = 1;
        $team_id = 1;

        if($request->method() == 'POST') {
            $user_id = $request['id_user'];
            $team_id = $request['team_id'];
        }


        //dd('user_id: ' . $user_id . ' team_id: ' . $team_id );

        $teams = DB::select('SELECT DISTINCT p.id, p.name, p.user_id FROM (SELECT t.id, t.name, tu.user_id FROM teams t INNER JOIN team_user tu ON t.id = tu.team_id UNION ALL
        SELECT id, name, user_id FROM teams) p WHERE p.user_id = ?', [$user_id]);

        $queryNews = 'SELECT * FROM news n LEFT JOIN news_teams nt ON n.id = nt.news_id WHERE n.user_id = ?';

        if($request['team_id'] > 0 ) {
            $queryNews .= ' AND nt.team_id = ?';
        }else{
            $queryNews .= ' AND 0 = ?';
        };

        //if($request->method() == 'POST') dd($queryNews);

        $news = DB::select($queryNews, [$user_id, $team_id]);


        //if($request->method() == 'POST') dd($news);


        //$news = News::all();
        //$teams = Team::all();
        return view('rrhh.news.index', compact('news', 'teams'));
    }


    public function index_employees(Request $request)
    {
        //dd($request);
        $team_selected = $request->team_id;
        //$membership = Membership::where('user_id',$request['id_user'])->get();
        //$companies = Team::with('team_user','user_id', $request['id_user'])->get();
        //$companies = Membership::with('team')->where('user_id', $request['id_user'])->get();
        /*$men = array();
        for ($i = 0; $i < count(collect($membership)); $i++){
            $men[] = array($membership[$i]->team_id);
            if ($i == 0 && $request->team_id == 0) {
                $team_selected = $membership[$i]->team_id;
            }
        }*/
        //print_r($team_selected);
        //$companies = Team::whereIn('id', $men)->get();
        $company = Team::where('id', $team_selected)->get();
        //dd($companies);
        $areas = CompanyAreas::where('team_id', $team_selected)->get();
        //dd($areas);
        return view('rrhh.employees.index', compact('company', 'team_selected', 'areas'));
    }

    public function create_group(Request $request)
    {
        $team_selected = $request->team_id;
        $user_id = $request->id_user;
        /*$membership = Membership::where('user_id',$request['id_user'])->get();
        $men = array();
        for ($i = 0; $i < count(collect($membership)); $i++){
            $men[] = array($membership[$i]->team_id);
        }*/

        $company = Team::where('id', $team_selected)->get();

        $users = DB::select('SELECT u.id AS user_id, u.name, t.id AS team_id FROM users u INNER JOIN team_user tu ON u.id = tu.user_id INNER JOIN teams t ON tu.team_id = t.id
        WHERE t.id = ? AND u.id != ?;', [$team_selected, $user_id]);

        return view('rrhh.employees.create_group', compact('company', 'users'));
    }

    public function store_group(Request $request)
    {

        try {
           $area = CompanyAreas::create([
                'name' => $request['area_name'],
                'team_id' => $request['team_id'],
            ]);

            $area_users = CompanyAreasUser::create([
                'company_area_id' => $area['id'],
                'user_id' => $request['id_user'],
            ]);

            if($_POST) {
                foreach ($_POST as $clave=>$valor) {
                    if(str_contains($clave, 'chk')){
                        $area_users = CompanyAreasUser::create([
                            'company_area_id' => $area['id'],
                            'user_id' => $valor,
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            activity()
                ->withProperties(['tittle' => $request['tittle'],
                                  'description' => $request['description'],
                                  'class' => __CLASS__,
                                  'function' => __METHOD__
                                  ])
                ->log('ERROR: ' . $e->getMessage());
        }

        $team_selected = $request['team_id'];
        $company = Team::where('id', $team_selected)->get();
        $areas = CompanyAreas::where('team_id', $team_selected)->get();
        return view('rrhh.employees.index', compact('company', 'team_selected', 'areas'));

    }

    public function edit_group(Request $request)
    {
        $team_selected = $request->team_id;
        $user_id = $request->id_user;
        $area_id = $request->area_id;
        $company = Team::where('id', $team_selected)->get();
        $area = CompanyAreas::where('id', $area_id)->get();
        $users = DB::select('SELECT * FROM (SELECT u.id user_id, u.name, 1 AS assigned FROM users u INNER JOIN company_areas_users cau ON u.id = cau.user_id WHERE cau.deleted_at IS NULL AND cau.company_area_id = ?
        UNION SELECT u.id user_id, u.name, 0 AS assigned FROM users u WHERE u.id != 1 AND NOT exists (SELECT 1 FROM company_areas_users cau WHERE cau.deleted_at IS NULL AND cau.user_id = u.id and company_area_id = ?)) Q
        ORDER BY Q.user_id;', [$area_id, $area_id]);

        return view('rrhh.employees.edit_group', compact('company', 'users', 'area'));
    }

    public function update_group(Request $request)
    {
        try {

            $area = CompanyAreas::where('id', $request['area_id'])->update([
                 'name' => $request['area_name'],
             ]);

             CompanyAreasUser::where('company_area_id', $request['area_id'])->delete();

             if($_POST) {
                 foreach ($_POST as $clave=>$valor) {
                     if(str_contains($clave, 'chk')){
                      CompanyAreasUser::create([
                            'company_area_id' => $request['area_id'],
                            'user_id' => $valor,
                        ]);
                     }
                 }
             }
         } catch (\Exception $e) {
             activity()
                 ->withProperties(['tittle' => $request['tittle'],
                                   'description' => $request['description'],
                                   'class' => __CLASS__,
                                   'function' => __METHOD__
                                   ])
                 ->log('ERROR: ' . $e->getMessage());
         }

         $team_selected = $request['team_id'];
         $company = Team::where('id', $team_selected)->get();
         $areas = CompanyAreas::where('team_id', $team_selected)->get();
         return view('rrhh.employees.index', compact('company', 'team_selected', 'areas'));
    }

    public function destroy_group(Request $request)
    {
        CompanyAreasUser::where('company_area_id', $request['area_id'])->delete();
        CompanyAreas::where('id', $request['area_id'])->delete();

        $team_selected = $request['team_id'];
        $company = Team::where('id', $team_selected)->get();
        $areas = CompanyAreas::where('team_id', $team_selected)->get();
        return view('rrhh.employees.index', compact('company', 'team_selected', 'areas'));
    }




















    public function index_paychecks()
    {
        $news = News::all();
        return view('rrhh.paychecks.index', compact('news'));
    }

    public function index_documents()
    {
        $news = News::all();
        return view('rrhh.documents.index', compact('news'));
    }


    public function index_activities()
    {
        $news = News::all();
        return view('rrhh.activities.index', compact('news'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
