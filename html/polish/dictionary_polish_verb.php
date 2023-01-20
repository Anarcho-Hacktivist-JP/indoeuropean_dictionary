<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_adjective_class.php");
include(dirname(__FILE__) . "/../language_class/IndoEuropean_noun_class.php");
include(dirname(__FILE__) . "/../language_class/IndoEuropean_verb_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Polish_Common.php");

// 活用表を取得する。
function get_verb_conjugation_chart($word){
  // 配列を宣言
	$conjugations = array();
	// 動詞の情報を取得
	$polish_verbs = Polish_Common::get_verb_by_japanese($word);
  // 動詞の情報が取得できない場合は
  if(!$polish_verbs){
    // 空を返す。
    return array();  
  }

	// 新しい配列に詰め替え
	foreach ($polish_verbs as $polish_verb) {
    $conjugations = array_merge(Polish_Common::get_verb_conjugation($polish_verb), $conjugations);
	}

  // 結果を返す。
	return $conjugations;
}

// 活用表を取得する。
function get_verb_conjugation_chart_by_english($word){
  // 配列を宣言
	$conjugations = array();
	// 英語で動詞の情報を取得
	$polish_verbs = Polish_Common::get_verb_by_english($word);
  // 動詞の情報が取得できない場合は
  if(!$polish_verbs){
	  // 動詞が取得できない場合
    // 動詞を生成
	  $verb_polish = new Polish_Verb($word."ować");
	  // 活用表生成、配列に格納
	  $conjugations[$verb_polish->get_infinitive()] = $verb_polish->get_chart();
  } else {
    // 新しい配列に詰め替え
	  foreach ($polish_verbs as $polish_verb) {
      $conjugations = array_merge(Polish_Common::get_verb_conjugation($polish_verb), $conjugations);
	  }
  }
  // 結果を返す。
	return $conjugations;
}

// 活用表を取得する。
function get_verb_conjugation_chart_by_polish($word){
  // 配列を宣言
	$conjugations = array();
	// ポーランド語で動詞の情報を取得
	$polish_verb = Polish_Common::get_verb_from_DB($word);
  // 動詞が取得できたか確認する。
  if($polish_verb){
    // 動詞が取得できた場合
    $conjugations = array_merge(Polish_Common::get_verb_conjugation($polish_verb), $conjugations);
  } else {
	  // 動詞が取得できない場合
    // 動詞を生成
	  $verb_polish = new Polish_Verb($word);
	  // 活用表生成、配列に格納
	  $conjugations[$verb_polish->get_infinitive()] = $verb_polish->get_chart();
  }
  // 結果を返す。
	return $conjugations;
}

// 名詞から活用表を取得する。
function get_conjugation_by_noun($word){
	// 名詞の語幹を取得
	$polish_verbs = Polish_Common::get_polish_denomitive_verb($word, Polish_Common::DB_NOUN);
  // 名詞の情報が取得できない場合は
  if(!$polish_verbs){
    // 空を返す。
    return array();
  } 
  // 配列を宣言
  $conjugations = array();   
	// 新しい配列に詰め替え
	foreach ($polish_verbs as $polish_verb) {
	  // 読み込み
	  $verb_data = new Polish_Verb($polish_verb);
	  // 活用表生成、配列に格納
	  $conjugations[$verb_data->get_infinitive()] = $verb_data->get_chart();
	}
  // 結果を返す。
	return $conjugations;
}

