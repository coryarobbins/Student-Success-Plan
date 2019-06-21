<?php
session_start();
echo '<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>';
if(!empty($_SESSION['message'])) {
    $message = $_SESSION['message'];
    echo '<div id="notice"><p>'.$message.'</p></div>';
   }
   if(!empty($_SESSION['error'])) {
    $error = $_SESSION['error'];
    echo '<div id="error"><p>'.$error.'</p></div>';
   }
echo '<div id="loginpage">
    <div id="content">
		<div id="logo">
<img src="/images/logo.png">
</div>
<div id="loginform">
<form class="login" action="ssp.php" method="post">
    <label for="username">Username:</label><input type="text" name="username" placeholder="Username" autofocus><br>
    <label for="password">Password:</label><input type="password" name="password" placeholder="Password"><br>
    <input type="submit" value="Login">
</form>
<p>Login to Success Net to view and/or edit your Student Success Plan.</p>
<a href="forgot.html">Forgot your username or password?</a>
</div>
</div>
</div>
</body>
</html>';
session_destroy();
?>