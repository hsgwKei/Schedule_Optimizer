<?php
//ユーザIDを受信, JSに値渡しの為のエンコード
$user_id = $_GET['user_id'];
$user_id = json_encode($user_id);

//入力(タスク名, きつさ)を配列に格納
for($i_task = 0; $i_task < 30; $i_task++){
    $task_name[$i_task] = $_POST['task_name'.$i_task];
    $task_weight[$i_task] = $_POST['weight'.$i_task];
    //空白のタスクの重さは999に設定．
    if($_POST['task_name'.$i_task]==''){
        $task_weight[$i_task] = 999;
    }
}

$task_name = array_values(array_diff($task_name, array(''))); //ここでtask_name=""の入力は排除
$task_weight = array_values(array_diff($task_weight, array(999))); //ここでtask_weight=999の入力は排除
$task_name = json_encode($task_name); //JSに値渡しの為のエンコード
$task_weight = json_encode($task_weight); //JSに値渡しの為のエンコード
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="static/style.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>スケージュール最適化</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./js/jquery-3.5.1.min.js"></script>
    <script src="./js/Sortable.min.js"></script>
    <script type="text/javascript">
        var user_id = JSON.parse('<?php echo $user_id; ?>');
        var task_name = JSON.parse('<?php echo $task_name; ?>');
        var task_weight = JSON.parse('<?php echo $task_weight; ?>');
    </script>
    <script type="text/javascript" src="./js/ScheduleOptimizer.js"></script>
</head>
<body>
    <a class="app-tytle">Schedule Optimizer</a>
    <div class="flex-column-center">
        <div class="card-body-main">
            <div class="txt-card-main">
                <p>最適化しました‼ タスクをドラッグ＆ドロップして修正することができます．</p>
                <p>修正後，スケジュールを登録してください．</p>
            </div>
            <form action="" method="POST">
                <div id="input_pluralBox">
                    <div class="flex-column-center" id="input_plural">
                        <div class="lists_wrap">
                            <ul class="list" id="list1" name="list">
                                <li class="a" id="li_id"></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="flex-column-center">
                    <input class="btn-reg" type="button" name="btn-reg" value="このスケジュールで登録する">
                </div>
            </form>
        </div>
    </div>
</body>
</html>