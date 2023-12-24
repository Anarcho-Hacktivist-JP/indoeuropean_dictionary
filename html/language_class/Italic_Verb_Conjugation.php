<?php
session_start();
header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_noun_class.php");
include(dirname(__FILE__) . "/../language_class/IndoEuropean_adjective_class.php");
include(dirname(__FILE__) . "/../language_class/IndoEuropean_verb_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Latin_Common.php");

// ラテン語の検索
function search_latin_conjugation($input_verb, $person, $voice, $mood, $aspect, $tense){

	// 動詞の情報を取得
	$latin_verb = Latin_Common::get_verb_from_DB($input_verb)[0];

	// 活用種別で分ける。
	if($latin_verb["verb_type"] == "5sum"){
	    // 読み込み
	    $verb_data = new Latin_Verb_Sum();
    	$verb_data->add_stem($latin_verb["infinitive_stem"]);
    } else if($latin_verb["verb_type"] == "5volo"){
	    // 読み込み
	    $verb_data = new Latin_Verb_Volo();
    	$verb_data->add_stem($latin_verb["infinitive_stem"]);
    } else if($latin_verb["verb_type"] == "5fer"){
    	// 読み込み
    	$verb_data = new Latin_Verb_Fero();
     	$verb_data->add_stem($latin_verb["infinitive_stem"]);
    } else if($latin_verb["verb_type"] == "5eo"){
    	// 読み込み
    	$verb_data = new Latin_Verb_Eo();
    	$verb_data->add_stem($latin_verb["infinitive_stem"]);
    } else {
	    // 読み込み
	    $verb_data = new Latin_Verb($latin_verb["infinitive_stem"], "");
    }

    // 結果を返す。
    return $verb_data->get_latin_verb($person, $voice, $mood, $aspect, $tense);
}

// 挿入データ－言語－
$language = Commons::cut_words(trim($_POST['language']), 128);
// 挿入データ－対象－
$word = Commons::cut_words(trim($_POST['word']), 128);
// 挿入データ－人称－
$person = Commons::cut_words(trim($_POST['person']), 128);
// 挿入データ－態－
$voice = Commons::cut_words(trim($_POST['voice']), 128);
// 挿入データ－相－
$aspect = Commons::cut_words(trim($_POST['aspect']), 128);
// 挿入データ－時制－
$tense = Commons::cut_words(trim($_POST['tense']), 128);
// 挿入データ－法－
$mood = Commons::cut_words(trim($_POST['mood']), 128);

// 言語によって分ける。
if($language == Commons::LATIN && $word != ""){
    // ラテン語
    $result = search_latin_conjugation($word, $person, $voice, $mood, $aspect, $tense);
}

// ヘッダーを作成
header("Content-type: application/json; charset=UTF-8");
// 送信データを作成
$list = [
    "result" => $result,
];
// 送信
echo json_encode($list);
exit;