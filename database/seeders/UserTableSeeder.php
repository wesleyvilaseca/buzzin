<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenants = Tenant::first();

        $tenants->users()->create([
            'name' => 'Wesley',
            'email' => 'wesley@mail.com',
            'password' => bcrypt('12345678')
        ]);
    }
}
