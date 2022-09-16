<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/language_class/IndoEuropean_verb_class.php");
include(dirname(__FILE__) . "/language_class/Database_session.php");
include(dirname(__FILE__) . "/language_class/Commons.php");
include(dirname(__FILE__) . "/language_class/Sanskrit_Common.php");

// 挿入データ－語根の種別－
$root_type = trim(filter_input(INPUT_POST, 'root-type'));
// 挿入データ－喉音の有無－
$laryngeal_type = trim(filter_input(INPUT_POST, 'laryngeal-type'));
// 挿入データ－動詞の種別－
$verb_type = trim(filter_input(INPUT_POST, 'verb-type'));

// 単語取得
$question_word = Sanskrit_Common::get_random_verb($verb_type, $root_type, $laryngeal_type);
// 読み込み
$sanskrit_verb = new Vedic_Verb($question_word["dictionary_stem"]);
// 問題集生成
$question_data = $sanskrit_verb->get_conjugation_form_by_each_condition();
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
        <?php echo Sanskrit_Common::root_type_selection_button(); ?>
        <?php echo Sanskrit_Common::laryngeal_type_selection_button(); ?>       
        <?php echo Sanskrit_Common::verb_type_selection_button(); ?>   
        <input class="input js-persist" type="checkbox" name="save" /><span class="label-title">送信時に条件を保存する</span>
        <input type="submit" class="btn-check" id="btn-search">
        <label class="btn btn-outline-secondary" for="btn-search">問題を生成</label>
      </form>
      <script src="https://unpkg.com/form-storage@latest/build/form-storage.js"></script>
      <script>
        var storage = new FormStorage('.js-form-storage',{
          name: 'form-storage-ved-verb2',
          checkbox: '.js-persist'
        });
      </script>     
      <p><?php echo $question_data['question_sentence2']; ?></p>
      <div class="mt-2 js-form-storage">
        <?php echo Sanskrit_Common::voice_selection_button(); ?>
        <?php echo Sanskrit_Common::aspect_selection_button(); ?>
        <?php echo Sanskrit_Common::mood_selection_button(); ?>
        <?php echo Sanskrit_Common::person_selection_button(); ?>     
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
      //選択制御(相)
      function click_aspect_button(){
      	// 現在形にチェックがある場合は
      	if ($('#practice-condition [name=aspect]:checked').val() == "present"){
      		// 祈願法にdisableを付ける
      		document.getElementById("btn-bend").setAttribute("disabled", true);	
      		// 現在形のdisabled属性を削除
      		document.getElementById("btn-tense-present").removeAttribute("disabled"); 
       		// 受動態のdisabled属性を削除
          document.getElementById("btn-passive").removeAttribute("disabled");                   
      	} else if($('#practice-condition [name=aspect]:checked').val() == "aorist"){
      		// 完結相にチェックがある場合は
      		// 祈願法のdisabled属性を削除
      		document.getElementById("btn-bend").removeAttribute("disabled");
          // 現在形にdisabled属性を付与
      		document.getElementById("btn-tense-present").setAttribute("disabled", true);
       		// 受動態のdisabled属性を削除
          document.getElementById("btn-passive").removeAttribute("disabled");         	       
      	} else if($('#practice-condition [name=aspect]:checked').val() == "perfect"){
      		// 完了相にチェックがある場合は
      		// 祈願法にdisableを付ける
      		document.getElementById("btn-bend").setAttribute("disabled", true);	
       		// 受動態にdisableを付ける
          document.getElementById("btn-passive").setAttribute("disabled", true);	       
       		// 現在形のdisabled属性を削除
          document.getElementById("btn-tense-present").removeAttribute("disabled");       
      	} else if($('#practice-condition [name=aspect]:checked').val() == "future"){
      		// 未然相にチェックがある場合は
      		// 祈願法にdisableを付ける
      		document.getElementById("btn-bend").setAttribute("disabled", true);	
       		// 現在形のdisabled属性を削除
          document.getElementById("btn-tense-present").removeAttribute("disabled");
       		// 受動態のdisabled属性を削除
          document.getElementById("btn-passive").removeAttribute("disabled");                 
      	} else {
      		// すべてにチェックがある場合は
      		// 祈願法にdisableを付ける
      		document.getElementById("btn-bend").setAttribute("disabled", true);	
       		// 現在形のdisabled属性を削除
          document.getElementById("btn-tense-present").removeAttribute("disabled"); 
          // 受動態のdisabled属性を削除
          document.getElementById("btn-passive").removeAttribute("disabled");               
      	}
      }
      //選択制御(語根種別)
      function click_root_button(){
      	// 現在形にチェックがある場合は
      	if ($('#practice-condition [name=root-type]:checked').val() == "present"){
      		// 以下のボタンのdisabled属性を設定
      		document.getElementById("btn-verb3").setAttribute("disabled", true);    // 動詞種別 - 第3類
      		document.getElementById("btn-verb4").setAttribute("disabled", true);    // 動詞種別 - 第4類
      		document.getElementById("btn-verb5").setAttribute("disabled", true);    // 動詞種別 - 第5類
      		document.getElementById("btn-verb8").setAttribute("disabled", true);    // 動詞種別 - 第8類
      		document.getElementById("btn-verb9").setAttribute("disabled", true);    // 動詞種別 - 第9類
      		// 以下のボタンのdisabled属性を削除
      		document.getElementById("btn-verb1").removeAttribute("disabled");       // 動詞種別 - 第1類
          document.getElementById("btn-verb2").removeAttribute("disabled");       // 動詞種別 - 第2類
          document.getElementById("btn-verb6").removeAttribute("disabled");       // 動詞種別 - 第6類
          document.getElementById("btn-verb10").removeAttribute("disabled");      // 動詞種別 - 第10類      
      	} else if($('#practice-condition [name=root-type]:checked').val() == "aorist"){
      		// 完結相にチェックがある場合は
      		// 以下のボタンのdisabled属性を設定
      		document.getElementById("btn-verb6").setAttribute("disabled", true);    // 動詞種別 - 第6類
      		document.getElementById("btn-verb10").setAttribute("disabled", true);   // 動詞種別 - 第10類
      		// 以下のボタンのdisabled属性を削除
      		document.getElementById("btn-verb3").removeAttribute("disabled");       // 動詞種別 - 第3類
          document.getElementById("btn-verb4").removeAttribute("disabled");       // 動詞種別 - 第4類
          document.getElementById("btn-verb5").removeAttribute("disabled");       // 動詞種別 - 第5類
          document.getElementById("btn-verb7").removeAttribute("disabled");       // 動詞種別 - 第7類
          document.getElementById("btn-verb8").removeAttribute("disabled");       // 動詞種別 - 第8類   
      		document.getElementById("btn-verb9").removeAttribute("disabled");       // 動詞種別 - 第9類
      	} else {
      		// すべてにチェックがある場合は
      		// 以下のボタンのdisabled属性を削除
      		document.getElementById("btn-verb1").removeAttribute("disabled");       // 動詞種別 - 第1類
          document.getElementById("btn-verb2").removeAttribute("disabled");       // 動詞種別 - 第2類
      		document.getElementById("btn-verb3").removeAttribute("disabled");       // 動詞種別 - 第3類
          document.getElementById("btn-verb4").removeAttribute("disabled");       // 動詞種別 - 第4類
          document.getElementById("btn-verb5").removeAttribute("disabled");       // 動詞種別 - 第5類
          document.getElementById("btn-verb7").removeAttribute("disabled");       // 動詞種別 - 第7類
          document.getElementById("btn-verb8").removeAttribute("disabled");       // 動詞種別 - 第8類
      		document.getElementById("btn-verb9").removeAttribute("disabled");       // 動詞種別 - 第9類
          document.getElementById("btn-verb10").removeAttribute("disabled");      // 動詞種別 - 第10類 
      	}
      }
    </script> 
	  <script type="text/javascript" src="js/input_button.js"></script>
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
            Language_Practice.answer_the_question_skr_verb();
	        });
        }
    </script>      
    </script>
  </body>
</html>