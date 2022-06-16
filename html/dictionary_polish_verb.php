<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/language_class/IndoEuropean_adjective_class.php");
include(dirname(__FILE__) . "/language_class/IndoEuropean_noun_class.php");
include(dirname(__FILE__) . "/language_class/IndoEuropean_verb_class.php");
include(dirname(__FILE__) . "/language_class/Database_session.php");
include(dirname(__FILE__) . "/language_class/Commons.php");
include(dirname(__FILE__) . "/language_class/Polish_Common.php");

// 活用表を取得する。
function get_verb_conjugation_chart($word){
  // 配列を宣言
	$conjugations = array();
	// 動詞の情報を取得
	$polish_verbs = Polish_Common::get_verb_by_japanese($word);
  // 動詞の情報が取得できない場合は
  if(!$polish_verbs && Polish_Common::is_alphabet_or_not($word)){
	  // 英語で動詞の情報を取得
	  $polish_verbs = Polish_Common::get_verb_by_english($word);
    // 動詞の情報が取得できない場合は
    if(!$polish_verbs){
      // 動詞の情報を取得
	    $polish_verb = Polish_Common::get_verb_from_DB($word);
      // 動詞が取得できたか確認する。
      if($polish_verb){
        // 動詞が取得できた場合
        $conjugations = array_merge(Polish_Common::get_verb_conjugation($polish_verb[0]), $conjugations);
      } else {
		    // 動詞が取得できない場合
        // 動詞を生成
		    $verb_polish = new Polish_Verb($word);
		    // 活用表生成、配列に格納
		    $conjugations[$verb_polish->get_infinitive()] = $verb_polish->get_chart();
      }
    } else {
      // 新しい配列に詰め替え
	    foreach ($polish_verbs as $polish_verb) {
        $conjugations = array_merge(Polish_Common::get_verb_conjugation($polish_verb), $conjugations);
	    }
    }
  } else if(!Polish_Common::is_alphabet_or_not($word)){
    // 空を返す。
    return array();   
  } else {
	  // 新しい配列に詰め替え
	  foreach ($polish_verbs as $polish_verb) {
      $conjugations = array_merge(Polish_Common::get_verb_conjugation($polish_verb), $conjugations);
	  }
  }
  // 結果を返す。
	return $conjugations;
}

