<?php

//データベースに接続する。
function set_DB_session(){
	try
	{
		//データベースに接続するために必要なデータソースを変数に格納
		//mysql:host=ホスト名;dbname=データベース名;charset=文字エンコード
		$dsn = "mysql:host=mysql;dbname=test;charset=utf8mb4";

		//データベースのユーザー名
		$user = "test";

		//データベースのパスワード
		$password = "test";
	    // PDOインスタンスを生成
	    $db_host = new PDO($dsn,$user,$password);
	    // 結果を返す。
	    return $db_host;
	} 
	catch (PDOException $e)
	{
	    // エラーメッセージを表示させる
	    echo $e->getMessage();
	    error_log($e->getMessage());
	    // 強制終了
	    die();
	}
}
?>