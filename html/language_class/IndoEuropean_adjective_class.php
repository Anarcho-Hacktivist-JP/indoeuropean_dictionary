<?php

// インドヨーロッパ語形容詞クラス
class Adjective_Common_IE {

	// 格語尾リスト
	protected $case_suffix_list =  [
		[
			"adjective_type" => "vowel",
			"adjective_type_name" => "母音活用",				
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
			"adjective_type" => "consonant",
			"adjective_type_name" => "子音活用",			
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
	
	// 比較級第一語幹
	protected $comparative_first_stem = "";

	// 比較級第二語幹
	protected $comparative_second_stem = "";	

	// 比較級第三語幹
	protected $comparative_third_stem = "";
	
	// 最上級弱語幹
	protected $superlative_first_stem= "";

	// 最上級弱語幹
	protected $superlative_second_stem = "";	
	
	// 最上級強語幹
	protected $superlative_third_stem = "";
	
	// 日本語訳
	protected $japanese_translation = "";
	
	// 英語訳
	protected $english_translation = "";
	
	// 活用種別
	protected $adjective_type = "";

	// 活用種別名
	protected $adjective_type_name = "";	

	// 単数なしフラグ
	protected $deponent_singular = "";

	// 複数なしフラグ
	protected $deponent_plural = "";

	// 原級格語尾
	protected $case_suffix = 
	[
		"masc" => 
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
		],
		"fem" => 
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
		],
		"neu" => 
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
		],
	];
	
	// 比較級語尾
	protected $comparative_case_suffix = 
	[
		"masc" => 
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
		],
		"fem" => 
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
		],
		"neu" => 
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
		],
	];
	
	// 最上級語尾
	protected $superlative_case_suffix = 
	[
		"masc" => 
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
		],
		"fem" => 
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
		],
		"neu" => 
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
		],
	];

	// 地名フラグ
	protected $location_name = "";

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
    function __construct1($adjective)
    {
		// 形容詞情報を取得
		$this->set_adj_data($adjective);

		// 初期化
		$masculine_declensioninfo = $this->get_adjective_case_suffix($this->adjective_type, Commons::ANIMATE_GENDER);
		$feminine_declensioninfo = $this->get_adjective_case_suffix($this->adjective_type, Commons::ACTION_GENDER);
		$neuter_declensioninfo = $this->get_adjective_case_suffix($this->adjective_type, Commons::INANIMATE_GENDER);

		// 活用表を挿入(男性)
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::NOMINATIVE] = $masculine_declensioninfo["sg_nom"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::GENETIVE] = $masculine_declensioninfo["sg_gen"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::DATIVE] = $masculine_declensioninfo["sg_dat"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::ACCUSATIVE] = $masculine_declensioninfo["sg_acc"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::ABLATIVE] = $masculine_declensioninfo["sg_abl"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::INSTRUMENTAL] = $masculine_declensioninfo["sg_ins"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::LOCATIVE] = $masculine_declensioninfo["sg_loc"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::VOCATIVE] = $masculine_declensioninfo["sg_voc"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::NOMINATIVE] = $masculine_declensioninfo["du_nom"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::GENETIVE] = $masculine_declensioninfo["du_gen"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::DATIVE] = $masculine_declensioninfo["du_dat"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::ACCUSATIVE] = $masculine_declensioninfo["du_acc"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::ABLATIVE] = $masculine_declensioninfo["du_abl"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::INSTRUMENTAL] = $masculine_declensioninfo["du_ins"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::LOCATIVE] = $masculine_declensioninfo["du_loc"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::VOCATIVE] = $masculine_declensioninfo["du_voc"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::NOMINATIVE] = $masculine_declensioninfo["pl_nom"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::GENETIVE] = $masculine_declensioninfo["pl_gen"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::DATIVE] = $masculine_declensioninfo["pl_dat"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::ACCUSATIVE] = $masculine_declensioninfo["pl_acc"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::ABLATIVE] = $masculine_declensioninfo["pl_abl"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::INSTRUMENTAL] = $masculine_declensioninfo["pl_ins"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::LOCATIVE] = $masculine_declensioninfo["pl_loc"];
		$this->case_suffix[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::VOCATIVE] = $masculine_declensioninfo["pl_voc"];

		// 活用表を挿入(女性)
		$this->case_suffix[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::NOMINATIVE] = $feminine_declensioninfo["sg_nom"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::GENETIVE] = $feminine_declensioninfo["sg_gen"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::DATIVE] = $feminine_declensioninfo["sg_dat"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::ACCUSATIVE] = $feminine_declensioninfo["sg_acc"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::ABLATIVE] = $feminine_declensioninfo["sg_abl"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::INSTRUMENTAL] = $feminine_declensioninfo["sg_ins"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::LOCATIVE] = $feminine_declensioninfo["sg_loc"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::VOCATIVE] = $feminine_declensioninfo["sg_voc"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::DUAL][Commons::NOMINATIVE] = $feminine_declensioninfo["du_nom"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::DUAL][Commons::GENETIVE] = $feminine_declensioninfo["du_gen"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::DUAL][Commons::DATIVE] = $feminine_declensioninfo["du_dat"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::DUAL][Commons::ACCUSATIVE] = $feminine_declensioninfo["du_acc"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::DUAL][Commons::ABLATIVE] = $feminine_declensioninfo["du_abl"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::DUAL][Commons::INSTRUMENTAL] = $feminine_declensioninfo["du_ins"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::DUAL][Commons::LOCATIVE] = $feminine_declensioninfo["du_loc"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::DUAL][Commons::VOCATIVE] = $feminine_declensioninfo["du_voc"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::PLURAL][Commons::NOMINATIVE] = $feminine_declensioninfo["pl_nom"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::PLURAL][Commons::GENETIVE] = $feminine_declensioninfo["pl_gen"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::PLURAL][Commons::DATIVE] = $feminine_declensioninfo["pl_dat"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::PLURAL][Commons::ACCUSATIVE] = $feminine_declensioninfo["pl_acc"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::PLURAL][Commons::ABLATIVE] = $feminine_declensioninfo["pl_abl"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::PLURAL][Commons::INSTRUMENTAL] = $feminine_declensioninfo["pl_ins"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::PLURAL][Commons::LOCATIVE] = $feminine_declensioninfo["pl_loc"];
		$this->case_suffix[Commons::ACTION_GENDER][Commons::PLURAL][Commons::VOCATIVE] = $feminine_declensioninfo["pl_voc"];
		
		// 活用表を挿入(中性)
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::NOMINATIVE] = $neuter_declensioninfo["sg_nom"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::GENETIVE] = $neuter_declensioninfo["sg_gen"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::DATIVE] = $neuter_declensioninfo["sg_dat"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::ACCUSATIVE] = $neuter_declensioninfo["sg_acc"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::ABLATIVE] = $neuter_declensioninfo["sg_abl"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::INSTRUMENTAL] = $neuter_declensioninfo["sg_ins"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::LOCATIVE] = $neuter_declensioninfo["sg_loc"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::VOCATIVE] = $neuter_declensioninfo["sg_voc"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::NOMINATIVE] = $neuter_declensioninfo["du_nom"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::GENETIVE] = $neuter_declensioninfo["du_gen"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::DATIVE] = $neuter_declensioninfo["du_dat"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::ACCUSATIVE] = $neuter_declensioninfo["du_acc"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::ABLATIVE] = $neuter_declensioninfo["du_abl"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::INSTRUMENTAL] = $neuter_declensioninfo["du_ins"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::LOCATIVE] = $neuter_declensioninfo["du_loc"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::VOCATIVE] = $neuter_declensioninfo["du_voc"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::NOMINATIVE] = $neuter_declensioninfo["pl_nom"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::GENETIVE] = $neuter_declensioninfo["pl_gen"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::DATIVE] = $neuter_declensioninfo["pl_dat"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::ACCUSATIVE] = $neuter_declensioninfo["pl_acc"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::ABLATIVE] = $neuter_declensioninfo["pl_abl"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::INSTRUMENTAL] = $neuter_declensioninfo["pl_ins"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::LOCATIVE] = $neuter_declensioninfo["pl_loc"];
		$this->case_suffix[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::VOCATIVE] = $neuter_declensioninfo["pl_voc"];
    }

	// 形容詞の格変化を取得する。
	protected function get_adjective_case_suffix($adjective_type, $gender){
		// 全ての接尾辞リストを参照
		foreach ($this->case_suffix_list as $case_suffix) {
			//　曲用種別と性別が一致する場合は
			if($case_suffix["adjective_type"] == $adjective_type && 
			   strpos($case_suffix["gender"], $gender) !== false){
				// 結果を返す
				return $case_suffix;
			}
		}
		
		//取得できない場合はnull
		return null;
	}
    
    // 形容詞情報取得
	protected function get_adjective_from_DB($adjective, $table){
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `".$table."` WHERE `dictionary_stem` = '".$adjective."'";
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
	
    // 形容詞情報を取得
    private function set_adj_data($adjective){

    	// 形容詞情報を取得
		$word_info = $this->get_adjective_from_DB($adjective, "adjective_pie", false);
		if($word_info){
			// データを挿入
			$this->first_stem = $word_info["weak_stem"];						// 弱語幹
			$this->third_stem = substr($word_info["strong_stem"], 0, -1);	// 強語幹
			$this->adjective_type = $word_info["adjective_type"];			// 形容詞種別
		}
    }
	
	//形容詞変化作成
	protected function get_declensioned_adjective($case, $number, $gender, $grade){
		// 語幹が存在しない場合は返さない。
		if($this->third_stem == ""){
			return "-";
		}

		// 初期化
		$adjective = "";
		// 形容詞の程度で分岐する。
		if($grade == Commons::ADJ_GRADE_POSITIVE){
			$adjective = $this->generate_positive($case, $number, $gender);
		} else if($grade == Commons::ADJ_GRADE_COMPERATIVE){
			$adjective = $this->generate_comp($case, $number, $gender);
		} else if($grade == Commons::ADJ_GRADE_SUPERATIVE){
			$adjective = $this->generate_super($case, $number, $gender);
		}

		// 結果を返す
		return trim($adjective);
	}

	// 原級形容詞作成
	protected function generate_positive($case, $number, $gender){
		// 格語尾を取得
		$case_suffix = $this->case_suffix[$gender][$number][$case];
		// 形容詞と結合
		if($case == Commons::NOMINATIVE && $number == Commons::SINGULAR){
			// 弱語幹の場合
			$adjective = $this->first_stem;
		} else if($case == Commons::ACCUSATIVE && $number == Commons::SINGULAR && $gender == Commons::INANIMATE_GENDER){
			// 強語幹の場合
			$adjective = $this->first_stem;
		} else {
			// 強語幹の場合
			$adjective = $this->third_stem.$case_suffix;
		}		
		// 結果を返す
		return $adjective;
	}

	// 比較級形容詞作成
	protected function generate_comp($case, $number, $gender){
		// 格語尾を取得
		$case_suffix = $this->comparative_case_suffix[$gender][$number][$case];
		// 形容詞と結合
		if($case == Commons::NOMINATIVE && $number == Commons::SINGULAR){
			// 弱語幹の場合
			$adjective = $this->comparative_first_stem;
		} else if($case == Commons::ACCUSATIVE && $number == Commons::SINGULAR && $gender == Commons::INANIMATE_GENDER){
			// 強語幹の場合
			$adjective = $this->comparative_first_stem;
		} else {
			// 強語幹の場合
			$adjective = $this->comparative_third_stem.$case_suffix;
		}	
		// 結果を返す
		return $adjective;
	}

	// 最上級形容詞作成
	protected function generate_super($case, $number, $gender){
		// 格語尾を取得
		$case_suffix = $this->superlative_case_suffix[$gender][$number][$case];
		// 形容詞と結合
		if($case == Commons::NOMINATIVE && $number == Commons::SINGULAR){
			// 弱語幹の場合
			$adjective = $this->superlative_first_stem;
		} else if($case == Commons::ACCUSATIVE && $number == Commons::SINGULAR && $gender == Commons::INANIMATE_GENDER){
			// 強語幹の場合
			$adjective = $this->superlative_first_stem;
		} else {
			// 強語幹の場合
			$adjective = $this->superlative_third_stem.$case_suffix;
		}		
		// 結果を返す
		return $adjective;
	}
    
    // 形容詞のタイトルを取得
    public function get_adjective_title(){

    	// タイトルを作る
    	$adjective_title = $this->first_stem;

		// 英語訳がある場合は
		if ($this->english_translation != ""){
			// 訳を入れる。
			$adjective_title = $adjective_title." 英語：".$this->english_translation."、";
		}
		
		// 日本語訳がある場合は
		if ($this->japanese_translation != ""){
			// 訳を入れる。
			$adjective_title = $adjective_title." 日本語：".$this->japanese_translation."";
		}

		// 結果を返す。
		return $this->adjective_type_name."  ".$adjective_title;
    }

	// 曲用表を作成
	protected function make_adjective_declension($word_chart){
		// 格変化配列
		$case_array = array(Commons::NOMINATIVE, Commons::GENETIVE, Commons::DATIVE, Commons::ACCUSATIVE, Commons::ABLATIVE, Commons::INSTRUMENTAL, Commons::LOCATIVE, Commons::VOCATIVE);
		// 数配列
		$number_array = array(Commons::SINGULAR, Commons::DUAL, Commons::PLURAL);
		// 名詞クラス配列
		$gender_array = array(Commons::ANIMATE_GENDER, Commons::ACTION_GENDER, Commons::INANIMATE_GENDER);
		// 形容詞級
		$grande_array = array(Commons::ADJ_GRADE_POSITIVE, Commons::ADJ_GRADE_COMPERATIVE, Commons::ADJ_GRADE_SUPERATIVE);

		// 全ての級
		foreach ($grande_array as $grade){
			// 全ての名詞クラス
			foreach ($gender_array as $gender){
				// 全ての数
				foreach ($number_array as $number){
					// 全ての格			
					foreach ($case_array as $case){
						// 数・格に応じて多次元配列を作成		
						$word_chart[$grade][$gender][$number][$case] = $this->get_declensioned_adjective($case, $number, $gender, $grade);
					}
				}
			}
		}

		// 結果を返す。
		return $word_chart;
	}

}

// ラテン語形容詞クラス
class Latin_Adjective extends Adjective_Common_IE {

