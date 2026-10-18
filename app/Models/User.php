<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['nip', 'nama', 'role', 'unor', 'password'])]
// #[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Daftar unor_siasn_induk yang diset untuk user via pivot user_unor.
     */
    public function kantorUnorNames(): Collection
    {
        return DB::table('user_unor')
            ->where('user_id', $this->id)
            ->pluck('unor_siasn_induk');
    }

    /**
     * Simpan daftar kantor yang boleh diakses (ganti seluruh isi pivot).
     *
     * @param  array<int, string>  $names
     */
    public function syncKantorUnor(array $names): void
    {
        DB::table('user_unor')->where('user_id', $this->id)->delete();

        $rows = collect($names)
            ->filter()
            ->unique()
            ->map(fn (string $name) => [
                'user_id' => $this->id,
                'unor_siasn_induk' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ])
            ->all();

        if ($rows !== []) {
            DB::table('user_unor')->insert($rows);
        }
    }

    /**
     * Nama kantor (unor_siasn_induk) yang boleh diakses user.
     * Mengembalikan null untuk admin (semua kantor).
     * Untuk PIC/Operator: pakai pivot, fallback ke unor milik user jika pivot kosong.
     *
     * @return array<int, string>|null
     */
    public function kantorNames(): ?array
    {
        if ($this->hasRole('admin')) {
            return null;
        }

        $names = $this->kantorUnorNames()->values()->all();

        if ($names === []) {
            return $this->unor ? [$this->unor] : [];
        }

        return $names;
    }

    /**
     * Nama kantor berbasis unor_simpegnas (ListKantor.nama_kantor) yang boleh diakses.
     * Dipakai untuk halaman persentase yang bekerja pada unor_simpegnas.
     * Mengembalikan null untuk admin (semua kantor).
     *
     * @return array<int, string>|null
     */
    public function kantorSimpegnasNames(): ?array
    {
        $names = $this->kantorNames();

        if ($names === null) {
            return null;
        }

        return AsnDariApi::whereIn('unor_siasn_induk', $names)
            ->pluck('unor_simpegnas')
            ->unique()
            ->values()
            ->all();
    }
}
