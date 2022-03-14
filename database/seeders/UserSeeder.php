<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=> 'admin',
            'last_name'=> Str::random(5),
            'dni'=> '00000',
            'email'=> 'admin@to.com',
            'password' => Hash::make('12345678'),
            'token_crypt' => Crypt::encrypt('12345678'),
            'salary'=> 0,
            'role'=> '1',
            'status' => 1,
            'phone'=> '00000',
            'date_birth' =>'2000-01-01',
        ]);
    }
}
