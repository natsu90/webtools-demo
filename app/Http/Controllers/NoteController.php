<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Note;

class NoteController extends BaseController
{
    public function store($id, Request $request)
    {
    	$data = $this->validateRequest($request);

    	$patient = Patient::find($id);
    	$patient->notes()->create($data);

    	return redirect('/patients/'. $patient->id);
    }

    protected function validateRequest(Request $request)
    {
    	return $request->validate([
    		'description' => 'required'
    	]);
    }

    public function update($id, Request $request)
    {
    	$data = $this->validateRequest($request);

    	$note = Note::find($id);
    	$note->update($data);

    	return redirect('/patients/'. $note->patient_id);
    }

    public function edit($id)
    {
    	$note = Note::find($id);
    	$patient = $note->patient;

    	return view('note.form', compact('note', 'patient'));
    }

    public function create($id)
    {
    	$patient = Patient::find($id);

    	return view('note.form', compact('patient'));
    }
}
