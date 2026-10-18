<?php

use App\Models\AsnDariApi;
use App\Models\DataAbsen;
use App\Models\ListKantor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    seedRoles();
});

/**
 * Siapkan dua kantor beserta data ASN & absen agar ada isian dropdown rekap.
 */
function siapkanDuaKantor(): array
{
    $tahun = date('Y');

    foreach ([
        ['Kantor Alpha', 'kantor-alpha-id', '1000000000000001'],
        ['Kantor Beta', 'kantor-beta-id', '1000000000000002'],
    ] as [$nama, $id, $nip]) {
        $kantor = ListKantor::factory()->create([
            'nama_kantor' => $nama,
            'id_kantor' => $id,
        ]);

        AsnDariApi::create([
            'nip' => $nip,
            'nama' => 'ASN '.$nama,
            'pangkat' => 'Pembina',
            'golongan' => 'IV/a',
            'status' => 'PNS',
            'jabatan' => 'Pelaksana',
            'unor_siasn' => 'Unor Siasn',
            'unor_siasn_induk' => $nama,
            'unor_simpegnas_id' => $kantor->id_kantor,
            'unor_simpegnas' => $kantor->nama_kantor,
            'foto_simpegnas' => null,
        ]);

        DataAbsen::factory()->create([
            'nip' => $nip,
            'nama' => 'ASN '.$nama,
            'date' => $tahun.'-08-01',
            'hari_libur' => '0',
            'unor_simpegnas' => $kantor->nama_kantor,
            'unor_simpegnas_id' => $kantor->id_kantor,
            'status' => 'HM',
            'status_change' => 'HN',
            'status_script' => 'HN',
            'persentase' => '100',
        ]);
    }

    return [
        'alpha' => ['Kantor Alpha', 'kantor-alpha-id'],
        'beta' => ['Kantor Beta', 'kantor-beta-id'],
    ];
}

test('guest ditolak dari route admin dan pic', function () {
    $this->get('/admin')->assertRedirect('/login');
    $this->get('/pic/dashboard/pic')->assertRedirect('/login');
    $this->get('/admin/list-user')->assertRedirect('/login');
});

test('operator ditolak dari route admin', function () {
    $this->actingAs(createUserWithRole('operator'))
        ->get('/admin/list-user')
        ->assertForbidden();
});

test('admin bisa mengakses route admin', function () {
    $this->actingAs(createUserWithRole('admin'))
        ->get('/admin/list-user')
        ->assertOk();
});

test('admin melihat semua kantor di rekap', function () {
    siapkanDuaKantor();

    $response = $this->actingAs(createUserWithRole('admin'))->get('/pic/dashboard/pic');

    $response->assertOk()
        ->assertSee('Kantor Alpha')
        ->assertSee('Kantor Beta');
});

test('operator tanpa setting kantor hanya melihat kantornya sendiri', function () {
    siapkanDuaKantor();

    $operator = User::factory()->create(['unor' => 'Kantor Alpha']);
    $operator->assignRole('operator');

    $response = $this->actingAs($operator)->get('/pic/dashboard/pic');

    $response->assertOk()
        ->assertSee('Kantor Alpha')
        ->assertDontSee('Kantor Beta');
});

test('operator dengan setting kantor admin melihat kantor tersebut', function () {
    siapkanDuaKantor();

    $operator = User::factory()->create(['unor' => 'Kantor Alpha']);
    $operator->assignRole('operator');
    $operator->syncKantorUnor(['Kantor Beta']);

    $response = $this->actingAs($operator)->get('/pic/dashboard/pic');

    $response->assertOk()
        ->assertSee('Kantor Beta')
        ->assertDontSee('Kantor Alpha');
});

test('pic hanya melihat kantor yang diset di pivot', function () {
    siapkanDuaKantor();

    $pic = User::factory()->create(['unor' => 'Kantor Alpha']);
    $pic->assignRole('pic');
    $pic->syncKantorUnor(['Kantor Alpha']);

    $response = $this->actingAs($pic)->get('/pic/dashboard/pic');

    $response->assertOk()
        ->assertSee('Kantor Alpha')
        ->assertDontSee('Kantor Beta');
});

test('operator ditolak akses kantor lain di lihat-satu-kantor-saja', function () {
    siapkanDuaKantor();

    $operator = User::factory()->create(['unor' => 'Kantor Alpha']);
    $operator->assignRole('operator');

    $this->actingAs($operator)->post('/pic/lihat-satu-kantor-saja', [
        'filterNamaKantor' => 'Kantor Beta',
        'month' => date('Y').'-08',
    ])->assertForbidden();
});

test('operator bisa akses kantor sendiri di lihat-satu-kantor-saja', function () {
    siapkanDuaKantor();

    $operator = User::factory()->create(['unor' => 'Kantor Alpha']);
    $operator->assignRole('operator');

    $this->actingAs($operator)->post('/pic/lihat-satu-kantor-saja', [
        'filterNamaKantor' => 'Kantor Alpha',
        'month' => date('Y').'-08',
    ])->assertOk();
});

