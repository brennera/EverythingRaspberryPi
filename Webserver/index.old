<html>
<head>
   <TITLE>Solar Home in Fairplay, Colorado</TITLE>
   <link rel="shortcut icon"
 href="IOT2.ico">
   
</head>
<body bgcolor="#FFFFFF" BACKGROUND="image7.jpg" link="#000000" vlink="#0000FF" alink="#0000FF">
&nbsp; 
<center>
<table BORDER=2 WIDTH="850" >
<tr BGCOLOR="silver" >
      <td > <br>
        
        <div align="center"><img src="house.jpg" width=320 height=172 hspace=10 border=0> 
          <p> <b><font face="times" size="+3"><font color="#000000" size="+3" face="Times New Roman, Times, serif">Solar Home in Fairplay, Colorado</font></b> 
        </div>
         
        
</td>
</tr>
</table>

<table BORDER=2 WIDTH="850" >
    <tr BGCOLOR="#FF6600"> 
      <td width="326" bgcolor="#FFFFCC"> 
		<font  FACE="arial"><strong><a href="http://brennercaprera.ddns.net/raspberrypi/Current_Fairplay_Data_graph.php">Current Data Summary</a></strong> </font><p>
		<font  FACE="arial"><strong><a href="http://brennercaprera.ddns.net/raspberrypi/Fairplay_temperatureV3.php">Daily Temperature Log and Graph</a></strong> </font><p>
		<font  FACE="arial"><strong><a href="http://fairplayhome.ddns.net:4572/HeaterOnOffLogFairplay.php">Fairplay Heater On-Off Log</a></strong> </font><p>
		<font  FACE="arial"><strong><a href="http://fairplayhome.ddns.net/current_outback.php">Current Outback Data</a></strong> </font><p>
		<font  FACE="arial"><strong><a href="/phpmyadmin">phpMyAdmin</a></strong> </font>
		</p>
		<div style="width: 600px; float:left; height:320px"><a href="outsidecam.jpg"><img  src="outsidecam.jpg" width="480" height="320"></a>
		</div><!--<a href="/ftp/EastCAMrotate.jpg" ><img  src="http://fairplayhome.ddns.net:4572/ftp/EastCAMrotate.jpg"width="240" height="320" ></a>
		-->
		<div style="width: 100px; float:left; height:320px">
		<a href="radoncam.jpg"><img  src="radoncam.jpg" width="120" height="160"></a>
		<a href="radoncam2.jpg"><img  src="radoncam2.jpg" width="160" height="120"></a>
		</div>
		 
		<br><br clear="all">
		<a href="radoncam3.jpg" ><img  src="radoncam3.jpg"width="320" height="240" ></a>
		<br>
	<?php
	$currentyear= date('Y');
	$currentmonth= date('m');
	$currentday= date('d');
	$intmonth=intval($currentmonth);
	$intday=intval($currentday);
	$currentdate= date('Y-m-d');
	$link = @mysqli_connect('localhost', 'fairplay', 'YE2-5192', 'fairplay');
    if (mysqli_connect_error()) {
		 echo'Could not connect to the database';
	} 
	$query = "SELECT * FROM Fairplay_sunrise_sunset_times WHERE date='$currentdate'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	$sunrise=$row['sunrise'];
	$sunset=$row['sunset'];
	
	$query = "SELECT * FROM fairplay_lux_sensor_log ORDER BY id DESC";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	$lux=$row['lux'];
	$lux_time=$row['time'];
	$lux_date=$row['date'];
	?>
	<p>
		
	<font  size="2" FACE="arial"><B>Sunrise <?php echo  "$currentdate";?>: </B><?php echo  "$sunrise";?><br><B>Sunset <?php echo  "$currentdate";?>: </B><?php echo  "$sunset";?> <br><br>
	 <B>Light Intensity <?php echo  "$lux_date";?> <?php echo  "$lux_time";?>: </B><?php echo  "$lux";?> Lux</font>
	 <p><font size="3" FACE="arial"><strong>Current Temperature and Humidity</strong> </font><br>
	
	
	
		
		<table width="600" border="1" bordercolor="#000000" bgcolor="#b3f0ff">
  <tr bgcolor="#FFCC00"> 
      <td width="200" bgcolor="#FFFFFF"> 
        </td>
	 
      <td width="150" bgcolor="#00b8e6"> 
        <center>
        <b><font color="#000000" >Date</font></b> 
      </center></td>
	
      <td width="150" bgcolor="#00b8e6"> 
        <center>
        <b><font color="#000000" >Time</font></b> 
      </center></td>
		<td width="150" bgcolor="#00b8e6"> 
        <center>
        <b><font color="#000000" >Temperature</font></b> 
      </center></td>
	
      <td width="150" bgcolor="#00b8e6"> 
        <center>
        <b><font color="#000000" >Humidity</font></b> 
      </center></td>
	  
		</tr>
		
