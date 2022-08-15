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
		$masculine_declensioninfo = $this->get_adjective_case_suffix($this->adjective_type, "Masculine");
		$feminine_declensioninfo = $this->get_adjective_case_suffix($this->adjective_type, "Feminine");
		$neuter_declensioninfo = $this->get_adjective_case_suffix($this->adjective_type, "Neuter");

		// 活用表を挿入(男性)
		$this->case_suffix["masc"]["sg"]["nom"] = $masculine_declensioninfo["sg_nom"];
		$this->case_suffix["masc"]["sg"]["gen"] = $masculine_declensioninfo["sg_gen"];
		$this->case_suffix["masc"]["sg"]["dat"] = $masculine_declensioninfo["sg_dat"];
		$this->case_suffix["masc"]["sg"]["acc"] = $masculine_declensioninfo["sg_acc"];
		$this->case_suffix["masc"]["sg"]["abl"] = $masculine_declensioninfo["sg_abl"];
		$this->case_suffix["masc"]["sg"]["ins"] = $masculine_declensioninfo["sg_ins"];
		$this->case_suffix["masc"]["sg"]["loc"] = $masculine_declensioninfo["sg_loc"];
		$this->case_suffix["masc"]["sg"]["voc"] = $masculine_declensioninfo["sg_voc"];
		$this->case_suffix["masc"]["du"]["nom"] = $masculine_declensioninfo["du_nom"];
		$this->case_suffix["masc"]["du"]["gen"] = $masculine_declensioninfo["du_gen"];
		$this->case_suffix["masc"]["du"]["dat"] = $masculine_declensioninfo["du_dat"];
		$this->case_suffix["masc"]["du"]["acc"] = $masculine_declensioninfo["du_acc"];
		$this->case_suffix["masc"]["du"]["abl"] = $masculine_declensioninfo["du_abl"];
		$this->case_suffix["masc"]["du"]["ins"] = $masculine_declensioninfo["du_ins"];
		$this->case_suffix["masc"]["du"]["loc"] = $masculine_declensioninfo["du_loc"];
		$this->case_suffix["masc"]["du"]["voc"] = $masculine_declensioninfo["du_voc"];
		$this->case_suffix["masc"]["pl"]["nom"] = $masculine_declensioninfo["pl_nom"];
		$this->case_suffix["masc"]["pl"]["gen"] = $masculine_declensioninfo["pl_gen"];
		$this->case_suffix["masc"]["pl"]["dat"] = $masculine_declensioninfo["pl_dat"];
		$this->case_suffix["masc"]["pl"]["acc"] = $masculine_declensioninfo["pl_acc"];
		$this->case_suffix["masc"]["pl"]["abl"] = $masculine_declensioninfo["pl_abl"];
		$this->case_suffix["masc"]["pl"]["ins"] = $masculine_declensioninfo["pl_ins"];
		$this->case_suffix["masc"]["pl"]["loc"] = $masculine_declensioninfo["pl_loc"];
		$this->case_suffix["masc"]["pl"]["voc"] = $masculine_declensioninfo["pl_voc"];

		// 活用表を挿入(女性)
		$this->case_suffix["fem"]["sg"]["nom"] = $feminine_declensioninfo["sg_nom"];
		$this->case_suffix["fem"]["sg"]["gen"] = $feminine_declensioninfo["sg_gen"];
		$this->case_suffix["fem"]["sg"]["dat"] = $feminine_declensioninfo["sg_dat"];
		$this->case_suffix["fem"]["sg"]["acc"] = $feminine_declensioninfo["sg_acc"];
		$this->case_suffix["fem"]["sg"]["abl"] = $feminine_declensioninfo["sg_abl"];
		$this->case_suffix["fem"]["sg"]["ins"] = $feminine_declensioninfo["sg_ins"];
		$this->case_suffix["fem"]["sg"]["loc"] = $feminine_declensioninfo["sg_loc"];
		$this->case_suffix["fem"]["sg"]["voc"] = $feminine_declensioninfo["sg_voc"];
		$this->case_suffix["fem"]["du"]["nom"] = $feminine_declensioninfo["du_nom"];
		$this->case_suffix["fem"]["du"]["gen"] = $feminine_declensioninfo["du_gen"];
		$this->case_suffix["fem"]["du"]["dat"] = $feminine_declensioninfo["du_dat"];
		$this->case_suffix["fem"]["du"]["acc"] = $feminine_declensioninfo["du_acc"];
		$this->case_suffix["fem"]["du"]["abl"] = $feminine_declensioninfo["du_abl"];
		$this->case_suffix["fem"]["du"]["ins"] = $feminine_declensioninfo["du_ins"];
		$this->case_suffix["fem"]["du"]["loc"] = $feminine_declensioninfo["du_loc"];
		$this->case_suffix["fem"]["du"]["voc"] = $feminine_declensioninfo["du_voc"];
		$this->case_suffix["fem"]["pl"]["nom"] = $feminine_declensioninfo["pl_nom"];
		$this->case_suffix["fem"]["pl"]["gen"] = $feminine_declensioninfo["pl_gen"];
		$this->case_suffix["fem"]["pl"]["dat"] = $feminine_declensioninfo["pl_dat"];
		$this->case_suffix["fem"]["pl"]["acc"] = $feminine_declensioninfo["pl_acc"];
		$this->case_suffix["fem"]["pl"]["abl"] = $feminine_declensioninfo["pl_abl"];
		$this->case_suffix["fem"]["pl"]["ins"] = $feminine_declensioninfo["pl_ins"];
		$this->case_suffix["fem"]["pl"]["loc"] = $feminine_declensioninfo["pl_loc"];
		$this->case_suffix["fem"]["pl"]["voc"] = $feminine_declensioninfo["pl_voc"];
		
		// 活用表を挿入(中性)
		$this->case_suffix["neu"]["sg"]["nom"] = $neuter_declensioninfo["sg_nom"];
		$this->case_suffix["neu"]["sg"]["gen"] = $neuter_declensioninfo["sg_gen"];
		$this->case_suffix["neu"]["sg"]["dat"] = $neuter_declensioninfo["sg_dat"];
		$this->case_suffix["neu"]["sg"]["acc"] = $neuter_declensioninfo["sg_acc"];
		$this->case_suffix["neu"]["sg"]["abl"] = $neuter_declensioninfo["sg_abl"];
		$this->case_suffix["neu"]["sg"]["ins"] = $neuter_declensioninfo["sg_ins"];
		$this->case_suffix["neu"]["sg"]["loc"] = $neuter_declensioninfo["sg_loc"];
		$this->case_suffix["neu"]["sg"]["voc"] = $neuter_declensioninfo["sg_voc"];
		$this->case_suffix["neu"]["du"]["nom"] = $neuter_declensioninfo["du_nom"];
		$this->case_suffix["neu"]["du"]["gen"] = $neuter_declensioninfo["du_gen"];
		$this->case_suffix["neu"]["du"]["dat"] = $neuter_declensioninfo["du_dat"];
		$this->case_suffix["neu"]["du"]["acc"] = $neuter_declensioninfo["du_acc"];
		$this->case_suffix["neu"]["du"]["abl"] = $neuter_declensioninfo["du_abl"];
		$this->case_suffix["neu"]["du"]["ins"] = $neuter_declensioninfo["du_ins"];
		$this->case_suffix["neu"]["du"]["loc"] = $neuter_declensioninfo["du_loc"];
		$this->case_suffix["neu"]["du"]["voc"] = $neuter_declensioninfo["du_voc"];
		$this->case_suffix["neu"]["pl"]["nom"] = $neuter_declensioninfo["pl_nom"];
		$this->case_suffix["neu"]["pl"]["gen"] = $neuter_declensioninfo["pl_gen"];
		$this->case_suffix["neu"]["pl"]["dat"] = $neuter_declensioninfo["pl_dat"];
		$this->case_suffix["neu"]["pl"]["acc"] = $neuter_declensioninfo["pl_acc"];
		$this->case_suffix["neu"]["pl"]["abl"] = $neuter_declensioninfo["pl_abl"];
		$this->case_suffix["neu"]["pl"]["ins"] = $neuter_declensioninfo["pl_ins"];
		$this->case_suffix["neu"]["pl"]["loc"] = $neuter_declensioninfo["pl_loc"];
		$this->case_suffix["neu"]["pl"]["voc"] = $neuter_declensioninfo["pl_voc"];
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
		if($grade == "positive"){
			$adjective = $this->generate_positive($case, $number, $gender);
		} else if($grade == "comp"){
			$adjective = $this->generate_comp($case, $number, $gender);
		} else if($grade == "super"){
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
		if($case == Commons::$NOMINATIVE && $number == Commons::$SINGULAR){
			// 弱語幹の場合
			$adjective = $this->first_stem;
		} else if($case == Commons::$ACCUSATIVE && $number == Commons::$SINGULAR && $gender == Commons::$NEUTER_GENDER){
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
		if($case == Commons::$NOMINATIVE && $number == Commons::$SINGULAR){
			// 弱語幹の場合
			$adjective = $this->comparative_first_stem;
		} else if($case == Commons::$ACCUSATIVE && $number == Commons::$SINGULAR && $gender == Commons::$NEUTER_GENDER){
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
		if($case == Commons::$NOMINATIVE && $number == Commons::$SINGULAR){
			// 弱語幹の場合
			$adjective = $this->superlative_first_stem;
		} else if($case == Commons::$ACCUSATIVE && $number == Commons::$SINGULAR && $gender == Commons::$NEUTER_GENDER){
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
		$case_array = array(Commons::$NOMINATIVE, Commons::$GENETIVE, Commons::$DATIVE, Commons::$ACCUSATIVE, Commons::$ABLATIVE, Commons::$INSTRUMENTAL, Commons::$LOCATIVE, Commons::$VOCATIVE);
		// 数配列
		$number_array = array(Commons::$SINGULAR, Commons::$DUAL, Commons::$PLURAL);
		// 名詞クラス配列
		$gender_array = array(Commons::$MASCULINE_GENDER, Commons::$FEMINE_GENDER, Commons::$NEUTER_GENDER);
		// 形容詞級
		$grande_array = array(Commons::$ADJ_GRADE_POSITIVE, Commons::$ADJ_GRADE_COMPERATIVE, Commons::$ADJ_GRADE_SUPERATIVE);

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
		$this->get_adj_declension(Commons::$ADJ_GRADE_POSITIVE);		// 原級
		$this->get_adj_declension(Commons::$ADJ_GRADE_COMPERATIVE);		// 比較級
		$this->get_adj_declension(Commons::$ADJ_GRADE_SUPERATIVE);		// 最上級
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
		$this->get_adj_declension(Commons::$ADJ_GRADE_POSITIVE);		// 原級
		$this->get_adj_declension(Commons::$ADJ_GRADE_COMPERATIVE);			// 比較級
		$this->get_adj_declension(Commons::$ADJ_GRADE_SUPERATIVE);			// 最上級

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
		$word_info = $this->get_adjective_from_DB($adjective, Latin_Common::$DB_ADJECTIVE);
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
		if($grade == Commons::$ADJ_GRADE_POSITIVE){
			$adjective_type = $this->adjective_type;
		} else if($grade == Commons::$ADJ_GRADE_COMPERATIVE){
			$adjective_type = "3pri";
		} else if($grade == Commons::$ADJ_GRADE_SUPERATIVE){
			$adjective_type = "1-2";
		}

		// 曲用を取得
		$masculine_declension = $this->get_adjective_case_suffix($adjective_type, "Masculine");
		$feminine_declension = $this->get_adjective_case_suffix($adjective_type, "Feminine");
		$neuter_declension = $this->get_adjective_case_suffix($adjective_type, "Neuter");

		// 初期化
		$case_suffixes = array();		
		
		// 活用表を挿入(男性)
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$NOMINATIVE] = $masculine_declension["sg_nom"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$GENETIVE] = $masculine_declension["sg_gen"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$DATIVE] = $masculine_declension["sg_dat"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$ACCUSATIVE] = $masculine_declension["sg_acc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$ABLATIVE] = $masculine_declension["sg_abl"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$LOCATIVE] = $masculine_declension["sg_loc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$VOCATIVE] = $masculine_declension["sg_voc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$NOMINATIVE] = $masculine_declension["pl_nom"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$GENETIVE] = $masculine_declension["pl_gen"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$DATIVE] = $masculine_declension["pl_dat"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$ACCUSATIVE] = $masculine_declension["pl_acc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$ABLATIVE] = $masculine_declension["pl_abl"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$LOCATIVE] = $masculine_declension["pl_loc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$VOCATIVE] = $masculine_declension["pl_voc"];

		// 活用表を挿入(女性)
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$NOMINATIVE] = $feminine_declension["sg_nom"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$GENETIVE] = $feminine_declension["sg_gen"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$DATIVE] = $feminine_declension["sg_dat"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$ACCUSATIVE] = $feminine_declension["sg_acc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$ABLATIVE] = $feminine_declension["sg_abl"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$LOCATIVE] = $feminine_declension["sg_loc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$VOCATIVE] = $feminine_declension["sg_voc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$NOMINATIVE] = $feminine_declension["pl_nom"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$GENETIVE] = $feminine_declension["pl_gen"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$DATIVE] = $feminine_declension["pl_dat"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$ACCUSATIVE] = $feminine_declension["pl_acc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$ABLATIVE] = $feminine_declension["pl_abl"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$LOCATIVE] = $feminine_declension["pl_loc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$VOCATIVE] = $feminine_declension["pl_voc"];
		
		// 活用表を挿入(中性)
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$NOMINATIVE] = $neuter_declension["sg_nom"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$GENETIVE] = $neuter_declension["sg_gen"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$DATIVE] = $neuter_declension["sg_dat"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$ACCUSATIVE] = $neuter_declension["sg_acc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$ABLATIVE] = $neuter_declension["sg_abl"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$LOCATIVE] = $neuter_declension["sg_loc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$VOCATIVE] = $neuter_declension["sg_voc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$NOMINATIVE] = $neuter_declension["pl_nom"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$GENETIVE] = $neuter_declension["pl_gen"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$DATIVE] = $neuter_declension["pl_dat"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$ACCUSATIVE] = $neuter_declension["pl_acc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$ABLATIVE] = $neuter_declension["pl_abl"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$LOCATIVE] = $neuter_declension["pl_loc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$VOCATIVE] = $neuter_declension["pl_voc"];
		
		// 活用を挿入
		if($grade == Commons::$ADJ_GRADE_POSITIVE){
			// 活用種別名
			$this->adjective_type_name = $masculine_declension["adjective_type_name"];				
			$this->case_suffix = $case_suffixes;
		} else if($grade == Commons::$ADJ_GRADE_COMPERATIVE){
			$this->comparative_case_suffix = $case_suffixes;
		} else if($grade == Commons::$ADJ_GRADE_SUPERATIVE){
			$this->superlative_case_suffix = $case_suffixes;
		}		
	}
	
	// 形容詞作成(原級)
	protected function generate_positive($case, $number, $gender){
		// 格語尾を取得
		$case_suffix = "";
		// 曲用語尾を取得
		if($number == Commons::$SINGULAR && $this->deponent_singular != Commons::$TRUE){
			// 単数
			$case_suffix = $this->case_suffix[$gender][$number][$case];
		} else if($number == Commons::$PLURAL && ($this->deponent_plural != Commons::$TRUE && $this->location_name != Commons::$TRUE)){
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
			if($this->gender == Commons::$MASCULINE_GENDER && Commons::$SINGULAR && ($case == Commons::$NOMINATIVE || $case == Commons::$VOCATIVE)){
				// ここで結果を返す。
				return $this->first_stem;					
			} else if($case == Commons::$ACCUSATIVE && $this->gender == Commons::$NEUTER_GENDER && $number == Commons::$SINGULAR){
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
		if($number == Commons::$SINGULAR && $this->deponent_singular != Commons::$TRUE){
			// 単数
			$case_suffix = $this->comparative_case_suffix[$gender][$number][$case];
		} else if($number == Commons::$PLURAL && ($this->deponent_plural != Commons::$TRUE & $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->comparative_case_suffix[$gender][$number][$case];
		} else {
			// ハイフンを返す。
			return "-";
		}

		// それ以外は単数の主格と呼格は弱語幹
		if(($case == Commons::$NOMINATIVE && $number == Commons::$SINGULAR) || ($case == Commons::$VOCATIVE && $number == Commons::$SINGULAR)){
			// ここで結果を返す。
			return $this->comparative_first_stem;					
		} else if($case == Commons::$ACCUSATIVE && $this->gender == Commons::$NEUTER_GENDER && $number == Commons::$SINGULAR){
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
		if($number == Commons::$SINGULAR && $this->deponent_singular != Commons::$TRUE){
			// 単数
			$case_suffix = $this->superlative_case_suffix[$gender][$number][$case];
		} else if($number == Commons::$PLURAL && ($this->deponent_plural != Commons::$TRUE & $this->location_name != Commons::$TRUE)){
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
		if($grade == Commons::$ADJ_GRADE_POSITIVE){
			// 原級
			// 活用種別で分岐
			if(preg_match("/(1-2|1-2r|1-2gr1)$/", $this->adjective_type)){
				// 第一・第二活用の場合
				$adverb = $this->third_stem.$this->adverb_suffix_12;
			} else {
				// それ以外の場合
				$adverb = $this->third_stem.$this->adverb_suffix_3;
			}			
		} else if($grade == Commons::$ADJ_GRADE_COMPERATIVE){
			// 比較級
			$adverb = $this->comparative_third_stem.$this->adverb_suffix_3;
		} else if($grade == Commons::$ADJ_GRADE_SUPERATIVE){
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
		$word_chart[commons::$ADJ_GRADE_POSITIVE]["adverb"] = $this->get_adverb(commons::$ADJ_GRADE_POSITIVE);
		$word_chart[commons::$ADJ_GRADE_COMPERATIVE]["adverb"] = $this->get_adverb(commons::$ADJ_GRADE_COMPERATIVE);
		$word_chart[Commons::$ADJ_GRADE_SUPERATIVE]["adverb"] = $this->get_adverb(Commons::$ADJ_GRADE_SUPERATIVE);

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
			$ary = array(Commons::$NOMINATIVE, Commons::$GENETIVE, Commons::$DATIVE, Commons::$ACCUSATIVE, Commons::$ABLATIVE, Commons::$LOCATIVE, Commons::$VOCATIVE);	// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$case = $ary[$key];			
		}

		// 数がない場合
		if($number == ""){
			// 単数・複数の中からランダムで選択
			$ary = array(Commons::$SINGULAR, Commons::$PLURAL);			// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$number = $ary[$key];			
		}

		// 性別がない場合
		if($gender == ""){
			// 全ての性別の中からランダムで選択
			$ary = array(Commons::$MASCULINE_GENDER, Commons::$FEMINE_GENDER, Commons::$NEUTER_GENDER);			// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$gender = $ary[$key];			
		}	

		// 形容詞の級に指定がない場合は
		if($grade == ""){
			// 全ての級を対象にする。
			$ary = array(Commons::$ADJ_GRADE_POSITIVE, Commons::$ADJ_GRADE_COMPERATIVE, Commons::$ADJ_GRADE_SUPERATIVE);	// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$grade = $ary[$key];			
		}

		// 配列に格納
		$question_data = array();
		$question_data['question_sentence'] = $this->get_adjective_title()."の".$gender." ".$number." ".$case."を答えよ";				
		$question_data['answer'] = $this->get_declensioned_adjective($case, $number, $gender, $grade);
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
			"sg_gen" => "yās",
			"sg_dat" => "yai",
			"sg_acc" => "m",
			"sg_abl" => "yās",
			"sg_ins" => "ā",
			"sg_loc" => "yām",
			"sg_voc" => "e",
			"du_nom" => "e",
			"du_gen" => "ayos",
			"du_dat" => "bhiām",
			"du_acc" => "e",
			"du_abl" => "bhiām",
			"du_ins" => "bhiām",
			"du_loc" => "ayos",
			"du_voc" => "e",
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
			"adjective_type" => "1-2",
			"adjective_type_name" => "a-変化形容詞",			
			"gender" => "Masculine",
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
			"pl_dat" => "ibhyas",
			"pl_acc" => "ān",
			"pl_abl" => "ibhyas",
			"pl_ins" => "ibhis",			
			"pl_loc" => "isu",
			"pl_voc" => "āsas"
		],
		[
			"adjective_type" => "1-2",
			"adjective_type_name" => "a-変化形容詞",			
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
			"pl_nom" => "āsas",
			"pl_gen" => "anām",
			"pl_dat" => "ibhyas",
			"pl_acc" => "ān",
			"pl_abl" => "ibhyas",
			"pl_ins" => "ibhis",			
			"pl_loc" => "isu",
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
	    $this->get_adj_declension(Commons::$ADJ_GRADE_POSITIVE);
	    $this->get_adj_declension(Commons::$ADJ_GRADE_COMPERATIVE);
	    $this->get_adj_declension(Commons::$ADJ_GRADE_SUPERATIVE);
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
		$this->get_adj_declension(Commons::$ADJ_GRADE_POSITIVE);
		$this->get_adj_declension(Commons::$ADJ_GRADE_COMPERATIVE);
		$this->get_adj_declension(Commons::$ADJ_GRADE_SUPERATIVE);
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_sanskrit2($adjective, $flag) {
    	// 親クラス初期化
		parent::__construct();
		// 第二語幹生成
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
		$this->get_adj_declension(Commons::$ADJ_GRADE_POSITIVE);		// 原級
		$this->get_adj_declension(Commons::$ADJ_GRADE_COMPERATIVE);		// 比較級
		$this->get_adj_declension(Commons::$ADJ_GRADE_SUPERATIVE);		// 最上級
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
		$this->get_adj_declension(Commons::$ADJ_GRADE_POSITIVE);		// 原級
		$this->get_adj_declension(Commons::$ADJ_GRADE_COMPERATIVE);		// 比較級
		$this->get_adj_declension(Commons::$ADJ_GRADE_SUPERATIVE);		// 最上級
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
		if($grade == Commons::$ADJ_GRADE_POSITIVE){
			$adjective_type = $this->adjective_type;
		} else if($grade == Commons::$ADJ_GRADE_COMPERATIVE){
			$adjective_type = "1-2";
		} else if($grade == Commons::$ADJ_GRADE_SUPERATIVE){
			$adjective_type = "1-2";
		}
		// 曲用を取得
		$masculine_declension = $this->get_adjective_case_suffix($adjective_type, "Masculine");
		$feminine_declension = $this->get_adjective_case_suffix($adjective_type, "Feminine");
		$neuter_declension = $this->get_adjective_case_suffix($adjective_type, "Neuter");

		// 活用表を挿入(男性)
		// 単数
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$NOMINATIVE] = $masculine_declension["sg_nom"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$GENETIVE] = $masculine_declension["sg_gen"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$DATIVE] = $masculine_declension["sg_dat"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$ACCUSATIVE] = $masculine_declension["sg_acc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$ABLATIVE] = $masculine_declension["sg_abl"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$INSTRUMENTAL] = $masculine_declension["sg_ins"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$LOCATIVE] = $masculine_declension["sg_loc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$VOCATIVE] = $masculine_declension["sg_voc"];
		
		// 双数
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$DUAL][Commons::$NOMINATIVE] = $masculine_declension["du_nom"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$DUAL][Commons::$GENETIVE] = $masculine_declension["du_gen"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$DUAL][Commons::$DATIVE] = $masculine_declension["du_dat"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$DUAL][Commons::$ACCUSATIVE] = $masculine_declension["du_acc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$DUAL][Commons::$ABLATIVE] = $masculine_declension["du_abl"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$DUAL][Commons::$INSTRUMENTAL] = $masculine_declension["du_ins"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$DUAL][Commons::$LOCATIVE] = $masculine_declension["du_loc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$DUAL][Commons::$VOCATIVE] = $masculine_declension["du_voc"];
		
		// 複数
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$NOMINATIVE] = $masculine_declension["pl_nom"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$GENETIVE] = $masculine_declension["pl_gen"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$DATIVE] = $masculine_declension["pl_dat"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$ACCUSATIVE] = $masculine_declension["pl_acc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$ABLATIVE] = $masculine_declension["pl_abl"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$INSTRUMENTAL] = $masculine_declension["pl_ins"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$LOCATIVE] = $masculine_declension["pl_loc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$VOCATIVE] = $masculine_declension["pl_voc"];

		// 活用表を挿入(女性)		
		// 単数
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$NOMINATIVE] = $feminine_declension["sg_nom"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$GENETIVE] = $feminine_declension["sg_gen"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$DATIVE] = $feminine_declension["sg_dat"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$ACCUSATIVE] = $feminine_declension["sg_acc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$ABLATIVE] = $feminine_declension["sg_abl"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$INSTRUMENTAL] = $feminine_declension["sg_ins"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$LOCATIVE] = $feminine_declension["sg_loc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$VOCATIVE] = $feminine_declension["sg_voc"];
		
		// 双数
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$DUAL][Commons::$NOMINATIVE] = $feminine_declension["du_nom"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$DUAL][Commons::$GENETIVE] = $feminine_declension["du_gen"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$DUAL][Commons::$DATIVE] = $feminine_declension["du_dat"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$DUAL][Commons::$ACCUSATIVE] = $feminine_declension["du_acc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$DUAL][Commons::$ABLATIVE] = $feminine_declension["du_abl"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$DUAL][Commons::$INSTRUMENTAL] = $feminine_declension["du_ins"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$DUAL][Commons::$LOCATIVE] = $feminine_declension["du_loc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$DUAL][Commons::$VOCATIVE] = $feminine_declension["du_voc"];
		
		// 複数
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$NOMINATIVE] = $feminine_declension["pl_nom"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$GENETIVE] = $feminine_declension["pl_gen"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$DATIVE] = $feminine_declension["pl_dat"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$ACCUSATIVE] = $feminine_declension["pl_acc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$ABLATIVE] = $feminine_declension["pl_abl"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$INSTRUMENTAL] = $feminine_declension["pl_ins"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$LOCATIVE] = $feminine_declension["pl_loc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$VOCATIVE] = $feminine_declension["pl_voc"];

		// 活用表を挿入(女性)		
		// 単数
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$NOMINATIVE] = $neuter_declension["sg_nom"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$GENETIVE] = $neuter_declension["sg_gen"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$DATIVE] = $neuter_declension["sg_dat"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$ACCUSATIVE] = $neuter_declension["sg_acc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$ABLATIVE] = $neuter_declension["sg_abl"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$INSTRUMENTAL] = $neuter_declension["sg_ins"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$LOCATIVE] = $neuter_declension["sg_loc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$VOCATIVE] = $neuter_declension["sg_voc"];
		
		// 双数
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$DUAL][Commons::$NOMINATIVE] = $neuter_declension["du_nom"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$DUAL][Commons::$GENETIVE] = $neuter_declension["du_gen"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$DUAL][Commons::$DATIVE] = $neuter_declension["du_dat"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$DUAL][Commons::$ACCUSATIVE] = $neuter_declension["du_acc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$DUAL][Commons::$ABLATIVE] = $neuter_declension["du_abl"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$DUAL][Commons::$INSTRUMENTAL] = $neuter_declension["du_ins"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$DUAL][Commons::$LOCATIVE] = $neuter_declension["du_loc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$DUAL][Commons::$VOCATIVE] = $neuter_declension["du_voc"];
		
		// 複数
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$NOMINATIVE] = $neuter_declension["pl_nom"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$GENETIVE] = $neuter_declension["pl_gen"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$DATIVE] = $neuter_declension["pl_dat"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$ACCUSATIVE] = $neuter_declension["pl_acc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$ABLATIVE] = $neuter_declension["pl_abl"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$INSTRUMENTAL] = $neuter_declension["pl_ins"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$LOCATIVE] = $neuter_declension["pl_loc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$VOCATIVE] = $neuter_declension["pl_voc"];

		// 活用を挿入
		if($grade == Commons::$ADJ_GRADE_POSITIVE){
			// 活用種別名
			$this->adjective_type_name = $masculine_declension["adjective_type_name"];				
			$this->case_suffix = $case_suffixes;
		} else if($grade == Commons::$ADJ_GRADE_COMPERATIVE){
			$this->comparative_case_suffix = $case_suffixes;
		} else if($grade == Commons::$ADJ_GRADE_SUPERATIVE){
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
			$this->first_stem = Sanskrit_Common::change_vowel_grade($this->second_stem, Sanskrit_Common::$ZERO_GRADE);		// 弱語幹
			$this->third_stem = Sanskrit_Common::change_vowel_grade($this->second_stem, Sanskrit_Common::$VRIDDHI);			// 強語幹
		} else if($this->adjective_type == "3n"){
			// n活用の場合			
			if(preg_match('/(an)$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -2)."n";		// 弱語幹
				$this->third_stem = mb_substr($this->second_stem, 0, -2)."ān";		// 強語幹
			} else if(preg_match('/(in)$/',$this->second_stem)){
				$this->first_stem = mb_substr($this->second_stem, 0, -2)."in";		// 弱語幹
				$this->third_stem = mb_substr($this->second_stem, 0, -2)."īn";		// 強語幹
			} else {
				$this->first_stem = mb_substr($this->second_stem, 0, -2).Sanskrit_Common::change_vowel_grade(mb_substr($this->second_stem, -2), Sanskrit_Common::$ZERO_GRADE);
				$this->third_stem = mb_substr($this->second_stem, 0, -2).Sanskrit_Common::change_vowel_grade(mb_substr($this->second_stem, -2), Sanskrit_Common::$VRIDDHI);
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
		$word_info = $this->get_adjective_from_DB($adjective, Sanskrit_Common::$DB_ADJECTIVE, false);
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
		} else {
			$comp_super_stem = $this->first_stem;
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
		if($gender == Commons::$MASCULINE_GENDER || $gender == Commons::$FEMINE_GENDER){
			if($case == Commons::$NOMINATIVE || $case == Commons::$VOCATIVE){
				$stem = $this->third_stem;
			} else if($case == Commons::$ACCUSATIVE && ($number == Commons::$SINGULAR || $number == Commons::$DUAL)){
				$stem = $this->third_stem;
			} else if($case == Commons::$INSTRUMENTAL && ($number == Commons::$DUAL || $number == Commons::$PLURAL)){
				$stem = $this->second_stem;
			} else if($case == Commons::$DATIVE && ($number == Commons::$DUAL || $number == Commons::$PLURAL)){
				$stem = $this->second_stem;
			} else if($case == Commons::$ABLATIVE && ($number == Commons::$DUAL || $number == Commons::$PLURAL)){
				$stem = $this->second_stem;	
			} else if($case == Commons::$LOCATIVE && $number == Commons::$PLURAL){
				$stem = $this->second_stem;							
			} else {
				$stem = $this->first_stem;
			}
		} else if($gender == Commons::$NEUTER_GENDER){
			if($case == Commons::$NOMINATIVE || $case == Commons::$VOCATIVE || $case == Commons::$ACCUSATIVE){
				switch($number){
					case Commons::$SINGULAR:
						$stem = $this->second_stem;							
						break;
					case Commons::$DUAL:
						$stem = $this->first_stem;							
						break;
					case Commons::$PLURAL:
						$stem = $this->third_stem;							
						break;
					default:
						$stem = $this->third_stem;
						break;			
				}

			} else if($case == Commons::$INSTRUMENTAL && ($number == Commons::$DUAL || $number == Commons::$PLURAL)){
				$stem = $this->second_stem;
			} else if($case == Commons::$DATIVE && ($number == Commons::$DUAL || $number == Commons::$PLURAL)){
				$stem = $this->second_stem;
			} else if($case == Commons::$ABLATIVE && ($number == Commons::$DUAL || $number == Commons::$PLURAL)){
				$stem = $this->second_stem;	
			} else if($case == Commons::$LOCATIVE && $number == Commons::$PLURAL){
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
			//$stem = mb_substr($stem, 0, -1);
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
		if($grade == "positive"){
			return $this->second_stem;
		} else if($grade == "comp"){
			return $this->comparative_second_stem;
		} else if($grade == "super"){
			return $this->superlative_second_stem;
		}
	}

    // 曲用表を取得
	private function get_adverb_chart($word_chart){
		// 形容詞級
		$grande_array = array(Commons::$ADJ_GRADE_POSITIVE, Commons::$ADJ_GRADE_COMPERATIVE, Commons::$ADJ_GRADE_SUPERATIVE);
		// 全ての級
		foreach ($grande_array as $grade){

			// 名詞クラスごとに語幹を取得
			$masc_stem = $this->get_second_stem($grade);
			$fem_stem = Sanskrit_Common::sandhi_engine($masc_stem, $this->case_suffix[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$NOMINATIVE]);

			// 副詞(拡張格)
			$word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["elative"] = Sanskrit_Common::sandhi_engine($masc_stem, "tas");
			$word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["inessive1"] = Sanskrit_Common::sandhi_engine($masc_stem, "trā");
			$word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["inessive2"] = Sanskrit_Common::sandhi_engine($masc_stem, "dha");		
			$word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["comitative"] = Sanskrit_Common::sandhi_engine($masc_stem, "thā");		
			$word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["multiplicative"] = Sanskrit_Common::sandhi_engine($masc_stem, "dhā");	
			$word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["essive"] = Sanskrit_Common::sandhi_engine($masc_stem, "vat");	
			$word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["translative"] = Sanskrit_Common::sandhi_engine($masc_stem, "sāt");		
			$word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["temporal"] = Sanskrit_Common::sandhi_engine($masc_stem, "dā");	
			$word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["illative"] = Sanskrit_Common::sandhi_engine($masc_stem, "ac");	
			$word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["distributive"] = Sanskrit_Common::sandhi_engine($masc_stem, "sas");
			$word_chart[$grade][Commons::$FEMINE_GENDER][Commons::$SINGULAR]["elative"] = Sanskrit_Common::sandhi_engine($fem_stem, "tas");
			$word_chart[$grade][Commons::$FEMINE_GENDER][Commons::$SINGULAR]["inessive1"] = Sanskrit_Common::sandhi_engine($fem_stem, "trā");
			$word_chart[$grade][Commons::$FEMINE_GENDER][Commons::$SINGULAR]["inessive2"] = Sanskrit_Common::sandhi_engine($fem_stem, "dha");		
			$word_chart[$grade][Commons::$FEMINE_GENDER][Commons::$SINGULAR]["comitative"] = Sanskrit_Common::sandhi_engine($fem_stem, "thā");		
			$word_chart[$grade][Commons::$FEMINE_GENDER][Commons::$SINGULAR]["multiplicative"] = Sanskrit_Common::sandhi_engine($fem_stem, "dhā");	
			$word_chart[$grade][Commons::$FEMINE_GENDER][Commons::$SINGULAR]["essive"] = Sanskrit_Common::sandhi_engine($fem_stem, "vat");	
			$word_chart[$grade][Commons::$FEMINE_GENDER][Commons::$SINGULAR]["translative"] = Sanskrit_Common::sandhi_engine($fem_stem, "sāt");		
			$word_chart[$grade][Commons::$FEMINE_GENDER][Commons::$SINGULAR]["temporal"] = Sanskrit_Common::sandhi_engine($fem_stem, "dā");	
			$word_chart[$grade][Commons::$FEMINE_GENDER][Commons::$SINGULAR]["illative"] = Sanskrit_Common::sandhi_engine($fem_stem, "ac");	
			$word_chart[$grade][Commons::$FEMINE_GENDER][Commons::$SINGULAR]["distributive"] = Sanskrit_Common::sandhi_engine($fem_stem, "sas");
			$word_chart[$grade][Commons::$NEUTER_GENDER][Commons::$SINGULAR]["elative"] = $word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["elative"];
			$word_chart[$grade][Commons::$NEUTER_GENDER][Commons::$SINGULAR]["inessive1"] = $word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["inessive1"];
			$word_chart[$grade][Commons::$NEUTER_GENDER][Commons::$SINGULAR]["inessive2"] = $word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["inessive2"];		
			$word_chart[$grade][Commons::$NEUTER_GENDER][Commons::$SINGULAR]["comitative"] = $word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["comitative"];		
			$word_chart[$grade][Commons::$NEUTER_GENDER][Commons::$SINGULAR]["multiplicative"] = $word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["multiplicative"];	
			$word_chart[$grade][Commons::$NEUTER_GENDER][Commons::$SINGULAR]["essive"] = $word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["essive"];	
			$word_chart[$grade][Commons::$NEUTER_GENDER][Commons::$SINGULAR]["translative"] = $word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["translative"];		
			$word_chart[$grade][Commons::$NEUTER_GENDER][Commons::$SINGULAR]["temporal"] = $word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["temporal"];	
			$word_chart[$grade][Commons::$NEUTER_GENDER][Commons::$SINGULAR]["illative"] = $word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["illative"];	
			$word_chart[$grade][Commons::$NEUTER_GENDER][Commons::$SINGULAR]["distributive"] = $word_chart[$grade][Commons::$MASCULINE_GENDER][Commons::$SINGULAR]["distributive"];			
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
			$ary = array(Commons::$NOMINATIVE, Commons::$GENETIVE, Commons::$DATIVE, Commons::$ACCUSATIVE, Commons::$ABLATIVE, Commons::$INSTRUMENTAL, Commons::$LOCATIVE, Commons::$VOCATIVE);	// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$case = $ary[$key];			
		}

		// 数がない場合
		if($number == ""){
			// 単数・複数の中からランダムで選択
			$ary = array(Commons::$SINGULAR, Commons::$DUAL, Commons::$PLURAL);			// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$number = $ary[$key];			
		}

		// 性別がない場合
		if($gender == ""){
			// 全ての性別の中からランダムで選択
			$ary = array(Commons::$MASCULINE_GENDER, Commons::$FEMINE_GENDER, Commons::$NEUTER_GENDER);			// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$gender = $ary[$key];			
		}	

		// 形容詞の級に指定がない場合は
		if($grade == ""){
			// 全ての級を対象にする。
			$ary = array(Commons::$ADJ_GRADE_POSITIVE, Commons::$ADJ_GRADE_COMPERATIVE, Commons::$ADJ_GRADE_SUPERATIVE);	// 初期化
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
		$this->get_adj_declension(Commons::$ADJ_GRADE_POSITIVE);		// 原級
		$this->get_adj_declension(Commons::$ADJ_GRADE_COMPERATIVE);			// 比較級
		$this->get_adj_declension(Commons::$ADJ_GRADE_SUPERATIVE);			// 最上級
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
		$word_info = $this->get_adjective_from_DB($adjective, Polish_Common::$DB_ADJECTIVE);
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
				if(preg_match('/[^aiueoąę][^aiueoąę]$/', $stem) && !preg_match('/kk$/', $stem)){
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
		if($grade == Commons::$ADJ_GRADE_POSITIVE){
			$adjective_type = $this->adjective_type;
		} else if($grade == Commons::$ADJ_GRADE_COMPERATIVE){
			$adjective_type = "1-2";
		} else if($grade == Commons::$ADJ_GRADE_SUPERATIVE){
			$adjective_type = "1-2";
		}

		// 曲用を取得
		$masculine_declension = $this->get_adjective_case_suffix($adjective_type, "Masculine");
		$feminine_declension = $this->get_adjective_case_suffix($adjective_type, "Feminine");
		$neuter_declension = $this->get_adjective_case_suffix($adjective_type, "Neuter");

		// 活用表を挿入(男性)
		// 単数
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$NOMINATIVE] = $masculine_declension["sg_nom"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$GENETIVE] = $masculine_declension["sg_gen"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$DATIVE] = $masculine_declension["sg_dat"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$ACCUSATIVE] = $masculine_declension["sg_acc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$INSTRUMENTAL] = $masculine_declension["sg_ins"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$LOCATIVE] = $masculine_declension["sg_loc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$SINGULAR][Commons::$VOCATIVE] = $masculine_declension["sg_voc"];
		
		// 双数
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$DUAL][Commons::$NOMINATIVE] = $masculine_declension["du_nom"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$DUAL][Commons::$GENETIVE] = $masculine_declension["du_gen"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$DUAL][Commons::$DATIVE] = $masculine_declension["du_dat"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$DUAL][Commons::$ACCUSATIVE] = $masculine_declension["du_acc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$DUAL][Commons::$INSTRUMENTAL] = $masculine_declension["du_ins"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$DUAL][Commons::$LOCATIVE] = $masculine_declension["du_loc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$DUAL][Commons::$VOCATIVE] = $masculine_declension["du_voc"];
		
		// 複数
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$NOMINATIVE] = $masculine_declension["pl_nom"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$GENETIVE] = $masculine_declension["pl_gen"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$DATIVE] = $masculine_declension["pl_dat"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$ACCUSATIVE] = $masculine_declension["pl_acc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$INSTRUMENTAL] = $masculine_declension["pl_ins"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$LOCATIVE] = $masculine_declension["pl_loc"];
		$case_suffixes[Commons::$MASCULINE_GENDER][Commons::$PLURAL][Commons::$VOCATIVE] = $masculine_declension["pl_voc"];

		// 活用表を挿入(女性)		
		// 単数
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$NOMINATIVE] = $feminine_declension["sg_nom"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$GENETIVE] = $feminine_declension["sg_gen"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$DATIVE] = $feminine_declension["sg_dat"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$ACCUSATIVE] = $feminine_declension["sg_acc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$INSTRUMENTAL] = $feminine_declension["sg_ins"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$LOCATIVE] = $feminine_declension["sg_loc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$SINGULAR][Commons::$VOCATIVE] = $feminine_declension["sg_voc"];
		
		// 双数
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$DUAL][Commons::$NOMINATIVE] = $feminine_declension["du_nom"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$DUAL][Commons::$GENETIVE] = $feminine_declension["du_gen"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$DUAL][Commons::$DATIVE] = $feminine_declension["du_dat"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$DUAL][Commons::$ACCUSATIVE] = $feminine_declension["du_acc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$DUAL][Commons::$INSTRUMENTAL] = $feminine_declension["du_ins"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$DUAL][Commons::$LOCATIVE] = $feminine_declension["du_loc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$DUAL][Commons::$VOCATIVE] = $feminine_declension["du_voc"];
		
		// 複数
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$NOMINATIVE] = $feminine_declension["pl_nom"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$GENETIVE] = $feminine_declension["pl_gen"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$DATIVE] = $feminine_declension["pl_dat"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$ACCUSATIVE] = $feminine_declension["pl_acc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$INSTRUMENTAL] = $feminine_declension["pl_ins"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$LOCATIVE] = $feminine_declension["pl_loc"];
		$case_suffixes[Commons::$FEMINE_GENDER][Commons::$PLURAL][Commons::$VOCATIVE] = $feminine_declension["pl_voc"];

		// 活用表を挿入(女性)		
		// 単数
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$NOMINATIVE] = $neuter_declension["sg_nom"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$GENETIVE] = $neuter_declension["sg_gen"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$DATIVE] = $neuter_declension["sg_dat"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$ACCUSATIVE] = $neuter_declension["sg_acc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$INSTRUMENTAL] = $neuter_declension["sg_ins"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$LOCATIVE] = $neuter_declension["sg_loc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$SINGULAR][Commons::$VOCATIVE] = $neuter_declension["sg_voc"];
		
		// 双数
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$DUAL][Commons::$NOMINATIVE] = $neuter_declension["du_nom"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$DUAL][Commons::$GENETIVE] = $neuter_declension["du_gen"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$DUAL][Commons::$DATIVE] = $neuter_declension["du_dat"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$DUAL][Commons::$ACCUSATIVE] = $neuter_declension["du_acc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$DUAL][Commons::$INSTRUMENTAL] = $neuter_declension["du_ins"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$DUAL][Commons::$LOCATIVE] = $neuter_declension["du_loc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$DUAL][Commons::$VOCATIVE] = $neuter_declension["du_voc"];
		
		// 複数
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$NOMINATIVE] = $neuter_declension["pl_nom"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$GENETIVE] = $neuter_declension["pl_gen"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$DATIVE] = $neuter_declension["pl_dat"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$ACCUSATIVE] = $neuter_declension["pl_acc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$INSTRUMENTAL] = $neuter_declension["pl_ins"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$LOCATIVE] = $neuter_declension["pl_loc"];
		$case_suffixes[Commons::$NEUTER_GENDER][Commons::$PLURAL][Commons::$VOCATIVE] = $neuter_declension["pl_voc"];
		
		// 活用を挿入
		if($grade == Commons::$ADJ_GRADE_POSITIVE){
			// 活用種別名
			$this->adjective_type_name = $masculine_declension["adjective_type_name"];				
			$this->case_suffix = $case_suffixes;
		} else if($grade == Commons::$ADJ_GRADE_COMPERATIVE){
			$this->comparative_case_suffix = $case_suffixes;
		} else if($grade == Commons::$ADJ_GRADE_SUPERATIVE){
			$this->superlative_case_suffix = $case_suffixes;
		}		
	}
	
	// 形容詞作成(原級)
	protected function generate_positive($case, $number, $gender){
		// 格語尾を取得
		$case_suffix = "";
		// 曲用語尾を取得
		if($number == Commons::$SINGULAR && $this->deponent_singular != Commons::$TRUE){
			// 単数
			$case_suffix = $this->case_suffix[$gender][$number][$case];
		} else if($number == Commons::$DUAL && ($this->deponent_plural != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->case_suffix[$gender][$number][$case];			
		} else if($number == Commons::$PLURAL && ($this->deponent_plural != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->case_suffix[$gender][$number][$case];
		} else {
			// ハイフンを返す。
			return "-";
		}

		// 語幹を取得
		// それ以外は単数の主格と呼格は弱語幹
		if($this->gender == Commons::$MASCULINE_GENDER && Commons::$SINGULAR && ($case == Commons::$NOMINATIVE || $case == Commons::$VOCATIVE)){
			// ここで結果を返す。
			return $this->first_stem;					
		} else if($case == Commons::$ACCUSATIVE && $this->gender == Commons::$NEUTER_GENDER && $number == Commons::$SINGULAR){
			// 中性の単数対格は主格と同じ
			// ここで結果を返す。
			return $this->first_stem;
		} else {
			// それ以外は強語幹
			$adjective = $this->third_stem;
		}

		// 変換処理
		$adjective = trim($adjective.$case_suffix);			
		$adjective = preg_replace("/di$/", "dzi", $adjective);
		$adjective = preg_replace("/ti$/", "cy", $adjective);
		$adjective = preg_replace("/ri$/", "rzy", $adjective);

		$adjective = preg_replace("/be$/", "bie", $adjective);
		$adjective = preg_replace("/pe$/", "pie", $adjective);	
		$adjective = preg_replace("/me$/", "mie", $adjective);
		$adjective = preg_replace("/ne$/", "nie", $adjective);
		$adjective = preg_replace("/re$/", "rze", $adjective);
		$adjective = preg_replace("/te$/", "cie", $adjective);
		$adjective = preg_replace("/de$/", "dzie", $adjective);
		$adjective = preg_replace("/ke$/", "ce", $adjective);
		$adjective = preg_replace("/kem$/", "kiem", $adjective);		
		$adjective = preg_replace("/ge$/", "dzie", $adjective);

		$adjective = preg_replace("/ry$/", "rzy", $adjective);
		$adjective = preg_replace("/dy$/", "dzy", $adjective);
		$adjective = preg_replace("/ky$/", "cy", $adjective);
		$adjective = preg_replace("/gy$/", "dzy", $adjective);

		// 最後の音節のoは短音になる。但し単音節の単語は除く
		$adjective = preg_replace("/[aiueo]{1}.o([^aiueoąęó])$/u", "ó\\1", $adjective);

		// 結果を返す
		return $adjective;
	}
	
	// 形容詞作成(比較級)
	protected function generate_comp($case, $number, $gender){
		// 格語尾を取得
		$case_suffix = null;
		// 曲用語尾を取得
		if($number == Commons::$SINGULAR && $this->deponent_singular != Commons::$TRUE){
			// 単数
			$case_suffix = $this->comparative_case_suffix[$gender][$number][$case];
		} else if($number == Commons::$DUAL && ($this->deponent_plural != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->comparative_case_suffix[$gender][$number][$case];				
		} else if($number == Commons::$PLURAL && ($this->deponent_singular != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
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
		if($number == Commons::$SINGULAR && $this->deponent_singular != Commons::$TRUE){
			// 単数
			$case_suffix = $this->superlative_case_suffix[$gender][$number][$case];
		} else if($number == Commons::$DUAL && ($this->deponent_plural != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
			// 複数
			$case_suffix = $this->superlative_case_suffix[$gender][$number][$case];				
		} else if($number == Commons::$PLURAL && ($this->deponent_singular != Commons::$TRUE || $this->location_name != Commons::$TRUE)){
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
		if($grade == Commons::$ADJ_GRADE_POSITIVE){
			// 原級
			// 活用種別で分岐
			$adverb = $this->third_stem."e";			
		} else if($grade == Commons::$ADJ_GRADE_COMPERATIVE){
			// 比較級
			$adverb = $this->comparative_third_stem."ej";
		} else if($grade == Commons::$ADJ_GRADE_SUPERATIVE){
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
		$word_chart[commons::$ADJ_GRADE_POSITIVE]["adverb"] = $this->get_adverb(commons::$ADJ_GRADE_POSITIVE);
		$word_chart[commons::$ADJ_GRADE_COMPERATIVE]["adverb"] = $this->get_adverb(commons::$ADJ_GRADE_COMPERATIVE);
		$word_chart[Commons::$ADJ_GRADE_SUPERATIVE]["adverb"] = $this->get_adverb(Commons::$ADJ_GRADE_SUPERATIVE);

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
			$ary = array(Commons::$NOMINATIVE, Commons::$GENETIVE, Commons::$DATIVE, Commons::$ACCUSATIVE, Commons::$INSTRUMENTAL, Commons::$LOCATIVE, Commons::$VOCATIVE);	// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$case = $ary[$key];			
		}

		// 数がない場合
		if($number == ""){
			// 単数・複数の中からランダムで選択
			$ary = array(Commons::$SINGULAR, Commons::$PLURAL);			// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$number = $ary[$key];			
		}

		// 性別がない場合
		if($gender == ""){
			// 全ての性別の中からランダムで選択
			$ary = array(Commons::$MASCULINE_GENDER, Commons::$FEMINE_GENDER, Commons::$NEUTER_GENDER);			// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$gender = $ary[$key];			
		}	

		// 形容詞の級に指定がない場合は
		if($grade == ""){
			// 全ての級を対象にする。
			$ary = array(Commons::$ADJ_GRADE_POSITIVE, Commons::$ADJ_GRADE_COMPERATIVE, Commons::$ADJ_GRADE_SUPERATIVE);	// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$grade = $ary[$key];			
		}

		// 配列に格納
		$question_data = array();
		$question_data['question_sentence'] = $this->get_adjective_title()."の".$gender." ".$number." ".$case."を答えよ";				
		$question_data['answer'] = $this->get_declensioned_adjective($case, $number, $gender, $grade);
		$question_data['case'] = $case;
		$question_data['number'] = $number;	
		$question_data['gender'] = $gender;
		$question_data['grade'] = $grade;			

		// 結果を返す。
		return $question_data;
	}	

}


?>