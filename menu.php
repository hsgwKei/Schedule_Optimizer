<?php
//ユーザIDを受信
$user_id = $_GET['user_id'];

//タスク登録画面に遷移
if(isset($_POST['btn-menu-task'])){
    $url = './input_task.php?user_id='.$user_id;
    header('Location:'.$url);
    exit;
}
//マイスケジュール画面に遷移
if(isset($_POST['btn-menu-sche'])){
    $url = './my_schedule.php?user_id='.$user_id;
    header('Location:'.$url);
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="static/style.css">
    <title>メニュー</title>
</head>
<body>
    <a class="app-tytle">Schedule Optimizer</a>
    <div class="flex-column-center">
        <a class="txt-menu">ようこそ, <?php echo $user_id; ?> さん！</a>
    </div>
    <div class="flex-column-center">
        <div class="card-body-menu">
            <h4 class="login-tytle">メニュー</h4>
            <form acrion="" method="POST">
                <div class="flex-column-center">
                    <input type="submit" class="btn-menu-task" name="btn-menu-task" value="タスク登録">
                    <input type="submit" class="btn-menu-sche" name="btn-menu-sche" value="マイスケジュール">
                </div>
            </form>
            <p class="flex-column-right">
                <a class="signout-menu" href='./login.php'>サインアウト</a>
            </p>
        </div>
    </div>
</body>
</html>