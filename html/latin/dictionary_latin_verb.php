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
function get_verb_conjugation_chart($word, $verb_genre){
  // 配列を宣言
	$conjugations = array();
	// 動詞の情報を取得
	$latin_verbs = Latin_Common::get_verb_by_japanese($word);
  // 動詞の情報が取得できない場合は
  if(!$latin_verbs){
    // 空を返す。
    return array();   
  }

	// 新しい配列に詰め替え
	foreach ($latin_verbs as $latin_verb) {
    $conjugations = array_merge(Latin_Common::get_verb_conjugation($latin_verb, $verb_genre), $conjugations);
	}
  // 結果を返す。
	return $conjugations;
}

// 活用表を取得する。
function get_verb_conjugation_chart_by_english($word, $verb_genre){
  // 配列を宣言
	$conjugations = array();
	// 英語で動詞の情報を取得
	$latin_verbs = Latin_Common::get_verb_by_english($word);
  // 動詞の情報が取得できない場合は
  if(!$latin_verbs){
	  // 動詞が取得できない場合
    // 動詞を生成
	  $verb_latin = new Latin_Verb($word, $verb_genre);
	  // 活用表生成、配列に格納
	  $conjugations[$verb_latin->get_infinitive()] = $verb_latin->get_chart();
  } else {
    // 新しい配列に詰め替え
	  foreach ($latin_verbs as $latin_verb) {
      $conjugations = array_merge(Latin_Common::get_verb_conjugation($latin_verb, $verb_genre), $conjugations);
	  }
  }
  // 結果を返す。
	return $conjugations;
}

// 活用表を取得する。
function get_verb_conjugation_chart_by_latin($word, $verb_genre){
  // 配列を宣言
	$conjugations = array();
  // 動詞の情報を取得
	$latin_verb = Latin_Common::get_verb_from_DB($word);
  // 動詞が取得できたか確認する。
  if($latin_verb){
    // 動詞が取得できた場合
    $conjugations = Latin_Common::get_verb_conjugation($latin_verb[0], $verb_genre);
  } else {
	  // 動詞が取得できない場合
    // 動詞を生成
	  $verb_latin = new Latin_Verb($word, $verb_genre);
	  // 活用表生成、配列に格納
	  $conjugations[$verb_latin->get_infinitive()] = $verb_latin->get_chart();
	  // メモリを解放
	  unset($verb_data);
  }
  // 結果を返す。
	return $conjugations;
}

// 名詞から活用表を取得する。
function get_conjugation_by_noun($word, $verb_genre){

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
    // 動詞の種別が指定されている場合はそちらを優先
    if($verb_genre != ""){
	    // 読み込み
	    $verb_data = new Latin_Verb($latin_verb, $verb_genre);
	    // 活用表生成、配列に格納
	    $conjugations[$verb_data->get_infinitive()] = $verb_data->get_chart();
	    // メモリを解放
	    unset($verb_data);
    } else {
	    // 読み込み
	    $verb_data = new Latin_Verb($latin_verb);
	    // 活用表生成、配列に格納
	    $conjugations[$verb_data->get_infinitive()] = $verb_data->get_chart();
	    // メモリを解放
	    unset($verb_data);
    }
	}
  // 結果を返す。
	return $conjugations;
}

// 形容詞から活用表を取得する。
function get_conjugation_by_adjective($word, $verb_genre){
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
    // 動詞の種別が指定されている場合はそちらを優先
    if($verb_genre != ""){
	    // 読み込み
	    $verb_data = new Latin_Verb($latin_verb, $verb_genre);
	    // 活用表生成、配列に格納
	    $conjugations[$verb_data->get_infinitive()] = $verb_data->get_chart();
	    // メモリを解放
	    unset($verb_data);
    } else {
	    // 読み込み
	    $verb_data = new Latin_Verb($latin_verb);
	    // 活用表生成、配列に格納
	    $conjugations[$verb_data->get_infinitive()] = $verb_data->get_chart();
	    // メモリを解放
	    unset($verb_data);
    }
	}
  // 結果を返す。
	return $conjugations;
}