	// 格語尾リスト
	protected $case_suffix_list =
		[
			[
				"adjective_type" => "1-2",
				"adjective_type_name" => "第一・第二活用",
				"gender" => "Feminine",
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
				"adjective_type" => "1-2",
				"adjective_type_name" => "第一・第二活用",				
				"gender" => "Masculine",
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
				"adjective_type" => "1-2",
				"adjective_type_name" => "第一・第二活用",				
				"gender" => "Neuter",
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
				"pl_voc" => "a"
			],
			[
				"adjective_type" => "1-2r",
				"adjective_type_name" => "第一・第二活用(r語幹)",				
				"gender" => "Feminine",
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
				"adjective_type" => "1-2r",
				"adjective_type_name" => "第一・第二活用(r語幹)",				
				"gender" => "Masculine",
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
				"adjective_type" => "1-2r",
				"adjective_type_name" => "第一・第二活用(r語幹)",				
				"gender" => "Neuter",
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
				"pl_voc" => "a"
			],
			[
				"adjective_type" => "1-2gr1",
				"adjective_type_name" => "第一・第二活用(ギリシア式)",
				"gender" => "Feminine",
				"sg_nom" => "a",
				"sg_gen" => "ae",
				"sg_dat" => "ae",
				"sg_acc" => "an",
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
				"adjective_type" => "1-2gr1",
				"adjective_type_name" => "第一・第二活用(ギリシア式)",				
				"gender" => "Masculine",
				"sg_nom" => "os",
				"sg_gen" => "ī",
				"sg_dat" => "ō",
				"sg_acc" => "on",
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
				"adjective_type" => "1-2gr1",
				"adjective_type_name" => "第一・第二活用(ギリシア式)",				
				"gender" => "Neuter",
				"sg_nom" => "on",
				"sg_gen" => "ī",
				"sg_dat" => "ō",
				"sg_acc" => "on",
				"sg_abl" => "ō(d)",
				"sg_loc" => "ī",
				"sg_voc" => "on",
				"pl_nom" => "a",
				"pl_gen" => "ōrum",
				"pl_dat" => "īs",
				"pl_acc" => "a",
				"pl_abl" => "īs",
				"pl_loc" => "īs",
				"pl_voc" => "a"
			],
			[
				"adjective_type" => "3s",
				"adjective_type_name" => "第三活用(s語幹)",
				"gender" => "Masculine/Feminine",				
				"sg_nom" => "s",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "em",
				"sg_abl" => "ī(d)",
				"sg_loc" => "i",
				"sg_voc" => "s",
				"pl_nom" => "ēs",
				"pl_gen" => "ium",
				"pl_dat" => "ibus",
				"pl_acc" => "ēs",
				"pl_abl" => "ibus",
				"pl_loc" => "ibus",
				"pl_voc" => "ēs"
			],
			[
				"adjective_type" => "3s",
				"adjective_type_name" => "第三活用(s語幹)",				
				"gender" => "Neuter",
				"sg_nom" => "s",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "s",
				"sg_abl" => "ī(d)",
				"sg_loc" => "i",
				"sg_voc" => "s",
				"pl_nom" => "ia",
				"pl_gen" => "ium",
				"pl_dat" => "ibus",
				"pl_acc" => "ia",
				"pl_abl" => "ibus",
				"pl_loc" => "ibus",
				"pl_voc" => "ia"
			],
			[
				"adjective_type" => "3e",
				"adjective_type_name" => "第三活用(s語幹)",				
				"gender" => "Masculine/Feminine",
				"sg_nom" => "ēs",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "em",
				"sg_abl" => "ī(d)",
				"sg_loc" => "ī",
				"sg_voc" => "s",
				"pl_nom" => "ēs",
				"pl_gen" => "ium",
				"pl_dat" => "ibus",
				"pl_acc" => "ēs",
				"pl_abl" => "ibus",
				"pl_loc" => "ibus",
				"pl_voc" => "ēs"
			],
			[
				"adjective_type" => "3e",
				"adjective_type_name" => "第三活用(e語幹)",				
				"gender" => "Neuter",
				"sg_nom" => "es",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "es",
				"sg_abl" => "e",
				"sg_loc" => "ī",
				"sg_voc" => "s",
				"pl_nom" => "ia",
				"pl_gen" => "ium",
				"pl_dat" => "ibus",
				"pl_acc" => "ia",
				"pl_abl" => "ibus",
				"pl_loc" => "ibus",
				"pl_voc" => "ia"
			],
			[
				"adjective_type" => "3i",
				"adjective_type_name" => "第三活用(i語幹)",				
				"gender" => "Masculine/Feminine",
				"sg_nom" => "is",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "em",
				"sg_abl" => "ī(d)",
				"sg_loc" => "ī",
				"sg_voc" => "is",
				"pl_nom" => "ēs",
				"pl_gen" => "ium",
				"pl_dat" => "ibus",
				"pl_acc" => "ēs",
				"pl_abl" => "ibus",
				"pl_loc" => "ibus",
				"pl_voc" => "ēs"
			],
			[
				"adjective_type" => "3i",
				"adjective_type_name" => "第三活用(i語幹)",				
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
				"adjective_type" => "3Rhot",
				"adjective_type_name" => "第三活用(r語幹)",
				"gender" => "Masculine/Feminine",
				"sg_nom" => "is",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "em",
				"sg_abl" => "e",
				"sg_loc" => "i",
				"sg_voc" => "is ",
				"pl_nom" => "ēs",
				"pl_gen" => "um",
				"pl_dat" => "ibus",
				"pl_acc" => "ēs",
				"pl_abl" => "ibus",
				"pl_loc" => "ibus",
				"pl_voc" => "ēs"
			],
			[
				"adjective_type" => "3Rhot",
				"adjective_type_name" => "第三活用(r語幹)",				
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
				"adjective_type" => "3con",
				"adjective_type_name" => "第三活用(子音語幹)",
				"gender" => "Masculine/Feminine",
				"sg_nom" => "",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "em",
				"sg_abl" => "ī",
				"sg_loc" => "e",
				"sg_voc" => "",
				"pl_nom" => "ēs",
				"pl_gen" => "ium",
				"pl_dat" => "ibus",
				"pl_acc" => "ēs",
				"pl_abl" => "ibus",
				"pl_loc" => "ibus",
				"pl_voc" => "ēs"
			],
			[
				"adjective_type" => "3con",
				"adjective_type_name" => "第三活用(子音語幹)",				
				"gender" => "Neuter",
				"sg_nom" => "",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "",
				"sg_abl" => "ī(d)",
				"sg_loc" => "e",
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
				"adjective_type" => "3r",
				"adjective_type_name" => "第三活用(r語幹)",	
				"gender" => "Feminine",
				"sg_nom" => "",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "em",
				"sg_abl" => "ī(d)",
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
				"adjective_type" => "3r",
				"adjective_type_name" => "第三活用(r語幹)",					
				"gender" => "Masculine",
				"sg_nom" => "",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "em",
				"sg_abl" => "ī(d)",
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
				"adjective_type" => "3r",
				"adjective_type_name" => "第三活用(r語幹)",					
				"gender" => "Neuter",
				"sg_nom" => "",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "",
				"sg_abl" => "ī(d)",
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
				"adjective_type" => "3r2",
				"adjective_type_name" => "第三活用(r語幹・性別区別あり)",					
				"gender" => "Feminine",
				"sg_nom" => "is",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "em",
				"sg_abl" => "ī(d)",
				"sg_loc" => "i",
				"sg_voc" => "is",
				"pl_nom" => "ēs",
				"pl_gen" => "um",
				"pl_dat" => "ibus",
				"pl_acc" => "ēs",
				"pl_abl" => "ibus",
				"pl_loc" => "ibus",
				"pl_voc" => "ēs"
			],
			[
				"adjective_type" => "3r2",
				"adjective_type_name" => "第三活用(r語幹・性別区別あり)",				
				"gender" => "Masculine",
				"sg_nom" => "",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "em",
				"sg_abl" => "ī(d)",
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
				"adjective_type" => "3r2",
				"adjective_type_name" => "第三活用(r語幹・性別区別あり)",				
				"gender" => "Neuter",
				"sg_nom" => "e",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "e",
				"sg_abl" => "ī(d)",
				"sg_loc" => "i",
				"sg_voc" => "e",
				"pl_nom" => "ia",
				"pl_gen" => "um",
				"pl_dat" => "ibus",
				"pl_acc" => "ia",
				"pl_abl" => "ibus",
				"pl_loc" => "ibus",
				"pl_voc" => "ia"
			],
			[
				"adjective_type" => "3pri",
				"adjective_type_name" => "比較級",
				"gender" => "Masculine/Feminine",
				"sg_nom" => "",
				"sg_gen" => "is ",
				"sg_dat" => "ī",
				"sg_acc" => "em",
				"sg_abl" => "e",
				"sg_loc" => "i",
				"sg_voc" => "",
				"pl_nom" => "ēs",
				"pl_gen" => "ium",
				"pl_dat" => "ibus",
				"pl_acc" => "ēs",
				"pl_abl" => "ibus",
				"pl_loc" => "ibus",
				"pl_voc" => "ēs"
			],
			[
				"adjective_type" => "3pri",
				"adjective_type_name" => "比較級",
				"gender" => "Neuter",
				"sg_nom" => "ius",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "ius",
				"sg_abl" => "e",
				"sg_loc" => "i",
				"sg_voc" => "ius",
				"pl_nom" => "a",
				"pl_gen" => "ium",
				"pl_dat" => "ibus",
				"pl_acc" => "a",
				"pl_abl" => "ibus",
				"pl_loc" => "ibus",
				"pl_voc" => "a"
			],
			[
				"adjective_type" => "3",
				"adjective_type_name" => "第三活用",
				"gender" => "Masculine/Feminine",
				"sg_nom" => "",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "em",
				"sg_abl" => "ī(d)",
				"sg_loc" => "i",
				"sg_voc" => "s",
				"pl_nom" => "ēs",
				"pl_gen" => "ium",
				"pl_dat" => "ibus",
				"pl_acc" => "ēs",
				"pl_abl" => "ibus",
				"pl_loc" => "ibus",
				"pl_voc" => "ēs"
			],
			[
				"adjective_type" => "3",
				"adjective_type_name" => "第三活用",				
				"gender" => "Neuter",
				"sg_nom" => "",
				"sg_gen" => "is",
				"sg_dat" => "ī",
				"sg_acc" => "",
				"sg_abl" => "ī(d)",
				"sg_loc" => "i",
				"sg_voc" => "s",
				"pl_nom" => "ia",
				"pl_gen" => "ium",
				"pl_dat" => "ibus",
				"pl_acc" => "ia",
				"pl_abl" => "ibus",
				"pl_loc" => "ibus",
				"pl_voc" => "ia"
			]
		];
	


	// 地名フラグ
	protected $location_name = "";
	// 副詞接尾辞
	protected $adverb_suffix_12 = "e";
	// 副詞接尾辞
	protected $adverb_suffix_3 = "iter";

	
    /*=====================================
    コンストラクタ
    ======================================*/
    function __construct_lat1($adjective) {
    	// 親クラス初期化
		parent::__construct();
		// 形容詞情報を取得
		$this->set_adj_data(htmlspecialchars($adjective));
		// 比較級・最上級を作成
		$this->get_comp_super_stem($this->third_stem);
		
		// 活用語尾を取得
		$this->get_adj_declension(Commons::ADJ_GRADE_POSITIVE);		// 原級
		$this->get_adj_declension(Commons::ADJ_GRADE_COMPERATIVE);		// 比較級
		$this->get_adj_declension(Commons::ADJ_GRADE_SUPERATIVE);		// 最上級
    }
    
