<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    private string $access_token;
    public function setUp(): void
    {
        parent::setUp();
        $response = $this->postJson('/api/auth/login', [
            'email' => 'user@gmail.net',
            'password' => 'password',
        ]);
        $this->access_token = $response->json('access_token');
        $this->withHeader('Authorization', 'Bearer ' . $this->access_token);
    }


    public function test_laporan_motor()
    {
        $response = $this->postJson('/api/laporan', [
            'tgl_awal' => '20-07-2023',
            'tgl_akhir' => '21-07-2023',
            'tipe' => 'motor',
        ]);

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'data' => $response->json('data'),
        ]);
    }

    public function test_laporan_mobil()
    {
        $response = $this->postJson('/api/laporan', [
            'tgl_awal' => '20-07-2023',
            'tgl_akhir' => '21-07-2023',
            'tipe' => 'mobil',
        ]);

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'data' => $response->json('data'),
        ]);
    }
}
