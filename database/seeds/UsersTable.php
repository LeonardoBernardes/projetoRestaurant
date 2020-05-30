<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Leonardo',
            'email' => 'leonardo@rest.com.br',
            'password' => bcrypt('Leonardo123')
        ]);
    }
}
