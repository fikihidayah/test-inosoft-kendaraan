<?php

namespace Tests\Feature;

use App\Models\Kendaraan;
use App\Models\Kendaraan\Motor;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SaleTest extends TestCase
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

    public function test_get_all(): void
    {
        $response = $this->getJson('/api/sale');

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'data' => $response->json('data'),
        ]);
    }

    public function test_get_one()
    {
        $id_sale =  $this->test_store_motor();
        $response = $this->getJson('/api/sale/' . $id_sale);

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'data' => $response->json('data'),
        ]);
    }

    public function store_motor(): array
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

        $kendaraan_id = $createResponse->json('data.kendaraan_id');

        $id = $createResponse->json('data._id');

        $updateStokResponse = $this->putJson('/api/kendaraan/motor/' . $id  . '/stok', [
            'stok' => 10,
        ]);

        $updateStokResponse->assertStatus(200)->assertJson([
            'status' => 200,
            'data' => $updateStokResponse->json('data'),
        ]);

        $createSaleResponse = $this->postJson('/api/sale', [
            'kendaraan_id' => $kendaraan_id,
            'jumlah' => 2,
            'total_harga' => 40_000_000,
            'tipe' => 'motor',
        ]);

        $createSaleResponse->assertStatus(201)->assertJson([
            'status' => 201,
            'message' => 'Berhasil menambahan transaksi penjualan!',
            'data' => $createSaleResponse->json('data'),
        ]);

        return ['create' => $createResponse, 'createSale' => $createSaleResponse];
    }

    public function test_store_motor(): string
    {
        $response = $this->store_motor();
        $createResponse = $response['create'];
        $createSaleResponse = $response['createSale'];

        $this->destroy($createResponse);

        $id = $createSaleResponse->json('data._id');

        Sale::destroy($id);
        return $id;
    }

    private function destroy($response): void
    {
        Motor::destroy($response->json('data._id'));
        Kendaraan::destroy($response->json('data.kendaraan_id'));
    }

    public function test_destroy(): void
    {
        $response = $this->store_motor();
        $createResponse = $response['create'];
        $createSaleResponse = $response['createSale'];
        $id = $createSaleResponse->json('data._id');

        $destroyResponse = $this->deleteJson('/api/sale/' . $id);
        $destroyResponse->assertStatus(200)->assertJson([
            'status' => 200,
            'message' => 'Berhasil menghapus data penjualan',
        ]);

        $this->destroy($createResponse);
    }
}
