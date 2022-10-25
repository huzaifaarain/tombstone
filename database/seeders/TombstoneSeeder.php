<?php

namespace Database\Seeders;

use App\Models\Tombstone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TombstoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tombstone::factory(10)->create();
    }
}
