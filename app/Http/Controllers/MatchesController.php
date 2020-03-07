<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Exception;
use App\Models\Teams;
use App\Models\Matches;
use App\Models\TeamMatches;

class MatchesController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    private $teams;
    private $matches;
    private $team_matches;

    public function __construct(Teams $teams, Matches $matches, TeamMatches $teammatches)
    {
        $this->teams = $teams;
        $this->matches = $matches;
        $this->teammatches = $teammatches;
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function index()
    {
        return view('index');
    
    }

    

}
