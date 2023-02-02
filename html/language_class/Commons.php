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
	public const PRESENT_ASPECT = "present";				// 進行相
	public const AORIST_ASPECT = "aorist";					// 完結相
	public const PERFECT_ASPECT = "perfect";				// 完了相
	public const PRESENT_TENSE = "present";					// 現在形
	public const PAST_TENSE = "past";						// 過去形
	public const FUTURE_TENSE = "future";					// 未来形
	public const ACTIVE_VOICE = "active";					// 能動態
	public const MEDIOPASSIVE_VOICE = "mediopassive";		// 中受動態	
	public const MIDDLE_VOICE = "middle";					// 中動態		
	public const PASSIVE_VOICE = "passive";					// 受動態	

	public const INDICATIVE = "ind";						// 直接法
	public const SUBJUNCTIVE = "subj";						// 接続法	
	public const OPTATIVE = "opt";							// 希求法
	public const IMPERATIVE = "imper";						// 命令法
	public const IMJUNCTIVE = "injunc";						// 指令法

	public const START_VERB = "inchorative";				// 始動動詞
	public const STRONG_VERB = "frequentive";				// 頻度動詞
	public const WANT_VERB = "desiderative";				// 願望動詞
	public const MAKE_VERB = "causative";					// 使役動詞
	public const NOUN_VERB = "denomitive";					// 名詞起源動詞
	public const INTENSE_VERB = "intensive";				// 強意動詞
	public const RESULTATIBE = "resultative";				// 結果動詞

	public const SINGULAR = "sg";							// 単数
	public const DUAL = "du";								// 双数
	public const PLURAL = "pl";								// 複数
	public const ANIMATE_GENDER = "masc";					// 男性
	public const ACTION_GENDER = "fem";						// 女性
	public const INANIMATE_GENDER = "neu";					// 中性

	public const NOMINATIVE = "nom";						// 主格
	public const GENETIVE = "gen";							// 属格
	public const DATIVE = "dat";							// 与格
	public const ACCUSATIVE = "acc";						// 対格
	public const ABLATIVE = "abl";							// 奪格
	public const INSTRUMENTAL = "ins";						// 具格
	public const LOCATIVE = "loc";							// 地格
	public const VOCATIVE = "voc";							// 呼格
	
	public const ADJ_GRADE_POSITIVE = "positive";			// 形容詞比較級 - 原級
	public const ADJ_GRADE_COMPERATIVE = "comp";			// 形容詞比較級 - 比較級
	public const ADJ_GRADE_SUPERATIVE = "super";			// 形容詞比較級 - 最上級

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

	// ギリシア文字に変換
	public static function latin_to_greek($sentence, $flag){

		// 古代文字フラグがONの場合は
		if($flag){
			// 古代文字
			$sentence = preg_replace("/w/u", "Ϝ", $sentence);
			$sentence = preg_replace("/st/u", "Ϛ", $sentence);
			$sentence = preg_replace("/h/u", "Ͱ", $sentence);
			$sentence = preg_replace("/kw/u", "ϙ", $sentence);
			$sentence = preg_replace("/q/u", "ϙ", $sentence);
			$sentence = preg_replace("/ss/u", "ϡ", $sentence);	
			$sentence = preg_replace("/sh/u", "ϸ", $sentence);		
		}

		// 気音対応
		$sentence = preg_replace("/th/u", "θ", $sentence);
		$sentence = preg_replace("/ph/u", "φ", $sentence);
		$sentence = preg_replace("/f/u", "φ", $sentence);
		$sentence = preg_replace("/kh/u", "χ", $sentence);
		$sentence = preg_replace("/h/u", "χ", $sentence);


		// 二重子音
		$sentence = preg_replace("/ps/u", "ψ", $sentence);
		$sentence = preg_replace("/ks/u", "ξ", $sentence);
		$sentence = preg_replace("/x/u", "ξ", $sentence);
		$sentence = preg_replace("/dz/u", "ζ", $sentence);

		// 二重母音
		$sentence = preg_replace("/au/u", "αυ", $sentence);
		$sentence = preg_replace("/eeu/u", "ηυ", $sentence);
		$sentence = preg_replace("/ēu/u", "ηυ", $sentence);
		$sentence = preg_replace("/eu/u", "ευ", $sentence);
		$sentence = preg_replace("/ou/u", "ου", $sentence);
		$sentence = preg_replace("/ui/u", "υι", $sentence);

		// 長音
		$sentence = preg_replace("/ee/u", "η", $sentence);
		$sentence = preg_replace("/ē/u", "η", $sentence);
		$sentence = preg_replace("/ō/u", "ω", $sentence);
		$sentence = preg_replace("/oo/u", "ω", $sentence);	

		// その他
		$sentence = preg_replace("/a/u", "α", $sentence);
		$sentence = preg_replace("/b/u", "β", $sentence);
		$sentence = preg_replace("/g/u", "γ", $sentence);
		$sentence = preg_replace("/d/u", "δ", $sentence);
		$sentence = preg_replace("/e/u", "ε", $sentence);
		$sentence = preg_replace("/z/u", "ζ", $sentence);
		$sentence = preg_replace("/i/u", "ι", $sentence);
		$sentence = preg_replace("/k/u", "κ", $sentence);
		$sentence = preg_replace("/l/u", "λ", $sentence);
		$sentence = preg_replace("/m/u", "μ", $sentence);
		$sentence = preg_replace("/n/u", "ν", $sentence);
		$sentence = preg_replace("/p/u", "π", $sentence);
		$sentence = preg_replace("/r/u", "ρ", $sentence);
		$sentence = preg_replace("/s$/u", "ς", $sentence);
		$sentence = preg_replace("/s/u", "σ", $sentence);
		$sentence = preg_replace("/t/u", "τ", $sentence);
		$sentence = preg_replace("/y/u", "υ", $sentence);

		// 結果を返す。
		return $sentence;
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

	// 英単語を分析する。
	public static function get_multiple_english_words_detail($check_words){
		// AIによる造語対応
		// 実行先を指定
		$command = "python3 /var/www/html/python/NLTK/NLTK.py 2>&1 $check_words";
		// 実行し、その結果を取得する。
		exec($command , $result);
		var_dump($result);
		// 結果を返す。
		return $result;
	} 

	// 曲用可能チェック
	public static function is_word_declensionable($word_category){
		// 結果を返す(名詞・形容詞はtrue)。
		return preg_match('(noun|adjective)', $word_category);
	}

	// 古形ボタンの生成
	public static function archaic_button(){

		// ボタンを生成
		$button_html_code = '
		<div class="d-grid gap-2 d-md-block">
			<input type="button" name="archaic" class="btn-check" id="btn-archaic-off" autocomplete="off" value="true">
			<label class="btn btn-primary" for="btn-archaic-off">古形を非表示</label>
			<input type="button" name="archaic" class="btn-check" id="btn-archaic-on" autocomplete="off" value="false">
			<label class="btn btn-primary" for="btn-archaic-on">古形を表示</label>
		</div>';

		// 結果を返す。
		return $button_html_code;
	}

	// 文法用語の変換関数
	public static function change_gramatical_words($word){

		// 用語変換
		switch($word){
			// 名詞・形容詞の格変化を日本語名に変換する。
			case self::NOMINATIVE:
				return "主格";
				break;
			case self::GENETIVE:
				return "属格";
				break;
			case self::DATIVE:
				return "与格";
				break;		
			case self::ACCUSATIVE:
				return "対格";
				break;
			case self::ABLATIVE:
				return "奪格";
				break;
			case self::INSTRUMENTAL:
				return "具格";
				break;
			case self::LOCATIVE:
				return "地格";
				break;	
			case self::VOCATIVE:
				return "呼格";
				break;
			// 名詞・形容詞・動詞の数を変換する。
			case self::SINGULAR:
				return "単数";
				break;
			case self::DUAL:
				return "双数";
				break;	
			case self::PLURAL:
				return "複数";
				break;
			// 形容詞・動詞の性別を変換する。
			case self::ANIMATE_GENDER:
				return "男性";
				break;
			case self::ACTION_GENDER:
				return "女性";
				break;	
			case self::INANIMATE_GENDER:
				return "中性";
				break;
			// 形容詞比較級を変換する。
			case self::ADJ_GRADE_POSITIVE:
				return "原級";
				break;
			case self::ADJ_GRADE_COMPERATIVE:
				return "比較級";
				break;	
			case self::ADJ_GRADE_SUPERATIVE:
				return "最上級";
				break;
			default:
				return "";
				break;
		}
	}

}

