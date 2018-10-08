<!DOCTYPE html>								<!--htmlにおけるコメントアウト-->
<html>
<html lang = "ja">
<head>
<meta charset = "uft-8">
<title>mission_2-5</title>
</head>
<body>
<h1></h1>

<?php				//編集時用phpと自己定義関数の作成
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
$filename = 'mission_2-5_hiraga.txt';		//コメント保存ファイル名
$filename_pass = 'mission_2-5_pass.txt';	//パスワード保存ファイル名

$fp = fopen($filename_pass, 'a');			//パスワードファイルを開く(作成)
fclose($fp);						//パスワードファイルを閉じる
$fp = fopen($filename, 'a');				//テキストファイルを開く(作成)
fclose($fp);						//テキストファイルを閉じる

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
//		echo "編集"."<br>";		//test
		$texts= file($filename,FILE_IGNORE_NEW_LINES);		//テキストを読み込む
		foreach($texts as $a =>  $text){			//テキストを一行ずつ取り出す
			$chara = explode("<>", $text);			//テキストを要素に分解
			if($chara[0] == $editenum){			//編集番号と投稿番号が一致した時
				$editename = $chara[1];			//フォーム内へ出力
				$editecomment = $chara[2];		//フォーム内へ出力
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
<input type="text" name="editenum" placeholder="編集番号"><br/>						<!--編集依頼フォーム-->
<input type="hidden" name="hiddennum" value="<?php echo $hiddennum; ?>">				<!--隠れた編集依頼フォーム-->
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

//echo situation($comment,$name,$deletenum,$editenum,$hiddennum,$password)."<br>"; //状況確認
//echo "コメント=".$comment."名前=".$name."削除番号=".$deletenum."編集番号=".$editenum."フラグ=".$hiddennum."パスワード=".$password."<br>";	//変数確認
//echo var_dump()."<br>";	//変数の状況確認

//test editenum start
//echo "～test～"."<br>";
//	$passes = file($filename_pass,FILE_IGNORE_NEW_LINES);		//テキストファイルを配列として代入(ただし改行を避ける)
//	foreach((array)$passes as $a => $pas){				//変数を強制的に配列にするとともにその配列を要素ごとに$textに代入
//		$chara = explode("<>", $pas);				//$text内容を分割
//		$y = 0;
//		echo $pas."<br>";	//test
//		echo $chara[0]."?".$chara[1]."<br>";	//test
//		if($editenum == $chara[0] and $password == $chara[1]){		//パスワードが一致した条件
//			$y = 1;
//			break;					//一致したら、foreachから抜け出す
//		}
//	}
//	echo $y."<br>";
//echo "～test～"."<br>";
//test editenumnum end
function pass($num,$pass){						// パスワードの一致判別
	$filename_pass = 'mission_2-5_pass.txt';			//パスワード保存ファイル名
	$passes = file($filename_pass,FILE_IGNORE_NEW_LINES);		//テキストファイルを配列として代入(ただし改行を避ける)
	foreach((array)$passes as $a => $pas){				//変数を強制的に配列にするとともにその配列を要素ごとに$textに代入
		$chara = explode("<>", $pas);				//$text内容を分割
		$y = 0;
		if($num == $chara[0] and $pass == $chara[1]){		//パスワードが一致した条件
			$y = 1;
			break;						//一致したら、foreachから抜け出す
		}
	}
	return $y;
}

switch(situation($comment,$name,$deletenum,$editenum,$hiddennum,$password)){
	case(2):	//編集投稿時
//		echo "編集投稿"."<br>";	//test
		if(pass($editenum,$password) == 1){					//パスワード一致条件
			$texts= file($filename,FILE_IGNORE_NEW_LINES);			//テキストを読み込む
			$x = fopen($filename,'w');					//テキストを初期化
			fclose($x);
			foreach( $texts as $a =>  $text){					//テキストを一行ずつ取り出す
				$chara = explode("<>", $text);					//テキストを要素に分解
				if($hiddennum == $chara[0]){						//編集時は改めて出力
					$fp = fopen($filename, 'a');
					rewind($fp);
					fwrite($fp,$chara[0]."<>".$name."<>".$comment."<>".$time."\n");
					fclose($fp);
				}
				else{									//編集以外はそのまま出力
					$fp = fopen($filename, 'a');
					rewind($fp);
					fwrite($fp,$chara[0]."<>".$chara[1]."<>".$chara[2]."<>".$chara[3]."\n");
					fclose($fp);
				}
			}
			$texts= file($filename,FILE_IGNORE_NEW_LINES);			//再度テキストを読み込む
			foreach( $texts as $a =>  $text){					//配列を要素ごとに$textに代入
				$chara = explode("<>", $text);						//$text内容を分割
				echo $chara[0].$chara[1].$chara[2].$chara[3]."<br>";			//分割内容を出力
			}
		}
		else{								//パスワード不一致条件
			echo "この編集は無効です。"."<br>";
		}
		break;
	case(1):		//通常投稿
//		echo "通常投稿"."<br>";	//test
		$fp = fopen($filename, 'a');						//ファイルを開く
		$num = count(file($filename));				//配列数を数える
		$num = $num + 1;					//投稿番号の取得
		rewind($fp);								//ポインタを先頭にもってくる
		fwrite($fp,$num."<>".$name."<>".$comment."<>".$time."\n");		//形式通りに記入
		fclose($fp);								//ファイルを閉じる
	
		$fpass = fopen($filename_pass, 'a');					//パスワードファイルを開く
		rewind($fpass);								//ポインタを先頭にもってくる
		fwrite($fpass,$num."<>".$password."\n");				//形式通りに記入
		fclose($fpass);								//ファイルを閉じる

	
		$texts= file($filename,FILE_IGNORE_NEW_LINES);		//テキストファイルを配列として代入
		foreach( $texts as $a =>  $text){					//配列を要素ごとに$textに代入
			$chara = explode("<>", $text);						//$text内容を分割
			echo $chara[0].$chara[1].$chara[2].$chara[3]."<br>";			//分割内容を出力
		}
	break;
	case(4):		//削除
//		echo "削除"."<br>";		//test
		if(pass($deletenum,$password) == 1){				//パスワード一致条件
			$texts= file($filename,FILE_IGNORE_NEW_LINES);		//テキストを読み込む
			$x = fopen($filename,'w');				//テキストを初期化
			fclose($x);
			foreach( $texts as $a =>  $text){					//テキストを一行ずつ取り出す
				$chara = explode("<>", $text);					//テキストを要素に分解
				if($chara[0] == $deletenum){						//投稿番号が削除依頼番号と同じ時の条件
					echo "投稿番号".$chara[0]."の削除を実行しました。"."<br>";		//削除番号の表示
						//パスワードの削除
						$passes= file($filename_pass,FILE_IGNORE_NEW_LINES);		//パスワードファイルを配列として代入
						$fp = fopen($filename_pass, 'w');					//パスワードを初期化
						fclose($fp);
						foreach($passes as $a =>  $pas){					//配列を要素ごとに$textに代入
							$cha = explode("<>", $pas);						//$text内容を分割
							if($chara[0] == $cha[0]){
							}
							elseif($chara[0] > $cha[0]){						//投稿番号以前はそのまま出力
								$fp = fopen($filename_pass, 'a');
								rewind($fp);
								fwrite($fp,$cha[0]."<>".$cha[1]."\n");
								fclose($fp);
							}
							elseif($chara[0] < $cha[0]){						//投稿番号以降は投稿番号を一つ減らして出力
								$fp = fopen($filename_pass, 'a');
								$x = $cha[0]-1;						//削除番号以降は投稿番号を一つ減らす
								rewind($fp);
								fwrite($fp,$x."<>".$cha[1]."\n");
								fclose($fp);
							}
							else{									//投稿番号のときは何もしないと思ったが、
							}										//一つ上の階層で除かれていたので気にしない。
						}
				}
				else{									//投稿番号が削除依頼番号と違う時
					if($deletenum > $chara[0]){						//投稿番号以前はそのまま出力
						$fp = fopen($filename, 'a');
						rewind($fp);
						fwrite($fp,$chara[0]."<>".$chara[1]."<>".$chara[2]."<>".$chara[3]."\n");
						fclose($fp);
					}
					elseif($deletenum < $chara[0]){						//投稿番号以降は投稿番号を一つ減らして出力
						$fp = fopen($filename, 'a');
						$x = $chara[0]-1;						//削除番号以降は投稿番号を一つ減らす
						rewind($fp);
						fwrite($fp,$x."<>".$chara[1]."<>".$chara[2]."<>".$chara[3]."\n");
						fclose($fp);
					}
					else{									//投稿番号のときは何もしないと思ったが、
					}										//一つ上の階層で除かれていたので気にしない。
				}
			}
			$texts= file($filename,FILE_IGNORE_NEW_LINES);			//再度テキストを読み込む
			foreach( $texts as $a =>  $text){					//配列を要素ごとに$textに代入
				$chara = explode("<>", $text);					//$text内容を分割
				echo $chara[0].$chara[1].$chara[2].$chara[3]."<br>";		//分割内容を出力
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
