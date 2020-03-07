<?php

/**
 * @method : pr()
 * @author : adventivepk@gmail.com <Fahad Abbas>
 * @param  : Null  
 * @return : formatted array
 * @since : 07/03/2020
 * @example : none
*/
function pr($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";  
}


/**
 * @method : pre()
 * @author : adventivepk@gmail.com <Fahad Abbas>
 * @param  : Null  
 * @return : formatted array and exits the code
 * @since : 07/03/2020
 * @example : none
*/
function pre($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";  
    exit;
}


/**
 * @method : roundRobin()
 * @author : adventivepk@gmail.com <Fahad Abbas>
 * @param  : Null  
 * @return : formatted array and exits the code
 * @since : 07/03/2020
 * @example : none
*/
function roundRobin( array $teams ){

    if (count($teams)%2 != 0){
        array_push($teams,"bye");
    }
    $away = array_splice($teams,(count($teams)/2));
    $home = $teams;
    for ($i=0; $i < count($home)+count($away)-1; $i++)
    {
        for ($j=0; $j<count($home); $j++)
        {
            $round[$i][$j]["Home"]=$home[$j];
            $round[$i][$j]["Away"]=$away[$j];
        }
        if(count($home)+count($away)-1 > 2)
        {
            $s = array_splice( $home, 1, 1 );
            $slice = array_shift( $s  );
            array_unshift($away,$slice );
            array_push( $home, array_pop($away ) );
        }
    }
    return $round;
}


?>
