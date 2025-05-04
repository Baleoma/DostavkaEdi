<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Dish;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Role::factory()->createMany([
            ['name' => 'admin'],
            ['name' => 'user'],
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin11'),
            'phone' => +7228133778,
            'role_id' => 1,
        ]);

        Discount::factory()->create([
            'min_order_amount' => 2000,
            'discount_percentage' => 5,
        ]);

        Status::factory()->createMany([
            ['name' => 'pending'],
            ['name' => 'confirmed'],
            ['name' => 'in_progress'],
            ['name' => 'delivered'],
            ['name' => 'cancelled'],
        ]);

        User::factory(10)->create();
        Restaurant::factory(10)->create();
        Category::factory(10)->create();
        Dish::factory(10)->create();


    }
}
