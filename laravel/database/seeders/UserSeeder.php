<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            'name'=>'admin',
            'username'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('admin'),
            'nip'=>'0000'
        ]);
        DB::table('users')->insert([
            'name'=>'Safrizal, S.ST',
            'username'=>'safrizal',
            'email'=>'safriza@gmail.com',
            'password'=>Hash::make('admin'),
            'nip'=>'198705302010031001',
            'role'=>'user'
        ]);
        DB::table('users')->insert([
            'name'=>'Syarifah Shabrina',
            'username'=>'shabrina',
            'email'=>'syarifahshabrina8@gmail.com',
            'password'=>Hash::make('1234'),
            'nip'=>'11111',
            'role'=>'user'
        ]);
        DB::table('users')->insert([
            'name'=>'Salwa Khalisha',
            'username'=>'Salwa',
            'email'=>'salwakhalisha2023@gmail.com ',
            'password'=>Hash::make('1234'),
            'nip'=>'22222',
            'role'=>'user'
        ]);
        DB::table('users')->insert([
            'name'=>'Rani bila aulia',
            'username'=>'Rani',
            'email'=>'ranibilaaulia@gmail.com ',
            'password'=>Hash::make('1234'),
            'nip'=>'33333',
            'role'=>'user'
        ]);
    }
}
