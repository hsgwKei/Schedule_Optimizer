<?php
//ScheduleOptimizer.js からユーザIDと最適化後のタスク順序を受信
header("Content-Type: application/json; charset=UTF-8");
$user_id = $_POST['user_id'];
$tasks = $_POST['tasks'];

//DB情報
$db_dsn      = 'mysql:dbname=heroku_21cd91a4ab64864;host=us-cdbr-east-03.cleardb.com'; //dname:DB名, host:ホスト名
$db_user     = 'b2f23a6bfef325'; //DBのユーザ名
$db_password = '4a17af6b'; //DBのパスワード
/*$db_dsn      = 'mysql:dbname=test;host=localhost:3307'; //dname:DB名, host:ホスト名
$db_user     = 'root'; //DBのユーザ名
$db_password = ''; //DBのパスワード*/

//最適化後のタスク順序をマイスケジュールとしてDBに保存
try{

    //ユーザID，タスク名，タイムスタンプをDB保存
    $dbh = new PDO($db_dsn, $db_user, $db_password);
    $sql = 'INSERT INTO task 
    (user_id,
    task0, task1, task2, task3, task4,
    task5, task6, task7, task8, task9,
    task10, task11, task12, task13, task14,
    task15, task16, task17, task18, task19,
    task20, task21, task22, task23, task24,
    task25, task26, task27, task28, task29,
    created)
    VALUES 
    (:user_id, 
    :task0, :task1, :task2, :task3, :task4,
    :task5, :task6, :task7, :task8, :task9,
    :task10, :task11, :task12, :task13, :task14,
    :task15, :task16, :task17, :task18, :task19,
    :task20, :task21, :task22, :task23, :task24,
    :task25, :task26, :task27, :task28, :task29,
    now())';
    $stmt = $dbh->prepare($sql);
    $params = array(':user_id' => $user_id);
    for($i_task = 0; $i_task < count($tasks); $i_task++){
        $params = array_merge($params, array(':task'.$i_task => $tasks[$i_task]));
    }
    for($i_task = count($tasks); $i_task < 30; $i_task++){
        $params = array_merge($params, array(':task'.$i_task => ''));
    }
    $stmt->execute($params);
}
catch(PDOException $e){ //接続エラー時
    print("データベースの接続に失敗しました".$e->getMessage());
    die();
}
$dbh = null;

//ScheduleOptimizer.js へユーザIDを渡す
echo json_encode($user_id);
exit;
?>