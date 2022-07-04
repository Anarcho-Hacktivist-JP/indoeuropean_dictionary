<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/language_class/IndoEuropean_adjective_class.php");
include(dirname(__FILE__) . "/language_class/Database_session.php");
include(dirname(__FILE__) . "/language_class/Commons.php");
include(dirname(__FILE__) . "/language_class/Polish_Common.php");

// 挿入データ－性別－
$gender = trim(filter_input(INPUT_POST, 'gender'));
// 挿入データ－活用種別－
$declension = trim(filter_input(INPUT_POST, 'declension'));
// 挿入データ－数－
$number = trim(filter_input(INPUT_POST, 'number'));
// 挿入データ－格－
$case = trim(filter_input(INPUT_POST, 'case'));

// 単語取得
$question_word = Polish_Common::get_random_adjective($declension);
// 読み込み
$adjective_polish = new Polish_Adjective($question_word["dictionary_stem"]);
// 問題集生成
$question_data = $adjective_polish->get_form_by_number_case_gender_grade($case, $number, $gender, Commons::$ADJ_GRADE_POSITIVE);
?>
<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>印欧語活用辞典：羅和辞書</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
  </head>
  <?php require_once("header.php"); ?>
  <body>
    <div class="container item">
      <form action="" method="post" class="mt-2 js-form-storage" id="practice-condition" name="practice_condition">
        <?php echo Polish_Common::adjective_gender_selection_button(); ?>
        <?php echo Polish_Common::adjective_declension_type_selection_button(); ?>
        <?php echo Polish_Common::number_selection_button(); ?> 
        <?php echo Polish_Common::case_selection_button(); ?>         
        <input class="input js-persist" type="checkbox" name="save" /><span class="label-title">送信時に条件を保存する</span>
        <input type="submit" class="btn-check" id="btn-search">
        <label class="btn btn-outline-secondary" for="btn-search">問題を生成</label>
      </form>
      <script src="https://unpkg.com/form-storage@latest/build/form-storage.js"></script>
      <script>
        var storage = new FormStorage('.js-form-storage',{
          name: 'form-storage-pol-adj',
          checkbox: '.js-persist'
        });
      </script>     
      <p><?php echo $question_data['question_sentence']; ?></p>
      <div class="input-group mb-3">
        <input type="text" class="form-control" aria-describedby="basic-addon2" id="input-answer">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="button" id="button-answer">Button</button>
        </div>       
      </div>      
      <?php echo Polish_Common::input_special_button(); ?>   
    </div>
  <footer class="">
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        var question_data = '<?php echo json_encode($question_data, JSON_UNESCAPED_UNICODE); ?>';
    </script>
    <script>
        $(function(){
          // イベントを設定
          setEvents();
        });

        function answer_the_question(){
          var answer = $('#input-answer').val();

          // JSON → 配列に書き換え
          var json_question_data = JSON.parse(question_data);          

          if(answer == json_question_data['answer']){
            alert("正解");
            location.reload();
          } else {
            alert("不正解");            
          }
        }

        // 入力ボックスに文字の挿入
        function add_chara(str, selIdx)
        {
          // テキストボックスの値を取得
          var text_sentence = $('#input-answer').val();
          $('#input-answer').val(strIns(text_sentence, selIdx, str));
        }

        // 文字列の挿入
        function strIns(str, idx, val){
          var res = str.slice(0, idx) + val + str.slice(idx);
          return res;
        };

        //イベントを設定
        function setEvents(){
	        // セレクトボックス選択時
	        $('#button-answer').click( function(){
            answer_the_question();
	        });
	        // ボタン入力
	        $('#button-a').click( function(){
            // カーソル位置
            var selIdx = $('#input-answer').get(0).selectionStart;
            // 挿入
            add_chara($(this).val(), selIdx);
	        });
	        $('#button-c').click( function(){
            // カーソル位置
            var selIdx = $('#input-answer').get(0).selectionStart;
            // 挿入
            add_chara($(this).val(), selIdx);
	        });
	        $('#button-e').click( function(){
            // カーソル位置
            var selIdx = $('#input-answer').get(0).selectionStart;
            // 挿入
            add_chara($(this).val(), selIdx);
	        }); 
	        $('#button-l').click( function(){
            // カーソル位置
            var selIdx = $('#input-answer').get(0).selectionStart;
            // 挿入
            add_chara($(this).val(), selIdx);
	        });
	        $('#button-n').click( function(){
            // カーソル位置
            var selIdx = $('#input-answer').get(0).selectionStart;
            // 挿入
            add_chara($(this).val(), selIdx);
	        });
	        $('#button-o').click( function(){
            // カーソル位置
            var selIdx = $('#input-answer').get(0).selectionStart;
            // 挿入
            add_chara($(this).val(), selIdx);
	        }); 
	        $('#button-s').click( function(){
            // カーソル位置
            var selIdx = $('#input-answer').get(0).selectionStart;
            // 挿入
            add_chara($(this).val(), selIdx);
	        });
	        $('#button-z1').click( function(){
            // カーソル位置
            var selIdx = $('#input-answer').get(0).selectionStart;
            // 挿入
            add_chara($(this).val(), selIdx);
	        });
	        $('#button-z2').click( function(){
            // カーソル位置
            var selIdx = $('#input-answer').get(0).selectionStart;
            // 挿入
            add_chara($(this).val(), selIdx);
	        });                                      
        }

    </script>      
    </script>
  </body>
</html>