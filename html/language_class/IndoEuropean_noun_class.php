<?php
// インドヨーロッパ語共通名詞クラス
class Noun_Common_IE {

	// 格語尾リスト
	protected $case_suffix_list =  [
		[
			"noun_type" => "vowel",
			"noun_type_name" => "母音活用",				
			"gender" => "Masculine/Feminine/Neuter",
			"sg_nom" => "s",
			"sg_gen" => "osya",
			"sg_dat" => "ōy",
			"sg_acc" => "om",
			"sg_abl" => "od",
			"sg_ins" => "oh",
			"sg_loc" => "oy",
			"sg_voc" => "",
			"du_nom" => "oh",
			"du_gen" => "oyows",
			"du_dat" => "-",
			"du_acc" => "oh",
			"du_abl" => "-",
			"du_ins" => "-",
			"du_loc" => "oyows",
			"du_voc" => "oh",
			"pl_nom" => "ōs",
			"pl_gen" => "ōm",
			"pl_dat" => "omos",
			"pl_acc" => "oms",
			"pl_abl" => "omos",
			"pl_ins" => "ōys",			
			"pl_loc" => "osu",
			"pl_voc" => "ōs"
		],
		[
			"noun_type" => "consonant",
			"noun_type_name" => "子音活用",			
			"gender" => "Masculine/Feminine/Neuter",
			"sg_nom" => "s",
			"sg_gen" => "osya",
			"sg_dat" => "ōy",
			"sg_acc" => "om",
			"sg_abl" => "od",
			"sg_ins" => "oh",
			"sg_loc" => "oy",
			"sg_voc" => "",
			"du_nom" => "oh",
			"du_gen" => "oyows",
			"du_dat" => "-",
			"du_acc" => "oh",
			"du_abl" => "-",
			"du_ins" => "-",
			"du_loc" => "oyows",
			"du_voc" => "oh",
			"pl_nom" => "ōs",
			"pl_gen" => "ōm",
			"pl_dat" => "omos",
			"pl_acc" => "oms",
			"pl_abl" => "omos",
			"pl_ins" => "ōys",			
			"pl_loc" => "osu",
			"pl_voc" => "ōs"
		],
	];

	// 第一語幹
	protected $first_stem = "";

	// 第二語幹
	protected $second_stem = "";
	
	// 第三語幹
	protected $third_stem = "";
	
	// 性別
	protected $gender = "";
	
	// 活用種別
	protected $noun_type = "";

	// 活用種別名称
	protected $noun_type_name = "";

	// 単数なしフラグ
	protected $deponent_singular = "";

	// 複数なしフラグ
	protected $deponent_plural = "";	

	// 格語尾
	protected $case_suffix = 
	[
		"sg" => 
		[
			"nom" => "",
			"gen" => "",
			"dat" => "",
			"acc" => "",
			"abl" => "",
			"ins" => "",
			"loc" => "",
			"voc" => "",
		],
		"du" => 
		[
			"nom" => "",
			"gen" => "",
			"dat" => "",
			"acc" => "",
			"abl" => "",
			"ins" => "",
			"loc" => "",
			"voc" => "",
		],
		"pl" => 
		[
			"nom" => "",
			"gen" => "",
			"dat" => "",
			"acc" => "",
			"abl" => "",
			"ins" => "",
			"loc" => "",
			"voc" => "",
		],		
	];

	// 性別定数
	protected const PIE_ANIMATE = "Masculine";		// 男性
	protected const PIE_INANIMATE = "Neuter";		// 中性
	protected const PIE_ACTION = "Feminine";		// 女性


    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    function __construct1($noun)
    {
		// 名詞情報をセット
		$this->set_data($noun);
		// 活用表を挿入
		$this->get_noun_declension();
    }
    
    // 名詞情報取得
	protected function get_noun_from_DB($noun, $table){
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `".$table."` WHERE `dictionary_stem` = '".$noun."'";
		// SQLを実行
		$stmt = $db_host->query($query);

		// 結果が取得できたら、
		if($stmt){
			// 連想配列に整形して返す。
			return $stmt->fetch(PDO::FETCH_BOTH);
		} else {
			return null;
		}
	}
	
    // 名詞情報を取得
    private function set_data($noun){
    	// 名詞情報を取得
		$database_info = $this->get_noun_from_DB($noun, "noun_pie", false);
		// データがある場合は
		if($database_info){
			// データを挿入
			$this->first_stem = $database_info["first_stem"];							//第一語幹
			$this->third_stem = mb_substr($database_info["third_stem"], 0, -1);	//第三語幹
			$this->gender = $database_info["gender"];								//性別
			$this->noun_type = $database_info["noun_type"];							//名詞タイプ
		}
    }

	// 名詞の格変化を取得する。
	protected function get_noun_case_suffix($noun_type, $gender){
		// 全ての接尾辞リストを参照
		foreach ($this->case_suffix_list as $case_suffix) {
			//　曲用種別と性別が一致する場合は
			if($case_suffix["noun_type"] == $noun_type && 
			   strpos($case_suffix["gender"], $gender) !== false){
				// 結果を返す
				return $case_suffix;
			}
		}
		
		//取得できない場合はnull
		return null;
	}	
    
    // 活用表セット
    private function get_noun_declension(){

		// 初期化
		$declension = array();
		// 全ての接尾辞リストを参照
		$declension = $this->get_noun_case_suffix($this->noun_type, $this->gender);

		// 活用表を挿入
		// 単数
		$this->case_suffix[Commons::SINGULAR][Commons::NOMINATIVE] = $declension["sg_nom"];
		$this->case_suffix[Commons::SINGULAR][Commons::GENETIVE] = $declension["sg_gen"];
		$this->case_suffix[Commons::SINGULAR][Commons::DATIVE] = $declension["sg_dat"];
		$this->case_suffix[Commons::SINGULAR][Commons::ACCUSATIVE] = $declension["sg_acc"];
		$this->case_suffix[Commons::SINGULAR][Commons::ABLATIVE] = $declension["sg_abl"];
		$this->case_suffix[Commons::SINGULAR][Commons::INSTRUMENTAL] = $declension["sg_ins"];
		$this->case_suffix[Commons::SINGULAR][Commons::LOCATIVE] = $declension["sg_loc"];
		$this->case_suffix[Commons::SINGULAR][Commons::VOCATIVE] = $declension["sg_voc"];
		
		// 双数
		$this->case_suffix[Commons::DUAL][Commons::NOMINATIVE] = $declension["du_nom"];
		$this->case_suffix[Commons::DUAL][Commons::GENETIVE] = $declension["du_gen"];
		$this->case_suffix[Commons::DUAL][Commons::DATIVE] = $declension["du_dat"];
		$this->case_suffix[Commons::DUAL][Commons::ACCUSATIVE] = $declension["du_acc"];
		$this->case_suffix[Commons::DUAL][Commons::ABLATIVE] = $declension["du_abl"];
		$this->case_suffix[Commons::DUAL][Commons::INSTRUMENTAL] = $declension["du_ins"];
		$this->case_suffix[Commons::DUAL][Commons::LOCATIVE] = $declension["du_loc"];
		$this->case_suffix[Commons::DUAL][Commons::VOCATIVE] = $declension["du_voc"];
		
		// 複数
		$this->case_suffix[Commons::PLURAL][Commons::NOMINATIVE] = $declension["pl_nom"];
		$this->case_suffix[Commons::PLURAL][Commons::GENETIVE] = $declension["pl_gen"];
		$this->case_suffix[Commons::PLURAL][Commons::DATIVE] = $declension["pl_dat"];
		$this->case_suffix[Commons::PLURAL][Commons::ACCUSATIVE] = $declension["pl_acc"];
		$this->case_suffix[Commons::PLURAL][Commons::ABLATIVE] = $declension["pl_abl"];
		$this->case_suffix[Commons::PLURAL][Commons::INSTRUMENTAL] = $declension["pl_ins"];
		$this->case_suffix[Commons::PLURAL][Commons::LOCATIVE] = $declension["pl_loc"];
		$this->case_suffix[Commons::PLURAL][Commons::VOCATIVE] = $declension["pl_voc"];

		// 活用種別名
		$this->noun_type_name = $declension["noun_type_name"];
    }
	
	// 名詞作成
	public function get_declensioned_noun($case, $number){
		// 格語尾を取得
		$case_suffix = null;
		//曲用語尾を取得
		$case_suffix = $this->case_suffix[$number][$case];
		
		// 名詞と結合
		if($case == Commons::NOMINATIVE || $case == Commons::VOCATIVE || $case == Commons::ACCUSATIVE){
			// 第一語幹の場合
			$noun = $this->first_stem.$case_suffix;
		} else {
			// 第三語幹の場合
			$noun = $this->third_stem.$case_suffix;
		}
		
		// 結果を返す
		return $noun;
	}

	// 性別の名称を返す
	public function get_gender_name(){
		// 名称に応じて分ける。
		if($this->gender == self::PIE_ANIMATE){			
			return "男性";
		} else if($this->gender == self::PIE_ACTION){		
			return "女性";
		} else if($this->gender == self::PIE_INANIMATE){
			return "中性";
		} else if($this->gender == "Masculine/Feminine" || $this->gender == "Feminine/Masculine"){						
			return "男性/女性";
		} else if($this->gender == "Masculine/Neuter"){
			return "男性/中性";
		} else if($this->gender == "Masculine/Feminine/Neuter"){
			return "男性/女性/中性";
		} else if($this->gender == "Masculine-Animate"){
			return "男性-生物";
		} else if($this->gender == "Masculine-Inanimate"){
			return "男性-無生物";				
		} else {
			return "なし";
		}
	}

    // 名詞のタイトルを取得
    public function get_noun_title(){

    	// タイトルを作る
    	$noun_title = "名詞  ".$this->first_stem;

		// 英語訳がある場合は
		if ($this->english_translation != ""){
			// 訳を入れる。
			$noun_title = $noun_title." 英語：".$this->english_translation."、";
		}
		
		// 日本語訳がある場合は
		if ($this->japanese_translation != ""){
			// 訳を入れる。
			$noun_title = $noun_title." 日本語：".$this->japanese_translation;
		}

    	// 結果を返す。
    	return " 性別：".$this->get_gender_name()."、 ".$this->noun_type_name."  ".$noun_title;
    }

	// 曲用表を作成
	protected function make_noun_declension($word_chart){
		// 格変化配列
		$case_array = array(Commons::NOMINATIVE, Commons::GENETIVE, Commons::DATIVE, Commons::ACCUSATIVE, Commons::ABLATIVE, Commons::INSTRUMENTAL, Commons::LOCATIVE, Commons::VOCATIVE);
		// 数配列
		$number_array = array(Commons::SINGULAR, Commons::DUAL, Commons::PLURAL);

		// 全ての数		
		foreach ($number_array as $number){
			// 全ての格			
			foreach ($case_array as $case){
				// 数・格に応じて多次元配列を作成		
				$word_chart[$number][$case] = $this->get_declensioned_noun($case, $number);
			}
		}

		// 結果を返す。
		return $word_chart;
	}

	// 曲用表を作成(動名詞用)
	protected function make_infinitive_declension($word_chart){
		// 格変化配列
		$case_array = array(Commons::NOMINATIVE, Commons::GENETIVE, Commons::DATIVE, Commons::ACCUSATIVE, Commons::ABLATIVE, Commons::INSTRUMENTAL, Commons::LOCATIVE, Commons::VOCATIVE);
		// 数配列
		$number_array = array(Commons::SINGULAR);

		// 全ての数		
		foreach ($number_array as $number){
			// 全ての格			
			foreach ($case_array as $case){
				// 数・格に応じて多次元配列を作成		
				$word_chart[$number][$case] = $this->get_declensioned_noun($case, $number);
			}
		}

		// 結果を返す。
		return $word_chart;
	}


}

// ラテン語名詞クラス
class Latin_Noun extends Noun_Common_IE {