// 名詞から活用表を取得する。
function get_conjugation_by_noun($word){

	// 名詞の語幹を取得
	$polish_nouns = Polish_Common::get_polish_strong_stem($word, Polish_Common::$DB_NOUN);
  // 名詞の情報が取得できない場合は
  if(!$polish_nouns){
    // 空を返す。
    return array();
  }  
  // 初期化
  $polish_verbs = array();
	// 全ての値に適用
	for ($i = 0; $i < count($polish_nouns); $i++) {
		// 第一変化動詞に変更
		$polish_verbs[$i] = $polish_nouns[$i]."ować";
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
	$polish_adjectives = Polish_Common::get_polish_strong_stem($word, Polish_Common::$DB_ADJECTIVE);
  // 形容詞の情報が取得できない場合は
  if(!$polish_adjectives){
    // 空を返す。
    return array();
  } 
  // 初期化
  $polish_verbs = array();
	// 全ての値に適用
	for ($i = 0; $i < count($polish_adjectives); $i++) {
		// 第一変化動詞に変更
		$polish_verbs[$i] = $polish_adjectives[$i]."ować";
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

// 挿入データ－対象－
$input_verb = trim(filter_input(INPUT_POST, 'input_verb'));

// AIによる造語対応
$janome_result = Commons::get_multiple_words_detail($input_verb);
$janome_result = Commons::convert_compound_array($janome_result);

// 条件分岐
if($input_verb != "" && $janome_result[0][1] == "名詞" && !Polish_Common::is_alphabet_or_not($input_verb) && !strpos($input_verb, Commons::$LIKE_MARK)){
  // 名詞の場合は名詞で動詞を取得
	$conjugations = get_conjugation_by_noun($input_verb);
} else if($input_verb != "" && $janome_result[0][1] == "形容詞" && !Polish_Common::is_alphabet_or_not($input_verb) && !strpos($input_verb, Commons::$LIKE_MARK) ){
  // 形容詞の場合は形容詞で動詞を取得
	$conjugations = get_conjugation_by_adjective($input_verb);    
} else if($input_verb != ""){
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
    <title>印欧語活用辞典：ラテン語辞書</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>    
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
  </head>
    <?php require_once("header.php"); ?>
  <body>
    <div class="container item table-striped">
      <h1>ポーランド語辞書（動詞）</h1>
      <p>あいまい検索は+</p>
      <form action="" method="post" class="mt-4 mb-4" id="form-category">
        <input type="text" name="input_verb" class="">
        <input type="submit" class="btn-check" id="btn-generate">
        <label class="btn" for="btn-generate">検索</label>
        <select class="" id="verb-selection" aria-label="Default select example">
          <option selected>単語を選んでください</option>
          <?php echo Commons::select_option($conjugations); ?>
        </select>
      </form>
      <details>
        <summary>動詞の活用</summary>      
        <table class="table-bordered" id="conjugation-table" style="overflow: auto;">
        <thead>
          <tr>
            <th scope="row" style="width:10%">態</th>
            <th scope="col" style="width:45%">能動</th>
            <th scope="col" style="width:45%">中動</th>               
          </tr>
        </thead>
        <tbody>
          <tr><th scope="row" colspan="3">現在時制</th></tr>
          <tr><th scope="row">1人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称複数</th><td></td><td></td></tr>
          <tr><th scope="row" colspan="3">未完了過去</th></tr>
          <tr><th scope="row">1人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称複数</th><td></td><td></td></tr>
          <tr><th scope="row" colspan="3">単純過去</th></tr>
          <tr><th scope="row">1人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称複数</th><td></td><td></td></tr>
          <tr><th scope="row" colspan="3">未来時制</th></tr>
          <tr><th scope="row">1人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称複数</th><td></td><td></td></tr>
          <tr><th scope="row" colspan="3">完了形</th></tr>
          <tr><th scope="row">1人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称複数</th><td></td><td></td></tr>
          <tr><th scope="row" colspan="3">過去完了</th></tr>
          <tr><th scope="row">1人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称複数</th><td></td><td></td></tr>         
          <tr><th scope="row" colspan="3">未来完了形</th></tr>
          <tr><th scope="row">1人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称複数</th><td></td><td></td></tr>
          <tr><th scope="row" colspan="3">仮定法</th></tr>
          <tr><th scope="row">1人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称複数</th><td></td><td></td></tr> 
          <tr><th scope="row" colspan="3">仮定法過去</th></tr>
          <tr><th scope="row">1人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称複数</th><td></td><td></td></tr>
          <tr><th scope="row" colspan="3">命令法</th></tr>
          <tr><th scope="row">1人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称単数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称双数</th><td></td><td></td></tr>
          <tr><th scope="row">1人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">2人称複数</th><td></td><td></td></tr>
          <tr><th scope="row">3人称複数</th><td></td><td></td></tr>
        </tbody>
        </table>
      </details><br>
      <details>
        <summary>現在分詞</summary>      
        <table class="table-bordered" id="active-participle-table">
            <?php echo Polish_Common::make_adjective_column_chart("現在分詞"); ?>
          <tbody>
            <?php echo Polish_Common::make_adjective_chart(); ?>
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>受動分詞</summary>
        <table class="table-bordered" id="passive-participle-table">
          <?php echo Polish_Common::make_adjective_column_chart("完了分詞"); ?>
          <tbody>
            <?php echo Polish_Common::make_adjective_chart(); ?>
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>動名詞</summary>      
        <table class="table-bordered" id="verbal-noun-table">
          <thead>
            <tr><th scope="row" style="width:10%">格</th>
            <th scope="col" style="width:30%">単数</th>
            <th scope="col" style="width:30%">双数</th>
            <th scope="col" style="width:30%">複数</th>
          </tr>
        </thead>
          <tbody>
            <tr><th scope="row">主格</th><td></td><td></td><td></td></tr>
            <tr><th scope="row">属格</th><td></td><td></td><td></td></tr>
            <tr><th scope="row">与格</th><td></td><td></td><td></td></tr>
            <tr><th scope="row">対格</th><td></td><td></td><td></td></tr>
            <tr><th scope="row">具格</th><td></td><td></td><td></td></tr>          
            <tr><th scope="row">地格</th><td></td><td></td><td></td></tr>          
            <tr><th scope="row">呼格</th><td></td><td></td><td></td></tr>                 
          </tbody>
        </table>
      </details><br>  
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
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
          var active = json_verb["active"];            //能動態現在
          var middle = json_verb["mediopassive"];     //受動態現在

          // 格納データを作成
          var verb_table = [
            ["", "", ""],
            [active["present"]["1sg"]["masc"], middle["present"]["1sg"]["masc"]],
            [active["present"]["2sg"]["masc"], middle["present"]["2sg"]["masc"]],
            [active["present"]["3sg"]["masc"], middle["present"]["3sg"]["masc"]],
            [active["present"]["1du"]["masc"], middle["present"]["1du"]["masc"]],
            [active["present"]["2du"]["masc"], middle["present"]["2du"]["masc"]],
            [active["present"]["3du"]["masc"], middle["present"]["3du"]["masc"]],            
            [active["present"]["1pl"]["masc"], middle["present"]["1pl"]["masc"]],
            [active["present"]["2pl"]["masc"], middle["present"]["2pl"]["masc"]],
            [active["present"]["3pl"]["masc"], middle["present"]["3pl"]["masc"]],
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
            ["", "", ""],
            [active["future"]["1sg"]["masc"], middle["future"]["1sg"]["masc"]],
            [active["future"]["2sg"]["masc"], middle["future"]["2sg"]["masc"]],
            [active["future"]["3sg"]["masc"], middle["future"]["3sg"]["masc"]],
            [active["future"]["1du"]["masc"], middle["future"]["1du"]["masc"]],
            [active["future"]["2du"]["masc"], middle["future"]["2du"]["masc"]],
            [active["future"]["3du"]["masc"], middle["future"]["3du"]["masc"]],            
            [active["future"]["1pl"]["masc"], middle["future"]["1pl"]["masc"]],
            [active["future"]["2pl"]["masc"], middle["future"]["2pl"]["masc"]],
            [active["future"]["3pl"]["masc"], middle["future"]["3pl"]["masc"]],
            ["", "", ""],
            [active["perfect"]["1sg"]["masc"], middle["perfect"]["1sg"]["masc"]],
            [active["perfect"]["2sg"]["masc"], middle["perfect"]["2sg"]["masc"]],
            [active["perfect"]["3sg"]["masc"], middle["perfect"]["3sg"]["masc"]],
            [active["perfect"]["1du"]["masc"], middle["perfect"]["1du"]["masc"]],
            [active["perfect"]["2du"]["masc"], middle["perfect"]["2du"]["masc"]],
            [active["perfect"]["3du"]["masc"], middle["perfect"]["3du"]["masc"]],            
            [active["perfect"]["1pl"]["masc"], middle["perfect"]["1pl"]["masc"]],
            [active["perfect"]["2pl"]["masc"], middle["perfect"]["2pl"]["masc"]],
            [active["perfect"]["3pl"]["masc"], middle["perfect"]["3pl"]["masc"]],
            ["", "", ""],
            [active["past_perfect"]["1sg"]["masc"], middle["past_perfect"]["1sg"]["masc"]],
            [active["past_perfect"]["2sg"]["masc"], middle["past_perfect"]["2sg"]["masc"]],
            [active["past_perfect"]["3sg"]["masc"], middle["past_perfect"]["3sg"]["masc"]],
            [active["past_perfect"]["1du"]["masc"], middle["past_perfect"]["1du"]["masc"]],
            [active["past_perfect"]["2du"]["masc"], middle["past_perfect"]["2du"]["masc"]],
            [active["past_perfect"]["3du"]["masc"], middle["past_perfect"]["3du"]["masc"]],
            [active["past_perfect"]["1pl"]["masc"], middle["past_perfect"]["1pl"]["masc"]],
            [active["past_perfect"]["2pl"]["masc"], middle["past_perfect"]["2pl"]["masc"]],
            [active["past_perfect"]["3pl"]["masc"], middle["past_perfect"]["3pl"]["masc"]], 
            ["", "", ""],
            [active["future_perfect"]["1sg"]["masc"], middle["future_perfect"]["1sg"]["masc"]],
            [active["future_perfect"]["2sg"]["masc"], middle["future_perfect"]["2sg"]["masc"]],
            [active["future_perfect"]["3sg"]["masc"], middle["future_perfect"]["3sg"]["masc"]],
            [active["future_perfect"]["1du"]["masc"], middle["future_perfect"]["1du"]["masc"]],
            [active["future_perfect"]["2du"]["masc"], middle["future_perfect"]["2du"]["masc"]],
            [active["future_perfect"]["3du"]["masc"], middle["future_perfect"]["3du"]["masc"]],
            [active["future_perfect"]["1pl"]["masc"], middle["future_perfect"]["1pl"]["masc"]],
            [active["future_perfect"]["2pl"]["masc"], middle["future_perfect"]["2pl"]["masc"]],
            [active["future_perfect"]["3pl"]["masc"], middle["future_perfect"]["3pl"]["masc"]],            
            ["", "", ""],
            [active["subj"]["1sg"]["masc"], middle["subj"]["1sg"]["masc"]],
            [active["subj"]["2sg"]["masc"], middle["subj"]["2sg"]["masc"]],
            [active["subj"]["3sg"]["masc"], middle["subj"]["3sg"]["masc"]],
            [active["subj"]["1du"]["masc"], middle["subj"]["1du"]["masc"]],
            [active["subj"]["2du"]["masc"], middle["subj"]["2du"]["masc"]],
            [active["subj"]["3du"]["masc"], middle["subj"]["3du"]["masc"]],            
            [active["subj"]["1pl"]["masc"], middle["subj"]["1pl"]["masc"]],
            [active["subj"]["2pl"]["masc"], middle["subj"]["2pl"]["masc"]],
            [active["subj"]["3pl"]["masc"], middle["subj"]["3pl"]["masc"]],  
            ["", "", ""],
            [active["subj_perfect"]["1sg"]["masc"], middle["subj_perfect"]["1sg"]["masc"]],
            [active["subj_perfect"]["2sg"]["masc"], middle["subj_perfect"]["2sg"]["masc"]],
            [active["subj_perfect"]["3sg"]["masc"], middle["subj_perfect"]["3sg"]["masc"]],
            [active["subj_perfect"]["1du"]["masc"], middle["subj_perfect"]["1du"]["masc"]],
            [active["subj_perfect"]["2du"]["masc"], middle["subj_perfect"]["2du"]["masc"]],
            [active["subj_perfect"]["3du"]["masc"], middle["subj_perfect"]["3du"]["masc"]],            
            [active["subj_perfect"]["1pl"]["masc"], middle["subj_perfect"]["1pl"]["masc"]],
            [active["subj_perfect"]["2pl"]["masc"], middle["subj_perfect"]["2pl"]["masc"]],
            [active["subj_perfect"]["3pl"]["masc"], middle["subj_perfect"]["3pl"]["masc"]],  
            ["", "", ""],
            ["", "", ""],
            [active["imper"]["2sg"]["masc"], middle["imper"]["2sg"]["masc"]],
            ["", "", ""],
            [active["imper"]["1du"]["masc"], middle["imper"]["1du"]["masc"]],
            [active["imper"]["2du"]["masc"], middle["imper"]["2du"]["masc"]],
            ["", "", ""],         
            [active["imper"]["1pl"]["masc"], middle["imper"]["1pl"]["masc"]],
            [active["imper"]["2pl"]["masc"], middle["imper"]["2pl"]["masc"]],
            ["", "", ""],          
          ];
          
          // 結果を返す。
          return verb_table;
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

        }
        

        //イベントを設定
        function setEvents(){
	        // セレクトボックス選択時
	        $('#verb-selection').change( function(){
            output_table_data();
	        });
        }

    </script>
  <footer class="">
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>