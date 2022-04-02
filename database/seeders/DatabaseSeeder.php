<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'user';
        $user->email = 'user@mail.com';
        $user->group = 'ИБ-41';
        $user->password = Hash::make('user');
        $user->save();

        $userRole = new Role();
        $userRole->type = 'user';
        $userRole->name = 'user';
        $userRole->save();

        $user->roles()->attach($userRole);

        $admin = new User();
        $admin->name = 'admin';
        $admin->email = 'admin@mail.com';
        $admin->group = 'Администратор';
        $admin->password = Hash::make('admin');
        $admin->save();

        $adminRole = new Role();
        $adminRole->type = 'admin';
        $adminRole->name = 'admin';
        $adminRole->save();

        $admin->roles()->attach($adminRole);

        $categories = ['Web', 'Reverse', 'Stegano', 'Forensic', 'Networking'];

        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->name = $categoryName;
            $category->save();
        }
    }
}
