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
use App\Models\User;
use App\Models\Paycheck;
use DB;


class RrhhController extends Controller
{

    //-----------------------------------------------------------------INICIO RRHH GRAL
    public function index()
    {
        return view('rrhh.index');
    }
    //-----------------------------------------------------------------FIN RRHH GRAL

    //-----------------------------------------------------------------INICIO NEWS
    public function index_news(Request $request)
    {
        $team_selected = $request->team_id;
        $area_id = $request->area_id;
        $area_selected = $area_id;
        $company = Team::where('id', $team_selected)->get();
        $areas = CompanyAreas::where('team_id', $team_selected)->get();
        $query = 'SELECT n.id, n.tittle, n.description, n.user_id, n.deleted_at, n.created_at, n.updated_at, group_concat(ca.name) equipo FROM news n INNER JOIN news_teams nt ON n.id = nt.news_id INNER JOIN company_areas ca ON nt.company_area_id = ca.id WHERE ca.deleted_at IS NULL AND n.deleted_at IS NULL AND ca.team_id = ?';

        if ($area_id > 0) {
            $query .= ' AND nt.company_area_id = ?';
        }else {
            $query .= ' AND 0 = ?';
        }

        $query .= ' GROUP BY n.id, n.tittle, n.description, n.user_id, n.deleted_at, n.created_at, n.updated_at';

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


        $team_selected = $request->team_id;
        $area_id = 0;
        $area_selected = $area_id;
        $company = Team::where('id', $team_selected)->get();
        $areas = CompanyAreas::where('team_id', $team_selected)->get();
        $query = 'SELECT n.id, n.tittle, n.description, n.user_id, n.deleted_at, n.created_at, n.updated_at, group_concat(ca.name) equipo FROM news n INNER JOIN news_teams nt ON n.id = nt.news_id INNER JOIN company_areas ca ON nt.company_area_id = ca.id WHERE ca.deleted_at IS NULL AND n.deleted_at IS NULL AND ca.team_id = ?';

        if ($area_id > 0) {
            $query .= ' AND nt.company_area_id = ?';
        }else {
            $query .= ' AND 0 = ?';
        }

        $query .= ' GROUP BY n.id, n.tittle, n.description, n.user_id, n.deleted_at, n.created_at, n.updated_at';

        $news = DB::select($query, [$team_selected, $area_id]);
        return view('rrhh.news.index', compact('company', 'team_selected', 'areas', 'news', 'area_selected'));

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

         $team_selected = $request->team_id;
         $area_id = 0;
         $area_selected = $area_id;
         $company = Team::where('id', $team_selected)->get();
         $areas = CompanyAreas::where('team_id', $team_selected)->get();
         $query = 'SELECT n.id, n.tittle, n.description, n.user_id, n.deleted_at, n.created_at, n.updated_at, group_concat(ca.name) equipo FROM news n INNER JOIN news_teams nt ON n.id = nt.news_id INNER JOIN company_areas ca ON nt.company_area_id = ca.id WHERE ca.deleted_at IS NULL AND n.deleted_at IS NULL AND ca.team_id = ?';

         if ($area_id > 0) {
             $query .= ' AND nt.company_area_id = ?';
         }else {
             $query .= ' AND 0 = ?';
         }

         $query .= ' GROUP BY n.id, n.tittle, n.description, n.user_id, n.deleted_at, n.created_at, n.updated_at';

         $news = DB::select($query, [$team_selected, $area_id]);
         return view('rrhh.news.index', compact('company', 'team_selected', 'areas', 'news', 'area_selected'));
    }

