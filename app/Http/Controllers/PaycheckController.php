<?php

namespace App\Http\Controllers;

use App\Models\Paycheck;
use App\Models\User;
use Illuminate\Http\Request;

class PaycheckController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('id', $request->id)->get();

        $tfauth = $user[0]->two_factor_secret == null ? false : true;

        $paychecks = Paycheck::where('user_id','=', $request->id)->get();

        if ($tfauth) {
            return view('paychecks.index', compact('paychecks'));
        }else {
            return view('paychecks.index', [
                'errorCode' => 403,
                'errorMessage' => 'No tiene habilitado 2FA.',
            ]);
        }
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show(Paycheck $paycheck)
    {
        return view('paychecks.show', compact('paycheck'));
    }

    public function edit(Paycheck $paycheck)
    {

    }

    public function update(Request $request, Paycheck $paycheck)
    {

    }

    public function destroy(Paycheck $paycheck)
    {

    }
}