test('edit user mengubah role dan sinkron kantor', function () {
    seedRoles();

    $admin = createUserWithRole('admin');

    // buat user pic lewat store
    AsnDariApi::create([
        'nip' => '200000000000000001',
        'nama' => 'ASN Edit',
        'pangkat' => 'Pembina',
        'golongan' => 'IV/a',
        'status' => 'PNS',
        'jabatan' => 'Pelaksana',
        'unor_siasn' => 'Unor Siasn',
        'unor_siasn_induk' => 'Kantor Alpha',
        'unor_simpegnas_id' => 'kantor-alpha-id',
        'unor_simpegnas' => 'Kantor Alpha',
        'foto_simpegnas' => null,
    ]);

    $this->actingAs($admin)->post('/admin/add-user', [
        'nip' => '200000000000000001',
        'akses' => 'pic',
        'unor' => 'Kantor Alpha',
        'password' => 'password123',
        'kantors' => ['Kantor Alpha'],
    ])->assertRedirect('/admin/list-user');

    $user = User::where('nip', '200000000000000001')->first();
    expect($user->hasRole('pic'))->toBeTrue();
    expect($user->kantorUnorNames()->all())->toBe(['Kantor Alpha']);

    // ubah jadi operator + ganti kantor
    $this->actingAs($admin)->put('/admin/update-user/'.$user->id, [
        'akses' => 'operator',
        'unor' => 'Kantor Beta',
        'kantors' => ['Kantor Beta'],
    ])->assertRedirect('/admin/list-user');

    expect($user->fresh()->hasRole('operator'))->toBeTrue()
        ->and($user->fresh()->hasRole('pic'))->toBeFalse();
    expect($user->kantorUnorNames()->all())->toBe(['Kantor Beta']);
});

test('admin tidak bisa self-demotion', function () {
    $admin = createUserWithRole('admin');

    $this->actingAs($admin)->put('/admin/update-user/'.$admin->id, [
        'akses' => 'operator',
        'unor' => 'Kantor Alpha',
    ])->assertSessionHas('error');

    expect($admin->fresh()->hasRole('admin'))->toBeTrue();
});

test('admin quick-set user lain menjadi pic dengan kantor', function () {
    $admin = createUserWithRole('admin');
    $target = User::factory()->create(['unor' => 'Kantor Alpha']);
    $target->assignRole('operator');

    $this->actingAs($admin)->put('/admin/quick-set-role/'.$target->id, [
        'akses' => 'pic',
        'kantors' => ['Kantor Alpha', 'Kantor Beta'],
    ])->assertSessionHas('success');

    expect($target->fresh()->hasRole('pic'))->toBeTrue()
        ->and($target->fresh()->hasRole('operator'))->toBeFalse();
    expect($target->kantorUnorNames()->all())->toBe(['Kantor Alpha', 'Kantor Beta']);
});

test('admin quick-set ke admin mengosongkan kantor', function () {
    $admin = createUserWithRole('admin');
    $target = User::factory()->create(['unor' => 'Kantor Alpha']);
    $target->assignRole('operator');
    $target->syncKantorUnor(['Kantor Alpha']);

    $this->actingAs($admin)->put('/admin/quick-set-role/'.$target->id, [
        'akses' => 'admin',
    ])->assertSessionHas('success');

    expect($target->fresh()->hasRole('admin'))->toBeTrue();
    expect($target->kantorUnorNames()->all())->toBe([]);
});

test('admin tidak bisa quick-set akunnya sendiri', function () {
    $admin = createUserWithRole('admin');

    $this->actingAs($admin)->put('/admin/quick-set-role/'.$admin->id, [
        'akses' => 'operator',
        'kantors' => ['Kantor Alpha'],
    ])->assertSessionHas('error');

    expect($admin->fresh()->hasRole('admin'))->toBeTrue();
});

test('list user bisa mencari dan filter role', function () {
    $admin = createUserWithRole('admin');
    $pic = User::factory()->create(['nip' => '999999999999999999', 'nama' => 'Budi Santoso']);
    $pic->assignRole('pic');
    $operator = User::factory()->create(['nip' => '888888888888888888', 'nama' => 'Siti Aminah']);
    $operator->assignRole('operator');

    $this->actingAs($admin)->get('/admin/list-user?q=Budi')
        ->assertOk()
        ->assertSee('Budi Santoso')
        ->assertDontSee('Siti Aminah');

    $this->actingAs($admin)->get('/admin/list-user?role=operator')
        ->assertOk()
        ->assertSee('Siti Aminah')
        ->assertDontSee('Budi Santoso');

    $this->actingAs($admin)->get('/admin/list-user?q=999999999999999999')
        ->assertOk()
        ->assertSee('Budi Santoso');
});
