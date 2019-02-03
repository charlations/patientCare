<?php

namespace App\Http\Controllers;

use App\Patient;
use App\MedHistory;
use App\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{

		/**
		 * Check permissions via middleware for all necesary functions
		 */
		public function __construct()
		{
			$this->middleware('permission:patient_delete')->only('destroy');
		}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
				$patients = DB::table('patients')->get();
				return view('patient.index', ['patients' => $patients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
				$insurances = DB::table('insurances')->get();
        return view('patient.create', ['insurances' => $insurances]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
			Patient::create($request->validate([
				'name' => ['required', 'min:2'],
				'lastNames' => 'nullable',
				'birthdate' => ['required', 'date'],
				'gender' => ['required', 'regex:/^(genderH|genderM|genderO)$/'],
				'email' => ['nullable', 'email'],
				'idInsurance' => ['nullable', 'exists:mysql.insurances,id']
			]));
			return redirect()->route('patient.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        //dd($patient, $patient->id);
				$medHist = DB::table('medHistList')
					->leftJoin('medHistory', function($join) use(&$patient) {
						$join->on('medHistList.id', '=', 'medHistory.idMedHistList')
									->where('medHistory.idPatient', '=', $patient->id);
					})->get();
				/* $medHist = DB::table('medHistory')
					->where('idPatient', $patient->id)
					->join('medHistList', function ($join) {
						$join->on('medHistory.idMedHistList', '=', 'medHistList.id');
					})
					->get(); */
				$age = Patient::getAge($patient->birthdate);
				//dd(compact('medHist', 'patient', 'age'), $age);
				return view('medHist.index', ['medHist' => $medHist])
					->with(compact('patient'))
					->with('patientAge', $age);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
				$insurances = DB::table('insurances')->get();
        return view('patient.edit', compact('patient'), ['insurances' => $insurances]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
				$patient->update($request->validate([
					'name' => ['required', 'min:2'],
					'lastNames' => 'nullable',
					'birthdate' => ['required', 'date'],
					'gender' => ['required', 'regex:/^(Hombre|Mujer|Otro)$/'],
					'email' => ['nullable', 'email'],
					'idInsurance' => ['nullable', 'exists:mysql.insurances,id']
				]));
				return redirect()->route('patient.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
			$patient->delete();
			return redirect('/patient');
    }
}
