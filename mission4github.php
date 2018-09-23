<!DOCTYPE html>
<html lang = "ja">
<head>
	<meta charset = "UTF-8">
</head>
<body>

<?php
mb_internal_encoding("UTF-8");
$dsn = 'ユーザー名';
$user = 'データベース名';
$password ='パスワード';
//データベースに接続
$pdo = new PDO($dsn,$user,$password);
//テーブルの作成
$sql="CREATE TABLE IF NOT EXISTS mission4"
."("
."id INT not null auto_increment primary key,"
."name char(32),"
."comment TEXT,"
."pass TEXT,"
."date timestamp not null default current_timestamp"
.");";
$stmt = $pdo->query($sql);

//編集
if(!empty($_POST['edit']) and !empty($_POST['pass_edit'])){
//条件が一致したとき
	$sql = 'SELECT * FROM mission4';
	$results = $pdo -> query($sql);
	foreach ($results as $row){
	if($row['id'] == $_POST['edit'] and $row['pass'] == $_POST['pass_edit']){
	$_POST['line'] = $row['id'];
	$_POST['name'] = $row['name'];
	$_POST['comment'] = $row['comment'];
	}
	}
}
//編集処理
if(!empty($_POST['name']) and !empty($_POST['comment']) and !empty($_POST['pass']) and !empty($_POST['line'])){
$id = $_POST['line'];
$nm = $_POST['name'];
$kome =  $_POST['comment'];
$pas =  $_POST['pass'];
$date = date("Y/m/d H:i:s");
$sql = "update mission4 set name='$nm' , comment='$kome',pass='$pas',date ='$date' where id = $id";
$result = $pdo->query($sql);
//バグや表示されっぱなし防止のため
$_POST['name'] ="";
$_POST['comment'] ="";
$_POST['line'] ="";
$_POST['pass'] ="";
}
//新規投稿　4-1テーブル名
if(!empty($_POST['name']) and !empty($_POST['comment']) and !empty($_POST['pass'])){
$sql = $pdo -> prepare("INSERT INTO mission4(name,comment,pass,date) VALUES(:name,:comment,:pass,:date)");
$sql -> bindParam(':name',$name,PDO::PARAM_STR);
$sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
$sql -> bindParam(':pass',$pass,PDO::PARAM_STR);
$sql -> bindParam(':date',$date,PDO::PARAM_STR);
$name = $_POST["name"];
$comment = $_POST["comment"];
$pass = $_POST["pass"];
$date = date("Y/m/d H:i:s");
$sql-> execute();
$_POST['name'] ="";
$_POST['comment'] ="";
$_POST['pass'] ="";
}
?>
 <form  action="mission4.php"method="POST" >  
	<!-- 書き込み用フォーム -->
	<p>名前:<input type = "text" name = "name" value = "<?=$_POST['name'];?>"></p>
	<p>コメント:<input type = "text" name = "comment"value = "<?=$_POST['comment'];?>"></p>
	<p>パスワード:<input type = "password" name = "pass"value = "<?=$_POST['pass'];?>"></p>
	<input type = "hidden" name = "line" value = "<?=$_POST['line'];?>">
	<input type = "submit" value = "送信">
	<br/>

	<!-- 削除用フォーム -->	
	<p>削除番号:<input type="text" name="delete"></p>
	パスワード<input type="text" name="pass_delete">
	<input type="submit"value="削除">
 
	<!-- 編集用フォーム -->	
	<p>編集対象番号:<input type"text" name="edit"><p/>
	パスワード<input type="text" name="pass_edit">
	<input type="submit"value="編集">
 </form>
<?php
//削除
if(!empty($_POST['delete']) and !empty($_POST['pass_delete'])){
	$sql = 'SELECT * FROM mission4 order by id';
	$results = $pdo -> query($sql);
	//削除番号の取得
	$number = $_POST['delete'];
	//パスワード取得
	$pass2 =  $_POST['pass_delete'];
	foreach ($results as $row){
	if($row['id'] == $number and $row['pass'] == $pass2){
	$gg = $row['id'];
	$sql = "delete from mission4 where id=$gg";
	$result = $pdo->query($sql);
	}
	}
}

//ブラウザ表示
$sql = 'SELECT * FROM mission4 ORDER BY id';
$results = $pdo -> query($sql);
foreach ($results as $row){

echo $row['id'].',';
echo $row['name'].',';
echo $row['comment'].',';
echo $row['date'].'<br>';
}
?>
 
</body>
</html>
