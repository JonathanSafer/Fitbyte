<?php include 'init.php'; 
    include 'actions.php';
    include 'settings.php';
    session_start();
    //somehow we need to know the userID here (presumably stored in a session? @Robert)
    $userId = $_SESSION["user_id"];//to be replaced
    if (isset($_POST['log']) && isset($_POST['exercise']) && isset($_POST['quantity'])) {
        $result = newEntry($userId, $_POST['exercise'], $_POST['quantity']);
    }
    if(isset($_POST['logout'])){
        echo "logging out";
        logout();
    }
?>


<!DOCTYPE html>
<meta charset="utf-8">
<title>FitByte</title>
<head>
    <link rel="stylesheet" href="fitbyte.css">
</head>
<body>

    <h1 style="float: left;"> My Dashboard </h1>
    <form action="dashboard.php" method="post">
        <button type="submit" value="logout" name="logout" style="float: right; display: flex">Logout</button>
    </form>
    <h2 class=center style="padding-top: 10%">Quick Add:</h2>


    <form class=center action="dashboard.php" method="post">
        Exercise:<br>
        <select name="exercise">
            <?php
            foreach ($exercises as &$sample){
            ?>
                <option name="exercise" value="<?php echo $sample;?>"><?php echo $sample ?></option>
                <?php
            }
            ?>
        </select><br>
        Quantity: (For a plank enter # of seconds)<br>
        <input type="text" name="quantity"><br>
        <button type="submit" value="log" name="log">Log Data</button>
    </form>
    <?php if (isset($result)) { ?>
        <h3 class=center><?php echo $result ?></h3>
    <?php } ?>
    <h2 class=center style="padding-top: 2%">My Totals:</h2>
    <?php
        foreach ($exercises as &$sample){
        ?>
            <h3 class=center><?php echo $sample?>: <?php echo total($sample, $userId) ?></h3>
            <?php
        }
        unset($sample)
    ?>
    <h2 class=center style="padding-top: 2%">Exercises Over Time:</h2>
    <?php
        foreach ($exercises as &$sample){
            $query = "SELECT * FROM exercises WHERE p_id = $userId AND exercise = '$sample'";
            $result = mysqli_query($GLOBALS['conn'], $query);
            if(!$result){//no result no need for a graph
                continue;
            }
            $dataPoints = array();
            $dates = array();//will be needed to find earliest date
            while($entry = mysqli_fetch_assoc($result)) {//populate array of results for this person with this exercise type
                if($entry['time']){
                    $dataPoints[] = array("label" => $entry['time'], "y" => $entry['quantity']);
                    $dates[] = $entry['time'];
                }
            }
            if(count($dataPoints) == 0){//if array is empty don't bother with graph
                continue;
            }
            array_multisort(array_column($dataPoints, 'label'), SORT_ASC, $dataPoints);
            // foreach ($dataPoints[]){
            //     //loop up sum to make progress chart
            // }
            //find earliest entry (this will be the beginning of the graph
            $earliestDate = min($dates);
            $currentDate = date("Y-m-d H:i:s");


        ?>
            <!-- <h3 class=center><?php echo $sample?>: <?php echo $earliestDate; echo json_encode($dataPoints, JSON_NUMERIC_CHECK) ?>
             --></h3>
            <canvas id="<?php echo $sample?>" width="300" height="150"></canvas>
            <script>
                dashChart("<?php echo $sample?>", <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK)?>, 300, 150)
                // console.log(dataPoints)
                // var ctx = c.getContext("2d");
                // ctx.moveTo(0, 0);
                // ctx.lineTo(200, 100);
                // ctx.stroke();
            </script>
            <?php
        }
    ?>

</body>
