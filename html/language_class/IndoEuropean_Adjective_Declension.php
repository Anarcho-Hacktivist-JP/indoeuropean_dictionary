<?php
session_start();
header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_adjective_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Sanskrit_Common.php");
include(dirname(__FILE__) . "/../language_class/Latin_Common.php");
include(dirname(__FILE__) . "/../language_class/Polish_Common.php");
include(dirname(__FILE__) . "/../language_class/Greek_Common.php");

// 梵語の検索
function search_sanskrit_declension($input_adjective, $case, $number, $gender, $grade){
    // 単語を検索
    $question_words = Sanskrit_Common::get_wordstem_from_DB($input_adjective, Sanskrit_Common::DB_ADJECTIVE);
    // 取得できない場合は
    if(!$question_words && Sanskrit_Common::is_alphabet_or_not($input_adjective)){
        // アルファベットの場合は単語を入れる。
        $word = $input_adjective; 
    } else {
        // 取得できた場合は結果を入れる。
        $word = $question_words[0];
    }
    // 読み込み
    $vedic_adjective = new Vedic_Adjective($word);
    // 結果を返す。
    return $vedic_adjective->get_declensioned_adjective($case, $number, $gender, $grade);
}

// ポーランド語の検索
function search_polish_declension($input_adjective, $case, $number, $gender, $grade){
    // 単語を検索
    $question_words = Polish_Common::get_wordstem_from_DB($input_adjective, Polish_Common::DB_ADJECTIVE);
    // 取得できない場合は
    if(!$question_words && Polish_Common::is_alphabet_or_not($input_adjective)){
        // アルファベットの場合は単語を入れる。
        $word = $input_adjective; 
    } else {
        // 取得できた場合は結果を入れる。
        $word = $question_words[0];
    }
    // 読み込み
    $polish_adjective = new Polish_Adjective($word);
    // 結果を返す。
    return $polish_adjective->get_declensioned_adjective($case, $number, $gender, $grade);
}

// ラテン語の検索
function search_latin_declension($input_adjective, $case, $number, $gender, $grade){
    // 単語を検索
    $question_words = Latin_Common::get_wordstem_from_DB($input_adjective, Latin_Common::DB_ADJECTIVE);
    // 取得できない場合は
    if(!$question_words && Latin_Common::is_alphabet_or_not($input_adjective)){
        // アルファベットの場合は単語を入れる。
        $word = $input_adjective; 
    } else {
        // 取得できた場合は結果を入れる。
        $word = $question_words[0];
    }
    // 読み込み
    $latin_adjective = new Latin_Adjective($word);
    // 結果を返す。
    return $latin_adjective->get_declensioned_adjective($case, $number, $gender, $grade);
}

// ギリシア語の検索
function search_greek_declension($input_adjective, $case, $number, $gender, $grade){
    // 単語を検索
    $question_words = Koine_Common::get_wordstem_from_DB($input_adjective, Koine_Common::DB_ADJECTIVE);
    // 取得できない場合は
    if(!$question_words && Koine_Common::is_alphabet_or_not($input_adjective)){
        // アルファベットの場合は単語を入れる。
        $word = $input_adjective; 
    } else {
        // 取得できた場合は結果を入れる。
        $word = $question_words[0];
    }
    // 読み込み
    $koine_adjective = new Koine_Adjective($word);
    // 結果を返す。
    return $koine_adjective->get_declensioned_adjective($case, $number, $gender, $grade);
}


// 挿入データ－言語－
$language = Commons::cut_words(trim($_POST['language']), 128);
// 挿入データ－対象－
$word = Commons::cut_words(trim($_POST['word']), 128);
// 挿入データ－性別－
$gender = Commons::cut_words(trim($_POST['gender']), 128);
// 挿入データ－数－
$number = Commons::cut_words(trim($_POST['number']), 32);
// 挿入データ－格－
$case = Commons::cut_words(trim($_POST['case']), 32);
// 挿入データ－級－
$grade = Commons::cut_words(trim($_POST['grade']), 32);

// 言語によって分ける。
if ($language == Commons::BONGO && $word != ""){
    $result = search_sanskrit_declension($word, $case, $number, $gender, $grade);
} else if($language == Commons::POLISH && $word != ""){
    $result = search_polish_declension($word, $case, $number, $gender, $grade);
} else if($language == Commons::LATIN && $word != ""){
    $result = search_latin_declension($word, $case, $number, $gender, $grade);
} else if($language == Commons::GREEK && $word != ""){
    $result = search_latin_declension($word, $case, $number, $gender, $grade);
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