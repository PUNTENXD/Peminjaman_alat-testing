<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Alat;
use App\Models\Peminjaman;

class PeminjamanTest extends TestCase
{
    use RefreshDatabase;

public function test_peminjaman_berhasil_dan_stok_berkurang()
{
    $user = User::factory()->create([
        'role' => 'peminjam'
    ]);

    $alat = Alat::factory()->create([
        'stok' => 5
    ]);

    $response = $this->post('/peminjaman', [
        'id_user' => $user->id_user,
        'id_alat' => $alat->id_alat,
        'jumlah' => 2,
        'tgl_rencana_kembali' => now()->addDays(3)
    ]);

    $response->assertStatus(302); // redirect success

    $this->assertDatabaseHas('peminjaman', [
        'id_user' => $user->id_user,
        'id_alat' => $alat->id_alat,
        'jumlah' => 2
    ]);

    $this->assertEquals(3, $alat->fresh()->stok);
}

    }


