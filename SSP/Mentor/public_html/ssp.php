<?php
//ini_set('display_errors', 'On');
session_start();
if(!isset($_SESSION['user_id']))
{
header('Window-target: _top');
header("Location: index.html");
exit;
}
require_once('../mysqli_connect.php');


$usr = ($_POST['StudentSelector']);


    if ($usr == "Who could use your guidance next?") {
    	$pleaseSelect = 'Please select a student from the dropdown list above before clicking on the "View Plan" button.';
   		echo '
   			<html>
   			<head>
   				<link rel="stylesheet" type="text/css" href="css/style.css">
   				<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
   			</head>
   			<body>
   				<div id="loginpage">
   				<div id="warning">
   					<div id="warningform">
   						<h1><i class="fas fa-times"></i></h1>
   						<h1>Oops!</h1>
   						<p>'.$pleaseSelect.'</p>
   					</div>
   				</div>
   				</div>
   			</body>

   			</html>
   		';
   		exit;
   	}
$loginQuery = "select * from students WHERE students.local_id='".$usr."'";
$loginResponse = @mysqli_query($dbc, $loginQuery);
$loginResults = mysqli_fetch_assoc($loginResponse);
$localID = $loginResults['local_id'];
$rowpass = $loginResults['password'];
$stateID = $loginResults['state_id'];
$statusQuery = "select * from sessions where local_id = ".$localID.";";
$statusResponse = @mysqli_query($dbc, $statusQuery);
/*
$statusResults = mysqli_fetch_assoc($loginResponse);
$ISACTIVE = $statusResults['isActive'];
$SessionStart = $statusResults['startTime'];
$ISLOCKED =  $statusResults['isLocked'];
*/
$firstname = $loginResults['first_name'];
$lastname = $loginResults['last_name'];
$mentor = $loginResults['mentor'];
$classOf = $loginResults['class_of'];
$lastUpdated = $loginResults['last_updated'];
//Check password.  If valid, proceed, if not, redirect to login.
//if ($pass == $rowpass){
//Check if the session is marked as active.
while ($sessionCheck = mysqli_fetch_assoc($statusResponse)){

if ($sessionCheck[isActive] == 'YES') {
	$existingsession = $sessionCheck[startTime];
//If yes, check if previous session started less than 45 minutes ago, and, if so, alert the mentor, and ask for confirmation to trash existing session or cancel.
		$currenttime = date('Y-m-d H:i:s');
    if ($existingsession >= $currenttime-2700) {
    	$fourtyfiveminutes = $existingsession+2700;
    	$interval = $fourtyfiveminutes-$currenttime;
    	$minutesseconds = gmdate('i', $interval);
    	$currentlyactive = $firstname.' '.$lastname.' has an active SSP session.  They could be editing, or they may have forgotten to log out.  Do you wish to trash the existing session and delete any unsaved changes '.$firstname.' has made?';
   		echo '
   			<html>
   			<head>
   				<link rel="stylesheet" type="text/css" href="css/style.css">
   				<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
   			</head>
   			<body>
   				<div id="loginpage">
   				<div id="warning">
   					<div id="warningform">
   					<form class="warningform" action="trash.php" method="post">
   						<input type="hidden" name="row" value="'.$localID.'">
   						<input type="hidden" name="StudentSelector" value="'.$usr.'">
   						<h1><i class="fas fa-exclamation-triangle"></i></h1>
   						<h1>Warning!</h1>
   						<p>'.$currentlyactive.'</p>
   						<a href="frame.html"><button type="button">NO, THANKS!</button></a>
   						<input type="submit" value="Yes, Please">
   					</form>
   					</div>
   				</div>
   				</div>
   			</body>

   			</html>
   		';
   		exit;

//If yes, but previous session started longer than 45 minutes ago, go ahead and proceed as normal.
    } else {
    	goto accepted;
    }
//If state is marked as MENTOR, ignore.
} else if ($sessionCheck[isActive] == 'MENTOR'){
    	goto accepted;
    }
}
//This begins the main section.



