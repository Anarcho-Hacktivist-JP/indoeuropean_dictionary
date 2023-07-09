<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_adjective_class.php");
include(dirname(__FILE__) . "/../language_class/IndoEuropean_noun_class.php");
include(dirname(__FILE__) . "/../language_class/IndoEuropean_verb_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Sanskrit_Common.php");

?>
<!doctype html>
<html lang="ja">
  <head>
    <?php require_once("sanskrit_including.php"); ?>
    <title>印欧語活用辞典：梵語辞書</title>
  </head>
  <body>
    <?php require_once("sanskrit_header.php"); ?>
    <div class="container item table-striped">
      <h1>梵語辞書（名詞曲用検索）</h1>
      <div class="mt-4 mb-4" id="form-search">
        <section class="row">
          <div class="col-md-12 mb-0 textBox1">
            <input type="text" name="word" id="word" class="form-control" placeholder="名詞の辞書形を入れてください">
            <?php echo Sanskrit_Common::input_special_button(); ?>
          </div>
        </section>
        <?php echo Sanskrit_Common::number_selection_button(false); ?> 
        <?php echo Sanskrit_Common::case_selection_button(false); ?>
        <?php echo Sanskrit_Common::declension_button_and_text(); ?>
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
          Word_Change_Search.search_noun_declension("sanskrit");
	      });

        // ボタンにイベントを設定
        Input_Botton.SanskritBotton('#word');
      }
    </script>
  <footer class="">
  </footer>
  </body>
</html>