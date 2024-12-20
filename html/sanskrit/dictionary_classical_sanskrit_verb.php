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
function get_verb_conjugation_chart($word){

  // 配列を宣言
	$conjugations = array();
	// 動詞の情報を取得
	$vedic_verbs = Sanskrit_Common::get_verb_by_japanese($word);
  // 動詞の情報が取得できない場合は
  if(!$vedic_verbs){
    // 空を返す。
    return array();
  }
	// 新しい配列に詰め替え
	foreach ($vedic_verbs as $vedic_verb) {
	  // 活用表生成、配列に格納
	  $conjugations = array_merge(Sanskrit_Common::get_verb_chart($vedic_verb["dictionary_stem"], Commons::$TRUE), $conjugations);
	}

  // 結果を返す。
	return $conjugations;
}

// 梵語で活用表を取得する。
function get_verb_conjugation_chart_by_sanskrit($word){
  // 配列を宣言
	$conjugations = array();
  // 動詞の情報を語根から取得
  $vedic_verbs = Sanskrit_Common::get_root_from_root($word);
  // 取得できなかった場合は
  if(!$vedic_verbs){
    // 活用表生成、配列に格納
    $conjugations = Sanskrit_Common::get_verb_chart($word, Commons::$TRUE);
    // 結果を返す。
    return $conjugations;
  } 

	// 新しい配列に詰め替え
	foreach ($vedic_verbs as $vedic_verb) {
	  // 活用表生成、配列に格納
	  $conjugations = array_merge(Sanskrit_Common::get_verb_chart($vedic_verb["dictionary_stem"], Commons::$TRUE), $conjugations);
	}

  // 結果を返す。
	return $conjugations;
}

// 英語で活用表を取得する。
function get_verb_conjugation_chart_by_english($word){
  // 配列を宣言
	$conjugations = array();
  // 動詞の情報を語根から取得
  $vedic_verbs = Sanskrit_Common::get_root_from_root($word);
  // 取得できなかった場合は
  if(!$vedic_verbs){
    // 活用表生成、配列に格納
    $conjugations = Sanskrit_Common::get_verb_chart($word, Commons::$TRUE);
    // 結果を返す。
    return $conjugations;
  } 

	// 新しい配列に詰め替え
	foreach ($vedic_verbs as $vedic_verb) {
	  // 活用表生成、配列に格納
	  $conjugations = array_merge(Sanskrit_Common::get_verb_chart($vedic_verb["dictionary_stem"], Commons::$TRUE), $conjugations);
	}

  // 結果を返す。
	return $conjugations;
}

// 名詞から活用表を取得する。
function get_verb_conjugation_chart_by_noun($word){

	// 名詞の語幹を取得
	$sanskrit_verbs = Sanskrit_Common::get_sanskrit_strong_stem($word, Sanskrit_Common::DB_NOUN);
  // 名詞の情報が取得できない場合は
  if(!$sanskrit_verbs){
    // 空を返す。
    return array();
  } 

  // 動詞を取得
	$conjugations = Sanskrit_Common::make_denomitive_verb($sanskrit_verbs, $word, Commons::$TRUE);

  // 結果を返す。
  return $conjugations;
}

