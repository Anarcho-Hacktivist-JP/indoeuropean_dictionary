<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_noun_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Greek_Common.php");

// 活用表を取得する。
function get_noun_declension_chart($word, $gender){
	// 名詞の情報を取得
	$noun_words = Koine_Common::get_dictionary_stem_by_japanese($word, Koine_Common::DB_NOUN, $gender);
  // 取得できない場合は
  if(!$noun_words){
    // 空を返す。
    return array();   
  }
 	// 配列を宣言
  $declensions = array(); 
	// 新しい配列に詰め替え
	foreach ($noun_words as $noun_word) {
		// 読み込み
		$koine_noun = new Koine_Noun($noun_word);
		// 配列に格納
		$declensions[$koine_noun->get_second_stem()] = $koine_noun->get_chart();
	}
  // 結果を返す。
	return $declensions;
}

// 活用表を取得する。
function get_noun_declension_chart_by_english($word, $gender){
  // 英語で取得する。
  $noun_words = Koine_Common::get_dictionary_stem_by_english($word, Koine_Common::DB_NOUN, $gender);    
  // 取得できない場合は
  if(!$noun_words){
    // その単語を入れる        
    $noun_words[] = $word;
  }    
 	// 配列を宣言
  $declensions = array(); 
	// 新しい配列に詰め替え
	foreach ($noun_words as $noun_word) {
		// 読み込み
		$koine_noun = new Koine_Noun($noun_word);
		// 配列に格納
		$declensions[$koine_noun->get_second_stem()] = $koine_noun->get_chart();
	}
  // 結果を返す。
	return $declensions;
}

// 活用表を取得する。
function get_noun_declension_chart_by_greek($word){
  // 単語から直接取得する
  $noun_words = Koine_Common::get_wordstem_from_DB($word, Koine_Common::DB_NOUN);
  // 取得できない場合は
  if(!$noun_words){
    // その単語を入れる        
    $noun_words[] = $word;
  }   
 	// 配列を宣言
  $declensions = array(); 
  // 新しい配列に詰め替え
  foreach ($noun_words as $noun_word) {
    // 読み込み
    $koine_noun = new Koine_Noun($noun_word);
    // 配列に格納
    $declensions[$koine_noun->get_second_stem()] = $koine_noun->get_chart();
  }
  // 結果を返す。
	return $declensions;
}

// 挿入データ－対象－
$input_noun = trim(filter_input(INPUT_POST, 'input_noun'));
// 挿入データ－言語－
$search_lang = trim(filter_input(INPUT_POST, 'input_search_lang'));
// 挿入データ－性別－
$gender = trim(filter_input(INPUT_POST, 'gender'));

// AIによる造語対応
$janome_result = Commons::get_multiple_words_detail($input_noun);
$janome_result = Commons::convert_compound_array($janome_result);

// 検索結果の配列
$declensions = array();

// 条件ごとに判定して単語を検索して取得する
if(count($janome_result) > 1 && !ctype_alnum($input_noun) && $search_lang == Commons::NIHONGO && !strpos($input_noun, Commons::$LIKE_MARK)){
  // 複合語の場合
  $declensions = Koine_Common::make_compound_chart($janome_result, "noun", $input_noun);
} else if($input_noun != "" && $search_lang == Commons::GREEK && Koine_Common::is_alphabet_or_not($input_noun)){
  // 対象が入力されていれば処理を実行
	$declensions = get_noun_declension_chart_by_greek($input_noun);
} else if($input_noun != "" && $search_lang == Commons::EIGO && Koine_Common::is_latin_alphabet_or_not($input_noun)){
  // 対象が入力されていれば処理を実行
	$declensions = get_noun_declension_chart_by_english($input_noun, $gender);
} else if($input_noun != "" && $search_lang == Commons::NIHONGO && !Koine_Common::is_latin_alphabet_or_not($input_noun) && !Koine_Common::is_alphabet_or_not($input_noun)){
  // 対象が入力されていれば処理を実行
  $declensions = get_noun_declension_chart($input_noun, $gender);
}

