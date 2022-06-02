<!-- From "My Raspberry Pi Does Everything!!!" by Anne Brenner 2022 -->
<html>
<head>
<title>Current Temperature GET</title>
</head>
<body>

<?php
$temp=$_GET["temp"];
echo $temp;
$humid=$_GET["humid"];
echo $humid;
if($temp==""){$temp="-99.9";}
$link = @mysqli_connect('localhost', 'home_automation', 'YE2-5192', 'home_automation');
if (mysqli_connect_error()) {die('Could not connect to the database');} 
echo 'Connected successfully'; 
$query = "UPDATE current_values SET date=CURDATE(), time=CURTIME(), temperature='$temp' , humidity='$humid' ";  
if (mysqli_query($link, $query)) {echo 'Entered successfully';} 
else {die('Could not connect to the database');}
mysqli_close($link);
?>

</body>
</html>
	