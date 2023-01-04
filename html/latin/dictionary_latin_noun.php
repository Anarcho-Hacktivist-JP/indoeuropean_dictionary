<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_noun_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Latin_Common.php");

// 活用表を取得する。
function get_noun_declension_chart($word){
	// 名詞の情報を取得
	$noun_words = Latin_Common::get_dictionary_stem_by_japanese($word, Latin_Common::DB_NOUN);
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
		$latin_noun = new Latin_Noun($noun_word);
		// 配列に格納
		$declensions[$latin_noun->get_first_stem()] = $latin_noun->get_chart();
	}
  // 結果を返す。
	return $declensions;
}

// 活用表を取得する。
function get_noun_declension_chart_by_english($word){

  // 英語で取得する。
  $noun_words = Latin_Common::get_dictionary_stem_by_english($word, Latin_Common::DB_NOUN);    
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
		$latin_noun = new Latin_Noun($noun_word);
		// 配列に格納
		$declensions[$latin_noun->get_first_stem()] = $latin_noun->get_chart();
	}
  // 結果を返す。
	return $declensions;
}

// 活用表を取得する。
function get_noun_declension_chart_by_latin($word){
  // 単語から直接取得する
  $noun_words = Latin_Common::get_wordstem_from_DB($word, Latin_Common::DB_NOUN);
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
		$latin_noun = new Latin_Noun($noun_word);
		// 配列に格納
		$declensions[$latin_noun->get_first_stem()] = $latin_noun->get_chart();
	}
  // 結果を返す。
	return $declensions;
}


// 動詞から活用表を取得する。
function get_noun_declension_chart_by_verb($word){
	// データベースから訳語の動詞を取得する。
	$verb_words = Latin_Common::get_verb_by_japanese($word);
  // 取得できない場合は
  if(!$verb_words){
	  // データベースから訳語の動詞を取得する。
	  $verb_words = Latin_Common::get_verb_by_english($word);
    // 取得できない場合は
    if(!$verb_words){
      return array();
    }
  }
  // 動詞を名詞に変換
  $noun_words = array(); 
	// 新しい配列に詰め替え
	foreach ($verb_words as $verb_word){	
		// 最終単語
		$noun_words[] = mb_substr($verb_word["infinitive_stem"], 0, -2)."ns";
		// 最終単語
		$noun_words[] = mb_substr($verb_word["perfect_participle"], 0, -2)."iō";    
	}
 	// 配列を宣言
  $declensions = array(); 
	// 新しい配列に詰め替え
	foreach ($noun_words as $noun_word) {
		// 読み込み
		$latin_noun = new Latin_Noun($noun_word);
		// 配列に格納
		$declensions[$latin_noun->get_first_stem()] = $latin_noun->get_chart();
	}
  // 結果を返す。
	return $declensions;
}

//造語対応
function get_compound_noun_word($janome_result, $input_noun){
  // データを取得(男性)
	$declensions = Latin_Common::make_compound_chart($janome_result, "noun", $input_noun);
	// 結果を返す。
	return $declensions;
}

// 挿入データ－対象－
$input_noun = Commons::cut_words(trim(filter_input(INPUT_POST, 'input_noun')), 128);
// 挿入データ－言語－
$search_lang = trim(filter_input(INPUT_POST, 'input_search_lang'));

// AIによる造語対応
$janome_result = Commons::get_multiple_words_detail($input_noun);
$janome_result = Commons::convert_compound_array($janome_result);

// 検索結果の配列
$declensions = array();

// 条件ごとに判定して単語を検索して取得する
if(count($janome_result) > 1 && $search_lang == "japanese" && !ctype_alnum($input_noun) && !strpos($input_noun, Commons::$LIKE_MARK)){
  // 複合語の場合(日本語のみ)
  $declensions = get_compound_noun_word($janome_result, $input_noun);
} else if($input_noun != "" && $search_lang == "japanese" && $janome_result[0][1] == "動詞"){
  // 動詞の場合は動詞で名詞を取得(日本語のみ)
	$declensions = get_noun_declension_chart_by_verb($input_noun);
} else if($input_noun != "" && $search_lang == "latin" && Latin_Common::is_alphabet_or_not($input_noun)){
  // 対象が入力されていれば処理を実行
	$declensions = get_noun_declension_chart_by_latin($input_noun);
} else if($input_noun != "" && $search_lang == "english" && Latin_Common::is_alphabet_or_not($input_noun)){
  // 対象が入力されていれば処理を実行
	$declensions = get_noun_declension_chart_by_english($input_noun);
} else if($input_noun != "" && $search_lang == "japanese" && !Latin_Common::is_alphabet_or_not($input_noun)){
  // 対象が入力されていれば処理を実行
	$declensions = get_noun_declension_chart($input_noun);
}

