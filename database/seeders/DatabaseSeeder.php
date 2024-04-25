<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roleAdminId   = Role::firstOrCreate(['code' => 'admin'  ])->id;
        $roleManagerId = Role::firstOrCreate(['code' => 'manager'])->id;
        $roleOwnerId   = Role::firstOrCreate(['code' => 'owner'  ])->id;
        $roleUserId    = Role::firstOrCreate(['code' => 'user'   ])->id;

        User::create([
            'first_name' => 'Чернов',
            'last_name' => 'Николай',
            'patronymic' => 'Михайлович',
            'phone' => 89994355644,
            'login' => 'chernov-nm',
            'password' => 'chernov!',
            'is_passed_moderation' => true,
            'is_banned' => false,
            'role_id' => $roleAdminId
        ]);

        User::create([
            'first_name' => 'Демьянова',
            'last_name' => 'Кристина',
            'patronymic' => 'Максимовна',
            'phone' => 89964335121,
            'login' => 'demienova-km',
            'password' => 'demienova!',
            'is_passed_moderation' => true,
            'is_banned' => false,
            'role_id' => $roleManagerId
        ]);

        User::create([
            'first_name' => 'Серебрякова',
            'last_name' => 'Мария',
            'patronymic' => 'Андреевна',
            'phone' => 87359675432,
            'login' => 'serebrakova-ma',
            'password' => 'serebrakova!',
            'is_passed_moderation' => true,
            'is_banned' => false,
            'role_id' => $roleOwnerId
        ]);

        User::create([
            'first_name' => 'Фролова',
            'last_name' => 'София',
            'patronymic' => 'Демидовна',
            'phone' => 89432143567,
            'login' => 'frolova-cd',
            'password' => 'frolova!',
            'is_passed_moderation' => true,
            'is_banned' => false,
            'role_id' => $roleUserId
        ]);
    }
}
