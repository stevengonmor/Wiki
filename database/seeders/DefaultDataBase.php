<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DefaultDataBase extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //Create permissions
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'post-list',
            'post-create',
            'post-edit',
            'post-delete',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        //Create Roles
        $roleAdmin = Role::create(['name' => 'Administrador']);
        $roleEdit = Role::create(['name' => 'Editor']);
        $roleAuth = Role::create(['name' => 'Autenticado']);
        //Assign permissions to roles
        $permissionsAdmin = Permission::pluck('id', 'id')->all();
        $permissionsEditAuth = [];
        $i = 1;
        $sum = 6;
        for ($i; $i <= 7; $i++) {
            $permissionsEditAuth[$i] = $sum++;
        }
        $roleAdmin->syncPermissions($permissionsAdmin);
        $roleEdit->syncPermissions($permissionsEditAuth);
        $roleAuth->syncPermissions($permissionsEditAuth);
        //Create Admin user with default role
        $user = User::create([
                    'name' => 'Administrador',
                    'email' => 'admin@gmail.com',
                    'about_me' => 'Soy el administrador',
                    'password' => bcrypt('123'),
                    'profile_picture' => 'user.jpg'
        ]);
        $user->assignRole([$roleAdmin->id]);
        //Insert Default Categories for posts   
        \DB::table('categories')->insert([
            [
                'name' => 'Desarrollo Web',
            ],
            [
                'name' => 'Desarrollo de Software',
            ],
            [
                'name' => 'Ciberseguridad',
            ]
        ]);
        //Insert Default Statuses for posts
        \DB::table('statuses')->insert([
            [
                'name' => 'Abierto',
            ],
            [
                'name' => 'Actualizado',
            ],
            [
                'name' => 'Cerrado',
            ]
        ]);
    }

}
