<html>
<head>
   <TITLE>Light Control</TITLE>
   <link rel="shortcut icon" href="beach.png">
</head>
<body bgcolor="#FFFFFF" BACKGROUND="image7.jpg" link="#000000" vlink="#0000FF" alink="#0000FF">
<?php

$SecondWest=$_GET["SecondWest"];
$SecondEast=$_GET["SecondEast"];
$MasterWest=$_GET["MasterWest"];
$MasterEast=$_GET["MasterEast"];

if ($SecondWest=="ON") {shell_exec('mosquitto_pub -u "anne" -P "YE2-5192" -t "cmnd/rfbridge/Rfkey1" -m "0"');
sleep(1);
shell_exec('mosquitto_pub -u "anne" -P "YE2-5192" -t "lights" -m "Second Bedroom West Turned ON"');
sleep(5);}
elseif ($SecondWest=="OFF"){shell_exec('mosquitto_pub -u "anne" -P "YE2-5192" -t "cmnd/rfbridge/Rfkey2" -m "0"');
sleep(1);
shell_exec('mosquitto_pub -u "anne" -P "YE2-5192" -t "lights" -m "Second Bedroom West Turned OFF"');
sleep(5);}
elseif ($SecondEast=="ON") {shell_exec('mosquitto_pub -u "anne" -P "YE2-5192" -t "cmnd/rfbridge/Rfkey9" -m "0"');
sleep(1);
shell_exec('mosquitto_pub -u "anne" -P "YE2-5192" -t "lights" -m "Second Bedroom East Turned ON"');
sleep(5);}
elseif ($SecondEast=="OFF"){shell_exec('mosquitto_pub -u "anne" -P "YE2-5192" -t "cmnd/rfbridge/Rfkey10" -m "0"');
sleep(1);
shell_exec('mosquitto_pub -u "anne" -P "YE2-5192" -t "lights" -m "Second Bedroom East Turned OFF"');
sleep(5);}
//**************add MasterEast and MasterWest here
elseif ($MasterWest=="ON") {
	
$command = escapeshellcmd("sudo python /var/www/html/secure/mqtt.py 1TOGGLE");
   echo $command;
    $resultAsString = shell_exec($command);
    echo $resultAsString;	
shell_exec('mosquitto_pub -u "anne" -P "YE2-5192" -t "lights" -m "Master Bedroom West Turned ON"');
sleep(5);}
elseif ($MasterWest=="OFF"){
	$command = escapeshellcmd("sudo python /var/www/html/secure/mqtt.py 1TOGGLE");
   echo $command;
    $resultAsString = shell_exec($command);
    echo $resultAsString;
shell_exec('mosquitto_pub -u "anne" -P "YE2-5192" -t "lights" -m "Master Bedroom West Turned OFF"');
sleep(5);}
elseif ($MasterEast=="ON") {shell_exec('mosquitto_pub -u "anne" -P "YE2-5192" -t "cmnd/rfbridge/Rfkey7" -m "0"');
shell_exec('mosquitto_pub -u "anne" -P "YE2-5192" -t "lights" -m "Master Bedroom East Turned ON"');
sleep(5);}
elseif ($MasterEast=="OFF"){shell_exec('mosquitto_pub -u "anne" -P "YE2-5192" -t "cmnd/rfbridge/Rfkey8" -m "0"');
shell_exec('mosquitto_pub -u "anne" -P "YE2-5192" -t "lights" -m "Master Bedroom East Turned OFF"');
sleep(5);}

?>
<center>
<table BORDER=2 WIDTH="300" >
<tr BGCOLOR="silver" >
      <td > <br>
        
        <div align="center"><img src="beach.png" width=100 height=100 > 
          <br> <b><font face="times" size="3"><font color="#000000" size="+3" face="Times New Roman, Times, serif">NSB<BR>Control Lights</font></b> 
        </div>
         
        
       
</td>
</tr>
</table>

<table BORDER=2 WIDTH="300" >
    <tr BGCOLOR="#FF6600"> 
      <td width="326" bgcolor="#FFFFCC"> 
	  
	  <center><font color="#000000" size="+2" face="Times New Roman, Times, serif"><A href="lights.php" ><font size="2" face="Arial, Helvetica, sans-serif"><B>UPDATE</B></font><br></A></center>
	  
		<form method="GET" action=''>
<font size="3" face="Arial, Helvetica, sans-serif"><strong>Second Bedroom West:&nbsp;&nbsp;&nbsp;</strong></font>
<input type="submit" name="SecondWest"  value="ON" style="font-size:8pt;color:white;background-color:green;border:2px solid #336600;border-radius: 25px;padding:3px">&nbsp;&nbsp;
<input type="submit" name="SecondWest"  value="OFF" style="font-size:8pt;color:white;background-color:red;border:2px solid #b30000;border-radius: 25px;padding:3px">
<p><font size="3" face="Arial, Helvetica, sans-serif"><strong>Second Bedroom East:&nbsp;&nbsp;&nbsp;&nbsp;</strong></font>
<input type="submit" name="SecondEast"  value="ON" style="font-size:8pt;color:white;background-color:green;border:2px solid #336600;border-radius: 25px;padding:3px">&nbsp;&nbsp;
<input type="submit" name="SecondEast"  value="OFF" style="font-size:8pt;color:white;background-color:red;border:2px solid #b30000;border-radius: 25px;padding:3px">
  <p>
  <font size="3" face="Arial, Helvetica, sans-serif"><strong>Master Bedroom West:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></font>
<input type="submit" name="MasterWest"  value="ON" style="font-size:8pt;color:white;background-color:green;border:2px solid #336600;border-radius: 25px;padding:3px">&nbsp;&nbsp;
<input type="submit" name="MasterWest"  value="OFF" style="font-size:8pt;color:white;background-color:red;border:2px solid #b30000;border-radius: 25px;padding:3px">
<p><font size="3" face="Arial, Helvetica, sans-serif"><strong>Master Bedroom East:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></font>
<input type="submit" name="MasterEast"  value="ON" style="font-size:8pt;color:white;background-color:green;border:2px solid #336600;border-radius: 25px;padding:3px">&nbsp;&nbsp;
<input type="submit" name="MasterEast"  value="OFF" style="font-size:8pt;color:white;background-color:red;border:2px solid #b30000;border-radius: 25px;padding:3px">
</form>


</td>      
</tr>
</table>

</center>




</center>
</body>
</html>
