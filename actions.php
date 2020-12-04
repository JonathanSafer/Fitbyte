<?php

function total($exercise, $user_id){ //return total amount of an exercise done by a person
    $query = "SELECT quantity FROM exercises WHERE p_id = $user_id AND exercise = '$exercise'";
    $result = mysqli_query($GLOBALS['conn'], $query);
    if(!$result){
        return "0";
    }
    $sum = 0;
    while($entry = mysqli_fetch_assoc($result)) {
        $sum = $sum + $entry['quantity'];
    }
    return "$sum";
}

function newEntry($user_id, $exercise, $quantity){//new entry for an exercise done. Time is entered in seconds
    //first determine id associated with user name
    $intQuantity = intval($quantity);
    if (!is_int($intQuantity) || $intQuantity <= 0) {
        return "Quantity must be a positive whole number";
    }
    
    $entry = "INSERT INTO exercises (p_id, exercise, quantity) VALUES ('$user_id', '$exercise', '$intQuantity')";
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

function protectedCreateAccount($username, $email, $first_name, $last_name, $password, $confirm_password){
    if($password != $confirm_password){
        return "passwords don't match";
    }
    //email cannot be in use
    $emailQuery = "SELECT email FROM people WHERE email = '$email'";
    $result = mysqli_query($GLOBALS['conn'], $emailQuery);
    $row = mysqli_fetch_assoc($result);
    if($row){
        return "Email is already in use";
    }
    //username cannot be in use
    $usernameQuery = "SELECT username FROM people WHERE username = '$username'";
    $result = mysqli_query($GLOBALS['conn'], $usernameQuery);
    $row = mysqli_fetch_assoc($result);
    if($row){
        return "Username is already in use";
    }

    //create the account
    createAccount($username, $email, $first_name, $last_name, $password);
    return "Account creation successful!";
}

function createAccount($username, $email, $first_name, $last_name, $password){
    $entry = "INSERT INTO people (username, email, first_name, last_name, password) VALUES ('$username', '$email', '$first_name', '$last_name', sha1('$password'))";
    if (mysqli_query($GLOBALS['conn'], $entry)) {
        return "Successful log <br>";
    } else {
        $error = mysqli_error($GLOBALS['conn']);
        return "$error<br>";
    }
}

function login($username, $password){
    $query = "SELECT id FROM people WHERE username = '$username' AND password = sha1('$password')";
    $result = mysqli_query($GLOBALS['conn'], $query);
    $row = mysqli_fetch_assoc($result);    
    if($row){
        session_start();
        //successful login -> redirect to dashboard
        // user id = $row["id"]
        $_SESSION["user_id"] = $row["id"];
        header("Location: dashboard.php");
        exit();
    } else {
        return "username or password is incorrect";
    }
}

function logout(){
    //redirect to main page and end session
}

?>