<?php
$currentdate= date('Y-m-d');

 $query = "SELECT * FROM current_temperature ORDER BY id DESC";
  $result = mysqli_query($link, $query);
	$rowarray=array();
	
   while ($row = mysqli_fetch_array($result)){
	   	
   $location= $row['location'];
   if($location=='hot_water_tank'){$location='Hot Water Tank';}
   if($location=='BBO'){$location='BB Outside';}
   if($location=='BBI'){$location='BB Inside';}
   $temp= $row['temperature'];
   $humid=strval(intval($row['humidity']));
   if ($humid=='0'){$humid='';}
   else{$humid=$humid.'%';}
   
   $date= $row['date'];
   $time= $row['time'];
   
     
   ?>
   <tr> 
    <td align="left" bgcolor="#9999CC"><font color='#000000' size='2'><b><?php echo  "$location";?></b></font></td>
	 <td align="left"><font color='#000000'><?php echo  "$date";?></font></td>
	 <td align="left"><font color='#000000'><?php echo  "$time";?></font></td>
	 <td align="right"><font color='#000000'><?php echo  "$temp";?>&#8457;</font></td>
	 <td align="right"><font color='#000000'><?php echo  "$humid";?></font></td>
	 	
      </tr>
   <?php
 }
	   
?>
  </table>		
	 <form action="http://fairplayhome.ddns.net:4572/Daily_lux_get.php" target="iframe_a" method="get">
		<font  FACE="arial"><strong>Daily Lux Values</strong> </font><br>
		<font  FACE="arial">Year: 
		<select name="year">
			<option value='<?php echo  "$currentyear";?>'><?php echo  "$currentyear";?></option>
			<option value="2017">2017</option>
			<option value="2018">2018</option>
			<option value="2019">2019</option>
			<option value="2020">2020</option>
		</select>
		
		Month:
		<select name="month">
			<option value='<?php echo  "$currentmonth";?>'><?php echo  "$intmonth";?></option>
			<option value="01">1</option>
			<option value="02">2</option>
			<option value="03">3</option>
			<option value="04">4</option>
			<option value="05">5</option>
			<option value="06">6</option>
			<option value="07">7</option>
			<option value="08">8</option>
			<option value="09">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
		</select>
		
		Day:
		<select name="day">
			<option value='<?php echo  "$currentday";?>'><?php echo  "$intday";?></option>
			<option value="01">1</option>
			<option value="02">2</option>
			<option value="03">3</option>
			<option value="04">4</option>
			<option value="05">5</option>
			<option value="06">6</option>
			<option value="07">7</option>
			<option value="08">8</option>
			<option value="09">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
			<option value="13">13</option>
			<option value="14">14</option>
			<option value="15">15</option>
			<option value="16">16</option>
			<option value="17">17</option>
			<option value="18">18</option>
			<option value="19">19</option>
			<option value="20">20</option>
			<option value="21">21</option>
			<option value="22">22</option>
			<option value="23">23</option>
			<option value="24">24</option>
			<option value="25">25</option>
			<option value="26">26</option>
			<option value="27">27</option>
			<option value="28">28</option>
			<option value="29">29</option>
			<option value="30">30</option>
			<option value="31">31</option>
		</select>
		
		</font>
		<input type="submit" value="Submit">
		</form>
	<iframe height="320px"  width = "100%" src="http://fairplayhome.ddns.net:4572/Daily_lux_get.php?year=<?php echo  $currentyear;?>&month=<?php echo  $currentmonth;?>&day=<?php echo  $currentday;?>" name="iframe_a"></iframe>

</td>
</tr>
</table>
</center>
</body>
</html>
