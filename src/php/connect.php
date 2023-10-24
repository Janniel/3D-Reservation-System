<?php
	$conn = mysqli_connect("localhost","root","");
	date_default_timezone_set("Asia/Manila");
	if(!mysqli_select_db($conn,"soar")) //yung "soar" yung database name ko
	{
		die("connection error");
	}
?>