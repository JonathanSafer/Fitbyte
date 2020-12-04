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
        logout();
        echo "logging out";
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
        <input type="button" value="Logout" name="logout" style="float: right; display: flex">
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
    ?>

</body>
