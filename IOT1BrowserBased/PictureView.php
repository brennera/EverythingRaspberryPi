<!-- From "My Raspberry Pi Does Everything!!!" by Anne Brenner 2022 -->
<?php
echo 'last_insidecam.jpg<center><img width=320 height= 240 src="last_insidecam.jpg" /><br /></center>';
echo '<br><br>';

$images = glob("*insidecam.jpg");
$i=0;
foreach($images as $image) {
    echo $image.'<center><a href='.$image.'><img width=320 height= 240 src="'.$image.'" /></a><br /></center>';
	$i++;
	if($i==3){
		$i=0;
		echo '<br><br>';
  }
}
?>
