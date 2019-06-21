var breakpoint = false;

$('#GradeLevelCourses').scroll(function() {
    var scroll = $('#GradeLevelCourses').scrollLeft();
  if (scroll < 1 ) {
     dimLeft();
  }
   if (scroll > 600 ) {
     dimRight();
  }
});

$('#ScoreInputs').scroll(function() {
    var scroll = $('#ScoreInputs').scrollLeft();
  if (scroll < 1 ) {
     dimLeft2();
  }
   if (scroll > 600 ) {
     dimRight2();
  }
});
$('#InterventionInputs').scroll(function() {
    var scroll = $('#InterventionInputs').scrollLeft();
  if (scroll < 1 ) {
     dimLeft4();
  }
   if (scroll > 600 ) {
     dimRight4();
  }
});
$('#resumewrapper').scroll(function() {
    var scroll = $('#resumewrapper').scrollLeft();
  if (scroll < 1 ) {
     dimLeft3();
  }
   if (scroll > 600 ) {
     dimRight3();
  }
});


function dimLeft() {
  var d = document.getElementById("left-button");
  var r = document.getElementById("right-button");
  d.className += " dimLeft";
  r.className -= " dimRight";
}
function dimRight() {
  var d = document.getElementById("right-button");
  var l = document.getElementById("left-button");
  d.className += " dimRight";
  l.className -= " dimLeft";
}
function dimLeft2() {
  var d = document.getElementById("left-button2");
  var r = document.getElementById("right-button2");
  d.className += " dimLeft";
  r.className -= " dimRight";
}
function dimRight2() {
  var d = document.getElementById("right-button2");
  var l = document.getElementById("left-button2");
  d.className += " dimRight";
  l.className -= " dimLeft";
}
function dimLeft3() {
  var d = document.getElementById("left-button3");
  var r = document.getElementById("right-button3");
  d.className += " dimLeft";
  r.className -= " dimRight";
}
function dimRight3() {
  var d = document.getElementById("right-button3");
  var l = document.getElementById("left-button3");
  d.className += " dimRight";
  l.className -= " dimLeft";
}
function dimLeft4() {
  var d = document.getElementById("left-button4");
  var r = document.getElementById("right-button4");
  d.className += " dimLeft";
  r.className -= " dimRight";
}
function dimRight4() {
  var d = document.getElementById("right-button4");
  var l = document.getElementById("left-button4");
  d.className += " dimRight";
  l.className -= " dimLeft";
}


$('#right-button').click(function() {
  event.preventDefault();
  $('#GradeLevelCourses').animate({
    scrollLeft: "+=1000px"
  }, "slow");
  $('#ScoreInputs').animate({
    scrollLeft: "+=1000px"
  }, "slow");
  $('#InterventionInputs').animate({
    scrollLeft: "+=1000px"
  }, "slow");
  $('#resumewrapper').animate({
    scrollLeft: "+=1000px"
  }, "slow");
});

 $('#left-button').click(function() {
  event.preventDefault();
  $('#GradeLevelCourses').animate({
    scrollLeft: "-=1000px"
  }, "slow");
  $('#ScoreInputs').animate({
    scrollLeft: "-=1000px"
  }, "slow");
  $('#InterventionInputs').animate({
    scrollLeft: "-=1000px"
  }, "slow");
  $('#resumewrapper').animate({
    scrollLeft: "-=1000px"
  }, "slow");
});
 $('#right-button2').click(function() {
  event.preventDefault();
  $('#GradeLevelCourses').animate({
    scrollLeft: "+=1000px"
  }, "slow");
  $('#ScoreInputs').animate({
    scrollLeft: "+=1000px"
  }, "slow");
  $('#InterventionInputs').animate({
    scrollLeft: "+=1000px"
  }, "slow");
  $('#resumewrapper').animate({
    scrollLeft: "+=1000px"
  }, "slow");
});

 $('#left-button2').click(function() {
  event.preventDefault();
  $('#GradeLevelCourses').animate({
    scrollLeft: "-=1000px"
  }, "slow");
  $('#ScoreInputs').animate({
    scrollLeft: "-=1000px"
  }, "slow");
  $('#InterventionInputs').animate({
    scrollLeft: "-=1000px"
  }, "slow");
  $('#resumewrapper').animate({
    scrollLeft: "-=1000px"
  }, "slow");
});
 $('#right-button3').click(function() {
  event.preventDefault();
  $('#GradeLevelCourses').animate({
    scrollLeft: "+=1000px"
  }, "slow");
  $('#ScoreInputs').animate({
    scrollLeft: "+=1000px"
  }, "slow");
  $('#InterventionInputs').animate({
    scrollLeft: "+=1000px"
  }, "slow");
  $('#resumewrapper').animate({
    scrollLeft: "+=1000px"
  }, "slow");
});

 $('#left-button3').click(function() {
  event.preventDefault();
  $('#GradeLevelCourses').animate({
    scrollLeft: "-=1000px"
  }, "slow");
  $('#ScoreInputs').animate({
    scrollLeft: "-=1000px"
  }, "slow");
  $('#InterventionInputs').animate({
    scrollLeft: "-=1000px"
  }, "slow");
  $('#resumewrapper').animate({
    scrollLeft: "-=1000px"
  }, "slow");
});


 $('#right-button4').click(function() {
  event.preventDefault();
  $('#GradeLevelCourses').animate({
    scrollLeft: "+=1000px"
  }, "slow");
  $('#ScoreInputs').animate({
    scrollLeft: "+=1000px"
  }, "slow");
  $('#InterventionInputs').animate({
    scrollLeft: "+=1000px"
  }, "slow");
  $('#resumewrapper').animate({
    scrollLeft: "+=1000px"
  }, "slow");
});

 $('#left-button4').click(function() {
  event.preventDefault();
  $('#GradeLevelCourses').animate({
    scrollLeft: "-=1000px"
  }, "slow");
  $('#ScoreInputs').animate({
    scrollLeft: "-=1000px"
  }, "slow");
  $('#InterventionInputs').animate({
    scrollLeft: "-=1000px"
  }, "slow");
  $('#resumewrapper').animate({
    scrollLeft: "-=1000px"
  }, "slow");
});