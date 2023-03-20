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

// 活用表を取得する。
function get_verb_conjugation_chart($word){
  // 配列を宣言
	$conjugations = array();
	// 動詞の情報を取得
	$latin_verbs = Latin_Common::get_verb_by_japanese($word);
  // 動詞の情報が取得できない場合は
  if(!$latin_verbs && Latin_Common::is_alphabet_or_not($word)){
    // 空を返す。
    return array();   
  }
  // 新しい配列に詰め替え
	foreach ($latin_verbs as $latin_verb) {
    // 動詞を生成
	  $verb_latin = new Common_Romance_Verb($latin_verb["infinitive_stem"]);
	  // 活用表生成、配列に格納
	  $conjugations[$verb_latin->get_infinitive()] = $verb_latin->get_chart();
	}
  // 結果を返す。
	return $conjugations;
}

// 活用表を取得する。
function get_verb_conjugation_chart_by_english($word){
  // 配列を宣言
	$conjugations = array();
	// 英語で動詞の情報を取得
	$latin_verbs = Latin_Common::get_verb_by_english($word);
  // 動詞の情報が取得できない場合は
  if(!$latin_verbs){
	  // 動詞が取得できない場合
    // 動詞を生成
	  $verb_latin = new Common_Romance_Verb($word);
	  // 活用表生成、配列に格納
	  $conjugations[$verb_latin->get_infinitive()] = $verb_latin->get_chart();
  } else {
    // 新しい配列に詰め替え
	  foreach ($latin_verbs as $latin_verb) {
      // 動詞を生成
	    $verb_latin = new Common_Romance_Verb($latin_verb["infinitive_stem"]);
	    // 活用表生成、配列に格納
	    $conjugations[$verb_latin->get_infinitive()] = $verb_latin->get_chart();
	  }
  }
  // 結果を返す。
	return $conjugations;
}

// 活用表を取得する。
function get_verb_conjugation_chart_by_latin($word){
  // 配列を宣言
	$conjugations = array();
  // 動詞の情報を取得
	$latin_verb = Latin_Common::get_verb_from_DB($word);
  // 動詞が取得できたか確認する。
  if($latin_verb){
    // 活用種別で分ける
    if($latin_verb[0]["verb_type"] == "5sum"){
      // 不規則動詞(esse)
	    $verb_latin = new Common_Romance_Sum();
      $verb_latin->add_stem($latin_verb[0]["infinitive_stem"]);
    } else {
      // 動詞を生成
	    $verb_latin = new Common_Romance_Verb($latin_verb[0]["infinitive_stem"]);
    }

	  // 活用表生成、配列に格納
	  $conjugations[$verb_latin->get_infinitive()] = $verb_latin->get_chart();
	  // メモリを解放
	  unset($verb_data);
  } else {
	  // 動詞が取得できない場合
    // 動詞を生成
	  $verb_latin = new Common_Romance_Verb($word);
	  // 活用表生成、配列に格納
	  $conjugations[$verb_latin->get_infinitive()] = $verb_latin->get_chart();
	  // メモリを解放
	  unset($verb_data);
  }
  // 結果を返す。
	return $conjugations;
}

// 名詞から活用表を取得する。
function get_conjugation_by_noun($word){

	// 名詞の語幹を取得
	$latin_verbs = Latin_Common::get_latin_denomitive_verb($word, Latin_Common::DB_NOUN);
  // 名詞の情報が取得できない場合は
  if(!$latin_verbs){
    // 空を返す。
    return array();
  } 
  // 配列を宣言
  $conjugations = array();   
	// 新しい配列に詰め替え
	foreach ($latin_verbs as $latin_verb) {
	  // 読み込み
	  $verb_data = new Common_Romance_Verb($latin_verb);
	  // 活用表生成、配列に格納
	  $conjugations[$verb_data->get_infinitive()] = $verb_data->get_chart();
	  // メモリを解放
	  unset($verb_data);
	}
  // 結果を返す。
	return $conjugations;
}

