<?php
session_start();
header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_noun_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Sanskrit_Common.php");

// 挿入データ－性別－
$gender = trim(filter_input(INPUT_POST, 'gender'));
// 挿入データ－活用種別－
$declension = trim(filter_input(INPUT_POST, 'declension'));

// 単語を検索
$question_word = Sanskrit_Common::get_random_noun($gender, $declension);
// 読み込み
$vedic_noun = new Vedic_Noun($question_word["dictionary_stem"]);
// 問題集生成
$question_data = $vedic_noun->get_form_by_number_case("", "");
?>
<!doctype html>
<html lang="ja">
  <head>
    <?php require_once("sanskrit_including.php"); ?>
    <title>印欧語活用辞典：梵語名詞練習</title>
  </head>
  <body>
    <?php require_once("sanskrit_header.php"); ?>
    <div class="container item">
      <form action="" method="post" class="mt-2 js-form-storage" id="practice-condition" name="practice_condition">
        <?php echo Sanskrit_Common::noun_gender_selection_button(true); ?>
        <?php echo Sanskrit_Common::noun_declension_type_selection_button(); ?>    
        <input class="input js-persist" type="checkbox" name="save" /><span class="label-title">送信時に条件を保存する</span>
        <input type="submit" class="btn-check" id="btn-search">
        <label class="btn btn-outline-secondary" for="btn-search">問題を生成</label>
      </form>
      <script src="https://unpkg.com/form-storage@latest/build/form-storage.js"></script>
      <script>
        var storage = new FormStorage('.js-form-storage',{
          name: 'form-storage-ved-noun2',
          checkbox: '.js-persist'
        });
      </script> 
      <p><?php echo $question_data['question_sentence2']; ?></p>
      <div class="mt-2 js-form-storage textBox">
        <?php echo Sanskrit_Common::number_selection_button(); ?> 
        <?php echo Sanskrit_Common::case_selection_button(); ?>      
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
            Language_Practice.answer_the_question_noun();
	        });
        }
    </script>      
  </body>
</html>