<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use App\Models\Teams;
use App\Models\Matches;
use App\Models\TeamMatches;
use App\Models\Rounds;
use DB;

class MatchesController extends Controller
{
     /**
     * Instantiate a new Matches Controller instance.
     *
     * @return void
     */
    private $teams;
    private $matches;
    private $team_matches;
    private $rounds;

    public function __construct(Teams $teams, Matches $matches, TeamMatches $team_matches,Rounds $rounds)
    {
        $this->rounds = $rounds;
        $this->teams = $teams;
        $this->matches = $matches;
        $this->team_matches = $team_matches;
    }

    /**
     * @method : index()
     * @author : adventivepk@gmail.com <Fahad Abbas>
     * @param  : Null  
     * @return : Index Blade View
     * @since : 07/03/2020
     * @example : none
    */
    public function index()
    {
        $teams = $this->teams->OrderBy('matches_won','DESC')->get();
        return view('index',compact('teams'));
    }


    /**
     * @method : playAllMatches()
     * @author : adventivepk@gmail.com <Fahad Abbas>
     * @param  : Request  
     * @return : Json response for TEams
     * @since : 07/03/2020
     * @example : none
    */
    public function playAllMatches(Request $request){

        extract($request->all());
        $numberofteams = $this->teams->count();
        $teams = $this->teams->get()->toArray();
        try {

            $round_matches = roundRobin($teams);
            // pre($round_matches);
            foreach ($round_matches as $key => $round){
                $round_number = $key+1;
                $roundData = [
                    "round" => $round_number,
                    "created_at" =>  \Carbon\Carbon::now(), 
                    "updated_at" => \Carbon\Carbon::now(), 
                ];
                $this->rounds->insert($roundData);
                $roundId = DB::getPdo()->lastInsertId();;
               
    
                // checking for if round has been created
                if ( $roundId ){
                    foreach ($round as $key => $match){
                        $match_number = $key+1;
                        $matchData = [
                            "round_id" => $roundId,
                            "match_number" => $match_number,
                            "created_at" =>  \Carbon\Carbon::now(), 
                            "updated_at" => \Carbon\Carbon::now(), 
                        ];
                        $this->matches->insert($matchData);
                        $matchId = DB::getPdo()->lastInsertId();
    
                        //checking for if match has been created
                        if ( $matchId ){
                            // pre loading and calculations for gaols and results for home/away team
                            $teamhome = $match['Home']['goals'] = rand(0, 10);
                            $teamaway = $match['Away']['goals'] = rand(0, 10);
                            if ($teamhome > $teamaway){
                                $match['Home']['result'] = 'won';
                                $match['Away']['result'] = 'lost';
                            }elseif ($teamhome < $teamaway){
                                $match['Home']['result'] = 'lost';
                                $match['Away']['result'] = 'won';
                            }elseif ($teamhome == $teamaway){
                                $match['Home']['result'] = $match['Away']['result'] = 'drawn';
                            }
    
                            foreach ($match as $key => $team_matches){
                                //setting up data for each match
                                $teamMatchData = [
                                    "match_id" => $matchId,
                                    "round_id" => $roundId,
                                    "venue" => strtolower($key),
                                    "team_id" =>  $team_matches['id'],
                                    "goals" => $team_matches['goals'],
                                    "result" => $team_matches['result'],
                                    "created_at" =>  \Carbon\Carbon::now(), 
                                    "updated_at" => \Carbon\Carbon::now(), 
                                ];
                                //dumping match data
                                $this->team_matches->insert($teamMatchData);
                            }
                            
                            $this->updateTeams($match);
                        }
                    }
                }
            }

            $data['data'] = ['teams'=> $this->teams->get()->toArray()];
            $data['code'] = 200;
            $data['msg'] = 'success';
            $data['response'] = 'ok';
            return response()->json($data, $data['code']);

        }catch(Exception $e){

            $data['data'] = null;
            $data['code'] = 404;
            $data['msg'] = $e->getMessage();
            $data['response'] = 'error';
            return response()->json($data, $data['code']);

        }
       
    }


