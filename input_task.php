<?php
//ユーザIDを受信
$user_id = $_GET['user_id'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="static/style.css">
    <title>タスク登録</title>
    <script src="./js/jquery-3.5.1.min.js"></script>
    <script>
        var n_input = 1; //現在のタスク入力欄数
        
        //プラスボタンでタスク入力欄を1つ追加
        $(document).on("click", ".add", function() {
            if(n_input < 30){
                n_input++;
                var target = $(this).parent().clone(true).insertAfter($(this).parent());
            }
        });
        
        //-ボタンでタスク入力欄を1つ削除
        $(document).on("click", ".del", function() {
            var target = $(this).parent();
            if(target.parent().children().length > 1) {
                target.remove();
                n_input--;
            }
        });
        
        //submitするべきかチェック
        function checkSubmit(){

            //3つ以上のタスクを入力しているか
            if(n_input < 3){
                alert('タスクは3つ以上登録してください．');
                return false; //submit中断
            }

            //タスクのきつさが全て同じになっていないか
            var weights = [];
            $('.input-tsk-weight').each(function(){
                weights.push($(this).val());
            });
            if(weights.every(v => v === weights[0])){
                alert('タスクのきつさは全て同じにしないでください．');
                return false; //submit中断
            }

            //タスク名とタスクのきつさに添え字付きnameをふる(それぞれの入力欄を識別するため)
            var N_task = $('.form-control').length;
            for(let i_task = 0; i_task < N_task; i_task++){
                var target_main = $('#input_pluralBox');
                var target = target_main.children('div').eq(i_task).attr('name', 'task' + i_task);
                target.children('.form-control').attr('name','task_name'+i_task);
                target.children('.input-tsk-weight').attr('name','weight'+i_task);
            }
            
            return true; //submit
        }
    </script>
</head>
<body>
    <a class="app-tytle">Schedule Optimizer</a>
    <div class="flex-column-center">
        <div class="card-body-main">
            <div class="txt-card-main">
                <p>タスク名の記入とそのタスクのきつさを設定してください(3~30タスク設定できます)</p>
                <p>＋ボタンで入力欄を増やすことができます．-ボタンで削除できます．</p>
            </div>
            <form action=<?php echo "./optimize_schedule.php?user_id=".$user_id ?> method="POST" onsubmit="return checkSubmit();">
                <div id="input_pluralBox">
                    <div class="flex-column-center" id="input_plural">
                        <input type="text" class="form-control" placeholder="タスク名">
                        <p>きつくない</p><input class="input-tsk-weight" type="range"><p class="txt-tsk-weight">きつい</p>
                        <input type="button" value="＋" class="add pluralBtn">
                        <input type="button" value="－" class="del pluralBtn">
                    </div>
                </div>
                <div class="flex-column-center">
                    <input class="btn-reg" id="btn-reg" type="submit" name="task_reg" value="タスクを登録／最適化する">
                </div>
            </form>
        </div>
    </div>
</body>
</html>