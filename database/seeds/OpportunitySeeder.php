<?php

use Illuminate\Database\Seeder;

class OpportunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Opportunity::class, 300)->create()->each(function ($opportunity){
           $opportunity->detail()->save(factory(\App\Models\OpportunityDetail::class)->make());
        });
    }
}
