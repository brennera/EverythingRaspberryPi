<!-- From "My Raspberry Pi Does Everything!!!" by Anne Brenner 2022 -->
<html>
<head>
<TITLE>Browser Based IOT Platform</TITLE>
</head>
<body>
<center>
<table BORDER=2 WIDTH="600" ><tr BGCOLOR="yellow" ><td>
<center><font FACE="arial"><H1>Browser Based IOT Platform</H1></font></center>
</td></tr></table>	

<table BORDER=2 WIDTH="600" ><tr BGCOLOR="silver" ><td>
<font size="3" FACE="arial"><b>Time: </b>
<?php 
date_default_timezone_set("America/New_York"); //change to your time zone
echo date("h:i:sa"); 
?>
</font><br>
<font size="3" FACE="arial"><b>Date: </b>
<?php echo date("Y-m-d"); ?>
</font><p>
<font size="3" FACE="arial"><b>Tasmota Switch: </b>

</font><p>
<font size="3" FACE="arial"><b>Current Temperature and Humidity: </b>

</font><p>
<font size="3" FACE="arial"><b>Feed from Webcam: </b>

</font>
</td></tr></table>
</center>
</body></html>
