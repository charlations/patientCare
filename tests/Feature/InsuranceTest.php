<?php

namespace Tests\Feature;

use App\Insurance;
use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class InsuranceTest extends TestCase
{	

	public function createSession() {
		$credentials = array(
			'email' => 'carla@email.com',
			'password' => '123456',
		);
		$response = $this->post('/login', $credentials);
	}
	/**
	 * Test insurance 
	 * 
	 */
	public function testCreateInsuranceSucessfully() {
		$this->createSession();
		$response = $this->get('/insurance');
		$response = $this->post('/insurance',[
			'insuranceName' => 'FooInsurance',
			'notes' => 'FooNote',
			'_token' => csrf_token(),
		]);
		$this->assertDatabaseHas('insurances', [
				'insuranceName' => 'FooInsurance'
		]);
		$response->assertLocation('/insurance');
	}

	/**
	 * Test insurance without name
	 */
	public function testInsuranceNoName() {

		$this->createSession();
		$response = $this->get('/insurance');
		$response = $this->post('/insurance',[
			'notes' => 'NoteNoName',
			'_token' => csrf_token(),
		]);
		$this->assertDatabaseMissing('insurances', [
				'notes' => 'NoteNoName'
		]);
		$response->assertLocation('/insurance');
	}

	public function testInsuranceUpdate() {
		$this->createSession();
		$insurance = DB::table('insurances')->where('insuranceName','=','FooInsurance')->first();
		$response = $this->post('/insurance/'.$insurance->id,[
			'insuranceName' => 'FooInsuranceUpdate',
			'notes' => 'FooNoteUpdate',
			'_method' => 'PATCH',
			'_token' => csrf_token(),
		]);
		$this->assertDatabaseHas('insurances', [
			'insuranceName' => 'FooInsuranceUpdate',
			'notes' => 'FooNoteUpdate'
		]);
		$this->assertDatabaseMissing('insurances', [
			'insuranceName' => 'FooInsurance'
		]);
		$response->assertLocation('/insurance');
	}

	public function testInsuranceDelete() {
		$this->createSession();
		$insurance = DB::table('insurances')->where('insuranceName','=','FooInsuranceUpdate')->first();
		$response = $this->post('/insurance/'.$insurance->id,[
			'_method' => 'DELETE',
			'_token' => csrf_token(),
		]);
		$this->assertDatabaseMissing('insurances', [
			'insuranceName' => 'FooInsuranceUpdate'
		]);
		$response->assertLocation('/insurance');
	}
}
