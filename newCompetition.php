<?php include 'init.php'; 
    include 'actions.php';
    include 'settings.php';
    session_start();
    $userId = $_SESSION["user_id"];


    if (isset($_POST['create']) && isset($_POST['compName']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
        //we have all the info, now attempt to create a competition with this info
        $result = createGroup($_POST['compName'], $_POST['password'], $_POST['confirm_password'], $userId);
        //result options: competition name is in use, passwords don't match, you must leave a competition before you can create another
    }
    if (isset($_POST['join']) && isset($_POST['compName']) && isset($_POST['password'])) {
        //we have all the info, now attempt to join a group with this info
        $result = joinGroup($_POST['compName'], $_POST['password'], $userId);
        //result options: competition name or pw does not exist, competition is full, you must leave a competition before you can join another
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fitbyte.css">
    <title>fitbyte</title>
</head>
<body>
    <h1 > Join/Create a Competition </h1>
    <form action="competitions.php" method="post">
        <button type="submit" value="competitions" name="Competitions" style="float: right; display: flex">Competitions</button>
    </form>
    <div class="center1" >
        <p class="login" style="color: white;"> Join </p>
        <form action="newCompetition.php" method="post">
            <label for=""></label>
            <input type="text" placeholder="Competition Name" name="compName" class="s" required>
            <input type="password" placeholder="Password" name="password" class="s" required>
            <input type="submit" value="Join" class="sumbit"class="s" name="join">
        </form>
        <?php if (isset($result)) { ?>
            <h3 class=center><?php echo $result ?></h3>
        <?php } ?>
    </div>
    <div class="center1" >
        <p class="login" style="color: black"> Create </p>
        <form action="newCompetition.php" method="post">
            <label for=""></label>
            <input type="text" placeholder="Competition Name" name="compName" class="s" required>
            <input type="password" placeholder="Password" name="password" class="s" required>
            <input type="password" placeholder="Confirm Password" name="confirm_password" class="s" required><br />
            <input type="submit" value="Create" class="sumbit"class="s" name="create">
        </form>
    </div>
</body>
<?php
    include 'footer.php';
?>
</html>