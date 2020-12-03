<?php include 'init.php'; 
    include 'actions.php';
    include 'settings.php';
    if (isset($_POST['log']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['exercise']) && isset($_POST['quantity'])) {
        $result = protectedEntry($_POST['username'], $_POST['password'], $_POST['exercise'], $_POST['quantity']);
    }
?>

<!DOCTYPE html>
<meta charset="utf-8">
<title>FitByte</title>
<head>
    <link rel="stylesheet" href="fitbyte.css">
</head>
<body>
    <h1 style="float: left;"> Welcome to FitByte </h1>
    <a href="login.php"><button style="float: right; display: flex">Login/Signup</button></a>

    <h2 class=center style="padding-top: 10%">Quick Add:</h2>


    <form class=center action="index.php"method="post">
        Username:<br>
        <input type="text" name="username"><br>
        Password:<br>
        <input type="password" name="password"><br>
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
</body>