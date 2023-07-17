<?php
session_start();
header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_adjective_class.php");
include(dirname(__FILE__) . "/../language_class/IndoEuropean_noun_class.php");
include(dirname(__FILE__) . "/../language_class/IndoEuropean_verb_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Greek_Common.php");

// 活用表を取得する。
function get_verb_conjugation_chart($word){

  // 配列を宣言
	$conjugations = array();
	// 動詞の情報を取得
	$koine_verbs = Koine_Common::get_verb_by_japanese($word);
  // 動詞の情報が取得できない場合は
  if(!$koine_verbs){
      // 空を返す。
      return array();
  }
	// 新しい配列に詰め替え
	foreach ($koine_verbs as $koine_verb) {
	  // 活用表生成、配列に格納
	  $conjugations = array_merge(get_verb_chart($koine_verb["dictionary_stem"]), $conjugations);
	}

  // 結果を返す。
	return $conjugations;
}

// 活用表を取得する。
function get_verb_conjugation_chart_by_english($word, $verb_genre){
  // 配列を宣言
	$conjugations = array();
	// 英語で動詞の情報を取得
	$latin_verbs = Koine_Common::get_verb_by_english($word);
  // 動詞の情報が取得できない場合は
  if(!$latin_verbs){
	  // 動詞が取得できない場合
    // 動詞を生成
	  $verb_koine = new Koine_Verb($word, $verb_genre);
	  // 活用表生成、配列に格納
	  $conjugations[$verb_koine->get_dic_stem()] = $verb_koine->get_chart();
  } else {
    // 新しい配列に詰め替え
	  foreach ($latin_verbs as $latin_verb) {
      $conjugations = array_merge(Koine_Common::get_verb_conjugation($latin_verb), $conjugations);
	  }
  }
  // 結果を返す。
	return $conjugations;
}

// 活用表を取得する。
function get_verb_conjugation_chart_by_koine($word, $verb_genre){
  // 配列を宣言
	$conjugations = array();
  // 動詞の情報を取得
	$koine_verb = Koine_Common::get_verb_from_DB($word);
  // 動詞が取得できたか確認する。
  if($koine_verb){
    // 動詞が取得できた場合
    $conjugations = Koine_Common::get_verb_conjugation($koine_verb["dictionary_stem"]);
  } else {
	  // 動詞が取得できない場合
    // 動詞を生成
	  $verb_koine = new Koine_Verb($word, $verb_genre);
	  // 活用表生成、配列に格納
	  $conjugations[$verb_koine->get_dic_stem()] = $verb_koine->get_chart();
	  // メモリを解放
	  unset($verb_data);
  }
  // 結果を返す。
	return $conjugations;
}

// 動詞の活用を取得
function get_verb_chart($word){
	// 読み込み
	$vedic_verb = new Koine_Verb($word);
  // 新しい配列を作成
  $new_array = array();
	// 活用表生成、配列に格納
	$new_array[$vedic_verb->get_dic_stem()] = $vedic_verb->get_chart();
	// メモリを解放
	unset($vedic_verb);
  // 結果を返す。
  return $new_array;
}

// 名詞から活用表を取得する。
function get_conjugation_by_noun($word){

	// 名詞の語幹を取得
	$koine_verbs = Koine_Common::get_koine_strong_stem($word, Koine_Common::DB_NOUN);
  // 名詞の情報が取得できない場合は
  if(!$koine_verbs){
    // 空を返す。
    return array();
  } 
  // 配列を宣言
  $conjugations = array();   
	// 新しい配列に詰め替え
	foreach ($koine_verbs as $koine_verb) {
	  // 読み込み
	  $vedic_verb = new Koine_Verb($koine_verb, "noun", $word);
	  // 活用表生成、配列に格納
	  $conjugations[$vedic_verb->get_dic_stem()] = $vedic_verb->get_chart();
	  // メモリを解放
	  unset($vedic_verb);
	}
  // 結果を返す。
	return $conjugations;
}