// 形容詞から活用表を取得する。
function get_conjugation_by_adjective($word){
	// 形容詞の語幹を取得
	$latin_verbs = Latin_Common::get_latin_denomitive_verb($word, Latin_Common::DB_ADJECTIVE);
  // 形容詞の情報が取得できない場合は
  if(!$latin_verbs){
    // 空を返す。
    return array();
  }
  // 状態動詞を結合する。
  $latin_verbs = array_merge(Latin_Common::get_latin_stative_verb($word), $latin_verbs);
  // 配列を宣言
  $conjugations = array();   
	// 新しい配列に詰め替え
	foreach ($latin_verbs as $latin_verb) {         
	  // 読み込み
	  $verb_data = new Common_Romance_Verb($latin_verb["infinitive_stem"]);
	  // 活用表生成、配列に格納
	  $conjugations[$verb_data->get_infinitive()] = $verb_data->get_chart();
	  // メモリを解放
	  unset($verb_data);
	}
  // 結果を返す。
	return $conjugations;
}

// 挿入データ－対象－
$input_verb = trim(filter_input(INPUT_POST, 'input_verb'));
// 挿入データ－言語－
$search_lang = trim(filter_input(INPUT_POST, 'input_search_lang'));

// AIによる造語対応
$janome_result = Commons::get_multiple_words_detail($input_verb);
$janome_result = Commons::convert_compound_array($janome_result);