// 挿入データ－対象－
$input_verb = trim(filter_input(INPUT_POST, 'input_verb'));
// 挿入データ－動詞種別－
$input_verb_type = trim(filter_input(INPUT_POST, 'input_verb_type'));
// 挿入データ－言語－
$search_lang = trim(filter_input(INPUT_POST, 'input_search_lang'));

// AIによる造語対応
$janome_result = Commons::get_multiple_words_detail($input_verb);
$janome_result = Commons::convert_compound_array($janome_result);

// 条件ごとに判定して単語を検索して取得する
if($input_verb != "" && count($janome_result) > 1 && $search_lang == Commons::NIHONGO && !ctype_alnum($input_verb) && !strpos($input_verb, Commons::$LIKE_MARK)){
  // 複合語の場合(日本語のみ)
	$conjugations = Latin_Common::make_compound_chart($janome_result, "verb", $input_verb);
} else if($input_verb != "" && $janome_result[0][1] == "名詞" && $search_lang == Commons::NIHONGO && !Latin_Common::is_alphabet_or_not($input_verb) && !strpos($input_verb, Commons::$LIKE_MARK)){
  // 名詞の場合は名詞で動詞を取得(日本語のみ)
	$conjugations = get_conjugation_by_noun($input_verb, $input_verb_type);
} else if($input_verb != "" && $janome_result[0][1] == "形容詞" && $search_lang == Commons::NIHONGO && !Latin_Common::is_alphabet_or_not($input_verb) && !strpos($input_verb, Commons::$LIKE_MARK) ){
  // 形容詞の場合は形容詞で動詞を取得(日本語のみ)
	$conjugations = get_conjugation_by_adjective($input_verb, $input_verb_type);
} else if($input_verb != "" && $search_lang == Commons::LATIN && Latin_Common::is_alphabet_or_not($input_verb)){
  // 対象が入力されていればラテン語処理を実行
	$conjugations = get_verb_conjugation_chart_by_latin($input_verb, $input_verb_type);
} else if($input_verb != "" && $search_lang == Commons::EIGO && Latin_Common::is_alphabet_or_not($input_verb)){
  // 対象が入力されていれば英語で処理を実行
	$conjugations = get_verb_conjugation_chart_by_english($input_verb, $input_verb_type);
} else if($input_verb != "" && $search_lang == Commons::NIHONGO && !Latin_Common::is_alphabet_or_not($input_verb)){
  // 対象が入力されていれば日本語で処理を実行
	$conjugations = get_verb_conjugation_chart($input_verb, $input_verb_type);
}

