<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_verb_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Latin_Common.php");

// 挿入データ－動詞の種別－
$verb_type = trim(filter_input(INPUT_POST, 'verb-type'));
// 挿入データ－人称－
$person = trim(filter_input(INPUT_POST, 'person'));
// 挿入データ－態－
$voice = trim(filter_input(INPUT_POST, 'voice'));
// 挿入データ－相－
$aspect = trim(filter_input(INPUT_POST, 'aspect'));
// 挿入データ－時制－
$tense = trim(filter_input(INPUT_POST, 'tense'));
// 挿入データ－法－
$mood = trim(filter_input(INPUT_POST, 'mood'));

// 単語取得
$question_word = Latin_Common::get_random_verb($verb_type);
// 読み込み
$latin_verb = new Latin_Verb($question_word["dictionary_stem"]);
// 問題集生成
$question_data = $latin_verb->get_conjugation_form_by_each_condition($person, $voice, $mood, $aspect, $tense);
?>
<!doctype html>
<html lang="ja">
  <head>
  	<?php require_once("latin_including.php"); ?>
    <title>印欧語活用辞典：ラテン語動詞練習</title>
  </head>
  <?php require_once("latin_header.php"); ?>
  <body>
    <div class="container item">
      <form action="" method="post" class="mt-2 js-form-storage" id="practice-condition" name="practice_condition">
        <?php echo Latin_Common::verb_type_selection_button(); ?>
        <?php echo Latin_Common::voice_selection_button(true); ?>
        <?php echo Latin_Common::aspect_selection_button(true); ?>       
        <?php echo Latin_Common::tense_selection_button(true); ?>       
        <?php echo Latin_Common::mood_selection_button(true); ?>
        <?php echo Latin_Common::person_selection_button(true); ?>        
        <input class="input js-persist" type="checkbox" name="save" /><span class="label-title">送信時に条件を保存する</span>
        <input type="submit" class="btn-check" id="btn-search">
        <label class="btn btn-outline-secondary" for="btn-search">問題を生成</label>
      </form>
      <script src="https://unpkg.com/form-storage@latest/build/form-storage.js"></script>
      <script>
        var storage = new FormStorage('.js-form-storage',{
          name: 'form-storage-lat-verb',
          checkbox: '.js-persist'
        });
      </script>       
      <p><?php echo $question_data['question_sentence']; ?></p>
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
      //選択制御(相)
      function click_aspect_button(){
      	// 現在形にチェックがある場合は
      	if ($('#practice-condition [name=aspect]:checked').val() == "present"){
      		// 命令法のdisabled属性を削除
      		document.getElementById("btn-imper").removeAttribute("disabled", true);	            	       
      	} else if($('#practice-condition [name=aspect]:checked').val() == "perfect"){
      		// 完了相にチェックがある場合は
      		// 命令法にdisableを付ける
      		document.getElementById("btn-imper").setAttribute("disabled", true);	            
      	} else {
      		// すべてにチェックがある場合は
      		// 命令法のdisabled属性を削除
      		document.getElementById("btn-imper").removeAttribute("disabled", true);	              
      	}
      }

      //選択制御(法)
      function click_mood_button(){
      	// 直接法にチェックがある場合は
      	if ($('#practice-condition [name=mood]:checked').val() == "ind"){
      		// 全時制・法のdisabled属性を削除
      		document.getElementById("btn-tense-present").removeAttribute("disabled", true);
      		document.getElementById("btn-tense-past").removeAttribute("disabled", true);	 
      		document.getElementById("btn-tense-future").removeAttribute("disabled", true);	 
      		document.getElementById("btn-aspect-perfect").removeAttribute("disabled", true);

        	// 全人称のdisaabled属性を削除
      		document.getElementById("btn-1sg").removeAttribute("disabled", true);
      		document.getElementById("btn-2sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-3sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-1pl").removeAttribute("disabled", true);
      		document.getElementById("btn-2pl").removeAttribute("disabled", true);	 
      		document.getElementById("btn-3pl").removeAttribute("disabled", true);	 
      	} else if($('#practice-condition [name=mood]:checked').val() == "subj"){
      		// 接続法にチェックがある場合は
      		// 未来形にdisableを付ける
      		document.getElementById("btn-tense-present").removeAttribute("disabled", true);
      		document.getElementById("btn-tense-past").removeAttribute("disabled", true);	 
      		document.getElementById("btn-tense-future").setAttribute("disabled", true);	 
      		document.getElementById("btn-aspect-perfect").removeAttribute("disabled", true);

          	// 全人称のdisaabled属性を削除
      		document.getElementById("btn-1sg").removeAttribute("disabled", true);
      		document.getElementById("btn-2sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-3sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-1pl").removeAttribute("disabled", true);
      		document.getElementById("btn-2pl").removeAttribute("disabled", true);	 
      		document.getElementById("btn-3pl").removeAttribute("disabled", true);	 
      	} else if($('#practice-condition [name=mood]:checked').val() == "imper"){
      		// 命令法にチェックがある場合は
      		// 過去形・完了形にdisableを付ける
      		document.getElementById("btn-tense-present").removeAttribute("disabled", true);
      		document.getElementById("btn-tense-past").setAttribute("disabled", true);	 
      		document.getElementById("btn-tense-future").removeAttribute("disabled", true);	 
      		document.getElementById("btn-aspect-perfect").setAttribute("disabled", true);	

          	// 1人称にdisableを付ける
      		document.getElementById("btn-1sg").setAttribute("disabled", true);
      		document.getElementById("btn-2sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-1pl").setAttribute("disabled", true);
      		document.getElementById("btn-2pl").removeAttribute("disabled", true);	        

          // 未来形にチェックがある場合は
          if($('#practice-condition [name=tense]:checked').val() == "future"){
            // 3人称のdisaabled属性を削除
            document.getElementById("btn-3sg").removeAttribute("disabled", true);	
            document.getElementById("btn-3pl").removeAttribute("disabled", true);	 
          } else {
            // それ以外は付与
            document.getElementById("btn-3sg").setAttribute("disabled", true);	
            document.getElementById("btn-3pl").setAttribute("disabled", true);	 
          }
      	} else {
      		// すべてにチェックがある場合は
      		// 全時制・法のdisabled属性を削除
      		document.getElementById("btn-tense-present").removeAttribute("disabled", true);
      		document.getElementById("btn-tense-past").removeAttribute("disabled", true);	 
      		document.getElementById("btn-tense-future").removeAttribute("disabled", true);	 
      		document.getElementById("btn-aspect-perfect").removeAttribute("disabled", true);
          
          	// 全人称のdisaabled属性を削除
      		document.getElementById("btn-1sg").removeAttribute("disabled", true);
      		document.getElementById("btn-2sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-3sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-1pl").removeAttribute("disabled", true);
      		document.getElementById("btn-2pl").removeAttribute("disabled", true);	 
      		document.getElementById("btn-3pl").removeAttribute("disabled", true);	 
      	}
      }

      //選択制御(時制)
      function click_tense_button(){
      	// 現在形にチェックがある場合は
      	if ($('#practice-condition [name=tense]:checked').val() == "present"){
      		// 全ての法のdisabled属性を削除
      		document.getElementById("btn-ind").removeAttribute("disabled", true);
      		document.getElementById("btn-subj").removeAttribute("disabled", true);	 
      		document.getElementById("btn-imper").removeAttribute("disabled", true);	 

          // 全人称のdisaabled属性を削除
      		document.getElementById("btn-1sg").removeAttribute("disabled", true);
      		document.getElementById("btn-2sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-3sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-1pl").removeAttribute("disabled", true);
      		document.getElementById("btn-2pl").removeAttribute("disabled", true);	 
      		document.getElementById("btn-3pl").removeAttribute("disabled", true);	

          // 命令法にチェックがある場合は
          if($('#practice-condition [name=mood]:checked').val() == "imper"){
            // 3人称のdisaabled属性を削除
            document.getElementById("btn-1sg").setAttribute("disabled", true);
      		document.getElementById("btn-2sg").removeAttribute("disabled", true);	 
            document.getElementById("btn-3sg").setAttribute("disabled", true);
      		document.getElementById("btn-1pl").setAttribute("disabled", true);
      		document.getElementById("btn-2pl").removeAttribute("disabled", true);	 
            document.getElementById("btn-3pl").setAttribute("disabled", true);	 
          } else {
            // それ以外は付与
            document.getElementById("btn-1sg").removeAttribute("disabled", true);
      		document.getElementById("btn-2sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-3sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-1pl").removeAttribute("disabled", true);
      		document.getElementById("btn-2pl").removeAttribute("disabled", true);	 
      		document.getElementById("btn-3pl").removeAttribute("disabled", true);	
          }
      	} else if($('#practice-condition [name=tense]:checked').val() == "past"){
      		// 過去形にチェックがある場合は
      		// 命令法にdisableを付ける
      		document.getElementById("btn-ind").removeAttribute("disabled", true);
      		document.getElementById("btn-subj").removeAttribute("disabled", true);	 
      		document.getElementById("btn-imper").setAttribute("disabled", true);	 

          // 全人称のdisaabled属性を削除
      		document.getElementById("btn-1sg").removeAttribute("disabled", true);
      		document.getElementById("btn-2sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-3sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-1pl").removeAttribute("disabled", true);
      		document.getElementById("btn-2pl").removeAttribute("disabled", true);	 
      		document.getElementById("btn-3pl").removeAttribute("disabled", true);	 

      	} else if($('#practice-condition [name=tense]:checked').val() == "future"){
      		// 未来形にチェックがある場合は
      		// 命令法にdisableを付ける
      		document.getElementById("btn-ind").removeAttribute("disabled", true);
      		document.getElementById("btn-subj").removeAttribute("disabled", true);	 
      		document.getElementById("btn-imper").setAttribute("disabled", true);	 

          // 1人称にdisableを付ける
      		document.getElementById("btn-1sg").setAttribute("disabled", true);
      		document.getElementById("btn-2sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-1pl").setAttribute("disabled", true);
      		document.getElementById("btn-2pl").removeAttribute("disabled", true);	        

          // 命令法にチェックがある場合は
          if($('#practice-condition [name=mood]:checked').val() == "imper"){
            // 3人称のdisaabled属性を削除
            document.getElementById("btn-1sg").setAttribute("disabled", true);
      		document.getElementById("btn-2sg").removeAttribute("disabled", true);	 
            document.getElementById("btn-3sg").removeAttribute("disabled", true);
      		document.getElementById("btn-1pl").setAttribute("disabled", true);
      		document.getElementById("btn-2pl").removeAttribute("disabled", true);	 
            document.getElementById("btn-3pl").removeAttribute("disabled", true);	 
          } else {
            // それ以外は付与
            document.getElementById("btn-1sg").removeAttribute("disabled", true);
      		document.getElementById("btn-2sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-3sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-1pl").removeAttribute("disabled", true);
      		document.getElementById("btn-2pl").removeAttribute("disabled", true);	 
      		document.getElementById("btn-3pl").removeAttribute("disabled", true);	
          }
      	} else {
      		// すべてにチェックがある場合は
      		// 全時制・法のdisabled属性を削除
      		document.getElementById("btn-tense-present").removeAttribute("disabled", true);
      		document.getElementById("btn-tense-past").removeAttribute("disabled", true);	 
      		document.getElementById("btn-tense-future").removeAttribute("disabled", true);	 
      		document.getElementById("btn-aspect-perfect").removeAttribute("disabled", true);
          
          // 全人称のdisaabled属性を削除
      		document.getElementById("btn-1sg").removeAttribute("disabled", true);
      		document.getElementById("btn-2sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-3sg").removeAttribute("disabled", true);	 
      		document.getElementById("btn-1pl").removeAttribute("disabled", true);
      		document.getElementById("btn-2pl").removeAttribute("disabled", true);	 
      		document.getElementById("btn-3pl").removeAttribute("disabled", true);	 
      	}
      }
  
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