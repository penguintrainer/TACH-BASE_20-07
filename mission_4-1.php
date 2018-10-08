<!DOCTYPE html>								<!--htmlにおけるコメントアウト-->
<html>
<html lang = "ja">
<head>
<meta charset = "uft-8">
<title>mission_4</title>
</head>
<body>
<h1></h1>

<?php				//編集時用phpと自己定義関数の作成
$dsn = 'mysql:dbname=tt_328_99sv_coco_com;host=localhost';	//データベースとしてmysqlを使うときの呪文
$user = 'tt-328.99sv-coco';					//ユーザー名
$password = 'h3FAnNTc';						//パスワード
$pdo = new PDO($dsn,$user,$password);				//データベースと接続

$sql = "CREATE TABLE pass"					//テーブル作成のsql
."("								//
."id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, "			//id部分の設定 AUTO_INCREMENT 
."pass TEXT"
.")";								//
$stmt = $pdo -> query($sql);					//テーブルの作成

$sql = "CREATE TABLE contributions"					//テーブル作成のsql
."("								//
."id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, "			//id部分の設定 AUTO_INCREMENT 
."name char(32), "						//name部分の設定
."comment TEXT, "						//comment部分の設定
."time TEXT"							//time部分の設定	"TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP"
.")";								//
$stmt = $pdo -> query($sql);					//テーブルの作成


