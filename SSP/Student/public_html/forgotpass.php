<?php
require dirname(__FILE__).'/google/vendor/autoload.php';
$secret_file_path = dirname(__FILE__).'/secret_file.json';
putenv('GOOGLE_APPLICATION_CREDENTIALS='.$secret_file_path);
$client = new Google_Client();
$client->addScope(array(Google_Service_Sheets::SPREADSHEETS_READONLY, Google_Service_Sheets::SPREADSHEETS));
$client->useApplicationDefaultCredentials();
$service = new Google_Service_Sheets($client);
$gsheetid = '1Dd7RpQP5mNYFCazKh9whWeX7wIGoh11f_Hi8HA9EjmM';
$range = 'StudentData!A1:ZZ1000';
$courselist = 'CourseLists!A1:ZZ1000';
$gradreq = 'GraduationRequirements!A1:G50';
$params = [
	'dateTimeRenderOption' => 'FORMATTED_STRING',
	'majorDimension' => 'ROWS'
];
$courseparams = [
	'dateTimeRenderOption' => 'FORMATTED_STRING',
	'majorDimension' => 'COLUMNS'
];

$valueRange = $service->spreadsheets_values->get($gsheetid, $range, $params);
$listValues = $valueRange['values'];
//echo '<pre>'; print_r($listValues[0]); echo '</pre>';

$access_token = $client->fetchAccessTokenWithAssertion()["access_token"];
//print 'Access token = '.$access_token.'<br><br>';

$email = ($_POST['email']);
//echo '<pre>'; print_r($_POST); echo '</pre>';
$split = explode("@", $email);
$usr = $split[0];
//echo '<pre>'; print_r($usr); echo '</pre>';

$row = array_search($usr, array_column($listValues, '0'));
//print_r($row);
//echo $listValues[$row][0];
$url = '<a href="https://ssp.wftigers.org">';
// the message
$msg = "Hello, ".$listValues[$row][2]." ".$listValues[$row][3].",\nYour Student Success Net credentials are below.\n\nUsername: ".$listValues[$row][0]."\nPassword: ".$listValues[$row][1]."\n\n";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);
$full_name = 'Technology Department';
$email_from = "tech@wftigers.org";
$from_mail = $full_name.'<'.$email_from.'>';
$from = $from_mail;
$headers .= 'From: ' . $from . "\r\n";

// send email
mail($email,"Your Student Success Net Credentials",$msg,$headers);

echo '<html><head><link rel="stylesheet" type="text/css" href="css/style.css"></head>';
echo '
<body>
<div id="main">
	<div id="header">
		<div id="headerlogo">
			<img src="/images/logo.png">
		</div>
		<div id="identifiers">	
			<div id="studentname">
				<span>Welcome, '.$listValues[$row][2].' '.$listValues[$row][3].'!</span>
			</div>
			<div id="mentor">
				<span>Your mentor teacher is '.$listValues[$row][4].'.</span>
			</div>
			<div id="classof">
				<span>Class of: '.$listValues[$row][5].'</span>
			</div>
		</div>

	</div>


';
echo '<div id="fouryearplan">
	<p style="text-align:center;">Thanks, '.$listValues[$row][2].' '.$listValues[$row][3].'.  Your username and password were emailed to '.$email.'.</p>
	<p style="text-align:center;"><a href="login.html">Return to the login page.</a></p>
	';
echo '</div>';
echo '</div></body></html>';
?>