<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_noun_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Polish_Common.php");

// 活用表を取得する。
function get_noun_declension_chart($word, $gender){
	// 名詞の情報を取得
	$noun_words = Polish_Common::get_dictionary_stem_by_japanese($word, Polish_Common::DB_NOUN, $gender);
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
		$polish_noun = new Polish_Noun($noun_word);
		// 配列に格納
		$declensions[$polish_noun->get_first_stem()] = $polish_noun->get_chart();
	}
  // 結果を返す。
	return $declensions;
}

// 活用表を取得する。
function get_noun_declension_chart_by_english($word, $gender){
  // 英語で取得する。
  $noun_words = Polish_Common::get_dictionary_stem_by_english($word, Polish_Common::DB_NOUN, $gender);    
  // 取得できない場合は
  if(!$noun_words && !Polish_Common::is_alphabet_or_not($word)){    
    // 空を返す。
    return array();
  } else {
    $noun_words[] = $word;
  }
 	// 配列を宣言
  $declensions = array(); 
	// 新しい配列に詰め替え
	foreach ($noun_words as $noun_word) {
		// 読み込み
		$polish_noun = new Polish_Noun($noun_word);
		// 配列に格納
		$declensions[$polish_noun->get_first_stem()] = $polish_noun->get_chart();
	}
  // 結果を返す。
	return $declensions;
}

// 活用表を取得する。
function get_noun_declension_chart_by_polish($word, $gender){
	// 名詞の情報を取得
  // 単語から直接取得する
  $noun_words = Polish_Common::get_wordstem_from_DB($word, Polish_Common::DB_NOUN);
  // 取得できない場合は
  if(!$noun_words){
    $noun_words[] = $word;
  } else if(Polish_Common::is_alphabet_or_not($word)){
    $noun_words[] = $word;
  }
 	// 配列を宣言
  $declensions = array(); 
	// 新しい配列に詰め替え
	foreach ($noun_words as $noun_word) {
		// 読み込み
		$polish_noun = new Polish_Noun($noun_word);
		// 配列に格納
		$declensions[$polish_noun->get_first_stem()] = $polish_noun->get_chart();
	}
  // 結果を返す。
	return $declensions;
}

// 形容詞から名詞の活用表を取得する。
function get_adjective_declension_chart($word){
	// 形容詞の情報を取得
	$adjective_words = Polish_Common::get_dictionary_stem_by_japanese($word, Polish_Common::DB_ADJECTIVE, "");
  // 取得できない場合は
  if(!$adjective_words){
    // 英語で取得する。
    $adjective_words = Polish_Common::get_dictionary_stem_by_english($word, Polish_Common::DB_ADJECTIVE);  
    if(!$adjective_words){
      // 取得できない場合は
      if(!$adjective_words && !Polish_Common::is_alphabet_or_not($word)){
        // 空を返す。
        return array();
      } else if(Polish_Common::is_alphabet_or_not($word)){
        $adjective_words[] = $word;
      }
    }
  }

  // 名詞化配列を生成
  $noun_suffix = array("ość", "ota", "stwo");

	// 配列を宣言
	$declensions = array();  
	// 新しい配列に詰め替え
	foreach ($adjective_words as $adjective_word) {
    // 形容詞化
    foreach($noun_suffix as $suffix){
		  // 読み込み
		  $polish_noun= new Polish_Noun(mb_substr($adjective_word, 0, -1).$suffix);
		  // 活用表生成
		  $declensions[$polish_noun->get_first_stem()] = $polish_noun->get_chart();
    }
	}
  // 結果を返す。
	return $declensions;
}

// 挿入データ－対象－
$input_noun = Commons::cut_words(trim(filter_input(INPUT_POST, 'input_noun')), 128);
// 挿入データ－言語－
$search_lang = trim(filter_input(INPUT_POST, 'input_search_lang'));
// 挿入データ－性別－
$gender = trim(filter_input(INPUT_POST, 'gender'));

// 検索結果の配列
$declensions = array();

