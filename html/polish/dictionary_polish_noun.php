<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_noun_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Polish_Common.php");

// 活用表を取得する。
function get_noun_declension_chart($word){
	// 名詞の情報を取得
	$noun_words = Polish_Common::get_dictionary_stem_by_japanese($word, Polish_Common::DB_NOUN, "");
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
function get_noun_declension_chart_by_english($word){
  // 英語で取得する。
  $noun_words = Polish_Common::get_dictionary_stem_by_english($word, Polish_Common::DB_NOUN);    
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
function get_noun_declension_chart_by_polish($word){
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

// 検索結果の配列
$declensions = array();

// AIによる造語対応
$janome_result = Commons::get_multiple_words_detail($input_adjective);
$janome_result = Commons::convert_compound_array($janome_result);

// 対象が入力されていれば処理を実行
if($input_noun != "" && count($janome_result) == 1 && $janome_result[0][1] == "形容詞" && !Polish_Common::is_alphabet_or_not($input_noun)){
  // 形容詞の場合は形容詞で名詞を取得
	$declensions = get_adjective_declension_chart($input_noun);
} else if($input_noun != "" && $search_lang == "polish" && Polish_Common::is_alphabet_or_not($input_noun)){
  // ポーランド語
  $declensions = get_noun_declension_chart_by_polish($input_noun);
} else if($input_noun != "" && $search_lang == "english" && Polish_Common::is_alphabet_or_not($input_noun)){
  // 英語
	$declensions = get_noun_declension_chart_by_english($input_noun);
} else if($input_noun != "" && $search_lang == "japanese" && !Polish_Common::is_alphabet_or_not($input_noun)){
  // 日本語
	$declensions = get_noun_declension_chart($input_noun);
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
    <title>印欧語活用辞典：ポーランド辞書</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
    <link href="/../css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
  </head>
    <?php require_once("polish_header.php"); ?>
  <body>
    <div class="container item table-striped">
      <p>あいまい検索は+ ※(薄文字の部分は現在は使わない)</p>
      <form action="" method="post" class="mt-4 mb-4" id="form-search">
        <input type="text" name="input_noun" id="input_noun" class="form-control" placeholder="検索語句(日本語・英語・ポーランド語)、形容詞も可">
        <?php echo Polish_Common::language_select_box(); ?>      
        <input type="submit" class="btn-check" id="btn-search">
        <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-search">検索</label>
        <select class="form-select" id="noun-selection">
          <option selected>単語を選んでください</option>
          <?php echo Commons::select_option($declensions); ?>
        </select>
      </form>
      <?php echo Polish_Common::input_special_button(); ?>     
      <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="noun-table" style="overflow: auto;">
        <thead>
          <tr><th scope="row" class="text-center" style="width:10%">格</th>
          <th scope="col" class="text-center" style="width:30%">単数</th>
          <th scope="col" class="table-archaic text-center" style="width:30%">双数</th>
          <th scope="col" class="text-center" style="width:30%">複数</th>
        </tr>
      </thead>
        <tbody>
          <tr><th class="text-center" scope="row">主格</th><td></td><td class="table-archaic"></td><td></td></tr>
          <tr><th class="text-center" scope="row">属格</th><td></td><td class="table-archaic"></td><td></td></tr>
          <tr><th class="text-center" scope="row">与格</th><td></td><td class="table-archaic"></td><td></td></tr>
          <tr><th class="text-center" scope="row">対格</th><td></td><td class="table-archaic"></td><td></td></tr>
          <tr><th class="text-center" scope="row">具格</th><td></td><td class="table-archaic"></td><td></td></tr>          
          <tr><th class="text-center" scope="row">地格</th><td></td><td class="table-archaic"></td><td></td></tr>          
          <tr><th class="text-center" scope="row">呼格</th><td></td><td class="table-archaic"></td><td></td></tr>                 
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
	  <script type="text/javascript" src="/../js/background_attack.js"></script>
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
          // オブジェクト呼び出し
          //var cyber_punish_kacap = new Cyber_Punish_Kacap(500);
          // 実行
          //cyber_punish_kacap.attack_start();
        }
    </script>    
  </body>
</html>