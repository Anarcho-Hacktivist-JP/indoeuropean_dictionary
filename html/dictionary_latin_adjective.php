<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/language_class/IndoEuropean_adjective_class.php");
include(dirname(__FILE__) . "/language_class/Database_session.php");
include(dirname(__FILE__) . "/language_class/Commons.php");
include(dirname(__FILE__) . "/language_class/Latin_Common.php");

// 活用表を取得する。
function get_adjective_declension_chart($word){
	// 形容詞の情報を取得
	$adjective_words = Latin_Common::get_dictionary_stem_by_japanese($word, Latin_Common::DB_ADJECTIVE);
  // 取得できない場合は
  if(!$adjective_words){
    // 空を返す。
    return array();   
  }
	// 配列を宣言
	$declensions = array();  
	// 新しい配列に詰め替え
	foreach ($adjective_words as $adjective_word) {
		// 読み込み
		$latin_adjective = new Latin_Adjective($adjective_word);
		// 活用表生成
		$declensions[$latin_adjective->get_first_stem()] = $latin_adjective->get_chart();
	}
  // 結果を返す。
	return $declensions;
}

// 活用表を取得する。
function get_adjective_declension_chart_by_english($word){
	// 形容詞の情報を取得
  // 英語で取得する。
  $adjective_words = Latin_Common::get_dictionary_stem_by_english($word, Latin_Common::DB_ADJECTIVE);  
  // 取得できない場合は
  if(!$adjective_words){
    // その単語を入れる        
    $adjective_words[] = $word;
  }    
	// 配列を宣言
	$declensions = array();  
	// 新しい配列に詰め替え
	foreach ($adjective_words as $adjective_word) {
		// 読み込み
		$latin_adjective = new Latin_Adjective($adjective_word);
		// 活用表生成
		$declensions[$latin_adjective->get_first_stem()] = $latin_adjective->get_chart();
	}
  // 結果を返す。
	return $declensions;
}

// 活用表を取得する。
function get_adjective_declension_chart_by_latin($word){
	// 形容詞の情報を取得
  // 単語から直接取得する
  $adjective_words = Latin_Common::get_wordstem_from_DB($word, Latin_Common::DB_ADJECTIVE);
  // 取得できない場合は
  if(!$adjective_words){
    // その単語を入れる
    $adjective_words[] = $word;
  } 
	// 配列を宣言
	$declensions = array();  
	// 新しい配列に詰め替え
	foreach ($adjective_words as $adjective_word) {
		// 読み込み
		$latin_adjective = new Latin_Adjective($adjective_word);
		// 活用表生成
		$declensions[$latin_adjective->get_first_stem()] = $latin_adjective->get_chart();
	}
  // 結果を返す。
	return $declensions;
}

// 活用表を取得する。
function get_adjective_declension_chart_by_verb($word){
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
  // 動詞を形容詞に変換
  $adjective_words = array(); 
	// 新しい配列に詰め替え
	foreach ($verb_words as $verb_word){	
		// 最終単語
		$adjective_words[] = mb_substr($verb_word["infinitive_stem"], 0, -2)."ns"; 
	}
 	// 配列を宣言
  $declensions = array(); 
	// 新しい配列に詰め替え
	foreach ($adjective_words as $adjective_word) {
		// 読み込み
		$latin_adjective = new Latin_Adjective($adjective_word);
		// 活用表生成
		$declensions[$latin_adjective->get_first_stem()] = $latin_adjective->get_chart();
	}
  // 結果を返す。
	return $declensions;
}

//造語対応
function get_compound_adjective_word($janome_result, $input_adjective){
  // データを取得
	$declensions = Latin_Common::make_compound_chart($janome_result, "adjective", $input_adjective);
	// 結果を返す。
	return $declensions;
}

// 挿入データ－対象－
$input_adjective = Commons::cut_words(trim(filter_input(INPUT_POST, 'input_adjective')), 128);
// 挿入データ－言語－
$search_lang = trim(filter_input(INPUT_POST, 'input_search_lang'));

// AIによる造語対応
$janome_result = Commons::get_multiple_words_detail($input_adjective);
$janome_result = Commons::convert_compound_array($janome_result);

