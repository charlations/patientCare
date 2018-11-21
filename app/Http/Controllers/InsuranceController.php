<?php

namespace App\Http\Controllers;
use App\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
				$insurances = DB::table('insurances')->get();
				return view('insurance.index', ['insurances' => $insurances]);
		}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
			Insurance::create($request->all());
			return view('insurance.index', ['insurances' => $insurances]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
			Insurance::create($request->validate([
				'insuranceName' => ['required', 'min:2'],
				'notes' => 'nullable'
			]));
			return redirect()->route('insurance.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Insurance $insurance, Request $request)
    {
				$insurance->update($request->validate([
					'insuranceName' => ['required', 'min:2'],
					'notes' => 'nullable'
				]))	;
				/* $insurance = Insurance::findOrFail($id);
				
				$insurance->insuranceName = $request['insuranceName'];
				$insurance->notes = $request['notes'];

				$insurance->save(); */
				return redirect('/insurance');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Insurance $insurance)
    {
        $insurance->delete();
				return redirect('/insurance');
    }
}
