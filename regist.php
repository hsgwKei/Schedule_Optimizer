<?php
//ユーザID, パスワード, 確認用パスワードを受信
$user_id = $_POST['user_id'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

$error_msg = ''; //エラーメッセージ用
$save_flg = FALSE; //新規登録可能かの判断用フラグ

//新規登録ボタン押下後の登録情報を基に新規登録可能か判断する(存在しない：$save_flg=TRUE)
if(isset($_POST['sign_up'])){
    //DB情報
    $db_dsn      = 'mysql:dbname=heroku_21cd91a4ab64864;host=us-cdbr-east-03.cleardb.com'; //dname:DB名, host:ホスト名
    $db_user     = 'b2f23a6bfef325'; //DBのユーザ名
    $db_password = '4a17af6b'; //DBのパスワード
    /*$db_dsn      = 'mysql:dbname=test;host=localhost:3307'; //dname:DB名, host:ホスト名
    $db_user     = 'root'; //DBのユーザ名
    $db_password = ''; //DBのパスワード*/

    //1.ユーザIDが8文字以上か判断
    //2.ユーザIDがDB内で重複しないか判断
    //3.パスワードが8文字以上か判断
    //4.パスワードが確認用パスワードと一致するか判断
    $dbh = new PDO($db_dsn, $db_user, $db_password);
    if(strlen($user_id) >= 8){
        //ユーザIDがDB内に無いか検索
        $sql = 'SELECT * FROM guests';
        $stmt = $dbh->query($sql);
        $userid_absence = TRUE;
        foreach ($stmt as $row) {
            if($row['user_id'] == $user_id){
                $userid_absence = FALSE;
            }
        }
        if($userid_absence){
            if(strlen($password) >= 8){
                if($password == $password_confirm){
                    $save_flg = TRUE;
                }
                else{
                    $error_msg = '※ パスワードが確認用と一致しません.';
                }
            }
            else{
                $error_msg = '※ パスワードが短いです. 半角英数字8文字以上で入力してください.';
            }
        }
        else{
            $error_msg = '※ ユーザーIDは既に存在しています.';
        }
    }
    else{
        $error_msg = '※ ユーザーIDが短いです. 半角英数字8文字以上で入力してください.';
    }
    // 接続を閉じる
    $dbh = null;
}

//新規登録可能な場合
if($save_flg){
    //DB情報
    $db_dsn      = 'mysql:dbname=heroku_21cd91a4ab64864;host=us-cdbr-east-03.cleardb.com'; //dname:DB名, host:ホスト名
    $db_user     = 'b2f23a6bfef325'; //DBのユーザ名
    $db_password = '4a17af6b'; //DBのパスワード
    /*$db_dsn      = 'mysql:dbname=test;host=localhost:3307'; //dname:DB名, host:ホスト名
    $db_user     = 'root'; //DBのユーザ名
    $db_password = ''; //DBのパスワード*/

    //登録情報をDBに保存
    try{
        $dbh = new PDO($db_dsn, $db_user, $db_password);
        $sql = 'INSERT INTO guests (user_id, password, created) VALUES (:user_id, :password, now())';
        $stmt = $dbh->prepare($sql);
        $params = array(':user_id' => $user_id, ':password' => $password);
        $stmt->execute($params);
    }
    catch(PDOException $e){ //接続エラー時
        print("データベースの接続に失敗しました".$e->getMessage());
        die();
    }

    $dbh = null; //接続を閉じる
    //メニュー画面に遷移
    $url = './menu.php?user_id='.$user_id;
    header('Location:'.$url);
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="static/style.css">
    <title>新規登録</title>
    <script type="text/javascript">
        //半角英数字
        function checkForm($this){
            var str=$this.value;
            while(str.match(/[^A-Z^a-z\d\-]/))
            {
                str=str.replace(/[^A-Z^a-z\d\-]/,"");
            }
            $this.value=str;
        }
    </script>
</head>
<body>
    <a class="app-tytle">Schedule Optimizer</a>
    <div class="flex-column-center">
        <div class="card-body-signup">
            <h4 class="login-tytle">アカウントの新規作成</h4>
            <form action="" method="POST">
                <dl class="login-text">
                    <dt>ユーザーID</dt>
                    <dd><input type="text" class="sign_up-input" name="user_id" placeholder="半角英数字8文字以上で入力してください (a~z, A~Z, 数字, - のみ可)" onInput="checkForm(this)"></dd>
                    <dt>パスワード</dt>
                    <dd><input type="password" class="sign_up-input" name="password" placeholder="半角英数字8文字以上で入力してください (a~z, A~Z, 数字, - のみ可)" onInput="checkForm(this)"></dd>
                    <dt>パスワード(確認用)</dt>
                    <dd><input type="password" class="sign_up-input" name="password_confirm" placeholder="半角英数字8文字以上で入力してください (a~z, A~Z, 数字, - のみ可)"></dd>
                </dl>
                <a class="err-msg"><?php echo $error_msg; ?></a>
                <div class="flex-column-center">
                    <input class="btn-login" type="submit" name="sign_up" value="アカウントを作成する">
                </div>
                <p class="flex-column-right">
                    <a class="txt-signup" href='./login.php'>ログイン画面に戻る</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>