// 検索結果の配列
$declensions = array();

// 条件ごとに判定して単語を検索して取得する
if(count($janome_result) > 1 && $search_lang == "japanese" && !ctype_alnum($input_adjective) && !strpos($input_adjective, Commons::$LIKE_MARK)){
  // 複合語の場合(日本語のみ)
  $declensions = get_compound_adjective_word($janome_result, $input_adjective);
} else if($input_adjective != "" && $search_lang == "japanese" && $janome_result[0][1] == "動詞"){
  // 動詞の場合は動詞で形容詞を取得(日本語のみ)
	$declensions = get_adjective_declension_chart_by_verb($input_adjective);
} else if($input_adjective != "" && $search_lang == "japanese" && !Latin_Common::is_alphabet_or_not($input_adjective)){
  // 対象が入力されていれば処理を実行
	$declensions = get_adjective_declension_chart($input_adjective);
} else if($input_adjective != "" && $search_lang == "english" && Latin_Common::is_alphabet_or_not($input_adjective)){
  // 対象が入力されていれば処理を実行
	$declensions = get_adjective_declension_chart_by_english($input_adjective);
} else if($input_adjective != "" && $search_lang == "latin" && Latin_Common::is_alphabet_or_not($input_adjective)){
  // 対象が入力されていれば処理を実行
	$declensions = get_adjective_declension_chart_by_latin($input_adjective);
}