function h($str) {		//脆弱性対策(クロスサイト・スクリプティング対策)
	return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$name = h($_POST["name"]);			//投稿者
$comment = h($_POST["comment"]);		//コメント
$time = date('Y\年m月d日H時i分');		//年月日
$deletenum = h($_POST["deletenum"]);		//削除番号
$editenum = h($_POST["editenum"]);		//編集番号
$hiddennum = h($_POST["hiddennum"]);		//編集フラグ受け取り
$password = h($_POST["password"]);		//パスワード受け取り

$dsn = 'mysql:dbname=tt_328_99sv_coco_com;host=localhost';	//データベースとしてmysqlを使うときの呪文
$user = 'tt-328.99sv-coco';					//ユーザー名
$password = 'h3FAnNTc';						//パスワード
$pdo = new PDO($dsn,$user,$password);				//データベースと接続

function situation($comment,$name,$deletenum,$editenum,$hiddennum,$password){		//状況判別関数
	if($comment == "" and $name == "" and $deletenum == "" and $editenum == "" and $hiddennum == "" and $password == ""){	//入力なし
		$y = 0;
	}
	elseif($comment != "" and $name != "" and $deletenum == "" and $editenum == "" and $hiddennum == "" and $password != ""){	//通常投稿
		$y = 1;
	}
	elseif($comment != "" and $name != "" and $deletenum == "" and $editenum == "" and $hiddennum != "" and $password != ""){	//編集投稿
		$y = 2;
	}
	elseif($comment == "" and $name == "" and $deletenum == "" and $editenum != "" and $hiddennum == "" and $password != ""){	//編集
		$y = 3;
	}
	elseif($comment == "" and $name == "" and $deletenum != "" and $editenum == "" and $hiddennum == "" and $password != ""){	//削除
		$y = 4;
	}
	elseif($password == ""){													//パスワードなし
		$y = 5;
	}
	else{																//その他
		$y = 6;
	}
	return $y;
}

switch(situation($comment,$name,$deletenum,$editenum,$hiddennum,$password)){
	case(3):							//編集モード時のフォームへの任意コメントの出力
		$sql = "SELECT*FROM contributions";
		$texts = $pdo -> query($sql);

		foreach($texts as $a =>  $chara){			//テキストを一行ずつ取り出す
//			$chara = explode("<>", $text);			//テキストを要素に分解

			if($chara['id'] == $editenum){			//編集番号と投稿番号が一致した時
				$editename = $chara['name'];			//フォーム内へ出力
				$editecomment = $chara['comment'];		//フォーム内へ出力
			}
			else{
			}
		}
		break;
}
$hiddennum = $editenum;
?>
<!--掲示版フォームの表示-->
<form action = "" method = "POST">									<!--ポスト関数-->
<input type = "text" name ="name" value="<?php echo $editename; ?>" placeholder="投稿者"><br/>		<!--投稿者フォーム-->
<input type = "text" name ="comment" value="<?php echo $editecomment; ?>" placeholder="コメント"><br/>	<!--コメントフォーム-->
<input type = "text" name ="deletenum" placeholder="削除番号"><br/>					<!--削除番号取得フォーム-->
<input type = "text" name="editenum" placeholder="編集番号"><br/>						<!--編集依頼フォーム-->
<input type = "hidden" name="hiddennum" value="<?php echo $hiddennum; ?>">				<!--隠れた編集依頼フォーム-->
<input type = "password" name ="password" placeholder="パスワード"><br/>				<!--パスワード取得フォーム-->
<input type = "submit"  value="submit" ><br/><br>							<!--送信フォーム-->
</form>
</body>
<footer></footer>
</html>

<?php
$name = h($_POST["name"]);						//投稿者
$comment = h($_POST["comment"]);					//コメント
$time = date('Y\年m月d日H時i分');					//年月日
$hiddennum = h($_POST["hiddennum"]);					//編集フラグ受け取り
$password = h($_POST["password"]);					//パスワード受け取り

function pass($num,$pass){						// パスワードの一致判別

	$dsn = 'mysql:dbname=tt_328_99sv_coco_com;host=localhost';	//データベースとしてmysqlを使うときの呪文
	$user = 'tt-328.99sv-coco';					//ユーザー名
	$password = 'h3FAnNTc';						//パスワード
	$pdo = new PDO($dsn,$user,$password);				//データベースと接続

	$sql = "SELECT*FROM pass";
	$passes = $pdo -> query($sql);

	foreach($passes as $a => $chara){				//変数を強制的に配列にするとともにその配列を要素ごとに$textに代入
		$y = 0;
		if($num == $chara['id'] and $pass == $chara['pass']){		//パスワードが一致した条件
			$y = 1;
			break;						//一致したら、foreachから抜け出す
		}
	}
	return $y;
}

switch(situation($comment,$name,$deletenum,$editenum,$hiddennum,$password)){
	case(2):							//編集投稿時
		if(pass($hiddennum,$password) == 1){					//パスワード一致条件

			$id = $hiddennum;
			$nm = $name;
			$kome = $comment;
			$date = $time;
			$sql = "update contributions set name = '$nm',comment = '$kome' ,time = '$date'where id = $id";	//idを指定して編集の指示
			$result = $pdo -> query($sql);							//67行目で作成した編集指示の実行

			$sql = "SELECT*FROM contributions";
			$results = $pdo -> query($sql);
			foreach($results as $row){
				echo $row['id'];
				echo $row['name'];
				echo $row['comment'];
				echo $row['time']."<br>";
			}
		}
		else{								//パスワード不一致条件
			echo "この編集は無効です。"."<br>";
		}
		break;
	case(1):							//通常投稿

		$sql = $pdo -> prepare("INSERT INTO contributions(name,comment,time) VALUES(:name,:comment,:time)");		//
		$sql -> bindParam(':name',$name,PDO::PARAM_STR);							//:nameのパラメータに$nameの内容をを文字列として代入
		$sql -> bindParam(':comment',$comment,PDO::PARAM_STR);							//:commentのパラメータに$commentの内容を文字列として代入
		$sql -> bindParam(':time',$time,PDO::PARAM_STR);
		$name = $name;											//パラメータ内に値を代入
		$comment = $comment;											//パラメータ内に値を代入
		$time = $time;
		$sql -> execute();											//$sqlで定義されたデータベースへの問い合わせを実行

		$sql = $pdo -> prepare("INSERT INTO pass(pass) VALUES(:pass)");		//
		$sql -> bindParam(':pass',$pass,PDO::PARAM_STR);
		$pass = $password;
		$sql -> execute();											//$sqlで定義されたデータベースへの問い合わせを実行

		$sql = "SELECT*FROM contributions";
		$results = $pdo -> query($sql);
		foreach($results as $row){
			echo $row['id'];		//idの出力
			echo $row['name'];		//nameの出力
			echo $row['comment'];	//commentの出力
			echo $row['time']."<br>";
		}


	break;
	case(4):		//削除
		if(pass($deletenum,$password) == 1){				//パスワード一致条件

			$id = $deletenum;
			$sql = "delete from contributions where id = $id";		//idを指定して削除
			$result = $pdo -> query($sql);

			$sql = "delete from pass where id = $id";		//idを指定して削除
			$result = $pdo -> query($sql);

					echo "投稿番号".$chara[0]."の削除を実行しました。"."<br>";		//削除番号の表示

			$sql = "SELECT*FROM contributions";
			$results = $pdo -> query($sql);
			foreach($results as $row){
				echo $row['id'];
				echo $row['name'];
				echo $row['comment'];
				echo $row['time']."<br>";
			}


		}
		else{
			echo "この削除は無効です。"."<br>";
		}
	break;
	case(5):
		echo "パスワードを入力してください"."<br>";
	break;
	case(6):
		echo "入力方法に誤りがあることが考えられます。"."<br>"."必要十分の情報を書き込んでください。"."<br>";
	break;
}
?>
