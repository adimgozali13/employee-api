<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('users')->pluck('id'); 

        foreach ($users as $user_id) {
            DB::table('leaves')->insert([
                'user_id' => $user_id,
                'start_date' => Carbon::now()->addDays(rand(1, 30)), 
                'end_date' => Carbon::now()->addDays(rand(31, 60)), 
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
