<?php
include('database.php');
date_default_timezone_set('Asia/Singapore');
$mydate=getdate(date("U"));
$mytime=localtime(time(),true);
$date="$mydate[year]-$mydate[mon]-$mydate[mday] ";
$time="$mytime[tm_hour]:$mytime[tm_min]:$mytime[tm_sec]";
$datetime=$date.$time;
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h2>Mr Teo's Office</h2>
<h3>To access Mr Teo's office, you need to generate an OTP.</h3>
<center>
<div class="forms"><form action="index.php" method="post">
<h3>Date and Time (Format: YYYY-MM-DD HH:MI:SS): <input type="text" name="datetime" value="<?php echo $datetime; ?>" required></h3>
<div>
<input type="submit" name="submit" value="Generate OTP" />
</div>
</form>
<h3>Generated OTP (expires in 30 seconds): <input type="text" name="otp" value="<?php 
$chosendatetime="";
if(isset($_POST['submit']))
	{
		function gen_random_string($length=6)
    {
        $chars ="1234567890";
        $final_rand ='';
        for($i=0;$i<$length; $i++)
        {
            $final_rand .= $chars[ rand(0,strlen($chars)-1)];
        }
        return $final_rand;
    }
	$datetimestart=$_POST['datetime'];
	$otp=gen_random_string();
	$hash=password_hash($otp, PASSWORD_BCRYPT);
	$result = mysqli_query($conn,"INSERT INTO web (datetimestart, hash) VALUES ('$datetimestart', '$hash')");
	if($result)
			{
				
				echo $otp;
				
			}
			else
			{
				echo "error, please try again.";
			}
	} 
else
	{
		echo "please generate otp";
	} 
	
	?>" readonly><br></h3>
	<h3>Time Set for the above OTP is: <?php 
	if(isset($_POST['submit'])){
		$chosendatetime=$_POST['datetime'];
		echo $chosendatetime;
	}
	else echo "";?><h3>
<form action="index.php" method="post">
<div>
<input type="submit" name="submit1" value="Key in OTP" />
<?php 
if(isset($_POST['submit1'])) 
	{
		header("Location: opendoor.php");
	}
?>
</div>
</form>
</div>
</center>
</body>
</html>