    /*=====================================
    コンストラクタ
    ======================================*/
    function __construct_lat3($compound, $last_word, $translation) {
    	// 親クラス初期化
		parent::__construct();
		// 形容詞情報をセット
		$this->set_adj_data($last_word);
		// 語幹を変更
		$this->first_stem = $compound.$this->first_stem;		// 第一語幹
		$this->third_stem = $compound.$this->third_stem;		// 第三語幹
		// 比較級・最上級を作成
		$this->get_comp_super_stem($this->third_stem);			
		// 活用語尾を取得
		$this->get_adj_declension(Commons::ADJ_GRADE_POSITIVE);		// 原級
		$this->get_adj_declension(Commons::ADJ_GRADE_COMPERATIVE);			// 比較級
		$this->get_adj_declension(Commons::ADJ_GRADE_SUPERATIVE);			// 最上級

		// 日本語訳を書き換え
		$this->japanese_translation = $translation;		// 日本語訳
		$this->english_translation = "";				// 英語訳
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
    
    // 形容詞情報を取得
    private function set_adj_data($adjective){

    	// 形容詞情報を取得
		$word_info = $this->get_adjective_from_DB($adjective, Latin_Common::DB_ADJECTIVE);
		// データの取得確認
		if($word_info){
			// データを挿入
			$this->first_stem = $word_info["weak_stem"];						// 弱語幹
			$this->third_stem = mb_substr($word_info["strong_stem"], 0, -1);	// 強語幹
			$this->adjective_type = $word_info["adjective_type"];			// 形容詞種別
			$this->japanese_translation = $word_info["japanese_translation"];	//日本語訳
			$this->english_translation = $word_info["english_translation"];		//英語訳
			$this->deponent_singular = $word_info["deponent_singular"];	//単数のみフラグ
			$this->deponent_plural = $word_info["deponent_plural"];		//複数のみフラグ
			$this->location_name = $word_info["location_name"];			//地名フラグ
		} else {
			// 訳を指定
			$this->japanese_translation = "借用";
			$this->english_translation = "loanword";
			// 形容詞の語幹を設定
			$this->first_stem = $adjective;         // 弱語幹
			$this->third_stem = $adjective;         // 強語幹
			// 形容詞の語幹と曲用種別を設定
			// 文字列の最後で判断
			if(preg_match("/a$/", $adjective)){
				$this->adjective_type = "1-2";          				// 名詞種別
				$this->third_stem = mb_substr($adjective, 0, -1);		// 強語幹を変更			
				$this->first_stem = mb_substr($adjective, 0, -1)."us";	// 弱語幹を変更
			} else if(preg_match("/(us|um|os|om|on)$/", $adjective)){
				$this->adjective_type = "1-2";          				// 名詞種別
				$this->third_stem = mb_substr($adjective, 0, -2);		// 強語幹を変更
				$this->first_stem = $this->third_stem."us";				// 弱語幹を変更
			} else if(preg_match("/u$/", $adjective)){
				$this->adjective_type = "1-2";          				// 名詞種別		
				$this->first_stem = $adjective."s";						// 弱語幹を変更
				$this->third_stem = mb_substr($adjective, 0, -1);		// 強語幹を変更
			} else if(preg_match("/(e|i|o|ō)$/", $adjective)){
				$this->adjective_type = "1-2";          				// 名詞種別		
				$this->first_stem = $adjective."us";					// 弱語幹を変更
			} else if(preg_match("/(es|is)$/", $adjective)){					
				$this->adjective_type = "3i";        					// 名詞種別
				$this->third_stem = mb_substr($adjective, 0, -2);		// 強語幹を変更		
			} else if(preg_match("/(ns)$/", $adjective)){
				$this->adjective_type = "3con";          				// 名詞種別			
				$this->third_stem = mb_substr($adjective, 0, -2)."nt";	// 強語幹を変更
			} else if(preg_match("/(er|or)$/", $adjective)){
				$this->adjective_type = "3r";       					// 名詞種別
			} else if(preg_match("/s$/", $adjective)){						
				$this->adjective_type = "3s";        					// 名詞種別	
				$this->third_stem = mb_substr($adjective, 0, -1);		// 強語幹を変更
			} else if(preg_match("/x$/", $adjective)){						
				$this->adjective_type = "3s";        					// 名詞種別
				$this->third_stem = mb_substr($adjective, 0, -1)."c";	// 強語幹を変更
			} else {
				$this->adjective_type = "1-2";          				// 名詞種別		
				$this->first_stem = $adjective."us";					// 弱語幹を変更
			}
		}
    }

	// 比較級・最上級を作成
	private function get_comp_super_stem($stem){

		switch($stem){
			case "bon":
				$this->comparative_first_stem = "melior";		// 比較級弱語幹
				$this->comparative_third_stem = "meliōr";		// 比較級強語幹
				$this->superlative_first_stem = "optimus";		// 最上級強語幹
				$this->superlative_third_stem = "optim";		// 最上級強語幹
				break;
			case "magn":
				$this->comparative_first_stem = "maior";		// 比較級弱語幹
				$this->comparative_third_stem = "maiōr";		// 比較級強語幹	
				$this->superlative_first_stem = "maximus";		// 最上級強語幹
				$this->superlative_third_stem = "maxim";		// 最上級強語幹								
				break;
			case "mał":
				$this->comparative_first_stem = "peior";		// 比較級弱語幹
				$this->comparative_third_stem = "peiōr";		// 比較級強語幹
				$this->superlative_first_stem = "pessimus";		// 最上級強語幹
				$this->superlative_third_stem = "pessim";		// 最上級強語幹
				break;
			case "parv":
				$this->comparative_first_stem = "minor";		// 比較級弱語幹
				$this->comparative_third_stem = "minōr";		// 比較級強語幹
				$this->superlative_first_stem = "minimus";		// 最上級強語幹
				$this->superlative_third_stem = "minim";		// 最上級強語幹
				break;				
			case "mult":
				$this->comparative_first_stem = "plus";			// 比較級弱語幹
				$this->comparative_third_stem = "plur";			// 比較級強語幹
				$this->superlative_first_stem = "plurimus";		// 最上級強語幹
				$this->superlative_third_stem = "plurim";		// 最上級強語幹				
				break;			
			default:
				$this->comparative_first_stem = $stem."ior";		// 比較級弱語幹
				$this->comparative_third_stem = $stem."iōr";		// 比較級強語幹
				$this->superlative_first_stem = $stem."issimus";	// 最上級強語幹
				$this->superlative_third_stem = $stem."issim";		// 最上級強語幹
				break;				
		}	
	}
	
	// 形容詞活用取得
	private function get_adj_declension($grade){
		// 形容詞の程度で分岐する。
		if($grade == Commons::ADJ_GRADE_POSITIVE){
			$adjective_type = $this->adjective_type;
		} else if($grade == Commons::ADJ_GRADE_COMPERATIVE){
			$adjective_type = "3pri";
		} else if($grade == Commons::ADJ_GRADE_SUPERATIVE){
			$adjective_type = "1-2";
		}

		// 曲用を取得
		$masculine_declension = $this->get_adjective_case_suffix($adjective_type, "Masculine");
		$feminine_declension = $this->get_adjective_case_suffix($adjective_type, "Feminine");
		$neuter_declension = $this->get_adjective_case_suffix($adjective_type, "Neuter");

		// 初期化
		$case_suffixes = array();		
		
		// 活用表を挿入(男性)
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::NOMINATIVE] = $masculine_declension["sg_nom"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::GENETIVE] = $masculine_declension["sg_gen"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::DATIVE] = $masculine_declension["sg_dat"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::ACCUSATIVE] = $masculine_declension["sg_acc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::ABLATIVE] = $masculine_declension["sg_abl"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::LOCATIVE] = $masculine_declension["sg_loc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::VOCATIVE] = $masculine_declension["sg_voc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::NOMINATIVE] = $masculine_declension["pl_nom"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::GENETIVE] = $masculine_declension["pl_gen"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::DATIVE] = $masculine_declension["pl_dat"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::ACCUSATIVE] = $masculine_declension["pl_acc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::ABLATIVE] = $masculine_declension["pl_abl"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::LOCATIVE] = $masculine_declension["pl_loc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::VOCATIVE] = $masculine_declension["pl_voc"];

		// 活用表を挿入(女性)
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::NOMINATIVE] = $feminine_declension["sg_nom"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::GENETIVE] = $feminine_declension["sg_gen"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::DATIVE] = $feminine_declension["sg_dat"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::ACCUSATIVE] = $feminine_declension["sg_acc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::ABLATIVE] = $feminine_declension["sg_abl"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::LOCATIVE] = $feminine_declension["sg_loc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::VOCATIVE] = $feminine_declension["sg_voc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::NOMINATIVE] = $feminine_declension["pl_nom"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::GENETIVE] = $feminine_declension["pl_gen"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::DATIVE] = $feminine_declension["pl_dat"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::ACCUSATIVE] = $feminine_declension["pl_acc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::ABLATIVE] = $feminine_declension["pl_abl"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::LOCATIVE] = $feminine_declension["pl_loc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::VOCATIVE] = $feminine_declension["pl_voc"];
		
		// 活用表を挿入(中性)
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::NOMINATIVE] = $neuter_declension["sg_nom"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::GENETIVE] = $neuter_declension["sg_gen"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::DATIVE] = $neuter_declension["sg_dat"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::ACCUSATIVE] = $neuter_declension["sg_acc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::ABLATIVE] = $neuter_declension["sg_abl"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::LOCATIVE] = $neuter_declension["sg_loc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::VOCATIVE] = $neuter_declension["sg_voc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::NOMINATIVE] = $neuter_declension["pl_nom"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::GENETIVE] = $neuter_declension["pl_gen"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::DATIVE] = $neuter_declension["pl_dat"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::ACCUSATIVE] = $neuter_declension["pl_acc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::ABLATIVE] = $neuter_declension["pl_abl"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::LOCATIVE] = $neuter_declension["pl_loc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::VOCATIVE] = $neuter_declension["pl_voc"];
		
		// 活用を挿入
		if($grade == Commons::ADJ_GRADE_POSITIVE){
			// 活用種別名
			$this->adjective_type_name = $masculine_declension["adjective_type_name"];				
			$this->case_suffix = $case_suffixes;
		} else if($grade == Commons::ADJ_GRADE_COMPERATIVE){
			$this->comparative_case_suffix = $case_suffixes;
		} else if($grade == Commons::ADJ_GRADE_SUPERATIVE){
			$this->superlative_case_suffix = $case_suffixes;
		}		
	}
	
	// 形容詞作成(原級)
	protected function generate_positive($case, $number, $gender){
		// 格語尾を取得
		$case_suffix = "";
		// 曲用語尾を取得
		if($number == Commons::SINGULAR && $this->deponent_singular != Commons::$TRUE){
			// 単数
			$case_suffix = $this->case_suffix[$gender][$number][$case];
		} else if($number == Commons::PLURAL && ($this->deponent_plural != Commons::$TRUE && $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->case_suffix[$gender][$number][$case];
		} else {
			// ハイフンを返す。
			return "-";
		}

		// 語幹を取得
		if($this->adjective_type == "1-2" || 
		   $this->adjective_type == "1-2gr1" ||
		   $this->adjective_type == "3" ||		   
		   $this->adjective_type == "3i" || 
		   $this->adjective_type == "3e"		   	   
		   ){
			// 第一・第二活用(r活用除く)、第三母音活用、第四・第五活用の場合は常に強語幹
			$adjective = $this->third_stem;		
		} else {
			// それ以外は単数の主格と呼格は弱語幹
			if($gender == Commons::ANIMATE_GENDER && $number == Commons::SINGULAR && ($case == Commons::NOMINATIVE || $case == Commons::VOCATIVE)){
				// ここで結果を返す。
				return $this->first_stem;					
			} else if($gender == Commons::INANIMATE_GENDER && $number == Commons::SINGULAR && ($case == Commons::NOMINATIVE || $case == Commons::ACCUSATIVE || $case == Commons::VOCATIVE)){
				// 中性の単数対格は主格と同じ
				// ここで結果を返す。
				return $this->first_stem;
			} else {
				// それ以外は強語幹
				$adjective = $this->third_stem;
			}
		}

		// 結果を返す
		return trim($adjective.$case_suffix);
	}
	
	// 形容詞作成(比較級)
	protected function generate_comp($case, $number, $gender){
		// 格語尾を取得
		$case_suffix = null;
		// 曲用語尾を取得
		if($number == Commons::SINGULAR && $this->deponent_singular != Commons::$TRUE){
			// 単数
			$case_suffix = $this->comparative_case_suffix[$gender][$number][$case];
		} else if($number == Commons::PLURAL && ($this->deponent_plural != Commons::$TRUE & $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->comparative_case_suffix[$gender][$number][$case];
		} else {
			// ハイフンを返す。
			return "-";
		}

		// それ以外は単数の主格と呼格は弱語幹
		if(($case == Commons::NOMINATIVE && $number == Commons::SINGULAR) || ($case == Commons::VOCATIVE && $number == Commons::SINGULAR)){
			// ここで結果を返す。
			return $this->comparative_first_stem;					
		} else if($case == Commons::ACCUSATIVE && $gender == Commons::INANIMATE_GENDER && $number == Commons::SINGULAR){
			// 中性の単数対格は主格と同じ
			// ここで結果を返す。
			return $this->comparative_first_stem;
		} else {
			// 結果を返す
			return trim($this->comparative_third_stem.$case_suffix);
		}
	}	
	
	// 形容詞作成(最上級)
	protected function generate_super($case, $number, $gender){
		// 格語尾を取得
		$case_suffix = null;
		// 曲用語尾を取得
		if($number == Commons::SINGULAR && $this->deponent_singular != Commons::$TRUE){
			// 単数
			$case_suffix = $this->superlative_case_suffix[$gender][$number][$case];
		} else if($number == Commons::PLURAL && ($this->deponent_plural != Commons::$TRUE & $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->superlative_case_suffix[$gender][$number][$case];
		} else {
			// ハイフンを返す。
			return "-";
		}

		// 結果を返す
		return trim($this->superlative_third_stem.$case_suffix);
	}
	
	// 副詞作成
    public function get_adverb($grade = "positive"){ 	
		// 初期化
		$adverb = "";
		// 形容詞の程度で分岐する。
		if($grade == Commons::ADJ_GRADE_POSITIVE){
			// 原級
			// 活用種別で分岐
			if(preg_match("/(1-2|1-2r|1-2gr1)$/", $this->adjective_type)){
				// 第一・第二活用の場合
				$adverb = $this->third_stem.$this->adverb_suffix_12;
			} else {
				// それ以外の場合
				$adverb = $this->third_stem.$this->adverb_suffix_3;
			}			
		} else if($grade == Commons::ADJ_GRADE_COMPERATIVE){
			// 比較級
			$adverb = $this->comparative_third_stem.$this->adverb_suffix_3;
		} else if($grade == Commons::ADJ_GRADE_SUPERATIVE){
			// 最上級
			$adverb = $this->superlative_third_stem.$this->adverb_suffix_12;
		}
		// 結果を返す
		return $adverb;
    }

    // 曲用表をすべて取得
	public function get_chart(){
		// 初期化
		$word_chart = array();		
		// タイトル情報を挿入
		$word_chart['title'] = $this->get_adjective_title();
		// 辞書見出しを入れる。
		$word_chart['dic_title'] = $this->get_first_stem();
		// 活用種別を入れる。
		$word_chart['type'] = $this->adjective_type_name;
		// 曲用を取得
		$word_chart = $this->make_adjective_declension($word_chart);
		// 副詞の情報を入れる。
		$word_chart[Commons::ADJ_GRADE_POSITIVE]["adverb"] = $this->get_adverb(Commons::ADJ_GRADE_POSITIVE);
		$word_chart[Commons::ADJ_GRADE_COMPERATIVE]["adverb"] = $this->get_adverb(Commons::ADJ_GRADE_COMPERATIVE);
		$word_chart[Commons::ADJ_GRADE_SUPERATIVE]["adverb"] = $this->get_adverb(Commons::ADJ_GRADE_SUPERATIVE);

		// 結果を返す。
		return $word_chart;
	}

	// 語幹を取得
	public function get_first_stem(){
		return $this->first_stem;
	}

	// 語幹を取得
	public function get_third_stem(){
		return $this->third_stem;
	}

	// 特定の格変化を取得する(ない場合はランダム)。
	public function get_form_by_number_case_gender_grade($case = "", $number = "", $gender = "", $grade = ""){

		// 格がない場合
		if($case == ""){
			// 全ての格の中からランダムで選択
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

		// 性別がない場合
		if($gender == ""){
			// 全ての性別の中からランダムで選択
			$ary = array(Commons::ANIMATE_GENDER, Commons::ACTION_GENDER, Commons::INANIMATE_GENDER);			// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$gender = $ary[$key];			
		}	

		// 形容詞の級に指定がない場合は
		if($grade == ""){
			// 全ての級を対象にする。
			$ary = array(Commons::ADJ_GRADE_POSITIVE, Commons::ADJ_GRADE_COMPERATIVE, Commons::ADJ_GRADE_SUPERATIVE);	// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$grade = $ary[$key];			
		}

		// 配列に格納
		$question_data = array();
		$question_data['question_sentence'] = $this->get_adjective_title()."の".Commons::change_gramatical_words($gender).Commons::change_gramatical_words($number).Commons::change_gramatical_words($case)."を答えよ";				
		$question_data['answer'] = $this->get_declensioned_adjective($case, $number, $gender, $grade);
		$question_data['question_sentence2'] = $question_data['answer']."の性、格と数を答えよ";	
		$question_data['case'] = $case;
		$question_data['number'] = $number;	
		$question_data['gender'] = $gender;
		$question_data['grade'] = $grade;			

		// 結果を返す。
		return $question_data;
	}	

}

// 梵語共通クラス
class Vedic_Adjective extends Adjective_Common_IE {

	// 格語尾リスト
	protected $case_suffix_list =  [
		[
			"adjective_type" => "1-2",
			"adjective_type_name" => "a-変化形容詞",				
			"gender" => "Feminine",
			"sg_nom" => "ā",
			"sg_gen" => "āyās",
			"sg_dat" => "āyai",
			"sg_acc" => "ām",
			"sg_abl" => "āyās",
			"sg_ins" => "ā",
			"sg_loc" => "āyām",
			"sg_voc" => "e",
			"du_nom" => "e",
			"du_gen" => "āyos",
			"du_dat" => "ābhiām",
			"du_acc" => "e",
			"du_abl" => "ābhiām",
			"du_ins" => "ābhiām",
			"du_loc" => "ayos",
			"du_voc" => "e",
			"pl_nom" => "ās",
			"pl_gen" => "nām",
			"pl_dat" => "ābhyas",
			"pl_acc" => "ās",
			"pl_abl" => "ābhyas",
			"pl_ins" => "ābhis",			
			"pl_loc" => "āsu",
			"pl_voc" => "ās"
		],
		[
			"adjective_type" => "1-2",
			"adjective_type_name" => "a-変化形容詞",			
			"gender" => "Masculine",
			"sg_nom" => "as",
			"sg_gen" => "asya",
			"sg_dat" => "aya",
			"sg_acc" => "am",
			"sg_abl" => "at",
			"sg_ins" => "ena",
			"sg_loc" => "e",
			"sg_voc" => "a",
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
			"adjective_type" => "1-2",
			"adjective_type_name" => "a-変化形容詞",			
			"gender" => "Neuter",
			"sg_nom" => "am",
			"sg_gen" => "asya",
			"sg_dat" => "aya",
			"sg_acc" => "am",
			"sg_abl" => "at",
			"sg_ins" => "ena",
			"sg_loc" => "e",
			"sg_voc" => "a",
			"du_nom" => "e",
			"du_gen" => "yos",
			"du_dat" => "bhiām",
			"du_acc" => "e",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "yos",
			"du_voc" => "e",
			"pl_nom" => "āsas",
			"pl_gen" => "anām",
			"pl_dat" => "ebhyas",
			"pl_acc" => "ān",
			"pl_abl" => "ebhyas",
			"pl_ins" => "ebhis",			
			"pl_loc" => "esu",
			"pl_voc" => "āsas"
		],
		[
			"adjective_type" => "3s",
			"adjective_type_name" => "語根形容詞",	
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
			"adjective_type" => "3s",
			"adjective_type_name" => "語根形容詞",
			"gender" => "Masculine/Neuter",
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
			"adjective_type" => "3n",
			"adjective_type_name" => "n-変化形容詞",
			"gender" => "Masculine/Feminine",
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
			"adjective_type" => "3n",
			"adjective_type_name" => "n-変化形容詞",
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
			"adjective_type" => "3con",
			"adjective_type_name" => "子音変化形容詞",
			"gender" => "Masculine/Feminine",
			"sg_nom" => "",
			"sg_gen" => "as",
			"sg_dat" => "e",
			"sg_acc" => "am",
			"sg_abl" => "as",
			"sg_ins" => "ā",
			"sg_loc" => "i",
			"sg_voc" => "",
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
			"adjective_type" => "3con",
			"adjective_type_name" => "子音変化形容詞",
			"gender" => "Neuter",
			"sg_nom" => "",
			"sg_gen" => "as",
			"sg_dat" => "e",
			"sg_acc" => "",
			"sg_abl" => "as",
			"sg_ins" => "ā",
			"sg_loc" => "i",
			"sg_voc" => "",
			"du_nom" => "au",
			"du_gen" => "os",
			"du_dat" => "bhiām",
			"du_acc" => "au",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "os",
			"du_voc" => "au",
			"pl_nom" => "i",
			"pl_gen" => "ām",
			"pl_dat" => "bhyas",
			"pl_acc" => "as",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "as"
		],
		[
			"adjective_type" => "double",
			"adjective_type_name" => "二重母音形容詞",
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
			"adjective_type" => "double",
			"adjective_type_name" => "二重母音形容詞",
			"gender" => "Masculine/Neuter",
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
			"adjective_type" => "3r",
			"adjective_type_name" => "r-変化形容詞",
			"gender" => "Neuter",
			"sg_nom" => "ā",
			"sg_gen" => "ur",
			"sg_dat" => "e",
			"sg_acc" => "āram",
			"sg_abl" => "ur",
			"sg_ins" => "ā",
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
			"adjective_type" => "3r",
			"adjective_type_name" => "r-変化形容詞",
			"gender" => "Masculine/Feminine",
			"sg_nom" => "ā",
			"sg_gen" => "ur",
			"sg_dat" => "e",
			"sg_acc" => "āram",
			"sg_abl" => "ur",
			"sg_ins" => "ā",
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
			"adjective_type" => "3i",
			"adjective_type_name" => "i-変化形容詞",
			"gender" => "Feminine",
			"sg_nom" => "ī",
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
			"adjective_type" => "3i",
			"adjective_type_name" => "i-変化形容詞",
			"gender" => "Masculine",
			"sg_nom" => "s",
			"sg_gen" => "ās",
			"sg_dat" => "aye",
			"sg_acc" => "m",
			"sg_abl" => "ās",
			"sg_ins" => "ā",
			"sg_loc" => "āu",
			"sg_voc" => "ai",
			"du_nom" => "ī",
			"du_gen" => "os",
			"du_dat" => "bhiām",
			"du_acc" => "ī",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "os",
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
			"adjective_type" => "3i",
			"adjective_type_name" => "i-変化形容詞",
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
			"adjective_type" => "4u",
			"adjective_type_name" => "u-変化形容詞",
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
			"adjective_type" => "4u",
			"adjective_type_name" => "u-変化形容詞",
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
			"adjective_type" => "4u",
			"adjective_type_name" => "u-変化形容詞",
			"gender" => "Feminine",
			"sg_nom" => "ūs",
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
			"pl_nom" => "ūs",
			"pl_gen" => "nām",
			"pl_dat" => "bhyas",
			"pl_acc" => "ūs",
			"pl_abl" => "bhyas",
			"pl_ins" => "bhis",	
			"pl_loc" => "su",
			"pl_voc" => "ūs"
		],				
	];

	// 比較級種別
	protected $comp_type = "";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_sanskrit4($root, $suffix, $verb_translation, $suffix_translation) {
		// 親クラス初期化
	    parent::__construct();
	    // 単語を作成
	    $word = Sanskrit_Common::sandhi_engine($root, $suffix);
	    // 情報をセット
	    $this->set_adj_data($word);
	    // 日本語訳を書き換え
	    $this->japanese_translation = $verb_translation.$suffix_translation;		// 日本語訳
	    $this->english_translation = "";											// 英語訳
		// 残りの語幹を作成
		$this->make_other_stem();
		// 比較級・最上級を作成
		$this->get_comp_super_stem();   
	    // 活用表を挿入
	    $this->get_adj_declension(Commons::ADJ_GRADE_POSITIVE);
	    $this->get_adj_declension(Commons::ADJ_GRADE_COMPERATIVE);
	    $this->get_adj_declension(Commons::ADJ_GRADE_SUPERATIVE);
   }

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_sanskrit3($compound, $last_word, $translation) {
    	// 親クラス初期化
		parent::__construct();
		// 形容詞情報をセット
		$this->set_adj_data($last_word);
		// 残りの語幹を作成
		$this->make_other_stem();	
		// 語幹を変更
		$this->first_stem = Sanskrit_Common::sandhi_engine($compound, $this->first_stem);		// 第一語幹
		$this->second_stem = Sanskrit_Common::sandhi_engine($compound, $this->second_stem);		// 第二語幹		
		$this->third_stem = Sanskrit_Common::sandhi_engine($compound, $this->third_stem);		// 第三語幹
		// 比較級・最上級を作成
		$this->get_comp_super_stem();
		// 日本語訳を書き換え
		$this->japanese_translation = $translation;			// 日本語訳
		$this->english_translation = "";			// 英語訳
		
		// 活用表を挿入
		$this->get_adj_declension(Commons::ADJ_GRADE_POSITIVE);
		$this->get_adj_declension(Commons::ADJ_GRADE_COMPERATIVE);
		$this->get_adj_declension(Commons::ADJ_GRADE_SUPERATIVE);
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_sanskrit2($adjective, $flag) {
    	// 親クラス初期化
		parent::__construct();
		// 比較級フラグ
		$this->comp_type = Commons::$FALSE;
		// 文字列の最後で判断
		if(preg_match('/(a|ā)$/',$adjective)){		
			// 形容詞の種別で活用が決定する。		
			$this->adjective_type = "1-2";           						// 名詞種別
			$this->second_stem = mb_substr($adjective, 0, -1)."a";			// 第二語幹
		} else if(preg_match('/(at|ac)$/',$adjective)){
			$this->adjective_type = "3con";									// 名詞種別
			$this->second_stem = $adjective;								// 第二語幹						
		} else if(preg_match('/(as|is|us)$/',$adjective)){			
			// 形容詞の種別で活用が決定する。													
			$this->adjective_type = "3con";									// 名詞種別
			$this->second_stem = $adjective;								// 第二語幹												
		} else {		
			// 形容詞の種別で活用が決定する。													
			$this->adjective_type = "3s";									// 名詞種別
			$this->second_stem = $adjective;								// 第二語幹
		}
		// 残りの語幹を作成
		$this->make_other_stem();
		// 比較級・最上級を作成
		$this->get_comp_super_stem();		
		// 活用語尾を取得
		$this->get_adj_declension(Commons::ADJ_GRADE_POSITIVE);		// 原級
		$this->get_adj_declension(Commons::ADJ_GRADE_COMPERATIVE);		// 比較級
		$this->get_adj_declension(Commons::ADJ_GRADE_SUPERATIVE);		// 最上級
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_sanskrit1($adjective) {
    	// 親クラス初期化
		parent::__construct();
		// 形容詞情報をセット
		$this->set_adj_data(htmlspecialchars($adjective));
		// 残りの語幹を作成
		$this->make_other_stem();
		// 比較級・最上級を作成
		$this->get_comp_super_stem();		
		// 活用語尾を取得
		$this->get_adj_declension(Commons::ADJ_GRADE_POSITIVE);		// 原級
		$this->get_adj_declension(Commons::ADJ_GRADE_COMPERATIVE);		// 比較級
		$this->get_adj_declension(Commons::ADJ_GRADE_SUPERATIVE);		// 最上級
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
    private function get_adj_declension($grade = "positive"){

		// 形容詞の程度で分岐する。
		if($grade == Commons::ADJ_GRADE_POSITIVE){
			$adjective_type = $this->adjective_type;
		} else if($grade == Commons::ADJ_GRADE_COMPERATIVE){
			$adjective_type = "1-2";
		} else if($grade == Commons::ADJ_GRADE_SUPERATIVE){
			$adjective_type = "1-2";
		}
		// 曲用を取得
		$masculine_declension = $this->get_adjective_case_suffix($adjective_type, "Masculine");
		$feminine_declension = $this->get_adjective_case_suffix($adjective_type, "Feminine");
		$neuter_declension = $this->get_adjective_case_suffix($adjective_type, "Neuter");

		// 活用表を挿入(男性)
		// 単数
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::NOMINATIVE] = $masculine_declension["sg_nom"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::GENETIVE] = $masculine_declension["sg_gen"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::DATIVE] = $masculine_declension["sg_dat"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::ACCUSATIVE] = $masculine_declension["sg_acc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::ABLATIVE] = $masculine_declension["sg_abl"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::INSTRUMENTAL] = $masculine_declension["sg_ins"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::LOCATIVE] = $masculine_declension["sg_loc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::VOCATIVE] = $masculine_declension["sg_voc"];
		
		// 双数
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::NOMINATIVE] = $masculine_declension["du_nom"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::GENETIVE] = $masculine_declension["du_gen"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::DATIVE] = $masculine_declension["du_dat"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::ACCUSATIVE] = $masculine_declension["du_acc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::ABLATIVE] = $masculine_declension["du_abl"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::INSTRUMENTAL] = $masculine_declension["du_ins"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::LOCATIVE] = $masculine_declension["du_loc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::VOCATIVE] = $masculine_declension["du_voc"];
		
		// 複数
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::NOMINATIVE] = $masculine_declension["pl_nom"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::GENETIVE] = $masculine_declension["pl_gen"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::DATIVE] = $masculine_declension["pl_dat"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::ACCUSATIVE] = $masculine_declension["pl_acc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::ABLATIVE] = $masculine_declension["pl_abl"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::INSTRUMENTAL] = $masculine_declension["pl_ins"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::LOCATIVE] = $masculine_declension["pl_loc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::VOCATIVE] = $masculine_declension["pl_voc"];

		// 活用表を挿入(女性)		
		// 単数
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::NOMINATIVE] = $feminine_declension["sg_nom"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::GENETIVE] = $feminine_declension["sg_gen"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::DATIVE] = $feminine_declension["sg_dat"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::ACCUSATIVE] = $feminine_declension["sg_acc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::ABLATIVE] = $feminine_declension["sg_abl"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::INSTRUMENTAL] = $feminine_declension["sg_ins"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::LOCATIVE] = $feminine_declension["sg_loc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::VOCATIVE] = $feminine_declension["sg_voc"];
		
		// 双数
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::NOMINATIVE] = $feminine_declension["du_nom"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::GENETIVE] = $feminine_declension["du_gen"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::DATIVE] = $feminine_declension["du_dat"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::ACCUSATIVE] = $feminine_declension["du_acc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::ABLATIVE] = $feminine_declension["du_abl"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::INSTRUMENTAL] = $feminine_declension["du_ins"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::LOCATIVE] = $feminine_declension["du_loc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::VOCATIVE] = $feminine_declension["du_voc"];
		
		// 複数
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::NOMINATIVE] = $feminine_declension["pl_nom"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::GENETIVE] = $feminine_declension["pl_gen"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::DATIVE] = $feminine_declension["pl_dat"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::ACCUSATIVE] = $feminine_declension["pl_acc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::ABLATIVE] = $feminine_declension["pl_abl"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::INSTRUMENTAL] = $feminine_declension["pl_ins"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::LOCATIVE] = $feminine_declension["pl_loc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::VOCATIVE] = $feminine_declension["pl_voc"];

		// 活用表を挿入(女性)		
		// 単数
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::NOMINATIVE] = $neuter_declension["sg_nom"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::GENETIVE] = $neuter_declension["sg_gen"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::DATIVE] = $neuter_declension["sg_dat"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::ACCUSATIVE] = $neuter_declension["sg_acc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::ABLATIVE] = $neuter_declension["sg_abl"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::INSTRUMENTAL] = $neuter_declension["sg_ins"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::LOCATIVE] = $neuter_declension["sg_loc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::VOCATIVE] = $neuter_declension["sg_voc"];
		
		// 双数
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::NOMINATIVE] = $neuter_declension["du_nom"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::GENETIVE] = $neuter_declension["du_gen"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::DATIVE] = $neuter_declension["du_dat"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::ACCUSATIVE] = $neuter_declension["du_acc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::ABLATIVE] = $neuter_declension["du_abl"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::INSTRUMENTAL] = $neuter_declension["du_ins"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::LOCATIVE] = $neuter_declension["du_loc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::VOCATIVE] = $neuter_declension["du_voc"];
		
		// 複数
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::NOMINATIVE] = $neuter_declension["pl_nom"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::GENETIVE] = $neuter_declension["pl_gen"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::DATIVE] = $neuter_declension["pl_dat"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::ACCUSATIVE] = $neuter_declension["pl_acc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::ABLATIVE] = $neuter_declension["pl_abl"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::INSTRUMENTAL] = $neuter_declension["pl_ins"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::LOCATIVE] = $neuter_declension["pl_loc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::VOCATIVE] = $neuter_declension["pl_voc"];

