<?php

namespace App\Http\Controllers;

use App\Models\Paycheck;
use Illuminate\Http\Request;

class PaycheckController extends Controller
{
    public function index(Request $request)
    {
        $paychecks = Paycheck::where('user_id','=', $request->id)->get();
        return view('paychecks.index', compact('paychecks'));
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
