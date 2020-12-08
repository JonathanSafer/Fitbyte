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
    
    $entry = "INSERT INTO exercises (p_id, exercise, quantity, time) VALUES ('$user_id', '$exercise', '$intQuantity', now())";
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
    $result = createAccount($username, $email, $first_name, $last_name, $password);
    return $result;
    //return "Account creation successful!";
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
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

?>

<script>
    function dashChart(chartId, dataPoints, width, height){
        const buffer = 20
        const virtualBuffer = buffer + 5
        console.log(dataPoints)

        const canvas = document.getElementById(chartId);
        const ctx = canvas.getContext("2d");
        drawBorders(ctx, width, height, buffer)
        drawTitles(ctx, width, height, buffer, chartId)

        ctx.moveTo(virtualBuffer, height - virtualBuffer);
        const minX = Date.parse(dataPoints[0].label)
        const maxX = Date.parse(dataPoints[dataPoints.length-1].label)
        const xRange = maxX - minX
        const minY = 0
        let maxY = 0
        for(const point of dataPoints){
            maxY += point.y
        }
        let currentY = 0
        let firstPoint = true
        for(const point of dataPoints){
            currentY += point.y
            const x = (Date.parse(point.label) - minX)/xRange * (width - (virtualBuffer*2)) + virtualBuffer
            const y = (height - virtualBuffer) - ((height - (virtualBuffer*2)) * currentY/maxY)
            console.log(x,y)
            if(firstPoint){
                firstPoint = false
                ctx.moveTo(x, y)
                continue;
            }
            ctx.lineTo(x, y)
        }
        ctx.strokeStyle = "#FF0000";
        ctx.stroke();
    }

    function drawBorders(ctx, width, height, buffer){
        ctx.moveTo(0, 0)
        ctx.strokeRect(0, 0, width, height)
        ctx.strokeRect(buffer, buffer, width - (buffer * 2), height - (buffer * 2))
    }

    function drawTitles(ctx, width, height, buffer, title){
        ctx.font = "15px Arial"
        ctx.fillText(title, width/2 - title.length*3, 3*buffer/4)
    }
</script>