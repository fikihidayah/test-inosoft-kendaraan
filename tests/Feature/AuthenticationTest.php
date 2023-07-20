<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // Delete sebelum di test untuk register
        User::where('name', 'user biasa')->delete();
    }

    public function test_login(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'user@gmail.net',
            'password' => 'password', // credential ini sudah ada sejak awal dibuat dengan seeder
        ]);

        $access_token = $response->json('access_token');
        $expire_in = $response->json('expire_in');

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'access_token' => $access_token,
            'token_type' => 'bearer',
            'expire_in' => $expire_in
        ]);
    }

    public function test_register(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'user biasa',
            'email' => 'userbiasa@gmail.com',
            'password' => '123456',
            'confirm_password' => '123456',
        ]);

        $data = $response->json('data');

        $response->assertStatus(201)->assertJson([
            'status' => 201,
            'message' => 'You have successed register!',
            'data' => $data,
        ]);
    }

    public function test_logout()
    {
        $login = $this->postJson('/api/auth/login', [
            'email' => 'user@gmail.net',
            'password' => 'password',
        ]);

        $login->assertStatus(200);

        $response = $this->postJson('/api/auth/logout');
        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'message' => 'Successed log out!',
        ]);
    }

    public function test_refresh_token()
    {
        $login = $this->postJson('/api/auth/login', [
            'email' => 'user@gmail.net',
            'password' => 'password',
        ]);

        $login->assertStatus(200);

        $response = $this->getJson('/api/auth/refresh');

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'access_token' => $response->json('access_token'),
            'token_type' => 'bearer',
        ]);
    }

    public function test_user_exsits()
    {
        $login = $this->postJson('/api/auth/login', [
            'email' => 'user@gmail.net',
            'password' => 'password',
        ]);

        $access_token = $login->json('access_token');

        $response = $this->withHeader('Authorization', 'Bearer ' . $access_token)
            ->getJson('/api/users/me');

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'data' => $response->json('data'),
        ]);
    }
}
