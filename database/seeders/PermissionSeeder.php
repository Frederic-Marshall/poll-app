<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем роли
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Создаем права и назначаем их для ролей
        $adminPanelPermission = Permission::firstOrCreate(['name' => 'admin_panel']);
        $adminRole->givePermissionTo($adminPanelPermission);

        // Ищем пользователей
        $users = User::all();
        $adminUser = $users->first();
        $regularUser = $users->where('id', 2)->first();

        // Назначаем роли пользователям
        $adminUser->assignRole($adminRole);
        $regularUser->assignRole($userRole);
    }
}
