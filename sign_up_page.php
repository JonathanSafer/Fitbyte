<?php include 'init.php'; 
    include 'actions.php';
    include 'settings.php';


    if (isset($_POST['create']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['confirm_password'])) {
        //we have all the info, now attempt to create an acct with this info
        $result = protectedCreateAccount($_POST['username'], $_POST['email'], $_POST['first_name'], $_POST['last_name'], $_POST['password'], $_POST['confirm_password']);
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
<h1 > Welcome to FitByte </h1>
<div class="center" >
<p class="login"> Sign up</p>
     <form action="sign_up_page.php" method="post">
     <label for=""></label>
         <input type="text" placeholder="First Name" name="first_name" class="s" required>
        <input type="text" placeholder="Last Name" name="last_name" class="s" required><br />
        <input type="text" name="username" placeholder="username" class="s" required>
        <input type="text" placeholder="Email" name="email" class="s" required> <br />
         <input type="password" placeholder="Password" name="password" class="s" required>
        <input type="password" placeholder="Confirm Password" name="confirm_password" class="s" required><br />
         <input type="submit" value="create" class="sumbit"class="s" name="create">
                        
      </form>
    <?php if (isset($result)) { ?>
        <h3 class=center><?php echo $result ?></h3>
    <?php } ?>

</div>
<a href="login.php"><button style="float: right; display: flex">Login</button></a>

</body>
</html>