	protected $case_suffix_list =  [
		[
			"noun_type" => "1",
			"noun_type_name" => "第一活用",				
			"gender" => "Masculine/Feminine/Neuter",
			"sg_nom" => "a",
			"sg_gen" => "ae",
			"sg_dat" => "ae",
			"sg_acc" => "am",
			"sg_abl" => "ā(d)",
			"sg_loc" => "ae",
			"sg_voc" => "a",
			"pl_nom" => "ae",
			"pl_gen" => "ārum",
			"pl_dat" => "īs",
			"pl_acc" => "ās",
			"pl_abl" => "īs",
			"pl_loc" => "īs",
			"pl_voc" => "ae"
		],
		[
			"noun_type" => "1gr1",
			"noun_type_name" => "第一活用(ギリシア式)",
			"gender" => "Masculine/Feminine",
			"sg_nom" => "ās",
			"sg_gen" => "ae",
			"sg_dat" => "ae",
			"sg_acc" => "am",
			"sg_abl" => "ā(d)",
			"sg_loc" => "ae",
			"sg_voc" => "ā",
			"pl_nom" => "ae",
			"pl_gen" => "ārum",
			"pl_dat" => "īs",
			"pl_acc" => "ās",
			"pl_abl" => "īs",
			"pl_loc" => "īs",
			"pl_voc" => "ae"
		],
		[
			"noun_type" => "1gr2",
			"noun_type_name" => "第一活用(ギリシア式)",			
			"gender" => "Masculine/Feminine",
			"sg_nom" => "ēs",
			"sg_gen" => "ae",
			"sg_dat" => "ae",
			"sg_acc" => "am",
			"sg_abl" => "ā(d)",
			"sg_loc" => "ae",
			"sg_voc" => "ē",
			"pl_nom" => "ae",
			"pl_gen" => "ārum",
			"pl_dat" => "īs",
			"pl_acc" => "ās",
			"pl_abl" => "īs",
			"pl_loc" => "īs",
			"pl_voc" => "ae"
		],
		[
			"noun_type" => "1gr3",
			"noun_type_name" => "第一活用(ギリシア式)",			
			"gender" => "Masculine/Feminine",
			"sg_nom" => "ē",
			"sg_gen" => "ae",
			"sg_dat" => "ae",
			"sg_acc" => "am",
			"sg_abl" => "ā(d)",
			"sg_loc" => "ae",
			"sg_voc" => "ē",
			"pl_nom" => "ae",
			"pl_gen" => "ārum",
			"pl_dat" => "īs",
			"pl_acc" => "ās",
			"pl_abl" => "īs",
			"pl_loc" => "īs",
			"pl_voc" => "ae"
		],
		[
			"noun_type" => "2",
			"noun_type_name" => "第二活用",	
			"gender" => "Masculine/Feminine/Neuter",
			"sg_nom" => "us",
			"sg_gen" => "ī",
			"sg_dat" => "ō",
			"sg_acc" => "um",
			"sg_abl" => "ō(d)",
			"sg_loc" => "ī",
			"sg_voc" => "e",
			"pl_nom" => "ī",
			"pl_gen" => "ōrum",
			"pl_dat" => "īs",
			"pl_acc" => "ōs",
			"pl_abl" => "īs",
			"pl_loc" => "īs",
			"pl_voc" => "ī"
		],
		[
			"noun_type" => "2gr1",
			"noun_type_name" => "第二活用(ギリシア式)",				
			"gender" => "Masculine/Feminine",
			"sg_nom" => "ōs",
			"sg_gen" => "ī",
			"sg_dat" => "ō",
			"sg_acc" => "ōna",
			"sg_abl" => "ō(d)",
			"sg_loc" => "ī",
			"sg_voc" => "ū",
			"pl_nom" => "ī",
			"pl_gen" => "ōrum",
			"pl_dat" => "īs",
			"pl_acc" => "ōs",
			"pl_abl" => "īs",
			"pl_loc" => "īs",
			"pl_voc" => "ī"
		],
		[
			"noun_type" => "2gr1",
			"noun_type_name" => "第二活用(ギリシア式)",					
			"gender" => "Neuter",
			"sg_nom" => "ōs",
			"sg_gen" => "ī",
			"sg_dat" => "ō",
			"sg_acc" => "ōna",
			"sg_abl" => "ō(d)",
			"sg_loc" => "ī",
			"sg_voc" => "ū",
			"pl_nom" => "a",
			"pl_gen" => "ōrum",
			"pl_dat" => "īs",
			"pl_acc" => "a",
			"pl_abl" => "īs",
			"pl_loc" => "īs",
			"pl_voc" => "ī"
		],
		[
			"noun_type" => "2gr2",
			"noun_type_name" => "第二活用(ギリシア式)",					
			"gender" => "Neuter",
			"sg_nom" => "on",
			"sg_gen" => "ī",
			"sg_dat" => "ō",
			"sg_acc" => "on",
			"sg_abl" => "ō(d)",
			"sg_loc" => "ī",
			"sg_voc" => "e",
			"pl_nom" => "a",
			"pl_gen" => "ōrum",
			"pl_dat" => "īs",
			"pl_acc" => "a",
			"pl_abl" => "īs",
			"pl_loc" => "īs",
			"pl_voc" => "ī"
		],
		[
			"noun_type" => "2r",
			"noun_type_name" => "第二活用(r語幹)",					
			"gender" => "Masculine/Feminine",
			"sg_nom" => "er",
			"sg_gen" => "ī",
			"sg_dat" => "ō",
			"sg_acc" => "um",
			"sg_abl" => "ō(d)",
			"sg_loc" => "ī",
			"sg_voc" => "e",
			"pl_nom" => "ī",
			"pl_gen" => "ōrum",
			"pl_dat" => "īs",
			"pl_acc" => "ōs",
			"pl_abl" => "īs",
			"pl_loc" => "īs",
			"pl_voc" => "ī"
		],
		[
			"noun_type" => "2um",
			"noun_type_name" => "第二活用",				
			"gender" => "Masculine/Neuter",
			"sg_nom" => "um",
			"sg_gen" => "ī",
			"sg_dat" => "ō",
			"sg_acc" => "um",
			"sg_abl" => "ō(d)",
			"sg_loc" => "ī",
			"sg_voc" => "um",
			"pl_nom" => "a",
			"pl_gen" => "ōrum",
			"pl_dat" => "īs",
			"pl_acc" => "a",
			"pl_abl" => "īs",
			"pl_loc" => "īs",
			"pl_voc" => "ī"
		],
		[
			"noun_type" => "3",
			"noun_type_name" => "第三活用",				
			"gender" => "Masculine/Feminine",
			"sg_nom" => "",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "em",
			"sg_abl" => "e",
			"sg_loc" => "i",
			"sg_voc" => "",
			"pl_nom" => "ēs",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "ēs",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ēs"
		],
		[
			"noun_type" => "3",
			"noun_type_name" => "第三活用",					
			"gender" => "Neuter",
			"sg_nom" => "",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "",
			"sg_abl" => "e",
			"sg_loc" => "i",
			"sg_voc" => "",
			"pl_nom" => "ia",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "ia",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ia"
		],
		[
			"noun_type" => "3a",
			"noun_type_name" => "第三活用",					
			"gender" => "Neuter",
			"sg_nom" => "-",
			"sg_gen" => "-",
			"sg_dat" => "-",
			"sg_acc" => "-",
			"sg_abl" => "-",
			"sg_loc" => "-",
			"sg_voc" => "-",
			"pl_nom" => "a",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "a",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "a"
		],
		[
			"noun_type" => "3con",
			"noun_type_name" => "第三活用(子音語幹)",					
			"gender" => "Masculine/Feminine",
			"sg_nom" => "",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "em",
			"sg_abl" => "e",
			"sg_loc" => "i",
			"sg_voc" => "",
			"pl_nom" => "ēs",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "ēs",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ēs"
		],
		[
			"noun_type" => "3con",
			"noun_type_name" => "第三活用(子音語幹)",					
			"gender" => "Neuter",
			"sg_nom" => "",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "",
			"sg_abl" => "e",
			"sg_loc" => "i",
			"sg_voc" => "",
			"pl_nom" => "a",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "a",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "a"
		],
		[
			"noun_type" => "3con2",
			"noun_type_name" => "第三活用(子音語幹)",					
			"gender" => "Masculine/Feminine",
			"sg_nom" => "",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "em",
			"sg_abl" => "e",
			"sg_loc" => "i",
			"sg_voc" => "",
			"pl_nom" => "ēs",
			"pl_gen" => "ium",
			"pl_dat" => "ibus",
			"pl_acc" => "īs",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ēs"
		],
		[
			"noun_type" => "3con2",
			"noun_type_name" => "第三活用(子音語幹)",					
			"gender" => "Neuter",
			"sg_nom" => "",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "",
			"sg_abl" => "e",
			"sg_loc" => "i",
			"sg_voc" => "",
			"pl_nom" => "ia",
			"pl_gen" => "ium",
			"pl_dat" => "ibus",
			"pl_acc" => "ia",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ia"
		],
		[
			"noun_type" => "3e",
			"noun_type_name" => "第三活用(e語幹)",				
			"gender" => "Neuter",
			"sg_nom" => "e",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "e",
			"sg_abl" => "ī(d)",
			"sg_loc" => "ī",
			"sg_voc" => "e",
			"pl_nom" => "ia",
			"pl_gen" => "ium",
			"pl_dat" => "ibus",
			"pl_acc" => "ia",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ia"
		],
		[
			"noun_type" => "3i",
			"noun_type_name" => "第三活用(i語幹)",				
			"gender" => "Masculine/Feminine",
			"sg_nom" => "is",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "em",
			"sg_abl" => "e",
			"sg_loc" => "ī",
			"sg_voc" => "is ",
			"pl_nom" => "ēs",
			"pl_gen" => "ium",
			"pl_dat" => "ibus",
			"pl_acc" => "īs",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ēs"
		],
		[
			"noun_type" => "3i",
			"noun_type_name" => "第三活用(i語幹)",				
			"gender" => "Neuter",
			"sg_nom" => "is",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "is",
			"sg_abl" => "e",
			"sg_loc" => "ī",
			"sg_voc" => "is",
			"pl_nom" => "a",
			"pl_gen" => "ium",
			"pl_dat" => "ibus",
			"pl_acc" => "a",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "a"
		],
		[
			"noun_type" => "3m",
			"noun_type_name" => "第三活用(m語幹)",	
			"gender" => "Feminine",
			"sg_nom" => "s",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "em",
			"sg_abl" => "e",
			"sg_loc" => "ī",
			"sg_voc" => "s",
			"pl_nom" => "ēs",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "ēs",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ēs"
		],
		[
			"noun_type" => "3n",
			"noun_type_name" => "第三活用(n語幹)",				
			"gender" => "Masculine/Feminine",
			"sg_nom" => "",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "em",
			"sg_abl" => "e",
			"sg_loc" => "i",
			"sg_voc" => "",
			"pl_nom" => "ēs",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "ēs",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ēs"
		],
		[
			"noun_type" => "3n",
			"noun_type_name" => "第三活用(n語幹)",	
			"gender" => "Neuter",
			"sg_nom" => "",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "",
			"sg_abl" => "e",
			"sg_loc" => "i",
			"sg_voc" => "",
			"pl_nom" => "a",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "a",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "a"
		],
		[
			"noun_type" => "3r",
			"noun_type_name" => "第三活用(r語幹)",	
			"gender" => "Masculine/Feminine",
			"sg_nom" => "",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "em",
			"sg_abl" => "e",
			"sg_loc" => "i",
			"sg_voc" => "",
			"pl_nom" => "ēs",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "ēs",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ēs"
		],
		[
			"noun_type" => "3r",
			"noun_type_name" => "第三活用(r語幹)",				
			"gender" => "Neuter",
			"sg_nom" => "",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "",
			"sg_abl" => "e",
			"sg_loc" => "i",
			"sg_voc" => "",
			"pl_nom" => "a",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "a",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "a"
		],
		[
			"noun_type" => "3Rhot",
			"noun_type_name" => "第三活用(r語幹)",				
			"gender" => "Masculine/Feminine",
			"sg_nom" => "",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "em",
			"sg_abl" => "e",
			"sg_loc" => "i",
			"sg_voc" => "",
			"pl_nom" => "ēs",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "ēs",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ēs"
		],
		[
			"noun_type" => "3Rhot",
			"noun_type_name" => "第三活用(r語幹)",				
			"gender" => "Neuter",
			"sg_nom" => "",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "",
			"sg_abl" => "e",
			"sg_loc" => "i",
			"sg_voc" => "",
			"pl_nom" => "a",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "a",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "a"
		],
		[
			"noun_type" => "3s",
			"noun_type_name" => "第三活用(s語幹)",				
			"gender" => "Masculine/Feminine",
			"sg_nom" => "s",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "em",
			"sg_abl" => "e",
			"sg_loc" => "ī",
			"sg_voc" => "s",
			"pl_nom" => "ēs",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "ēs",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ēs"
		],
		[
			"noun_type" => "3s",
			"noun_type_name" => "第三活用(s語幹)",						
			"gender" => "Neuter",
			"sg_nom" => "s",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "s",
			"sg_abl" => "e",
			"sg_loc" => "ī",
			"sg_voc" => "s",
			"pl_nom" => "a",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "a",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "a"
		],
		[
			"noun_type" => "3gr1",
			"noun_type_name" => "第三活用(ギリシア式)",					
			"gender" => "Masculine/Feminine",
			"sg_nom" => "ēr",
			"sg_gen" => "os",
			"sg_dat" => "ī",
			"sg_acc" => "a",
			"sg_abl" => "e",
			"sg_loc" => "ī",
			"sg_voc" => "ēr",
			"pl_nom" => "ēs",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "es",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ēs"
		],
		[
			"noun_type" => "3gr2",
			"noun_type_name" => "第三活用(ギリシア式)",					
			"gender" => "Feminine",
			"sg_nom" => "",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "a",
			"sg_abl" => "e",
			"sg_loc" => "ī",
			"sg_voc" => "",
			"pl_nom" => "ēs",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "es",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ēs"
		],
		[
			"noun_type" => "3gr3",
			"noun_type_name" => "第三活用(ギリシア式)",					
			"gender" => "Feminine",
			"sg_nom" => "is",
			"sg_gen" => "eōs",
			"sg_dat" => "ī",
			"sg_acc" => "a",
			"sg_abl" => "ei",
			"sg_loc" => "ī",
			"sg_voc" => "i",
			"pl_nom" => "ēs",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "es",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ēs"
		],
		[
			"noun_type" => "3gr3",
			"noun_type_name" => "第三活用(ギリシア式)",					
			"gender" => "Masculine",
			"sg_nom" => "s",
			"sg_gen" => "is",
			"sg_dat" => "ī",
			"sg_acc" => "en",
			"sg_abl" => "e",
			"sg_loc" => "ī",
			"sg_voc" => "s",
			"pl_nom" => "ēs",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "es",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ēs"
		],
		[
			"noun_type" => "3gr4",
			"noun_type_name" => "第三活用(ギリシア式)",					
			"gender" => "Neuter",
			"sg_nom" => "",
			"sg_gen" => "is ",
			"sg_dat" => "ī",
			"sg_acc" => "a",
			"sg_abl" => "e",
			"sg_loc" => "ī",
			"sg_voc" => "",
			"pl_nom" => "ēs",
			"pl_gen" => "um",
			"pl_dat" => "ibus",
			"pl_acc" => "es",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ēs"
		],
		[
			"noun_type" => "4",
			"noun_type_name" => "第四活用",					
			"gender" => "Masculine/Feminine/Neuter",
			"sg_nom" => "us",
			"sg_gen" => "ūs",
			"sg_dat" => "uī",
			"sg_acc" => "um",
			"sg_abl" => "ū(d)",
			"sg_loc" => "i",
			"sg_voc" => "us",
			"pl_nom" => "ūs",
			"pl_gen" => "uum",
			"pl_dat" => "ibus",
			"pl_acc" => "ūs",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ūs"
		],
		[
			"noun_type" => "4gr",
			"noun_type_name" => "第四活用(ギリシア式)",				
			"gender" => "Feminine",
			"sg_nom" => "ō",
			"sg_gen" => "ūs",
			"sg_dat" => "uī",
			"sg_acc" => "um",
			"sg_abl" => "ū(d)",
			"sg_loc" => "i",
			"sg_voc" => "us",
			"pl_nom" => "ūs",
			"pl_gen" => "uum",
			"pl_dat" => "ibus",
			"pl_acc" => "ūs",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ūs"
		],
		[
			"noun_type" => "4u",
			"noun_type_name" => "第四活用(u語幹)",				
			"gender" => "Neuter",
			"sg_nom" => "ū",
			"sg_gen" => "ūs",
			"sg_dat" => "uī",
			"sg_acc" => "ū",
			"sg_abl" => "ū(d)",
			"sg_loc" => "i",
			"sg_voc" => "ū",
			"pl_nom" => "ua",
			"pl_gen" => "uum",
			"pl_dat" => "ibus",
			"pl_acc" => "ua",
			"pl_abl" => "ibus",
			"pl_loc" => "ibus",
			"pl_voc" => "ua"
		],
		[
			"noun_type" => "5",
			"noun_type_name" => "第五活用",				
			"gender" => "Feminine",
			"sg_nom" => "ēs",
			"sg_gen" => "eī",
			"sg_dat" => "eī",
			"sg_acc" => "em",
			"sg_abl" => "ē(d)",
			"sg_loc" => "ē",
			"sg_voc" => "ēs",
			"pl_nom" => "ēs",
			"pl_gen" => "ērum",
			"pl_dat" => "ēbus",
			"pl_acc" => "ēs",
			"pl_abl" => "ēbus",
			"pl_loc" => "ēbus",
			"pl_voc" => "ēs"
		],
		[
			"noun_type" => "5e",
			"noun_type_name" => "第五活用(e語幹)",							
			"gender" => "Masculine/Feminine",
			"sg_nom" => "ēs",
			"sg_gen" => "ēī",
			"sg_dat" => "ēī",
			"sg_acc" => "em",
			"sg_abl" => "ē(d)",
			"sg_loc" => "ē",
			"sg_voc" => "ēs",
			"pl_nom" => "ēs",
			"pl_gen" => "ērum",
			"pl_dat" => "ēbus",
			"pl_acc" => "ēs",
			"pl_abl" => "ēbus",
			"pl_loc" => "ēbus",
			"pl_voc" => "ēs"
		],
	];

