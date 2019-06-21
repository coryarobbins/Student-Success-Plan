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
$localID = $_POST[row];
$stateID = $_POST[stateid];
$row = ($_POST['row']);
$statusQuery = "select * from sessions where local_id = ".$localID.";";
$statusResponse = @mysqli_query($dbc, $statusQuery);
while ($sessionCheck = mysqli_fetch_assoc($statusResponse)){

if($sessionCheck[isActive] == "MENTOR")
{
	    $anotherdevice = 'Sorry, but your Student Success Plan is currently being edited by your Mentor.  Please either try to make your changes later, or go and speak with your Mentor.';
          $_SESSION['error'] = $anotherdevice;     
          echo "<script type='text/javascript'>alert('$anotherdevice');</script>";
   		header( "refresh:0;url=index.php" );
   		exit;
}

if($sessionCheck[isLocked] == "YES")
{
      $anotherdevice = 'Sorry, but your Student Success Plan is currently locked to prevent changes.  Speak with your mentor if you need to edit.';
      $_SESSION['error'] = $anotherdevice;
      echo "<script type='text/javascript'>alert('$anotherdevice');</script>";
      header( "refresh:0;url=index.php" );
      exit;
}
}
$sqlUpdateQuery = "update students set students.last_updated=NOW() where students.local_id = ".$localID.";update sessions set sessions.isActive='NO' where sessions.local_id = ".$localID.";update seventhcourses set seventhcourses.english='".$_POST[seventhEnglish]."',seventhcourses.math='".$_POST[seventhmath]."',seventhcourses.science='".$_POST[seventhscience]."',seventhcourses.socialStudies='".$_POST[seventhsocialStudies]."',seventhcourses.technology='".$_POST[seventhtechnology]."',seventhcourses.electiveOne='".$_POST[electiveOne]."',seventhcourses.electiveTwo='".$_POST[electiveTwo]."',seventhcourses.activity='".$_POST[sevenactivity]."' where seventhcourses.local_id = ".$localID.";update eighthcourses set eighthcourses.english='".$_POST[eighthEnglish]."',eighthcourses.math='".$_POST[eighthmath]."',eighthcourses.science='".$_POST[eighthscience]."',eighthcourses.socialStudies='".$_POST[eighthsocialStudies]."',eighthcourses.technology='".$_POST[eighthtechnology]."',eighthcourses.electiveOne='".$_POST[eightelectiveOne]."',eighthcourses.electiveTwo='".$_POST[eightelectiveTwo]."',eighthcourses.activity='".$_POST[eightactivity]."',eighthcourses.other='".$_POST[eightother]."' where eighthcourses.local_id = ".$localID.";update ninethcourses set ninethcourses.english='".$_POST[ninethEnglish]."',ninethcourses.math='".$_POST[ninethmath]."',ninethcourses.science='".$_POST[ninethscience]."',ninethcourses.health='".$_POST[ninethHealth]."',ninethcourses.electiveOne='".$_POST[nineelectiveOne]."',ninethcourses.electiveTwo='".$_POST[nineelectiveTwo]."',ninethcourses.electiveThree='".$_POST[nineelectiveThree]."',ninethcourses.electiveFour='".$_POST[nineelectiveFour]."',ninethcourses.other='".$_POST[nineother]."',ninethcourses.credits='".$_POST[ninecredits]."' where ninethcourses.local_id = ".$localID.";update tenthcourses set tenthcourses.english='".$_POST[tenthEnglish]."',tenthcourses.math='".$_POST[tenthmath]."',tenthcourses.science='".$_POST[tenthscience]."',tenthcourses.socialStudies='".$_POST[tenthsocialStudies]."',tenthcourses.electiveOne='".$_POST[tenelectiveOne]."',tenthcourses.electiveTwo='".$_POST[tenelectiveTwo]."',tenthcourses.electiveThree='".$_POST[tenelectiveThree]."',tenthcourses.electiveFour='".$_POST[tenelectiveFour]."',tenthcourses.other='".$_POST[tenother]."',tenthcourses.courseRetakes='".$_POST[tenretakes]."',tenthcourses.credits='".$_POST[tencredits]."' where tenthcourses.local_id = ".$localID.";update eleventhcourses set eleventhcourses.english='".$_POST[eleventhEnglish]."',eleventhcourses.math='".$_POST[eleventhmath]."',eleventhcourses.science='".$_POST[eleventhscience]."',eleventhcourses.socialStudies='".$_POST[eleventhsocialStudies]."',eleventhcourses.electiveOne='".$_POST[elevenelectiveOne]."',eleventhcourses.electiveTwo='".$_POST[elevenelectiveTwo]."',eleventhcourses.electiveThree='".$_POST[elevenelectiveThree]."',eleventhcourses.electiveFour='".$_POST[elevenelectiveFour]."',eleventhcourses.other='".$_POST[elevenother]."',eleventhcourses.courseRetakes='".$_POST[elevenretakes]."',eleventhcourses.credits='".$_POST[elevencredits]."' where eleventhcourses.local_id = ".$localID.";update twelfthcourses set twelfthcourses.english='".$_POST[twelfthEnglish]."',twelfthcourses.math='".$_POST[twelfthmath]."',twelfthcourses.science='".$_POST[twelfthscience]."',twelfthcourses.socialStudies='".$_POST[twelfthsocialStudies]."',twelfthcourses.electiveOne='".$_POST[twelveelectiveOne]."',twelfthcourses.electiveTwo='".$_POST[twelveelectiveTwo]."',twelfthcourses.electiveThree='".$_POST[twelveelectiveThree]."',twelfthcourses.electiveFour='".$_POST[twelveelectiveFour]."',twelfthcourses.other='".$_POST[twelveother]."',twelfthcourses.courseRetakes='".$_POST[twelveretakes]."',twelfthcourses.credits='".$_POST[twelvecredits]."' where twelfthcourses.local_id = ".$localID.";update creditcalcs set creditcalcs.eighthHS=".$_POST[eightthHsCredits].",creditcalcs.totalCollege=".$_POST[CollegeCredits].",creditcalcs.totalHS=".$_POST[Total_Credits]." where creditcalcs.local_id = ".$localID.";update goalplanning set goalplanning.collegeObjective='".$_POST[College_Objectives]."',goalplanning.vocationalObjective='".$_POST[Vocational_Objectives]."',goalplanning.strongestArea='".$_POST[strongestarea]."',goalplanning.weakestArea='".$_POST[weakestarea]."',goalplanning.improvementGoal='".$_POST[My_Improvement_Goal]."' where goalplanning.local_id = ".$localID.";update designations set designations.gt='".$_POST[GT]."',designations.504='".$_POST[504]."',designations.iep='".$_POST[IEP]."',designations.ell='".$_POST[ELL]."',designations.speechServices='".$_POST[Speech_Services]."' where designations.local_id = ".$localID.";update certificationgoals set certificationgoals.certGoal1='".$_POST[CertificationGoals1]."',certificationgoals.certGoal2='".$_POST[CertificationGoals2]."',certificationgoals.certGoal3='".$_POST[CertificationGoals3]."' where certificationgoals.local_id = ".$localID.";update seventhscores set seventhscores.aspireEnglish='".$_POST[seventhAspireEnglish]."',seventhscores.aspireReading='".$_POST[seventhAspireReading]."',seventhscores.aspireScience='".$_POST[seventhAspireScience]."',seventhscores.aspireMath='".$_POST[seventhAspireMath]."',seventhscores.mapLanguage='".$_POST[seventMapLanguage]."',seventhscores.mapReading='".$_POST[seventMapReading]."',seventhscores.mapScience='".$_POST[seventMapScience]."',seventhscores.mapMath='".$_POST[seventMapMath]."',seventhscores.dukeTip='".$_POST[seventdukeTip]."' where seventhscores.state_id = ".$stateID.";update eighthscores set eighthscores.aspireEnglish='".$_POST[eighthAspireEnglish]."',eighthscores.aspireReading='".$_POST[eighthAspireReading]."',eighthscores.aspireScience='".$_POST[eighthAspireScience]."',eighthscores.aspireMath='".$_POST[eighthAspireMath]."',eighthscores.mapLanguage='".$_POST[eighthMapLanguage]."',eighthscores.mapReading='".$_POST[eighthMapReading]."',eighthscores.mapScience='".$_POST[eighthMapScience]."',eighthscores.mapMath='".$_POST[eighthMapMath]."' where eighthscores.state_id = ".$stateID.";update ninethscores set ninethscores.aspireEnglish='".$_POST[ninethAspireEnglish]."',ninethscores.aspireReading='".$_POST[ninethAspireReading]."',ninethscores.aspireScience='".$_POST[ninethAspireScience]."',ninethscores.aspireMath='".$_POST[ninethAspireMath]."',ninethscores.mapLanguage='".$_POST[ninethMapLanguage]."',ninethscores.mapReading='".$_POST[ninethMapReading]."',ninethscores.mapScience='".$_POST[ninethMapScience]."',ninethscores.mapMath='".$_POST[ninethMapMath]."' where ninethscores.state_id = ".$stateID.";update tenthscores set tenthscores.aspireEnglish='".$_POST[tenthAspireEnglish]."',tenthscores.aspireReading='".$_POST[tenthAspireReading]."',tenthscores.aspireScience='".$_POST[tenthAspireScience]."',tenthscores.aspireMath='".$_POST[tenthAspireMath]."',tenthscores.mapLanguage='".$_POST[tenthMapLanguage]."',tenthscores.mapReading='".$_POST[tenthMapReading]."',tenthscores.mapScience='".$_POST[tenthMapScience]."',tenthscores.mapMath='".$_POST[tenthMapMath]."' where tenthscores.state_id = ".$stateID.";update eleventhscores set eleventhscores.mapLanguage='".$_POST[eleventhMapLanguage]."',eleventhscores.mapReading='".$_POST[eleventhMapReading]."',eleventhscores.mapScience='".$_POST[eleventhMapScience]."',eleventhscores.mapMath='".$_POST[eleventhMapMath]."',eleventhscores.actEnglish='".$_POST[eleventhactEnglish]."',eleventhscores.actReading='".$_POST[eleventhactReading]."',eleventhscores.actScience='".$_POST[eleventhactScience]."',eleventhscores.actMath='".$_POST[eleventhactMath]."',eleventhscores.actComposite='".$_POST[eleventhactComposite]."',eleventhscores.asvab='".$_POST[eleventhAsvab]."' where eleventhscores.state_id = ".$stateID.";update twelfthscores set twelfthscores.actEnglish='".$_POST[twelfthactEnglish]."',twelfthscores.actReading='".$_POST[twelfthactReading]."',twelfthscores.actScience='".$_POST[twelfthactScience]."',twelfthscores.actMath='".$_POST[twelfthactMath]."',twelfthscores.actComposite='".$_POST[twelfthactComposite]."' where twelfthscores.state_id = ".$stateID.";update seventhinterventions set seventhinterventions.intervention1='".$_POST[sevenInterventions1]."',seventhinterventions.intervention2='".$_POST[sevenInterventions2]."',seventhinterventions.intervention3='".$_POST[sevenInterventions3]."' where seventhinterventions.local_id = ".$localID.";update eighthinterventions set eighthinterventions.intervention1='".$_POST[eightInterventions1]."',eighthinterventions.intervention2='".$_POST[eightInterventions2]."',eighthinterventions.intervention3='".$_POST[eightInterventions3]."' where eighthinterventions.local_id = ".$localID.";update ninethinterventions set ninethinterventions.intervention1='".$_POST[nineInterventions1]."',ninethinterventions.intervention2='".$_POST[nineInterventions2]."' where ninethinterventions.local_id = ".$localID.";update tenthinterventions set tenthinterventions.intervention1='".$_POST[tenInterventions1]."',tenthinterventions.intervention2='".$_POST[tenInterventions2]."',tenthinterventions.intervention3='".$_POST[tenInterventions3]."',tenthinterventions.intervention4='".$_POST[tenInterventions4]."' where tenthinterventions.local_id = ".$localID.";update eleventhinterventions set eleventhinterventions.intervention1='".$_POST[elevenInterventions1]."',eleventhinterventions.intervention2='".$_POST[elevenInterventions2]."',eleventhinterventions.intervention3='".$_POST[elevenInterventions3]."' where eleventhinterventions.local_id = ".$localID.";update twelfthinterventions set twelfthinterventions.intervention1='".$_POST[twelveInterventions1]."',twelfthinterventions.intervention2='".$_POST[twelveInterventions2]."',twelfthinterventions.intervention3='".$_POST[twelveInterventions3]."' where twelfthinterventions.local_id = ".$localID.";update vocationalplan set vocationalplan.careerFocus='".$_POST[CareerFocus]."' where vocationalplan.local_id = ".$localID.";update ninethsupporting set ninethsupporting.supportingCourse1='".$_POST[ninesupporting1]."',ninethsupporting.supportingCourse2='".$_POST[ninesupporting2]."',ninethsupporting.supportingCourse3='".$_POST[ninesupporting3]."' where ninethsupporting.local_id = ".$localID.";update tenthsupporting set tenthsupporting.supportingCourse1='".$_POST[tensupporting1]."',tenthsupporting.supportingCourse2='".$_POST[tensupporting2]."',tenthsupporting.supportingCourse3='".$_POST[tensupporting3]."' where tenthsupporting.local_id = ".$localID.";update eleventhsupporting set eleventhsupporting.supportingCourse1='".$_POST[elevensupporting1]."',eleventhsupporting.supportingCourse2='".$_POST[elevensupporting2]."',eleventhsupporting.supportingCourse3='".$_POST[elevensupporting3]."' where eleventhsupporting.local_id = ".$localID.";update twelfthsupporting set twelfthsupporting.supportingCourse1='".$_POST[twelvesupporting1]."',twelfthsupporting.supportingCourse2='".$_POST[twelvesupporting2]."',twelfthsupporting.supportingCourse3='".$_POST[twelvesupporting3]."' where twelfthsupporting.local_id = ".$localID.";update certificationsearned set certificationsearned.certsEarned1='".$_POST[CertificationsEarned1]."',certificationsearned.certsEarned2='".$_POST[CertificationsEarned2]."',certificationsearned.certsEarned3='".$_POST[CertificationsEarned3]."' where certificationsearned.local_id = ".$localID.";update seventhresume set seventhresume.activity1='".$_POST[sevenactivity1]."',seventhresume.activity2='".$_POST[sevenactivity2]."',seventhresume.honors1='".$_POST[sevenhonors1]."',seventhresume.honors2='".$_POST[sevenhonors2]."',seventhresume.communityService1='".$_POST[sevencomservice1]."',seventhresume.communityService2='".$_POST[sevencomservice2]."' where seventhresume.local_id = ".$localID.";update eighthresume set eighthresume.activity1='".$_POST[eightactivity1]."',eighthresume.activity2='".$_POST[eightactivity2]."',eighthresume.honors1='".$_POST[eighthonors1]."',eighthresume.honors2='".$_POST[eighthonors2]."',eighthresume.gpaSem1='".$_POST[eightgpaSem1]."',eighthresume.gpaSem2='".$_POST[eightgpaSem2]."',eighthresume.cumulativeGpa='".$_POST[eightcumulativeGpa]."',eighthresume.communityService1='".$_POST[eightcomservice1]."',eighthresume.communityService2='".$_POST[eightcomservice2]."' where eighthresume.local_id = ".$localID.";update ninethresume set ninethresume.activity1='".$_POST[nineactivity1]."',ninethresume.activity2='".$_POST[nineactivity2]."',ninethresume.honors1='".$_POST[ninehonors1]."',ninethresume.honors2='".$_POST[ninehonors2]."',ninethresume.gpaSem1='".$_POST[ninegpaSem1]."',ninethresume.gpaSem2='".$_POST[ninegpaSem2]."',ninethresume.cumulativeGpa='".$_POST[ninecumulativeGpa]."',ninethresume.classRank='".$_POST[nineclassRank]."',ninethresume.communityService1='".$_POST[ninecomservice1]."',ninethresume.communityService2='".$_POST[ninecomservice2]."' where ninethresume.local_id = ".$localID.";update tenthresume set tenthresume.activity1='".$_POST[tenactivity1]."',tenthresume.activity2='".$_POST[tenactivity2]."',tenthresume.honors1='".$_POST[tenhonors1]."',tenthresume.honors2='".$_POST[tenhonors2]."',tenthresume.gpaSem1='".$_POST[tengpaSem1]."',tenthresume.gpaSem2='".$_POST[tengpaSem2]."',tenthresume.cumulativeGpa='".$_POST[tencumulativeGpa]."',tenthresume.classRank='".$_POST[tenclassRank]."',tenthresume.communityService1='".$_POST[tencomservice1]."',tenthresume.communityService2='".$_POST[tencomservice2]."' where tenthresume.local_id = ".$localID.";update eleventhresume set eleventhresume.activity1='".$_POST[elevenactivity1]."',eleventhresume.activity2='".$_POST[elevenactivity2]."',eleventhresume.honors1='".$_POST[elevenhonors1]."',eleventhresume.honors2='".$_POST[elevenhonors2]."',eleventhresume.gpaSem1='".$_POST[elevengpaSem1]."',eleventhresume.gpaSem2='".$_POST[elevengpaSem2]."',eleventhresume.cumulativeGpa='".$_POST[elevencumulativeGpa]."',eleventhresume.classRank='".$_POST[elevenclassRank]."',eleventhresume.communityService1='".$_POST[elevencomservice1]."',eleventhresume.communityService2='".$_POST[elevencomservice2]."' where eleventhresume.local_id = ".$localID.";update twelfthresume set twelfthresume.activity1='".$_POST[twelveactivity1]."',twelfthresume.activity2='".$_POST[twelveactivity2]."',twelfthresume.honors1='".$_POST[twelvehonors1]."',twelfthresume.honors2='".$_POST[twelvehonors2]."',twelfthresume.gpaSem1='".$_POST[twelvegpaSem1]."',twelfthresume.gpaSem2='".$_POST[twelvegpaSem2]."',twelfthresume.cumulativeGpa='".$_POST[twelvecumulativeGpa]."',twelfthresume.classRank='".$_POST[twelveclassRank]."',twelfthresume.communityService1='".$_POST[twelvecomservice1]."',twelfthresume.communityService2='".$_POST[twelvecomservice2]."' where twelfthresume.local_id = ".$localID.";update careerreadiness set careerreadiness.college1='".$_POST[college1]."',careerreadiness.college2='".$_POST[college2]."',careerreadiness.college3='".$_POST[college3]."',careerreadiness.armedServicesBranch='".$_POST[armedServicesBranch]."',careerreadiness.vocationTrade='".$_POST[vocationTrade]."',careerreadiness.employmentIndustry='".$_POST[employmentIndustry]."' where careerreadiness.local_id = ".$localID.";";
$sqlUpdateWrite = @mysqli_multi_query($dbc, $sqlUpdateQuery);
$setSessionQuery = "update sessions set sessions.isActive='NO' where local_id = ".$localID.";";
$setSesstionInactive = @mysqli_query($dbc, $setSessionQuery);
mysqli_close($dbc);
$_SESSION['message'] = 'Your Student Success Plan has been updated successfully.';
header("Location: index.php");
?>