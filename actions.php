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

function newEntry($name, $exercise, $quantity){//new entry for an exercise done. Time is entered in seconds
    //first determine id associated with user name
    $query = "SELECT id FROM people WHERE name = '$name'";
    $result = mysqli_query($GLOBALS['conn'], $query) or die("$name is not a valid name");
    $p_id = mysqli_fetch_assoc($result)['id'];
    $entry = "INSERT INTO body_weight_exercises (p_id, $exercise) VALUES ($p_id, $quantity)";
    if (mysqli_query($GLOBALS['conn'], $entry)) {
        return "Successful log <br>";
    } else {
        return "Failed to log data <br>";
    }
}

?>