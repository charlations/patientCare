<?php

namespace App\Http\Controllers;

use App\MedHistory;
use App\Patient;
use App\MedHistList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Patient $patient)
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MedHistory  $medHistory
     * @return \Illuminate\Http\Response
     */
    public function show(MedHistory $medHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MedHistory  $medHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(MedHistory $medHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MedHistory  $medHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MedHistory $medHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MedHistory  $medHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedHistory $medHistory)
    {
        //
    }
}
