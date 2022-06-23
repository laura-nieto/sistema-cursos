<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $userSuperAdmin = User::create([
            'name'=> 'Super',
            'last_name'=> 'Admin',
            'email'=>'super_admin@info.com',
            'password'=> bcrypt('12345678'),
            'dni'=> '0',
            'gender'=>'male',
            'active'=>true,
            'remember_token' => Str::random(10),
        ]);

        // $userAdmin = User::create([
        //     'name'=> 'admin',
        //     'last_name'=> 'Admin',
        //     'email'=>'admin@info.com',
        //     'password'=> bcrypt('12345678'),
        //     'dni'=> '951234561',
        //     'gender'=>'male',
        //     'active'=>true,
        //     'remember_token' => Str::random(10),
        // ]);
        // $userAcademyAdmin = User::create([
        //     'academy_id'=>1,
        //     'name'=>'academyAdmin',
        //     'last_name'=>'academyAdmin',
        //     'email'=>'academyAdmin@info.com',
        //     'password'=>bcrypt('12345678'),
        //     'dni'=> '951234562',
        //     'gender'=>'male',
        //     'active'=>true,
        //     'remember_token' => Str::random(10),
        // ]);
        // $userAcademyAdmin2 = User::create([
        //     'academy_id'=>2,
        //     'name'=> 'academyAdmin',
        //     'last_name'=> 'academyAdmin',
        //     'email'=>'academyAdmin2@info.com',
        //     'password'=> bcrypt('12345678'),
        //     'dni'=> '95123459',
        //     'gender'=>'male',
        //     'active'=>true,
        //     'remember_token' => Str::random(10),
        // ]);
        // $userAcademy = User::create([
        //     'academy_id'=>3,
        //     'name'=> 'academy',
        //     'last_name'=> 'academy',
        //     'email'=>'academy@info.com',
        //     'password'=> bcrypt('12345678'),
        //     'dni'=> '951234563',
        //     'gender'=>'male',
        //     'active'=>true,
        //     'remember_token' => Str::random(10),
        // ]);
        // $userOperador = User::create([
        //     'name'=> 'operador',
        //     'last_name'=> 'operador',
        //     'email'=>'operador@info.com',
        //     'password'=> bcrypt('12345678'),
        //     'dni'=> '951234564',
        //     'gender'=>'male',
        //     'active'=>true,
        //     'remember_token' => Str::random(10),
        // ]);

        $superAdminRole = Role::create(['name'=>'super_admin']);
        $adminRole = Role::create(['name'=>'admin']);
        $userAcademyAdminRole = Role::create(['name'=>'Administrador de academia']);
        $userAcademyRole = Role::create(['name'=>'Operador de academia']);
        $operatorRole = Role::create(['name'=>'Operador']);
    
        Permission::create(['name' => 'users.index'])->syncRoles([$adminRole,$userAcademyAdminRole]);
        Permission::create(['name' => 'users.create'])->syncRoles([$adminRole,$userAcademyAdminRole]);
        Permission::create(['name' => 'users.edit'])->syncRoles([$adminRole,$userAcademyAdminRole]);
        Permission::create(['name' => 'users.destroy'])->syncRoles([$adminRole,$userAcademyAdminRole]);

        Permission::create(['name' => 'roles.index'])->syncRoles([$adminRole]);
        Permission::create(['name' => 'roles.create'])->syncRoles([$adminRole]);
        Permission::create(['name' => 'roles.edit'])->syncRoles([$adminRole]);
        Permission::create(['name' => 'roles.destroy'])->syncRoles([$adminRole]);

        Permission::create(['name' => 'academies.index'])->syncRoles([$adminRole]);
        Permission::create(['name' => 'academies.create'])->syncRoles([$adminRole]);
        Permission::create(['name' => 'academies.edit'])->syncRoles([$adminRole]);
        Permission::create(['name' => 'academies.destroy'])->syncRoles([$adminRole]);

        Permission::create(['name' => 'branch_offices.index'])->syncRoles([$adminRole]);
        Permission::create(['name' => 'branch_offices.create'])->syncRoles([$adminRole]);
        Permission::create(['name' => 'branch_offices.edit'])->syncRoles([$adminRole]);
        Permission::create(['name' => 'branch_offices.destroy'])->syncRoles([$adminRole]);

        Permission::create(['name' => 'courses.index'])->syncRoles([$userAcademyAdminRole,$userAcademyRole,$adminRole]);
        Permission::create(['name' => 'courses.create'])->syncRoles([$userAcademyAdminRole,$userAcademyRole,$adminRole]);
        Permission::create(['name' => 'courses.edit'])->syncRoles([$userAcademyAdminRole,$userAcademyRole,$adminRole]);
        Permission::create(['name' => 'courses.destroy'])->syncRoles([$userAcademyAdminRole,$userAcademyRole,$adminRole]);

        Permission::create(['name' => 'students.index'])->syncRoles([$adminRole,$userAcademyAdminRole,$userAcademyRole,$adminRole]);
        Permission::create(['name' => 'students.create'])->syncRoles([$userAcademyAdminRole,$userAcademyRole,$adminRole]);
        Permission::create(['name' => 'students.edit'])->syncRoles([$userAcademyAdminRole,$userAcademyRole,$adminRole]);
        Permission::create(['name' => 'students.destroy'])->syncRoles([$adminRole]);

        Permission::create(['name' => 'course_types.index'])->syncRoles([$adminRole]);
        Permission::create(['name' => 'course_types.create'])->syncRoles([$adminRole]);
        Permission::create(['name' => 'course_types.edit'])->syncRoles([$adminRole]);
        Permission::create(['name' => 'course_types.destroy'])->syncRoles([$adminRole]);
        
        Permission::create(['name' => 'certificates.index'])->syncRoles([$adminRole,$userAcademyAdminRole,$userAcademyRole,$operatorRole]);
        Permission::create(['name' => 'certificates.destroy']);
        
        Permission::create(['name' => 'presentes.index'])->syncRoles([$userAcademyAdminRole,$userAcademyRole,$adminRole]);
        Permission::create(['name' => 'presentes.create'])->syncRoles([$userAcademyAdminRole,$userAcademyRole,$adminRole]);
        Permission::create(['name' => 'presentes.edit'])->syncRoles([$adminRole]);

        $userSuperAdmin->assignRole($superAdminRole);
        // $userAdmin->assignRole($adminRole);
        // $userAcademyAdmin->assignRole($userAcademyAdminRole);
        // $userAcademyAdmin2->assignRole($userAcademyAdminRole);
        // $userAcademy->assignRole($userAcademyRole);
        // $userOperador->assignRole($operatorRole);
    }
}