    public function destroy_news(Request $request)
    {
        News::where('id', $request['new_id'])->delete();

        $team_selected = $request->team_id;
        $area_id = 0;
        $area_selected = $area_id;
        $company = Team::where('id', $team_selected)->get();
        $areas = CompanyAreas::where('team_id', $team_selected)->get();
        $query = 'SELECT n.id, n.tittle, n.description, n.user_id, n.deleted_at, n.created_at, n.updated_at, group_concat(ca.name) equipo FROM news n INNER JOIN news_teams nt ON n.id = nt.news_id INNER JOIN company_areas ca ON nt.company_area_id = ca.id WHERE ca.deleted_at IS NULL AND n.deleted_at IS NULL AND ca.team_id = ?';

        if ($area_id > 0) {
            $query .= ' AND nt.company_area_id = ?';
        }else {
            $query .= ' AND 0 = ?';
        }

        $query .= ' GROUP BY n.id, n.tittle, n.description, n.user_id, n.deleted_at, n.created_at, n.updated_at';

        $news = DB::select($query, [$team_selected, $area_id]);
        return view('rrhh.news.index', compact('company', 'team_selected', 'areas', 'news', 'area_selected'));
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
        WHERE u.deleted_at IS NULL AND t.id = ? AND u.id != ?;', [$team_selected, $user_id]);
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
        $users = DB::select('SELECT * FROM (SELECT u.id user_id, u.name, 1 AS assigned FROM users u INNER JOIN company_areas_users cau ON u.id = cau.user_id WHERE u.deleted_at IS NULL AND cau.company_area_id = ?
        UNION SELECT u.id user_id, u.name, 0 AS assigned FROM users u WHERE u.deleted_at IS NULL AND u.id != 1 AND NOT exists (SELECT 1 FROM company_areas_users cau WHERE cau.user_id = u.id and company_area_id = ?)) Q
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


    //-----------------------------------------------------------------INICIO EMPLOYEES
    public function index_employees(Request $request)
    {
        $team_selected = $request->team_id;

        $area_id = $request->area_id;
        $area_selected = $area_id;

        $role_name = $request->role_name;
        $role_selected = $role_name;

        $company = Team::where('id', $team_selected)->get();
        $areas = CompanyAreas::where('team_id', $team_selected)->get();
        $roles = DB::select('SELECT * FROM roles;');

        $query = 'SELECT u.id, u.name, tu.role, group_concat(ca.name) teams FROM users u INNER JOIN team_user tu ON u.id = tu.user_id INNER JOIN company_areas ca ON tu.team_id = ca.team_id INNER JOIN company_areas_users cau ON ca.id = cau.company_area_id AND u.id = cau.user_id WHERE ca.deleted_at IS NULL AND u.deleted_at IS NULL AND u.id != 1 AND tu.team_id = ?';

        if ($area_selected > 0) {
           $query .= ' AND ca.id = ?';
        }else {
            $query .= ' AND 0 = ?';
        }

        if ($role_selected != 'all') {
            $query .= ' AND tu.role = ?';
        }else {
            $query .= ' AND \'all\' = ?';
        }

        $query .= ' GROUP BY u.id, u.name, tu.id, tu.role ORDER BY u.name;';

        $employees = DB::select($query, [$team_selected, $area_selected, $role_selected]);

        return view('rrhh.employees.index', compact('company', 'team_selected', 'areas', 'employees', 'area_selected', 'roles', 'role_selected'));
    }

    public function edit_employee(Request $request)
    {
        $team_selected = $request->team_id;
        $employee_id = $request->employee_id;
        $user_id = $request->id_user;
        $area_id = $request->area_id;

        $user = User::where('id', $employee_id)->get();

        $role_loged = DB::select('SELECT r.id FROM roles r INNER JOIN model_has_roles mhr ON r.id = mhr.role_id WHERE mhr.model_id = ? ', [$user_id]);

        $roles = DB::select('SELECT * FROM (SELECT *, 0 AS assigned FROM roles r WHERE NOT EXISTS (SELECT 1 FROM model_has_roles mhr WHERE r.id = mhr.role_id AND mhr.model_id = ?)
        UNION ALL
        SELECT r.*, 1 AS assigned FROM roles r INNER JOIN model_has_roles mhr ON r.id = mhr.role_id WHERE mhr.model_id = ?) q WHERE q.id >= ?;'
        , [$employee_id, $employee_id, $role_loged[0]->id]);

        $areas = DB::select('SELECT ca.*, 0 AS assigned FROM company_areas ca WHERE ca.deleted_at IS NULL AND ca.team_id = ? AND NOT EXISTS ( SELECT 1 FROM company_areas_users cau WHERE ca.id = cau.company_area_id AND cau.user_id = ?)
        UNION ALL
        SELECT ca.*, 1 AS assigned FROM company_areas ca INNER JOIN company_areas_users cau ON ca.id = cau.company_area_id WHERE ca.deleted_at IS NULL  AND ca.team_id = ? AND cau.user_id = ?;'
        , [$team_selected, $employee_id, $team_selected, $employee_id]);

        return view('rrhh.employees.edit_employee', compact('user', 'roles', 'areas'));
    }

