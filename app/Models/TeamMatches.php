<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;
use DB;


class TeamMatches extends Model 
{
    

    protected $table = 'team_matches';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $fillable = [
        'goals', 'result'
    ];




    
}
