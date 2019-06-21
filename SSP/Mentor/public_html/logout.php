<?php
session_start();
if(!isset($_SESSION['user_id']))
{
header('Window-target: _top');
$_SESSION['error'] = 'You must login to access this page!';
header("Location: index.php");
exit;
}
session_destroy();

/*
require dirname(__FILE__).'/google/vendor/autoload.php';
$secret_file_path = dirname(__FILE__).'/secret_file.json';
putenv('GOOGLE_APPLICATION_CREDENTIALS='.$secret_file_path);
$client = new Google_Client();
$client->addScope(array(Google_Service_Sheets::SPREADSHEETS_READONLY, Google_Service_Sheets::SPREADSHEETS));
$client->useApplicationDefaultCredentials();
$service = new Google_Service_Sheets($client);
$gsheetid = '1Dd7RpQP5mNYFCazKh9whWeX7wIGoh11f_Hi8HA9EjmM';
$range = 'StudentData!A1:ZZ1000';
$params = [
	'dateTimeRenderOption' => 'FORMATTED_STRING',
	'majorDimension' => 'ROWS'
];
$valueRange = $service->spreadsheets_values->get($gsheetid, $range, $params);
$listValues = $valueRange['values'];
//var_export($listValues);

$access_token = $client->fetchAccessTokenWithAssertion()["access_token"];
//print 'Access token = '.$access_token.'<br><br>';
$ISACTIVE = array_search('SessionIsActive', $listValues[0]);
$SessionStart = array_search('SessionStartTime', $listValues[0]);


function num2alpha($n)
{
    for($r = ""; $n >= 0; $n = intval($n / 26) - 1)
        $r = chr($n%26 + 0x41) . $r;
    return $r;
}
//sample usage:
$activecolumn = num2alpha($ISACTIVE);
$sessionstartcolumn = num2alpha($SessionStart);
$row = ($_POST['row']);
$range2 = 'StudentData!'.$activecolumn.++$row.':'.$sessionstartcolumn.$row;
$sessiondata = array('NO','');
$uploaded = [$sessiondata];
$options = [
	'valueInputOption' => 'USER_ENTERED'
];
$valueRange2 = new Google_Service_Sheets_ValueRange();
$valueRange2->setValues($uploaded);
$valueRange2->setMajorDimension('ROWS');
$result = $service->spreadsheets_values->update($gsheetid, $range2, $valueRange2, $options);

echo '<pre>'; print_r($uploaded); echo '</pre>';
*/
header("Location: index.php");
?>