// 形容詞から活用表を取得する。
function get_conjugation_by_adjective($word){
	// 形容詞の語幹を取得
	$koine_verbs = Koine_Common::get_koine_strong_stem($word, Koine_Common::DB_ADJECTIVE);
  // 名詞の情報が取得できない場合は
  if(!$koine_verbs){
    // 空を返す。
    return array();
  } 
  // 配列を宣言
  $conjugations = array();   
	// 新しい配列に詰め替え
	foreach ($koine_verbs as $koine_verb) {
	  // 読み込み
	  $vedic_verb = new Koine_Verb($koine_verb, "adjective", $word);
	  // 活用表生成、配列に格納
	  $conjugations[$vedic_verb->get_dic_stem()] = $vedic_verb->get_chart();
	  // メモリを解放
	  unset($vedic_verb);
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
if(count($janome_result) > 1 && !ctype_alnum($input_verb) && $search_lang == Commons::NIHONGO && !strpos($input_verb, Commons::$LIKE_MARK)){
  // 複合語の場合
  $conjugations = Koine_Common::make_compound_chart($janome_result, "verb", $input_verb);
} else if($input_verb != "" && $janome_result[0][1] == "名詞" && $search_lang == Commons::NIHONGO && !Koine_Common::is_alphabet_or_not($input_verb) && !strpos($input_verb, Commons::$LIKE_MARK)){
  // 名詞の場合は名詞で動詞を取得
	$conjugations = get_conjugation_by_noun($input_verb);
} else if($input_verb != "" && $janome_result[0][1] == "形容詞" && $search_lang == Commons::NIHONGO && !Koine_Common::is_alphabet_or_not($input_verb) && !strpos($input_verb, Commons::$LIKE_MARK) ){
  // 形容詞の場合は形容詞で動詞を取得
	$conjugations = get_conjugation_by_adjective($input_verb); 
} else if($input_verb != "" && $search_lang == Commons::GREEK && Koine_Common::is_alphabet_or_not($input_verb)){
  // 対象が入力されていればラテン語処理を実行
	$conjugations = get_verb_conjugation_chart_by_koine($input_verb, $input_verb_type);
} else if($input_verb != "" && $search_lang == Commons::EIGO && !Koine_Common::is_alphabet_or_not($input_verb) && Koine_Common::is_latin_alphabet_or_not($input_verb)){
  // 対象が入力されていれば英語で処理を実行
	$conjugations = get_verb_conjugation_chart_by_english($input_verb, $input_verb_type);
} else if($input_verb != "" && $search_lang == Commons::NIHONGO && !Koine_Common::is_alphabet_or_not($input_verb) && !Koine_Common::is_latin_alphabet_or_not($input_verb)){
  // 対象が入力されていれば日本語で処理を実行
	$conjugations = get_verb_conjugation_chart($input_verb, $input_verb_type);
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
      <h1>ギリシア語辞書（動詞）</h1>
      <form action="" method="post" class="mt-4 mb-4" id="form-category">
        <input type="text" name="input_verb" class="form-control" id="input_verb" placeholder="検索語句(日本語・英語・ギリシア語)、名詞や形容詞も可 あいまい検索は+">
        <?php echo Koine_Common::language_select_box(); ?>  
        <input type="submit" class="btn-check" id="btn-generate">
        <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-generate">検索</label>
        <select class="form-select" id="verb-selection" aria-label="Default select example">
          <option selected>単語を選んでください</option>
          <?php echo Commons::select_option($conjugations); ?>
        </select>
      </form>
      <?php echo Koine_Common::input_special_button(); ?>         
      <details>
        <summary>一次動詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="primary-conjugation-table">
          <?php echo Koine_Common::make_verbal_chart("一次動詞"); ?>     
        </table>
      </details><br>
      <details>
        <summary>一次動詞分詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="primary-participle-table">
          <?php echo Koine_Common::make_adjective_column_chart("一次動詞分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">不完了体能動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?>          
            <tr><th scope="row" class="text-center" colspan="10">不完了体中受動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?>
            <tr><th scope="row" class="text-center" colspan="10">始動相能動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?>          
            <tr><th scope="row" class="text-center" colspan="10">始動相中受動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">完了体能動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">完了体中動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?>        
            <tr><th scope="row" class="text-center" colspan="10">完了体受動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">完了形能動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">完了形中受動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相能動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相中動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相受動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?> 
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>一次動詞不定詞</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="primary-infinitive-table">
        <?php echo Koine_Common::make_infinitive_chart(); ?> 
        </table>
      </details><br>
      <details>
        <summary>使役動詞</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="causative-conjugation-table">
          <?php echo Koine_Common::make_verbal_chart("使役動詞");?>   
        </table>
      </details><br>
      <details>
        <summary>使役動詞分詞</summary>        
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="causative-participle-table">
          <?php echo Koine_Common::make_adjective_column_chart("使役動詞分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">不完了体能動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?>          
            <tr><th scope="row" class="text-center" colspan="10">不完了体中受動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?>
            <tr><th scope="row" class="text-center" colspan="10">始動相能動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?>          
            <tr><th scope="row" class="text-center" colspan="10">始動相中受動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">完了体能動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">完了体中動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?>        
            <tr><th scope="row" class="text-center" colspan="10">完了体受動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">完了形能動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">完了形中受動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相能動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相中動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相受動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?>       
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>使役動詞不定詞</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="causative-infinitive-table">
        <?php echo Koine_Common::make_infinitive_chart(); ?> 
        </table>
      </details><br>
      <details>
        <summary>強意動詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="intensive-conjugation-table">
          <?php echo Koine_Common::make_verbal_chart("強意動詞");?>  
        </table>
      </details><br>
      <details>
        <summary>強意動詞分詞</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="intensive-participle-table">
          <?php echo Koine_Common::make_adjective_column_chart("強意動詞分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">不完了体能動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?>           
            <tr><th scope="row" class="text-center" colspan="10">不完了体中動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?>   
            <tr><th scope="row" class="text-center" colspan="10">始動相能動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?>          
            <tr><th scope="row" class="text-center" colspan="10">始動相中受動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">完了体能動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?>  
            <tr><th scope="row" class="text-center" colspan="10">完了体中受動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?>  
            <tr><th scope="row" class="text-center" colspan="10">未然相能動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?>  
            <tr><th scope="row" class="text-center" colspan="10">未然相中受動態</th></tr>
            <?php echo Koine_Common::make_adjective_chart(); ?>  
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>強意動詞不定詞</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="intensive-infinitive-table">
        <?php echo Koine_Common::make_infinitive_chart(); ?> 
        </table>
      </details><br>
    </div>
    <script>
        var verb_table_data = '<?php echo json_encode($conjugations, JSON_UNESCAPED_UNICODE); ?>';
    </script>
	  <script type="text/javascript" src="/../js/input_button.js"></script>
    <script>

        $(function(){
          // イベントを設定
          setEvents();
        });

        // 動詞の配列をテーブル用に変換にする。
        function get_verb(json_verb, verb_type, table_id){

          // 活用情報を取得
          var active_present = json_verb["present"]["active"];                  //能動態不完了体
          var middle_present = json_verb["present"]["mediopassive"];            //中受動態不完了体
          var active_inchorative = json_verb["inchorative"]["active"];          //能動態始動動詞
          var middle_inchorative = json_verb["inchorative"]["mediopassive"];    //中受動態始動動詞             
          var active_aorist = json_verb["aorist"]["active"];                    //能動態完了体
          var middle_aorist = json_verb["aorist"]["mediopassive"];              //中動態完了体
          var passive_aorist = json_verb["aorist"]["passive"];                  //受動態完了体
          var active_perfect = json_verb["perfect"]["active"];                  //能動態完了形
          var middle_perfect = json_verb["perfect"]["mediopassive"];            //中受動態完了形
          var active_future = json_verb["future"]["active"];                    //能動態未来形
          var middle_future = json_verb["future"]["mediopassive"];              //中動態未来形
          var passive_future = json_verb["future"]["passive"];                  //受動態未来形

          // 格納データを作成
          var verb_table = [
            ["", "", "", "", "", "", "", "", "", "", ""],
            [active_present["present"]["1sg"], middle_present["present"]["1sg"], active_inchorative["present"]["1sg"], middle_inchorative["present"]["1sg"], active_aorist["present"]["1sg"], middle_aorist["present"]["1sg"], passive_aorist["present"]["1sg"], active_perfect["present"]["1sg"], middle_perfect["present"]["1sg"], active_future["present"]["1sg"], middle_future["present"]["1sg"], passive_future["present"]["1sg"]],
            [active_present["present"]["2sg"], middle_present["present"]["2sg"], active_inchorative["present"]["2sg"], middle_inchorative["present"]["2sg"], active_aorist["present"]["2sg"], middle_aorist["present"]["2sg"], passive_aorist["present"]["2sg"], active_perfect["present"]["2sg"], middle_perfect["present"]["2sg"], active_future["present"]["2sg"], middle_future["present"]["2sg"], passive_future["present"]["2sg"]],
            [active_present["present"]["3sg"], middle_present["present"]["3sg"], active_inchorative["present"]["3sg"], middle_inchorative["present"]["3sg"], active_aorist["present"]["3sg"], middle_aorist["present"]["3sg"], passive_aorist["present"]["3sg"], active_perfect["present"]["3sg"], middle_perfect["present"]["3sg"], active_future["present"]["3sg"], middle_future["present"]["3sg"], passive_future["present"]["3sg"]],
            [active_present["present"]["2du"], middle_present["present"]["2du"], active_inchorative["present"]["2du"], middle_inchorative["present"]["2du"], active_aorist["present"]["2du"], middle_aorist["present"]["2du"], passive_aorist["present"]["2du"], active_perfect["present"]["2du"], middle_perfect["present"]["2du"], active_future["present"]["2du"], middle_future["present"]["2du"], passive_future["present"]["2du"]],
            [active_present["present"]["3du"], middle_present["present"]["3du"], active_inchorative["present"]["3du"], middle_inchorative["present"]["3du"], active_aorist["present"]["3du"], middle_aorist["present"]["3du"], passive_aorist["present"]["3du"], active_perfect["present"]["3du"], middle_perfect["present"]["3du"], active_future["present"]["3du"], middle_future["present"]["3du"], passive_future["present"]["3du"]],
            [active_present["present"]["1pl"], middle_present["present"]["1pl"], active_inchorative["present"]["1pl"], middle_inchorative["present"]["1pl"], active_aorist["present"]["1pl"], middle_aorist["present"]["1pl"], passive_aorist["present"]["1pl"], active_perfect["present"]["1pl"], middle_perfect["present"]["1pl"], active_future["present"]["1pl"], middle_future["present"]["1pl"], passive_future["present"]["1pl"]],
            [active_present["present"]["2pl"], middle_present["present"]["2pl"], active_inchorative["present"]["2pl"], middle_inchorative["present"]["2pl"], active_aorist["present"]["2pl"], middle_aorist["present"]["2pl"], passive_aorist["present"]["2pl"], active_perfect["present"]["2pl"], middle_perfect["present"]["2pl"], active_future["present"]["2pl"], middle_future["present"]["2pl"], passive_future["present"]["2pl"]],
            [active_present["present"]["3pl"], middle_present["present"]["3pl"], active_inchorative["present"]["3pl"], middle_inchorative["present"]["3pl"], active_aorist["present"]["3pl"], middle_aorist["present"]["3pl"], passive_aorist["present"]["3pl"], active_perfect["present"]["3pl"], middle_perfect["present"]["3pl"], active_future["present"]["3pl"], middle_future["present"]["3pl"], passive_future["present"]["3pl"]],
            ["", "", "", "", "", "", "", "", "", "", ""],
            [active_present["past"]["1sg"], middle_present["past"]["1sg"], active_inchorative["past"]["1sg"], middle_inchorative["past"]["1sg"], active_aorist["past"]["1sg"], middle_aorist["past"]["1sg"], passive_aorist["past"]["1sg"], active_perfect["past"]["1sg"], middle_perfect["past"]["1sg"], active_future["past"]["1sg"], middle_future["past"]["1sg"], passive_future["past"]["1sg"]],
            [active_present["past"]["2sg"], middle_present["past"]["2sg"], active_inchorative["past"]["2sg"], middle_inchorative["past"]["2sg"], active_aorist["past"]["2sg"], middle_aorist["past"]["2sg"], passive_aorist["past"]["2sg"], active_perfect["past"]["2sg"], middle_perfect["past"]["2sg"], active_future["past"]["2sg"], middle_future["past"]["2sg"], passive_future["past"]["2sg"]],
            [active_present["past"]["3sg"], middle_present["past"]["3sg"], active_inchorative["past"]["3sg"], middle_inchorative["past"]["3sg"], active_aorist["past"]["3sg"], middle_aorist["past"]["3sg"], passive_aorist["past"]["3sg"], active_perfect["past"]["3sg"], middle_perfect["past"]["3sg"], active_future["past"]["3sg"], middle_future["past"]["3sg"], passive_future["past"]["3sg"]],
            [active_present["past"]["2du"], middle_present["past"]["2du"], active_inchorative["past"]["2du"], middle_inchorative["past"]["2du"], active_aorist["past"]["2du"], middle_aorist["past"]["2du"], passive_aorist["past"]["2du"], active_perfect["past"]["2du"], middle_perfect["past"]["2du"], active_future["past"]["2du"], middle_future["past"]["2du"], passive_future["past"]["2du"]],
            [active_present["past"]["3du"], middle_present["past"]["3du"], active_inchorative["past"]["3du"], middle_inchorative["past"]["3du"], active_aorist["past"]["3du"], middle_aorist["past"]["3du"], passive_aorist["past"]["3du"], active_perfect["past"]["3du"], middle_perfect["past"]["3du"], active_future["past"]["3du"], middle_future["past"]["3du"], passive_future["past"]["3du"]],
            [active_present["past"]["1pl"], middle_present["past"]["1pl"], active_inchorative["past"]["1pl"], middle_inchorative["past"]["1pl"], active_aorist["past"]["1pl"], middle_aorist["past"]["1pl"], passive_aorist["past"]["1pl"], active_perfect["past"]["1pl"], middle_perfect["past"]["1pl"], active_future["past"]["1pl"], middle_future["past"]["1pl"], passive_future["past"]["1pl"]],
            [active_present["past"]["2pl"], middle_present["past"]["2pl"], active_inchorative["past"]["2pl"], middle_inchorative["past"]["2pl"], active_aorist["past"]["2pl"], middle_aorist["past"]["2pl"], passive_aorist["past"]["2pl"], active_perfect["past"]["2pl"], middle_perfect["past"]["2pl"], active_future["past"]["2pl"], middle_future["past"]["2pl"], passive_future["past"]["2pl"]],
            [active_present["past"]["3pl"], middle_present["past"]["3pl"], active_inchorative["past"]["3pl"], middle_inchorative["past"]["3pl"], active_aorist["past"]["3pl"], middle_aorist["past"]["3pl"], passive_aorist["past"]["3pl"], active_perfect["past"]["3pl"], middle_perfect["past"]["3pl"], active_future["past"]["3pl"], middle_future["past"]["3pl"], passive_future["past"]["3pl"]],
            ["", "", "", "", "", "", "", "", "", "", ""],
            [active_present["subj"]["1sg"], middle_present["subj"]["1sg"], active_inchorative["subj"]["1sg"], middle_inchorative["subj"]["1sg"], active_aorist["subj"]["1sg"], middle_aorist["subj"]["1sg"], passive_aorist["subj"]["1sg"], active_perfect["subj"]["1sg"], middle_perfect["subj"]["1sg"], active_future["subj"]["1sg"], middle_future["subj"]["1sg"], passive_future["subj"]["1sg"]],
            [active_present["subj"]["2sg"], middle_present["subj"]["2sg"], active_inchorative["subj"]["2sg"], middle_inchorative["subj"]["2sg"], active_aorist["subj"]["2sg"], middle_aorist["subj"]["2sg"], passive_aorist["subj"]["2sg"], active_perfect["subj"]["2sg"], middle_perfect["subj"]["2sg"], active_future["subj"]["2sg"], middle_future["subj"]["2sg"], passive_future["subj"]["2sg"]],
            [active_present["subj"]["3sg"], middle_present["subj"]["3sg"], active_inchorative["subj"]["3sg"], middle_inchorative["subj"]["3sg"], active_aorist["subj"]["3sg"], middle_aorist["subj"]["3sg"], passive_aorist["subj"]["3sg"], active_perfect["subj"]["3sg"], middle_perfect["subj"]["3sg"], active_future["subj"]["3sg"], middle_future["subj"]["3sg"], passive_future["subj"]["3sg"]],
            [active_present["subj"]["2du"], middle_present["subj"]["2du"], active_inchorative["subj"]["2du"], middle_inchorative["subj"]["2du"], active_aorist["subj"]["2du"], middle_aorist["subj"]["2du"], passive_aorist["subj"]["2du"], active_perfect["subj"]["2du"], middle_perfect["subj"]["2du"], active_future["subj"]["2du"], middle_future["subj"]["2du"], passive_future["subj"]["2du"]],
            [active_present["subj"]["3du"], middle_present["subj"]["3du"], active_inchorative["subj"]["3du"], middle_inchorative["subj"]["3du"], active_aorist["subj"]["3du"], middle_aorist["subj"]["3du"], passive_aorist["subj"]["3du"], active_perfect["subj"]["3du"], middle_perfect["subj"]["3du"], active_future["subj"]["3du"], middle_future["subj"]["3du"], passive_future["subj"]["3du"]],
            [active_present["subj"]["1pl"], middle_present["subj"]["1pl"], active_inchorative["subj"]["1pl"], middle_inchorative["subj"]["1pl"], active_aorist["subj"]["1pl"], middle_aorist["subj"]["1pl"], passive_aorist["subj"]["1pl"], active_perfect["subj"]["1pl"], middle_perfect["subj"]["1pl"], active_future["subj"]["1pl"], middle_future["subj"]["1pl"], passive_future["subj"]["1pl"]],
            [active_present["subj"]["2pl"], middle_present["subj"]["2pl"], active_inchorative["subj"]["2pl"], middle_inchorative["subj"]["2pl"], active_aorist["subj"]["2pl"], middle_aorist["subj"]["2pl"], passive_aorist["subj"]["2pl"], active_perfect["subj"]["2pl"], middle_perfect["subj"]["2pl"], active_future["subj"]["2pl"], middle_future["subj"]["2pl"], passive_future["subj"]["2pl"]],
            [active_present["subj"]["3pl"], middle_present["subj"]["3pl"], active_inchorative["subj"]["3pl"], middle_inchorative["subj"]["3pl"], active_aorist["subj"]["3pl"], middle_aorist["subj"]["3pl"], passive_aorist["subj"]["3pl"], active_perfect["subj"]["3pl"], middle_perfect["subj"]["3pl"], active_future["subj"]["3pl"], middle_future["subj"]["3pl"], passive_future["subj"]["3pl"]],
            ["", "", "", "", "", "", "", "", "", "", ""],
            [active_present["opt"]["1sg"], middle_present["opt"]["1sg"], active_inchorative["opt"]["1sg"], middle_inchorative["opt"]["1sg"],  active_aorist["opt"]["1sg"], middle_aorist["opt"]["1sg"], passive_aorist["opt"]["1sg"], active_perfect["opt"]["1sg"], middle_perfect["opt"]["1sg"], active_future["opt"]["1sg"], middle_future["opt"]["1sg"], passive_future["opt"]["1sg"]],
            [active_present["opt"]["2sg"], middle_present["opt"]["2sg"], active_inchorative["opt"]["2sg"], middle_inchorative["opt"]["2sg"],  active_aorist["opt"]["2sg"], middle_aorist["opt"]["2sg"], passive_aorist["opt"]["2sg"], active_perfect["opt"]["2sg"], middle_perfect["opt"]["2sg"], active_future["opt"]["2sg"], middle_future["opt"]["2sg"], passive_future["opt"]["2sg"]],
            [active_present["opt"]["3sg"], middle_present["opt"]["3sg"], active_inchorative["opt"]["3sg"], middle_inchorative["opt"]["3sg"],  active_aorist["opt"]["3sg"], middle_aorist["opt"]["3sg"], passive_aorist["opt"]["3sg"], active_perfect["opt"]["3sg"], middle_perfect["opt"]["3sg"], active_future["opt"]["3sg"], middle_future["opt"]["3sg"], passive_future["opt"]["3sg"]],
            [active_present["opt"]["2du"], middle_present["opt"]["2du"], active_inchorative["opt"]["2du"], middle_inchorative["opt"]["2du"],  active_aorist["opt"]["2du"], middle_aorist["opt"]["2du"], passive_aorist["opt"]["2du"], active_perfect["opt"]["2du"], middle_perfect["opt"]["2du"], active_future["opt"]["2du"], middle_future["opt"]["2du"], passive_future["opt"]["2du"]],
            [active_present["opt"]["3du"], middle_present["opt"]["3du"], active_inchorative["opt"]["3du"], middle_inchorative["opt"]["3du"],  active_aorist["opt"]["3du"], middle_aorist["opt"]["3du"], passive_aorist["opt"]["3du"], active_perfect["opt"]["3du"], middle_perfect["opt"]["3du"], active_future["opt"]["3du"], middle_future["opt"]["3du"], passive_future["opt"]["3du"]],
            [active_present["opt"]["1pl"], middle_present["opt"]["1pl"], active_inchorative["opt"]["1pl"], middle_inchorative["opt"]["1pl"],  active_aorist["opt"]["1pl"], middle_aorist["opt"]["1pl"], passive_aorist["opt"]["1pl"], active_perfect["opt"]["1pl"], middle_perfect["opt"]["1pl"], active_future["opt"]["1pl"], middle_future["opt"]["1pl"], passive_future["opt"]["1pl"]],
            [active_present["opt"]["2pl"], middle_present["opt"]["2pl"], active_inchorative["opt"]["2pl"], middle_inchorative["opt"]["2pl"],  active_aorist["opt"]["2pl"], middle_aorist["opt"]["2pl"], passive_aorist["opt"]["2pl"], active_perfect["opt"]["2pl"], middle_perfect["opt"]["2pl"], active_future["opt"]["2pl"], middle_future["opt"]["2pl"], passive_future["opt"]["2pl"]],
            [active_present["opt"]["3pl"], middle_present["opt"]["3pl"], active_inchorative["opt"]["3pl"], middle_inchorative["opt"]["3pl"],  active_aorist["opt"]["3pl"], middle_aorist["opt"]["3pl"], passive_aorist["opt"]["3pl"], active_perfect["opt"]["3pl"], middle_perfect["opt"]["3pl"], active_future["opt"]["3pl"], middle_future["opt"]["3pl"], passive_future["opt"]["3pl"]],
            ["", "", "", "", "", "", "", "", "", "", ""],
            [active_present["imper"]["2sg"], middle_present["imper"]["2sg"], active_inchorative["imper"]["2sg"], middle_inchorative["imper"]["2sg"],  active_aorist["imper"]["2sg"], middle_aorist["imper"]["2sg"], passive_aorist["imper"]["2sg"], active_perfect["imper"]["2sg"], middle_perfect["imper"]["2sg"], active_future["imper"]["2sg"], middle_future["imper"]["2sg"], passive_future["imper"]["2sg"]],
            [active_present["imper"]["3sg"], middle_present["imper"]["3sg"], active_inchorative["imper"]["3sg"], middle_inchorative["imper"]["3sg"],  active_aorist["imper"]["3sg"], middle_aorist["imper"]["3sg"], passive_aorist["imper"]["3sg"], active_perfect["imper"]["3sg"], middle_perfect["imper"]["3sg"], active_future["imper"]["3sg"], middle_future["imper"]["3sg"], passive_future["imper"]["3sg"]],
            [active_present["imper"]["2du"], middle_present["imper"]["2du"], active_inchorative["imper"]["2du"], middle_inchorative["imper"]["2du"],  active_aorist["imper"]["2du"], middle_aorist["imper"]["2du"], passive_aorist["imper"]["2du"], active_perfect["imper"]["2du"], middle_perfect["imper"]["2du"], active_future["imper"]["2du"], middle_future["imper"]["2du"], passive_future["imper"]["2du"]],
            [active_present["imper"]["3du"], middle_present["imper"]["3du"], active_inchorative["imper"]["3du"], middle_inchorative["imper"]["3du"],  active_aorist["imper"]["3du"], middle_aorist["imper"]["3du"], passive_aorist["imper"]["3du"], active_perfect["imper"]["3du"], middle_perfect["imper"]["3du"], active_future["imper"]["3du"], middle_future["imper"]["3du"], passive_future["imper"]["3du"]],
            [active_present["imper"]["2pl"], middle_present["imper"]["2pl"], active_inchorative["imper"]["2pl"], middle_inchorative["imper"]["2pl"],  active_aorist["imper"]["2pl"], middle_aorist["imper"]["2pl"], passive_aorist["imper"]["2pl"], active_perfect["imper"]["2pl"], middle_perfect["imper"]["2pl"], active_future["imper"]["2pl"], middle_future["imper"]["2pl"], passive_future["imper"]["2pl"]],
            [active_present["imper"]["3pl"], middle_present["imper"]["3pl"], active_inchorative["imper"]["3pl"], middle_inchorative["imper"]["3pl"],  active_aorist["imper"]["3pl"], middle_aorist["imper"]["3pl"], passive_aorist["imper"]["3pl"], active_perfect["imper"]["3pl"], middle_perfect["imper"]["3pl"], active_future["imper"]["3pl"], middle_future["imper"]["3pl"], passive_future["imper"]["3pl"]],
          ];

          // 行オブジェクトの取得
          var rows = $(table_id)[0].rows;
          // 各行をループ処理
          $.each(rows, function(i){
            // タイトル行は除外する。
            if(i <= 1){
              return true;
            } else if(verb_table[i - 2][0] == ""){
              // 説明行も除外
              return true;
            }
            // 活用を挿入
            rows[i].cells[1].innerText = verb_table[i - 2][0];      // 進行相能動
            rows[i].cells[2].innerText = verb_table[i - 2][1];      // 進行相中動
            rows[i].cells[3].innerText = verb_table[i - 2][2];      // 始動相能動
            rows[i].cells[4].innerText = verb_table[i - 2][3];      // 始動相中動
            rows[i].cells[5].innerText = verb_table[i - 2][4];      // 完結相能動
            rows[i].cells[6].innerText = verb_table[i - 2][5];      // 完結相中動 
            rows[i].cells[7].innerText = verb_table[i - 2][6];      // 完結相受動
            rows[i].cells[8].innerText = verb_table[i - 2][7];      // 完了相能動
            rows[i].cells[9].innerText = verb_table[i - 2][8];      // 完了相受動             
            rows[i].cells[10].innerText = verb_table[i - 2][9];     // 未来形能動
            rows[i].cells[11].innerText = verb_table[i - 2][10];    // 未来形中動
            rows[i].cells[12].innerText = verb_table[i - 2][11];    // 未来形受動            
          });
        }

        // 分詞・形容詞の配列をテーブル用に変換にする。
        function get_adjective(json_adjective){

          // 原級形容詞の格変化情報を取得
          var positive_masc_sg = json_adjective["positive"]["masc"]["sg"];   //単数男性
          var positive_fem_sg = json_adjective["positive"]["fem"]["sg"];     //単数女性
          var positive_neu_sg = json_adjective["positive"]["neu"]["sg"];   	//単数中性
          var positive_masc_du = json_adjective["positive"]["masc"]["du"];   //双数男性
          var positive_fem_du = json_adjective["positive"]["fem"]["du"];     //双数女性
          var positive_neu_du = json_adjective["positive"]["neu"]["du"];   	//双数中性          
          var positive_masc_pl = json_adjective["positive"]["masc"]["pl"]; 	//複数男性
          var positive_fem_pl = json_adjective["positive"]["fem"]["pl"];   	//複数女性
          var positive_neu_pl = json_adjective["positive"]["neu"]["pl"];   	//複数中性
          
          // 比較級形容詞の格変化情報を取得
          var comp_masc_sg = json_adjective["comp"]["masc"]["sg"]; 	        //単数男性
          var comp_fem_sg = json_adjective["comp"]["fem"]["sg"];   	        //単数女性
          var comp_neu_sg = json_adjective["comp"]["neu"]["sg"];   	        //単数中性
          var comp_masc_du = json_adjective["comp"]["masc"]["du"];           //双数男性
          var comp_fem_du = json_adjective["comp"]["fem"]["du"];             //双数女性
          var comp_neu_du = json_adjective["comp"]["neu"]["du"];   	        //双数中性           
          var comp_masc_pl = json_adjective["comp"]["masc"]["pl"]; 		      //複数男性
          var comp_fem_pl = json_adjective["comp"]["fem"]["pl"];   		      //複数女性
          var comp_neu_pl = json_adjective["comp"]["neu"]["pl"];   		      //複数中性
          
          // 最上級形容詞の格変化情報を取得
          var super_masc_sg = json_adjective["super"]["masc"]["sg"]; 	      //単数男性
          var super_fem_sg = json_adjective["super"]["fem"]["sg"];   	      //単数女性
          var super_neu_sg = json_adjective["super"]["neu"]["sg"];   	      //単数中性
          var super_masc_du = json_adjective["super"]["masc"]["du"];         //双数男性
          var super_fem_du = json_adjective["super"]["fem"]["du"];           //双数女性
          var super_neu_du = json_adjective["super"]["neu"]["du"];   	      //双数中性            
          var super_masc_pl = json_adjective["super"]["masc"]["pl"]; 		    //複数男性
          var super_fem_pl = json_adjective["super"]["fem"]["pl"];   		    //複数女性
          var super_neu_pl = json_adjective["super"]["neu"]["pl"];   		    //複数中性
          
          // 格納データを作成
          var adj_table = [
            ["", "", "", "", "", "", ""],
            ["", "", "", "", "", "", ""],
            [positive_masc_sg["nom"], positive_fem_sg["nom"], positive_neu_sg["nom"], positive_masc_du["nom"], positive_fem_du["nom"], positive_neu_du["nom"], positive_masc_pl["nom"], positive_fem_pl["nom"], positive_neu_pl["nom"]],
            [positive_masc_sg["gen"], positive_fem_sg["gen"], positive_neu_sg["gen"], positive_masc_du["gen"], positive_fem_du["gen"], positive_neu_du["gen"], positive_masc_pl["gen"], positive_fem_pl["gen"], positive_neu_pl["gen"]],
            [positive_masc_sg["dat"], positive_fem_sg["dat"], positive_neu_sg["dat"], positive_masc_du["dat"], positive_fem_du["dat"], positive_neu_du["dat"], positive_masc_pl["dat"], positive_fem_pl["dat"], positive_neu_pl["dat"]],
            [positive_masc_sg["acc"], positive_fem_sg["acc"], positive_neu_sg["acc"], positive_masc_du["acc"], positive_fem_du["acc"], positive_neu_du["acc"], positive_masc_pl["acc"], positive_fem_pl["acc"], positive_neu_pl["acc"]],
            [positive_masc_sg["abl"], positive_fem_sg["abl"], positive_neu_sg["abl"], positive_masc_du["abl"], positive_fem_du["abl"], positive_neu_du["abl"], positive_masc_pl["abl"], positive_fem_pl["abl"], positive_neu_pl["abl"]],
            [positive_masc_sg["ins"], positive_fem_sg["ins"], positive_neu_sg["ins"], positive_masc_du["ins"], positive_fem_du["ins"], positive_neu_du["ins"], positive_masc_pl["ins"], positive_fem_pl["ins"], positive_neu_pl["ins"]],            
            [positive_masc_sg["loc"], positive_fem_sg["loc"], positive_neu_sg["loc"], positive_masc_du["loc"], positive_fem_du["loc"], positive_neu_du["loc"], positive_masc_pl["loc"], positive_fem_pl["loc"], positive_neu_pl["loc"]],
            [positive_masc_sg["voc"], positive_fem_sg["voc"], positive_neu_sg["voc"], positive_masc_du["voc"], positive_fem_du["voc"], positive_neu_du["voc"], positive_masc_pl["voc"], positive_fem_pl["voc"], positive_neu_pl["voc"]],
            [positive_masc_sg["allative"], positive_fem_sg["allative"], positive_neu_sg["allative"], "", "", "", ""],
            [positive_masc_sg["allative2"], positive_fem_sg["allative2"], positive_neu_sg["allative2"], "", "", "", ""],
            ["", "", "", "", "", "", ""],
            [comp_masc_sg["nom"], comp_fem_sg["nom"], comp_neu_sg["nom"], comp_masc_du["nom"], comp_fem_du["nom"], comp_neu_du["nom"], comp_masc_pl["nom"], comp_fem_pl["nom"], comp_neu_pl["nom"]],
            [comp_masc_sg["gen"], comp_fem_sg["gen"], comp_neu_sg["gen"], comp_masc_du["gen"], comp_fem_du["gen"], comp_neu_du["gen"], comp_masc_pl["gen"], comp_fem_pl["gen"], comp_neu_pl["gen"]],
            [comp_masc_sg["dat"], comp_fem_sg["dat"], comp_neu_sg["dat"], comp_masc_du["dat"], comp_fem_du["dat"], comp_neu_du["dat"], comp_masc_pl["dat"], comp_fem_pl["dat"], comp_neu_pl["dat"]],
            [comp_masc_sg["acc"], comp_fem_sg["acc"], comp_neu_sg["acc"], comp_masc_du["acc"], comp_fem_du["acc"], comp_neu_du["acc"], comp_masc_pl["acc"], comp_fem_pl["acc"], comp_neu_pl["acc"]],
            [comp_masc_sg["abl"], comp_fem_sg["abl"], comp_neu_sg["abl"], comp_masc_du["abl"], comp_fem_du["abl"], comp_neu_du["abl"], comp_masc_pl["abl"], comp_fem_pl["abl"], comp_neu_pl["abl"]],
            [comp_masc_sg["ins"], comp_fem_sg["ins"], comp_neu_sg["ins"], comp_masc_du["ins"], comp_fem_du["ins"], comp_neu_du["ins"], comp_masc_pl["ins"], comp_fem_pl["ins"], comp_neu_pl["ins"]],
            [comp_masc_sg["loc"], comp_fem_sg["loc"], comp_neu_sg["loc"], comp_masc_du["loc"], comp_fem_du["loc"], comp_neu_du["loc"], comp_masc_pl["loc"], comp_fem_pl["loc"], comp_neu_pl["loc"]],
            [comp_masc_sg["voc"], comp_fem_sg["voc"], comp_neu_sg["voc"], comp_masc_du["voc"], comp_fem_du["voc"], comp_neu_du["voc"], comp_masc_pl["voc"], comp_fem_pl["voc"], comp_neu_pl["voc"]],
            [comp_masc_sg["allative"], comp_fem_sg["allative"], comp_neu_sg["allative"], "", "", "", ""],
            [comp_masc_sg["allative2"], comp_fem_sg["allative2"], comp_neu_sg["allative2"], "", "", "", ""],      
            ["", "", "", "", "", "", ""],
            [super_masc_sg["nom"], super_fem_sg["nom"], super_neu_sg["nom"], super_masc_du["nom"], super_fem_du["nom"], super_neu_du["nom"], super_masc_pl["nom"], super_fem_pl["nom"], super_neu_pl["nom"]],
            [super_masc_sg["gen"], super_fem_sg["gen"], super_neu_sg["gen"], super_masc_du["gen"], super_fem_du["gen"], super_neu_du["gen"], super_masc_pl["gen"], super_fem_pl["gen"], super_neu_pl["gen"]],
            [super_masc_sg["dat"], super_fem_sg["dat"], super_neu_sg["dat"], super_masc_du["dat"], super_fem_du["dat"], super_neu_du["dat"], super_masc_pl["dat"], super_fem_pl["dat"], super_neu_pl["dat"]],
            [super_masc_sg["acc"], super_fem_sg["acc"], super_neu_sg["acc"], super_masc_du["acc"], super_fem_du["acc"], super_neu_du["acc"], super_masc_pl["acc"], super_fem_pl["acc"], super_neu_pl["acc"]],
            [super_masc_sg["abl"], super_fem_sg["abl"], super_neu_sg["abl"], super_masc_du["abl"], super_fem_du["abl"], super_neu_du["abl"], super_masc_pl["abl"], super_fem_pl["abl"], super_neu_pl["abl"]],
            [super_masc_sg["ins"], super_fem_sg["ins"], super_neu_sg["ins"], super_masc_du["ins"], super_fem_du["ins"], super_neu_du["ins"], super_masc_pl["ins"], super_fem_pl["ins"], super_neu_pl["ins"]],            
            [super_masc_sg["loc"], super_fem_sg["loc"], super_neu_sg["loc"], super_masc_du["loc"], super_fem_du["loc"], super_neu_du["loc"], super_masc_pl["loc"], super_fem_pl["loc"], super_neu_pl["loc"]],
            [super_masc_sg["voc"], super_fem_sg["voc"], super_neu_sg["voc"], super_masc_du["voc"], super_fem_du["voc"], super_neu_du["voc"], super_masc_pl["voc"], super_fem_pl["voc"], super_neu_pl["voc"]],
            [super_masc_sg["allative"], super_fem_sg["allative"], super_neu_sg["allative"], "", "", "", ""],
            [super_masc_sg["allative2"], super_fem_sg["allative2"], super_neu_sg["allative2"], "", "", "", ""],                 
          ];

          // 結果を返す。
          return adj_table;
        }

        // 分詞をテーブルにセット
        function set_adjective_to_table(table_id, particple_table){
          // 行オブジェクトの取得
          var rows = $(table_id)[0].rows;
          // 各行をループ処理
          $.each(rows, function(i){
            // タイトル行は除外する。
            if(particple_table[i][0] == ""){
              return true;
            } else if(rows[i].cells[5] == undefined){
              rows[i].cells[1].innerText = particple_table[i][0]; // 副詞列
              rows[i].cells[2].innerText = particple_table[i][1]; // 副詞列
              rows[i].cells[3].innerText = particple_table[i][2]; // 副詞列               
            } else {
              // 格変化を挿入
              rows[i].cells[1].innerText = particple_table[i][0];     // 単数男性(1行目)
              rows[i].cells[2].innerText = particple_table[i][1];     // 単数女性(2行目)
              rows[i].cells[3].innerText = particple_table[i][2];     // 単数中性(3行目)
              rows[i].cells[4].innerText = particple_table[i][3];     // 双数男性(4行目)
              rows[i].cells[5].innerText = particple_table[i][4];     // 双数女性(5行目)
              rows[i].cells[6].innerText = particple_table[i][5];     // 双数中性(6行目)  
              rows[i].cells[7].innerText = particple_table[i][6];     // 複数男性(4行目)
              rows[i].cells[8].innerText = particple_table[i][7];     // 複数女性(5行目)
              rows[i].cells[9].innerText = particple_table[i][8];     // 複数中性(6行目)       
            }
              
          });
        }

        // 不定詞をテーブルにセット
        function set_infinitive_to_table(table_id, infinitive_table){
          // 行オブジェクトの取得
          var rows = $(table_id)[0].rows;
          // 各行をループ処理
          $.each(rows, function(i){
            // タイトル行は除外する。
            if(i == 0){
              return true;
            }
            // 格変化を挿入
            for (let j = 0; j < infinitive_table[i - 1].length; j++) {
              rows[i].cells[j + 1].innerText = infinitive_table[i - 1][j]; // 単数(1行目)
            }
          });
        }       

        // 分詞をセット
        function set_participle(json_participle, verb_type, table_id){

          // 各分詞を挿入
          var active_present = json_participle["participle"]["present"]["active"];            //能動態不完了体
          var middle_present = json_participle["participle"]["present"]["middle"];            //中受動態不完了体
          var active_inchorative = json_participle["participle"]["inchorative"]["active"];        //能動態始動相
          var middle_inchorative = json_participle["participle"]["inchorative"]["middle"];        //中受動態始動相
          var active_aorist = json_participle["participle"]["aorist"]["active"];              //能動態完了体
          var middle_aorist = json_participle["participle"]["aorist"]["middle"];              //中動態完了体
          var passive_aorist = json_participle["participle"]["aorist"]["passive"];            //受動態完了体
          var active_perfect = json_participle["participle"]["perfect"]["active"];            //能動態完了形
          var middle_perfect = json_participle["participle"]["perfect"]["middle"];            //中受動態完了形
          var active_future = json_participle["participle"]["future"]["active"];              //能動態未来形
          var middle_future = json_participle["participle"]["future"]["middle"];              //中動態未来形
          var passive_future = json_participle["participle"]["future"]["passive"];            //受動態未来形

          // 分詞
          var particple_table = [
            ["", "", "", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", "", "", ""],
          ];

          // 分詞を配列にして連結する。
          particple_table = particple_table.concat(get_adjective(active_present));        //能動態不完了体
          particple_table = particple_table.concat(get_adjective(middle_present));        //中受動態不完了体
          particple_table = particple_table.concat(get_adjective(active_inchorative));    //能動態始動相
          particple_table = particple_table.concat(get_adjective(middle_inchorative));    //中受動態始動相    
          particple_table = particple_table.concat(get_adjective(active_aorist));         //能動態完了体
          particple_table = particple_table.concat(get_adjective(middle_aorist));         //中動態完了体
          particple_table = particple_table.concat(get_adjective(passive_aorist));        //受動態完了体
          particple_table = particple_table.concat(get_adjective(active_perfect));        //能動態完了形
          particple_table = particple_table.concat(get_adjective(middle_perfect));        //中受動態完了形
          particple_table = particple_table.concat(get_adjective(active_future));         //能動態未来形
          particple_table = particple_table.concat(get_adjective(middle_future));         //中動態未来形
          particple_table = particple_table.concat(get_adjective(passive_future));        //受動態未来形

          // テーブルにセットする。
          set_adjective_to_table(table_id, particple_table);
        }

        // 不定詞
        function set_infinitive(table_data, verb_type, table_id){
          // JSONに書き換え
          var json_infinitive = table_data["infinitive"];


          // 格納データを作成
          var infinitive_table = [
            [json_infinitive["present"]["active"], json_infinitive["inchorative"]["active"], json_infinitive["aorist"]["active"], json_infinitive["perfect"]["active"], json_infinitive["future"]["active"]],
            [json_infinitive["present"]["middle"], json_infinitive["inchorative"]["middle"], json_infinitive["aorist"]["middle"], json_infinitive["perfect"]["middle"], json_infinitive["future"]["middle"]],
            [json_infinitive["present"]["passive"], json_infinitive["inchorative"]["passive"], json_infinitive["aorist"]["passive"], json_infinitive["perfect"]["passive"], json_infinitive["future"]["passive"]],
          ];

          // テーブルにセットする。
          set_infinitive_to_table(table_id, infinitive_table);
        }

        // 動詞ごとにテーブルを出力する。
        function verb_output_by_verb_type(verb_data, verb_type){
          // 動詞をテーブルに入れる。
          get_verb(verb_data, verb_type, '#' + verb_type + '-conjugation-table');         
          // 不定詞をセットする。
          set_infinitive(verb_data, verb_type, '#' + verb_type + '-infinitive-table');
          // 分詞をテーブルを入れる。
          set_participle(verb_data, verb_type, '#' + verb_type + '-participle-table'); 
        }

        // 単語選択後の処理
        function output_table_data(){
          // JSONに書き換え
          var table_data = JSON.parse(verb_table_data)[$('#verb-selection').val()];

          // mapに変換
          const map = new Map(Object.entries(table_data))

          // 要素ごとに処理する。
          map.forEach((val,key)=>{
            if(key != "title" && key != "dic_title" && key != "category" && key != "type"){
              // 動詞を動詞の種別ごとに出力
              verb_output_by_verb_type(val, key);
            }
          })
        }

        //イベントを設定
        function setEvents(){
	        // セレクトボックス選択時
	        $('#verb-selection').change( function(){
            output_table_data();
	        });
          // ボタンにイベントを設定
          Input_Botton.GreekBotton('#input_verb'); 
        }
        
    </script>
  <footer class="">
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>