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

?>
