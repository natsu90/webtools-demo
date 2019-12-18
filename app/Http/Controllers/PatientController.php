<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;

class PatientController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$patients = Patient::all();

    	return view('patient.index', compact('patients'));
    }

    public function edit($id)
    {
    	$patient = Patient::find($id);

    	return view('patient.form', compact('patient'));
    }

    public function create()
    {
    	return view('patient.form');
    }

    public function update($id, Request $request)
    {
    	$data = $this->validateRequest($request);

    	$patient = Patient::find($id);
    	$patient->update($data);

    	return redirect('/patients/'. $patient->id);
    }

    public function store(Request $request)
    {
    	$data = $this->validateRequest($request);

    	$patient = Patient::create($data);

    	return redirect('/patients/'. $patient->id);
    }

    protected function validateRequest(Request $request)
    {
    	return $request->validate([
    		'name' => 'required'
    	]);
    }
}
