<?php include 'init.php'; 
    include 'actions.php';
    include 'settings.php';


    if (isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password'])) {
        //we have all the info, now attempt to create an acct with this info
        $result = login($_POST['username'], $_POST['password']);
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
<div class="center">

        <div class="login-div">
            <p>Login</p>
        <form action="#" method="POST" class="">
             <input type="text" name="username" placeholder="Username" class="s"> 
            <input type="password" name="password" placeholder="Password" class="s"> 
            <input type="submit" value="login" name="login" class="s" >
        </form>
        </div>
</div>
<?php if (isset($result)) { ?>
    <h3 class=center><?php echo $result ?></h3>
<?php } ?>
<div class="login-dhc">
    <p>Don't have an account</p>
    <a href="sign_up_page.php"><button  >Signup</button></a>
</div>
</body>
</html>