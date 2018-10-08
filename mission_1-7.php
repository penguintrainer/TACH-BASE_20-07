<!DOCTYPE html>
<html>
<html lang = "ja">
<head>
<meta charset = "uft-8">
<title>mission_1-7</title>
</head>
<body>
<h1></h1>
<form action = "mission_1-7.php" method = "POST">
<input type = "text" name ="comment"><br/>
<input type = "submit">
</form>
</body>
</html>

<?php
$comment = $_POST["comment"];
if($comment ==""){
}
else{
	if($comment =="完成"){
		echo "おめでとう！"."<br>";
	}
	else if($comment != ""){
		echo "ご入力ありがとうございます。"."<br>".date('Y\年m月d日H時i分')."に".$comment."を受け付けました"."<br>";
	}
	
	$filename = 'mission_1-7_hiraga.txt';
	$fp = fopen($filename, 'a');
	rewind($fp);
	fwrite($fp, $comment.PHP_EOL);
	fclose($fp);

	$txts= file("mission_1-7_hiraga.txt");
	foreach( $txts as $n =>  $txt){
		$n = $n + 1 ;
		echo $n.".".$txt."<br>";
	}
}
?>
