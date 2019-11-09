<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Customers::class, 10000)->create()->each(function ($user) {
            $user->customers()->save(factory(App\Customers::class)->make());
        });
        
        //$this->call(booking_times_seeder::class);
    }
}
