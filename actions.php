<?php

function total($exercise, $name){ //return total amount of an exercise done by a person
    $query = "SELECT $exercise FROM body_weight_exercises, people WHERE body_weight_exercises.p_id = people.id AND people.name = '$name'";
    $result = mysqli_query($GLOBALS['conn'], $query) or die("Error in $query at total function");
    $sum = 0;
    while($entry = mysqli_fetch_assoc($result)) {
        $sum = $sum + $entry[$exercise];
    }
    return "$name has done $sum $exercise" . "<br>";
}

function newEntry($user_id, $exercise, $quantity){//new entry for an exercise done. Time is entered in seconds
    //first determine id associated with user name
    
    // $exercise = strtoupper($exercise);
    
    // $exercise = array("push-ups", "pull-ups", "planks");

    // if(in_array("push-ups", $exercise)
    //    {
    //     echo "Exercise found";
    //    } else {
    //     echo "Exercise not found";  // not final.. 16-22
          
   
    // if (is_int($quantity) && $quantity >0) {
    // return TRUE;
    //   } else {
        
    // echo "Enter a positive number";   // Not sure yet if its working .. line24=28
    //  }
     
    $entry = "INSERT INTO exercises (p_id, exercise, quantity) VALUES ('$user_id', '$exercise', '$quantity')";
    if (mysqli_query($GLOBALS['conn'], $entry)) {
        return "Successful log <br>";
    } else {
        $error = mysqli_error($GLOBALS['conn']);
        return "$error <br>";
    }
}

function protectedEntry($username, $password, $exercise, $quantity){
    $query = "SELECT id FROM people WHERE username = '$username' AND password = sha1('$password')";
    $result = mysqli_query($GLOBALS['conn'], $query);
    if($result){
        return newEntry(mysqli_fetch_assoc($result)["id"], $exercise, $quantity);
    } else {
        return "username or password is incorrect";
    }
}

?>
