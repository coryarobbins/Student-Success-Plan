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
$localID = ($_POST['studenttolock']);
//Set session inactive.
$setSessionQuery = "update sessions set sessions.isActive='NO' where local_id = ".$localID.";";
$setSesstionInActive = @mysqli_query($dbc, $setSessionQuery);
//Set session unlocked.
$setLockedQuery = "update sessions set sessions.isLocked='NO' where local_id = ".$localID.";";
$setUnLocked = @mysqli_query($dbc, $setLockedQuery);

header("Location: frame.html#top");

?>