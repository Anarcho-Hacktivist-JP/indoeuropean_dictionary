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

// 活用表を取得する。
function get_noun_declension_chart($word){
	// 名詞の情報を取得
	$noun_words = Sanskrit_Common::get_dictionary_stem_by_japanese($word, Sanskrit_Common::DB_NOUN, "");
	// 形容詞の情報を取得
	$adjective_words = Sanskrit_Common::get_dictionary_stem_by_japanese($word, Sanskrit_Common::DB_ADJECTIVE, "");
  // 取得できない場合は
  if(!$noun_words && !$adjective_words){
    // 空を返す。
    return array();
  }

  // 名詞のデータを取得
  $declensions = set_noun_table_data($noun_words, $adjective_words);
  // 結果を返す。
  return $declensions;
}

// 名詞を梵語で取得する。
function get_noun_declension_chart_by_sanskrit($word){

  // 単語から直接取得する
  $noun_words = Sanskrit_Common::get_wordstem_from_DB($word, Sanskrit_Common::DB_NOUN);
  // 取得できない場合は
  if(!$noun_words && Sanskrit_Common::is_alphabet_or_not($word)){
    // アルファベットの場合は単語を入れる。
    $noun_words[] = $word;
  }

  // 名詞のデータを取得
  $declensions = set_noun_table_data($noun_words, array());
  // 結果を返す。
  return $declensions;
}

// 名詞を英語で取得する。
function get_noun_declension_chart_by_english($word){
  // 英語で取得する。
  // 名詞の情報を取得
  $noun_words = Sanskrit_Common::get_dictionary_stem_by_english($word, Sanskrit_Common::DB_NOUN);
	// 形容詞の情報を取得
  $adjective_words = Sanskrit_Common::get_dictionary_stem_by_english($word, Sanskrit_Common::DB_ADJECTIVE);   
  // 取得できない場合は
  if(!$noun_words && !$adjective_words && Sanskrit_Common::is_alphabet_or_not($word)){
    // アルファベットの場合は単語を入れる。
    $noun_words[] = $word;
  }

  // 名詞のデータを取得
  $declensions = set_noun_table_data($noun_words, $adjective_words);
  // 結果を返す。
  return $declensions;
}

// 名詞のデータをセットする。
function set_noun_table_data($noun_words, $adjective_words){
 	// 配列を宣言
   $declensions = array(); 
   // 名詞がある場合は名詞を新しい配列に詰め替え
   if($noun_words){
     foreach ($noun_words as $noun_word) {
       // 読み込み
       $sanskrit_noun = new Vedic_Noun($noun_word);
       // 配列に格納
       $declensions[$sanskrit_noun->get_second_stem()] = $sanskrit_noun->get_chart();
       // メモリを解放
       unset($sanskrit_noun);
     }
   }
 
   // 形容詞がある場合は名詞を新しい配列に詰め替え
   if($adjective_words){
     // 名詞区分のセット
     $noun_genres = array("animate", "action");
     // 形容詞を新しい配列に詰め替え
     foreach ($adjective_words as $adjective_word) {
       // 全ての名詞区分の名詞を取得する。
       foreach ($noun_genres as $noun_genre) {
         // 読み込み
         $sanskrit_noun = new Vedic_Noun($adjective_word, $noun_genre);
         // 配列に格納
         $declensions[$sanskrit_noun->get_second_stem()] = $sanskrit_noun->get_chart();
         // メモリを解放
         unset($sanskrit_noun);
       }
     }
   }
   // 結果を返す。
   return $declensions;
}

//造語対応
function get_compound_noun_word($janome_result, $input_noun){
  // データを取得(男性)
	$declensions = Sanskrit_Common::make_compound_chart($janome_result, "noun", $input_noun);
	// 結果を返す。
	return $declensions;
}

// 挿入データ－対象－
$input_noun = trim(filter_input(INPUT_POST, 'input_noun'));
// 挿入データ－言語－
$search_lang = trim(filter_input(INPUT_POST, 'input_search_lang'));

// AIによる造語対応
$janome_result = Commons::get_multiple_words_detail($input_noun);
$janome_result = Commons::convert_compound_array($janome_result);

// 検索結果の配列
$declensions = array();

