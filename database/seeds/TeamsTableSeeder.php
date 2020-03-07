<?php

use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            [
                "team_name"=>"Chelsea"
            ],
            [
                "team_name"=>"Arsenal"
            ],
            [
                "team_name"=>"Manchester City"
            ],
            [
                "team_name"=>"LiverPool"
            ]
        ];
        
        foreach ($teams as $team){
            DB::table('teams')->insert([
                'team_name' => $team['team_name'],
                "matches_played"=>"0",
                "matches_lost"=>"0",
                "matches_won"=>"0",
                "matches_drawn"=>"0",
                "total_goals"=>"0",
            ]);
        }
    }
}
