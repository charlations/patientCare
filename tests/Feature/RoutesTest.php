<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoutesTest extends TestCase
{
	/**
	 * Test all existing routes are reachable.
	 *
	 */
	public function testRoutes() {
		$response = $this->get('/');
		$response->assertStatus(200);
		$response->assertLocation('/');

		$response = $this->get('/home');
		$response->assertRedirect('/login');

		$response = $this->get('/insurance');
		$response->assertRedirect('/login');

		$response = $this->get('/user');
		$response->assertRedirect('/login');

		$response = $this->get('/patient');
		$response->assertRedirect('/login');

		$response = $this->get('/appointment');
		$response->assertRedirect('/login');
	}


	/**
	 * Test non reachable route.
	 * TODO: Define unreachable behaviour
	 */
	public function testFakeRoute() {
		$response = $this->get('/notValidRoute');
		$response->assertStatus(404);
	}

	/**
	* Test User reachable routes are reachable. 
	*
	*/
	public function testUserRoutes($email = null, $pass = null, $role = 'admin') {
		$email = ($email == null ? 'carla@email.com' : $email);
		$pass = ($pass == null ? '123456' : $pass);
		$user = new User(['email' => $email, 'password' => $pass]);
		$response = $this->post('/login', [
			'email' => $email,
			'password' => $pass,
		]);
		$response->assertRedirect('/home');
		$response->assertLocation('/home');
		
		$response = $this->get('/');
		$response->assertStatus(200);
		$response->assertLocation('/');

		$response = $this->get('/home');
		$response->assertStatus(200);
		$response->assertViewIs('patient.index');

		$response = $this->get('/insurance');
		if($role == 'admin' || $role == 'doctor' || $role == 'assistant') {
			$response->assertStatus(200);
			$response->assertViewIs('insurance.index');
		} else {
			echo ("\nNo tiene permiso\n");
			$response->assertStatus(302);
		}
		
		$response = $this->get('/user');
		if($role == 'admin') {
			$response->assertStatus(200);
			$response->assertViewIs('user.index');
		} else {
			$response->assertStatus(302);
		}

		$response = $this->get('/patient');
		if($role == 'admin' || $role == 'doctor' || $role == 'assistant') {
			$response->assertStatus(200);
			$response->assertViewIs('patient.index');
		} else {
			$response->assertStatus(302);
		}

		$response = $this->get('/appointment');
		if($role == 'admin' || $role == 'doctor') {
			$response->assertStatus(200);
			$response->assertViewIs('appointment.index');
		} else {
			$response->assertStatus(302);
		}
	}

	public function testDoctorRoutes() {
		$this->testUserRoutes('chezz@email.com', '654321', 'doctor');
	}

	public function testAssistantRoutes() {
		$this->testUserRoutes('azu@email.com', '123456', 'assistant');
	}
}
