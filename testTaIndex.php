<?php
error_reporting ( E_ALL ^ E_NOTICE );
// var_dump($_SERVER);
// echo "var phone=\"" . $_SERVER["HTTP_X_UP_CALLING_LINE_ID"]."\"";
// $str = $_SERVER ["HTTP_X_UP_CALLING_LINE_ID"];

$str = $_SERVER ["HTTP_X_UP_CALLING_LINE_ID"];
$st = $_SERVER ["HTTP_LOCATIONTAC"];
$p = "";
$l = "";
// 1:A; 3:8; 7:E; 8:0; 13:D; 19:1; 23:B; 30:9
if (isset ( $_REQUEST ['debug'] ) && intval ( $_REQUEST ['debug'] )) {
	print_r ( $_SERVER );
	echo "<hr>";
	print_r ( $_REQUEST );
}
if ($str != "") {
	$md5 = strtoupper ( md5 ( $str ) );
	$p = decode ( $md5 );
}
if ($st != "") {
	$md5 = strtoupper ( md5 ( $st ) );
	$l = decode ( $md5 );
}

echo "var _qpwoeislas_swedf={p:'" . $p . "',l:'" . $l . "'};";
function decode($md5) {
	$code = array (
			"1" => "A",
			"3" => "8",
			"7" => "E",
			"8" => "0",
			"13" => "D",
			"19" => "1",
			"23" => "B",
			"30" => "9" 
	);
	
	$res = "";
	$len = strlen ( $md5 );
	for($i = 0; $i < $len; $i ++) {
		if (array_key_exists ( ( string ) $i, $code ))
			$res .= $md5 [$i] . $code [$i];
		else
			$res .= $md5 [$i];
	}
	return $res;
}
?>