// AIによる造語対応
$janome_result = Commons::get_multiple_words_detail($input_adjective);
$janome_result = Commons::convert_compound_array($janome_result);

// 対象が入力されていれば処理を実行
if($input_noun != "" && count($janome_result) == 1 && $janome_result[0][1] == "形容詞" && $search_lang == Commons::NIHONGO && !Polish_Common::is_alphabet_or_not($input_noun)){
  // 形容詞の場合は形容詞で名詞を取得
	$declensions = get_adjective_declension_chart($input_noun);
} else if($input_noun != "" && $search_lang == Commons::POLISH && Polish_Common::is_alphabet_or_not($input_noun)){
  // ポーランド語
  $declensions = get_noun_declension_chart_by_polish($input_noun, $gender);
} else if($input_noun != "" && $search_lang == Commons::EIGO && Polish_Common::is_alphabet_or_not($input_noun)){
  // 英語
	$declensions = get_noun_declension_chart_by_english($input_noun, $gender);
} else if($input_noun != "" && $search_lang == Commons::NIHONGO && !Polish_Common::is_alphabet_or_not($input_noun)){
  // 日本語
	$declensions = get_noun_declension_chart($input_noun, $gender);
}

?>
<!doctype html>
<html lang="ja">
  <head>
    <title>印欧語活用辞典：ポーランド辞書</title>
    <?php require_once("polish_including.php"); ?>
  </head>
  <body>
    <?php require_once("polish_header.php"); ?>
    <div class="container item table-striped">
      <h1>ポーランド辞書（名詞）</h1>
      <p>性別選択は名詞で入力の場合のみ可</p>
      <form action="" method="post" class="mt-4 mb-4" id="form-search">
        <section class="row mb-3">
          <div class="col-md-6 mb-0 textBox1">
            <input type="text" name="input_noun" id="input_noun" class="form-control" placeholder="検索語句(日本語・英語・ポーランド語)、形容詞も可 あいまい検索は+">
            <?php echo Polish_Common::input_special_button(); ?>
          </div>
          <div class="col-md-3 mb-0">
            <?php echo Polish_Common::language_select_box(); ?>
          </div>
          <div class="col-md-3 mb-0">
            <input type="submit" class="btn-check" id="btn-search">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-search">検索</label>
          </div>
        </section>
        <?php echo Polish_Common::noun_gender_selection_button(true); ?>
      </form>
      <select class="form-select" id="noun-selection">
        <option selected>単語を選んでください</option>
        <?php echo Commons::select_option($declensions); ?>
      </select>
      <?php echo Commons::archaic_button(); ?>
      <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="noun-table" style="overflow: auto;">
        <?php echo Polish_Common::make_noun_column_chart(); ?>
        <?php echo Polish_Common::make_noun_chart(); ?>
      </table>
    </div>
  <footer class="">
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        var noun_table_data = '<?php echo json_encode($declensions, JSON_UNESCAPED_UNICODE); ?>';
    </script>
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
            [declension_sg["nom"], "*" + declension_du["nom"], declension_pl["nom"]],
            [declension_sg["gen"], "*" + declension_du["gen"], declension_pl["gen"]],
            [declension_sg["dat"], "*" + declension_du["dat"], declension_pl["dat"]],
            [declension_sg["acc"], "*" + declension_du["acc"], declension_pl["acc"]],
            [declension_sg["ins"], "*" + declension_du["ins"], declension_pl["ins"]],            
            [declension_sg["loc"], "*" + declension_du["loc"], declension_pl["loc"]],
            [declension_sg["voc"], "*" + declension_du["voc"], declension_pl["voc"]],            
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
          Input_Botton.PolishBotton('#input_noun'); 
          // 古形隠しボタン
          Input_Botton.HiddenArchaicBotton();
          // 初期状態は古形の表示を隠す。
          $(".table-archaic").css("display", "none");
          // オブジェクト呼び出し
          //var cyber_punish_kacap = new Cyber_Punish_Kacap(500);
          // 実行
          //cyber_punish_kacap.attack_start();
        }
    </script>    
  </body>
</html>