// 条件ごとに判定して単語を検索して取得する
if($input_verb != "" && $janome_result[0][1] == "名詞" && $search_lang == Commons::NIHONGO && !Latin_Common::is_alphabet_or_not($input_verb) && !strpos($input_verb, Commons::$LIKE_MARK)){
  // 名詞の場合は名詞で動詞を取得(日本語のみ)
	$conjugations = get_conjugation_by_noun($input_verb);
} else if($input_verb != "" && $janome_result[0][1] == "形容詞" && $search_lang == Commons::NIHONGO && !Latin_Common::is_alphabet_or_not($input_verb) && !strpos($input_verb, Commons::$LIKE_MARK) ){
  // 形容詞の場合は形容詞で動詞を取得(日本語のみ)
	$conjugations = get_conjugation_by_adjective($input_verb);
} else if($input_verb != "" && $search_lang == Commons::LATIN && Latin_Common::is_alphabet_or_not($input_verb)){
  // 対象が入力されていればラテン語処理を実行
	$conjugations = get_verb_conjugation_chart_by_latin($input_verb);
} else if($input_verb != "" && $search_lang == Commons::EIGO && Latin_Common::is_alphabet_or_not($input_verb)){
  // 対象が入力されていれば英語で処理を実行
	$conjugations = get_verb_conjugation_chart_by_english($input_verb);
} else if($input_verb != "" && $search_lang == Commons::NIHONGO && !Latin_Common::is_alphabet_or_not($input_verb)){
  // 対象が入力されていれば日本語で処理を実行
	$conjugations = get_verb_conjugation_chart($input_verb);
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
    <link href="/../css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
  </head>
    <?php require_once("latin_header.php"); ?>
  <body>
    <div class="container item table-striped">
      <h1>ラテン語辞書（俗ラテン語動詞）</h1>
      <p>あいまい検索は+</p>
      <form action="" method="post" class="mt-4 mb-4" id="form-category">
        <input type="text" name="input_verb" class="form-control" id="input_verb" placeholder="検索語句(日本語・英語・ラテン語)、名詞や形容詞も可">
        <?php echo Latin_Common::input_special_button(); ?>    
        <?php echo Latin_Common::language_select_box(); ?> 
        <input type="submit" class="btn-check" id="btn-generate">
        <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-generate">検索</label>
        <select class="form-select" id="verb-selection" aria-label="Default select example">
          <option selected>単語を選んでください</option>
          <?php echo Commons::select_option($conjugations); ?>
        </select>
      </form>
      <details>
        <summary>動詞の活用</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="conjugation-table" style="overflow: auto;">
          <thead>
            <tr>
              <th class="text-center" scope="row" style="width:5%">相</th>
              <th class="text-center" scope="col" colspan="3" style="width:60%">進行相</th>
              <th class="text-center" scope="col" colspan="2" style="width:35%">完了相</th>
            </tr>
            <tr>
              <th class="text-center" scope="row" style="width:5%">法</th>
              <th class="text-center" scope="col" style="width:15%">直説法</th>
              <th class="text-center" scope="col" style="width:15%">接続法</th>
              <th class="text-center" scope="col" style="width:15%">命令法</th>
              <th class="text-center" scope="col" style="width:15%">直説法</th>
              <th class="text-center" scope="col" style="width:15%">接続法</th>
            </tr>
          </thead>
          <tbody>
            <tr><th class="text-center" scope="row" colspan="6">現在形</th></tr>
            <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row" colspan="6">過去形</th></tr>
            <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row" colspan="11">未来形</th></tr>
            <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td></tr>
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>不定詞・分詞</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap text-nowrap" id="infinitive-table">
          <thead>
            <tr><th class="text-center" scope="row" style="width:10%">不定詞・分詞</th><th scope="col" style="width:45%">不定詞</th><th scope="col" style="width:45%">分詞</th></tr></thead>
          <tbody>
            <tr><th class="text-center" scope="row">現在形1</th><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">現在形1</th><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">完了形</th><td></td><td></td></tr>
          </tbody>
        </table>
      </details><br>   
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        var verb_table_data = '<?php echo json_encode($conjugations, JSON_UNESCAPED_UNICODE); ?>';
    </script>
	  <script type="text/javascript" src="/../js/input_button.js"></script>
    <script>
        $(function(){
          // イベントを設定
          setEvents();
        });

        // 配列をテーブル用に変換にする。
        function get_verb(table_data, word){

          // JSONに書き換え
          var json_verb = JSON.parse(table_data)[word];

          // 活用情報を取得
          var active_present = json_verb["active"]["present"];       //能動態現在
          var active_imperfect = json_verb["active"]["past"];       //能動態過去進行
          var active_future = json_verb["active"]["future"];               //能動態未来
          var active_perfect = json_verb["active"]["present_perfect"];      //能動態完了      
          var active_perfect = json_verb["active"]["present_perfect"];      //能動態完了
          var active_past_perfect = json_verb["active"]["past_perfect"];      //能動態過去完了
          var active_future_perfect = json_verb["active"]["future_perfect"];      //能動態未来完了

          // 格納データを作成
          var verb_table = [
            ["", "", "", "", "", "", "", "", "", "", "", ""],
            [active_present["ind"]["1sg"], active_present["subj"]["1sg"], "-", active_perfect["ind"]["1sg"], active_perfect["subj"]["1sg"]],
            [active_present["ind"]["2sg"], active_present["subj"]["2sg"], active_present["imper"]["2sg"], active_perfect["ind"]["2sg"], active_perfect["subj"]["2sg"]],
            [active_present["ind"]["3sg"], active_present["subj"]["3sg"], "-", active_perfect["ind"]["3sg"], active_perfect["subj"]["3sg"]],
            [active_present["ind"]["1pl"], active_present["subj"]["1pl"], "-", active_perfect["ind"]["1pl"], active_perfect["subj"]["1pl"]],
            [active_present["ind"]["2pl"], active_present["subj"]["2pl"], active_present["imper"]["2pl"], active_perfect["ind"]["2pl"], active_perfect["subj"]["2pl"]],                                        
            [active_present["ind"]["3pl"], active_present["subj"]["3pl"], "-", active_perfect["ind"]["3pl"], active_perfect["subj"]["3pl"]],
            ["", "", "", "", "", "", "", "", "", "", "", ""],
            [active_imperfect["ind"]["1sg"], active_imperfect["subj"]["1sg"], "-", active_past_perfect["ind"]["1sg"], active_past_perfect["subj"]["1sg"]],
            [active_imperfect["ind"]["2sg"], active_imperfect["subj"]["2sg"], "-", active_past_perfect["ind"]["2sg"], active_past_perfect["subj"]["2sg"]],
            [active_imperfect["ind"]["3sg"], active_imperfect["subj"]["3sg"], "-", active_past_perfect["ind"]["3sg"], active_past_perfect["subj"]["3sg"]],
            [active_imperfect["ind"]["1pl"], active_imperfect["subj"]["1pl"], "-", active_past_perfect["ind"]["1pl"], active_past_perfect["subj"]["1pl"]],
            [active_imperfect["ind"]["2pl"], active_imperfect["subj"]["2pl"], "-", active_past_perfect["ind"]["2pl"], active_past_perfect["subj"]["2pl"]],
            [active_imperfect["ind"]["3pl"], active_imperfect["subj"]["3pl"], "-", active_past_perfect["ind"]["3pl"], active_past_perfect["subj"]["3pl"]],
            ["", "", "", "", "", "", "", "", "", "", "", ""],
            [active_future["ind"]["1sg"], "-", "-", active_future_perfect["ind"]["1sg"], "-",],
            [active_future["ind"]["2sg"], "-", "-", active_future_perfect["ind"]["2sg"], "-",],
            [active_future["ind"]["3sg"], "-", "-", active_future_perfect["ind"]["3sg"], "-",],
            [active_future["ind"]["1pl"], "-", "-", active_future_perfect["ind"]["1pl"], "-",],
            [active_future["ind"]["2pl"], "-", "-", active_future_perfect["ind"]["2pl"], "-",],
            [active_future["ind"]["3pl"], "-", "-", active_future_perfect["ind"]["3pl"], "-",],
          ];
          
          // 結果を返す。
          return verb_table;
        }

        // 配列をテーブル用に変換にする(不定詞用)。
        function get_infinitive(table_data, selected_word){

          // JSONに書き換え
          var json_inifinitive = JSON.parse(table_data)[selected_word]["infinitive"];
          var json_inifinitive = JSON.parse(table_data)[selected_word]["present_active"];
          var json_inifinitive = JSON.parse(table_data)[selected_word]["perfect_passive"];
          var json_inifinitive = JSON.parse(table_data)[selected_word]["future_passive"];

          // 格納データを作成
          var infinitive_table = [
            [json_inifinitive, json_inifinitive["present_passive"]],
            [json_inifinitive["perfect_active"], json_inifinitive["perfect_passive"]],
            [json_inifinitive["future_active"], json_inifinitive["future_passive"]],
          ];
          
          // 結果を返す。
          return infinitive_table;
        }

        // 単語選択後の処理
        function output_table_data(){
          // 活用表を取得 
          const conjugation_table = get_verb(verb_table_data, $('#verb-selection').val());
          // 行オブジェクトの取得
          var rows = $('#conjugation-table')[0].rows;
          // 各行をループ処理
          $.each(rows, function(i){
            // タイトル行は除外する。
            if(i <= 2){
              return true;
            } else if(i % 7 == 2){
              // 説明行も除外
              return true;
            }
            // 活用を挿入
            rows[i].cells[1].innerText = conjugation_table[i - 2][0]; // 進行相直説法能動
            rows[i].cells[2].innerText = conjugation_table[i - 2][1]; // 進行相接続法能動
            rows[i].cells[3].innerText = conjugation_table[i - 2][2]; // 進行相命令法能動
            rows[i].cells[4].innerText = conjugation_table[i - 2][3]; // 完了相直説法能動
            rows[i].cells[5].innerText = conjugation_table[i - 2][4]; // 完了相接続法能動
          });

          // 分詞・不定詞を取得                          
          const verb_infinitive = get_infinitive(verb_table_data, $('#verb-selection').val());
          
          // 不定詞を取得
          // 行オブジェクトの取得
          var rows = $('#infinitive-table')[0].rows;
          // 各行をループ処理
          $.each(rows, function(i){
            // タイトル行は除外する。
            if(i == 0){
              return true;
            }
            // 格変化を挿入
            rows[i].cells[1].innerText = verb_infinitive[i - 1][0]; // 能動態(1行目)
            rows[i].cells[2].innerText = verb_infinitive[i - 1][1]; // 受動態(2行目)
          });
        }

        //イベントを設定
        function setEvents(){
	        // セレクトボックス選択時
	        $('#verb-selection').change( function(){
            output_table_data();
	        });
          // ボタンにイベントを設定
          Input_Botton.LatinBotton('#input_verb'); 
        }

    </script>
  <footer class="">
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>