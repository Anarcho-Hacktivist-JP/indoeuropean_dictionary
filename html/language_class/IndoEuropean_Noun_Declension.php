<?php
session_start();
header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_noun_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Sanskrit_Common.php");
include(dirname(__FILE__) . "/../language_class/Latin_Common.php");
include(dirname(__FILE__) . "/../language_class/Polish_Common.php");
include(dirname(__FILE__) . "/../language_class/Greek_Common.php");

// 梵語の検索
function search_sanskrit_declension($input_noun, $case, $number){
    // 単語を検索
    $question_words = Sanskrit_Common::get_wordstem_from_DB($input_noun, Sanskrit_Common::DB_NOUN);
    // 取得できない場合は
    if(!$question_words && Sanskrit_Common::is_alphabet_or_not($input_noun)){
        // アルファベットの場合は単語を入れる。
        $word = $input_noun; 
    } else {
        // 取得できた場合は結果を入れる。
        $word = $question_words[0];
    }
    // 読み込み
    $vedic_noun = new Vedic_Noun($word);
    // 結果を返す。
    return $vedic_noun->get_declensioned_noun($case, $number);
}

// ポーランド語の検索
function search_polish_declension($input_noun, $case, $number){
    // 単語を検索
    $question_words = Polish_Common::get_wordstem_from_DB($input_noun, Polish_Common::DB_NOUN);
    // 取得できない場合は
    if(!$question_words && Polish_Common::is_alphabet_or_not($input_noun)){
        // アルファベットの場合は単語を入れる。
        $word = $input_noun; 
    } else {
        // 取得できた場合は結果を入れる。
        $word = $question_words[0];
    }

    // 読み込み
    $polish_noun = new Polish_Noun($word);
    // 結果を返す。
    return $polish_noun->get_declensioned_noun($case, $number);
}

// ラテン語の検索
function search_latin_declension($input_noun, $case, $number){
    // 単語を検索
    $question_words = Latin_Common::get_wordstem_from_DB($input_noun, Latin_Common::DB_NOUN);
    // 取得できない場合は
    if(!$question_words && Latin_Common::is_alphabet_or_not($input_noun)){
        // アルファベットの場合は単語を入れる。
        $word = $input_noun; 
    } else {
        // 取得できた場合は結果を入れる。
        $word = $question_words[0];
    }

    // 読み込み
    $latin_noun = new Latin_Noun($word);
    // 結果を返す。
    return $latin_noun->get_declensioned_noun($case, $number);
}

// ギリシア語の検索
function search_greek_declension($input_noun, $case, $number){
    // 単語を検索
    $question_words = Koine_Common::get_wordstem_from_DB($input_noun, Koine_Common::DB_NOUN);
    // 取得できない場合は
    if(!$question_words && Latin_Common::is_alphabet_or_not($input_noun)){
        // アルファベットの場合は単語を入れる。
        $word = $input_noun; 
    } else {
        // 取得できた場合は結果を入れる。
        $word = $question_words[0];
    }
    // 読み込み
    $koine_noun = new Koine_Noun($word);
    // 結果を返す。
    return $koine_noun->get_declensioned_noun($case, $number);
}

// 挿入データ－言語－
$language = Commons::cut_words(trim($_POST['language']), 128);
// 挿入データ－対象－
$word = Commons::cut_words(trim($_POST['word']), 128);
// 挿入データ－数－
$number = Commons::cut_words(trim($_POST['number']), 32);
// 挿入データ－格－
$case = Commons::cut_words(trim($_POST['case']), 32);

// 言語によって分ける。
if ($language == Commons::BONGO && $word != ""){
    $result = search_sanskrit_declension($word, $case, $number);
} else if($language == Commons::POLISH && $word != ""){
    $result = search_polish_declension($word, $case, $number);
} else if($language == Commons::LATIN && $word != ""){
    $result = search_latin_declension($word, $case, $number);
} else if($language == Commons::GREEK && $word != ""){
    $result = search_greek_declension($word, $case, $number);
} else {
    $result = "指定なし";
}

header("Content-type: application/json; charset=UTF-8");
// 送信データを作成
$list = [
    "result" => $result,
];
// 送信
echo json_encode($list);

exit;