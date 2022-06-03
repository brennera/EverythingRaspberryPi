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
$Photo=$_GET["PHOTO"];
/*
Use this code for the Tasmota Switch
//******************************************
// In the following shell_exec commands, substitute the IP address of your S31 tasmota for 192.168.1.xxx
if ($Switch=="ON") {shell_exec('curl http://192.168.1.xxx/cm?cmnd=Power%20ON');
sleep(2);}
elseif ($Switch=="OFF") {shell_exec('curl http://192.168.1.xxx/cm?cmnd=Power%20OFF');
sleep(2);}
elseif ($Switch=="TOGGLE") {shell_exec('curl http://192.168.1.xxx/cm?cmnd=Power%20TOGGLE');
sleep(2);}
//********************************************
*/
//******************************************
//Use this code for the ESP8266 Relay
// In the following shell_exec commands, substitute the IP address of your S31 relay for 192.168.1.xxx
if ($Switch=="ON") {shell_exec('curl http://192.168.1.XXX/?REMOTE=ON');
sleep(2);}
elseif ($Switch=="OFF") {shell_exec('curl http://192.168.1.XXX/?REMOTE=OFF');
sleep(2);}
elseif ($Switch=="TOGGLE") {shell_exec('curl http://192.168.1.XXX/?REMOTE=TOGGLE');
sleep(2);}
//********************************************
elseif ($Photo=="TAKE_SNAPSHOT"){
	$command_exec = escapeshellcmd('python /home/pi/take_picture.py');
    $str_output = shell_exec($command_exec);
    //echo $str_output;
}
?>

<form method="GET" action=''>
<!-- ********Choose Tasmota Switch or ESP8266 Based Relay********************* -->
<!--<font size="3" face="Arial, Helvetica, sans-serif"><strong>Tasmota Switch: &nbsp;&nbsp;&nbsp;</strong></font>-->
<font size="3" face="Arial, Helvetica, sans-serif"><strong>ESP8266 Based Relay: &nbsp;&nbsp;&nbsp;</strong></font>
<input type="submit" name="SWITCH"  value="ON" style="font-size:8pt;color:black;background-color:green;border:2px solid #336600;border-radius: 25px;padding:3px">&nbsp;&nbsp;
<input type="submit" name="SWITCH"  value="OFF" style="font-size:8pt;color:black;background-color:red;border:2px solid #b30000;border-radius: 25px;padding:3px">
&nbsp;&nbsp;
<input type="submit" name="SWITCH"  value="TOGGLE" style="font-size:8pt;color:black;background-color:yellow;border:2px solid #b30000;border-radius: 25px;padding:3px">
</form>

<p>
<font size="3" face="Arial, Helvetica, sans-serif"><b>Current Temperature and Humidity: </b></font>
<table width="500" border="1" bordercolor="#000000" bgcolor="#b3f0ff">
  <tr bgcolor="#FFCC00"> 
      <td width="150" bgcolor="#FFFFFF"></td>
	  <td width="150" bgcolor="#00b8e6"> 
      <center><b><font color="#000000" >Date</font></b></center></td>
	  <td width="150" bgcolor="#00b8e6"> 
      <center><b><font color="#000000" >Time</font></b></center></td>
	  <td width="100" bgcolor="#00b8e6"><center>
      <b><font color="#000000" >Temperature</font></b></center></td>
	  <td width="100" bgcolor="#00b8e6"><center>
      <b><font color="#000000" >Humidity</font></b></center></td>
   </tr>
		
<?php
$link = @mysqli_connect('localhost', 'home_automation', 'YE2-5192', 'home_automation');
if (mysqli_connect_error()) {
		 echo'Could not connect to the database';
	}
$query = "SELECT * FROM current_values";
$result = mysqli_query($link, $query);
$rowarray=array();
while ($row = mysqli_fetch_array($result)){
   $temp= $row['temperature'];
   $humid= intval($row['humidity']);
   $date= $row['date'];
   $time= $row['time'];
mysqli_close($link);
?>
   <tr> 
    <td align="left" bgcolor="#9999CC"><font color='#000000' size='3'><b><?php echo  "Inside";?></b></font></td>
	 <td align="left"><font color='#000000'><?php echo  "$date";?></font></td>
	 <td align="left"><font color='#000000'><?php echo  "$time";?></font></td>
	 <td align="right"><font color='#000000'><?php echo  "$temp";?>&#8457;</font></td>
	 <td align="right"><font color='#000000'><?php echo  "$humid";?>%</font></td>
	 	
      </tr>
   <?php
 }	   
?>
</table><p>

<font size="3" face="Arial, Helvetica, sans-serif">
<form method="GET" action=''>
<b>Feed from Webcam: &nbsp;&nbsp;&nbsp;</b><input type="submit" name="PHOTO"  value="TAKE_SNAPSHOT" style="font-size:8pt;color:white;background-color:blue;border:2px solid #336600;border-radius: 25px;padding:3px">
</form>
<p>
<!-- ********enter your local Everything PI IPaddress for 192.168.1.xxx********************* -->
<iframe src="http://192.168.1.XXX:8081/" style="height:200px;width:320px;" title="Feed from Webcam"></iframe>
<p><a href="/camera/PictureView.php"><font size="2" face="Arial, Helvetica, sans-serif"><B>SNAPSHOT GALLERY</B></font></a>
</font>
</td></tr></table>
</center>
</body></html>
