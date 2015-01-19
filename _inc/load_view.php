	<?php

	$max_height = 150;
	$max_line = 1000;

	$images = array();
	$other_files = array();
	
	if( $handle = opendir($here) ){
		while (false !== ($file = readdir($handle))) {
			$filename = explode('.', $file);
			$ext = array_pop($filename);
			if(empty($ext)) continue;
			$ext = strtolower($ext);
			if($ext == "png" || $ext == "jpg" || $ext == "gif" || $ext == "jpeg"){
				array_push($images, $file);
			} else {
				array_push($other_files, $file);
			}
		}
		natcasesort ($images);
		natcasesort ($other_files);
		closedir($handle);
	}
	
	class ImageDisplay{
		public $originalW;
		public $originalH;
		public $width;
		public $height;
		public $imgUrl;
		
		public function __construct($w, $h, $u, $ow, $oh){
			$this->width = $w;
			$this->height = $h;
			$this->imgUrl = $u;
			$this->originalW = $ow;
			$this->originalH = $oh;
		}
		
		public function showImage($framePadding){
			print("<div class='imageDiv' style='padding-left: ".$framePadding."px; padding-right: ".$framePadding."px;'>");
				print("<a href='".$this->imgUrl."'>");
				print("<img src='".$this->imgUrl."' style='width: ".$this->width."px; height: ".$this->height."px' />");
				print("<div class='imageDesc' style='width: ".($this->width - 4)."px;'>[".$this->imgUrl."]<br/>(".$this->originalW." x ".$this->originalH.")</div>");
				print("</a>");
			print("</div>");
		}
	}
	
?>

<html>

<head>
	<title>images.paulovelho.com</title>
	<style>
		*{
			margin: 0px;
		}
		body{
			background-color: #FFF;
		}
		a {
			color: #000;
		}
		a:visited {
			color: #833;
		}
		#wrapper{
			left: 50%;
			margin-left: -500px;
			position: absolute;
			background-color: #FFF;
			min-height: 100%;
		}
		#main{
			width: 1000px;
		}
		#imageFrame{
			width: 1000px;
			float: left;
		}
		div.imageLine{
			width: <?php echo $max_line; ?>;
			float: left;
			border-bottom: 1px solid #666;
			text-align: center;
		}
		div.imageDiv{
			float: left;
			border: 0;
			text-align: center;
			padding-top: 5px;
			padding-bottom: 5px;
		}
		div.imageDiv:hover{
			background-color: #CCC;
		}
		div.imageDesc{
			border: 1px solid #000;
			background-color: #FFF;
			font-size: 10px;
			font-family: Verdana;
			margin-top: 5px;
		}
		
		#listFiles{
			float: left;
			padding: 20px;
			width: 100%;
		}
		#listFiles h3{
			width: 100%;
			text-align: center;
			font-size: 15px;
			font-variant: small-caps;
		}
		#listFiles span{
			float: left;
			width: 100%;
			padding-left: 30px;
		}
		
		#header{
			height: 100px;
			width: 100%;
			text-align: center;
			margin-top: 10px;
			margin-bottom:10px;
		}
		#header hr{
			width: 100%;
			border: 1px solid #AAA;
			margin-top: 5px;
		}
		
	</style>
</head>

<body>
	<div id="wrapper">
	<div id="main">
		<div id="header">
			<hr>
		</div>
		<div id="imageFrame">
<?php
	
	$imageArr = array();
	$line = 0;
	$images_per_line = 0;
	
	function printLine($imageArr, $frameWidth){
		print("<div class='imageLine'>");
		foreach($imageArr as $image){
			$image->showImage($frameWidth);
		}
		print("</div>");
	}
	
	foreach($images as $img){
		$size = getimagesize($img);
		$width = $size[0]; $height = $size[1];
		if( $height > $max_height ){
			$proportion = $height/$max_height;
			$width = floor($width/$proportion);
			$height = $max_height;
		}
		$nextLineSize = $line + $width;
		if($nextLineSize > $max_line){
			$framePadding = floor( (($max_line - $line) / $images_per_line) / 2 );
			printLine($imageArr, $framePadding);
			unset($imageArr); $imageArr = array(); // clear the array
			$nextLineSize = $width;
			$images_per_line = 0;
		}
		array_push($imageArr, new ImageDisplay($width, $height, $img, $size[0], $size[1]));
		$line = $nextLineSize;
		$images_per_line++;
	}
	
	if( count($imageArr) > 0 ){
		$framePadding = floor( (($max_line - $line) / $images_per_line) / 2 );
		printLine($imageArr, $framePadding);
	}

?>
		</div>
		<div id="listFiles">
<?php
/*
	print("<h3>Other Files and Folders:</h3>");
	foreach($other_files as $file){
		print("<span><a href='".$file."'>".$file."</a></span>");
	}
*/
	$pageURL = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	$pageURL = explode('/', $pageURL);
	array_pop($pageURL);
	$pageURL = implode('/', $pageURL);
?>
		</div>
	
	</div>
	</div>
	
	<script type="text/javascript" src="/_inc/javascript/jquery.js"></script>
	<script type="text/javascript" src="/_inc/javascript/jquery.lightbox-0.5.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/_inc/javascript/jquery.lightbox-0.5.css" media="screen" />
    <script type="text/javascript">
    $(function() {
        $('.imageDiv a').lightBox();
    });
    </script>
</body>
</html>