<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('jams')->truncate();
        $times = [];
        $start = strtotime('00:00');
        $end = strtotime('23:00');
        while ($start <= $end) {
            $times[] = [
                'jam' => date('H:i:s', $start),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $start += 3600; // 1 hour
        }
        \Illuminate\Support\Facades\DB::table('jams')->insert($times);
    }
}