accepted:
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
if (!empty($usr)){
//Set session active.
$setSessionQuery = "update sessions set sessions.isActive='MENTOR' where local_id = ".$localID.";";
$setSesstionActive = @mysqli_query($dbc, $setSessionQuery);

echo '<html><head><link rel="stylesheet" type="text/css" href="css/style.css"><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"></head>';
echo '
<body>
<div id="main">
	<div id="headerz">
		<div id="identifiers">	
			<div id="mentor">
				<span>Mentor: '.$mentor.'.</span>
			</div>
			<div id="classof">
				<span>Class of: '.$classOf.'</span>
			</div>
			<div id="lastupdated">
				<span>Last Updated On: '.$lastUpdated.'</span>
			</div>
		</div>
	</div>
';
echo '<div id="closessession"><form id="close" class="close" action="closestudent.php" method="post">
			<div id="closefloat">
			<input type="hidden" name="studenttoclose" value="'.$localID.'">
			<button type="submit" title="Close Student File"><i class="fas fa-times-circle" style="font-size:xx-large"></i></button>
			</div>
</form>
</div>';


// Show lock or unlock button
if ($sessionCheck[isLocked] == 'YES'){
	echo '<div id="lock"><form id="lock" class="lock" action="unlockstudent.php" method="post">
			<div id="lockfloat">
			<input type="hidden" name="studenttolock" value="'.$localID.'">
			<button type="submit" title="Unlock Student File"><i class="fas fa-unlock" style="font-size:xx-large"></i></button>
			</div>
</form>
</div>';

} else{
echo '<div id="lock"><form id="lock" class="lock" action="lockstudent.php" method="post">
			<div id="lockfloat">
			<input type="hidden" name="studenttolock" value="'.$localID.'">
			<button type="submit" title="Lock Student File"><i class="fas fa-lock" style="font-size:xx-large"></i></button>
			</div>
</form>
</div>';
}




//Begin the form...  Every field AFTER "Class of" must be accounted for in the post message.
$editedOn = date('l jS \of F Y h:i A');
echo '<div id="sspform"><form class="sspfields" action="edit.php" method="post">
			<div id="savefloat">
			<button type="submit" title="Save Student File"><i class="fas fa-save" style="font-size:xx-large"></i></button>
			</div>
			<input type="hidden" name="row" value="'.$localID.'">
			<input type="hidden" name="stateid" value="'.$stateID.'">
			<input type="hidden" name="lastupdated" value="'.$editedOn.'">
';

//Begin Title and Instructions
			echo '
			<div id="plan">';
			echo '<h1>'.$firstname.' '.$lastname.'\'s Student Success Plan</h1>
			<p style="text-align:center;color:red;"><strong>**NOTE**  This document does not save automatically.  You MUST click save, or all of your changes will be lost! **NOTE**</strong></p>
			<p>Directions: Use the guide below to plan your courses for all four years of high school. Use drop-down options where indicated, or type in the specific course. Make sure to complete ALL sections! The classes marked with an * have requirements. Refer to the documents listed in the "Essential Course Planning Documents" section listed below for specifics. Courses marked with an � do not count towards credit. Do not use the "Course Retakes" field for planning. These should only be used if you have failed a semester and need to make it up the next year. If this happens, you must also leave an elective blank on the year you do the retake. Also, if you transferred from another school or are otherwise taking a class not offered to your grade level, please type the name of the course followed by "(Transferred)" in the "Other" box for the relevant year.</p>
			</div>
			';
//Begin Grade Level Courses
			echo '<div id="coursewrapper"><div id="left-button" class=" dimLeft"><img src="/images/left.png" ></div><div id="GradeLevelCourses">';

$seventhcourseQuery = "SELECT seventhcourses.english, seventhcourses.math, seventhcourses.science, seventhcourses.socialStudies, seventhcourses.technology, seventhcourses.electiveOne, seventhcourses.electiveTwo, seventhcourses.activity FROM students, seventhcourses, creditcalcs WHERE students.local_id = seventhcourses.local_id AND students.local_id = creditcalcs.local_id and students.local_id = '".$localID."';";
$seventhcourseResponse = @mysqli_query($dbc, $seventhcourseQuery);
$seventhcourseResults = mysqli_fetch_assoc($seventhcourseResponse);
$seventhcourselistQuery = "SELECT * FROM seventhcourselist;";
$seventhcourselistResponse = @mysqli_query($dbc, $seventhcourselistQuery);
$seventhcourselistResults = mysqli_fetch_assoc($seventhcourselistResponse);
// Begin Seventh Grade Year Grade Level Copy
			echo '<div id="seventhcourses">';
						echo '<h1>7th Grade Courses</h1>';
//Begin Seventh English	
						$seventhcourselistResponse = @mysqli_query($dbc, $seventhcourselistQuery);						
						echo '<div><label for="7th English">English</label>';
						echo '<select name="seventhEnglish" id="seventhEnglish">';	
						$opt =	'<option selected="selected">'.$seventhcourseResults['english'].'</option>';
						while ($row = mysqli_fetch_assoc($seventhcourselistResponse)){
							if ($row[english] == NULL) continue;
							if ($row[english] == $seventhcourseResults['english']) continue;
						$opt .= "<option value='{$row['english']}'>{$row['english']}</option>\n";
						}
						$opt .='</select></div>';
						echo $opt;
//End Seventh English	
//Begin Seventh math	
$seventhcourselistResponse = @mysqli_query($dbc, $seventhcourselistQuery);						
echo '<div><label for="7th Math">Math</label>';
echo '<select name="seventhmath" id="seventhmath">';	
$opt =	'<option selected="selected">'.$seventhcourseResults['math'].'</option>';
while ($row = mysqli_fetch_assoc($seventhcourselistResponse)){
	if ($row[math] == NULL) continue;
	if ($row[math] == $seventhcourseResults['math']) continue;
$opt .= "<option value='{$row['math']}'>{$row['math']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End Seventh math	
//Begin Seventh science	
$seventhcourselistResponse = @mysqli_query($dbc, $seventhcourselistQuery);						
echo '<div><label for="7th Science">Science</label>';
echo '<select name="seventhscience" id="seventhscience">';	
$opt =	'<option selected="selected">'.$seventhcourseResults['science'].'</option>';
while ($row = mysqli_fetch_assoc($seventhcourselistResponse)){
	if ($row[science] == NULL) continue;
	if ($row[science] == $seventhcourseResults['science']) continue;
$opt .= "<option value='{$row['science']}'>{$row['science']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End Seventh science	
//Begin Seventh Social Studies	
$seventhcourselistResponse = @mysqli_query($dbc, $seventhcourselistQuery);						
echo '<div><label for="7th Social Studies">Social Studies</label>';
echo '<select name="seventhsocialStudies" id="seventhsocialStudies">';	
$opt =	'<option selected="selected">'.$seventhcourseResults['socialStudies'].'</option>';
while ($row = mysqli_fetch_assoc($seventhcourselistResponse)){
	if ($row[socialStudies] == NULL) continue;
	if ($row[socialStudies] == $seventhcourseResults['socialStudies']) continue;
$opt .= "<option value='{$row['socialStudies']}'>{$row['socialStudies']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End Seventh Social Studies		
//Begin Seventh technology	
$seventhcourselistResponse = @mysqli_query($dbc, $seventhcourselistQuery);						
echo '<div><label for="7th Technology">Technology</label>';
echo '<select name="seventhtechnology" id="seventhtechnology">';	
$opt =	'<option selected="selected">'.$seventhcourseResults['technology'].'</option>';
while ($row = mysqli_fetch_assoc($seventhcourselistResponse)){
	if ($row[technology] == NULL) continue;
	if ($row[technology] == $seventhcourseResults['technology']) continue;
$opt .= "<option value='{$row['technology']}'>{$row['technology']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End Seventh technology	
//Begin Seventh Elective One	
$seventhcourselistResponse = @mysqli_query($dbc, $seventhcourselistQuery);						
echo '<div><label for="7th Elective One">Elective One</label>';
echo '<select name="electiveOne" id="7electiveOne">';	
$opt =	'<option selected="selected">'.$seventhcourseResults['electiveOne'].'</option>';
while ($row = mysqli_fetch_assoc($seventhcourselistResponse)){
	if ($row[electiveOne] == NULL) continue;
	if ($row[electiveTwo] == $seventhcourseResults['electiveOne']) continue;
$opt .= "<option value='{$row['electiveOne']}'>{$row['electiveOne']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End Seventh Elective One

//Begin Seventh Elective Two	
$seventhcourselistResponse = @mysqli_query($dbc, $seventhcourselistQuery);					
echo '<div><label for="7th Elective Two">Elective Two</label>';
echo '<select name="electiveTwo" id="7electiveTwo">';	
$opt =	'<option selected="selected">'.$seventhcourseResults['electiveTwo'].'</option>';
while ($row = mysqli_fetch_assoc($seventhcourselistResponse)){
	if ($row[electiveTwo] == NULL) continue;
	if ($row[electiveTwo] == $seventhcourseResults['electiveTwo']) continue;
$opt .= "<option value='{$row['electiveTwo']}'>{$row['electiveTwo']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End Seventh Elective Two

//Begin Seventh Rotation						
echo '<div><label for="7th Activity">Activity</label>
<input type="text" name="sevenactivity" value="Rotation" readonly="readonly">';
echo'</div>';
//End Seventh Rotation
			echo'</div>';
//End Seventh Grade Year Grade Level Copy


// Begin eighth Grade Year Grade Level Copy
$eighthcourseQuery = "SELECT eighthcourses.english, eighthcourses.math, eighthcourses.science, eighthcourses.socialStudies, eighthcourses.technology, eighthcourses.electiveOne, eighthcourses.electiveTwo, eighthcourses.activity, eighthcourses.other FROM students, eighthcourses, creditcalcs WHERE students.local_id = eighthcourses.local_id AND students.local_id = creditcalcs.local_id and students.local_id = '".$localID."';";
$eighthcourseResponse = @mysqli_query($dbc, $eighthcourseQuery);
$eighthcourseResults = mysqli_fetch_assoc($eighthcourseResponse);
$eighthcourselistQuery = "SELECT * FROM eighthcourselist;";
$eighthcourselistResponse = @mysqli_query($dbc, $eighthcourselistQuery);
$eighthcourselistResults = mysqli_fetch_assoc($eighthcourselistResponse);
			echo '<div id="eighthcourses">';
						echo '<h1>8th Grade Courses</h1>';
//Begin eighth English	
						$eighthcourselistResponse = @mysqli_query($dbc, $eighthcourselistQuery);						
						echo '<div><label for="8th English">English</label>';
						echo '<select name="eighthEnglish" id="eighthEnglish">';	
						$opt =	'<option selected="selected">'.$eighthcourseResults['english'].'</option>';
						while ($row = mysqli_fetch_assoc($eighthcourselistResponse)){
							if ($row[english] == NULL) continue;
							if ($row[english] == $eighthcourseResults['english']) continue;
						$opt .= "<option value='{$row['english']}'>{$row['english']}</option>\n";
						}
						$opt .='</select></div>';
						echo $opt;
//End eighth English	
//Begin eighth math	
$eighthcourselistResponse = @mysqli_query($dbc, $eighthcourselistQuery);						
echo '<div><label for="8th Math">Math</label>';
echo '<select name="eighthmath" id="eighthmath">';	
$opt =	'<option selected="selected">'.$eighthcourseResults['math'].'</option>';
while ($row = mysqli_fetch_assoc($eighthcourselistResponse)){
	if ($row[math] == NULL) continue;
	if ($row[math] == $eighthcourseResults['math']) continue;
$opt .= "<option value='{$row['math']}'>{$row['math']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End eighth math	
//Begin eighth science	
$eighthcourselistResponse = @mysqli_query($dbc, $eighthcourselistQuery);						
echo '<div><label for="8th Science">Science</label>';
echo '<select name="eighthscience" id="eighthscience">';	
$opt =	'<option selected="selected">'.$eighthcourseResults['science'].'</option>';
while ($row = mysqli_fetch_assoc($eighthcourselistResponse)){
	if ($row[science] == NULL) continue;
	if ($row[science] == $eighthcourseResults['science']) continue;
$opt .= "<option value='{$row['science']}'>{$row['science']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End eighth science	
//Begin eighth Social Studies	
$eighthcourselistResponse = @mysqli_query($dbc, $eighthcourselistQuery);						
echo '<div><label for="8th Social Studies">Social Studies</label>';
echo '<select name="eighthsocialStudies" id="eighthsocialStudies">';	
$opt =	'<option selected="selected">'.$eighthcourseResults['socialStudies'].'</option>';
while ($row = mysqli_fetch_assoc($eighthcourselistResponse)){
	if ($row[socialStudies] == NULL) continue;
	if ($row[socialStudies] == $eighthcourseResults['socialStudies']) continue;
$opt .= "<option value='{$row['socialStudies']}'>{$row['socialStudies']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End eighth Social Studies		
//Begin eighth technology	
$eighthcourselistResponse = @mysqli_query($dbc, $eighthcourselistQuery);						
echo '<div><label for="8th Technology">Technology</label>';
echo '<select name="eighthtechnology" id="eighthtechnology">';	
$opt =	'<option selected="selected">'.$eighthcourseResults['technology'].'</option>';
while ($row = mysqli_fetch_assoc($eighthcourselistResponse)){
	if ($row[technology] == NULL) continue;
	if ($row[technology] == $eighthcourseResults['technology']) continue;
$opt .= "<option value='{$row['technology']}'>{$row['technology']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End eighth technology	
//Begin eighth Elective One	
$eighthcourselistResponse = @mysqli_query($dbc, $eighthcourselistQuery);						
echo '<div><label for="8th Elective One">Elective One</label>';
echo '<select name="eightelectiveOne" id="8electiveOne">';	
$opt =	'<option selected="selected">'.$eighthcourseResults['electiveOne'].'</option>';
while ($row = mysqli_fetch_assoc($eighthcourselistResponse)){
	if ($row[electiveOne] == NULL) continue;
	if ($row[electiveTwo] == $eighthcourseResults['electiveOne']) continue;
$opt .= "<option value='{$row['electiveOne']}'>{$row['electiveOne']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End eighth Elective One

//Begin eighth Elective Two	
$eighthcourselistResponse = @mysqli_query($dbc, $eighthcourselistQuery);					
echo '<div><label for="8th Elective Two">Elective Two</label>';
echo '<select name="eightelectiveTwo" id="8electiveTwo">';	
$opt =	'<option selected="selected">'.$eighthcourseResults['electiveTwo'].'</option>';
while ($row = mysqli_fetch_assoc($eighthcourselistResponse)){
	if ($row[electiveTwo] == NULL) continue;
	if ($row[electiveTwo] == $eighthcourseResults['electiveTwo']) continue;
$opt .= "<option value='{$row['electiveTwo']}'>{$row['electiveTwo']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End eighth Elective Two

//Begin eighth Rotation						
echo '<div><label for="8th Activity">Activity</label>
<input type="text" name="eightactivity" value="Rotation" readonly="readonly">';
echo'</div>';
//End eighth Rotation

//Begin eighth other						
echo '<div><label for="8th Other">Other</label>
<input type="text" name="eightother" value="'.$eighthcourseResults['other'].'">';
echo'</div>';
//End eighth other
			echo'</div>';
//End eighth Grade Year Grade Level Copy



// Begin nineth Grade Year Grade Level Copy
$ninethcourseQuery = "SELECT ninethcourses.english, ninethcourses.math, ninethcourses.science, ninethcourses.health, ninethcourses.electiveOne, ninethcourses.electiveTwo, ninethcourses.electiveThree, ninethcourses.electiveFour, ninethcourses.other, ninethcourses.credits FROM students, ninethcourses, creditcalcs WHERE students.local_id = ninethcourses.local_id AND students.local_id = creditcalcs.local_id and students.local_id = '".$localID."';";
$ninethcourseResponse = @mysqli_query($dbc, $ninethcourseQuery);
$ninethcourseResults = mysqli_fetch_assoc($ninethcourseResponse);
$ninethcourselistQuery = "SELECT * FROM ninethcourselist;";
$ninethcourselistResponse = @mysqli_query($dbc, $ninethcourselistQuery);
$ninethcourselistResults = mysqli_fetch_assoc($ninethcourselistResponse);
			echo '<div id="freshmancourses">';
						echo '<h1>9th Grade Courses</h1>';
//Begin nineth English	
						$ninethcourselistResponse = @mysqli_query($dbc, $ninethcourselistQuery);						
						echo '<div><label for="9th English">English</label>';
						echo '<select name="ninethEnglish" id="ninethEnglish">';	
						$opt =	'<option selected="selected">'.$ninethcourseResults['english'].'</option>';
						while ($row = mysqli_fetch_assoc($ninethcourselistResponse)){
							if ($row[english] == NULL) continue;
							if ($row[english] == $ninethcourseResults['english']) continue;
						$opt .= "<option value='{$row['english']}'>{$row['english']}</option>\n";
						}
						$opt .='</select></div>';
						echo $opt;
//End nineth English	
//Begin nineth math	
$ninethcourselistResponse = @mysqli_query($dbc, $ninethcourselistQuery);						
echo '<div><label for="9th Math">Math</label>';
echo '<select name="ninethmath" id="ninethmath">';	
$opt =	'<option selected="selected">'.$ninethcourseResults['math'].'</option>';
while ($row = mysqli_fetch_assoc($ninethcourselistResponse)){
	if ($row[math] == NULL) continue;
	if ($row[math] == $ninethcourseResults['math']) continue;
$opt .= "<option value='{$row['math']}'>{$row['math']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End nineth math	
//Begin nineth science	
$ninethcourselistResponse = @mysqli_query($dbc, $ninethcourselistQuery);						
echo '<div><label for="9th Science">Science</label>';
echo '<select name="ninethscience" id="ninethscience">';	
$opt =	'<option selected="selected">'.$ninethcourseResults['science'].'</option>';
while ($row = mysqli_fetch_assoc($ninethcourselistResponse)){
	if ($row[science] == NULL) continue;
	if ($row[science] == $ninethcourseResults['science']) continue;
$opt .= "<option value='{$row['science']}'>{$row['science']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End nineth science	
//Begin nineth Health	
$ninethcourselistResponse = @mysqli_query($dbc, $ninethcourselistQuery);						
echo '<div><label for="9th Health">Health & PE</label>';
echo '<select name="ninethHealth" id="ninethHealth">';	
$opt =	'<option selected="selected">'.$ninethcourseResults['health'].'</option>';
while ($row = mysqli_fetch_assoc($ninethcourselistResponse)){
	if ($row[health] == NULL) continue;
	if ($row[health] == $ninethcourseResults['health']) continue;
$opt .= "<option value='{$row['health']}'>{$row['health']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End nineth Health		
//Begin nineth Elective One	
$ninethcourselistResponse = @mysqli_query($dbc, $ninethcourselistQuery);						
echo '<div><label for="9th Elective One">Elective One</label>';
echo '<select name="nineelectiveOne" id="9electiveOne">';	
$opt =	'<option selected="selected">'.$ninethcourseResults['electiveOne'].'</option>';
while ($row = mysqli_fetch_assoc($ninethcourselistResponse)){
	if ($row[electiveOne] == NULL) continue;
	if ($row[electiveTwo] == $ninethcourseResults['electiveOne']) continue;
$opt .= "<option value='{$row['electiveOne']}'>{$row['electiveOne']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End nineth Elective One

//Begin nineth Elective Two	
$ninethcourselistResponse = @mysqli_query($dbc, $ninethcourselistQuery);					
echo '<div><label for="9th Elective Two">Elective Two</label>';
echo '<select name="nineelectiveTwo" id="9electiveTwo">';	
$opt =	'<option selected="selected">'.$ninethcourseResults['electiveTwo'].'</option>';
while ($row = mysqli_fetch_assoc($ninethcourselistResponse)){
	if ($row[electiveTwo] == NULL) continue;
	if ($row[electiveTwo] == $ninethcourseResults['electiveTwo']) continue;
$opt .= "<option value='{$row['electiveTwo']}'>{$row['electiveTwo']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End nineth Elective Two

//Begin nineth Elective Three	
$ninethcourselistResponse = @mysqli_query($dbc, $ninethcourselistQuery);					
echo '<div><label for="9th Elective Three">Elective Three</label>';
echo '<select name="nineelectiveThree" id="9electiveThree">';	
$opt =	'<option selected="selected">'.$ninethcourseResults['electiveThree'].'</option>';
while ($row = mysqli_fetch_assoc($ninethcourselistResponse)){
	if ($row[electiveThree] == NULL) continue;
	if ($row[electiveThree] == $ninethcourseResults['electiveThree']) continue;
$opt .= "<option value='{$row['electiveThree']}'>{$row['electiveThree']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End nineth Elective Three

//Begin nineth Elective Four	
$ninethcourselistResponse = @mysqli_query($dbc, $ninethcourselistQuery);					
echo '<div><label for="9th Elective Four">Elective Four</label>';
echo '<select name="nineelectiveFour" id="9electiveFour">';	
$opt =	'<option selected="selected">'.$ninethcourseResults['electiveFour'].'</option>';
while ($row = mysqli_fetch_assoc($ninethcourselistResponse)){
	if ($row[electiveFour] == NULL) continue;
	if ($row[electiveFour] == $ninethcourseResults['electiveFour']) continue;
$opt .= "<option value='{$row['electiveFour']}'>{$row['electiveFour']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End nineth Elective Two

//Begin nineth other						
echo '<div><label for="9th Other">Other</label>
<input type="text" name="nineother" value="'.$ninethcourseResults['other'].'">';
echo'</div>';
//End nineth other

//Begin nineth credits						
echo '<div><label for="9th Credits">Credits Earned</label>
<input type="text" name="ninecredits" value="'.$ninethcourseResults['credits'].'">';
echo'</div>';
//End nineth credits
			echo'</div>';
//End nineth Grade Year Grade Level Copy


// Begin tenth Grade Year Grade Level Copy
$tenthcourseQuery = "SELECT tenthcourses.english, tenthcourses.math, tenthcourses.science, tenthcourses.socialStudies, tenthcourses.electiveOne, tenthcourses.electiveTwo, tenthcourses.electiveThree, tenthcourses.electiveFour, tenthcourses.other, tenthcourses.courseRetakes, tenthcourses.credits FROM students, tenthcourses, creditcalcs WHERE students.local_id = tenthcourses.local_id AND students.local_id = creditcalcs.local_id and students.local_id = '".$localID."';";
$tenthcourseResponse = @mysqli_query($dbc, $tenthcourseQuery);
$tenthcourseResults = mysqli_fetch_assoc($tenthcourseResponse);
$tenthcourselistQuery = "SELECT * FROM tenthcourselist;";
$tenthcourselistResponse = @mysqli_query($dbc, $tenthcourselistQuery);
$tenthcourselistResults = mysqli_fetch_assoc($tenthcourselistResponse);
			echo '<div id="sophomorecourses">';
						echo '<h1>10th Grade Courses</h1>';
//Begin tenth English	
						$tenthcourselistResponse = @mysqli_query($dbc, $tenthcourselistQuery);						
						echo '<div><label for="10th English">English</label>';
						echo '<select name="tenthEnglish" id="tenthEnglish">';	
						$opt =	'<option selected="selected">'.$tenthcourseResults['english'].'</option>';
						while ($row = mysqli_fetch_assoc($tenthcourselistResponse)){
							if ($row[english] == NULL) continue;
							if ($row[english] == $tenthcourseResults['english']) continue;
						$opt .= "<option value='{$row['english']}'>{$row['english']}</option>\n";
						}
						$opt .='</select></div>';
						echo $opt;
//End tenth English	
//Begin tenth math	
$tenthcourselistResponse = @mysqli_query($dbc, $tenthcourselistQuery);						
echo '<div><label for="10th Math">Math</label>';
echo '<select name="tenthmath" id="tenthmath">';	
$opt =	'<option selected="selected">'.$tenthcourseResults['math'].'</option>';
while ($row = mysqli_fetch_assoc($tenthcourselistResponse)){
	if ($row[math] == NULL) continue;
	if ($row[math] == $tenthcourseResults['math']) continue;
$opt .= "<option value='{$row['math']}'>{$row['math']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End tenth math	
//Begin tenth science	
$tenthcourselistResponse = @mysqli_query($dbc, $tenthcourselistQuery);						
echo '<div><label for="10th Science">Science</label>';
echo '<select name="tenthscience" id="tenthscience">';	
$opt =	'<option selected="selected">'.$tenthcourseResults['science'].'</option>';
while ($row = mysqli_fetch_assoc($tenthcourselistResponse)){
	if ($row[science] == NULL) continue;
	if ($row[science] == $tenthcourseResults['science']) continue;
$opt .= "<option value='{$row['science']}'>{$row['science']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End tenth science	
//Begin tenth Social Studies	
$tenthcourselistResponse = @mysqli_query($dbc, $tenthcourselistQuery);						
echo '<div><label for="10th Social Studiees">Social Studies</label>';
echo '<select name="tenthsocialStudies" id="tenthsocialStudies">';	
$opt =	'<option selected="selected">'.$tenthcourseResults['socialStudies'].'</option>';
while ($row = mysqli_fetch_assoc($tenthcourselistResponse)){
	if ($row[socialStudies] == NULL) continue;
	if ($row[socialStudies] == $tenthcourseResults['socialStudies']) continue;
$opt .= "<option value='{$row['socialStudies']}'>{$row['socialStudies']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End tenth Social Studies		
//Begin tenth Elective One	
$tenthcourselistResponse = @mysqli_query($dbc, $tenthcourselistQuery);						
echo '<div><label for="10th Elective One">Elective One</label>';
echo '<select name="tenelectiveOne" id="10electiveOne">';	
$opt =	'<option selected="selected">'.$tenthcourseResults['electiveOne'].'</option>';
while ($row = mysqli_fetch_assoc($tenthcourselistResponse)){
	if ($row[electiveOne] == NULL) continue;
	if ($row[electiveTwo] == $tenthcourseResults['electiveOne']) continue;
$opt .= "<option value='{$row['electiveOne']}'>{$row['electiveOne']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End tenth Elective One

//Begin tenth Elective Two	
$tenthcourselistResponse = @mysqli_query($dbc, $tenthcourselistQuery);					
echo '<div><label for="10th Elective Two">Elective Two</label>';
echo '<select name="tenelectiveTwo" id="10electiveTwo">';	
$opt =	'<option selected="selected">'.$tenthcourseResults['electiveTwo'].'</option>';
while ($row = mysqli_fetch_assoc($tenthcourselistResponse)){
	if ($row[electiveTwo] == NULL) continue;
	if ($row[electiveTwo] == $tenthcourseResults['electiveTwo']) continue;
$opt .= "<option value='{$row['electiveTwo']}'>{$row['electiveTwo']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End tenth Elective Two

//Begin tenth Elective Three	
$tenthcourselistResponse = @mysqli_query($dbc, $tenthcourselistQuery);					
echo '<div><label for="10th Elective Three">Elective Three</label>';
echo '<select name="tenelectiveThree" id="10electiveThree">';	
$opt =	'<option selected="selected">'.$tenthcourseResults['electiveThree'].'</option>';
while ($row = mysqli_fetch_assoc($tenthcourselistResponse)){
	if ($row[electiveThree] == NULL) continue;
	if ($row[electiveThree] == $tenthcourseResults['electiveThree']) continue;
$opt .= "<option value='{$row['electiveThree']}'>{$row['electiveThree']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End tenth Elective Three

//Begin tenth Elective Four	
$tenthcourselistResponse = @mysqli_query($dbc, $tenthcourselistQuery);					
echo '<div><label for="10th Elective Four">Elective Four</label>';
echo '<select name="tenelectiveFour" id="10electiveFour">';	
$opt =	'<option selected="selected">'.$tenthcourseResults['electiveFour'].'</option>';
while ($row = mysqli_fetch_assoc($tenthcourselistResponse)){
	if ($row[electiveFour] == NULL) continue;
	if ($row[electiveFour] == $tenthcourseResults['electiveFour']) continue;
$opt .= "<option value='{$row['electiveFour']}'>{$row['electiveFour']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End tenth Elective Two

//Begin tenth other						
echo '<div><label for="10th Other">Other</label>
<input type="text" name="tenother" value="'.$tenthcourseResults['other'].'">';
echo'</div>';
//End tenth other
//Begin tenth retakes						
echo '<div><label for="10th Retakes">Course Retakes</label>
<input type="text" name="tenretakes" value="'.$tenthcourseResults['courseRetakes'].'">';
echo'</div>';
//End tenth retakes
//Begin tenth credits						
echo '<div><label for="10th Credits">Credits Earned</label>
<input type="text" name="tencredits" value="'.$tenthcourseResults['credits'].'">';
echo'</div>';
//End tenth credits
			echo'</div>';
//End tenth Grade Year Grade Level Copy



// Begin eleventh Grade Year Grade Level Copy
$eleventhcourseQuery = "SELECT eleventhcourses.english, eleventhcourses.math, eleventhcourses.science, eleventhcourses.socialStudies, eleventhcourses.electiveOne, eleventhcourses.electiveTwo, eleventhcourses.electiveThree, eleventhcourses.electiveFour, eleventhcourses.other, eleventhcourses.courseRetakes, eleventhcourses.credits FROM students, eleventhcourses, creditcalcs WHERE students.local_id = eleventhcourses.local_id AND students.local_id = creditcalcs.local_id and students.local_id = '".$localID."';";
$eleventhcourseResponse = @mysqli_query($dbc, $eleventhcourseQuery);
$eleventhcourseResults = mysqli_fetch_assoc($eleventhcourseResponse);
$eleventhcourselistQuery = "SELECT * FROM eleventhcourselist;";
$eleventhcourselistResponse = @mysqli_query($dbc, $eleventhcourselistQuery);
$eleventhcourselistResults = mysqli_fetch_assoc($eleventhcourselistResponse);
			echo '<div id="juniorcourses">';
						echo '<h1>11th Grade Courses</h1>';
//Begin eleventh English	
						$eleventhcourselistResponse = @mysqli_query($dbc, $eleventhcourselistQuery);						
						echo '<div><label for="11th English">English</label>';
						echo '<select name="eleventhEnglish" id="eleventhEnglish">';	
						$opt =	'<option selected="selected">'.$eleventhcourseResults['english'].'</option>';
						while ($row = mysqli_fetch_assoc($eleventhcourselistResponse)){
							if ($row[english] == NULL) continue;
							if ($row[english] == $eleventhcourseResults['english']) continue;
						$opt .= "<option value='{$row['english']}'>{$row['english']}</option>\n";
						}
						$opt .='</select></div>';
						echo $opt;
//End eleventh English	
//Begin eleventh math	
$eleventhcourselistResponse = @mysqli_query($dbc, $eleventhcourselistQuery);						
echo '<div><label for="11th Math">Math</label>';
echo '<select name="eleventhmath" id="eleventhmath">';	
$opt =	'<option selected="selected">'.$eleventhcourseResults['math'].'</option>';
while ($row = mysqli_fetch_assoc($eleventhcourselistResponse)){
	if ($row[math] == NULL) continue;
	if ($row[math] == $eleventhcourseResults['math']) continue;
$opt .= "<option value='{$row['math']}'>{$row['math']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End eleventh math	
//Begin eleventh science	
$eleventhcourselistResponse = @mysqli_query($dbc, $eleventhcourselistQuery);						
echo '<div><label for="11th Science">Science</label>';
echo '<select name="eleventhscience" id="eleventhscience">';	
$opt =	'<option selected="selected">'.$eleventhcourseResults['science'].'</option>';
while ($row = mysqli_fetch_assoc($eleventhcourselistResponse)){
	if ($row[science] == NULL) continue;
	if ($row[science] == $eleventhcourseResults['science']) continue;
$opt .= "<option value='{$row['science']}'>{$row['science']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End eleventh science	
//Begin eleventh Social Studies	
$eleventhcourselistResponse = @mysqli_query($dbc, $eleventhcourselistQuery);						
echo '<div><label for="11th Social Studiees">Social Studies</label>';
echo '<select name="eleventhsocialStudies" id="eleventhsocialStudies">';	
$opt =	'<option selected="selected">'.$eleventhcourseResults['socialStudies'].'</option>';
while ($row = mysqli_fetch_assoc($eleventhcourselistResponse)){
	if ($row[socialStudies] == NULL) continue;
	if ($row[socialStudies] == $eleventhcourseResults['socialStudies']) continue;
$opt .= "<option value='{$row['socialStudies']}'>{$row['socialStudies']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End eleventh Social Studies		
//Begin eleventh Elective One	
$eleventhcourselistResponse = @mysqli_query($dbc, $eleventhcourselistQuery);						
echo '<div><label for="11th Elective One">Elective One</label>';
echo '<select name="elevenelectiveOne" id="11electiveOne">';	
$opt =	'<option selected="selected">'.$eleventhcourseResults['electiveOne'].'</option>';
while ($row = mysqli_fetch_assoc($eleventhcourselistResponse)){
	if ($row[electiveOne] == NULL) continue;
	if ($row[electiveTwo] == $eleventhcourseResults['electiveOne']) continue;
$opt .= "<option value='{$row['electiveOne']}'>{$row['electiveOne']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End eleventh Elective One

//Begin eleventh Elective Two	
$eleventhcourselistResponse = @mysqli_query($dbc, $eleventhcourselistQuery);					
echo '<div><label for="11th Elective Two">Elective Two</label>';
echo '<select name="elevenelectiveTwo" id="11electiveTwo">';	
$opt =	'<option selected="selected">'.$eleventhcourseResults['electiveTwo'].'</option>';
while ($row = mysqli_fetch_assoc($eleventhcourselistResponse)){
	if ($row[electiveTwo] == NULL) continue;
	if ($row[electiveTwo] == $eleventhcourseResults['electiveTwo']) continue;
$opt .= "<option value='{$row['electiveTwo']}'>{$row['electiveTwo']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End eleventh Elective Two

//Begin eleventh Elective Three	
$eleventhcourselistResponse = @mysqli_query($dbc, $eleventhcourselistQuery);					
echo '<div><label for="11th Elective Three">Elective Three</label>';
echo '<select name="elevenelectiveThree" id="11electiveThree">';	
$opt =	'<option selected="selected">'.$eleventhcourseResults['electiveThree'].'</option>';
while ($row = mysqli_fetch_assoc($eleventhcourselistResponse)){
	if ($row[electiveThree] == NULL) continue;
	if ($row[electiveThree] == $eleventhcourseResults['electiveThree']) continue;
$opt .= "<option value='{$row['electiveThree']}'>{$row['electiveThree']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End eleventh Elective Three

//Begin eleventh Elective Four	
$eleventhcourselistResponse = @mysqli_query($dbc, $eleventhcourselistQuery);					
echo '<div><label for="11th Elective Four">Elective Four</label>';
echo '<select name="elevenelectiveFour" id="11electiveFour">';	
$opt =	'<option selected="selected">'.$eleventhcourseResults['electiveFour'].'</option>';
while ($row = mysqli_fetch_assoc($eleventhcourselistResponse)){
	if ($row[electiveFour] == NULL) continue;
	if ($row[electiveFour] == $eleventhcourseResults['electiveFour']) continue;
$opt .= "<option value='{$row['electiveFour']}'>{$row['electiveFour']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End eleventh Elective Two

//Begin eleventh other						
echo '<div><label for="11th Other">Other</label>
<input type="text" name="elevenother" value="'.$eleventhcourseResults['other'].'">';
echo'</div>';
//End eleventh other
//Begin eleventh retakes						
echo '<div><label for="11th Retakes">Course Retakes</label>
<input type="text" name="elevenretakes" value="'.$eleventhcourseResults['courseRetakes'].'">';
echo'</div>';
//End eleventh retakes
//Begin eleventh credits						
echo '<div><label for="11th Credits">Credits Earned</label>
<input type="text" name="elevencredits" value="'.$eleventhcourseResults['credits'].'">';
echo'</div>';
//End eleventh credits
			echo'</div>';
//End eleventh Grade Year Grade Level Copy




// Begin twelfth Grade Year Grade Level Copy
$twelfthcourseQuery = "SELECT twelfthcourses.english, twelfthcourses.math, twelfthcourses.science, twelfthcourses.socialStudies, twelfthcourses.electiveOne, twelfthcourses.electiveTwo, twelfthcourses.electiveThree, twelfthcourses.electiveFour, twelfthcourses.other, twelfthcourses.courseRetakes, twelfthcourses.credits FROM students, twelfthcourses, creditcalcs WHERE students.local_id = twelfthcourses.local_id AND students.local_id = creditcalcs.local_id and students.local_id = '".$localID."';";
$twelfthcourseResponse = @mysqli_query($dbc, $twelfthcourseQuery);
$twelfthcourseResults = mysqli_fetch_assoc($twelfthcourseResponse);
$twelfthcourselistQuery = "SELECT * FROM twelfthcourselist;";
$twelfthcourselistResponse = @mysqli_query($dbc, $twelfthcourselistQuery);
$twelfthcourselistResults = mysqli_fetch_assoc($twelfthcourselistResponse);
			echo '<div id="seniorcourses">';
						echo '<h1>12th Grade Courses</h1>';
//Begin twelfth English	
						$twelfthcourselistResponse = @mysqli_query($dbc, $twelfthcourselistQuery);						
						echo '<div><label for="12th English">English</label>';
						echo '<select name="twelfthEnglish" id="twelfthEnglish">';	
						$opt =	'<option selected="selected">'.$twelfthcourseResults['english'].'</option>';
						while ($row = mysqli_fetch_assoc($twelfthcourselistResponse)){
							if ($row[english] == NULL) continue;
							if ($row[english] == $twelfthcourseResults['english']) continue;
						$opt .= "<option value='{$row['english']}'>{$row['english']}</option>\n";
						}
						$opt .='</select></div>';
						echo $opt;
//End twelfth English	
//Begin twelfth math	
$twelfthcourselistResponse = @mysqli_query($dbc, $twelfthcourselistQuery);						
echo '<div><label for="12th Math">Math</label>';
echo '<select name="twelfthmath" id="twelfthmath">';	
$opt =	'<option selected="selected">'.$twelfthcourseResults['math'].'</option>';
while ($row = mysqli_fetch_assoc($twelfthcourselistResponse)){
	if ($row[math] == NULL) continue;
	if ($row[math] == $twelfthcourseResults['math']) continue;
$opt .= "<option value='{$row['math']}'>{$row['math']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End twelfth math	
//Begin twelfth science	
$twelfthcourselistResponse = @mysqli_query($dbc, $twelfthcourselistQuery);						
echo '<div><label for="12th Science">Science</label>';
echo '<select name="twelfthscience" id="twelfthscience">';	
$opt =	'<option selected="selected">'.$twelfthcourseResults['science'].'</option>';
while ($row = mysqli_fetch_assoc($twelfthcourselistResponse)){
	if ($row[science] == NULL) continue;
	if ($row[science] == $twelfthcourseResults['science']) continue;
$opt .= "<option value='{$row['science']}'>{$row['science']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End twelfth science	
//Begin twelfth Social Studies	
$twelfthcourselistResponse = @mysqli_query($dbc, $twelfthcourselistQuery);						
echo '<div><label for="12th Social Studiees">Social Studies</label>';
echo '<select name="twelfthsocialStudies" id="twelfthsocialStudies">';	
$opt =	'<option selected="selected">'.$twelfthcourseResults['socialStudies'].'</option>';
while ($row = mysqli_fetch_assoc($twelfthcourselistResponse)){
	if ($row[socialStudies] == NULL) continue;
	if ($row[socialStudies] == $twelfthcourseResults['socialStudies']) continue;
$opt .= "<option value='{$row['socialStudies']}'>{$row['socialStudies']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End twelfth Social Studies		
//Begin twelfth Elective One	
$twelfthcourselistResponse = @mysqli_query($dbc, $twelfthcourselistQuery);						
echo '<div><label for="12th Elective One">Elective One</label>';
echo '<select name="twelveelectiveOne" id="12electiveOne">';	
$opt =	'<option selected="selected">'.$twelfthcourseResults['electiveOne'].'</option>';
while ($row = mysqli_fetch_assoc($twelfthcourselistResponse)){
	if ($row[electiveOne] == NULL) continue;
	if ($row[electiveTwo] == $twelfthcourseResults['electiveOne']) continue;
$opt .= "<option value='{$row['electiveOne']}'>{$row['electiveOne']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End twelfth Elective One

//Begin twelfth Elective Two	
$twelfthcourselistResponse = @mysqli_query($dbc, $twelfthcourselistQuery);					
echo '<div><label for="12th Elective Two">Elective Two</label>';
echo '<select name="twelveelectiveTwo" id="12electiveTwo">';	
$opt =	'<option selected="selected">'.$twelfthcourseResults['electiveTwo'].'</option>';
while ($row = mysqli_fetch_assoc($twelfthcourselistResponse)){
	if ($row[electiveTwo] == NULL) continue;
	if ($row[electiveTwo] == $twelfthcourseResults['electiveTwo']) continue;
$opt .= "<option value='{$row['electiveTwo']}'>{$row['electiveTwo']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End twelfth Elective Two

//Begin twelfth Elective Three	
$twelfthcourselistResponse = @mysqli_query($dbc, $twelfthcourselistQuery);					
echo '<div><label for="12th Elective Three">Elective Three</label>';
echo '<select name="twelveelectiveThree" id="12electiveThree">';	
$opt =	'<option selected="selected">'.$twelfthcourseResults['electiveThree'].'</option>';
while ($row = mysqli_fetch_assoc($twelfthcourselistResponse)){
	if ($row[electiveThree] == NULL) continue;
	if ($row[electiveThree] == $twelfthcourseResults['electiveThree']) continue;
$opt .= "<option value='{$row['electiveThree']}'>{$row['electiveThree']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End twelfth Elective Three

//Begin twelfth Elective Four	
$twelfthcourselistResponse = @mysqli_query($dbc, $twelfthcourselistQuery);					
echo '<div><label for="12th Elective Four">Elective Four</label>';
echo '<select name="twelveelectiveFour" id="12electiveFour">';	
$opt =	'<option selected="selected">'.$twelfthcourseResults['electiveFour'].'</option>';
while ($row = mysqli_fetch_assoc($twelfthcourselistResponse)){
	if ($row[electiveFour] == NULL) continue;
	if ($row[electiveFour] == $twelfthcourseResults['electiveFour']) continue;
$opt .= "<option value='{$row['electiveFour']}'>{$row['electiveFour']}</option>\n";
}
$opt .='</select></div>';
echo $opt;
//End twelfth Elective Two

//Begin twelfth other						
echo '<div><label for="12th Other">Other</label>
<input type="text" name="twelveother" value="'.$twelfthcourseResults['other'].'">';
echo'</div>';
//End twelfth other
//Begin twelfth retakes						
echo '<div><label for="12th Retakes">Course Retakes</label>
<input type="text" name="twelveretakes" value="'.$twelfthcourseResults['courseRetakes'].'">';
echo'</div>';
//End twelfth retakes
//Begin twelfth credits						
echo '<div><label for="12th Credits">Credits Earned</label>
<input type="text" name="twelvecredits" value="'.$twelfthcourseResults['credits'].'">';
echo'</div>';
//End twelfth credits
			echo'</div>';
//End twelfth Grade Year Grade Level Copy
echo '</div><div id="right-button"><img src="/images/right.png" ></div></div>';
//End Grade Level Courses


//Begin Credit Calculations
$ethgdcreditsquery = "select eighthHS from creditcalcs where local_id='".$localID."';";
$collegeCreditsquery = "select totalCollege from creditcalcs where local_id='".$localID."';";
$creditCalcQuery = "SELECT (IFNULL(SUM(t.credits), 0) + IFNULL(SUM(e.credits), 0) + IFNULL(SUM(ten.credits), 0 ) + IFNULL(SUM(n.credits), 0 ) + IFNULL(SUM(ei.eighthHS), 0 )) total_credits FROM students s LEFT JOIN twelfthcourses t on t.local_id = s.local_id LEFT JOIN eleventhcourses e on e.local_id = s.local_id LEFT JOIN tenthcourses ten on ten.local_id = s.local_id LEFT JOIN ninethcourses n on n.local_id = s.local_id LEFT JOIN creditcalcs ei on ei.local_id = s.local_id WHERE s.local_id = '".$localID."';";
$creditCalcResponse = @mysqli_query($dbc, $creditCalcQuery);
$creditCalcResults = mysqli_fetch_assoc($creditCalcResponse);
$eighthcreditResponse = @mysqli_query($dbc, $ethgdcreditsquery);
$eighthcreditResults = mysqli_fetch_assoc($eighthcreditResponse);
$CollegecreditResponse = @mysqli_query($dbc, $collegeCreditsquery);
$CollegecreditResults = mysqli_fetch_assoc($CollegecreditResponse);

$totalcredits = $creditCalcResults['total_credits'];
$submitcredits = $creditCalcResults['total_credits'];
$ethgdcredits = $eighthcreditResults['eighthHS'];
$collegecredits = $CollegecreditResults['totalCollege'];

		echo'<div id="CreditCalcs">';
					echo '<div id="ethgdcredits"><label for="8th HS Credits">HS Credits from 8th Grade </label><input type="text" name="eightthHsCredits" value="'.$ethgdcredits.'"></div>';
					echo '<div id="collegecredits"><label for="College Credits">College Credits </label><input type="text" name="CollegeCredits" value="'.$collegecredits.'"></div>'; 
					echo '<div id="totalcredits"><h3>Total HS Credits: </h3><span>'.$totalcredits.'</span></div>
						<input type="hidden" name="Total Credits" value="'.$submitcredits.'">';
					echo '<h1></h1>';
		echo '</div>';
//End Credit Calculations


//Begin Static Content
echo '<div id="static-container">';
//Begin Additional Resources
$essentialDocsQuery = "select essentialCourseTitle, essentialCourseLink from additionalresources;";
$essentialDocsResponse = @mysqli_query($dbc, $essentialDocsQuery);	
 			echo'<div id="resource-container">
 					<h4>Essential Course Planning Documents</h4>';
					 $opt = '<ul>';
					 while ($row = mysqli_fetch_assoc($essentialDocsResponse)){
						if ($row[essentialCourseTitle] == NULL) continue;
					$opt .= "<li><a href='{$row['essentialCourseLink']}' target='_blank'>{$row['essentialCourseTitle']}</a></li>\n";
					}
					$opt .='</ul>';
					echo $opt;
 			echo '</div>';
//End Additional Resources


//Begin Graduation Requirements.
$gradrequirementsQuery = "select * from gradrequirements where subject != 'TOTAL CREDITS';";
$gradrequirementsResponse = @mysqli_query($dbc, $gradrequirementsQuery);
$totalrequirmentsQuery = "select * from gradrequirements where subject = 'TOTAL CREDITS';";
$totalrequirmentsResponse = @mysqli_query($dbc, $totalrequirmentsQuery);
$totalreqirementsResults = mysqli_fetch_assoc($totalrequirmentsResponse);
 			echo'<div id="gradreq-container">
 					<h4>Graduation Requirements</h4>';		
$opt = '
		<table id="gradtable">
			<tr>
				<th>Subject Area</th>
				<th>Credits</th>
			</tr>';

while ($row = mysqli_fetch_assoc($gradrequirementsResponse)){
	if ($row[subject] == NULL) continue;
$opt .= "<tr><td>{$row['subject']}</td><td>{$row['credits']}</td></tr>\n";
}
$opt .='<tr style="font-weight:bold"><td>'.$totalreqirementsResults[subject].'</td><td>'.$totalreqirementsResults[credits].'</td></tr></table>';
echo $opt;
 			echo'</div>';
//End Graduation Requirements

//Begin Goal/Designation Box
 			echo'<div id="goalsanddesignations">';
//Begin Goal Tracker
	$goalQuery = "select * from goalplanning where local_id = '".$localID."';";
	$goalResponse = @mysqli_query($dbc, $goalQuery);
	$goalResults = mysqli_fetch_assoc($goalResponse);
	$collegeobjQuery = "select * from collegeobjectiveslist;";
	$collegeobjResponse = @mysqli_query($dbc, $collegeobjQuery);
	$vocationalobjQuery = "select * from vocationalobjectiveslist;";
	$vocationalobjResponse = @mysqli_query($dbc, $vocationalobjQuery);
 			echo'<div id="goals-container">
 					<h4>Goal Planning</h4>';
				 					echo'<div><label for="College Objectives">College Objectives</label>';
				 					$opt = '<select name="College Objectives" id="colobj">
 								 	<option selected="selected">'.$goalResults[collegeObjective].'</option>
									 ';
							 while ($row = mysqli_fetch_assoc($collegeobjResponse)){
								 if ($row[objective] == NULL) continue;
							 $opt .= "<option value='{$row['objective']}'>{$row['objective']}</option>\n";
							 }
							 $opt .='</select>';
							 echo $opt; 


				 					echo'<label for="Vocational Objective">Vocational Objective</label>';
				 					$opt = '<select name="Vocational Objectives" id="vocobj">
 								 	<option selected="selected">'.$goalResults[vocationalObjective].'</option>
									 ';
							 while ($row = mysqli_fetch_assoc($vocationalobjResponse)){
								 if ($row[objective] == NULL) continue;
							 $opt .= "<option value='{$row['objective']}'>{$row['objective']}</option>\n";
							 }
							 $opt .='</select>';
							 echo $opt; 
								echo '<div><label for="My Strongest Area Is">My Strongest Area Is:</label><input type="text" name="strongestarea" value="'.$goalResults[strongestArea].'"></div>';
								echo '<div><label for="My Weakest Area Is">My Weakest Area Is:</label><input type="text" name="weakestarea" value="'.$goalResults[weakestArea].'"></div>';
								echo '<div><label for="My Improvement Goal">My Improvement Goal</label><textarea name="My Improvement Goal">'.$goalResults[improvementGoal].'</textarea></div>';
								echo '</div>';
 			echo '</div>';
//End Goal Tracker

//Begin Designations
	$designationQuery = "select * from designations where local_id = '".$localID."';";
	$designationResponse = @mysqli_query($dbc, $designationQuery);
	$designationResults = mysqli_fetch_assoc($designationResponse);


 	$designations = array_search('Designations', $listValues[0]);
 			echo'<div id="designation-container">';
					$opt = "<h4>Designations</h4>\n";
						if($designationResults[gt] == 1) {
							$opt .= '<label class="container">GT<input type="checkbox" name="GT" value="1" checked><span class="checkmark"></span></label>';
							} else {
							$opt .= '<input type="hidden" name="GT" value="0" /><label class="container">GT<input type="checkbox" name="GT" value="1"><span class="checkmark"></span></label>';
							}
							if($designationResults[504] == 1) {
								$opt .= '<label class="container">504<input type="checkbox" name="504" value="1" checked><span class="checkmark"></span></label>';
								} else {
								$opt .= '<input type="hidden" name="504" value="0" /><label class="container">504<input type="checkbox" name="504" value="1"><span class="checkmark"></span></label>';
								}
								if($designationResults[iep] == 1) {
									$opt .= '<label class="container">IEP<input type="checkbox" name="IEP" value="1" checked><span class="checkmark"></span></label>';
									} else {
									$opt .= '<input type="hidden" name="IEP" value="0" /><label class="container">IEP<input type="checkbox" name="IEP" value="1"><span class="checkmark"></span></label>';
									}
									if($designationResults[ell] == 1) {
										$opt .= '<label class="container">ELL<input type="checkbox" name="ELL" value="1" checked><span class="checkmark"></span></label>';
										} else {
										$opt .= '<input type="hidden" name="ELL" value="0" /><label class="container">ELL<input type="checkbox" name="ELL" value="1"><span class="checkmark"></span></label>';
										}
										if($designationResults[speechServices] == 1) {
											$opt .= '<label class="container">Speech Services<input type="checkbox" name="Speech Services" value="1" checked><span class="checkmark"></span></label>';
											} else {
											$opt .= '<input type="hidden" name="Speech Services" value="0" /><label class="container">Speech Services<input type="checkbox" name="Speech Services" value="1"><span class="checkmark"></span></label>';
											}
										echo $opt; 					 	

 			echo '</div>';
//End Designations

//Begin Certificate Goals
$certgoalQuery = "select * from certificationgoals where local_id = '".$localID."';";
$certgoalResponse = @mysqli_query($dbc, $certgoalQuery);
$certgoalResults = mysqli_fetch_assoc($certgoalResponse);
$certlistquery = "select * from certificationsList;";
$certlistResponse = @mysqli_query($dbc, $certlistquery);
				echo'<div id="certified"><h4>I want to be certified in:</h4>
						<select name="CertificationGoals1" id="certgoals1">';

						$opt = '<option selected="selected">'.$certgoalResults[certGoal1].'</option>';
			   while ($row = mysqli_fetch_assoc($certlistResponse)){
				   if ($row[certification] == NULL) continue;
			   $opt .= "<option value='{$row['certification']}'>{$row['certification']}</option>\n";
			   }
			   $opt .='</select>';
			   echo $opt; 
			   $certlistquery = "select * from certificationsList;";
			   $certlistResponse = @mysqli_query($dbc, $certlistquery);
						$opt = '<select name="CertificationGoals2" id="certgoals2">
 								 	<option selected="selected">'.$certgoalResults[certGoal2].'</option>';
									  while ($row = mysqli_fetch_assoc($certlistResponse)){
										if ($row[certification] == NULL) continue;
									$opt .= "<option value='{$row['certification']}'>{$row['certification']}</option>\n";
									}
									$opt .='</select>';
									echo $opt;
									$certlistquery = "select * from certificationsList;";
									$certlistResponse = @mysqli_query($dbc, $certlistquery);
						$opt = '<select name="CertificationGoals3" id="certgoals2">
 								 	<option selected="selected">'.$certgoalResults[certGoal3].'</option>';
									  while ($row = mysqli_fetch_assoc($certlistResponse)){
										if ($row[certification] == NULL) continue;
									$opt .= "<option value='{$row['certification']}'>{$row['certification']}</option>\n";
									}
									$opt .='</select></div>';
									echo $opt;
//End Certificate Goals

//Begin Certificate Resources
$certificationResourceQuery = "select certificationTitle, certificationLinks from additionalresources;";
$certificationResourceResponse = @mysqli_query($dbc, $certificationResourceQuery);	
 			echo'<div id="cert-resource-container">
 					<h4>Certification Resources</h4>';
					 $opt = '<ul>';
					 while ($row = mysqli_fetch_assoc($certificationResourceResponse)){
						if ($row[certificationTitle] == NULL) continue;
					$opt .= "<li><a href='{$row['certificationLinks']}' target='_blank'>{$row['certificationTitle']}</a></li>\n";
					}
					$opt .='</ul></div>';
					echo $opt;
//End Certificate Resources
 			echo '</div>';
//End Goal/Designation Box
 		echo '</div>';
//End Static Content



//Begin Score Inputs
echo'<div id="scorewrapper"><div id="left-button2" class=" dimLeft"><img src="/images/left.png" ></div><div id="ScoreInputs">';
// Begin 7th Grade Testing
$seventhscoresQuery = "SELECT seventhscores.aspireEnglish, seventhscores.aspireReading, seventhscores.aspireScience, seventhscores.aspireMath, seventhscores.mapLanguage, seventhscores.mapReading, seventhscores.mapScience, seventhscores.mapMath, seventhscores.dukeTip FROM students, seventhscores WHERE students.state_id = seventhscores.state_id and students.state_id = '".$stateID."';";
$seventhscoresResponse = @mysqli_query($dbc, $seventhscoresQuery);
$seventhscoresResults = mysqli_fetch_assoc($seventhscoresResponse);
echo '<div id="seventhtesting">';
echo '<h1>7th Grade Testing</h1>';
   echo '<div><label for="ACT Aspire English">ACT Aspire English</label><input type="text" name="seventhAspireEnglish" value="'.$seventhscoresResults[aspireEnglish].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Aspire Reading">ACT Aspire Reading</label><input type="text" name="seventhAspireReading" value="'.$seventhscoresResults[aspireReading].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Aspire Science">ACT Aspire Science</label><input type="text" name="seventhAspireScience" value="'.$seventhscoresResults[aspireScience].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Aspire Math">ACT Aspire Math</label><input type="text" name="seventhAspireMath" value="'.$seventhscoresResults[aspireMath].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Language">MAP Language</label><input type="text" name="seventMapLanguage" value="'.$seventhscoresResults[mapLanguage].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Reading">MAP Reading</label><input type="text" name="seventMapReading" value="'.$seventhscoresResults[mapReading].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Science">MAP Science</label><input type="text" name="seventMapScience" value="'.$seventhscoresResults[mapScience].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Math">MAP Math</label><input type="text" name="seventMapMath" value="'.$seventhscoresResults[mapMath].'" readonly="readonly"></div>';
   echo '<div><label for="Duke TIP">Duke TIP/ACT Score</label><input type="text" name="seventdukeTip" value="'.$seventhscoresResults[dukeTip].'" readonly="readonly"></div>';
   echo '</div>';
//End 7th Grade Testing

// Begin 8th Grade Testing
$eighthscoresQuery = "SELECT eighthscores.aspireEnglish, eighthscores.aspireReading, eighthscores.aspireScience, eighthscores.aspireMath, eighthscores.mapLanguage, eighthscores.mapReading, eighthscores.mapScience, eighthscores.mapMath FROM students, eighthscores WHERE students.state_id = eighthscores.state_id and students.state_id = '".$stateID."';";
$eighthscoresResponse = @mysqli_query($dbc, $eighthscoresQuery);
$eighthscoresResults = mysqli_fetch_assoc($eighthscoresResponse);
echo '<div id="eighthtesting">';
echo '<h1>8th Grade Testing</h1>';
   echo '<div><label for="ACT Aspire English">ACT Aspire English</label><input type="text" name="eighthAspireEnglish" value="'.$eighthscoresResults[aspireEnglish].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Aspire Reading">ACT Aspire Reading</label><input type="text" name="eighthAspireReading" value="'.$eighthscoresResults[aspireReading].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Aspire Science">ACT Aspire Science</label><input type="text" name="eighthAspireScience" value="'.$eighthscoresResults[aspireScience].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Aspire Math">ACT Aspire Math</label><input type="text" name="eighthAspireMath" value="'.$eighthscoresResults[aspireMath].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Language">MAP Language</label><input type="text" name="eighthMapLanguage" value="'.$eighthscoresResults[mapLanguage].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Reading">MAP Reading</label><input type="text" name="eighthMapReading" value="'.$eighthscoresResults[mapReading].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Science">MAP Science</label><input type="text" name="eighthMapScience" value="'.$eighthscoresResults[mapScience].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Math">MAP Math</label><input type="text" name="eighthMapMath" value="'.$eighthscoresResults[mapMath].'" readonly="readonly"></div>';
   echo '</div>';

//End 8th Grade Testing

// Begin 9th Grade Testing
$ninethscoresQuery = "SELECT ninethscores.aspireEnglish, ninethscores.aspireReading, ninethscores.aspireScience, ninethscores.aspireMath, ninethscores.mapLanguage, ninethscores.mapReading, ninethscores.mapScience, ninethscores.mapMath FROM students, ninethscores WHERE students.state_id = ninethscores.state_id and students.state_id = '".$stateID."';";
$ninethscoresResponse = @mysqli_query($dbc, $ninethscoresQuery);
$ninethscoresResults = mysqli_fetch_assoc($ninethscoresResponse);
echo '<div id="ninethtesting">';
echo '<h1>9th Grade Testing</h1>';
   echo '<div><label for="ACT Aspire English">ACT Aspire English</label><input type="text" name="ninethAspireEnglish" value="'.$ninethscoresResults[aspireEnglish].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Aspire Reading">ACT Aspire Reading</label><input type="text" name="ninethAspireReading" value="'.$ninethscoresResults[aspireReading].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Aspire Science">ACT Aspire Science</label><input type="text" name="ninethAspireScience" value="'.$ninethscoresResults[aspireScience].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Aspire Math">ACT Aspire Math</label><input type="text" name="ninethAspireMath" value="'.$ninethscoresResults[aspireMath].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Language">MAP Language</label><input type="text" name="ninethMapLanguage" value="'.$ninethscoresResults[mapLanguage].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Reading">MAP Reading</label><input type="text" name="ninethMapReading" value="'.$ninethscoresResults[mapReading].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Science">MAP Science</label><input type="text" name="ninethMapScience" value="'.$ninethscoresResults[mapScience].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Math">MAP Math</label><input type="text" name="ninethMapMath" value="'.$ninethscoresResults[mapMath].'" readonly="readonly"></div>';
   echo '</div>';

//End 9th Grade Testing

// Begin 10th Grade Testing
$tenthscoresQuery = "SELECT tenthscores.aspireEnglish, tenthscores.aspireReading, tenthscores.aspireScience, tenthscores.aspireMath, tenthscores.mapLanguage, tenthscores.mapReading, tenthscores.mapScience, tenthscores.mapMath FROM students, tenthscores WHERE students.state_id = tenthscores.state_id and students.state_id = '".$stateID."';";
$tenthscoresResponse = @mysqli_query($dbc, $tenthscoresQuery);
$tenthscoresResults = mysqli_fetch_assoc($tenthscoresResponse);
echo '<div id="tenthtesting">';
echo '<h1>10th Grade Testing</h1>';
   echo '<div><label for="ACT Aspire English">ACT Aspire English</label><input type="text" name="tenthAspireEnglish" value="'.$tenthscoresResults[aspireEnglish].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Aspire Reading">ACT Aspire Reading</label><input type="text" name="tenthAspireReading" value="'.$tenthscoresResults[aspireReading].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Aspire Science">ACT Aspire Science</label><input type="text" name="tenthAspireScience" value="'.$tenthscoresResults[aspireScience].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Aspire Math">ACT Aspire Math</label><input type="text" name="tenthAspireMath" value="'.$tenthscoresResults[aspireMath].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Language">MAP Language</label><input type="text" name="tenthMapLanguage" value="'.$tenthscoresResults[mapLanguage].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Reading">MAP Reading</label><input type="text" name="tenthMapReading" value="'.$tenthscoresResults[mapReading].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Science">MAP Science</label><input type="text" name="tenthMapScience" value="'.$tenthscoresResults[mapScience].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Math">MAP Math</label><input type="text" name="tenthMapMath" value="'.$tenthscoresResults[mapMath].'" readonly="readonly"></div>';
   echo '</div>';

//End 10th Grade Testing

// Begin 11th Grade Testing
$eleventhscoresQuery = "SELECT eleventhscores.mapLanguage, eleventhscores.mapReading, eleventhscores.mapScience, eleventhscores.mapMath, eleventhscores.actEnglish, eleventhscores.actReading, eleventhscores.actScience, eleventhscores.actMath, eleventhscores.actComposite, eleventhscores.asvab FROM students, eleventhscores WHERE students.state_id = eleventhscores.state_id and students.state_id = '".$stateID."';";
$eleventhscoresResponse = @mysqli_query($dbc, $eleventhscoresQuery);
$eleventhscoresResults = mysqli_fetch_assoc($eleventhscoresResponse);
echo '<div id="eleventhtesting">';
echo '<h1>11th Grade Testing</h1>';
   echo '<div><label for="MAP Language">MAP Language</label><input type="text" name="eleventhMapLanguage" value="'.$eleventhscoresResults[mapLanguage].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Reading">MAP Reading</label><input type="text" name="eleventhMapReading" value="'.$eleventhscoresResults[mapReading].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Science">MAP Science</label><input type="text" name="eleventhMapScience" value="'.$eleventhscoresResults[mapScience].'" readonly="readonly"></div>';
   echo '<div><label for="MAP Math">MAP Math</label><input type="text" name="eleventhMapMath" value="'.$eleventhscoresResults[mapMath].'" readonly="readonly"></div>';
   echo '<div><label for="ACT English">ACT English</label><input type="text" name="eleventhactEnglish" value="'.$eleventhscoresResults[actEnglish].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Reading">ACT Reading</label><input type="text" name="eleventhactReading" value="'.$eleventhscoresResults[actReading].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Science">ACT Science</label><input type="text" name="eleventhactScience" value="'.$eleventhscoresResults[actScience].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Math">ACT Math</label><input type="text" name="eleventhactMath" value="'.$eleventhscoresResults[actMath].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Composite">ACT Composite</label><input type="text" name="eleventhactComposite" value="'.$eleventhscoresResults[actComposite].'" readonly="readonly"></div>';
   echo '<div><label for="ASVAB">ASVAB</label><input type="text" name="eleventhAsvab" value="'.$eleventhscoresResults[asvab].'" readonly="readonly"></div>';
   echo '</div>';

//End 11th Grade Testing

// Begin 12th Grade Testing
$twelfthscoresQuery = "SELECT twelfthscores.actEnglish, twelfthscores.actReading, twelfthscores.actScience, twelfthscores.actMath, twelfthscores.actComposite FROM students, twelfthscores WHERE students.state_id = twelfthscores.state_id and students.state_id = '".$stateID."';";
$twelfthscoresResponse = @mysqli_query($dbc, $twelfthscoresQuery);
$twelfthscoresResults = mysqli_fetch_assoc($twelfthscoresResponse);
echo '<div id="twelfthtesting">';
echo '<h1>12th Grade Testing</h1>';
   echo '<div><label for="ACT English">ACT English</label><input type="text" name="twelfthactEnglish" value="'.$twelfthscoresResults[actEnglish].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Reading">ACT Reading</label><input type="text" name="twelfthactReading" value="'.$twelfthscoresResults[actReading].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Science">ACT Science</label><input type="text" name="twelfthactScience" value="'.$twelfthscoresResults[actScience].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Math">ACT Math</label><input type="text" name="twelfthactMath" value="'.$twelfthscoresResults[actMath].'" readonly="readonly"></div>';
   echo '<div><label for="ACT Composite">ACT Composite</label><input type="text" name="twelfthactComposite" value="'.$twelfthscoresResults[actComposite].'" readonly="readonly"></div>';
   echo '</div>';

//End 12th Grade Testing
echo '</div><div id="right-button2"><img src="/images/right.png" ></div></div><script src="/js/gradescroll.js"></script>';
//End Score Inputs

//Begin Interventions
echo'<div id="Interventionwrapper"><div id="left-button4" class=" dimLeft"><img src="/images/left.png" ></div><div id="InterventionInputs">';
// Begin 7th Grade Interventions
$seventhinterventionQuery = "select * from seventhinterventions where local_id = '".$localID."';";
$seventhinterventionResponse = @mysqli_query($dbc, $seventhinterventionQuery);
$seventhinterventionResults = mysqli_fetch_assoc($seventhinterventionResponse);
$seventhinterventionlistquery = "select seventh from interventionlist;";
$seventhinterventionlistResponse = @mysqli_query($dbc, $seventhinterventionlistquery);
		echo '<div id="seventhintervention">';
					echo '<h1>7th Grade Interventions</h1>
					<label for ="Intervention">Intervention</label><select name ="sevenInterventions1" id="sevenInterventions1">';
						$opt = '<option selected="selected">'.$seventhinterventionResults[intervention1].'</option>';
			   while ($row = mysqli_fetch_assoc($seventhinterventionlistResponse)){
				   if ($row[seventh] == NULL) continue;
			   $opt .= "<option value='{$row['seventh']}'>{$row['seventh']}</option>\n";
			   }
			   $opt .='</select>';
			   echo $opt; 
			   $seventhinterventionlistquery = "select seventh from interventionlist;";
			   $seventhinterventionlistResponse = @mysqli_query($dbc, $seventhinterventionlistquery);
								  echo '<label for ="Intervention">Intervention</label><select name ="sevenInterventions2" id="sevenInterventions2">';
									   $opt = '<option selected="selected">'.$seventhinterventionResults[intervention2].'</option>';
							  while ($row = mysqli_fetch_assoc($seventhinterventionlistResponse)){
								  if ($row[seventh] == NULL) continue;
							  $opt .= "<option value='{$row['seventh']}'>{$row['seventh']}</option>\n";
							  }
							  $opt .='</select>';
							  echo $opt; 
							  $seventhinterventionlistquery = "select seventh from interventionlist;";
							  $seventhinterventionlistResponse = @mysqli_query($dbc, $seventhinterventionlistquery);
												 echo '<label for ="Intervention">Intervention</label><select name ="sevenInterventions3" id="sevenInterventions3">';
													  $opt = '<option selected="selected">'.$seventhinterventionResults[intervention3].'</option>';
											 while ($row = mysqli_fetch_assoc($seventhinterventionlistResponse)){
												 if ($row[seventh] == NULL) continue;
											 $opt .= "<option value='{$row['seventh']}'>{$row['seventh']}</option>\n";
											 }
											 $opt .='</select>';
											 echo $opt; 
			echo'</div>';
//End 7th Grade Interventions
// Begin 8th Grade Interventions
$eighthinterventionQuery = "select * from eighthinterventions where local_id = '".$localID."';";
$eighthinterventionResponse = @mysqli_query($dbc, $eighthinterventionQuery);
$eighthinterventionResults = mysqli_fetch_assoc($eighthinterventionResponse);
$eighthinterventionlistquery = "select eighth from interventionlist;";
$eighthinterventionlistResponse = @mysqli_query($dbc, $eighthinterventionlistquery);
		echo '<div id="eighthintervention">';
					echo '<h1>8th Grade Interventions</h1>
					<label for ="Intervention">Intervention</label><select name ="eightInterventions1" id="eightInterventions1">';
						$opt = '<option selected="selected">'.$eighthinterventionResults[intervention1].'</option>';
			   while ($row = mysqli_fetch_assoc($eighthinterventionlistResponse)){
				   if ($row[eighth] == NULL) continue;
			   $opt .= "<option value='{$row['eighth']}'>{$row['eighth']}</option>\n";
			   }
			   $opt .='</select>';
			   echo $opt; 
			   $eighthinterventionlistquery = "select eighth from interventionlist;";
			   $eighthinterventionlistResponse = @mysqli_query($dbc, $eighthinterventionlistquery);
								  echo '<label for ="Intervention">Intervention</label><select name ="eightInterventions2" id="eightInterventions2">';
									   $opt = '<option selected="selected">'.$eighthinterventionResults[intervention2].'</option>';
							  while ($row = mysqli_fetch_assoc($eighthinterventionlistResponse)){
								  if ($row[eighth] == NULL) continue;
							  $opt .= "<option value='{$row['eighth']}'>{$row['eighth']}</option>\n";
							  }
							  $opt .='</select>';
							  echo $opt; 
							  $eighthinterventionlistquery = "select eighth from interventionlist;";
							  $eighthinterventionlistResponse = @mysqli_query($dbc, $eighthinterventionlistquery);
												 echo '<label for ="Intervention">Intervention</label><select name ="eightInterventions3" id="eightInterventions3">';
													  $opt = '<option selected="selected">'.$eighthinterventionResults[intervention3].'</option>';
											 while ($row = mysqli_fetch_assoc($eighthinterventionlistResponse)){
												 if ($row[eighth] == NULL) continue;
											 $opt .= "<option value='{$row['eighth']}'>{$row['eighth']}</option>\n";
											 }
											 $opt .='</select>';
											 echo $opt; 
			echo'</div>';
//End 8th Grade Interventions
// Begin 9th Grade Interventions
$ninethinterventionQuery = "select * from ninethinterventions where local_id = '".$localID."';";
$ninethinterventionResponse = @mysqli_query($dbc, $ninethinterventionQuery);
$ninethinterventionResults = mysqli_fetch_assoc($ninethinterventionResponse);
$ninethinterventionlistquery = "select nineth from interventionlist;";
$ninethinterventionlistResponse = @mysqli_query($dbc, $ninethinterventionlistquery);
		echo '<div id="ninethintervention">';
					echo '<h1>9th Grade Interventions</h1>
					<label for ="Intervention">Intervention</label><select name ="nineInterventions1" id="nineInterventions1">';
						$opt = '<option selected="selected">'.$ninethinterventionResults[intervention1].'</option>';
			   while ($row = mysqli_fetch_assoc($ninethinterventionlistResponse)){
				   if ($row[nineth] == NULL) continue;
			   $opt .= "<option value='{$row['nineth']}'>{$row['nineth']}</option>\n";
			   }
			   $opt .='</select>';
			   echo $opt; 
			   $ninethinterventionlistquery = "select nineth from interventionlist;";
			   $ninethinterventionlistResponse = @mysqli_query($dbc, $ninethinterventionlistquery);
								  echo '<label for ="Intervention">Intervention</label><select name ="nineInterventions2" id="nineInterventions2">';
									   $opt = '<option selected="selected">'.$ninethinterventionResults[intervention2].'</option>';
							  while ($row = mysqli_fetch_assoc($ninethinterventionlistResponse)){
								  if ($row[nineth] == NULL) continue;
							  $opt .= "<option value='{$row['nineth']}'>{$row['nineth']}</option>\n";
							  }
							  $opt .='</select>';
							  echo $opt; 
			echo'</div>';
//End 9th Grade Interventions

// Begin 10th Grade Interventions
$tenthinterventionQuery = "select * from tenthinterventions where local_id = '".$localID."';";
$tenthinterventionResponse = @mysqli_query($dbc, $tenthinterventionQuery);
$tenthinterventionResults = mysqli_fetch_assoc($tenthinterventionResponse);
$tenthinterventionlistquery = "select tenth from interventionlist;";
$tenthinterventionlistResponse = @mysqli_query($dbc, $tenthinterventionlistquery);
		echo '<div id="tenthintervention">';
					echo '<h1>10th Grade Interventions</h1>
					<label for ="Intervention">Intervention</label><select name ="tenInterventions1" id="tenInterventions1">';
						$opt = '<option selected="selected">'.$tenthinterventionResults[intervention1].'</option>';
			   while ($row = mysqli_fetch_assoc($tenthinterventionlistResponse)){
				   if ($row[tenth] == NULL) continue;
			   $opt .= "<option value='{$row['tenth']}'>{$row['tenth']}</option>\n";
			   }
			   $opt .='</select>';
			   echo $opt; 
			   $tenthinterventionlistquery = "select tenth from interventionlist;";
			   $tenthinterventionlistResponse = @mysqli_query($dbc, $tenthinterventionlistquery);
								  echo '<label for ="Intervention">Intervention</label><select name ="tenInterventions2" id="tenInterventions2">';
									   $opt = '<option selected="selected">'.$tenthinterventionResults[intervention2].'</option>';
							  while ($row = mysqli_fetch_assoc($tenthinterventionlistResponse)){
								  if ($row[tenth] == NULL) continue;
							  $opt .= "<option value='{$row['tenth']}'>{$row['tenth']}</option>\n";
							  }
							  $opt .='</select>';
							  echo $opt; 
							  $tenthinterventionlistquery = "select tenth from interventionlist;";
							  $tenthinterventionlistResponse = @mysqli_query($dbc, $tenthinterventionlistquery);
												 echo '<label for ="Intervention">Intervention</label><select name ="tenInterventions3" id="tenInterventions3">';
													  $opt = '<option selected="selected">'.$tenthinterventionResults[intervention3].'</option>';
											 while ($row = mysqli_fetch_assoc($tenthinterventionlistResponse)){
												 if ($row[tenth] == NULL) continue;
											 $opt .= "<option value='{$row['tenth']}'>{$row['tenth']}</option>\n";
											 }
											 $opt .='</select>';
											 echo $opt; 
											 $tenthinterventionlistquery = "select tenth from interventionlist;";
											 $tenthinterventionlistResponse = @mysqli_query($dbc, $tenthinterventionlistquery);
																echo '<label for ="Intervention">Intervention</label><select name ="tenInterventions4" id="tenInterventions4">';
																	 $opt = '<option selected="selected">'.$tenthinterventionResults[intervention4].'</option>';
															while ($row = mysqli_fetch_assoc($tenthinterventionlistResponse)){
																if ($row[tenth] == NULL) continue;
															$opt .= "<option value='{$row['tenth']}'>{$row['tenth']}</option>\n";
															}
															$opt .='</select>';
															echo $opt; 
			echo'</div>';
//End 10th Grade Interventions

// Begin 11th Grade Interventions
$eleventhinterventionQuery = "select * from eleventhinterventions where local_id = '".$localID."';";
$eleventhinterventionResponse = @mysqli_query($dbc, $eleventhinterventionQuery);
$eleventhinterventionResults = mysqli_fetch_assoc($eleventhinterventionResponse);
$eleventhinterventionlistquery = "select eleventh from interventionlist;";
$eleventhinterventionlistResponse = @mysqli_query($dbc, $eleventhinterventionlistquery);
		echo '<div id="eleventhintervention">';
					echo '<h1>11th Grade Interventions</h1>
					<label for ="Intervention">Intervention</label><select name ="elevenInterventions1" id="elevenInterventions1">';
						$opt = '<option selected="selected">'.$eleventhinterventionResults[intervention1].'</option>';
			   while ($row = mysqli_fetch_assoc($eleventhinterventionlistResponse)){
				   if ($row[eleventh] == NULL) continue;
			   $opt .= "<option value='{$row['eleventh']}'>{$row['eleventh']}</option>\n";
			   }
			   $opt .='</select>';
			   echo $opt; 
			   $eleventhinterventionlistquery = "select eleventh from interventionlist;";
			   $eleventhinterventionlistResponse = @mysqli_query($dbc, $eleventhinterventionlistquery);
								  echo '<label for ="Intervention">Intervention</label><select name ="elevenInterventions2" id="elevenInterventions2">';
									   $opt = '<option selected="selected">'.$eleventhinterventionResults[intervention2].'</option>';
							  while ($row = mysqli_fetch_assoc($eleventhinterventionlistResponse)){
								  if ($row[eleventh] == NULL) continue;
							  $opt .= "<option value='{$row['eleventh']}'>{$row['eleventh']}</option>\n";
							  }
							  $opt .='</select>';
							  echo $opt; 
							  $eleventhinterventionlistquery = "select eleventh from interventionlist;";
							  $eleventhinterventionlistResponse = @mysqli_query($dbc, $eleventhinterventionlistquery);
												 echo '<label for ="Intervention">Intervention</label><select name ="elevenInterventions3" id="elevenInterventions3">';
													  $opt = '<option selected="selected">'.$eleventhinterventionResults[intervention3].'</option>';
											 while ($row = mysqli_fetch_assoc($eleventhinterventionlistResponse)){
												 if ($row[eleventh] == NULL) continue;
											 $opt .= "<option value='{$row['eleventh']}'>{$row['eleventh']}</option>\n";
											 }
											 $opt .='</select>';
											 echo $opt; 
			echo'</div>';
//End 11th Grade Interventions

// Begin 12th Grade Interventions
$twelfthinterventionQuery = "select * from twelfthinterventions where local_id = '".$localID."';";
$twelfthinterventionResponse = @mysqli_query($dbc, $twelfthinterventionQuery);
$twelfthinterventionResults = mysqli_fetch_assoc($twelfthinterventionResponse);
$twelfthinterventionlistquery = "select twelfth from interventionlist;";
$twelfthinterventionlistResponse = @mysqli_query($dbc, $twelfthinterventionlistquery);
		echo '<div id="twelfthintervention">';
					echo '<h1>12th Grade Interventions</h1>
					<label for ="Intervention">Intervention</label><select name ="twelveInterventions1" id="twelveInterventions1">';
						$opt = '<option selected="selected">'.$twelfthinterventionResults[intervention1].'</option>';
			   while ($row = mysqli_fetch_assoc($twelfthinterventionlistResponse)){
				   if ($row[twelfth] == NULL) continue;
			   $opt .= "<option value='{$row['twelfth']}'>{$row['twelfth']}</option>\n";
			   }
			   $opt .='</select>';
			   echo $opt; 
			   $twelfthinterventionlistquery = "select twelfth from interventionlist;";
			   $twelfthinterventionlistResponse = @mysqli_query($dbc, $twelfthinterventionlistquery);
								  echo '<label for ="Intervention">Intervention</label><select name ="twelveInterventions2" id="twelveInterventions2">';
									   $opt = '<option selected="selected">'.$twelfthinterventionResults[intervention2].'</option>';
							  while ($row = mysqli_fetch_assoc($twelfthinterventionlistResponse)){
								  if ($row[twelfth] == NULL) continue;
							  $opt .= "<option value='{$row['twelfth']}'>{$row['twelfth']}</option>\n";
							  }
							  $opt .='</select>';
							  echo $opt; 
							  $twelfthinterventionlistquery = "select twelfth from interventionlist;";
							  $twelfthinterventionlistResponse = @mysqli_query($dbc, $twelfthinterventionlistquery);
												 echo '<label for ="Intervention">Intervention</label><select name ="twelveInterventions3" id="twelveInterventions3">';
													  $opt = '<option selected="selected">'.$twelfthinterventionResults[intervention3].'</option>';
											 while ($row = mysqli_fetch_assoc($twelfthinterventionlistResponse)){
												 if ($row[twelfth] == NULL) continue;
											 $opt .= "<option value='{$row['twelfth']}'>{$row['twelfth']}</option>\n";
											 }
											 $opt .='</select>';
											 echo $opt; 
			echo'</div>';
//End 12th Grade Interventions

 			echo '</div><div id="right-button4"><img src="/images/right.png" ></div></div><script src="/js/gradescroll.js"></script>';

//Begin Career Development
	echo '<div id="careerandcollegereadiness">';
		echo '<h1>Career & College Readiness</h1>';
//Begin Vocational Plan
echo '<div id="myvocationalplan">';
	echo '<h1>My Vocational Plan</h1>';
	echo '<p class="tagline">The path to your career begins with high school coursework.</p>';
	echo '<p class="tagline">Directions: Use the guide below to list your career focus and record the courses you have taken each year that are related to your chosen career. Also select any certifications you have obtained.</p>';
	echo '<div id="careerwrapper">';

//Begin Career Focus
$vocationalplanQuery = "select * from vocationalplan where local_id = '".$localID."';";
$vocationalplanResponse = @mysqli_query($dbc, $vocationalplanQuery);
$vocationalplanResults = mysqli_fetch_assoc($vocationalplanResponse);
echo '<div id="careerfocus">
		<h4>Career Focus</h4><input type="text" name="CareerFocus" value="'.$vocationalplanResults[careerFocus].'">
	 </div>';
//End Career Focus
//Begin Supporting Courses
echo '<div id="supportingcourses">';
echo '<h2>Supporting Courses Taken</h2>';
echo '<div id="supportingcourseswrapper">';
//Begin 9th Supporting
$ninethsupportingQuery = "select * from ninethsupporting where local_id = '".$localID."';";
$ninethsupportingResponse = @mysqli_query($dbc, $ninethsupportingQuery);
$ninethsupportingResults = mysqli_fetch_assoc($ninethsupportingResponse);
			echo '<div id= "ninethsupporting">
					<h4>9th Grade Courses</h4>';
					echo '<div><input type="text" name="ninesupporting1" value="'.$ninethsupportingResults[supportingCourse1].'"></div>';
					echo '<div><input type="text" name="ninesupporting2" value="'.$ninethsupportingResults[supportingCourse2].'"></div>';
					echo '<div><input type="text" name="ninesupporting3" value="'.$ninethsupportingResults[supportingCourse3].'"></div>';
			echo '</div>';
//End 9th Supporting

//Begin 10th Supporting
$tenthsupportingQuery = "select * from tenthsupporting where local_id = '".$localID."';";
$tenthsupportingResponse = @mysqli_query($dbc, $tenthsupportingQuery);
$tenthsupportingResults = mysqli_fetch_assoc($tenthsupportingResponse);
			echo '<div id= "tenthsupporting">
					<h4>10th Grade Courses</h4>';
					echo '<div><input type="text" name="tensupporting1" value="'.$tenthsupportingResults[supportingCourse1].'"></div>';
					echo '<div><input type="text" name="tensupporting2" value="'.$tenthsupportingResults[supportingCourse2].'"></div>';
					echo '<div><input type="text" name="tensupporting3" value="'.$tenthsupportingResults[supportingCourse3].'"></div>';
			echo '</div>';
//End 10th Supporting

//Begin 11th Supporting
$eleventhsupportingQuery = "select * from eleventhsupporting where local_id = '".$localID."';";
$eleventhsupportingResponse = @mysqli_query($dbc, $eleventhsupportingQuery);
$eleventhsupportingResults = mysqli_fetch_assoc($eleventhsupportingResponse);
			echo '<div id= "eleventhsupporting">
					<h4>11th Grade Courses</h4>';
					echo '<div><input type="text" name="elevensupporting1" value="'.$eleventhsupportingResults[supportingCourse1].'"></div>';
					echo '<div><input type="text" name="elevensupporting2" value="'.$eleventhsupportingResults[supportingCourse2].'"></div>';
					echo '<div><input type="text" name="elevensupporting3" value="'.$eleventhsupportingResults[supportingCourse3].'"></div>';
			echo '</div>';
//End 11th Supporting

//Begin 12th Supporting
$twelfthsupportingQuery = "select * from twelfthsupporting where local_id = '".$localID."';";
$twelfthsupportingResponse = @mysqli_query($dbc, $twelfthsupportingQuery);
$twelfthsupportingResults = mysqli_fetch_assoc($twelfthsupportingResponse);
			echo '<div id= "twelfthsupporting">
					<h4>12th Grade Courses</h4>';
					echo '<div><input type="text" name="twelvesupporting1" value="'.$twelfthsupportingResults[supportingCourse1].'"></div>';
					echo '<div><input type="text" name="twelvesupporting2" value="'.$twelfthsupportingResults[supportingCourse2].'"></div>';
					echo '<div><input type="text" name="twelvesupporting3" value="'.$twelfthsupportingResults[supportingCourse3].'"></div>';
			echo '</div>';
//End 12th Supporting
echo '</div>';
//End Supporting Courses


echo'</div>';
//Begin Certification Div
$certearnedQuery = "select * from certificationsearned where local_id = '".$localID."';";
$certearnedResponse = @mysqli_query($dbc, $certearnedQuery);
$certearnedResults = mysqli_fetch_assoc($certearnedResponse);
$certlistquery = "select * from certificationsList;";
$certlistResponse = @mysqli_query($dbc, $certlistquery);
				echo'<div id="certs-wrapper"><h4>I have the following certifications:</h4>
						<select name="CertificationsEarned1" id="certgoals1">';

						$opt = '<option selected="selected">'.$certearnedResults[certsEarned1].'</option>';
			   while ($row = mysqli_fetch_assoc($certlistResponse)){
				   if ($row[certification] == NULL) continue;
			   $opt .= "<option value='{$row['certification']}'>{$row['certification']}</option>\n";
			   }
			   $opt .='</select>';
			   echo $opt; 
			   $certlistquery = "select * from certificationsList;";
			   $certlistResponse = @mysqli_query($dbc, $certlistquery);
						$opt = '<select name="CertificationsEarned2" id="certgoals2">
 								 	<option selected="selected">'.$certearnedResults[certsEarned2].'</option>';
									  while ($row = mysqli_fetch_assoc($certlistResponse)){
										if ($row[certification] == NULL) continue;
									$opt .= "<option value='{$row['certification']}'>{$row['certification']}</option>\n";
									}
									$opt .='</select>';
									echo $opt;
									$certlistquery = "select * from certificationsList;";
									$certlistResponse = @mysqli_query($dbc, $certlistquery);
						$opt = '<select name="CertificationsEarned3" id="certgoals2">
 								 	<option selected="selected">'.$certearnedResults[certsEarned3].'</option>';
									  while ($row = mysqli_fetch_assoc($certlistResponse)){
										if ($row[certification] == NULL) continue;
									$opt .= "<option value='{$row['certification']}'>{$row['certification']}</option>\n";
									}
									$opt .='</select></div>';
									echo $opt;
//End Certification Div
			echo'</div>';
			echo'</div>';
//End Vocational Plan
//Begin Resume Building
echo'<div id="resumebuilding">';
		echo'<h2>Resume Builder</h2>';
		echo'<p>The items below will be helpful when you need to create your resume and when filling out job or scholarship applications.</p>';
		echo'<div id="resumebuttonwrap"><div id="left-button3" class=" dimLeft"><img src="/images/left.png" ></div><div id="resumewrapper">';
//Begin 7th Resume
echo'<div id="seventhresume">';
echo'<h2>7th Grade</h2>';
//Begin 7th Activities
$seventhResumeQuery = "select * from seventhresume where local_id = '".$localID."';";
$seventhResumeResponse = @mysqli_query($dbc, $seventhResumeQuery);
$seventhResumeResults = mysqli_fetch_assoc($seventhResumeResponse);
			echo '<div id= "seventhactivities">
					<h4>Activities</h4>';
					echo '<div><input type="text" name="sevenactivity1" value="'.$seventhResumeResults[activity1].'"></div>';
					echo '<div><input type="text" name="sevenactivity2" value="'.$seventhResumeResults[activity2].'"></div>';
			echo '</div>';
//End 7th Activities
//Begin 7th Honors
			echo '<div id= "seventhhonors">
					<h4>Honors</h4>';
					echo '<div><input type="text" name="sevenhonors1" value="'.$seventhResumeResults[honors2].'"></div>';
					echo '<div><input type="text" name="sevenhonors2" value="'.$seventhResumeResults[honors2].'"></div>';
			echo '</div>';
//End 7th Honors
//Begin 7th Community Service
			echo '<div id= "seventhservice">
					<h4>Community Service</h4>';
					echo '<div><input type="text" name="sevencomservice1" value="'.$seventhResumeResults[communityService1].'"></div>';
					echo '<div><input type="text" name="sevencomservice2" value="'.$seventhResumeResults[communityService2].'"></div>';
			echo '</div>';
//End 7th Community Service

echo'</div>';
//End 7th Resume


//Begin 8th Resume
echo'<div id="eighthresume">';
echo'<h2>8th Grade</h2>';
//Begin 8th Activities
$eighthResumeQuery = "select * from eighthresume where local_id = '".$localID."';";
$eighthResumeResponse = @mysqli_query($dbc, $eighthResumeQuery);
$eighthResumeResults = mysqli_fetch_assoc($eighthResumeResponse);
			echo '<div id= "eighthactivities">
					<h4>Activities</h4>';
					echo '<div><input type="text" name="eightactivity1" value="'.$eighthResumeResults[activity1].'"></div>';
					echo '<div><input type="text" name="eightactivity2" value="'.$eighthResumeResults[activity2].'"></div>';
			echo '</div>';
//End 8th Activities
//Begin 8th Honors
			echo '<div id= "eighthhonors">
					<h4>Honors</h4>';
					echo '<div><input type="text" name="eighthonors1" value="'.$eighthResumeResults[honors2].'"></div>';
					echo '<div><input type="text" name="eighthonors2" value="'.$eighthResumeResults[honors2].'"></div>';
			echo '</div>';
//End 8th Honors
//Begin 8th GPA
echo'<div id="eighthgpa">
			<h4>GPA</h4>
			<p>Only include high school courses</p>';
			echo'<div><label for="GPA SEM 1">GPA SEM 1 </label><input type="text" name="eightgpaSem1" value="'.$eighthResumeResults[gpaSem1].'"></div>
			<div><label for="GPA SEM 2">GPA SEM 2 </label><input type="text" name="eightgpaSem2" value="'.$eighthResumeResults[gpaSem2].'"></div>
			<div><label for="Cumulative">Cumulative </label><input type="text" name="eightcumulativeGpa" value="'.$eighthResumeResults[cumulativeGpa].'"></div>
			</div>';
//End 8th GPA
//Begin 8th Community Service
			echo '<div id= "eighthservice">
					<h4>Community Service</h4>';
					echo '<div><input type="text" name="eightcomservice1" value="'.$eighthResumeResults[communityService1].'"></div>';
					echo '<div><input type="text" name="eightcomservice2" value="'.$eighthResumeResults[communityService2].'"></div>';
			echo '</div>';
//End 8th Community Service

echo'</div>';
//End 8th Resume

//Begin 9th Resume
echo'<div id="ninethresume">';
echo'<h2>9th Grade</h2>';
//Begin 9th Activities
$ninethResumeQuery = "select * from ninethresume where local_id = '".$localID."';";
$ninethResumeResponse = @mysqli_query($dbc, $ninethResumeQuery);
$ninethResumeResults = mysqli_fetch_assoc($ninethResumeResponse);
			echo '<div id= "ninethactivities">
					<h4>Activities</h4>';
					echo '<div><input type="text" name="nineactivity1" value="'.$ninethResumeResults[activity1].'"></div>';
					echo '<div><input type="text" name="nineactivity2" value="'.$ninethResumeResults[activity2].'"></div>';
			echo '</div>';
//End 9th Activities
//Begin 9th Honors
			echo '<div id= "ninethhonors">
					<h4>Honors</h4>';
					echo '<div><input type="text" name="ninehonors1" value="'.$ninethResumeResults[honors2].'"></div>';
					echo '<div><input type="text" name="ninehonors2" value="'.$ninethResumeResults[honors2].'"></div>';
			echo '</div>';
//End 9th Honors
//Begin 9th GPA
echo'<div id="ninethgpa">
			<h4>GPA</h4>
			<p>Only include high school courses</p>';
			echo'<div><label for="GPA SEM 1">GPA SEM 1 </label><input type="text" name="ninegpaSem1" value="'.$ninethResumeResults[gpaSem1].'"></div>
			<div><label for="GPA SEM 2">GPA SEM 2 </label><input type="text" name="ninegpaSem2" value="'.$ninethResumeResults[gpaSem2].'"></div>
			<div><label for="Cumulative">Cumulative </label><input type="text" name="ninecumulativeGpa" value="'.$ninethResumeResults[cumulativeGpa].'"></div>
			</div>';
//End 9th GPA
//Begin 9th Class Rank
echo'<div id="ninethrank">
			<h4>Class Rank</h4>';
			echo '<div><input type="text" name="nineclassRank" value="'.$ninethResumeResults[classRank].'"></div>';
		echo '</div>';
//End 9th Class Rank
//Begin 9th Community Service
			echo '<div id= "ninethservice">
					<h4>Community Service</h4>';
					echo '<div><input type="text" name="ninecomservice1" value="'.$ninethResumeResults[communityService1].'"></div>';
					echo '<div><input type="text" name="ninecomservice2" value="'.$ninethResumeResults[communityService2].'"></div>';
			echo '</div>';
//End 9th Community Service

echo'</div>';
//End 9th Resume

//Begin 10th Resume
echo'<div id="tenthresume">';
echo'<h2>10th Grade</h2>';
//Begin 10th Activities
$tenthResumeQuery = "select * from tenthresume where local_id = '".$localID."';";
$tenthResumeResponse = @mysqli_query($dbc, $tenthResumeQuery);
$tenthResumeResults = mysqli_fetch_assoc($tenthResumeResponse);
			echo '<div id= "tenthactivities">
					<h4>Activities</h4>';
					echo '<div><input type="text" name="tenactivity1" value="'.$tenthResumeResults[activity1].'"></div>';
					echo '<div><input type="text" name="tenactivity2" value="'.$tenthResumeResults[activity2].'"></div>';
			echo '</div>';
//End 10th Activities
//Begin 10th Honors
			echo '<div id= "tenthhonors">
					<h4>Honors</h4>';
					echo '<div><input type="text" name="tenhonors1" value="'.$tenthResumeResults[honors2].'"></div>';
					echo '<div><input type="text" name="tenhonors2" value="'.$tenthResumeResults[honors2].'"></div>';
			echo '</div>';
//End 10th Honors
//Begin 10th GPA
echo'<div id="tenthgpa">
			<h4>GPA</h4>
			<p>Only include high school courses</p>';
			echo'<div><label for="GPA SEM 1">GPA SEM 1 </label><input type="text" name="tengpaSem1" value="'.$tenthResumeResults[gpaSem1].'"></div>
			<div><label for="GPA SEM 2">GPA SEM 2 </label><input type="text" name="tengpaSem2" value="'.$tenthResumeResults[gpaSem2].'"></div>
			<div><label for="Cumulative">Cumulative </label><input type="text" name="tencumulativeGpa" value="'.$tenthResumeResults[cumulativeGpa].'"></div>
			</div>';
//End 10th GPA
//Begin 10th Class Rank
echo'<div id="tenthrank">
			<h4>Class Rank</h4>';
			echo '<div><input type="text" name="tenclassRank" value="'.$tenthResumeResults[classRank].'"></div>';
		echo '</div>';
//End 10th Class Rank
//Begin 10th Community Service
			echo '<div id= "tenthservice">
					<h4>Community Service</h4>';
					echo '<div><input type="text" name="tencomservice1" value="'.$tenthResumeResults[communityService1].'"></div>';
					echo '<div><input type="text" name="tencomservice2" value="'.$tenthResumeResults[communityService2].'"></div>';
			echo '</div>';
//End 10th Community Service

echo'</div>';
//End 10th Resume

//Begin 11th Resume
echo'<div id="eleventhresume">';
echo'<h2>11th Grade</h2>';
//Begin 11th Activities
$eleventhResumeQuery = "select * from eleventhresume where local_id = '".$localID."';";
$eleventhResumeResponse = @mysqli_query($dbc, $eleventhResumeQuery);
$eleventhResumeResults = mysqli_fetch_assoc($eleventhResumeResponse);
			echo '<div id= "eleventhactivities">
					<h4>Activities</h4>';
					echo '<div><input type="text" name="elevenactivity1" value="'.$eleventhResumeResults[activity1].'"></div>';
					echo '<div><input type="text" name="elevenactivity2" value="'.$eleventhResumeResults[activity2].'"></div>';
			echo '</div>';
//End 11th Activities
//Begin 11th Honors
			echo '<div id= "eleventhhonors">
					<h4>Honors</h4>';
					echo '<div><input type="text" name="elevenhonors1" value="'.$eleventhResumeResults[honors2].'"></div>';
					echo '<div><input type="text" name="elevenhonors2" value="'.$eleventhResumeResults[honors2].'"></div>';
			echo '</div>';
//End 11th Honors
//Begin 11th GPA
echo'<div id="eleventhgpa">
			<h4>GPA</h4>
			<p>Only include high school courses</p>';
			echo'<div><label for="GPA SEM 1">GPA SEM 1 </label><input type="text" name="elevengpaSem1" value="'.$eleventhResumeResults[gpaSem1].'"></div>
			<div><label for="GPA SEM 2">GPA SEM 2 </label><input type="text" name="elevengpaSem2" value="'.$eleventhResumeResults[gpaSem2].'"></div>
			<div><label for="Cumulative">Cumulative </label><input type="text" name="elevencumulativeGpa" value="'.$eleventhResumeResults[cumulativeGpa].'"></div>
			</div>';
//End 11th GPA
//Begin 11th Class Rank
echo'<div id="eleventhrank">
			<h4>Class Rank</h4>';
			echo '<div><input type="text" name="elevenclassRank" value="'.$eleventhResumeResults[classRank].'"></div>';
		echo '</div>';
//End 11th Class Rank
//Begin 11th Community Service
			echo '<div id= "eleventhservice">
					<h4>Community Service</h4>';
					echo '<div><input type="text" name="elevencomservice1" value="'.$eleventhResumeResults[communityService1].'"></div>';
					echo '<div><input type="text" name="elevencomservice2" value="'.$eleventhResumeResults[communityService2].'"></div>';
			echo '</div>';
//End 11th Community Service

echo'</div>';
//End 11th Resume

//Begin 12th Resume
echo'<div id="twelfthresume">';
echo'<h2>12th Grade</h2>';
//Begin 12th Activities
$twelfthResumeQuery = "select * from twelfthresume where local_id = '".$localID."';";
$twelfthResumeResponse = @mysqli_query($dbc, $twelfthResumeQuery);
$twelfthResumeResults = mysqli_fetch_assoc($twelfthResumeResponse);
			echo '<div id= "twelfthactivities">
					<h4>Activities</h4>';
					echo '<div><input type="text" name="twelveactivity1" value="'.$twelfthResumeResults[activity1].'"></div>';
					echo '<div><input type="text" name="twelveactivity2" value="'.$twelfthResumeResults[activity2].'"></div>';
			echo '</div>';
//End 12th Activities
//Begin 12th Honors
			echo '<div id= "twelfthhonors">
					<h4>Honors</h4>';
					echo '<div><input type="text" name="twelvehonors1" value="'.$twelfthResumeResults[honors2].'"></div>';
					echo '<div><input type="text" name="twelvehonors2" value="'.$twelfthResumeResults[honors2].'"></div>';
			echo '</div>';
//End 12th Honors
//Begin 12th GPA
echo'<div id="twelfthgpa">
			<h4>GPA</h4>
			<p>Only include high school courses</p>';
			echo'<div><label for="GPA SEM 1">GPA SEM 1 </label><input type="text" name="twelvegpaSem1" value="'.$twelfthResumeResults[gpaSem1].'"></div>
			<div><label for="GPA SEM 2">GPA SEM 2 </label><input type="text" name="twelvegpaSem2" value="'.$twelfthResumeResults[gpaSem2].'"></div>
			<div><label for="Cumulative">Cumulative </label><input type="text" name="twelvecumulativeGpa" value="'.$twelfthResumeResults[cumulativeGpa].'"></div>
			</div>';
//End 12th GPA
//Begin 12th Class Rank
echo'<div id="twelfthrank">
			<h4>Class Rank</h4>';
			echo '<div><input type="text" name="twelveclassRank" value="'.$twelfthResumeResults[classRank].'"></div>';
		echo '</div>';
//End 12th Class Rank
//Begin 12th Community Service
			echo '<div id= "twelfthservice">
					<h4>Community Service</h4>';
					echo '<div><input type="text" name="twelvecomservice1" value="'.$twelfthResumeResults[communityService1].'"></div>';
					echo '<div><input type="text" name="twelvecomservice2" value="'.$twelfthResumeResults[communityService2].'"></div>';
			echo '</div>';
//End 12th Community Service

echo'</div>';
//End 12th Resume
echo'</div>';
echo'<div id="right-button3"><img src="/images/right.png" ></div><script src="/js/gradescroll.js"></script>';
echo'</div>';
echo'</div>';
//End Resume Building


//Begin Career Readiness
echo'<div id="careerreadiness">';
			echo '<h1>My Plan for Career Readiness</h1>';
			echo '<p>Many students choose to attend vocational programs after high school for well-paid, high-need technical jobs. Community colleges & trade schools offer great preparation opportunities. Some students choose to join the armed services or seek employment. Please use the resources below to help plan for your life after high school even if you do not plan to go directly to a 4-year college.</p>';
echo'<div id="future">';
		echo'<div id="careerexpwrapper">';
		echo'<div id="careerexploration">';
			echo '<h3>Career Exploration</h3>';
			echo '<p>Many students often do not know what career pathway to choose while in high school. We strongly encourage all students to sign up for an ACT profile account and explore career interests and opportunities.</p>';
		echo '</div>';
//Begin Additional Resources
echo'<div id="careerexploration-resources">
<h4>Additional Resources</h4>';
$careerExplorationResourceQuery = "select careerExplorationTitle, careerExplorationLink from additionalresources;";
$careerExplorationResourceResponse = @mysqli_query($dbc, $careerExplorationResourceQuery);
$opt = '<ul>';
while ($row = mysqli_fetch_assoc($careerExplorationResourceResponse)){
   if ($row[careerExplorationTitle] == NULL) continue;
$opt .= "<li><a href='{$row['careerExplorationLink']}' target='_blank'>{$row['careerExplorationTitle']}</a></li>\n";
}
$opt .='</ul></div>';
echo $opt;
echo '</div>';
//End Additional Resources






//Begin College Readiness
echo'<div id="collegereadiness">';
//Begin College Choices
$careerreadinessQuery = "select * from careerreadiness where local_id = '".$localID."';";
$careerreadinessResponse = @mysqli_query($dbc, $careerreadinessQuery);
$careerreadinessResults = mysqli_fetch_assoc($careerreadinessResponse);
							echo '<div id= "collegechoices">
									<h3>Top College Choices</h3>
									<p>List below your top 3 choices:</>';
									echo '<div><input type="text" name="college1" value="'.$careerreadinessResults[college1].'"></div>';
									echo '<div><input type="text" name="college2" value="'.$careerreadinessResults[college2].'"></div>';
									echo '<div><input type="text" name="college3" value="'.$careerreadinessResults[college3].'"></div>';
									echo '</div>';
//End College Choices
//Begin Additional Resources
 			echo'<div id="collegereadiness-resources">
 					<h4>Additional Resources</h4>';
$collegeResourceQuery = "select collegeTitle, collegeLink from additionalresources;";
$collegeResourceResponse = @mysqli_query($dbc, $collegeResourceQuery);
					 $opt = '<ul>';
					 while ($row = mysqli_fetch_assoc($collegeResourceResponse)){
						if ($row[collegeTitle] == NULL) continue;
					 $opt .= "<li><a href='{$row['collegeLink']}' target='_blank'>{$row['collegeTitle']}</a></li>\n";
					 }
					 $opt .='</ul></div>';
					 echo $opt;
//End Additional Resources
echo'</div>';
//End College Readiness



//Begin Armed Services Readiness
echo'<div id="armedservicesreadiness">';
//Begin Armed Service Branch Selection
				echo'<div id="armedservices">
							<h3>Armed Services</h3>
							<p>List below the branch you would like to join:</p>';
							echo '<div><input type="text" name="armedServicesBranch" value="'.$careerreadinessResults[armedServicesBranch].'"></div>';

				echo'</div>';
//End Armed Service Branch Selection
//Begin Additional Resources
 			echo'<div id="armedservices-resources">
 					<h4>Additional Resources</h4>';
$armedServicesResourceQuery = "select armedServicesTitle, armedServicesLink from additionalresources;";
$armedServicesResourceResponse = @mysqli_query($dbc, $armedServicesResourceQuery);
					  $opt = '<ul>';
					  while ($row = mysqli_fetch_assoc($armedServicesResourceResponse)){
						 if ($row[armedServicesTitle] == NULL) continue;
						  $opt .= "<li><a href='{$row['armedServicesLink']}' target='_blank'>{$row['armedServicesTitle']}</a></li>\n";
					  }
					  $opt .='</ul></div>';
					  echo $opt;
//End Additional Resources
echo'</div>';
//End Armed Services Readiness



//Begin Vocational Trade Readiness
echo'<div id="tradereadiness">';
//Begin Vocational Trade Selection
				echo'<div id="tradeprogram">
							<h3>Vocational / Trade Program</h3>
							<p>List below your plan after high school to make sure you have the training / education for your desired field:</p>';
							echo '<div><input type="text" name="vocationTrade" value="'.$careerreadinessResults[vocationTrade].'"></div>';
//End Vocational Trade Selection
//Begin Additional Resources
 			echo'<div id="tradeprogram-resources">
 					<h4>Additional Resources</h4>';
$vocationalResourceQuery = "select vocationalTitle, vocationalLink from additionalresources;";
$vocationalResourceResponse = @mysqli_query($dbc, $vocationalResourceQuery);
					   $opt = '<ul>';
					   while ($row = mysqli_fetch_assoc($vocationalResourceResponse)){
						  if ($row[vocationalTitle] == NULL) continue;
							   $opt .= "<li><a href='{$row['vocationalLink']}' target='_blank'>{$row['vocationalTitle']}</a></li>\n";
						   }
					   $opt .='</ul></div>';
					   echo $opt;
echo'</div>';
//End Additional Resources
echo'</div>';
//End Vocational Trade Readiness




//Begin Employment Readiness
echo'<div id="employmentreadiness">';
//Begin Employment Selection
				echo'<div id="employment">
							<h3>Employment</h3>
							<p>List below the job / industry you plan to join:</p>';
							echo '<div><input type="text" name="employmentIndustry" value="'.$careerreadinessResults[employmentIndustry].'"></div>';
//End Employment Selection
//Begin Additional Resources
 			echo'<div id="employment-resources">
 					<h4>Additional Resources</h4>';
$employmentResourceQuery = "select employmentTitle, employmentLink from additionalresources;";
$employmentResourceResponse = @mysqli_query($dbc, $employmentResourceQuery);
						$opt = '<ul>';
						while ($row = mysqli_fetch_assoc($employmentResourceResponse)){
						   if ($row[employmentTitle] == NULL) continue;
							$opt .= "<li><a href='{$row['employmentLink']}' target='_blank'>{$row['employmentTitle']}</a></li>\n";
						}
						$opt .='</ul></div>';
						echo $opt;
//End Additional Resources
echo'</div>';
//End Employment Readiness


echo'</div>';
echo'</div>';
//End Career Readiness
//Begin Trade School Note
		echo'<div id="tradeschoolnotice">';
			echo '<p>Note to students: Though there are many for-profit trade & vocational schools that offer training programs, we encourage students to research local community colleges that offer the same programs for significantly less money and are accredited. Units earned in community college programs are most often transferrable to 4-year colleges & universities.</p>';
		echo '</div>';
//End Trade School Note
echo'</div>';
//End Career Development
//Nothing after the next 3 lines.  This ends the primary script, and anything submitted must be contained within the <form></form> tags.
	echo '<br><br><input type="submit" value="Save Your Plan">
 </form>
</div>';
echo '</div></body></html>';
} else {


echo'<html><head><link rel="stylesheet" type="text/css" href="css/style.css"><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"><body><div id="badpassword"><div><i class="fas fa-arrow-up"></i><p>Please select a student from the dropdown list above to get started!</p></div></div>';


}
?>