// 形容詞から活用表を取得する。
function get_conjugation_by_adjective($word){
	// 形容詞の語幹を取得
	$polish_verbs = Polish_Common::get_polish_denomitive_verb($word, Polish_Common::DB_ADJECTIVE);
  // 形容詞の情報が取得できない場合は
  if(!$polish_verbs){
    // 空を返す。
    return array();
  } 
  // 状態動詞を結合する。
  $polish_verbs = array_merge(Polish_Common::get_polish_stative_verb($word), $polish_verbs);
  // 配列を宣言
  $conjugations = array();   
	// 新しい配列に詰め替え
	foreach ($polish_verbs as $polish_verb) {         
	  // 読み込み
	  $verb_data = new Polish_Verb($polish_verb);
	  // 活用表生成、配列に格納
	  $conjugations[$verb_data->get_infinitive()] = $verb_data->get_chart();
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

// 条件分岐
if($input_verb != "" && $janome_result[0][1] == "名詞" && count($janome_result) == 1 && !Polish_Common::is_alphabet_or_not($input_verb) && !strpos($input_verb, Commons::$LIKE_MARK)){
  // 名詞の場合は名詞で動詞を取得
	$conjugations = get_conjugation_by_noun($input_verb);
} else if($input_verb != "" && $janome_result[0][1] == "形容詞" && count($janome_result) == 1 && !Polish_Common::is_alphabet_or_not($input_verb) && !strpos($input_verb, Commons::$LIKE_MARK) ){
  // 形容詞の場合は形容詞で動詞を取得
	$conjugations = get_conjugation_by_adjective($input_verb);
} else if($input_verb != "" && $search_lang == "polish" && Polish_Common::is_alphabet_or_not($input_verb)){
  // 処理を実行
  $conjugations = get_verb_conjugation_chart_by_polish($input_verb);
} else if($input_verb != "" && $search_lang == "english" && Polish_Common::is_alphabet_or_not($input_verb)){
  // 処理を実行
  $conjugations = get_verb_conjugation_chart_by_english($input_verb);
} else if($input_verb != "" && $search_lang == "japanese" && !Polish_Common::is_alphabet_or_not($input_verb)){
  // 処理を実行
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
    <title>印欧語活用辞典：ポーランド語辞書</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/> 
    <link href="/../css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
  </head>
    <?php require_once("polish_header.php"); ?>
  <body>
    <div class="container item table-striped">
      <h1>ポーランド語辞書（動詞）</h1>
      <p>あいまい検索は+</p>
      <form action="" method="post" class="mt-4 mb-4" id="form-category">
        <input type="text" name="input_verb" class="form-control" id="input_verb" placeholder="検索語句(日本語・英語・ポーランド語)、名詞や形容詞も可">
        <?php echo Polish_Common::language_select_box(); ?>  
        <input type="submit" class="btn-check" id="btn-generate">
        <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-generate">検索</label>
        <select class="form-select" id="verb-selection" aria-label="Default select example">
          <option selected>単語を選んでください</option>
          <?php echo Commons::select_option($conjugations); ?>
        </select>
      </form>
      <?php echo Polish_Common::input_special_button(); ?>
      <?php echo Commons::noun_archaic_button(); ?>
      <details>
        <summary>動詞の活用 ※(薄文字の部分は現在は使わない)</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="conjugation-table" style="overflow: auto;">
        <thead>
          <tr>
            <th class="text-center" scope="row" style="width:10%">態</th>
            <th class="text-center" scope="col" style="width:45%">能動</th>
            <th class="text-center" scope="col" style="width:45%">中動</th>               
          </tr>
        </thead>
        <tbody>
          <tr><th class="text-center" scope="row" colspan="3">現在時制</th></tr>
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row" colspan="3">過去形</th></tr>
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td></tr>
          <tr><th class="text-center table-archaic" scope="row" colspan="3">過去完了</th></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>          
          <tr><th class="text-center" scope="row" colspan="3">未来時制</th></tr>
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td></tr>       
          <tr><th class="text-center" scope="row" colspan="3">未来完了形</th></tr>
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row" colspan="3">仮定法</th></tr>
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td></tr> 
          <tr><th class="text-center table-archaic" scope="row" colspan="3">仮定法過去</th></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>  
          <tr><th class="text-center" scope="row" colspan="3">命令法</th></tr>
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td></tr>
          <tr><th class="text-center table-archaic" scope="row" colspan="3">未完了過去</th></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>  
          <tr><th class="text-center table-archaic" scope="row" colspan="3">単純過去</th></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称双数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">1人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">2人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          <tr><th class="text-center table-archaic" scope="row">3人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td></tr>         
        </tbody>
        </table>
      </details><br>
      <details>
        <summary>現在分詞 ※(薄文字の部分は現在は使わない)</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="active-participle-table">
            <?php echo Polish_Common::make_adjective_column_chart("現在分詞"); ?>
          <tbody>
            <?php echo Polish_Common::make_adjective_chart(); ?>
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>受動分詞 ※(薄文字の部分は現在は使わない)</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="passive-participle-table">
          <?php echo Polish_Common::make_adjective_column_chart("完了分詞"); ?>
          <tbody>
            <?php echo Polish_Common::make_adjective_chart(); ?>
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>動名詞 ※(薄文字の部分は現在は使わない)</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="verbal-noun-table">
          <thead>
            <tr><th scope="row" style="width:10%">格</th>
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
      </details><br>  
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        var verb_table_data = '<?php echo json_encode($conjugations, JSON_UNESCAPED_UNICODE); ?>';
    </script>
	  <script type="text/javascript" src="/../js/input_button.js"></script>
	  <script type="text/javascript" src="/../js/background_attack.js"></script>
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
          var active = json_verb["active"];            //能動態現在
          var middle = json_verb["mediopassive"];     //受動態現在

          // 格納データを作成
          var verb_table = [
            ["", "", ""],
            [active["present"]["1sg"]["masc"], middle["present"]["1sg"]["masc"]],
            [active["present"]["2sg"]["masc"], middle["present"]["2sg"]["masc"]],
            [active["present"]["3sg"]["masc"], middle["present"]["3sg"]["masc"]],
            ["*" + active["present"]["1du"]["masc"], "*" + middle["present"]["1du"]["masc"]],
            ["*" + active["present"]["2du"]["masc"], "*" + middle["present"]["2du"]["masc"]],
            ["*" + active["present"]["3du"]["masc"], "*" + middle["present"]["3du"]["masc"]],            
            [active["present"]["1pl"]["masc"], middle["present"]["1pl"]["masc"]],
            [active["present"]["2pl"]["masc"], middle["present"]["2pl"]["masc"]],
            [active["present"]["3pl"]["masc"], middle["present"]["3pl"]["masc"]],
            ["", "", ""],
            [active["perfect"]["1sg"]["masc"] + "\n" + active["perfect"]["1sg"]["fem"], middle["perfect"]["1sg"]["masc"] + "\n" + middle["perfect"]["1sg"]["fem"] + "\n"],
            [active["perfect"]["2sg"]["masc"] + "\n" + active["perfect"]["2sg"]["fem"], middle["perfect"]["2sg"]["masc"] + "\n" + middle["perfect"]["2sg"]["fem"] + "\n"],
            [active["perfect"]["3sg"]["masc"] + "\n" + active["perfect"]["3sg"]["fem"] + "\n" + active["perfect"]["3sg"]["neu"], middle["perfect"]["3sg"]["masc"] + "\n" + middle["perfect"]["3sg"]["fem"] + "\n" + middle["perfect"]["3sg"]["neu"]],
            ["*" + active["perfect"]["1du"]["masc"] + "\n" + "*" + active["perfect"]["1du"]["fem"], "*" + middle["perfect"]["1du"]["masc"] + "\n" + "*" + middle["perfect"]["1du"]["fem"] + "\n"],
            ["*" + active["perfect"]["2du"]["masc"] + "\n" + "*" + active["perfect"]["2du"]["fem"], "*" + middle["perfect"]["2du"]["masc"] + "\n" + "*" + middle["perfect"]["2du"]["fem"] + "\n"],
            ["*" + active["perfect"]["3du"]["masc"] + "\n" + "*" + active["perfect"]["3du"]["fem"] + "\n" + "*" + active["perfect"]["3du"]["neu"], "*" + middle["perfect"]["3du"]["masc"] + "\n" +"*" +  middle["perfect"]["3du"]["fem"] + "\n" + "*" + middle["perfect"]["3du"]["neu"]],            
            [active["perfect"]["1pl"]["masc"] + "\n" + active["perfect"]["1pl"]["fem"], middle["perfect"]["1pl"]["masc"] + "\n" + middle["perfect"]["1pl"]["fem"] + "\n"],
            [active["perfect"]["2pl"]["masc"] + "\n" + active["perfect"]["2pl"]["fem"], middle["perfect"]["2pl"]["masc"] + "\n" + middle["perfect"]["2pl"]["fem"] + "\n"],
            [active["perfect"]["3pl"]["masc"] + "\n" + active["perfect"]["3pl"]["fem"] + "\n" + active["perfect"]["3pl"]["neu"], middle["perfect"]["3pl"]["masc"] + "\n" + middle["perfect"]["3pl"]["fem"] + "\n" + middle["perfect"]["3pl"]["neu"]],
            ["", "", ""],
            [active["past_perfect"]["1sg"]["masc"] + "\n" + active["past_perfect"]["1sg"]["fem"], middle["past_perfect"]["1sg"]["masc"] + "\n" + middle["past_perfect"]["1sg"]["fem"]],
            [active["past_perfect"]["2sg"]["masc"] + "\n" + active["past_perfect"]["2sg"]["fem"], middle["past_perfect"]["2sg"]["masc"] + "\n" + middle["past_perfect"]["2sg"]["fem"]],
            [active["past_perfect"]["3sg"]["masc"] + "\n" + active["past_perfect"]["3sg"]["fem"] + "\n" + active["past_perfect"]["3sg"]["neu"], middle["past_perfect"]["3sg"]["masc"] + "\n" + middle["past_perfect"]["3sg"]["fem"] + "\n" + middle["past_perfect"]["3sg"]["neu"]],
            ["*" + active["past_perfect"]["1du"]["masc"] + "\n" + "*" + active["past_perfect"]["1du"]["fem"], "*" + middle["past_perfect"]["1du"]["masc"] + "\n" + "*" + middle["past_perfect"]["1du"]["fem"]],
            ["*" + active["past_perfect"]["2du"]["masc"] + "\n" + "*" + active["past_perfect"]["2du"]["fem"], "*" + middle["past_perfect"]["2du"]["masc"] + "\n" + "*" + middle["past_perfect"]["2du"]["fem"]],
            ["*" + active["past_perfect"]["3du"]["masc"] + "\n" + "*" + active["past_perfect"]["3du"]["fem"] + "\n" + "*" + active["past_perfect"]["3du"]["neu"], "*" + middle["past_perfect"]["3du"]["masc"] + "\n" + "*" + middle["past_perfect"]["3du"]["fem"] + "\n" + "*" + middle["past_perfect"]["3du"]["neu"]],
            [active["past_perfect"]["1pl"]["masc"] + "\n" + active["past_perfect"]["1pl"]["fem"], middle["past_perfect"]["1pl"]["masc"] + "\n" + middle["past_perfect"]["1pl"]["fem"]],
            [active["past_perfect"]["2pl"]["masc"] + "\n" + active["past_perfect"]["2pl"]["fem"], middle["past_perfect"]["2pl"]["masc"] + "\n" + middle["past_perfect"]["2pl"]["fem"]],
            [active["past_perfect"]["3pl"]["masc"] + "\n" + active["past_perfect"]["3pl"]["fem"] + "\n" + active["past_perfect"]["3pl"]["neu"], middle["past_perfect"]["3pl"]["masc"] + "\n" + middle["past_perfect"]["3pl"]["fem"] + "\n" + middle["past_perfect"]["3pl"]["neu"]], 
            ["", "", ""],
            [active["future"]["1sg"]["masc"], middle["future"]["1sg"]["masc"]],
            [active["future"]["2sg"]["masc"], middle["future"]["2sg"]["masc"]],
            [active["future"]["3sg"]["masc"], middle["future"]["3sg"]["masc"]],
            ["*" + active["future"]["1du"]["masc"], "*" + middle["future"]["1du"]["masc"]],
            ["*" + active["future"]["2du"]["masc"], "*" + middle["future"]["2du"]["masc"]],
            ["*" + active["future"]["3du"]["masc"], "*" + middle["future"]["3du"]["masc"]],            
            [active["future"]["1pl"]["masc"], middle["future"]["1pl"]["masc"]],
            [active["future"]["2pl"]["masc"], middle["future"]["2pl"]["masc"]],
            [active["future"]["3pl"]["masc"], middle["future"]["3pl"]["masc"]],          
            ["", "", ""],
            [active["future_perfect"]["1sg"]["masc"] + "\n" + active["future_perfect"]["1sg"]["fem"], middle["future_perfect"]["1sg"]["masc"] + "\n" + middle["future_perfect"]["1sg"]["fem"]],
            [active["future_perfect"]["2sg"]["masc"] + "\n" + active["future_perfect"]["2sg"]["fem"], middle["future_perfect"]["2sg"]["masc"] + "\n" + middle["future_perfect"]["2sg"]["fem"]],
            [active["future_perfect"]["3sg"]["masc"] + "\n" + active["future_perfect"]["3sg"]["fem"] + "\n" + active["future_perfect"]["3sg"]["neu"], middle["future_perfect"]["3sg"]["masc"] + "\n" + middle["future_perfect"]["3sg"]["fem"] + "\n" + middle["future_perfect"]["3sg"]["neu"]],
            ["*" + active["future_perfect"]["1du"]["masc"] + "\n" + "*" + active["future_perfect"]["1du"]["fem"], "*" + middle["future_perfect"]["1du"]["masc"] + "\n" + "*" + middle["future_perfect"]["1du"]["fem"]],
            ["*" + active["future_perfect"]["2du"]["masc"] + "\n" + "*" + active["future_perfect"]["2du"]["fem"], "*" + middle["future_perfect"]["2du"]["masc"] + "\n" + "*" + middle["future_perfect"]["2du"]["fem"]],
            ["*" + active["future_perfect"]["3du"]["masc"] + "\n" + "*" + active["future_perfect"]["3du"]["fem"] + "\n" + "*" + active["future_perfect"]["3du"]["neu"], "*" + middle["future_perfect"]["3du"]["masc"] + "\n" + "*" + middle["future_perfect"]["3du"]["fem"] + "\n" + "*" + middle["future_perfect"]["3du"]["neu"]],
            [active["future_perfect"]["1pl"]["masc"] + "\n" + active["future_perfect"]["1pl"]["fem"], middle["future_perfect"]["1pl"]["masc"] + "\n" + middle["future_perfect"]["1pl"]["fem"]],
            [active["future_perfect"]["2pl"]["masc"] + "\n" + active["future_perfect"]["2pl"]["fem"], middle["future_perfect"]["2pl"]["masc"] + "\n" + middle["future_perfect"]["2pl"]["fem"]],
            [active["future_perfect"]["3pl"]["masc"] + "\n" + active["future_perfect"]["3pl"]["fem"] + "\n" + active["future_perfect"]["3pl"]["neu"], middle["future_perfect"]["3pl"]["masc"] + "\n" + middle["future_perfect"]["3pl"]["fem"] + "\n" + middle["future_perfect"]["3pl"]["neu"]],            
            ["", "", ""],
            [active["subj"]["1sg"]["masc"] + "\n" + active["subj"]["1sg"]["fem"], middle["subj"]["1sg"]["masc"] + "\n" + middle["subj"]["1sg"]["fem"]],
            [active["subj"]["2sg"]["masc"] + "\n" + active["subj"]["2sg"]["fem"], middle["subj"]["2sg"]["masc"] + "\n" + middle["subj"]["2sg"]["fem"]],
            [active["subj"]["3sg"]["masc"] + "\n" + active["subj"]["3sg"]["fem"] + "\n" + active["subj"]["3sg"]["neu"], middle["subj"]["3sg"]["masc"] + "\n" + middle["subj"]["3sg"]["fem"] + "\n" + middle["subj"]["3sg"]["neu"]],
            ["*" + active["subj"]["1du"]["masc"] + "\n" + "*" + active["subj"]["1du"]["fem"], "*" + middle["subj"]["1du"]["masc"] + "\n" + "*" + middle["subj"]["1du"]["fem"]],
            ["*" + active["subj"]["2du"]["masc"] + "\n" + "*" + active["subj"]["2du"]["fem"], "*" + middle["subj"]["2du"]["masc"] + "\n" + "*" + middle["subj"]["2du"]["fem"]],
            ["*" + active["subj"]["3du"]["masc"] + "\n" + "*" + active["subj"]["3du"]["fem"] + "\n" + active["subj"]["3du"]["neu"], "*" + middle["subj"]["3du"]["masc"] + "\n" + "*" + middle["subj"]["3du"]["fem"] + "\n" + "*" + middle["subj"]["3du"]["neu"]],            
            [active["subj"]["1pl"]["masc"] + "\n" + active["subj"]["1pl"]["fem"], middle["subj"]["1pl"]["masc"] + "\n" + middle["subj"]["1pl"]["fem"]],
            [active["subj"]["2pl"]["masc"] + "\n" + active["subj"]["2pl"]["fem"], middle["subj"]["2pl"]["masc"] + "\n" + middle["subj"]["2pl"]["fem"]],
            [active["subj"]["3pl"]["masc"] + "\n" + active["subj"]["3pl"]["fem"] + "\n" + active["subj"]["3pl"]["neu"], middle["subj"]["3pl"]["masc"] + "\n" + middle["subj"]["3pl"]["fem"] + "\n" + middle["subj"]["3pl"]["neu"]],  
            ["", "", ""],
            [active["subj_perfect"]["1sg"]["masc"] + "\n" + active["subj_perfect"]["1sg"]["fem"], middle["subj_perfect"]["1sg"]["masc"] + "\n" + middle["subj_perfect"]["1sg"]["fem"]],
            [active["subj_perfect"]["2sg"]["masc"] + "\n" + active["subj_perfect"]["2sg"]["fem"], middle["subj_perfect"]["2sg"]["masc"] + "\n" + middle["subj_perfect"]["2sg"]["fem"]],
            [active["subj_perfect"]["3sg"]["masc"] + "\n" + active["subj_perfect"]["3sg"]["fem"] + "\n" + active["subj_perfect"]["3sg"]["neu"], middle["subj_perfect"]["3sg"]["masc"] + "\n" + middle["subj_perfect"]["3sg"]["fem"] + "\n" + middle["subj_perfect"]["3sg"]["neu"]],
            ["*" + active["subj_perfect"]["1du"]["masc"] + "\n" + "*" + active["subj_perfect"]["1du"]["fem"], "*" + middle["subj_perfect"]["1du"]["masc"] + "\n" + "*" + middle["subj_perfect"]["1du"]["fem"]],
            ["*" + active["subj_perfect"]["2du"]["masc"] + "\n" + "*" + active["subj_perfect"]["2du"]["fem"], "*" + middle["subj_perfect"]["2du"]["masc"] + "\n" + "*" + middle["subj_perfect"]["2du"]["fem"]],
            ["*" + active["subj_perfect"]["3du"]["masc"] + "\n" + "*" + active["subj_perfect"]["3du"]["fem"] + "\n" + active["subj_perfect"]["3du"]["neu"], "*" + middle["subj_perfect"]["3du"]["masc"] + "\n" + "*" + middle["subj_perfect"]["3du"]["fem"] + "\n" + "*" + middle["subj_perfect"]["3du"]["neu"]],            
            [active["subj_perfect"]["1pl"]["masc"] + "\n" + active["subj_perfect"]["1pl"]["fem"], middle["subj_perfect"]["1pl"]["masc"] + "\n" + middle["subj_perfect"]["1pl"]["fem"]],
            [active["subj_perfect"]["2pl"]["masc"] + "\n" + active["subj_perfect"]["2pl"]["fem"], middle["subj_perfect"]["2pl"]["masc"] + "\n" + middle["subj_perfect"]["2pl"]["fem"]],
            [active["subj_perfect"]["3pl"]["masc"] + "\n" + active["subj_perfect"]["3pl"]["fem"] + "\n" + active["subj_perfect"]["3pl"]["neu"], middle["subj_perfect"]["3pl"]["masc"] + "\n" + middle["subj_perfect"]["3pl"]["fem"] + "\n" + middle["subj_perfect"]["3pl"]["neu"]],  
            ["", "", ""],
            ["", "", ""],
            [active["imper"]["2sg"]["masc"], middle["imper"]["2sg"]["masc"]],
            ["", "", ""],
            ["*" + active["imper"]["1du"]["masc"], "*" + middle["imper"]["1du"]["masc"]],
            ["*" + active["imper"]["2du"]["masc"], "*" + middle["imper"]["2du"]["masc"]],
            ["", "", ""],         
            [active["imper"]["1pl"]["masc"], middle["imper"]["1pl"]["masc"]],
            [active["imper"]["2pl"]["masc"], middle["imper"]["2pl"]["masc"]],
            ["", "", ""],
            ["", "", ""],
            ["*" + active["past"]["1sg"]["masc"], "*" + middle["past"]["1sg"]["masc"]],
            ["*" + active["past"]["2sg"]["masc"], "*" + middle["past"]["2sg"]["masc"]],
            ["*" + active["past"]["3sg"]["masc"], "*" + middle["past"]["3sg"]["masc"]],
            ["*" + active["past"]["1du"]["masc"], "*" + middle["past"]["1du"]["masc"]],
            ["*" + active["past"]["2du"]["masc"], "*" + middle["past"]["2du"]["masc"]],
            ["*" + active["past"]["3du"]["masc"], "*" + middle["past"]["3du"]["masc"]],            
            ["*" + active["past"]["1pl"]["masc"], "*" + middle["past"]["1pl"]["masc"]],
            ["*" + active["past"]["2pl"]["masc"], "*" + middle["past"]["2pl"]["masc"]],
            ["*" + active["past"]["3pl"]["masc"], "*" + middle["past"]["3pl"]["masc"]],
            ["", "", ""],
            ["*" + active["aorist"]["1sg"]["masc"], "*" + middle["aorist"]["1sg"]["masc"]],
            ["*" + active["aorist"]["2sg"]["masc"], "*" + middle["aorist"]["2sg"]["masc"]],
            ["*" + active["aorist"]["3sg"]["masc"], "*" + middle["aorist"]["3sg"]["masc"]],
            ["*" + active["aorist"]["1du"]["masc"], "*" + middle["aorist"]["1du"]["masc"]],
            ["*" + active["aorist"]["2du"]["masc"], "*" + middle["aorist"]["2du"]["masc"]],
            ["*" + active["aorist"]["3du"]["masc"], "*" + middle["aorist"]["3du"]["masc"]],            
            ["*" + active["aorist"]["1pl"]["masc"], "*" + middle["aorist"]["1pl"]["masc"]],
            ["*" + active["aorist"]["2pl"]["masc"], "*" + middle["aorist"]["2pl"]["masc"]],
            ["*" + active["aorist"]["3pl"]["masc"], "*" + middle["aorist"]["3pl"]["masc"]],                
          ];
          
          // 結果を返す。
          return verb_table;
        }

        // 配列をテーブル用に変換にする。
        function get_participle(table_data, word, participle_name){

          // JSONに書き換え
          var json_participle = JSON.parse(table_data)[word][participle_name];

          // 原級形容詞の格変化情報を取得
          var positive_masc_sg = json_participle["positive"]["masc"]["sg"];   //単数男性
          var positive_fem_sg = json_participle["positive"]["fem"]["sg"];     //単数女性
          var positive_neu_sg = json_participle["positive"]["neu"]["sg"];   	//単数中性
          var positive_masc_du = json_participle["positive"]["masc"]["du"];   //双数男性
          var positive_fem_du = json_participle["positive"]["fem"]["du"];     //双数女性
          var positive_neu_du = json_participle["positive"]["neu"]["du"];   	//双数中性          
          var positive_masc_pl = json_participle["positive"]["masc"]["pl"]; 	//複数男性
          var positive_fem_pl = json_participle["positive"]["fem"]["pl"];   	//複数女性
          var positive_neu_pl = json_participle["positive"]["neu"]["pl"];   	//複数中性
          
          // 比較級形容詞の格変化情報を取得
          var comp_masc_sg = json_participle["comp"]["masc"]["sg"]; 	        //単数男性
          var comp_fem_sg = json_participle["comp"]["fem"]["sg"];   	        //単数女性
          var comp_neu_sg = json_participle["comp"]["neu"]["sg"];   	        //単数中性
          var comp_masc_du = json_participle["comp"]["masc"]["du"];           //双数男性
          var comp_fem_du = json_participle["comp"]["fem"]["du"];             //双数女性
          var comp_neu_du = json_participle["comp"]["neu"]["du"];   	        //双数中性           
          var comp_masc_pl = json_participle["comp"]["masc"]["pl"]; 		      //複数男性
          var comp_fem_pl = json_participle["comp"]["fem"]["pl"];   		      //複数女性
          var comp_neu_pl = json_participle["comp"]["neu"]["pl"];   		      //複数中性
          
          // 最上級形容詞の格変化情報を取得
          var super_masc_sg = json_participle["super"]["masc"]["sg"]; 	      //単数男性
          var super_fem_sg = json_participle["super"]["fem"]["sg"];   	      //単数女性
          var super_neu_sg = json_participle["super"]["neu"]["sg"];   	      //単数中性
          var super_masc_du = json_participle["super"]["masc"]["du"];         //双数男性
          var super_fem_du = json_participle["super"]["fem"]["du"];           //双数女性
          var super_neu_du = json_participle["super"]["neu"]["du"];   	      //双数中性            
          var super_masc_pl = json_participle["super"]["masc"]["pl"]; 		    //複数男性
          var super_fem_pl = json_participle["super"]["fem"]["pl"];   		    //複数女性
          var super_neu_pl = json_participle["super"]["neu"]["pl"];   		    //複数中性
          
          // 格納データを作成
          var adj_table = [
            ["", "", "", "", "", "", ""],
            [positive_masc_sg["nom"], positive_fem_sg["nom"], positive_neu_sg["nom"], "*" + positive_masc_du["nom"], "*" + positive_fem_du["nom"], "*" + positive_neu_du["nom"], positive_masc_pl["nom"], positive_fem_pl["nom"], positive_neu_pl["nom"]],
            [positive_masc_sg["gen"], positive_fem_sg["gen"], positive_neu_sg["gen"], "*" + positive_masc_du["gen"], "*" + positive_fem_du["gen"], "*" + positive_neu_du["gen"], positive_masc_pl["gen"], positive_fem_pl["gen"], positive_neu_pl["gen"]],
            [positive_masc_sg["dat"], positive_fem_sg["dat"], positive_neu_sg["dat"], "*" + positive_masc_du["dat"], "*" + positive_fem_du["dat"], "*" + positive_neu_du["dat"], positive_masc_pl["dat"], positive_fem_pl["dat"], positive_neu_pl["dat"]],
            [positive_masc_sg["acc"], positive_fem_sg["acc"], positive_neu_sg["acc"], "*" + positive_masc_du["acc"], "*" + positive_fem_du["acc"], "*" + positive_neu_du["acc"], positive_masc_pl["acc"], positive_fem_pl["acc"], positive_neu_pl["acc"]],
            [positive_masc_sg["ins"], positive_fem_sg["ins"], positive_neu_sg["ins"], "*" + positive_masc_du["ins"], "*" + positive_fem_du["ins"], "*" + positive_neu_du["ins"], positive_masc_pl["ins"], positive_fem_pl["ins"], positive_neu_pl["ins"]],            
            [positive_masc_sg["loc"], positive_fem_sg["loc"], positive_neu_sg["loc"], "*" + positive_masc_du["loc"], "*" + positive_fem_du["loc"], "*" + positive_neu_du["loc"], positive_masc_pl["loc"], positive_fem_pl["loc"], positive_neu_pl["loc"]],
            [positive_masc_sg["voc"], positive_fem_sg["voc"], positive_neu_sg["voc"], "*" + positive_masc_du["voc"], "*" + positive_fem_du["voc"], "*" + positive_neu_du["voc"], positive_masc_pl["voc"], positive_fem_pl["voc"], positive_neu_pl["voc"]],
            ["", "", "", "", "", "", ""],
            [comp_masc_sg["nom"], comp_fem_sg["nom"], comp_neu_sg["nom"], "*" + comp_masc_du["nom"], "*" + comp_fem_du["nom"], "*" + comp_neu_du["nom"], comp_masc_pl["nom"], comp_fem_pl["nom"], comp_neu_pl["nom"]],
            [comp_masc_sg["gen"], comp_fem_sg["gen"], comp_neu_sg["gen"], "*" + comp_masc_du["gen"], "*" + comp_fem_du["gen"], "*" + comp_neu_du["gen"], comp_masc_pl["gen"], comp_fem_pl["gen"], comp_neu_pl["gen"]],
            [comp_masc_sg["dat"], comp_fem_sg["dat"], comp_neu_sg["dat"], "*" + comp_masc_du["dat"], "*" + comp_fem_du["dat"], "*" + comp_neu_du["dat"], comp_masc_pl["dat"], comp_fem_pl["dat"], comp_neu_pl["dat"]],
            [comp_masc_sg["acc"], comp_fem_sg["acc"], comp_neu_sg["acc"], "*" + comp_masc_du["acc"], "*" + comp_fem_du["acc"], "*" + comp_neu_du["acc"], comp_masc_pl["acc"], comp_fem_pl["acc"], comp_neu_pl["acc"]],
            [comp_masc_sg["ins"], comp_fem_sg["ins"], comp_neu_sg["ins"], "*" + comp_masc_du["ins"], "*" + comp_fem_du["ins"], "*" + comp_neu_du["ins"], comp_masc_pl["ins"], comp_fem_pl["ins"], comp_neu_pl["ins"]],
            [comp_masc_sg["loc"], comp_fem_sg["loc"], comp_neu_sg["loc"], "*" + comp_masc_du["loc"], "*" + comp_fem_du["loc"], "*" + comp_neu_du["loc"], comp_masc_pl["loc"], comp_fem_pl["loc"], comp_neu_pl["loc"]],
            [comp_masc_sg["voc"], comp_fem_sg["voc"], comp_neu_sg["voc"], "*" + comp_masc_du["voc"], "*" + comp_fem_du["voc"], "*" + comp_neu_du["voc"], comp_masc_pl["voc"], comp_fem_pl["voc"], comp_neu_pl["voc"]],  
            ["", "", "", "", "", "", ""],
            [super_masc_sg["nom"], super_fem_sg["nom"], super_neu_sg["nom"], "*" + super_masc_du["nom"], "*" + super_fem_du["nom"], "*" + super_neu_du["nom"], super_masc_pl["nom"], super_fem_pl["nom"], super_neu_pl["nom"]],
            [super_masc_sg["gen"], super_fem_sg["gen"], super_neu_sg["gen"], "*" + super_masc_du["gen"], "*" + super_fem_du["gen"], "*" + super_neu_du["gen"], super_masc_pl["gen"], super_fem_pl["gen"], super_neu_pl["gen"]],
            [super_masc_sg["dat"], super_fem_sg["dat"], super_neu_sg["dat"], "*" + super_masc_du["dat"], "*" + super_fem_du["dat"], "*" + super_neu_du["dat"], super_masc_pl["dat"], super_fem_pl["dat"], super_neu_pl["dat"]],
            [super_masc_sg["acc"], super_fem_sg["acc"], super_neu_sg["acc"], "*" + super_masc_du["acc"], "*" + super_fem_du["acc"], "*" + super_neu_du["acc"], super_masc_pl["acc"], super_fem_pl["acc"], super_neu_pl["acc"]],
            [super_masc_sg["ins"], super_fem_sg["ins"], super_neu_sg["ins"], "*" + super_masc_du["ins"], "*" + super_fem_du["ins"], "*" + super_neu_du["ins"], super_masc_pl["ins"], super_fem_pl["ins"], super_neu_pl["ins"]],            
            [super_masc_sg["loc"], super_fem_sg["loc"], super_neu_sg["loc"], "*" + super_masc_du["loc"], "*" + super_fem_du["loc"], "*" + super_neu_du["loc"], super_masc_pl["loc"], super_fem_pl["loc"], super_neu_pl["loc"]],
            [super_masc_sg["voc"], super_fem_sg["voc"], super_neu_sg["voc"], "*" + super_masc_du["voc"], "*" + super_fem_du["voc"], "*" + super_neu_du["voc"], super_masc_pl["voc"], super_fem_pl["voc"], super_neu_pl["voc"]],             
          ];
          
          // 結果を返す。
          return adj_table;
        }

        // 配列をテーブル用に変換にする。
        function get_verbal_noun(table_data, word, participle_name){
          // JSONに書き換え
          var json_verbal_noun = JSON.parse(table_data)[word][participle_name];
          // 格変化情報を取得
          var declension_sg = json_verbal_noun["sg"];  //単数
          var declension_du = json_verbal_noun["du"];  //双数
          var declension_pl = json_verbal_noun["pl"];  //複数
          // 格納データを作成
          var verbal_noun = [
            [declension_sg["nom"], "*" + declension_du["nom"], declension_pl["nom"]],
            [declension_sg["gen"], "*" + declension_du["gen"], declension_pl["gen"]],
            [declension_sg["dat"], "*" + declension_du["dat"], declension_pl["dat"]],
            [declension_sg["acc"], "*" + declension_du["acc"], declension_pl["acc"]],
            [declension_sg["ins"], "*" + declension_du["ins"], declension_pl["ins"]],            
            [declension_sg["loc"], "*" + declension_du["loc"], declension_pl["loc"]],
            [declension_sg["voc"], "*" + declension_du["voc"], declension_pl["voc"]],            
          ];
          
          // 結果を返す。
          return verbal_noun;
        }

        // 分詞をテーブルにセットする。
        function set_particple_to_table(particple_data, table_id){
          // 行オブジェクトの取得
          var rows = $(table_id)[0].rows;
          // 各行をループ処理
          $.each(rows, function(i){
            // タイトル行は除外する。
            if(i == 0 || i == 1){
              return true;
            } else if(particple_data[i - 2][0] == ""){
              if(i == 2){
                rows[i].cells[0].innerText = "原級";
              } else if(i == 20){
                rows[i].cells[0].innerText = "比較級";
              } else if(i == 38){
                rows[i].cells[0].innerText = "最上級";
              }
              // 説明行も除外
              return true;
            } else {
              // 格変化を挿入
              rows[i].cells[1].innerText = particple_data[i - 2][0]; // 単数男性(1行目)
              rows[i].cells[2].innerText = particple_data[i - 2][1]; // 単数女性(2行目)
              rows[i].cells[3].innerText = particple_data[i - 2][2]; // 単数中性(3行目)
              rows[i].cells[4].innerText = particple_data[i - 2][3]; // 双数男性(4行目)
              rows[i].cells[5].innerText = particple_data[i - 2][4]; // 双数女性(5行目)
              rows[i].cells[6].innerText = particple_data[i - 2][5]; // 双数中性(6行目)  
              rows[i].cells[7].innerText = particple_data[i - 2][6]; // 複数男性(4行目)
              rows[i].cells[8].innerText = particple_data[i - 2][7]; // 複数女性(5行目)
              rows[i].cells[9].innerText = particple_data[i - 2][8]; // 複数中性(6行目)       
            }
          });
        }

        // 単語選択後の処理
        function set_verbal_noun_to_table(particple_data, table_id){
          // 行オブジェクトの取得
          var rows = $(table_id)[0].rows;
          // 各行をループ処理
          $.each(rows, function(i){
            // タイトル行は除外する。
            if(i == 0){
              return true;
            } else if(i < 9){
              // 格変化を挿入
              rows[i].cells[1].innerText = particple_data[i - 1][0]; // 単数(1行目)
              rows[i].cells[2].innerText = particple_data[i - 1][1]; // 双数(2行目)
              rows[i].cells[3].innerText = particple_data[i - 1][2]; // 複数(3行目)
            }
          });
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
            if(i <= 1){
              return true;
            } else if(i % 10 == 1){
              // 説明行も除外
              return true;
            }
            // 活用を挿入
            rows[i].cells[1].innerText = conjugation_table[i - 1][0]; // 能動
            rows[i].cells[2].innerText = conjugation_table[i - 1][1]; // 中動
          });

          // 分詞のデータを取得
          const present_active = get_participle(verb_table_data, $('#verb-selection').val(), "present_active");       // 現在能動分詞
          const present_passive = get_participle(verb_table_data, $('#verb-selection').val(), "present_passive");     // 現在受動分詞
          const verbal_noun = get_verbal_noun(verb_table_data, $('#verb-selection').val(), "verbal_noun");            // 動名詞

          // テーブルにセットする。
          set_particple_to_table(present_active, '#active-participle-table');     // 現在能動分詞
          set_particple_to_table(present_passive, '#passive-participle-table');   // 現在受動分詞
          set_verbal_noun_to_table(verbal_noun, '#verbal-noun-table');            // 動名詞
        }

        //イベントを設定
        function setEvents(){
	        // セレクトボックス選択時
	        $('#verb-selection').change( function(){
            output_table_data();
	        });
          // ボタンにイベントを設定
          Input_Botton.PolishBotton('#input_verb'); 
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
  <footer class="">
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>