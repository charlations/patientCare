<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
		/**
		 * Test login with correct user and password
		 * ./vendor/bin/phpunit
		 */
		public function testLoginSucessfully()
		{
			/*T_T*/
			$user = factory(User::class)->create([
				'password' => bcrypt($password = 'whydoeslaravelhateme'),
			]);
			$response = $this->post('/login', [
				'email' => $user->email,
				'password' => $password,
			]);
			$response->assertRedirect('/home');
			$this->assertAuthenticatedAs($user);
			$user->forceDelete();
		}
		
		/**
		 * Test login with correct user but wrong password
		 */
		public function testLoginWrongPass()
		{
			$user = factory(User::class)->create([
				'password' => bcrypt($password = 'whydoeslaravelhateme'),
			]);
			$response = $this->from('/login')->post('/login', [
				'email' => $user->email,
				'password' => 'thisisthewrongpassword',
			]);
			$response->assertRedirect('/login');
			$response->assertSessionHasErrors('email');
			$this->assertTrue(session()->hasOldInput('email'));
			$this->assertFalse(session()->hasOldInput('password'));
			$this->assertGuest();
			$user->forceDelete();
		}
		
		/**
		 * Test login with correct user and password
		 */
		public function testLoginWrongUser()
		{
			$user = factory(User::class)->create([
				'password' => bcrypt($password = 'whydoeslaravelhateme'),
			]);
			$response = $this->from('/login')->post('/login', [
				'email' => 'thisisnotmyemail@email.com',
				'password' => $password,
			]);
			$response->assertRedirect('/login');
			$response->assertSessionHasErrors('email');
			$this->assertTrue(session()->hasOldInput('email'));
			$this->assertFalse(session()->hasOldInput('password'));
			$this->assertGuest();
			$user->forceDelete();
		}
		
		/**
		 * Test login with correct user and no password
		 */
		public function testLoginNoPassword()
		{
			$user = factory(User::class)->create([
				'password' => bcrypt($password = 'whydoeslaravelhateme'),
			]);
			$response = $this->get('/login');
			$response = $this->from('/login')->post('/login', [
				'email' => $user->email,
				'password' => '',
			]);
			$response->assertRedirect('/login');
			$response->assertSessionHasErrors('password');
			$this->assertTrue(session()->hasOldInput('email'));
			$this->assertFalse(session()->hasOldInput('password'));
			$this->assertGuest();
			$user->forceDelete();
		}
}
