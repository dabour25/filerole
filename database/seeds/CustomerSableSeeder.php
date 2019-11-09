<?php

use Illuminate\Database\Seeder;

class CustomerSableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        factory(App\Customers::class, 10000)->create()->each(function ($user) {
            $user->customers()->save(factory(App\Customers::class)->make());
        });


    }
}