class Common_IE {
	public static $DB_NOUN = "";			// 名詞データベース名
	public static $DB_ADJECTIVE = "";		// 形容詞データベース名
	public static $DB_VERB = "";			// 動詞データベース名
	public static $DB_ADVERB = "";			// 副詞データベース名


	// 性別選択ボタンの生成
	public static function noun_gender_selection_button($all_flag = false){

		// ボタンを生成
		$button_html_code = '
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
		  </div>';

		// 全ての選択肢を入れる場合は、ボタンを追加
		if($all_flag){
			$button_html_code = $button_html_code.
			'<div class="col-md-3">
				<input type="radio" name="gender" class="btn-check" id="btn-all-gender" autocomplete="off" value="" checked="checked">
				<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-gender">すべて</label>
		  	 </div>';
		}

		// 結果を返す。
		return $button_html_code.'</section>';
	}

	// 性別選択ボタンの生成(検索用)
	public static function search_gender_selection_button(){
		// ボタンを生成
		return '
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
		 </div>';
	}


	// 性別選択ボタンの生成
	public static function adjective_gender_selection_button($all_flag = false){

		// ボタンを生成
		$button_html_code = '
		<h3>性別</h3>
		<section class="row">
		  <div class="col-md-3">
			<input type="radio" name="gender" class="btn-check" id="btn-masculine" autocomplete="off" value="'.Commons::ANIMATE_GENDER.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-masculine">男性</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="gender" class="btn-check" id="btn-femine" autocomplete="off" value="'.Commons::ACTION_GENDER.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-femine">女性</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="gender" class="btn-check" id="btn-neuter" autocomplete="off" value="'.Commons::INANIMATE_GENDER.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-neuter">中性</label>
		  </div>';
		
		// 全ての選択肢を入れる場合は、ボタンを追加
		if($all_flag){
			$button_html_code = $button_html_code.
			'<div class="col-md-3">
				<input type="radio" name="gender" class="btn-check" id="btn-all-gender" autocomplete="off" value="" checked="checked">
				<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-gender">すべて</label>
		  	 </div>';
		}

		// 結果を返す。
		return $button_html_code.'</section>';
	}	

