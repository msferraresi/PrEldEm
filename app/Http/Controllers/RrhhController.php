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

    //-----------------------------------------------------------------INICIO NEWS
    public function index_news(Request $request)
    {
        $team_selected = $request->team_id;
        $area_id = $request->area_id;
        $area_selected = $area_id;
        $company = Team::where('id', $team_selected)->get();
        $areas = CompanyAreas::where('team_id', $team_selected)->get();
        $query = 'SELECT DISTINCT n.* FROM news n INNER JOIN news_teams nt ON n.id = nt.news_id INNER JOIN company_areas ca ON nt.company_area_id = ca.id WHERE n.deleted_at IS NULL AND ca.team_id = ?';

        if ($area_id > 0) {
            $query .= ' AND nt.company_area_id = ?';
        }else {
            $query .= ' AND 0 = ?';
        }
        $news = DB::select($query, [$team_selected, $area_id]);
        return view('rrhh.news.index', compact('company', 'team_selected', 'areas', 'news', 'area_selected'));
    }

    public function create_news(Request $request)
    {
        $team_selected = $request->team_id;
        /*$membership = Membership::where('user_id',$request['id_user'])->get();
        $men = array();
        for ($i = 0; $i < count(collect($membership)); $i++){
            $men[] = array($membership[$i]->team_id);
        }*/

        $company = Team::where('id', $team_selected)->get();
        $areas = CompanyAreas::where('team_id', $team_selected)->get();

        return view('rrhh.news.create_news', compact('company', 'areas'));
    }

    public function store_news(Request $request)
    {

        try {
            $new = News::create([
                'tittle' => $request['tittle'],
                'description' => $request['description'],
                'user_id' => $request['id_user'],
            ]);

            if($_POST) {
                foreach ($_POST as $clave=>$valor) {
                    if(str_contains($clave, 'chk')){
                        $area_users = NewsTeams::create([
                            'news_id' => $new['id'],
                            'company_area_id' => $valor,
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
        $news = News::all();
        return view('rrhh.news.index', compact('company', 'team_selected', 'areas', 'news'));

    }

    public function edit_news(Request $request)
    {
        $team_selected = $request->team_id;
        $new_id = $request->new_id;
        $new = News::where('id', $new_id)->get();
        $areas = DB::select('SELECT ca.id area_id, ca.name, 1 AS assigned FROM company_areas ca INNER JOIN news_teams nt ON ca.id = nt.company_area_id WHERE nt.news_id = ? AND ca.team_id = ? AND ca.deleted_at IS NULL
        UNION ALL SELECT ca.id area_id, ca.name, 0 AS assigned FROM company_areas ca WHERE ca.team_id = ? AND ca.deleted_at IS NULL AND NOT EXISTS (SELECT 1 FROM news_teams nt WHERE nt.company_area_id = ca.id AND nt.news_id = ?);',
        [$new_id, $team_selected, $team_selected, $new_id]);
        return view('rrhh.news.edit_news', compact('areas', 'new'));
    }

    public function update_news(Request $request)
    {
        try {

            $news = News::where('id', $request['new_id'])->update([
                'tittle' => $request['tittle'],
                'description' => $request['description'],
                'user_id' => $request['id_user'],
             ]);

             NewsTeams::where('news_id', $request['new_id'])->delete();

             if($_POST) {
                foreach ($_POST as $clave=>$valor) {
                    if(str_contains($clave, 'chk')){
                        $area_users = NewsTeams::create([
                            'news_id' => $request['new_id'],
                            'company_area_id' => $valor,
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
         $news = News::all();
         return view('rrhh.news.index', compact('company', 'team_selected', 'areas', 'news'));
    }

    public function destroy_news(Request $request)
    {
        NewsTeams::where('news_id', $request['new_id'])->delete();
        News::where('id', $request['new_id'])->delete();

        $team_selected = $request['team_id'];
        $company = Team::where('id', $team_selected)->get();
        $areas = CompanyAreas::where('team_id', $team_selected)->get();
        $news = News::all();
        return view('rrhh.news.index', compact('company', 'team_selected', 'areas', 'news'));
    }
    //-----------------------------------------------------------------FIN NEWS

    //-----------------------------------------------------------------INICIO GROUPS
    public function index_group(Request $request)
    {
        $team_selected = $request->team_id;
        $company = Team::where('id', $team_selected)->get();
        $areas = CompanyAreas::where('team_id', $team_selected)->get();
        return view('rrhh.groups.index', compact('company', 'team_selected', 'areas'));
    }

    public function create_group(Request $request)
    {
        $team_selected = $request->team_id;
        $user_id = $request->id_user;
        $company = Team::where('id', $team_selected)->get();
        $users = DB::select('SELECT u.id AS user_id, u.name, t.id AS team_id FROM users u INNER JOIN team_user tu ON u.id = tu.user_id INNER JOIN teams t ON tu.team_id = t.id
        WHERE t.id = ? AND u.id != ?;', [$team_selected, $user_id]);
        return view('rrhh.groups.create_group', compact('company', 'users'));
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
        return view('rrhh.groups.index', compact('company', 'team_selected', 'areas'));
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

        return view('rrhh.groups.edit_group', compact('company', 'users', 'area'));
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
         return view('rrhh.groups.index', compact('company', 'team_selected', 'areas'));
    }

    public function destroy_group(Request $request)
    {
        CompanyAreasUser::where('company_area_id', $request['area_id'])->delete();
        CompanyAreas::where('id', $request['area_id'])->delete();

        $team_selected = $request['team_id'];
        $company = Team::where('id', $team_selected)->get();
        $areas = CompanyAreas::where('team_id', $team_selected)->get();
        return view('rrhh.groups.index', compact('company', 'team_selected', 'areas'));
    }
    //-----------------------------------------------------------------FIN GROUPS




















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
