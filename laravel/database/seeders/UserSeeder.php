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
        // DB::table('users')->insert([
        //     'name'=>'admin',
        //     'username'=>'admin',
        //     'email'=>'smkn1karangbaru@gmail.com',
        //     'password'=>Hash::make('admin'),
        //     'nip'=>'0000'
        // ]);
        
        DB::table('users')->insert([
            'name'=>'Kepala Sekolah',
            'username'=>'adminks',
            'email'=>'smkn1kb@gmail.com',
            'password'=>Hash::make('ks10107158'),
            'nip'=>'-',
            'role'=>'admin'
        ]);
        
    }
}
