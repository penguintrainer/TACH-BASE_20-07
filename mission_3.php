<!DOCTYPE html>								<!--htmlにおけるコメントアウト-->
<html>
<html lang = "ja">
<head>
<meta charset = "uft-8">
<title>mission_3-6</title>
</head>
<body>
<h1></h1>

<?php
//3-1:mysqlとの接続設定（出力なし）
echo "3-1"."<br>";	//test
$dsn = 'mysql:dbname=tt_328_99sv_coco_com;host=localhost';	//データベースとしてmysqlを使うときの呪文
$user = 'tt-328.99sv-coco';					//ユーザー名
$password = 'h3FAnNTc';						//パスワード
$pdo = new PDO($dsn,$user,$password);				//データベースと接続
echo "<hr>";	//test

//3-2:mysqlというデータベース上にテーブルを作成（出力なし）
echo "3-2"."<br>";//test
$sql = "CREATE TABLE tbtest"					//テーブル作成のsql
."("								//
."id INT,"							//id部分の設定
."name char(32),"						//name部分の設定
."comment TEXT"							//comment部分の設定
.");";								//
$stmt = $pdo -> query($sql);					//3-1を用いたmysqlの接続とsqlの実行
echo "<hr>";	//test

//3-3:データベース上に存在するテーブルの名前を出力（テーブル名が出力される）
echo "3-3"."<br>";	//test
$sql = 'SHOW TABLES';						//テーブル一覧表示のsql
$result = $pdo -> query($sql);					//3-1の接続をもとにしたsqlの実行
foreach($result as $row){					//テーブル名の出力
echo $row[0];
echo "<br>";
}
echo "<hr>";							//区切りライン

//3-4:作成したテーブルの名前やカラムといった構造を確認（テーブルの名前やらカラムやらがごちゃごちゃ出力される）
echo "3-4"."<br>";	//test
$sql = "SHOW CREATE TABLE tbtest";				//テーブル中身表示のsql
$result = $pdo -> query($sql);					//sqlの実行
foreach($result as $row){					//テーブル中身の出力
	print_r($row);
}
echo "<hr>";							//区切りライン

//3-5:作成したテーブル内にデータを挿入していく(出力なし)
echo "3-5"."<br>";	//test
$sql = $pdo -> prepare("INSERT INTO tbtest(id,name,comment) VALUES('1',:name,:comment)");		//3-1を用いてmysqlと接続し、tbtestというテーブル内のid,name,commentを1,:name,:commentに変更する
$sql -> bindParam(':name',$name,PDO::PARAM_STR);							//:nameのパラメータに$nameの内容をを文字列として代入
$sql -> bindParam(':comment',$comment,PDO::PARAM_STR);							//:commentのパラメータに$commentの内容を文字列として代入
$name = 'あああ';											//パラメータ内に値を代入
$comment = "test";											//パラメータ内に値を代入
$sql -> execute();											//$sqlで定義されたデータベースへの問い合わせを実行
echo "<hr>";	//test

//3-6:指定したテーブル内のデータを表示（出力あり）
echo "3-6"."<br>";	//test
$sql = "SELECT*FROM tbtest";
$results = $pdo -> query($sql);
foreach($results as $row){
	echo $row['id'];		//idの出力
	echo $row['name'];		//nameの出力
	echo $row['comment']."<br>";	//commentの出力
}
echo "<hr>";

//3-7-1:テーブル内のデータを編集（出力なし）
echo "3-7-1"."<br>";	//test
$id = 1;
$nm = "あいうえお";
$kome = "かきくけこ";
$sql = "update tbtest set name = '$nm',comment = '$kome' where id = $id";	//idを指定して編集の指示
$result = $pdo -> query($sql);							//67行目で作成した編集指示の実行
echo "<hr>";	//test

//3-7-2:指定したテーブル内のデータを表示（編集内容の確認）
echo "3-7-2"."<br>";	//test
$sql = "SELECT*FROM tbtest";
$results = $pdo -> query($sql);
foreach($results as $row){
	echo $row['id'];
	echo $row['name'];
	echo $row['comment']."<br>";
}
echo "<hr>";

//3-8-1:テーブル内のデータを削除(出力なし)
echo "3-8-1"."<br>";	//test
$id = 1;
$sql = "delete from tbtest where id = $id";		//idを指定して削除
$result = $pdo -> query($sql);
echo "<hr>";	//test

//3-8-2:指定したテーブル内のデータを表示（削除内容の確認）
echo "3-8-2"."<br>";	//test
$sql = "SELECT*FROM tbtest";
$results = $pdo -> query($sql);
foreach($results as $row){
	echo $row['id'];
	echo $row['name'];
	echo $row['comment']."<br>";
}
echo "<hr>";	//test

?>
</form>
</body>
<footer></footer>
</html>
