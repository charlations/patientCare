<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    
    /**
		 * Require user be logged in
		 * Check permissions via middleware for all necessary functions
		 */
		public function __construct()
		{
				$this->middleware('auth');
				$this->middleware('permission:appointment_index')->only('index');
				$this->middleware('permission:appointment_index')->only('indexAll');
				$this->middleware('permission:appointment_create')->only('create');
				$this->middleware('permission:appointment_create')->only('store');
				$this->middleware('permission:appointment_view')->only('show');
				$this->middleware('permission:appointment_edit')->only('edit');
				$this->middleware('permission:appointment_edit')->only('update');
				$this->middleware('permission:appointment_delete')->only('destroy');
		}
		
		/**
     * Display a listing of the resource.
     * @param int patientId
     * @return \Illuminate\Http\Response
     */
    public function index($patientId)
    {
				$appointments = Appointment::where('idPatient', $patientId)
					->orderBy('created_at', 'desc')
					->simplePaginate(10);
				$patient = DB::table('patients')->where('id', $patientId)->first();
				//dd(compact('patient', 'appointments'));
				return view('appointment.index', compact('patient', 'appointments'));
    }

    /**
     * Display a listing of the all the appointments, not filtering by the patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAll()
    {
				$appointments = Appointment::orderBy('created_at', 'desc')
					->join('patients', 'appointments.idPatient', '=', 'patients.id')
					->select('appointments.*', 'patients.name', 'patients.lastNames')
					->simplePaginate(10);
				//dd($appointments, $appointments->links());
				return view('appointment.index', compact('appointments'));
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
    public function show($patientId, Appointment $appointment)
    {
				$patient = Patient::findOrFail($patientId);
				if ($appointment->idPatient == $patientId) {
					//dd(compact('patient', 'appointment'));
					return view('appointment.show', compact('patient', 'appointment'));
				} else {
					abort(404);
				}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit($patientId, Appointment $appointment)
    {
				//If patientId in URL and appointment don't match, return error
				if ($appointment->idPatient != $patientId) {
					abort(404);
				}
				//Get the stored diagnosis
				$diagnosis = DB::table('appointments')->select('diagnosis')->distinct()->get();
				$patient = DB::table('patients')->where('id', $patientId)->first();
				dd(compact('appointment', 'patient', 'diagnosis'));
				return view('appointment.create', compact('appointment', 'patient', 'diagnosis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $patientId, Appointment $appointment)
    {
        dd($request, $patientId, $appointment);
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
