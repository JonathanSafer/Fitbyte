<?php include 'init.php'; 
    include 'actions.php';
    include 'settings.php';
    session_start();
    $userId = $_SESSION["user_id"];
?>


<!DOCTYPE html>
<meta charset="utf-8">
<title>FitByte</title>
<head>
    <link rel="stylesheet" href="fitbyte.css">
</head>
<body>

    <h1 style="float: left;"> My Competitions </h1>
    <form action="dashboard.php" method="post">
        <button type="submit" value="logout" name="logout" style="float: right; display: flex">Logout</button>
    </form>
    <form action="dashboard.php" method="post">
        <button type="submit" value="dashboard" name="Dashboard" style="float: right; display: flex">Dashboard</button>
    </form>
    <form style="padding-top: 10%" action="newCompetition.php" method="post">
        <button type="submit" value="new" name="newCompetition" class="center">Join or start a new competition</button>
    </form>
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
            <canvas id="<?php echo $sample?>" width="400" height="200"></canvas>
            <script>
                dashChart("<?php echo $sample?>", <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK)?>, 400, 200)
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
<?php
 include 'footer.php';
?>
</html>