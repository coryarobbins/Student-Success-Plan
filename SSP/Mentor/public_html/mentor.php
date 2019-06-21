<?php
session_start();
require_once('../mysqli_connect.php');

$usr = ($_POST['username']);
$pass = ($_POST['password']);
$_SESSION['user_id'] = $usr;
if(!isset($_SESSION['user_id']))
{
header('Window-target: _top');
$_SESSION['error'] = 'You must login to access this page!';
header("Location: index.php");
exit;
}
$loginQuery = "select * from mentor WHERE mentor.username='".$usr."'";
$loginResponse = @mysqli_query($dbc, $loginQuery);
$loginResults = mysqli_fetch_assoc($loginResponse);
$rowpass = $loginResults['password'];

if ($rowpass == 'google'){
	//Check password.  If valid, proceed, if not, redirect to login.
$username = $_POST['username'];
$password = $_POST['password'];
$ldapconfig['host'] = '127.0.0.1';//CHANGE THIS TO THE CORRECT LDAP SERVER
$ldapconfig['port'] = '1636';
$ldapconfig['basedn'] = 'dc=wftigers,dc=org';//CHANGE THIS TO THE CORRECT BASE DN
$ldapconfig['usersdn'] = 'ou=Users';//CHANGE THIS TO THE CORRECT USER OU/CN
$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
ldap_set_option($ds, LDAP_OPT_NETWORK_TIMEOUT, 10);
$dn="uid=".$username.",".$ldapconfig['usersdn'].",".$ldapconfig['basedn'];
if ($bind=ldap_bind($ds, $dn, $password)) {
	$authenticated = 'true';
}}
 elseif ($pass == 'google') {
	$authenticated = 'false';
} elseif ($pass == $rowpass) {
	$authenticated = 'true';
}


if ($authenticated == 'true') {

$editedOn = date('l jS \of F Y h:i A');

$counter = 0;
$mentor = $loginResults['name'];

echo '<html><head><link rel="stylesheet" type="text/css" href="css/style.css"><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script></head>';
echo '
<body>
<div id="main">
	<div id="header">
		<div id="headerlogo">
			<img src="/images/logo.png">
		</div>
		<div id="welcome">	
			<div id="mentorname">
				<span>Welcome, '.$mentor.'!</span>
			</div>
			<div id="date">
				<span>Today is: '.$editedOn.'</span>
			</div>
			<div id="instructions">
				<span>Select a student from the list to the right to get started.</span><br>
				<span>PLEASE REMEMBER TO SAVE OR CLOSE EACH STUDENT FILE THAT YOU OPEN!</span>
			</div>
		</div>
		<div id="logout">
			<a href="logout.php"><button type="button">Logout</button></a>
		</div>

	</div>


';

//Begin the form...  Every field AFTER "Class of" must be accounted for in the post message.
echo '<div id="mentorform"><form class="mentorfields" action="ssp.php" method="post" target="studentplan" id="studentselctor">

			<input type="hidden" name="lastupdated" value="'.$editedOn.'">
';

//Start Student Selector
$menteeListQuery = "select * from students where students.mentor= '".$mentor."';";
$menteeListResponse = @mysqli_query($dbc, $menteeListQuery);
//$menteeListResults = mysqli_fetch_assoc($menteeListResponse);
 		$opt = '<select name="StudentSelector" id="MentorList"><option selected="selected">Who could use your guidance next?</option>';
							  while ($menteeListResults = mysqli_fetch_assoc($menteeListResponse)){
								  if ($menteeListResults[username] == NULL) continue;
							  $opt .= "<option value='{$menteeListResults['local_id']}'>{$menteeListResults['first_name']} {$menteeListResults['last_name']}</option>\n";
							  }
		$opt .='</select>';
		echo $opt;
//End Student Selector


//Nothing after the next 3 lines.  This ends the primary script, and anything submitted must be contained within the <form></form> tags.
			echo '<input type="submit" value="View Plan">
 			</form>
 </div>';

 echo'<iframe name="studentplan" src="frame.html"></iframe>';

} else {
	echo $rowpass;
echo '<html><head><link rel="stylesheet" type="text/css" href="css/style.css"><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"><body><div id="badpassword"><div><i class="fas fa-exclamation-circle"></i><p>The username and password combination you entered did not match our records.  Please check the information and try again.</p></div></div>';
$_SESSION['error'] = "The username and password combination you entered did not match our records.  Please check the information and try again.";
header("Location: index.php");
//echo '<pre>'; print_r($listValues); echo '</pre>';
//echo '<pre>'; print_r($_POST); echo '</pre>';
//print_r(array_values($_POST));
//echo '<pre>'; print_r($pass); echo '</pre>';
//echo '<pre>'; print_r($rowpass); echo '</pre>';

}

echo '</div>


</body></html>';
?>