?>
<!doctype html>
<html lang="ja">
  <head>
    <?php require_once("latin_including.php"); ?>
    <title>印欧語活用辞典：ラテン語辞書</title>
  </head>
  <body>
    <?php require_once("latin_header.php"); ?>
    <div class="container item table-striped">
      <h1>ラテン語辞書（動詞）</h1>
      <form action="" method="post" class="mt-4 mb-4" id="form-category">
        <section class="row mb-3">
          <div class="col-md-5 mb-0 textBox1">
            <input type="text" name="input_verb" class="form-control" id="input_verb" placeholder="検索語句(日本語・英語・ラテン語)、名詞や形容詞も可 あいまい検索は+">
            <?php echo Latin_Common::input_special_button(); ?>
          </div>
          <div class="col-md-3 mb-0">
            <?php echo Latin_Common::language_select_box(); ?> 
          </div>
          <div class="col-md-2 mb-0 textBox9">
            <select class="form-select" name="input_verb_type">
              <option value="">通常</option>          
              <option value="inchorative">始動動詞</option>
              <option value="causative">使役動詞</option>
              <option value="desiderative">願望動詞</option>
              <option value="frequentive">強意動詞</option>          
            </select>
          </div>
          <div class="col-md-2 mb-0">
            <input type="submit" class="btn-check" id="btn-generate">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-generate">検索</label>
          </div>
        </section>
        <div class="input-group input-group-lg">
          <span class="input-group-text" id="inputGroup-sizing-lg">翻訳後</span>
          <select class="form-select" id="verb-selection" aria-label="Default select example">
            <option selected>単語を選んでください</option>
            <?php echo Commons::select_option($conjugations); ?>
          </select>
        </div>
      </form>
      <?php echo Commons::archaic_button(); ?>
      <details>
        <summary>動詞の活用 ※(薄文字の部分は古風な用法)</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="conjugation-table" style="overflow: auto;">
          <thead>
            <tr>
              <th class="text-center" scope="row" style="width:5%">相</th>
              <th class="text-center" scope="col" colspan="6" style="width:60%">進行相</th>
              <th class="text-center" scope="col" colspan="4" style="width:35%">完了相</th>
            </tr>
            <tr>
              <th class="text-center" scope="row" style="width:5%">法</th>
              <th class="text-center" scope="col" colspan="2" style="width:15%">直説法</th>
              <th class="text-center" scope="col" colspan="2" style="width:15%">接続法</th>
              <th class="text-center" scope="col" colspan="2" style="width:15%">命令法</th>
              <th class="text-center" scope="col" colspan="2" style="width:15%">直説法</th>
              <th class="text-center" scope="col" colspan="2" style="width:15%">接続法</th>
            </tr>
            <tr>
              <th class="text-center" scope="row" style="width:5%">態</th>
              <th class="text-center" scope="col" style="width:8%">能動</th>
              <th class="text-center" scope="col" style="width:8%">受動</th>
              <th class="text-center" scope="col" style="width:8%">能動</th>
              <th class="text-center" scope="col" style="width:8%">受動</th>
              <th class="text-center" scope="col" style="width:8%">能動</th>
              <th class="text-center" scope="col" style="width:8%">受動</th>
              <th class="text-center" scope="col" style="width:10%">能動</th>
              <th class="text-center" scope="col" style="width:10%">受動</th>
              <th class="text-center" scope="col" style="width:10%">能動</th>
              <th class="text-center" scope="col" style="width:10%">受動</th>
            </tr>
          </thead>
          <tbody>
            <tr><th class="text-center" scope="row" colspan="11">現在形</th></tr>
            <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row" colspan="11">過去形</th></tr>
            <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row" colspan="11">未来形</th></tr>
            <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><th class="text-center table-archaic" scope="row" colspan="11">未来形2</th></tr>
            <tr><th class="text-center table-archaic" scope="row">1人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td></tr>
            <tr><th class="text-center table-archaic" scope="row">2人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td></tr>
            <tr><th class="text-center table-archaic" scope="row">3人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td></tr>
            <tr><th class="text-center table-archaic" scope="row">1人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td></tr>
            <tr><th class="text-center table-archaic" scope="row">2人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td></tr>
            <tr><th class="text-center table-archaic" scope="row">3人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td></tr>
            <tr><th class="text-center table-archaic" scope="row" colspan="11">無時制</th></tr>
            <tr><th class="text-center table-archaic" scope="row">1人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td></tr>
            <tr><th class="text-center table-archaic" scope="row">2人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td></tr>
            <tr><th class="text-center table-archaic" scope="row">3人称単数</th><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td></tr>
            <tr><th class="text-center table-archaic" scope="row">1人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td></tr>
            <tr><th class="text-center table-archaic" scope="row">2人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td></tr>
            <tr><th class="text-center table-archaic" scope="row">3人称複数</th><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td></tr>
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>現在分詞</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap text-nowrap" id="present-participle-table">
            <?php echo Latin_Common::make_adjective_column_chart("現在分詞"); ?>
          <tbody>
            <tr><th class="text-center" scope="row" colspan="7">原級</th></tr>
            <?php echo Latin_Common::make_adjective_chart(); ?>
            <tr><th class="text-center" scope="row" colspan="7">比較級</th></tr>
            <?php echo Latin_Common::make_adjective_chart(); ?>
            <tr><th class="text-center" scope="row" colspan="7">最上級</th></tr>
            <?php echo Latin_Common::make_adjective_chart(); ?>
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>完了分詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap text-nowrap" id="perfect-participle-table">
          <?php echo Latin_Common::make_adjective_column_chart("完了分詞"); ?>
          <tbody>
            <tr><th class="text-center" scope="row" colspan="7">原級</th></tr>
            <?php echo Latin_Common::make_adjective_chart(); ?>
            <tr><th class="text-center" scope="row" colspan="7">比較級</th></tr>
            <?php echo Latin_Common::make_adjective_chart(); ?>
            <tr><th class="text-center" scope="row" colspan="7">最上級</th></tr>
            <?php echo Latin_Common::make_adjective_chart(); ?>
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>未来能動分詞</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap text-nowrap" id="future-active-participle-table">
          <?php echo Latin_Common::make_adjective_column_chart("未来能動分詞"); ?>
          <tbody>
            <tr><th class="text-center" scope="row" colspan="7">原級</th></tr>
            <?php echo Latin_Common::make_adjective_chart(); ?>
            <tr><th class="text-center" scope="row" colspan="7">比較級</th></tr>
            <?php echo Latin_Common::make_adjective_chart(); ?>
            <tr><th class="text-center" scope="row" colspan="7">最上級</th></tr>
            <?php echo Latin_Common::make_adjective_chart(); ?>
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>未来受動分詞</summary>     
        <table class="table table-success table-bordered table-striped table-hover text-nowrap text-nowrap" id="future-passive-participle-table">
          <?php echo Latin_Common::make_adjective_column_chart("未来受動分詞"); ?>
          <tbody>
            <tr><th class="text-center" scope="row" colspan="7">原級</th></tr>
            <?php echo Latin_Common::make_adjective_chart(); ?>
            <tr><th class="text-center" scope="row" colspan="7">比較級</th></tr>
            <?php echo Latin_Common::make_adjective_chart(); ?>
            <tr><th class="text-center" scope="row" colspan="7">最上級</th></tr>
            <?php echo Latin_Common::make_adjective_chart(); ?>
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>不定詞</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap text-nowrap" id="infinitive-table">
          <thead>
            <tr><th class="text-center" scope="row" style="width:10%">不定詞</th><th scope="col" style="width:45%">能動形</th><th scope="col" style="width:45%">受動形</th></tr></thead>
          <tbody>
            <tr><th class="text-center" scope="row">現在形</th><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">完了形</th><td></td><td></td></tr>
            <tr><th class="text-center" scope="row">未来形</th><td></td><td></td></tr>
          </tbody>
        </table>
      </details><br>   
    </div>
    <script>
        var verb_table_data = '<?php echo json_encode($conjugations, JSON_UNESCAPED_UNICODE); ?>';
    </script>
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
          var passive_present = json_verb["mediopassive"]["present"];     //受動態現在
          var active_imperfect = json_verb["active"]["past"];       //能動態過去進行
          var passive_imperfect = json_verb["mediopassive"]["past"];     //受動態過去進行 
          var active_future = json_verb["active"]["future"];               //能動態未来
          var passive_future = json_verb["mediopassive"]["future"];             //受動態未来
          var active_perfect = json_verb["active"]["present_perfect"];      //能動態完了
          var passive_perfect = json_verb["mediopassive"]["present_perfect"];    //受動態完了           
          var active_perfect = json_verb["active"]["present_perfect"];      //能動態完了
          var passive_perfect = json_verb["mediopassive"]["present_perfect"];    //受動態完了
          var active_timeless = json_verb["active"]["timeless"];    //能動態完了(古形)           
          var active_past_perfect = json_verb["active"]["past_perfect"];      //能動態過去完了
          var passive_past_perfect = json_verb["mediopassive"]["past_perfect"];    //受動態過去完了 
          var active_future_perfect = json_verb["active"]["future_perfect"];      //能動態未来完了
          var passive_future_perfect = json_verb["mediopassive"]["future_perfect"];    //受動態未来完了
          var active_future_perfect2 = json_verb["active"]["future_perfect2"];      //能動態未来完了(古形)
          var passive_future_perfect2 = json_verb["mediopassive"]["future_perfect2"];    //受動態未来完了(古形)

          // 格納データを作成
          var verb_table = [
            ["", "", "", "", "", "", "", "", "", "", "", ""],
            [active_present["ind"]["1sg"], passive_present["ind"]["1sg"], active_present["subj"]["1sg"], passive_present["subj"]["1sg"], "-", "-", active_perfect["ind"]["1sg"], passive_perfect["ind"]["1sg"], active_perfect["subj"]["1sg"], passive_perfect["subj"]["1sg"]],
            [active_present["ind"]["2sg"], passive_present["ind"]["2sg"], active_present["subj"]["2sg"], passive_present["subj"]["2sg"], active_present["imper"]["2sg"], passive_present["imper"]["2sg"], active_perfect["ind"]["2sg"], passive_perfect["ind"]["2sg"], active_perfect["subj"]["2sg"], passive_perfect["subj"]["2sg"]],
            [active_present["ind"]["3sg"], passive_present["ind"]["3sg"], active_present["subj"]["3sg"], passive_present["subj"]["3sg"], "-", "-", active_perfect["ind"]["3sg"], passive_perfect["ind"]["3sg"], active_perfect["subj"]["3sg"], passive_perfect["subj"]["3sg"]],
            [active_present["ind"]["1pl"], passive_present["ind"]["1pl"], active_present["subj"]["1pl"], passive_present["subj"]["1pl"], "-", "-", active_perfect["ind"]["1pl"], passive_perfect["ind"]["1pl"], active_perfect["subj"]["1pl"], passive_perfect["subj"]["1pl"]],
            [active_present["ind"]["2pl"], passive_present["ind"]["2pl"], active_present["subj"]["2pl"], passive_present["subj"]["2pl"], active_present["imper"]["2pl"], passive_present["imper"]["2pl"], active_perfect["ind"]["2pl"], passive_perfect["ind"]["2pl"], active_perfect["subj"]["2pl"], passive_perfect["subj"]["2pl"]],                                        
            [active_present["ind"]["3pl"], passive_present["ind"]["3pl"], active_present["subj"]["3pl"], passive_present["subj"]["3pl"], "-", "-", active_perfect["ind"]["3pl"], passive_perfect["ind"]["3pl"], active_perfect["subj"]["3pl"], passive_perfect["subj"]["3pl"]],
            ["", "", "", "", "", "", "", "", "", "", "", ""],
            [active_imperfect["ind"]["1sg"], passive_imperfect["ind"]["1sg"], active_imperfect["subj"]["1sg"], passive_imperfect["subj"]["1sg"], "-", "-", active_past_perfect["ind"]["1sg"], passive_past_perfect["ind"]["1sg"], active_past_perfect["subj"]["1sg"], passive_past_perfect["subj"]["1sg"]],
            [active_imperfect["ind"]["2sg"], passive_imperfect["ind"]["2sg"], active_imperfect["subj"]["2sg"], passive_imperfect["subj"]["2sg"], "-", "-", active_past_perfect["ind"]["2sg"], passive_past_perfect["ind"]["2sg"], active_past_perfect["subj"]["2sg"], passive_past_perfect["subj"]["2sg"]],
            [active_imperfect["ind"]["3sg"], passive_imperfect["ind"]["3sg"], active_imperfect["subj"]["3sg"], passive_imperfect["subj"]["3sg"], "-", "-", active_past_perfect["ind"]["3sg"], passive_past_perfect["ind"]["3sg"], active_past_perfect["subj"]["3sg"], passive_past_perfect["subj"]["3sg"]],
            [active_imperfect["ind"]["1pl"], passive_imperfect["ind"]["1pl"], active_imperfect["subj"]["1pl"], passive_imperfect["subj"]["1pl"], "-", "-", active_past_perfect["ind"]["1pl"], passive_past_perfect["ind"]["1pl"], active_past_perfect["subj"]["1pl"], passive_past_perfect["subj"]["1pl"]],
            [active_imperfect["ind"]["2pl"], passive_imperfect["ind"]["2pl"], active_imperfect["subj"]["2pl"], passive_imperfect["subj"]["2pl"], "-", "-", active_past_perfect["ind"]["2pl"], passive_past_perfect["ind"]["2pl"], active_past_perfect["subj"]["2pl"], passive_past_perfect["subj"]["2pl"]],
            [active_imperfect["ind"]["3pl"], passive_imperfect["ind"]["3pl"], active_imperfect["subj"]["3pl"], passive_imperfect["subj"]["3pl"], "-", "-", active_past_perfect["ind"]["3pl"], passive_past_perfect["ind"]["3pl"], active_past_perfect["subj"]["3pl"], passive_past_perfect["subj"]["3pl"]],
            ["", "", "", "", "", "", "", "", "", "", "", ""],
            [active_future["ind"]["1sg"], passive_future["ind"]["1sg"], "-", "-", "-", "-", active_future_perfect["ind"]["1sg"], passive_future_perfect["ind"]["1sg"], "-", "-",],
            [active_future["ind"]["2sg"], passive_future["ind"]["2sg"], "-", "-", active_future["imper"]["2sg"],passive_future["imper"]["2sg"], active_future_perfect["ind"]["2sg"], passive_future_perfect["ind"]["2sg"], "-", "-",],
            [active_future["ind"]["3sg"], passive_future["ind"]["3sg"], "-", "-", active_future["imper"]["3sg"],passive_future["imper"]["3sg"], active_future_perfect["ind"]["3sg"], passive_future_perfect["ind"]["3sg"], "-", "-",],
            [active_future["ind"]["1pl"], passive_future["ind"]["1pl"], "-", "-", "-", "-", active_future_perfect["ind"]["1pl"], passive_future_perfect["ind"]["1pl"], "-", "-",],
            [active_future["ind"]["2pl"], passive_future["ind"]["2pl"], "-", "-", active_future["imper"]["2pl"], passive_future["imper"]["2pl"], active_future_perfect["ind"]["2pl"], passive_future_perfect["ind"]["2pl"], "-", "-",],
            [active_future["ind"]["3pl"], passive_future["ind"]["3pl"], "-", "-", active_future["imper"]["3pl"], passive_future["imper"]["3pl"], active_future_perfect["ind"]["3pl"], passive_future_perfect["ind"]["3pl"], "-", "-",],
            ["", "", "", "", "", "", "", "", "", "", "", ""],
            [active_future_perfect2["ind"]["1sg"], passive_future_perfect2["ind"]["1sg"], "-", "-", "-", "-", "-", "-", "-", "-"],
            [active_future_perfect2["ind"]["2sg"], passive_future_perfect2["ind"]["2sg"], "-", "-", "-", "-", "-", "-", "-", "-"],
            [active_future_perfect2["ind"]["3sg"], passive_future_perfect2["ind"]["3sg"], "-", "-", "-", "-", "-", "-", "-", "-"],
            [active_future_perfect2["ind"]["1pl"], passive_future_perfect2["ind"]["1pl"], "-", "-", "-", "-", "-", "-", "-", "-"],
            [active_future_perfect2["ind"]["2pl"], passive_future_perfect2["ind"]["2pl"], "-", "-", "-", "-", "-", "-", "-", "-"],
            [active_future_perfect2["ind"]["3pl"], passive_future_perfect2["ind"]["3pl"], "-", "-", "-", "-", "-", "-", "-", "-"],
            ["", "", "", "", "", "", "", "", "", "", "", ""],
            ["-", "-", "-", "-", "-", "-", "-", "-", active_timeless["subj"]["1sg"], "-"],
            ["-", "-", "-", "-", "-", "-", "-", "-", active_timeless["subj"]["2sg"], "-"],
            ["-", "-", "-", "-", "-", "-", "-", "-", active_timeless["subj"]["3sg"], "-"],
            ["-", "-", "-", "-", "-", "-", "-", "-", active_timeless["subj"]["1pl"], "-"],
            ["-", "-", "-", "-", "-", "-", "-", "-", active_timeless["subj"]["2pl"], "-"],
            ["-", "-", "-", "-", "-", "-", "-", "-", active_timeless["subj"]["3pl"], "-"],   
          ];
          
          // 結果を返す。
          return verb_table;
        }

        // 配列をテーブル用に変換にする。
        function get_participle(table_data, selected_word, participle_name){

          // JSONに書き換え
          var json_participle = JSON.parse(table_data)[selected_word][participle_name];

          // 原級形容詞の格変化情報を取得
          var positive_masc_sg = json_participle["positive"]["masc"]["sg"]; //単数男性
          var positive_fem_sg = json_participle["positive"]["fem"]["sg"];   //単数女性
          var positive_neu_sg = json_participle["positive"]["neu"]["sg"];   	//単数中性
          var positive_masc_pl = json_participle["positive"]["masc"]["pl"]; 	//複数男性
          var positive_fem_pl = json_participle["positive"]["fem"]["pl"];   	//複数女性
          var positive_neu_pl = json_participle["positive"]["neu"]["pl"];   		//複数中性
          
          // 比較級形容詞の格変化情報を取得
          var comp_masc_sg = json_participle["comp"]["masc"]["sg"]; 	//単数男性
          var comp_fem_sg = json_participle["comp"]["fem"]["sg"];   	//単数女性
          var comp_neu_sg = json_participle["comp"]["neu"]["sg"];   	//単数中性
          var comp_masc_pl = json_participle["comp"]["masc"]["pl"]; 		//複数男性
          var comp_fem_pl = json_participle["comp"]["fem"]["pl"];   		//複数女性
          var comp_neu_pl = json_participle["comp"]["neu"]["pl"];   		//複数中性
          
          // 最上級形容詞の格変化情報を取得
          var super_masc_sg = json_participle["super"]["masc"]["sg"]; 	//単数男性
          var super_fem_sg = json_participle["super"]["fem"]["sg"];   	//単数女性
          var super_neu_sg = json_participle["super"]["neu"]["sg"];   	//単数中性
          var super_masc_pl = json_participle["super"]["masc"]["pl"]; 		//複数男性
          var super_fem_pl = json_participle["super"]["fem"]["pl"];   		//複数女性
          var super_neu_pl = json_participle["super"]["neu"]["pl"];   		//複数中性
          
          // 格納データを作成
          var declension_table = [
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
          return declension_table;
        }

        // 配列をテーブル用に変換にする(不定詞用)。
        function get_infinitive(table_data, selected_word){

          // JSONに書き換え
          var json_inifinitive = JSON.parse(table_data)[selected_word]["infinitive"];

          // 格納データを作成
          var infinitive_table = [
            [json_inifinitive["present_active"], json_inifinitive["present_passive"]],
            [json_inifinitive["perfect_active"], json_inifinitive["perfect_passive"]],
            [json_inifinitive["future_active"], json_inifinitive["future_passive"]],
          ];
          
          // 結果を返す。
          return infinitive_table;
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
              } else if(i == 10){
                rows[i].cells[0].innerText = "比較級";
              } else if(i == 18){
                rows[i].cells[0].innerText = "最上級";
              }
              // 説明行も除外
              return true;
            }
            // 格変化を挿入
            rows[i].cells[1].innerText = particple_data[i - 2][0]; // 単数男性(1行目)
            rows[i].cells[2].innerText = particple_data[i - 2][1]; // 単数女性(2行目)
            rows[i].cells[3].innerText = particple_data[i - 2][2]; // 単数中性(3行目)
            rows[i].cells[4].innerText = particple_data[i - 2][3]; // 複数男性(4行目)
            rows[i].cells[5].innerText = particple_data[i - 2][4]; // 複数女性(5行目)
            rows[i].cells[6].innerText = particple_data[i - 2][5]; // 複数中性(6行目)  
          });
        }

        // 単語選択後の処理
        function output_table_data(){
          // 非同期並列処理を行う
          $.when(
            // 動詞処理
            $.Deferred().resolve().then(function() {
              // 活用表を取得 
              const conjugation_table = get_verb(verb_table_data, $('#verb-selection').val());
              // 行オブジェクトの取得
              var rows = $('#conjugation-table')[0].rows;
              // 各行をループ処理
              $.each(rows, function(i){
                // タイトル行は除外する。
                if(i <= 3){
                  return true;
                } else if(i % 7 == 3){
                  // 説明行も除外
                  return true;
                }
                // 活用を挿入
                rows[i].cells[1].innerText = conjugation_table[i - 3][0]; // 進行相直説法能動
                rows[i].cells[2].innerText = conjugation_table[i - 3][1]; // 進行相直説法受動
                rows[i].cells[3].innerText = conjugation_table[i - 3][2]; // 進行相接続法能動
                rows[i].cells[4].innerText = conjugation_table[i - 3][3]; // 進行相接続法受動
                rows[i].cells[5].innerText = conjugation_table[i - 3][4]; // 進行相命令法能動
                rows[i].cells[6].innerText = conjugation_table[i - 3][5]; // 進行相命令法受動
                rows[i].cells[7].innerText = conjugation_table[i - 3][6]; // 完了相直説法能動
                rows[i].cells[8].innerText = conjugation_table[i - 3][7]; // 完了相直説法受動
                rows[i].cells[9].innerText = conjugation_table[i - 3][8]; // 完了相接続法能動
                rows[i].cells[10].innerText = conjugation_table[i - 3][9]; // 完了相接続法受動
              });
            }),
            // 現在分詞
            $.Deferred().resolve().then(function() {
              // 分詞を取得 
              const present_active = get_participle(verb_table_data, $('#verb-selection').val(), "present_active");
              // テーブルにセット
              set_particple_to_table(present_active, '#present-participle-table');
            }),
            // 完了分詞
            $.Deferred().resolve().then(function() {
              // 分詞を取得 
              const perfect_passive = get_participle(verb_table_data, $('#verb-selection').val(), "perfect_passive");
              // テーブルにセット
              set_particple_to_table(perfect_passive, '#perfect-participle-table');
            }),
            // 未来能動分詞
            $.Deferred().resolve().then(function() {
              // 分詞を取得 
              const future_active = get_participle(verb_table_data, $('#verb-selection').val(), "future_active");
              // テーブルにセット
              set_particple_to_table(future_active, '#future-active-participle-table');
            }),
            // 未来受動分詞
            $.Deferred().resolve().then(function() {
              // 分詞を取得 
              const future_passive = get_participle(verb_table_data, $('#verb-selection').val(), "future_passive"); 
              // テーブルにセット
              set_particple_to_table(future_passive, '#future-passive-participle-table');
            }),
            // 不定詞
            $.Deferred().resolve().then(function() {
              // データを取得 
              const verb_infinitive = get_infinitive(verb_table_data, $('#verb-selection').val());
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
            })
          );
        }

        //イベントを設定
        function setEvents(){
	        // セレクトボックス選択時
	        $('#verb-selection').change( function(){
            output_table_data();
	        });
          // ボタンにイベントを設定
          Input_Botton.LatinBotton('#input_verb'); 
          // 古形隠しボタン
          Input_Botton.HiddenArchaicBotton();
          // 初期状態は古形の表示を隠す。
          $(".table-archaic").css("display", "none");
        }

    </script>
  <footer class="">
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>