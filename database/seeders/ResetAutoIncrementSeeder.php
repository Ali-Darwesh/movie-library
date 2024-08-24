<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResetAutoIncrementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET @count = 0');
        DB::statement('UPDATE ' . (new \App\Models\Movie)->getTable() . ' SET id = @count:= @count + 1');
        DB::statement('ALTER TABLE ' . (new \App\Models\Movie)->getTable() . ' AUTO_INCREMENT = 1');
    }
}
