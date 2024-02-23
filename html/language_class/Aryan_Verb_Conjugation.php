<?php
session_start();
header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_noun_class.php");
include(dirname(__FILE__) . "/../language_class/IndoEuropean_adjective_class.php");
include(dirname(__FILE__) . "/../language_class/IndoEuropean_verb_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Sanskrit_Common.php");

// 挿入データ－言語－
$language = Commons::cut_words(trim($_POST['language']), 128);
// 挿入データ－対象－
$word = Commons::cut_words(trim($_POST['word']), 128);
// 挿入データ－人称－
$person = Commons::cut_words(trim($_POST['person']), 32);
// 挿入データ－態－
$voice = Commons::cut_words(trim($_POST['voice']), 32);
// 挿入データ－相－
$aspect = Commons::cut_words(trim($_POST['aspect']), 32);
// 挿入データ－法－
$mood = Commons::cut_words(trim($_POST['mood']), 32);
// 挿入データ－動詞活用－
$verb_type = Commons::cut_words(trim($_POST['verb-type']), 32);

// 梵語動詞
function get_sanskrit_verb_conjugation($word, $person, $voice, $aspect, $mood, $verb_type){

    // 動詞の情報を語根から取得
    $vedic_verbs = Sanskrit_Common::get_root_from_root($word);
    // 取得できた場合は
    if($vedic_verbs){
        // 検索結果を検索
	    foreach ($vedic_verbs as $vedic_verb) {
            // 動詞活用と一致する場合は
            if ($vedic_verb["conjugation_present_type"] == $verb_type){
                // 結果を入れて上書きする。
                $word = $vedic_verb["dictionary_stem"];
            }
        }
    }
	// 読み込み
	$vedic_verb = new Vedic_Verb($word);
    // 結果を返す。
    return $vedic_verb->get_sanskrit_verb($person, $voice, $mood, $aspect, true);
}

// ギリシア語動詞
function get_koine_verb_conjugation($word, $person, $voice, $aspect, $mood){
    // 読み込み
    $koine_verb = new Koine_Verb($word);
    // 結果を返す。
    return $koine_verb->get_koine_verb($person, $voice, $mood, $aspect);
}

// 言語によって分ける。
if($language == Commons::BONGO && $word != ""){
    // 梵語
    $result = get_sanskrit_verb_conjugation($word, $person, $voice, $mood, $aspect, $verb_type);
} else if($language == Commons::GREEK && $word != ""){
    // ギリシア語
    $result = get_koine_verb_conjugation($word, $person, $voice, $mood, $aspect);
}

// ヘッダーを入れて出力
echo Commons::make_reply_header($result);

exit;