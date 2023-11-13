<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_adjective_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Latin_Common.php");

// 挿入データ－活用種別－
$declension = trim(filter_input(INPUT_POST, 'declension'));

// 単語取得
$question_word = Latin_Common::get_random_adjective($declension);
// 読み込み
$adjective_latin = new Latin_Adjective($question_word["dictionary_stem"]);
// 問題集生成
$question_data = $adjective_latin->get_form_by_number_case_gender_grade("", "", "", Commons::ADJ_GRADE_POSITIVE);
?>
<!doctype html>
<html lang="ja">
  <head>
    <?php require_once("latin_including.php"); ?>
    <title>印欧語活用辞典：ラテン語形容詞練習</title>
  </head>
  <?php require_once("latin_header.php"); ?>
  <body>
    <div class="container item">
      <form action="" method="post" class="mt-2 js-form-storage" id="practice-condition" name="practice_condition">
        <?php echo Latin_Common::adjective_declension_type_selection_button(); ?> 
        <input class="input js-persist" type="checkbox" name="save" /><span class="label-title">送信時に条件を保存する</span>
        <input type="submit" class="btn-check" id="btn-search">
        <label class="btn btn-outline-secondary" for="btn-search">問題を生成</label>
      </form>
      <script src="https://unpkg.com/form-storage@latest/build/form-storage.js"></script>
      <script>
        var storage = new FormStorage('.js-form-storage',{
          name: 'form-storage-lat-adj2',
          checkbox: '.js-persist'
        });
      </script>     
      <p><?php echo $question_data['question_sentence2']; ?></p>
      <div class="mt-2 js-form-storage textBox">
        <?php echo Latin_Common::adjective_gender_selection_button(); ?>
        <?php echo Latin_Common::number_selection_button(); ?> 
        <?php echo Latin_Common::case_selection_button(); ?>        
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="button" id="button-answer">答え合わせ</button>
        </div>       
      </div>
    </div>
  <footer class="">
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        var question_data = '<?php echo json_encode($question_data, JSON_UNESCAPED_UNICODE); ?>';
    </script>
	  <script type="text/javascript" src="/../js/input_button.js"></script>
    <script>
        $(function(){
          // イベントを設定
          setEvents();
        });

        //イベントを設定
        function setEvents(){
	        // 回答ボタン選択時
	        $('#button-answer').click( function(){
            // 答えを出す
            Language_Practice.answer_the_question_adjective();
	        });
        }
    </script>      
    </script>
  </body>
</html>