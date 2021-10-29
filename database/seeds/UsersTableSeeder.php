<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
          DB::table('users')->insert([
            'fname' => 'John',
            'lname' => 'Smith',
            'email' => 'mittul@technobrave.com',
            'password' => Hash::make('Techno@123'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
    }
}