?>
<!doctype html>
<html lang="ja">
  <head>
    <?php require_once("koine_including.php"); ?>
    <title>印欧語活用辞典：ギリシア語辞書</title>
  </head>
  <body>
    <?php require_once("koine_header.php"); ?>
    <div class="container item table-striped">
      <form action="" method="post" class="mt-4 mb-4" id="form-search">
        <section class="row mb-3 textBox1">
          <input type="text" name="input_noun" id="input_noun" class="form-control" placeholder="検索語句(日本語・英語・ギリシア語) あいまい検索は+">
          <?php echo Koine_Common::input_special_button(); ?>
        </section>
        <section class="row mb-3">
          <?php echo Koine_Common::language_select_box(); ?>
        </section>
        <p>性別選択は名詞で入力の場合のみ可</p>
        <?php echo Koine_Common::noun_gender_selection_button(true); ?>      
        <input type="submit" class="btn-check" id="btn-search">
        <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-search">検索</label>
        <select class="form-select" id="noun-selection">
          <option selected>単語を選んでください</option>
          <?php echo Commons::select_option($declensions); ?>
        </select>
      </form>
      <table class="table table-success table-bordered table-striped table-hover" id="noun-table">
        <thead>
          <tr><th scope="row" style="width:10%">格</th>
          <th scope="col" style="width:30%">単数</th>
          <th scope="col" style="width:30%">双数</th>
          <th scope="col" style="width:30%">複数</th>
        </tr>
      </thead>
        <tbody>
          <tr><th class="text-center" scope="row">主格</th><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">属格</th><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">与格</th><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">対格</th><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">呼格</th><td></td><td></td><td></td></tr>
          <tr><th class="text-center table-optional" scope="row">奪格(副詞)</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td></tr>  
          <tr><th class="text-center table-optional" scope="row">具格(副詞)</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td></tr>          
          <tr><th class="text-center table-optional" scope="row">地格(副詞)</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td></tr>          
          <tr><th class="text-center table-optional" scope="row">出格1(副詞)</th><td colspan="3" class="table-optional"></td></tr>
          <tr><th class="text-center table-optional" scope="row">出格2(副詞)</th><td colspan="3" class="table-optional"></td></tr>
        </tbody>
      </table>
    </div>
  <footer class="">
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        var noun_table_data = '<?php echo json_encode($declensions, JSON_UNESCAPED_UNICODE); ?>';
    </script>
	  <script type="text/javascript" src="/../js/input_button.js"></script>
    <script>
        $(function(){
          // イベントを設定
          setEvents();
        });

        // 配列をテーブル用に変換にする。
        function arrange_table_data(table_data, word){

          // JSONに書き換え
          var json_noun = JSON.parse(table_data);

          // 格変化情報を取得
          var declension_sg = json_noun[word]["sg"];  //単数
          var declension_du = json_noun[word]["du"];  //双数
          var declension_pl = json_noun[word]["pl"];  //複数
          
          // 格納データを作成
          var noun_table = [
            [declension_sg["nom"], declension_du["nom"], declension_pl["nom"]],
            [declension_sg["gen"], declension_du["gen"], declension_pl["gen"]],
            [declension_sg["dat"], declension_du["dat"], declension_pl["dat"]],
            [declension_sg["acc"], declension_du["acc"], declension_pl["acc"]],
            [declension_sg["voc"], declension_du["voc"], declension_pl["voc"]],
            [declension_sg["abl"], declension_du["abl"], declension_pl["abl"]],
            [declension_sg["ins"], declension_du["ins"], declension_pl["ins"]],            
            [declension_sg["loc"], declension_du["loc"], declension_pl["loc"]],
            [declension_sg["allative"]],
            [declension_sg["allative2"]],
          ];
          
          // 結果を返す。
          return noun_table;
        }

        // 単語選択後の処理
        function output_table_data(){
          // 行オブジェクトの取得
          var rows = $('#noun-table')[0].rows;
          // 格変化表を取得 
          const noun_decl_data = arrange_table_data(noun_table_data, $('#noun-selection').val());
          // 各行をループ処理
          $.each(rows, function(i){
            // タイトル行は除外する。
            if(i == 0){
              return true;
            } else if(i < 9){
              // 格変化を挿入
              rows[i].cells[1].innerText = noun_decl_data[i - 1][0]; // 単数(1行目)
              rows[i].cells[2].innerText = noun_decl_data[i - 1][1]; // 双数(2行目)
              rows[i].cells[3].innerText = noun_decl_data[i - 1][2]; // 複数(3行目)
            } else {
              // 格変化(拡張・副詞)を挿入
              rows[i].cells[1].innerText = noun_decl_data[i - 1][0]; // 単数(1行目)              
            }
          });
        }

        //イベントを設定
        function setEvents(){
	        // セレクトボックス選択時
	        $('#noun-selection').change( function(){
            output_table_data();
	        });
          // ボタンにイベントを設定
          Input_Botton.GreekBotton('#input_noun'); 
        }
    </script>    
  </body>
</html>