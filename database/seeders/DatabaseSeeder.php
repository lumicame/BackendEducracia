<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Type;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $type=new Type();
        $type->name="Educación";
        $type->save();

        $department=new Department();
        $department->name="Armenia, Quindio";
        $department->save();

        $user=new User();
        $user->name="Administrador";
        $user->email="admin@educracia.com";
        $user->password="admin2021";
        $user->nit=0;
        $user->type="admin";
        $user->department_id=1;
        $user->save();
        // \App\Models\User::factory(10)->create();
    }
}

