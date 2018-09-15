<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Unit;
use App\Supplier;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        User::create([
            'name'           => 'Administrator',
            'email'       => 'admin@aporio.com',
            'password'       => bcrypt('123456'),
            'remember_token' => str_random(10),
        ]);

        Category::create([
            'name' => 'INJEKSI'
        ]);
        Category::create([
            'name' => 'KULIT'
        ]);
        Category::create([
            'name' => 'KUMUR'
        ]);
        Category::create([
            'name' => 'LUAR'
        ]);
        Category::create([
            'name' => 'MATA'
        ]);

        Unit::create([
            'name' => 'BOX'
        ]);
        Unit::create([
            'name' => 'BOTOL'
        ]);
        Unit::create([
            'name' => 'CAPSUL'
        ]);
        Unit::create([
            'name' => 'KG'
        ]);
        Unit::create([
            'name' => 'MG'
        ]);

        Supplier::create([
            'code' => '00000001',
            'name' => 'Lukman Abubakar',
            'address' => 'JL.Veteran Utara Lr.124 No.1',
            'mobile' => '081243431015',
            'cp' => 'Lukman Abubakar',
            'rekening' => '1090014091987',
            'npwp' => '111111111111111',
        ]);
    }
}
