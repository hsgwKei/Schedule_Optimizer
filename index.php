<?php
//DBにテーブル(ログイン情報用, スケジュール登録用)を作成
//テーブルが既に作成されていたら何もしない
include('create_table.php');

//ログイン画面に遷移
include('login.php');
?>
