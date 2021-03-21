<?php
//ユーザIDを受信
$user_id = $_GET['user_id'];

//DB情報
$db_dsn      = 'mysql:dbname=heroku_21cd91a4ab64864;host=us-cdbr-east-03.cleardb.com'; //dname:DB名, host:ホスト名
$db_user     = 'b2f23a6bfef325'; //DBのユーザ名
$db_password = '4a17af6b'; //DBのパスワード
/*$db_dsn      = 'mysql:dbname=test;host=localhost:3307'; //dname:DB名, host:ホスト名
$db_user     = 'root'; //DBのユーザ名
$db_password = ''; //DBのパスワード*/

//ユーザIDを基にユーザの最新のマイスケジュールを表示
try{
    $dbh = new PDO($db_dsn, $db_user, $db_password);
    //ユーザのスケジュールデータのみ取得
    $sql = 'SELECT * FROM task WHERE user_id = "'.$user_id.'" order by id desc limit 1';
    $stmt = $dbh->query($sql);

    //最新のマイスケジュールを配列に格納
    $my_schedule = [];
    foreach ($stmt as $key => $row) {
        for($i_task = 0; $i_task < 30; $i_task++){
            $my_schedule = array_merge($my_schedule, array($row['task'.$i_task]));
        }
        $created = $row['created'];
    }
    $my_schedule = array_values(array_diff($my_schedule, array(''))); //タスク名=""のタスクを削除
    $created = json_encode($created); //タイムスタンプをJSに値渡すためにエンコード
    $my_schedule = json_encode($my_schedule); //マイスケジュールをJSに値渡すためにエンコード
}
catch(PDOException $e){ //接続エラー時
    print("データベースの接続に失敗しました".$e->getMessage());
    die();
}

$dbh = null; //接続を閉じる
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="static/style.css">
    <title>スケージュール最適化</title>
    <script>
        var my_schedule = JSON.parse('<?php echo $my_schedule; ?>');
        var created = JSON.parse('<?php echo $created; ?>');
    </script>
    <script src="./js/jquery-3.5.1.min.js"></script>
    <script>
        $(function(){
            if(my_schedule.length == 0){
                $('.non-data-msg').html('データがありません．<br>メニューに戻り，『タスク登録』から本日のタスクを登録してください．');
                $('#input_pluralBox').hide();
            }
            else{
                $('.non-data-msg').html(created + ' (+09:00:00) に登録したスケジュールです．');
            }
            var target = $('#li_id');
            target.text(my_schedule[0]).attr('name', 0);
            for(let i = 1; i < my_schedule.length; i++){
                target.clone(true).insertBefore(target.text(my_schedule[i]).attr('name', i));
            }
        });
    </script>
</head>
<body>
    <a class="app-tytle">Schedule Optimizer</a>
    <div class="flex-column-center">
        <div class="card-body-main">
            <form action method="POST">
                <div class="flex-column-center">
                    <p class="txt-your-schedule">YOUR SCHEDULE</p>
                </div>
                <div class="flex-column-center">
                    <p class="non-data-msg"></P>
                </div>
                <div id="input_pluralBox">
                    <div class="flex-column-center" id="input_plural">
                        <div class="lists_wrap">
                            <ul class="list" id="list1">
                                <li class="a" id="li_id"></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="b1"></div>
                <div class="flex-column-center">
                    <input class="btn-reg" type="submit" formaction=<?php echo "./menu.php?user_id=".$user_id ?> value="メニューに戻る">
                </div>
            </form>
        </div>
    </div>
</body>
</html>