    /**
     * @method : playRoundMatches()
     * @author : adventivepk@gmail.com <Fahad Abbas>
     * @param  : Request   (round number)
     * @return : Json response for TEams
     * @since : 07/03/2020
     * @example : none
    */
    public function playRoundMatches(Request $request){

        extract($request->all());
        $numberofteams = $this->teams->count();
        $teams = $this->teams->get()->toArray();

        $validator = \Validator::make($request->all(), [
			'round_number' => 'required|integer',
		],$this->messages);
	
		if ($validator->fails()) {
			$data['data'] = null;
			$data['code'] = 400;
			$data['msg'] = $validator->errors()->first();
			$data['response'] = 'ok';
			return response()->json($data, $data['code']); 
		}

        $round_matches = roundRobin($teams);
        $round = $round_matches[$round_number-1];
        

        try{


            $roundCompleted = $this->rounds->where('round',$round_number)->count();
            if ($roundCompleted){
               throw new Exception ("This round already has been compleyed",400);
            }
           
            $roundData = [
                "round" => $round_number,
                "created_at" =>  \Carbon\Carbon::now(), 
                "updated_at" => \Carbon\Carbon::now(), 
            ];
            $this->rounds->insert($roundData);
            $roundId = DB::getPdo()->lastInsertId();;
    
            // checking for if round has been created
            if ( $roundId ){
                foreach ($round as $key => $match){
                    $match_number = $key+1;
                    $matchData = [
                        "round_id" => $roundId,
                        "match_number" => $match_number,
                        "created_at" =>  \Carbon\Carbon::now(), 
                        "updated_at" => \Carbon\Carbon::now(), 
                    ];
                    $this->matches->insert($matchData);
                    $matchId = DB::getPdo()->lastInsertId();
    
                    //checking for if match has been created
                    if ( $matchId ){
                        // pre loading and calculations for gaols and results for home/away team
                        $teamhome = $match['Home']['goals'] = rand(0, 10);
                        $teamaway = $match['Away']['goals'] = rand(0, 10);
                        if ($teamhome > $teamaway){
                            $match['Home']['result'] = 'won';
                            $match['Away']['result'] = 'lost';
                        }elseif ($teamhome < $teamaway){
                            $match['Home']['result'] = 'lost';
                            $match['Away']['result'] = 'won';
                        }elseif ($teamhome == $teamaway){
                            $match['Home']['result'] = $match['Away']['result'] = 'drawn';
                        }
    
                        foreach ($match as $key => $team_matches){
                            //setting up data for each match
                            $teamMatchData = [
                                "match_id" => $matchId,
                                "round_id" => $roundId,
                                "venue" => strtolower($key),
                                "team_id" =>  $team_matches['id'],
                                "goals" => $team_matches['goals'],
                                "result" => $team_matches['result'],
                                "created_at" =>  \Carbon\Carbon::now(), 
                                "updated_at" => \Carbon\Carbon::now(), 
                            ];
                            //dumping match data
                            $this->team_matches->insert($teamMatchData);
                        }
                        
                        $this->updateTeams($match);
                    }
                }
            }

            $data['data'] = ['teams'=> $this->teams->get()->toArray()];
            $data['code'] = 200;
            $data['msg'] = 'success';
            $data['response'] = 'ok';
            return response()->json($data, $data['code']);
        }catch(Exception $e){

            $data['data'] = null;
            $data['code'] = 400;
            $data['msg'] = $e->getMessage();
            $data['response'] = 'error';
            return response()->json($data, $data['code']);
        }
       
        
    }

    /**
     * @method : updateTeams()
     * @author : adventivepk@gmail.com <Fahad Abbas>
     * @param  : Teams   (array)
     * @return : Json response for TEams
     * @since : 07/03/2020
     * @example : none
    */
    private function updateTeams(array $teams){
        // updating records for all teams
        foreach ($teams as $key => $team) {
            $teamdata['matches_played'] = $this->team_matches->where('team_id',$team['id'])->count();
            $teamdata['matches_won'] = $this->team_matches->where('team_id',$team['id'])->where('result','won')->count();
            $teamdata['matches_lost'] = $this->team_matches->where('team_id',$team['id'])->where('result','lost')->count();
            $teamdata['matches_drawn'] = $this->team_matches->where('team_id',$team['id'])->where('result','drawn')->count();
            $teamdata['total_goals'] =  $this->team_matches->select(DB::raw('SUM(goals) as total_goals'))->where('team_id',$team['id'])->first()->total_goals;
            $this->teams->where('id',$team['id'])->update($teamdata);
        }
        
    }

    /**
     * @method : ResetAll()
     * @author : adventivepk@gmail.com <Fahad Abbas>
     * @param  : Teams   (array)
     * @return : Json response for TEams
     * @since : 07/03/2020
     * @example :this method flushes all the data for matches and rounds
    */
    public function ResetAll(){
        // updating records for all teams
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        TeamMatches::query()->truncate();
        Matches::query()->truncate();
        Rounds::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
       
        $teams  = $this->teams->get()->toArray();
        foreach ($teams as $team) {
            $teamdata['matches_played'] = '0';
            $teamdata['matches_won'] = '0';
            $teamdata['matches_lost'] = '0';
            $teamdata['matches_drawn'] = '0';
            $teamdata['total_goals'] =  '0';
            $this->teams->where('id',$team['id'])->update($teamdata);
        }

        $data['data'] = ['teams'=> $this->teams->get()->toArray()];
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['response'] = 'ok';
        return response()->json($data, $data['code']);


    }

     /**
     * @method : RoundMatches matches()
     * @author : adventivepk@gmail.com <Fahad Abbas>
     * @param  : Teams   (array)
     * @return : Json response for TEams
     * @since : 07/03/2020
     * @example :this method flushes all the data for matches and rounds
    */
    public function RoundMatches(Request $request){

        extract($request->all());
        // updating records for all teams

        $validator = \Validator::make($request->all(), [
			'round_number' => 'required|integer',
		],$this->messages);
	
		if ($validator->fails()) {
			$data['data'] = null;
			$data['code'] = 400;
			$data['msg'] = $validator->errors()->first();
			$data['response'] = 'ok';
			return response()->json($data, $data['code']); 
		}
        try{
            
            $round = $this->rounds->select('id')->where('round',$round_number)->first();
            if (!$round){
                throw new Exception("No round found",404);
            }
            $matches = $this->team_matches->where('round_id',$round->id)->get()->toArray();
            $results = DB::table('team_matches')
                        ->join('teams', 'teams.id', '=', 'team_matches.team_id')
                        ->where('team_matches.round_id',$round->id)
                        ->select('teams.team_name', 'team_matches.goals' ,'team_matches.match_id')
                        ->orderBy('team_matches.match_id','DESC')
                        ->get()->toArray();

            //processing a bit of code
            //$newResults = array();
           
            $data['data'] = ['matches'=> $results];
            $data['code'] = 200;
            $data['msg'] = 'success';
            $data['response'] = 'ok';
            return response()->json($data, $data['code']);
        }catch(Exception $e){

            $data['data'] = null;
            $data['code'] = 400;
            $data['msg'] = $e->getMessage();
            $data['response'] = 'error';
            return response()->json($data, $data['code']);
        }
       
       


    }


}