	// 地名フラグ
	protected $location_name = "";
	
    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_lat1($noun) {
    	// 親クラス初期化
		parent::__construct();
		// 名詞情報をセット
		$this->set_data(htmlspecialchars($noun));
		// 活用表を挿入
		$this->get_noun_declension();
    }
    
    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_lat3($compound, $last_word, $translation) {
    	// 親クラス初期化
		parent::__construct();
		// 名詞情報をセット
		$this->set_data(htmlspecialchars($last_word), false);
		// 語幹を変更
		$this->first_stem = htmlspecialchars($compound).$this->first_stem;		// 第一語幹
		$this->third_stem = htmlspecialchars($compound).$this->third_stem;		// 第三語幹
		// 日本語訳を書き換え
		$this->japanese_translation = $translation;			// 日本語訳
		$this->english_translation = "";			// 英語訳
		
		// 活用表を挿入
		$this->get_noun_declension();
    }
    
    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
        $a = func_get_args();
        $i = func_num_args();
        //引数に応じて別々のコンストラクタを似非的に呼び出す
        if (method_exists($this,$f='__construct_lat'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }
    
    // 活用表セット
    private function get_noun_declension(){

		// 初期化
		$declension = array();
		// 全ての接尾辞リストを参照
		$declension = $this->get_noun_case_suffix($this->noun_type, $this->gender);
		
		// 単数
		$this->case_suffix[Commons::SINGULAR][Commons::NOMINATIVE] = $declension["sg_nom"];
		$this->case_suffix[Commons::SINGULAR][Commons::GENETIVE] = $declension["sg_gen"];
		$this->case_suffix[Commons::SINGULAR][Commons::DATIVE] = $declension["sg_dat"];
		$this->case_suffix[Commons::SINGULAR][Commons::ACCUSATIVE] = $declension["sg_acc"];
		$this->case_suffix[Commons::SINGULAR][Commons::ABLATIVE] = $declension["sg_abl"];
		$this->case_suffix[Commons::SINGULAR][Commons::INSTRUMENTAL] = $declension["sg_ins"];
		$this->case_suffix[Commons::SINGULAR][Commons::LOCATIVE] = $declension["sg_loc"];
		$this->case_suffix[Commons::SINGULAR][Commons::VOCATIVE] = $declension["sg_voc"];
		
		// 複数
		$this->case_suffix[Commons::PLURAL][Commons::NOMINATIVE] = $declension["pl_nom"];
		$this->case_suffix[Commons::PLURAL][Commons::GENETIVE] = $declension["pl_gen"];
		$this->case_suffix[Commons::PLURAL][Commons::DATIVE] = $declension["pl_dat"];
		$this->case_suffix[Commons::PLURAL][Commons::ACCUSATIVE] = $declension["pl_acc"];
		$this->case_suffix[Commons::PLURAL][Commons::ABLATIVE] = $declension["pl_abl"];
		$this->case_suffix[Commons::PLURAL][Commons::INSTRUMENTAL] = $declension["pl_ins"];
		$this->case_suffix[Commons::PLURAL][Commons::LOCATIVE] = $declension["pl_loc"];
		$this->case_suffix[Commons::PLURAL][Commons::VOCATIVE] = $declension["pl_voc"];

		// 活用種別名
		$this->noun_type_name = $declension["noun_type_name"];
    }
    
    // 名詞情報を取得
    private function set_data($noun){
    	// 名詞情報を取得
		$word_info = $this->get_noun_from_DB($noun, Latin_Common::DB_NOUN);
		// データがある場合は
		if($word_info){
			// データを挿入
			$this->first_stem = $word_info["weak_stem"];							//第一語幹
			$this->third_stem = mb_substr($word_info["strong_stem"], 0, -1);	//第三語幹
			$this->gender = $word_info["gender"];								//性別
			$this->noun_type = $word_info["noun_type"];							//名詞タイプ
			$this->japanese_translation = $word_info["japanese_translation"];	//日本語訳
			$this->english_translation = $word_info["english_translation"];		//英語訳
			$this->deponent_singular = $word_info["deponent_singular"];	//単数のみフラグ
			$this->deponent_plural = $word_info["deponent_plural"];		//複数のみフラグ
			$this->location_name = $word_info["location_name"];			//地名フラグ
		} else {
			// 第一語幹・第三語幹生成
			$this->first_stem = $noun;
			$this->third_stem = mb_substr($noun, 0, -1);

			// 日本語訳
			$this->japanese_translation = "借用";
			// 英語訳
			$this->english_translation = "loanword";
			
			// 文字列の最後で判断
			if(preg_match("/a$/", $noun)){				
				$this->gender = self::PIE_ACTION;						//性別
				$this->noun_type = 1;							//名詞種別
			} else if(preg_match("/u$/", $noun)){						
				$this->gender = self::PIE_ANIMATE;    				//性別
				$this->noun_type = 2;           				//名詞種別
				$this->first_stem = $noun."s";					//第一語幹
				$this->third_stem = mb_substr($noun, 0, -1);	//第三語幹						
			} else if(preg_match("/(us|os)$/", $noun)){						
				$this->gender = self::PIE_ANIMATE;    					//性別
				$this->noun_type = 2;           					//名詞種別
				$this->first_stem = mb_substr($noun, 0, -2)."us";	//第三語幹				
				$this->third_stem = mb_substr($noun, 0, -2);		//第三語幹
			} else if(preg_match("/(um|on)$/", $noun)){						
				$this->gender = self::PIE_ANIMATE;    					//性別
				$this->noun_type = "2um";           				//名詞種別
				$this->first_stem = mb_substr($noun, 0, -2)."um";	//第三語幹				
				$this->third_stem = mb_substr($noun, 0, -2);	//第三語幹		
			} else if(preg_match("/(is|es)$/", $noun)){						
				$this->gender = self::PIE_ANIMATE;       				//性別
				$this->noun_type = "3i";        				//名詞種別
				$this->third_stem = mb_substr($noun, 0, -2);	//第三語幹
			} else if(preg_match("/(o|ō)$/", $noun)){						
				$this->gender = self::PIE_INANIMATE;       				//性別
				$this->noun_type = "3n";        				//名詞種別
				$this->third_stem = $noun."n";					//第三語幹
			} else if(preg_match("/(ns)$/", $noun)){
				$this->gender = self::PIE_ANIMATE;    				//性別				
				$this->noun_type = "3con";          				// 名詞種別			
				$this->third_stem = mb_substr($noun, 0, -2)."nt";	// 強語幹を変更
				$this->first_stem = $noun;							// 弱語幹を変更	
			} else if(preg_match("/(tor)$/", $noun)){						
				$this->gender = self::PIE_ANIMATE;    					//性別
				$this->noun_type = "3r";        					//名詞種別
				$this->third_stem = $noun;							//第三語幹
				$this->third_stem = mb_substr($noun, 0, -2)."ōr";	// 強語幹を変更											
			} else if(preg_match("/(er|or)$/", $noun)){						
				$this->gender = self::PIE_ANIMATE;    				//性別
				$this->noun_type = "3r";        				//名詞種別
				$this->third_stem = $noun;						//第三語幹
			} else if(preg_match("/s$/", $noun)){						
				$this->gender = self::PIE_ACTION;    						//性別
				$this->noun_type = "3s";        					//名詞種別
				$this->third_stem = mb_substr($noun, 0, -1);		//第三語幹				
			} else if(preg_match("/x$/", $noun)){						
				$this->gender = self::PIE_ACTION;    						//性別
				$this->noun_type = "3s";        					//名詞種別
				$this->third_stem = mb_substr($noun, 0, -1)."c";	//第三語幹
			} else {											
				$this->gender = self::PIE_ANIMATE;    				//性別
				$this->noun_type = 2;           				//名詞種別
				$this->first_stem = $noun."us";					//第一語幹
				$this->third_stem = $noun;						//第三語幹
			}
		}
    }
	
	// 名詞作成
	public function get_declensioned_noun($case, $number){

		// 格語尾を取得
		$case_suffix = "";
		//曲用語尾を取得(単数の複数の有無をチェック)
		if($number == Commons::SINGULAR && $this->deponent_singular != Commons::$TRUE){
			// 単数
			$case_suffix = $this->case_suffix[$number][$case];
		} else if($number == Commons::PLURAL && ($this->deponent_plural != Commons::$TRUE && $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->case_suffix[$number][$case];
		} else {
			// ハイフンを返す。
			return "-";
		}

		// 語幹を取得
		if(preg_match('/^(1|1gr1|1gr2|1gr3|2|2gr1|2gr2|2um|3e|4|4gr|4u|5|5e)$/',$this->noun_type)){
			// 第一・第二活用(r活用除く)、第三母音活用、第四・第五活用の場合は常に強語幹
			$noun = $this->third_stem;		
		} else {
			// それ以外は単数の主格と呼格は弱語幹
			if(($case == Commons::NOMINATIVE && $number == Commons::SINGULAR) || ($case == Commons::VOCATIVE && $number == Commons::SINGULAR)){
				// ここで結果を返す。
				return $this->first_stem;					
			} else if($case == Commons::ACCUSATIVE && $this->gender == self::PIE_INANIMATE && $number == Commons::SINGULAR){
				// 中性の単数対格は主格と同じ
				// ここで結果を返す。
				return $this->first_stem;
			} else {
				// それ以外は強語幹
				$noun = $this->third_stem;					
			}
		}

		// 結果を返す
		return trim($noun.$case_suffix);
	}
	
	// 曲用表を取得
	public function get_chart(){
		
		// 初期化
		$word_chart = array();
		
		// タイトル情報を挿入
		$word_chart['title'] = $this->get_noun_title();
		// 辞書見出しを入れる。
		$word_chart['dic_title'] = $this->first_stem;
		// 活用種別を入れる。
		$word_chart['type'] = $this->noun_type_name;
		// 性別を入れる。
		$word_chart['gender'] = $this->get_gender_name();		
		// 曲用を入れる。
		$word_chart = $this->make_noun_declension($word_chart);
		// 結果を返す。
		return $word_chart;
	}

	// 語幹を取得
	public function get_first_stem(){
		return $this->first_stem;
	}	

	// 特定の格変化を取得する(ない場合はランダム)。
	public function get_form_by_number_case($case = "", $number = ""){

		// 格がない場合
		if($case == ""){
			// 単数・複数の中からランダムで選択
			$ary = array(Commons::NOMINATIVE, Commons::GENETIVE, Commons::DATIVE, Commons::ACCUSATIVE, Commons::ABLATIVE, Commons::LOCATIVE, Commons::VOCATIVE);	// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$case = $ary[$key];			
		}

		// 数がない場合
		if($number == ""){
			// 単数・複数の中からランダムで選択
			$ary = array(Commons::SINGULAR, Commons::PLURAL);			// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$number = $ary[$key];			
		}

		// 配列に格納
		$question_data = array();
		$question_data['question_sentence'] = $this->get_noun_title()."の".$number." ".$case."を答えよ";
		$question_data['answer'] = $this->get_declensioned_noun($case, $number);
		$question_data['question_sentence2'] = $question_data['answer']."の数と格を答えよ";
		$question_data['case'] = $case;
		$question_data['number'] = $number;

		// 結果を返す。
		return $question_data;
	}
}

// 梵語共通クラス
class Vedic_Noun extends Noun_Common_IE {

	// 格語尾リスト
	protected $case_suffix_list =  [
		[
			"noun_type" => "1",
			"noun_type_name" => "ā-変化名詞",				
			"gender" => "Feminine",
			"sg_nom" => "ā",
			"sg_gen" => "āyās",
			"sg_dat" => "āye",
			"sg_acc" => "ām",
			"sg_abl" => "āyās",
			"sg_ins" => "ā",
			"sg_loc" => "āyām",
			"sg_voc" => "e",
			"du_nom" => "e",
			"du_gen" => "yos",
			"du_dat" => "bhiām",
			"du_acc" => "e",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "yos",
			"du_voc" => "e",
			"pl_nom" => "ās",
			"pl_gen" => "ānām",
			"pl_dat" => "bhyas",
			"pl_acc" => "ās",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",			
			"pl_loc" => "su",
			"pl_voc" => "ās"
		],
		[
			"noun_type" => "2",
			"noun_type_name" => "a-変化名詞",			
			"gender" => "Masculine/Feminine",
			"sg_nom" => "s",
			"sg_gen" => "sya",
			"sg_dat" => "aya",
			"sg_acc" => "m",
			"sg_abl" => "at",
			"sg_ins" => "ena",
			"sg_loc" => "e",
			"sg_voc" => "",
			"du_nom" => "au",
			"du_gen" => "yos",
			"du_dat" => "bhiām",
			"du_acc" => "au",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "yos",
			"du_voc" => "au",
			"pl_nom" => "āsas",
			"pl_gen" => "ānām",
			"pl_dat" => "ebhyas",
			"pl_acc" => "ān",
			"pl_abl" => "ebhyas",
			"pl_ins" => "ebhis",			
			"pl_loc" => "esu",
			"pl_voc" => "āsas"
		],
		[
			"noun_type" => "2",
			"noun_type_name" => "a-変化名詞",			
			"gender" => "Neuter",
			"sg_nom" => "m",
			"sg_gen" => "sya",
			"sg_dat" => "aya",
			"sg_acc" => "m",
			"sg_abl" => "at",
			"sg_ins" => "ena",
			"sg_loc" => "e",
			"sg_voc" => "",
			"du_nom" => "e",
			"du_gen" => "yos",
			"du_dat" => "bhiām",
			"du_acc" => "e",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "yos",
			"du_voc" => "e",
			"pl_nom" => "a",
			"pl_gen" => "anām",
			"pl_dat" => "ebhyas",
			"pl_acc" => "a",
			"pl_abl" => "ebhyas",
			"pl_ins" => "ebhis",			
			"pl_loc" => "esu",
			"pl_voc" => "a"
		],
		[
			"noun_type" => "3s",
			"noun_type_name" => "語根名詞",	
			"gender" => "Feminine",
			"sg_nom" => "s",
			"sg_gen" => "as",
			"sg_dat" => "e",
			"sg_acc" => "am",
			"sg_abl" => "as",
			"sg_ins" => "ā",
			"sg_loc" => "i",
			"sg_voc" => "s",
			"du_nom" => "au",
			"du_gen" => "os",
			"du_dat" => "bhiām",
			"du_acc" => "au",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "os",
			"du_voc" => "au",
			"pl_nom" => "as",
			"pl_gen" => "ām",
			"pl_dat" => "bhyas",
			"pl_acc" => "as",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "as"
		],
		[
			"noun_type" => "3s",
			"noun_type_name" => "語根名詞",
			"gender" => "Masculine",
			"sg_nom" => "s",
			"sg_gen" => "as",
			"sg_dat" => "e",
			"sg_acc" => "am",
			"sg_abl" => "as",
			"sg_ins" => "ā",
			"sg_loc" => "i",
			"sg_voc" => "s",
			"du_nom" => "u",
			"du_gen" => "os",
			"du_dat" => "bhiām",
			"du_acc" => "u",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "os",
			"du_voc" => "u",
			"pl_nom" => "as",
			"pl_gen" => "ām",
			"pl_dat" => "bhyas",
			"pl_acc" => "as",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "as"
		],
		[
			"noun_type" => "3n",
			"noun_type_name" => "n-変化名詞",
			"gender" => "Masculine",
			"sg_nom" => "s",
			"sg_gen" => "as",
			"sg_dat" => "e",
			"sg_acc" => "am",
			"sg_abl" => "as",
			"sg_ins" => "ā",
			"sg_loc" => "i",
			"sg_voc" => "s",
			"du_nom" => "au",
			"du_gen" => "os",
			"du_dat" => "bhiām",
			"du_acc" => "au",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "os",
			"du_voc" => "au",
			"pl_nom" => "as",
			"pl_gen" => "ām",
			"pl_dat" => "bhyas",
			"pl_acc" => "as",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "as"
		],
		[
			"noun_type" => "3n",
			"noun_type_name" => "n-変化名詞",
			"gender" => "Neuter",
			"sg_nom" => "s",
			"sg_gen" => "as",
			"sg_dat" => "e",
			"sg_acc" => "s",
			"sg_abl" => "as",
			"sg_ins" => "ā",
			"sg_loc" => "i",
			"sg_voc" => "s",
			"du_nom" => "ī",
			"du_gen" => "os",
			"du_dat" => "bhiām",
			"du_acc" => "ī",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "os",
			"du_voc" => "ī",
			"pl_nom" => "āni",
			"pl_gen" => "ām",
			"pl_dat" => "bhyas",
			"pl_acc" => "āni",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "āni"
		],
		[
			"noun_type" => "3con",
			"noun_type_name" => "子音変化名詞",
			"gender" => "Masculine",
			"sg_nom" => "",
			"sg_gen" => "as",
			"sg_dat" => "e",
			"sg_acc" => "am",
			"sg_abl" => "as",
			"sg_ins" => "ā",
			"sg_loc" => "i",
			"sg_voc" => "s",
			"du_nom" => "au",
			"du_gen" => "os",
			"du_dat" => "bhiām",
			"du_acc" => "au",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "os",
			"du_voc" => "au",
			"pl_nom" => "as",
			"pl_gen" => "ām",
			"pl_dat" => "bhyas",
			"pl_acc" => "as",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "as"
		],
		[
			"noun_type" => "3con",
			"noun_type_name" => "子音変化名詞",
			"gender" => "Feminine",
			"sg_nom" => "",
			"sg_gen" => "as",
			"sg_dat" => "e",
			"sg_acc" => "am",
			"sg_abl" => "as",
			"sg_ins" => "ā",
			"sg_loc" => "i",
			"sg_voc" => "s",
			"du_nom" => "au",
			"du_gen" => "os",
			"du_dat" => "bhiām",
			"du_acc" => "au",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "os",
			"du_voc" => "au",
			"pl_nom" => "as",
			"pl_gen" => "ām",
			"pl_dat" => "bhyas",
			"pl_acc" => "as",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "as"
		],
		[
			"noun_type" => "3con",
			"noun_type_name" => "子音変化名詞",
			"gender" => "Neuter",
			"sg_nom" => "",
			"sg_gen" => "as",
			"sg_dat" => "e",
			"sg_acc" => "",
			"sg_abl" => "as",
			"sg_ins" => "ā",
			"sg_loc" => "i",
			"sg_voc" => "",
			"du_nom" => "ī",
			"du_gen" => "os",
			"du_dat" => "bhiām",
			"du_acc" => "ī",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "os",
			"du_voc" => "ī",
			"pl_nom" => "i",
			"pl_gen" => "ām",
			"pl_dat" => "bhyas",
			"pl_acc" => "i",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "i"
		],
		[
			"noun_type" => "double",
			"noun_type_name" => "二重母音名詞",
			"gender" => "Feminine",
			"sg_nom" => "s",
			"sg_gen" => "as",
			"sg_dat" => "e",
			"sg_acc" => "am",
			"sg_abl" => "as",
			"sg_ins" => "ā",
			"sg_loc" => "i",
			"sg_voc" => "s",
			"du_nom" => "au",
			"du_gen" => "os",
			"du_dat" => "bhiām",
			"du_acc" => "au",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "os",
			"du_voc" => "au",
			"pl_nom" => "as",
			"pl_gen" => "ām",
			"pl_dat" => "bhyas",
			"pl_acc" => "as",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "as"
		],
		[
			"noun_type" => "double",
			"noun_type_name" => "二重母音名詞",
			"gender" => "Masculine",
			"sg_nom" => "s",
			"sg_gen" => "as",
			"sg_dat" => "e",
			"sg_acc" => "s",
			"sg_abl" => "as",
			"sg_ins" => "ā",
			"sg_loc" => "i",
			"sg_voc" => "s",
			"du_nom" => "au",
			"du_gen" => "os",
			"du_dat" => "bhiām",
			"du_acc" => "au",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "os",
			"du_voc" => "au",
			"pl_nom" => "as",
			"pl_gen" => "ām",
			"pl_dat" => "bhyas",
			"pl_acc" => "as",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "as"
		],
		[
			"noun_type" => "3r",
			"noun_type_name" => "r-変化名詞",
			"gender" => "Neuter",
			"sg_nom" => "ā",
			"sg_gen" => "ur",
			"sg_dat" => "re",
			"sg_acc" => "āram",
			"sg_abl" => "ur",
			"sg_ins" => "rā",
			"sg_loc" => "ari",
			"sg_voc" => "ar",
			"du_nom" => "ṛṇī",
			"du_gen" => "ros",
			"du_dat" => "ṛbhiām",
			"du_acc" => "ṛṇī",
			"du_abl" => "ṛbhiām",
			"du_ins" => "ṛbhiām",
			"du_loc" => "ros",
			"du_voc" => "ṛṇī",
			"pl_nom" => "ṛṇī",
			"pl_gen" => "ṝṇām",
			"pl_dat" => "ṛbhyas",
			"pl_acc" => "ṛṇī",
			"pl_abl" => "ṛbhyas",
			"pl_ins" => "ṛbhis",	
			"pl_loc" => "ṛsu",
			"pl_voc" => "ṛṇī"
		],
		[
			"noun_type" => "3r",
			"noun_type_name" => "r-変化名詞",
			"gender" => "Masculine/Feminine",
			"sg_nom" => "ā",
			"sg_gen" => "ur",
			"sg_dat" => "re",
			"sg_acc" => "āram",
			"sg_abl" => "ur",
			"sg_ins" => "rā",
			"sg_loc" => "ari",
			"sg_voc" => "ar",
			"du_nom" => "arā",
			"du_gen" => "ros",
			"du_dat" => "ṛbhiām",
			"du_acc" => "arā",
			"du_abl" => "ṛbhiām",
			"du_ins" => "ṛbhiām",
			"du_loc" => "ros",
			"du_voc" => "arā",
			"pl_nom" => "āras",
			"pl_gen" => "ṛṇām",
			"pl_dat" => "ṛbhyas",
			"pl_acc" => "ṝn",
			"pl_abl" => "ṛbhyas",
			"pl_ins" => "ṛbhis",	
			"pl_loc" => "ṛsu",
			"pl_voc" => "āras"
		],
		[
			"noun_type" => "3i",
			"noun_type_name" => "i-変化名詞",
			"gender" => "Feminine",
			"sg_nom" => "s",
			"sg_gen" => "yes",
			"sg_dat" => "aye",
			"sg_acc" => "m",
			"sg_abl" => "yes",
			"sg_ins" => "ā",
			"sg_loc" => "āu",
			"sg_voc" => "ai",
			"du_nom" => "ī",
			"du_gen" => "yos",
			"du_dat" => "bhiām",
			"du_acc" => "ī",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "yos",
			"du_voc" => "ī",
			"pl_nom" => "ayas",
			"pl_gen" => "īnām",
			"pl_dat" => "bhyas",
			"pl_acc" => "īn",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "ayas"
		],
		[
			"noun_type" => "3i",
			"noun_type_name" => "i-変化名詞",
			"gender" => "Masculine",
			"sg_nom" => "s",
			"sg_gen" => "yes",
			"sg_dat" => "aye",
			"sg_acc" => "m",
			"sg_abl" => "yes",
			"sg_ins" => "ā",
			"sg_loc" => "āu",
			"sg_voc" => "ai",
			"du_nom" => "ī",
			"du_gen" => "yos",
			"du_dat" => "bhiām",
			"du_acc" => "ī",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "yos",
			"du_voc" => "ī",
			"pl_nom" => "ayas",
			"pl_gen" => "īnām",
			"pl_dat" => "bhyas",
			"pl_acc" => "īn",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "ayas"
		],
		[
			"noun_type" => "3i",
			"noun_type_name" => "i-変化名詞",
			"gender" => "Neuter",
			"sg_nom" => "",
			"sg_gen" => "as",
			"sg_dat" => "e",
			"sg_acc" => "",
			"sg_abl" => "as",
			"sg_ins" => "ā",
			"sg_loc" => "ni",
			"sg_voc" => "ai",
			"du_nom" => "nī",
			"du_gen" => "nos",
			"du_dat" => "bhiām",
			"du_acc" => "nī",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "nos",
			"du_voc" => "nī",
			"pl_nom" => "ī",
			"pl_gen" => "īnām",
			"pl_dat" => "bhyas",
			"pl_acc" => "ī",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "ī"
		],
		[
			"noun_type" => "4u",
			"noun_type_name" => "u-変化名詞",
			"gender" => "Feminine",
			"sg_nom" => "s",
			"sg_gen" => "os",
			"sg_dat" => "avai",
			"sg_acc" => "m",
			"sg_abl" => "os",
			"sg_ins" => "ā",
			"sg_loc" => "au",
			"sg_voc" => "o",
			"du_nom" => "ū",
			"du_gen" => "os",
			"du_dat" => "bhiām",
			"du_acc" => "ū",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "os",
			"du_voc" => "ū",
			"pl_nom" => "avas",
			"pl_gen" => "ūnām",
			"pl_dat" => "bhyas",
			"pl_acc" => "ūs",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "avas"
		],
		[
			"noun_type" => "4u",
			"noun_type_name" => "u-変化名詞",
			"gender" => "Masculine",
			"sg_nom" => "s",
			"sg_gen" => "os",
			"sg_dat" => "avai",
			"sg_acc" => "m",
			"sg_abl" => "os",
			"sg_ins" => "ā",
			"sg_loc" => "au",
			"sg_voc" => "o",
			"du_nom" => "ū",
			"du_gen" => "os",
			"du_dat" => "bhiām",
			"du_acc" => "ū",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "os",
			"du_voc" => "ū",
			"pl_nom" => "avas",
			"pl_gen" => "ūnām",
			"pl_dat" => "bhyas",
			"pl_acc" => "ūṅs",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "avas"
		],
		[
			"noun_type" => "4u",
			"noun_type_name" => "u-変化名詞",
			"gender" => "Neuter",
			"sg_nom" => "",
			"sg_gen" => "os",
			"sg_dat" => "e",
			"sg_acc" => "",
			"sg_abl" => "os",
			"sg_ins" => "ā",
			"sg_loc" => "ni",
			"sg_voc" => "au",
			"du_nom" => "nī",
			"du_gen" => "nos",
			"du_dat" => "bhiām",
			"du_acc" => "nī",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "nos",
			"du_voc" => "nī",
			"pl_nom" => "ū",
			"pl_gen" => "īnām",
			"pl_dat" => "bhyas",
			"pl_acc" => "ū",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "ū"
		],
		[
			"noun_type" => "3ilong",
			"noun_type_name" => "ī-変化名詞",
			"gender" => "Feminine/Masculine",
			"sg_nom" => "",
			"sg_gen" => "ās",
			"sg_dat" => "ai",
			"sg_acc" => "īm",
			"sg_abl" => "ās",
			"sg_ins" => "ā",
			"sg_loc" => "ām",
			"sg_voc" => "",
			"du_nom" => "ī",
			"du_gen" => "os",
			"du_dat" => "bhiām",
			"du_acc" => "ī",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "os",
			"du_voc" => "ī",
			"pl_nom" => "s",
			"pl_gen" => "nām",
			"pl_dat" => "bhyas",
			"pl_acc" => "s",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "s"
		],
		[
			"noun_type" => "4ulong",
			"noun_type_name" => "ū-変化名詞",
			"gender" => "Feminine",
			"sg_nom" => "",
			"sg_gen" => "ās",
			"sg_dat" => "ai",
			"sg_acc" => "ūm",
			"sg_abl" => "ās",
			"sg_ins" => "ā",
			"sg_loc" => "ām",
			"sg_voc" => "",
			"du_nom" => "ī",
			"du_gen" => "os",
			"du_dat" => "bhiām",
			"du_acc" => "ī",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "os",
			"du_voc" => "ī",
			"pl_nom" => "s",
			"pl_gen" => "nām",
			"pl_dat" => "bhyas",
			"pl_acc" => "s",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "s"
		],		
	];

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_sanskrit2($noun, $noun_genre) {
    	// 親クラス初期化
		parent::__construct();
		// 手動で情報をセット
		$this->set_data_manual(htmlspecialchars($noun), $noun_genre);
		// 残りの語幹を作成
		$this->make_other_stem();
		// 活用表を挿入
		$this->get_noun_declension();
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_sanskrit5($root, $suffix, $verb_translation, $suffix_translation, $noun_genre) {
     	// 親クラス初期化
		parent::__construct();
		// 単語を作成
		$word = Sanskrit_Common::sandhi_engine($root, $suffix);
		// 手動で情報をセット
		$this->set_data_manual(htmlspecialchars($word), $noun_genre);
		// 残りの語幹を作成
		$this->make_other_stem();
		// 日本語訳を書き換え
		$this->japanese_translation = $verb_translation.$suffix_translation;		// 日本語訳
		$this->english_translation = "";											// 英語訳
		
		// 活用表を挿入
		$this->get_noun_declension();
    }
    
    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_sanskrit3($compound, $last_word, $translation) {
    	// 親クラス初期化
		parent::__construct();
		// 情報をセット
		$this->set_data($last_word, "");
		// 残りの語幹を作成
		$this->make_other_stem();
		// 語幹を変更
		$this->first_stem = Sanskrit_Common::sandhi_engine($compound, $this->first_stem);		// 第一語幹
		$this->second_stem = Sanskrit_Common::sandhi_engine($compound, $this->second_stem);		// 第二語幹		
		$this->third_stem = Sanskrit_Common::sandhi_engine($compound, $this->third_stem);		// 第三語幹
		// 日本語訳を書き換え
		$this->japanese_translation = $translation;			// 日本語訳
		$this->english_translation = "";			// 英語訳
		
		// 活用表を挿入
		$this->get_noun_declension();
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_sanskrit1($noun) {
    	// 親クラス初期化
		parent::__construct();
		// 名詞情報をセット
		$this->set_data(htmlspecialchars($noun), "animate");
		// 残りの語幹を作成
		$this->make_other_stem();
		// 活用表を挿入
		$this->get_noun_declension();
    }
    
    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
        $a = func_get_args();
        $i = func_num_args();
        //引数に応じて別々のコンストラクタを似非的に呼び出す
        if (method_exists($this,$f='__construct_sanskrit'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }
    
    // 活用表セット
    private function get_noun_declension(){

		// 全ての接尾辞リストを参照
		$declension = $this->get_noun_case_suffix($this->noun_type, $this->gender);

		// 活用表を挿入	
		// 単数
		$this->case_suffix[Commons::SINGULAR][Commons::NOMINATIVE] = $declension["sg_nom"];
		$this->case_suffix[Commons::SINGULAR][Commons::GENETIVE] = $declension["sg_gen"];
		$this->case_suffix[Commons::SINGULAR][Commons::DATIVE] = $declension["sg_dat"];
		$this->case_suffix[Commons::SINGULAR][Commons::ACCUSATIVE] = $declension["sg_acc"];
		$this->case_suffix[Commons::SINGULAR][Commons::ABLATIVE] = $declension["sg_abl"];
		$this->case_suffix[Commons::SINGULAR][Commons::INSTRUMENTAL] = $declension["sg_ins"];
		$this->case_suffix[Commons::SINGULAR][Commons::LOCATIVE] = $declension["sg_loc"];
		$this->case_suffix[Commons::SINGULAR][Commons::VOCATIVE] = $declension["sg_voc"];
		
		// 双数
		$this->case_suffix[Commons::DUAL][Commons::NOMINATIVE] = $declension["du_nom"];
		$this->case_suffix[Commons::DUAL][Commons::GENETIVE] = $declension["du_gen"];
		$this->case_suffix[Commons::DUAL][Commons::DATIVE] = $declension["du_dat"];
		$this->case_suffix[Commons::DUAL][Commons::ACCUSATIVE] = $declension["du_acc"];
		$this->case_suffix[Commons::DUAL][Commons::ABLATIVE] = $declension["du_abl"];
		$this->case_suffix[Commons::DUAL][Commons::INSTRUMENTAL] = $declension["du_ins"];
		$this->case_suffix[Commons::DUAL][Commons::LOCATIVE] = $declension["du_loc"];
		$this->case_suffix[Commons::DUAL][Commons::VOCATIVE] = $declension["du_voc"];
		
		// 複数
		$this->case_suffix[Commons::PLURAL][Commons::NOMINATIVE] = $declension["pl_nom"];
		$this->case_suffix[Commons::PLURAL][Commons::GENETIVE] = $declension["pl_gen"];
		$this->case_suffix[Commons::PLURAL][Commons::DATIVE] = $declension["pl_dat"];
		$this->case_suffix[Commons::PLURAL][Commons::ACCUSATIVE] = $declension["pl_acc"];
		$this->case_suffix[Commons::PLURAL][Commons::ABLATIVE] = $declension["pl_abl"];
		$this->case_suffix[Commons::PLURAL][Commons::INSTRUMENTAL] = $declension["pl_ins"];
		$this->case_suffix[Commons::PLURAL][Commons::LOCATIVE] = $declension["pl_loc"];
		$this->case_suffix[Commons::PLURAL][Commons::VOCATIVE] = $declension["pl_voc"];

		// 活用種別名
		$this->noun_type_name = $declension["noun_type_name"];
    }

	// 語幹を作成
	private function make_other_stem(){
		// 活用種別に合わせて語幹を作る。
		if(preg_match('/^(1|2)$/',$this->noun_type)){
			// a-変化活用の場合
			$this->first_stem = $this->second_stem;		// 弱語幹
			$this->third_stem = $this->second_stem;		// 強語幹
		} else if($this->noun_type == "3s"){
			// 語根活用の場合		
			$this->first_stem = Sanskrit_Common::change_vowel_grade($this->second_stem, Sanskrit_Common::ZERO_GRADE);		// 弱語幹
			$this->third_stem = Sanskrit_Common::change_vowel_grade($this->second_stem, Sanskrit_Common::VRIDDHI);	// 強語幹
		} else if($this->noun_type == "3n"){
			// n活用の場合
			if(preg_match('/(an)$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -2)."n";		// 弱語幹
				$this->third_stem = mb_substr($this->second_stem, 0, -2)."ān";		// 強語幹
			} else if(preg_match('/(in)$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -2)."in";		// 弱語幹
				$this->third_stem = mb_substr($this->second_stem, 0, -2)."īn";		// 強語幹
			} else {
				$this->first_stem = mb_substr($this->second_stem, 0, -2).Sanskrit_Common::change_vowel_grade(mb_substr($this->second_stem, -2), Sanskrit_Common::ZERO_GRADE);		// 弱語幹
				$this->third_stem = mb_substr($this->second_stem, 0, -2).Sanskrit_Common::change_vowel_grade(mb_substr($this->second_stem, -2), Sanskrit_Common::VRIDDHI);	// 強語幹
			}
		} else if($this->noun_type == "3con"){
			// 子音活用の場合			
			if(preg_match('/(at|āt)$/',$this->second_stem)){				
				$this->first_stem = mb_substr($this->second_stem, 0, -2)."at";
				$this->second_stem = mb_substr($this->second_stem, 0, -2)."at";				
				$this->third_stem = mb_substr($this->second_stem, 0, -2)."ānt";
			} else if(preg_match('/(yac)$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -3)."īc";
				$this->second_stem = mb_substr($this->second_stem, 0, -3)."āc";
				$this->third_stem = mb_substr($this->second_stem, 0, -3)."ānc";
			} else if(preg_match('/(vas)$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -3)."uṣ";
				$this->second_stem = mb_substr($this->second_stem, 0, -3)."vat";
				$this->third_stem = mb_substr($this->second_stem, 0, -3)."vāṃs";
			} else if(preg_match('/(ac)$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -2)."āc";
				$this->second_stem = mb_substr($this->second_stem, 0, -2)."āc";
				$this->third_stem = mb_substr($this->second_stem, 0, -2)."ānc";						
			} else {
				$this->first_stem = $this->second_stem;		// 弱語幹
				$this->third_stem = $this->second_stem;		// 強語幹
				if($this->gender ==  self::PIE_INANIMATE){
					$this->third_stem = mb_substr($this->second_stem, 0, -2)."āṃs";
				}	
			}			
		} else {
			// それ以外の活用の場合				
			$this->first_stem = $this->second_stem;			// 弱語幹
			$this->third_stem = $this->second_stem;			// 強語幹
		}
	}
    
    // 名詞情報を取得
    private function set_data($noun, $noun_genre){
    	// 名詞情報を取得
		$word_info = $this->get_noun_from_DB($noun, Sanskrit_Common::DB_NOUN, false);
		// データがある場合は
		if($word_info){
			// データを挿入
			$this->second_stem = $word_info["stem"];							// 第二語幹			
			$this->gender = $word_info["gender"];								// 性別
			$this->noun_type = $word_info["noun_type"];							// 名詞タイプ			
			$this->japanese_translation = $word_info["japanese_translation"];	// 日本語訳
			$this->english_translation = $word_info["english_translation"];		// 英語訳
		} else {
			// 見つからない場合は手動で設定
			$this->set_data_manual($noun, $noun_genre);
		}
    }

	// 語幹を手動作成
	private function set_data_manual($noun, $noun_genre){
		// 第一語幹・第三語幹生成
		$this->second_stem = $noun;												// 第二語幹
		// 日本語訳
		$this->japanese_translation = "借用";
		// 英語訳
		$this->english_translation = "loanword";
		
		// 文字列の最後で判断
		if($noun_genre == "root"){
			// 語根名詞(不定詞)はこちら
			$this->gender = self::PIE_ACTION;    							// 名詞区分
			$this->noun_type = "3s";										// 名詞種別
		} else if(preg_match('/(e|o|au|ai)$/',$noun)){
			$this->noun_type = "double";									// 名詞種別
			// 名詞の種別で性別・活用が決定する。										
			if($noun_genre == "agent" || $noun_genre == "animate" || $noun_genre == "inanimate"){
				$this->gender = self::PIE_ANIMATE;							// 名詞区分
			} else if($noun_genre == "action"){						
				$this->gender = self::PIE_ACTION;    						// 名詞区分
			} else {
				$this->gender = self::PIE_ANIMATE;							// 名詞区分
			}
		} else if(preg_match('/(a|ā)$/',$noun)){		
			// 名詞の種別で性別・活用が決定する。		
			if($noun_genre == "agent" || $noun_genre == "animate"){
				$this->gender = self::PIE_ANIMATE;							// 名詞区分
				$this->noun_type = 2;										// 名詞種別
				$this->second_stem = mb_substr($noun, 0, -1)."a";			// 第二語幹
			} else if($noun_genre == "inanimate"){						
				$this->gender =  self::PIE_INANIMATE;    					// 名詞区分
				$this->noun_type = 2;           							// 名詞種別
				$this->second_stem = mb_substr($noun, 0, -1)."a";			// 第二語幹
			} else if($noun_genre == "action"){						
				$this->gender = self::PIE_ACTION;    						// 名詞区分
				$this->noun_type = 1;           							// 名詞種別
				$this->second_stem = mb_substr($noun, 0, -1)."ā";			// 第二語幹
			} else {
				if(preg_match('/a$/u',$noun)){
					$this->gender = self::PIE_ANIMATE;    					// 名詞区分
					$this->noun_type = 2;           						// 名詞種別
					$this->second_stem = mb_substr($noun, 0, -1)."a";		// 第二語幹
				} else if(preg_match('/ā$/u',$noun)){
					$this->gender = self::PIE_ACTION; 						// 名詞区分
					$this->noun_type = 1;           						// 名詞種別
					$this->second_stem = mb_substr($noun, 0, -1)."ā";		// 第二語幹
				}
			}
		} else if(preg_match('/(u|ū)$/',$noun)){			
			// 名詞の種別で性別・活用が決定する。							
			if($noun_genre == "agent" || $noun_genre == "animate"){
				$this->gender = self::PIE_ANIMATE;							// 名詞区分
				$this->noun_type = 4;										// 名詞種別
				$this->second_stem = mb_substr($noun, 0, -1)."u";			// 第二語幹
			} else if($noun_genre == "inanimate"){						
				$this->gender = self::PIE_INANIMATE;    					// 名詞区分
				$this->noun_type = 4;           							// 名詞種別
				$this->second_stem = mb_substr($noun, 0, -1)."u";			// 第二語幹
			} else if($noun_genre == "action"){	
				if(preg_match('/u$/',$noun)){
					$this->gender = self::PIE_ACTION; 				    	// 名詞区分
					$this->noun_type = 4;									// 名詞種別
					$this->second_stem = mb_substr($noun, 0, -1)."u";		// 第二語幹
				} else if(preg_match('/ū$/',$noun)){
					$this->gender = self::PIE_ACTION; 						// 名詞区分
					$this->noun_type = "4ulong";           					// 名詞種別
					$this->second_stem = mb_substr($noun, 0, -1)."ū";		// 第二語幹
				}
			} else {
				if(preg_match('/u$/',$noun)){
					$this->gender = self::PIE_ANIMATE;						// 名詞区分
					$this->noun_type = 4;									// 名詞種別
					$this->second_stem = mb_substr($noun, 0, -1)."u";		// 第二語幹
				} else if(preg_match('/ū$/',$noun)){
					$this->gender = self::PIE_ACTION; 						// 名詞区分
					$this->noun_type = "4ulong";           					// 名詞種別
					$this->second_stem = mb_substr($noun, 0, -1)."ū";		// 第二語幹
				}
			}
		} else if(preg_match('/(i|ī)$/',$noun)){		
			// 名詞の種別で性別・活用が決定する。								
			if($noun_genre == "agent" || $noun_genre == "animate"){
				$this->gender = self::PIE_ANIMATE;							// 名詞区分
				$this->noun_type = "3i";									// 名詞種別
				$this->second_stem = mb_substr($noun, 0, -1)."i";			// 第二語幹
			} else if($noun_genre == "inanimate"){						
				$this->gender =  self::PIE_INANIMATE;    					// 名詞区分
				$this->noun_type = "3i";           							// 名詞種別
				$this->second_stem = mb_substr($noun, 0, -1)."i";			// 第二語幹
			} else if($noun_genre == "action"){						
				if(preg_match('/i$/',$noun)){
					$this->gender = self::PIE_ACTION; 						// 名詞区分
					$this->noun_type = "3i";								// 名詞種別
					$this->second_stem = mb_substr($noun, 0, -1)."i";		// 第二語幹
				} else if(preg_match('/ī$/',$noun)){
					$this->gender = self::PIE_ACTION; 						// 名詞区分
					$this->noun_type = "3ilong";           					// 名詞種別
					$this->second_stem = mb_substr($noun, 0, -1)."ī";		// 第二語幹
				}
			} else {
				if(preg_match('/i$/',$noun)){
					$this->gender = self::PIE_ANIMATE;						// 名詞区分
					$this->noun_type = "3i";								// 名詞種別
					$this->second_stem = mb_substr($noun, 0, -1)."i";		// 第二語幹
				} else if(preg_match('/ī$/',$noun)){
					$this->gender = self::PIE_ACTION; 						// 名詞区分
					$this->noun_type = "3ilong";           					// 名詞種別
					$this->second_stem = mb_substr($noun, 0, -1)."ī";		// 第二語幹
				}
			}
		} else if(preg_match('/(r|ṛ)$/',$noun)){
			$this->noun_type = "3r";										// 名詞種別				
			if($noun_genre == "agent" || $noun_genre == "animate"){
				$this->gender = self::PIE_ANIMATE;							// 名詞区分
				$this->second_stem = mb_substr($noun, 0, -1);				// 第二語幹
			} else {
				$this->gender = self::PIE_INANIMATE;						// 名詞区分
				$this->second_stem = mb_substr($noun, 0, -1);				// 第二語幹
			}
		} else if(preg_match('/(n)$/',$noun)){
			$this->noun_type = "3n";										// 名詞種別
			if($noun_genre == "agent" || $noun_genre == "animate"){
				$this->gender = self::PIE_ANIMATE;							// 名詞区分
			} else {
				$this->gender = self::PIE_INANIMATE;						// 名詞区分
			}
		} else if(preg_match('/(at|ac|yas|vas)$/',$noun)){
			// 名詞の種別で性別・活用が決定する。						
			$this->noun_type = "3con";										// 名詞種別
			if($noun_genre == "agent" || $noun_genre == "animate"){
				$this->gender = self::PIE_ANIMATE;							// 名詞区分
			} else if($noun_genre == "action"){						
				$this->gender = self::PIE_ACTION; 							// 名詞区分
			} else {
				$this->gender =  self::PIE_INANIMATE;						// 名詞区分
			}												
		} else if(preg_match('/(as|is|us)$/',$noun)){
			$this->gender = self::PIE_INANIMATE;							// 名詞区分
			$this->noun_type = "3con";										// 名詞種別
		} else if(preg_match('/(s|t)$/',$noun)){
			$this->noun_type = "3con";										// 名詞種別
			// 名詞の種別で性別・活用が決定する。										
			if($noun_genre == "agent" || $noun_genre == "animate"){
				$this->gender = self::PIE_ANIMATE;							// 名詞区分
			} else {
				$this->gender =  self::PIE_INANIMATE;						// 名詞区分
			}							
		} else {		
			// 名詞の種別で性別・活用が決定する。													
			if($noun_genre == "agent" || $noun_genre == "animate"){
				$this->gender = self::PIE_ANIMATE;							// 名詞区分
				$this->noun_type = "3s";									// 名詞種別
			} else if($noun_genre == "inanimate"){						
				$this->gender =  self::PIE_INANIMATE;    					// 名詞区分
				$this->noun_type = 2;           							// 名詞種別
				$this->second_stem = $noun."a";								// 第二語幹
			} else if($noun_genre == "action"){						
				$this->gender = self::PIE_ACTION; 	  						// 名詞区分
				$this->noun_type = "3s";									// 名詞種別
			} else {
				$this->gender =  self::PIE_ANIMATE;    						// 名詞区分
				$this->noun_type = "3s";									// 名詞種別
			}
		}
	}

	// 名詞作成
	public function get_declensioned_noun($case, $number){

		// 語幹が存在しない場合は返さない。
		if($this->third_stem == ""){
			return "-";
		}

		// 格語尾を取得
		$case_suffix = "";
		// 曲用語尾を取得
		$case_suffix = $this->case_suffix[$number][$case];

		// 語幹を取得
		$stem = "";

		// 性・数・格に応じて語幹を生成
		// 男性および女性
		if($this->gender == self::PIE_ANIMATE || $this->gender == self::PIE_ACTION){
			if($case == Commons::NOMINATIVE || $case == Commons::VOCATIVE){
				$stem = $this->third_stem;
			} else if($case == Commons::ACCUSATIVE && ($number == Commons::SINGULAR || $number == Commons::DUAL)){
				$stem = $this->third_stem;
			} else if($case == Commons::INSTRUMENTAL && ($number == Commons::DUAL || $number == Commons::PLURAL)){
				$stem = $this->second_stem;
			} else if($case == Commons::DATIVE && ($number == Commons::DUAL || $number == Commons::PLURAL)){
				$stem = $this->second_stem;
			} else if($case == Commons::ABLATIVE && ($number == Commons::DUAL || $number == Commons::PLURAL)){
				$stem = $this->second_stem;	
			} else if($case == Commons::LOCATIVE && $number == Commons::PLURAL){
				$stem = $this->second_stem;							
			} else {
				$stem = $this->first_stem;
			}
		} else if($this->gender == self::PIE_INANIMATE){
			if($case == Commons::NOMINATIVE || $case == Commons::VOCATIVE || $case == Commons::ACCUSATIVE){
				switch($number){
					case Commons::SINGULAR:
						$stem = $this->second_stem;							
						break;
					case Commons::DUAL:
						$stem = $this->first_stem;							
						break;
					case Commons::PLURAL:
						$stem = $this->third_stem;							
						break;
					default:
						$stem = $this->third_stem;				
						break;			
				}
			} else if($case == Commons::INSTRUMENTAL && ($number == Commons::DUAL || $number == Commons::PLURAL)){
				$stem = $this->second_stem;
			} else if($case == Commons::DATIVE && ($number == Commons::DUAL || $number == Commons::PLURAL)){
				$stem = $this->second_stem;
			} else if($case == Commons::ABLATIVE && ($number == Commons::DUAL || $number == Commons::PLURAL)){
				$stem = $this->second_stem;	
			} else if($case == Commons::LOCATIVE && $number == Commons::PLURAL){
				$stem = $this->second_stem;							
			} else {
				$stem = $this->first_stem;
			}
		} else {
			// ハイフンを返す。
			return "-";
		}
		
		// 語幹修正
		if($this->noun_type == 1 || $this->noun_type == 2 || $this->noun_type == "3i" || $this->noun_type == 4){
			// 第一・第二・第三・第四変化の場合
			// 格変化の語尾が母音で始まる場合は
			if(Commons::is_vowel_or_not(mb_substr($case_suffix, 0, 1))){
				// 最後の母音を削る
				$stem = mb_substr($stem, 0, -1);			 	
			} 
		}

		// rで始まる場合は
		if($this->noun_type == "3r" && preg_match('/ṛ$/', mb_substr($stem, -1))){
			//常に語幹の最後の母音を削る
			$stem = mb_substr($stem, 0, -1);				
		}	

		// 結果を生成
		$noun = Sanskrit_Common::sandhi_engine($stem, $case_suffix, true, true);

		// 結果を返す
		return htmlspecialchars($noun);
	}

	// 語幹を取得
	public function get_second_stem(){
		return $this->second_stem;
	}

	// 語幹を取得
	public function get_third_stem(){
		return $this->third_stem;
	}
	
	// 性別の名称を返す
	public function get_gender_name(){
		// 名称に応じて分ける。
		if($this->gender == self::PIE_ANIMATE){
			return "名詞区分 - 動作主名詞";
		} else if($this->gender == self::PIE_ACTION){
			return "名詞区分 - 動作名詞";
		} else if($this->gender == self::PIE_INANIMATE){
			return "名詞区分 - 無生物名詞";
		} else {
			return "なし";
		}
	}
	
	// 曲用表を取得
	public function get_chart(){
		
		// 初期化
		$word_chart = array();
		
		// タイトル情報を挿入
		$word_chart['title'] = $this->get_noun_title();
		// 辞書見出しを入れる。
		$word_chart['dic_title'] = $this->get_second_stem();
		// 種別を入れる。
		$word_chart['category'] = "名詞";
		// 活用種別を入れる。
		$word_chart['type'] = $this->noun_type_name;
		// 性別を入れる。
		$word_chart['gender'] = $this->get_gender_name();
		// 曲用を入れる。
		$word_chart = $this->make_noun_declension($word_chart);

		// 副詞(拡張格)
		$word_chart[Commons::SINGULAR]["elative"] = Sanskrit_Common::sandhi_engine($this->second_stem, "tas", true);
		$word_chart[Commons::SINGULAR]["inessive1"] = Sanskrit_Common::sandhi_engine($this->second_stem, "trā", true);
		$word_chart[Commons::SINGULAR]["inessive2"] = Sanskrit_Common::sandhi_engine($this->second_stem, "dha", true);		
		$word_chart[Commons::SINGULAR]["comitative"] = Sanskrit_Common::sandhi_engine($this->second_stem, "thā", true);		
		$word_chart[Commons::SINGULAR]["multiplicative"] = Sanskrit_Common::sandhi_engine($this->second_stem, "dhā", true);	
		$word_chart[Commons::SINGULAR]["essive"] = Sanskrit_Common::sandhi_engine($this->second_stem, "vat", true);	
		$word_chart[Commons::SINGULAR]["translative"] = Sanskrit_Common::sandhi_engine($this->second_stem, "sāt", true);		
		$word_chart[Commons::SINGULAR]["temporal"] = Sanskrit_Common::sandhi_engine($this->second_stem, "dā", true);	
		$word_chart[Commons::SINGULAR]["illative"] = Sanskrit_Common::sandhi_engine($this->second_stem, "ac", true);	
		$word_chart[Commons::SINGULAR]["distributive"] = Sanskrit_Common::sandhi_engine($this->second_stem, "sas", true);	
		
		// 結果を返す。
		return $word_chart;
	}

	// 動名詞を取得
	public function get_infinitive(){
		
		// 初期化
		$word_chart = array();

		// 曲用を入れる。
		$word_chart = $this->make_infinitive_declension($word_chart);

		// 副詞(拡張格)
		$word_chart[Commons::SINGULAR]["elative"] = Sanskrit_Common::sandhi_engine($this->second_stem, "tas", true);
		$word_chart[Commons::SINGULAR]["inessive1"] = Sanskrit_Common::sandhi_engine($this->second_stem, "trā", true);
		$word_chart[Commons::SINGULAR]["inessive2"] = Sanskrit_Common::sandhi_engine($this->second_stem, "dha", true);		
		$word_chart[Commons::SINGULAR]["comitative"] = Sanskrit_Common::sandhi_engine($this->second_stem, "thā", true);		
		$word_chart[Commons::SINGULAR]["multiplicative"] = Sanskrit_Common::sandhi_engine($this->second_stem, "dhā", true);	
		$word_chart[Commons::SINGULAR]["essive"] = Sanskrit_Common::sandhi_engine($this->second_stem, "vat", true);	
		$word_chart[Commons::SINGULAR]["translative"] = Sanskrit_Common::sandhi_engine($this->second_stem, "sāt", true);		
		$word_chart[Commons::SINGULAR]["temporal"] = Sanskrit_Common::sandhi_engine($this->second_stem, "dā", true);	
		$word_chart[Commons::SINGULAR]["illative"] = Sanskrit_Common::sandhi_engine($this->second_stem, "ac", true);	
		$word_chart[Commons::SINGULAR]["distributive"] = Sanskrit_Common::sandhi_engine($this->second_stem, "sas", true);	
		
		// 結果を返す。
		return $word_chart;
	}	

	// 特定の格変化を取得する(ない場合はランダム)。
	public function get_form_by_number_case($case = "", $number = ""){

		// 格がない場合
		if($case == ""){
			// 単数・複数の中からランダムで選択
			$ary = array(Commons::NOMINATIVE, Commons::GENETIVE, Commons::DATIVE, Commons::ACCUSATIVE, Commons::ABLATIVE, Commons::INSTRUMENTAL, Commons::LOCATIVE, Commons::VOCATIVE);	// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$case = $ary[$key];			
		}

		// 数がない場合
		if($number == ""){
			// 単数・複数の中からランダムで選択
			$ary = array(Commons::SINGULAR, Commons::DUAL, Commons::PLURAL);			// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$number = $ary[$key];			
		}

		// 配列に格納
		$question_data = array();
		$question_data['question_sentence'] = $this->get_noun_title()."の".$number." ".$case."を答えよ";
		$question_data['answer'] = $this->get_declensioned_noun($case, $number);
		$question_data['question_sentence2'] = $question_data['answer']."の数と格を答えよ";
		$question_data['case'] = $case;
		$question_data['number'] = $number;

		// 結果を返す。
		return $question_data;
	}
}

// ポーランド語共通クラス
class Polish_Noun extends Noun_Common_IE{

	// 格語尾リスト
	protected $case_suffix_list =  [
		[
			"noun_type" => "0",
			"noun_type_name" => "不変化名詞",
			"gender" => "Feminine/Masculine-Animate/Masculine-Inanimate/Neuter",
			"sg_nom" => "",
			"sg_gen" => "",
			"sg_dat" => "",
			"sg_acc" => "",
			"sg_ins" => "",
			"sg_loc" => "",
			"sg_voc" => "",
			"du_nom" => "",
			"du_gen" => "",
			"du_dat" => "",
			"du_acc" => "",
			"du_ins" => "",
			"du_loc" => "",
			"du_voc" => "",
			"pl_nom" => "",
			"pl_gen" => "",
			"pl_dat" => "",
			"pl_acc" => "",
			"pl_ins" => "",
			"pl_loc" => "",
			"pl_voc" => ""
		],			
		[
			"noun_type" => "1",
			"noun_type_name" => "a-変化名詞",
			"gender" => "Feminine/Masculine-Animate/Masculine-Inanimate",
			"sg_nom" => "a",
			"sg_gen" => "y",
			"sg_dat" => "ie",
			"sg_acc" => "ę",
			"sg_ins" => "ą",
			"sg_loc" => "ie",
			"sg_voc" => "o",
			"du_nom" => "e",
			"du_gen" => "u",
			"du_dat" => "ama",
			"du_acc" => "e",
			"du_ins" => "ama",
			"du_loc" => "u",
			"du_voc" => "e",
			"pl_nom" => "y",
			"pl_gen" => "",
			"pl_dat" => "om",
			"pl_acc" => "y",
			"pl_ins" => "ami",
			"pl_loc" => "ach",
			"pl_voc" => "y"
		],
		[
			"noun_type" => "1k",
			"noun_type_name" => "a-変化名詞",
			"gender" => "Feminine/Masculine-Animate/Masculine-Inanimate",
			"sg_nom" => "a",
			"sg_gen" => "i",
			"sg_dat" => "e",
			"sg_acc" => "ę",
			"sg_ins" => "ą",
			"sg_loc" => "e",
			"sg_voc" => "o",
			"du_nom" => "e",
			"du_gen" => "u",
			"du_dat" => "ama",
			"du_acc" => "e",
			"du_ins" => "ama",
			"du_loc" => "u",
			"du_voc" => "e",
			"pl_nom" => "i",
			"pl_gen" => "",
			"pl_dat" => "om",
			"pl_acc" => "i",
			"pl_ins" => "ami",
			"pl_loc" => "ach",
			"pl_voc" => "i"
		],
		[
			"noun_type" => "1i",
			"noun_type_name" => "ia-変化名詞",
			"gender" => "Feminine",
			"sg_nom" => "a",
			"sg_gen" => "y",
			"sg_dat" => "y",
			"sg_acc" => "ę",
			"sg_ins" => "ą",
			"sg_loc" => "y",
			"sg_voc" => "o",
			"du_nom" => "e",
			"du_gen" => "u",
			"du_dat" => "yma",
			"du_acc" => "e",
			"du_ins" => "yma",
			"du_loc" => "u",
			"du_voc" => "e",
			"pl_nom" => "e",
			"pl_gen" => "",
			"pl_dat" => "om",
			"pl_acc" => "e",
			"pl_ins" => "ami",
			"pl_loc" => "ach",
			"pl_voc" => "e"
		],
		[
			"noun_type" => "1ia",
			"noun_type_name" => "ia-変化名詞",
			"gender" => "Feminine",
			"sg_nom" => "a",
			"sg_gen" => "i",
			"sg_dat" => "i",
			"sg_acc" => "ę",
			"sg_ins" => "ą",
			"sg_loc" => "i",
			"sg_voc" => "o",
			"du_nom" => "e",
			"du_gen" => "u",
			"du_dat" => "yma",
			"du_acc" => "e",
			"du_ins" => "yma",
			"du_loc" => "u",
			"du_voc" => "e",
			"pl_nom" => "e",
			"pl_gen" => "",
			"pl_dat" => "om",
			"pl_acc" => "e",
			"pl_ins" => "ami",
			"pl_loc" => "ach",
			"pl_voc" => "e"
		],
		[
			"noun_type" => "1ni",
			"noun_type_name" => "ni-変化名詞",
			"gender" => "Feminine",
			"sg_nom" => "",
			"sg_gen" => "",
			"sg_dat" => "",
			"sg_acc" => "ę",
			"sg_ins" => "ą",
			"sg_loc" => "",
			"sg_voc" => "",
			"du_nom" => "e",
			"du_gen" => "u",
			"du_dat" => "yma",
			"du_acc" => "e",
			"du_ins" => "yma",
			"du_loc" => "u",
			"du_voc" => "e",
			"pl_nom" => "e",
			"pl_gen" => "",
			"pl_dat" => "om",
			"pl_acc" => "e",
			"pl_ins" => "ami",
			"pl_loc" => "ach",
			"pl_voc" => "e"
		],					
		[
			"noun_type" => "3i",
			"noun_type_name" => "ā-変化名詞",
			"gender" => "Feminine",
			"sg_nom" => "",
			"sg_gen" => "i",
			"sg_dat" => "i",
			"sg_acc" => "",
			"sg_ins" => "ą",
			"sg_loc" => "i",
			"sg_voc" => "i",
			"du_nom" => "e",
			"du_gen" => "u",
			"du_dat" => "yma",
			"du_acc" => "e",
			"du_ins" => "yma",
			"du_loc" => "u",
			"du_voc" => "e",
			"pl_nom" => "e",
			"pl_gen" => "i",
			"pl_dat" => "om",
			"pl_acc" => "e",
			"pl_ins" => "ami",			
			"pl_loc" => "ach",
			"pl_voc" => "e"
		],		
		[
			"noun_type" => "3y",
			"noun_type_name" => "ā-変化名詞",
			"gender" => "Feminine",
			"sg_nom" => "",
			"sg_gen" => "y",
			"sg_dat" => "y",
			"sg_acc" => "",
			"sg_ins" => "ą",
			"sg_loc" => "y",
			"sg_voc" => "y",
			"du_nom" => "e",
			"du_gen" => "u",
			"du_dat" => "yma",
			"du_acc" => "e",
			"du_ins" => "yma",
			"du_loc" => "u",
			"du_voc" => "e",
			"pl_nom" => "e",
			"pl_gen" => "y",
			"pl_dat" => "om",
			"pl_acc" => "e",
			"pl_ins" => "ami",			
			"pl_loc" => "ach",
			"pl_voc" => "e"
		],		
		[
			"noun_type" => "2",
			"noun_type_name" => "男性名詞",			
			"gender" => "Masculine-Animate",
			"sg_nom" => "",
			"sg_gen" => "a",
			"sg_dat" => "owi",
			"sg_acc" => "a",
			"sg_ins" => "em",
			"sg_loc" => "e",
			"sg_voc" => "e",
			"du_nom" => "a",
			"du_gen" => "u",
			"du_dat" => "oma",
			"du_acc" => "a",
			"du_ins" => "oma",
			"du_loc" => "u",
			"du_voc" => "a",
			"pl_nom" => "i",
			"pl_gen" => "ów",
			"pl_dat" => "om",
			"pl_acc" => "ów",
			"pl_ins" => "ami",
			"pl_loc" => "ach",
			"pl_voc" => "i"
		],		
		[
			"noun_type" => "2",
			"noun_type_name" => "男性名詞",			
			"gender" => "Masculine-Inanimate",
			"sg_nom" => "",
			"sg_gen" => "u",
			"sg_dat" => "owi",
			"sg_acc" => "",
			"sg_ins" => "em",
			"sg_loc" => "e",
			"sg_voc" => "e",
			"du_nom" => "a",
			"du_gen" => "u",
			"du_dat" => "oma",
			"du_acc" => "a",
			"du_ins" => "oma",
			"du_loc" => "u",
			"du_voc" => "a",
			"pl_nom" => "y",
			"pl_gen" => "ów",
			"pl_dat" => "om",
			"pl_acc" => "ów",
			"pl_ins" => "ami",
			"pl_loc" => "ach",
			"pl_voc" => "y"
		],
		[
			"noun_type" => "2adj",
			"noun_type_name" => "男性名詞",			
			"gender" => "Masculine-Animate",
			"sg_nom" => "i",
			"sg_gen" => "iego",
			"sg_dat" => "iemu",
			"sg_acc" => "iego",
			"sg_ins" => "im",
			"sg_loc" => "im",
			"sg_voc" => "i",
			"du_nom" => "aj",
			"du_gen" => "óch",
			"du_dat" => "oma",
			"du_acc" => "óch",
			"du_ins" => "oma",
			"du_loc" => "óch",
			"du_voc" => "aj",
			"pl_nom" => "ie",
			"pl_gen" => "ich",
			"pl_dat" => "im",
			"pl_acc" => "ich",
			"pl_ins" => "imi",
			"pl_loc" => "ich",
			"pl_voc" => "ie"
		],
		[
			"noun_type" => "2adj",
			"noun_type_name" => "男性名詞",			
			"gender" => "Masculine-Inanimate",
			"sg_nom" => "i",
			"sg_gen" => "iego",
			"sg_dat" => "iemu",
			"sg_acc" => "i",
			"sg_ins" => "im",
			"sg_loc" => "im",
			"sg_voc" => "i",
			"du_nom" => "aj",
			"du_gen" => "óch",
			"du_dat" => "oma",
			"du_acc" => "aj",
			"du_ins" => "oma",
			"du_loc" => "óch",
			"du_voc" => "aj",
			"pl_nom" => "ie",
			"pl_gen" => "ich",
			"pl_dat" => "im",
			"pl_acc" => "ich",
			"pl_ins" => "imi",
			"pl_loc" => "ich",
			"pl_voc" => "ie"
		],
		[
			"noun_type" => "2adj1",
			"noun_type_name" => "男性名詞",			
			"gender" => "Masculine-Animate",
			"sg_nom" => "y",
			"sg_gen" => "ego",
			"sg_dat" => "emu",
			"sg_acc" => "ego",
			"sg_ins" => "ym",
			"sg_loc" => "ym",
			"sg_voc" => "y",
			"du_nom" => "aj",
			"du_gen" => "óch",
			"du_dat" => "oma",
			"du_acc" => "óch",
			"du_ins" => "oma",
			"du_loc" => "óch",
			"du_voc" => "aj",
			"pl_nom" => "i",
			"pl_gen" => "ych",
			"pl_dat" => "ym",
			"pl_acc" => "ych",
			"pl_ins" => "ymi",
			"pl_loc" => "ych",
			"pl_voc" => "i"
		],
		[
			"noun_type" => "2adj1",
			"noun_type_name" => "男性名詞",			
			"gender" => "Masculine-Inanimate",
			"sg_nom" => "y",
			"sg_gen" => "ego",
			"sg_dat" => "emu",
			"sg_acc" => "y",
			"sg_ins" => "ym",
			"sg_loc" => "ym",
			"sg_voc" => "y",
			"du_nom" => "aj",
			"du_gen" => "óch",
			"du_dat" => "oma",
			"du_acc" => "aj",
			"du_ins" => "oma",
			"du_loc" => "óch",
			"du_voc" => "aj",
			"pl_nom" => "i",
			"pl_gen" => "ych",
			"pl_dat" => "ym",
			"pl_acc" => "ych",
			"pl_ins" => "ymi",
			"pl_loc" => "ych",
			"pl_voc" => "i"
		],		
		[
			"noun_type" => "2k",
			"noun_type_name" => "男性名詞",			
			"gender" => "Feminine/Masculine-Animate",
			"sg_nom" => "",
			"sg_gen" => "a",
			"sg_dat" => "owi",
			"sg_acc" => "a",
			"sg_ins" => "iem",
			"sg_loc" => "u",
			"sg_voc" => "u",
			"du_nom" => "a",
			"du_gen" => "u",
			"du_dat" => "oma",
			"du_acc" => "u",
			"du_ins" => "oma",
			"du_loc" => "u",
			"du_voc" => "a",
			"pl_nom" => "y",
			"pl_gen" => "ów",
			"pl_dat" => "om",
			"pl_acc" => "ów",
			"pl_ins" => "ami",
			"pl_loc" => "ach",
			"pl_voc" => "y"
		],
		[
			"noun_type" => "2ki",
			"noun_type_name" => "男性名詞",			
			"gender" => "Feminine/Masculine-Animate",
			"sg_nom" => "",
			"sg_gen" => "a",
			"sg_dat" => "owi",
			"sg_acc" => "a",
			"sg_ins" => "iem",
			"sg_loc" => "u",
			"sg_voc" => "u",
			"du_nom" => "a",
			"du_gen" => "u",
			"du_dat" => "oma",
			"du_acc" => "u",
			"du_ins" => "oma",
			"du_loc" => "u",
			"du_voc" => "a",
			"pl_nom" => "i",
			"pl_gen" => "ów",
			"pl_dat" => "om",
			"pl_acc" => "ów",
			"pl_ins" => "ami",
			"pl_loc" => "ach",
			"pl_voc" => "i"
		],
		[
			"noun_type" => "2k",
			"noun_type_name" => "男性名詞",			
			"gender" => "Masculine-Inanimate",
			"sg_nom" => "",
			"sg_gen" => "a",
			"sg_dat" => "owi",
			"sg_acc" => "a",
			"sg_ins" => "iem",
			"sg_loc" => "u",
			"sg_voc" => "u",
			"du_nom" => "a",
			"du_gen" => "u",
			"du_dat" => "oma",
			"du_acc" => "a",
			"du_ins" => "oma",
			"du_loc" => "u",
			"du_voc" => "a",
			"pl_nom" => "i",
			"pl_gen" => "ów",
			"pl_dat" => "om",
			"pl_acc" => "ów",
			"pl_ins" => "ami",
			"pl_loc" => "ach",
			"pl_voc" => "i"
		],		
		[
			"noun_type" => "2p",
			"noun_type_name" => "男性名詞",
			"gender" => "Masculine-Animate",
			"sg_nom" => "",
			"sg_gen" => "a",
			"sg_dat" => "owi",
			"sg_acc" => "a",
			"sg_ins" => "em",
			"sg_loc" => "u",
			"sg_voc" => "u",
			"du_nom" => "a",
			"du_gen" => "u",
			"du_dat" => "oma",
			"du_acc" => "u",
			"du_ins" => "oma",
			"du_loc" => "u",
			"du_voc" => "a",
			"pl_nom" => "owie",
			"pl_gen" => "ów",
			"pl_dat" => "om",
			"pl_acc" => "ów",
			"pl_ins" => "ami",
			"pl_loc" => "ach",
			"pl_voc" => "owie"
		],
		[
			"noun_type" => "2p",
			"noun_type_name" => "男性名詞",
			"gender" => "Masculine-Inanimate",
			"sg_nom" => "",
			"sg_gen" => "a",
			"sg_dat" => "owi",
			"sg_acc" => "",
			"sg_ins" => "em",
			"sg_loc" => "u",
			"sg_voc" => "u",
			"du_nom" => "a",
			"du_gen" => "u",
			"du_dat" => "oma",
			"du_acc" => "a",
			"du_ins" => "oma",
			"du_loc" => "u",
			"du_voc" => "a",
			"pl_nom" => "e",
			"pl_gen" => "ów",
			"pl_dat" => "om",
			"pl_acc" => "e",
			"pl_ins" => "ami",
			"pl_loc" => "ach",
			"pl_voc" => "e"
		],
		[
			"noun_type" => "2p1",
			"noun_type_name" => "男性名詞",			
			"gender" => "Masculine-Animate",
			"sg_nom" => "",
			"sg_gen" => "a",
			"sg_dat" => "owi",
			"sg_acc" => "a",
			"sg_ins" => "em",
			"sg_loc" => "u",
			"sg_voc" => "u",
			"du_nom" => "a",
			"du_gen" => "u",
			"du_dat" => "oma",
			"du_acc" => "u",
			"du_ins" => "oma",
			"du_loc" => "u",
			"du_voc" => "a",
			"pl_nom" => "y",
			"pl_gen" => "ów",
			"pl_dat" => "om",
			"pl_acc" => "ów",
			"pl_ins" => "ami",
			"pl_loc" => "ach",
			"pl_voc" => "y"
		],
		[
			"noun_type" => "2p1",
			"noun_type_name" => "男性名詞",			
			"gender" => "Masculine-Inanimate",
			"sg_nom" => "",
			"sg_gen" => "u",
			"sg_dat" => "owi",
			"sg_acc" => "",
			"sg_ins" => "em",
			"sg_loc" => "u",
			"sg_voc" => "u",
			"du_nom" => "a",
			"du_gen" => "u",
			"du_dat" => "oma",
			"du_acc" => "a",
			"du_ins" => "oma",
			"du_loc" => "u",
			"du_voc" => "a",
			"pl_nom" => "y",
			"pl_gen" => "ów",
			"pl_dat" => "om",
			"pl_acc" => "y",
			"pl_ins" => "ami",
			"pl_loc" => "ach",
			"pl_voc" => "y"
		],
		[
			"noun_type" => "2o",
			"noun_type_name" => "o-変化名詞",			
			"gender" => "Feminine/Neuter",
			"sg_nom" => "o",
			"sg_gen" => "a",
			"sg_dat" => "u",
			"sg_acc" => "o",
			"sg_ins" => "em",
			"sg_loc" => "u",
			"sg_voc" => "o",
			"du_nom" => "e",
			"du_gen" => "u",
			"du_dat" => "oma",
			"du_acc" => "e",
			"du_ins" => "oma",
			"du_loc" => "u",
			"du_voc" => "e",
			"pl_nom" => "a",
			"pl_gen" => "",
			"pl_dat" => "om",
			"pl_acc" => "a",
			"pl_ins" => "ami",			
			"pl_loc" => "ach",
			"pl_voc" => "a"
		],
		[
			"noun_type" => "2e",
			"noun_type_name" => "e-変化名詞",			
			"gender" => "Feminine/Neuter",
			"sg_nom" => "e",
			"sg_gen" => "a",
			"sg_dat" => "u",
			"sg_acc" => "e",
			"sg_ins" => "em",
			"sg_loc" => "u",
			"sg_voc" => "e",
			"du_nom" => "e",
			"du_gen" => "u",
			"du_dat" => "oma",
			"du_acc" => "e",
			"du_ins" => "oma",
			"du_loc" => "u",
			"du_voc" => "e",
			"pl_nom" => "a",
			"pl_gen" => "",
			"pl_dat" => "om",
			"pl_acc" => "a",
			"pl_ins" => "ami",			
			"pl_loc" => "ach",
			"pl_voc" => "a"
		],		
		[
			"noun_type" => "2um",
			"noun_type_name" => "um-変化名詞",			
			"gender" => "Neuter",
			"sg_nom" => "um",
			"sg_gen" => "um",
			"sg_dat" => "um",
			"sg_acc" => "um",
			"sg_ins" => "um",
			"sg_loc" => "um",
			"sg_voc" => "um",
			"du_nom" => "e",
			"du_gen" => "u",
			"du_dat" => "oma",
			"du_acc" => "e",
			"du_ins" => "oma",
			"du_loc" => "u",
			"du_voc" => "e",
			"pl_nom" => "a",
			"pl_gen" => "",
			"pl_dat" => "om",
			"pl_acc" => "a",
			"pl_ins" => "ami",			
			"pl_loc" => "ach",
			"pl_voc" => "a"
		],
		[
			"noun_type" => "3n",
			"noun_type_name" => "n-変化名詞",
			"gender" => "Neuter",
			"sg_nom" => "ę",
			"sg_gen" => "enia",
			"sg_dat" => "eniu",
			"sg_acc" => "ę",
			"sg_ins" => "eniem",
			"sg_loc" => "eniu",
			"sg_voc" => "ę",
			"du_nom" => "enie",
			"du_gen" => "eniu",
			"du_dat" => "onoma",
			"du_acc" => "enie",
			"du_ins" => "onoma",
			"du_loc" => "eniu",
			"du_voc" => "enie",
			"pl_nom" => "ona",
			"pl_gen" => "on",
			"pl_dat" => "onom",
			"pl_acc" => "ona",
			"pl_ins" => "onami",
			"pl_loc" => "onach",
			"pl_voc" => "ona"
		],		
		[
			"noun_type" => "3con",
			"noun_type_name" => "子音変化名詞",
			"gender" => "Neuter",
			"sg_nom" => "ę",
			"sg_gen" => "ęcia",
			"sg_dat" => "ęciu",
			"sg_acc" => "ę",
			"sg_ins" => "ęciem",
			"sg_loc" => "ęciu",
			"sg_voc" => "ę",
			"du_nom" => "ęcie",
			"du_gen" => "ęciu",
			"du_dat" => "ętoma",
			"du_acc" => "ęcie",
			"du_ins" => "ętoma",
			"du_loc" => "ęciu",
			"du_voc" => "ęcie",
			"pl_nom" => "ęta",
			"pl_gen" => "ąt",
			"pl_dat" => "ętom",
			"pl_acc" => "ęta",
			"pl_ins" => "ętami",
			"pl_loc" => "ętach",
			"pl_voc" => "ęta"
		],
	];

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_polish1($noun) {
    	// 親クラス初期化
		parent::__construct();
		// 名詞情報をセット
		$this->set_data(htmlspecialchars($noun), "");
		// 活用表を挿入
		$this->get_noun_declension();
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_polish2($noun, $noun_genre) {
    	// 親クラス初期化
		parent::__construct();
		// 名詞情報をセット
		$this->set_data(htmlspecialchars($noun), $noun_genre);
		// 活用表を挿入
		$this->get_noun_declension();
    }	
    
    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
        $a = func_get_args();
        $i = func_num_args();
        //引数に応じて別々のコンストラクタを似非的に呼び出す
        if (method_exists($this,$f='__construct_polish'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }

    // 名詞情報を取得
    private function set_data($noun, $noun_genre){
    	// 名詞情報を取得
		$word_info = $this->get_noun_from_DB($noun, Polish_Common::DB_NOUN);
		// データがある場合は
		if($word_info){
			// データを挿入
			$this->first_stem = $word_info["weak_stem"];						//第一語幹
			$this->third_stem = mb_substr($word_info["strong_stem"], 0, -1);	//第三語幹
			$this->gender = $word_info["gender"];								//性別
			$this->noun_type = $word_info["noun_type"];							//名詞タイプ
			$this->japanese_translation = $word_info["japanese_translation"];	//日本語訳
			$this->english_translation = $word_info["english_translation"];		//英語訳
			$this->deponent_singular = $word_info["deponent_singular"];			//単数のみフラグ
			$this->deponent_plural = $word_info["deponent_plural"];				//複数のみフラグ
		} else {
			// 第一語幹・第三語幹生成
			$this->first_stem = $noun;
			$this->third_stem = $noun;

			// 日本語訳
			$this->japanese_translation = "借用";
			// 英語訳
			$this->english_translation = "loanword";
			
			// 文字列の最後で判断
			if(preg_match("/(k|g|ch)a$/", $noun)){						
				$this->gender = self::PIE_ACTION;    				// 性別
				$this->noun_type = "1k";           					// 名詞種別
			} else if(preg_match("/a$/", $noun)){				
				$this->gender = self::PIE_ACTION;					// 性別
				$this->third_stem = mb_substr($noun, 0, -1);		// 強語幹を変更						
				$this->noun_type = 1;								// 名詞種別
			} else if(preg_match("/ść$/", $noun)){						
				$this->gender = self::PIE_ACTION;    				// 性別
				$this->noun_type = "3i";        					// 名詞種別
				$this->third_stem = mb_substr($noun, 0, -1);		// 第三語幹					
			} else if(preg_match("/ół/", $noun)){						
				$this->gender = self::PIE_ANIMATE;    				// 性別
				$this->noun_type = "2p1";           				// 名詞種別
			} else if(preg_match("/(ć|dź|ń|ś|ź|l|j)$/", $noun)){	
				$this->gender = self::PIE_ANIMATE;    					// 性別
				$this->noun_type = "2p";           					// 名詞種別
			} else if(preg_match("/(c|cz|dz|dż|rz|sz|ż)$/", $noun)){	
				$this->gender = self::PIE_ANIMATE;    					// 性別
				$this->noun_type = "2p1";           				// 名詞種別				
			} else if(preg_match("/(d|f|ł|n|r|s|t|z|p|b|m|w)$/", $noun)){	
				$this->gender = self::PIE_ANIMATE;    					// 性別
				$this->noun_type = 2;           					// 名詞種別
			} else if(preg_match("/(k|g|ch)$/", $noun)){						
				$this->gender = self::PIE_ANIMATE;    				// 性別
				$this->noun_type = "2k";           					// 名詞種別
			} else if(preg_match("/(o)$/", $noun)){						
				$this->gender = "Neuter";    						// 性別
				$this->third_stem = mb_substr($noun, 0, -1);		// 強語幹を変更
				$this->noun_type = "2o";           					// 名詞種別	
			} else if(preg_match("/(e)$/", $noun)){						
				$this->gender = "Neuter";    						// 性別
				$this->third_stem = mb_substr($noun, 0, -1);		// 強語幹を変更
				$this->noun_type = "2e";           					// 名詞種別	
			} else if(preg_match("/(um)$/", $noun)){						
				$this->gender = "Neuter";    						// 性別
				$this->third_stem = mb_substr($noun, 0, -2);		// 強語幹を変更
				$this->noun_type = "2um";           				// 名詞種別									
			} else if(preg_match("/(ę)$/", $noun)){
				$this->gender = "Neuter";    						// 性別				
				$this->noun_type = "3con";          				// 名詞種別			
				$this->third_stem = mb_substr($noun, 0, -2)."n";	// 強語幹を変更
			} else {											
				$this->gender = self::PIE_ANIMATE;    				// 性別
				$this->noun_type = 2;           				// 名詞種別
			}

			// 男性名詞の場合は
			if($this->gender == self::PIE_ANIMATE){
				// 名詞の分類で活用を分ける。	
				if($noun_genre == "animate"){
					// 生物
					$this->gender = "Masculine-Animate"; 
				} else if($noun_genre == "animate"){
					// 無生物
					$this->gender = "Masculine-Inanimate"; 
				} else {
					// それ以外
					$this->gender = "Masculine-Animate"; 
				}
			}
		}
    }

    // 活用表セット
    private function get_noun_declension(){

		// 全ての接尾辞リストを参照
		$declension = $this->get_noun_case_suffix($this->noun_type, $this->gender);

		// 活用表を挿入	
		// 単数
		$this->case_suffix[Commons::SINGULAR][Commons::NOMINATIVE] = $declension["sg_nom"];
		$this->case_suffix[Commons::SINGULAR][Commons::GENETIVE] = $declension["sg_gen"];
		$this->case_suffix[Commons::SINGULAR][Commons::DATIVE] = $declension["sg_dat"];
		$this->case_suffix[Commons::SINGULAR][Commons::ACCUSATIVE] = $declension["sg_acc"];
		$this->case_suffix[Commons::SINGULAR][Commons::INSTRUMENTAL] = $declension["sg_ins"];
		$this->case_suffix[Commons::SINGULAR][Commons::LOCATIVE] = $declension["sg_loc"];
		$this->case_suffix[Commons::SINGULAR][Commons::VOCATIVE] = $declension["sg_voc"];
		
		// 双数
		$this->case_suffix[Commons::DUAL][Commons::NOMINATIVE] = $declension["du_nom"];
		$this->case_suffix[Commons::DUAL][Commons::GENETIVE] = $declension["du_gen"];
		$this->case_suffix[Commons::DUAL][Commons::DATIVE] = $declension["du_dat"];
		$this->case_suffix[Commons::DUAL][Commons::ACCUSATIVE] = $declension["du_acc"];
		$this->case_suffix[Commons::DUAL][Commons::INSTRUMENTAL] = $declension["du_ins"];
		$this->case_suffix[Commons::DUAL][Commons::LOCATIVE] = $declension["du_loc"];
		$this->case_suffix[Commons::DUAL][Commons::VOCATIVE] = $declension["du_voc"];
		
		// 複数
		$this->case_suffix[Commons::PLURAL][Commons::NOMINATIVE] = $declension["pl_nom"];
		$this->case_suffix[Commons::PLURAL][Commons::GENETIVE] = $declension["pl_gen"];
		$this->case_suffix[Commons::PLURAL][Commons::DATIVE] = $declension["pl_dat"];
		$this->case_suffix[Commons::PLURAL][Commons::ACCUSATIVE] = $declension["pl_acc"];
		$this->case_suffix[Commons::PLURAL][Commons::INSTRUMENTAL] = $declension["pl_ins"];
		$this->case_suffix[Commons::PLURAL][Commons::LOCATIVE] = $declension["pl_loc"];
		$this->case_suffix[Commons::PLURAL][Commons::VOCATIVE] = $declension["pl_voc"];

		// 活用種別名
		$this->noun_type_name = $declension["noun_type_name"];
    }

	// 名詞作成
	public function get_declensioned_noun($case, $number){

		// 格語尾を取得
		$case_suffix = "";
		//曲用語尾を取得(単数の複数の有無をチェック)
		if($number == Commons::SINGULAR && $this->deponent_singular != Commons::$TRUE){
			// 単数
			$case_suffix = $this->case_suffix[$number][$case];
		} else if($number == Commons::DUAL && ($this->deponent_plural != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
			// 双数
			$case_suffix = $this->case_suffix[$number][$case];			
		} else if($number == Commons::PLURAL && ($this->deponent_plural != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->case_suffix[$number][$case];
		} else {
			// ハイフンを返す。
			return "-";
		}

		// 語幹を取得
		if(($number == Commons::SINGULAR && $this->gender == "Neuter") && ($case == Commons::VOCATIVE || $case == Commons::NOMINATIVE)){
			// ここで結果を返す。
			return $this->first_stem;					
		} else if($case == Commons::ACCUSATIVE && $this->gender == "Neuter" && $number == Commons::SINGULAR){
			// 中性の単数対格は主格と同じ
			// ここで結果を返す。
			return $this->first_stem;
		} else {
			// それ以外は強語幹
			$noun = trim($this->third_stem.$case_suffix);					
		}

		// 連音処理
		$noun = Polish_Common::polish_sandhi($noun);

		// 結果を返す
		return $noun;
	}
	
	// 曲用表を取得
	public function get_chart(){
		
		// 初期化
		$word_chart = array();
		
		// タイトル情報を挿入
		$word_chart['title'] = $this->get_noun_title();
		// 辞書見出しを入れる。
		$word_chart['dic_title'] = $this->first_stem;
		// 活用種別を入れる。
		$word_chart['type'] = $this->noun_type_name;
		// 性別を入れる。
		$word_chart['gender'] = $this->get_gender_name();		
		// 曲用を入れる。
		$word_chart = $this->make_noun_declension($word_chart);
		// 結果を返す。
		return $word_chart;
	}

	// 語幹を取得
	public function get_first_stem(){
		return $this->first_stem;
	}		

	// 特定の格変化を取得する(ない場合はランダム)。
	public function get_form_by_number_case($case = "", $number = ""){

		// 格がない場合
		if($case == ""){
			// 単数・複数の中からランダムで選択
			$ary = array(Commons::NOMINATIVE, Commons::GENETIVE, Commons::DATIVE, Commons::ACCUSATIVE, Commons::INSTRUMENTAL, Commons::LOCATIVE, Commons::VOCATIVE);	// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$case = $ary[$key];			
		}

		// 数がない場合
		if($number == ""){
			// 単数・複数の中からランダムで選択
			$ary = array(Commons::SINGULAR, Commons::PLURAL);			// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$number = $ary[$key];			
		}

		// 配列に格納
		$question_data = array();
		$question_data['question_sentence'] = $this->get_noun_title()."の".$number." ".$case."を答えよ";
		$question_data['answer'] = $this->get_declensioned_noun($case, $number);
		$question_data['question_sentence2'] = $question_data['answer']."の数と格を答えよ";
		$question_data['case'] = $case;
		$question_data['number'] = $number;

		// 結果を返す。
		return $question_data;
	}

}

// ギリシア語共通クラス
class Koine_Noun extends Noun_Common_IE {

	// 格語尾リスト
	protected $case_suffix_list =  [
		[
			"noun_type" => "1a",
			"noun_type_name" => "ā-変化名詞",
			"gender" => "Feminine",
			"sg_nom" => "ᾱ",
			"sg_gen" => "ᾱς",
			"sg_dat" => "ᾳ",
			"sg_acc" => "ᾱν",
			"sg_voc" => "ᾱ",
			"du_nom" => "ᾱ",
			"du_gen" => "αιν",
			"du_dat" => "αιν",
			"du_acc" => "ᾱ",
			"du_voc" => "ᾱ",
			"pl_nom" => "αι",
			"pl_gen" => "ᾱς",
			"pl_dat" => "αις",
			"pl_acc" => "ᾱς",
			"pl_voc" => "αι"
		],
		[
			"noun_type" => "1as",
			"noun_type_name" => "as-変化名詞",			
			"gender" => "Masculine/Feminine",
			"sg_nom" => "ᾱς",
			"sg_gen" => "ου",
			"sg_dat" => "ᾳ",
			"sg_acc" => "ᾱν",
			"sg_voc" => "ᾱ",
			"du_nom" => "ᾱ́",
			"du_gen" => "αιν",
			"du_dat" => "αιν",
			"du_acc" => "ᾱ́",
			"du_voc" => "ᾱ́",
			"pl_nom" => "αι",
			"pl_gen" => "ῶν",
			"pl_dat" => "αις",
			"pl_acc" => "ᾱς",
			"pl_voc" => "αι"			
		],
		[
			"noun_type" => "1on",
			"noun_type_name" => "on-変化名詞",			
			"gender" => "Feminine",
			"sg_nom" => "ον",
			"sg_gen" => "ου",
			"sg_dat" => "ῳ",
			"sg_acc" => "ον",
			"sg_voc" => "ον",
			"du_nom" => "ω",
			"du_gen" => "οιν",
			"du_dat" => "οιν",
			"du_acc" => "ω",
			"du_voc" => "ω",
			"pl_nom" => "ᾰ",
			"pl_gen" => "ῶν",
			"pl_dat" => "οις",
			"pl_acc" => "ᾰ",
			"pl_voc" => "ᾰ"
		],
		[
			"noun_type" => "1e",
			"noun_type_name" => "ē-変化名詞",
			"gender" => "Feminine",
			"sg_nom" => "ή",
			"sg_gen" => "ῆς",
			"sg_dat" => "ῇ",
			"sg_acc" => "ήν",
			"sg_voc" => "ή",
			"du_nom" => "ᾱ́",
			"du_gen" => "αῖν",
			"du_dat" => "αῖν",
			"du_acc" => "ᾱ́",
			"du_voc" => "ᾱ́",
			"pl_nom" => "αί",
			"pl_gen" => "ῶν",
			"pl_dat" => "αῖς",
			"pl_acc" => "άς",
			"pl_voc" => "αί"
		],
		[
			"noun_type" => "1es",
			"noun_type_name" => "ēs-変化名詞",			
			"gender" => "Masculine/Feminine",
			"sg_nom" => "ής",
			"sg_gen" => "οῦ",
			"sg_dat" => "ῇ",
			"sg_acc" => "ήν",
			"sg_voc" => "ᾰ́",
			"du_nom" => "ᾱ́",
			"du_gen" => "αῖν",
			"du_dat" => "αῖν",
			"du_acc" => "ᾱ́",
			"du_voc" => "ᾱ́",
			"pl_nom" => "αι",
			"pl_gen" => "ῶν",
			"pl_dat" => "αῖς",
			"pl_acc" => "άς",
			"pl_voc" => "αι"			
		],
		[
			"noun_type" => "2",
			"noun_type_name" => "os-変化名詞",			
			"gender" => "Masculine/Feminine",
			"sg_nom" => "ος",
			"sg_gen" => "ου",
			"sg_dat" => "ῳ",
			"sg_acc" => "ον",
			"sg_voc" => "ε",
			"du_nom" => "ω",
			"du_gen" => "οιν",
			"du_dat" => "οιν",
			"du_acc" => "ω",
			"du_voc" => "ω",
			"pl_nom" => "οι",
			"pl_gen" => "ῶν",
			"pl_dat" => "οις",
			"pl_acc" => "ους",
			"pl_voc" => "οι"
		],
		[
			"noun_type" => "2on",
			"noun_type_name" => "on-変化名詞",			
			"gender" => "Neuter",
			"sg_nom" => "ον",
			"sg_gen" => "ου",
			"sg_dat" => "ῳ",
			"sg_acc" => "ον",
			"sg_voc" => "ον",
			"du_nom" => "ω",
			"du_gen" => "οιν",
			"du_dat" => "οιν",
			"du_acc" => "ω",
			"du_voc" => "ω",
			"pl_nom" => "ᾰ",
			"pl_gen" => "ῶν",
			"pl_dat" => "οις",
			"pl_acc" => "ᾰ",
			"pl_voc" => "ᾰ"
		],
		[
			"noun_type" => "root",
			"noun_type_name" => "語根名詞",	
			"gender" => "Feminine/Masculine",
			"sg_nom" => "",
			"sg_gen" => "ος",
			"sg_dat" => "ι",
			"sg_acc" => "α",
			"sg_voc" => "",
			"du_nom" => "ε",
			"du_gen" => "οιν",
			"du_dat" => "οιν",
			"du_acc" => "ε",
			"du_voc" => "ε",
			"pl_nom" => "ες",
			"pl_gen" => "ῶν",
			"pl_dat" => "ι",
			"pl_acc" => "ας",
			"pl_voc" => "ες"
		],
		[
			"noun_type" => "root",
			"noun_type_name" => "語根名詞",	
			"gender" => "Neuter",
			"sg_nom" => "ξ",
			"sg_gen" => "ος",
			"sg_dat" => "ι",
			"sg_acc" => "",
			"sg_voc" => "ξ",
			"du_nom" => "ε",
			"du_gen" => "οιν",
			"du_dat" => "οιν",
			"du_acc" => "ε",
			"du_voc" => "ε",
			"pl_nom" => "ᾰ",
			"pl_gen" => "ῶν",
			"pl_dat" => "ι",
			"pl_acc" => "ᾰ",
			"pl_voc" => "ᾰ"
		],
		[
			"noun_type" => "3t",
			"noun_type_name" => "t-変化名詞",
			"gender" => "Feminine/Masculine",
			"sg_nom" => "ς",
			"sg_gen" => "ος",
			"sg_dat" => "ι",
			"sg_acc" => "α",
			"sg_voc" => "ς",
			"du_nom" => "ε",
			"du_gen" => "οιν",
			"du_dat" => "οιν",
			"du_acc" => "ε",
			"du_voc" => "ε",
			"pl_nom" => "ᾰ",
			"pl_gen" => "ῶν",
			"pl_dat" => "ι",
			"pl_acc" => "ᾰ",
			"pl_voc" => "ᾰ"
		],
		[
			"noun_type" => "3nt",
			"noun_type_name" => "t-変化名詞",
			"gender" => "Feminine/Masculine",
			"sg_nom" => "ς",
			"sg_gen" => "ος",
			"sg_dat" => "ι",
			"sg_acc" => "α",
			"sg_voc" => "",
			"du_nom" => "ε",
			"du_gen" => "οιν",
			"du_dat" => "οιν",
			"du_acc" => "ε",
			"du_voc" => "ε",
			"pl_nom" => "ᾰ",
			"pl_gen" => "ῶν",
			"pl_dat" => "ι",
			"pl_acc" => "ᾰ",
			"pl_voc" => "ᾰ"
		],
		[
			"noun_type" => "3at",
			"noun_type_name" => "t-変化名詞",
			"gender" => "Neuter",
			"sg_nom" => "α",
			"sg_gen" => "ος",
			"sg_dat" => "ι",
			"sg_acc" => "α",
			"sg_voc" => "α",
			"du_nom" => "ε",
			"du_gen" => "οιν",
			"du_dat" => "οιν",
			"du_acc" => "ε",
			"du_voc" => "ε",
			"pl_nom" => "ᾰ",
			"pl_gen" => "ῶν",
			"pl_dat" => "ι",
			"pl_acc" => "ᾰ",
			"pl_voc" => "ᾰ"
		],
		[
			"noun_type" => "3n",
			"noun_type_name" => "n-変化名詞",
			"gender" => "Masculine",
			"sg_nom" => "",
			"sg_gen" => "ος",
			"sg_dat" => "ι",
			"sg_acc" => "α",
			"sg_voc" => "",
			"du_nom" => "ε",
			"du_gen" => "οιν",
			"du_dat" => "οιν",
			"du_acc" => "ε",
			"du_voc" => "ε",
			"pl_nom" => "ες",
			"pl_gen" => "ῶν",
			"pl_dat" => "ι",
			"pl_acc" => "ας",
			"pl_voc" => "ες"
		],
		[
			"noun_type" => "3n",
			"noun_type_name" => "n-変化名詞",
			"gender" => "Neuter",
			"sg_nom" => "",
			"sg_gen" => "ος",
			"sg_dat" => "ι",
			"sg_acc" => "",
			"sg_voc" => "",
			"du_nom" => "ε",
			"du_gen" => "οιν",
			"du_dat" => "οιν",
			"du_acc" => "ε",
			"du_voc" => "ε",
			"pl_nom" => "ᾰ",
			"pl_gen" => "ῶν",
			"pl_dat" => "ι",
			"pl_acc" => "ᾰ",
			"pl_voc" => "ᾰ"
		],
		[
			"noun_type" => "3con",
			"noun_type_name" => "子音変化名詞",
			"gender" => "Masculine/Feminine",
			"sg_nom" => "",
			"sg_gen" => "ος",
			"sg_dat" => "ι",
			"sg_acc" => "α",
			"sg_voc" => "",
			"du_nom" => "ε",
			"du_gen" => "οιν",
			"du_dat" => "οιν",
			"du_acc" => "ε",
			"du_voc" => "ε",
			"pl_nom" => "ες",
			"pl_gen" => "ῶν",
			"pl_dat" => "ι",
			"pl_acc" => "ας",
			"pl_voc" => "ες"
		],
		[
			"noun_type" => "3con",
			"noun_type_name" => "子音変化名詞",
			"gender" => "Neuter",
			"sg_nom" => "",
			"sg_gen" => "ος",
			"sg_dat" => "ι",
			"sg_acc" => "",
			"sg_voc" => "",
			"du_nom" => "ε",
			"du_gen" => "οιν",
			"du_dat" => "οιν",
			"du_acc" => "ε",
			"du_voc" => "ε",
			"pl_nom" => "ᾰ",
			"pl_gen" => "ῶν",
			"pl_dat" => "ι",
			"pl_acc" => "ᾰ",
			"pl_voc" => "ᾰ"
		],
		[
			"noun_type" => "double",
			"noun_type_name" => "二重母音名詞",
			"gender" => "Feminine/Masculine",
			"sg_nom" => "ύς",
			"sg_gen" => "ύως",
			"sg_dat" => "ῖ",
			"sg_acc" => "ᾱ",
			"sg_voc" => "ῦ",
			"du_nom" => "",
			"du_gen" => "οιν",
			"du_dat" => "οιν",
			"du_acc" => "",
			"du_voc" => "",
			"pl_nom" => "ῖς",
			"pl_gen" => "ων",
			"pl_dat" => "ῦσι",
			"pl_acc" => "ᾱς",
			"pl_voc" => "ῖς"
		],
		[
			"noun_type" => "o-long",
			"noun_type_name" => "ō-変化名詞",
			"gender" => "Feminine",
			"sg_nom" => "ώ",
			"sg_gen" => "οῦς",
			"sg_dat" => "οῖ",
			"sg_acc" => "ώ",
			"sg_voc" => "οῖ",
			"du_nom" => "ωε",
			"du_gen" => "ωοιν",
			"du_dat" => "ωοιν",
			"du_acc" => "ωε",
			"du_voc" => "ωε",
			"pl_nom" => "ωες",
			"pl_gen" => "ωων",
			"pl_dat" => "ωσι",
			"pl_acc" => "ωας",
			"pl_voc" => "ωες"
		],
		[
			"noun_type" => "os-long",
			"noun_type_name" => "ō-変化名詞",
			"gender" => "Masculine",
			"sg_nom" => "ως",
			"sg_gen" => "ωος",
			"sg_dat" => "ωι",
			"sg_acc" => "ωα",
			"sg_voc" => "ως",
			"du_nom" => "ωε",
			"du_gen" => "ωοιν",
			"du_dat" => "ωοιν",
			"du_acc" => "ωε",
			"du_voc" => "ωε",
			"pl_nom" => "ωες",
			"pl_gen" => "ωων",
			"pl_dat" => "ωσι",
			"pl_acc" => "ωας",
			"pl_voc" => "ωες"
		],
		[
			"noun_type" => "3r",
			"noun_type_name" => "r-変化名詞",
			"gender" => "Feminine/Masculine",
			"sg_nom" => "",
			"sg_gen" => "ος",
			"sg_dat" => "ι",
			"sg_acc" => "α",
			"sg_voc" => "",
			"du_nom" => "ε",
			"du_gen" => "οιν",
			"du_dat" => "οιν",
			"du_acc" => "ε",
			"du_voc" => "ε",
			"pl_nom" => "ες",
			"pl_gen" => "ῶν",
			"pl_dat" => "ι",
			"pl_acc" => "ας",
			"pl_voc" => "ες"
		],
		[
			"noun_type" => "3i",
			"noun_type_name" => "i-変化名詞",
			"gender" => "Feminine/Masculine",
			"sg_nom" => "ις",
			"sg_gen" => "εως",
			"sg_dat" => "ει",
			"sg_acc" => "ιν",
			"sg_voc" => "ι",
			"du_nom" => "ει",
			"du_gen" => "έοιν",
			"du_dat" => "έοιν",
			"du_acc" => "ει",
			"du_voc" => "ει",
			"pl_nom" => "εις",
			"pl_gen" => "εων",
			"pl_dat" => "εσι",
			"pl_acc" => "εις",
			"pl_voc" => "εις"
		],
		[
			"noun_type" => "4u",
			"noun_type_name" => "u-変化名詞",
			"gender" => "Feminine/Masculine",
			"sg_nom" => "ύς",
			"sg_gen" => "ύως",
			"sg_dat" => "ύι",
			"sg_acc" => "ύν",
			"sg_voc" => "ύ",
			"du_nom" => "ύι",
			"du_gen" => "ύοιν",
			"du_dat" => "ύοιν",
			"du_acc" => "ύι",
			"du_voc" => "ύι",
			"pl_nom" => "ύις",
			"pl_gen" => "ύων",
			"pl_dat" => "ύσι",
			"pl_acc" => "ύις",
			"pl_voc" => "ύις"
		],
	];
    
	// 副詞種別
	protected const adverb_suffix = "φῐ";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_koine3($compound, $last_word, $translation) {
    	// 親クラス初期化
		parent::__construct();
		// 情報をセット
		$this->set_data($last_word, "");
		// 残りの語幹を作成
		$this->make_other_stem();
		// 語幹を変更
		$this->first_stem = Sanskrit_Common::sandhi_engine($compound, $this->first_stem);		// 第一語幹
		$this->second_stem = Sanskrit_Common::sandhi_engine($compound, $this->second_stem);		// 第二語幹		
		$this->third_stem = Sanskrit_Common::sandhi_engine($compound, $this->third_stem);		// 第三語幹
		// 日本語訳を書き換え
		$this->japanese_translation = $translation;			// 日本語訳
		$this->english_translation = "";			// 英語訳
		
		// 活用表を挿入
		$this->get_noun_declension();
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_koine1($noun) {
    	// 親クラス初期化
		parent::__construct();
		// 名詞情報をセット
		$this->set_data(htmlspecialchars($noun));
		// 残りの語幹を作成
		$this->make_other_stem();
		// 活用表を挿入
		$this->get_noun_declension();
    }
    
    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
        $a = func_get_args();
        $i = func_num_args();
        //引数に応じて別々のコンストラクタを似非的に呼び出す
        if (method_exists($this,$f='__construct_koine'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }
    
    // 活用表セット
    private function get_noun_declension(){

		// 全ての接尾辞リストを参照
		$declension = $this->get_noun_case_suffix($this->noun_type, $this->gender);

		// 活用表を挿入	
		// 単数
		$this->case_suffix[Commons::SINGULAR][Commons::NOMINATIVE] = $declension["sg_nom"];
		$this->case_suffix[Commons::SINGULAR][Commons::GENETIVE] = $declension["sg_gen"];
		$this->case_suffix[Commons::SINGULAR][Commons::DATIVE] = $declension["sg_dat"];
		$this->case_suffix[Commons::SINGULAR][Commons::ACCUSATIVE] = $declension["sg_acc"];
		$this->case_suffix[Commons::SINGULAR][Commons::VOCATIVE] = $declension["sg_voc"];
		
		// 双数
		$this->case_suffix[Commons::DUAL][Commons::NOMINATIVE] = $declension["du_nom"];
		$this->case_suffix[Commons::DUAL][Commons::GENETIVE] = $declension["du_gen"];
		$this->case_suffix[Commons::DUAL][Commons::DATIVE] = $declension["du_dat"];
		$this->case_suffix[Commons::DUAL][Commons::ACCUSATIVE] = $declension["du_acc"];
		$this->case_suffix[Commons::DUAL][Commons::VOCATIVE] = $declension["du_voc"];
		
		// 複数
		$this->case_suffix[Commons::PLURAL][Commons::NOMINATIVE] = $declension["pl_nom"];
		$this->case_suffix[Commons::PLURAL][Commons::GENETIVE] = $declension["pl_gen"];
		$this->case_suffix[Commons::PLURAL][Commons::DATIVE] = $declension["pl_dat"];
		$this->case_suffix[Commons::PLURAL][Commons::ACCUSATIVE] = $declension["pl_acc"];
		$this->case_suffix[Commons::PLURAL][Commons::VOCATIVE] = $declension["pl_voc"];

		// 活用種別名
		$this->noun_type_name = $declension["noun_type_name"];
    }

	// 語幹を作成
	private function make_other_stem(){
		// 活用種別に合わせて語幹を作る。
		if(preg_match('/^(1|2)/',$this->noun_type)){
			// 第一・第二変化活用の場合
			$this->first_stem = $this->second_stem;		// 弱語幹
			$this->third_stem = $this->second_stem;		// 強語幹
		} else if(preg_match('/^(root|3t|3con)/',$this->noun_type)){
			// 子音活用の場合			
			if(preg_match('/(τ|δ|θ)$/',$this->second_stem)){				
				$this->first_stem = mb_substr($this->second_stem, 0, -1);			
				$this->third_stem = mb_substr($this->second_stem, 0, -1)."σ";
			} else if(preg_match('/(κ|γ|χ)$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -1);			
				$this->third_stem = mb_substr($this->second_stem, 0, -1)."ξ";			
			} else if(preg_match('/(π|β|φ)$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -1);			
				$this->third_stem = mb_substr($this->second_stem, 0, -1)."ψ";	
			}
		} else if(preg_match('/^(3at)/',$this->noun_type)){
			// 子音活用の場合			
			$this->first_stem = mb_substr($this->second_stem, 0, -1);			
			$this->third_stem = mb_substr($this->second_stem, 0, -1)."τ";
		} else if(preg_match('/^(3nt)/',$this->noun_type)){
			// 子音活用の場合			
			$this->first_stem = mb_substr($this->second_stem, 0, -1);			
			$this->third_stem = mb_substr($this->second_stem, 0, -1)."ντ";
		} else if(preg_match('/^(3n)/',$this->noun_type)){
			// 子音活用の場合			
			$this->first_stem = mb_substr($this->second_stem, 0, -1);			
			$this->third_stem = mb_substr($this->second_stem, 0, -1)."ν";
		} else {
			// それ以外の活用の場合				
			$this->first_stem = $this->second_stem;			// 弱語幹
			$this->third_stem = $this->second_stem;			// 強語幹
		}
	}
    
    // 名詞情報を取得
    private function set_data($noun){
    	// 名詞情報を取得
		$word_info = $this->get_noun_from_DB($noun, Koine_Common::DB_NOUN, false);
		// データがある場合は
		if($word_info){
			// データを挿入
			$this->second_stem = $word_info["stem"];							// 第二語幹			
			$this->gender = $word_info["gender"];								// 性別
			$this->noun_type = $word_info["noun_type"];							// 名詞タイプ			
			$this->japanese_translation = $word_info["japanese_translation"];	// 日本語訳
			$this->english_translation = $word_info["english_translation"];		// 英語訳
			$this->deponent_singular = $word_info["deponent_singular"];			// 単数なし
			$this->deponent_plural = $word_info["deponent_singular"];			// 複数なし
			$this->location_name = $word_info["deponent_singular"];				// 地名・名前フラグ
		} else {
			// 見つからない場合は手動で設定
			$this->set_data_manual($noun);
		}
    }

	// 語幹を手動作成
	private function set_data_manual($noun){
		// 第一語幹・第三語幹生成
		$this->second_stem = $noun;												// 第二語幹
		// 日本語訳
		$this->japanese_translation = "借用";
		// 英語訳
		$this->english_translation = "loanword";
		
		// 文字列の最後で判断
		if(preg_match('/(α|ᾱ)$/',$noun)){		
			// 名詞の種別で性別・活用が決定する。		
			$this->gender = "Feminine";    						// 名詞区分
			$this->noun_type = "1a";           					// 名詞種別
			$this->second_stem = mb_substr($this->second_stem, 0, -1);	// 第二語幹
		} else if(preg_match('/(ή|η)$/',$noun)){		
			// 名詞の種別で性別・活用が決定する。		
			$this->gender = "Feminine";									// 名詞区分
			$this->noun_type = "1e";									// 名詞種別
			$this->second_stem = mb_substr($this->second_stem, 0, -2);	// 第二語幹
		} else if(preg_match('/(ασ|ας|ᾱσ|ᾱς)$/',$noun)){		
			// 名詞の種別で性別・活用が決定する。		
			$this->gender = "Masculine";								// 名詞区分
			$this->noun_type = "1as";									// 名詞種別
			$this->second_stem = mb_substr($this->second_stem, 0, -2);	// 第二語幹
		} else if(preg_match('/(ή|η)$/',$noun)){		
			// 名詞の種別で性別・活用が決定する。		
			$this->gender = "Feminine";									// 名詞区分
			$this->noun_type = "1e";									// 名詞種別
			$this->second_stem = mb_substr($this->second_stem, 0, -2);	// 第二語幹
		} else if(preg_match('/(ήσ|ής|ησ|ης)$/',$noun)){		
			// 名詞の種別で性別・活用が決定する。		
			$this->gender = "Masculine";								// 名詞区分
			$this->noun_type = "1as";									// 名詞種別
			$this->second_stem = mb_substr($this->second_stem, 0, -2);	// 第二語幹
		} else if(preg_match('/(οσ|ος)$/',$noun)){		
			// 名詞の種別で性別・活用が決定する。		
			$this->gender = "Masculine";								// 名詞区分
			$this->noun_type = 2;										// 名詞種別
			$this->second_stem = mb_substr($this->second_stem, 0, -2);	// 第二語幹
		} else if(preg_match('/(ο)$/',$noun)){		
			// 名詞の種別で性別・活用が決定する。		
			$this->gender = "Neuter";									// 名詞区分
			$this->noun_type = "2on";									// 名詞種別
			$this->second_stem = mb_substr($this->second_stem, 0, -1);	// 第二語幹
		} else if(preg_match('/(ον)$/',$noun)){		
			// 名詞の種別で性別・活用が決定する。		
			$this->gender = "Neuter";									// 名詞区分
			$this->noun_type = "2on";									// 名詞種別
			$this->second_stem = mb_substr($this->second_stem, 0, -2);	// 第二語幹		
		} else if(preg_match('/(υ)$/',$noun)){		
			// 名詞の種別で性別・活用が決定する。		
			$this->gender = "Masculine";						// 名詞区分
			$this->noun_type = 4;								// 名詞種別
		} else if(preg_match('/(ι)$/',$noun)){		
			// 名詞の種別で性別・活用が決定する。								
			$this->gender = "Masculine";						// 名詞区分
			$this->noun_type = "3i";							// 名詞種別
		} else if(preg_match('/(η)$/',$noun)){
			// 名詞の種別で性別・活用が決定する。		
			$this->gender = "Feminine";    						// 名詞区分
			$this->noun_type = "1e";           					// 名詞種別
		} else if(preg_match('/(λ|ρ)$/',$noun)){
			$this->gender = "Masculine";						// 名詞区分
			$this->noun_type = "3r";							// 名詞種別				
		} else if(preg_match('/(τ|ς)$/',$noun)){
			$this->gender = "Masculine";						// 名詞区分
			$this->noun_type = "3con";							// 名詞種別	
		} else if(preg_match('/(ν)$/',$noun)){
			$this->gender = "Masculine";						// 名詞区分
			$this->noun_type = "3n";							// 名詞種別										
		} else {														
			// 名詞の種別で性別・活用が決定する。		
			$this->gender = "Masculine";						// 名詞区分
			$this->noun_type = 2;								// 名詞種別
		}
	}

	// 名詞作成
	public function get_declensioned_noun($case, $number){

		// 語幹が存在しない場合は返さない。
		if($this->third_stem == ""){
			return "-";
		}

		// 格語尾を取得
		$case_suffix = "";
		//曲用語尾を取得(単数の複数の有無をチェック)
		if($number == Commons::SINGULAR && $this->deponent_singular != Commons::$TRUE){
			// 単数
			$case_suffix = $this->case_suffix[$number][$case];
		} else if($number == Commons::DUAL && ($this->deponent_plural != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
			// 双数
			$case_suffix = $this->case_suffix[$number][$case];			
		} else if($number == Commons::PLURAL && ($this->deponent_plural != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->case_suffix[$number][$case];
		} else {
			// ハイフンを返す。
			return "-";
		}

		// 語幹を取得
		$stem = "";

		// 性・数・格に応じて語幹を生成
		if($number == Commons::SINGULAR && ($case == Commons::NOMINATIVE || $case == Commons::VOCATIVE)){
			// 単数主格・呼格
			$stem = $this->first_stem;
		} else if($number == Commons::SINGULAR && $this->gender == "Neuter" && $case == Commons::ACCUSATIVE){
			// 単数対格(中性)
			$stem = $this->first_stem;	
		} else if ($number == Commons::PLURAL && $case == Commons::DATIVE){
			// 複数与格
			$stem = $this->third_stem;	
		} else {
			$stem = $this->second_stem;	
		}

		// 結果を返す
		return htmlspecialchars($stem.$case_suffix);
	}

	// 語幹を取得
	public function get_second_stem(){
		return $this->second_stem;
	}

	// 語幹を取得
	public function get_third_stem(){
		return $this->third_stem;
	}

	// 曲用表を取得
	public function get_chart(){
		
		// 初期化
		$word_chart = array();
		
		// タイトル情報を挿入
		$word_chart['title'] = $this->get_noun_title();
		// 辞書見出しを入れる。
		$word_chart['dic_title'] = $this->get_second_stem();
		// 種別を入れる。
		$word_chart['category'] = "名詞";
		// 活用種別を入れる。
		$word_chart['type'] = $this->noun_type_name;
		// 性別を入れる。
		$word_chart['gender'] = $this->get_gender_name();
		// 曲用を入れる。
		$word_chart = $this->make_noun_declension($word_chart);

		// 副詞(拡張格)
		$word_chart[Commons::SINGULAR]["allative"] = $this->second_stem."δε";
		$word_chart[Commons::SINGULAR]["allative2"] = $this->second_stem."σε";
		$word_chart[Commons::SINGULAR][Commons::INSTRUMENTAL] = $this->second_stem."δον";
		$word_chart[Commons::SINGULAR][Commons::ABLATIVE] = $this->second_stem."θεν";
		$word_chart[Commons::SINGULAR][Commons::LOCATIVE] = $this->second_stem."θι";
		$word_chart[Commons::DUAL][Commons::INSTRUMENTAL] = $this->second_stem.self::adverb_suffix;
		$word_chart[Commons::DUAL][Commons::ABLATIVE] = $this->second_stem.self::adverb_suffix;
		$word_chart[Commons::DUAL][Commons::LOCATIVE] = $this->second_stem.self::adverb_suffix;
		$word_chart[Commons::PLURAL][Commons::INSTRUMENTAL] = $this->second_stem.self::adverb_suffix;
		$word_chart[Commons::PLURAL][Commons::ABLATIVE] = $this->second_stem.self::adverb_suffix;
		$word_chart[Commons::PLURAL][Commons::LOCATIVE] = $this->second_stem.self::adverb_suffix;

		// 結果を返す。
		return $word_chart;
	}

	// 特定の格変化を取得する(ない場合はランダム)。
	public function get_form_by_number_case($case = "", $number = ""){

		// 格がない場合
		if($case == ""){
			// 単数・複数の中からランダムで選択
			$ary = array(Commons::NOMINATIVE, Commons::GENETIVE, Commons::DATIVE, Commons::ACCUSATIVE, Commons::VOCATIVE);	// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$case = $ary[$key];			
		}

		// 数がない場合
		if($number == ""){
			// 単数・複数の中からランダムで選択
			$ary = array(Commons::SINGULAR, Commons::DUAL, Commons::PLURAL);			// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$number = $ary[$key];			
		}

		// 配列に格納
		$question_data = array();
		$question_data['question_sentence'] = $this->get_noun_title()."の".$number." ".$case."を答えよ";
		$question_data['answer'] = $this->get_declensioned_noun($case, $number);
		$question_data['question_sentence2'] = $question_data['answer']."の数と格を答えよ";
		$question_data['case'] = $case;
		$question_data['number'] = $number;

		// 結果を返す。
		return $question_data;
	}
}


?>