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
$directionsandtext = 'DirectionsAndOtherPlainText!A1:ZZ1000';
$mentorlist = 'MentorAccounts!A1:C1000';
$params = [
	'dateTimeRenderOption' => 'FORMATTED_STRING',
	'majorDimension' => 'ROWS'
];
$courseparams = [
	'dateTimeRenderOption' => 'FORMATTED_STRING',
	'majorDimension' => 'COLUMNS'
];
$courseparamsheaders = [
	'dateTimeRenderOption' => 'FORMATTED_STRING',
	'majorDimension' => 'ROWS'
];

$valueRange = $service->spreadsheets_values->get($gsheetid, $range, $params);
$listValues = $valueRange['values'];
//echo '<pre>'; print_r($listValues[0]); echo '</pre>';

$mentorRange = $service->spreadsheets_values->get($gsheetid, $mentorlist, $params);
$mentorValues = $mentorRange['values'];



$access_token = $client->fetchAccessTokenWithAssertion()["access_token"];
//print 'Access token = '.$access_token.'<br><br>';

$usr = ($_POST['username']);

$row = array_search($usr, array_column($mentorValues, '1'));
//print_r($row);
$pass = ($_POST['current']);
$newpass = ($_POST['newpass']);
$rowpass = $mentorValues[$row][2];
//print_r($row);
//if ($pass == $rowpass){

$range2 = 'MentorAccounts!C'.++$row.':D'.$row;
$data2 = array_values($_POST);
unset($data2[0]);
unset($data2[1]);
$data3 = ''.implode('~', $data2).'';
$data5 = explode("~", $data3);
$data6 = [$data5];
$options = [
	'valueInputOption' => 'USER_ENTERED'
];
$valueRange2 = new Google_Service_Sheets_ValueRange();
$valueRange2->setValues($data6);
$valueRange2->setMajorDimension('ROWS');
$result = $service->spreadsheets_values->update($gsheetid, $range2, $valueRange2, $options);




echo '<div id="fouryearplan">
	<p style="text-align:center;">Thanks!  Your password has been changed.</p>
	<a href="index.html"><p style="text-align:center;">You may now go back to the login page.</p></a>
	';
echo '</div>';
echo '</div></body></html>';
/*} else {
	echo '<div id="fouryearplan">
	<p style="text-align:center;">Sorry.  You entered the incorrect login information.  Please try again.</p>
	';
echo '</div>';
echo '</div></body></html>';
}*/
?>