		// 活用を挿入
		if($grade == Commons::ADJ_GRADE_POSITIVE){
			// 活用種別名
			$this->adjective_type_name = $masculine_declension["adjective_type_name"];				
			$this->case_suffix = $case_suffixes;
		} else if($grade == Commons::ADJ_GRADE_COMPERATIVE){
			$this->comparative_case_suffix = $case_suffixes;
		} else if($grade == Commons::ADJ_GRADE_SUPERATIVE){
			$this->superlative_case_suffix = $case_suffixes;
		}	
    }

	// 語幹を作成
	private function make_other_stem(){
		if($this->adjective_type == "1-2"){
			// a語幹の場合
			$this->first_stem = $this->second_stem;		// 弱語幹
			$this->third_stem = $this->second_stem;		// 強語幹
		} else if($this->adjective_type == "3s"){
			// 語根の場合		
			$this->first_stem = Sanskrit_Common::change_vowel_grade($this->second_stem, Sanskrit_Common::ZERO_GRADE);		// 弱語幹
			$this->third_stem = Sanskrit_Common::change_vowel_grade($this->second_stem, Sanskrit_Common::VRIDDHI);			// 強語幹
		} else if($this->adjective_type == "3n"){
			// n活用の場合			
			if(preg_match('/(an)$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -2)."n";		// 弱語幹
				$this->third_stem = mb_substr($this->second_stem, 0, -2)."ān";		// 強語幹
			} else if(preg_match('/(in)$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -2)."in";		// 弱語幹
				$this->third_stem = mb_substr($this->second_stem, 0, -2)."īn";		// 強語幹
			} else {
				$this->first_stem = mb_substr($this->second_stem, 0, -2).Sanskrit_Common::change_vowel_grade(mb_substr($this->second_stem, -2), Sanskrit_Common::ZERO_GRADE);
				$this->third_stem = mb_substr($this->second_stem, 0, -2).Sanskrit_Common::change_vowel_grade(mb_substr($this->second_stem, -2), Sanskrit_Common::VRIDDHI);
			}
		} else if($this->adjective_type == "3con"){
			if(preg_match('/(at|āt)$/',$this->second_stem)){				
				$this->first_stem = mb_substr($this->second_stem, 0, -2)."at";		// 弱語幹
				$this->second_stem = mb_substr($this->second_stem, 0, -2)."at";		// 中語幹
				$this->third_stem = mb_substr($this->second_stem, 0, -2)."ānt";		// 強語幹
			} else if(preg_match('/(yac)$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -3)."īc";		// 弱語幹
				$this->second_stem = mb_substr($this->second_stem, 0, -3)."āc";		// 中語幹
				$this->third_stem = mb_substr($this->second_stem, 0, -3)."ānc";		// 強語幹
			} else if(preg_match('/(vas)$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -3)."uṣ";		// 弱語幹
				$this->second_stem = mb_substr($this->second_stem, 0, -3)."vat";	// 中語幹
				$this->third_stem = mb_substr($this->second_stem, 0, -3)."vāṃs";	// 強語幹
			} else if(preg_match('/(ac)$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -2)."āc";		// 弱語幹
				$this->second_stem = mb_substr($this->second_stem, 0, -2)."āc";		// 中語幹
				$this->third_stem = mb_substr($this->second_stem, 0, -2)."ānc";		// 強語幹
			} else {
				$this->first_stem = $this->second_stem;		// 弱語幹
				$this->third_stem = $this->second_stem;		// 強語幹
			}			
		} else {
			$this->first_stem = $this->second_stem;		// 弱語幹
			$this->third_stem = $this->second_stem;		// 強語幹		
		}
	}
    
    // 形容詞情報を取得
    private function set_adj_data($adjective){
    	// 名詞情報を取得
		$word_info = $this->get_adjective_from_DB($adjective, Sanskrit_Common::DB_ADJECTIVE, false);
		// データがある場合は
		if($word_info){
			// データを挿入
			$this->adjective_type = $word_info["adjective_type"];				// 形容詞種別
			$this->comp_type = $word_info["comp_type"];							// 比較級種別			
			$this->second_stem = $word_info["stem"];							// 語幹		
			$this->japanese_translation = $word_info["japanese_translation"];	// 日本語訳
			$this->english_translation = $word_info["english_translation"];		// 英語訳
		} else {
			// 第一語幹・第三語幹生成
			$this->second_stem = $adjective;							// 第二語幹
			$this->comp_type = Commons::$FALSE;

			// 日本語訳
			$this->japanese_translation = "借用語";
			// 英語訳
			$this->english_translation = "loanword";
			
			// 文字列の最後で判断
			if(preg_match('/(a|ā)$/',$adjective)){		
				// 形容詞の種別で活用が決定する。		
				$this->adjective_type = "1-2";           					// 名詞種別
				$this->second_stem = mb_substr($adjective, 0, -1)."a";		// 第二語幹
			} else if(preg_match('/(u|ū)$/',$adjective)){			
				// 形容詞の種別で活用が決定する。							
				$this->adjective_type = 4;									// 名詞種別
				$this->second_stem = mb_substr($adjective, 0, -1)."u";		// 第二語幹
			} else if(preg_match('/(i|ī)$/',$adjective)){		
				// 形容詞の種別で活用が決定する。									
				$this->adjective_type = "3i";           					// 名詞種別
				$this->second_stem = mb_substr($adjective, 0, -1)."i";		// 第二語幹
			} else if((preg_match('/(e|o)$/',$adjective))){
				$this->adjective_type = "double";								// 名詞種別
				$this->second_stem = $adjective;								// 第二語幹
			} else if(preg_match('/(r)$/',$adjective)){
				$this->adjective_type = "3r";									// 名詞種別
				$this->second_stem = mb_substr($adjective, 0, -1);				// 第二語幹
			} else if(preg_match('/(n)$/',$adjective)){
				$this->adjective_type = "3n";									// 名詞種別
				$this->second_stem = $adjective;								// 第二語幹
			} else if(preg_match('/(at|ac)$/',$adjective)){
				$this->adjective_type = "3con";									// 名詞種別
				$this->second_stem = $adjective;								// 第二語幹						
			} else if(preg_match('/(as|is|us)$/',$adjective)){			
				// 形容詞の種別で活用が決定する。													
				$this->adjective_type = "3con";									// 名詞種別
				$this->second_stem = $adjective;								// 第二語幹								
			} else if(preg_match('/(s|t)$/',$adjective)){
				$this->adjective_type = "3con";									// 名詞種別
				$this->second_stem = $adjective;								// 第二語幹						
			} else {		
				// 形容詞の種別で活用が決定する。													
				$this->adjective_type = "3s";									// 名詞種別
				$this->second_stem = $adjective;								// 第二語幹
			}
		}
    }

	// 比較級・最上級を作成
	private function get_comp_super_stem(){
		// 比較級・最上級接尾辞を初期化
		$comp_inffix = "";
		$super_inffix = "";

		// 比較級種別
		if($this->comp_type != Commons::$TRUE){
			$comp_inffix = "tara";
			$super_inffix = "tama";
		} else {
			$comp_inffix = "īyas";
			$super_inffix = "iṣṭha";
		}

		// 比較級・最上級語幹を初期化
		$comp_super_stem = "";

		// 3語幹以上は中語幹、それ以外は弱語幹
		if(mb_strlen($this->second_stem) > 7){
			$comp_super_stem = $this->second_stem;
		} else if($this->second_stem != ""){
			$comp_super_stem = $this->first_stem;
		} else {
			// ない場合はここで処理を中断
			return;
		}

		// 語幹を作成
		$this->comparative_first_stem = Sanskrit_Common::sandhi_engine($comp_super_stem, $comp_inffix);
		$this->comparative_second_stem = Sanskrit_Common::sandhi_engine($comp_super_stem, $comp_inffix); 
		$this->comparative_third_stem = Sanskrit_Common::sandhi_engine($comp_super_stem, $comp_inffix); 
		$this->superlative_first_stem = Sanskrit_Common::sandhi_engine($comp_super_stem, $super_inffix); 
		$this->superlative_second_stem = Sanskrit_Common::sandhi_engine($comp_super_stem, $super_inffix); 
		$this->superlative_third_stem = Sanskrit_Common::sandhi_engine($comp_super_stem, $super_inffix); 
	}
	
	// 形容詞作成
	public function generate_positive($case, $number, $gender){

		// 語幹が存在しない場合は返さない。
		if($this->second_stem == ""){
			return "-";
		}

		// 格語尾を取得
		$case_suffix = $this->case_suffix[$gender][$number][$case];

		// 語幹を取得
		$stem = "";

		// 性・数・格に応じて語幹を生成
		// 男性および女性
		if($gender == Commons::ANIMATE_GENDER || $gender == Commons::ACTION_GENDER){
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
		} else if($gender == Commons::INANIMATE_GENDER){
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
		if($this->adjective_type == "1-2"){
			// 第二変化の場合は、最後のaを削る
			$stem = mb_substr($stem, 0, -1);
		} else if($this->adjective_type == "3i" || $this->adjective_type == 4){
			// 第三・第四変化の場合
			// 格変化の語尾が母音で始まる場合は
			if(Commons::is_vowel_or_not(mb_substr($case_suffix, 0, 1))){
				// 最後の母音を削る
				$stem = mb_substr($stem, 0, -1);				
			}
		}

		// 結果を生成
		$adjective = Sanskrit_Common::sandhi_engine($stem, $case_suffix, true, true);

		// 結果を返す
		return $adjective;
	}

	// 比較級形容詞作成
	protected function generate_comp($case, $number, $gender){
		// 格語尾を取得
		$case_suffix = $this->comparative_case_suffix[$gender][$number][$case];
		// 形容詞と結合		
		$adjective = Sanskrit_Common::sandhi_engine($this->comparative_third_stem, $case_suffix, true, true);
		// 結果を返す
		return $adjective;
	}

	// 最上級形容詞作成
	protected function generate_super($case, $number, $gender){
		// 格語尾を取得
		$case_suffix = $this->superlative_case_suffix[$gender][$number][$case];
		// 形容詞と結合
		$adjective = Sanskrit_Common::sandhi_engine($this->superlative_third_stem, $case_suffix, true, true);	
		// 結果を返す
		return $adjective;
	}

	// 語幹を取得
	public function get_second_stem($grade = "positive"){
		// 形容詞の程度で分岐する。
		if($grade == Commons::ADJ_GRADE_POSITIVE){
			return $this->second_stem;
		} else if($grade == Commons::ADJ_GRADE_COMPERATIVE){
			return $this->comparative_second_stem;
		} else if($grade == Commons::ADJ_GRADE_SUPERATIVE){
			return $this->superlative_second_stem;
		}
	}

    // 曲用表を取得
	private function get_adverb_chart($word_chart){
		// 形容詞級
		$grande_array = array(Commons::ADJ_GRADE_POSITIVE, Commons::ADJ_GRADE_COMPERATIVE, Commons::ADJ_GRADE_SUPERATIVE);
		// 全ての級
		foreach ($grande_array as $grade){

			// 名詞クラスごとに語幹を取得
			$masc_stem = $this->get_second_stem($grade);
			$fem_stem = Sanskrit_Common::sandhi_engine($masc_stem, $this->case_suffix[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::NOMINATIVE]);

			// 副詞(拡張格)
			$word_chart = $this->make_adverb_form($word_chart, $masc_stem, $grade, Commons::ANIMATE_GENDER);
			$word_chart = $this->make_adverb_form($word_chart, $masc_stem, $grade, Commons::ACTION_GENDER);
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::SINGULAR]["elative"] = $word_chart[$grade][Commons::ANIMATE_GENDER][Commons::SINGULAR]["elative"];
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::SINGULAR]["inessive1"] = $word_chart[$grade][Commons::ANIMATE_GENDER][Commons::SINGULAR]["inessive1"];
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::SINGULAR]["inessive2"] = $word_chart[$grade][Commons::ANIMATE_GENDER][Commons::SINGULAR]["inessive2"];		
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::SINGULAR]["comitative"] = $word_chart[$grade][Commons::ANIMATE_GENDER][Commons::SINGULAR]["comitative"];		
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::SINGULAR]["multiplicative"] = $word_chart[$grade][Commons::ANIMATE_GENDER][Commons::SINGULAR]["multiplicative"];	
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::SINGULAR]["essive"] = $word_chart[$grade][Commons::ANIMATE_GENDER][Commons::SINGULAR]["essive"];	
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::SINGULAR]["translative"] = $word_chart[$grade][Commons::ANIMATE_GENDER][Commons::SINGULAR]["translative"];		
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::SINGULAR]["temporal"] = $word_chart[$grade][Commons::ANIMATE_GENDER][Commons::SINGULAR]["temporal"];	
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::SINGULAR]["illative"] = $word_chart[$grade][Commons::ANIMATE_GENDER][Commons::SINGULAR]["illative"];	
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::SINGULAR]["distributive"] = $word_chart[$grade][Commons::ANIMATE_GENDER][Commons::SINGULAR]["distributive"];			
		}	
		// 結果を返す。
		return $word_chart;
	}	

    // 副詞を作成
	private function make_adverb_form($word_chart, $stem, $grade, $gender){
		
		// 各副詞を表に入れる。
		// 語幹がない場合は作成しない。
		if($stem == ""){
			$word_chart[$grade][$gender][Commons::SINGULAR]["elative"] = "-";
			$word_chart[$grade][$gender][Commons::SINGULAR]["inessive1"] = "-";
			$word_chart[$grade][$gender][Commons::SINGULAR]["inessive2"] = "-";		
			$word_chart[$grade][$gender][Commons::SINGULAR]["comitative"] = "-";		
			$word_chart[$grade][$gender][Commons::SINGULAR]["multiplicative"] = "-";	
			$word_chart[$grade][$gender][Commons::SINGULAR]["essive"] = "-";	
			$word_chart[$grade][$gender][Commons::SINGULAR]["translative"] = "-";		
			$word_chart[$grade][$gender][Commons::SINGULAR]["temporal"] = "-";	
			$word_chart[$grade][$gender][Commons::SINGULAR]["illative"] = "-";	
			$word_chart[$grade][$gender][Commons::SINGULAR]["distributive"] = "-";
		} else {
			$word_chart[$grade][$gender][Commons::SINGULAR]["elative"] = Sanskrit_Common::sandhi_engine($stem, "tas");
			$word_chart[$grade][$gender][Commons::SINGULAR]["inessive1"] = Sanskrit_Common::sandhi_engine($stem, "trā");
			$word_chart[$grade][$gender][Commons::SINGULAR]["inessive2"] = Sanskrit_Common::sandhi_engine($stem, "dha");		
			$word_chart[$grade][$gender][Commons::SINGULAR]["comitative"] = Sanskrit_Common::sandhi_engine($stem, "thā");		
			$word_chart[$grade][$gender][Commons::SINGULAR]["multiplicative"] = Sanskrit_Common::sandhi_engine($stem, "dhā");	
			$word_chart[$grade][$gender][Commons::SINGULAR]["essive"] = Sanskrit_Common::sandhi_engine($stem, "vat");	
			$word_chart[$grade][$gender][Commons::SINGULAR]["translative"] = Sanskrit_Common::sandhi_engine($stem, "sāt");		
			$word_chart[$grade][$gender][Commons::SINGULAR]["temporal"] = Sanskrit_Common::sandhi_engine($stem, "dā");	
			$word_chart[$grade][$gender][Commons::SINGULAR]["illative"] = Sanskrit_Common::sandhi_engine($stem, "ac");	
			$word_chart[$grade][$gender][Commons::SINGULAR]["distributive"] = Sanskrit_Common::sandhi_engine($stem, "sas");
		}


		// 結果を返す。
		return $word_chart;
	}
	
	// 曲用表を取得
	public function get_chart(){
		
		// 初期化
		$word_chart = array();
		
		// タイトル情報を挿入
		$word_chart['title'] = $this->get_adjective_title();
		// 辞書見出しを入れる。
		$word_chart['dic_title'] = $this->get_second_stem();
		// 種別を入れる。
		$word_chart['category'] = "形容詞";
		// 活用種別を入れる。
		$word_chart['type'] = $this->adjective_type_name;
		// 曲用を取得
		$word_chart = $this->make_adjective_declension($word_chart);
		// 副詞を取得
		$word_chart = $this->get_adverb_chart($word_chart);
		// 結果を返す。
		return $word_chart;
	}

	// 特定の格変化を取得する(ない場合はランダム)。
	public function get_form_by_number_case_gender_grade($case = "", $number = "", $gender = "", $grade = ""){

		// 格がない場合
		if($case == ""){
			// 全ての格の中からランダムで選択
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

		// 性別がない場合
		if($gender == ""){
			// 全ての性別の中からランダムで選択
			$ary = array(Commons::ANIMATE_GENDER, Commons::ACTION_GENDER, Commons::INANIMATE_GENDER);			// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$gender = $ary[$key];			
		}	

		// 形容詞の級に指定がない場合は
		if($grade == ""){
			// 全ての級を対象にする。
			$ary = array(Commons::ADJ_GRADE_POSITIVE, Commons::ADJ_GRADE_COMPERATIVE, Commons::ADJ_GRADE_SUPERATIVE);	// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$grade = $ary[$key];			
		}

		// 配列に格納
		$question_data = array();
		$question_data['question_sentence'] = $this->get_adjective_title()."の".Commons::change_gramatical_words($grade).Commons::change_gramatical_words($gender).Commons::change_gramatical_words($number).Commons::change_gramatical_words($case)."を答えよ";				
		$question_data['answer'] = $this->get_declensioned_adjective($case, $number, $gender, $grade);
		$question_data['question_sentence2'] = $question_data['answer']."の性、格と数を答えよ";	
		$question_data['case'] = $case;
		$question_data['number'] = $number;	
		$question_data['gender'] = $gender;
		$question_data['grade'] = $grade;			

		// 結果を返す。
		return $question_data;
	}	
	
}

