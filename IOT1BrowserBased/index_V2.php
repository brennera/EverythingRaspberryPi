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
<center><A href="index.php" ><font size="2" face="Arial, Helvetica, sans-serif"><B>UPDATE</B></font><br></A></center>	  
<font size="3" FACE="arial"><b>Time: </b>
<?php 
date_default_timezone_set("America/New_York"); //change to your time zone
echo date("h:i:s a"); 
?>
</font><p>
<font size="3" face="Arial, Helvetica, sans-serif"><b>Date: </b>
<?php echo date("Y-m-d"); ?>
</font><p>

<?php 
// This section tests if form data has been submitted
$Switch=$_GET["SWITCH"];
//******************************************
// In the following shell_exec commands, substitute the IP address of your S31 tasmota for 192.168.1.xxx
if ($Switch=="ON") {shell_exec('curl http://192.168.1.xxx/cm?cmnd=Power%20ON');
sleep(2);}
elseif ($Switch=="OFF") {shell_exec('curl http://192.168.1.xxx/cm?cmnd=Power%20OFF');
sleep(2);}
elseif ($Switch=="TOGGLE") {shell_exec('curl http://192.168.1.xxx/cm?cmnd=Power%20TOGGLE');
sleep(2);}
//********************************************
?>

<form method="GET" action=''>
<font size="3" face="Arial, Helvetica, sans-serif"><strong>Tasmota Switch: &nbsp;&nbsp;&nbsp;</strong></font>
<input type="submit" name="SWITCH"  value="ON" style="font-size:8pt;color:black;background-color:green;border:2px solid #336600;border-radius: 25px;padding:3px">&nbsp;&nbsp;
<input type="submit" name="SWITCH"  value="OFF" style="font-size:8pt;color:black;background-color:red;border:2px solid #b30000;border-radius: 25px;padding:3px">
&nbsp;&nbsp;
<input type="submit" name="SWITCH"  value="TOGGLE" style="font-size:8pt;color:black;background-color:yellow;border:2px solid #b30000;border-radius: 25px;padding:3px">
</form>

<p>
<font size="3" face="Arial, Helvetica, sans-serif"><b>Current Temperature and Humidity: </b>

</font><p>
<font size="3" face="Arial, Helvetica, sans-serif"><b>Feed from Webcam: </b>

</font>
</td></tr></table>
</center>
</body></html>