    public function update_employee(Request $request)
    {

        try {

            $user = User::where('id', $request['employee_id'])->update([
                'name' => $request['user_name'],
                'identification' => $request['user_identification'],
            ]);

             CompanyAreasUser::where('user_id', $request['employee_id'])->delete();

             if($_POST) {
                 foreach ($_POST as $clave=>$valor) {
                     if(str_contains($clave, 'chk')){
                      CompanyAreasUser::create([
                            'company_area_id' => $valor,
                            'user_id' => $request['employee_id'],
                        ]);
                     }
                 }
             }

             DB::update('UPDATE model_has_roles SET role_id = ? WHERE model_id = ?', [$request['role'], $request['employee_id']]);
             $rol = DB::select('SELECT * FROM roles r WHERE r.id = ?', [$request['role']]);
             DB::update('UPDATE team_user SET role = ? WHERE user_id = ? AND team_id = ?', [$rol[0]->name, $request['employee_id'], $request['team_id']]);

         } catch (\Exception $e) {
             activity()
                 ->withProperties(['tittle' => $request['tittle'],
                                   'description' => $request['description'],
                                   'class' => __CLASS__,
                                   'function' => __METHOD__
                                   ])
                 ->log('ERROR: ' . $e->getMessage());
         }

         $team_selected = $request->team_id;

         $area_id = $request->area_id;
         $area_selected = $area_id;

         $role_name = $rol[0]->name;
         $role_selected = $role_name;

         $company = Team::where('id', $team_selected)->get();
         $areas = CompanyAreas::where('team_id', $team_selected)->get();
         $roles = DB::select('SELECT * FROM roles;');

         $query = 'SELECT u.id, u.name, tu.role, group_concat(ca.name) teams FROM users u INNER JOIN team_user tu ON u.id = tu.user_id INNER JOIN company_areas ca ON tu.team_id = ca.team_id INNER JOIN company_areas_users cau ON ca.id = cau.company_area_id AND u.id = cau.user_id WHERE ca.deleted_at IS NULL AND u.deleted_at IS NULL AND u.id != 1 AND tu.team_id = ?';

         if ($area_selected > 0) {
            $query .= ' AND ca.id = ?';
         }else {
             $query .= ' AND 0 = ?';
         }

         if ($role_selected != 'all') {
             $query .= ' AND tu.role = ?';
         }else {
             $query .= ' AND \'all\' = ?';
         }

         $query .= ' GROUP BY u.id, u.name, tu.id, tu.role ORDER BY u.name;';

         $employees = DB::select($query, [$team_selected, $area_selected, $role_selected]);

         return view('rrhh.employees.index', compact('company', 'team_selected', 'areas', 'employees', 'area_selected', 'roles', 'role_selected'));
    }

    public function destroy_employee(Request $request)
    {
        $employee_id = $request->employee_id;

        User::find($employee_id)->delete();
        $team_selected = $request->team_id;

        $area_id = $request->area_id;
        $area_selected = $area_id;

        $role_name = $request->role_name;
        $role_selected = $role_name;

        $company = Team::where('id', $team_selected)->get();
        $areas = CompanyAreas::where('team_id', $team_selected)->get();
        $roles = DB::select('SELECT * FROM roles;');

        $query = 'SELECT u.id, u.name, tu.role, group_concat(ca.name) teams FROM users u INNER JOIN team_user tu ON u.id = tu.user_id INNER JOIN company_areas ca ON tu.team_id = ca.team_id INNER JOIN company_areas_users cau ON ca.id = cau.company_area_id AND u.id = cau.user_id WHERE ca.deleted_at IS NULL AND u.deleted_at IS NULL AND u.id != 1 AND tu.team_id = ?';

        if ($area_selected > 0) {
           $query .= ' AND ca.id = ?';
        }else {
            $query .= ' AND 0 = ?';
        }

        if ($role_selected != 'all') {
            $query .= ' AND tu.role = ?';
        }else {
            $query .= ' AND \'all\' = ?';
        }

        $query .= ' GROUP BY u.id, u.name, tu.id, tu.role ORDER BY u.name;';

        $employees = DB::select($query, [$team_selected, $area_selected, $role_selected]);

        return view('rrhh.employees.index', compact('company', 'team_selected', 'areas', 'employees', 'area_selected', 'roles', 'role_selected'));
    }
    //-----------------------------------------------------------------FIN EMPLOYEES

