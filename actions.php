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
    $entry = "INSERT INTO exercises (p_id, exercise, quantity) VALUES ($p_id, $exercise, $quantity)";
    if (mysqli_query($GLOBALS['conn'], $entry)) {
        return "Successful log <br>";
    } else {
        return "Failed to log data <br>";
    }
}

function protectedEntry($username, $password, $exercise, $quantity){
    $query = "SELECT id FROM people WHERE username = '$username' AND password = sha1('$password')";
    $user_id = mysqli_query($GLOBALS['conn'], $query);
    if($user_id){
        $result = newEntry($user_id, $exercise, $quantity);
        return $result;
    } else {
        return "username or password is incorrect";
    }
}

?>