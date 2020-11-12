<?php include 'init.php'; 
    include 'actions.php';
    if (isset($_POST['total']) && isset($_POST['name']) && isset($_POST['exercise'])) {
        $result = total($_POST['exercise'], $_POST['name']);
    }
    if (isset($_POST['log']) && isset($_POST['name']) && isset($_POST['exercise']) && isset($_POST['quantity'])) {
        $result = newEntry($_POST['name'], $_POST['exercise'], $_POST['quantity']);
    }

?>

<!DOCTYPE html>
<meta charset="utf-8">
<title>FitByte</title>
<body>


    <?php if (isset($result)) { ?>
        <h1> Result: <?php echo $result ?></h1>
    <?php } ?>
    <form action="/index.php" method="post">
        Name:<br>
        <select name="name">
            <?php
            $query = "SELECT * FROM people";
            $result = mysqli_query($GLOBALS['conn'], $query) or die("Error at $query");
            while($person = mysqli_fetch_assoc($result)){
                $name = $person['name'];
            ?>
                <option name="name" value="<?php echo $name;?>"><?php echo $name ?></option>
                <?php
            }
            ?>
        </select><br>
        Exercise:<br>
        <input type="text" name="exercise"><br>
        <button type="submit" value="total" name="total">Submit</button>
    </form>

    <form action="/index.php" method="post">
        <button type="submit" value="input" name="input">Log Data</button>
    </form>


    <?php if (isset($_POST['input'])) { ?>
        <form action="/index.php" method="post">
            <h3>Log info:</h3>
            Name:<br>
            <input type="text" name="name"><br>
            Exercise:<br>
            <input type="text" name="exercise"><br>
            Quantity: (For a plank enter # of seconds)<br>
            <input type="text" name="quantity"><br>
            <input type="submit" value="Submit" name="log">
        </form>
    <?php } ?>
</body>