// ポーランド語形容詞クラス
class Polish_Adjective extends Adjective_Common_IE {

	// 格語尾リスト
	protected $case_suffix_list =
		[
			[
				"adjective_type" => "1-2",
				"adjective_type_name" => "第一・第二活用",
				"gender" => "Feminine",
				"sg_nom" => "a",
				"sg_gen" => "ej",
				"sg_dat" => "ej",
				"sg_acc" => "ą",
				"sg_ins" => "ą",
				"sg_loc" => "ej",
				"sg_voc" => "a",
				"du_nom" => "a",
				"du_gen" => "óch",
				"du_dat" => "oma",
				"du_acc" => "a",
				"du_ins" => "oma",
				"du_loc" => "óch",
				"du_voc" => "a",
				"pl_nom" => "e",
				"pl_gen" => "ych",
				"pl_dat" => "ym",
				"pl_acc" => "e",
				"pl_ins" => "ymi",
				"pl_loc" => "ych",
				"pl_voc" => "e"
			],
			[
				"adjective_type" => "1-2",
				"adjective_type_name" => "第一・第二活用",				
				"gender" => "Masculine",
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
				"adjective_type" => "1-2",
				"adjective_type_name" => "第一・第二活用",				
				"gender" => "Neuter",
				"sg_nom" => "e",
				"sg_gen" => "ego",
				"sg_dat" => "emu",
				"sg_acc" => "e",
				"sg_ins" => "ym",
				"sg_loc" => "ym",
				"sg_voc" => "y",
				"du_nom" => "ie",
				"du_gen" => "óch",
				"du_dat" => "oma",
				"du_acc" => "ie",
				"du_ins" => "oma",
				"du_loc" => "óch",
				"du_voc" => "ie",
				"pl_nom" => "e",
				"pl_gen" => "ych",
				"pl_dat" => "ym",
				"pl_acc" => "e",
				"pl_ins" => "ymi",
				"pl_loc" => "ych",
				"pl_voc" => "e"
			],
			[
				"adjective_type" => "1-2i",
				"adjective_type_name" => "第一・第二活用",
				"gender" => "Feminine",
				"sg_nom" => "a",
				"sg_gen" => "iej",
				"sg_dat" => "iej",
				"sg_acc" => "ą",
				"sg_ins" => "ą",
				"sg_loc" => "iej",
				"sg_voc" => "a",
				"du_nom" => "a",
				"du_gen" => "óch",
				"du_dat" => "oma",
				"du_acc" => "a",
				"du_ins" => "oma",
				"du_loc" => "óch",
				"du_voc" => "a",
				"pl_nom" => "ie",
				"pl_gen" => "ich",
				"pl_dat" => "im",
				"pl_acc" => "ie",
				"pl_ins" => "imi",
				"pl_loc" => "ich",
				"pl_voc" => "ie"
			],
			[
				"adjective_type" => "1-2i",
				"adjective_type_name" => "第一・第二活用",				
				"gender" => "Masculine",
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
				"adjective_type" => "1-2i",
				"adjective_type_name" => "第一・第二活用",				
				"gender" => "Neuter",
				"sg_nom" => "ie",
				"sg_gen" => "iego",
				"sg_dat" => "iemu",
				"sg_acc" => "ie",
				"sg_ins" => "im",
				"sg_loc" => "im",
				"sg_voc" => "ie",
				"du_nom" => "ie",
				"du_gen" => "óch",
				"du_dat" => "oma",
				"du_acc" => "ie",
				"du_ins" => "oma",
				"du_loc" => "óch",
				"du_voc" => "ie",
				"pl_nom" => "ie",
				"pl_gen" => "ich",
				"pl_dat" => "im",
				"pl_acc" => "ie",
				"pl_ins" => "imi",
				"pl_loc" => "ich",
				"pl_voc" => "ie"
			],			
		];

	
		// 地名フラグ
	protected $location_name = "";
	
