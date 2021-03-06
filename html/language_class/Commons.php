<?php
header('Content-Type: text/html; charset=UTF-8');

require_once dirname(__FILE__) . "/php_others/parallel-for-master/autoload.php";

function longtime($item) {
    return $item . ".";
};

$executor = function($data) {
    $results = array();
    foreach($data as $item) {
        $results[] = $item;
    }
    return $results;
};

// 共通クラス
class Commons {

	public static $NO_RESULT = "該当なし";				//該当なし

	public static $LIKE_MARK = 	"+";					// 曖昧検索符号

	public static $TRUE = "1";		//trueフラグ
	public static $FALSE = "0";		//falseフラグ


	// 用語集
	public static $PRESENT_ASPECT = "present";				// 進行相
	public static $AORIST_ASPECT = "aorist";				// 完結相
	public static $PERFECT_ASPECT = "perfect";				// 完了相
	public static $PRESENT_TENSE = "present";				// 現在形
	public static $PAST_TENSE = "past";						// 過去形
	public static $FUTURE_TENSE = "future";					// 未来形
	public static $ACTIVE_VOICE = "active";					// 能動態
	public static $MEDIOPASSIVE_VOICE = "mediopassive";		// 中受動態	
	public static $MIDDLE_VOICE = "middle";					// 中動態		
	public static $PASSIVE_VOICE = "passive";				// 受動態	

	public static $INDICATIVE = "ind";						// 直接法
	public static $SUBJUNCTIVE = "subj";					// 接続法	
	public static $OPTATIVE = "opt";						// 希求法
	public static $IMPERATIVE = "imper";					// 命令法

	public static $START_VERB = "inchorative";				// 始動動詞
	public static $STRONG_VERB = "frequentive";				// 頻度動詞
	public static $WANT_VERB = "desiderative";				// 願望動詞
	public static $MAKE_VERB = "causative";					// 使役動詞

	public static $SINGULAR = "sg";							// 単数
	public static $DUAL = "du";								// 双数
	public static $PLURAL = "pl";							// 複数
	public static $MASCULINE_GENDER = "masc";				// 男性
	public static $FEMINE_GENDER = "fem";					// 女性
	public static $NEUTER_GENDER = "neu";					// 中性

	public static $NOMINATIVE = "nom";						// 主格
	public static $GENETIVE = "gen";						// 属格
	public static $DATIVE = "dat";							// 与格
	public static $ACCUSATIVE = "acc";						// 対格
	public static $ABLATIVE = "abl";						// 奪格
	public static $INSTRUMENTAL = "ins";					// 具格
	public static $LOCATIVE = "loc";						// 地格
	public static $VOCATIVE = "voc";						// 呼格
	
	public static $ADJ_GRADE_POSITIVE = "positive";			// 形容詞比較級 - 原級
	public static $ADJ_GRADE_COMPERATIVE = "comp";			// 形容詞比較級 - 比較級
	public static $ADJ_GRADE_SUPERATIVE = "super";			// 形容詞比較級 - 最上級

	// 長音変換
	public static function vowel_short_to_long($sound){

		// 不正コード対策
		$sound = Commons::cut_words($sound, 1);

		// 変換処理
		if($sound == "a"){
			$sound = "ā";
		} else if($sound == "i"){
			$sound = "ī";
		} else if($sound == "u"){
			$sound = "ū";
		} else if($sound == "e"){
			$sound = "ē";
		} else if($sound == "o"){
			$sound = "ō";
		}
		// 結果を返す。
		return $sound;
	}
	
	// 短音変換
	public static function vowel_long_to_short($sound){	

		// 不正コード対策
		$sound = Commons::cut_words($sound, 1);

		// 変換処理
		if($sound == "ā"){
			$sound = "a";
		} else if($sound == "ī"){
			$sound = "i";
		} else if($sound == "ū"){
			$sound = "u";
		} else if($sound == "ē"){
			$sound = "e";
		} else if($sound == "ō"){
			$sound = "o";
		}
		// 結果を返す。
		return $sound;
	}

	// 母音チェック
	public static function is_vowel_or_not($sound){	

		// 不正コード対策
		$sound = Commons::cut_words($sound, 1);

		// 変換処理
		if($sound == "ā" || $sound == "ī" || $sound == "ū" || $sound == "ē" || $sound == "ō" || $sound == "ȳ" ||
		   $sound == "a" || $sound == "i" || $sound == "u" || $sound == "e" || $sound == "o" || $sound == "y" ||
		   $sound == "á" || $sound == "í" || $sound == "ú" || $sound == "é" || $sound == "ó" || $sound == "ý" ||
		   $sound == "à" || $sound == "ì" || $sound == "ù" || $sound == "è" || $sound == "ò" ||
		   $sound == "â" || $sound == "î" || $sound == "û" || $sound == "ê" || $sound == "ô"
		   ){
			return true;
		}
		// 結果を返す。
		return false;
	}

