<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereEmail('sudipsingh04@gmail.com')->first();

        if(!$user){
            User::create([
                'name'      =>  'Sudip Singh',
                'email'     =>  'sudipsingh04@gmail.com',
                'role'      =>  'admin',
                'password'  =>  Hash::make('12345678'),
            ]);
        }
    }
}