    /*=====================================
    コンストラクタ
    ======================================*/
    function __construct_polish1($adjective) {
    	// 親クラス初期化
		parent::__construct();
		// 形容詞情報を取得
		$this->set_adj_data(htmlspecialchars($adjective));
		// 比較級・最上級を作成
		$this->get_comp_super_stem($this->third_stem);
		
		// 活用語尾を取得
		$this->get_adj_declension(Commons::ADJ_GRADE_POSITIVE);		// 原級
		$this->get_adj_declension(Commons::ADJ_GRADE_COMPERATIVE);			// 比較級
		$this->get_adj_declension(Commons::ADJ_GRADE_SUPERATIVE);			// 最上級
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
    
    // 形容詞情報を取得
    private function set_adj_data($adjective){

    	// 形容詞情報を取得
		$word_info = $this->get_adjective_from_DB($adjective, Polish_Common::DB_ADJECTIVE);
		// データの取得確認
		if($word_info){
			// データを挿入
			$this->first_stem = $word_info["weak_stem"];						// 弱語幹
			$this->third_stem = mb_substr($word_info["strong_stem"], 0, -1);	// 強語幹
			$this->adjective_type = $word_info["adjective_type"];				// 形容詞種別
			$this->japanese_translation = $word_info["japanese_translation"];	//日本語訳
			$this->english_translation = $word_info["english_translation"];		//英語訳
			$this->deponent_singular = $word_info["deponent_singular"];			//単数のみフラグ
			$this->deponent_plural = $word_info["deponent_plural"];				//複数のみフラグ
			$this->location_name = $word_info["location_name"];					//地名フラグ
		} else {
			// 訳を指定
			$this->japanese_translation = "借用";
			$this->english_translation = "loanword";
			// 形容詞の語幹を設定
			$this->first_stem = $adjective;         // 弱語幹
			$this->third_stem = $adjective;         // 強語幹
			// 形容詞の語幹と曲用種別を設定
			// 文字列の最後で判断
			if(preg_match("/y$/", $adjective)){
				$this->adjective_type = "1-2";          				// 名詞種別
				$this->third_stem = mb_substr($adjective, 0, -1);		// 強語幹を変更			
			} else if(preg_match("/(i)$/", $adjective)){
				$this->adjective_type = "1-2i";       					// 名詞種別	
				$this->third_stem = mb_substr($adjective, 0, -1);		// 強語幹を変更			
			} else {
				$this->adjective_type = "1-2";          				// 名詞種別		
				$this->first_stem = $adjective."y";						// 弱語幹を変更
			}
		}
    }

	// 比較級・最上級を作成
	private function get_comp_super_stem($stem){

		switch($stem){
			case "dobr":
				$this->comparative_first_stem = "lepszy";		// 比較級弱語幹
				$this->comparative_third_stem = "lepsz";		// 比較級強語幹				
				break;
			case "zł":
				$this->comparative_first_stem = "gorszy";		// 比較級弱語幹
				$this->comparative_third_stem = "gorsz";		// 比較級強語幹					
				break;
			case "mał":
				$this->comparative_first_stem = "mniejszy";		// 比較級弱語幹
				$this->comparative_third_stem = "mniejsz";		// 比較級強語幹					
				break;
			case "wielk":
				$this->comparative_first_stem = "większy";		// 比較級弱語幹
				$this->comparative_third_stem = "większ";		// 比較級強語幹				
				break;				
			case "wysok":
				$this->comparative_first_stem = "wyższy";		// 比較級弱語幹
				$this->comparative_third_stem = "wyższ";		// 比較級強語幹
				break;
			case "gorąc":
				$this->comparative_first_stem = "gorętszy";		// 比較級弱語幹
				$this->comparative_third_stem = "gorętsz";		// 比較級強語幹
				break;
			case "tward":
				$this->comparative_first_stem = "twardszy";		// 比較級弱語幹
				$this->comparative_third_stem = "twardsz";		// 比較級強語幹
				break;				
			default:
				// 通常処理の場合
				if(preg_match('/sk$/', $stem)) {
					$stem = preg_replace("/sk$/", "ż", $stem);
					$this->comparative_first_stem = $stem."szy";		// 比較級弱語幹
					$this->comparative_third_stem = $stem."sz";			// 比較級強語幹
				} else if(preg_match('/k$/', $stem) && !preg_match('/kk$/', $stem)) {
					// ki形容詞
					$this->comparative_first_stem = mb_substr($stem, 0, -1)."szy";		// 比較級弱語幹
					$this->comparative_third_stem = mb_substr($stem, 0, -1)."sz";		// 比較級強語幹
				} else if(preg_match('/n$/', $stem)) {
					// ny形容詞
					$this->comparative_first_stem = mb_substr($stem, 0, -1)."iejszy";		// 比較級弱語幹
					$this->comparative_third_stem = mb_substr($stem, 0, -1)."iejsz";		// 比較級強語幹
				} else if(preg_match('/ow$/', $stem)) {
					// owy形容詞
					$this->comparative_first_stem = "bardziej ".$stem."y";	// 比較級弱語幹
					$this->comparative_third_stem = "bardziej ".$stem;		// 比較級強語幹
				} else if(preg_match('/[^aiueoąę][^aiueoąę]$/', $stem) && !preg_match('/kk$/', $stem)){
					$stem = preg_replace("/ł$/", "l", $stem);
					$stem = preg_replace("/st$/", "ści", $stem);					
					$stem = preg_replace("/w$/", "wi", $stem);
					$stem = preg_replace("/n$/", "ni", $stem);
					$stem = preg_replace("/r$/", "rz", $stem);					
					$stem = preg_replace("/[g|sk]$/", "ż", $stem);
					$stem = preg_replace("/[ao](.)$/", "e\\1", $stem);
					$stem = preg_replace("/ą/", "ę", $stem);
					$stem = preg_replace("/kk$/", "k", $stem);					
					$this->comparative_first_stem = $stem."ejszy";		// 比較級弱語幹
					$this->comparative_third_stem = $stem."ejsz";		// 比較級強語幹
				} else {
					$stem = preg_replace("/ł$/", "l", $stem);
					$stem = preg_replace("/n$/", "ń", $stem);
					$stem = preg_replace("/[g|sk]$/", "ż", $stem);
					$stem = preg_replace("/[ao](.)$/", "e\\1", $stem);
					$stem = preg_replace("/ą/", "ę", $stem);
					$stem = preg_replace("/kk$/", "k", $stem);
					$this->comparative_first_stem = $stem."szy";		// 比較級弱語幹
					$this->comparative_third_stem = $stem."sz";			// 比較級強語幹
				}
				break;
		}
		$this->superlative_first_stem = "naj".$this->comparative_first_stem;		// 最上級強語幹
		$this->superlative_third_stem = "naj".$this->comparative_third_stem;		// 最上級強語幹		

	}
	
	// 形容詞活用取得
	private function get_adj_declension($grade){
		// 形容詞の程度で分岐する。
		if($grade == Commons::ADJ_GRADE_POSITIVE){
			$adjective_type = $this->adjective_type;
		} else if($grade == Commons::ADJ_GRADE_COMPERATIVE){
			$adjective_type = "1-2";
		} else if($grade == Commons::ADJ_GRADE_SUPERATIVE){
			$adjective_type = "1-2";
		}

		// 曲用を取得
		$masculine_declension = $this->get_adjective_case_suffix($adjective_type, "Masculine");
		$feminine_declension = $this->get_adjective_case_suffix($adjective_type, "Feminine");
		$neuter_declension = $this->get_adjective_case_suffix($adjective_type, "Neuter");

		// 活用表を挿入(男性)
		// 単数
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::NOMINATIVE] = $masculine_declension["sg_nom"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::GENETIVE] = $masculine_declension["sg_gen"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::DATIVE] = $masculine_declension["sg_dat"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::ACCUSATIVE] = $masculine_declension["sg_acc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::INSTRUMENTAL] = $masculine_declension["sg_ins"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::LOCATIVE] = $masculine_declension["sg_loc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::VOCATIVE] = $masculine_declension["sg_voc"];
		
		// 双数
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::NOMINATIVE] = $masculine_declension["du_nom"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::GENETIVE] = $masculine_declension["du_gen"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::DATIVE] = $masculine_declension["du_dat"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::ACCUSATIVE] = $masculine_declension["du_acc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::INSTRUMENTAL] = $masculine_declension["du_ins"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::LOCATIVE] = $masculine_declension["du_loc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::VOCATIVE] = $masculine_declension["du_voc"];
		