	// 最大文字数制限
	public static function cut_words($sentence, $length){
		// 不正コード対策
		$sentence = htmlspecialchars($sentence);	
		// 結果を返す。
		return strval(mb_substr($sentence, 0, $length));
	}

	// 複合語の配列を変換する。
	public static function convert_compound_array($janome_result){
		// 配列に詰め替え
		$input_words = array();	// 初期化
		foreach ($janome_result as $janome_word) {
			// 配列化
			$input_word = explode(" ", $janome_word);
			// 配列に格納
			array_push($input_words, $input_word);
		}

		// 結果を返す。
		return $input_words;
	}

	// 選択オプションを作る。
	public static function select_option($word_tables){
		// optionのhtmlを格納する文字変数
		$optional_html_code = "";
	  	// 配列からタイトル名と辞書見出しを入れる。
	  	foreach ($word_tables as $word_table) {
	  	// optionコードを格納する。
	  	$optional_html_code = $optional_html_code.
							'<option value="'.$word_table['dic_title'].'">'.
							  $word_table['title'].
							'</option>'; 
		}
  
		// 結果を返す。
		return $optional_html_code;
  	}
	  
	// 単語を分析する。
	public static function get_multiple_words_detail($check_words){
		// AIによる造語対応
		// 実行先を指定
		$command = "python3 /var/www/html/python/janome/janome_example.py $check_words";
		// 実行し、その結果を取得する。
		exec($command , $result);
		var_dump($result);
		// 結果を返す。
		return $result;
	} 

}

class Common_IE {
	public static $DB_NOUN = "";			// 名詞データベース名
	public static $DB_ADJECTIVE = "";		// 形容詞データベース名
	public static $DB_VERB = "";			// 動詞データベース名
	public static $DB_ADVERB = "";			// 副詞データベース名


	// 性別選択ボタンの生成
	public static function noun_gender_selection_button(){
		return '
		<h3>性別</h3>
		<section class="row">
		  <div class="col-md-3">
			<input type="radio" name="gender" class="btn-check" id="btn-masculine" autocomplete="off" value="Masculine">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-masculine">男性</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="gender" class="btn-check" id="btn-femine" autocomplete="off" value="Feminine">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-femine">女性</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="gender" class="btn-check" id="btn-neuter" autocomplete="off" value="Neuter">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-neuter">中性</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="gender" class="btn-check" id="btn-all-gender" autocomplete="off" value="" checked="checked">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-gender">すべて</label>
		  </div>
		</section>';
	}

	// 性別選択ボタンの生成
	public static function adjective_gender_selection_button(){
		return '
		<h3>性別</h3>
		<section class="row">
		  <div class="col-md-3">
			<input type="radio" name="gender" class="btn-check" id="btn-masculine" autocomplete="off" value="'.Commons::$MASCULINE_GENDER.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-masculine">男性</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="gender" class="btn-check" id="btn-femine" autocomplete="off" value="'.Commons::$FEMINE_GENDER.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-femine">女性</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="gender" class="btn-check" id="btn-neuter" autocomplete="off" value="'.Commons::$NEUTER_GENDER.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-neuter">中性</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="gender" class="btn-check" id="btn-all-gender" autocomplete="off" value="" checked="checked">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-gender">すべて</label>
		  </div>
		</section>';
	}	

	// 数選択ボタンの生成
	public static function number_selection_button(){
		return '
		<h3>数</h3>
		<section class="row">
		  <div class="col-md-3">
			<input type="radio" name="number" class="btn-check" id="btn-sg" autocomplete="off" value="'.Commons::$SINGULAR.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-sg">単数</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="number" class="btn-check" id="btn-du" autocomplete="off" value="'.Commons::$DUAL.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-du">双数</label>
		  </div>		  
		  <div class="col-md-3">
			<input type="radio" name="number" class="btn-check" id="btn-pl" autocomplete="off" value="'.Commons::$PLURAL.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-pl">複数</label>
		  </div>              
		  <div class="col-md-3">
			<input type="radio" name="number" class="btn-check" id="btn-all-number" autocomplete="off" value="" checked="checked">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-number">すべて</label>
		  </div>
		</section>';
	}

}



?>