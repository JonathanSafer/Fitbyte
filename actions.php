<?php

function total($exercise, $user_id){ //return total amount of an exercise done by a person
    $query = "SELECT $amount FROM exercises WHERE p_id = $user_id AND exercise = $exercise";
    $result = mysqli_query($GLOBALS['conn'], $query);
    $sum = 0;
    while($entry = mysqli_fetch_assoc($result)) {
        $sum = $sum + $entry[$amount];
    }
    return "$sum";
}

function newEntry($user_id, $exercise, $quantity){//new entry for an exercise done. Time is entered in seconds
    //first determine id associated with user name
    
    if (!is_int($quantity) && $quantity <0) {
        return 'You should enter a positive whole number';
    }
    
    if (empty($quantity) ) {
        return 'Please enter quantity of exercise';
    }
    
    $entry = "INSERT INTO exercises (p_id, exercise, quantity) VALUES ('$user_id', '$exercise', '$quantity')";
    if (mysqli_query($GLOBALS['conn'], $entry)) {
        return "Successful log <br>";
    } else {
        $error = mysqli_error($GLOBALS['conn']);
        return "$error<br>";
    }
}

function protectedEntry($username, $password, $exercise, $quantity){
    $query = "SELECT id FROM people WHERE username = '$username' AND password = sha1('$password')";
    $result = mysqli_query($GLOBALS['conn'], $query);
    $row = mysqli_fetch_assoc($result);    
    if($row){
        return newEntry($row["id"], $exercise, $quantity);
    } else {
        return "username or password is incorrect";
    }
}

?>
