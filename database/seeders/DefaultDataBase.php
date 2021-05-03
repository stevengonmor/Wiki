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
            'Ver Roles',
            'Crear Roles',
            'Editar Roles',
            'Eliminar Roles',
            'Ver Historial',
            'Crear Usuarios',
            'Eliminar Usuarios',
            'Ver Usuarios',
            'Editar Usuarios',
            'Ver Publicaciones',
            'Crear Publicaciones',
            'Editar Publicaciones',
            'Eliminar Publicaciones',
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
        $sum = 8;
        for ($i; $i <= 6; $i++) {
            $permissionsEditAuth[$i] = $sum++;
        }
        $roleAdmin->syncPermissions($permissionsAdmin);
        $roleEdit->syncPermissions($permissionsEditAuth);
        $roleAuth->syncPermissions($permissionsEditAuth);
        //Create default users with default role
        $user_admin = User::create([
                    'name' => 'Carlos Montana',
                    'email' => 'admin@gmail.com',
                    'about_me' => 'Soy un administrador.',
                    'password' => bcrypt('123'),
                    'profile_picture' => 'user.jpg'
        ]);
        $user_admin->assignRole([$roleAdmin->id]);
        $user_auth = User::create([
                    'name' => 'Gerardo Rodriguez',
                    'email' => 'auth@gmail.com',
                    'about_me' => 'Soy un autenticado.',
                    'password' => bcrypt('123'),
                    'profile_picture' => 'user.jpg'
        ]);
        $user_auth->assignRole([$roleAuth->id]);
        $user_edit = User::create([
                    'name' => 'Karla Jiménez',
                    'email' => 'edit@gmail.com',
                    'about_me' => 'Soy una editora.',
                    'password' => bcrypt('123'),
                    'profile_picture' => 'user.jpg'
        ]);
        $user_edit->assignRole([$roleEdit->id]);
        //Insert Default Types for posts   
        \DB::table('types')->insert([
            [
                'name' => 'Informativa',
            ],
            [
                'name' => 'Pregunta',
            ]
        ]);
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
                'name' => 'Abierta',
            ],
            [
                'name' => 'Actualizada',
            ],
            [
                'name' => 'Cerrada',
            ]
        ]);
    }

}
