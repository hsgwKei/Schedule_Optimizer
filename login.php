<?php
//ユーザIDとパスワードの受信
$user_id = $_POST['user_id'];
$password = $_POST['password'];

$error_msg = ''; //エラーメッセージ用
$msg_num = 0;
$login_flg = FALSE; //ログイン可能かの判断用フラグ

if(isset($_POST['login'])){
    //DB情報
    $db_dsn      = 'mysql:dbname=heroku_21cd91a4ab64864;host=us-cdbr-east-03.cleardb.com'; //dname:DB名, host:ホスト名
    $db_user     = 'b2f23a6bfef325'; //DBのユーザ名
    $db_password = '4a17af6b'; //DBのパスワード
    /*$db_dsn      = 'mysql:dbname=test;host=localhost:3307'; //dname:DB名, host:ホスト名
    $db_user     = 'root'; //DBのユーザ名
    $db_password = ''; //DBのパスワード*/
    
    try{
        //ユーザーIDを参照し，パスワード照合
        $dbh = new PDO($db_dsn, $db_user, $db_password);
        $sql = 'SELECT * FROM guests';
        $stmt = $dbh->query($sql);
        foreach ($stmt as $row) {
            if($row['user_id'] == $user_id){ //ユーザIDがDBに存在しない
                if($row['password'] == $password){ //パスワードが一致
                    $login_flg = TRUE; //ログイン可のフラグ
                    $msg_num = 2;
                }
                else{ //パスワード不一致
                    $msg_num = 1;
                }
            }
        }

        switch($msg_num){
            case 0: //ユーザIDがDBに存在しない場合
                $error_msg = 'ユーザーIDが間違っているようです．';
                break;
            case 1: //パスワード不一致の場合
                $error_msg = 'パスワードが間違っているようです．';
                break;
            case 2: //ユーザID存在かつパスワード一致(ログイン可)
                $error_msg = '';
                break;
        }
    }
    catch(PDOException $e){ //接続エラー時
        print("データベースの接続に失敗しました".$e->getMessage());
        die();
    }

    if($login_flg){
        $dbh = null; //接続を閉じる
        //メニュー画面に遷移
        $url = './menu.php?user_id='.$user_id;
        header('Location:'.$url);
        exit;
    }
    else{
        $dbh = null; //接続を閉じる
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="static/style.css">
    <title>ログイン画面</title>
</head>
<body>
    <a class="app-tytle">Schedule Optimizer</a>
    <div class="flex-column-center">
        <div class="card-body-login">
            <h4 class="login-tytle">ログイン</h4>
            <form action="" method="POST">
                <dl class="login-text">
                    <dt>ユーザーID</dt>
                    <dd><input type="text" class="login-input" name="user_id"></dd>
                    <dt>パスワード</dt>
                    <dd></dd><input type="password" class="login-input" name="password"></dd>
                </dl>
                <a class="err-msg"><?php echo $error_msg; ?></a>
                <div class="flex-column-center">
                    <input class="btn-login" type="submit" name="login" value="ログイン">
                </div>
                <p class="flex-column-right">
                    <a class="txt-signup" href='./regist.php'>アカウントを新規作成</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>