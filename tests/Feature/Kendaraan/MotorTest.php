<?php

namespace Tests\Feature\Kendaraan;

use App\Models\Kendaraan;
use App\Models\Kendaraan\Motor;
use Tests\TestCase;

class MotorTest extends TestCase
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

    public function test_get_all()
    {
        $response = $this->getJson('/api/kendaraan/motor');

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'data' => $response->json('data'),
        ]);
    }

    public function test_store()
    {
        $response = $this->postJson('/api/kendaraan/motor', [
            'tahun_keluaran' => 2022,
            'warna' => 'Biru',
            'harga' => 20_000_000,
            'mesin' => 'DOHC',
            'tipe_suspensi' => 'Parallel Fork',
            'tipe_transmisi' => 'Otomatis',
        ]);

        $response->assertStatus(201)->assertJson([
            'status' => 201,
            'message' => 'Berhasil menambahkan data motor',
            'data' => $response->json('data'),
        ]);

        Motor::destroy($response->json('data._id'));
        Kendaraan::destroy($response->json('data.kendaraan_id'));
    }

    public function test_get_one()
    {
        $createResponse = $this->postJson('/api/kendaraan/motor', [
            'tahun_keluaran' => 2022,
            'warna' => 'Biru',
            'harga' => 20_000_000,
            'mesin' => 'DOHC',
            'tipe_suspensi' => 'Parallel Fork',
            'tipe_transmisi' => 'Otomatis',
        ]);

        $createResponse->assertStatus(201)->assertJson([
            'status' => 201,
            'message' => 'Berhasil menambahkan data motor',
            'data' => $createResponse->json('data'),
        ]);

        $id = $createResponse->json('data._id');
        $lihatResponse = $this->getJson('/api/kendaraan/motor/' . $id);
        $lihatResponse->assertJson([
            'status' => 200,
            'data' => $lihatResponse->json('data'),
        ]);

        Motor::destroy($createResponse->json('data._id'));
        Kendaraan::destroy($createResponse->json('data.kendaraan_id'));
    }

    public function test_update()
    {
        $createResponse = $this->postJson('/api/kendaraan/motor', [
            'tahun_keluaran' => 2022,
            'warna' => 'Biru',
            'harga' => 20_000_000,
            'mesin' => 'DOHC',
            'tipe_suspensi' => 'Parallel Fork',
            'tipe_transmisi' => 'Otomatis',
        ]);

        $createResponse->assertStatus(201)->assertJson([
            'status' => 201,
            'message' => 'Berhasil menambahkan data motor',
            'data' => $createResponse->json('data'),
        ]);


        $id = $createResponse->json('data._id');

        $updateResponse = $this->putJson('/api/kendaraan/motor/' . $id, [
            'harga' => 23_000_000,
            'mesin' => 'Tiga Stroke',
            'tipe_suspensi' => 'OHV',
            'tipe_transmisi' => 'Otomatis',
        ]);

        $updateResponse->assertStatus(200)->assertJson([
            'status' => 200,
            'message' => 'Berhasil mengubah data motor',
            'data' => $updateResponse->json('data'),
        ]);

        Motor::destroy($createResponse->json('data._id'));
        Kendaraan::destroy($createResponse->json('data.kendaraan_id'));
    }

    public function test_delete()
    {
        $createResponse = $this->postJson('/api/kendaraan/motor', [
            'tahun_keluaran' => 2022,
            'warna' => 'Biru',
            'harga' => 250_000_000,
            'mesin' => 'DOHC',
            'tipe_suspensi' => 'Parallel Fork',
            'tipe_transmisi' => 'Otomatis',
        ]);

        $createResponse->assertStatus(201)->assertJson([
            'status' => 201,
            'message' => 'Berhasil menambahkan data motor',
            'data' => $createResponse->json('data'),
        ]);

        $id = $createResponse->json('data._id');

        $deleteResponse = $this->deleteJson('/api/kendaraan/motor/' . $id);

        $deleteResponse->assertStatus(200)->assertJson([
            'status' => 200,
            'message' => 'Berhasil menghapus data motor',
        ]);
    }

    public function test_lihat_stok()
    {
        $createResponse = $this->postJson('/api/kendaraan/motor', [
            'tahun_keluaran' => 2022,
            'warna' => 'Biru',
            'harga' => 250_000_000,
            'mesin' => 'DOHC',
            'tipe_suspensi' => 'Parallel Fork',
            'tipe_transmisi' => 'Otomatis',
        ]);

        $createResponse->assertStatus(201)->assertJson([
            'status' => 201,
            'message' => 'Berhasil menambahkan data motor',
            'data' => $createResponse->json('data'),
        ]);

        $this->assertEquals(0, $createResponse->json('data.kendaraan.stok'));

        $id = $createResponse->json('data._id');
        $lihatStokResponse = $this->getJson('/api/kendaraan/motor/' . $id  . '/stok', [
            'stok' => 10,
        ]);

        $lihatStokResponse->assertStatus(200)->assertJson([
            'status' => 200,
            'data' => $lihatStokResponse->json('data'),
        ]);

        Motor::destroy($createResponse->json('data._id'));
        Kendaraan::destroy($createResponse->json('data.kendaraan_id'));
    }

    public function test_update_stok()
    {
        $createResponse = $this->postJson('/api/kendaraan/motor', [
            'tahun_keluaran' => 2022,
            'warna' => 'Biru',
            'harga' => 250_000_000,
            'mesin' => 'DOHC',
            'tipe_suspensi' => 'Parallel Fork',
            'tipe_transmisi' => 'Otomatis',
        ]);

        $createResponse->assertStatus(201)->assertJson([
            'status' => 201,
            'message' => 'Berhasil menambahkan data motor',
            'data' => $createResponse->json('data'),
        ]);

        $this->assertEquals(0, $createResponse->json('data.kendaraan.stok'));

        $id = $createResponse->json('data._id');

        $updateStokResponse = $this->putJson('/api/kendaraan/motor/' . $id  . '/stok', [
            'stok' => 10,
        ]);

        $updateStokResponse->assertStatus(200)->assertJson([
            'status' => 200,
            'data' => $updateStokResponse->json('data'),
        ]);

        $this->assertEquals(10, $updateStokResponse->json('data.kendaraan.stok'));

        Motor::destroy($createResponse->json('data._id'));
        Kendaraan::destroy($createResponse->json('data.kendaraan_id'));
    }
}