// 形容詞から活用表を取得する。
function get_verb_conjugation_chart_by_adjective($word){
	// 形容詞の語幹を取得
	$sanskrit_verbs = Sanskrit_Common::get_sanskrit_strong_stem($word, Sanskrit_Common::DB_ADJECTIVE);
  // 名詞の情報が取得できない場合は
  if(!$sanskrit_verbs){
    // 空を返す。
    return array();
  } 

  // 動詞を取得
	$conjugations = Sanskrit_Common::make_denomitive_verb($sanskrit_verbs, $word, Commons::$TRUE);
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
if($input_verb != "" && $search_lang == Commons::NIHONGO && count($janome_result) > 1 && !ctype_alnum($input_verb) && !strpos($input_verb, Commons::$LIKE_MARK) && !Sanskrit_Common::is_alphabet_or_not($input_verb)){
  // 複合語の場合(日本語のみ)
  $conjugations = Sanskrit_Common::make_compound_chart($janome_result, "verb", $input_verb);
} else if($input_verb != "" && $search_lang == Commons::NIHONGO && $janome_result[0][1] == "名詞" && !Sanskrit_Common::is_alphabet_or_not($input_verb) && !strpos($input_verb, Commons::$LIKE_MARK)){
  // 名詞の場合は名詞で動詞を取得(日本語のみ)
	$conjugations = get_verb_conjugation_chart_by_noun($input_verb);
} else if($input_verb != "" && $search_lang == Commons::NIHONGO && $janome_result[0][1] == "形容詞" && !Sanskrit_Common::is_alphabet_or_not($input_verb) && !strpos($input_verb, Commons::$LIKE_MARK) ){
  // 形容詞の場合は形容詞で動詞を取得(日本語のみ)
	$conjugations = get_verb_conjugation_chart_by_adjective($input_verb);
} else if($input_verb != "" && $search_lang == Commons::EIGO && Sanskrit_Common::is_alphabet_or_not($input_verb)){
  // 梵語で処理を実行
  $conjugations = get_verb_conjugation_chart_by_english($input_verb);
} else if($input_verb != "" && $search_lang == Commons::BONGO && Sanskrit_Common::is_alphabet_or_not($input_verb)){
  // 英語で処理を実行
  $conjugations = get_verb_conjugation_chart_by_sanskrit($input_verb);
} else if($input_verb != "" && $search_lang == Commons::NIHONGO && !Sanskrit_Common::is_alphabet_or_not($input_verb)){
  // 日本語で処理を実行
  $conjugations = get_verb_conjugation_chart($input_verb);
}

?>
<!doctype html>
<html lang="ja">
  <head>
    <?php require_once("sanskrit_including.php"); ?>
    <title>印欧語活用辞典：梵語辞書</title>
  </head>
  <body>
    <?php require_once("sanskrit_header.php"); ?>
    <div class="container item table-striped">
      <h1>梵語辞書（動詞）</h1>
      <form action="" method="post" class="mt-4 mb-4" id="form-category">
        <section class="row mb-3">
          <div class="col-md-7 mb-0 textBox1">
            <input type="text" name="input_verb" class="form-control" id="input_verb" placeholder="検索語句(日本語・英語・サンスクリット)、名詞や形容詞も可 あいまい検索は+">
            <?php echo Sanskrit_Common::input_special_button(); ?>
          </div>
          <div class="col-md-3 mb-0">
            <?php echo Sanskrit_Common::language_select_box(); ?>
          </div>
          <div class="col-md-2 mb-0">
            <input type="submit" class="btn-check" id="btn-generate">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-generate">検索</label>
          </div>
        </section>
        <select class="form-select" id="verb-selection" aria-label="Default select example">
          <option selected>単語を選んでください</option>
          <?php echo Commons::select_option($conjugations); ?>
        </select>
      </form>
      <?php echo Commons::extension_button(); ?>
      <details>
        <summary>一次動詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="primary-conjugation-table">
          <?php echo Sanskrit_Common::make_classical_verbal_chart("一次動詞"); ?>     
        </table>
      </details><br>
      <details>
        <summary>一次動詞分詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="primary-participle-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("一次動詞分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">不完了体能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>          
            <tr><th scope="row" class="text-center" colspan="10">不完了体中動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>          
            <tr><th scope="row" class="text-center" colspan="10">不完了体受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">完了形能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">完了形中受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相中動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>一次動詞過去分詞</summary>       
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="primary-past-participle-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("過去分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">na-過去分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ta-過去分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>    
            <tr><th scope="row" class="text-center" colspan="10">na-過去能動分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ta-過去受動分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>一次動詞動形容詞</summary>          
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="primary-verbal-adjective-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("動形容詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">tavya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>
            <tr><th scope="row" class="text-center" colspan="10">ta-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>              
            <tr><th scope="row" class="text-center" colspan="10">anīya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>使役動詞</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="causative-conjugation-table">
          <?php echo Sanskrit_Common::make_classical_verbal_chart("使役動詞");?>   
        </table>
      </details><br>
      <details>
        <summary>使役動詞分詞</summary>        
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="causative-participle-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("使役動詞分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">不完了体能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>          
            <tr><th scope="row" class="text-center" colspan="10">不完了体中動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>          
            <tr><th scope="row" class="text-center" colspan="10">不完了体受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相中動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>  
            <tr><th scope="row" class="text-center" colspan="10">未然相受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>           
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>使役動詞過去分詞</summary>         
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="causative-past-participle-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("使役動詞過去分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">na-過去分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ta-過去分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>    
            <tr><th scope="row" class="text-center" colspan="10">na-過去能動分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ta-過去受動分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>         
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>使役動形容詞</summary>         
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="causative-verbal-adjective-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("使役動形容詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">tavya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">anīya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>願望動詞</summary>           
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="desiderative-conjugation-table">
          <?php echo Sanskrit_Common::make_classical_verbal_chart("願望動詞");?>  
        </table>
      </details><br>
      <details>
        <summary>願望動詞分詞</summary>         
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="desiderative-participle-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("願望動詞分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">不完了体能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>      
            <tr><th scope="row" class="text-center" colspan="10">不完了体中動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>        
            <tr><th scope="row" class="text-center" colspan="10">不完了体受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相中受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>   
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>願望動詞過去分詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="desiderative-past-participle-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("願望動詞過去分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">na-過去分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ta-過去分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>      
            <tr><th scope="row" class="text-center" colspan="10">na-過去能動分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row"class="text-center"  colspan="10">ta-過去受動分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>        
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>願望動形容詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="desiderative-verbal-adjective-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("願望動形容詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">tavya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">anīya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>  
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>強意動詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="intensive-conjugation-table">
          <?php echo Sanskrit_Common::make_classical_verbal_chart("強意動詞");?>  
        </table>
      </details><br>
      <details>
        <summary>強意動詞分詞</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="intensive-participle-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("強意動詞分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">不完了体能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>           
            <tr><th scope="row" class="text-center" colspan="10">不完了体中動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>    
            <tr><th scope="row" class="text-center" colspan="10">不完了体受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>  
            <tr><th scope="row" class="text-center" colspan="10">未然相能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>  
            <tr><th scope="row" class="text-center" colspan="10">未然相中受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>  
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>強意動詞過去分詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="intensive-past-participle-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("強意動詞過去分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">na-過去分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>  
            <tr><th scope="row" class="text-center" colspan="10">ta-過去分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>  
            <tr><th scope="row" class="text-center" colspan="10">na-過去能動分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>  
            <tr><th scope="row" class="text-center" colspan="10">ta-過去受動分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>  
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>強意動詞動形容詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="intensive-verbal-adjective-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("強意動詞動形容詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">tavya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>  
            <tr><th scope="row" class="text-center" colspan="10">ya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>        
            <tr><th scope="row" class="text-center" colspan="10">anīya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>  
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>使役+願望動詞</summary>           
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="causative-desiderative-conjugation-table">
          <?php echo Sanskrit_Common::make_classical_verbal_chart("使役+願望動詞");?>  
        </table>
      </details><br>
      <details>
        <summary>使役+願望動詞分詞</summary>         
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="causative-desiderative-participle-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("使役+願望動詞分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">不完了体能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>      
            <tr><th scope="row" class="text-center" colspan="10">不完了体中動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>        
            <tr><th scope="row" class="text-center" colspan="10">不完了体受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相中受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>   
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>使役+願望動詞過去分詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="causative-desiderative-past-participle-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("使役+願望動詞過去分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">na-過去分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ta-過去分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>      
            <tr><th scope="row" class="text-center" colspan="10">na-過去能動分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ta-過去受動分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>        
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>使役+願望動形容詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="causative-desiderative-verbal-adjective-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("使役+願望動形容詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">tavya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">anīya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>  
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>強意+願望動詞</summary>           
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="intensive-desiderative-conjugation-table">
          <?php echo Sanskrit_Common::make_classical_verbal_chart("強意+願望動詞");?>  
        </table>
      </details><br>
      <details>
        <summary>強意+願望動詞分詞</summary>         
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="intensive-desiderative-participle-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("強意+願望動詞分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">不完了体能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>      
            <tr><th scope="row" class="text-center" colspan="10">不完了体中動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>        
            <tr><th scope="row" class="text-center" colspan="10">不完了体受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相中受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>   
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>強意+願望動詞過去分詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="intensive-desiderative-past-participle-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("強意+願望動詞過去分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">na-過去分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ta-過去分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>      
            <tr><th scope="row" class="text-center" colspan="10">na-過去能動分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ta-過去受動分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>        
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>強意+願望動形容詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="intensive-desiderative-verbal-adjective-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("強意+願望動形容詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">tavya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">anīya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>  
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>願望+使役動詞</summary>           
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="desiderative-causative-conjugation-table">
          <?php echo Sanskrit_Common::make_classical_verbal_chart("願望+使役動詞");?>  
        </table>
      </details><br>
      <details>
        <summary>願望+使役動詞分詞</summary>         
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="desiderative-causative-participle-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("願望+使役動詞分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">不完了体能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>      
            <tr><th scope="row" class="text-center" colspan="10">不完了体中動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>        
            <tr><th scope="row" class="text-center" colspan="10">不完了体受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相中受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>   
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>願望+使役動詞過去分詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="desiderative-causative-past-participle-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("願望+使役動詞過去分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">na-過去分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ta-過去分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>      
            <tr><th scope="row" class="text-center" colspan="10">na-過去能動分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ta-過去受動分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>        
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>願望+使役動形容詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="desiderative-causative-verbal-adjective-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("願望+使役動形容詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">tavya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">anīya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>  
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>強意+使役動詞</summary>           
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="intensive-causative-conjugation-table">
          <?php echo Sanskrit_Common::make_classical_verbal_chart("強意+使役動詞");?>  
        </table>
      </details><br>
      <details>
        <summary>強意+使役動詞分詞</summary>         
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="intensive-causative-participle-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("強意+使役動詞分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">不完了体能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>      
            <tr><th scope="row" class="text-center" colspan="10">不完了体中動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>        
            <tr><th scope="row" class="text-center" colspan="10">不完了体受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相能動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">未然相中受動態</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>   
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>強意+使役動詞不定詞</summary>      
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="intensive-causative-infinitive-table">
          <?php echo Sanskrit_Common::make_third_verb_infinitive_chart("強意+使役動詞"); ?>
        </table>
      </details><br>
      <details>
        <summary>強意+使役動詞過去分詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="intensive-causative-past-participle-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("強意+使役動詞過去分詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">na-過去分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ta-過去分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>      
            <tr><th scope="row" class="text-center" colspan="10">na-過去能動分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ta-過去受動分詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>        
          </tbody>
        </table>
      </details><br>
      <details>
        <summary>強意+使役動形容詞</summary>
        <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="intensive-causative-verbal-adjective-table">
          <?php echo Sanskrit_Common::make_adjective_column_chart("強意+使役動形容詞"); ?>
          <tbody>
            <tr><th scope="row" class="text-center" colspan="10">tavya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">ya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?> 
            <tr><th scope="row" class="text-center" colspan="10">anīya-動形容詞</th></tr>
            <?php echo Sanskrit_Common::make_adjective_chart(); ?>  
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

        // 派生動詞の配列をテーブル用に変換にする。
        function set_verb(json_verb, verb_type, table_id){

          // 活用情報を取得
          var active_present = json_verb["present"]["active"];                  //能動態不完了体
          var middle_present = json_verb["present"]["mediopassive"];            //中動態不完了体
          var passive_present = json_verb["present"]["passive"];                //受動態不完了体           
          var active_aorist = json_verb["aorist"]["active"];                    //能動態完了体
          var middle_aorist = json_verb["aorist"]["mediopassive"];              //中動態完了体
          var passive_aorist = json_verb["aorist"]["passive"];                  //受動態完了体
          var active_perfect = json_verb["perfect"]["active"];                  //能動態完了体
          var middle_perfect = json_verb["perfect"]["mediopassive"];            //中受動態完了体
          var active_future = json_verb["future"]["active"];                    //能動態未来形
          var middle_future = json_verb["future"]["mediopassive"];              //中動態未来形
          var passive_future = json_verb["future"]["passive"];                  //受動態未来形

          // 格納データを作成
          var verb_table = [
            ["", "", "", "", "", "", "", "", "", "", ""],
            [active_present["present"]["1sg"], middle_present["present"]["1sg"], passive_present["present"]["1sg"], active_aorist["present"]["1sg"], middle_aorist["present"]["1sg"], passive_aorist["present"]["1sg"], active_perfect["present"]["1sg"], middle_perfect["present"]["1sg"], active_future["present"]["1sg"], middle_future["present"]["1sg"], passive_future["present"]["1sg"]],
            [active_present["present"]["2sg"], middle_present["present"]["2sg"], passive_present["present"]["2sg"], active_aorist["present"]["2sg"], middle_aorist["present"]["2sg"], passive_aorist["present"]["2sg"], active_perfect["present"]["2sg"], middle_perfect["present"]["2sg"], active_future["present"]["2sg"], middle_future["present"]["2sg"], passive_future["present"]["2sg"]],
            [active_present["present"]["3sg"], middle_present["present"]["3sg"], passive_present["present"]["3sg"], active_aorist["present"]["3sg"], middle_aorist["present"]["3sg"], passive_aorist["present"]["3sg"], active_perfect["present"]["3sg"], middle_perfect["present"]["3sg"], active_future["present"]["3sg"], middle_future["present"]["3sg"], passive_future["present"]["3sg"]],
            [active_present["present"]["1du"], middle_present["present"]["1du"], passive_present["present"]["1du"], active_aorist["present"]["1du"], middle_aorist["present"]["1du"], passive_aorist["present"]["1du"], active_perfect["present"]["1du"], middle_perfect["present"]["1du"], active_future["present"]["1du"], middle_future["present"]["1du"], passive_future["present"]["1du"]],
            [active_present["present"]["2du"], middle_present["present"]["2du"], passive_present["present"]["2du"], active_aorist["present"]["2du"], middle_aorist["present"]["2du"], passive_aorist["present"]["2du"], active_perfect["present"]["2du"], middle_perfect["present"]["2du"], active_future["present"]["2du"], middle_future["present"]["2du"], passive_future["present"]["2du"]],
            [active_present["present"]["3du"], middle_present["present"]["3du"], passive_present["present"]["3du"], active_aorist["present"]["3du"], middle_aorist["present"]["3du"], passive_aorist["present"]["3du"], active_perfect["present"]["3du"], middle_perfect["present"]["3du"], active_future["present"]["3du"], middle_future["present"]["3du"], passive_future["present"]["3du"]],
            [active_present["present"]["1pl"], middle_present["present"]["1pl"], passive_present["present"]["1pl"], active_aorist["present"]["1pl"], middle_aorist["present"]["1pl"], passive_aorist["present"]["1pl"], active_perfect["present"]["1pl"], middle_perfect["present"]["1pl"], active_future["present"]["1pl"], middle_future["present"]["1pl"], passive_future["present"]["1pl"]],
            [active_present["present"]["2pl"], middle_present["present"]["2pl"], passive_present["present"]["2pl"], active_aorist["present"]["2pl"], middle_aorist["present"]["2pl"], passive_aorist["present"]["2pl"], active_perfect["present"]["2pl"], middle_perfect["present"]["2pl"], active_future["present"]["2pl"], middle_future["present"]["2pl"], passive_future["present"]["2pl"]],
            [active_present["present"]["3pl"], middle_present["present"]["3pl"], passive_present["present"]["3pl"], active_aorist["present"]["3pl"], middle_aorist["present"]["3pl"], passive_aorist["present"]["3pl"], active_perfect["present"]["3pl"], middle_perfect["present"]["3pl"], active_future["present"]["3pl"], middle_future["present"]["3pl"], passive_future["present"]["3pl"]],
            ["", "", "", "", "", "", "", "", "", "", ""],
            [active_present["past"]["1sg"], middle_present["past"]["1sg"], passive_present["past"]["1sg"], active_aorist["past"]["1sg"], middle_aorist["past"]["1sg"], passive_aorist["past"]["1sg"], active_perfect["past"]["1sg"], middle_perfect["past"]["1sg"], active_future["past"]["1sg"], middle_future["past"]["1sg"], passive_future["past"]["1sg"]],
            [active_present["past"]["2sg"], middle_present["past"]["2sg"], passive_present["past"]["2sg"], active_aorist["past"]["2sg"], middle_aorist["past"]["2sg"], passive_aorist["past"]["2sg"], active_perfect["past"]["2sg"], middle_perfect["past"]["2sg"], active_future["past"]["2sg"], middle_future["past"]["2sg"], passive_future["past"]["2sg"]],
            [active_present["past"]["3sg"], middle_present["past"]["3sg"], passive_present["past"]["3sg"], active_aorist["past"]["3sg"], middle_aorist["past"]["3sg"], passive_aorist["past"]["3sg"], active_perfect["past"]["3sg"], middle_perfect["past"]["3sg"], active_future["past"]["3sg"], middle_future["past"]["3sg"], passive_future["past"]["3sg"]],
            [active_present["past"]["1du"], middle_present["past"]["1du"], passive_present["past"]["1du"], active_aorist["past"]["1du"], middle_aorist["past"]["1du"], passive_aorist["past"]["1du"], active_perfect["past"]["1du"], middle_perfect["past"]["1du"], active_future["past"]["1du"], middle_future["past"]["1du"], passive_future["past"]["1du"]],
            [active_present["past"]["2du"], middle_present["past"]["2du"], passive_present["past"]["2du"], active_aorist["past"]["2du"], middle_aorist["past"]["2du"], passive_aorist["past"]["2du"], active_perfect["past"]["2du"], middle_perfect["past"]["2du"], active_future["past"]["2du"], middle_future["past"]["2du"], passive_future["past"]["2du"]],
            [active_present["past"]["3du"], middle_present["past"]["3du"], passive_present["past"]["3du"], active_aorist["past"]["3du"], middle_aorist["past"]["3du"], passive_aorist["past"]["3du"], active_perfect["past"]["3du"], middle_perfect["past"]["3du"], active_future["past"]["3du"], middle_future["past"]["3du"], passive_future["past"]["3du"]],
            [active_present["past"]["1pl"], middle_present["past"]["1pl"], passive_present["past"]["1pl"], active_aorist["past"]["1pl"], middle_aorist["past"]["1pl"], passive_aorist["past"]["1pl"], active_perfect["past"]["1pl"], middle_perfect["past"]["1pl"], active_future["past"]["1pl"], middle_future["past"]["1pl"], passive_future["past"]["1pl"]],
            [active_present["past"]["2pl"], middle_present["past"]["2pl"], passive_present["past"]["2pl"], active_aorist["past"]["2pl"], middle_aorist["past"]["2pl"], passive_aorist["past"]["2pl"], active_perfect["past"]["2pl"], middle_perfect["past"]["2pl"], active_future["past"]["2pl"], middle_future["past"]["2pl"], passive_future["past"]["2pl"]],
            [active_present["past"]["3pl"], middle_present["past"]["3pl"], passive_present["past"]["3pl"], active_aorist["past"]["3pl"], middle_aorist["past"]["3pl"], passive_aorist["past"]["3pl"], active_perfect["past"]["3pl"], middle_perfect["past"]["3pl"], active_future["past"]["3pl"], middle_future["past"]["3pl"], passive_future["past"]["3pl"]],
            ["", "", "", "", "", "", "", "", "", "", ""],
            [active_present["injunc"]["1sg"], middle_present["injunc"]["1sg"], passive_present["injunc"]["1sg"], active_aorist["injunc"]["1sg"], middle_aorist["injunc"]["1sg"], passive_aorist["injunc"]["1sg"], active_perfect["injunc"]["1sg"], middle_perfect["injunc"]["1sg"], active_future["injunc"]["1sg"], middle_future["injunc"]["1sg"], passive_future["injunc"]["1sg"]],
            [active_present["injunc"]["2sg"], middle_present["injunc"]["2sg"], passive_present["injunc"]["2sg"], active_aorist["injunc"]["2sg"], middle_aorist["injunc"]["2sg"], passive_aorist["injunc"]["2sg"], active_perfect["injunc"]["2sg"], middle_perfect["injunc"]["2sg"], active_future["injunc"]["2sg"], middle_future["injunc"]["2sg"], passive_future["injunc"]["2sg"]],
            [active_present["injunc"]["3sg"], middle_present["injunc"]["3sg"], passive_present["injunc"]["3sg"], active_aorist["injunc"]["3sg"], middle_aorist["injunc"]["3sg"], passive_aorist["injunc"]["3sg"], active_perfect["injunc"]["3sg"], middle_perfect["injunc"]["3sg"], active_future["injunc"]["3sg"], middle_future["injunc"]["3sg"], passive_future["injunc"]["3sg"]],
            [active_present["injunc"]["1du"], middle_present["injunc"]["1du"], passive_present["injunc"]["1du"], active_aorist["injunc"]["1du"], middle_aorist["injunc"]["1du"], passive_aorist["injunc"]["1du"], active_perfect["injunc"]["1du"], middle_perfect["injunc"]["1du"], active_future["injunc"]["1du"], middle_future["injunc"]["1du"], passive_future["injunc"]["1du"]],
            [active_present["injunc"]["2du"], middle_present["injunc"]["2du"], passive_present["injunc"]["2du"], active_aorist["injunc"]["2du"], middle_aorist["injunc"]["2du"], passive_aorist["injunc"]["2du"], active_perfect["injunc"]["2du"], middle_perfect["injunc"]["2du"], active_future["injunc"]["2du"], middle_future["injunc"]["2du"], passive_future["injunc"]["2du"]],
            [active_present["injunc"]["3du"], middle_present["injunc"]["3du"], passive_present["injunc"]["3du"], active_aorist["injunc"]["3du"], middle_aorist["injunc"]["3du"], passive_aorist["injunc"]["3du"], active_perfect["injunc"]["3du"], middle_perfect["injunc"]["3du"], active_future["injunc"]["3du"], middle_future["injunc"]["3du"], passive_future["injunc"]["3du"]],
            [active_present["injunc"]["1pl"], middle_present["injunc"]["1pl"], passive_present["injunc"]["1pl"], active_aorist["injunc"]["1pl"], middle_aorist["injunc"]["1pl"], passive_aorist["injunc"]["1pl"], active_perfect["injunc"]["1pl"], middle_perfect["injunc"]["1pl"], active_future["injunc"]["1pl"], middle_future["injunc"]["1pl"], passive_future["injunc"]["1pl"]],
            [active_present["injunc"]["2pl"], middle_present["injunc"]["2pl"], passive_present["injunc"]["2pl"], active_aorist["injunc"]["2pl"], middle_aorist["injunc"]["2pl"], passive_aorist["injunc"]["2pl"], active_perfect["injunc"]["2pl"], middle_perfect["injunc"]["2pl"], active_future["injunc"]["2pl"], middle_future["injunc"]["2pl"], passive_future["injunc"]["2pl"]],
            [active_present["injunc"]["3pl"], middle_present["injunc"]["3pl"], passive_present["injunc"]["3pl"], active_aorist["injunc"]["3pl"], middle_aorist["injunc"]["3pl"], passive_aorist["injunc"]["3pl"], active_perfect["injunc"]["3pl"], middle_perfect["injunc"]["3pl"], active_future["injunc"]["3pl"], middle_future["injunc"]["3pl"], passive_future["injunc"]["3pl"]],
            ["", "", "", "", "", "", "", "", "", "", ""],
            [active_present["opt"]["1sg"], middle_present["opt"]["1sg"], passive_present["opt"]["1sg"], active_aorist["bend"]["1sg"], middle_aorist["bend"]["1sg"], passive_aorist["bend"]["1sg"], active_perfect["opt"]["1sg"], middle_perfect["opt"]["1sg"], active_future["opt"]["1sg"], middle_future["opt"]["1sg"], passive_future["opt"]["1sg"]],
            [active_present["opt"]["2sg"], middle_present["opt"]["2sg"], passive_present["opt"]["2sg"], active_aorist["bend"]["2sg"], middle_aorist["bend"]["2sg"], passive_aorist["bend"]["2sg"], active_perfect["opt"]["2sg"], middle_perfect["opt"]["2sg"], active_future["opt"]["2sg"], middle_future["opt"]["2sg"], passive_future["opt"]["2sg"]],
            [active_present["opt"]["3sg"], middle_present["opt"]["3sg"], passive_present["opt"]["3sg"], active_aorist["bend"]["3sg"], middle_aorist["bend"]["3sg"], passive_aorist["bend"]["3sg"], active_perfect["opt"]["3sg"], middle_perfect["opt"]["3sg"], active_future["opt"]["3sg"], middle_future["opt"]["3sg"], passive_future["opt"]["3sg"]],
            [active_present["opt"]["1du"], middle_present["opt"]["1du"], passive_present["opt"]["1du"], active_aorist["bend"]["1du"], middle_aorist["bend"]["1du"], passive_aorist["bend"]["1du"], active_perfect["opt"]["1du"], middle_perfect["opt"]["1du"], active_future["opt"]["1du"], middle_future["opt"]["1du"], passive_future["opt"]["1du"]],
            [active_present["opt"]["2du"], middle_present["opt"]["2du"], passive_present["opt"]["2du"], active_aorist["bend"]["2du"], middle_aorist["bend"]["2du"], passive_aorist["bend"]["2du"], active_perfect["opt"]["2du"], middle_perfect["opt"]["2du"], active_future["opt"]["2du"], middle_future["opt"]["2du"], passive_future["opt"]["2du"]],
            [active_present["opt"]["3du"], middle_present["opt"]["3du"], passive_present["opt"]["3du"], active_aorist["bend"]["3du"], middle_aorist["bend"]["3du"], passive_aorist["bend"]["3du"], active_perfect["opt"]["3du"], middle_perfect["opt"]["3du"], active_future["opt"]["3du"], middle_future["opt"]["3du"], passive_future["opt"]["3du"]],
            [active_present["opt"]["1pl"], middle_present["opt"]["1pl"], passive_present["opt"]["1pl"], active_aorist["bend"]["1pl"], middle_aorist["bend"]["1pl"], passive_aorist["bend"]["1pl"], active_perfect["opt"]["1pl"], middle_perfect["opt"]["1pl"], active_future["opt"]["1pl"], middle_future["opt"]["1pl"], passive_future["opt"]["1pl"]],
            [active_present["opt"]["2pl"], middle_present["opt"]["2pl"], passive_present["opt"]["2pl"], active_aorist["bend"]["2pl"], middle_aorist["bend"]["2pl"], passive_aorist["bend"]["2pl"], active_perfect["opt"]["2pl"], middle_perfect["opt"]["2pl"], active_future["opt"]["2pl"], middle_future["opt"]["2pl"], passive_future["opt"]["2pl"]],
            [active_present["opt"]["3pl"], middle_present["opt"]["3pl"], passive_present["opt"]["3pl"], active_aorist["bend"]["3pl"], middle_aorist["bend"]["3pl"], passive_aorist["bend"]["3pl"], active_perfect["opt"]["3pl"], middle_perfect["opt"]["3pl"], active_future["opt"]["3pl"], middle_future["opt"]["3pl"], passive_future["opt"]["3pl"]],
            ["", "", "", "", "", "", "", "", "", "", ""],
            [active_present["imper"]["1sg"], middle_present["imper"]["1sg"], passive_present["imper"]["1sg"], active_aorist["imper"]["1sg"], middle_aorist["imper"]["1sg"], passive_aorist["imper"]["1sg"], active_perfect["imper"]["1sg"], middle_perfect["imper"]["1sg"], active_future["imper"]["1sg"], middle_future["imper"]["1sg"], passive_future["imper"]["1sg"]],
            [active_present["imper"]["2sg"], middle_present["imper"]["2sg"], passive_present["imper"]["2sg"], active_aorist["imper"]["2sg"], middle_aorist["imper"]["2sg"], passive_aorist["imper"]["2sg"], active_perfect["imper"]["2sg"], middle_perfect["imper"]["2sg"], active_future["imper"]["2sg"], middle_future["imper"]["2sg"], passive_future["imper"]["2sg"]],
            [active_present["imper"]["3sg"], middle_present["imper"]["3sg"], passive_present["imper"]["3sg"], active_aorist["imper"]["3sg"], middle_aorist["imper"]["3sg"], passive_aorist["imper"]["3sg"], active_perfect["imper"]["3sg"], middle_perfect["imper"]["3sg"], active_future["imper"]["3sg"], middle_future["imper"]["3sg"], passive_future["imper"]["3sg"]],
            [active_present["imper"]["1du"], middle_present["imper"]["1du"], passive_present["imper"]["1du"], active_aorist["imper"]["1du"], middle_aorist["imper"]["1du"], passive_aorist["imper"]["1du"], active_perfect["imper"]["1du"], middle_perfect["imper"]["1du"], active_future["imper"]["1du"], middle_future["imper"]["1du"], passive_future["imper"]["1du"]],
            [active_present["imper"]["2du"], middle_present["imper"]["2du"], passive_present["imper"]["2du"], active_aorist["imper"]["2du"], middle_aorist["imper"]["2du"], passive_aorist["imper"]["2du"], active_perfect["imper"]["2du"], middle_perfect["imper"]["2du"], active_future["imper"]["2du"], middle_future["imper"]["2du"], passive_future["imper"]["2du"]],
            [active_present["imper"]["3du"], middle_present["imper"]["3du"], passive_present["imper"]["3du"], active_aorist["imper"]["3du"], middle_aorist["imper"]["3du"], passive_aorist["imper"]["3du"], active_perfect["imper"]["3du"], middle_perfect["imper"]["3du"], active_future["imper"]["3du"], middle_future["imper"]["3du"], passive_future["imper"]["3du"]],
            [active_present["imper"]["1pl"], middle_present["imper"]["1pl"], passive_present["imper"]["1pl"], active_aorist["imper"]["1pl"], middle_aorist["imper"]["1pl"], passive_aorist["imper"]["1pl"], active_perfect["imper"]["1pl"], middle_perfect["imper"]["1pl"], active_future["imper"]["1pl"], middle_future["imper"]["1pl"], passive_future["imper"]["1pl"]],
            [active_present["imper"]["2pl"], middle_present["imper"]["2pl"], passive_present["imper"]["2pl"], active_aorist["imper"]["2pl"], middle_aorist["imper"]["2pl"], passive_aorist["imper"]["2pl"], active_perfect["imper"]["2pl"], middle_perfect["imper"]["2pl"], active_future["imper"]["2pl"], middle_future["imper"]["2pl"], passive_future["imper"]["2pl"]],
            [active_present["imper"]["3pl"], middle_present["imper"]["3pl"], passive_present["imper"]["3pl"], active_aorist["imper"]["3pl"], middle_aorist["imper"]["3pl"], passive_aorist["imper"]["3pl"], active_perfect["imper"]["3pl"], middle_perfect["imper"]["3pl"], active_future["imper"]["3pl"], middle_future["imper"]["3pl"], passive_future["imper"]["3pl"]],
          ];

          // 行オブジェクトの取得
          var rows = $(table_id)[0].rows;
          // 各行をループ処理
          $.each(rows, function(i){
            // タイトル行は除外する。
            if(i <= 1){
              return true;
            } else if(i % 10 == 2){
              // 説明行も除外
              return true;
            }
            // 活用を挿入
            rows[i].cells[1].innerText = verb_table[i - 2][0];      // 進行相能動
            rows[i].cells[2].innerText = verb_table[i - 2][1];      // 進行相中動
            rows[i].cells[3].innerText = verb_table[i - 2][2];      // 進行相受動
            rows[i].cells[4].innerText = verb_table[i - 2][3];     // 完結相能動
            rows[i].cells[5].innerText = verb_table[i - 2][4];    // 完結相中動 
            rows[i].cells[6].innerText = verb_table[i - 2][5];    // 完結相受動
            rows[i].cells[7].innerText = verb_table[i - 2][6];    // 完了相能動
            rows[i].cells[8].innerText = verb_table[i - 2][7];    // 完了相受動             
            rows[i].cells[9].innerText = verb_table[i - 2][8];    // 未来形能動
            rows[i].cells[10].innerText = verb_table[i - 2][9];    // 未来形中動
            rows[i].cells[11].innerText = verb_table[i - 2][10];    // 未来形受動            
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
            ["", "", "", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", "", "", ""],
            [positive_masc_sg["nom"], positive_fem_sg["nom"], positive_neu_sg["nom"], positive_masc_du["nom"], positive_fem_du["nom"], positive_neu_du["nom"], positive_masc_pl["nom"], positive_fem_pl["nom"], positive_neu_pl["nom"]],
            [positive_masc_sg["gen"], positive_fem_sg["gen"], positive_neu_sg["gen"], positive_masc_du["gen"], positive_fem_du["gen"], positive_neu_du["gen"], positive_masc_pl["gen"], positive_fem_pl["gen"], positive_neu_pl["gen"]],
            [positive_masc_sg["dat"], positive_fem_sg["dat"], positive_neu_sg["dat"], positive_masc_du["dat"], positive_fem_du["dat"], positive_neu_du["dat"], positive_masc_pl["dat"], positive_fem_pl["dat"], positive_neu_pl["dat"]],
            [positive_masc_sg["acc"], positive_fem_sg["acc"], positive_neu_sg["acc"], positive_masc_du["acc"], positive_fem_du["acc"], positive_neu_du["acc"], positive_masc_pl["acc"], positive_fem_pl["acc"], positive_neu_pl["acc"]],
            [positive_masc_sg["abl"], positive_fem_sg["abl"], positive_neu_sg["abl"], positive_masc_du["abl"], positive_fem_du["abl"], positive_neu_du["abl"], positive_masc_pl["abl"], positive_fem_pl["abl"], positive_neu_pl["abl"]],
            [positive_masc_sg["ins"], positive_fem_sg["ins"], positive_neu_sg["ins"], positive_masc_du["ins"], positive_fem_du["ins"], positive_neu_du["ins"], positive_masc_pl["ins"], positive_fem_pl["ins"], positive_neu_pl["ins"]],            
            [positive_masc_sg["loc"], positive_fem_sg["loc"], positive_neu_sg["loc"], positive_masc_du["loc"], positive_fem_du["loc"], positive_neu_du["loc"], positive_masc_pl["loc"], positive_fem_pl["loc"], positive_neu_pl["loc"]],
            [positive_masc_sg["voc"], positive_fem_sg["voc"], positive_neu_sg["voc"], positive_masc_du["voc"], positive_fem_du["voc"], positive_neu_du["voc"], positive_masc_pl["voc"], positive_fem_pl["voc"], positive_neu_pl["voc"]],
            [positive_masc_sg["elative"], positive_fem_sg["elative"], positive_neu_sg["elative"], "", "", "", ""],
            [positive_masc_sg["inessive1"], positive_fem_sg["inessive1"], positive_neu_sg["inessive1"], "", "", "", ""],
            [positive_masc_sg["inessive2"], positive_fem_sg["inessive2"], positive_neu_sg["inessive2"], "", "", "", ""],  
            [positive_masc_sg["comitative"], positive_fem_sg["comitative"], positive_neu_sg["comitative"], "", "", "", ""],
            [positive_masc_sg["multiplicative"], positive_fem_sg["multiplicative"], positive_neu_sg["multiplicative"], "", "", "", ""],
            [positive_masc_sg["essive"], positive_fem_sg["essive"], positive_neu_sg["essive"], "", "", "", ""], 
            [positive_masc_sg["translative"], positive_fem_sg["translative"], positive_neu_sg["translative"], "", "", "", ""],
            [positive_masc_sg["temporal"], positive_fem_sg["temporal"], positive_neu_sg["temporal"], "", "", "", ""],
            [positive_masc_sg["illative"], positive_fem_sg["illative"], positive_neu_sg["illative"], "", "", "", ""],
            [positive_masc_sg["distributive"], positive_fem_sg["distributive"], positive_neu_sg["distributive"], "", "", "", ""],
            ["", "", "", "", "", "", ""],
            [comp_masc_sg["nom"], comp_fem_sg["nom"], comp_neu_sg["nom"], comp_masc_du["nom"], comp_fem_du["nom"], comp_neu_du["nom"], comp_masc_pl["nom"], comp_fem_pl["nom"], comp_neu_pl["nom"]],
            [comp_masc_sg["gen"], comp_fem_sg["gen"], comp_neu_sg["gen"], comp_masc_du["gen"], comp_fem_du["gen"], comp_neu_du["gen"], comp_masc_pl["gen"], comp_fem_pl["gen"], comp_neu_pl["gen"]],
            [comp_masc_sg["dat"], comp_fem_sg["dat"], comp_neu_sg["dat"], comp_masc_du["dat"], comp_fem_du["dat"], comp_neu_du["dat"], comp_masc_pl["dat"], comp_fem_pl["dat"], comp_neu_pl["dat"]],
            [comp_masc_sg["acc"], comp_fem_sg["acc"], comp_neu_sg["acc"], comp_masc_du["acc"], comp_fem_du["acc"], comp_neu_du["acc"], comp_masc_pl["acc"], comp_fem_pl["acc"], comp_neu_pl["acc"]],
            [comp_masc_sg["abl"], comp_fem_sg["abl"], comp_neu_sg["abl"], comp_masc_du["abl"], comp_fem_du["abl"], comp_neu_du["abl"], comp_masc_pl["abl"], comp_fem_pl["abl"], comp_neu_pl["abl"]],
            [comp_masc_sg["ins"], comp_fem_sg["ins"], comp_neu_sg["ins"], comp_masc_du["ins"], comp_fem_du["ins"], comp_neu_du["ins"], comp_masc_pl["ins"], comp_fem_pl["ins"], comp_neu_pl["ins"]],
            [comp_masc_sg["loc"], comp_fem_sg["loc"], comp_neu_sg["loc"], comp_masc_du["loc"], comp_fem_du["loc"], comp_neu_du["loc"], comp_masc_pl["loc"], comp_fem_pl["loc"], comp_neu_pl["loc"]],
            [comp_masc_sg["voc"], comp_fem_sg["voc"], comp_neu_sg["voc"], comp_masc_du["voc"], comp_fem_du["voc"], comp_neu_du["voc"], comp_masc_pl["voc"], comp_fem_pl["voc"], comp_neu_pl["voc"]],
            [comp_masc_sg["elative"], comp_fem_sg["elative"], comp_neu_sg["elative"], "", "", "", ""],
            [comp_masc_sg["inessive1"], comp_fem_sg["inessive1"], comp_neu_sg["inessive1"], "", "", "", ""],
            [comp_masc_sg["inessive2"], comp_fem_sg["inessive2"], comp_neu_sg["inessive2"], "", "", "", ""],  
            [comp_masc_sg["comitative"], comp_fem_sg["comitative"], comp_neu_sg["comitative"], "", "", "", ""],
            [comp_masc_sg["multiplicative"], comp_fem_sg["multiplicative"], comp_neu_sg["multiplicative"], "", "", "", ""],
            [comp_masc_sg["essive"], comp_fem_sg["essive"], comp_neu_sg["essive"], "", "", "", ""], 
            [comp_masc_sg["translative"], comp_fem_sg["translative"], comp_neu_sg["translative"], "", "", "", ""],
            [comp_masc_sg["temporal"], comp_fem_sg["temporal"], comp_neu_sg["temporal"], "", "", "", ""],
            [comp_masc_sg["illative"], comp_fem_sg["illative"], comp_neu_sg["illative"], "", "", "", ""],
            [comp_masc_sg["distributive"], comp_fem_sg["distributive"], comp_neu_sg["distributive"], "", "", "", ""],         
            ["", "", "", "", "", "", ""],
            [super_masc_sg["nom"], super_fem_sg["nom"], super_neu_sg["nom"], super_masc_du["nom"], super_fem_du["nom"], super_neu_du["nom"], super_masc_pl["nom"], super_fem_pl["nom"], super_neu_pl["nom"]],
            [super_masc_sg["gen"], super_fem_sg["gen"], super_neu_sg["gen"], super_masc_du["gen"], super_fem_du["gen"], super_neu_du["gen"], super_masc_pl["gen"], super_fem_pl["gen"], super_neu_pl["gen"]],
            [super_masc_sg["dat"], super_fem_sg["dat"], super_neu_sg["dat"], super_masc_du["dat"], super_fem_du["dat"], super_neu_du["dat"], super_masc_pl["dat"], super_fem_pl["dat"], super_neu_pl["dat"]],
            [super_masc_sg["acc"], super_fem_sg["acc"], super_neu_sg["acc"], super_masc_du["acc"], super_fem_du["acc"], super_neu_du["acc"], super_masc_pl["acc"], super_fem_pl["acc"], super_neu_pl["acc"]],
            [super_masc_sg["abl"], super_fem_sg["abl"], super_neu_sg["abl"], super_masc_du["abl"], super_fem_du["abl"], super_neu_du["abl"], super_masc_pl["abl"], super_fem_pl["abl"], super_neu_pl["abl"]],
            [super_masc_sg["ins"], super_fem_sg["ins"], super_neu_sg["ins"], super_masc_du["ins"], super_fem_du["ins"], super_neu_du["ins"], super_masc_pl["ins"], super_fem_pl["ins"], super_neu_pl["ins"]],            
            [super_masc_sg["loc"], super_fem_sg["loc"], super_neu_sg["loc"], super_masc_du["loc"], super_fem_du["loc"], super_neu_du["loc"], super_masc_pl["loc"], super_fem_pl["loc"], super_neu_pl["loc"]],
            [super_masc_sg["voc"], super_fem_sg["voc"], super_neu_sg["voc"], super_masc_du["voc"], super_fem_du["voc"], super_neu_du["voc"], super_masc_pl["voc"], super_fem_pl["voc"], super_neu_pl["voc"]],
            [super_masc_sg["elative"], super_fem_sg["elative"], super_neu_sg["elative"], "", "", "", ""],
            [super_masc_sg["inessive1"], super_fem_sg["inessive1"], super_neu_sg["inessive1"], "", "", "", ""],
            [super_masc_sg["inessive2"], super_fem_sg["inessive2"], super_neu_sg["inessive2"], "", "", "", ""],  
            [super_masc_sg["comitative"], super_fem_sg["comitative"], super_neu_sg["comitative"], "", "", "", ""],
            [super_masc_sg["multiplicative"], super_fem_sg["multiplicative"], super_neu_sg["multiplicative"], "", "", "", ""],
            [super_masc_sg["essive"], super_fem_sg["essive"], super_neu_sg["essive"], "", "", "", ""], 
            [super_masc_sg["translative"], super_fem_sg["translative"], super_neu_sg["translative"], "", "", "", ""],
            [super_masc_sg["temporal"], super_fem_sg["temporal"], super_neu_sg["temporal"], "", "", "", ""],
            [super_masc_sg["illative"], super_fem_sg["illative"], super_neu_sg["illative"], "", "", "", ""],
            [super_masc_sg["distributive"], super_fem_sg["distributive"], super_neu_sg["distributive"], "", "", "", ""],    
          ];        
          // 結果を返す。
          return adj_table;
        }

        // 不定詞をテーブル用に変換にする。
        function get_infinitive(table_data){

          // 格変化情報を取得
          var declension_sg = table_data["sg"];  //単数
          
          // 格納データを作成
          var infinitive_table = [
            [declension_sg["nom"]],
            [declension_sg["gen"]],
            [declension_sg["dat"]],
            [declension_sg["acc"]],
            [declension_sg["abl"]],
            [declension_sg["ins"]],            
            [declension_sg["loc"]],
            [declension_sg["voc"]],            
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
          return infinitive_table;
        }

        // 分詞・動形容詞をテーブルにセット
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
            for (let j = 0; j < infinitive_table.length; j++) {
              rows[i].cells[j + 1].innerText = infinitive_table[j][i - 1]; // 単数(1行目)
            }
          });
        }       

        // 分詞をセット
        function set_participle(json_participle, verb_type, table_id){

          // 各分詞を挿入
          var active_present = json_participle["present"]["active"]["participle"];            //能動態不完了体
          var middle_present = json_participle["present"]["middle"]["participle"];            //中動態不完了体
          var passive_present = json_participle["present"]["passive"]["participle"];          //受動態不完了体
          var active_perfect = json_participle["perfect"]["active"]["participle"];            //能動態完了形
          var middle_perfect = json_participle["perfect"]["mediopassive"]["participle"];      //中受動態完了形
          var active_future = json_participle["future"]["active"]["participle"];              //能動態未来形
          var middle_future = json_participle["future"]["middle"]["participle"];              //中動態未来形
          var passive_future = json_participle["future"]["passive"]["participle"];            //受動態未来形

          // 分詞
          var particple_table = [
            ["", "", "", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", "", "", ""],
          ];

          // 分詞を配列にして連結する。
          particple_table = particple_table.concat(get_adjective(active_present));     //能動態不完了体
          particple_table = particple_table.concat(get_adjective(middle_present));     //中動態不完了体
          particple_table = particple_table.concat(get_adjective(passive_present));    //受動態不完了体
          particple_table = particple_table.concat(get_adjective(active_perfect));     //能動態完了形
          particple_table = particple_table.concat(get_adjective(middle_perfect));     //中受動態完了形
          particple_table = particple_table.concat(get_adjective(active_future));      //能動態未来形
          particple_table = particple_table.concat(get_adjective(middle_future));      //中動態未来形
          particple_table = particple_table.concat(get_adjective(passive_future));     //受動態未来形

          // テーブルにセットする。
          set_adjective_to_table(table_id, particple_table);
        }

        // 分詞をテーブルにセット(派生動詞用)
        function set_socondary_participle(json_participle, verb_type, table_id){

          // 各分詞を挿入
          var active_present = json_participle["present"]["active"]["participle"];            //能動態不完了体
          var middle_present = json_participle["present"]["middle"]["participle"];            //中動態不完了体
          var passive_present = json_participle["present"]["passive"]["participle"];          //受動態不完了体
          var active_future = json_participle["future"]["active"]["participle"];              //能動態未来形
          var middle_future = json_participle["future"]["mediopassive"]["participle"];        //中動態未来形

          // 分詞
          var particple_table = [
            ["", "", "", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", "", "", ""],
          ];

          // 分詞を配列にして連結する。
          particple_table = particple_table.concat(get_adjective(active_present));     //能動態不完了体
          particple_table = particple_table.concat(get_adjective(middle_present));     //中動態不完了体
          particple_table = particple_table.concat(get_adjective(passive_present));    //受動態不完了体
          particple_table = particple_table.concat(get_adjective(active_future));      //能動態未来形
          particple_table = particple_table.concat(get_adjective(middle_future));      //中動態未来形

          // テーブルにセットする。
          set_adjective_to_table(table_id, particple_table);        
        }

        // 過去分詞をセット
        function set_past_particple(json_participle, verb_type, table_id){

          var active_ta_past = json_participle["past"]["active"]["ta-participle"];            //能動態ta過去形
          var active_na_past = json_participle["past"]["active"]["na-participle"];            //能動態na過去形
          var passive_ta_past = json_participle["past"]["passive"]["ta-participle"];           //受動態ta過去形
          var passive_na_past = json_participle["past"]["passive"]["na-participle"];           //受動態na過去形

          // 分詞
          var particple_table = [
            ["", "", "", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", "", "", ""],
          ];

          // 分詞を配列にして連結する。
          particple_table = particple_table.concat(get_adjective(passive_na_past));     //受動態na過去形         
          particple_table = particple_table.concat(get_adjective(passive_ta_past));     //受動態ta過去形
          particple_table = particple_table.concat(get_adjective(active_na_past));      //能動態na過去形      
          particple_table = particple_table.concat(get_adjective(active_ta_past));      //能動態ta過去形

          // テーブルにセットする。
          set_adjective_to_table(table_id, particple_table);
        }

        // 動形容詞をセット
        function set_primary_adjective_particple(json_participle, verb_type, table_id){

          var adjective_tavya = json_participle["adjective"]["tavya"];           //tavya
          var adjective_ya = json_participle["adjective"]["ya"];                 //ya
          var adjective_ta = json_participle["adjective"]["ta"];                //ta
          var adjective_aniya = json_participle["adjective"]["aniya"];          //anīya

          // 分詞
          var particple_table = [
            ["", "", "", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", "", "", ""],
          ];

          // 分詞を配列にして連結する。
          particple_table = particple_table.concat(get_adjective(adjective_tavya));      //tavya
          particple_table = particple_table.concat(get_adjective(adjective_ya));         //ya
          particple_table = particple_table.concat(get_adjective(adjective_ta));        //ta
          particple_table = particple_table.concat(get_adjective(adjective_aniya));     //anīya

          // テーブルにセットする。
          set_adjective_to_table(table_id, particple_table);
        }

        // 動形容詞をセット
        function set_secondary_adjective_particple(json_participle, verb_type, table_id){

          var adjective_tavya = json_participle["adjective"]["tavya"];           //tavya
          var adjective_ya = json_participle["adjective"]["ya"];                 //ya
          var adjective_aniya = json_participle["adjective"]["aniya"];          //anīya

          // 分詞
          var particple_table = [
            ["", "", "", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", "", "", ""],
          ];

          // 分詞を配列にして連結する。
          particple_table = particple_table.concat(get_adjective(adjective_tavya));      //tavya
          particple_table = particple_table.concat(get_adjective(adjective_ya));         //ya
          particple_table = particple_table.concat(get_adjective(adjective_aniya));      //anīya

          // テーブルにセットする。
          set_adjective_to_table(table_id, particple_table); 
        }

        // 不定詞
        function set_infinitive(table_data, verb_type, table_id){
          // JSONに書き換え
          var json_infinitive = table_data["infinitive"];

          // 初期化
          var infinitives = new Array();

          // 不定詞を挿入
          json_infinitive.forEach((infinitive) => {
            infinitives.push(get_infinitive(infinitive));
          });          

          // テーブルにセットする。
          set_infinitive_to_table(table_id, infinitives);
        }

        // 動詞ごとにテーブルを出力する。
        function verb_output_by_verb_type(verb_data, verb_type){
          // 一次動詞とそれ以外で場合分け
          if(verb_type == "primary"){
            // 動詞をテーブルに入れる。
            set_verb(verb_data, verb_type, '#' + verb_type + '-conjugation-table');   
            // 通常の分詞をテーブルを入れる。
            set_participle(verb_data, verb_type, '#' + verb_type + '-participle-table'); 
            // 動形容詞をテーブルに入れる。
            set_primary_adjective_particple(verb_data, verb_type, '#' + verb_type + '-verbal-adjective-table');
          } else if(verb_type == "causative"){
            // 使役動詞
            // 動詞をテーブルに入れる。
            set_verb(verb_data, verb_type, '#' + verb_type + '-conjugation-table');   
            // 通常の分詞をテーブルを入れる。
            set_participle(verb_data, verb_type, '#' + verb_type + '-participle-table'); 
            // 動形容詞をテーブルに入れる。
            set_secondary_adjective_particple(verb_data, verb_type, '#' + verb_type + '-verbal-adjective-table');
          } else if(verb_type.indexOf('causative') != -1 && verb_type.indexOf('causative') != 0){
            // 使役動詞
            // 動詞をテーブルに入れる。
            set_verb(verb_data, verb_type, '#' + verb_type + '-conjugation-table');   
            // 通常の分詞をテーブルを入れる。
            set_participle(verb_data, verb_type, '#' + verb_type + '-participle-table'); 
            // 動形容詞をテーブルに入れる。
            set_secondary_adjective_particple(verb_data, verb_type, '#' + verb_type + '-verbal-adjective-table');
          } else {
            // 二次動詞以降
            // 動詞をテーブルに入れる。
            set_verb(verb_data, verb_type, '#' + verb_type + '-conjugation-table');   
            // 通常の分詞をテーブルを入れる。
            set_socondary_participle(verb_data, verb_type, '#' + verb_type + '-participle-table'); 
            // 動形容詞をテーブルに入れる。
            set_secondary_adjective_particple(verb_data, verb_type, '#' + verb_type + '-verbal-adjective-table');
          }
          // 過去分詞をテーブルを入れる。
          set_past_particple(verb_data, verb_type, '#' + verb_type + '-past-participle-table');  
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
          Input_Botton.SanskritBotton('#input_verb');
          // 拡張表示ボタン
          Input_Botton.HiddenExtensionBotton();
          // 初期状態は拡張形式の表示を隠す。
          $(".table-extension").css("display", "none");
        }
        
    </script>
  <footer class="">
  </footer>
  </body>
</html>