<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;
use DB;


class Teams extends Model 
{
    

    protected $table = 'teams';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'matches_played', 'matches_won','matches_lost','matches_drawn','total_goals'
    ];




    
}