    //-----------------------------------------------------------------INICIO FILES
    public function index_files(Request $request)
    {
        $company_selected = $request->company_id;
        $user_id = $request->id_user;
        $type_file_selected = $request->type_file_id;

        $company = Team::where('id', $company_selected)->first();
        $type_files = TypeFile::all();

        $conditions[] =  ['company_id', $company_selected];

        if($type_file_selected > 0 ) $conditions[] = ['type_file_id', $type_file_selected];

        $files = File::select()->where($conditions)->get();

        return view('rrhh.files.index', compact('company', 'type_files', 'files', 'type_file_selected'));
    }

    public function create_file(Request $request){

        $company_selected = $request->company_id;
        $user_id = $request->id_user;
        $company = Team::where('id', $company_selected)->first();
        $type_files = TypeFile::all();

        return view('rrhh.files.create_file', compact('company', 'type_files'));
    }

    public function store_file(Request $request){

        if($request->hasFile('urlpdf')){
            $file_pdf = $request->file('urlpdf');
            $file_name = $this->generate_name(30).".".$file_pdf->guessExtension();
            $file_path = public_path('storage/paychecks/'.$file_name);

            if ($file_pdf->guessExtension()=='pdf') {

                copy($file_pdf, $file_path);

                $result = File::create([
                    'path' => $file_path,
                    'month' => $request->month,
                    'year' => $request->year,
                    'type_file_id' =>  $request->type_file_id,
                    'user_id' => $request->id_user,
                    'company_id'=> $request->company_id,
                    'comments'=> $request->comments,
                ]);

                Paycheck::create([
                    'path' => '/download/paychecks/1979/8752ba4b-3970-4a46-bf22-a6c2f91f5a38.pdf',
                    'month' => $request->month,
                    'year' => $request->year,
                    'type_file_id' =>  $request->type_file_id,
                    'user_id'=> 2,
                    'company_id'=> $request->company_id,
                    'comments'=> $request->comments,
                ]);

                Paycheck::create([
                    'path' => '/download/paychecks/1974/d78790ee-90d1-4d8a-a4a5-1c4e679df022.pdf',
                    'month' => $request->month,
                    'year' => $request->year,
                    'type_file_id' =>  $request->type_file_id,
                    'user_id'=> 3,
                    'company_id'=> $request->company_id,
                    'comments'=> $request->comments,
                ]);

                Paycheck::create([
                    'path' => '/download/paychecks/1980/0d8db700-559c-4443-b2b7-11f7c699606e.pdf',
                    'month' => $request->month,
                    'year' => $request->year,
                    'type_file_id' =>  $request->type_file_id,
                    'user_id'=>4,
                    'company_id'=> $request->company_id,
                    'comments'=> $request->comments,
                ]);





            }else{
                dd("No es un pdf");
            }

            $company_selected = $request->company_id;
            $user_id = $request->id_user;
            $type_file_selected = 0;

            $company = Team::where('id', $company_selected)->first();
            $type_files = TypeFile::all();

            $conditions[] =  ['company_id', $company_selected];

            if($type_file_selected > 0 ) $conditions[] = ['type_file_id', $type_file_selected];

            $files = File::select()->where($conditions)->get();

            return view('rrhh.files.index', compact('company', 'type_files', 'files', 'type_file_selected'));
        }
    }

    public function destroy_file(Request $request){
        $company_selected = $request->company_id;
        $user_id = $request->id_user;
        $type_file_selected = 0;
        $file_id = $request->file_id;
        File::find($file_id)->delete();

        $company = Team::where('id', $company_selected)->first();
        $type_files = TypeFile::all();

        $conditions[] =  ['company_id', $company_selected];

        if($type_file_selected > 0 ) $conditions[] = ['type_file_id', $type_file_selected];

        $files = File::select()->where($conditions)->get();

        return view('rrhh.files.index', compact('company', 'type_files', 'files', 'type_file_selected'));
    }

    //-----------------------------------------------------------------FIN FILES

    private function generate_name($max) {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return 'pdf_'.substr(str_shuffle($permitted_chars), 0, $max).time();
    }

}
