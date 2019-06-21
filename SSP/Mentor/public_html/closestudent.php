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
$localID = $_POST['studenttoclose'];
$setSessionQuery = "update sessions set sessions.isActive='NO' where local_id = ".$localID.";";
$setSesstionActive = @mysqli_query($dbc, $setSessionQuery);

header("Location: frame.html#top");

?>