?>
<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>印欧語活用辞典：ラテン語辞書</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
  </head>
  <?php require_once("header.php"); ?>
  <body>
    <div class="container item table-striped">   
      <p>あいまい検索は+</p>
      <form action="" method="post" class="mt-4 mb-4" id="form-search">
        <input type="text" name="input_adjective" class="form-control" id="input_adjective" placeholder="検索語句(日本語・英語・ラテン語)">
        <?php echo Latin_Common::language_select_box(); ?> 
        <input type="submit" class="btn-check" id="btn-search">
        <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-search">検索</label>
        <select class="form-select" id="adjective-selection" aria-label="Default select example">
          <option selected>単語を選んでください</option>
          <?php echo Commons::select_option($declensions); ?>
        </select>
      </form>
      <?php echo Latin_Common::input_special_button(); ?>
      <table class="table table-success table-bordered table-striped table-hover" id="adjective-table">
        <?php echo Latin_Common::make_adjective_column_chart(); ?>
        <tbody>
          <tr><th class="text-center" scope="row" colspan="7">原級</th></tr>
          <?php echo Latin_Common::make_adjective_chart(); ?>
          <tr><th class="text-center" scope="row" colspan="7">比較級</th></tr>
          <?php echo Latin_Common::make_adjective_chart(); ?>
          <tr><th class="text-center" scope="row" colspan="7">最上級</th></tr>
          <?php echo Latin_Common::make_adjective_chart(); ?>
        </tbody>
      </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        var adj_table_data = '<?php echo json_encode($declensions, JSON_UNESCAPED_UNICODE); ?>';
    </script>
	  <script type="text/javascript" src="js/input_button.js"></script>
    <script>
        $(function(){
          // イベントを設定
          setEvents();
        });

        // 配列をテーブル用に変換にする。
        function get_adjective(table_data, word){

          // JSONに書き換え
          var json_adjective = JSON.parse(table_data)[word];

          // 原級形容詞の格変化情報を取得
          var positive_masc_sg = json_adjective["positive"]["masc"]["sg"]; //単数男性
          var positive_fem_sg = json_adjective["positive"]["fem"]["sg"];   //単数女性
          var positive_neu_sg = json_adjective["positive"]["neu"]["sg"];   	//単数中性
          var positive_masc_pl = json_adjective["positive"]["masc"]["pl"]; 	//複数男性
          var positive_fem_pl = json_adjective["positive"]["fem"]["pl"];   	//複数女性
          var positive_neu_pl = json_adjective["positive"]["neu"]["pl"];   		//複数中性
          
          // 比較級形容詞の格変化情報を取得
          var comp_masc_sg = json_adjective["comp"]["masc"]["sg"]; 	//単数男性
          var comp_fem_sg = json_adjective["comp"]["fem"]["sg"];   	//単数女性
          var comp_neu_sg = json_adjective["comp"]["neu"]["sg"];   	//単数中性
          var comp_masc_pl = json_adjective["comp"]["masc"]["pl"]; 		//複数男性
          var comp_fem_pl = json_adjective["comp"]["fem"]["pl"];   		//複数女性
          var comp_neu_pl = json_adjective["comp"]["neu"]["pl"];   		//複数中性
          
          // 最上級形容詞の格変化情報を取得
          var super_masc_sg = json_adjective["super"]["masc"]["sg"]; 	//単数男性
          var super_fem_sg = json_adjective["super"]["fem"]["sg"];   	//単数女性
          var super_neu_sg = json_adjective["super"]["neu"]["sg"];   	//単数中性
          var super_masc_pl = json_adjective["super"]["masc"]["pl"]; 		//複数男性
          var super_fem_pl = json_adjective["super"]["fem"]["pl"];   		//複数女性
          var super_neu_pl = json_adjective["super"]["neu"]["pl"];   		//複数中性
          
          // 格納データを作成
          var adj_table = [
            ["", "", "", "", "", "", ""],
            [positive_masc_sg["nom"], positive_fem_sg["nom"], positive_neu_sg["nom"], positive_masc_pl["nom"], positive_fem_pl["nom"], positive_neu_pl["nom"]],
            [positive_masc_sg["gen"], positive_fem_sg["gen"], positive_neu_sg["gen"], positive_masc_pl["gen"], positive_fem_pl["gen"], positive_neu_pl["gen"]],
            [positive_masc_sg["dat"], positive_fem_sg["dat"], positive_neu_sg["dat"], positive_masc_pl["dat"], positive_fem_pl["dat"], positive_neu_pl["dat"]],
            [positive_masc_sg["acc"], positive_fem_sg["acc"], positive_neu_sg["acc"], positive_masc_pl["acc"], positive_fem_pl["acc"], positive_neu_pl["acc"]],
            [positive_masc_sg["abl"], positive_fem_sg["abl"], positive_neu_sg["abl"], positive_masc_pl["abl"], positive_fem_pl["abl"], positive_neu_pl["abl"]],
            [positive_masc_sg["loc"], positive_fem_sg["loc"], positive_neu_sg["loc"], positive_masc_pl["loc"], positive_fem_pl["loc"], positive_neu_pl["loc"]],
            [positive_masc_sg["voc"], positive_fem_sg["voc"], positive_neu_sg["voc"], positive_masc_pl["voc"], positive_fem_pl["voc"], positive_neu_pl["voc"]],
            ["", "", "", "", "", "", ""],
            [comp_masc_sg["nom"], comp_fem_sg["nom"], comp_neu_sg["nom"], comp_masc_pl["nom"], comp_fem_pl["nom"], comp_neu_pl["nom"]],
            [comp_masc_sg["gen"], comp_fem_sg["gen"], comp_neu_sg["gen"], comp_masc_pl["gen"], comp_fem_pl["gen"], comp_neu_pl["gen"]],
            [comp_masc_sg["dat"], comp_fem_sg["dat"], comp_neu_sg["dat"], comp_masc_pl["dat"], comp_fem_pl["dat"], comp_neu_pl["dat"]],
            [comp_masc_sg["acc"], comp_fem_sg["acc"], comp_neu_sg["acc"], comp_masc_pl["acc"], comp_fem_pl["acc"], comp_neu_pl["acc"]],
            [comp_masc_sg["abl"], comp_fem_sg["abl"], comp_neu_sg["abl"], comp_masc_pl["abl"], comp_fem_pl["abl"], comp_neu_pl["abl"]],
            [comp_masc_sg["loc"], comp_fem_sg["loc"], comp_neu_sg["loc"], comp_masc_pl["loc"], comp_fem_pl["loc"], comp_neu_pl["loc"]],
            [comp_masc_sg["voc"], comp_fem_sg["voc"], comp_neu_sg["voc"], comp_masc_pl["voc"], comp_fem_pl["voc"], comp_neu_pl["voc"]],
            ["", "", "", "", "", "", ""],
            [super_masc_sg["nom"], super_fem_sg["nom"], super_neu_sg["nom"], super_masc_pl["nom"], super_fem_pl["nom"], super_neu_pl["nom"]],
            [super_masc_sg["gen"], super_fem_sg["gen"], super_neu_sg["gen"], super_masc_pl["gen"], super_fem_pl["gen"], super_neu_pl["gen"]],
            [super_masc_sg["dat"], super_fem_sg["dat"], super_neu_sg["dat"], super_masc_pl["dat"], super_fem_pl["dat"], super_neu_pl["dat"]],
            [super_masc_sg["acc"], super_fem_sg["acc"], super_neu_sg["acc"], super_masc_pl["acc"], super_fem_pl["acc"], super_neu_pl["acc"]],
            [super_masc_sg["abl"], super_fem_sg["abl"], super_neu_sg["abl"], super_masc_pl["abl"], super_fem_pl["abl"], super_neu_pl["abl"]],
            [super_masc_sg["loc"], super_fem_sg["loc"], super_neu_sg["loc"], super_masc_pl["loc"], super_fem_pl["loc"], super_neu_pl["loc"]],
            [super_masc_sg["voc"], super_fem_sg["voc"], super_neu_sg["voc"], super_masc_pl["voc"], super_fem_pl["voc"], super_neu_pl["voc"]],
          ];
          
          // 結果を返す。
          return adj_table;
        }

        // 副詞を取得
        function get_title_and_adverb(table_data, grade, word){
          // JSONに書き換え
          var json_adverb = JSON.parse(table_data)[word];
          // 形容詞の等級に応じて返す。
          switch (grade) {
            case "positive":
              return "原級　副詞：" + json_adverb[grade]["adverb"];
              break;
            case "comp":
              return "比較級　副詞：" + json_adverb[grade]["adverb"];
              break;
            case 'super':
              return "最上級　副詞：" + json_adverb[grade]["adverb"];
              break;
            default:
              return "原級　副詞：" + json_adverb[grade]["adverb"];
            }       
        }

        // 単語選択後の処理
        function output_table_data(){
          // 格変化表を取得 
          const adjective_decl_data = get_adjective(adj_table_data, $('#adjective-selection').val());

          // 行オブジェクトの取得
          var rows = $('#adjective-table')[0].rows;
          // 各行をループ処理
          $.each(rows, function(i){
            // タイトル行は除外する。
            if(i == 0 || i == 1){
              return true;
            } else if(adjective_decl_data[i - 2][0] == ""){
              if(i == 2){
                rows[i].cells[0].innerText = get_title_and_adverb(adj_table_data, "positive", $('#adjective-selection').val());
              } else if(i == 10){
                rows[i].cells[0].innerText = get_title_and_adverb(adj_table_data, "comp", $('#adjective-selection').val());
              } else if(i == 18){
                rows[i].cells[0].innerText = get_title_and_adverb(adj_table_data, "super", $('#adjective-selection').val());
              }
              // 説明行も除外
              return true;
            }
            // 格変化を挿入
            rows[i].cells[1].innerText = adjective_decl_data[i - 2][0]; // 単数男性(1行目)
            rows[i].cells[2].innerText = adjective_decl_data[i - 2][1]; // 単数女性(2行目)
            rows[i].cells[3].innerText = adjective_decl_data[i - 2][2]; // 単数中性(3行目)
            rows[i].cells[4].innerText = adjective_decl_data[i - 2][3]; // 複数男性(4行目)
            rows[i].cells[5].innerText = adjective_decl_data[i - 2][4]; // 複数女性(5行目)
            rows[i].cells[6].innerText = adjective_decl_data[i - 2][5]; // 複数中性(6行目)           
          });
        }

        //イベントを設定
        function setEvents(){
	        // セレクトボックス選択時
	        $('#adjective-selection').change( function(){
            output_table_data();
	        });
          // ボタンにイベントを設定
          Input_Botton.LatinBotton('#input_adjective');  
        }

    </script>
  <footer class="">
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>