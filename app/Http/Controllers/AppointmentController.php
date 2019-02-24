<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($patientId)
    {
				//Get the stored diagnosis
				$diagnosis = DB::table('appointments')->select('diagnosis')->distinct()->get();
				$patient = DB::table('patients')->where('id', $patientId)->first();
				//dd(compact('patient', 'diagnosis'));
				return view('appointment.create', compact('patient', 'diagnosis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($patientId, Request $request)
    {
				$pId = ['idPatient' => $patientId];
				$request->merge($pId);
				//dd(compact('request'));
				$app = Appointment::create($request->validate([
					'idPatient' => ['required', 'exists:mysql.patients,id'],
					'symptoms' => 'nullable',
					'heartrate' => 'nullable',
					'bloodpressure' => ['nullable', 'regex:/[0-9][0-9]+\/[0-9][0-9]+/'],
					'temp' => 'nullable',
					'weight' => 'nullable',
					'height' => 'nullable',
					'exploration' => 'nullable',
					'prevStudies' => 'nullable',
					'diagnosis' => 'required',
					'treatment' => 'nullable'
				]));
				return redirect()->action('PatientController@show', $patientId);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
