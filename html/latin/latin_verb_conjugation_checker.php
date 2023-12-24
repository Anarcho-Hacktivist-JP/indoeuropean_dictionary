<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_adjective_class.php");
include(dirname(__FILE__) . "/../language_class/IndoEuropean_noun_class.php");
include(dirname(__FILE__) . "/../language_class/IndoEuropean_verb_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Latin_Common.php");

?>
<!doctype html>
<html lang="ja">
  <head>
    <?php require_once("latin_including.php"); ?>
    <title>印欧語活用辞典：ラテン語辞書</title>  
  </head>
  <body>
    <?php require_once("latin_header.php"); ?>
    <div class="container item table-striped">
      <h1>ラテン語辞書（動詞活用検索）</h1>
      <div class="mt-4 mb-4" id="form-search">
        <section class="row">
          <div class="col-md-12 mb-0 textBox1">
            <input type="text" name="word" id="word" class="form-control" placeholder="動詞の辞書形を入れてください">
            <?php echo Latin_Common::input_special_button(); ?>
          </div>
        </section>
        <?php echo Latin_Common::voice_selection_button(false); ?>
        <?php echo Latin_Common::aspect_selection_button(false); ?>       
        <?php echo Latin_Common::tense_selection_button(false); ?>       
        <?php echo Latin_Common::mood_selection_button(false); ?>
        <?php echo Latin_Common::person_selection_button(false); ?>        
        <?php echo Latin_Common::conjugation_button_and_text(); ?>
      </div>
    </div>
  <footer class="">
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
      $(function(){
        // イベントを設定
        setEvents();
      });


      //イベントを設定
      function setEvents(){
	      // セレクトボックス選択時
	      $('#btn-search').click( function(){
          // 語形変化を検索
          Word_Change_Search.search_latin_romance_conjugation("latin");
	      });

        // ボタンにイベントを設定
        Input_Botton.LatinBotton('#word');

      }
    </script>
  <footer class="">
  </footer>
  </body>
</html>