		// 複数
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::NOMINATIVE] = $masculine_declension["pl_nom"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::GENETIVE] = $masculine_declension["pl_gen"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::DATIVE] = $masculine_declension["pl_dat"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::ACCUSATIVE] = $masculine_declension["pl_acc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::INSTRUMENTAL] = $masculine_declension["pl_ins"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::LOCATIVE] = $masculine_declension["pl_loc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::VOCATIVE] = $masculine_declension["pl_voc"];

		// 活用表を挿入(女性)		
		// 単数
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::NOMINATIVE] = $feminine_declension["sg_nom"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::GENETIVE] = $feminine_declension["sg_gen"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::DATIVE] = $feminine_declension["sg_dat"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::ACCUSATIVE] = $feminine_declension["sg_acc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::INSTRUMENTAL] = $feminine_declension["sg_ins"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::LOCATIVE] = $feminine_declension["sg_loc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::VOCATIVE] = $feminine_declension["sg_voc"];
		
		// 双数
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::NOMINATIVE] = $feminine_declension["du_nom"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::GENETIVE] = $feminine_declension["du_gen"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::DATIVE] = $feminine_declension["du_dat"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::ACCUSATIVE] = $feminine_declension["du_acc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::INSTRUMENTAL] = $feminine_declension["du_ins"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::LOCATIVE] = $feminine_declension["du_loc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::VOCATIVE] = $feminine_declension["du_voc"];
		
		// 複数
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::NOMINATIVE] = $feminine_declension["pl_nom"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::GENETIVE] = $feminine_declension["pl_gen"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::DATIVE] = $feminine_declension["pl_dat"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::ACCUSATIVE] = $feminine_declension["pl_acc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::INSTRUMENTAL] = $feminine_declension["pl_ins"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::LOCATIVE] = $feminine_declension["pl_loc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::VOCATIVE] = $feminine_declension["pl_voc"];

		// 活用表を挿入(女性)		
		// 単数
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::NOMINATIVE] = $neuter_declension["sg_nom"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::GENETIVE] = $neuter_declension["sg_gen"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::DATIVE] = $neuter_declension["sg_dat"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::ACCUSATIVE] = $neuter_declension["sg_acc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::INSTRUMENTAL] = $neuter_declension["sg_ins"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::LOCATIVE] = $neuter_declension["sg_loc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::VOCATIVE] = $neuter_declension["sg_voc"];
		
		// 双数
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::NOMINATIVE] = $neuter_declension["du_nom"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::GENETIVE] = $neuter_declension["du_gen"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::DATIVE] = $neuter_declension["du_dat"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::ACCUSATIVE] = $neuter_declension["du_acc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::INSTRUMENTAL] = $neuter_declension["du_ins"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::LOCATIVE] = $neuter_declension["du_loc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::VOCATIVE] = $neuter_declension["du_voc"];
		
		// 複数
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::NOMINATIVE] = $neuter_declension["pl_nom"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::GENETIVE] = $neuter_declension["pl_gen"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::DATIVE] = $neuter_declension["pl_dat"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::ACCUSATIVE] = $neuter_declension["pl_acc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::INSTRUMENTAL] = $neuter_declension["pl_ins"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::LOCATIVE] = $neuter_declension["pl_loc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::VOCATIVE] = $neuter_declension["pl_voc"];
		
		// 活用を挿入
		if($grade == Commons::ADJ_GRADE_POSITIVE){
			// 活用種別名
			$this->adjective_type_name = $masculine_declension["adjective_type_name"];				
			$this->case_suffix = $case_suffixes;
		} else if($grade == Commons::ADJ_GRADE_COMPERATIVE){
			$this->comparative_case_suffix = $case_suffixes;
		} else if($grade == Commons::ADJ_GRADE_SUPERATIVE){
			$this->superlative_case_suffix = $case_suffixes;
		}		
	}
	
	// 形容詞作成(原級)
	protected function generate_positive($case, $number, $gender){
		// 格語尾を取得
		$case_suffix = "";
		// 曲用語尾を取得
		if($number == Commons::SINGULAR && $this->deponent_singular != Commons::$TRUE){
			// 単数
			$case_suffix = $this->case_suffix[$gender][$number][$case];
		} else if($number == Commons::DUAL && ($this->deponent_plural != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->case_suffix[$gender][$number][$case];			
		} else if($number == Commons::PLURAL && ($this->deponent_plural != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->case_suffix[$gender][$number][$case];
		} else {
			// ハイフンを返す。
			return "-";
		}

		// 語幹を取得
		// それ以外は単数の主格と呼格は弱語幹
		if($gender == Commons::ANIMATE_GENDER && Commons::SINGULAR && ($case == Commons::NOMINATIVE || $case == Commons::VOCATIVE)){
			// ここで結果を返す。
			return $this->first_stem;					
		} else if($case == Commons::ACCUSATIVE && $gender == Commons::INANIMATE_GENDER && $number == Commons::SINGULAR){
			// 中性の単数対格は主格と同じ
			// ここで結果を返す。
			return $this->first_stem;
		} else {
			// それ以外は強語幹
			$adjective = $this->third_stem;
		}

		// 連音処理
		$adjective = trim($adjective.$case_suffix);				// 下処理
		$adjective = Polish_Common::polish_sandhi($adjective);

		// 結果を返す
		return $adjective;
	}
	
	// 形容詞作成(比較級)
	protected function generate_comp($case, $number, $gender){
		// 格語尾を取得
		$case_suffix = null;
		// 曲用語尾を取得
		if($number == Commons::SINGULAR && $this->deponent_singular != Commons::$TRUE){
			// 単数
			$case_suffix = $this->comparative_case_suffix[$gender][$number][$case];
		} else if($number == Commons::DUAL && ($this->deponent_plural != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->comparative_case_suffix[$gender][$number][$case];				
		} else if($number == Commons::PLURAL && ($this->deponent_singular != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->comparative_case_suffix[$gender][$number][$case];
		} else {
			// ハイフンを返す。
			return "-";
		}

		// 結果を返す
		return trim($this->comparative_third_stem.$case_suffix);
	}	
	
	// 形容詞作成(最上級)
	protected function generate_super($case, $number, $gender){
		// 格語尾を取得
		$case_suffix = null;
		// 曲用語尾を取得
		if($number == Commons::SINGULAR && $this->deponent_singular != Commons::$TRUE){
			// 単数
			$case_suffix = $this->superlative_case_suffix[$gender][$number][$case];
		} else if($number == Commons::DUAL && ($this->deponent_plural != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->superlative_case_suffix[$gender][$number][$case];				
		} else if($number == Commons::PLURAL && ($this->deponent_singular != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->superlative_case_suffix[$gender][$number][$case];
		} else {
			// ハイフンを返す。
			return "-";
		}

		// 結果を返す
		return trim($this->superlative_third_stem.$case_suffix);
	}
	
	// 副詞作成
    public function get_adverb($grade = "positive"){ 	
		// 初期化
		$adverb = "";
		// 形容詞の程度で分岐する。
		if($grade == Commons::ADJ_GRADE_POSITIVE){
			// 原級
			// 活用種別で分岐
			$adverb = $this->third_stem."e";			
		} else if($grade == Commons::ADJ_GRADE_COMPERATIVE){
			// 比較級
			$adverb = $this->comparative_third_stem."ej";
		} else if($grade == Commons::ADJ_GRADE_SUPERATIVE){
			// 最上級
			$adverb = $this->superlative_third_stem."ej";
		}
		// 結果を返す
		return $adverb;
    }

    // 曲用表をすべて取得
	public function get_chart(){
		// 初期化
		$word_chart = array();		
		// タイトル情報を挿入
		$word_chart['title'] = $this->get_adjective_title();
		// 辞書見出しを入れる。
		$word_chart['dic_title'] = $this->get_first_stem();
		// 活用種別を入れる。
		$word_chart['type'] = $this->adjective_type_name;
		// 曲用を取得
		$word_chart = $this->make_adjective_declension($word_chart);
		// 副詞の情報を入れる。
		$word_chart[Commons::ADJ_GRADE_POSITIVE]["adverb"] = $this->get_adverb(Commons::ADJ_GRADE_POSITIVE);
		$word_chart[Commons::ADJ_GRADE_COMPERATIVE]["adverb"] = $this->get_adverb(Commons::ADJ_GRADE_COMPERATIVE);
		$word_chart[Commons::ADJ_GRADE_SUPERATIVE]["adverb"] = $this->get_adverb(Commons::ADJ_GRADE_SUPERATIVE);

		// 結果を返す。
		return $word_chart;
	}

	// 語幹を取得
	public function get_first_stem(){
		return $this->first_stem;
	}

	// 語幹を取得
	public function get_third_stem(){
		return $this->third_stem;
	}

	// 特定の格変化を取得する(ない場合はランダム)。
	public function get_form_by_number_case_gender_grade($case, $number, $gender, $grade){

		// 格がない場合
		if($case == ""){
			// 全ての格の中からランダムで選択
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

		// 性別がない場合
		if($gender == ""){
			// 全ての性別の中からランダムで選択
			$ary = array(Commons::ANIMATE_GENDER, Commons::ACTION_GENDER, Commons::INANIMATE_GENDER);			// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$gender = $ary[$key];			
		}	

		// 形容詞の級に指定がない場合は
		if($grade == ""){
			// 全ての級を対象にする。
			$ary = array(Commons::ADJ_GRADE_POSITIVE, Commons::ADJ_GRADE_COMPERATIVE, Commons::ADJ_GRADE_SUPERATIVE);	// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$grade = $ary[$key];			
		}

		// 配列に格納
		$question_data = array();
		$question_data['question_sentence'] = $this->get_adjective_title()."の".Commons::change_gramatical_words($gender).Commons::change_gramatical_words($number).Commons::change_gramatical_words($case)."を答えよ";				
		$question_data['answer'] = $this->get_declensioned_adjective($case, $number, $gender, $grade);
		$question_data['question_sentence2'] = $question_data['answer']."の性、格と数を答えよ";	
		$question_data['case'] = $case;
		$question_data['number'] = $number;	
		$question_data['gender'] = $gender;
		$question_data['grade'] = $grade;			

		// 結果を返す。
		return $question_data;
	}	

}

// ギリシア語共通クラス
class Koine_Adjective extends Adjective_Common_IE {

	// 格語尾リスト
	protected $case_suffix_list =  [
		[
			"adjective_type" => "1-2",
			"adjective_type_name" => "a-変化形容詞",				
			"gender" => "Feminine",
			"sg_nom" => "ᾱ",
			"sg_gen" => "ᾱς",
			"sg_dat" => "ᾳ",
			"sg_acc" => "ᾱν",
			"sg_voc" => "ᾱ",
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
			"adjective_type" => "1-2",
			"adjective_type_name" => "a-変化形容詞",			
			"gender" => "Masculine",
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
			"adjective_type" => "1-2",
			"adjective_type_name" => "a-変化形容詞",			
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
			"adjective_type" => "1-2o",
			"adjective_type_name" => "a-変化形容詞",			
			"gender" => "Masculine/Feminine",
			"sg_nom" => "ως",
			"sg_gen" => "ω",
			"sg_dat" => "ῳ",
			"sg_acc" => "ων",
			"sg_voc" => "ε",
			"du_nom" => "ω",
			"du_gen" => "ῳν",
			"du_dat" => "ῳν",
			"du_acc" => "ω",
			"du_voc" => "ω",
			"pl_nom" => "ῳ",
			"pl_gen" => "ῶν",
			"pl_dat" => "ῳς",
			"pl_acc" => "ως",
			"pl_voc" => "ωι"
		],
		[
			"adjective_type" => "1-2o",
			"adjective_type_name" => "a-変化形容詞",			
			"gender" => "Neuter",
			"sg_nom" => "ων",
			"sg_gen" => "ωυ",
			"sg_dat" => "ῳ",
			"sg_acc" => "ων",
			"sg_voc" => "ων",
			"du_nom" => "ω",
			"du_gen" => "ῳν",
			"du_dat" => "ῳν",
			"du_acc" => "ω",
			"du_voc" => "ω",
			"pl_nom" => "ᾰ",
			"pl_gen" => "ῶν",
			"pl_dat" => "ωις",
			"pl_acc" => "ᾰ",
			"pl_voc" => "ᾰ"
		],
		[
			"adjective_type" => "1-2a",
			"adjective_type_name" => "a-変化形容詞(アテネ)",				
			"gender" => "Feminine",
			"sg_nom" => "ᾱ",
			"sg_gen" => "ᾱς",
			"sg_dat" => "ᾳ",
			"sg_acc" => "ᾱν",
			"sg_voc" => "ᾱ",
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
			"adjective_type" => "1-2a",
			"adjective_type_name" => "a-変化形容詞(アテネ)",			
			"gender" => "Masculine",
			"sg_nom" => "οῦς",
			"sg_gen" => "ου",
			"sg_dat" => "ῳ",
			"sg_acc" => "οῦν",
			"sg_voc" => "οῦ",
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
			"adjective_type" => "1-2a",
			"adjective_type_name" => "a-変化形容詞(アテネ)",			
			"gender" => "Neuter",
			"sg_nom" => "οῦν",
			"sg_gen" => "οῦ",
			"sg_dat" => "ῳ",
			"sg_acc" => "οῦν",
			"sg_voc" => "οῦν",
			"du_nom" => "ω",
			"du_gen" => "οῖν",
			"du_dat" => "οῖν",
			"du_acc" => "ω",
			"du_voc" => "ω",
			"pl_nom" => "ᾰ",
			"pl_gen" => "ῶν",
			"pl_dat" => "οις",
			"pl_acc" => "ᾰ",
			"pl_voc" => "ᾰ"
		],
		[
			"adjective_type" => "3s",
			"adjective_type_name" => "語根形容詞",	
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
			"adjective_type" => "3s",
			"adjective_type_name" => "語根形容詞",	
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
			"adjective_type" => "3i",
			"adjective_type_name" => "i-変化形容詞",	
			"gender" => "Feminine/Masculine",
			"sg_nom" => "ης",
			"sg_gen" => "ους",
			"sg_dat" => "ει",
			"sg_acc" => "η",
			"sg_voc" => "ες",
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
			"adjective_type" => "3i",
			"adjective_type_name" => "i-変化形容詞",	
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
			"adjective_type" => "3t",
			"adjective_type_name" => "t-変化形容詞",
			"gender" => "Masculine",
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
			"pl_dat" => "εσῐ",
			"pl_acc" => "ᾰ",
			"pl_voc" => "ᾰ"
		],
		[
			"adjective_type" => "3t",
			"adjective_type_name" => "t-変化形容詞",
			"gender" => "Neuter",
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
			"pl_dat" => "εσῐ",
			"pl_acc" => "ᾰ",
			"pl_voc" => "ᾰ"
		],
		[
			"adjective_type" => "3t",
			"adjective_type_name" => "t-変化形容詞",				
			"gender" => "Feminine",
			"sg_nom" => "ᾰ",
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
			"adjective_type" => "3nt",
			"adjective_type_name" => "t-変化形容詞",
			"gender" => "Masculine",
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
			"pl_dat" => "εσῐ",
			"pl_acc" => "ᾰ",
			"pl_voc" => "ᾰ"
		],

		[
			"adjective_type" => "3nt",
			"adjective_type_name" => "t-変化形容詞",
			"gender" => "Neuter",
			"sg_nom" => "ον",
			"sg_gen" => "ος",
			"sg_dat" => "ι",
			"sg_acc" => "ον",
			"sg_voc" => "",
			"du_nom" => "ε",
			"du_gen" => "οιν",
			"du_dat" => "οιν",
			"du_acc" => "ε",
			"du_voc" => "ε",
			"pl_nom" => "ᾰ",
			"pl_gen" => "ῶν",
			"pl_dat" => "εσῐ",
			"pl_acc" => "ᾰ",
			"pl_voc" => "ᾰ"
		],
		[
			"adjective_type" => "3nt",
			"adjective_type_name" => "t-変化形容詞",				
			"gender" => "Feminine",
			"sg_nom" => "ᾰ",
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
			"adjective_type" => "3at",
			"adjective_type_name" => "t-変化形容詞",
			"gender" => "Masculine",
			"sg_nom" => "ον",
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
			"pl_dat" => "εσῐ",
			"pl_acc" => "ᾰ",
			"pl_voc" => "ᾰ"
		],
		[
			"adjective_type" => "3at",
			"adjective_type_name" => "t-変化形容詞",
			"gender" => "Neuter",
			"sg_nom" => "ον",
			"sg_gen" => "ος",
			"sg_dat" => "ι",
			"sg_acc" => "ον",
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
			"adjective_type" => "3at",
			"adjective_type_name" => "t-変化形容詞",				
			"gender" => "Feminine",
			"sg_nom" => "ᾰ",
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
			"adjective_type" => "3n",
			"adjective_type_name" => "n-変化形容詞",
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
			"adjective_type" => "3n",
			"adjective_type_name" => "n-変化形容詞",
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
			"adjective_type" => "3con",
			"adjective_type_name" => "子音変化形容詞",
			"gender" => "Masculine/Feminine",
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
			"pl_nom" => "ες",
			"pl_gen" => "ῶν",
			"pl_dat" => "ι",
			"pl_acc" => "ας",
			"pl_voc" => "ες"
		],
		[
			"adjective_type" => "3con",
			"adjective_type_name" => "子音変化形容詞",
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
			"adjective_type" => "o-long",
			"adjective_type_name" => "ō-変化名詞",
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
			"adjective_type" => "o-long",
			"adjective_type_name" => "ō-変化名詞",
			"gender" => "Masculine/Neuter",
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
			"noun_type" => "4u",
			"noun_type_name" => "u-変化名詞",
			"gender" => "Masculine",
			"sg_nom" => "ύς",
			"sg_gen" => "έος",
			"sg_dat" => "εῖ",
			"sg_acc" => "ύν",
			"sg_voc" => "ύ",
			"du_nom" => "έε",
			"du_gen" => "έοιν",
			"du_dat" => "έοιν",
			"du_acc" => "έε",
			"du_voc" => "έε",
			"pl_nom" => "εῖς",
			"pl_gen" => "εων",
			"pl_dat" => "έσῐν",
			"pl_acc" => "εῖς",
			"pl_voc" => "εῖς"
		],
		[
			"noun_type" => "4u",
			"noun_type_name" => "u-変化名詞",
			"gender" => "Feminine",
			"sg_nom" => "εῖᾰ",
			"sg_gen" => "είᾱς",
			"sg_dat" => "είᾳ",
			"sg_acc" => "εῖᾰν",
			"sg_voc" => "εῖᾰ",
			"du_nom" => "είᾱ",
			"du_gen" => "είαιν",
			"du_dat" => "είαιν",
			"du_acc" => "είᾱ",
			"du_voc" => "είᾱ",
			"pl_nom" => "εῖαι",
			"pl_gen" => "ειῶν",
			"pl_dat" => "είαις",
			"pl_acc" => "είᾱς",
			"pl_voc" => "εῖαι"
		],
		[
			"noun_type" => "4u",
			"noun_type_name" => "u-変化名詞",
			"gender" => "Neuter",
			"sg_nom" => "ῠ́",
			"sg_gen" => "έος",
			"sg_dat" => "εῖ",
			"sg_acc" => "ῠ́",
			"sg_voc" => "ῠ́",
			"du_nom" => "έε",
			"du_gen" => "έοιν",
			"du_dat" => "έοιν",
			"du_acc" => "έε",
			"du_voc" => "έε",
			"pl_nom" => "έᾰ",
			"pl_gen" => "έων",
			"pl_dat" => "έσῐν",
			"pl_acc" => "έᾰ",
			"pl_voc" => "έᾰ"
		],
	];

	// 比較級種別
	protected $comp_type = "";

	// 副詞種別
	protected const adverb_suffix = "φῐ";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_koine3($compound, $last_word, $translation) {
    	// 親クラス初期化
		parent::__construct();
		// 形容詞情報をセット
		$this->set_adj_data($last_word);
		// 残りの語幹を作成
		$this->make_other_stem();	
		// 語幹を変更
		$this->first_stem = $compound.$this->first_stem;		// 第一語幹
		$this->second_stem = $compound.$this->second_stem;		// 第二語幹		
		$this->third_stem = $compound.$this->third_stem;		// 第三語幹
		// 比較級・最上級を作成
		$this->get_comp_super_stem();
		// 日本語訳を書き換え
		$this->japanese_translation = $translation;			// 日本語訳
		$this->english_translation = "";			// 英語訳
		
		// 活用表を挿入
		$this->get_adj_declension(Commons::ADJ_GRADE_POSITIVE);
		$this->get_adj_declension(Commons::ADJ_GRADE_COMPERATIVE);
		$this->get_adj_declension(Commons::ADJ_GRADE_SUPERATIVE);
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_koine2($adjective, $flag) {
    	// 親クラス初期化
		parent::__construct();
		// 比較級フラグ
		$this->comp_type = Commons::$FALSE;
		// 文字列の最後で判断
		if(preg_match('/ος$/',$adjective)){		
			// 形容詞の種別で活用が決定する。		
			$this->adjective_type = "1-2";           						// 名詞種別
			$this->second_stem = mb_substr($adjective, 0, -2);				// 第二語幹
		} else if(preg_match('/ων$/',$adjective)){
			$this->adjective_type = "3nt";									// 名詞種別
			$this->second_stem = $adjective;								// 第二語幹		
		} else {		
			// 形容詞の種別で活用が決定する。													
			$this->adjective_type = "3s";									// 名詞種別
			$this->second_stem = $adjective;								// 第二語幹
		}
		// 残りの語幹を作成
		$this->make_other_stem();
		// 比較級・最上級を作成
		$this->get_comp_super_stem();		
		// 活用語尾を取得
		$this->get_adj_declension(Commons::ADJ_GRADE_POSITIVE);		// 原級
		$this->get_adj_declension(Commons::ADJ_GRADE_COMPERATIVE);		// 比較級
		$this->get_adj_declension(Commons::ADJ_GRADE_SUPERATIVE);		// 最上級
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_koine1($adjective) {
    	// 親クラス初期化
		parent::__construct();
		// 形容詞情報をセット
		$this->set_adj_data(htmlspecialchars($adjective));
		// 残りの語幹を作成
		$this->make_other_stem();
		// 比較級・最上級を作成
		$this->get_comp_super_stem();		
		// 活用語尾を取得
		$this->get_adj_declension(Commons::ADJ_GRADE_POSITIVE);		// 原級
		$this->get_adj_declension(Commons::ADJ_GRADE_COMPERATIVE);		// 比較級
		$this->get_adj_declension(Commons::ADJ_GRADE_SUPERATIVE);		// 最上級
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
    private function get_adj_declension($grade = "positive"){

		// 形容詞の程度で分岐する。
		if($grade == Commons::ADJ_GRADE_POSITIVE){
			$adjective_type = $this->adjective_type;
		} else if($grade == Commons::ADJ_GRADE_COMPERATIVE){
			$adjective_type = "1-2";
		} else if($grade == Commons::ADJ_GRADE_SUPERATIVE){
			$adjective_type = "1-2";
		} else {
			$adjective_type = "1-2";		
		}
		// 曲用を取得
		$masculine_declension = $this->get_adjective_case_suffix($adjective_type, "Masculine");
		$feminine_declension = $this->get_adjective_case_suffix($adjective_type, "Feminine");
		$neuter_declension = $this->get_adjective_case_suffix($adjective_type, "Neuter");

		// 活用表を挿入(男性)
		// 単数
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::NOMINATIVE] = $masculine_declension["sg_nom"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::GENETIVE] = $masculine_declension["sg_gen"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::DATIVE] = $masculine_declension["sg_dat"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::ACCUSATIVE] = $masculine_declension["sg_acc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::VOCATIVE] = $masculine_declension["sg_voc"];
		
		// 双数
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::NOMINATIVE] = $masculine_declension["du_nom"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::GENETIVE] = $masculine_declension["du_gen"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::DATIVE] = $masculine_declension["du_dat"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::ACCUSATIVE] = $masculine_declension["du_acc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::DUAL][Commons::VOCATIVE] = $masculine_declension["du_voc"];
		
		// 複数
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::NOMINATIVE] = $masculine_declension["pl_nom"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::GENETIVE] = $masculine_declension["pl_gen"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::DATIVE] = $masculine_declension["pl_dat"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::ACCUSATIVE] = $masculine_declension["pl_acc"];
		$case_suffixes[Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::VOCATIVE] = $masculine_declension["pl_voc"];

		// 活用表を挿入(女性)		
		// 単数
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::NOMINATIVE] = $feminine_declension["sg_nom"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::GENETIVE] = $feminine_declension["sg_gen"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::DATIVE] = $feminine_declension["sg_dat"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::ACCUSATIVE] = $feminine_declension["sg_acc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::VOCATIVE] = $feminine_declension["sg_voc"];
		
		// 双数
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::NOMINATIVE] = $feminine_declension["du_nom"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::GENETIVE] = $feminine_declension["du_gen"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::DATIVE] = $feminine_declension["du_dat"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::ACCUSATIVE] = $feminine_declension["du_acc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::DUAL][Commons::VOCATIVE] = $feminine_declension["du_voc"];
		
		// 複数
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::NOMINATIVE] = $feminine_declension["pl_nom"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::GENETIVE] = $feminine_declension["pl_gen"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::DATIVE] = $feminine_declension["pl_dat"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::ACCUSATIVE] = $feminine_declension["pl_acc"];
		$case_suffixes[Commons::ACTION_GENDER][Commons::PLURAL][Commons::VOCATIVE] = $feminine_declension["pl_voc"];

		// 活用表を挿入(女性)		
		// 単数
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::NOMINATIVE] = $neuter_declension["sg_nom"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::GENETIVE] = $neuter_declension["sg_gen"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::DATIVE] = $neuter_declension["sg_dat"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::ACCUSATIVE] = $neuter_declension["sg_acc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::VOCATIVE] = $neuter_declension["sg_voc"];
		
		// 双数
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::NOMINATIVE] = $neuter_declension["du_nom"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::GENETIVE] = $neuter_declension["du_gen"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::DATIVE] = $neuter_declension["du_dat"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::ACCUSATIVE] = $neuter_declension["du_acc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::DUAL][Commons::VOCATIVE] = $neuter_declension["du_voc"];
		
		// 複数
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::NOMINATIVE] = $neuter_declension["pl_nom"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::GENETIVE] = $neuter_declension["pl_gen"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::DATIVE] = $neuter_declension["pl_dat"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::ACCUSATIVE] = $neuter_declension["pl_acc"];
		$case_suffixes[Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::VOCATIVE] = $neuter_declension["pl_voc"];

		// 活用を挿入
		if($grade == Commons::ADJ_GRADE_POSITIVE){
			// 活用種別名
			$this->adjective_type_name = $masculine_declension["adjective_type_name"];				
			$this->case_suffix = $case_suffixes;
		} else if($grade == Commons::ADJ_GRADE_COMPERATIVE){
			$this->comparative_case_suffix = $case_suffixes;
		} else if($grade == Commons::ADJ_GRADE_SUPERATIVE){
			$this->superlative_case_suffix = $case_suffixes;
		}	
    }

	// 語幹を作成
	private function make_other_stem(){
		// 活用種別に合わせて語幹を作る。
		if(preg_match('/^(1-2)/',$this->adjective_type)){
			// 第一・第二変化活用の場合
			$this->first_stem = $this->second_stem;		// 弱語幹
			$this->third_stem = $this->second_stem;		// 強語幹
		} else if(preg_match('/^(root|3t|3con)/',$this->adjective_type)){
			// 子音活用の場合
			// 単語の語尾で語幹が変化する。			
			if(preg_match('/(τ|δ|θ)$/',$this->second_stem)){				
				$this->first_stem = mb_substr($this->second_stem, 0, -1);			
				$this->third_stem = mb_substr($this->second_stem, 0, -1)."σ";
			} else if(preg_match('/(κ|γ|χ)$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -1);			
				$this->third_stem = mb_substr($this->second_stem, 0, -1)."ξ";			
			} else if(preg_match('/(π|β|φ)$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -1);			
				$this->third_stem = mb_substr($this->second_stem, 0, -1)."ψ";	
			} else if(preg_match('/όν$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -2)."ών";			
				$this->third_stem = mb_substr($this->second_stem, 0, -2);
			}		
		} else if(preg_match('/^(3at)/',$this->adjective_type)){
			// 子音活用の場合			
			$this->first_stem = mb_substr($this->second_stem, 0, -1);			
			$this->third_stem = mb_substr($this->second_stem, 0, -1)."τ";
		} else if(preg_match('/^(3nt)/',$this->adjective_type)){
			// 子音活用の場合
			// 単語の語尾で語幹が変化する。		
			if(preg_match('/εντ$/',$this->second_stem)){				
				$this->first_stem = mb_substr($this->second_stem, 0, -2)."ις";			
				$this->third_stem = mb_substr($this->second_stem, 0, -2)."σσ";
			} else if(preg_match('/οντ$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -3)."ων";			
				$this->third_stem = mb_substr($this->second_stem, 0, -3)."ουσ";
			} else if(preg_match('/ᾰντ$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -3)."ᾱς";			
				$this->third_stem = mb_substr($this->second_stem, 0, -3)."ᾱσ";			
			} else {
				$this->first_stem = mb_substr($this->second_stem, 0, -1)."σ";			
				$this->third_stem = mb_substr($this->second_stem, 0, -1)."ντ";
			}		
		} else if(preg_match('/^(3n)/',$this->adjective_type)){
			// 子音活用の場合			
			$this->first_stem = mb_substr($this->second_stem, 0, -1);			
			$this->third_stem = mb_substr($this->second_stem, 0, -1)."ν";
		} else {
			// それ以外の活用の場合				
			$this->first_stem = $this->second_stem;			// 弱語幹
			$this->third_stem = $this->second_stem;			// 強語幹
		}
	}
    
    // 形容詞情報を取得
    private function set_adj_data($adjective){
    	// 名詞情報を取得
		$word_info = $this->get_adjective_from_DB($adjective, Koine_Common::DB_ADJECTIVE, false);
		// データがある場合は
		if($word_info){
			// データを挿入
			$this->adjective_type = $word_info["adjective_type"];				// 形容詞種別
			$this->comp_type = $word_info["comp_type"];							// 比較級種別			
			$this->second_stem = $word_info["stem"];							// 語幹		
			$this->japanese_translation = $word_info["japanese_translation"];	// 日本語訳
			$this->english_translation = $word_info["english_translation"];		// 英語訳
		} else {
			// 第一語幹・第三語幹生成
			$this->second_stem = $adjective;							// 第二語幹
			$this->comp_type = Commons::$FALSE;

			// 日本語訳
			$this->japanese_translation = "借用";
			// 英語訳
			$this->english_translation = "loanword";
			
			// 文字列の最後で判断
			if(preg_match('/(α|ᾱ)$/',$adjective)){		
				// 形容詞の種別で性別・活用が決定する。		
				$this->adjective_type = "1-2";           					// 形容詞種別
				$this->second_stem = mb_substr($this->second_stem, 0, -1);	// 第二語幹
			} else if(preg_match('/(ή|η)$/',$adjective)){
				// 形容詞の種別で性別・活用が決定する。		
				$this->adjective_type = "1-2";           					// 形容詞種別
				$this->second_stem = mb_substr($this->second_stem, 0, -1);	// 第二語幹
			} else if(preg_match('/(ήσ|ής|ησ|ης|οσ|ος)$/',$adjective)){		
				// 形容詞の種別で性別・活用が決定する。		
				$this->adjective_type = "1-2";								// 名詞種別
				$this->second_stem = mb_substr($this->second_stem, 0, -2);	// 第二語幹
			} else if(preg_match('/(ο)$/',$adjective)){		
				// 形容詞の種別で性別・活用が決定する。		
				$this->adjective_type = "1-2";								// 名詞種別
				$this->second_stem = mb_substr($this->second_stem, 0, -1);	// 第二語幹
			} else if(preg_match('/(ον)$/',$adjective)){		
				// 形容詞の種別で性別・活用が決定する。		
				$this->adjective_type = "1-2";								// 名詞種別
				$this->second_stem = mb_substr($this->second_stem, 0, -2);	// 第二語幹
			} else if(preg_match('/(υ|υς)$/',$adjective)){		
				// 形容詞の種別で性別・活用が決定する。		
				$this->adjective_type = 4;								// 名詞種別
			} else if(preg_match('/(η|ης)$/',$adjective)){		
				// 形容詞の種別で性別・活用が決定する。								
				$this->adjective_type = "3i";							// 名詞種別
			} else if(preg_match('/(λ|ρ)$/',$adjective)){
				$this->adjective_type = "3con";							// 名詞種別				
			} else if(preg_match('/(τ|ς)$/',$adjective)){
				$this->adjective_type = "3con";							// 名詞種別	
			} else if(preg_match('/(ν)$/',$adjective)){
				$this->adjective_type = "3n";							// 名詞種別										
			} else {														
				// 名詞の種別で性別・活用が決定する。		
				$this->adjective_type = 2;								// 名詞種別
			}
		}
    }

	// 比較級・最上級を作成
	private function get_comp_super_stem(){
		// 比較級・最上級接尾辞を初期化
		$comp_inffix = "";
		$super_inffix = "";

		// 比較級種別
		if($this->comp_type != Commons::$TRUE){
			$comp_inffix = "τερ";
			$super_inffix = "τατ";
		} else {
			$comp_inffix = "ίων";
			$super_inffix = "ιστ";
		}

		// 比較級・最上級語幹を初期化
		$comp_super_stem = "";

		// 3語幹以上は中語幹、それ以外は弱語幹
		if(mb_strlen($this->second_stem) > 7){
			$comp_super_stem = $this->second_stem;
		} else {
			$comp_super_stem = $this->first_stem;
		}

		// 語幹を作成
		$this->comparative_first_stem = $comp_super_stem.$comp_inffix;
		$this->comparative_second_stem = $comp_super_stem.$comp_inffix; 
		$this->comparative_third_stem = $comp_super_stem.$comp_inffix; 
		$this->superlative_first_stem = $comp_super_stem.$super_inffix; 
		$this->superlative_second_stem = $comp_super_stem.$super_inffix; 
		$this->superlative_third_stem = $comp_super_stem.$super_inffix; 
	}
	
	// 形容詞作成
	public function generate_positive($case, $number, $gender){

		// 語幹が存在しない場合は返さない。
		if($this->third_stem == ""){
			return "-";
		}

		// 格語尾を取得
		$case_suffix = "";
		//曲用語尾を取得(単数の複数の有無をチェック)
		if($number == Commons::SINGULAR && $this->deponent_singular != Commons::$TRUE){
			// 単数
			$case_suffix = $this->case_suffix[$gender][$number][$case];
		} else if($number == Commons::DUAL && ($this->deponent_plural != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
			// 双数
			$case_suffix = $this->case_suffix[$gender][$number][$case];			
		} else if($number == Commons::PLURAL && ($this->deponent_plural != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->case_suffix[$gender][$number][$case];
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
		} else if($number == Commons::SINGULAR && $gender == Commons::INANIMATE_GENDER && $case == Commons::ACCUSATIVE){
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

	// 比較級形容詞作成
	protected function generate_comp($case, $number, $gender){
		// 格語尾を取得
		$case_suffix = $this->comparative_case_suffix[$gender][$number][$case];
		// 形容詞と結合		
		$adjective = $this->comparative_second_stem.$case_suffix;
		// 結果を返す
		return $adjective;
	}

	// 最上級形容詞作成
	protected function generate_super($case, $number, $gender){
		// 格語尾を取得
		$case_suffix = $this->superlative_case_suffix[$gender][$number][$case];
		// 形容詞と結合
		$adjective = $this->superlative_second_stem.$case_suffix;	
		// 結果を返す
		return $adjective;
	}

	// 語幹を取得
	public function get_second_stem($grade = "positive"){
		// 形容詞の程度で分岐する。
		if($grade == Commons::ADJ_GRADE_POSITIVE){
			return $this->second_stem;
		} else if($grade == Commons::ADJ_GRADE_COMPERATIVE){
			return $this->comparative_second_stem;
		} else if($grade == Commons::ADJ_GRADE_SUPERATIVE){
			return $this->superlative_second_stem;
		}
	}

    // 曲用表を取得
	private function get_adverb_chart($word_chart){
		// 形容詞級
		$grande_array = array(Commons::ADJ_GRADE_POSITIVE, Commons::ADJ_GRADE_COMPERATIVE, Commons::ADJ_GRADE_SUPERATIVE);
		// 全ての級
		foreach ($grande_array as $grade){

			// 名詞クラスごとに語幹を取得
			$masc_stem = $this->get_second_stem($grade);
			$fem_stem = $masc_stem.$this->case_suffix[Commons::ACTION_GENDER][Commons::SINGULAR][Commons::NOMINATIVE];

			// 副詞(拡張格)
			$word_chart[$grade]["adverb"] = $masc_stem."ως";
			$word_chart[$grade][Commons::ANIMATE_GENDER][Commons::SINGULAR]["allative"] = $masc_stem."δε";
			$word_chart[$grade][Commons::ANIMATE_GENDER][Commons::SINGULAR]["allative2"] = $masc_stem."σε";
			$word_chart[$grade][Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::INSTRUMENTAL] = $masc_stem."δον";
			$word_chart[$grade][Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::ABLATIVE] = $masc_stem."θεν";		
			$word_chart[$grade][Commons::ANIMATE_GENDER][Commons::SINGULAR][Commons::LOCATIVE] = $masc_stem."θι";
			$word_chart[$grade][Commons::ANIMATE_GENDER][Commons::DUAL][Commons::INSTRUMENTAL] = $masc_stem.self::adverb_suffix;
			$word_chart[$grade][Commons::ANIMATE_GENDER][Commons::DUAL][Commons::ABLATIVE] = $masc_stem.self::adverb_suffix;
			$word_chart[$grade][Commons::ANIMATE_GENDER][Commons::DUAL][Commons::LOCATIVE] = $masc_stem.self::adverb_suffix;
			$word_chart[$grade][Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::ABLATIVE] = $masc_stem.self::adverb_suffix;
			$word_chart[$grade][Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::INSTRUMENTAL] = $masc_stem.self::adverb_suffix;
			$word_chart[$grade][Commons::ANIMATE_GENDER][Commons::PLURAL][Commons::LOCATIVE] = $masc_stem.self::adverb_suffix;

			$word_chart[$grade][Commons::ACTION_GENDER][Commons::SINGULAR]["allative"] = $fem_stem."δε";
			$word_chart[$grade][Commons::ACTION_GENDER][Commons::SINGULAR]["allative2"] = $fem_stem."σε";
			$word_chart[$grade][Commons::ACTION_GENDER][Commons::SINGULAR][Commons::INSTRUMENTAL] = $fem_stem."δον";
			$word_chart[$grade][Commons::ACTION_GENDER][Commons::SINGULAR][Commons::ABLATIVE] = $fem_stem."θεν";		
			$word_chart[$grade][Commons::ACTION_GENDER][Commons::SINGULAR][Commons::LOCATIVE] = $fem_stem."θι";
			$word_chart[$grade][Commons::ACTION_GENDER][Commons::DUAL][Commons::INSTRUMENTAL] = $fem_stem.self::adverb_suffix;
			$word_chart[$grade][Commons::ACTION_GENDER][Commons::DUAL][Commons::ABLATIVE] = $fem_stem.self::adverb_suffix;
			$word_chart[$grade][Commons::ACTION_GENDER][Commons::DUAL][Commons::LOCATIVE] = $fem_stem.self::adverb_suffix;
			$word_chart[$grade][Commons::ACTION_GENDER][Commons::PLURAL][Commons::ABLATIVE] = $fem_stem.self::adverb_suffix;
			$word_chart[$grade][Commons::ACTION_GENDER][Commons::PLURAL][Commons::INSTRUMENTAL] = $fem_stem.self::adverb_suffix;
			$word_chart[$grade][Commons::ACTION_GENDER][Commons::PLURAL][Commons::LOCATIVE] = $fem_stem.self::adverb_suffix;
	
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::SINGULAR]["allative"] = $masc_stem."δε";
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::SINGULAR]["allative2"] = $masc_stem."σε";
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::INSTRUMENTAL] = $masc_stem."δον";
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::ABLATIVE] = $masc_stem."θεν";		
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::SINGULAR][Commons::LOCATIVE] = $masc_stem."θι";
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::DUAL][Commons::INSTRUMENTAL] = $masc_stem.self::adverb_suffix;
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::DUAL][Commons::ABLATIVE] = $masc_stem.self::adverb_suffix;
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::DUAL][Commons::LOCATIVE] = $masc_stem.self::adverb_suffix;
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::ABLATIVE] = $masc_stem.self::adverb_suffix;
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::INSTRUMENTAL] = $masc_stem.self::adverb_suffix;
			$word_chart[$grade][Commons::INANIMATE_GENDER][Commons::PLURAL][Commons::LOCATIVE] = $masc_stem.self::adverb_suffix;

		}	
		// 結果を返す。
		return $word_chart;
	}	
	
	// 曲用表を取得
	public function get_chart(){
		
		// 初期化
		$word_chart = array();
		
		// タイトル情報を挿入
		$word_chart['title'] = $this->get_adjective_title();
		// 辞書見出しを入れる。
		$word_chart['dic_title'] = $this->get_second_stem();
		// 種別を入れる。
		$word_chart['category'] = "形容詞";
		// 活用種別を入れる。
		$word_chart['type'] = $this->adjective_type_name;
		// 曲用を取得
		$word_chart = $this->make_adjective_declension($word_chart);
		// 副詞を取得
		$word_chart = $this->get_adverb_chart($word_chart);
		// 結果を返す。
		return $word_chart;
	}

	// 特定の格変化を取得する(ない場合はランダム)。
	public function get_form_by_number_case_gender_grade($case = "", $number = "", $gender = "", $grade = ""){

		// 格がない場合
		if($case == ""){
			// 全ての格の中からランダムで選択
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

		// 性別がない場合
		if($gender == ""){
			// 全ての性別の中からランダムで選択
			$ary = array(Commons::ANIMATE_GENDER, Commons::ACTION_GENDER, Commons::INANIMATE_GENDER);			// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$gender = $ary[$key];			
		}	

		// 形容詞の級に指定がない場合は
		if($grade == ""){
			// 全ての級を対象にする。
			$ary = array(Commons::ADJ_GRADE_POSITIVE, Commons::ADJ_GRADE_COMPERATIVE, Commons::ADJ_GRADE_SUPERATIVE);	// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$grade = $ary[$key];			
		}

		// 配列に格納
		$question_data = array();
		$question_data['question_sentence'] = $this->get_adjective_title()."の".$grade." ".$gender." ".$number." ".$case."を答えよ";				
		$question_data['answer'] = $this->get_declensioned_adjective($case, $number, $gender, $grade);
		$question_data['question_sentence2'] = $question_data['answer']."の性、格と数を答えよ";	
		$question_data['case'] = $case;
		$question_data['number'] = $number;	
		$question_data['gender'] = $gender;
		$question_data['grade'] = $grade;			

		// 結果を返す。
		return $question_data;
	}	
	
}

?>