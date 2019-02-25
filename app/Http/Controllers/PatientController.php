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
		 * Require user be logged in
		 */
		public function __construct()
		{
				$this->middleware('auth');
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
				'gender' => ['required', 'regex:/^(genderF|genderM|genderO)$/'],
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
        /* OLD
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
					->get(); */ /* OLD */
				$medHistList = DB::table('medHistList')->get();
				$medHistHistory = DB::table('medHistory')->where('idPatient', $patient->id)->get();
				foreach($medHistList as $listItem) {
					$listItem->histRecord = NULL;
					foreach($medHistHistory as $medHistItem) {
						if($listItem->id == $medHistItem->idMedHistList) {
							$listItem->histRecord = $medHistItem->histRecord;
						}
					}
				}
				// Para formatear la fecha en el blade: "{{ date('d/m/Y', strtotime($appoint->created_at)) }}"
				$appointments = DB::table('appointments')->where('idPatient', $patient->id)->orderBy('created_at', 'desc')->get();
				$age = Patient::getAge($patient->birthdate);
				//dd(compact('patient', 'medHistList', 'appointments'), sizeof($medHistHistory));
				return view('patient.show', compact('medHistList'))
					->with(compact('patient'))
					->with(compact('appointments'))
					->with('patientAge', $age)
					->with('medHistRegisters', sizeof($medHistHistory));
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
				$medHistList = DB::table('medHistList')->get();
				$medHistHistory = DB::table('medHistory')->where('idPatient', $patient->id)->get();
				foreach($medHistList as $listItem) {
					$listItem->histRecord = NULL;
					foreach($medHistHistory as $medHistItem) {
						if($listItem->id == $medHistItem->idMedHistList) {
							$listItem->histRecord = $medHistItem->histRecord;
						}
					}
				}
				//dd(compact('patient'), compact('insurances'), compact('medHistList'));
				return view('patient.edit', compact('patient'))
					->with(compact('medHistList'))
					->with(compact('insurances'));
				/* OLD
				$medHist = DB::table('medHistList')
					->leftJoin('medHistory', function($join) use(&$patient) {
						$join->on('medHistList.id', '=', 'medHistory.idMedHistList')
									->where('medHistory.idPatient', '=', $patient->id);
					})->get();
				dd(compact('patient'), compact('medHist'), compact('insurances'));
        return view('patient.edit', compact('patient'), ['insurances' => $insurances, 'medHist' => $medHist]); /* OLD */
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
				/*  $tempArray = [];
				foreach($request->except(['_token', '_method', 'name', 'lastNames', 'birthdate', 'gender', 'email', 'idInsurance']) as $histReqKey => $histReqPart) {
					array_push($tempArray, $histReqKey);
					array_push($tempArray, $histReqPart);
				}
				dd($request, $patient->id, $tempArray); /*  */
				//dd($request->except(['_token', '_method', 'name', 'lastNames', 'birthdate', 'gender', 'email', 'idInsurance']));
				$patient->update($request->validate([
					'name' => ['required', 'min:2'],
					'lastNames' => 'nullable',
					'birthdate' => ['required', 'date'],
					'gender' => ['required', 'regex:/^(genderF|genderM|genderO)$/'],
					'email' => ['nullable', 'email'],
					'idInsurance' => ['nullable', 'exists:mysql.insurances,id']
				]));
				// HERE
				foreach($request->except(['_token', '_method', 'name', 'lastNames', 'birthdate', 'gender', 'email', 'idInsurance']) as $histReqKey => $histReqPart) {
					$histMed = MedHistory::updateOrCreate(['idMedHistList' => $histReqKey, 'idPatient' => $patient->id], ['idPatient' => $patient->id, 'idMedHistList' => $histReqKey, 'histRecord' => $histReqPart]);
				}
				// TO HERE
				return redirect()->action('PatientController@show', $patient);
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