// 条件ごとに判定して単語を検索して取得する
if($search_lang == "japanese" && count($janome_result) > 1 && !ctype_alnum($input_noun) && !strpos($input_noun, Commons::$LIKE_MARK)){
  // 複合語の場合(日本語のみ)
  $declensions = get_compound_noun_word($janome_result, $input_noun);
} else if($input_noun != "" && $search_lang == "japanese" && $janome_result[0][1] == "動詞"){
  // 動詞の場合の場合(日本語のみ)
  $declensions = Sanskrit_Common::get_noun_from_verb($input_noun);
} else if($input_noun != "" && $search_lang == "sanskrit" && Sanskrit_Common::is_alphabet_or_not($input_noun)){
  // 梵語
  // 対象が入力されていれば処理を実行
	$declensions = get_noun_declension_chart_by_sanskrit($input_noun);
} else if($input_noun != "" && $search_lang == "english" && Sanskrit_Common::is_alphabet_or_not($input_noun)){
  // 英語
  // 対象が入力されていれば処理を実行
	$declensions = get_noun_declension_chart_by_english($input_noun);
} else if($input_noun != "" && $search_lang == "japanese" && !Sanskrit_Common::is_alphabet_or_not($input_noun)){
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
    <title>印欧語活用辞典：梵語辞書</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>    
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
  </head>
    <?php require_once("sanskrit_header.php"); ?>
  <body>
    <div class="container item table-striped">
      <p>あいまい検索は+</p>
      <form action="" method="post" class="mt-4 mb-4" id="form-search">
        <input type="text" name="input_noun" id="input_noun" class="form-control" placeholder="検索語句(日本語・英語・サンスクリット)">
        <input type="submit" class="btn-check" id="btn-search">
        <?php echo Sanskrit_Common::language_select_box(); ?>
        <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-search">検索</label>
        <select class="form-select" id="noun-selection">
          <option selected>単語を選んでください</option>
          <?php echo Commons::select_option($declensions); ?>
        </select>
      </form>
      <?php echo Sanskrit_Common::input_special_button(); ?>              
      <table class="table table-success table-bordered table-striped table-hover" id="noun-table">
        <thead>
          <tr>
          <th class="text-center" scope="row" style="width:19%">格</th>
          <th class="text-center" scope="col" style="width:27%">単数</th>
          <th class="text-center" scope="col" style="width:27%">双数</th>
          <th class="text-center" scope="col" style="width:27%">複数</th>
        </tr>
      </thead>
        <tbody>
          <tr><th class="text-center" scope="row">主格</th><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">属格</th><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">与格</th><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">対格</th><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">奪格</th><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">具格</th><td></td><td></td><td></td></tr>          
          <tr><th class="text-center" scope="row">地格</th><td></td><td></td><td></td></tr>          
          <tr><th class="text-center" scope="row">呼格</th><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">起点の副詞</th><td colspan="3"></td></tr>
          <tr><th class="text-center" scope="row">場所の副詞1</th><td colspan="3"></td></tr>
          <tr><th class="text-center" scope="row">場所の副詞2</th><td colspan="3"></td></tr>
          <tr><th class="text-center" scope="row">状態や方法の副詞</th><td colspan="3"></td></tr>
          <tr><th class="text-center" scope="row">種類や回数の副詞</th><td colspan="3"></td></tr>
          <tr><th class="text-center" scope="row">様態の副詞</th><td colspan="3"></td></tr>
          <tr><th class="text-center" scope="row">性質や付加状況の副詞</th><td colspan="3"></td></tr>
          <tr><th class="text-center" scope="row">時の副詞</th><td colspan="3"></td></tr>
          <tr><th class="text-center" scope="row">方向の副詞</th><td colspan="3"></td></tr> 
          <tr><th class="text-center" scope="row">配分や量や方法の副詞</th><td colspan="3"></td></tr>                    
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
            [declension_sg["abl"], declension_du["abl"], declension_pl["abl"]],
            [declension_sg["ins"], declension_du["ins"], declension_pl["ins"]],            
            [declension_sg["loc"], declension_du["loc"], declension_pl["loc"]],
            [declension_sg["voc"], declension_du["voc"], declension_pl["voc"]],                  
            [declension_sg["elative"]],
            [declension_sg["inessive1"]],
            [declension_sg["inessive2"]],  
            [declension_sg["comitative"]],
            [declension_sg["multiplicative"]],
            [declension_sg["essive"]],             
            [declension_sg["translative"]],
            [declension_sg["temporal"]],
            [declension_sg["illative"]],
            [declension_sg["distributive"]],
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
          Input_Botton.SanskritBotton('#input_noun'); 
        }

    </script>
  </body>
</html>