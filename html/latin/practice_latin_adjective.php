<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_adjective_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Latin_Common.php");

// 挿入データ－性別－
$gender = trim(filter_input(INPUT_POST, 'gender'));
// 挿入データ－活用種別－
$declension = trim(filter_input(INPUT_POST, 'declension'));
// 挿入データ－数－
$number = trim(filter_input(INPUT_POST, 'number'));
// 挿入データ－格－
$case = trim(filter_input(INPUT_POST, 'case'));

// 単語取得
$question_word = Latin_Common::get_random_adjective($declension);
// 読み込み
$adjective_latin = new Latin_Adjective($question_word["dictionary_stem"]);
// 問題集生成
$question_data = $adjective_latin->get_form_by_number_case_gender_grade($case, $number, $gender, Commons::ADJ_GRADE_POSITIVE);
?>
<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>印欧語活用辞典：ラテン語形容詞練習</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
    <link href="/../css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
  </head>
  <?php require_once("latin_header.php"); ?>
  <body>
    <div class="container item">
      <form action="" method="post" class="mt-2 js-form-storage" id="practice-condition" name="practice_condition">
        <?php echo Latin_Common::adjective_gender_selection_button(true); ?>
        <?php echo Latin_Common::adjective_declension_type_selection_button(); ?>
        <?php echo Latin_Common::number_selection_button(true); ?> 
        <?php echo Latin_Common::case_selection_button(true); ?>         
        <input class="input js-persist" type="checkbox" name="save" /><span class="label-title">送信時に条件を保存する</span>
        <input type="submit" class="btn-check" id="btn-search">
        <label class="btn btn-outline-secondary" for="btn-search">問題を生成</label>
      </form>
      <script src="https://unpkg.com/form-storage@latest/build/form-storage.js"></script>
      <script>
        var storage = new FormStorage('.js-form-storage',{
          name: 'form-storage-lat-adj',
          checkbox: '.js-persist'
        });
      </script>
      <section class="row mb-3"> 
        <p><?php echo $question_data['question_sentence']; ?></p>
      </section>
      <section class="row mb-3 textBox"> 
        <div class="input-group col-md-3 mb-0">
          <input type="text" class="form-control" aria-describedby="basic-addon2" id="input-answer" placeholder="答えを入れる">
          <button class="btn btn-outline-secondary" type="button" id="button-answer">答え合わせ</button> 
        </div>
        <div class="input-group-append col-md-3 mb-0">
          <?php echo Latin_Common::input_special_button(); ?>
        </div>
      </section> 
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
            Language_Practice.answer_the_question();
	        });
          // ボタンにイベントを設定
          Input_Botton.SanskritBotton('#input-answer');
        }

    </script>      
    </script>
  </body>
</html>