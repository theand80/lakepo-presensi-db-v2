<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Daftar role aplikasi dan migrasi kolom legacy users.role ke Spatie.
     */
    public function run(): void
    {
        $roles = ['admin', 'pic', 'operator'];

        foreach ($roles as $role) {
            Role::findOrCreate($role, 'web');
        }

        User::query()->whereNotNull('role')->get()
            ->filter(fn (User $user) => in_array($user->role, $roles, true))
            ->each(function (User $user) use ($roles) {
                if (! $user->hasAnyRole($roles)) {
                    $user->assignRole($user->role);
                }
            });
    }
}
