<?php

use Illuminate\Database\Seeder;

class CitizenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Citizen::class,300)->create();
    }
}