	// 数選択ボタンの生成
	public static function number_selection_button($all_flag = false){

		// ボタンを生成
		$button_html_code = '
		<h3>数</h3>
		<section class="row">
		  <div class="col-md-3">
			<input type="radio" name="number" class="btn-check" id="btn-sg" autocomplete="off" value="'.Commons::SINGULAR.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-sg">単数</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="number" class="btn-check" id="btn-pl" autocomplete="off" value="'.Commons::PLURAL.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-pl">複数</label>
		  </div>';

		// 全ての選択肢を入れる場合は、ボタンを追加
		if($all_flag){
			$button_html_code = $button_html_code.
			'<div class="col-md-3">
				<input type="radio" name="number" class="btn-check" id="btn-all-number" autocomplete="off" value="" checked="checked">
				<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-number">すべて</label>
		  	 </div>';
		}

		// 結果を返す。
		return $button_html_code.'</section>';
	}

	// 人称ボタンの生成
	public static function person_selection_button($all_flag = false){
		// ボタンを生成
		$button_html_code = '
        <h3>人称</h3>
        <section class="row">
          <div class="col-md-3">
            <input type="radio" name="person" class="btn-check" id="btn-1sg" autocomplete="off" value="1sg" onclick="click_person_button()">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1sg">1人称単数</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="person" class="btn-check" id="btn-2sg" autocomplete="off" value="2sg" onclick="click_person_button()">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-2sg">2人称単数</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="person" class="btn-check" id="btn-3sg" autocomplete="off" value="3sg" onclick="click_person_button()">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3sg">3人称単数</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="person" class="btn-check" id="btn-1pl" autocomplete="off" value="1pl" onclick="click_person_button()">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1pl">1人称複数</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="person" class="btn-check" id="btn-2pl" autocomplete="off" value="2pl" onclick="click_person_button()">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-2pl">2人称複数</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="person" class="btn-check" id="btn-3pl" autocomplete="off" value="3pl" onclick="click_person_button()">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3pl">3人称複数</label>
          </div>';

		// 全ての選択肢を入れる場合は、ボタンを追加
		if($all_flag){
			$button_html_code = $button_html_code.
			'<div class="col-md-3">
            	<input type="radio" name="person" class="btn-check" id="btn-all-person" autocomplete="off" value="" checked="checked" onclick="click_person_button()">
            	<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-person">すべて</label>
         	 </div>';
		}

		// 結果を返す。
		return $button_html_code.'</section>';
	}

}



?>