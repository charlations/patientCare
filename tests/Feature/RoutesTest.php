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
	public function testUserRoutes($email = null, $pass = null) {
		$email = ($email == null ? 'carla@email.com' : $email);
		$pass = ($pass == null ? '123456' : $pass);
		$response = $this->post('/login', [
			'email' => $email,
			'password' => $pass,
		]);
		$response->assertRedirect('/home');
		$response->assertLocation('/home');
		
		$response = $this->get('/');
		$response->assertStatus(200);
		$response->assertLocation('/');

		$response = $this->get('/home');  //get('/home');
		//echo $response->getOriginalContent();
		print_r($response->headers);
		$response->assertStatus(200);
		$response->assertViewIs('patient.index');

		$response = $this->get('/insurance');
		$response->assertStatus(200);
		$response->assertViewIs('insurance.index');

		$response = $this->get('/user');
		$response->assertStatus(200);
		$response->assertViewIs('user.index');

		$response = $this->get('/patient');
		$response->assertStatus(200);
		$response->assertViewIs('patient.index');

		$response = $this->get('/appointment');
		$response->assertStatus(200);
		$response->assertViewIs('appointment.index');
	}

	/*public function testDoctorRoutes() {
		testUserRoutes('chezz@email.com');
	}

	public function testAssistantRoutes() {
		testUserRoutes('azu@email.com');
	}*/
}