?>
<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link href="/../css/style.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">   
    <title>印欧語活用辞典：羅和辞書(名詞)</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>       
  </head>
  <?php require_once("latin_header.php"); ?>
  <body>
    <div class="container item table-striped">
      <p>あいまい検索は+</p>
      <form action="" method="post" class="mt-4 mb-4 form-search" id="form-search">
        <input type="text" name="input_noun" id="input_noun" class="form-control" placeholder="検索語句(日本語・英語・ラテン語)">
        <?php echo Latin_Common::language_select_box(); ?>      
        <input type="submit" class="btn-check" id="btn-search">
        <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-search">検索</label>
        <select class="form-select" id="noun-selection">
          <option selected>単語を選んでください</option>
          <?php echo Commons::select_option($declensions); ?>
        </select>
      </form>
      <?php echo Latin_Common::input_special_button(); ?>       
      <table class="table table-success table-bordered table-striped table-hover" id="noun-table">
        <thead>
          <tr>
            <th class="text-center" scope="row"style="width:30%">格</th>
            <th class="text-center" scope="col" style="width:35%">単数</th>
            <th class="text-center" scope="col" style="width:35%">複数</th>
          </tr>
        </thead>
        <tbody>
          <tr><th scope="row" class="text-center">主格</th><td></td><td></td></tr>
          <tr><th scope="row" class="text-center">属格</th><td></td><td></td></tr>
          <tr><th scope="row" class="text-center">与格</th><td></td><td></td></tr>
          <tr><th scope="row" class="text-center">対格</th><td></td><td></td></tr>
          <tr><th scope="row" class="text-center">奪格</th><td></td><td></td></tr>
          <tr><th scope="row" class="text-center">地格</th><td></td><td></td></tr>
          <tr><th scope="row" class="text-center">呼格</th><td></td><td></td></tr>
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
        function get_noun(table_data, word){

          // JSONに書き換え
          var json_noun = JSON.parse(table_data);

          // 格変化情報を取得
          var declension_sg = json_noun[word]["sg"];  //単数
          var declension_pl = json_noun[word]["pl"];  //複数
          
          // 格納データを作成
          var noun_table = [
            [declension_sg["nom"], declension_pl["nom"]],
            [declension_sg["gen"], declension_pl["gen"]],
            [declension_sg["dat"], declension_pl["dat"]],
            [declension_sg["acc"], declension_pl["acc"]],
            [declension_sg["abl"], declension_pl["abl"]],
            [declension_sg["loc"], declension_pl["loc"]],
            [declension_sg["voc"], declension_pl["voc"]],
          ];
          
          // 結果を返す。
          return noun_table;
        }

        // 単語選択後の処理
        function output_table_data(){
          // 行オブジェクトの取得
          var rows = $('#noun-table')[0].rows;
          // 格変化表を取得 
          const noun_decl_data = get_noun(noun_table_data, $('#noun-selection').val());
          // 各行をループ処理
          $.each(rows, function(i){
            // タイトル行は除外する。
            if(i == 0){
              return true;
            }
            // 格変化を挿入
            rows[i].cells[1].innerText = noun_decl_data[i - 1][0]; // 単数(1行目)
            rows[i].cells[2].innerText = noun_decl_data[i - 1][1]; // 複数(2行目)
          });
        }

        //イベントを設定
        function setEvents(){
	        // セレクトボックス選択時
	        $('#noun-selection').change( function(){
            output_table_data();
	        });
          // ボタンにイベントを設定
          Input_Botton.LatinBotton('#input_noun');                   
        }
    </script>
  </body>
</html>