<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;
use DB;


class Matches extends Model 
{
    

    protected $table = 'matches';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'matches_played', 'matches_won','matches_lost','prmatches_drawn','total_goals'
    ];




    
}
