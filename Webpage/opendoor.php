<?php
include('database.php');

	if(isset($_POST['submit2']))
	{
		$otp1=$_POST['otp1'];
		$query = mysqli_query($conn,"SELECT * FROM web WHERE NOW() <= DATE_ADD(datetimestart, INTERVAL 30 SECOND)");
		$rows = mysqli_num_rows($query);
		
		if($rows > 0){
			$data=mysqli_fetch_array($query);			
			$hash=$data['hash'];
			if(password_verify($otp1, $hash)){
				echo "OTP is correct. Click the Unlock button to unlock the door.";
				header("Location: opensesame.php");
			}	
			else
			{
				echo "OTP is wrong.";
			}
		}
		else echo "you are not allowed to access the office at this time";
	} 
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('txt').innerHTML =
    h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}

$(document).ready(function(){
	$("#hide").hide();
    $("#show").click(function(){
        $("#hide").show();
    });
});
</script>
</head>
<body>
<h3 style="padding: 1px;">Real-Time Clock</h3>
<center>
<body onload="startTime()">
<div id="txt" style="align-text:center; font-size: 50px; margin: 0 500px 0 500px; border-style: solid; border-color: black; border-width: medium;"></div>
<br>
<h3>Please key in OTP to enter Mr Teo's office.</h3>
<div class="opendoor">
<form action="opendoor.php" method="post">
<input type="text" name="otp1">
<div>
<input id="show" type="submit" name="submit2" value="Enter" />
</div>
</form>
</div>
<br>
<br>

</center>



</body>
</html>
