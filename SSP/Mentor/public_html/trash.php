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
$localID = ($_POST['row']);
//Set session inactive.
$setSessionQuery = "update sessions set sessions.isActive='NO' where local_id = ".$localID.";";
$setSesstionInActive = @mysqli_query($dbc, $setSessionQuery);
echo'<html><head><link rel="stylesheet" type="text/css" href="css/style.css"><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"><body><div id="badpassword"><div><i class="far fa-trash-alt"></i><p>Please wait while we trash the session...</p></div></div>';
echo'<form id="myForm" action="ssp.php" method="post">
<input type="hidden" name="row" value="'.$_POST['row'].'">
<input type="hidden" name="StudentSelector" value="'.$_POST['StudentSelector'].'">
</form>
<script type="text/javascript">
    document.getElementById("myForm").submit();
</script></body></html>';
?>