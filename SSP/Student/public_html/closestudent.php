<?php
session_start();
if(!isset($_SESSION['user_id']))
{
header('Window-target: _top');
$_SESSION['error'] = 'You must login to access this page!';
header("Location: index.php");
exit;
}
require_once('../mysqli_connect.php');
$row = ($_POST['studenttoclose']);
$setSessionQuery = "update sessions set sessions.isActive='NO' where local_id = ".$row.";";
$setSesstionInactive = @mysqli_query($dbc, $setSessionQuery);
mysqli_close($dbc);
$_SESSION['error'] = 'No changes were made to your Student Success Plan!';
header("Location: index.php");
?>