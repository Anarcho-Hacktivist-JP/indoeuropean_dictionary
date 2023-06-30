<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_verb_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Polish_Common.php");

// 挿入データ－動詞の種別－
$verb_type = trim(filter_input(INPUT_POST, 'verb-type'));
// 挿入データ－人称－
$person = trim(filter_input(INPUT_POST, 'person'));
// 挿入データ－法－
$mood = trim(filter_input(INPUT_POST, 'mood'));
// 挿入データ－相－
$aspect = trim(filter_input(INPUT_POST, 'aspect'));

// 単語取得
$question_word = Polish_Common::get_random_verb($verb_type, $aspect);
// 読み込み
$polish_verb = new Polish_Verb($question_word["dictionary_stem"]);
// 問題集生成
$question_data = $polish_verb->get_conjugation_form_by_each_condition($person, $mood);
?>
<!doctype html>
<html lang="ja">
  <head>
    <title>印欧語活用辞典：ポーランド語動詞練習</title>
    <?php require_once("polish_including.php"); ?>
  </head>
  <body>
    <?php require_once("polish_header.php"); ?>
    <div class="container item">
      <form action="" method="post" class="mt-2 js-form-storage" id="practice-condition" name="practice_condition">
        <?php echo Polish_Common::verb_type_selection_button(); ?>
        <?php //echo Polish_Common::adjective_gender_selection_button(); ?>
        <?php echo Polish_Common::aspect_selection_button(); ?>        
        <?php echo Polish_Common::mood_selection_button(true); ?>
        <?php echo Polish_Common::person_selection_button(true); ?>        
        <input class="input js-persist" type="checkbox" name="save" /><span class="label-title">送信時に条件を保存する</span>
        <input type="submit" class="btn-check" id="btn-search">
        <label class="btn btn-outline-secondary" for="btn-search">問題を生成</label>
      </form>
      <script src="https://unpkg.com/form-storage@latest/build/form-storage.js"></script>
      <script>
        var storage = new FormStorage('.js-form-storage',{
          name: 'form-storage-pol-verb',
          checkbox: '.js-persist'
        });
      </script>       
      <p><?php echo $question_data['question_sentence']; ?></p>
      <section class="row mb-3 textBox"> 
        <div class="input-group col-md-3 mb-0">
          <input type="text" class="form-control" aria-describedby="basic-addon2" id="input-answer" placeholder="答えを入れる">
          <button class="btn btn-outline-secondary" type="button" id="button-answer">答え合わせ</button>
        </div>
        <div class="input-group-append col-md-4 mb-0">
          <?php echo Polish_Common::input_special_button(); ?>
        </div>
      </section> 
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

        //イベントを設定
        function setEvents(){
	        // 回答ボタン選択時
	        $('#button-answer').click( function(){
            // 答えを出す
            Language_Practice.answer_the_question();
	        });
          // ボタンにイベントを設定
          Input_Botton.SanskritBotton('#input-answer');
        }

    </script>      
    </script>
  </body>
</html>