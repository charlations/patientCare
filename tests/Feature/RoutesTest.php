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
	public function testUserRoutes() {
		$response = $this->post('/login', [
			'email' => 'carla@email.com',
			'password' => '123456',
		]);
		$response->assertRedirect('/home');

		$response = $this->get('/home');
		$response->assertLocation('/home');

		$response = $this->get('/insurance');
		$response->assertLocation('/insurance');

		$response = $this->get('/user');
		$response->assertLocation('/user');

		$response = $this->get('/patient');
		$response->assertLocation('/patient');

		$response = $this->get('/appointment');
		$response->assertLocation('/appointment');
	}
}
