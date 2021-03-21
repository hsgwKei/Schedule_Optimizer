<?php
//DB情報
$db_dsn      = 'mysql:dbname=heroku_21cd91a4ab64864;host=us-cdbr-east-03.cleardb.com'; //dname:DB名, host:ホスト名
$db_user     = 'b2f23a6bfef325'; //DBのユーザ名
$db_password = '4a17af6b'; //DBのパスワード
/*$db_dsn      = 'mysql:dbname=test;host=localhost:3307'; //dname:DB名, host:ホスト名
$db_user     = 'root'; //DBのユーザ名
$db_password = ''; //DBのパスワード*/

//ログイン情報用DBの作成
$sql = 'CREATE TABLE IF NOT EXISTS guests (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(20),
    password VARCHAR(20),
    created TIMESTAMP
) ';
try{
    // DBへ接続
    $dbh = new PDO($db_dsn, $db_user, $db_password);
    $dbh->setAttribute(PDO :: ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO :: ATTR_ERRMODE, PDO :: ERRMODE_EXCEPTION);
    $dbh->query($sql);
}
catch(PDOException $e){ //テーブル作成エラー時
    print("データベースの接続に失敗しました".$e->getMessage());
    die();
}
$dbh = null; //接続を閉じる

//スケジュール登録用DBの作成
$sql = 'CREATE TABLE IF NOT EXISTS task (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(20),
    task0 VARCHAR(100), task1 VARCHAR(100), task2 VARCHAR(100), task3 VARCHAR(100), task4 VARCHAR(100),
    task5 VARCHAR(100), task6 VARCHAR(100), task7 VARCHAR(100), task8 VARCHAR(100), task9 VARCHAR(100),
    task10 VARCHAR(100), task11 VARCHAR(100), task12 VARCHAR(100), task13 VARCHAR(100), task14 VARCHAR(100),
    task15 VARCHAR(100), task16 VARCHAR(100), task17 VARCHAR(100), task18 VARCHAR(100), task19 VARCHAR(100),
    task20 VARCHAR(100), task21 VARCHAR(100), task22 VARCHAR(100), task23 VARCHAR(100), task24 VARCHAR(100),
    task25 VARCHAR(100), task26 VARCHAR(100), task27 VARCHAR(100), task28 VARCHAR(100), task29 VARCHAR(100),
    created TIMESTAMP
) ';
try{
    // DBへ接続
    $dbh = new PDO($db_dsn, $db_user, $db_password);
    $dbh->setAttribute(PDO :: ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO :: ATTR_ERRMODE, PDO :: ERRMODE_EXCEPTION);
    $dbh->query($sql);
}
catch(PDOException $e){ //テーブル作成エラー時
    print("データベースの接続に失敗しました".$e->getMessage());
    die();
}
$dbh = null; //接続を閉じる
?>