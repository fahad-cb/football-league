@extends('layouts.app')

@section('content')
<section class="main_container">
  <h2 class="text-center backcolor_bg">League Results</h2>
  <div class="container">

    <div class="row">
      <div class="col-md-8">
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Team</th>
              <th scope="col">Played</th>
              <th scope="col">Won</th>
              <th scope="col">Lost</th>
              <th scope="col">Drawn</th>
              <th scope="col">GD</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($teams as $team)
            <tr>
              <th scope="row">{{ $team->team_name }}</th>
              <td id="played-{{$team->id}}">{{ $team->matches_played }}</td>
              <td id="won-{{$team->id}}">{{ $team->matches_won }}</td>
              <td id="lost-{{$team->id}}">{{ $team->matches_lost }}</td>
              <td id="drawn-{{$team->id}}">{{ $team->matches_drawn }}</td>
              <td id="goals-{{$team->id}}">{{ $team->total_goals }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="col-md-4">
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Team</th>
              <th scope="col">Win Probabilty</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Chelsea</th>
              <td>20%</td>
            </tr>
            <tr>
              <th scope="row">Chelsea</th>
              <td>20%</td>
            </tr>
            <tr>
              <th scope="row">Chelsea</th>
              <td>20%</td>
            </tr>
            <tr>
              <th scope="row">Chelsea</th>
              <td>20%</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>


    <div class="row">
      <div class="col-md-8">
        <h3>Match Results Week</h3>
        <h6> 1st week match results </h6>
        <div class="card" style="width: 30rem;">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Chelsea   3-2 LiverPol</li>
            <li class="list-group-item">Team      2-3 team</li>
          </ul>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col-md-4">
        <button class="btn btn-sm btn-default play-all">Play All</button>
        <button class="btn btn-sm btn-default pull-right next-week">Next Week</button>
        <button class="btn btn-sm btn-default reset-all">Reset All</button>
      </div>
    </div>
     
    
  </div>
</section>
@endsection


@section('script')

<script type="text/javascript">   
 
  $( document ).ready(function(){
    // code goes here
    var round = 0;
    
  
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $(document).on('click',".next-week",function(e){
     // e.preventDefault();
      if (round > 2){
        alert('All rounds are finished ! ');
      }else{
          round++;
          jQuery.ajax({
            url: "{{ url('/play_round/') }}",
            method: 'post',
            data: { round_number : round },
            success: function(results){
                if (results){
                  let teams = results.data.teams;
                  for( let i = 0 ; i <  results.data.teams.length ; i++){
                    $("#played-"+teams[i].id).html(teams[i].matches_played);
                    $("#won-"+teams[i].id).html(teams[i].matches_won);
                    $("#lost-"+teams[i].id).html(teams[i].matches_lost);
                    $("#drawn-"+teams[i].id).html(teams[i].matches_drawn);
                    $("#goals-"+teams[i].id).html(teams[i].matches_goals);
                  }
                }else{
                  console.log('no results found');
                }
            }
          });
      
      }
     
    });


    $(document).on('click',".play-all",function(e){
     // e.preventDefault();
      jQuery.ajax({
        url: "{{ url('/play_all/') }}",
        method: 'post',
        data: { round_number : round },
        success: function(results){
            if (results){
              let teams = results.data.teams;
              for( let i = 0 ; i <  results.data.teams.length ; i++){
                $("#played-"+teams[i].id).html(teams[i].matches_played);
                $("#won-"+teams[i].id).html(teams[i].matches_won);
                $("#lost-"+teams[i].id).html(teams[i].matches_lost);
                $("#drawn-"+teams[i].id).html(teams[i].matches_drawn);
                $("#goals-"+teams[i].id).html(teams[i].matches_goals);
              }
            }else{
              console.log('no results found');
            }
        }
      });
    });


    $(document).on('click',".reset-all",function(e){
     
      jQuery.ajax({
        url: "{{ url('/reset_all/') }}",
        method: 'post',
        data: {  },
        success: function(results){
          if (results){
            let teams = results.data.teams;
            for( let i = 0 ; i <  results.data.teams.length ; i++){
              $("#played-"+teams[i].id).html(teams[i].matches_played);
              $("#won-"+teams[i].id).html(teams[i].matches_won);
              $("#lost-"+teams[i].id).html(teams[i].matches_lost);
              $("#drawn-"+teams[i].id).html(teams[i].matches_drawn);
              $("#goals-"+teams[i].id).html(teams[i].matches_goals);
            }
          }else{
            console.log('no results found');
          }
        }
      });
    
    });
   
  });

</script>
@endsection
  
