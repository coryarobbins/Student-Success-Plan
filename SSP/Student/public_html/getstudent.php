<?php

require_once('../mysqli_connect.php');

$query = "select * from students, seventhcourses WHERE students.local_id='123456789' AND students.local_id = seventhcourses.local_id";

$response = @mysqli_query($dbc, $query);


if($response){

	echo '<table align="left"
	cellspacing="5" cellpadding="8">

	<tr><td align="left"><b>Username</b></td>
	<td align="left"><b>password</b></td>
	<td align="left"><b>First Name</b></td>
	<td align="left"><b>Last Name</b></td>
	<td align="left"><b>Mentor</b></td>
	<td align="left"><b>Class Of</b></td>
	<td align="left"><b>State ID</b></td>
	<td align="left"><b>Local ID</b></td>
	<td align="left"><b>Last Updated</b></td>
	<td align="left"><b>Seventh Math</b></td>
	<td align="left"><b>Science</b></td>
	<td align="left"><b>Social Studies</b></td>
	<td align="left"><b>Technology</b></td>
	<td align="left"><b>ElectiveOne</b></td>
	<td align="left"><b>Elective Two</b></td>
	<td align="left"><b>Activity</b></td>
	<td align="left"><b>Local ID</b></td></tr>';


	while ($row = mysqli_fetch_array($response)){

		echo '<tr><td align=left">' .
		$row['username'] . '</td><td align="left">' .
		$row['password'] . '</td><td align="left">' .
		$row['first_name'] . '</td><td align="left">' .
		$row['last_name'] . '</td><td align="left">' .
		$row['mentor'] . '</td><td align="left">' .
		$row['class_of'] . '</td><td align="left">' .
		$row['state_id'] . '</td><td align="left">' .
		$row['local_id'] . '</td><td align="left">' .
		$row['last_updated'] . '</td><td align="left">' .
		$row['seventh_math'] . '</td><td align="left">' .
		$row['seventh_science'] . '</td><td align="left">' .
		$row['seventh_socialstudies'] . '</td><td align="left">' .
		$row['seventh_technology'] . '</td><td align="left">' .
		$row['seventh_electiveOne'] . '</td><td align="left">' .
		$row['seventh_electiveTwo'] . '</td><td align="left">' .
		$row['seventh_activity'] . '</td><td align="left">' .
		$row['local_id'] . '</td><td align="left">';

		echo '</tr>';
	}

	echo '</table>';

} else {


	echo "Couldn't do it";
	echo mysqli_error($dbc);
}
mysqli_close($dbc);




?>