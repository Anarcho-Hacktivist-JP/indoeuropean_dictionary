<?php
set_time_limit(600);

// インドヨーロッパ語動詞クラス
class Verb_Common_IE {

	// 不完了体動詞
	protected $present_stem = "";
	
	// 完了体動詞
	protected $aorist_stem = "";
	
	// 状態動詞
	protected $perfect_stem = "";

	// 一次人称接尾辞(現在、接続用)
	protected $primary_number = 
	[		
		"active" => 
		[
			"1sg" => "mi",
			"2sg" => "si", 
			"3sg" => "ti",
			"1pl" => "mos",
			"2pl" => "te", 
			"3pl" => "nti",			
		],
		"mediopassive" => 
		[
			"1sg" => "or",
			"2sg" => "thor", 
			"3sg" => "tor",
			"1pl" => "mosdh",
			"2pl" => "dhwo", 
			"3pl" => "ntor",			
		],
	];
	
	// 二次人称接尾辞(過去、願望用)
	protected $secondary_number = 
	[		
		"active" => 
		[
			"1sg" => "m",
			"2sg" => "s", 
			"3sg" => "t",
			"1pl" => "me",
			"2pl" => "te", 
			"3pl" => "nt",		
		],
		"mediopassive" => 
		[
			"1sg" => "o",
			"2sg" => "tho", 
			"3sg" => "to",
			"1pl" => "medh",
			"2pl" => "dhwo", 
			"3pl" => "nto",
		],
	];

	// 命令人称接尾辞
	protected $imperative_number = 
	[
		"active" => 
		[
			"1sg" => "",
			"2sg" => "dhi", 
			"3sg" => "tu",
			"1pl" => "",
			"2pl" => "te", 
			"3pl" => "ntu",	
		],
		"mediopassive" => 
		[
			"1sg" => "",
			"2sg" => "so", 
			"3sg" => "to",
			"1pl" => "",
			"2pl" => "dwo", 
			"3pl" => "nto",	
		],

	];
	
	// 完了人称接尾辞
	protected $perfect_number = 
	[
		"active" => 
		[
			"1sg" => "e",
			"2sg" => "the", 
			"3sg" => "e",
			"1pl" => "mr",
			"2pl" => "e", 
			"3pl" => "er",	
		],
	];
	
	// 直接法
	protected $ind = "";
	// 命令法
	protected $imper = "";
	// 希求法
	protected $opt = "ye";
	// 接続法
	protected $subj = "e";
	
	// 不完了体能動分詞
	protected $present_participle_active = "";
	// 不完了体受動分詞
	protected $present_participle_passive = "";
	// 不完了体中動分詞
	protected $present_participle_middle = "";	
	// 完了体能動分詞
	protected $aorist_participle_active = "";
	// 完了体受動分詞
	protected $aorist_participle_passive = "";
	// 完了体中動分詞
	protected $aorist_participle_middle = "";	
	// 状態動詞能動分詞
	protected $perfect_participle_active = "";
	// 状態動詞受動分詞
	protected $perfect_participle_passive = "";
	// 状態動詞中動分詞
	protected $perfect_participle_middle = "";


	// 欠如-能動形	
	protected $deponent_active = "";
	// 欠如-受動形	
	protected $deponent_mediopassive = "";
	// 欠如-不完了体	
	protected $deponent_present = "";
	// 欠如-完了体	
	protected $deponent_aorist = "";	
	// 欠如-状態動詞形	
	protected $deponent_perfect = "";


	// 日本語訳
	protected $japanese_translation = "";
	// 英語訳
	protected $english_translation = "";
	
	// 活用種別
	protected $class = "";

	// 活用種別名
	protected $class_name = "";	
	// 活用種別-語根種別
	protected $root_type = "";
	// 活用種別-同志種別
	protected $verb_type = "";

	// 追加語幹
	protected $add_stem = "";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
        $a = func_get_args();
        $i = func_num_args();
        //引数に応じて別々のコンストラクタを似非的に呼び出す
        if (method_exists($this,$f='__construct'.$i)) {			
            call_user_func_array(array($this,$f),$a);
        }
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    function __construct1($dictionary_stem) {
    	// 動詞情報を取得
		$this->get_verb_data($dictionary_stem);
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    function __construct3($present_stem, $aorist_stem, $perfect_stem) {
    	$this->present_stem = $present_stem;		//現在相
    	$this->aorist_stem = $aorist_stem;			//完結相
    	$this->perfect_stem = $perfect_stem;		//完了相
    }

    // 動詞情報を取得
    protected function get_verb_data($verb){
    	// 動詞情報を取得
		$word_info = $this->get_verb_from_DB($verb, "verb_pie");
		// データがある場合は
		if($word_info){
			// データを挿入
			$this->present_stem = $word_info["present_stem"];		//現在相
			$this->aorist_stem = $word_info["aorist_stem"];			//完結相
			$this->perfect_stem = $word_info["perfect_stem"];		//完了相
		} else {
			// データを挿入
			$this->present_stem = $verb;		//現在相
			$this->aorist_stem = $verb;			//完結相
			$this->perfect_stem = $verb;		//完了相			
		}
    }

    // 動詞情報取得
	protected function get_verb_from_DB($dictionary_stem, $table){
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `".$table."` WHERE `dictionary_stem` = '".$dictionary_stem."'";
		// SQLを実行
		$stmt = $db_host->query($query);
		// メモリ解放処理
		unset($db_host);
		// 結果が取得できたら、
		if($stmt){
			// 連想配列に整形して返す。
			return $stmt->fetch(PDO::FETCH_BOTH);
		} else {
			return null;
		}
	}
	
	// 動詞作成
	public function get_PIE_verb($person, $voice, $mood, $aspect, $tense){
		//動詞の語幹を取得
		$verb_stem = "";
		if($aspect == Commons::PRESENT_ASPECT){
			// 不完了形
			$verb_stem = $this->present_stem;
		} else if($aspect == Commons::AORIST_ASPECT){
			// 完了形
			$verb_stem = $this->aorist_stem;
		} else if($aspect == Commons::PERFECT_ASPECT){
			// 状態動詞
			$verb_stem = $this->perfect_stem;
		} else {
			// ハイフンを返す。
			return "-";
		} 
		
		//法を取得
		if($mood == Commons::INDICATIVE){
			// 直説法
			$verb_stem = $verb_stem.$this->ind;
			// 時制を分ける。
			if($tense == "present") {
				$verb_stem = $this->get_primary_suffix($verb_stem, $voice, $person);
			} else {
				$verb_stem = $this->get_secondary_suffix($verb_stem, $voice, $person);
			}
		} else if($mood == Commons::OPTATIVE){
			// 希求法
			$verb_stem = $verb_stem.$this->opt;
			$verb_stem = $this->get_secondary_suffix($verb_stem, $voice, $person);
		} else if($mood == Commons::SUBJUNCTIVE){
			// 接続法
			$verb_stem = $verb_stem.$this->subj;
			$verb_stem = $this->get_primary_suffix($verb_stem, $voice, $person);
		} else if($mood == Commons::IMPERATIVE){
			// 命令法
			$verb_stem = $verb_stem.$this->imper;
			$verb_stem = $this->get_imperative_suffix($verb_stem, $voice, $person);
		}
		
		// 結果を返す。
		return $verb_stem;

	}
	
	// 一次語尾
	protected function get_primary_suffix($verb_conjugation, $voice, $person){
		// 語尾を取得
		if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 能動態
			$verb_conjugation = $verb_conjugation.$this->primary_number[$voice][$person];
		} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
			// 中受動態単数
			$verb_conjugation = $verb_conjugation.$this->primary_number[$voice][$person];
		} else {
			// ハイフンを返す。
			return "-";
		} 
		
		// 結果を返す。
		return $verb_conjugation;
	}
	
	// 二次語尾
	protected function get_secondary_suffix($verb_conjugation, $voice, $person){
		// 語尾を取得
		if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 能動態単数
			$verb_conjugation = $verb_conjugation.$this->secondary_number[$voice][$person];
		} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
			// 中受動態単数
			$verb_conjugation = $verb_conjugation.$this->secondary_number[$voice][$person];
		} else {
			// ハイフンを返す。
			return "-";
		} 
		
		// 結果を返す。
		return $verb_conjugation;
	}
	
	// 命令語尾
	protected function get_imperative_suffix($verb_conjugation, $voice, $person){
		// 命令法
		// 語尾を取得
		if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 能動態単数
			$verb_conjugation = $verb_conjugation.$this->imperative_number[$voice][$person];
		} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
			// 中受動態単数
			$verb_conjugation = $verb_conjugation.$this->imperative_number[$voice][$person];
		} else {
			// ハイフンを返す。
			return "-";
		} 
		// 結果を返す。
		return $verb_conjugation;
	}
	
	// 完了語尾
	protected function get_perfect_suffix($verb_conjugation, $voice, $person){
		// 語尾を取得
		if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 能動態単数
			$verb_conjugation = $verb_conjugation.$this->perfect_number[$voice][$person];
		} else {
			// ハイフンを返す。
			return "-";
		}  
		// 結果を返す。
		return $verb_conjugation;
	}

    // 動詞のタイトルを取得
    protected function get_title($dic_form){

		// タイトルを作成
		$verb_script = $dic_form;

		// 英語訳がある場合は
		if ($this->english_translation != ""){
			// 訳を入れる。
			$verb_script = $verb_script." 英語：".$this->english_translation."";
		}
		
		// 日本語訳がある場合は
		if ($this->japanese_translation != ""){
			// 訳を入れる。
			$verb_script = $verb_script." 日本語：".$this->japanese_translation."";
		}

    	// 結果を返す。
    	return $verb_script;
	}

    // 欠如動詞チェック
    protected function deponent_check($voice, $aspect){
		// 能動態がない動詞で能動態が選択されている場合は		
		if($voice == Commons::ACTIVE_VOICE && $this->deponent_active == Commons::$TRUE){
			return false;
		} 

		// 中受動態がない動詞で中受動態が選択されている場合は		
		if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive == Commons::$TRUE){
			return false;
		} 

		// 進行相がない動詞で進行相が選択されている場合は		
		if($aspect == Commons::PRESENT_ASPECT && $this->deponent_present == Commons::$TRUE){
			return false;
		}

		// 完結相がない動詞で完結相が選択されている場合は		
		if($aspect == Commons::AORIST_ASPECT && $this->deponent_aorist == Commons::$TRUE){
			return false;
		} 

		// 完了相がない動詞で完了相が選択されている場合は		
		if($aspect == Commons::PERFECT_ASPECT && $this->deponent_perfect == Commons::$TRUE){
			return false;
		} 

		// それ以外の場合はtrue
		return true;
	}

}

// ラテン語クラス
class Latin_Verb extends Verb_Common_IE {
	
	// 一次人称接尾辞(現在、未来)
	protected $primary_number = 
	[		
		"active" => 
		[
			"1sg" => "ō",
			"2sg" => "s", 
			"3sg" => "t",
			"1pl" => "mus",
			"2pl" => "tis", 
			"3pl" => "unt",	
		],
		"mediopassive" => 
		[
			"1sg" => "or",
			"2sg" => "ris", 
			"3sg" => "tur",
			"1pl" => "mur",
			"2pl" => "minī", 
			"3pl" => "untur",	
		],
	];
	
	// 二次人称接尾辞(過去、接続、未来)
	protected $secondary_number = 
	[
		"active" => 
		[
			"1sg" => "m",
			"2sg" => "s", 
			"3sg" => "t",
			"1pl" => "mus",
			"2pl" => "tis", 
			"3pl" => "nt",	
		],
		"mediopassive" => 
		[
			"1sg" => "r",
			"2sg" => "ris", 
			"3sg" => "tur",
			"1pl" => "mur",
			"2pl" => "minī", 
			"3pl" => "ntur",	
		],
	];

	// 命令人称接尾辞
	protected $imperative_number = 
	[
		"active" => 
		[
			"1sg" => "",
			"2sg" => "", 
			"3sg" => "",
			"1pl" => "",
			"2pl" => "te", 
			"3pl" => "",	
		],
		"mediopassive" => 
		[
			"1sg" => "",
			"2sg" => "re", 
			"3sg" => "",
			"1pl" => "",
			"2pl" => "mini", 
			"3pl" => "",	
		],
	];
	
	// 未来命令人称接尾辞
	protected $imperative_future_number = 
	[
		"active" => 
		[
			"1sg" => "",
			"2sg" => "tō", 
			"3sg" => "tō",
			"1pl" => "",
			"2pl" => "tōte", 
			"3pl" => "ntō",	
		],
		"mediopassive" => 
		[
			"1sg" => "",
			"2sg" => "tor", 
			"3sg" => "tor",
			"1pl" => "",
			"2pl" => "minor", 
			"3pl" => "ntor",	
		],
	];
	
	// 完了人称接尾辞
	protected $perfect_number = 
	[
		"active" => 
		[
			"1sg" => "i",
			"2sg" => "istī", 
			"3sg" => "it",
			"1pl" => "imus",
			"2pl" => "istis", 
			"3pl" => "ērent",	
		]
	];
	
	// 直接法
	protected $ind = "";
	// 命令法
	protected $imper = "";
	// 希求法→接続法
	protected $opt = "";
	// 接続法→未来形
	protected $subj = "";
	
	// 不定形
	protected $infinitive = "";
	// 受動不定形
	protected $passive_infinitive = "";
	// 完了不定形
	protected $perfect_infinitive = "";
	// 完了受動不定形
	protected $perfect_passive_infinitive = "";
	// 未来不定形
	protected $future_infinitive = "";
	// 未来受動不定形
	protected $future_passive_infinitive = "";


	// 未来能動分詞
	protected $future_participle_active = "";
	// 未来受動分詞
	protected $future_participle_passive = "";
	// 目的分詞
	protected $supine = "";

	// 非人称のみ
	protected $deponent_personal = "";

	// 直接法過去接尾辞
	protected const past_ind_infix = "ba";
	// 未来形2接尾辞1
	protected const s_future_suffix = "ssi";
	// 未来形2接尾辞2
	protected const s_future_suffix2 = "si";
	// 直接法未来語尾
	protected const ind_future_suffix = "bi";
	// 直接法過去完了語尾
	protected const ind_perf_past_suffix = "era";	
	// 直接法未来完了語尾
	protected const ind_perf_future_suffix = "eri";

	// sum補助動詞
	protected const auxiliary_sum = "esse";

    /*=====================================
    コンストラクタ
    ======================================*/
 	function __construct_lat1($dic_stem) {
		// 親の呼び出し
    	parent::__construct($dic_stem);
    	// 動詞情報を取得
		$word_info = $this->get_verb_from_DB($dic_stem, Latin_Common::DB_VERB);
		// データの取得確認
		if($word_info){
			// データを挿入
			$this->present_stem = $word_info["present_stem"];						// 現在形
			$this->infinitive = $word_info["infinitive_stem"];						// 不定形
			$this->aorist_stem = $word_info["perfect_stem"];						// 完了形
			$this->perfect_stem = $word_info["perfect_stem"];						// 完了形
			$this->perfect_participle_passive = $word_info["perfect_participle"];	// 完了分詞

			$this->japanese_translation = $word_info["japanese_translation"];		// 日本語訳
			$this->english_translation = $word_info["english_translation"];			// 英語訳

			$this->deponent_active = $word_info["deponent_active"];					// 欠如-能動形
			$this->deponent_mediopassive = $word_info["deponent_passive"];				// 欠如-受動形
			$this->deponent_present = $word_info["deponent_present"];				// 欠如-現在形
			$this->deponent_perfect = $word_info["deponent_perfect"];				// 欠如-完了形
			$this->deponent_personal = $word_info["deponent_personal"];				// 非人称のみ
			$this->verb_type = $word_info["verb_type"];							// 活用種別
		} else if(preg_match('/(ficāre|ficare)$/',$dic_stem)){
			// 使役動詞の場合は
			$primary_stem = mb_substr($dic_stem, 0, -6)."re";
    		// 動詞情報を取得
			$word_info = $this->get_verb_from_DB($primary_stem, Latin_Common::DB_VERB);
			// データがある場合は
			if($word_info){
				// 共通語幹
				$common_stem = mb_substr($word_info["infinitive_stem"], 0, -2)."fic";
				// 動詞を設定
				$this->generate_uknown_verb($common_stem);				
				// データを挿入
				$this->japanese_translation = $word_info["japanese_translation"]."ことをさせる";	 // 日本語訳
				$this->english_translation = "make to ".$word_info["english_translation"];	 // 英語訳
			} else {
				// 不明動詞の対応
				$this->generate_uknown_verb(mb_substr($dic_stem, 0, -3));
			}
		} else if(preg_match('/(scere)$/',$dic_stem)){
			// 始動動詞の場合は
			$primary_stem = mb_substr($dic_stem, 0, -5)."re";
    		// 動詞情報を取得
			$word_info = $this->get_verb_from_DB($primary_stem, Latin_Common::DB_VERB);
			// データがある場合は
			if($word_info){
				// データを挿入
				$this->japanese_translation = $word_info["japanese_translation"]."ことをし始める";	 // 日本語訳
				$this->english_translation = "start to ".$word_info["english_translation"];			// 英語訳
				// 対応する動詞接尾辞の情報を入れる。
				$this->deponent_active = Commons::$FALSE;				// 欠如-能動形
				$this->deponent_mediopassive = Commons::$FALSE;				// 欠如-受動形
				$this->deponent_present = Commons::$FALSE;				// 欠如-現在形
				$this->deponent_perfect = Commons::$TRUE;				// 欠如-完了形
				$this->verb_type= "3";					// 活用種別
				$this->present_stem = mb_substr($dic_stem, 0, -3);	// 現在形
				$this->infinitive = $dic_stem;		// 不定形			
				$this->aorist_stem = "";					// 完了形
				$this->perfect_stem = "";					// 完了形
				$this->perfect_participle_passive = "";		// 完了分詞	
			} else {
				// 不明動詞の対応
				$this->generate_uknown_verb3(mb_substr($dic_stem, 0, -3));	
			}
		} else if(preg_match('/(tare|tāre|sare|sāre)$/',$dic_stem)){
			// 強意動詞の場合は
			$word_info = $this->get_original_verb(mb_substr($dic_stem, 0, -4), mb_substr($dic_stem, -5, 1));
			// データがある場合は
			if($word_info){
				// 共通語幹
				$common_stem = mb_substr($word_info["perfect_participle"], 0, -2);
				// 動詞を設定
				$this->generate_uknown_verb($common_stem);	
				// データを挿入
				$this->japanese_translation = $word_info["japanese_translation"]."ことを繰り返す";	  	// 日本語訳
				$this->english_translation = "continue to ".$word_info["english_translation"];		   // 英語訳	
			} else {
				// 不明動詞の対応
				$this->generate_uknown_verb(mb_substr($dic_stem, 0, -3));		
			}
		} else if(preg_match('/(turire|turīre|surire|surīre)$/',$dic_stem)){			
			// 願望動詞の場合は
			$word_info = $this->get_original_verb(mb_substr($dic_stem, 0, -6), mb_substr($dic_stem, -7, 1));
			if($word_info){
				// 共通語幹
				$common_stem = mb_substr($word_info["perfect_participle"], 0, -2)."ur";
				// 動詞を設定
				$this->generate_uknown_verb4($common_stem);					
				// データを挿入
				$this->japanese_translation = $word_info["japanese_translation"]."ことをしたい";	 // 日本語訳
				$this->english_translation = "want to ".$word_info["english_translation"];			// 英語訳		
			} else {
				// 不明動詞の対応
				$this->generate_uknown_verb4(mb_substr($dic_stem, 0, -3));	
			}
		} else if(preg_match('/(are|āre)$/',$dic_stem)){	
			// 不明動詞の対応
			$this->generate_uknown_verb(mb_substr($dic_stem, 0, -3));
		} else if(preg_match('/ēre$/',$dic_stem)){	
			// 不明動詞の対応
			$this->generate_uknown_verb2(mb_substr($dic_stem, 0, -3));
		} else if(preg_match('/ere$/',$dic_stem)){	
			// 不明動詞の対応
			$this->generate_uknown_verb3(mb_substr($dic_stem, 0, -3));			
		} else if(preg_match('/(ire|īre)$/',$dic_stem)){	
			// 不明動詞の対応
			$this->generate_uknown_verb4(mb_substr($dic_stem, 0, -3));										
		} else {
			// 不明動詞の対応
			$this->generate_uknown_verb($dic_stem);
		}

		// 動詞の種別を決定
		$this->decide_verb_class();
		// 動詞の語幹を作成
		$this->get_verb_stem($this->infinitive, $this->perfect_stem, $this->perfect_participle_passive);
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    function __construct_lat3($stem, $japanese_word, $last_word) {
		// 親の呼び出し
    	parent::__construct($last_word);		
		// 種別により分ける。
		if(mb_strpos($japanese_word, "にする") || preg_match('/ficāre$/',$last_word)){
			// 動詞の活用を作る。
			$this->generate_uknown_verb($stem."fic");												
		} else if(mb_strpos('化する',$japanese_word) || mb_strpos('になる',$japanese_word) || preg_match('/zāre$/', $last_word)){
			// 動詞の活用を作る。
			$this->generate_uknown_verb($stem."z");	
		} else if(mb_strpos('する', $japanese_word) && preg_match('/āre$/', $last_word)){
			// 不明動詞の対応
			$this->generate_uknown_verb(mb_substr($stem, 0, -1));																			
		} else {
			// それ以外は最後の語尾から動詞の活用を生成
			$this->__construct_lat1($last_word);
			// 後ろに付け加える。
			$this->present_stem = $stem.$this->present_stem ;								// 現在形
			$this->infinitive = $stem.$this->infinitive;									// 不定形
			$this->aorist_stem = $stem.$this->aorist_stem;									// 完了形
			$this->perfect_stem = $stem.$this->perfect_stem;								// 完了形
			$this->perfect_participle_passive = $stem.$this->perfect_participle_passive;	// 完了分詞														
		}
		// 動詞の種別を決定
		$this->decide_verb_class();
		// 訳を入れる。
		$this->japanese_translation = $japanese_word;									// 日本語訳
		$this->english_translation = "";												// 英語訳				
		// 動詞の語幹を作成
		$this->get_verb_stem($this->infinitive, $this->perfect_stem, $this->perfect_participle_passive);		
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    function __construct_lat2($infinitive, $verb_genre) {
		// 親の呼び出し
    	parent::__construct($infinitive);

		// 動詞の種別ごとで分ける。
		switch($verb_genre){
			case Commons::START_VERB:
				$infinitive = mb_substr($infinitive, 0, -2)."scere";
				break;
			case Commons::STRONG_VERB:
				$infinitive = mb_substr($infinitive, 0, -2)."tāre";
				break;
			case Commons::WANT_VERB:
				$infinitive = mb_substr($infinitive, 0, -2)."turīre";
				break;
			case Commons::MAKE_VERB:
				// 使役動詞
				if(preg_match('/(are|āre)$/',$infinitive)){	
					// 第一活用(名詞起源動詞)
					$infinitive = mb_substr($infinitive, 0, -2)."ficāre";
				} else if(preg_match('/ēre$/',$infinitive)){
					// 第二活用(状態動詞)
					$infinitive = mb_substr($infinitive, 0, -3)."iāre";
				} else if(preg_match('/ere$/',$infinitive)){	
					// 第三活用(語根動詞)
					$infinitive = mb_substr($infinitive, 0, -3)."ēre";	
				} else if(preg_match('/(ire|īre)$/',$infinitive)){	
					// 第四活用(形容詞起源動詞)
					$infinitive = mb_substr($infinitive, 0, -3)."iāre";
				}
				break;				
			default:
				break;
		}

		// 動詞の語幹を作成
		$this->__construct_lat1($infinitive);
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    function __construct_lat4($present_stem, $infinitive, $perfect_stem, $perfect_paticiple) {
		// 親の呼び出し
    	parent::__construct($present_stem, $perfect_stem, $perfect_stem);
		// 補足情報を取得
		$this->get_add_info($infinitive);
		// 動詞の種別を決定
		$this->decide_verb_class();
		// 不規則動詞以外は
		if(!preg_match('/5/', $this->verb_type)){
			// 動詞の語幹を作成
			$this->get_verb_stem($infinitive, $perfect_stem, $perfect_paticiple);
		}
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

	// 派生元動詞を検証
	private function get_original_verb($primary_stem, $marker){
		// 種別により分ける。
		// 種別に応じて元の動詞を生成
		switch ($marker) {
			case "ā":
				$original_verb = $primary_stem."re";
				break;
			case "a":
				$original_verb = mb_substr($primary_stem, 0, -1)."āre";
				break;	
			case "i":
				$original_verb = mb_substr($primary_stem, 0, -1)."ēre";
				break;
			case "ī":
				$original_verb = $primary_stem."re";
				break;
			case "p":
				$original_verb = mb_substr($primary_stem, 0, -1)."bere";
				break;
			case "c":
				$original_verb = mb_substr($primary_stem, 0, -1)."gere";
				break;						
			default:
				$original_verb = $primary_stem."ere";				
				break;
		}

    	// 動詞情報を取得
		$word_info = $this->get_verb_from_DB($original_verb, Latin_Common::DB_VERB);

		// 結果を返す。
		return $word_info;
	}

	// 追加情報を取得
	protected function get_add_info($dic_stem){
    	// 動詞情報を取得
		$word_info = $this->get_verb_from_DB($dic_stem, Latin_Common::DB_VERB);
		// データの取得確認
		if($word_info){
			$this->deponent_active = $word_info["deponent_active"];					// 欠如-能動形
			$this->deponent_mediopassive = $word_info["deponent_passive"];			// 欠如-受動形
			$this->deponent_present = $word_info["deponent_present"];				// 欠如-現在形
			$this->deponent_perfect = $word_info["deponent_perfect"];				// 欠如-完了形
			$this->deponent_personal = $word_info["deponent_personal"];				// 非人称のみ
			$this->japanese_translation = $word_info["japanese_translation"];		// 日本語訳
			$this->english_translation = $word_info["english_translation"];			// 英語訳
			$this->verb_type = $word_info["verb_type"];								// 活用種別
		}
	}

	// 不定詞を取得
	public function get_infinitive(){
		return $this->infinitive;
	}

	// 動詞種別の判定
	private function decide_verb_class(){
    	// 活用種別から動詞種別判定
		switch ($this->verb_type) {
		    case "1":
		        $this->ind = "a";		// 直接法
		        $this->opt = "e";			// 接続法←希求法
		        $this->imper = "ā";		// 命令法
				$this->class_name = "第一変化";	 // 活用名
		        break;
		    case "2":
				$this->ind = "e";		// 直接法
		        $this->opt = "a";			// 接続法←希求法
		        $this->imper = "ē";		// 命令法
				$this->class_name = "第二変化";	 // 活用名				
		        break;
		    case "3":
   				// 直説法語尾
				$this->ind = "i";		// 直接法
		        $this->opt = "a";			// 接続法←希求法
		        $this->subj = "e";		// 未来形←接続法
				$this->imper = "e";		// 命令法
				$this->class_name = "第三変化";	 // 活用名				
		        break;
			case "3a":
				// 直説法語尾
			 	$this->ind = "";				// 直接法
			 	$this->opt = "a";				// 接続法←希求法
				$this->imper = "i";			// 未来形←接続法
			 	$this->subj = "e";			// 命令法
				$this->class_name = "第三変化i型";	 // 活用名
				break;
		    case "4":
   				// 直説法語尾
				$this->ind = "";				// 直接法
		        $this->opt = "a";				// 接続法←希求法
		        $this->subj = "e";			// 未来形←接続法
		        $this->imper = "ī";			// 命令法
				$this->class_name = "第四変化型";	 // 活用名				
		        break;
		    case "5fio":
   				// 直説法語尾
				$this->ind = "";				// 直接法
		        $this->opt = "a";				// 接続法←希求法
		        $this->subj = "e";			// 未来形←接続法
				$this->imper = "i";			// 命令法
				$this->class_name = "不規則動詞";	 // 活用名				
		        break;				
		    case "5volo":
   				// 直説法語尾
				$this->ind = "";				// 直接法
		        $this->opt = "";				// 接続法←希求法
		        $this->subj = "e";			// 未来形←接続法
				$this->imper = "i";			// 命令法
				$this->class_name = "不規則動詞";	 // 活用名					
		        break;
		    case "5fer":
   				// 直説法語尾
				$this->ind = "";				// 直接法
		        $this->opt = "a";				// 接続法←希求法
		        $this->subj = "e";			// 未来形←接続法
				$this->imper = "";				// 命令法
				$this->class_name = "不規則動詞";	 // 活用名					
		        break;
		    case "5eo":
   				// 直説法語尾
				$this->ind = "";				// 直接法
		        $this->opt = "a";				// 接続法←希求法
		        $this->subj = "";			// 未来形←接続法
				$this->imper = "";				// 命令法
				$this->class_name = "不規則動詞";	 // 活用名					
		        break;					
			default:
				break;
		}
	}

	// 不明動詞の対応
	private function generate_uknown_verb($dic_stem){
		// 共通語幹を取得
		$common_stem = $dic_stem."ā";
		// 訳を入れる。
		$this->japanese_translation = "借用";
		$this->english_translation = "loanword";	
		// データを挿入(借用語)
		$this->deponent_active = Commons::$FALSE;				// 欠如-能動形
		$this->deponent_mediopassive = Commons::$FALSE;				// 欠如-受動形
		$this->deponent_present = Commons::$FALSE;				// 欠如-現在形
		$this->deponent_perfect = Commons::$FALSE;				// 欠如-完了形
		$this->verb_type= "1";					// 活用種別					
		$this->present_stem = mb_substr($common_stem, 0, -1);			// 現在形
		$this->infinitive = $common_stem ."re";							// 不定形
		$this->aorist_stem = $common_stem."v";							// 完了形
		$this->perfect_stem = $common_stem."v";							// 完了形
		$this->perfect_participle_passive = $common_stem."tus";			// 完了分詞
	}

	// 不明動詞の対応2
	private function generate_uknown_verb2($dic_stem){
		// 共通語幹を取得
		$common_stem = $dic_stem."ē";
		// 訳を入れる。
		$this->japanese_translation = "借用";
		$this->english_translation = "loanword";	
		// データを挿入(借用語)
		$this->deponent_active = Commons::$FALSE;				// 欠如-能動形
		$this->deponent_mediopassive = Commons::$FALSE;				// 欠如-受動形
		$this->deponent_present = Commons::$FALSE;				// 欠如-現在形
		$this->deponent_perfect = Commons::$FALSE;				// 欠如-完了形
		$this->verb_type= "2";					// 活用種別					
		$this->present_stem = mb_substr($common_stem, 0, -1)."e";		// 現在形
		$this->infinitive = $common_stem ."re";							// 不定形
		$this->aorist_stem = $dic_stem."v";								// 完了形
		$this->perfect_stem = $dic_stem."v";							// 完了形
		$this->perfect_participle_passive = $dic_stem."itus";			// 完了分詞
	}

	// 不明動詞の対応3
	private function generate_uknown_verb3($dic_stem){
		// 共通語幹を取得
		$common_stem = $dic_stem."e";
		// 訳を入れる。
		$this->japanese_translation = "借用";
		$this->english_translation = "loanword";	
		// データを挿入(借用語)
		$this->deponent_active = Commons::$FALSE;				// 欠如-能動形
		$this->deponent_mediopassive = Commons::$FALSE;			// 欠如-受動形
		$this->deponent_present = Commons::$FALSE;				// 欠如-現在形
		$this->deponent_perfect = Commons::$FALSE;				// 欠如-完了形
		$this->verb_type = "3";						// 活用種別					
		$this->present_stem = mb_substr($common_stem, 0, -1);			// 現在形
		$this->infinitive = $common_stem ."re";							// 不定形
		$this->aorist_stem = $common_stem;								// 完了形
		$this->perfect_stem = $common_stem;								// 完了形
		$this->perfect_participle_passive = $dic_stem."tus";			// 完了分詞
	}

	// 不明動詞の対応4
	private function generate_uknown_verb4($dic_stem){
		// 共通語幹を取得
		$common_stem = $dic_stem."ī";
		// 訳を入れる。
		$this->japanese_translation = "借用";
		$this->english_translation = "loanword";	
		// データを挿入(借用語)
		$this->deponent_active = Commons::$FALSE;				// 欠如-能動形
		$this->deponent_mediopassive = Commons::$FALSE;				// 欠如-受動形
		$this->deponent_present = Commons::$FALSE;				// 欠如-現在形
		$this->deponent_perfect = Commons::$FALSE;				// 欠如-完了形
		$this->verb_type= "4";					// 活用種別					
		$this->present_stem = mb_substr($common_stem, 0, -1)."i";		// 現在形
		$this->infinitive = $common_stem ."re";							// 不定形
		$this->aorist_stem = $common_stem."v";							// 完了形
		$this->perfect_stem = $common_stem."v";							// 完了形
		$this->perfect_participle_passive = $dic_stem."ītus";			// 完了分詞
	}
	
	// 動詞の語根を取得
    private function get_verb_root($infinitive){
        // 能動態欠如動詞・第三変化の場合は
        if($this->verb_type === 3 && $this->deponent_active == Commons::$TRUE){
            // 一文字削って返す。
            return mb_substr($infinitive, 0, -1)."ē";
        } else if($this->verb_type === "3a" && $this->deponent_active == Commons::$TRUE){
            // 一文字削って返す。
            return mb_substr($infinitive, 0, -2)."ē";
        } else {
            // それ以外は二文字削って返す。
            return mb_substr($infinitive, 0, -2);
        }    
    }

	// 動詞の語幹を作成
	private function get_verb_stem($infinitive, $perfect_stem, $perfect_paticiple){	
		// 分詞語尾を取得
		$common_stem = $this->get_verb_root($infinitive);

		// 分詞を挿入
		// 現在形が存在する場合は
		if($this->deponent_present != Commons::$TRUE){
			$this->present_participle_active = $common_stem."ns";		// 不完了体能動分詞
		}

		// 完了形が存在する場合は
		if($this->deponent_perfect != Commons::$TRUE){
			$this->perfect_participle_passive = $perfect_paticiple;		// 状態動詞受動分詞
		}
		
		$this->future_participle_active = $common_stem."turus";		// 未来能動分詞
		$this->future_participle_passive = $common_stem."ndus";		// 未来受動分詞
		$this->supine = $common_stem."tum";							// 目的分詞
		
		// 不定詞を挿入
		// 現在形が存在する場合は
		if($this->deponent_present != Commons::$TRUE){
			$this->infinitive = $infinitive;						// 不定形
			// 受動形が存在する場合は
			if($this->deponent_mediopassive != Commons::$TRUE){
				$this->passive_infinitive = $common_stem."rī";      // 受動不定形
			}
		}

		// 完了形が存在する場合は
		if($this->deponent_present != Commons::$TRUE){
			// 能動形が存在する場合は
			if($this->deponent_active != Commons::$TRUE){
				$this->perfect_infinitive = $perfect_stem."isse";      	// 完了不定形
			}
			// 受動形が存在する場合は
			if($this->deponent_mediopassive != Commons::$TRUE){
				$this->perfect_passive_infinitive = $perfect_paticiple." ".self::auxiliary_sum;         // 完了受動不定形
			}
		}
		
		$this->future_infinitive = $this->future_participle_active." ".self::auxiliary_sum;     // 未来不定形
		$this->future_passive_infinitive = $this->future_participle_active." "."īrī";			// 未来受動不定形
	}
	
	// 動詞作成
	public function get_latin_verb($person, $voice, $mood, $aspect, $tense){

		// 非人称チェック
		if($this->deponent_personal == "1" && $person != "3sg"){
			// ハイフンを返す。
			return "-";			
		}

		// 不適切な組み合わせのチェック
		if(!$this->deponent_check($voice, $aspect)){
			// ハイフンを返す。
			return "-";		
		}

		//動詞の語幹を取得
		$verb_conjugation = "";
		if($aspect == Commons::PRESENT_ASPECT && $this->deponent_present != Commons::$TRUE){
			// 不完了形
			$verb_conjugation = $this->present_stem;
		} else if($aspect == Commons::PERFECT_ASPECT && $this->deponent_perfect != Commons::$TRUE){
			// 状態動詞
			$verb_conjugation = $this->perfect_stem;
		} else {
			// ハイフンを返す。
			return "-";
		} 
		
		//法を取得
		if($mood == Commons::INDICATIVE){
			// 相で分ける
			if($aspect == Commons::PRESENT_ASPECT && $this->deponent_present != Commons::$TRUE){
				// 進行相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->get_primary_infix($verb_conjugation, $aspect, $tense, $voice, $person, $this->ind);
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->get_ind_past($voice, $person);
				} else if($tense == Commons::FUTURE_TENSE){
					//未来形
					$verb_conjugation = $this->get_ind_future($this->present_stem, $voice, $person);
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::ACTIVE_VOICE && $this->deponent_perfect != Commons::$TRUE && $this->deponent_active != Commons::$TRUE){
				// 完了相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					// 現在形					
					$verb_conjugation = $this->get_perfect_suffix($verb_conjugation, $voice, $person, "");
				} else if($tense == Commons::PAST_TENSE){
					// 過去形
					// コピュラの呼び出し
					$verb_sum = new Latin_Verb_Sum();
					// 生成					
					$verb_conjugation = $verb_conjugation.$verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense);
				} else if($tense == Commons::FUTURE_TENSE){
					// 未来形
					$verb_conjugation = $this->get_primary_infix($verb_conjugation, $aspect, $tense, $voice, $person, self::ind_perf_future_suffix);
				} else if($tense == "future2"){
					// 未来形古形
					$verb_conjugation = $this->get_future2($voice, $person);
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_perfect != Commons::$TRUE && $this->deponent_mediopassive != Commons::$TRUE){
				// 完了相受動態
				// 未来完了のみ単純時制
				if($tense == "future2"){
					// 未来形古形
					$verb_conjugation = $this->get_future2($voice, $person);
				} else if ($tense == Commons::PRESENT_TENSE || $tense == Commons::PAST_TENSE || $tense == Commons::FUTURE_TENSE) {
					// それ以外
					// コピュラの呼び出し
					$verb_sum = new Latin_Verb_Sum();
					// 複合時制
					$verb_conjugation = $this->perfect_participle_passive." ".$verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense);
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else {
				// ハイフンを返す。
				return "-";
			}
		} else if($mood == Commons::SUBJUNCTIVE){
			// 接続法
			// 相で分ける
			if($aspect == Commons::PRESENT_ASPECT && $this->deponent_present != Commons::$TRUE){
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->get_secondary_infix($verb_conjugation, $voice, $person, $this->opt);
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->make_subj_past($voice, $person);
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::ACTIVE_VOICE && $this->deponent_perfect != Commons::$TRUE && $this->deponent_active != Commons::$TRUE){
				// 完了相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {			
					// 現在形
					// コピュラの呼び出し
					$verb_sum = new Latin_Verb_Sum();
					// 生成						
					$verb_conjugation = $verb_conjugation."er".mb_substr($verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense), 1);
				} else if($tense == "timeless"){
					// 現在形古形
					$verb_conjugation = $this->get_perfect2($person);
				} else if($tense == Commons::PAST_TENSE){
					// 過去形
					// コピュラの呼び出し
					$verb_sum = new Latin_Verb_Sum();
					// 生成										
					$verb_conjugation = $verb_conjugation."i".mb_substr($verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense), 1);
				} else {
					// ハイフンを返す。
					return "-";
				} 
			} else if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_perfect != Commons::$TRUE && $this->deponent_mediopassive != Commons::$TRUE){
				// 完了相受動態
				// コピュラの呼び出し
				$verb_sum = new Latin_Verb_Sum();
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE || $tense == Commons::PAST_TENSE) {
					//現在形
					$verb_conjugation = $this->perfect_participle_passive." ".$verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense);
				} else {
					// ハイフンを返す。
					return "-";
				} 
			} else {
				// ハイフンを返す。
				return "-";
			}
		} else if($mood == Commons::IMPERATIVE){
			// 命令形語幹を作成
			// 初期化
			$verb_conjugation = "";
            // 能動態欠如動詞・第三変化の場合は
            if(($this->verb_type == 3) && $this->deponent_present != Commons::$TRUE){
                // 一文字削って接尾辞を追加
                $verb_conjugation = mb_substr($this->infinitive, 0, -1).$this->imper;
            } else {
                // それ以外の場合は
                // 三文字削って接尾辞を追加
                $verb_conjugation = mb_substr($this->infinitive, 0, -3).$this->imper;
            }
			// 時制を分ける。
			if($tense == Commons::PRESENT_TENSE) {
				// 現在形
				$verb_conjugation = $this->get_imperative_suffix($verb_conjugation, $voice, $person);
			} else if($tense == Commons::FUTURE_TENSE){
				// 未来形
				$verb_conjugation = $this->get_future_imperative($verb_conjugation, $voice, $person);
			} else {
				// ハイフンを返す。
				return "-";
			}
		} else {
			// ハイフンを返す。
			return "-";
		}
		
		// 文字を変換
		$verb_conjugation = str_replace("cs", "x", $verb_conjugation);
		// 結果を返す。
		return $verb_conjugation;
	}
	
	// 一次語尾
	protected function get_primary_infix($verb_stem, $aspect, $tense, $voice, $person, $infix){

		// 接尾辞を追加
		$verb_stem = $verb_stem.$infix;
		// 文字列を切除
		if($this->verb_type == "1" && $tense == Commons::PRESENT_TENSE){
			// 第一活用現在形の場合
			// 人称によっては最後の文字を削除
			if($person == "1sg"){
				// 一人称単数、三人称複数
				// 最後の母音を切除
				$verb_stem  = mb_substr($verb_stem, 0, -1);
			} 
		} else if($this->verb_type == "3" || $tense != Commons::PRESENT_TENSE){
			// 第三、第四活用または現在形以外
			// 人称によっては最後の文字を削除
			if(preg_match('(1sg|3pl)', $person)){
				// 一人称単数、三人称複数
				// 最後の母音を切除
				$verb_stem  = mb_substr($verb_stem, 0, -1);
			}
		} else if($this->verb_type == "2" && $aspect == Commons::PRESENT_ASPECT){
			// 第二活用現在形の場合
			// 最後の母音を切除
			$verb_stem  = mb_substr($verb_stem, 0, -1);	
		}

		// 一人称複数、二人称単複数(未来形古形以外)
		if((preg_match('(1pl|2pl|2sg)', $person)) && $tense != "future2"){				
			$vovel = mb_substr($verb_stem, -1, 1);
			// 最後の母音を切り取って、長音を付ける
			$verb_stem  = mb_substr($verb_stem, 0, -1);
			$verb_stem = $verb_stem.Commons::vowel_short_to_long($vovel);
		}	

		// 語尾を追加
		$verb_conjugation = $this->get_primary_suffix_latin($verb_stem, $aspect, $tense, $voice, $person);
		// 結果を返す。
		return $verb_conjugation;
	}
	
	// 一次語尾
	protected function get_primary_suffix_latin($verb_stem, $aspect, $tense, $voice, $person){
		// 対象は三人称複数のみ
		if($person == "3pl") {
			// 時制と動詞クラスで分ける。
			// 現在形と未来形の1・2活用
			if($aspect == Commons::PRESENT_ASPECT && $tense == Commons::PRESENT_TENSE && ($this->verb_type== 1 || $this->verb_type== 2) && $this->deponent_present != Commons::$TRUE){
				// 態で分ける。
				if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
					// 能動態
					$verb_conjugation = $verb_stem.$this->secondary_number[$voice][$person];
				} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
					// 受動態
					$verb_conjugation = $verb_stem.$this->secondary_number[$voice][$person];
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else if($aspect == Commons::PERFECT_ASPECT && ($tense == Commons::FUTURE_TENSE || $tense == "future2") && $this->deponent_perfect != Commons::$TRUE){
				// 態で分ける。
				if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
					// 能動態
					$verb_conjugation = $verb_stem."i".$this->secondary_number[$voice][$person];
				} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
					// 受動態(古形のみ)
					$verb_conjugation = $verb_stem."i".$this->secondary_number[$voice][$person];				
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else {
				// それ以外は親クラスを呼び出す
				$verb_conjugation = $this->get_primary_suffix($verb_stem, $voice, $person);			
			}
		} else {
			// それ以外は親クラスを呼び出す
			$verb_conjugation = $this->get_primary_suffix($verb_stem, $voice, $person);
		}
		// 結果を返す。
		return $verb_conjugation;
	}
	
	// 二次語尾
	protected function get_secondary_infix($verb_stem, $voice, $person, $infix){	
		// 接尾辞を追加
		$verb_conjugation = $verb_stem.$infix;
		// 一人称複数、二人称単複数
		if(preg_match('/(1pl|2pl|2sg)/', $person)){
			// 最後の母音を切り取って、長音を付ける
			$vovel = mb_substr($verb_conjugation, -1, 1);
			$verb_conjugation  = mb_substr($verb_conjugation, 0, -1);
			$verb_conjugation = $verb_conjugation.Commons::vowel_short_to_long($vovel);
		}
		// 語尾を追加
		$verb_conjugation = $this->get_secondary_suffix($verb_conjugation, $voice, $person);
		// 結果を返す。
		return $verb_conjugation;
	}

	// 直接法過去を作成
	protected function get_ind_past($voice, $person){
		// 第三、第四活用以外の過去形
		if(preg_match('/(1|2|5eo)/', $this->verb_type)){
			// 接尾辞を追加
			$verb_conjugation = $this->get_verb_root($this->infinitive);
		} else if(preg_match('/(3|3a|4|5fio|5volo|5fer)/', $this->verb_type)){
			// 第三・第四活用
			// 接尾辞を追加
			$verb_conjugation = $this->present_stem."ē";
		} else {
			// ハイフンを返す。
			return "-";			
		}

		// 結果を返す。
		return $this->get_secondary_infix($verb_conjugation, $voice, $person, self::past_ind_infix);
	}

	// 接続法過去を作成
	protected function make_subj_past($voice, $person){			
		// 過去形を生成
		$past_tense = $this->get_secondary_infix($this->infinitive, $voice, $person, "");
		// 結果を返す。
		return $past_tense;
	}	

	// 完了形古形
	private function get_perfect2($person){
		// 初期化
		$sigmatic_aorist_stem = mb_substr($this->perfect_participle_passive, 0, -3);
		// 活用種別によって語幹と接尾辞を分ける。		
		// 条件分岐
		if(preg_match('/tus/', $this->perfect_participle_passive)){
			$sigmatic_aorist_stem = mb_substr($this->perfect_participle_passive, 0, -3)."s";
		}
		// コピュラの呼び出し
		$verb_sum = new Latin_Verb_Sum();		
		// 結果を返す。
		return $sigmatic_aorist_stem.$verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, Commons::SUBJUNCTIVE, Commons::PRESENT_ASPECT, Commons::PRESENT_TENSE);
	}
	
	// 未来形
	protected function get_ind_future($verb_stem, $voice, $person){
		// 動詞の活用種別で分ける
		if(preg_match('/(1|2|5eo)$/', $this->verb_type)){
			// 語幹を生成
			$verb_stem = $this->get_verb_root($this->infinitive);
			// 未来形を生成			
			$verb_stem = $this->get_primary_infix($verb_stem, Commons::PRESENT_ASPECT, Commons::FUTURE_TENSE, $voice, $person, self::ind_future_suffix);
		} else if(preg_match('/(3|3a|4|5fio|5volo|5fer)$/', $this->verb_type)){			
			// 第三・第四活用
			// 接中辞
			$future_infix = "";			
			// 人称によって分ける
			if($person == "1sg"){
				// 1人称単数
				$future_infix = "a";
			} else {
				// それ以外
				$future_infix = $this->subj;
			}
			// 語尾を追加
			$verb_stem = $this->get_secondary_infix($verb_stem, $voice, $person, $future_infix);	
		} else if($this->verb_type == "5sum"){
			// 処理を実行する
			$verb_stem = $this->get_primary_infix($verb_stem, Commons::PRESENT_ASPECT, Commons::FUTURE_TENSE, $voice, $person, self::ind_perf_future_suffix);
		}  

		// 結果を返す。
		return $verb_stem;
	}

	// 未来形2
	private function get_future2($voice, $person){
		// 未来形古形
		// 活用種別によって語幹と接尾辞を分ける。
		$s_future_suffix = "";
		$s_future_stem = "";
		// 条件分岐
		if(preg_match('/tus/', $this->perfect_participle_passive)){
			// -tusの場合
			$s_future_suffix = self::s_future_suffix;
			$s_future_stem = mb_substr($this->perfect_participle_passive, 0, -3);
		} else if(preg_match('(sus|sum)', $this->perfect_participle_passive)){
			// -susの場合
			$s_future_suffix = self::s_future_suffix2;
			$s_future_stem = mb_substr($this->perfect_participle_passive, 0, -3);			
		} else {
			// ハイフンを返す。
			return "-";
		}

		// 結果を返す。
		return $this->get_primary_infix($s_future_stem, Commons::PERFECT_ASPECT, "future2", $voice, $person, $s_future_suffix);
	}
	
	// 未来命令語尾
	protected function get_future_imperative($verb_conjugation, $voice, $person){
		// 命令法
		// 語尾を取得
		if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 能動態単数
			$imperative_form = $verb_conjugation.$this->imperative_future_number[$voice][$person];
		} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
			// 中受動態単数
			$imperative_form = $verb_conjugation.$this->imperative_future_number[$voice][$person];
		} else {
			// ハイフンを返す。
			return "-";
		}
		// 結果を返す。
		return $imperative_form;
	}

	// 分詞の曲用表を返す。	
	protected function get_participle($participle_stem){
		// 読み込み
		$adj_latin = new Latin_Adjective($participle_stem);
		// 結果を返す。
		return $adj_latin->get_chart();
	}

	// 通常変化部分の動詞の活用を作成する。
	protected function make_common_standard_verb_conjugation($conjugation){

		// 配列を作成
		$voice_array = array(Commons::ACTIVE_VOICE, Commons::MEDIOPASSIVE_VOICE);						//態
		$tense_array = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE, Commons::FUTURE_TENSE);	//時制
		$mood_array = array(Commons::INDICATIVE, Commons::SUBJUNCTIVE, Commons::IMPERATIVE);			//法
		$person_array = array("1sg", "2sg", "3sg", "1pl", "2pl", "3pl");								//人称

		// 活用表を挿入(現在相)
		// 全ての態
		foreach ($voice_array as $voice){
			// 全ての時制			
			foreach ($tense_array as $tense){
				// 全ての法			
				foreach ($mood_array as $mood){
					// 全ての人称			
					foreach ($person_array as $person){
						// 態・時制・法・人称に応じて多次元配列を作成		
						$conjugation[$voice][$tense][$mood][$person] = $this->get_latin_verb($person, $voice, $mood, Commons::PRESENT_ASPECT, $tense);						
					}
				}
			}
		}

		// 活用表を挿入(完了相)
		// 全ての態
		foreach ($voice_array as $voice){
			// 全ての完了時制			
			foreach ($tense_array as $tense){
				// 全ての法			
				foreach ($mood_array as $mood){
					// 全ての人称			
					foreach ($person_array as $person){
						// 態・時制・法・人称に応じて多次元配列を作成		
						$conjugation[$voice][$tense."_".Commons::PERFECT_ASPECT][$mood][$person] = $this->get_latin_verb($person, $voice, $mood, Commons::PERFECT_ASPECT, $tense);						
					}
				}
			}
		}

		// 結果を返す。
		return $conjugation;
	}

	// 活用表を取得する。
	public function get_chart(){

		// 初期化
		$conjugation = array();
		// タイトル情報を挿入
		$conjugation["title"] = $this->get_title($this->infinitive);
		// 辞書見出しを入れる。
		$conjugation["dic_title"] = $this->infinitive;
		// 種別を入れる。
		$conjugation["category"] = "動詞";
		// 活用種別
		$conjugation["type"] = $this->class_name;
		// 共通変化部分の動詞の活用を取得
		$conjugation = $this->make_common_standard_verb_conjugation($conjugation);
		// 能動態完了相を入れる。
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1sg"] = $this->get_latin_verb("1sg", Commons::ACTIVE_VOICE, Commons::INDICATIVE, Commons::PERFECT_ASPECT, "future2");
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2sg"] = $this->get_latin_verb("2sg", Commons::ACTIVE_VOICE, Commons::INDICATIVE, Commons::PERFECT_ASPECT, "future2");
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3sg"] = $this->get_latin_verb("3sg", Commons::ACTIVE_VOICE, Commons::INDICATIVE, Commons::PERFECT_ASPECT, "future2");
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1pl"] = $this->get_latin_verb("1pl", Commons::ACTIVE_VOICE, Commons::INDICATIVE, Commons::PERFECT_ASPECT, "future2");
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2pl"] = $this->get_latin_verb("2pl", Commons::ACTIVE_VOICE, Commons::INDICATIVE, Commons::PERFECT_ASPECT, "future2");
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3pl"] = $this->get_latin_verb("3pl", Commons::ACTIVE_VOICE, Commons::INDICATIVE, Commons::PERFECT_ASPECT, "future2");
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["1sg"] = $this->get_latin_verb("1sg", Commons::ACTIVE_VOICE, Commons::SUBJUNCTIVE, Commons::PERFECT_ASPECT, "timeless");
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["2sg"] = $this->get_latin_verb("2sg", Commons::ACTIVE_VOICE, Commons::SUBJUNCTIVE, Commons::PERFECT_ASPECT, "timeless");
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["3sg"] = $this->get_latin_verb("3sg", Commons::ACTIVE_VOICE, Commons::SUBJUNCTIVE, Commons::PERFECT_ASPECT, "timeless");
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["1pl"] = $this->get_latin_verb("1pl", Commons::ACTIVE_VOICE, Commons::SUBJUNCTIVE, Commons::PERFECT_ASPECT, "timeless");
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["2pl"] = $this->get_latin_verb("2pl", Commons::ACTIVE_VOICE, Commons::SUBJUNCTIVE, Commons::PERFECT_ASPECT, "timeless");
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["3pl"] = $this->get_latin_verb("3pl", Commons::ACTIVE_VOICE, Commons::SUBJUNCTIVE, Commons::PERFECT_ASPECT, "timeless");
		// 能動態完了相を入れる。
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1sg"] = $this->get_latin_verb("1sg", Commons::MEDIOPASSIVE_VOICE, Commons::INDICATIVE, Commons::PERFECT_ASPECT, "future2");
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2sg"] = $this->get_latin_verb("2sg", Commons::MEDIOPASSIVE_VOICE, Commons::INDICATIVE, Commons::PERFECT_ASPECT, "future2");
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3sg"] = $this->get_latin_verb("3sg", Commons::MEDIOPASSIVE_VOICE, Commons::INDICATIVE, Commons::PERFECT_ASPECT, "future2");
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1pl"] = $this->get_latin_verb("1pl", Commons::MEDIOPASSIVE_VOICE, Commons::INDICATIVE, Commons::PERFECT_ASPECT, "future2");
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2pl"] = $this->get_latin_verb("2pl", Commons::MEDIOPASSIVE_VOICE, Commons::INDICATIVE, Commons::PERFECT_ASPECT, "future2");
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3pl"] = $this->get_latin_verb("3pl", Commons::MEDIOPASSIVE_VOICE, Commons::INDICATIVE, Commons::PERFECT_ASPECT, "future2");

		// 分詞を挿入
		$conjugation["present_active"] = $this->get_participle($this->present_participle_active);	// 不完了体能動分詞
		$conjugation["perfect_passive"] = $this->get_participle($this->perfect_participle_passive);	// 状態動詞受動分詞
		$conjugation["future_active"] = $this->get_participle($this->future_participle_active);		// 未来能動分詞
		$conjugation["future_passive"] = $this->get_participle($this->future_participle_passive);	// 未来受動分詞
		$conjugation["supine"] = $this->get_participle($this->supine);								// 目的分詞
		
		// 不定詞を挿入
		$conjugation["infinitive"]["present_active"] = $this->infinitive;						// 不定形
		$conjugation["infinitive"]["present_passive"] = $this->passive_infinitive;			// 受動不定形
		// 完了形がある場合は挿入する。
		if($this->deponent_perfect != Commons::$TRUE){
			$conjugation["infinitive"]["perfect_active"] = $this->perfect_infinitive;				// 完了不定形
			$conjugation["infinitive"]["perfect_passive"] = $this->perfect_passive_infinitive;	// 完了受動不定形
		} else if($this->deponent_perfect == "1") {
			$conjugation["infinitive"]["perfect_active"] = "-";	// 完了不定形
			$conjugation["infinitive"]["perfect_passive"] = "-";	// 完了受動不定形
		}

		$conjugation["infinitive"]["future_active"] = $this->future_infinitive;				// 未来不定形
		$conjugation["infinitive"]["future_passive"] = $this->future_passive_infinitive;		// 未来受動不定形		

		// 結果を返す。
		return $conjugation;
	}

	// 特定の活用を取得する(ない場合はランダム)。
	public function get_conjugation_form_by_each_condition($person = "", $voice = "", $mood = "", $aspect = "", $tense = ""){

		// 態がない場合
		if($voice == ""){
			// 欠如動詞対応
			if($this->deponent_active != Commons::$TRUE){
				// 能動態なし
				$ary = array(Commons::MEDIOPASSIVE_VOICE);
			} else if($this->deponent_mediopassive != Commons::$TRUE){
				// 受動態なし
				$ary = array(Commons::ACTIVE_VOICE);
			} else {
				// それ以外
				$ary = array(Commons::ACTIVE_VOICE, Commons::MEDIOPASSIVE_VOICE);	// 初期化
			}	
			// 能動態・受動態の中からランダムで選択	
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$voice = $ary[$key];			
		}
		// 法がない場合
		if($mood == ""){
			// 全ての性別の中からランダムで選択
			$ary = array(Commons::INDICATIVE, Commons::SUBJUNCTIVE, Commons::IMPERATIVE);	// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$mood = $ary[$key];			
		}	

		// 相がない場合
		if($aspect == ""){
			// 命令形とそれ以外で分ける。
			if($mood == Commons::IMPERATIVE){
				// 命令法
				$ary = array(Commons::PRESENT_ASPECT);	
			} else {
				// それ以外
				// 欠如動詞対応
				if($this->deponent_present != Commons::$TRUE){
					// 現在形なし
					$ary = array(Commons::PERFECT_ASPECT);	
				} else if($this->deponent_perfect != Commons::$TRUE){
					// 完了形なし
					$ary = array(Commons::PRESENT_ASPECT);	
				} else {
					// それ以外
					$ary = array(Commons::PRESENT_ASPECT, Commons::PERFECT_ASPECT);	
				}
			}
			// 全ての相の中からランダムで選択
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$aspect = $ary[$key];			
		}

		// 時制がない場合
		if($tense == ""){
			// 直接法・接続法・命令法で分ける。
			if($mood == Commons::IMPERATIVE){
				// 命令法
				$ary = array(Commons::PRESENT_TENSE, Commons::FUTURE_TENSE);	// 初期化
			} else if($mood == Commons::SUBJUNCTIVE){
				// 接続法
				$ary = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE);		// 初期化
			} else {
				// それ以外(直接法)
				$ary = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE, Commons::FUTURE_TENSE);	// 初期化
			}		
			// 全ての時制の中からランダムで選択
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$tense = $ary[$key];			
		}	
		
		// 人称と数がない場合は
		if($person == ""){
			// 命令形とそれ以外で分ける。
			if($mood == Commons::IMPERATIVE && $tense == Commons::PRESENT_TENSE){
				// 現在命令
				$ary = array("2sg", "3sg", "2pl", "3pl"); // 初期化
			} else if($mood == Commons::IMPERATIVE && $tense == Commons::FUTURE_TENSE){
				// 未来命令
				$ary = array("2sg", "3sg", "2pl", "3pl"); // 初期化	
			} else {
				// それ以外
				$ary = array("1sg", "2sg", "3sg", "1pl", "2pl", "3pl"); // 初期化
			}
			// 全ての人称からランダムで選択
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$person = $ary[$key];			
		}


		// 配列に格納
		$question_data = array();
		$question_data['question_sentence'] = $this->get_title($this->infinitive)."の".$aspect." ".$tense." ".$mood." ".$voice." ".$person."を答えよ";				
		$question_data['answer'] = $this->get_latin_verb($person, $voice, $mood, $aspect, $tense);
		$question_data['question_sentence2'] = $question_data['answer']."の時制、法、態と人称を答えよ。";
		$question_data['aspect'] = $aspect;
		$question_data['tense'] = $tense;	
		$question_data['mood'] = $mood;
		$question_data['voice'] = $voice;
		$question_data['person'] = $person;			

		// 結果を返す。
		return $question_data;
	}

}

class Latin_Verb_Sum extends Latin_Verb {

	// 現在形人称
	protected $present_number = 
	[		
		"active" => 
		[
			"1sg" => "sum",
			"2sg" => "es", 
			"3sg" => "est",
			"1pl" => "sumus",
			"2pl" => "estis", 
			"3pl" => "sunt",	
		],
	];
	
	// 活用種別
	protected $class = "5sum";
	
	// 不定形
	protected $infinitive = "esse";
	// 完了不定形
	protected $perfect_infinitive = "fuisse";
	// 未来不定形
	protected $future_infinitive = "futūrum esse";
	// 不完了体能動分詞
	protected $present_participle_active = "sōns";
	// 未来能動分詞			
	protected $future_participle_active = "futūrus";		
	// 追加語幹
	protected $added_stem = "";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
		// 親の呼び出し
    	parent::__construct("es", $this->infinitive, "fu", "futus");
    }

	// esseの派生動詞に対応
	public function add_stem($verb){
		// 派生部分を取得
		$this->added_stem = mb_substr($verb, 0, -4);
		// 変更がなければ、ここで処理を中断する。
		if($this->added_stem == ""){
			return;
		}
		// 語幹を変更
		$this->present_stem = $this->added_stem.$this->present_stem;								// 現在形
		$this->aorist_stem = $this->added_stem.$this->aorist_stem;									// 完了形
		$this->perfect_stem = $this->added_stem.$this->perfect_stem;								// 完了形

		// 分詞を挿入
		$this->present_participle_active = $this->added_stem.$this->present_participle_active;		// 不完了体能動分詞
		$this->perfect_participle_passive = $this->added_stem.$this->perfect_participle_passive;	// 状態動詞受動分詞
		$this->future_participle_active = $this->added_stem.$this->future_participle_active;		// 未来能動分詞
		$this->future_participle_passive = $this->added_stem.$this->future_participle_passive;		// 未来受動分詞
		$this->supine = $this->added_stem.$this->supine;											// 目的分詞
		
		// 不定詞を挿入
		$this->infinitive = $this->added_stem.$this->infinitive;									// 不定形
		$this->passive_infinitive = $this->added_stem.$this->passive_infinitive;                    // 受動不定形
		$this->perfect_infinitive = $this->added_stem.$this->perfect_infinitive;                    // 完了不定形
		$this->perfect_passive_infinitive = $this->added_stem.$this->perfect_passive_infinitive;    // 完了受動不定形
		$this->future_infinitive = $this->added_stem.$this->future_infinitive;          			// 未来不定形
		$this->future_passive_infinitive = $this->added_stem.$this->future_passive_infinitive;		// 未来受動不定形
		// 情報を更新
		$this->get_add_info($this->infinitive);		
	}

	
	// 動詞作成
	public function get_latin_verb($person, $voice, $mood, $aspect, $tense){

		// 初期化
		$verb_conjugation = "";

		// 中動態は処理しない。
		if($voice == Commons::MEDIOPASSIVE_VOICE){
			// ハイフンを返す。
			return "-";			
		}

		// 法を取得
		if($mood == Commons::INDICATIVE){
			// 相で分ける
			if($aspect == Commons::PRESENT_ASPECT){
				// 進行相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->added_stem.$this->present_number[Commons::ACTIVE_VOICE][$person];
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->get_secondary_infix($this->added_stem, Commons::ACTIVE_VOICE, $person, self::ind_perf_past_suffix);
				} else if($tense == Commons::FUTURE_TENSE){
					//未来形
					$verb_conjugation = $this->get_ind_future($this->added_stem, Commons::ACTIVE_VOICE, $person);
				}
			} else if($aspect == Commons::PERFECT_ASPECT){
				// 完了相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->perfect_stem.$this->perfect_number[Commons::ACTIVE_VOICE][$person];
				} else if($tense == Commons::PAST_TENSE){
					// 過去形
					// コピュラの呼び出し
					$verb_sum = new Latin_Verb_Sum();
					// 生成					
					$verb_conjugation = $this->perfect_stem.$verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense);
				} else if($tense == Commons::FUTURE_TENSE){
					//未来形
					$verb_conjugation = $this->get_primary_infix($this->perfect_stem, $aspect, $tense, Commons::ACTIVE_VOICE, $person, self::ind_perf_future_suffix);
				}
			} else {
				// ハイフンを返す。
				return "-";
			} 
		} else if($mood == Commons::SUBJUNCTIVE){
			// 接続法
			// 相で分ける
			if($aspect == Commons::PRESENT_ASPECT){
				// 進行相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->get_secondary_infix($this->added_stem."si", Commons::ACTIVE_VOICE, $person, "");
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->get_secondary_infix($this->present_stem, Commons::ACTIVE_VOICE, $person, "se");
				}
			} else if($aspect == Commons::PERFECT_ASPECT){
				// コピュラの呼び出し
				$verb_sum = new Latin_Verb_Sum();				
				// 完了相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					// 現在形				
					$verb_conjugation = $this->perfect_stem."er".mb_substr($verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense), 1);
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->perfect_stem."i".mb_substr($verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense), 1);
				} 
			} else {
				// ハイフンを返す。
				return "-";
			} 
		} else if($mood = Commons::IMPERATIVE){
			// 時制を分ける。
			if($tense == Commons::PRESENT_TENSE) {
				// 命令法
				$verb_conjugation = $this->get_imperative_suffix($this->present_stem, Commons::ACTIVE_VOICE, $person);
			} else if($tense == Commons::FUTURE_TENSE){
				//未来形
				$verb_conjugation = $this->get_future_imperative($this->present_stem, Commons::ACTIVE_VOICE, $person);
			}
		} else {
			// ハイフンを返す。
			return "-";
		} 	
		// 結果を返す。
		return $verb_conjugation;
	}	
	
	// 活用表を取得する。
	public function get_chart(){
		// 初期化
		$conjugation = array();
		// タイトル情報を挿入
		$conjugation["title"] = $this->get_title($this->infinitive);
		// 辞書見出しを入れる。
		$conjugation["dic_title"] = $this->infinitive;
		// 種別を入れる。
		$conjugation["category"] = "動詞";
		// 活用種別
		$conjugation["type"] = $this->class_name;
		
		// 共通変化部分の動詞の活用を取得
		$conjugation = $this->make_common_standard_verb_conjugation($conjugation);

		// 能動態を入れる。
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["1sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["2sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["3sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["1pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["2pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["3pl"] = "-";
		// 受動態を入れる。
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1sg"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2sg"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3sg"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1pl"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2pl"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3pl"] = "-";

		// 分詞を挿入
		$conjugation["present_active"] = $this->get_participle($this->present_participle_active);	// 不完了体能動分詞
		$conjugation["perfect_passive"] = $this->get_participle($this->perfect_participle_passive);	// 状態動詞受動分詞
		$conjugation["future_active"] = $this->get_participle($this->future_participle_active);		// 未来能動分詞
		$conjugation["future_passive"] = $this->get_participle($this->future_participle_passive);	// 未来受動分詞
		$conjugation["supine"] = $this->get_participle($this->supine);								// 目的分詞
		
		// 不定詞を挿入
		$conjugation["infinitive"]["present_active"] = $this->infinitive;					// 不定形
		$conjugation["infinitive"]["present_passive"] = "-";								// 受動不定形
		$conjugation["infinitive"]["perfect_active"] = $this->perfect_infinitive;			// 完了不定形
		$conjugation["infinitive"]["perfect_passive"] = "-";								// 完了受動不定形

		$conjugation["infinitive"]["future_active"] = $this->future_infinitive;				// 未来不定形
		$conjugation["infinitive"]["future_passive"] = "-";									// 未来受動不定形

		// 結果を返す。
		return $conjugation;
	}

}

class Latin_Verb_Fio extends Latin_Verb {
	
	// 活用種別
	protected $class = "5fio";
	
	// 不定形
	protected $infinitive = "fierī";
	// 完了不定形
	protected $perfect_infinitive = "fuisse";
	// 未来不定形
	protected $future_infinitive = "futūrum esse";

	// 未来能動分詞
	protected $future_participle_active = "futūrus";

	// 追加語幹
	protected $added_stem = "";

	// 希求法→接続法
	protected $opt = "a";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
		// 親の呼び出し
    	parent::__construct("fi", $this->infinitive, "fu", "futus");
    }

	// esseの派生動詞に対応
	public function add_stem($verb){
		// 派生部分を取得
		$this->added_stem = mb_substr($verb, 0, -5);
		// 変更がなければ、ここで処理を中断する。
		if($this->added_stem == ""){
			return;
		}
		// 語幹を変更
		$this->present_stem = $this->added_stem.$this->present_stem;								// 現在形
		$this->aorist_stem = $this->added_stem.$this->aorist_stem;									// 完了形
		$this->perfect_stem = $this->added_stem.$this->perfect_stem;								// 完了形

		// 分詞を挿入
		$this->present_participle_active = $this->added_stem.$this->present_participle_active;		// 不完了体能動分詞
		$this->perfect_participle_passive = $this->added_stem.$this->perfect_participle_passive;	// 状態動詞受動分詞
		$this->future_participle_active = $this->added_stem.$this->future_participle_active;		// 未来能動分詞
		$this->future_participle_passive = $this->added_stem.$this->future_participle_passive;		// 未来受動分詞
		$this->supine = $this->added_stem.$this->supine;											// 目的分詞
		
		// 不定詞を挿入
		$this->infinitive = $this->added_stem.$this->infinitive;									// 不定形
		$this->passive_infinitive = $this->added_stem.$this->passive_infinitive;                    // 受動不定形
		$this->perfect_infinitive = $this->added_stem.$this->perfect_infinitive;                    // 完了不定形
		$this->perfect_passive_infinitive = $this->added_stem.$this->perfect_passive_infinitive;    // 完了受動不定形
		$this->future_infinitive = $this->added_stem.$this->future_infinitive;          			// 未来不定形
		$this->future_passive_infinitive = $this->added_stem.$this->future_passive_infinitive;		// 未来受動不定形
		// 情報を更新
		$this->get_add_info($this->infinitive);		
	}

	
	// 動詞作成
	public function get_latin_verb($person, $voice, $mood, $aspect, $tense){		

		// 中動態は処理しない。
		if($voice == Commons::MEDIOPASSIVE_VOICE){
			// ハイフンを返す。
			return "-";			
		}

		// 初期化
		$verb_conjugation = "";
		// 法を取得
		if($mood == Commons::INDICATIVE){
			// 相で分ける
			if($aspect == Commons::PRESENT_ASPECT){
				// 進行相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->get_primary_infix($this->present_stem, $aspect, $tense, Commons::ACTIVE_VOICE, $person, $this->ind);
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->get_ind_past(Commons::ACTIVE_VOICE, $person);
				} else if($tense == Commons::FUTURE_TENSE){
					//未来形
					$verb_conjugation = $this->get_ind_future($this->present_stem, Commons::ACTIVE_VOICE, $person);
				}
			} else if($aspect == Commons::PERFECT_ASPECT){
				// 完了相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->perfect_stem.$this->perfect_number[Commons::ACTIVE_VOICE][$person];
				} else if($tense == Commons::PAST_TENSE){
					// 過去形
					// コピュラの呼び出し
					$verb_sum = new Latin_Verb_Sum();
					// 生成					
					$verb_conjugation = $this->perfect_stem.$verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense);
				} else if($tense == Commons::FUTURE_TENSE){
					//未来形
					$verb_conjugation = $this->get_primary_infix($this->perfect_stem, $aspect, $tense, Commons::ACTIVE_VOICE, $person, self::ind_perf_future_suffix);
				}
			}
		} else if($mood == Commons::SUBJUNCTIVE){
			// 接続法
			// 相で分ける
			if($aspect == Commons::PRESENT_ASPECT){
				// 進行相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->get_secondary_infix($this->present_stem, Commons::ACTIVE_VOICE, $person, $this->opt);
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->get_secondary_infix($this->present_stem, $voice, $person, "ere");
				}
			} else if($aspect == Commons::PERFECT_ASPECT){
				// コピュラの呼び出し
				$verb_sum = new Latin_Verb_Sum();				
				// 完了相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					// 現在形				
					$verb_conjugation = $this->perfect_stem."er".mb_substr($verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense), 1);
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->perfect_stem."i".mb_substr($verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense), 1);
				} 
			}
		} else if($mood = Commons::IMPERATIVE){
			// 時制を分ける。
			if($tense == Commons::PRESENT_TENSE) {
				// 命令法
				$verb_conjugation = $this->get_imperative_suffix($this->present_stem, Commons::ACTIVE_VOICE, $person);
			} else if($tense == Commons::FUTURE_TENSE){
				//未来形
				$verb_conjugation = $this->get_future_imperative($this->present_stem, Commons::ACTIVE_VOICE, $person);
			}
		}	
		// 結果を返す。
		return $verb_conjugation;
	}	
	
	// 活用表を取得する。
	public function get_chart(){
		// 初期化
		$conjugation = array();
		// タイトル情報を挿入
		$conjugation["title"] = $this->get_title($this->infinitive);
		// 辞書見出しを入れる。
		$conjugation["dic_title"] = $this->infinitive;
		// 種別を入れる。
		$conjugation["category"] = "動詞";
		// 活用種別
		$conjugation["type"] = $this->class_name;
		
		// 共通変化部分の動詞の活用を取得
		$conjugation = $this->make_common_standard_verb_conjugation($conjugation);

		// 能動態を入れる。
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["1sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["2sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["3sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["1pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["2pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["3pl"] = "-";
		// 受動態を入れる。
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1sg"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2sg"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3sg"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1pl"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2pl"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3pl"] = "-";

		// 分詞を挿入
		$conjugation["present_active"] = $this->get_participle($this->present_participle_active);	// 不完了体能動分詞
		$conjugation["perfect_passive"] = $this->get_participle($this->perfect_participle_passive);	// 状態動詞受動分詞
		$conjugation["future_active"] = $this->get_participle($this->future_participle_active);		// 未来能動分詞
		$conjugation["future_passive"] = $this->get_participle($this->future_participle_passive);	// 未来受動分詞
		$conjugation["supine"] = $this->get_participle($this->supine);								// 目的分詞
		
		// 不定詞を挿入
		$conjugation["infinitive"]["present_active"] = $this->infinitive;					// 不定形
		$conjugation["infinitive"]["present_passive"] = "-";								// 受動不定形
		$conjugation["infinitive"]["perfect_active"] = $this->perfect_infinitive;			// 完了不定形
		$conjugation["infinitive"]["perfect_passive"] = "-";								// 完了受動不定形

		$conjugation["infinitive"]["future_active"] = $this->future_infinitive;				// 未来不定形
		$conjugation["infinitive"]["future_passive"] = "-";									// 未来受動不定形

		// 結果を返す。
		return $conjugation;
	}

}

class Latin_Verb_Volo extends Latin_Verb {

	// 現在形人称
	protected $present_number = 
	[		
		"active" => 
		[
			"1sg" => "volō",
			"2sg" => "vīs", 
			"3sg" => "vult",
			"1pl" => "volumus",
			"2pl" => "vultis", 
			"3pl" => "volunt",	
		],
	];
	
	// 活用種別
	protected $class = "5volo";
	
	// 不定形
	protected $infinitive = "velle";
	// 完了不定形
	protected $perfect_infinitive = "voluisse";

	// 不完了体能動分詞
	protected $present_participle_active = "volēns";

	// 追加語幹
	protected $added_stem = "";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
		// 親の呼び出し
    	parent::__construct("vol", "velle", "volu", "");
    }

	// esseの派生動詞に対応
	public function add_stem($verb){
		// 派生部分を取得
		//$this->added_stem = mb_substr($verb, 0, -3);

		// 語幹を変更
		$this->present_stem = $this->added_stem.$this->present_stem;								// 現在形
		$this->aorist_stem = $this->added_stem.$this->aorist_stem;									// 完了形
		$this->perfect_stem = $this->added_stem.$this->perfect_stem;								// 完了形

		// 分詞を挿入
		$this->present_participle_active = $this->added_stem.$this->present_participle_active;		// 不完了体能動分詞
		
		// 不定詞を挿入
		$this->infinitive = $this->added_stem.$this->infinitive;									// 不定形
		$this->perfect_infinitive = $this->added_stem.$this->perfect_infinitive;                    // 完了不定形
	}

	
	// 動詞作成
	public function get_latin_verb($person, $voice, $mood, $aspect, $tense){

		// 中動態は処理しない。
		if($voice == Commons::MEDIOPASSIVE_VOICE){
			// ハイフンを返す。
			return "-";			
		}

		// 初期化
		$verb_conjugation = "";
		// 法を取得
		if($mood == Commons::INDICATIVE){
			// 相で分ける
			if($aspect == Commons::PRESENT_ASPECT){
				// 進行相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->added_stem.$this->present_number[Commons::ACTIVE_VOICE][$person];
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->get_ind_past(Commons::ACTIVE_VOICE, $person);
				} else if($tense == Commons::FUTURE_TENSE){
					//未来形
					$verb_conjugation = $this->get_ind_future($this->present_stem, Commons::ACTIVE_VOICE, $person);
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else if($aspect == Commons::PERFECT_ASPECT){
				// 完了相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->perfect_stem.$this->perfect_number[Commons::ACTIVE_VOICE][$person];
				} else if($tense == Commons::PAST_TENSE){
					// 過去形
					// コピュラの呼び出し
					$verb_sum = new Latin_Verb_Sum();
					// 生成					
					$verb_conjugation = $this->perfect_stem.$verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense);
				} else if($tense == Commons::FUTURE_TENSE){
					//未来形
					$verb_conjugation = $this->get_primary_infix($this->perfect_stem, $aspect, $tense, Commons::ACTIVE_VOICE, $person, self::ind_perf_future_suffix);
				} else {
					// ハイフンを返す。
					return "-";
				}
			}
		} else if($mood == Commons::SUBJUNCTIVE){
			// 接続法
			// 相で分ける
			if($aspect == Commons::PRESENT_ASPECT){
				// 進行相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->get_secondary_infix($this->added_stem."veli", Commons::ACTIVE_VOICE, $person, "");
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->get_secondary_infix("velli", Commons::ACTIVE_VOICE, $person, "");
				}
			} else if($aspect == Commons::PERFECT_ASPECT){
				// コピュラの呼び出し
				$verb_sum = new Latin_Verb_Sum();				
				// 完了相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					// 現在形				
					$verb_conjugation = $this->perfect_stem."er".mb_substr($verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense), 1);
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->perfect_stem."i".mb_substr($verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense), 1);
				} else {
					// ハイフンを返す。
					return "-";
				} 
			}
		} else if($mood = Commons::IMPERATIVE){
			// 命令法
			$verb_conjugation = $this->present_stem.$this->imper;
			// 時制を分ける。
			if($tense == Commons::PRESENT_TENSE) {
				// 現在形
				$verb_conjugation = $this->get_imperative_suffix($verb_conjugation, $voice, $person);
			} else if($tense == Commons::FUTURE_TENSE){
				// 未来形
				$verb_conjugation = $this->get_future_imperative($verb_conjugation, $voice, $person);
			} else {
				// ハイフンを返す。
				return "-";
			}
		} else {
			// それ以外はハイフン
			return "-";
		}
		// 結果を返す。
		return $verb_conjugation;
	}

	// 活用表を取得する。
	public function get_chart(){
		// 初期化
		$conjugation = array();
		// タイトル情報を挿入
		$conjugation["title"] = $this->get_title($this->infinitive);
		// 辞書見出しを入れる。
		$conjugation["dic_title"] = $this->infinitive;
		// 種別を入れる。
		$conjugation["category"] = "動詞";
		// 活用種別
		$conjugation["type"] = $this->class_name;
		
		// 共通変化部分の動詞の活用を取得
		$conjugation = $this->make_common_standard_verb_conjugation($conjugation);

		// 能動態を入れる。
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["1sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["2sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["3sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["1pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["2pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["3pl"] = "-";
		// 受動態を入れる。
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1sg"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2sg"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3sg"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1pl"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2pl"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3pl"] = "-";

		// 分詞を挿入
		$conjugation["present_active"] = $this->get_participle($this->present_participle_active);	// 不完了体能動分詞
		$conjugation["perfect_passive"] = $this->get_participle($this->perfect_participle_passive);	// 状態動詞受動分詞
		$conjugation["future_active"] = $this->get_participle($this->future_participle_active);		// 未来能動分詞
		$conjugation["future_passive"] = $this->get_participle($this->future_participle_passive);	// 未来受動分詞
		$conjugation["supine"] = $this->get_participle($this->supine);								// 目的分詞
		
		// 不定詞を挿入
		$conjugation["infinitive"]["present_active"] = $this->infinitive;					// 不定形
		$conjugation["infinitive"]["present_passive"] = "-";								// 受動不定形
		$conjugation["infinitive"]["perfect_active"] = $this->perfect_infinitive;			// 完了不定形
		$conjugation["infinitive"]["perfect_passive"] = "-";								// 完了受動不定形

		$conjugation["infinitive"]["future_active"] = $this->future_infinitive;				// 未来不定形
		$conjugation["infinitive"]["future_passive"] = "-";									// 未来受動不定形

		// 結果を返す。
		return $conjugation;
	}

}

class Latin_Verb_Fero extends Latin_Verb {

	// 現在形人称
	protected $present_number = 
	[		
		"active" => 
		[
			"1sg" => "ferō",
			"2sg" => "fers", 
			"3sg" => "fert",
			"1pl" => "ferimus",
			"2pl" => "fertis", 
			"3pl" => "ferunt",	
		],
		"mediopassive" => 
		[
			"1sg" => "feror",
			"2sg" => "ferris", 
			"3sg" => "fertur",
			"1pl" => "ferimur",
			"2pl" => "feriminī", 
			"3pl" => "feruntur",	
		],		
	];
	
	// 活用種別
	protected $class = "5fer";
	
	// 不定形
	protected $infinitive = "ferre";
	// 受動不定形
	protected $passive_infinitive = "ferrī";
	// 完了不定形
	protected $perfect_infinitive = "tetulisse";
	// 完了受動不定形
	protected $perfect_passive_infinitive = "lātum esse";
	// 未来不定形
	protected $future_infinitive = "futūrum esse";
	// 未来受動不定形
	protected $future_passive_infinitive = "lātum īrī";

	// 不完了体能動分詞
	protected $present_participle_active = "ferēns";
	// 完了形受動分詞
	protected $perfect_participle_passive = "lātus";
	// 未来能動分詞
	protected $future_participle_active = "lātūrus";
	// 未来受動分詞
	protected $future_participle_passive = "ferundus";

	// 目的分詞
	protected $supine = "lātum";

	// 追加語幹
	protected $added_stem = "";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
		// 親の呼び出し
    	parent::__construct("fer", "ferre", "tetul", "lātus");
    }

	// esseの派生動詞に対応
	public function add_stem($verb){
		// 派生部分を取得
		$this->added_stem = mb_substr($verb, 0, -5);
		// 変更がなければ、ここで処理を中断する。
		if($this->added_stem == ""){
			return;
		}
		// 語幹を変更
		$this->present_stem = $this->added_stem.$this->present_stem;								// 現在形
		$this->aorist_stem = $this->added_stem.$this->aorist_stem;									// 完了形
		$this->perfect_stem = $this->added_stem.$this->perfect_stem;								// 完了形

		// 分詞を挿入
		$this->present_participle_active = $this->added_stem.$this->present_participle_active;		// 不完了体能動分詞
		$this->perfect_participle_passive = $this->added_stem.$this->perfect_participle_passive;	// 完了形受動分詞
		$this->future_participle_active = $this->added_stem.$this->future_participle_active;		// 未来能動分詞
		$this->future_participle_passive = $this->added_stem.$this->future_participle_passive;		// 未来受動分詞
		$this->supine = $this->added_stem.$this->supine;											// 目的分詞

		// 不定詞を挿入
		$this->infinitive = $this->added_stem.$this->infinitive;									// 不定形
		$this->perfect_infinitive = $this->added_stem.$this->perfect_infinitive;                    // 完了不定形
		$this->future_passive_infinitive = $this->added_stem.$this->future_passive_infinitive;      // 未来不定形		
		$this->passive_infinitive = $this->added_stem.$this->passive_infinitive;					// 受動不定形
		$this->perfect_passive_infinitive = $this->added_stem.$this->perfect_passive_infinitive;    // 受動完了不定形		
		$this->future_passive_infinitive = $this->added_stem.$this->future_passive_infinitive;      // 受動未来不定形	

		// 情報を更新
		$this->get_add_info($this->infinitive);
	}

	
	// 動詞作成
	public function get_latin_verb($person, $voice, $mood, $aspect, $tense){

		// 不適切な組み合わせのチェック
		if(!$this->deponent_check($voice, $aspect)){
			// ハイフンを返す。
			return "-";		
		}

		//動詞の語幹を取得
		$verb_conjugation = "";
		if($aspect == Commons::PRESENT_ASPECT){
			// 不完了形
			$verb_conjugation = $this->present_stem;
		} else if($aspect == Commons::PERFECT_ASPECT){
			// 状態動詞
			$verb_conjugation = $this->perfect_stem;
		} else {
			// ハイフンを返す。
			return "-";
		} 
		
		//法を取得
		if($mood == Commons::INDICATIVE){
			// 相で分ける
			if($aspect == Commons::PRESENT_ASPECT){
				// 進行相
				// 直説法
				$verb_conjugation = $verb_conjugation.$this->ind;
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->added_stem.$this->present_number[$voice][$person];;
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->get_ind_past($voice, $person);
				} else if($tense == Commons::FUTURE_TENSE){
					//未来形
					$verb_conjugation = $this->get_ind_future($this->present_stem, $voice, $person);
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::ACTIVE_VOICE){
				// 完了相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					// 現在形					
					$verb_conjugation = $this->get_perfect_suffix($verb_conjugation, $voice, $person, "");
				} else if($tense == Commons::PAST_TENSE){
					// コピュラの呼び出し
					$verb_sum = new Latin_Verb_Sum();					
					$verb_conjugation = $verb_conjugation.$verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense);
				} else if($tense == Commons::FUTURE_TENSE){
					// 未来形
					$verb_conjugation = $this->get_primary_infix($verb_conjugation, $aspect, $tense, $voice, $person, self::ind_perf_future_suffix);
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::MEDIOPASSIVE_VOICE){
				// 完了相受動態
				// 未来完了のみ単純時制
				if($tense == Commons::PRESENT_TENSE || $tense == Commons::PAST_TENSE || $tense == Commons::FUTURE_TENSE) {
					// それ以外
					// コピュラの呼び出し
					$verb_sum = new Latin_Verb_Sum();
					// 複合時制
					$verb_conjugation = $this->perfect_participle_passive." ".$verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense);
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else {
				// ハイフンを返す。
				return "-";
			}
		} else if($mood == Commons::SUBJUNCTIVE){
			// 接続法
			// 相で分ける
			if($aspect == Commons::PRESENT_ASPECT){
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->get_secondary_infix($verb_conjugation, $voice, $person, $this->opt);
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->make_subj_past($voice, $person);
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::ACTIVE_VOICE){
				// 完了相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					// 現在形
					// コピュラの呼び出し
					$verb_sum = new Latin_Verb_Sum();
					// 生成						
					$verb_conjugation = $verb_conjugation."er".mb_substr($verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense), 1);
				} else if($tense == Commons::PAST_TENSE){
					// 過去形
					// コピュラの呼び出し
					$verb_sum = new Latin_Verb_Sum();
					// 生成										
					$verb_conjugation = $verb_conjugation."i".mb_substr($verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense), 1);
				} else {
					// ハイフンを返す。
					return "-";
				} 
			} else if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::MEDIOPASSIVE_VOICE){
				// 完了相受動態
				// コピュラの呼び出し
				$verb_sum = new Latin_Verb_Sum();
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE || $tense == Commons::PAST_TENSE) {
					//現在形
					$verb_conjugation = $this->perfect_participle_passive." ".$verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense);
				} else {
					// ハイフンを返す。
					return "-";
				} 
			} else {
				// ハイフンを返す。
				return "-";
			}
		} else if($mood == Commons::IMPERATIVE){
			// 命令法
			$verb_conjugation = $verb_conjugation.$this->imper;
			// 時制を分ける。
			if($tense == Commons::PRESENT_TENSE) {
				// 現在形
				$verb_conjugation = $this->get_imperative_suffix($verb_conjugation, $voice, $person);
			} else if($tense == Commons::FUTURE_TENSE){
				// 未来形
				$verb_conjugation = $this->get_future_imperative($verb_conjugation, $voice, $person);
			} else {
				// ハイフンを返す。
				return "-";
			}
		}
		
		// 文字を変換
		$verb_conjugation = str_replace("cs", "x", $verb_conjugation);
		// 結果を返す。
		return $verb_conjugation;
	}

	// 活用表を取得する。
	public function get_chart(){
		// 初期化
		$conjugation = array();
		// タイトル情報を挿入
		$conjugation["title"] = $this->get_title($this->infinitive);
		// 辞書見出しを入れる。
		$conjugation["dic_title"] = $this->infinitive;
		// 種別を入れる。
		$conjugation["category"] = "動詞";
		// 活用種別
		$conjugation["type"] = $this->class_name;
		
		// 能動態現在相を入れる。
		// 共通変化部分の動詞の活用を取得
		$conjugation = $this->make_common_standard_verb_conjugation($conjugation);
		// 能動態を入れる。
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["1sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["2sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["3sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["1pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["2pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["3pl"] = "-";
		// 受動態を入れる。
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1sg"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2sg"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3sg"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1pl"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2pl"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3pl"] = "-";

		// 分詞を挿入
		$conjugation["present_active"] = $this->get_participle($this->present_participle_active);	// 不完了体能動分詞
		$conjugation["perfect_passive"] = $this->get_participle($this->perfect_participle_passive);	// 状態動詞受動分詞
		$conjugation["future_active"] = $this->get_participle($this->future_participle_active);		// 未来能動分詞
		$conjugation["future_passive"] = $this->get_participle($this->future_participle_passive);	// 未来受動分詞
		$conjugation["supine"] = $this->get_participle($this->supine);								// 目的分詞
		
		// 不定詞を挿入
		$conjugation["infinitive"]["present_active"] = $this->infinitive;						// 不定形
		$conjugation["infinitive"]["present_passive"] = $this->passive_infinitive;			// 受動不定形
		$conjugation["infinitive"]["perfect_active"] = $this->perfect_infinitive;				// 完了不定形
		$conjugation["infinitive"]["perfect_passive"] = $this->perfect_passive_infinitive;	// 完了受動不定形

		$conjugation["infinitive"]["future_active"] = $this->future_infinitive;				// 未来不定形
		$conjugation["infinitive"]["future_passive"] = $this->future_passive_infinitive;		// 未来受動不定形

		// 結果を返す。
		return $conjugation;
	}

}

class Latin_Verb_Eo extends Latin_Verb {

	// 現在形人称
	protected $present_number = 
	[		
		"active" => 
		[
			"1sg" => "eō",
			"2sg" => "īs", 
			"3sg" => "it",
			"1pl" => "īmus",
			"2pl" => "ītis", 
			"3pl" => "eunt",	
		],
		"mediopassive" => 
		[
			"1sg" => "eor",
			"2sg" => "īris", 
			"3sg" => "ītur",
			"1pl" => "īmur",
			"2pl" => "īminī", 
			"3pl" => "euntur",	
		],		
	];

	// 完了人称接尾辞
	protected $perfect_number = 
	[
		"active" => 
		[
			"1sg" => "īvī",
			"2sg" => "īvistī", 
			"3sg" => "īvit",
			"1pl" => "iimus",
			"2pl" => "īstis", 
			"3pl" => "iērunt",	
		]
	];

	// 未来命令人称接尾辞
	protected $imperative_future_number = 
	[
		"active" => 
		[
			"1sg" => "",
			"2sg" => "ītō", 
			"3sg" => "ītō",
			"1pl" => "",
			"2pl" => "ītōte", 
			"3pl" => "euntō",	
		],
		"mediopassive" => 
		[
			"1sg" => "",
			"2sg" => "ītor", 
			"3sg" => "ītor",
			"1pl" => "",
			"2pl" => "", 
			"3pl" => "euntor",	
		],
	];

	
	// 活用種別
	protected $class = "5eo";
	
	// 不定形
	protected $infinitive = "īre";
	// 受動不定形
	protected $passive_infinitive = "īrī";
	// 完了不定形
	protected $perfect_infinitive = "īsse";
	// 完了受動不定形
	protected $perfect_passive_infinitive = "itum esse";
	// 未来不定形
	protected $future_infinitive = "itūrum esse";
	// 未来受動不定形
	protected $future_passive_infinitive = "itum īrī";

	// 不完了体能動分詞
	protected $present_participle_active = "iēns";
	// 完了形受動分詞
	protected $perfect_participle_passive = "itus";
	// 未来能動分詞
	protected $future_participle_active = "itūrus";
	// 未来受動分詞
	protected $future_participle_passive = "eundus";

	// 目的分詞
	protected $supine = "itum";
	
	// 追加語幹
	protected $added_stem = "";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
		// 親の呼び出し
    	parent::__construct("ī", "īre", "ī", "itus");
    }

	// 派生動詞に対応
	public function add_stem($verb){
		// 派生部分を取得
		$this->added_stem = mb_substr($verb, 0, -3);
		// 変更がなければ、ここで処理を中断する。
		if($this->added_stem == ""){
			return;
		}

		// 語幹を変更
		$this->present_stem = $this->added_stem.$this->present_stem;								// 現在形
		$this->aorist_stem = $this->added_stem.$this->aorist_stem;									// 完了形
		$this->perfect_stem = $this->added_stem.$this->perfect_stem;								// 完了形

		// 分詞を挿入
		$this->present_participle_active = $this->added_stem.$this->present_participle_active;		// 不完了体能動分詞
		$this->perfect_participle_passive = $this->added_stem.$this->perfect_participle_passive;	// 完了形受動分詞
		$this->future_participle_active = $this->added_stem.$this->future_participle_active;		// 未来能動分詞
		$this->future_participle_passive = $this->added_stem.$this->future_participle_passive;		// 未来受動分詞
		$this->supine = $this->added_stem.$this->supine;											// 目的分詞

		// 不定詞を挿入
		$this->infinitive = $this->added_stem.$this->infinitive;									// 不定形
		$this->perfect_infinitive = $this->added_stem.$this->perfect_infinitive;                    // 完了不定形
		$this->future_passive_infinitive = $this->added_stem.$this->future_passive_infinitive;      // 未来不定形		
		$this->passive_infinitive = $this->added_stem.$this->passive_infinitive;					// 受動不定形
		$this->perfect_passive_infinitive = $this->added_stem.$this->perfect_passive_infinitive;    // 受動完了不定形		
		$this->future_passive_infinitive = $this->added_stem.$this->future_passive_infinitive;      // 受動未来不定形	

		// 情報を更新
		$this->get_add_info($this->infinitive);
	}

	
	// 動詞作成
	public function get_latin_verb($person, $voice, $mood, $aspect, $tense){

		// 不適切な組み合わせのチェック
		if(!$this->deponent_check($voice, $aspect)){
			// ハイフンを返す。
			return "-";		
		}

		//動詞の語幹を取得
		$verb_conjugation = "";
		if($aspect == Commons::PRESENT_ASPECT){
			// 不完了形
			$verb_conjugation = $this->present_stem;
		} else if($aspect == Commons::PERFECT_ASPECT){
			// 状態動詞
			$verb_conjugation = $this->perfect_stem;
		} else {
			// ハイフンを返す。
			return "-";
		} 
		
		//法を取得
		if($mood == Commons::INDICATIVE){
			// 相で分ける
			if($aspect == Commons::PRESENT_ASPECT){
				// 進行相
				// 直説法
				$verb_conjugation = $verb_conjugation.$this->ind;
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->added_stem.$this->present_number[$voice][$person];
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->get_ind_past($voice, $person);
				} else if($tense == Commons::FUTURE_TENSE){
					//未来形
					$verb_conjugation = $this->get_ind_future($this->present_stem, $voice, $person);
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::ACTIVE_VOICE){
				// 完了相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					// 現在形					
					$verb_conjugation = $this->get_perfect_suffix($verb_conjugation, $voice, $person, "");
				} else if($tense == Commons::PAST_TENSE){
					// コピュラの呼び出し
					$verb_sum = new Latin_Verb_Sum();					
					$verb_conjugation = $verb_conjugation.$verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense);
				} else if($tense == Commons::FUTURE_TENSE){
					// 未来形
					$verb_conjugation = $this->get_primary_infix($verb_conjugation, $aspect, $tense, $voice, $person, self::ind_perf_future_suffix);
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::MEDIOPASSIVE_VOICE){
				// 完了相受動態
				if($tense == Commons::PRESENT_TENSE || $tense == Commons::PAST_TENSE || $tense == Commons::FUTURE_TENSE) {
					// それ以外
					// コピュラの呼び出し
					$verb_sum = new Latin_Verb_Sum();
					// 複合時制
					$verb_conjugation = $this->perfect_participle_passive." ".$verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense);
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else {
				// ハイフンを返す。
				return "-";
			}
		} else if($mood == Commons::SUBJUNCTIVE){
			// 接続法
			// 相で分ける
			if($aspect == Commons::PRESENT_ASPECT){
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->get_secondary_infix("e", $voice, $person, $this->opt);
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->make_subj_past($voice, $person);
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::ACTIVE_VOICE){
				// 完了相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					// 現在形
					// コピュラの呼び出し
					$verb_sum = new Latin_Verb_Sum();
					// 生成						
					$verb_conjugation = $verb_conjugation."er".mb_substr($verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense), 1);
				} else if($tense == Commons::PAST_TENSE){
					// 過去形
					// コピュラの呼び出し
					$verb_sum = new Latin_Verb_Sum();
					// 生成										
					$verb_conjugation = $verb_conjugation."i".mb_substr($verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense), 1);
				} else {
					// ハイフンを返す。
					return "-";
				} 
			} else if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::MEDIOPASSIVE_VOICE){
				// 完了相受動態
				// コピュラの呼び出し
				$verb_sum = new Latin_Verb_Sum();
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE || $tense == Commons::PAST_TENSE) {
					//現在形
					$verb_conjugation = $this->perfect_participle_passive." ".$verb_sum->get_latin_verb($person, Commons::ACTIVE_VOICE, $mood, Commons::PRESENT_ASPECT, $tense);
				} else {
					// ハイフンを返す。
					return "-";
				} 
			} else {
				// ハイフンを返す。
				return "-";
			}
		} else if($mood == Commons::IMPERATIVE){
			// 命令法
			$verb_conjugation = $verb_conjugation.$this->imper;
			// 時制を分ける。
			if($tense == Commons::PRESENT_TENSE) {
				// 現在形
				$verb_conjugation = $this->get_imperative_suffix($verb_conjugation, $voice, $person);
			} else if($tense == Commons::FUTURE_TENSE){
				// 未来形
				$verb_conjugation = $this->get_future_imperative("", $voice, $person);
			} else {
				// ハイフンを返す。
				return "-";
			}
		}
		
		// 文字を変換
		$verb_conjugation = str_replace("cs", "x", $verb_conjugation);
		// 結果を返す。
		return $verb_conjugation;
	}

	// 活用表を取得する。
	public function get_chart(){
		// 初期化
		$conjugation = array();
		// タイトル情報を挿入
		$conjugation["title"] = $this->get_title($this->infinitive);
		// 辞書見出しを入れる。
		$conjugation["dic_title"] = $this->infinitive;
		// 種別を入れる。
		$conjugation["category"] = "動詞";
		// 活用種別
		$conjugation["type"] = $this->class_name;
		
		// 能動態現在相を入れる。
		// 共通変化部分の動詞の活用を取得
		$conjugation = $this->make_common_standard_verb_conjugation($conjugation);
		// 能動態を入れる。
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["1sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["2sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["3sg"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["1pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["2pl"] = "-";
		$conjugation[Commons::ACTIVE_VOICE]["timeless"][Commons::SUBJUNCTIVE]["3pl"] = "-";
		// 受動態を入れる。
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1sg"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2sg"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3sg"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["1pl"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["2pl"] = "-";
		$conjugation[Commons::MEDIOPASSIVE_VOICE]["future_perfect2"][Commons::INDICATIVE]["3pl"] = "-";

		// 分詞を挿入
		$conjugation["present_active"] = $this->get_participle($this->present_participle_active);	// 不完了体能動分詞
		$conjugation["perfect_passive"] = $this->get_participle($this->perfect_participle_passive);	// 状態動詞受動分詞
		$conjugation["future_active"] = $this->get_participle($this->future_participle_active);		// 未来能動分詞
		$conjugation["future_passive"] = $this->get_participle($this->future_participle_passive);	// 未来受動分詞
		$conjugation["supine"] = $this->get_participle($this->supine);								// 目的分詞
		
		// 不定詞を挿入
		$conjugation["infinitive"]["present_active"] = $this->infinitive;						// 不定形
		$conjugation["infinitive"]["present_passive"] = $this->passive_infinitive;			// 受動不定形
		$conjugation["infinitive"]["perfect_active"] = $this->perfect_infinitive;				// 完了不定形
		$conjugation["infinitive"]["perfect_passive"] = $this->perfect_passive_infinitive;	// 完了受動不定形

		$conjugation["infinitive"]["future_active"] = $this->future_infinitive;				// 未来不定形
		$conjugation["infinitive"]["future_passive"] = $this->future_passive_infinitive;		// 未来受動不定形

		// 結果を返す。
		return $conjugation;
	}

}

// ロマンス語共通クラス
class Common_Romance_Verb extends Verb_Common_IE {
	
	// 一次人称接尾辞(現在、未来)
	protected $primary_number = 
	[		
		"active" => 
		[
			"1sg" => "ō",
			"2sg" => "s", 
			"3sg" => "t",
			"1pl" => "mus",
			"2pl" => "tis", 
			"3pl" => "unt",	
		],
	];
	
	// 二次人称接尾辞(過去、接続)
	protected $secondary_number = 
	[
		"active" => 
		[
			"1sg" => "",
			"2sg" => "s", 
			"3sg" => "t",
			"1pl" => "mos",
			"2pl" => "tes", 
			"3pl" => "nt",	
		],
	];

	// 三次人称接尾辞(未来)
	protected $third_number = 
	[
		"active" => 
		[
			"1sg" => "ai",
			"2sg" => "as", 
			"3sg" => "a",
			"1pl" => "emos",
			"2pl" => "eis", 
			"3pl" => "an",	
		],
	];

	// 命令人称接尾辞
	protected $imperative_number = 
	[
		"active" => 
		[
			"1sg" => "",
			"2sg" => "", 
			"3sg" => "",
			"1pl" => "",
			"2pl" => "te", 
			"3pl" => "",	
		],
	];
	
	// 完了人称接尾辞
	protected $perfect_number = 
	[
		"active" => 
		[
			"1sg" => "i",
			"2sg" => "isti", 
			"3sg" => "ut",
			"1pl" => "mus",
			"2pl" => "tes", 
			"3pl" => "ront",	
		]
	];
	
	// 直接法
	protected $ind = "";
	// 命令法
	protected $imper = "";
	// 希求法→接続法
	protected $opt = "";
	// 接続法→未来形
	protected $subj = "";
	
	// 不定形
	protected $infinitive = "";
	// 受動不定形
	protected $passive_infinitive = "";
	// 完了不定形
	protected $perfect_infinitive = "";
	// 完了受動不定形
	protected $perfect_passive_infinitive = "";
	// 未来不定形
	protected $future_infinitive = "";
	// 未来受動不定形
	protected $future_passive_infinitive = "";


	// 未来能動分詞
	protected $future_participle_active = "";
	// 未来受動分詞
	protected $future_participle_passive = "";
	// 目的分詞
	protected $supine = "";

	// 非人称のみ
	protected $deponent_personal = "";

	// 直接法過去接尾辞
	protected const past_ind_infix = "ba";
	// 直接法未来語尾
	protected const ind_future_infix = "r";
	// 直接法過去完了語尾
	protected const ind_perf_past_suffix = "ra";
	// 接続法過去完了語尾
	protected const subj_perf_past_suffix = "sse";	

	// 直接法未来完了語尾
	protected const ind_perf_future_suffix = "re";

	// sum補助動詞
	protected const auxiliary_sum = "esse";

    /*=====================================
    コンストラクタ
    ======================================*/
 	function __construct_lat1($dic_stem) {
		// 親の呼び出し
    	parent::__construct($dic_stem);
    	// 動詞情報を取得
		$word_info = $this->get_verb_from_DB($dic_stem, Latin_Common::DB_VERB);
		// データの取得確認
		if($word_info){
			// データを挿入
			$this->present_stem = $word_info["present_stem"];						// 現在形
			$this->infinitive = $word_info["infinitive_stem"];						// 不定形
			$this->perfect_stem = $word_info["perfect_stem"];						// 完了形
			$this->perfect_participle_passive = $word_info["perfect_participle"];	// 完了分詞

			$this->japanese_translation = $word_info["japanese_translation"];		// 日本語訳
			$this->english_translation = $word_info["english_translation"];			// 英語訳

			$this->deponent_personal = $word_info["deponent_personal"];				// 非人称のみ
			$this->verb_type = $word_info["verb_type"];								// 活用種別
		} else if(preg_match('/are$/', $dic_stem)){	
			// 不明動詞の対応
			$this->generate_uknown_verb(mb_substr($dic_stem, 0, -3));
		} else if(preg_match('/ere$/', $dic_stem)){	
			// 不明動詞の対応
			$this->generate_uknown_verb3(mb_substr($dic_stem, 0, -3));			
		} else if(preg_match('/ire$/', $dic_stem)){	
			// 不明動詞の対応
			$this->generate_uknown_verb4(mb_substr($dic_stem, 0, -3));										
		} else {
			// 不明動詞の対応
			$this->generate_uknown_verb($dic_stem);
		}

		// 動詞の種別を決定
		$this->decide_verb_class();
		// 動詞の語幹を作成
		$this->get_verb_stem($this->infinitive, $this->perfect_participle_passive);
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    function __construct_lat3($stem, $japanese_word, $last_word) {
		// 親の呼び出し
    	parent::__construct($last_word);		
		// 種別により分ける。
		if(mb_strpos('する', $japanese_word) && preg_match('/are$/', $last_word)){
			// 不明動詞の対応
			$this->generate_uknown_verb(mb_substr($stem, 0, -1));																			
		} else {
			// それ以外は最後の語尾から動詞の活用を生成
			$this->__construct_lat1($last_word);
			// 後ろに付け加える。
			$this->present_stem = $stem.$this->present_stem ;								// 現在形
			$this->infinitive = $stem.$this->infinitive;									// 不定形
			$this->perfect_stem = $stem.$this->perfect_stem;								// 完了形
			$this->perfect_participle_passive = $stem.$this->perfect_participle_passive;	// 完了分詞														
		}
		// 動詞の種別を決定
		$this->decide_verb_class();
		// 訳を入れる。
		$this->japanese_translation = $japanese_word;									// 日本語訳
		$this->english_translation = "";												// 英語訳				
		// 動詞の語幹を作成
		$this->get_verb_stem($this->infinitive, $this->perfect_participle_passive);		
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

	// 追加情報を取得
	protected function get_add_info($dic_stem){
    	// 動詞情報を取得
		$word_info = $this->get_verb_from_DB($dic_stem, Latin_Common::DB_VERB);
		// データの取得確認
		if($word_info){
			$this->deponent_personal = $word_info["deponent_personal"];				// 非人称のみ
			$this->japanese_translation = $word_info["japanese_translation"];		// 日本語訳
			$this->english_translation = $word_info["english_translation"];			// 英語訳
			$this->verb_type= $word_info["verb_type"];								// 活用種別
		}
	}

	// 不定詞を取得
	public function get_infinitive(){
		return $this->infinitive;
	}

	// 動詞種別の判定
	private function decide_verb_class(){
    	// 活用種別から動詞種別判定
		switch ($this->verb_type) {
		    case "1":
		        $this->ind = "a";		// 直接法
		        $this->opt = "e";			// 接続法←希求法
		        $this->imper = "ā";		// 命令法
				$this->class_name = "第一変化";	 // 活用名
		        break;
		    case "2":
				$this->ind = "e";		// 直接法
		        $this->opt = "a";			// 接続法←希求法
		        $this->imper = "ē";		// 命令法
				$this->class_name = "第二変化";	 // 活用名				
		        break;
		    case "3":
   				// 直説法語尾
				$this->ind = "i";		// 直接法
		        $this->opt = "a";			// 接続法←希求法
		        $this->subj = "e";		// 未来形←接続法
				$this->imper = "e";		// 命令法
				$this->class_name = "第三変化";	 // 活用名				
		        break;
			case "3a":
				// 直説法語尾
			 	$this->ind = "";				// 直接法
			 	$this->opt = "a";				// 接続法←希求法
				$this->imper = "i";			// 未来形←接続法
			 	$this->subj = "e";			// 命令法
				$this->class_name = "第三変化i型";	 // 活用名
				break;
		    case "4":
   				// 直説法語尾
				$this->ind = "";				// 直接法
		        $this->opt = "a";				// 接続法←希求法
		        $this->subj = "e";			// 未来形←接続法
		        $this->imper = "ī";			// 命令法
				$this->class_name = "第四変化型";	 // 活用名				
		        break;
		    case "5fio":
   				// 直説法語尾
				$this->ind = "";				// 直接法
		        $this->opt = "a";				// 接続法←希求法
		        $this->subj = "e";			// 未来形←接続法
				$this->imper = "i";			// 命令法
				$this->class_name = "不規則動詞";	 // 活用名				
		        break;				
		    case "5volo":
   				// 直説法語尾
				$this->ind = "";				// 直接法
		        $this->opt = "";				// 接続法←希求法
		        $this->subj = "e";			// 未来形←接続法
				$this->imper = "i";			// 命令法
				$this->class_name = "不規則動詞";	 // 活用名					
		        break;
		    case "5fer":
   				// 直説法語尾
				$this->ind = "";				// 直接法
		        $this->opt = "a";				// 接続法←希求法
		        $this->subj = "e";			// 未来形←接続法
				$this->imper = "";				// 命令法
				$this->class_name = "不規則動詞";	 // 活用名					
		        break;
		    case "5eo":
   				// 直説法語尾
				$this->ind = "";				// 直接法
		        $this->opt = "a";				// 接続法←希求法
		        $this->subj = "";			// 未来形←接続法
				$this->imper = "";				// 命令法
				$this->class_name = "不規則動詞";	 // 活用名					
		        break;					
			default:
				break;
		}
	}

	// 不明動詞の対応
	private function generate_uknown_verb($dic_stem){
		// 共通語幹を取得
		$common_stem = $dic_stem."a";
		// 訳を入れる。
		$this->japanese_translation = "借用";
		$this->english_translation = "loanword";	
		$this->verb_type= "1";					// 活用種別					
		$this->present_stem = mb_substr($common_stem, 0, -1);			// 現在形
		$this->infinitive = $common_stem ."re";							// 不定形
		$this->perfect_stem = $common_stem;								// 完了形
		$this->perfect_participle_passive = $common_stem."to";			// 完了分詞
	}

	// 不明動詞の対応3
	private function generate_uknown_verb3($dic_stem){
		// 共通語幹を取得
		$common_stem = $dic_stem."e";
		// 訳を入れる。
		$this->japanese_translation = "借用";
		$this->english_translation = "loanword";	
		$this->verb_type= "3";						// 活用種別					
		$this->present_stem = mb_substr($common_stem, 0, -1);			// 現在形
		$this->infinitive = $common_stem ."re";							// 不定形
		$this->aorist_stem = $common_stem;								// 完了形
		$this->perfect_stem = $common_stem;								// 完了形
		$this->perfect_participle_passive = $dic_stem."to";				// 完了分詞
	}

	// 不明動詞の対応4
	private function generate_uknown_verb4($dic_stem){
		// 共通語幹を取得
		$common_stem = $dic_stem."i";
		// 訳を入れる。
		$this->japanese_translation = "借用";
		$this->english_translation = "loanword";	
		$this->verb_type= "4";											// 活用種別					
		$this->present_stem = mb_substr($common_stem, 0, -1)."i";		// 現在形
		$this->infinitive = $common_stem."re";							// 不定形
		$this->perfect_stem = $common_stem;								// 完了形
		$this->perfect_participle_passive = $dic_stem."to";				// 完了分詞
	}

	// 動詞の語幹を作成
	private function get_verb_stem($infinitive, $perfect_paticiple){	
		// 分詞語尾を取得
		$common_stem = mb_substr($infinitive, 0, -2);

		// 分詞を挿入
		$this->present_participle_active = $common_stem."nto";		// 不完了体能動分詞
		$this->perfect_participle_passive = $perfect_paticiple;		// 状態動詞受動分詞
		$this->future_participle_passive = $common_stem."ndo";		// 未来受動分詞
		
		// 不定詞を挿入
		$this->infinitive = $infinitive;							// 不定形
	}
	
	// 動詞作成
	public function get_latin_verb($person, $mood, $aspect, $tense){

		// 非人称チェック
		if($this->deponent_personal == "1" && $person != "3sg"){
			// ハイフンを返す。
			return "-";			
		}

		//動詞の語幹を取得
		$verb_conjugation = "";
		if($aspect == Commons::PRESENT_ASPECT){
			// 不完了形
			$verb_conjugation = $this->present_stem;
		} else if($aspect == Commons::PERFECT_ASPECT){
			// 状態動詞
			$verb_conjugation = $this->perfect_stem;
		} else {
			// ハイフンを返す。
			return "-";
		}
		
		//法を取得
		if($mood == Commons::INDICATIVE){
			// 相で分ける
			if($aspect == Commons::PRESENT_ASPECT){
				// 進行相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->get_primary_infix($verb_conjugation, $aspect, $tense, $person, $this->ind);
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->get_ind_past($person);
				} else if($tense == Commons::FUTURE_TENSE){
					//未来形
					$verb_conjugation = $this->get_ind_future($person);
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else if($aspect == Commons::PERFECT_ASPECT){
				// 完了相
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					// 現在形					
					$verb_conjugation = $this->get_perfect_suffix($verb_conjugation, $person, "");
				} else if($tense == Commons::PAST_TENSE){
					// 過去形				
					$verb_conjugation = $this->get_secondary_infix($verb_conjugation, $person, self::ind_perf_past_suffix);
				} else if($tense == Commons::FUTURE_TENSE){
					// 未来形
					$verb_conjugation = $this->get_primary_infix($verb_conjugation, $aspect, $tense, $person, self::ind_perf_future_suffix);
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else {
				// ハイフンを返す。
				return "-";
			}
		} else if($mood == Commons::SUBJUNCTIVE){
			// 接続法
			// 相で分ける
			if($aspect == Commons::PRESENT_ASPECT){
				// 時制を分ける。
				if($tense == Commons::PRESENT_TENSE) {
					//現在形
					$verb_conjugation = $this->get_secondary_infix($verb_conjugation, $person, $this->opt);
				} else if($tense == Commons::PAST_TENSE){
					//過去形
					$verb_conjugation = $this->make_subj_past($person);
				} else {
					// ハイフンを返す。
					return "-";
				}
			} else if($aspect == Commons::PERFECT_ASPECT){
				// 完了相
				// 時制を分ける。
				if($tense == Commons::PAST_TENSE){
					// 過去形						
					$verb_conjugation = $this->get_secondary_infix($verb_conjugation, $person, self::subj_perf_past_suffix);
				} else {
					// ハイフンを返す。
					return "-";
				} 
			} else {
				// ハイフンを返す。
				return "-";
			}
		} else if($mood == Commons::IMPERATIVE){
			// 命令形語幹を作成
			$verb_conjugation = mb_substr($this->infinitive, 0, -3).$this->imper;
			// 時制を分ける。
			if($tense == Commons::PRESENT_TENSE) {
				// 現在形
				$verb_conjugation = $this->get_imperative_suffix($verb_conjugation, Commons::ACTIVE_VOICE, $person);
			} else {
				// ハイフンを返す。
				return "-";
			}
		} else {
			// ハイフンを返す。
			return "-";
		}
		
		// 文字を変換
		$verb_conjugation = str_replace("cs", "x", $verb_conjugation);
		// 結果を返す。
		return $verb_conjugation;
	}
	
	// 一次語尾
	protected function get_primary_infix($verb_stem, $aspect, $tense, $person, $infix){

		// 接尾辞を追加
		$verb_stem = $verb_stem.$infix;
		// 文字列を切除
		if($this->verb_type == "1" && $tense == Commons::PRESENT_TENSE){
			// 第一活用現在形の場合
			// 人称によっては最後の文字を削除
			if($person == "1sg"){
				// 一人称単数、三人称複数
				// 最後の母音を切除
				$verb_stem  = mb_substr($verb_stem, 0, -1);
			} 
		} else if($this->verb_type == "3" || $tense != Commons::PRESENT_TENSE){
			// 第三、第四活用または現在形以外
			// 人称によっては最後の文字を削除
			if(preg_match('(1sg|3pl)', $person)){
				// 一人称単数、三人称複数
				// 最後の母音を切除
				$verb_stem  = mb_substr($verb_stem, 0, -1);
			}
		} else if($this->verb_type == "2" && $aspect == Commons::PRESENT_ASPECT){
			// 第二活用現在形の場合
			// 最後の母音を切除
			$verb_stem  = mb_substr($verb_stem, 0, -1);	
		}

		// 語尾を追加
		$verb_conjugation = $this->get_primary_suffix_latin($verb_stem, $aspect, $tense, $person);
		// 結果を返す。
		return $verb_conjugation;
	}
	
	// 一次語尾
	protected function get_primary_suffix_latin($verb_stem, $aspect, $tense, $person){
		// 対象は三人称複数のみ
		if($person == "3pl") {
			// 時制と動詞クラスで分ける。	
			if($aspect == Commons::PRESENT_ASPECT && $tense == Commons::PRESENT_TENSE && $this->verb_type== 1 && $this->deponent_present != Commons::$TRUE){
				// 現在形と未来形の1・2活用
				$verb_conjugation = $verb_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person];
			} else {
				// それ以外は親クラスを呼び出す
				$verb_conjugation = $this->get_primary_suffix($verb_stem, Commons::ACTIVE_VOICE, $person);			
			}
		} else {
			// それ以外は親クラスを呼び出す
			$verb_conjugation = $this->get_primary_suffix($verb_stem, Commons::ACTIVE_VOICE, $person);
		}
		// 結果を返す。
		return $verb_conjugation;
	}
	
	// 二次語尾
	protected function get_secondary_infix($verb_stem, $person, $infix){	
		// 接尾辞を追加
		$verb_conjugation = $verb_stem.$infix;
		// 語尾を追加
		$verb_conjugation = $this->get_secondary_suffix($verb_conjugation, Commons::ACTIVE_VOICE, $person);
		// 結果を返す。
		return $verb_conjugation;
	}

	// 直接法過去を作成
	protected function get_ind_past($person){
		// 結果を返す。
		return $this->get_secondary_infix(mb_substr($this->infinitive, 0, -2), $person, self::past_ind_infix);
	}

	// 接続法過去を作成
	protected function make_subj_past($person){			
		// 過去形を生成
		$past_tense = $this->get_secondary_infix($this->infinitive, $person, "");
		// 結果を返す。
		return $past_tense;
	}	
	
	// 未来形
	protected function get_ind_future($person){
		// 結果を返す。
		return mb_substr($this->infinitive, 0, -1).$this->third_number[Commons::ACTIVE_VOICE][$person];
	}

	// 分詞の曲用表を返す。	
	protected function get_participle($participle_stem){
		// 読み込み
		$adj_latin = new Latin_Adjective($participle_stem);
		// 結果を返す。
		return $adj_latin->get_chart();
	}

	// 通常変化部分の動詞の活用を作成する。
	protected function make_common_standard_verb_conjugation($conjugation){

		// 配列を作成
		$voice_array = array(Commons::ACTIVE_VOICE);													//態
		$tense_array = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE, Commons::FUTURE_TENSE);		//時制
		$mood_array = array(Commons::INDICATIVE, Commons::SUBJUNCTIVE, Commons::IMPERATIVE);			//法
		$person_array = array("1sg", "2sg", "3sg", "1pl", "2pl", "3pl");								//人称

		// 活用表を挿入(現在相)
		// 全ての態
		foreach ($voice_array as $voice){
			// 全ての時制			
			foreach ($tense_array as $tense){
				// 全ての法			
				foreach ($mood_array as $mood){
					// 全ての人称			
					foreach ($person_array as $person){
						// 態・時制・法・人称に応じて多次元配列を作成		
						$conjugation[$voice][$tense][$mood][$person] = $this->get_latin_verb($person, $mood, Commons::PRESENT_ASPECT, $tense);						
					}
				}
			}
		}

		// 活用表を挿入(完了相)
		// 全ての態
		foreach ($voice_array as $voice){
			// 全ての完了時制			
			foreach ($tense_array as $tense){
				// 全ての法			
				foreach ($mood_array as $mood){
					// 全ての人称			
					foreach ($person_array as $person){
						// 態・時制・法・人称に応じて多次元配列を作成		
						$conjugation[$voice][$tense."_".Commons::PERFECT_ASPECT][$mood][$person] = $this->get_latin_verb($person, $mood, Commons::PERFECT_ASPECT, $tense);						
					}
				}
			}
		}

		// 結果を返す。
		return $conjugation;
	}

	// 活用表を取得する。
	public function get_chart(){

		// 初期化
		$conjugation = array();
		// タイトル情報を挿入
		$conjugation["title"] = $this->get_title($this->infinitive);
		// 辞書見出しを入れる。
		$conjugation["dic_title"] = $this->infinitive;
		// 種別を入れる。
		$conjugation["category"] = "動詞";
		// 活用種別
		$conjugation["type"] = $this->class_name;
		// 共通変化部分の動詞の活用を取得
		$conjugation = $this->make_common_standard_verb_conjugation($conjugation);

		// 分詞を挿入
		$conjugation["participle"]["present_active"] = $this->present_participle_active;		// 不完了体能動分詞
		$conjugation["participle"]["perfect_passive"] = $this->perfect_participle_passive;	// 状態動詞受動分詞
		$conjugation["participle"]["future_passive"] = $this->future_participle_passive;		// 未来受動分詞
		
		// 不定詞を挿入
		$conjugation["infinitive"] = $this->infinitive;						// 不定形
		
		// 結果を返す。
		return $conjugation;
	}

	// 特定の活用を取得する(ない場合はランダム)。
	public function get_conjugation_form_by_each_condition($person = "", $voice = "", $mood = "", $aspect = "", $tense = ""){

		// 法がない場合
		if($mood == ""){
			// 全ての性別の中からランダムで選択
			$ary = array(Commons::INDICATIVE, Commons::SUBJUNCTIVE, Commons::IMPERATIVE);	// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$mood = $ary[$key];			
		}	

		// 相がない場合
		if($aspect == ""){
			// 命令形とそれ以外で分ける。
			if($mood == Commons::IMPERATIVE){
				// 命令法
				$ary = array(Commons::PRESENT_ASPECT);	
			} else {
				// それ以外
				// 欠如動詞対応
				if($this->deponent_present != Commons::$TRUE){
					// 現在形なし
					$ary = array(Commons::PERFECT_ASPECT);	
				} else if($this->deponent_perfect != Commons::$TRUE){
					// 完了形なし
					$ary = array(Commons::PRESENT_ASPECT);	
				} else {
					// それ以外
					$ary = array(Commons::PRESENT_ASPECT, Commons::PERFECT_ASPECT);	
				}
			}
			// 全ての相の中からランダムで選択
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$aspect = $ary[$key];			
		}

		// 時制がない場合
		if($tense == ""){
			// 直接法・接続法・命令法で分ける。
			if($mood == Commons::IMPERATIVE){
				// 命令法
				$ary = array(Commons::PRESENT_TENSE);							// 初期化
			} else if($mood == Commons::SUBJUNCTIVE){
				// 接続法
				$ary = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE);		// 初期化
			} else {
				// それ以外(直接法)
				$ary = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE, Commons::FUTURE_TENSE);	// 初期化
			}		
			// 全ての時制の中からランダムで選択
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$tense = $ary[$key];			
		}	
		
		// 人称と数がない場合は
		if($person == ""){
			// 命令形とそれ以外で分ける。
			if($mood == Commons::IMPERATIVE && $tense == Commons::PRESENT_TENSE){
				// 現在命令
				$ary = array("2sg", "2pl"); // 初期化
			} else {
				// それ以外
				$ary = array("1sg", "2sg", "3sg", "1pl", "2pl", "3pl"); // 初期化
			}
			// 全ての人称からランダムで選択
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$person = $ary[$key];			
		}


		// 配列に格納
		$question_data = array();
		$question_data['question_sentence'] = $this->get_title($this->infinitive)."の".$aspect." ".$tense." ".$mood." ".$voice." ".$person."を答えよ";				
		$question_data['answer'] = $this->get_latin_verb($person, $voice, $mood, $aspect, $tense);
		$question_data['question_sentence2'] = $question_data['answer']."の時制、法、態と人称を答えよ。";
		$question_data['aspect'] = $aspect;
		$question_data['tense'] = $tense;	
		$question_data['mood'] = $mood;
		$question_data['voice'] = $voice;
		$question_data['person'] = $person;			

		// 結果を返す。
		return $question_data;
	}

	// 三次語尾
	protected function get_third_suffix($verb_conjugation, $person){
		// 結果を返す。
		return $verb_conjugation.$this->secondary_number[Commons::ACTIVE_VOICE][$person];
	}

}

class Common_Romance_Sum extends Common_Romance_Verb {

	// 現在形人称
	protected $present_number = 
	[		
		"active" => 
		[
			"1sg" => "som",
			"2sg" => "es", 
			"3sg" => "est",
			"1pl" => "somos",
			"2pl" => "estis", 
			"3pl" => "sont",	
		],
	];
	
	// 活用種別
	protected $class = "5sum";
	
	// 不定形
	protected $infinitive = "estare";
	// 不完了体能動分詞
	protected $present_participle_active = "sonto";
	// 未来能動分詞			
	protected $future_participle_active = "futuro";		
	// 追加語幹
	protected $added_stem = "";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
		// 親の呼び出し
    	parent::__construct("es", $this->infinitive, "fu", "futus");
    }

	// esseの派生動詞に対応
	public function add_stem($verb){
		// 派生部分を取得
		$this->added_stem = mb_substr($verb, 0, -4);
		// 変更がなければ、ここで処理を中断する。
		if($this->added_stem == ""){
			return;
		}
		// 語幹を変更
		$this->present_stem = $this->added_stem.$this->present_stem;								// 現在形
		$this->aorist_stem = $this->added_stem.$this->aorist_stem;									// 完了形
		$this->perfect_stem = $this->added_stem.$this->perfect_stem;								// 完了形

		// 情報を更新
		$this->get_add_info($this->infinitive);		
	}
	
	// 活用表を取得する。
	public function get_chart(){
		// 初期化
		$conjugation = array();
		// タイトル情報を挿入
		$conjugation["title"] = $this->get_title($this->infinitive);
		// 辞書見出しを入れる。
		$conjugation["dic_title"] = $this->infinitive;
		// 種別を入れる。
		$conjugation["category"] = "動詞";
		// 活用種別
		$conjugation["type"] = $this->class_name;
		
		// 共通変化部分の動詞の活用を取得
		$conjugation = $this->make_common_standard_verb_conjugation($conjugation);

		// 分詞を挿入
		$conjugation["present_active"] = $this->get_participle($this->present_participle_active);	// 不完了体能動分詞
		$conjugation["perfect_passive"] = $this->get_participle($this->perfect_participle_passive);	// 状態動詞受動分詞
		$conjugation["future_active"] = $this->get_participle($this->future_participle_active);		// 未来能動分詞
		$conjugation["future_passive"] = $this->get_participle($this->future_participle_passive);	// 未来受動分詞
		$conjugation["supine"] = $this->get_participle($this->supine);								// 目的分詞
		
		// 不定詞を挿入
		$conjugation["infinitive"]["present_active"] = $this->infinitive;					// 不定形
		$conjugation["infinitive"]["present_passive"] = "-";								// 受動不定形
		$conjugation["infinitive"]["perfect_active"] = $this->perfect_infinitive;			// 完了不定形
		$conjugation["infinitive"]["perfect_passive"] = "-";								// 完了受動不定形

		$conjugation["infinitive"]["future_active"] = $this->future_infinitive;				// 未来不定形
		$conjugation["infinitive"]["future_passive"] = "-";									// 未来受動不定形

		// 結果を返す。
		return $conjugation;
	}

}

// 梵語クラス
class Vedic_Verb extends Verb_Common_IE{

	// 語根
	protected $root = "";
	// 未然動詞
	protected $future_stem = "";
	// 始動動詞
	protected $inchorative_stem = "";
	// 結果動詞
	protected $resultative_stem = "";		
	
	// 不完了体使役動詞
	protected $present_causative_stem = "";
	// 完了体使役動詞
	protected $aorist_causative_stem = "";
	// 完了体使役動詞2
	protected $perfect_causative_stem = "";	
	// 未然使役動詞
	protected $future_causative_stem = "";
	
	// 不完了体願望動詞
	protected $present_desiderative_stem = "";
	// 完了体願望動詞
	protected $aorist_desiderative_stem = "";
	// 状態願望動詞
	protected $perfect_desiderative_stem = "";
	// 未然願望動詞
	protected $future_desiderative_stem = "";
	
	// 不完了体強意動詞
	protected $present_intensive_stem = "";
	// 完了体強意動詞
	protected $aorist_intensive_stem = "";
	// 状態強意動詞
	protected $perfect_intensive_stem = "";
	// 未然強意動詞
	protected $future_intensive_stem = "";

	// 不完了体使役+願望動詞
	protected $present_causative_desiderative_stem = "";
	// 完了体使役+願望動詞
	protected $aorist_causative_desiderative_stem = "";
	// 状態使役+願望動詞
	protected $perfect_causative_desiderative_stem = "";
	// 未然使役+願望動詞
	protected $future_causative_desiderative_stem = "";

	// 不完了体強意+願望動詞
	protected $present_intensive_desiderative_stem = "";
	// 完了体強意+願望動詞
	protected $aorist_intensive_desiderative_stem = "";
	// 状態強意+願望動詞
	protected $perfect_intensive_desiderative_stem = "";
	// 未然強意+願望動詞
	protected $future_intensive_desiderative_stem = "";

	// 不完了体願望+使役動詞
	protected $present_desiderative_causative_stem = "";
	// 完了体願望+使役動詞
	protected $aorist_desiderative_causative_stem = "";
	// 完了体願望+使役動詞2
	protected $perfect_desiderative_causative_stem = "";	
	// 未然願望+使役動詞
	protected $future_desiderative_causative_stem = "";

	// 不完了体強意+使役動詞
	protected $present_intensive_causative_stem = "";
	// 完了体強意+使役動詞
	protected $aorist_intensive_causative_stem = "";
	// 完了体強意+使役動詞2
	protected $perfect_intensive_causative_stem = "";	
	// 未然強意+使役動詞
	protected $future_intensive_causative_stem = "";

	
	// 一次人称接尾辞(現在、接続用)
	protected $primary_number = 
	[		
		"active" => 
		[
			"1sg" => "mi",
			"2sg" => "si", 
			"3sg" => "ti",
			"1du" => "vas",
			"2du" => "thas", 
			"3du" => "tas",			
			"1pl" => "mas",
			"2pl" => "tha", 
			"3pl" => "nti",			
		],
		"mediopassive" => 
		[
			"1sg" => "me",
			"2sg" => "se", 
			"3sg" => "te",
			"1du" => "vahe",
			"2du" => "the", 
			"3du" => "te",				
			"1pl" => "mahe",
			"2pl" => "dhve", 
			"3pl" => "nte",
		],
	];
	
	// 二次人称接尾辞(過去、願望用)
	protected $secondary_number = 
	[		
		"active" => 
		[
			"1sg" => "m",
			"2sg" => "s", 
			"3sg" => "t",
			"1du" => "va",
			"2du" => "tam", 
			"3du" => "tām",			
			"1pl" => "ma",
			"2pl" => "ta", 
			"3pl" => "n",		
		],
		"mediopassive" => 
		[
			"1sg" => "i",
			"2sg" => "thās", 
			"3sg" => "ta",
			"1du" => "vahi",
			"2du" => "thām", 
			"3du" => "tām",				
			"1pl" => "mahi",
			"2pl" => "dhvam", 
			"3pl" => "nta",
		],
	];

	// 命令人称接尾辞
	protected $imperative_number = 
	[
		"active" => 
		[
			"1sg" => "",
			"2sg" => "a", 
			"3sg" => "tu",
			"1du" => "",
			"2du" => "tam", 
			"3du" => "tām",
			"1pl" => "",
			"2pl" => "ta", 
			"3pl" => "ntu",	
		],
		"mediopassive" => 
		[
			"1sg" => "",
			"2sg" => "sva", 
			"3sg" => "tām",
			"1du" => "",
			"2du" => "ithām", 
			"3du" => "itām",
			"1pl" => "",
			"2pl" => "dhvam", 
			"3pl" => "ntām",	
		],
	];

	// 命令人称接尾辞(子音変化用)
	protected $imperative_number2 = 
	[
		"active" => 
		[
			"1sg" => "",
			"2sg" => "dhi", 
			"3sg" => "tu",
			"1du" => "",
			"2du" => "tam", 
			"3du" => "tām",
			"1pl" => "",
			"2pl" => "ta", 
			"3pl" => "ntu",	
		],
		"mediopassive" => 
		[
			"1sg" => "",
			"2sg" => "sva", 
			"3sg" => "tām",
			"1du" => "",
			"2du" => "ithām", 
			"3du" => "itām",
			"1pl" => "",
			"2pl" => "dhvam", 
			"3pl" => "ntām",	
		],
	];
	
	// 完了人称接尾辞
	protected $perfect_number = 
	[
		"active" => 
		[
			"1sg" => "a",
			"2sg" => "itha", 
			"3sg" => "a",
			"1du" => "iva",
			"2du" => "athus", 
			"3du" => "atus",			
			"1pl" => "ma",
			"2pl" => "a", 
			"3pl" => "us",	
		],
		"mediopassive" => 
		[
			"1sg" => "e",
			"2sg" => "ise", 
			"3sg" => "e",
			"1du" => "ivahai",
			"2du" => "āthe", 
			"3du" => "āte",			
			"1pl" => "imahe",
			"2pl" => "idhve", 
			"3pl" => "ire",	
		],	
	];

	// 希求法
	protected $opt = "yā";
	// 接続法
	protected $subj = "ā";

	// 未来能動分詞
	protected $future_participle_active = "";
	// 未来受動分詞
	protected $future_participle_passive = "";
	// 未来中動分詞
	protected $future_participle_middle = "";
	// 始動相能動分詞
	protected $inchorative_participle_active = "";
	// 始動相受動分詞
	protected $inchoative_participle_passive = "";
	// 始動相中動分詞
	protected $inchoative_participle_middle = "";
	// 結果相能動分詞
	protected $resultative_participle_active = "";
	// 結果相受動分詞
	protected $resultative_participle_passive = "";
	// 結果相中動分詞
	protected $resultative_participle_middle = "";	
	// 過去能動分詞
	protected $past_ta_participle_active = "";
	protected $past_na_participle_active = "";	
	// 過去受動分詞
	protected $past_ta_participle_passive = "";
	protected $past_na_participle_passive = "";
	// 一次動詞動形容詞
	protected $verbal_adjectives = array();
	// 一次動詞動不定詞
	protected $primary_infinitives = array();

	// 使役動詞不完了体能動分詞
	protected $present_causative_participle_active = "";
	// 使役動詞不完了体受動分詞
	protected $present_causative_participle_passive = "";
	// 使役動詞不完了体中動分詞
	protected $present_causative_participle_middle = "";	
	// 使役動詞完了体能動分詞
	protected $aorist_causative_participle_active = "";
	// 使役動詞完了体受動分詞
	protected $aorist_causative_participle_passive = "";
	// 使役動詞完了体中動分詞
	protected $aorist_causative_participle_middle = "";	
	// 使役動詞状態動詞能動分詞
	protected $perfect_causative_participle_active = "";
	// 使役動詞状態動詞受動分詞
	protected $perfect_causative_participle_passive = "";
	// 使役動詞状態動詞中動分詞
	protected $perfect_causative_participle_middle = "";	
	// 使役動詞未来能動分詞
	protected $future_causative_participle_active = "";
	// 使役動詞未来受動分詞
	protected $future_causative_participle_passive = "";
	// 使役動詞未来中動分詞
	protected $future_causative_participle_middle = "";
	// 使役過去能動分詞
	protected $past_causative_ta_participle_active = "";
	protected $past_causative_na_participle_active = "";	
	// 使役過去受動分詞
	protected $past_causative_ta_participle_passive = "";
	protected $past_causative_na_participle_passive = "";
	// 使役動詞動形容詞
	protected $causative_verbal_adjectives = array();
	// 使役動詞動不定詞
	protected $causative_infinitives = array();		

	// 願望動詞不完了体能動分詞
	protected $present_desiderative_participle_active = "";
	// 願望動詞不完了体受動分詞
	protected $present_desiderative_participle_passive = "";
	// 願望動詞不完了体中動分詞
	protected $present_desiderative_participle_middle = "";	
	// 願望動詞完了体能動分詞
	protected $aorist_desiderative_participle_active = "";
	// 願望動詞完了体中動分詞
	protected $aorist_desiderative_participle_middle = "";		
	// 願望動詞未来能動分詞
	protected $future_desiderative_participle_active = "";
	// 願望動詞未来中動分詞
	protected $future_desiderative_participle_middle = "";
	// 願望過去能動分詞
	protected $past_desiderative_ta_participle_active = "";
	protected $past_desiderative_na_participle_active = "";	
	// 願望過去受動分詞
	protected $past_desiderative_ta_participle_passive = "";
	protected $past_desiderative_na_participle_passive = "";
	// 願望動詞動形容詞
	protected $desiderative_verbal_adjectives = array();	
	// 願望動詞動不定詞
	protected $desiderative_infinitives = array();

	// 強意動詞不完了体能動分詞
	protected $present_intensive_participle_active = "";
	// 強意動詞不完了体受動分詞
	protected $present_intensive_participle_passive = "";
	// 強意動詞不完了体中動分詞
	protected $present_intensive_participle_middle = "";	
	// 強意動詞完了体能動分詞
	protected $aorist_intensive_participle_active = "";
	// 強意動詞完了体中動分詞
	protected $aorist_intensive_participle_middle = "";		
	// 強意動詞未来能動分詞
	protected $future_intensive_participle_active = "";
	// 強意動詞未来中動分詞
	protected $future_intensive_participle_middle = "";
	// 強意過去能動分詞
	protected $past_intensive_ta_participle_active = "";
	protected $past_intensive_na_participle_active = "";	
	// 強意過去受動分詞
	protected $past_intensive_ta_participle_passive = "";
	protected $past_intensive_na_participle_passive = "";	
	// 願望動詞動形容詞
	protected $intensive_verbal_adjectives = array();	
	// 強意動詞動不定詞
	protected $intensive_infinitives = array();

	// 使役+願望動詞不完了体能動分詞
	protected $present_causative_desiderative_participle_active = "";
	// 使役+願望動詞不完了体受動分詞
	protected $present_causative_desiderative_participle_passive = "";
	// 使役+願望動詞不完了体中動分詞
	protected $present_causative_desiderative_participle_middle = "";	
	// 使役+願望動詞完了体能動分詞
	protected $aorist_causative_desiderative_participle_active = "";
	// 使役+願望動詞完了体中動分詞
	protected $aorist_causative_desiderative_participle_middle = "";		
	// 使役+願望動詞未来能動分詞
	protected $future_causative_desiderative_participle_active = "";
	// 使役+願望動詞未来中動分詞
	protected $future_causative_desiderative_participle_middle = "";
	// 使役+願望過去能動分詞
	protected $past_causative_desiderative_ta_participle_active = "";
	protected $past_causative_desiderative_na_participle_active = "";	
	// 使役+願望過去受動分詞
	protected $past_causative_desiderative_ta_participle_passive = "";
	protected $past_causative_desiderative_na_participle_passive = "";
	// 使役+願望動詞動形容詞
	protected $causative_desiderative_verbal_adjectives = array();	
	// 使役+願望動詞動不定詞
	protected $causative_desiderative_infinitives = array();

	// 願望+使役動詞不完了体能動分詞
	protected $present_desiderative_causative_participle_active = "";
	// 願望+使役動詞不完了体受動分詞
	protected $present_desiderative_causative_participle_passive = "";
	// 願望+使役動詞不完了体中動分詞
	protected $present_desiderative_causative_participle_middle = "";	
	// 願望+使役動詞完了体能動分詞
	protected $aorist_desiderative_causative_participle_active = "";
	// 願望+使役動詞完了体受動分詞
	protected $aorist_desiderative_causative_participle_passive = "";
	// 願望+使役動詞完了体中動分詞
	protected $aorist_desiderative_causative_participle_middle = "";	
	// 願望+使役動詞状態動詞能動分詞
	protected $perfect_desiderative_causative_participle_active = "";
	// 願望+使役動詞状態動詞受動分詞
	protected $perfect_desiderative_causative_participle_passive = "";
	// 願望+使役動詞状態動詞中動分詞
	protected $perfect_desiderative_causative_participle_middle = "";	
	// 願望+使役動詞未来能動分詞
	protected $future_desiderative_causative_participle_active = "";
	// 願望+使役動詞未来受動分詞
	protected $future_desiderative_causative_participle_passive = "";
	// 願望+使役動詞未来中動分詞
	protected $future_desiderative_causative_participle_middle = "";
	// 願望+使役過去能動分詞
	protected $past_desiderative_causative_ta_participle_active = "";
	protected $past_desiderative_causative_na_participle_active = "";	
	// 願望+使役過去受動分詞
	protected $past_desiderative_causative_ta_participle_passive = "";
	protected $past_desiderative_causative_na_participle_passive = "";
	// 願望+使役動詞動形容詞
	protected $desiderative_causative_verbal_adjectives = array();
	// 願望+使役動詞動不定詞
	protected $desiderative_causative_infinitives = array();		

	// 強意+使役動詞不完了体能動分詞
	protected $present_intensive_causative_participle_active = "";
	// 強意+使役動詞不完了体受動分詞
	protected $present_intensive_causative_participle_passive = "";
	// 強意+使役動詞不完了体中動分詞
	protected $present_intensive_causative_participle_middle = "";	
	// 強意+使役動詞完了体能動分詞
	protected $aorist_intensive_causative_participle_active = "";
	// 強意+使役動詞完了体受動分詞
	protected $aorist_intensive_causative_participle_passive = "";
	// 強意+使役動詞完了体中動分詞
	protected $aorist_intensive_causative_participle_middle = "";	
	// 強意+使役動詞状態動詞能動分詞
	protected $perfect_intensive_causative_participle_active = "";
	// 強意+使役動詞状態動詞受動分詞
	protected $perfect_intensive_causative_participle_passive = "";
	// 強意+使役動詞状態動詞中動分詞
	protected $perfect_intensive_causative_participle_middle = "";	
	// 強意+使役動詞未来能動分詞
	protected $future_intensive_causative_participle_active = "";
	// 強意+使役動詞未来受動分詞
	protected $future_intensive_causative_participle_passive = "";
	// 強意+使役動詞未来中動分詞
	protected $future_intensive_causative_participle_middle = "";
	// 強意+使役過去能動分詞
	protected $past_intensive_causative_ta_participle_active = "";
	protected $past_intensive_causative_na_participle_active = "";	
	// 強意+使役過去受動分詞
	protected $past_intensive_causative_ta_participle_passive = "";
	protected $past_intensive_causative_na_participle_passive = "";
	// 強意+使役動詞動形容詞
	protected $intensive_causative_verbal_adjectives = array();
	// 強意+使役動詞動不定詞
	protected $intensive_causative_infinitives = array();

	// 強意+願望動詞不完了体能動分詞
	protected $present_intensive_desiderative_participle_active = "";
	// 強意+願望動詞不完了体受動分詞
	protected $present_intensive_desiderative_participle_passive = "";
	// 強意+願望動詞不完了体中動分詞
	protected $present_intensive_desiderative_participle_middle = "";	
	// 強意+願望動詞完了体能動分詞
	protected $aorist_intensive_desiderative_participle_active = "";
	// 強意+願望動詞完了体中動分詞
	protected $aorist_intensive_desiderative_participle_middle = "";		
	// 強意+願望動詞未来能動分詞
	protected $future_intensive_desiderative_participle_active = "";
	// 強意+願望動詞未来中動分詞
	protected $future_intensive_desiderative_participle_middle = "";
	// 強意+願望過去能動分詞
	protected $past_intensive_desiderative_ta_participle_active = "";
	protected $past_intensive_desiderative_na_participle_active = "";	
	// 強意+願望過去受動分詞
	protected $past_intensive_desiderative_ta_participle_passive = "";
	protected $past_intensive_desiderative_na_participle_passive = "";
	// 強意+願望動詞動形容詞
	protected $intensive_desiderative_verbal_adjectives = array();	
	// 強意+願望動詞動不定詞
	protected $intensive_desiderative_infinitives = array();

	// 活用種別-不完了体
	protected $conjugation_present_type = "";

	// 活用種別-語根種別
	protected $root_laryngeal_flag = "";

	// 欠如-未来形
	protected $deponent_future = "";	

	// 追加語幹
	protected $add_stem = "";

	// 受動態語尾
	protected const passive_suffix = "ya";

	// 過去接尾辞
	protected const and_then_prefix = "a";

	// アオリスト接尾辞
	protected const aorist_is_suffix = "is";

	// 未来形接尾辞
	protected const future_suffix1 = "sya";

	// 未来形接尾辞
	protected const future_suffix2 = "isya";

	// 名詞起源動詞接尾辞
	protected const denomitive_suffix = "aya";

	// 使役動詞接尾辞
	protected const causative_suffix = "ay";

	// 能動態分詞接尾辞
	protected const active_participle_suffix1 = "at";

	// 能動態分詞接尾辞2
	protected const active_participle_suffix2 = "t";

	// 中動態分詞接尾辞
	protected const middle_participle_suffix1 = "māma";

	// 中動態分詞接尾辞2
	protected const middle_participle_suffix2 = "āna";

	// 過去分詞接尾辞1
	protected const past_participle_suffix1 = "ta";

	// 過去分詞接尾辞2
	protected const past_participle_suffix2 = "na";

	// 過去分詞派生接尾辞2
	protected const past_participle_add_suffix = "vat";

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

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_sanskrit1($dic_stem) {
    	// 動詞情報を取得
		$this->get_verb_data($dic_stem);

		// 各動詞の語幹を作成
		$this->make_each_stems($this->root);				// 一次動詞
		$this->make_each_causative_stems($this->root);		// 使役動詞
		$this->make_each_desiderative_stems($this->root);	// 願望動詞
		$this->make_each_intensive_stems($this->root);		// 強意動詞
		$this->make_each_causative_desiderative_stems($this->root);	// 使役+願望動詞
		$this->make_each_intensive_desiderative_stems($this->root);	// 強意+願望動詞
		$this->make_each_desiderative_causative_stems($this->root);	// 使役+願望動詞
		$this->make_each_intensive_causative_stems($this->root);	// 強意+願望動詞
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct_sanskrit3($dic_stem, $noun_stem, $translation) {
    	// 動詞情報を取得
		$this->get_verb_data($dic_stem);
		// 名詞語幹を追加
		$this->add_stem = $noun_stem;
		// 各動詞の語幹を作成
		$this->make_each_stems($this->root);				// 一次動詞
		$this->make_each_causative_stems($dic_stem);		// 使役動詞
		$this->make_each_desiderative_stems($dic_stem);		// 願望動詞
		$this->make_each_intensive_stems($dic_stem);		// 強意動詞
		$this->make_each_causative_desiderative_stems($dic_stem);	// 使役+願望動詞
		$this->make_each_intensive_desiderative_stems($dic_stem);	// 強意+願望動詞
		$this->make_each_desiderative_causative_stems($dic_stem);	// 使役+願望動詞
		$this->make_each_intensive_causative_stems($dic_stem);		// 強意+願望動詞
		// 翻訳を変更
		$this->japanese_translation	= $translation;
		$this->english_translation = "compound verb";
    }

    // 動詞情報を取得
    protected function get_verb_data($dic_stem){
    	// 名詞情報を取得
		$word_info = $this->get_verb_from_DB($dic_stem, Sanskrit_Common::DB_VERB);

		// データがある場合は
		if($word_info){
			// 語根を取得
			$this->root = $word_info["root"];
			// 動詞種別を取得
			$this->root_type = $word_info["root_type"];
			$this->root_laryngeal_flag = $word_info["root_laryngeal_flag"];
			// 活用種別
			$this->conjugation_present_type = $word_info["conjugation_present_type"];	
			// 訳
			$this->japanese_translation = $word_info["japanese_translation"];
			$this->english_translation = $word_info["english_translation"];
			// 欠如フラグ
			$this->deponent_active = $word_info["deponent_active"];
			$this->deponent_mediopassive = $word_info["deponent_mediopassive"];
			$this->deponent_present = $word_info["deponent_present"];
			$this->deponent_aorist = $word_info["deponent_aorist"];
			$this->deponent_perfect = $word_info["deponent_perfect"];
			$this->deponent_future = $word_info["deponent_future"];
			// 追加語幹
			$this->add_stem	= $word_info["add_stem"];
		} else {
			// データを挿入
			$this->root = $dic_stem;		//現在相
			// 動詞種別を取得
			$this->root_type = Commons::PRESENT_ASPECT;
			// 喉音フラグ
			if(preg_match("/[aiuṛāīūṝ]x$/u", $this->root)){
				$this->root_laryngeal_flag = Commons::$TRUE;	
			} else {
				$this->root_laryngeal_flag = Commons::$FALSE;
			}
			// 活用種別
			if(preg_match("/[aiuāīū]$/u", $this->root)){
				// 母音語幹の場合は2
				$this->conjugation_present_type = "2";		
			} else {
				// それ以外は1
				$this->conjugation_present_type = "1";	
			}
		}
    }
 
	// 各語幹を取得
    private function make_each_stems($root){
		// 現在相
		if($this->deponent_present != Commons::$TRUE){
			// 活用種別ごとに分ける。
			switch ($this->conjugation_present_type) {
			    case 1:
					// 子音が連続している場合はそのまま
					if(!preg_match("/[bpkghcjlrtdḍṭmnṅñṃṇśṣs][bpkgcjlrtdḍṭmnṅñṃṇśṣs]$/", $root)){
						$this->present_stem = Sanskrit_Common::change_vowel_grade($root, Sanskrit_Common::GUNA)."a";
					} else {
						$this->present_stem = $root."a";
					}
					break;
			    case 2:
					$this->present_stem = Sanskrit_Common::change_vowel_grade($root, Sanskrit_Common::GUNA);
			        break;
			    case "3t":
					// 重複語幹作成
					$add_stem = $this->make_redumplicatation_addtion($root);
					// 語頭の子音を取り出して、重複語幹を作成			
					$this->present_stem = mb_substr($add_stem, 0, 1)."i".$root;
			        break;
			    case 3:
					// 重複語幹作成
					$add_stem = $this->make_redumplicatation_addtion($root);
					// 語頭の子音を取り出して、重複語幹を作成				
					$this->present_stem = mb_substr($add_stem, 0, 1).preg_replace("/[ṛṝ]/u", "i", $this->get_vowel_in_root()).Sanskrit_Common::change_vowel_grade($root, Sanskrit_Common::GUNA);
			        break;
			    case 4:
					$this->present_stem = $root."ya";
			        break;
			    case 5:
					$this->present_stem = $root."no";
			        break;
			    case 6:
					$this->present_stem = $root."a";
			        break;
			    case "7t":
					$this->present_stem = mb_ereg_replace("^(.+)([bpkgcjlrtdḍṭmnṅñṇśṣsyv]|[bpkghcjlrtdḍṭ]h)$", "\\1m\\2", $root);
			        break;
			    case "7t2":
					$this->present_stem = mb_ereg_replace("^(.+)([bpkgcjlrtdḍṭmnṅñṇśṣsyv]|[bpkghcjlrtdḍṭ]h)$", "\\1n\\2", $root);
			        break;
			    case 7:
					$this->present_stem = mb_ereg_replace("^(.+)([bpkgcjlrtdḍṭmnṅñṇśṣsyv]|[bpkghcjlrtdḍṭ]h)$", "\\1na\\2", mb_ereg_replace("^(.+)(n|ñ|ṅ)", "\\1", $root));
			        break;
			    case 8:
					$this->present_stem = $root."o";
			        break;
			    case 9:
					$this->present_stem = mb_ereg_replace("^(.+)(n|ñ|ṅ)", "\\1", $root)."nā";
			        break;
			    case 10:
					// 子音が連続している場合はそのまま
					if(!preg_match("/[bpkghcjlrtdḍṭmnṅñṃṇśṣs][bpkgcjlrtdḍṭmnṅñṃṇśṣs]$/u", $root)){
						$this->present_stem = Sanskrit_Common::change_vowel_grade($root, Sanskrit_Common::GUNA).self::denomitive_suffix;
					} else {
						$this->present_stem = $root.self::denomitive_suffix;
					}
			        break;
			    case Commons::NOUN_VERB:
					$this->present_stem = $root."a";
			        break;						
				default:
					$this->present_stem = $root."a";			
					break;														
			}
			// 現在分詞
			if(preg_match('(2|3|5|7|8|9)',$this->conjugation_present_type)){
				// 子音活用動詞	
				// 共通語幹を作成
				$common_participle_stme = $this->add_stem.Sanskrit_Common::change_vowel_grade($this->present_stem, Sanskrit_Common::ZERO_GRADE);
			} else {
				// 母音活用動詞
				// 共通語幹を作成
				$common_participle_stme = $this->add_stem.$this->present_stem;
			}

			// 能動分詞
			if($this->deponent_active != Commons::$TRUE){
				// 現在分詞
				if(preg_match('(2|3|5|7|8|9)',$this->conjugation_present_type)){
					// 子音活用動詞	
					$this->present_participle_active = Sanskrit_Common::sandhi_engine($common_participle_stme, self::active_participle_suffix1);
				} else {
					// 母音活用動詞
					$this->present_participle_active = Sanskrit_Common::sandhi_engine($common_participle_stme, self::active_participle_suffix2);
				}
			}
			
			// 中動分詞
			if($this->deponent_mediopassive != Commons::$TRUE){
				$this->present_participle_middle = Sanskrit_Common::sandhi_engine($common_participle_stme, self::middle_participle_suffix2);		// 中動態
				$this->present_participle_passive = $this->add_stem.Sanskrit_Common::sandhi_engine(Sanskrit_Common::sandhi_engine(Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::ZERO_GRADE), self::passive_suffix, true, false), "māma");	// 受動態
			}				
		}

		// 名詞起源動詞以外の場合は
		if($this->conjugation_present_type != Commons::NOUN_VERB){

			// 完了形
			if($this->deponent_present != Commons::$TRUE){
				// 重複語幹作成
				$add_stem = $this->make_redumplicatation_addtion($root);
				$add_stem = mb_substr($add_stem, 0, 2);		
				// 強語幹で重複する。
				$add_stem = Sanskrit_Common::change_vowel_grade(mb_ereg_replace("[ṛṝ]", "a", $add_stem), Sanskrit_Common::ZERO_GRADE);	
				// 完了形を作る	
				$this->perfect_stem = $add_stem.Sanskrit_Common::change_vowel_grade($root, Sanskrit_Common::GUNA);

				// 能動分詞
				if($this->deponent_active != Commons::$TRUE){
					// 能動形がある場合のみ作成
					$this->perfect_participle_active = $this->add_stem.Sanskrit_Common::sandhi_engine($this->get_weak_perfect_stem(Sanskrit_Common::ZERO_GRADE), "vas");		// 能動態
				}

				// 中動分詞
				if($this->deponent_mediopassive != Commons::$TRUE){
					// 中動形がある場合のみ作成
					$this->perfect_participle_passive = $this->add_stem.Sanskrit_Common::sandhi_engine($this->get_weak_perfect_stem(Sanskrit_Common::ZERO_GRADE), self::middle_participle_suffix2);		// 受動態
					$this->perfect_participle_middle = $this->add_stem.Sanskrit_Common::sandhi_engine($this->get_weak_perfect_stem(Sanskrit_Common::ZERO_GRADE), self::middle_participle_suffix2);		// 中動態		
				}
			}

			// 始動相
			if($this->deponent_present != Commons::$TRUE){
				// 現在形がある場合のみ作成
				// 文字によって分ける
				if(preg_match("/[kgcj]$/u", $this->root)){
					// kgで始まる場合は
					$this->inchorative_stem = Sanskrit_Common::sandhi_engine(preg_replace("/[kgcj]$/u", "", $root), "śca");		//mnは消す。
				} else {
					// それ以外は
					$this->inchorative_stem = Sanskrit_Common::sandhi_engine(preg_replace("/[mnśṣs]$/u", "c", $root), "cha");		//mnは消す。
				}

				// 能動分詞
				if($this->deponent_active != Commons::$TRUE){
					$this->inchorative_participle_active = $this->add_stem.Sanskrit_Common::change_vowel_grade($this->inchorative_stem, self::active_participle_suffix2);		// 能動態
				}

				// 中動分詞
				if($this->deponent_mediopassive != Commons::$TRUE){
					$this->inchoative_participle_middle = $this->add_stem.Sanskrit_Common::change_vowel_grade($this->inchorative_stem, self::middle_participle_suffix1);		// 中動態
				}
			}

			// 結果相
			if(preg_match("/dh$/", $this->root)){
				// dhで終わる場合は(語根に結合している場合は)
				$this->resultative_stem = Sanskrit_Common::sandhi_engine($root, "ā");
			} else {
				// それ以外は
				$this->resultative_stem = Sanskrit_Common::sandhi_engine($root, "dhā");
			}

			// 能動分詞
			if($this->deponent_active != Commons::$TRUE){
				$this->resultative_participle_active = $this->add_stem.Sanskrit_Common::change_vowel_grade($this->resultative_stem, self::active_participle_suffix2);		// 能動態
			}

			// 中動分詞
			if($this->deponent_mediopassive != Commons::$TRUE){
				$this->resultative_participle_middle = $this->add_stem.Sanskrit_Common::change_vowel_grade($this->resultative_stem, self::middle_participle_suffix1);		// 中動態			
			}
		}

		// 完了体
		// 語根の種別で分ける
		if($this->deponent_aorist != Commons::$TRUE){
			// 語根の種別で区別
			if($this->root_type == Commons::PRESENT_ASPECT){
				// 喉音フラグで判定(anitはなし、setはあり)
				if($this->conjugation_present_type == "10"){
					// 第10類動詞
					$this->aorist_stem = mb_substr($root, 0, 1).$this->get_vowel_in_root().$root."a";	// 完結相
				} else if(preg_match("/(ā|ai)$/u", $root)){
					// āとaiで終わる場合はs(is)アオリスト
					$this->aorist_stem = Sanskrit_Common::sandhi_engine($root, "sis", true, false);					// 完結相
				} else if(preg_match("/(ai|au|[iīuūeoṛṝ])[bpkghcjtdḍṭmnṅñṃṇ]*([śṣh])$/u", $root) &&
					      !preg_match("/(bh|ph|kh|gh|dh|th|ḍh|ṭh)$/u", $root)){
					// aを含まず、ś,ṣ,hで終わる場合はsaアオリスト
					$this->aorist_stem = Sanskrit_Common::sandhi_engine($root, "sa", true, false);					// 完結相
				} else if($this->root_laryngeal_flag != Commons::$TRUE){
					// anit語根
					$this->aorist_stem = Sanskrit_Common::sandhi_engine($root, "s", true, false);					// 完結相
				} else if($this->root_laryngeal_flag == Commons::$TRUE){
					// sat語根
					$this->aorist_stem = Sanskrit_Common::sandhi_engine($root, self::aorist_is_suffix, true, false);					// 完結相
				}
			} else if($this->conjugation_present_type == Commons::NOUN_VERB) {
				// 名詞起源動詞
				// 完了相(重複アオリスト)
				// 重複語幹作成
				$add_stem = $this->make_redumplicatation_addtion($this->add_stem);
				$add_stem = mb_substr($add_stem, 0, 1);				
				// 語幹を作成
				$this->perfect_stem = $add_stem."i".$this->add_stem;
				// 分詞を作成
				// 能動分詞
				if($this->deponent_active != Commons::$TRUE){
					$this->perfect_participle_active = $this->add_stem.Sanskrit_Common::sandhi_engine($this->perfect_stem, self::active_participle_suffix1);
				}
				// 中動分詞
				if($this->deponent_mediopassive != Commons::$TRUE){
					$this->perfect_participle_middle = $this->add_stem.Sanskrit_Common::sandhi_engine($this->perfect_stem, self::middle_participle_suffix1);
					$this->perfect_participle_passive = $this->perfect_participle_middle;
				}
				// 完結相				
				$this->aorist_stem = Sanskrit_Common::sandhi_engine("ay", self::aorist_is_suffix, true, false);		
			} else if($this->root_type == Commons::NOUN_VERB) {
				// 名詞起源動詞(語根から)
				// 完結相(重複アオリスト)
				// 重複語幹作成
				$add_stem = $this->make_redumplicatation_addtion($this->add_stem);
				$add_stem = mb_substr($add_stem, 0, 1);
				$this->aorist_stem = $add_stem."i".$this->add_stem;
			} else if($this->root_type == Commons::AORIST_ASPECT) {
				// 喉音フラグで判定(anitはなし、setはあり)
				if($this->root_laryngeal_flag == Commons::$TRUE){
					$this->aorist_stem = $root;			//完結相
				} else if($this->root_laryngeal_flag != Commons::$TRUE){
					$this->aorist_stem = $root."a";		//完結相
				}
			}

			// 完了体語幹
			// 能動分詞
			if($this->deponent_active != Commons::$TRUE){
				$this->aorist_participle_active = $this->add_stem.Sanskrit_Common::sandhi_engine($this->aorist_stem, self::active_participle_suffix1);		// 能動態
			}

			// 中動分詞
			if($this->deponent_mediopassive != Commons::$TRUE){
				$this->aorist_participle_middle = $this->add_stem.Sanskrit_Common::sandhi_engine($this->aorist_stem, self::middle_participle_suffix1);		// 中動態
				// 母音で終わる動詞は専用の受動態分詞を作る		
				if(preg_match("/[aiuṛāīūṝ]$/u", $this->root)){
					$this->aorist_participle_passive = $this->add_stem.Sanskrit_Common::sandhi_engine(Sanskrit_Common::sandhi_engine(Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI), "yis"), self::middle_participle_suffix1);
				} else if(preg_match("/(dṛś|han|grah)/u", $this->root)){
					// 一部の語根も対象
					$this->aorist_participle_passive = $this->add_stem.Sanskrit_Common::sandhi_engine(Sanskrit_Common::sandhi_engine(Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI), "yis"), self::middle_participle_suffix1);
				} else {
					// それ以外は中動態と同じ
					$this->aorist_participle_passive = $this->aorist_participle_middle;		
				}
			}
		}

		// 未然相
		if($this->deponent_future != Commons::$TRUE){
			// 未来語幹
			// 最後の音に基づいて語幹を作成
			if(preg_match("/[aiuāī]$/u", $this->root)){
				// 母音で終わる場合は
				$this->future_stem = Sanskrit_Common::sandhi_engine($root, self::future_suffix1, false, false);			//未然相
			} else if(preg_match("/[bpkgcjtdmnṅñṃṇ]$/u", $this->root)){
				// 子音で終わる場合は		
				$this->future_stem = $root.self::future_suffix2;		//未然相
			} else if(preg_match("/[śṣs]$/u", $this->root)){
				// 摩擦音の場合は
				$this->future_stem = Sanskrit_Common::sandhi_engine($root, self::future_suffix1, false, false);			//未然相
			} else if(preg_match("/[bpkgcjtd]h$/u", $this->root) || preg_match("/[rṛṝlḷḹ]$/u", $this->root) || preg_match("/h$/u", $this->root)){
				// 帯気音・流音・喉音の場合は
				$this->future_stem = $root.self::future_suffix2;		//未然相		
			} else {
				// それ以外
				$this->future_stem = Sanskrit_Common::sandhi_engine($root, self::future_suffix1, false, false);			//未然相
			}

			// 能動分詞
			if($this->deponent_active != Commons::$TRUE){
				$this->future_participle_active = $this->add_stem.Sanskrit_Common::sandhi_engine($this->future_stem, self::active_participle_suffix2);	// 能動態	
			}

			// 中動分詞
			if($this->deponent_mediopassive != Commons::$TRUE){
				$this->future_participle_middle = $this->add_stem.Sanskrit_Common::sandhi_engine($this->future_stem, self::middle_participle_suffix1);		// 中動態
				// 母音で終わる動詞は専用の受動態分詞を作る		
				if(preg_match("/[aiuṛāīūṝ]$/u", $this->root)){
					// 未来分詞
					$this->future_participle_passive = $this->add_stem.Sanskrit_Common::sandhi_engine(Sanskrit_Common::sandhi_engine(Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI), self::future_suffix2), self::middle_participle_suffix1);
				} else if(preg_match("/(dṛś|han|grah)/u", $this->root)){
					// 一部の語根も対象
					$this->future_participle_passive = $this->add_stem.Sanskrit_Common::sandhi_engine(Sanskrit_Common::sandhi_engine(Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI), self::future_suffix2), self::middle_participle_suffix1);				
				} else {	
					$this->future_participle_passive = $this->future_participle_middle;		// 未来分詞
				}
			}
		}

		// 過去分詞
		$this->past_ta_participle_passive = $this->add_stem.Sanskrit_Common::sandhi_engine(preg_replace("/[mnṅñṃṇ]$/u", "", $root), self::past_participle_suffix1);
		$this->past_na_participle_passive  = $this->add_stem.Sanskrit_Common::sandhi_engine($root, self::past_participle_suffix2);		
		$this->past_ta_participle_active = $this->past_ta_participle_passive.self::past_participle_add_suffix;
		$this->past_na_participle_active  = $this->past_na_participle_passive.self::past_participle_add_suffix;

		// 動形容詞
		$this->verbal_adjectives[] = $this->past_ta_participle_passive."vya";
		$this->verbal_adjectives[] = Sanskrit_Common::sandhi_engine($this->add_stem.$root, "ya");
		$this->verbal_adjectives[] = Sanskrit_Common::sandhi_engine($this->add_stem.$root, "ata");		
		$this->verbal_adjectives[] = Sanskrit_Common::sandhi_engine($this->add_stem.$root, "anīya");
		$this->verbal_adjectives[] = Sanskrit_Common::sandhi_engine($this->add_stem.$root, "enya");
		$this->verbal_adjectives[] = Sanskrit_Common::sandhi_engine($this->add_stem.$root, "āyya");

		// 不定詞
		$this->primary_infinitives[] = Sanskrit_Common::sandhi_engine($this->add_stem, $root);														// 語根
		$this->primary_infinitives[] = Sanskrit_Common::sandhi_engine($this->add_stem.preg_replace("/[mnṅñṃṇ]$/u", "", $root), "dhi");				// 語根dhi(中動態)不定詞		
		$this->primary_infinitives[] = Sanskrit_Common::sandhi_engine($this->add_stem.$root, "tu");													// 語根tu不定詞
		$this->primary_infinitives[] = Sanskrit_Common::sandhi_engine($this->add_stem.$this->present_stem, "itu");									// 不完了体tu不定詞
		$this->primary_infinitives[] = Sanskrit_Common::sandhi_engine($this->add_stem.$this->inchorative_stem, "tu");								// 始動動詞tu不定詞
		$this->primary_infinitives[] = Sanskrit_Common::sandhi_engine($this->add_stem.$this->resultative_stem, "tu");								// 結果動詞tu不定詞
		$this->primary_infinitives[] = Sanskrit_Common::sandhi_engine($this->add_stem.preg_replace("/[mnṅñṃṇ]$/u", "", $root), "ti");					// 語根tiスラブ式不定詞
		$this->primary_infinitives[] = Sanskrit_Common::sandhi_engine($this->add_stem.preg_replace("/[mnṅñṃṇ]$/u", "", $this->present_stem), "ti");		// 不完了体tiスラブ式不定詞
		$this->primary_infinitives[] = Sanskrit_Common::sandhi_engine($this->add_stem.$this->inchorative_stem, "ti");								// 始動動詞tiスラブ式不定詞
		$this->primary_infinitives[] = Sanskrit_Common::sandhi_engine($this->add_stem.$this->resultative_stem, "ti");								// 結果動詞tiスラブ式不定詞
		$this->primary_infinitives[] = Sanskrit_Common::sandhi_engine($this->add_stem.$root, "as");													// 語根asギリシア・ラテン式不定詞
		$this->primary_infinitives[] = Sanskrit_Common::sandhi_engine($this->add_stem.$this->aorist_stem, "as");									// 完了体asギリシア・ラテン式不定詞

    }

	// 使役語幹を作る
    private function make_each_causative_stems($root){

		// 初期化
		$prefix = "";
		// 使役用語幹
		if($this->conjugation_present_type == Commons::NOUN_VERB){
			// 名詞起源動詞		
			$common_causative_stem = Sanskrit_Common::sandhi_engine($this->add_stem, "ay");
		} else {
			// それ以外は強語幹にする。
			$common_causative_stem = Sanskrit_Common::change_vowel_grade($root, Sanskrit_Common::VRIDDHI);
			// āで終わる動詞はpを加える。
			if(preg_match("/ā$/", $this->root)){
				$common_causative_stem = $common_causative_stem."p";
			}
			// 接頭辞を入れる。
			$prefix = $this->add_stem;
		}		
		// 現在相
		$this->present_causative_stem = Sanskrit_Common::sandhi_engine($common_causative_stem, self::causative_suffix."a", false, false);
		
		// 完了体・完了形
		// 重複語幹を作る。
		$add_stem = mb_ereg_replace("/([bpkgcjtd])h/", "\\1", $root);
		$add_stem = mb_ereg_replace("k", "c", $add_stem);
		$add_stem = mb_ereg_replace("[hg]", "j", $add_stem);

		$this->perfect_causative_stem = mb_substr($common_causative_stem, 0, 1)."i".$root."a";									// 完了形
		$this->aorist_causative_stem = Sanskrit_Common::sandhi_engine($common_causative_stem.self::causative_suffix, self::aorist_is_suffix, false, false);			// 完了体
		
		// 未然相
		$this->future_causative_stem = Sanskrit_Common::sandhi_engine($common_causative_stem.self::causative_suffix, self::future_suffix2, false, false);		//未然相

		// 現在分詞
		$this->present_causative_participle_active = $prefix.$common_causative_stem.self::causative_suffix.self::active_participle_suffix1;			// 能動態
		$this->present_causative_participle_middle = $prefix.$this->present_causative_stem.self::middle_participle_suffix1;		// 中動態
		$this->present_causative_participle_passive = $prefix.$common_causative_stem.self::passive_suffix.self::middle_participle_suffix1;		// 受動態

		// 完了体分詞
		$this->aorist_causative_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->aorist_causative_stem, self::active_participle_suffix1);			// 能動態
		$this->aorist_causative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->aorist_causative_stem, self::middle_participle_suffix1);		// 中動態
		$this->aorist_causative_participle_passive = $prefix.Sanskrit_Common::sandhi_engine($common_causative_stem.self::aorist_is_suffix, self::middle_participle_suffix1);		// 受動態	

		// 完了形分詞
		$this->perfect_causative_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->perfect_causative_stem, self::active_participle_suffix1);		// 能動態
		$this->perfect_causative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->perfect_causative_stem, self::middle_participle_suffix1);		// 中動態

		// 未来分詞
		$this->future_causative_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->future_causative_stem, self::active_participle_suffix1);			// 能動態
		$this->future_causative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->future_causative_stem, self::middle_participle_suffix1);		// 中動態
		$this->future_causative_participle_passive = $prefix.Sanskrit_Common::sandhi_engine($common_causative_stem.self::future_suffix2, self::middle_participle_suffix1);		// 受動態

		// 過去分詞
		$this->past_causative_ta_participle_passive = $prefix.Sanskrit_Common::sandhi_engine($common_causative_stem, "i".self::past_participle_suffix1);
		$this->past_causative_na_participle_passive  = $prefix.Sanskrit_Common::sandhi_engine($common_causative_stem, self::past_participle_suffix2);
		$this->past_causative_ta_participle_active = $this->past_causative_ta_participle_passive.self::past_participle_add_suffix;
		$this->past_causative_na_participle_active  = $this->past_causative_na_participle_passive.self::past_participle_add_suffix;

		// 動形容詞
		$this->causative_verbal_adjectives[] = $this->past_causative_ta_participle_passive."vya";
		$this->causative_verbal_adjectives[] = Sanskrit_Common::sandhi_engine($prefix.$common_causative_stem, "ya");
		$this->causative_verbal_adjectives[] = Sanskrit_Common::sandhi_engine($prefix.$common_causative_stem, "anīya");	
		
		// 不定詞	
		$this->causative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix, $common_causative_stem);					// 語根		
		$this->causative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.preg_replace("/[mnṅñṃṇ]$/u", "", $this->present_causative_stem), "dhi");		// dhi(中動態)不定詞		
		$this->causative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$common_causative_stem, "tu");				// 語根tu不定詞
		$this->causative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$common_causative_stem.self::causative_suffix, "itu");		// 不完了体tu不定詞
		$this->causative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.preg_replace("/[mnṅñṃṇ]$/u", "", $this->present_causative_stem), "ti");		// 不完了体tiスラブ式不定詞
		$this->causative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$common_causative_stem, "as");				// 語根asギリシア・ラテン式不定詞
		$this->causative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$this->aorist_causative_stem, "as");		// 完了体asギリシア・ラテン式不定詞		
		$this->causative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$this->perfect_causative_stem, "as");		// 完了形asギリシア・ラテン式不定詞	
    }

	// 願望語幹を作る
    private function make_each_desiderative_stems($root){

		// 初期化
		$prefix = "";
		// 名詞起源動詞	
		if($this->root_type == Commons::NOUN_VERB){
			// 名詞と動詞接尾辞を結合	
			$root= Sanskrit_Common::sandhi_engine($this->add_stem, $root);
		} else {
			// 接頭辞を入れる。
			$prefix = $this->add_stem;
		}
		// 重複語幹を作る。
		$add_stem = $this->make_redumplicatation_addtion($root);		
		// iで重複する。
		$add_stem = mb_substr($add_stem, 0, 1).mb_ereg_replace("[ū]", "u", mb_ereg_replace("[aieoāīṛṝ]", "i", $this->get_vowel_in_root()));

		// 願望語幹
		$common_desiderative_stem = $add_stem.$root;

		// 現在相
		// 子音で判定
		if(!preg_match("/[bpkgcjlrtdḍṭmnṅñṃṇśṣs]$/", $root)){
			$this->present_desiderative_stem = Sanskrit_Common::sandhi_engine($common_desiderative_stem, "sa", false, false);
		} else if(preg_match("/[bpkgcjlrtdḍṭmnṅñṃṇśṣs]$/", $root)){
			$this->present_desiderative_stem = Sanskrit_Common::sandhi_engine($common_desiderative_stem, "isa", false, false);
		}
	
		// 完了体・完了形
		$this->aorist_desiderative_stem = Sanskrit_Common::sandhi_engine($common_desiderative_stem, "is".self::aorist_is_suffix, false, false);			// 完了体		
		$this->perfect_desiderative_stem = $this->present_desiderative_stem;										// 完了形
	
		// 未然相
		$this->future_desiderative_stem = Sanskrit_Common::sandhi_engine($common_desiderative_stem, self::aorist_is_suffix.self::future_suffix2, false, false);		//未然相

		// 現在分詞
		$this->present_desiderative_participle_active = $prefix.Sanskrit_Common::sandhi_engine(mb_substr($this->present_desiderative_stem, 0, -1), self::active_participle_suffix1);				// 能動態
		$this->present_desiderative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine(mb_substr($this->present_desiderative_stem, 0, -1), self::middle_participle_suffix1);				// 中動態
		$this->present_desiderative_participle_passive = $prefix.Sanskrit_Common::sandhi_engine(mb_substr($this->present_desiderative_stem, 0, -1).self::passive_suffix, self::middle_participle_suffix1);		// 受動態

		// 完了体分詞
		$this->aorist_desiderative_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->aorist_desiderative_stem, self::active_participle_suffix1);		// 能動態
		$this->aorist_desiderative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->aorist_desiderative_stem, self::middle_participle_suffix1);		// 中動態

		// 未来分詞
		$this->future_desiderative_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->future_desiderative_stem, self::active_participle_suffix1);		// 能動態
		$this->future_desiderative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->future_desiderative_stem, self::middle_participle_suffix1);		// 中動態

		// 過去分詞
		$this->past_desiderative_ta_participle_passive = $prefix.Sanskrit_Common::sandhi_engine($common_desiderative_stem, self::past_participle_suffix1);
		$this->past_desiderative_na_participle_passive  = $prefix.Sanskrit_Common::sandhi_engine($common_desiderative_stem, self::past_participle_suffix2);
		$this->past_desiderative_ta_participle_active = $this->past_desiderative_ta_participle_passive.self::past_participle_add_suffix;
		$this->past_desiderative_na_participle_active  = $this->past_desiderative_na_participle_passive.self::past_participle_add_suffix;

		// 動形容詞
		$this->desiderative_verbal_adjectives[] = $this->past_desiderative_ta_participle_passive."vya";
		$this->desiderative_verbal_adjectives[] = Sanskrit_Common::sandhi_engine($prefix.$common_desiderative_stem, "ya");
		$this->desiderative_verbal_adjectives[] = Sanskrit_Common::sandhi_engine($prefix.$common_desiderative_stem, "anīya");

		// 不定詞	
		$this->desiderative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$common_desiderative_stem, "itu");			// 語根tu不定詞
		$this->desiderative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$this->present_desiderative_stem, "itu");	// 不完了体tu不定詞
		$this->desiderative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$this->present_desiderative_stem, "ti");		// 不完了体tiスラブ式不定詞
    }

	// 強意語幹を作る
    private function make_each_intensive_stems($root){

		// 初期化
		$prefix = "";
		// 名詞起源動詞	
		if($this->root_type == Commons::NOUN_VERB){
			// 名詞と動詞接尾辞を結合	
			$root= Sanskrit_Common::sandhi_engine($this->add_stem, $root);
		} else {
			// 接頭辞を入れる。
			$prefix = $this->add_stem;
		}

		// 重複語幹を作る。
		$add_stem = $this->make_redumplicatation_addtion($root);	
		// 強語幹で重複する。
		$add_stem = mb_substr($add_stem, 0, 1).Sanskrit_Common::change_vowel_grade($this->get_vowel_in_root(), Sanskrit_Common::VRIDDHI);

		// 願望語幹
		$common_intensive_stem = $add_stem.$root;

		// 現在相
		// 喉音フラグで判定(anitはなし、setはあり)
		$this->present_intensive_stem = $common_intensive_stem;
	
		// 完了体・完了形
		$this->aorist_intensive_stem = Sanskrit_Common::sandhi_engine($common_intensive_stem, self::aorist_is_suffix, true, false);			// 完了体		
		$this->perfect_intensive_stem = $this->present_intensive_stem;													// 完了形
	
		// 未然相
		$this->future_intensive_stem = Sanskrit_Common::sandhi_engine($common_intensive_stem, self::future_suffix2, true, false);		//未然相

		// 現在分詞
		$this->present_intensive_participle_active = $prefix.$this->present_intensive_stem.self::active_participle_suffix1;				// 能動態
		$this->present_intensive_participle_middle = $prefix.$this->present_intensive_stem.self::middle_participle_suffix1;				// 中動態
		$this->present_intensive_participle_passive = $prefix.$this->present_intensive_stem.self::passive_suffix.self::middle_participle_suffix1;		// 受動態

		// 完了体分詞
		$this->aorist_intensive_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->aorist_intensive_stem, self::active_participle_suffix1);			// 能動態
		$this->aorist_intensive_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->aorist_intensive_stem, self::middle_participle_suffix1);		// 中動態

		// 未来分詞
		$this->future_intensive_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->future_intensive_stem, self::active_participle_suffix1);			// 能動態
		$this->future_intensive_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->future_intensive_stem, self::middle_participle_suffix1);		// 中動態

		// 過去分詞
		$this->past_intensive_ta_participle_passive = $prefix.Sanskrit_Common::sandhi_engine($common_intensive_stem, self::past_participle_suffix1);
		$this->past_intensive_na_participle_passive  = $prefix.Sanskrit_Common::sandhi_engine($common_intensive_stem, self::past_participle_suffix2);
		$this->past_intensive_ta_participle_active = $this->past_intensive_ta_participle_passive.self::past_participle_add_suffix;
		$this->past_intensive_na_participle_active  = $this->past_intensive_na_participle_passive.self::past_participle_add_suffix;

		// 動形容詞
		$this->intensive_verbal_adjectives[] = Sanskrit_Common::sandhi_engine($prefix.$common_intensive_stem, "tavya");
		$this->intensive_verbal_adjectives[] = Sanskrit_Common::sandhi_engine($prefix.$common_intensive_stem, "ya");
		$this->intensive_verbal_adjectives[] = Sanskrit_Common::sandhi_engine($prefix.$common_intensive_stem, "anīya");	

		// 不定詞
		$this->intensive_infinitives[] = Sanskrit_Common::sandhi_engine($prefix, $common_intensive_stem);					// 語根			
		$this->intensive_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$common_intensive_stem, "itu");				// 語根tu不定詞
		$this->intensive_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$this->present_intensive_stem, "itu");		// 不完了体tu不定詞
		$this->intensive_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$this->present_intensive_stem, "ti");		// 不完了体tiスラブ式不定詞

    }
	
	// 使役+願望語幹を作る
    private function make_each_causative_desiderative_stems($root){

		// 初期化
		$prefix = "";
		// 名詞起源動詞	
		if($this->root_type == Commons::NOUN_VERB){
			// 名詞と動詞接尾辞を結合	
			$root= Sanskrit_Common::sandhi_engine($this->add_stem, $root);
		} else {
			// 接頭辞を入れる。
			$prefix = $this->add_stem;
		}
		// 重複語幹を作る。
		$add_stem = $this->make_redumplicatation_addtion($root);			
		// iで重複する。
		$add_stem = mb_substr($add_stem, 0, 1).mb_ereg_replace("[ū]", "u", mb_ereg_replace("[aieoāīṛṝ]", "i", $this->get_vowel_in_root()));

		// 使役+願望語幹
		$common_causative_desiderative_stem = $add_stem.mb_substr($this->present_causative_stem, 0 ,-1);

		// 現在相
		$this->present_causative_desiderative_stem = Sanskrit_Common::sandhi_engine($common_causative_desiderative_stem, "isa", false, false);
	
		// 完了体・完了形
		$this->aorist_causative_desiderative_stem = Sanskrit_Common::sandhi_engine($common_causative_desiderative_stem, self::aorist_is_suffix, false, false);			// 完了体		
		$this->perfect_causative_desiderative_stem = $this->present_causative_desiderative_stem;										// 完了形
	
		// 未然相
		$this->future_causative_desiderative_stem = Sanskrit_Common::sandhi_engine($common_causative_desiderative_stem, self::future_suffix2, false, false);		//未然相
		

		// 現在分詞
		$this->present_causative_desiderative_participle_active = $prefix.Sanskrit_Common::sandhi_engine(mb_substr($this->present_causative_desiderative_stem, 0, -1), self::active_participle_suffix1);				// 能動態
		$this->present_causative_desiderative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine(mb_substr($this->present_causative_desiderative_stem, 0, -1), self::middle_participle_suffix1);				// 中動態
		$this->present_causative_desiderative_participle_passive = $prefix.Sanskrit_Common::sandhi_engine(mb_substr($this->present_causative_desiderative_stem, 0, -1).self::passive_suffix, self::middle_participle_suffix1);		// 受動態

		// 完了体分詞
		$this->aorist_causative_desiderative_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->aorist_desiderative_stem, self::active_participle_suffix1);			// 能動態
		$this->aorist_causative_desiderative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->aorist_desiderative_stem, self::middle_participle_suffix1);		// 中動態

		// 未来分詞
		$this->future_causative_desiderative_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->future_desiderative_stem, self::active_participle_suffix1);			// 能動態
		$this->future_causative_desiderative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->future_desiderative_stem, self::middle_participle_suffix1);		// 中動態

		// 過去分詞
		$this->past_causative_desiderative_ta_participle_passive = $prefix.Sanskrit_Common::sandhi_engine($common_causative_desiderative_stem, self::past_participle_suffix1);
		$this->past_causative_desiderative_na_participle_passive  = $prefix.Sanskrit_Common::sandhi_engine($common_causative_desiderative_stem, self::past_participle_suffix2);
		$this->past_causative_desiderative_ta_participle_active = $this->past_desiderative_ta_participle_passive.self::past_participle_add_suffix;
		$this->past_causative_desiderative_na_participle_active  = $this->past_desiderative_na_participle_passive.self::past_participle_add_suffix;

		// 動形容詞
		$this->causative_desiderative_verbal_adjectives[] = $this->past_desiderative_ta_participle_passive."vya";
		$this->causative_desiderative_verbal_adjectives[] = Sanskrit_Common::sandhi_engine($prefix.$common_causative_desiderative_stem, "ya");
		$this->causative_desiderative_verbal_adjectives[] = Sanskrit_Common::sandhi_engine($prefix.$common_causative_desiderative_stem, "anīya");

		// 不定詞	
		$this->causative_desiderative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$common_causative_desiderative_stem, "itu");			// 語根tu不定詞
		$this->causative_desiderative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$this->present_desiderative_stem, "itu");				// 不完了体tu不定詞
    }

	// 強意+願望語幹を作る
    private function make_each_intensive_desiderative_stems($root){

		// 初期化
		$prefix = "";
		// 名詞起源動詞	
		if($this->root_type == Commons::NOUN_VERB){
			// 名詞と動詞接尾辞を結合	
			$root= Sanskrit_Common::sandhi_engine($this->add_stem, $root);
		} else {
			// それ以外
			// 接頭辞を入れる。
			$prefix = $this->add_stem;
		}
		// 重複語幹を作る。
		$add_stem = $this->make_redumplicatation_addtion($root);			
		// iで重複する。
		$add_stem = mb_substr($add_stem, 0, 1).mb_ereg_replace("[ū]", "u", mb_ereg_replace("[aieoāīṛṝ]", "i", $this->get_vowel_in_root()));

		// 願望語幹
		$common_intensive_desiderative_stem = $this->present_intensive_stem;

		// 現在相
		// 子音で判定
		if(!preg_match("/[bpkgcjlrtdḍṭmnṅñṃṇśṣs]$/", $root)){
			$this->present_intensive_desiderative_stem = Sanskrit_Common::sandhi_engine($common_intensive_desiderative_stem, "sa", false, false);
		} else if(preg_match("/[bpkgcjlrtdḍṭmnṅñṃṇśṣs]$/", $root)){
			$this->present_intensive_desiderative_stem = Sanskrit_Common::sandhi_engine($common_intensive_desiderative_stem, "isa", false, false);
		}
	
		// 完了体・完了形
		$this->aorist_intensive_desiderative_stem = Sanskrit_Common::sandhi_engine($common_intensive_desiderative_stem, self::aorist_is_suffix, false, false);			// 完了体		
		$this->perfect_intensive_desiderative_stem = $this->present_intensive_desiderative_stem;										// 完了形
	
		// 未然相
		$this->future_intensive_desiderative_stem = Sanskrit_Common::sandhi_engine($common_intensive_desiderative_stem, self::future_suffix2, false, false);		//未然相

		// 現在分詞
		$this->present_intensive_desiderative_participle_active = $prefix.Sanskrit_Common::sandhi_engine(mb_substr($this->present_intensive_desiderative_stem, 0, -1), self::active_participle_suffix1);				// 能動態
		$this->present_intensive_desiderative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine(mb_substr($this->present_intensive_desiderative_stem, 0, -1), self::middle_participle_suffix1);				// 中動態
		$this->present_intensive_desiderative_participle_passive = $prefix.Sanskrit_Common::sandhi_engine(mb_substr($this->present_intensive_desiderative_stem, 0, -1).self::passive_suffix, self::middle_participle_suffix1);		// 受動態

		// 完了体分詞
		$this->aorist_intensive_desiderative_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->aorist_intensive_desiderative_stem, self::active_participle_suffix1);		// 能動態
		$this->aorist_intensive_desiderative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->aorist_intensive_desiderative_stem, self::middle_participle_suffix1);		// 中動態

		// 未来分詞
		$this->future_intensive_desiderative_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->future_intensive_desiderative_stem, self::active_participle_suffix1);		// 能動態
		$this->future_intensive_desiderative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->future_intensive_desiderative_stem, self::middle_participle_suffix1);		// 中動態

		// 過去分詞
		$this->past_intensive_desiderative_ta_participle_passive = $prefix.Sanskrit_Common::sandhi_engine($common_intensive_desiderative_stem, self::past_participle_suffix1);
		$this->past_intensive_desiderative_na_participle_passive  = $prefix.Sanskrit_Common::sandhi_engine($common_intensive_desiderative_stem, self::past_participle_suffix2);
		$this->past_intensive_desiderative_ta_participle_active = $this->past_intensive_desiderative_ta_participle_passive.self::past_participle_add_suffix;
		$this->past_intensive_desiderative_na_participle_active  = $this->past_intensive_desiderative_na_participle_passive.self::past_participle_add_suffix;

		// 動形容詞
		$this->intensive_desiderative_verbal_adjectives[] = $this->past_intensive_desiderative_ta_participle_passive."vya";
		$this->intensive_desiderative_verbal_adjectives[] = Sanskrit_Common::sandhi_engine($prefix.$common_intensive_desiderative_stem, "ya");
		$this->intensive_desiderative_verbal_adjectives[] = Sanskrit_Common::sandhi_engine($prefix.$common_intensive_desiderative_stem, "anīya");

		// 不定詞	
		$this->intensive_desiderative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$common_intensive_desiderative_stem, "itu");			// 語根tu不定詞
		$this->intensive_desiderative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$this->present_intensive_desiderative_stem, "itu");	// 不完了体tu不定詞
    }

	// 願望+使役語幹を作る
    private function make_each_desiderative_causative_stems($root){
		// 初期化
		$prefix = $this->add_stem;
		// 使役用語幹
		$common_desiderative_causative_stem = $this->present_desiderative_stem.self::causative_suffix;		
		// 現在相
		$this->present_desiderative_causative_stem = Sanskrit_Common::sandhi_engine($common_desiderative_causative_stem, "a", false, false);
		
		// 完了体・完了形
		$this->perfect_desiderative_causative_stem = mb_substr($root, 0, 1)."i".$common_desiderative_causative_stem."a";								// 完了形
		$this->aorist_desiderative_causative_stem = Sanskrit_Common::sandhi_engine($common_desiderative_causative_stem, self::aorist_is_suffix, false, false);			// 完了体
		
		// 未然相
		$this->future_desiderative_causative_stem = Sanskrit_Common::sandhi_engine($common_desiderative_causative_stem, self::future_suffix2, false, false);		//未然相

		// 現在分詞
		$this->present_desiderative_causative_participle_active = $prefix.$common_desiderative_causative_stem.self::active_participle_suffix1;					// 能動態
		$this->present_desiderative_causative_participle_middle = $prefix.$this->present_desiderative_causative_stem.self::middle_participle_suffix1;			// 中動態
		$this->present_desiderative_causative_participle_passive = $prefix.$this->present_desiderative_stem.self::passive_suffix.self::middle_participle_suffix1;		// 受動態

		// 完了体分詞
		$this->aorist_desiderative_causative_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->aorist_desiderative_causative_stem, self::active_participle_suffix1);			// 能動態
		$this->aorist_desiderative_causative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->aorist_desiderative_causative_stem, self::middle_participle_suffix1);		// 中動態
		$this->aorist_desiderative_causative_participle_passive = $prefix.Sanskrit_Common::sandhi_engine($common_desiderative_causative_stem.self::aorist_is_suffix, self::middle_participle_suffix1);		// 受動態	

		// 完了形分詞
		$this->perfect_desiderative_causative_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->perfect_desiderative_causative_stem, self::active_participle_suffix1);		// 能動態
		$this->perfect_desiderative_causative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->perfect_desiderative_causative_stem, self::middle_participle_suffix1);		// 中動態

		// 未来分詞
		$this->future_desiderative_causative_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->future_desiderative_causative_stem, self::active_participle_suffix1);			// 能動態
		$this->future_desiderative_causative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->future_desiderative_causative_stem, self::middle_participle_suffix1);		// 中動態
		$this->future_desiderative_causative_participle_passive = $prefix.Sanskrit_Common::sandhi_engine($common_desiderative_causative_stem.self::future_suffix2, self::middle_participle_suffix1);		// 受動態

		// 過去分詞
		$this->past_desiderative_causative_ta_participle_passive = $prefix.Sanskrit_Common::sandhi_engine($common_desiderative_causative_stem, "i".self::past_participle_suffix1);
		$this->past_desiderative_causative_na_participle_passive  = $prefix.Sanskrit_Common::sandhi_engine($common_desiderative_causative_stem, self::past_participle_suffix2);
		$this->past_desiderative_causative_ta_participle_active = $this->past_desiderative_causative_ta_participle_passive.self::past_participle_add_suffix;
		$this->past_desiderative_causative_na_participle_active  = $this->past_desiderative_causative_na_participle_passive.self::past_participle_add_suffix;

		// 動形容詞
		$this->desiderative_causative_verbal_adjectives[] = $this->past_desiderative_causative_ta_participle_passive."vya";
		$this->desiderative_causative_verbal_adjectives[] = Sanskrit_Common::sandhi_engine($prefix.$common_desiderative_causative_stem, "ya");
		$this->desiderative_causative_verbal_adjectives[] = Sanskrit_Common::sandhi_engine($prefix.$common_desiderative_causative_stem, "anīya");	
		
		// 不定詞	
		$this->desiderative_causative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$common_desiderative_causative_stem, "tu");				// 語根tu不定詞
		$this->desiderative_causative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$common_desiderative_causative_stem, "itu");		// 不完了体tu不定詞
    }

	// 強意+使役語幹を作る
    private function make_each_intensive_causative_stems($root){
		// 初期化
		$prefix = $this->add_stem;

		// 使役用語幹
		$common_intensive_causative_stem = $this->present_desiderative_stem.self::causative_suffix;

		// 現在相
		$this->present_intensive_causative_stem = Sanskrit_Common::sandhi_engine($common_intensive_causative_stem, "a", false, false);

		// 完了体・完了形
		$this->perfect_intensive_causative_stem = mb_substr($root, 0, 1)."i".$common_intensive_causative_stem."a";								// 完了形
		$this->aorist_intensive_causative_stem = Sanskrit_Common::sandhi_engine($common_intensive_causative_stem, self::aorist_is_suffix, false, false);			// 完了体
		
		// 未然相
		$this->future_intensive_causative_stem = Sanskrit_Common::sandhi_engine($common_intensive_causative_stem.self::causative_suffix, self::future_suffix2, false, false);		//未然相

		// 現在分詞
		$this->present_intensive_causative_participle_active = $prefix.$common_intensive_causative_stem.self::causative_suffix.self::active_participle_suffix1;			// 能動態
		$this->present_intensive_causative_participle_middle = $prefix.$this->present_causative_stem.self::middle_participle_suffix1;		// 中動態
		$this->present_intensive_causative_participle_passive = $prefix.$common_intensive_causative_stem.self::passive_suffix.self::middle_participle_suffix1;		// 受動態

		// 完了体分詞
		$this->aorist_intensive_causative_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->aorist_intensive_causative_stem, self::active_participle_suffix1);			// 能動態
		$this->aorist_intensive_causative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->aorist_intensive_causative_stem, self::middle_participle_suffix1);		// 中動態
		$this->aorist_intensive_causative_participle_passive = $prefix.Sanskrit_Common::sandhi_engine($common_intensive_causative_stem.self::aorist_is_suffix, self::middle_participle_suffix1);		// 受動態	

		// 完了形分詞
		$this->perfect_intensive_causative_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->perfect_intensive_causative_stem, self::active_participle_suffix1);		// 能動態
		$this->perfect_intensive_causative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->perfect_intensive_causative_stem, self::middle_participle_suffix1);		// 中動態

		// 未来分詞
		$this->future_intensive_causative_participle_active = $prefix.Sanskrit_Common::sandhi_engine($this->future_intensive_causative_stem, self::active_participle_suffix1);			// 能動態
		$this->future_intensive_causative_participle_middle = $prefix.Sanskrit_Common::sandhi_engine($this->future_intensive_causative_stem, self::middle_participle_suffix1);		// 中動態
		$this->future_intensive_causative_participle_passive = $prefix.Sanskrit_Common::sandhi_engine($common_intensive_causative_stem.self::future_suffix2, self::middle_participle_suffix1);		// 受動態

		// 過去分詞
		$this->past_intensive_causative_ta_participle_passive = $prefix.Sanskrit_Common::sandhi_engine($common_intensive_causative_stem, "i".self::past_participle_suffix1);
		$this->past_intensive_causative_na_participle_passive  = $prefix.Sanskrit_Common::sandhi_engine($common_intensive_causative_stem, self::past_participle_suffix2);
		$this->past_intensive_causative_ta_participle_active = $this->past_intensive_causative_ta_participle_passive.self::past_participle_add_suffix;
		$this->past_intensive_causative_na_participle_active  = $this->past_intensive_causative_na_participle_passive.self::past_participle_add_suffix;

		// 動形容詞
		$this->intensive_causative_verbal_adjectives[] = $this->past_intensive_causative_ta_participle_passive."vya";
		$this->intensive_causative_verbal_adjectives[] = Sanskrit_Common::sandhi_engine($prefix.$common_intensive_causative_stem, "ya");
		$this->intensive_causative_verbal_adjectives[] = Sanskrit_Common::sandhi_engine($prefix.$common_intensive_causative_stem, "anīya");	
		
		// 不定詞	
		$this->intensive_causative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$common_intensive_causative_stem, "tu");				// 語根tu不定詞
		$this->intensive_causative_infinitives[] = Sanskrit_Common::sandhi_engine($prefix.$common_intensive_causative_stem.self::causative_suffix, "itu");		// 不完了体tu不定詞

    }

	// 語根の母音を返す。
	private function get_vowel_in_root($sound_grade = ""){
		// 母音抜き出し
		$vowel = preg_replace('/[^aiueoāīūṛḷ]/u', '', $this->root);
		// 音階の指定がある場合はそれを反映する。
		if($sound_grade != ""){
			$vowel = Sanskrit_Common::change_vowel_grade($vowel, Sanskrit_Common::GUNA);
		} 
		// 結果を返す。
		return $vowel;
	}

	// 現在形弱語幹を返す。
	private function get_weak_present_stem(){
		//動詞種別ごとに分ける。
		switch ($this->conjugation_present_type) {
		    case 2:
				return $this->root;
		        break;
		    case 3:
				$add_stem = $this->make_redumplicatation_addtion($this->root);							
				return mb_substr($add_stem, 0, 1).mb_ereg_replace("[ṛṝ]", "i", $this->get_vowel_in_root()).Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::ZERO_GRADE);
		        break;
		    case 5:
				return $this->root."nu";
		        break;
		    case 7:
				return mb_ereg_replace("^(.+)([bpkgcjlrtdḍṭmnṅñṇśṣsyv]|[bpkghcjlrtdḍṭ]h)$", "\\1n\\2", mb_ereg_replace("^(.+)(n|ñ|ṅ)", "\\1", $this->root));
		        break;
		    case 8:
				return $this->root."u";
		        break;
		    case 9:
				return $this->root."nī";
		        break;			
			default:
				return $this->present_stem;
				break;
		}		
	}

	// 完了形語幹を返す。
	private function get_weak_perfect_stem($sound_grade){

		// 完了形
		$add_stem = $this->make_redumplicatation_addtion($this->root);
		$add_stem = mb_substr($add_stem, 0, 2);		
		// 強語幹で重複する。
		$add_stem = Sanskrit_Common::change_vowel_grade(mb_ereg_replace("[ṛṝ]", "a", $add_stem), Sanskrit_Common::ZERO_GRADE);

		// 音階で分ける。
		switch($sound_grade){
			case Sanskrit_Common::ZERO_GRADE:
				// 弱語幹の場合
				// 子音+a+子音の動詞の場合は 
				if(preg_match("/([bptd])a([bpkghcjtdḍṭṅñṇnmsśṣ]|[bpkghcjtdḍṭ]h)$/u", $this->root)){
					// 語根のaをeに変換して返す。
					return mb_ereg_replace("a", "e", $this->root);							
				} else {
					return mb_substr($add_stem, 0, 2).Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::ZERO_GRADE);	
				}					
				break;
			case Sanskrit_Common::GUNA:
				// 中語幹
				return $this->perfect_stem;			
				break;
			case Sanskrit_Common::VRIDDHI:
				// 強語幹
				return mb_substr($add_stem, 0, 2).Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI);					
				break;	
			default:
				break;				
		}
	}

	// 重複語幹を返す。
	private function make_redumplicatation_addtion($root){
		// グラスマンの法則
		$add_stem = mb_ereg_replace("([bpkgcjtd])h", "\\1", $root);
		// サテム言語処理1
		$add_stem = mb_ereg_replace("k", "c", $add_stem);
		// サテム言語処理2
		$add_stem = mb_ereg_replace("[hg]", "j", $add_stem);
		// 結果を返す。
		return $add_stem;
	}

	// 強意動詞完了形語幹を返す。
	private function get_weak_intensive_perfect_stem($sound_grade){

		// 初期化
		$prefix = "";
		// 名詞起源動詞	
		if($this->root_type == Commons::NOUN_VERB){
			// 名詞と動詞接尾辞を結合	
			$root = Sanskrit_Common::sandhi_engine($this->add_stem, $this->root);
		} else {
			// 接頭辞を入れる。
			$root = $this->root;
			// 接頭辞を入れる。
			$prefix = $this->add_stem;
		}

		// 重複語幹を作る。
		$add_stem = $this->make_redumplicatation_addtion($root);	
		// 強語幹で重複する。
		$add_stem = mb_substr($add_stem, 0, 1).Sanskrit_Common::change_vowel_grade($this->get_vowel_in_root(), Sanskrit_Common::VRIDDHI);

		// 音階で分ける。
		switch($sound_grade){
			case Sanskrit_Common::ZERO_GRADE:
				// 弱語幹の場合
				return $prefix.$add_stem.Sanskrit_Common::change_vowel_grade($root, Sanskrit_Common::ZERO_GRADE);						
				break;
			case Sanskrit_Common::GUNA:
				// 中語幹
				return $this->perfect_intensive_stem;			
				break;
			case Sanskrit_Common::VRIDDHI:
				// 強語幹
				return $prefix.$add_stem.Sanskrit_Common::change_vowel_grade($root, Sanskrit_Common::VRIDDHI);					
				break;	
			default:
				break;				
		}
	}	

	// sアオリスト活用を作る。
	private function get_s_aorist_indcative_conjugation($verb_stem, $voice, $person){

		// 初期化
		$verb_conjugation = "";

		// 態や人称で分ける。
		if(preg_match('/1sg/', $person) && $voice == Commons::ACTIVE_VOICE){
			// 単数1人称
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_stem, "am");
		} else if(preg_match('/(1sg)/', $person) && $voice == Commons::MEDIOPASSIVE_VOICE){
			// 中動態単数1人称
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_stem, "i");
		} else if(preg_match('/(2sg|3sg)/', $person) && $voice == Commons::ACTIVE_VOICE){
			// 単数2・3人称
			$verb_conjugation = $this->get_secondary_suffix(Sanskrit_Common::sandhi_engine($verb_stem, "ī"), $voice, $person);
		} else if(preg_match('/(2du|3du)/', $person) && $voice == Commons::MEDIOPASSIVE_VOICE){
			// 中動態単数2・3人称
			$verb_conjugation = $this->get_secondary_suffix(Sanskrit_Common::sandhi_engine($verb_stem, "ā"), $voice, $person);							
		} else if(preg_match('/(3pl)/', $person) && $voice == Commons::ACTIVE_VOICE){
			// 複数3人称
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_stem, "us");
		} else {
			// それ以外は連音処理入り
			$verb_conjugation = $this->get_sanskrit_secondary_suffix($verb_stem, $voice, $person);
		}

		// 結果を返す。
		return $verb_conjugation;
	}

	// isアオリスト活用を作る。
	private function get_is_aorist_indcative_conjugation($verb_stem, $voice, $person, $verb_root){

		// 初期化
		$verb_conjugation = "";
		
		// isアオリストは連音処理入り
		if(preg_match('/1sg/', $person) && $voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 単数1人称
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_stem, "am");
		} else if(preg_match('/(1sg)/', $person) && $voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
			// 中動態単数1人称
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_stem, "i");					
		} else if(preg_match('/(2sg|3sg)/', $person) && $voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 単数2・3人称
			$verb_conjugation = $this->get_secondary_suffix(Sanskrit_Common::sandhi_engine($verb_root, "ī"), $voice, $person);
		} else if(preg_match('/(2du|3du)/', $person) && $voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
			// 中動態単数2・3人称
			$verb_conjugation = $this->get_secondary_suffix(Sanskrit_Common::sandhi_engine($verb_stem, "ā"), $voice, $person);						
		} else if(preg_match('/(3pl)/', $person) && $voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 単数2・3人称
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_stem, "us");					
		} else {
			// それ以外は連音処理入り
			$verb_conjugation = $this->get_sanskrit_secondary_suffix($verb_stem, $voice, $person);
		}

		// 結果を返す。
		return $verb_conjugation;		
	}

	// sisアオリスト活用を作る。
	private function get_sis_aorist_indcative_conjugation($verb_stem, $voice, $person, $verb_root){

		// 初期化
		$verb_conjugation = "";
		
		// isアオリストは連音処理入り
		if(preg_match('/1sg/', $person) && $voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 単数1人称
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_stem, "am");
		} else if(preg_match('/(1sg)/', $person) && $voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
			// 中動態単数1人称
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_stem, "i");					
		} else if(preg_match('/(2sg|3sg)/', $person) && $voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 単数2・3人称
			$verb_conjugation = $this->get_secondary_suffix($verb_root."sī", $voice, $person);
		} else if(preg_match('/(2du|3du)/', $person) && $voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
			// 中動態単数2・3人称
			$verb_conjugation = $this->get_secondary_suffix($verb_stem."ā", $voice, $person);						
		} else if(preg_match('/(3pl)/', $person) && $voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 単数2・3人称
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_stem, "us");					
		} else {
			// それ以外は連音処理入り
			$verb_conjugation = $this->get_sanskrit_secondary_suffix($verb_stem, $voice, $person);
		}

		// 結果を返す。
		return $verb_conjugation;		
	}

	// 一次動詞二次語尾活用を作る。
	private function get_primary_verb_secondary_conjugation($verb_stem, $aspect, $voice, $person){
		// 初期化
		$verb_conjugation = "";

		// 条件ごとで分ける。
		if(($aspect == Commons::START_VERB || $aspect == Commons::RESULTATIBE) && $this->conjugation_present_type != "10" && $this->root_type != Commons::NOUN_VERB){
			// 始動相・結果相の場合
			// 母音活用動詞は親クラスで処理
			$verb_conjugation = $this->get_secondary_suffix($verb_stem, $voice, $person);
	 	} else if(preg_match('/(2|3|5|7|8|9)/',$this->conjugation_present_type) && $aspect == Commons::PRESENT_ASPECT){
			if(preg_match('/1sg/', $person) && $voice == Commons::ACTIVE_VOICE){
				// 単数1人称
				$verb_stem = $verb_stem."a";
			} else if(preg_match('/(3pl)/', $person)){
				// 三人称複数はaを加える。
				$verb_stem = $verb_stem."a";
			}
			// 不完了体子音活用動詞は連音処理入り			
			$verb_conjugation = $this->get_sanskrit_secondary_suffix($verb_stem, $voice, $person);
		} else if($aspect == Commons::AORIST_ASPECT && $this->conjugation_present_type == "10"){
			// 重複アオリストは親クラスで処理
			$verb_conjugation = $this->get_secondary_suffix($verb_stem, $voice, $person);
		} else if(($this->root_type == Commons::PRESENT_ASPECT || $this->root_type == Commons::NOUN_VERB) && $aspect == Commons::AORIST_ASPECT){
			// アオリストの種別ごとで場合分け
			if(preg_match("/(ā|ai)$/u", $this->root)){
				// sisはアオリストは連音処理入り
				$verb_conjugation = $this->get_sis_aorist_indcative_conjugation($verb_stem."a", $voice, $person, Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI));
			} else if(preg_match("/(ai|au|[iīuūeoṛṝ])[bpkghcjtdḍṭmnṅñṃṇ]*([śṣh])$/u", $this->root) &&
					  !preg_match("/(bh|ph|kh|gh|dh|th|ḍh|ṭh)$/u", $this->root)){
				// saアオリストは親クラスで処理
				$verb_conjugation = $this->get_secondary_suffix($verb_stem, $voice, $person);				
			} else if($this->root_laryngeal_flag != Commons::$TRUE){
				// sアオリストは連音処理入り
				$verb_conjugation = $this->get_s_aorist_indcative_conjugation($verb_stem, $voice, $person);
			} else{
				// isアオリストは連音処理入り
				$verb_conjugation = $this->get_is_aorist_indcative_conjugation($verb_stem, $voice, $person, Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI));
			}
		} else if($this->root_type == Commons::AORIST_ASPECT && $aspect == Commons::AORIST_ASPECT){
			// 第二アオリストは親クラスで処理
			$verb_conjugation = $this->get_secondary_suffix($verb_stem, $voice, $person);
		} else if($aspect == Commons::PERFECT_ASPECT && $this->root_type != Commons::NOUN_VERB){
			// 完了形はこちらに移動
			$verb_conjugation = $this->get_secondary_suffix($verb_stem."a", $voice, $person);											
		} else {
			// 母音活用動詞は親クラスで処理
			$verb_conjugation = $this->get_secondary_suffix($verb_stem, $voice, $person);
		} 

		// 結果を返す。
		return $verb_conjugation;
	}

	// 祈願法を作成
	private function get_active_benedictive_conjugation($verb_stem, $voice, $person){
		// 初期化
		$verb_conjugation = "";

		// 能動形が存在しない場合は
		if($this->deponent_active == Commons::$TRUE){
			// ハイフンを返す
			return "-";
		}

		// 条件で分ける。
		if(preg_match('/1sg/', $person)){
			// 単数1人称
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_stem, "am");
		} else if(preg_match('/(2sg|3sg)/', $person)){
			// 単数2・3人称
			$verb_conjugation = $this->get_secondary_suffix(mb_substr($verb_stem, 0, -1), $voice, $person);
		} else if(preg_match('/(3pl)/', $person)){
			// 複数3人称
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_stem, "us");		
		} else {
			// それ以外
			$verb_conjugation = $this->get_secondary_suffix($verb_stem, $voice, $person);
		}

		// 結果を返す。
		return $verb_conjugation;
	}

	// 祈願法を作成
	private function get_middle_benedictive_conjugation($verb_stem, $voice, $person){
		// 初期化
		$verb_conjugation = "";

		// 中受動形が存在しない場合は
		if($this->deponent_mediopassive == Commons::$TRUE){
			// ハイフンを返す
			return "-";
		}

		// 条件で分ける。
		if(preg_match('/1sg/', $person)){
			// 単数1人称
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_stem, "īya");
		} else if(preg_match('/(3sg|2du|3du)/', $person)){
			// 単数2・3人称
			$verb_conjugation = $this->get_secondary_suffix($verb_stem."īṣ", $voice, $person);
		} else if(preg_match('/(3pl)/', $person)){
			// 単数2・3人称
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_stem, "īran");				
		} else {
			// それ以外
			$verb_conjugation = $this->get_secondary_suffix($verb_stem."ī", $voice, $person);
		}

		// 結果を返す。
		return $verb_conjugation;
	}

	// 願望動詞の活用を作成
	private function make_desiderative_conjugation($verb_stem, $person, $voice, $tense_mood, $aspect, $desiderative_stem){

		// 活用形を初期化
		$verb_conjugation = "";

		// 時制を分ける。
		if($tense_mood == Commons::PRESENT_TENSE && ($aspect == Commons::PRESENT_ASPECT || $aspect == Commons::FUTURE_TENSE)) {
			// 母音活用動詞は親クラスで処理
			$verb_conjugation = $this->get_primary_suffix($verb_stem, $voice, $person);		
		} else if($aspect == Commons::PERFECT_ASPECT && $tense_mood == Commons::PRESENT_TENSE){
			// 完了形現在はこちらに移動
			$verb_conjugation = $this->get_sanskrit_perfect_suffix($verb_stem, $voice, $person);					
		} else if($tense_mood == Commons::PAST_TENSE){
			// 未完了は二次語尾
			if($aspect == Commons::AORIST_ASPECT){
				// isアオリストは連音処理入り
				$verb_conjugation = $this->get_is_aorist_indcative_conjugation($verb_stem, $voice, $person, mb_substr($desiderative_stem, 0 , -1));
			} else {
				// 不完了体・完了形・未来形は親クラスで処理
				$verb_conjugation = $this->get_secondary_suffix($verb_stem, $voice, $person);
			} 
			// 過去の接頭辞を付ける
			if(Commons::NOUN_VERB && ($verb_conjugation != "" && $verb_conjugation != "-")){
				$verb_conjugation = self::and_then_prefix.$verb_conjugation;
			}
		} else if($tense_mood == Commons::IMJUNCTIVE){
			// 指令法は二次語尾
			if($aspect == Commons::AORIST_ASPECT){
				// isアオリストは連音処理入り
				$verb_conjugation = $this->get_is_aorist_indcative_conjugation($verb_stem, $voice, $person, mb_substr($desiderative_stem, 0 , -1));
			} else {
				// 不完了体・完了形・未来形は親クラスで処理
				$verb_conjugation = $this->get_secondary_suffix($verb_stem, $voice, $person);
			}  			
		} else if($tense_mood == Commons::SUBJUNCTIVE){
			// 接続法
			$verb_stem = Sanskrit_Common::sandhi_engine($verb_stem, $this->subj);
			$verb_conjugation = $this->get_primary_suffix($verb_stem, $voice, $person);			
		} else if($tense_mood == Commons::OPTATIVE){
			// 希求法
			// 三人称複数の場合
			if(preg_match('/(3pl)/', $person)){
				// 相に応じて分ける。
				if(($aspect == Commons::PRESENT_ASPECT || $aspect == Commons::FUTURE_TENSE || $aspect == Commons::PERFECT_ASPECT)){
					// 不完了体母音活用動詞
					// 語尾と結合
					if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
						// 能動態の場合
						$verb_conjugation= $verb_stem."iyus";
					} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
						// 中受動態の場合
						$verb_conjugation= $verb_stem."iran";	
					} else {
						// ハイフンを返す。
						return "-";	
					}
				} else if($aspect == Commons::AORIST_ASPECT){
					// 語尾と結合
					if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
						// 能動態の場合
						$verb_conjugation= $verb_stem."yus";
					} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
						// 中受動態の場合
						$verb_conjugation= $verb_stem."īran";	
					} else {
						// ハイフンを返す。
						return "-";	
					}
				} 
			} else {
				// 希求法語尾を付ける
				$verb_stem = Sanskrit_Common::sandhi_engine($verb_stem, "i".$this->opt);
				// 活用語尾を付ける。
				$verb_conjugation = $this->get_secondary_suffix($verb_stem, $voice, $person);
			}
		} else if($tense_mood == "bend" && $aspect == Commons::AORIST_ASPECT){
			// 祈願法
			if($voice == Commons::ACTIVE_VOICE){
				// 能動形
				$verb_stem = Sanskrit_Common::sandhi_engine($desiderative_stem, $this->opt."s");
				$verb_conjugation = $this->get_active_benedictive_conjugation($verb_stem, $voice, $person);
			} else {
				// 中受動形
				$verb_stem = Sanskrit_Common::sandhi_engine(mb_substr($desiderative_stem, 0 , -1), self::aorist_is_suffix);
				$verb_conjugation = $this->get_middle_benedictive_conjugation($verb_stem, $voice, $person);			
			}			
		} else if($tense_mood == Commons::IMPERATIVE){
			// 命令法			
			if(preg_match('/(1sg|1du|1pl)/u', $person)){
				// 1人称の場合は接続法にする。
				$verb_stem = Sanskrit_Common::sandhi_engine($verb_stem, $this->subj);
				$verb_conjugation = $this->get_primary_suffix($verb_stem, $voice, $person);	
			} else {
				// それ以外は命令法
				if($aspect == Commons::AORIST_ASPECT){
					// isアオリストは連音処理入り
					$verb_conjugation = $this->get_sanskrit_imperative_suffix($verb_stem, $voice, $person);	
				} else {
					// 母音活用動詞は親クラスで処理
					$verb_conjugation = $this->get_imperative_suffix($verb_stem, $voice, $person);
				}
			}
		}

		// 結果を返す。
		return $verb_conjugation;
	}

	// 使役動詞の活用を作成
	private function make_causative_conjugation($verb_stem, $person, $voice, $tense_mood, $aspect, $desiderative_stem){

		// 活用形を初期化
		$verb_conjugation = "";

		// 時制と法で分ける。
		if($tense_mood == Commons::PRESENT_TENSE && ($aspect == Commons::PRESENT_ASPECT || $aspect == Commons::FUTURE_TENSE)) {
			// 母音活用動詞は親クラスで処理
			$verb_conjugation = $this->get_primary_suffix($verb_stem, $voice, $person);
		} else if($aspect == Commons::PERFECT_ASPECT && $tense_mood == Commons::PRESENT_TENSE){
			// 完了形現在は存在しないのでハイフンを返す。
			return "-";			
		} else if($tense_mood == Commons::PAST_TENSE){
			// 未完了は二次語尾
			if($aspect == Commons::AORIST_ASPECT){
				// isアオリストは連音処理入り
				$verb_conjugation = $this->get_is_aorist_indcative_conjugation($verb_stem, $voice, $person, mb_substr($desiderative_stem, 0 , -1));
			} else {
				// 不完了体・完了形・未来形は親クラスで処理
				$verb_conjugation = $this->get_secondary_suffix($verb_stem, $voice, $person);
			} 
			// 過去の接頭辞を付ける
			if(Commons::NOUN_VERB && ($verb_conjugation != "" && $verb_conjugation != "-")){
				$verb_conjugation = self::and_then_prefix.$verb_conjugation;
			}
		} else if($tense_mood == Commons::IMJUNCTIVE){
			// 指令法は二次語尾
			if($aspect == Commons::AORIST_ASPECT){
				// isアオリストは連音処理入り
				$verb_conjugation = $this->get_is_aorist_indcative_conjugation($verb_stem, $voice, $person, mb_substr($desiderative_stem, 0 , -1));
			} else {
				// 不完了体・完了形・未来形は親クラスで処理
				$verb_conjugation = $this->get_secondary_suffix($verb_stem, $voice, $person);
			}  			
		} else if($tense_mood == Commons::SUBJUNCTIVE){
			// 接続法
			$verb_stem = Sanskrit_Common::sandhi_engine($verb_stem, $this->subj);
			$verb_conjugation = $this->get_primary_suffix($verb_stem, $voice, $person);			
		} else if($tense_mood == Commons::OPTATIVE){			
			// 希求法
			// 三人称複数の場合
			if(preg_match('/(3pl)/', $person)){
				// 相に応じて分ける。
				if(($aspect == Commons::PRESENT_ASPECT || $aspect == Commons::FUTURE_TENSE)){
					// 現在形と未来形
					// 語尾と結合
					if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
						// 能動態の場合
						$verb_conjugation= $verb_stem."iyus";					
					} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
						// 中受動態の場合
						$verb_conjugation= $verb_stem."iran";	
					} else {
						// ハイフンを返す。
						return "-";	
					}
				} else if($aspect == Commons::AORIST_ASPECT || $aspect == Commons::PERFECT_ASPECT){
					// アオリストと完了形
					// 語尾と結合
					if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
						// 能動態の場合
						$verb_conjugation= $verb_stem."yus";
					} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
						// 中受動態の場合		
						$verb_conjugation= $verb_stem."īran";				
					} else {
						// ハイフンを返す。
						return "-";	
					}
				} else {
					// ハイフンを返す。
					return "-";
				}  
			} else {
				// 希求法語尾を付ける
				$verb_stem = Sanskrit_Common::sandhi_engine($verb_stem, "i".$this->opt);
				// 活用語尾を付ける。
				$verb_conjugation = $this->get_secondary_suffix($verb_stem, $voice, $person);
			}
		} else if($tense_mood == "bend" && ($aspect == Commons::AORIST_ASPECT || $aspect == Commons::PERFECT_ASPECT)){
			// 祈願法
			if($voice == Commons::ACTIVE_VOICE){
				// 能動形
				$verb_stem = Sanskrit_Common::sandhi_engine(mb_substr($desiderative_stem, 0 , -3), $this->opt."s");
				$verb_conjugation = $this->get_active_benedictive_conjugation($verb_stem, $voice, $person);
			} else {
				// 中受動形
				$verb_stem = Sanskrit_Common::sandhi_engine(mb_substr($desiderative_stem, 0 , -1), self::aorist_is_suffix);
				$verb_conjugation = $this->get_middle_benedictive_conjugation($verb_stem, $voice, $person);					
			}						
		} else if($tense_mood == Commons::IMPERATIVE){
			// 命令法			
			if(preg_match('/(1sg|1du|1pl)/', $person)){
				// 1人称の場合は接続法にする。
				$verb_stem = Sanskrit_Common::sandhi_engine($verb_stem, $this->subj);
				$verb_conjugation = $this->get_primary_suffix($verb_stem, $voice, $person);	
			} else {
				// それ以外は命令法
				if($aspect == Commons::AORIST_ASPECT){
					// isアオリストは連音処理入り
					$verb_conjugation = $this->get_sanskrit_imperative_suffix($verb_stem, $voice, $person);	
				} else {
					// 母音活用動詞は親クラスで処理
					$verb_conjugation = $this->get_imperative_suffix($verb_stem, $voice, $person);
				}
			}
		} else {
			// ハイフンを返す。
			return "-";
		} 

		// 結果を返す。
		return $verb_conjugation;
	}

	// 動詞作成
	public function get_sanskrit_verb($person, $voice, $tense_mood, $aspect, $vedic_flag){ 

		// 不適切な組み合わせのチェック
		if(!$this->deponent_check($voice, $aspect)){
			// ハイフンを返す。
			return "-";		
		}
		//動詞の語幹を取得
		$verb_stem = "";
		if($aspect == Commons::PRESENT_ASPECT && $this->deponent_present != Commons::$TRUE){
			// 不完了体
			// 受動態は専用の語幹を使用
			if($voice == Commons::PASSIVE_VOICE){
				// 名詞起源動詞の場合は
				if($this->root_type == Commons::NOUN_VERB){
					// yaをそのまま追加する。
					$verb_stem = self::denomitive_suffix.self::passive_suffix;
				} else {
					// それ以外はsandhiを通す。
					$verb_stem = Sanskrit_Common::sandhi_engine(Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::ZERO_GRADE), self::passive_suffix, false, false);
				}
			} else if(preg_match('(opt|imper)', $tense_mood)){
				// 命令法能動態3人称単数は強語幹
				if($tense_mood == Commons::IMPERATIVE && $person == "3sg" || ($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE)){
					$verb_stem = $this->present_stem;						
				} else {
					// それ以外の希求法・命令法は全て弱語幹
					$verb_stem = $this->get_weak_present_stem();
				}
			} else if($tense_mood == Commons::SUBJUNCTIVE){
				// 接続法はすべて強語幹
				$verb_stem = $this->present_stem;							
			} else {
				// それ以外
				if(preg_match('/(1sg|2sg|3sg)/', $person) && $voice != Commons::MEDIOPASSIVE_VOICE){
					// 能動態単数はすべて強語幹
					$verb_stem = $this->present_stem;						
				} else {
					// それ以外はすべて弱語幹
					$verb_stem = $this->get_weak_present_stem();				
				}
			}
		} else if($aspect == Commons::START_VERB && $this->root_type != Commons::NOUN_VERB && $this->deponent_present != Commons::$TRUE){
			// 始動相
			// 第10類・名詞起源動詞以外は追加する。
			$verb_stem = $this->inchorative_stem;	
		} else if($aspect == Commons::RESULTATIBE && $this->root_type != Commons::NOUN_VERB && $this->deponent_aorist != Commons::$TRUE){
			// 結果相
			// 第10類・名詞起源動詞以外は追加する。
			$verb_stem = $this->resultative_stem;				
		} else if($aspect == Commons::AORIST_ASPECT && $this->deponent_aorist != Commons::$TRUE){
			// 完了体
			// 中動態は語幹を変更
			if($this->conjugation_present_type == "10"){
				// 重複語幹の場合
				$verb_stem = $this->aorist_stem;
			} else if ($this->conjugation_present_type == Commons::NOUN_VERB && $voice == Commons::PASSIVE_VOICE) {	
				// 名詞起源動詞の場合
				$verb_stem = "y".self::aorist_is_suffix;
			} else if(preg_match("/[aiuṛīūṝ]$/u", $this->root) && $voice == Commons::PASSIVE_VOICE){
				// 母音で終わる動詞は専用の受動態を作る
				$verb_stem = Sanskrit_Common::sandhi_engine(Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI), self::aorist_is_suffix);	
			} else if(preg_match("/[ā]$/u", $this->root) && $voice == Commons::PASSIVE_VOICE){			
				// 母音で終わる動詞は専用の受動態を作る
				$verb_stem = Sanskrit_Common::sandhi_engine(Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI), "y".self::aorist_is_suffix);				
			} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->root_type == Commons::PRESENT_ASPECT){
				// isアオリストの場合はこちら
				if(preg_match("/(ā|ai)$/u", $this->root)){
					// sisアオリストの場合は
					$verb_stem = Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::GUNA)."sis";
				} else if(preg_match("/(ai|au|[iīuūeoṛṝ])[bpkghcjtdḍṭmnṅñṃṇ]*([śṣh])$/u", $this->root) &&
						  !preg_match("/(bh|ph|kh|gh|dh|th|ḍh|ṭh)$/u", $this->root)){
					// saアオリストの場合は
					$verb_stem  = $this->aorist_stem;
				} else if($this->root_laryngeal_flag == Commons::$TRUE && !preg_match("/(ā|ai)$/u", $this->root)){
					// isアオリストの場合は
					$verb_stem = Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::GUNA).self::aorist_is_suffix;
				} else {
					// それ以外
					$verb_stem = Sanskrit_Common::change_vowel_grade($this->aorist_stem, Sanskrit_Common::GUNA);
				}
			} else {
				// 完了体語幹の場合
				$verb_stem = $this->aorist_stem;
			}			
		} else if($aspect == Commons::PERFECT_ASPECT && $this->deponent_perfect != Commons::$TRUE){
			// 状態動詞		
			// 人称・法・時制によって場合分け
			if($this->root_type == Commons::NOUN_VERB){
				// 名詞起源動詞はこちら
				// 名詞派生動詞以外は中断する。
				if($this->conjugation_present_type != Commons::NOUN_VERB){
					// ハイフンを返す。
					return "-";
				}
				// 重複語幹の場合
				$verb_stem = $this->perfect_stem;			
			} else if(preg_match('/(1sg|2sg)/', $person) && $tense_mood == Commons::PRESENT_TENSE && $voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
				// 直接法現在の単数1・2人称は中語幹
				$verb_stem = $this->get_weak_perfect_stem(Sanskrit_Common::GUNA);			
			} else if(preg_match('/3sg/', $person) && $tense_mood == Commons::PRESENT_TENSE && $voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
				// 直接法現在の単数3人称は強語幹
				$verb_stem = $this->get_weak_perfect_stem(Sanskrit_Common::VRIDDHI);												
			} else if($tense_mood == Commons::PRESENT_TENSE){
				// それ以外の直接法現在はすべて弱語幹
				$verb_stem = $this->get_weak_perfect_stem(Sanskrit_Common::ZERO_GRADE);				
			} else {
				// それ以外はすべて中語幹
				$verb_stem = $this->get_weak_perfect_stem(Sanskrit_Common::GUNA);
			}
		} else if($aspect == Commons::FUTURE_TENSE && $this->deponent_future != Commons::$TRUE){
			// 未来
			// 母音で終わる動詞は専用の受動態を作る
			// 名詞起源動詞はayを取り除く
			if($this->conjugation_present_type == Commons::NOUN_VERB && $voice == Commons::PASSIVE_VOICE) {	
				$verb_stem = Sanskrit_Common::sandhi_engine("", self::future_suffix2);
			} else if ($this->conjugation_present_type == Commons::NOUN_VERB && $voice == Commons::PASSIVE_VOICE) {	
				// 名詞起源動詞の場合
				$verb_stem = "y".self::future_suffix2;
			} else if(preg_match("/[aiuṛīūṝ]$/", $this->root) && $voice == Commons::PASSIVE_VOICE){
				$verb_stem = Sanskrit_Common::sandhi_engine(Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI), self::future_suffix2);
			} else if(preg_match("/[ā]$/", $this->root) && $voice == Commons::PASSIVE_VOICE){
				$verb_stem = Sanskrit_Common::sandhi_engine(Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI), "y".self::future_suffix2);
			} else if(preg_match("/(dṛś|han|grah|grabh)/", $this->root)){
				// 一部の語根も対象
				$verb_stem = Sanskrit_Common::sandhi_engine(Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI), self::future_suffix2);	
			} else {
				// それ以外は通常の未然相
				$verb_stem = $this->future_stem;	
			}		
		} else {
			// ハイフンを返す。
			return "-";
		} 
		
		// 受動態は中動態に読み替え
		if($voice == Commons::PASSIVE_VOICE){
			$voice = Commons::MEDIOPASSIVE_VOICE;
		}

		//時制と法で取得
		if($tense_mood == Commons::PRESENT_TENSE && ($aspect == Commons::PRESENT_ASPECT || $aspect == Commons::FUTURE_TENSE)) {
			// 完了体・完了形以外の現在時制は一次語尾
			if(preg_match('(2|3|5|7|8|9)',$this->conjugation_present_type)){
				// 三人称複数はaを加える。
				if(preg_match('/(3pl)/', $person)){
					$verb_stem = $verb_stem."a";
				}
				// 音活用動詞は連音処理入り			
				$verb_conjugation = $this->get_sanskrit_primary_suffix($verb_stem, $voice, $person);				
			} else {
				// 母音活用動詞は親クラスで処理
				$verb_conjugation = $this->get_primary_suffix($verb_stem, $voice, $person);				
			}
		} else if(($aspect == Commons::START_VERB || $aspect == Commons::RESULTATIBE) && $tense_mood == Commons::PRESENT_TENSE){
			// 始動相・結果相の場合は親クラスで処理
			$verb_conjugation = $this->get_primary_suffix($verb_stem, $voice, $person);			
		} else if($aspect == Commons::PERFECT_ASPECT && $tense_mood == Commons::PRESENT_TENSE && $this->root_type != Commons::NOUN_VERB){
			// 完了形現在はこちらに移動
			$verb_conjugation = $this->get_sanskrit_perfect_suffix($verb_stem, $voice, $person);	
		} else if($tense_mood == Commons::PAST_TENSE){
			// 過去は二次語尾
			$verb_conjugation = $this->get_primary_verb_secondary_conjugation($verb_stem, $aspect, $voice, $person);
			// 名詞起源動詞以外はaを付け加える(名詞起源動詞は後で付け加える)
			if($this->root_type != Commons::NOUN_VERB && ($verb_conjugation != "" && $verb_conjugation != "-")){
				$verb_conjugation = self::and_then_prefix.$verb_conjugation;
			}
		} else if($tense_mood == Commons::IMJUNCTIVE){
			// 不完全接続法
			$verb_conjugation = $this->get_primary_verb_secondary_conjugation($verb_stem, $aspect, $voice, $person);
		} else if($tense_mood == Commons::SUBJUNCTIVE){
			// 接続法
			$verb_stem = Sanskrit_Common::sandhi_engine($verb_stem, $this->subj);
			$verb_conjugation = $this->get_primary_suffix($verb_stem, $voice, $person);			
		} else if($tense_mood == Commons::OPTATIVE){
			// 希求法
			// 三人称複数の場合
			if(preg_match('/(3pl)/', $person)){
				// 相に応じて分ける。
				if(($aspect == Commons::PRESENT_ASPECT && $aspect == Commons::FUTURE_TENSE) && preg_match('/(1|4|6|10|denomitive|ch-irritative)/',$this->conjugation_present_type)){
					// 不完了体母音活用動詞
					// 語尾と結合
					if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
						// 能動態の場合
						$verb_conjugation= $verb_stem."iyus";						 
					} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
						// 中受動態の場合
						$verb_conjugation= $verb_stem."iran";	
					} else {
						// ハイフンを返す。
						return "-";					
					}
				} else if($this->root_type == Commons::PRESENT_ASPECT && $aspect == Commons::AORIST_ASPECT){
					// 語尾と結合
					if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
						// 能動態の場合
						$verb_conjugation= $verb_stem."yus";						 
					} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
						// 中受動態の場合
						$verb_conjugation= $verb_stem."īran";	
					} else {
						// ハイフンを返す。
						return "-";					
					}
				} else {
					// 語尾と結合
					if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
						$verb_conjugation= $verb_stem."yus";						 
					} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
						$verb_conjugation= $verb_stem."airan";	
					} else {
						// ハイフンを返す。
						return "-";					
					}				
				}
			} else {
				// 相に応じて分ける。
				if($aspect == Commons::PRESENT_ASPECT && preg_match('/(1|3t|4|6|7t|10|denomitive|ch-irritative)/',$this->conjugation_present_type)){
					// 不完了体母音活用動詞
					$verb_stem = Sanskrit_Common::sandhi_engine($verb_stem, "i".$this->opt);
				} else if($aspect == Commons::FUTURE_TENSE){		
					// 未来形
					$verb_stem = Sanskrit_Common::sandhi_engine($verb_stem, "i".$this->opt);
				} else if($this->root_type == Commons::PRESENT_ASPECT &&  
						  $aspect == Commons::AORIST_ASPECT &&
						  $voice == Commons::MEDIOPASSIVE_VOICE){
					// isとsアオリスト中動態は専用の語尾
					if(preg_match('/(3sg|2du|3du)/', $person)){
						// 一部の人称はsを加える。
						$verb_stem = $verb_stem.self::aorist_is_suffix.$this->opt;
					} else {
						// それ以外はiのみ
						$verb_stem = Sanskrit_Common::sandhi_engine($verb_stem, "i".$this->opt);
					}
				} else {
					// それ以外
					$verb_stem = Sanskrit_Common::sandhi_engine($verb_stem, $this->opt);
				}
				// 語尾と結合
				$verb_conjugation = $this->get_secondary_suffix($verb_stem, $voice, $person);
			}
		} else if($tense_mood == "bend" && $aspect == Commons::AORIST_ASPECT){
			// 祈願法
			if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
				// 能動形
				$verb_stem = Sanskrit_Common::sandhi_engine(Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::ZERO_GRADE), $this->opt."s");
				$verb_conjugation = $this->get_active_benedictive_conjugation($verb_stem, $voice, $person);
			} else if(($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE)){
				// 中受動形
				$verb_stem = Sanskrit_Common::sandhi_engine(Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::GUNA), self::aorist_is_suffix);
				$verb_conjugation = $this->get_middle_benedictive_conjugation($verb_stem, $voice, $person);		
			} else {
				// ハイフンを返す。
				return "-";				
			}			
		} else if($tense_mood == Commons::IMPERATIVE){
			// 命令法			
			if(preg_match('/(1sg|1du|1pl)/', $person)){
				// 1人称の場合は接続法にする。
				$verb_stem = Sanskrit_Common::sandhi_engine($verb_stem, $this->subj);
				$verb_conjugation = $this->get_primary_suffix($verb_stem, $voice, $person);
			} else {
				// それ以外は命令法
				// 条件ごとで分ける。
				if(($aspect == Commons::START_VERB || $aspect == Commons::RESULTATIBE) && $this->conjugation_present_type != "10" && $this->root_type != Commons::NOUN_VERB){
					// 始動相・結果相の場合
					// 母音活用動詞は親クラスで処理
					$verb_conjugation = $this->get_secondary_suffix($verb_stem, $voice, $person);
	 			} else if(preg_match('/(2|3|5|7|8|9)/',$this->conjugation_present_type) && $aspect == Commons::PRESENT_ASPECT){
					// 子音活用動詞は連音処理入り
					$verb_conjugation = $this->get_sanskrit_imperative_suffix($verb_stem, $voice, $person);	
				} else if($aspect == Commons::AORIST_ASPECT && $this->conjugation_present_type == "10"){
					// 重複アオリストは親クラスで処理
					$verb_conjugation = $this->get_imperative_suffix($verb_stem, $voice, $person);
				} else if(preg_match("/[aiuṛāīūṝ]$/", $this->root) && $voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE && $aspect == Commons::AORIST_ASPECT){
					// アオリストの中動態はこちらで処理
					$verb_conjugation = $this->get_sanskrit_imperative_suffix($verb_stem, $voice, $person);	
				} else if(($this->root_type == Commons::PRESENT_ASPECT || $this->root_type == Commons::NOUN_VERB) && $aspect == Commons::AORIST_ASPECT){
					if($this->root_laryngeal_flag == Commons::$TRUE && !preg_match("/(ā|ai)$/", $this->root)){
						// isアオリストは親クラスで処理
						$verb_conjugation = $this->get_sanskrit_imperative_suffix($verb_stem, $voice, $person);	
					} else {
						// sアオリストは親クラスで処理
						$verb_conjugation = $this->get_imperative_suffix($verb_stem."a", $voice, $person);	
					}
				} else if($this->root_type == Commons::AORIST_ASPECT){
					// 第二アオリストは親クラスで処理
					$verb_conjugation = $this->get_imperative_suffix($verb_stem, $voice, $person);
				} else if($aspect == Commons::PERFECT_ASPECT && $this->root_type != Commons::NOUN_VERB){
					// 完了形は連音処理入り
					$verb_conjugation = $this->get_sanskrit_imperative_suffix($verb_stem, $voice, $person);
				} else {
					// 母音活用動詞は親クラスで処理
					$verb_conjugation = $this->get_imperative_suffix($verb_stem, $voice, $person);
				}
			}
		} else {
			// ハイフンを返す。
			return "-";
		} 
		
		// 結果を返す。
		if($this->root_type == Commons::NOUN_VERB){
			// 名詞起源動詞の場合は処理を変える。
			// 完了形の場合は
			if($aspect == Commons::PERFECT_ASPECT){
				// 過去形はここで追加する。
				if($tense_mood == Commons::PAST_TENSE){
					$verb_conjugation = self::and_then_prefix.$verb_conjugation;
				}
				// 結果を返す。
				return $verb_conjugation;
			} else {
				// 結果を返す。
				// 過去形はここで追加する。
				if($tense_mood == Commons::PAST_TENSE){
					// 過去形の場合
					return "a".Sanskrit_Common::sandhi_engine($this->add_stem, $verb_conjugation, $vedic_flag, true);
				} else {
					// それ以外の場合
					return Sanskrit_Common::sandhi_engine($this->add_stem, $verb_conjugation, $vedic_flag, true);
				}
			}
		} else {
			// それ以外、sandhiはここで行う。
			return Sanskrit_Common::sandhi_engine($this->add_stem, $verb_conjugation, $vedic_flag, true);
		}
	}

	// 使役動詞
	public function get_causative_sanskrit_verb($person, $voice, $tense_mood, $aspect, $vedic_flag){
		//動詞の語幹を取得
		$verb_stem = "";
		if($aspect == Commons::PRESENT_ASPECT){
			// 不完了体
			// 受動態は専用の語幹を使用
			if($voice == Commons::PASSIVE_VOICE){
				// 名詞起源動詞	
				if($this->root_type == Commons::NOUN_VERB){
					// 名詞と受動態接尾辞を結合
					$verb_stem = Sanskrit_Common::sandhi_engine($this->add_stem, self::passive_suffix);
				} else {
					// それ以外
					$verb_stem = Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI).self::passive_suffix;
				}
			} else {
				// そのまま入れる
				$verb_stem = $this->present_causative_stem;	
			}
		} else if($aspect == Commons::AORIST_ASPECT){			
			// 完了体
			// 受動態は専用の語幹を使用
			if($voice == Commons::PASSIVE_VOICE){
				// 名詞起源動詞	
				if($this->root_type == Commons::NOUN_VERB){
					// 名詞と受動態接尾辞を結合
					$verb_stem = Sanskrit_Common::sandhi_engine($this->add_stem, self::aorist_is_suffix);
				} else {
					// それ以外
					$verb_stem = Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI).self::aorist_is_suffix;
				}
			} else {
				// そのまま入れる
				$verb_stem = $this->aorist_causative_stem;
			}
		} else if($aspect == Commons::PERFECT_ASPECT){
			// 状態動詞		
			$verb_stem = $this->perfect_causative_stem;				
		} else if($aspect == Commons::FUTURE_TENSE){
			// 未然相
			// 受動態は専用の語幹を使用
			if($voice == Commons::PASSIVE_VOICE){
				// 名詞起源動詞	
				if($this->root_type == Commons::NOUN_VERB){
					// 名詞と受動態接尾辞を結合
					$verb_stem = Sanskrit_Common::sandhi_engine($this->add_stem, self::future_suffix2);
				} else {
					// それ以外
					$verb_stem = Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI).self::future_suffix2;
				}		
			} else {
				// そのまま入れる
				$verb_stem = $this->future_causative_stem;
			}					
		} else {
			// ハイフンを返す。
			return "-";
		} 

		// 受動態は中動態に読み替え
		if($voice == Commons::PASSIVE_VOICE){
			$voice = Commons::MEDIOPASSIVE_VOICE;
		}		
		
		// 動詞の活用を取得
		$verb_conjugation = $this->make_causative_conjugation($verb_stem, $person, $voice, $tense_mood, $aspect, $this->present_causative_stem);

		// 結果を返す。
		if($this->conjugation_present_type == Commons::NOUN_VERB){
			// 名詞起源動詞の場合
			// 連音を適用
			$verb_conjugation = Sanskrit_Common::change_sound_to_vedic($verb_conjugation, $vedic_flag);
			// 結果を返す。
			return Sanskrit_Common::change_sound_to_vedic($verb_conjugation, $vedic_flag);	
		} else {
			return Sanskrit_Common::sandhi_engine($this->add_stem, $verb_conjugation, $vedic_flag, true);
		}
	}

	// 願望動詞
	public function get_desiderative_sanskrit_verb($person, $voice, $tense_mood, $aspect, $vedic_flag){
		//動詞の語幹を取得
		$verb_stem = "";
		if($aspect == Commons::PRESENT_ASPECT){
			// 不完了体
			// 受動態は専用の語幹を使用
			if($voice == Commons::PASSIVE_VOICE){
				$verb_stem = $this->present_desiderative_stem.self::passive_suffix;					
			} else {
				// そのまま入れる
				$verb_stem = $this->present_desiderative_stem;	
			}
		} else if($aspect == Commons::AORIST_ASPECT){
			// 完了体
			$verb_stem = $this->aorist_desiderative_stem;			
		} else if($aspect == Commons::PERFECT_ASPECT){
			// 状態動詞		
			$verb_stem = $this->perfect_desiderative_stem;				
		} else if($aspect == Commons::FUTURE_TENSE){
			// 未然相
			$verb_stem = $this->future_desiderative_stem;			
		} else {
			// ハイフンを返す。
			return "-";
		} 
		
		// 受動態は中動態に読み替え
		if($voice == Commons::PASSIVE_VOICE){
			$voice = Commons::MEDIOPASSIVE_VOICE;
		}

		// 動詞の活用を取得
		$verb_conjugation = $this->make_desiderative_conjugation($verb_stem, $person, $voice, $tense_mood, $aspect, $this->present_desiderative_stem);

		// 結果を返す。
		if($this->conjugation_present_type == Commons::NOUN_VERB){
			// 名詞起源動詞の場合
			// 連音を適用
			$verb_conjugation = Sanskrit_Common::change_sound_to_vedic($verb_conjugation, $vedic_flag);
			// 結果を返す。
			return Sanskrit_Common::change_sound_to_vedic($verb_conjugation, $vedic_flag);
		} else {
			// それ以外の場合
			return Sanskrit_Common::sandhi_engine($this->add_stem, $verb_conjugation, $vedic_flag, true);
		}		
	}

	// 強意動詞
	public function get_intensive_sanskrit_verb($person, $voice, $tense_mood, $aspect, $vedic_flag){
		//動詞の語幹を取得
		$verb_stem = "";
		if($aspect == Commons::PRESENT_ASPECT){
			// 不完了体
			// 受動態は専用の語幹を使用
			if($voice == Commons::PASSIVE_VOICE){
				$verb_stem = $this->present_intensive_stem."y".self::passive_suffix;
			} else if($aspect == Commons::MEDIOPASSIVE_VOICE){
				$verb_stem = $this->present_intensive_stem."ya";
			} else {
				// そのまま入れる
				$verb_stem = $this->present_intensive_stem;	
			}
		} else if($aspect == Commons::AORIST_ASPECT){
			// 母音で終わる動詞は専用の受動態を作る
		 	if(preg_match("/[aiuṛāīūṝ]$/", $this->root) && $voice == Commons::PASSIVE_VOICE){
				$verb_stem = Sanskrit_Common::sandhi_engine(Sanskrit_Common::change_vowel_grade($this->present_intensive_stem, Sanskrit_Common::VRIDDHI), self::aorist_is_suffix);	
			} else {
				// 完了体
				$verb_stem = $this->aorist_intensive_stem;	
			}		
		} else if($aspect == Commons::PERFECT_ASPECT){
			// 状態動詞
			if(preg_match('/(1sg|2sg)/', $person) && $tense_mood == Commons::PRESENT_TENSE && $voice == Commons::ACTIVE_VOICE){
				// 直接法現在の単数1・2人称は中語幹
				$verb_stem = $this->perfect_intensive_stem;	
			} else if(preg_match('/3sg/', $person) && $tense_mood == Commons::PRESENT_TENSE && $voice == Commons::ACTIVE_VOICE){
				// 直接法現在の単数3人称は強語幹
				$verb_stem = $this->get_weak_intensive_perfect_stem(Sanskrit_Common::VRIDDHI);	
			} else if($tense_mood == Commons::PRESENT_TENSE){
				// それ以外の直接法現在はすべて弱語幹
				$verb_stem = $this->get_weak_intensive_perfect_stem(Sanskrit_Common::ZERO_GRADE);
			} else {
				// それ以外はすべて中語幹
				$verb_stem = $this->perfect_intensive_stem;	
			}			
		} else if($aspect == Commons::FUTURE_TENSE){
			// 母音で終わる動詞は専用の受動態を作る
			if(preg_match("/[aiuṛāīūṝ]$/", $this->root) && $voice == Commons::PASSIVE_VOICE){
				$verb_stem = Sanskrit_Common::sandhi_engine(Sanskrit_Common::change_vowel_grade($this->present_intensive_stem, Sanskrit_Common::VRIDDHI), self::future_suffix2);	
			} else {
				// 未然相
				$verb_stem = $this->future_intensive_stem;	
			}	
		} else {
			// ハイフンを返す。
			return "-";
		} 
		
		// 受動態は中動態に読み替え
		if($voice == Commons::PASSIVE_VOICE){
			$voice = Commons::MEDIOPASSIVE_VOICE;
		}

		if($tense_mood == Commons::PRESENT_TENSE && ($aspect == Commons::PRESENT_ASPECT || $aspect == Commons::FUTURE_TENSE)) {
			// 母音活用動詞は親クラスで処理
			$verb_conjugation = $this->get_sanskrit_primary_suffix($verb_stem, $voice, $person);		
		} else if($aspect == Commons::PERFECT_ASPECT && $tense_mood == Commons::PRESENT_TENSE){
			// 完了形現在はこちらに移動
			$verb_conjugation = $this->get_sanskrit_perfect_suffix($verb_stem, $voice, $person);
		} else if($tense_mood == Commons::PAST_TENSE){
			// 未完了は二次語尾
			if($aspect == Commons::AORIST_ASPECT){
				// isアオリストは連音処理入り
				$verb_conjugation = self::and_then_prefix.$this->get_is_aorist_indcative_conjugation($verb_stem, $voice, $person, mb_substr($this->present_intensive_stem, 0 , -1));				
			} else {
				// 不完了体・完了形・未来形は親クラスで処理
				$verb_conjugation = self::and_then_prefix.$this->get_secondary_suffix($verb_stem, $voice, $person);
			} 
		} else if($tense_mood == Commons::IMJUNCTIVE){
			// 未完了は二次語尾
			if($aspect == Commons::AORIST_ASPECT){
				// isアオリストは連音処理入り
				$verb_conjugation = $this->get_is_aorist_indcative_conjugation($verb_stem, $voice, $person, mb_substr($this->present_intensive_stem, 0 , -1));
			} else {
				// 不完了体・完了形・未来形は親クラスで処理
				$verb_conjugation = $this->get_secondary_suffix($verb_stem, $voice, $person);
			}  			
		} else if($tense_mood == Commons::SUBJUNCTIVE){
			// 接続法
			$verb_stem = Sanskrit_Common::sandhi_engine($verb_stem, $this->subj);
			$verb_conjugation = $this->get_primary_suffix($verb_stem, $voice, $person);			
		} else if($tense_mood == Commons::OPTATIVE){
			// 希求法
			// 三人称複数の場合
			if(preg_match('/(3pl)/', $person)){
				// 相に応じて分ける。
				if(($aspect == Commons::PRESENT_ASPECT || $aspect == Commons::FUTURE_TENSE || $aspect == Commons::PERFECT_ASPECT)){
					// アオリスト以外
					// 語尾と結合
					if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
						// 能動態の場合	
						$verb_conjugation= $verb_stem."iyus";
					} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){ 
						// 中受動態の場合
						$verb_conjugation= $verb_stem."iran";	
					} else {
						// ハイフンを返す。
						return "-";	
					}
				} else if($aspect == Commons::AORIST_ASPECT){
					// アオリストの場合
					// 語尾と結合
					if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
						// 能動態の場合	
						$verb_conjugation= $verb_stem."yus";						 
					} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){ 
						// 中受動態の場合
						$verb_conjugation= $verb_stem."īran";	
					} else {
						// ハイフンを返す。
						return "-";	
					}
				} 
			} else {
				// 希求法
				if($tense_mood == Commons::PRESENT_TENSE && $voice == Commons::MEDIOPASSIVE_VOICE){
					// 現在形の中受動態
					$verb_stem = $verb_stem."i".$this->opt;
				} else {
					// それ以外
					$verb_stem = Sanskrit_Common::sandhi_engine($verb_stem, $this->opt);
				}
				$verb_conjugation = $this->get_secondary_suffix($verb_stem, $voice, $person);
			}			
		} else if($tense_mood == "bend" && $aspect == Commons::AORIST_ASPECT){
			// 祈願法
			if($voice == Commons::ACTIVE_VOICE){
				// 能動形
				$verb_stem = Sanskrit_Common::sandhi_engine($this->present_intensive_stem, $this->opt."s");
				$verb_conjugation = $this->get_active_benedictive_conjugation($verb_stem, $voice, $person);
			} else {
				// 中受動形
				$verb_stem = Sanskrit_Common::sandhi_engine($this->present_intensive_stem, self::aorist_is_suffix);
				$verb_conjugation = $this->get_middle_benedictive_conjugation($verb_stem, $voice, $person);					
			}			
		} else if($tense_mood == Commons::IMPERATIVE){
			// 命令法			
			if(preg_match('(1sg|1du|1pl)', $person)){
				// 1人称の場合は接続法にする。
				$verb_stem = Sanskrit_Common::sandhi_engine($verb_stem, $this->subj);
				$verb_conjugation = $this->get_primary_suffix($verb_stem, $voice, $person);	
			} else {
				// それ以外は命令法
				if($aspect == Commons::AORIST_ASPECT){
					// isアオリストは連音処理入り
					$verb_conjugation = $this->get_sanskrit_imperative_suffix($verb_stem, $voice, $person);	
				} else if($aspect == Commons::PERFECT_ASPECT){
					// 完了形は連音処理入り
					$verb_conjugation = $this->get_sanskrit_imperative_suffix($verb_stem, $voice, $person);					
				} else {
					// 母音活用動詞は親クラスで処理
					$verb_conjugation = $this->get_imperative_suffix($verb_stem, $voice, $person);
				}
			}
		}
		
		// 結果を返す。
		if($this->conjugation_present_type == Commons::NOUN_VERB){
			// 名詞起源動詞
			return $verb_conjugation;
		} else {
			// それ以外の場合
			return Sanskrit_Common::sandhi_engine($this->add_stem, $verb_conjugation, $vedic_flag, true);
		}
	}

	// 使役+願望動詞
	public function get_causative_desiderative_sanskrit_verb($person, $voice, $tense_mood, $aspect, $vedic_flag){
		//動詞の語幹を取得
		$verb_stem = "";
		if($aspect == Commons::PRESENT_ASPECT){
			// 不完了体
			// 受動態は専用の語幹を使用
			if($voice == Commons::PASSIVE_VOICE){
				$verb_stem = $this->present_causative_desiderative_stem.self::passive_suffix;					
			} else {
				// そのまま入れる
				$verb_stem = $this->present_causative_desiderative_stem;	
			}
		} else if($aspect == Commons::AORIST_ASPECT){
			// 完了体
			$verb_stem = $this->aorist_causative_desiderative_stem;			
		} else if($aspect == Commons::PERFECT_ASPECT){
			// 状態動詞		
			$verb_stem = $this->perfect_causative_desiderative_stem;				
		} else if($aspect == Commons::FUTURE_TENSE){
			// 未然相
			$verb_stem = $this->future_causative_desiderative_stem;			
		} else {
			// ハイフンを返す。
			return "-";
		} 
		
		// 受動態は中動態に読み替え
		if($voice == Commons::PASSIVE_VOICE){
			$voice = Commons::MEDIOPASSIVE_VOICE;
		}

		// 動詞の活用を取得
		$verb_conjugation = $this->make_desiderative_conjugation($verb_stem, $person, $voice, $tense_mood, $aspect, $this->present_causative_desiderative_stem);

		// 結果を返す。
		if($this->conjugation_present_type == Commons::NOUN_VERB){
			// 名詞起源動詞の場合
			return Sanskrit_Common::sandhi_engine("", $verb_conjugation, $vedic_flag, true);
		} else {
			// それ以外の場合
			return Sanskrit_Common::sandhi_engine($this->add_stem, $verb_conjugation, $vedic_flag, true);
		}		
	}

	// 強意+願望動詞
	public function get_intensive_desiderative_sanskrit_verb($person, $voice, $tense_mood, $aspect, $vedic_flag){
		//動詞の語幹を取得
		$verb_stem = "";
		if($aspect == Commons::PRESENT_ASPECT){
			// 不完了体
			// 受動態は専用の語幹を使用
			if($voice == Commons::PASSIVE_VOICE){
				$verb_stem = $this->present_intensive_desiderative_stem.self::passive_suffix;					
			} else {
				// そのまま入れる
				$verb_stem = $this->present_intensive_desiderative_stem;	
			}
		} else if($aspect == Commons::AORIST_ASPECT){
			// 完了体
			$verb_stem = $this->aorist_intensive_desiderative_stem;			
		} else if($aspect == Commons::PERFECT_ASPECT){
			// 状態動詞		
			$verb_stem = $this->perfect_intensive_desiderative_stem;				
		} else if($aspect == Commons::FUTURE_TENSE){
			// 未然相
			$verb_stem = $this->future_intensive_desiderative_stem;			
		} else {
			// ハイフンを返す。
			return "-";
		} 
		
		// 受動態は中動態に読み替え
		if($voice == Commons::PASSIVE_VOICE){
			$voice = Commons::MEDIOPASSIVE_VOICE;
		}

		// 動詞の活用を取得
		$verb_conjugation = $this->make_desiderative_conjugation($verb_stem, $person, $voice, $tense_mood, $aspect, $this->present_intensive_desiderative_stem);

		// 結果を返す。
		if($this->conjugation_present_type == Commons::NOUN_VERB){
			// 名詞起源動詞の場合
			return Sanskrit_Common::sandhi_engine("", $verb_conjugation, $vedic_flag, true);
		} else {
			// それ以外の場合
			return Sanskrit_Common::sandhi_engine($this->add_stem, $verb_conjugation, $vedic_flag, true);
		}		
	}

	// 願望+使役動詞
	public function get_desiderative_causative_sanskrit_verb($person, $voice, $tense_mood, $aspect, $vedic_flag){
		//動詞の語幹を取得
		$verb_stem = "";
		if($aspect == Commons::PRESENT_ASPECT){
			// 不完了体
			// 受動態は専用の語幹を使用
			if($voice == Commons::PASSIVE_VOICE){
				$verb_stem = $this->present_desiderative_causative_stem.self::passive_suffix;
			} else {
				// そのまま入れる
				$verb_stem = $this->present_desiderative_causative_stem;	
			}
		} else if($aspect == Commons::AORIST_ASPECT){			
			// 完了体
			// 受動態は専用の語幹を使用
			if($voice == Commons::PASSIVE_VOICE){
				$verb_stem = mb_substr($this->aorist_desiderative_causative_stem, 0, -2).self::aorist_is_suffix;
			} else {
				// そのまま入れる
				$verb_stem = $this->aorist_desiderative_causative_stem;
			}
		} else if($aspect == Commons::PERFECT_ASPECT){
			// 状態動詞		
			$verb_stem = $this->perfect_desiderative_causative_stem;				
		} else if($aspect == Commons::FUTURE_TENSE){
			// 未然相
			// 受動態は専用の語幹を使用
			if($voice == Commons::PASSIVE_VOICE){
				$verb_stem = mb_substr($this->future_desiderative_causative_stem, 0, -2).self::future_suffix2;
			} else {
				// そのまま入れる
				$verb_stem = $this->future_desiderative_causative_stem;
			}					
		} else {
			// ハイフンを返す。
			return "-";
		} 

		// 受動態は中動態に読み替え
		if($voice == Commons::PASSIVE_VOICE){
			$voice = Commons::MEDIOPASSIVE_VOICE;
		}		
		
		// 動詞の活用を取得
		$verb_conjugation = $this->make_causative_conjugation($verb_stem, $person, $voice, $tense_mood, $aspect, $this->present_desiderative_causative_stem);

		// 結果を返す。
		if($this->conjugation_present_type == Commons::NOUN_VERB){
			// 名詞起源動詞場合
			return $verb_conjugation;	
		} else {
			return Sanskrit_Common::sandhi_engine($this->add_stem, $verb_conjugation, $vedic_flag, true);
		}
	}

	// 強意+使役動詞
	public function get_intensive_causative_sanskrit_verb($person, $voice, $tense_mood, $aspect, $vedic_flag){
		//動詞の語幹を取得
		$verb_stem = "";
		if($aspect == Commons::PRESENT_ASPECT){
			// 不完了体
			// 受動態は専用の語幹を使用
			if($voice == Commons::PASSIVE_VOICE){
				$verb_stem = $this->present_intensive_causative_stem.self::passive_suffix;
			} else {
				// そのまま入れる
				$verb_stem = $this->present_intensive_causative_stem;	
			}
		} else if($aspect == Commons::AORIST_ASPECT){			
			// 完了体
			// 受動態は専用の語幹を使用
			if($voice == Commons::PASSIVE_VOICE){
				$verb_stem = mb_substr($this->aorist_intensive_causative_stem, 0, -2).self::aorist_is_suffix;
			} else {
				// そのまま入れる
				$verb_stem = $this->aorist_intensive_causative_stem;
			}
		} else if($aspect == Commons::PERFECT_ASPECT){
			// 状態動詞		
			$verb_stem = $this->perfect_intensive_causative_stem;				
		} else if($aspect == Commons::FUTURE_TENSE){
			// 未然相
			// 受動態は専用の語幹を使用
			if($voice == Commons::PASSIVE_VOICE){
				$verb_stem = mb_substr($this->future_intensive_causative_stem, 0, -2).self::future_suffix2;
			} else {
				// そのまま入れる
				$verb_stem = $this->future_intensive_causative_stem;
			}					
		} else {
			// ハイフンを返す。
			return "-";
		} 

		// 受動態は中動態に読み替え
		if($voice == Commons::PASSIVE_VOICE){
			$voice = Commons::MEDIOPASSIVE_VOICE;
		}		
		
		// 動詞の活用を取得
		$verb_conjugation = $this->make_causative_conjugation($verb_stem, $person, $voice, $tense_mood, $aspect, $this->present_intensive_causative_stem);

		// 結果を返す。
		if($this->conjugation_present_type == Commons::NOUN_VERB){
			// 名詞起源動詞場合
			return $verb_conjugation;	
		} else {
			return Sanskrit_Common::sandhi_engine($this->add_stem, $verb_conjugation, $vedic_flag, true);
		}
	}

	// 一次語尾
	protected function get_sanskrit_primary_suffix($verb_conjugation, $voice, $person){
		// 語尾を取得
		if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 能動態
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_conjugation, $this->primary_number[$voice][$person]);
		} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
			// 中受動態単数
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_conjugation, $this->primary_number[$voice][$person]);
		} else {
			// ハイフンを返す。
			return "-";
		} 
		
		// 結果を返す。
		return $verb_conjugation;
	}
	
	// 二次語尾
	protected function get_sanskrit_secondary_suffix($verb_conjugation, $voice, $person){
		// 語尾を取得
		if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 能動態単数
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_conjugation, $this->secondary_number[$voice][$person]);
		} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
			// 中受動態単数
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_conjugation, $this->secondary_number[$voice][$person]);
		} else {
			// ハイフンを返す。
			return "-";
		} 
		
		// 結果を返す。
		return $verb_conjugation;
	}
	
	// 命令語尾
	protected function get_sanskrit_imperative_suffix($verb_conjugation, $voice, $person){
		// 命令法
		// 語尾を取得
		if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 能動態単数
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_conjugation, $this->imperative_number2[$voice][$person]);
		} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
			// 中受動態単数
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_conjugation, $this->imperative_number2[$voice][$person]);
		} else {
			// ハイフンを返す。
			return "-";
		} 
		// 結果を返す。
		return $verb_conjugation;
	}	
	
	// 完了語尾
	protected function get_sanskrit_perfect_suffix($verb_conjugation, $voice, $person){
		// 語尾を取得
		if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 能動態
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_conjugation, $this->perfect_number[$voice][$person], false, false);
		} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
			// 受動態
			$verb_conjugation = Sanskrit_Common::sandhi_engine($verb_conjugation, $this->perfect_number[$voice][$person], false, false);		
		} else {
			// ハイフンを返す。
			return "-";
		}  
		// 結果を返す。
		return $verb_conjugation;
	}

	// 分詞の曲用表を返す。	
	protected function get_participle($participle_stem){
		// 読み込み
		$vedic_adjective = new Vedic_Adjective($participle_stem, "participle");
		// 結果を取得
		$chart = $vedic_adjective->get_chart();
		// メモリを解放
		unset($vedic_adjective);
		// 結果を返す。
		return $chart;
	}

	// 不定詞の曲用表を返す。	
	protected function get_infinitive($infinitive_stem){
		// 読み込み
		$infinitive = new Vedic_Noun($infinitive_stem, "");
		// 結果を取得
		$chart = $infinitive->get_chart();
		// メモリを解放
		unset($infinitive);
		// 結果を返す。
		return $chart;
	}

	// 一次動詞の活用を作成する。
	protected function get_primary_verb_conjugation($classic_flag){

		// 配列を作成
		$aspect_array = array(Commons::PRESENT_ASPECT, Commons::START_VERB, Commons::RESULTATIBE, Commons::AORIST_ASPECT, Commons::PERFECT_ASPECT, Commons::FUTURE_TENSE);			// 相
		$voice_array = array(Commons::ACTIVE_VOICE, Commons::MEDIOPASSIVE_VOICE, Commons::PASSIVE_VOICE);								// 態
		$tense_mood_array = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE, Commons::IMJUNCTIVE, Commons::SUBJUNCTIVE, Commons::OPTATIVE, "bend", Commons::IMPERATIVE);	//時制と法
		$person_array = array("1sg", "2sg", "3sg", "1du", "2du", "3du", "1pl", "2pl", "3pl");												// 人称

		// 初期化
		$conjugation = array();
		// 全ての法
		foreach ($aspect_array as $aspect){	
			// 全ての態			
			foreach ($voice_array as $voice){
				// 全ての法			
				foreach ($tense_mood_array as $tense_mood){
					// 全ての人称			
					foreach ($person_array as $person){
						// 古典フラグ
						if($classic_flag == Commons::$TRUE){
							// 古典期に失われた活用は出力しない。
							if(!$this->judge_classical_conjugation($tense_mood, $aspect)){
								$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
								continue;
							}
							// 古典フラグONの時のアオリストは重複アオリスト		
							if($this->root_type == Commons::NOUN_VERB && $aspect == Commons::AORIST_ASPECT && $tense_mood != "bend"){
								$conjugation[$aspect][$voice][$tense_mood][$person] = $this->get_sanskrit_verb($person, $voice, $tense_mood, Commons::PERFECT_ASPECT, Commons::change_flag($classic_flag));	
								continue;
							}
						}
						// 態と人称で場合分けする。
						if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::PASSIVE_VOICE){
							// 完了形の受動態は存在しないため、処理を飛ばす。
							continue;
						} else if($aspect == Commons::START_VERB && $voice == Commons::PASSIVE_VOICE){
							// 始動動詞の受動態は存在しないため、処理を飛ばす。
							continue;
						} else if($aspect == Commons::RESULTATIBE && $voice == Commons::PASSIVE_VOICE){
							// 結果動詞の受動態は存在しないため、処理を飛ばす。
							continue;
						} else if($aspect == Commons::AORIST_ASPECT && $tense_mood == Commons::PRESENT_TENSE){
							// アオリストの現在時制は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
						} else if($aspect != Commons::AORIST_ASPECT && $tense_mood == "bend"){
							// アオリスト以外は祈願法は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";							
						} else if(!preg_match("/[aiuṛāīūṝ]$/", $this->root) && $aspect == Commons::AORIST_ASPECT && $voice == Commons::PASSIVE_VOICE){
							// 末尾が母音で終わらない動詞は、アオリストの受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else if(!preg_match("/[aiuṛāīūṝ]$/", $this->root) && $aspect == Commons::FUTURE_TENSE && $voice == Commons::PASSIVE_VOICE){
							// 末尾が母音で終わらない動詞は、未来形の受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];								
						} else {
							// 態・時制・法・人称に応じて多次元配列を作成		
							$conjugation[$aspect][$voice][$tense_mood][$person] = $this->get_sanskrit_verb($person, $voice, $tense_mood, $aspect, Commons::change_flag($classic_flag));	
						}					
					}
				}

			}
		}
		// 分詞を入れる。
		// 現在分詞
		$conjugation[Commons::PRESENT_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->present_participle_active);			// 能動
		$conjugation[Commons::PRESENT_ASPECT][Commons::MIDDLE_VOICE]["participle"] = $this->get_participle($this->present_participle_middle);			// 中動
		$conjugation[Commons::PRESENT_ASPECT][Commons::PASSIVE_VOICE]["participle"] = $this->get_participle($this->present_participle_passive);			// 受動
		
		// 完了体分詞(古典フラグがOFFの場合)
		if($classic_flag == Commons::$FALSE){
			$conjugation[Commons::AORIST_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->aorist_participle_active);			// 能動
			$conjugation[Commons::AORIST_ASPECT][Commons::MIDDLE_VOICE]["participle"] = $this->get_participle($this->aorist_participle_middle);			// 中動
			$conjugation[Commons::AORIST_ASPECT][Commons::PASSIVE_VOICE]["participle"] = $this->get_participle($this->aorist_participle_passive);		// 受動
		}

		// 完了形分詞
		$conjugation[Commons::PERFECT_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->perfect_participle_active);			// 能動
		$conjugation[Commons::PERFECT_ASPECT][Commons::MEDIOPASSIVE_VOICE]["participle"] = $this->get_participle($this->perfect_participle_middle);		// 中受動

		// 未来分詞
		$conjugation[Commons::FUTURE_TENSE][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->future_participle_active);				// 能動
		$conjugation[Commons::FUTURE_TENSE][Commons::MIDDLE_VOICE]["participle"] = $this->get_participle($this->future_participle_middle);				// 中動
		$conjugation[Commons::FUTURE_TENSE][Commons::PASSIVE_VOICE]["participle"] = $this->get_participle($this->future_participle_passive);			// 受動

		// 過去分詞
		$conjugation[Commons::PAST_TENSE][Commons::ACTIVE_VOICE]["na-participle"] = $this->get_participle($this->past_na_participle_active);			// na-能動
		$conjugation[Commons::PAST_TENSE][Commons::ACTIVE_VOICE]["ta-participle"] = $this->get_participle($this->past_ta_participle_active);			// ta-能動
		$conjugation[Commons::PAST_TENSE][Commons::PASSIVE_VOICE]["na-participle"] = $this->get_participle($this->past_na_participle_passive);			// na-受動
		$conjugation[Commons::PAST_TENSE][Commons::PASSIVE_VOICE]["ta-participle"] = $this->get_participle($this->past_ta_participle_passive);			// ta-受動

		// 動形容詞
		$conjugation["adjective"]["tavya"] = $this->get_participle($this->verbal_adjectives[0]);
		$conjugation["adjective"]["ya"] = $this->get_participle($this->verbal_adjectives[1]);
		$conjugation["adjective"]["ta"] = $this->get_participle($this->verbal_adjectives[2]);
		$conjugation["adjective"]["aniya"] = $this->get_participle($this->verbal_adjectives[3]);

		// 不定詞
		foreach($this->primary_infinitives as $primary_infinitive){
			$conjugation["infinitive"][] = $this->get_infinitive($primary_infinitive);
		}

		// 結果を返す。
		return $conjugation;
	}

	// 使役動詞の活用を作成する。
	protected function get_causative_verb_conjugation($classic_flag){

		// 配列を作成
		$aspect_array = array(Commons::PRESENT_ASPECT, Commons::START_VERB, Commons::RESULTATIBE, Commons::AORIST_ASPECT, Commons::PERFECT_ASPECT, Commons::FUTURE_TENSE);			// 相
		$voice_array = array(Commons::ACTIVE_VOICE, Commons::MEDIOPASSIVE_VOICE, Commons::PASSIVE_VOICE);								// 態
		$tense_mood_array = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE, Commons::IMJUNCTIVE, Commons::SUBJUNCTIVE, "bend", Commons::OPTATIVE, Commons::IMPERATIVE);	//時制と法
		$person_array = array("1sg", "2sg", "3sg", "1du", "2du", "3du", "1pl", "2pl", "3pl");												// 人称

		// 初期化
		$conjugation = array();

		// 全ての法
		foreach ($aspect_array as $aspect){	
			// 全ての態			
			foreach ($voice_array as $voice){
				// 全ての法			
				foreach ($tense_mood_array as $tense_mood){
					// 全ての人称			
					foreach ($person_array as $person){
						// 古典フラグ
						if($classic_flag == Commons::$TRUE){
							// 古典期に失われた活用は出力しない。
							if(!$this->judge_classical_conjugation($tense_mood, $aspect)){
								$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
								continue;
							}
						}
						// 態と人称で場合分けする。
						if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::PASSIVE_VOICE){
							// 完了形の受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else if($aspect == Commons::AORIST_ASPECT && $tense_mood == Commons::PRESENT_TENSE){
							// アオリストの現在時制は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
						} else if($aspect != Commons::AORIST_ASPECT && $tense_mood == "bend"){
							// アオリスト以外は祈願法は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";							
						} else {
							// 態・時制・法・人称に応じて多次元配列を作成		
							$conjugation[$aspect][$voice][$tense_mood][$person] = $this->get_causative_sanskrit_verb($person, $voice, $tense_mood, $aspect, Commons::change_flag($classic_flag));	
						}												
					}
				}
			}
		}

		// 分詞を入れる。
		// 現在分詞
		$conjugation[Commons::PRESENT_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->present_causative_participle_active);			// 能動
		$conjugation[Commons::PRESENT_ASPECT][Commons::MIDDLE_VOICE]["participle"] = $this->get_participle($this->present_causative_participle_middle);			// 中動
		$conjugation[Commons::PRESENT_ASPECT][Commons::PASSIVE_VOICE]["participle"] = $this->get_participle($this->present_causative_participle_passive);		// 受動

		// 完了体分詞(古典フラグがOFFの場合)
		if(Commons::change_flag($classic_flag) == Commons::$TRUE){	
			$conjugation[Commons::AORIST_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->aorist_causative_participle_active);			// 能動
			$conjugation[Commons::AORIST_ASPECT][Commons::MIDDLE_VOICE]["participle"] = $this->get_participle($this->aorist_causative_participle_middle);			// 中動
			$conjugation[Commons::AORIST_ASPECT][Commons::PASSIVE_VOICE]["participle"] = $this->get_participle($this->aorist_causative_participle_passive);			// 受動
		}

		// 完了形分詞
		$conjugation[Commons::PERFECT_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->perfect_causative_participle_active);			// 能動
		$conjugation[Commons::PERFECT_ASPECT][Commons::MEDIOPASSIVE_VOICE]["participle"] = $this->get_participle($this->perfect_causative_participle_middle);	// 中受動

		// 未来分詞
		$conjugation[Commons::FUTURE_TENSE][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->future_causative_participle_active);			// 能動
		$conjugation[Commons::FUTURE_TENSE][Commons::MIDDLE_VOICE]["participle"] = $this->get_participle($this->future_causative_participle_middle);			// 中動
		$conjugation[Commons::FUTURE_TENSE][Commons::PASSIVE_VOICE]["participle"] = $this->get_participle($this->future_causative_participle_passive);			// 受動

		// 過去分詞
		$conjugation[Commons::PAST_TENSE][Commons::ACTIVE_VOICE]["na-participle"] = $this->get_participle($this->past_causative_na_participle_active);			// na-能動
		$conjugation[Commons::PAST_TENSE][Commons::ACTIVE_VOICE]["ta-participle"] = $this->get_participle($this->past_causative_ta_participle_active);			// ta-能動
		$conjugation[Commons::PAST_TENSE][Commons::PASSIVE_VOICE]["na-participle"] = $this->get_participle($this->past_causative_na_participle_passive);		// na-受動
		$conjugation[Commons::PAST_TENSE][Commons::PASSIVE_VOICE]["ta-participle"] = $this->get_participle($this->past_causative_ta_participle_passive);		// ta-受動

		// 動形容詞
		$conjugation["adjective"]["tavya"] = $this->get_participle($this->causative_verbal_adjectives[0]);
		$conjugation["adjective"]["ya"] = $this->get_participle($this->causative_verbal_adjectives[1]);
		$conjugation["adjective"]["aniya"] = $this->get_participle($this->causative_verbal_adjectives[2]);

		// 不定詞
		foreach($this->causative_infinitives as $causative_infinitive){
			$conjugation["infinitive"][] = $this->get_infinitive($causative_infinitive);
		}

		// 結果を返す。
		return $conjugation;
	}

	// 願望動詞の活用を作成する。
	protected function get_desiderative_verb_conjugation($classic_flag){

		// 配列を作成
		$aspect_array = array(Commons::PRESENT_ASPECT, Commons::START_VERB, Commons::RESULTATIBE, Commons::AORIST_ASPECT, Commons::PERFECT_ASPECT, Commons::FUTURE_TENSE);			// 相
		$voice_array = array(Commons::ACTIVE_VOICE, Commons::MEDIOPASSIVE_VOICE, Commons::PASSIVE_VOICE);								// 態
		$tense_mood_array = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE, Commons::IMJUNCTIVE, Commons::SUBJUNCTIVE, "bend", Commons::OPTATIVE, Commons::IMPERATIVE);	//時制と法
		$person_array = array("1sg", "2sg", "3sg", "1du", "2du", "3du", "1pl", "2pl", "3pl");												// 人称

		// 初期化
		$conjugation = array();

		// 全ての法
		foreach ($aspect_array as $aspect){	
			// 全ての態			
			foreach ($voice_array as $voice){
				// 全ての法			
				foreach ($tense_mood_array as $tense_mood){
					// 全ての人称			
					foreach ($person_array as $person){
						// 古典フラグ
						if($classic_flag == Commons::$TRUE){
							// 古典期に失われた活用は出力しない。
							if(!$this->judge_classical_conjugation($tense_mood, $aspect)){
								$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
								continue;
							}
						}
						// 態と人称で場合分けする。
						if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::PASSIVE_VOICE){
							// 完了形の受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else if($aspect == Commons::AORIST_ASPECT && $tense_mood == Commons::PRESENT_TENSE){
							// アオリストの現在時制は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
						} else if($aspect != Commons::AORIST_ASPECT && $tense_mood == "bend"){
							// アオリスト以外は祈願法は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";							
						} else if($aspect == Commons::AORIST_ASPECT && $voice == Commons::PASSIVE_VOICE){
							// アオリストの受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else if($aspect == Commons::FUTURE_TENSE && $voice == Commons::PASSIVE_VOICE){
							// 未来形の受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else {
							// 態・時制・法・人称に応じて多次元配列を作成		
							$conjugation[$aspect][$voice][$tense_mood][$person] = $this->get_desiderative_sanskrit_verb($person, $voice, $tense_mood, $aspect, Commons::change_flag($classic_flag));	
						}
					}
				}
			}
		}

		// 分詞を入れる。
		// 現在分詞
		$conjugation[Commons::PRESENT_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->present_desiderative_participle_active);			// 能動
		$conjugation[Commons::PRESENT_ASPECT][Commons::MIDDLE_VOICE]["participle"] = $this->get_participle($this->present_desiderative_participle_middle);			// 中動
		$conjugation[Commons::PRESENT_ASPECT][Commons::PASSIVE_VOICE]["participle"] = $this->get_participle($this->present_desiderative_participle_passive);			// 受動

		// 完了体分詞(古典フラグがOFFの場合)
		if(Commons::change_flag($classic_flag) == Commons::$TRUE){	
			$conjugation[Commons::AORIST_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->aorist_desiderative_participle_active);			// 能動
			$conjugation[Commons::AORIST_ASPECT][Commons::MEDIOPASSIVE_VOICE]["participle"] = $this->get_participle($this->aorist_desiderative_participle_middle);		// 中受動
		}

		// 未来分詞
		$conjugation[Commons::FUTURE_TENSE][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->future_desiderative_participle_active);				// 能動
		$conjugation[Commons::FUTURE_TENSE][Commons::MEDIOPASSIVE_VOICE]["participle"] = $this->get_participle($this->future_desiderative_participle_middle);			// 中動

		// 過去分詞
		$conjugation[Commons::PAST_TENSE][Commons::ACTIVE_VOICE]["na-participle"] = $this->get_participle($this->past_desiderative_na_participle_active);				// na-能動
		$conjugation[Commons::PAST_TENSE][Commons::ACTIVE_VOICE]["ta-participle"] = $this->get_participle($this->past_desiderative_ta_participle_active);				// ta-能動
		$conjugation[Commons::PAST_TENSE][Commons::PASSIVE_VOICE]["na-participle"] = $this->get_participle($this->past_desiderative_na_participle_passive);			// na-受動
		$conjugation[Commons::PAST_TENSE][Commons::PASSIVE_VOICE]["ta-participle"] = $this->get_participle($this->past_desiderative_ta_participle_passive);			// ta-受動

		// 動形容詞
		$conjugation["adjective"]["tavya"] = $this->get_participle($this->desiderative_verbal_adjectives[0]);
		$conjugation["adjective"]["ya"] = $this->get_participle($this->desiderative_verbal_adjectives[1]);
		$conjugation["adjective"]["aniya"] = $this->get_participle($this->desiderative_verbal_adjectives[2]);

		// 不定詞
		foreach($this->desiderative_infinitives as $desiderative_infinitive){
			$conjugation["infinitive"][] = $this->get_infinitive($desiderative_infinitive);
		}

		// 結果を返す。
		return $conjugation;
	}

	// 強意動詞の活用を作成する。
	protected function get_intensive_verb_conjugation($classic_flag){

		// 配列を作成
		$aspect_array = array(Commons::PRESENT_ASPECT, Commons::START_VERB, Commons::RESULTATIBE, Commons::AORIST_ASPECT, Commons::PERFECT_ASPECT, Commons::FUTURE_TENSE);			// 相
		$voice_array = array(Commons::ACTIVE_VOICE, Commons::MEDIOPASSIVE_VOICE, Commons::PASSIVE_VOICE);								// 態
		$tense_mood_array = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE, Commons::IMJUNCTIVE, Commons::SUBJUNCTIVE, "bend", Commons::OPTATIVE, Commons::IMPERATIVE);	//時制と法
		$person_array = array("1sg", "2sg", "3sg", "1du", "2du", "3du", "1pl", "2pl", "3pl");												// 人称

		// 初期化
		$conjugation = array();

		// 全ての法
		foreach ($aspect_array as $aspect){	
			// 全ての態			
			foreach ($voice_array as $voice){
				// 全ての法			
				foreach ($tense_mood_array as $tense_mood){
					// 全ての人称			
					foreach ($person_array as $person){
						// 古典フラグ
						if($classic_flag == Commons::$TRUE){
							// 古典期に失われた活用は出力しない。
							if(!$this->judge_classical_conjugation($tense_mood, $aspect)){
								$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
								continue;
							}
						}
						// 態と人称で場合分けする。
						if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::PASSIVE_VOICE){
							// 完了形の受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else if($aspect == Commons::AORIST_ASPECT && $tense_mood == Commons::PRESENT_TENSE){
							// アオリストの現在時制は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
						} else if($aspect != Commons::AORIST_ASPECT && $tense_mood == "bend"){
							// アオリスト以外は祈願法は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";							
						} else if(!preg_match("/[aiuṛāīūṝ]$/", $this->root) && $aspect == Commons::AORIST_ASPECT && $voice == Commons::PASSIVE_VOICE){
							// 末尾が母音で終わらない動詞は、アオリストの受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else if(!preg_match("/[aiuṛāīūṝ]$/", $this->root) && $aspect == Commons::FUTURE_TENSE && $voice == Commons::PASSIVE_VOICE){
							// 末尾が母音で終わらない動詞は、未来形の受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];	
						} else {
							// 態・時制・法・人称に応じて多次元配列を作成		
							$conjugation[$aspect][$voice][$tense_mood][$person] = $this->get_intensive_sanskrit_verb($person, $voice, $tense_mood, $aspect, Commons::change_flag($classic_flag));	
						}
					}
				}
			}
		}

		// 分詞を入れる。
		// 現在分詞
		$conjugation[Commons::PRESENT_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->present_intensive_participle_active);			// 能動
		$conjugation[Commons::PRESENT_ASPECT][Commons::MIDDLE_VOICE]["participle"] = $this->get_participle($this->present_intensive_participle_middle);			// 中動
		$conjugation[Commons::PRESENT_ASPECT][Commons::PASSIVE_VOICE]["participle"] = $this->get_participle($this->present_intensive_participle_passive);			// 受動

		// 完了体分詞(古典フラグがOFFの場合)
		if(Commons::change_flag($classic_flag) == Commons::$TRUE){		
			$conjugation[Commons::AORIST_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->aorist_intensive_participle_active);				// 能動
			$conjugation[Commons::AORIST_ASPECT][Commons::MEDIOPASSIVE_VOICE]["participle"] = $this->get_participle($this->aorist_intensive_participle_middle);		// 中受動
		}

		// 未来分詞
		$conjugation[Commons::FUTURE_TENSE][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->future_intensive_participle_active);				// 能動
		$conjugation[Commons::FUTURE_TENSE][Commons::MEDIOPASSIVE_VOICE]["participle"] = $this->get_participle($this->future_intensive_participle_middle);		// 中動

		// 過去分詞
		$conjugation[Commons::PAST_TENSE][Commons::ACTIVE_VOICE]["na-participle"] = $this->get_participle($this->past_intensive_na_participle_active);			// na-能動
		$conjugation[Commons::PAST_TENSE][Commons::ACTIVE_VOICE]["ta-participle"] = $this->get_participle($this->past_intensive_ta_participle_active);			// ta-能動
		$conjugation[Commons::PAST_TENSE][Commons::PASSIVE_VOICE]["na-participle"] = $this->get_participle($this->past_intensive_na_participle_passive);			// na-受動
		$conjugation[Commons::PAST_TENSE][Commons::PASSIVE_VOICE]["ta-participle"] = $this->get_participle($this->past_intensive_ta_participle_passive);			// ta-受動		

		// 動形容詞
		$conjugation["adjective"]["tavya"] = $this->get_participle($this->intensive_verbal_adjectives[0]);
		$conjugation["adjective"]["ya"] = $this->get_participle($this->intensive_verbal_adjectives[1]);
		$conjugation["adjective"]["aniya"] = $this->get_participle($this->intensive_verbal_adjectives[2]);

		// 不定詞
		foreach($this->intensive_infinitives as $intensive_infinitive){
			$conjugation["infinitive"][] = $this->get_infinitive($intensive_infinitive);
		}
		// 結果を返す。
		return $conjugation;
	}

	// 使役+願望動詞の活用を作成する。
	protected function get_causative_desiderative_verb_conjugation($classic_flag){

		// 配列を作成
		$aspect_array = array(Commons::PRESENT_ASPECT, Commons::START_VERB, Commons::RESULTATIBE, Commons::AORIST_ASPECT, Commons::PERFECT_ASPECT, Commons::FUTURE_TENSE);			// 相
		$voice_array = array(Commons::ACTIVE_VOICE, Commons::MEDIOPASSIVE_VOICE, Commons::PASSIVE_VOICE);								// 態
		$tense_mood_array = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE, Commons::IMJUNCTIVE, Commons::SUBJUNCTIVE, "bend", Commons::OPTATIVE, Commons::IMPERATIVE);	//時制と法
		$person_array = array("1sg", "2sg", "3sg", "1du", "2du", "3du", "1pl", "2pl", "3pl");												// 人称

		// 初期化
		$conjugation = array();

		// 全ての法
		foreach ($aspect_array as $aspect){	
			// 全ての態			
			foreach ($voice_array as $voice){
				// 全ての法			
				foreach ($tense_mood_array as $tense_mood){
					// 全ての人称			
					foreach ($person_array as $person){
						// 古典フラグ
						if($classic_flag == Commons::$TRUE){
							// 古典期に失われた活用は出力しない。
							if(!$this->judge_classical_conjugation($tense_mood, $aspect)){
								$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
								continue;
							}
						}
						// 態と人称で場合分けする。
						if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::PASSIVE_VOICE){
							// 完了形の受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else if($aspect == Commons::AORIST_ASPECT && $tense_mood == Commons::PRESENT_TENSE){
							// アオリストの現在時制は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
						} else if($aspect != Commons::AORIST_ASPECT && $tense_mood == "bend"){
							// アオリスト以外は祈願法は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";							
						} else if($aspect == Commons::AORIST_ASPECT && $voice == Commons::PASSIVE_VOICE){
							// アオリストの受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else if($aspect == Commons::FUTURE_TENSE && $voice == Commons::PASSIVE_VOICE){
							// 未来形の受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else {
							// 態・時制・法・人称に応じて多次元配列を作成		
							$conjugation[$aspect][$voice][$tense_mood][$person] = $this->get_causative_desiderative_sanskrit_verb($person, $voice, $tense_mood, $aspect, Commons::change_flag($classic_flag));	
						}
					}
				}
			}
		}

		// 分詞を入れる。
		// 現在分詞
		$conjugation[Commons::PRESENT_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->present_causative_desiderative_participle_active);			// 能動
		$conjugation[Commons::PRESENT_ASPECT][Commons::MIDDLE_VOICE]["participle"] = $this->get_participle($this->present_causative_desiderative_participle_middle);			// 中動
		$conjugation[Commons::PRESENT_ASPECT][Commons::PASSIVE_VOICE]["participle"] = $this->get_participle($this->present_causative_desiderative_participle_passive);			// 受動

		// 完了体分詞(古典フラグがOFFの場合)
		if(Commons::change_flag($classic_flag) == Commons::$TRUE){	
			$conjugation[Commons::AORIST_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->aorist_causative_desiderative_participle_active);				// 能動
			$conjugation[Commons::AORIST_ASPECT][Commons::MEDIOPASSIVE_VOICE]["participle"] = $this->get_participle($this->aorist_causative_desiderative_participle_middle);		// 中受動
		}
		
		// 未来分詞
		$conjugation[Commons::FUTURE_TENSE][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->future_causative_desiderative_participle_active);				// 能動
		$conjugation[Commons::FUTURE_TENSE][Commons::MEDIOPASSIVE_VOICE]["participle"] = $this->get_participle($this->future_causative_desiderative_participle_middle);			// 中動

		// 過去分詞
		$conjugation[Commons::PAST_TENSE][Commons::ACTIVE_VOICE]["na-participle"] = $this->get_participle($this->past_causative_desiderative_na_participle_active);				// na-能動
		$conjugation[Commons::PAST_TENSE][Commons::ACTIVE_VOICE]["ta-participle"] = $this->get_participle($this->past_causative_desiderative_ta_participle_active);				// ta-能動
		$conjugation[Commons::PAST_TENSE][Commons::PASSIVE_VOICE]["na-participle"] = $this->get_participle($this->past_causative_desiderative_na_participle_passive);			// na-受動
		$conjugation[Commons::PAST_TENSE][Commons::PASSIVE_VOICE]["ta-participle"] = $this->get_participle($this->past_causative_desiderative_ta_participle_passive);			// ta-受動

		// 動形容詞
		$conjugation["adjective"]["tavya"] = $this->get_participle($this->causative_desiderative_verbal_adjectives[0]);
		$conjugation["adjective"]["ya"] = $this->get_participle($this->causative_desiderative_verbal_adjectives[1]);
		$conjugation["adjective"]["aniya"] = $this->get_participle($this->causative_desiderative_verbal_adjectives[2]);

		// 不定詞
		foreach($this->causative_desiderative_infinitives as $causative_desiderative_infinitive){
			$conjugation["infinitive"][] = $this->get_infinitive($causative_desiderative_infinitive);
		}

		// 結果を返す。
		return $conjugation;
	}

	// 強意+願望動詞の活用を作成する。
	protected function get_intensive_desiderative_verb_conjugation($classic_flag){

		// 配列を作成
		$aspect_array = array(Commons::PRESENT_ASPECT, Commons::START_VERB, Commons::RESULTATIBE, Commons::AORIST_ASPECT, Commons::PERFECT_ASPECT, Commons::FUTURE_TENSE);			// 相
		$voice_array = array(Commons::ACTIVE_VOICE, Commons::MEDIOPASSIVE_VOICE, Commons::PASSIVE_VOICE);								// 態
		$tense_mood_array = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE, Commons::IMJUNCTIVE, Commons::SUBJUNCTIVE, "bend", Commons::OPTATIVE, Commons::IMPERATIVE);	//時制と法
		$person_array = array("1sg", "2sg", "3sg", "1du", "2du", "3du", "1pl", "2pl", "3pl");												// 人称

		// 初期化
		$conjugation = array();

		// 全ての法
		foreach ($aspect_array as $aspect){	
			// 全ての態			
			foreach ($voice_array as $voice){
				// 全ての法			
				foreach ($tense_mood_array as $tense_mood){
					// 全ての人称			
					foreach ($person_array as $person){
						// 古典フラグ
						if($classic_flag == Commons::$TRUE){
							// 古典期に失われた活用は出力しない。
							if(!$this->judge_classical_conjugation($tense_mood, $aspect)){
								$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
								continue;
							}
						}
						// 態と人称で場合分けする。
						if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::PASSIVE_VOICE){
							// 完了形の受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else if($aspect == Commons::AORIST_ASPECT && $tense_mood == Commons::PRESENT_TENSE){
							// アオリストの現在時制は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
						} else if($aspect != Commons::AORIST_ASPECT && $tense_mood == "bend"){
							// アオリスト以外は祈願法は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";							
						} else if($aspect == Commons::AORIST_ASPECT && $voice == Commons::PASSIVE_VOICE){
							// アオリストの受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else if($aspect == Commons::FUTURE_TENSE && $voice == Commons::PASSIVE_VOICE){
							// 未来形の受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else {
							// 態・時制・法・人称に応じて多次元配列を作成		
							$conjugation[$aspect][$voice][$tense_mood][$person] = $this->get_intensive_desiderative_sanskrit_verb($person, $voice, $tense_mood, $aspect, Commons::change_flag($classic_flag));	
						}
					}
				}
			}
		}

		// 分詞を入れる。
		// 現在分詞
		$conjugation[Commons::PRESENT_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->present_intensive_desiderative_participle_active);			// 能動
		$conjugation[Commons::PRESENT_ASPECT][Commons::MIDDLE_VOICE]["participle"] = $this->get_participle($this->present_intensive_desiderative_participle_middle);			// 中動
		$conjugation[Commons::PRESENT_ASPECT][Commons::PASSIVE_VOICE]["participle"] = $this->get_participle($this->present_intensive_desiderative_participle_passive);			// 受動

		// 完了体分詞(古典フラグがOFFの場合)
		if(Commons::change_flag($classic_flag) == Commons::$TRUE){	
			$conjugation[Commons::AORIST_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->aorist_intensive_desiderative_participle_active);				// 能動
			$conjugation[Commons::AORIST_ASPECT][Commons::MEDIOPASSIVE_VOICE]["participle"] = $this->get_participle($this->aorist_intensive_desiderative_participle_middle);		// 中受動
		}
		// 未来分詞
		$conjugation[Commons::FUTURE_TENSE][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->future_intensive_desiderative_participle_active);				// 能動
		$conjugation[Commons::FUTURE_TENSE][Commons::MEDIOPASSIVE_VOICE]["participle"] = $this->get_participle($this->future_intensive_desiderative_participle_middle);			// 中動

		// 過去分詞
		$conjugation[Commons::PAST_TENSE][Commons::ACTIVE_VOICE]["na-participle"] = $this->get_participle($this->past_intensive_desiderative_na_participle_active);				// na-能動
		$conjugation[Commons::PAST_TENSE][Commons::ACTIVE_VOICE]["ta-participle"] = $this->get_participle($this->past_intensive_desiderative_ta_participle_active);				// ta-能動
		$conjugation[Commons::PAST_TENSE][Commons::PASSIVE_VOICE]["na-participle"] = $this->get_participle($this->past_intensive_desiderative_na_participle_passive);			// na-受動
		$conjugation[Commons::PAST_TENSE][Commons::PASSIVE_VOICE]["ta-participle"] = $this->get_participle($this->past_intensive_desiderative_ta_participle_passive);			// ta-受動

		// 動形容詞
		$conjugation["adjective"]["tavya"] = $this->get_participle($this->intensive_desiderative_verbal_adjectives[0]);
		$conjugation["adjective"]["ya"] = $this->get_participle($this->intensive_desiderative_verbal_adjectives[1]);
		$conjugation["adjective"]["aniya"] = $this->get_participle($this->intensive_desiderative_verbal_adjectives[2]);

		// 不定詞
		foreach($this->intensive_desiderative_infinitives as $intensive_desiderative_infinitive){
			$conjugation["infinitive"][] = $this->get_infinitive($intensive_desiderative_infinitive);
		}

		// 結果を返す。
		return $conjugation;
	}

	// 願望+使役動詞の活用を作成する。
	protected function get_desiderative_causative_verb_conjugation($classic_flag){

		// 配列を作成
		$aspect_array = array(Commons::PRESENT_ASPECT, Commons::START_VERB, Commons::RESULTATIBE, Commons::AORIST_ASPECT, Commons::PERFECT_ASPECT, Commons::FUTURE_TENSE);			// 相
		$voice_array = array(Commons::ACTIVE_VOICE, Commons::MEDIOPASSIVE_VOICE, Commons::PASSIVE_VOICE);								// 態
		$tense_mood_array = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE, Commons::IMJUNCTIVE, Commons::SUBJUNCTIVE, "bend", Commons::OPTATIVE, Commons::IMPERATIVE);	//時制と法
		$person_array = array("1sg", "2sg", "3sg", "1du", "2du", "3du", "1pl", "2pl", "3pl");												// 人称

		// 初期化
		$conjugation = array();

		// 全ての法
		foreach ($aspect_array as $aspect){	
			// 全ての態			
			foreach ($voice_array as $voice){
				// 全ての法			
				foreach ($tense_mood_array as $tense_mood){
					// 全ての人称			
					foreach ($person_array as $person){
						// 古典フラグ
						if($classic_flag == Commons::$TRUE){
							// 古典期に失われた活用は出力しない。
							if(!$this->judge_classical_conjugation($tense_mood, $aspect)){
								$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
								continue;
							}
						}
						// 態と人称で場合分けする。
						if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::PASSIVE_VOICE){
							// 完了形の受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else if($aspect == Commons::AORIST_ASPECT && $tense_mood == Commons::PRESENT_TENSE){
							// アオリストの現在時制は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
						} else if($aspect != Commons::AORIST_ASPECT && $tense_mood == "bend"){
							// アオリスト以外は祈願法は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";							
						} else if($aspect == Commons::AORIST_ASPECT && $voice == Commons::PASSIVE_VOICE){
							// アオリストの受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else if($aspect == Commons::FUTURE_TENSE && $voice == Commons::PASSIVE_VOICE){
							// 未来形の受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else {
							// 態・時制・法・人称に応じて多次元配列を作成		
							$conjugation[$aspect][$voice][$tense_mood][$person] = $this->get_causative_desiderative_sanskrit_verb($person, $voice, $tense_mood, $aspect, Commons::change_flag($classic_flag));	
						}
					}
				}
			}
		}

		// 分詞を入れる。
		// 現在分詞
		$conjugation[Commons::PRESENT_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->present_desiderative_causative_participle_active);			// 能動
		$conjugation[Commons::PRESENT_ASPECT][Commons::MIDDLE_VOICE]["participle"] = $this->get_participle($this->present_desiderative_causative_participle_middle);			// 中動
		$conjugation[Commons::PRESENT_ASPECT][Commons::PASSIVE_VOICE]["participle"] = $this->get_participle($this->present_desiderative_causative_participle_passive);			// 受動

		// 完了体分詞(古典フラグがOFFの場合)
		if(Commons::change_flag($classic_flag) == Commons::$TRUE){	
			$conjugation[Commons::AORIST_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->aorist_desiderative_causative_participle_active);				// 能動
			$conjugation[Commons::AORIST_ASPECT][Commons::MIDDLE_VOICE]["participle"] = $this->get_participle($this->aorist_desiderative_causative_participle_middle);				// 中動
			$conjugation[Commons::AORIST_ASPECT][Commons::PASSIVE_VOICE]["participle"] = $this->get_participle($this->aorist_desiderative_causative_participle_passive);			// 受動
		}
		// 完了形分詞
		$conjugation[Commons::PERFECT_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->perfect_desiderative_causative_participle_active);			// 能動
		$conjugation[Commons::PERFECT_ASPECT][Commons::MEDIOPASSIVE_VOICE]["participle"] = $this->get_participle($this->perfect_desiderative_causative_participle_middle);		// 中受動

		// 未来分詞
		$conjugation[Commons::FUTURE_TENSE][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->future_desiderative_causative_participle_active);				// 能動
		$conjugation[Commons::FUTURE_TENSE][Commons::MIDDLE_VOICE]["participle"] = $this->get_participle($this->future_desiderative_causative_participle_middle);				// 中動
		$conjugation[Commons::FUTURE_TENSE][Commons::PASSIVE_VOICE]["participle"] = $this->get_participle($this->future_desiderative_causative_participle_passive);				// 受動

		// 過去分詞
		$conjugation[Commons::PAST_TENSE][Commons::ACTIVE_VOICE]["na-participle"] = $this->get_participle($this->past_desiderative_causative_na_participle_active);				// na-能動
		$conjugation[Commons::PAST_TENSE][Commons::ACTIVE_VOICE]["ta-participle"] = $this->get_participle($this->past_desiderative_causative_ta_participle_active);				// ta-能動
		$conjugation[Commons::PAST_TENSE][Commons::PASSIVE_VOICE]["na-participle"] = $this->get_participle($this->past_desiderative_causative_na_participle_passive);			// na-受動
		$conjugation[Commons::PAST_TENSE][Commons::PASSIVE_VOICE]["ta-participle"] = $this->get_participle($this->past_desiderative_causative_ta_participle_passive);			// ta-受動

		// 動形容詞
		$conjugation["adjective"]["tavya"] = $this->get_participle($this->desiderative_causative_verbal_adjectives[0]);
		$conjugation["adjective"]["ya"] = $this->get_participle($this->desiderative_causative_verbal_adjectives[1]);
		$conjugation["adjective"]["aniya"] = $this->get_participle($this->desiderative_causative_verbal_adjectives[2]);

		// 不定詞
		foreach($this->desiderative_causative_infinitives as $desiderative_causative_infinitive){
			$conjugation["infinitive"][] = $this->get_infinitive($desiderative_causative_infinitive);
		}

		// 結果を返す。
		return $conjugation;
	}

	// 強意+使役動詞の活用を作成する。
	protected function get_intensive_causative_verb_conjugation($classic_flag){

		// 配列を作成
		$aspect_array = array(Commons::PRESENT_ASPECT, Commons::START_VERB, Commons::RESULTATIBE, Commons::AORIST_ASPECT, Commons::PERFECT_ASPECT, Commons::FUTURE_TENSE);			// 相
		$voice_array = array(Commons::ACTIVE_VOICE, Commons::MEDIOPASSIVE_VOICE, Commons::PASSIVE_VOICE);								// 態
		$tense_mood_array = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE, Commons::IMJUNCTIVE, Commons::SUBJUNCTIVE, "bend", Commons::OPTATIVE, Commons::IMPERATIVE);	//時制と法
		$person_array = array("1sg", "2sg", "3sg", "1du", "2du", "3du", "1pl", "2pl", "3pl");												// 人称

		// 初期化
		$conjugation = array();

		// 全ての法
		foreach ($aspect_array as $aspect){	
			// 全ての態			
			foreach ($voice_array as $voice){
				// 全ての法			
				foreach ($tense_mood_array as $tense_mood){
					// 全ての人称			
					foreach ($person_array as $person){
						// 古典フラグ
						if($classic_flag == Commons::$TRUE){
							// 古典期に失われた活用は出力しない。
							if(!$this->judge_classical_conjugation($tense_mood, $aspect)){
								$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
								continue;
							}
						}
						// 態と人称で場合分けする。
						if($aspect == Commons::PERFECT_ASPECT && $voice == Commons::PASSIVE_VOICE){
							// 完了形の受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else if($aspect == Commons::AORIST_ASPECT && $tense_mood == Commons::PRESENT_TENSE){
							// アオリストの現在時制は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
						} else if($aspect != Commons::AORIST_ASPECT && $tense_mood == "bend"){
							// アオリスト以外は祈願法は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";							
						} else if($aspect == Commons::AORIST_ASPECT && $voice == Commons::PASSIVE_VOICE){
							// アオリストの受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else if($aspect == Commons::FUTURE_TENSE && $voice == Commons::PASSIVE_VOICE){
							// 未来形の受動態と中動態は同じ
							$conjugation[$aspect][$voice][$tense_mood][$person] = $conjugation[$aspect][Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person];
						} else {
							// 態・時制・法・人称に応じて多次元配列を作成		
							$conjugation[$aspect][$voice][$tense_mood][$person] = $this->get_causative_desiderative_sanskrit_verb($person, $voice, $tense_mood, $aspect, Commons::change_flag($classic_flag));	
						}
					}
				}
			}
		}

		// 分詞を入れる。
		// 現在分詞
		$conjugation[Commons::PRESENT_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->present_intensive_causative_participle_active);			// 能動
		$conjugation[Commons::PRESENT_ASPECT][Commons::MIDDLE_VOICE]["participle"] = $this->get_participle($this->present_intensive_causative_participle_middle);			// 中動
		$conjugation[Commons::PRESENT_ASPECT][Commons::PASSIVE_VOICE]["participle"] = $this->get_participle($this->present_intensive_causative_participle_passive);			// 受動

		// 完了体分詞(古典フラグがOFFの場合)
		if(Commons::change_flag($classic_flag) == Commons::$TRUE){	
			$conjugation[Commons::AORIST_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->aorist_intensive_causative_participle_active);				// 能動
			$conjugation[Commons::AORIST_ASPECT][Commons::MIDDLE_VOICE]["participle"] = $this->get_participle($this->aorist_intensive_causative_participle_middle);				// 中動
			$conjugation[Commons::AORIST_ASPECT][Commons::PASSIVE_VOICE]["participle"] = $this->get_participle($this->aorist_intensive_causative_participle_passive);			// 受動
		}

		// 完了形分詞
		$conjugation[Commons::PERFECT_ASPECT][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->perfect_intensive_causative_participle_active);			// 能動
		$conjugation[Commons::PERFECT_ASPECT][Commons::MEDIOPASSIVE_VOICE]["participle"] = $this->get_participle($this->perfect_intensive_causative_participle_middle);		// 中受動

		// 未来分詞
		$conjugation[Commons::FUTURE_TENSE][Commons::ACTIVE_VOICE]["participle"] = $this->get_participle($this->future_intensive_causative_participle_active);				// 能動
		$conjugation[Commons::FUTURE_TENSE][Commons::MIDDLE_VOICE]["participle"] = $this->get_participle($this->future_intensive_causative_participle_middle);				// 中動
		$conjugation[Commons::FUTURE_TENSE][Commons::PASSIVE_VOICE]["participle"] = $this->get_participle($this->future_intensive_causative_participle_passive);			// 受動

		// 過去分詞
		$conjugation[Commons::PAST_TENSE][Commons::ACTIVE_VOICE]["na-participle"] = $this->get_participle($this->past_intensive_causative_na_participle_active);			// na-能動
		$conjugation[Commons::PAST_TENSE][Commons::ACTIVE_VOICE]["ta-participle"] = $this->get_participle($this->past_intensive_causative_ta_participle_active);			// ta-能動
		$conjugation[Commons::PAST_TENSE][Commons::PASSIVE_VOICE]["na-participle"] = $this->get_participle($this->past_intensive_causative_na_participle_passive);			// na-受動
		$conjugation[Commons::PAST_TENSE][Commons::PASSIVE_VOICE]["ta-participle"] = $this->get_participle($this->past_intensive_causative_ta_participle_passive);			// ta-受動

		// 動形容詞
		$conjugation["adjective"]["tavya"] = $this->get_participle($this->intensive_causative_verbal_adjectives[0]);
		$conjugation["adjective"]["ya"] = $this->get_participle($this->intensive_causative_verbal_adjectives[1]);
		$conjugation["adjective"]["aniya"] = $this->get_participle($this->intensive_causative_verbal_adjectives[2]);

		// 不定詞
		foreach($this->intensive_causative_infinitives as $intensive_causative_infinitive){
			$conjugation["infinitive"][] = $this->get_infinitive($intensive_causative_infinitive);
		}

		// 結果を返す。
		return $conjugation;
	}

	// 古典期活用のチェック
	protected function judge_classical_conjugation($tense_mood, $aspect){
		// 接続法は使わない
		if($tense_mood == Commons::SUBJUNCTIVE){
			return false;
		}
		// 完了形は現在形以外存在しない。
		if($aspect == Commons::PERFECT_ASPECT && $tense_mood != Commons::PRESENT_TENSE){
			return false;
		} else if($aspect == Commons::AORIST_ASPECT && !($tense_mood == Commons::PAST_TENSE || $tense_mood == Commons::IMJUNCTIVE || $tense_mood == "bend")){
			// アオリストは過去形、指令法、祈願法以外存在しない。
			return false;							
		} else if($aspect == Commons::FUTURE_TENSE && !($tense_mood == Commons::PRESENT_TENSE || $tense_mood == Commons::PAST_TENSE)){
			// 未来形は現在形・条件法以外存在しない。
			return false;							
		} else if($aspect == Commons::PRESENT_ASPECT && $tense_mood == Commons::IMJUNCTIVE){
			// 現在形指令法は存在しない。
			return false;							
		}

		// 問題なければTrueを返す。
		return true;
	}

	// 語根を取得
	public function get_root(){
		return $this->add_stem.$this->root."-".$this->conjugation_present_type."-".$this->deponent_active."-".$this->deponent_mediopassive
		."-".$this->deponent_present."-".$this->deponent_aorist."-".$this->deponent_perfect."-".$this->deponent_future;
	}

	// 活用表を取得する。
	public function get_chart($classic_flag){

		// 初期化
		$conjugation = array();
		// タイトル情報を挿入
		$conjugation["title"] = $this->get_title($this->add_stem.$this->root);
		// 辞書見出しを入れる。
		$conjugation["dic_title"] = $this->get_root();
		// 種別を入れる。
		$conjugation["category"] = "動詞";
		// 活用種別
		$conjugation["type"] = $this->conjugation_present_type;	

		//echo date("H:i:s") . "." . substr(explode(".", (microtime(true) . ""))[1], 0, 3)."<br>";
		// 一次動詞
		$conjugation["primary"] = $this->get_primary_verb_conjugation($classic_flag);
		//echo date("H:i:s") . "." . substr(explode(".", (microtime(true) . ""))[1], 0, 3)."<br>";
		// 使役動詞
		$conjugation[Commons::MAKE_VERB] = $this->get_causative_verb_conjugation($classic_flag);
		//echo date("H:i:s") . "." . substr(explode(".", (microtime(true) . ""))[1], 0, 3)."<br>";
		// 願望動詞
		$conjugation[Commons::WANT_VERB] = $this->get_desiderative_verb_conjugation($classic_flag);
		//echo date("H:i:s") . "." . substr(explode(".", (microtime(true) . ""))[1], 0, 3)."<br>";
		// 強意動詞
		$conjugation[Commons::INTENSE_VERB] = $this->get_intensive_verb_conjugation($classic_flag);
		//echo date("H:i:s") . "." . substr(explode(".", (microtime(true) . ""))[1], 0, 3)."<br>";
		// 使役+願望動詞
		$conjugation[Commons::MAKE_VERB."-".Commons::WANT_VERB] = $this->get_causative_desiderative_verb_conjugation($classic_flag);
		//echo date("H:i:s") . "." . substr(explode(".", (microtime(true) . ""))[1], 0, 3)."<br>";
		// 強意+願望動詞
		$conjugation[Commons::INTENSE_VERB."-".Commons::WANT_VERB] = $this->get_intensive_desiderative_verb_conjugation($classic_flag);
		//echo date("H:i:s") . "." . substr(explode(".", (microtime(true) . ""))[1], 0, 3)."<br>";
		// 願望+使役動詞
		$conjugation[Commons::WANT_VERB."-".Commons::MAKE_VERB] = $this->get_desiderative_causative_verb_conjugation($classic_flag);
		//echo date("H:i:s") . "." . substr(explode(".", (microtime(true) . ""))[1], 0, 3)."<br>";
		// 強意+使役動詞
		$conjugation[Commons::INTENSE_VERB."-".Commons::MAKE_VERB] = $this->get_intensive_causative_verb_conjugation($classic_flag);
		//echo date("H:i:s") . "." . substr(explode(".", (microtime(true) . ""))[1], 0, 3)."<br>";

		// 結果を返す。
		return $conjugation;
	}

	// 特定の活用を取得する(ない場合はランダム)。
	public function get_conjugation_form_by_each_condition($person = "", $voice = "", $mood = "", $aspect = "", $verb_genre = ""){

		// 相がない場合
		if($aspect == ""){
			// 初期化
			$ary = array(Commons::PRESENT_ASPECT, Commons::AORIST_ASPECT, Commons::PERFECT_ASPECT, Commons::FUTURE_TENSE);				
			// 欠如動詞対応
			// 進行相なし
			if($this->deponent_present == Commons::$TRUE){
				//削除実行
				$ary = array_diff($ary, array(Commons::PRESENT_ASPECT));
				//indexを詰める
				$ary = array_values($ary);			
			} 

			// 完結相なし
			if($this->deponent_aorist == Commons::$TRUE){
				//削除実行
				$ary = array_diff($ary, array(Commons::AORIST_ASPECT));
				//indexを詰める
				$ary = array_values($ary);		
			}
			
			// 完了相なし
			if($this->deponent_perfect == Commons::$TRUE){
				//削除実行
				$ary = array_diff($ary, array(Commons::PERFECT_ASPECT));
				//indexを詰める
				$ary = array_values($ary);		
			}

			// 未来相なし
			if($this->deponent_future == Commons::$TRUE){
				//削除実行
				$ary = array_diff($ary, array(Commons::FUTURE_TENSE));
				//indexを詰める
				$ary = array_values($ary);		
			}
			// 全ての相の中からランダムで選択
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$aspect = $ary[$key];			
		}

		// 法がない場合
		if($mood == ""){
			// 完結相とそれ以外で分ける。
			if($mood == Commons::AORIST_ASPECT){
				// 完結相
				$ary = array(Commons::PAST_TENSE, Commons::IMJUNCTIVE, Commons::SUBJUNCTIVE, Commons::OPTATIVE, "bend", Commons::IMPERATIVE);
			} else {
				// それ以外		
				$ary = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE, Commons::IMJUNCTIVE, Commons::SUBJUNCTIVE, Commons::OPTATIVE, Commons::IMPERATIVE);	// 初期化
			}
			// 全ての法の中からランダムで選択		
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$mood = $ary[$key];			
		}	

		// 態がない場合
		if($voice == ""){
			// 能動態・中動態・受動態の中からランダムで選択
			// 完了とそれ以外で分ける。
			if($mood == Commons::AORIST_ASPECT){
				// 完了形
				$ary = array(Commons::ACTIVE_VOICE, Commons::MEDIOPASSIVE_VOICE);
			} else {
				// それ以外		
				$ary = array(Commons::ACTIVE_VOICE, Commons::MEDIOPASSIVE_VOICE, Commons::PASSIVE_VOICE);	// 初期化
			}

			// 欠如動詞対応
			if($this->deponent_active == Commons::$TRUE){
				// 能動態なし
				// 削除実行
				$ary = array_diff($ary, array(Commons::ACTIVE_VOICE));
				//indexを詰める
				$ary = array_values($ary);	
			} else if($this->deponent_mediopassive == Commons::$TRUE){
				// 中動態なし
				// 削除実行
				$ary = array_diff($ary, array(Commons::MEDIOPASSIVE_VOICE, Commons::PASSIVE_VOICE));
				//indexを詰める
				$ary = array_values($ary);
			}
			// 全ての態からランダムで選択
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$voice = $ary[$key];			
		}

		// 人称と数がない場合は
		if($person == ""){
			// 全ての人称の中からランダムで選択
			$ary = array("1sg", "2sg", "3sg", "1du", "2du", "3du", "1pl", "2pl", "3pl");	// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$person = $ary[$key];			
		}

		// 配列に格納
		$question_data = array();
		$question_data['question_sentence'] = $this->get_title($this->add_stem."√".$this->root)."(第".$this->conjugation_present_type."類動詞) の".$aspect." ".$mood." ".$voice." ".$person."を答えよ";
		// 動詞の形態によって分ける。
		if($verb_genre == Commons::MAKE_VERB){
			// 使役動詞
			$question_data['answer'] = $this->get_causative_sanskrit_verb($person, $voice, $mood, $aspect, true);										// 解答
			$question_data['question_sentence2'] = $question_data['answer']."の相、法、態と人称を答えよ。 "."√".$this->root."活用種別：使役動詞";	// 説明文
		} else if($verb_genre == Commons::WANT_VERB){
			// 願望動詞
			$question_data['answer'] = $this->get_desiderative_sanskrit_verb($person, $voice, $mood, $aspect, true);									// 解答
			$question_data['question_sentence2'] = $question_data['answer']."の相、法、態と人称を答えよ。 "."√".$this->root."活用種別：願望動詞";	// 説明文
		} else if($verb_genre == Commons::INTENSE_VERB){
			// 強意動詞
			$question_data['answer'] = $this->get_intensive_sanskrit_verb($person, $voice, $mood, $aspect, true);										// 解答
			$question_data['question_sentence2'] = $question_data['answer']."の相、法、態と人称を答えよ。 "."√".$this->root."活用種別：強意動詞";	// 説明文
		} else {
			// 通常の動詞
			$question_data['answer'] = $this->get_sanskrit_verb($person, $voice, $mood, $aspect, true);																		// 解答
			$question_data['question_sentence2'] = $question_data['answer']."の相、法、態と人称を答えよ。 "."√".$this->root."活用種別：".$this->conjugation_present_type;	// 説明文
		}
		$question_data['aspect'] = $aspect;
		$question_data['mood'] = $mood;
		$question_data['voice'] = $voice;
		$question_data['person'] = $person;			

		// 結果を返す。
		return $question_data;
	}	

	// 動詞語根から派生名詞を作る。
	public function make_derivative_noun_from_root($suffixes){
		// 派生語を格納するリストを初期化
		$words = array();
		// 語根の準備
		$weak_stem = $this->add_stem.Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::ZERO_GRADE);	// 弱語根
		$middle_stem = $this->add_stem.Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::GUNA);		// 中語根
		$strong_stem = $this->add_stem.Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI);		// 強語根
		// 重複語根
		$add_stem = mb_ereg_replace("([bpkgcjtd])h", "\\1", $this->root);
		$add_stem = mb_ereg_replace("k", "c", $add_stem);
		$add_stem = mb_ereg_replace("[hg]", "j", $add_stem);
		$add_stem = mb_substr($add_stem, 0, 2);	
		$redumplication_stem = $this->add_stem.$add_stem.$this->root;

		// 全ての接尾辞を対象とする。
		foreach ($suffixes as $suffix) {
			// 初期化
			$verb_stem = "";
			// 必要な語根の種別によって分ける
			if($suffix["stem_type"] == "root"){
				$verb_stem = $this->add_stem.$this->root;
			} else if($suffix["stem_type"] == Sanskrit_Common::ZERO_GRADE){
				$verb_stem = $weak_stem;
			} else if($suffix["stem_type"] == Sanskrit_Common::GUNA){
				$verb_stem = $middle_stem;
			} else if($suffix["stem_type"] == Sanskrit_Common::VRIDDHI){
				$verb_stem = $strong_stem;
			} else if($suffix["stem_type"] == "redumplication"){
				$verb_stem = $redumplication_stem;
			} else if($suffix["stem_type"] == Commons::MAKE_VERB){
				$verb_stem = $this->add_stem.$this->present_causative_stem;
			} else if($suffix["stem_type"] == Commons::WANT_VERB){
				$verb_stem = $this->add_stem.$this->present_desiderative_stem;
			} else if($suffix["stem_type"] == Commons::INTENSE_VERB){
				$verb_stem = $this->add_stem.$this->present_intensive_stem;
			} else if($suffix["stem_type"] == Commons::PRESENT_ASPECT){
				$verb_stem = $this->add_stem.$this->present_stem;
			} else if($suffix["stem_type"] == Commons::AORIST_ASPECT){
				$verb_stem = $this->add_stem.$this->aorist_stem;
			} else if($suffix["stem_type"] == Commons::PERFECT_ASPECT){
				$verb_stem = $this->add_stem.$this->perfect_stem;
			} else if($suffix["stem_type"] == Commons::FUTURE_TENSE){
				$verb_stem = $this->add_stem.$this->future_stem;
 			} else {
				$verb_stem = "";
			}
			// 名詞を生成
			$noun = new Vedic_Noun($verb_stem, $suffix["suffix"], $this->japanese_translation, $suffix["mean"], $suffix["genre"]);
			// 結果を取得
			$words[$noun->get_second_stem()] = $noun->get_chart();
			// メモリを解放
			unset($noun);
		}

		// 一次動詞不定詞
		$root_infinitive = new Vedic_Noun($this->root);
		// 結果を取得
		$words[$this->root] = $root_infinitive->get_chart();
		// メモリを解放
		unset($root_infinitive);

		// 結果を返す。
		return $words;
	}

	// 動詞語根から派生形容詞を作る。
	public function make_derivative_adjective_from_root($suffixes){
		// 派生語を格納するリストを初期化
		$words = array();
		// 語根の準備
		$weak_stem = $this->add_stem.Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::ZERO_GRADE);	// 弱語根
		$middle_stem = $this->add_stem.Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::GUNA);		// 中語根
		$strong_stem = $this->add_stem.Sanskrit_Common::change_vowel_grade($this->root, Sanskrit_Common::VRIDDHI);		// 強語根
		// 重複語根
		$add_stem = mb_ereg_replace("([bpkgcjtd])h", "\\1", $this->root);
		$add_stem = mb_ereg_replace("k", "c", $add_stem);
		$add_stem = mb_ereg_replace("[hg]", "j", $add_stem);
		$add_stem = mb_substr($add_stem, 0, 2);	
		$redumplication_stem = $this->add_stem.$add_stem.$this->root;

		// 全ての接尾辞を対象とする。
		foreach ($suffixes as $suffix) {
			// 必要な語根の種別によって分ける
			if($suffix["stem_type"] == "root"){
				$verb_stem = $this->add_stem.$this->root;
			} else if($suffix["stem_type"] == Sanskrit_Common::ZERO_GRADE){
				$verb_stem = $weak_stem;
			} else if($suffix["stem_type"] == Sanskrit_Common::GUNA){
				$verb_stem = $middle_stem;
			} else if($suffix["stem_type"] == Sanskrit_Common::VRIDDHI){
				$verb_stem = $strong_stem;
			} else if($suffix["stem_type"] == "redumplication"){
				$verb_stem = $redumplication_stem;
			} else if($suffix["stem_type"] == Commons::MAKE_VERB){
				$verb_stem = $this->add_stem.$this->present_causative_stem;
			} else if($suffix["stem_type"] == Commons::WANT_VERB){
				$verb_stem = $this->add_stem.$this->present_desiderative_stem;
			} else if($suffix["stem_type"] == Commons::INTENSE_VERB){
				$verb_stem = $this->add_stem.$this->present_intensive_stem;
			} else if($suffix["stem_type"] == Commons::PRESENT_ASPECT){
				$verb_stem = $this->add_stem.$this->present_stem;
			} else if($suffix["stem_type"] == Commons::AORIST_ASPECT){
				$verb_stem = $this->add_stem.$this->aorist_stem;
			} else if($suffix["stem_type"] == Commons::PERFECT_ASPECT){
				$verb_stem = $this->add_stem.$this->perfect_stem;
			} else if($suffix["stem_type"] == Commons::FUTURE_TENSE){
				$verb_stem = $this->add_stem.$this->future_stem;
 			} else {
				$verb_stem = "";
			}
			// 形容詞を生成
			$adjective = new Vedic_Adjective($verb_stem, $suffix["suffix"], $this->japanese_translation, $suffix["mean"]);
			// 結果を取得
			$words[$adjective->get_second_stem()] = $adjective->get_chart();
			// メモリを解放
			unset($adjective);
		}

		// 現在分詞
		$words[$this->present_participle_active] = $this->get_participle($this->present_participle_active);			// 能動
		$words[$this->present_participle_middle] = $this->get_participle($this->present_participle_middle);			// 中動
		$words[$this->present_participle_passive] = $this->get_participle($this->present_participle_passive);		// 受動

		// 完了体分詞
		$words[$this->aorist_participle_active] = $this->get_participle($this->aorist_participle_active);			// 能動
		$words[$this->aorist_participle_middle] = $this->get_participle($this->aorist_participle_middle);			// 中動
		$words[$this->aorist_participle_passive] = $this->get_participle($this->aorist_participle_passive);			// 受動

		// 完了形分詞
		$words[$this->perfect_participle_active] = $this->get_participle($this->perfect_participle_active);			// 能動
		$words[$this->perfect_participle_middle] = $this->get_participle($this->perfect_participle_middle);			// 中受動

		// 未来分詞
		$words[$this->future_participle_active] = $this->get_participle($this->future_participle_active);			// 能動
		$words[$this->future_participle_middle] = $this->get_participle($this->future_participle_middle);			// 中動
		$words[$this->future_participle_passive] = $this->get_participle($this->future_participle_passive);			// 受動

		// 過去分詞
		$words[$this->past_na_participle_active] = $this->get_participle($this->past_na_participle_active);			// na-能動
		$words[$this->past_ta_participle_active] = $this->get_participle($this->past_ta_participle_active);			// ta-能動
		$words[$this->past_na_participle_passive] = $this->get_participle($this->past_na_participle_passive);		// na-受動
		$words[$this->past_ta_participle_passive] = $this->get_participle($this->past_ta_participle_passive);		// ta-受動

		// 使役動詞現在分詞
		$words[$this->present_causative_participle_active] = $this->get_participle($this->present_causative_participle_active);		// 能動
		$words[$this->present_causative_participle_middle] = $this->get_participle($this->present_causative_participle_middle);		// 中動
		$words[$this->present_causative_participle_passive] = $this->get_participle($this->present_causative_participle_passive);		// 受動

		// 使役動詞完了体分詞
		$words[$this->aorist_causative_participle_active] = $this->get_participle($this->aorist_causative_participle_active);		// 能動
		$words[$this->aorist_causative_participle_middle] = $this->get_participle($this->aorist_causative_participle_middle);		// 中動
		$words[$this->aorist_causative_participle_passive] = $this->get_participle($this->aorist_causative_participle_passive);		// 受動

		// 使役動詞完了形分詞
		$words[$this->perfect_causative_participle_active] = $this->get_participle($this->perfect_causative_participle_active);		// 能動
		$words[$this->perfect_causative_participle_middle] = $this->get_participle($this->perfect_causative_participle_middle);		// 中受動

		// 使役動詞未来分詞
		$words[$this->future_causative_participle_active] = $this->get_participle($this->future_causative_participle_active);		// 能動
		$words[$this->future_causative_participle_middle] = $this->get_participle($this->future_causative_participle_middle);		// 中動
		$words[$this->future_causative_participle_passive] = $this->get_participle($this->future_causative_participle_passive);		// 受動

		// 使役動詞過去分詞
		$words[$this->past_causative_na_participle_active] = $this->get_participle($this->past_causative_na_participle_active);		// na-能動
		$words[$this->past_causative_ta_participle_active] = $this->get_participle($this->past_causative_ta_participle_active);		// ta-能動
		$words[$this->past_causative_na_participle_passive] = $this->get_participle($this->past_causative_na_participle_passive);		// na-受動
		$words[$this->past_causative_ta_participle_passive] = $this->get_participle($this->past_causative_ta_participle_passive);		// ta-受動

		// 願望動詞現在分詞
		$words[$this->present_desiderative_participle_active] = $this->get_participle($this->present_desiderative_participle_active);		// 能動
		$words[$this->present_desiderative_participle_middle] = $this->get_participle($this->present_desiderative_participle_middle);		// 中動
		$words[$this->present_desiderative_participle_passive] = $this->get_participle($this->present_desiderative_participle_passive);		// 受動

		// 願望動詞完了体分詞
		$words[$this->aorist_desiderative_participle_active] = $this->get_participle($this->aorist_desiderative_participle_active);		// 能動
		$words[$this->aorist_desiderative_participle_middle] = $this->get_participle($this->aorist_desiderative_participle_middle);		// 中動

		// 願望動詞未来分詞
		$words[$this->future_desiderative_participle_active] = $this->get_participle($this->future_desiderative_participle_active);		// 能動
		$words[$this->future_desiderative_participle_middle] = $this->get_participle($this->future_desiderative_participle_middle);		// 中動

		// 願望動詞過去分詞
		$words[$this->past_desiderative_na_participle_active] = $this->get_participle($this->past_desiderative_na_participle_active);		// na-能動
		$words[$this->past_desiderative_ta_participle_active] = $this->get_participle($this->past_desiderative_ta_participle_active);		// ta-能動
		$words[$this->past_desiderative_na_participle_passive] = $this->get_participle($this->past_desiderative_na_participle_passive);		// na-受動
		$words[$this->past_desiderative_ta_participle_passive] = $this->get_participle($this->past_desiderative_ta_participle_passive);		// ta-受動

		// 強意動詞現在分詞
		$words[$this->present_intensive_participle_active] = $this->get_participle($this->present_intensive_participle_active);		// 能動
		$words[$this->present_intensive_participle_middle] = $this->get_participle($this->present_intensive_participle_middle);		// 中動
		$words[$this->present_intensive_participle_passive] = $this->get_participle($this->present_intensive_participle_passive);		// 受動

		// 強意動詞完了体分詞
		$words[$this->aorist_intensive_participle_active] = $this->get_participle($this->aorist_intensive_participle_active);		// 能動
		$words[$this->aorist_intensive_participle_middle] = $this->get_participle($this->aorist_intensive_participle_middle);		// 中動

		// 強意動詞未来分詞
		$words[$this->future_intensive_participle_active] = $this->get_participle($this->future_intensive_participle_active);		// 能動
		$words[$this->future_intensive_participle_middle] = $this->get_participle($this->future_intensive_participle_middle);		// 中動

		// 強意動詞過去分詞
		$words[$this->past_intensive_na_participle_active] = $this->get_participle($this->past_intensive_na_participle_active);		// na-能動
		$words[$this->past_intensive_ta_participle_active] = $this->get_participle($this->past_intensive_ta_participle_active);		// ta-能動
		$words[$this->past_intensive_na_participle_passive] = $this->get_participle($this->past_intensive_na_participle_passive);		// na-受動
		$words[$this->past_intensive_ta_participle_passive] = $this->get_participle($this->past_intensive_ta_participle_passive);		// ta-受動

		// 動形容詞
		foreach($this->verbal_adjectives as $verbal_adjective){
			$words[$verbal_adjective] = $this->get_infinitive($verbal_adjective);
		}

		// 使役動形容詞
		foreach($this->causative_verbal_adjectives as $causative_verbal_adjective){
			$words[$causative_verbal_adjective] = $this->get_infinitive($causative_verbal_adjective);
		}

		// 願望動形容詞
		foreach($this->desiderative_verbal_adjectives as $desiderative_verbal_adjective){
			$words[$desiderative_verbal_adjective] = $this->get_infinitive($desiderative_verbal_adjective);
		}

		// 強意動形容詞
		foreach($this->intensive_verbal_adjectives as $intensive_verbal_adjective){
			$words[$intensive_verbal_adjective] = $this->get_infinitive($intensive_verbal_adjective);
		}
		
		// 結果を返す。
		return $words;
	}

    // 欠如動詞チェック
    protected function deponent_check($voice, $aspect){
		// 能動態がない動詞で能動態が選択されている場合は		
		if($voice == Commons::ACTIVE_VOICE && $this->deponent_active == Commons::$TRUE){
			return false;
		} 

		// 中受動態がない動詞で中受動態が選択されている場合は		
		if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive == Commons::$TRUE){
			return false;
		} 

		// 進行相がない動詞で進行相が選択されている場合は		
		if($aspect == Commons::PRESENT_ASPECT && $this->deponent_present == Commons::$TRUE){
			return false;
		}

		// 完結相がない動詞で完結相が選択されている場合は		
		if($aspect == Commons::AORIST_ASPECT && $this->deponent_aorist == Commons::$TRUE){
			return false;
		} 

		// 完了相がない動詞で完了相が選択されている場合は		
		if($aspect == Commons::PERFECT_ASPECT && $this->deponent_perfect == Commons::$TRUE){
			return false;
		} 

		// 未来相がない動詞で完了相が選択されている場合は		
		if($aspect == Commons::FUTURE_TENSE && $this->deponent_future == Commons::$TRUE){
			return false;
		} 

		// それ以外の場合はtrue
		return true;
	}

}

// ポーランド語クラス
class Polish_Verb extends Verb_Common_IE {
	
	// 一次人称接尾辞(現在、未来)
	protected $primary_number = 
	[		
		"active" => 
		[
			"1sg" => "m",
			"2sg" => "sz", 
			"3sg" => "",
			"1du" => "wa",
			"2du" => "ta", 
			"3du" => "ta",
			"1pl" => "my",
			"2pl" => "cie", 
			"3pl" => "ją",	
		],
	];

	// 一次人称接尾辞(現在、未来)
	protected $primary_number2 = 
	[		
		"active" => 
		[
			"1sg" => "ę",
			"2sg" => "sz", 
			"3sg" => "",
			"1du" => "wa",
			"2du" => "ta", 
			"3du" => "ta",
			"1pl" => "my",
			"2pl" => "cie", 
			"3pl" => "ą",	
		],
	];
	
	// 二次人称接尾辞(過去、仮定)
	protected $secondary_number = 
	[
		"active" => 
		[
			"1sg" => "m",
			"2sg" => "ś", 
			"3sg" => "",
			"1du" => "śma",
			"2du" => "śta", 
			"3du" => "śta",				
			"1pl" => "śmy",
			"2pl" => "ście", 
			"3pl" => "",	
		],
	];

	// 命令人称接尾辞
	protected $imperative_number = 
	[
		"active" => 
		[
			"1sg" => "",
			"2sg" => "", 
			"3sg" => "",
			"1du" => "we",
			"2du" => "ta", 
			"3du" => "",			
			"1pl" => "my",
			"2pl" => "cie", 
			"3pl" => "",	
		],
	];

	// 過去接尾辞
	protected $aorist_number = 
	[
		"active" => 
		[
			"1sg" => "ch",
			"2sg" => "", 
			"3sg" => "",
			"1du" => "chowa",
			"2du" => "sta", 
			"3du" => "sta",
			"1pl" => "chom",
			"2pl" => "ście", 
			"3pl" => "chą",	
		],
	];

	// 未完了過去接尾辞
	protected $imperfect_number = 
	[
		"active" => 
		[
			"1sg" => "ch",
			"2sg" => "sz", 
			"3sg" => "sz",
			"1du" => "chowa",
			"2du" => "sta", 
			"3du" => "sta",			
			"1pl" => "chom",
			"2pl" => "szecie", 
			"3pl" => "chą",	
		],
	];
	
	// 直接法
	protected $ind = "";
	// 希求法→命令法
	protected $opt = "";
	// 接続法
	protected $subj = "by";
	
	// 強変化語幹
	protected $present_stem2 = "";
	// 過去語幹
	protected $past_stem = "";
	// 不定形
	protected $infinitive = "";
	// 副分詞
	protected $supine = "";
	// 動名詞
	protected $verbal_noun = "";

	// 非人称動詞フラグ
	protected $deponent_personal = "";

    /*=====================================
    コンストラクタ
    ======================================*/
 	function __construct_polish1($dic_stem) {
		// 親の呼び出し
    	parent::__construct($dic_stem);
    	// 動詞情報を取得
		$word_info = $this->get_verb_from_DB($dic_stem, Polish_Common::DB_VERB);
		// データの取得確認	
		if($word_info){
			// データを挿入
			$this->infinitive = $word_info["infinitive_stem"];						// 不定形			
			$this->present_stem = $word_info["present_stem"];						// 現在形
			$this->present_stem2 = $word_info["present_stem2"];						// 現在形2
			$this->past_stem = mb_substr($this->infinitive, 0, -1)."ł";				// 過去分詞
			$this->aorist_stem = mb_substr($this->infinitive, 0, -1);				// 過去形			
			$this->japanese_translation = $word_info["japanese_translation"];		// 日本語訳
			$this->english_translation = $word_info["english_translation"];			// 英語訳
			$this->verb_type = $word_info["verb_type"];								// 活用種別
			$this->root_type = $word_info["verb_aspect"];							// 動詞の種別
			$this->deponent_active = $word_info["deponent_active"];					// sie動詞判定
			$this->verbal_noun = mb_substr($this->infinitive, 0, -1)."nie";			// 動名詞
		} else if(preg_match('/(ować|owac)$/',$dic_stem)){	
			// 不明動詞の対応
			$this->generate_uknown_verb5(mb_substr($dic_stem, 0, -4));			
		} else if(preg_match('/(ać|ac)$/',$dic_stem)){	
			// 不明動詞の対応
			$this->generate_uknown_verb(mb_substr($dic_stem, 0, -2));
		} else if(preg_match('/(eć|ec)$/',$dic_stem)){	
			// 不明動詞の対応
			$this->generate_uknown_verb2(mb_substr($dic_stem, 0, -2));
		} else if(preg_match('/ąć$/',$dic_stem)){	
			// 不明動詞の対応
			$this->generate_uknown_verb3(mb_substr($dic_stem, 0, -2));			
		} else if(preg_match('/(ić|ic)$/',$dic_stem)){	
			// 不明動詞の対応
			$this->generate_uknown_verb4(mb_substr($dic_stem, 0, -2));										
		} else {
			// 不明動詞の対応
			$this->generate_uknown_verb($dic_stem);
		}

		// 動詞の種別を決定
		$this->decide_verb_class();
		// 動詞の語幹を作成
		$this->get_verb_stem($this->infinitive);
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

	// 不定詞を取得
	public function get_infinitive(){
		return $this->infinitive;
	}

	// 動詞種別の判定
	private function decide_verb_class(){
    	// 活用種別から動詞種別判定
		switch ($this->verb_type) {
		    case "1":
		        $this->ind = "a";				// 直接法
		        $this->opt = "aj";				// 命令法←希求法
				$this->class_name = "第一変化";	 // 活用名
		        break;
		    case "2":
		        $this->ind = "e";				// 直接法
		        $this->opt = "ej";				// 命令法←希求法
				$this->class_name = "第二変化";	 // 活用名				
		        break;
		    case "3":
				$this->ind = "i";				// 直接法
				$this->opt = "ij";				// 命令法←希求法
				$this->class_name = "第三変化";	 // 活用名				
		        break;
		    case "3root":
				$this->ind = "";					// 直接法
				$this->opt = "";					// 命令法←希求法
				$this->class_name = "第三変化語根";	 // 活用名				
		        break;
		    case "3root2":
				$this->ind = "";					// 直接法
				$this->opt = "";					// 命令法←希求法
				$this->class_name = "第三変化語根";	 // 活用名				
		        break;
		    case "3root3":
				$this->ind = "";					// 直接法
				$this->opt = "";					// 命令法←希求法
				$this->class_name = "第三変化語根";	 // 活用名				
		        break;				
		    case "4":
				$this->ind = "i";					// 直接法
		        $this->opt = "ij";					// 接続法←希求法
				$this->class_name = "第四変化型";	 // 活用名				
		        break;
		    case "5byc":
				$this->ind = "";					// 直接法
				$this->opt = "";					// 接続法←希求法
				$this->class_name = "不規則動詞";	 // 活用名				
		        break;
		    case "5isc":
				$this->ind = "";					// 直接法
				$this->opt = "";					// 接続法←希求法
				$this->class_name = "不規則動詞";	 // 活用名				
		        break;
		    case "5miec":
				$this->ind = "";					// 直接法
				$this->opt = "";					// 接続法←希求法
				$this->class_name = "不規則動詞";	 // 活用名				
		        break;
		    case "5brac":
				$this->ind = "";					// 直接法
				$this->opt = "";					// 接続法←希求法
				$this->class_name = "不規則動詞";	 // 活用名				
		        break;
		    case "denomitive":
				$this->ind = "";					// 直接法
				$this->opt = "";					// 接続法←希求法
				$this->class_name = "名詞起源動詞";	 // 活用名				
		        break;
		    case "denomitive2":
				$this->ind = "";					// 直接法
				$this->opt = "";					// 接続法←希求法
				$this->class_name = "名詞起源動詞";	 // 活用名				
		        break;														
			default:
				break;
		}
	}

	// 不明動詞の対応
	private function generate_uknown_verb($dic_stem){
		// 共通語幹を取得
		$common_stem = $dic_stem."a";
		// 訳を入れる。
		$this->japanese_translation = "借用";
		$this->english_translation = "loanword";	
		// データを挿入(借用語)
		$this->verb_type= "1";											// 活用種別					
		$this->present_stem = mb_substr($common_stem, 0, -1);			// 現在形
		$this->present_stem2 = mb_substr($common_stem, 0, -1);			// 現在形2		
		$this->aorist_stem = $common_stem;								// 完了形		
		$this->infinitive = $dic_stem ."ać";							// 不定形
		$this->past_stem = $common_stem."ł";							// 過去分詞
		$this->verbal_noun = $common_stem."nie";						// 動名詞
	}

	// 不明動詞の対応2
	private function generate_uknown_verb2($dic_stem){
		// 共通語幹を取得
		$common_stem = $dic_stem."e";
		// 訳を入れる。
		$this->japanese_translation = "借用";
		$this->english_translation = "loanword";	
		// データを挿入(借用語)
		$this->verb_type= "2";											// 活用種別					
		$this->present_stem = mb_substr($common_stem, 0, -1);			// 現在形
		$this->present_stem2 = mb_substr($common_stem, 0, -1);			// 現在形2		
		$this->aorist_stem = $common_stem;								// 完了形		
		$this->infinitive = $dic_stem ."eć";							// 不定形
		$this->past_stem = $common_stem."ł";							// 過去分詞
		$this->verbal_noun = $common_stem."nie";						// 動名詞
	}

	// 不明動詞の対応3
	private function generate_uknown_verb3($dic_stem){
		// 共通語幹を取得
		$common_stem = $dic_stem."i";
		// 訳を入れる。
		$this->japanese_translation = "借用";
		$this->english_translation = "loanword";	
		// データを挿入(借用語)
		$this->verb_type= "3";											// 活用種別					
		$this->present_stem = mb_substr($common_stem, 0, -1);			// 現在形
		$this->present_stem2 = $common_stem;							// 現在形2
		$this->infinitive = $dic_stem ."ąć";							// 不定形				
		$this->aorist_stem = mb_substr($this->infinitive, 0, -1);		// 完了形		
		$this->past_stem = $common_stem."ł";							// 過去分詞
		$this->verbal_noun = $common_stem."nie";						// 動名詞	
	}

	// 不明動詞の対応4
	private function generate_uknown_verb4($dic_stem){
		// 共通語幹を取得
		$common_stem = $dic_stem."i";
		// 訳を入れる。
		$this->japanese_translation = "借用";
		$this->english_translation = "loanword";	
		// データを挿入(借用語)
		$this->verb_type= "4";											// 活用種別					
		$this->present_stem = mb_substr($common_stem, 0, -1);			// 現在形
		$this->present_stem2 = mb_substr($common_stem, 0, -1);			// 現在形2		
		$this->aorist_stem = $common_stem;								// 完了形		
		$this->infinitive = $dic_stem ."ić";							// 不定形
		$this->past_stem = $common_stem."ł";							// 過去分詞	
		$this->verbal_noun = $common_stem."nie";						// 動名詞	
	}

	// 不明動詞の対応5
	private function generate_uknown_verb5($dic_stem){
		// 共通語幹を取得
		$common_stem = $dic_stem."uj";
		// 訳を入れる。
		$this->japanese_translation = "借用";
		$this->english_translation = "loanword";	
		// データを挿入(借用語)
		$this->verb_type= "denomitive";									// 活用種別					
		$this->present_stem = $common_stem."e";							// 現在形
		$this->present_stem2 = $common_stem;							// 現在形2		
		$this->aorist_stem = $dic_stem."owa";							// 完了形		
		$this->infinitive = $dic_stem ."ować";							// 不定形
		$this->past_stem = $dic_stem."ował";							// 過去分詞				
		$this->verbal_noun = $dic_stem."owanie";						// 動名詞
	}

	// 動詞の語幹を作成
	private function get_verb_stem($infinitive){	
		// 分詞語尾を取得
		$common_stem = mb_substr($infinitive, 0, -2);
		// 分詞を挿入
		$this->present_participle_active = $common_stem."jący";		// 不完了体能動分詞
		$this->present_participle_passive = $common_stem."ny";		// 状態動詞受動分詞
		$this->supine = $this->present_stem2."jąc";					// 目的分詞
		
		// 不定詞を挿入
		$this->infinitive = $infinitive;							// 不定形
	}
	
	// 動詞作成
	public function get_polish_verb($person, $tense_mood, $gender){

		// 非人称チェック
		if($this->deponent_personal == "1" && $person != "3sg"){
			// ハイフンを返す。
			return "-";			
		}

		// 初期化
		$verb_conjugation = "";
		
		//時制と法で取得
		if($tense_mood == Commons::PRESENT_TENSE) {
			// 現在形
			$verb_conjugation = $this->get_primary_suffix_polish($person);
		} else if($tense_mood == Commons::PAST_TENSE && $this->root_type != Commons::AORIST_ASPECT){
			// 未完了過去
			$verb_conjugation = $this->aorist_stem.$this->imperfect_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::AORIST_ASPECT){
			// 過去形
			$verb_conjugation = $this->aorist_stem.$this->aorist_number[Commons::ACTIVE_VOICE][$person];					
		} else if($tense_mood == Commons::FUTURE_TENSE && $this->root_type != Commons::AORIST_ASPECT){
			// 未来形
			// 補助動詞を呼び出す
			$auxiliary_byc = new Polish_Verb_Byc();
			// 結合
			$verb_conjugation = $auxiliary_byc->get_polish_verb($person, Commons::FUTURE_TENSE, $gender)." ".$this->infinitive;			
		} else if($tense_mood == Commons::PERFECT_ASPECT){
			// 過去形(完了)	
			$past_stem = $this->get_past_conditional_stem($gender, $person);
			// 男性形単数のみ特例処理
			if($gender == Commons::ANIMATE_GENDER && preg_match("/(1sg|2sg)$/", $person)){
				$past_stem = $past_stem."e";
			}
			$verb_conjugation = $past_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person];						
		} else if($tense_mood == Commons::PAST_TENSE."_".Commons::PERFECT_ASPECT){
			// 過去完了形
			$past_stem = $this->get_past_conditional_stem($gender, $person);
			// 男性形単数のみ特例処理
			if($gender == Commons::ANIMATE_GENDER && preg_match("/(1sg|2sg)$/", $person)){
				$past_stem = $past_stem."e";
			}						
			$verb_conjugation = $past_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);
		} else if($tense_mood == Commons::FUTURE_TENSE."_".Commons::PERFECT_ASPECT && $this->root_type != Commons::AORIST_ASPECT){
			// 未来完了形
			// 補助動詞を呼び出す
			$auxiliary_byc = new Polish_Verb_Byc();
			// 結合
			$verb_conjugation = $auxiliary_byc->get_polish_verb($person, Commons::FUTURE_TENSE, $gender)." ".$this->get_past_conditional_stem($gender, $person);
		} else if($tense_mood == Commons::SUBJUNCTIVE){
			// 仮定法
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::SUBJUNCTIVE."_".Commons::PERFECT_ASPECT){
			// 仮定法過去形
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);								
		} else if($tense_mood == Commons::IMPERATIVE){
			// 命令法
			$verb_conjugation = $this->present_stem2.$this->opt.$this->imperative_number[Commons::ACTIVE_VOICE][$person];	
		} else {
			// ハイフンを返す。
			return "-";
		} 

		// 最後の音節のoは短音になる。但し単音節の単語は除く
		$verb_conjugation = preg_replace("/[aiueo]{1}.o([^aiueoąęó])$/u", "ó\\1", $verb_conjugation);

		// 結果を返す。
		return $verb_conjugation;
	}
	
	// 一次語尾
	protected function get_primary_suffix_polish($person){

		// 一人称単数、三人称複数
		if(preg_match('(1sg|3pl)', $person)){
			// 語幹を作成
			if($this->verb_type == "2"){
				// 第二活用の場合
				$verb_stem  = $this->present_stem2;	
			} else {
				// それ以外
				$verb_stem  = $this->present_stem2.$this->ind;
			}
		} else {
			// 語幹を作成
			$verb_stem  = $this->present_stem.$this->ind;
		}

		// 初期化
		$verb_conjugation = "";
		// 第一変化動詞の場合は
		if($this->verb_type == "1"){
			// 親クラスを呼び出す
			$verb_conjugation = $this->get_primary_suffix($verb_stem, Commons::ACTIVE_VOICE, $person);
		} else {
			// それ以外は固有のメンバを呼び出す
			$verb_conjugation = $verb_stem.$this->primary_number2[Commons::ACTIVE_VOICE][$person];;			
		}

		$verb_conjugation = preg_replace("/o([bcfhlmnprswzćłńśźż])$/u", "ó\\1", $verb_conjugation);

		// 結果を返す。
		return $verb_conjugation;
	}

	// 過去・仮定法語幹を作る
	protected function get_past_conditional_stem($gender, $person){
		if($gender == Commons::ANIMATE_GENDER && preg_match("/sg$/", $person)){
			return $this->past_stem;
		} else if($gender == Commons::ACTION_GENDER && preg_match("/sg$/", $person)){
			// ąc動詞は語幹を変更して返す。
			if($this->verb_type == "3an"){
				return $this->present_stem."ęła";
			}
			return $this->past_stem."a";
		} else if($gender == Commons::INANIMATE_GENDER && preg_match("/sg$/", $person)){
			// ąc動詞は語幹を変更して返す。
			if($this->verb_type == "3an"){
				return $this->present_stem."ęło";
			}			
			return $this->past_stem."o";
		} else if($gender == Commons::ANIMATE_GENDER && preg_match("/(du|pl)$/", $person)){
			// ąc動詞は語幹を変更して返す。
			if($this->verb_type == "3an"){
				return $this->present_stem."ęły";
			}			
			return $this->past_stem."y";		
		} else if($gender == Commons::ACTION_GENDER && preg_match("/(du|pl)$/", $person)){
			// ąc動詞は語幹を変更して返す。
			if($this->verb_type == "3an"){
				return $this->present_stem."ęłi";
			}
			return $this->past_stem."i";
		} else if($gender == Commons::INANIMATE_GENDER && preg_match("/(du|pl)$/", $person)){
			// ąc動詞は語幹を変更して返す。
			if($this->verb_type == "3an"){
				return $this->present_stem."ęłi";
			}			
			return $this->past_stem."i";			
		} else {
			// ハイフンを返す。
			return "-";			
		}
	}

	// 過去完了・仮定法接辞を作る
	protected function get_pluperfect_stem($gender, $person){
		// 性別・数に分けて返す
		if($gender == Commons::ANIMATE_GENDER && preg_match("/sg$/", $person)){
			return "był";
		} else if($gender == Commons::ACTION_GENDER && preg_match("/sg$/", $person)){
			return $this->subj."ła";
		} else if($gender == Commons::INANIMATE_GENDER && preg_match("/sg$/", $person)){
			return $this->subj."ło";
		} else if($gender == Commons::ANIMATE_GENDER && preg_match("/(du|pl)$/", $person)){	
			return $this->subj."ły";		
		} else if($gender == Commons::ACTION_GENDER && preg_match("/(du|pl)$/", $person)){
			return $this->subj."łi";
		} else if($gender == Commons::INANIMATE_GENDER && preg_match("/(du|pl)$/", $person)){		
			return $this->subj."łi";			
		} else {
			// ハイフンを返す。
			return "-";			
		}
	}	
	
	// 分詞の曲用表を返す。	
	protected function get_participle($participle_stem){
		// 読み込み
		$adj_polish = new Polish_Adjective($participle_stem);
		// 結果を返す。
		return $adj_polish->get_chart();
	}

	// 動名詞の曲用表を返す。	
	protected function get_verbal_noun($participle_stem){
		// 読み込み
		$noun_polish = new Polish_Noun($participle_stem);
		// 結果を返す。
		return $noun_polish->get_chart();
	}	

	// 通常変化部分の動詞の活用を作成する。
	protected function make_common_standard_verb_conjugation($conjugation){
		// 配列を作成
		$gender_array = array(Commons::ANIMATE_GENDER, Commons::ACTION_GENDER, Commons::INANIMATE_GENDER);	//性別
		$tense_mood_array = array(Commons::PRESENT_TENSE, 
								  Commons::PAST_TENSE, 
								  Commons::AORIST_ASPECT, 
								  Commons::FUTURE_TENSE, 
								  Commons::PERFECT_ASPECT, 
								  Commons::PAST_TENSE."_".Commons::PERFECT_ASPECT,
								  Commons::FUTURE_TENSE."_".Commons::PERFECT_ASPECT,
								  Commons::SUBJUNCTIVE, 
								  Commons::SUBJUNCTIVE."_".Commons::PERFECT_ASPECT,
								  Commons::IMPERATIVE);										//時制・法
		$person_array = array("1sg", "2sg", "3sg", "1du", "2du", "3du", "1pl", "2pl", "3pl");	//人称

		// 活用表を挿入(現在相)
		// 全ての時制と法			
		foreach ($tense_mood_array as $tense_mood){
			// 全ての人称			
			foreach ($person_array as $person){
				// 全ての性別
				foreach ($gender_array as $gender){					
					// 態・時制・法・人称・性別に応じて多次元配列を作成		
					$conjugation[Commons::ACTIVE_VOICE][$tense_mood][$person][$gender] = $this->get_polish_verb($person, $tense_mood, $gender);
					// 取得できたか判定する。
					if($conjugation[Commons::ACTIVE_VOICE][$tense_mood][$person][$gender] == "-"){
						// 取得できない場合は、どちらも空にする。
						$conjugation[Commons::ACTIVE_VOICE][$tense_mood][$person][$gender] = "";
						$conjugation[Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person][$gender] = "";
					} else {
						$conjugation[Commons::MEDIOPASSIVE_VOICE][$tense_mood][$person][$gender] = $conjugation[Commons::ACTIVE_VOICE][$tense_mood][$person][$gender]." się";
					}
				}
			}
		}
		// 結果を返す。
		return $conjugation;
	}

	// 活用表を取得する。
	public function get_chart(){

		// 初期化
		$conjugation = array();
		// タイトル情報を挿入
		$conjugation["title"] = $this->get_title($this->infinitive);
		// 辞書見出しを入れる。
		$conjugation["dic_title"] = $this->infinitive;
		// 種別を入れる。
		$conjugation["category"] = "動詞";
		// 活用種別
		$conjugation["type"] = $this->class_name;
		// 共通変化部分の動詞の活用を取得
		$conjugation = $this->make_common_standard_verb_conjugation($conjugation);

		// 分詞を挿入
		$conjugation["present_active"] = $this->get_participle($this->present_participle_active);	// 能動分詞
		$conjugation["present_passive"] = $this->get_participle($this->present_participle_passive);	// 受動分詞
		$conjugation["supine"] = $this->get_participle($this->supine);								// 副分詞
		$conjugation["verbal_noun"] = $this->get_verbal_noun($this->verbal_noun);					// 動名詞		
		
		// 不定詞を挿入
		$conjugation["infinitive"]["present_active"] = $this->infinitive;						// 不定形	

		// 結果を返す。
		return $conjugation;
	}

	// 特定の活用を取得する(ない場合はランダム)。
	public function get_conjugation_form_by_each_condition($person = "", $tense_mood = "", $gender = ""){

		// 法がない場合
		if($tense_mood == ""){
			// 全ての性別の中からランダムで選択
			$ary = array(Commons::PRESENT_TENSE, 
						 Commons::FUTURE_TENSE, 
						 Commons::PERFECT_ASPECT, 
						 Commons::FUTURE_TENSE."_".Commons::PERFECT_ASPECT,
						 Commons::SUBJUNCTIVE, 
						 Commons::IMPERATIVE);																				
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$tense_mood = $ary[$key];			
		}


		// 性別がない場合
		if($gender == ""){
			// 全ての性別の中からランダムで選択
			$ary = array(Commons::ANIMATE_GENDER, Commons::ACTION_GENDER, Commons::INANIMATE_GENDER);			// 初期化
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$gender = $ary[$key];			
		}

		// 人称と数がない場合は
		if($person == ""){	
			// 命令形とそれ以外で分ける。
			if($tense_mood == Commons::IMPERATIVE){
				$ary = array("2sg", "1pl", "2pl"); // 初期化
			} else {
				$ary = array("1sg", "2sg", "3sg", "1pl", "2pl", "3pl"); // 初期化
			}
			// 全ての人称の中からランダムで選択
			$key = array_rand($ary, 1);
			// 選択したものを入れる。
			$person = $ary[$key];			
		} 


		// 配列に格納
		$question_data = array();
		$question_data['question_sentence'] = $this->get_title($this->infinitive)."の".$tense_mood." ".$gender." ".$person."を答えよ";				
		$question_data['answer'] = $this->get_polish_verb($person, $tense_mood, $gender);
		$question_data['question_sentence2'] = $question_data['answer']."の時制、法、態と人称を答えよ。";
		$question_data['mood'] = $tense_mood;
		$question_data['person'] = $person;			

		// 結果を返す。
		return $question_data;
	}

}

class Polish_Verb_Byc extends Polish_Verb {

	// 現在形人称
	protected $present_number = 
	[		
		"active" => 
		[
			"1sg" => "jestem",
			"2sg" => "jesteś", 
			"3sg" => "jest",
			"1du" => "jesteśma",
			"2du" => "jesteśta", 
			"3du" => "jesteśta",			
			"1pl" => "jesteśmy",
			"2pl" => "jesteście", 
			"3pl" => "są",	
		],
	];

	// 未来形人称
	protected $future_number = 
	[		
		"active" => 
		[
			"1sg" => "będę",
			"2sg" => "będziesz", 
			"3sg" => "będzie",
			"1du" => "będziema",
			"2du" => "będzieta", 
			"3du" => "będzieta",			
			"1pl" => "będziemy",
			"2pl" => "będziecie", 
			"3pl" => "będą",	
		],
	];

	// 活用種別
	protected $class = "5byc";
	
	// 不定形
	protected $infinitive = "być";

	// 命令形語幹
	private $imperative_stem = "bądź";
	
	// 追加語幹
	protected $added_stem = "";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
		// 親の呼び出し
    	parent::__construct($this->infinitive);
    }

	// esseの派生動詞に対応
	public function add_stem($verb){	
		// 派生部分を取得
		$this->added_stem = mb_substr($verb, 0, -3);
		// 変更がなければ、ここで処理を中断する。
		if($this->added_stem == ""){
			return;
		}

		// 追加語幹に対応
		$this->present_participle_active = $this->added_stem.$this->supine;		// 現在能動分詞			
		$this->supine = $this->added_stem.$this->supine;						// 副分詞		
		$this->verbal_noun = $this->added_stem.$this->verbal_noun;				// 動名詞
	}

	
	// 動詞作成
	public function get_polish_verb($person, $tense_mood, $gender){

		// 初期化
		$verb_conjugation = "";
		
		//時制と法で取得
		if($tense_mood == Commons::PRESENT_TENSE) {
			// 現在形
			$verb_conjugation = $this->present_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::PAST_TENSE){
			// 未完了過去
			$verb_conjugation = $this->aorist_stem.$this->imperfect_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::AORIST_ASPECT){
			// 過去形
			$verb_conjugation = $this->aorist_stem.$this->aorist_number[Commons::ACTIVE_VOICE][$person];					
		} else if($tense_mood == Commons::FUTURE_TENSE){
			// 未来形
			$verb_conjugation = $this->future_number[Commons::ACTIVE_VOICE][$person];					
		} else if($tense_mood == Commons::PERFECT_ASPECT){
			// 過去形(完了)	
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->aorist_number[Commons::ACTIVE_VOICE][$person];						
		} else if($tense_mood == Commons::PAST_TENSE."_".Commons::PERFECT_ASPECT){			
			// 過去完了形
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);			
		} else if($tense_mood == Commons::FUTURE_TENSE."_".Commons::PERFECT_ASPECT){
			// 未来完了形
			$verb_conjugation = $this->future_number[Commons::ACTIVE_VOICE][$person];							
		} else if($tense_mood == Commons::SUBJUNCTIVE){
			// 仮定法
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->aorist_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::SUBJUNCTIVE."_".Commons::PERFECT_ASPECT){
			// 仮定法過去形
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);									
		} else if($tense_mood == Commons::IMPERATIVE){
			// 命令法
			$verb_conjugation = $this->imperative_stem.$this->imperative_number[Commons::ACTIVE_VOICE][$person];	
		} else {
			// ハイフンを返す。
			return "-";
		}  

		// 結果を返す。
		return $verb_conjugation;
	}

}

class Polish_Verb_Isc extends Polish_Verb {

	// 活用種別
	protected $class = "5isc";
	
	// 不定形
	protected $infinitive = "iść";

	// 命令形語幹
	private $imperative_stem = "idź";
	
	// 追加語幹
	protected $added_stem = "";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
		// 親の呼び出し
    	parent::__construct($this->infinitive);

		$this->past_stem = "szedł";				// 過去分詞
		$this->aorist_stem = "id";				// 過去形			
		$this->verbal_noun = "szejście";		// 動名詞
    }

	// 派生動詞に対応
	public function add_stem($verb){	
		// 派生部分を取得
		$this->added_stem = mb_substr($verb, 0, -3);
		// 変更がなければ、ここで処理を中断する。
		if($this->added_stem == ""){
			return;
		}

		// 追加語幹に対応
		$this->present_participle_active = $this->added_stem.$this->supine;		// 現在能動分詞			
		$this->supine = $this->added_stem.$this->supine;						// 副分詞		
		$this->verbal_noun = $this->added_stem.$this->verbal_noun;				// 動名詞
	}

	
	// 動詞作成
	public function get_polish_verb($person, $tense_mood, $gender){

		// 初期化
		$verb_conjugation = "";
		
		//時制と法で取得
		if($tense_mood == Commons::PRESENT_TENSE) {
			// 現在形
			$verb_conjugation = $this->get_primary_suffix_polish($person);
		} else if($tense_mood == Commons::PAST_TENSE && $this->root_type != Commons::AORIST_ASPECT){
			// 未完了過去
			$verb_conjugation = $this->aorist_stem.$this->imperfect_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::AORIST_ASPECT){
			// 過去形
			$verb_conjugation = $this->aorist_stem.$this->aorist_number[Commons::ACTIVE_VOICE][$person];	
		} else if($tense_mood == Commons::FUTURE_TENSE && $this->root_type != Commons::AORIST_ASPECT){
			// 未来形
			// 補助動詞を呼び出す
			$auxiliary_byc = new Polish_Verb_Byc();
			// 結合
			$verb_conjugation = $auxiliary_byc->get_polish_verb($person, Commons::FUTURE_TENSE, $gender)." ".$this->infinitive;			
		} else if($tense_mood == Commons::PERFECT_ASPECT){
			// 過去形(完了)	
			$past_stem = $this->get_past_conditional_stem($gender, $person);
			// 男性形単数のみ特例処理
			if($gender == Commons::ANIMATE_GENDER && preg_match("/(1sg|2sg)$/", $person)){
				$past_stem = $past_stem."e";
			}
			$verb_conjugation = $past_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person];						
		} else if($tense_mood == Commons::PAST_TENSE."_".Commons::PERFECT_ASPECT){
			// 過去完了形
			$past_stem = $this->get_past_conditional_stem($gender, $person);
			// 男性形単数のみ特例処理
			if($gender == Commons::ANIMATE_GENDER && preg_match("/(1sg|2sg)$/", $person)){
				$past_stem = $past_stem."e";
			}						
			$verb_conjugation = $past_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);
		} else if($tense_mood == Commons::FUTURE_TENSE."_".Commons::PERFECT_ASPECT && $this->root_type != Commons::AORIST_ASPECT){
			// 未来完了形
			// 補助動詞を呼び出す
			$auxiliary_byc = new Polish_Verb_Byc();
			// 結合
			$verb_conjugation = $auxiliary_byc->get_polish_verb($person, Commons::FUTURE_TENSE, $gender)." ".$this->get_past_conditional_stem($gender, $person);
		} else if($tense_mood == Commons::SUBJUNCTIVE){
			// 仮定法
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::SUBJUNCTIVE."_".Commons::PERFECT_ASPECT){
			// 仮定法過去形
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);								
		} else if($tense_mood == Commons::IMPERATIVE){
			// 命令法
			$verb_conjugation = $this->imperative_stem.$this->imperative_number[Commons::ACTIVE_VOICE][$person];	
		} else {
			// ハイフンを返す。
			return "-";
		}  

		// 結果を返す。
		return $verb_conjugation;
	}

}

class Polish_Verb_Brac extends Polish_Verb {

	// 活用種別
	protected $class = "5brac";
	
	// 不定形
	protected $infinitive = "brać";

	// 命令形語幹
	private $imperative_stem = "bierz";
	
	// 追加語幹
	protected $added_stem = "";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
		// 親の呼び出し
    	parent::__construct($this->infinitive);

		$this->aorist_stem = "id";				// 過去形			
		$this->verbal_noun = "szejście";		// 動名詞
    }

	// 派生動詞に対応
	public function add_stem($verb){	
		// 派生部分を取得
		$this->added_stem = mb_substr($verb, 0, -4);
		// 変更がなければ、ここで処理を中断する。
		if($this->added_stem == ""){
			return;
		}

		// 追加語幹に対応
		$this->present_participle_active = $this->added_stem.$this->supine;		// 現在能動分詞			
		$this->supine = $this->added_stem.$this->supine;						// 副分詞		
		$this->verbal_noun = $this->added_stem.$this->verbal_noun;				// 動名詞
	}

	
	// 動詞作成
	public function get_polish_verb($person, $tense_mood, $gender){

		// 初期化
		$verb_conjugation = "";
		
		//時制と法で取得
		if($tense_mood == Commons::PRESENT_TENSE) {
			// 現在形
			$verb_conjugation = $this->get_primary_suffix_polish($person);
		} else if($tense_mood == Commons::PAST_TENSE && $this->root_type != Commons::AORIST_ASPECT){
			// 未完了過去
			$verb_conjugation = $this->aorist_stem.$this->imperfect_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::AORIST_ASPECT){
			// 過去形
			$verb_conjugation = $this->aorist_stem.$this->aorist_number[Commons::ACTIVE_VOICE][$person];	
		} else if($tense_mood == Commons::FUTURE_TENSE && $this->root_type != Commons::AORIST_ASPECT){
			// 未来形
			// 補助動詞を呼び出す
			$auxiliary_byc = new Polish_Verb_Byc();
			// 結合
			$verb_conjugation = $auxiliary_byc->get_polish_verb($person, Commons::FUTURE_TENSE, $gender)." ".$this->infinitive;			
		} else if($tense_mood == Commons::PERFECT_ASPECT){
			// 過去形(完了)	
			$past_stem = $this->get_past_conditional_stem($gender, $person);
			// 男性形単数のみ特例処理
			if($gender == Commons::ANIMATE_GENDER && preg_match("/(1sg|2sg)$/", $person)){
				$past_stem = $past_stem."e";
			}
			$verb_conjugation = $past_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person];						
		} else if($tense_mood == Commons::PAST_TENSE."_".Commons::PERFECT_ASPECT){
			// 過去完了形
			$past_stem = $this->get_past_conditional_stem($gender, $person);
			// 男性形単数のみ特例処理
			if($gender == Commons::ANIMATE_GENDER && preg_match("/(1sg|2sg)$/", $person)){
				$past_stem = $past_stem."e";
			}						
			$verb_conjugation = $past_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);
		} else if($tense_mood == Commons::FUTURE_TENSE."_".Commons::PERFECT_ASPECT && $this->root_type != Commons::AORIST_ASPECT){
			// 未来完了形
			// 補助動詞を呼び出す
			$auxiliary_byc = new Polish_Verb_Byc();
			// 結合
			$verb_conjugation = $auxiliary_byc->get_polish_verb($person, Commons::FUTURE_TENSE, $gender)." ".$this->get_past_conditional_stem($gender, $person);
		} else if($tense_mood == Commons::SUBJUNCTIVE){
			// 仮定法
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::SUBJUNCTIVE."_".Commons::PERFECT_ASPECT){
			// 仮定法過去形
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);								
		} else if($tense_mood == Commons::IMPERATIVE){
			// 命令法
			$verb_conjugation = $this->imperative_stem.$this->imperative_number[Commons::ACTIVE_VOICE][$person];	
		} else {
			// ハイフンを返す。
			return "-";
		}  

		// 結果を返す。
		return $verb_conjugation;
	}

}

class Polish_Verb_Wziac extends Polish_Verb {

	// 活用種別
	protected $class = "5wziac";
	
	// 不定形
	protected $infinitive = "wziąć";

	// 命令形語幹
	private $imperative_stem = "weź";
	
	// 追加語幹
	protected $added_stem = "";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
		// 親の呼び出し
    	parent::__construct($this->infinitive);
		
		$this->verbal_noun = "wzięcie";		// 動名詞
    }

	// 派生動詞に対応
	public function add_stem($verb){	
		// 派生部分を取得
		$this->added_stem = mb_substr($verb, 0, -5);
		// 変更がなければ、ここで処理を中断する。
		if($this->added_stem == ""){
			return;
		}

		// 追加語幹に対応
		$this->present_participle_active = $this->added_stem.$this->supine;		// 現在能動分詞			
		$this->supine = $this->added_stem.$this->supine;						// 副分詞		
		$this->verbal_noun = $this->added_stem.$this->verbal_noun;				// 動名詞
	}

	
	// 動詞作成
	public function get_polish_verb($person, $tense_mood, $gender){

		// 初期化
		$verb_conjugation = "";
		
		//時制と法で取得
		if($tense_mood == Commons::PRESENT_TENSE) {
			// 現在形
			$verb_conjugation = $this->get_primary_suffix_polish($person);
		} else if($tense_mood == Commons::PAST_TENSE && $this->root_type != Commons::AORIST_ASPECT){
			// 未完了過去
			$verb_conjugation = $this->aorist_stem.$this->imperfect_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::AORIST_ASPECT){
			// 過去形
			$verb_conjugation = $this->aorist_stem.$this->aorist_number[Commons::ACTIVE_VOICE][$person];	
		} else if($tense_mood == Commons::FUTURE_TENSE && $this->root_type != Commons::AORIST_ASPECT){
			// 未来形
			// 補助動詞を呼び出す
			$auxiliary_byc = new Polish_Verb_Byc();
			// 結合
			$verb_conjugation = $auxiliary_byc->get_polish_verb($person, Commons::FUTURE_TENSE, $gender)." ".$this->infinitive;			
		} else if($tense_mood == Commons::PERFECT_ASPECT){
			// 過去形(完了)	
			$past_stem = $this->get_past_conditional_stem($gender, $person);
			// 男性形単数のみ特例処理
			if($gender == Commons::ANIMATE_GENDER && preg_match("/(1sg|2sg)$/", $person)){
				$past_stem = $past_stem."e";
			}
			$verb_conjugation = $past_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person];						
		} else if($tense_mood == Commons::PAST_TENSE."_".Commons::PERFECT_ASPECT){
			// 過去完了形
			$past_stem = $this->get_past_conditional_stem($gender, $person);
			// 男性形単数のみ特例処理
			if($gender == Commons::ANIMATE_GENDER && preg_match("/(1sg|2sg)$/", $person)){
				$past_stem = $past_stem."e";
			}						
			$verb_conjugation = $past_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);
		} else if($tense_mood == Commons::FUTURE_TENSE."_".Commons::PERFECT_ASPECT && $this->root_type != Commons::AORIST_ASPECT){
			// 未来完了形
			// 補助動詞を呼び出す
			$auxiliary_byc = new Polish_Verb_Byc();
			// 結合
			$verb_conjugation = $auxiliary_byc->get_polish_verb($person, Commons::FUTURE_TENSE, $gender)." ".$this->get_past_conditional_stem($gender, $person);
		} else if($tense_mood == Commons::SUBJUNCTIVE){
			// 仮定法
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::SUBJUNCTIVE."_".Commons::PERFECT_ASPECT){
			// 仮定法過去形
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);								
		} else if($tense_mood == Commons::IMPERATIVE){
			// 命令法
			$verb_conjugation = $this->imperative_stem.$this->imperative_number[Commons::ACTIVE_VOICE][$person];	
		} else {
			// ハイフンを返す。
			return "-";
		}  

		// 結果を返す。
		return $verb_conjugation;
	}

}

class Polish_Verb_Miec extends Polish_Verb {

	// 活用種別
	protected $class = "5miec";
	
	// 不定形
	protected $infinitive = "mieć";

	// 命令形語幹
	private $imperative_stem = "";
	
	// 追加語幹
	protected $added_stem = "";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct() {
		// 親の呼び出し
    	parent::__construct($this->infinitive);
		
		$this->verbal_noun = "";		// 動名詞
		$this->imperative_stem = mb_substr($this->infinitive, 0, -1)."j";
    }

	// 派生動詞に対応
	public function add_stem($verb){	
		// 派生部分を取得
		$this->added_stem = mb_substr($verb, 0, -4);
		// 変更がなければ、ここで処理を中断する。
		if($this->added_stem == ""){
			return;
		}

		// 追加語幹に対応
		$this->present_participle_active = $this->added_stem.$this->supine;		// 現在能動分詞			
		$this->supine = $this->added_stem.$this->supine;						// 副分詞		
		$this->verbal_noun = $this->added_stem.$this->verbal_noun;				// 動名詞
	}

	
	// 動詞作成
	public function get_polish_verb($person, $tense_mood, $gender){

		// 初期化
		$verb_conjugation = "";
		
		//時制と法で取得
		if($tense_mood == Commons::PRESENT_TENSE) {
			// 現在形
			$verb_conjugation = $this->get_primary_suffix_polish($person);
		} else if($tense_mood == Commons::PAST_TENSE && $this->root_type != Commons::AORIST_ASPECT){
			// 未完了過去
			$verb_conjugation = $this->aorist_stem.$this->imperfect_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::AORIST_ASPECT){
			// 過去形
			$verb_conjugation = $this->aorist_stem.$this->aorist_number[Commons::ACTIVE_VOICE][$person];	
		} else if($tense_mood == Commons::FUTURE_TENSE && $this->root_type != Commons::AORIST_ASPECT){
			// 未来形
			// 補助動詞を呼び出す
			$auxiliary_byc = new Polish_Verb_Byc();
			// 結合
			$verb_conjugation = $auxiliary_byc->get_polish_verb($person, Commons::FUTURE_TENSE, $gender)." ".$this->infinitive;			
		} else if($tense_mood == Commons::PERFECT_ASPECT){
			// 過去形(完了)	
			$past_stem = $this->get_past_conditional_stem($gender, $person);
			// 男性形単数のみ特例処理
			if($gender == Commons::ANIMATE_GENDER && preg_match("/(1sg|2sg)$/", $person)){
				$past_stem = $past_stem."e";
			}
			$verb_conjugation = $past_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person];						
		} else if($tense_mood == Commons::PAST_TENSE."_".Commons::PERFECT_ASPECT){
			// 過去完了形
			$past_stem = $this->get_past_conditional_stem($gender, $person);
			// 男性形単数のみ特例処理
			if($gender == Commons::ANIMATE_GENDER && preg_match("/(1sg|2sg)$/", $person)){
				$past_stem = $past_stem."e";
			}						
			$verb_conjugation = $past_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);
		} else if($tense_mood == Commons::FUTURE_TENSE."_".Commons::PERFECT_ASPECT && $this->root_type != Commons::AORIST_ASPECT){
			// 未来完了形
			// 補助動詞を呼び出す
			$auxiliary_byc = new Polish_Verb_Byc();
			// 結合
			$verb_conjugation = $auxiliary_byc->get_polish_verb($person, Commons::FUTURE_TENSE, $gender)." ".$this->get_past_conditional_stem($gender, $person);
		} else if($tense_mood == Commons::SUBJUNCTIVE){
			// 仮定法
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::SUBJUNCTIVE."_".Commons::PERFECT_ASPECT){
			// 仮定法過去形
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);								
		} else if($tense_mood == Commons::IMPERATIVE){
			// 命令法
			$verb_conjugation = $this->imperative_stem.$this->imperative_number[Commons::ACTIVE_VOICE][$person];	
		} else {
			// ハイフンを返す。
			return "-";
		}  

		// 結果を返す。
		return $verb_conjugation;
	}

}

class Polish_Verb_Root extends Polish_Verb {

	// 活用種別
	protected $class = "3root";
	
	// 不定形
	protected $infinitive = "";

	// 命令形語幹
	private $imperative_stem = "";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct($infinitive) {
		// 親の呼び出し
    	parent::__construct($infinitive);

		$this->past_stem = $this->present_stem."ł";		// 過去分詞
		$this->aorist_stem = $this->present_stem2;			// 過去形
		$this->verbal_noun = $this->present_stem."nie";		// 動名詞
		$this->imperative_stem = $this->present_stem;		// 過去形
    }
	
	// 動詞作成
	public function get_polish_verb($person, $tense_mood, $gender){

		// 初期化
		$verb_conjugation = "";
		
		//時制と法で取得
		if($tense_mood == Commons::PRESENT_TENSE) {
			// 現在形
			$verb_conjugation = $this->get_primary_suffix_polish($person);
		} else if($tense_mood == Commons::PAST_TENSE && $this->root_type != Commons::AORIST_ASPECT){
			// 未完了過去
			$verb_conjugation = $this->aorist_stem.$this->imperfect_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::AORIST_ASPECT){
			// 過去形
			$verb_conjugation = $this->aorist_stem.$this->aorist_number[Commons::ACTIVE_VOICE][$person];	
		} else if($tense_mood == Commons::FUTURE_TENSE && $this->root_type != Commons::AORIST_ASPECT){
			// 未来形
			// 補助動詞を呼び出す
			$auxiliary_byc = new Polish_Verb_Byc();
			// 結合
			$verb_conjugation = $auxiliary_byc->get_polish_verb($person, Commons::FUTURE_TENSE, $gender)." ".$this->infinitive;			
		} else if($tense_mood == Commons::PERFECT_ASPECT){
			// 過去形(完了)	
			$past_stem = $this->get_past_conditional_stem($gender, $person);
			// 男性形単数のみ特例処理
			if($gender == Commons::ANIMATE_GENDER && preg_match("/(1sg|2sg)$/", $person)){
				$past_stem = $past_stem."e";
			}
			$verb_conjugation = $past_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person];						
		} else if($tense_mood == Commons::PAST_TENSE."_".Commons::PERFECT_ASPECT){
			// 過去完了形
			$past_stem = $this->get_past_conditional_stem($gender, $person);
			// 男性形単数のみ特例処理
			if($gender == Commons::ANIMATE_GENDER && preg_match("/(1sg|2sg)$/", $person)){
				$past_stem = $past_stem."e";
			}						
			$verb_conjugation = $past_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);
		} else if($tense_mood == Commons::FUTURE_TENSE."_".Commons::PERFECT_ASPECT && $this->root_type != Commons::AORIST_ASPECT){
			// 未来完了形
			// 補助動詞を呼び出す
			$auxiliary_byc = new Polish_Verb_Byc();
			// 結合
			$verb_conjugation = $auxiliary_byc->get_polish_verb($person, Commons::FUTURE_TENSE, $gender)." ".$this->get_past_conditional_stem($gender, $person);
		} else if($tense_mood == Commons::SUBJUNCTIVE){
			// 仮定法
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::SUBJUNCTIVE."_".Commons::PERFECT_ASPECT){
			// 仮定法過去形
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);								
		} else if($tense_mood == Commons::IMPERATIVE){
			// 命令法
			$verb_conjugation = $this->imperative_stem.$this->imperative_number[Commons::ACTIVE_VOICE][$person];	
		} else {
			// ハイフンを返す。
			return "-";
		}  

		// 結果を返す。
		return $verb_conjugation;
	}

}

class Polish_Verb_Root2 extends Polish_Verb {

	// 活用種別
	protected $class = "3root2";
	
	// 不定形
	protected $infinitive = "";

	// 命令形語幹
	private $imperative_stem = "";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct($infinitive) {
		// 親の呼び出し
    	parent::__construct($infinitive);

		$this->past_stem = $this->present_stem2."ł";		// 過去分詞
		$this->aorist_stem = $this->present_stem2;			// 過去形
		$this->verbal_noun = $this->present_stem;			// 動名詞
		$this->imperative_stem = $this->present_stem2;		// 過去形
    }
	
	// 動詞作成
	public function get_polish_verb($person, $tense_mood, $gender){

		// 初期化
		$verb_conjugation = "";
		
		//時制と法で取得
		if($tense_mood == Commons::PRESENT_TENSE) {
			// 現在形
			$verb_conjugation = $this->get_primary_suffix_polish($person);
		} else if($tense_mood == Commons::PAST_TENSE && $this->root_type != Commons::AORIST_ASPECT){
			// 未完了過去
			$verb_conjugation = $this->aorist_stem.$this->imperfect_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::AORIST_ASPECT){
			// 過去形
			$verb_conjugation = $this->aorist_stem.$this->aorist_number[Commons::ACTIVE_VOICE][$person];	
		} else if($tense_mood == Commons::FUTURE_TENSE && $this->root_type != Commons::AORIST_ASPECT){
			// 未来形
			// 補助動詞を呼び出す
			$auxiliary_byc = new Polish_Verb_Byc();
			// 結合
			$verb_conjugation = $auxiliary_byc->get_polish_verb($person, Commons::FUTURE_TENSE, $gender)." ".$this->infinitive;			
		} else if($tense_mood == Commons::PERFECT_ASPECT){
			// 過去形(完了)	
			$past_stem = $this->get_past_conditional_stem($gender, $person);
			// 男性形単数のみ特例処理
			if($gender == Commons::ANIMATE_GENDER && preg_match("/(1sg|2sg)$/", $person)){
				$past_stem = $past_stem."e";
			}
			$verb_conjugation = $past_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person];						
		} else if($tense_mood == Commons::PAST_TENSE."_".Commons::PERFECT_ASPECT){
			// 過去完了形
			$past_stem = $this->get_past_conditional_stem($gender, $person);
			// 男性形単数のみ特例処理
			if($gender == Commons::ANIMATE_GENDER && preg_match("/(1sg|2sg)$/", $person)){
				$past_stem = $past_stem."e";
			}						
			$verb_conjugation = $past_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);
		} else if($tense_mood == Commons::FUTURE_TENSE."_".Commons::PERFECT_ASPECT && $this->root_type != Commons::AORIST_ASPECT){
			// 未来完了形
			// 補助動詞を呼び出す
			$auxiliary_byc = new Polish_Verb_Byc();
			// 結合
			$verb_conjugation = $auxiliary_byc->get_polish_verb($person, Commons::FUTURE_TENSE, $gender)." ".$this->get_past_conditional_stem($gender, $person);
		} else if($tense_mood == Commons::SUBJUNCTIVE){
			// 仮定法
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::SUBJUNCTIVE."_".Commons::PERFECT_ASPECT){
			// 仮定法過去形
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);								
		} else if($tense_mood == Commons::IMPERATIVE){
			// 命令法
			$verb_conjugation = $this->imperative_stem.$this->imperative_number[Commons::ACTIVE_VOICE][$person];	
		} else {
			// ハイフンを返す。
			return "-";
		}  

		// 結果を返す。
		return $verb_conjugation;
	}

}

class Polish_Verb_Root3 extends Polish_Verb {

	// 活用種別
	protected $class = "3root3";
	
	// 不定形
	protected $infinitive = "";

	// 命令形語幹
	private $imperative_stem = "";

    /*=====================================
    コンストラクタ
    ======================================*/
    public function __construct($infinitive) {
		// 親の呼び出し
    	parent::__construct($infinitive);

		$this->past_stem = mb_substr($this->present_stem2, 0, -1)."ł";		// 過去分詞
		$this->aorist_stem = mb_substr($this->present_stem2, 0, -1);			// 過去形
		$this->verbal_noun = $this->present_stem."nie";		// 動名詞
		$this->imperative_stem = $this->present_stem2;		// 過去形
    }
	
	// 動詞作成
	public function get_polish_verb($person, $tense_mood, $gender){

		// 初期化
		$verb_conjugation = "";
		
		//時制と法で取得
		if($tense_mood == Commons::PRESENT_TENSE) {
			// 現在形
			$verb_conjugation = $this->get_primary_suffix_polish($person);
		} else if($tense_mood == Commons::PAST_TENSE && $this->root_type != Commons::AORIST_ASPECT){
			// 未完了過去
			$verb_conjugation = $this->aorist_stem.$this->imperfect_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::AORIST_ASPECT){
			// 過去形
			$verb_conjugation = $this->aorist_stem.$this->aorist_number[Commons::ACTIVE_VOICE][$person];	
		} else if($tense_mood == Commons::FUTURE_TENSE && $this->root_type != Commons::AORIST_ASPECT){
			// 未来形
			// 補助動詞を呼び出す
			$auxiliary_byc = new Polish_Verb_Byc();
			// 結合
			$verb_conjugation = $auxiliary_byc->get_polish_verb($person, Commons::FUTURE_TENSE, $gender)." ".$this->infinitive;			
		} else if($tense_mood == Commons::PERFECT_ASPECT){
			// 過去形(完了)	
			$past_stem = $this->get_past_conditional_stem($gender, $person);
			// 男性形単数のみ特例処理
			if($gender == Commons::ANIMATE_GENDER && preg_match("/(1sg|2sg)$/", $person)){
				$past_stem = $past_stem."e";
			}
			$verb_conjugation = $past_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person];						
		} else if($tense_mood == Commons::PAST_TENSE."_".Commons::PERFECT_ASPECT){
			// 過去完了形
			$past_stem = $this->get_past_conditional_stem($gender, $person);
			// 男性形単数のみ特例処理
			if($gender == Commons::ANIMATE_GENDER && preg_match("/(1sg|2sg)$/", $person)){
				$past_stem = $past_stem."e";
			}						
			$verb_conjugation = $past_stem.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);
		} else if($tense_mood == Commons::FUTURE_TENSE."_".Commons::PERFECT_ASPECT && $this->root_type != Commons::AORIST_ASPECT){
			// 未来完了形
			// 補助動詞を呼び出す
			$auxiliary_byc = new Polish_Verb_Byc();
			// 結合
			$verb_conjugation = $auxiliary_byc->get_polish_verb($person, Commons::FUTURE_TENSE, $gender)." ".$this->get_past_conditional_stem($gender, $person);
		} else if($tense_mood == Commons::SUBJUNCTIVE){
			// 仮定法
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person];
		} else if($tense_mood == Commons::SUBJUNCTIVE."_".Commons::PERFECT_ASPECT){
			// 仮定法過去形
			$verb_conjugation = $this->get_past_conditional_stem($gender, $person).$this->subj.$this->secondary_number[Commons::ACTIVE_VOICE][$person]." ".$this->get_pluperfect_stem($gender, $person);								
		} else if($tense_mood == Commons::IMPERATIVE){
			// 命令法
			$verb_conjugation = $this->imperative_stem.$this->imperative_number[Commons::ACTIVE_VOICE][$person];	
		} else {
			// ハイフンを返す。
			return "-";
		}  

		// 結果を返す。
		return $verb_conjugation;
	}

}

// ギリシア語動詞クラス
class Koine_Verb extends Verb_Common_IE {

	// 一次人称接尾辞(現在・接続・未来用)
	protected $primary_number = 
	[		
		"active" => 
		[
			"1sg" => "ω",
			"2sg" => "ις", 
			"3sg" => "ι",
			"2du" => "τον",
			"3du" => "τον", 
			"1pl" => "μεν",
			"2pl" => "τε", 
			"3pl" => "σιν",			
		],
		"mediopassive" => 
		[
			"1sg" => "μαι",
			"2sg" => "", 
			"3sg" => "ται",
			"2du" => "εσθον",
			"3du" => "εσθον", 
			"1pl" => "μεθα",
			"2pl" => "σθε", 
			"3pl" => "νται",			
		],
	];
	
	// 二次人称接尾辞(未完了過去、過去完了)
	protected $secondary_number = 
	[		
		"active" => 
		[
			"1sg" => "ν",
			"2sg" => "ς", 
			"3sg" => "",
			"2du" => "τον",
			"3du" => "την", 
			"1pl" => "μεν",
			"2pl" => "τε", 
			"3pl" => "ν",		
		],
		"mediopassive" => 
		[
			"1sg" => "μην",
			"2sg" => "", 
			"3sg" => "το",
			"2du" => "σθον",
			"3du" => "σθην", 
			"1pl" => "μεθα",
			"2pl" => "σθε", 
			"3pl" => "ντο",
		],
	];

	// 接続法接尾辞
	protected $subjunctive_number = 
	[		
		"active" => 
		[
			"1sg" => "",
			"2sg" => "ς", 
			"3sg" => "",
			"2du" => "τον",
			"3du" => "τον", 
			"1pl" => "μεν",
			"2pl" => "τε", 
			"3pl" => "σιν",			
		],
		"mediopassive" => 
		[
			"1sg" => "μαι",
			"2sg" => "", 
			"3sg" => "ται",
			"2du" => "εσθον",
			"3du" => "εσθον", 
			"1pl" => "μεθα",
			"2pl" => "σθε", 
			"3pl" => "νται",			
		],
	];

	// 希求法人称接尾辞
	protected $optative_number = 
	[
		"active" => 
		[
			"1sg" => "μι",
			"2sg" => "ς", 
			"3sg" => "",
			"2du" => "τον",
			"3du" => "την", 
			"1pl" => "μεν",
			"2pl" => "τε", 
			"3pl" => "εν",	
		],
		"mediopassive" => 
		[
			"1sg" => "μην",
			"2sg" => "ο", 
			"3sg" => "το",
			"2du" => "σθον",
			"3du" => "σθην", 
			"1pl" => "μεθα",
			"2pl" => "σθε", 
			"3pl" => "ντο",	
		],
	];

	// 命令人称接尾辞
	protected $imperative_number = 
	[
		"active" => 
		[
			"1sg" => "",
			"2sg" => "ν", 
			"3sg" => "τω",
			"2du" => "τον",
			"3du" => "των", 
			"1pl" => "",
			"2pl" => "τε", 
			"3pl" => "ούντων",	
		],
		"mediopassive" => 
		[
			"1sg" => "",
			"2sg" => "ου", 
			"3sg" => "σθω",
			"2du" => "σθον",
			"3du" => "σθων", 
			"1pl" => "",
			"2pl" => "σθε", 
			"3pl" => "σθων",	
		],
	];
	
	// 完了人称接尾辞(アオリスト・完了)
	protected $perfect_number = 
	[
		"active" => 
		[
			"1sg" => "",
			"2sg" => "ς", 
			"3sg" => "ν",
			"2du" => "τον",
			"3du" => "τον", 
			"1pl" => "μεν",
			"2pl" => "τε", 
			"3pl" => "ν",	
		],
		"mediopassive" => 
		[
			"1sg" => "μην",
			"2sg" => "ω", 
			"3sg" => "το",
			"2du" => "σθον",
			"3du" => "σθον", 
			"1pl" => "μεθα",
			"2pl" => "σθε", 
			"3pl" => "ντο",	
		],
	];

	// 始動動詞
	protected $inchoative_stem = "";
	// 未然動詞
	protected $future_stem = "";

	// 始動能動分詞
	protected $inchoative_participle_active = "";
	// 始動中動分詞
	protected $inchoative_participle_middle = "";
	// 未来能動分詞
	protected $future_participle_active = "";
	// 未来受動分詞
	protected $future_participle_passive = "";
	// 未来中動分詞
	protected $future_participle_middle = "";

	// 不完了体能動不定詞
	protected $present_infinitive_active = "";
	// 不完了体中動不定詞
	protected $present_infinitive_middle = "";	
	// 始動能動分詞
	protected $inchoative_infinitive_active = "";
	// 始動中動分詞
	protected $inchoative_infinitive_middle = "";
	// 完了体能動不定詞
	protected $aorist_infinitive_active = "";
	// 完了体受動不定詞
	protected $aorist_infinitive_passive = "";
	// 完了体中動不定詞
	protected $aorist_infinitive_middle = "";	
	// 状態動詞能動不定詞
	protected $perfect_infinitive_active = "";
	// 状態動詞中動不定詞
	protected $perfect_infinitive_middle = "";
	// 未来能動不定詞
	protected $future_infinitive_active = "";
	// 未来受動不定詞
	protected $future_infinitive_passive = "";
	// 未来中動不定詞
	protected $future_infinitive_middle = "";

	// 使役不完了体
	protected $causative_present_stem = "";
	// 使役始動動詞
	protected $causative_inchoative_stem = "";
	// 使役完了体
	protected $causative_aorist_stem = "";
	// 使役状態動詞
	protected $causative_perfect_stem = "";
	// 使役未然動詞
	protected $causative_future_stem = "";

	// 使役不完了体能動分詞
	protected $causative_present_participle_active = "";
	// 使役不完了体受動分詞
	protected $causative_present_participle_passive = "";
	// 使役不完了体中動分詞
	protected $causative_present_participle_middle = "";
	// 使役始動能動分詞
	protected $causative_inchoative_participle_active = "";
	// 使役始動中動分詞
	protected $causative_inchoative_participle_middle = "";
	// 使役完了体能動分詞
	protected $causative_aorist_participle_active = "";
	// 使役完了体受動分詞
	protected $causative_aorist_participle_passive = "";
	// 使役完了体中動分詞
	protected $causative_aorist_participle_middle = "";	
	// 使役状態動詞能動分詞
	protected $causative_perfect_participle_active = "";
	// 使役状態動詞受動分詞
	protected $causative_perfect_participle_passive = "";
	// 使役状態動詞中動分詞
	protected $causative_perfect_participle_middle = "";
	// 使役未来能動分詞
	protected $causative_future_participle_active = "";
	// 使役未来受動分詞
	protected $causative_future_participle_passive = "";
	// 使役未来中動分詞
	protected $causative_future_participle_middle = "";
	
	// 使役不完了体能動不定詞
	protected $causative_present_infinitive_active = "";
	// 使役不完了体中動不定詞
	protected $causative_present_infinitive_middle = "";
	// 使役始動能動不定詞
	protected $causative_inchoative_infinitive_active = "";
	// 使役始動中動不定詞
	protected $causative_inchoative_infinitive_middle = "";
	// 使役完了体能動不定詞
	protected $causative_aorist_infinitive_active = "";
	// 使役完了体受動不定詞
	protected $causative_aorist_infinitive_passive = "";
	// 使役完了体中動不定詞
	protected $causative_aorist_infinitive_middle = "";	
	// 使役状態動詞能動不定詞
	protected $causative_perfect_infinitive_active = "";
	// 使役状態動詞中動不定詞
	protected $causative_perfect_infinitive_middle = "";
	// 使役未来能動不定詞
	protected $causative_future_infinitive_active = "";
	// 使役未来受動不定詞
	protected $causative_future_infinitive_passive = "";
	// 使役未来中動不定詞
	protected $causative_future_infinitive_middle = "";

	// 強意不完了体
	protected $intensive_present_stem = "";
	// 強意始動動詞
	protected $intensive_inchoative_stem = "";
	// 強意完了体
	protected $intensive_aorist_stem = "";
	// 強意状態動詞
	protected $intensive_perfect_stem = "";
	// 強意未然動詞
	protected $intensive_future_stem = "";

	// 強意不完了体能動分詞
	protected $intensive_present_participle_active = "";
	// 強意不完了体受動分詞
	protected $intensive_present_participle_passive = "";
	// 強意不完了体中動分詞
	protected $intensive_present_participle_middle = "";
	// 強意始動能動分詞
	protected $intensive_inchoative_participle_active = "";
	// 強意始動中動分詞
	protected $intensive_inchoative_participle_middle = "";
	// 強意完了体能動分詞
	protected $intensive_aorist_participle_active = "";
	// 強意完了体受動分詞
	protected $intensive_aorist_participle_passive = "";
	// 強意完了体中動分詞
	protected $intensive_aorist_participle_middle = "";	
	// 強意状態動詞能動分詞
	protected $intensive_perfect_participle_active = "";
	// 強意状態動詞受動分詞
	protected $intensive_perfect_participle_passive = "";
	// 強意状態動詞中動分詞
	protected $intensive_perfect_participle_middle = "";
	// 強意未来能動分詞
	protected $intensive_future_participle_active = "";
	// 強意未来受動分詞
	protected $intensive_future_participle_passive = "";
	// 強意未来中動分詞
	protected $intensive_future_participle_middle = "";

	// 強意不完了体能動不定詞
	protected $intensive_present_infinitive_active = "";
	// 強意不完了体中動不定詞
	protected $intensive_present_infinitive_middle = "";
	// 使役始動能動不定詞
	protected $intensive_inchoative_infinitive_active = "";
	// 使役始動中動不定詞
	protected $intensive_inchoative_infinitive_middle = "";
	// 強意完了体能動不定詞
	protected $intensive_aorist_infinitive_active = "";
	// 強意完了体受動不定詞
	protected $intensive_aorist_infinitive_passive = "";
	// 強意完了体中動不定詞
	protected $intensive_aorist_infinitive_middle = "";	
	// 強意状態動詞能動不定詞
	protected $intensive_perfect_infinitive_active = "";
	// 強意状態動詞中動不定詞
	protected $intensive_perfect_infinitive_middle = "";
	// 強意未来能動不定詞
	protected $intensive_future_infinitive_active = "";
	// 強意未来受動不定詞
	protected $intensive_future_infinitive_passive = "";
	// 強意未来中動不定詞
	protected $intensive_future_infinitive_middle = "";

	// 欠如-未来形
	protected $deponent_future = "";	

	// 直接法
	protected $ind = "ε";
	protected $ind2 = "ού";

	// 過去
	protected const aor_past = "α";

	// 未完了
	protected const imper_past = "ά";
	protected const imper_past2 = "ώ";

	// 大過去
	protected const perf_past = "ει";

	// 命令法
	protected $imper = "";
	// 希求法
	protected $opt = "οι";

	// 接続法
	protected $subj = "η";
	protected $subj2 = "ώ";

	// 活用種別
	protected $class = "";

	// 受動態接尾辞
	protected const passive_suffix = "θή";
	// 完結接尾辞
	protected const aorist_suffix = "σ";
	// 完了形
	protected const perfect_suffix = "κ";
	// 未来接尾辞
	protected const future_suffix = "σ";

	
	// 現在・未来能動分詞接尾辞
	protected const active_participle_suffix = "ων";
	// 完結能動分詞接尾辞
	protected const active_participle_suffix2 = "ᾱς";
	// 完了能動分詞接尾辞
	protected const active_participle_suffix3 = "ως";
	// 現在・未来・完了中動分詞接尾辞
	protected const middle_participle_suffix = "ώμενος";
	// 完結能動分詞接尾辞
	protected const middle_participle_suffix2 = "ᾰ́μενος";
	// 完結受動分詞接尾辞
	protected const passive_participle_suffix = "ίς";

	// 能動態不定詞
	protected const active_infinitive_suffix = "ειν";
	// 能動態完結不定詞
	protected const active_infinitive_suffix2 = "αι";
	// 能動態完了不定詞
	protected const active_infinitive_suffix3 = "έναι";
	// 中受動態不定詞
	protected const middle_infinitive_suffix = "εσθαι";
	// 中受動態不定詞2
	protected const middle_infinitive_suffix2 = "ναι";

	// 辞書形
	protected $dictionary_stem = "";	
	// 活用種別名
	protected $class_name = "";	
	// 活用種別-語根種別
	protected $root_type = "";

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

    /*=====================================
    コンストラクタ
    ======================================*/
    function __construct_koine1($dictionary_stem) {
    	// 動詞情報を取得
		// 一次動詞
		$this->get_verb_data($dictionary_stem);
		// 使役動詞
		$this->make_causative_stem();
		// 強意動詞
		$this->make_intensive_stem();
    }

    /*=====================================
    コンストラクタ
    ======================================*/
    function __construct_koine3($word, $stem_type, $japanese_translation) {
    	// 動詞情報を取得
		// 一次動詞
		if($stem_type == "noun"){
			if(preg_match("/(υ)$/u", $word)){
				$this->get_verb_data($word."εω");
			} else if(preg_match("/(ᾰν)$/u", $word)){
				$this->get_verb_data(mb_substr($word, 0, -2)."αίνω");
			} else if(preg_match("/(ε)$/u", $word)){
				$this->get_verb_data($word."ύω");
			} else {
				$this->get_verb_data($word."αω");		
			}
		} else if($stem_type == "adjective"){
			$this->get_verb_data($word."εω");
		}
		// 使役動詞
		$this->make_causative_stem();
		// 強意動詞
		$this->make_intensive_stem();
		// 日本語訳
		$this->japanese_translation = $japanese_translation."(動詞化)";
    }

    // 動詞情報を取得
    protected function get_verb_data($verb){
		
    	// 動詞情報を取得
		$word_info = $this->get_verb_from_DB($verb, Koine_Common::DB_VERB);
		// データがある場合は
		if($word_info){
			// 辞書形
			$this->dictionary_stem = $verb;
			// データを挿入			
			$this->present_stem = $word_info["present_stem"];						// 現在相
			$this->aorist_stem = $word_info["aorist_stem"];							// 完結相
			// 動詞種別

			// 訳
			$this->japanese_translation = $word_info["japanese_translation"];		// 日本語
			$this->english_translation = $word_info["english_translation"];			// 英語
			// 欠如フラグ
			$this->deponent_active = $word_info["deponent_active"];					// 能動
			$this->deponent_mediopassive = $word_info["deponent_mediopassive"];		// 中受動
			$this->deponent_present = $word_info["deponent_present"];				// 現在
			$this->deponent_aorist = $word_info["deponent_aorist"];					// アオリスト
			$this->deponent_perfect = $word_info["deponent_perfect"];				// 完了
			// 追加語幹
			$this->add_stem	= $word_info["add_stem"];
		} else {
			// データを挿入
			// 現在相
			if(preg_match("/(ω|μι)$/u", $verb)){
				$this->present_stem = mb_substr($verb, 0, -1);
				// 辞書形
				$this->dictionary_stem = $this->present_stem."ω";
			} else if(preg_match("/μι$/u", $verb)){
				$this->present_stem = mb_substr($verb, 0, -2);
				// 辞書形
				$this->dictionary_stem = $this->present_stem."μι";
			} else {
				$this->present_stem = $verb;
				// 辞書形
				$this->dictionary_stem = $this->present_stem."ω";
			}
			// 完結相
			if(preg_match("/(νῡμῐ|νημῐ)$/u", $verb)){
				// 第7活用
				$this->aorist_stem = mb_substr($verb, 0, -4);
			} else if(preg_match("/[αευοωι]ν[^αευοωι]ᾰ́νω$/u", $verb)){
				// 第9活用
				$this->aorist_stem = mb_substr($verb, 0, -5).mb_substr($verb, -4, -3);
			} else if(preg_match("/(λλω|σσω|ττω)$/u", $verb)){
				// 第4活用
				$this->aorist_stem = mb_substr($verb, 0, -3)."ξ";
			} else if(preg_match("/σκω$/u", $verb)){
				// cch活用
				$this->aorist_stem = mb_substr($verb, 0, -3)."ησ";
			} else if(preg_match("/(α|ε)ω$/u", $verb)){
				// 第10活用1
				$this->aorist_stem = mb_substr($verb, 0, -1)."ησ";
			} else if(preg_match("/οω$/u", $verb)){
				// 第10活用2
				$this->aorist_stem = mb_substr($verb, 0, -1)."ωσ";
			} else {
				$this->aorist_stem = $verb."σ";
			}
	
			// 訳
			$this->japanese_translation = "借用";					// 日本語
			$this->english_translation = "borrowed";				// 英語
			// 欠如フラグ
			$this->deponent_active = Commons::$FALSE;				// 能動
			$this->deponent_mediopassive = Commons::$FALSE;			// 中受動
			$this->deponent_present = Commons::$FALSE;				// 現在
			$this->deponent_aorist = Commons::$FALSE;				// アオリスト
			$this->deponent_perfect = Commons::$FALSE;				// 完了
		}

		// 残りの相
		$this->inchoative_stem = $this->add_stem.$this->make_inchoative_stem($verb);	// 始動相
		$this->perfect_stem = $this->add_stem.$this->make_perfect_stem($verb);			// 完了形
		$this->future_stem = $this->add_stem.$this->make_future_stem($verb);			// 未来形

		// 分詞を作成
		$this->present_participle_active = $this->add_stem.$this->present_stem.self::active_participle_suffix;							// 現在能動
		$this->present_participle_middle = $this->add_stem.$this->present_stem.self::middle_participle_suffix;							// 現在中受動
		$this->inchoative_participle_active = $this->add_stem.$this->inchoative_stem.self::active_participle_suffix;					// 始動能動
		$this->inchoative_participle_middle = $this->add_stem.$this->inchoative_stem.self::middle_participle_suffix;					// 始動中受動
		$this->aorist_participle_active = $this->add_stem.$this->aorist_stem.self::active_participle_suffix2;							// 完結能動
		$this->aorist_participle_middle = $this->add_stem.$this->aorist_stem.self::middle_participle_suffix2;							// 完結中動
		$this->aorist_participle_passive = $this->add_stem.$this->aorist_stem.self::passive_suffix.self::middle_participle_suffix2;		// 完結受動
		$this->perfect_participle_active = $this->add_stem.$this->perfect_stem.self::active_participle_suffix;							// 完了能動
		$this->perfect_participle_middle = $this->add_stem.$this->perfect_stem.self::middle_participle_suffix;							// 完了中受動
		$this->future_participle_active = $this->add_stem.$this->future_stem.self::active_participle_suffix;							// 未来能動
		$this->future_participle_middle = $this->add_stem.$this->future_stem.self::middle_participle_suffix;							// 未来中動
		$this->future_participle_passive = $this->add_stem.$this->future_stem.self::passive_suffix.self::middle_participle_suffix;		// 未来受動

		// 不定詞を作成
		$this->present_infinitive_active = $this->add_stem.$this->present_stem.self::active_infinitive_suffix;							// 現在能動
		$this->present_infinitive_middle = $this->add_stem.$this->present_stem.self::middle_infinitive_suffix;							// 現在中受動
		$this->inchoative_infinitive_active = $this->add_stem.$this->inchoative_stem.self::active_infinitive_suffix;					// 始動能動
		$this->inchoative_infinitive_middle = $this->add_stem.$this->inchoative_stem.self::middle_infinitive_suffix;					// 始動中受動
		$this->aorist_infinitive_active = $this->add_stem.$this->aorist_stem.self::active_infinitive_suffix2;							// 完結能動
		$this->aorist_infinitive_middle = $this->add_stem.$this->aorist_stem.self::middle_infinitive_suffix;							// 完結中動
		$this->aorist_infinitive_passive = $this->add_stem.$this->aorist_stem.self::passive_suffix.self::middle_infinitive_suffix;		// 完結受動
		$this->perfect_infinitive_active = $this->add_stem.$this->perfect_stem.self::active_infinitive_suffix3;							// 完了能動
		$this->perfect_infinitive_middle = $this->add_stem.$this->perfect_stem.self::middle_infinitive_suffix2;							// 完了中受動
		$this->future_infinitive_active = $this->add_stem.$this->future_stem.self::active_infinitive_suffix;							// 未来能動
		$this->future_infinitive_middle = $this->add_stem.$this->future_stem.self::middle_infinitive_suffix;							// 未来中動
		$this->future_infinitive_passive = $this->add_stem.$this->future_stem.self::passive_suffix.self::middle_infinitive_suffix;		// 未来受動
    }

	// 始動形を作成
	private function make_inchoative_stem($verb){
		// 始動相
		if(preg_match("/σκω$/u", $verb)){
			// それ以外
			return mb_substr($verb, 0, -1);
		} else if(preg_match("/(α|ε)ω$/u", $verb)){
			// 第10活用1
			return $verb."σκ";
		} else if(preg_match("/(ο|ό)ω$/u", $verb)){
			// 第10活用2
			return $verb."σκ";
		} else {
			// それ以外
			return $verb."έ"."σκ";
		}
	}

	// 完了形を作成
	private function make_perfect_stem($verb){
		// 完了相
		if(preg_match("/^θ/u", $verb)){
			$perfect_stem = "τέ".$verb."η".self::perfect_suffix;
		} else if(preg_match("/^φ/u", $verb)){
			$perfect_stem = "πέ".$verb."η".self::perfect_suffix;
		} else if(preg_match("/^χ/u", $verb)){
			$perfect_stem = "κέ".$verb."η".self::perfect_suffix;
		} else if(preg_match("/σκω$/u", $verb)){
			// 始動相
			$perfect_stem = mb_substr($verb, 0, 1)."έ".mb_substr($verb, 0, -3).self::perfect_suffix;
		} else if(preg_match("/(α|ί)ζω$/u", $verb)){
			// 反復動詞
			$perfect_stem = mb_substr($verb, 0, 1)."έ".mb_substr($verb, 0, -2)."η".self::perfect_suffix;
		} else if(preg_match("/(α|ε|ο)ω$/u", $verb)){
			// 使役動詞
			$perfect_stem = mb_substr($verb, 0, 1)."έ".mb_substr($verb, 0, -2)."η".self::perfect_suffix;
		} else if(preg_match("/(ο|ό)ω$/u", $verb)){
			// 名詞起源動詞
			$perfect_stem = mb_substr($verb, 0, 1)."έ".mb_substr($verb, 0, -2)."ω".self::perfect_suffix;		
		} else {
			// それ以外
			$perfect_stem = mb_substr($verb, 0, 1)."έ".$verb.self::perfect_suffix;;
		}

		// 結果を返す。
		return $perfect_stem;
	}

	// 未来形を作成
	private function make_future_stem($verb){
		// 未来形
		if(preg_match("/(νῡμῐ|νημῐ)$/u", $verb)){
			// 第7活用
			$future_stem = mb_substr($verb, 0, -4).self::future_suffix;
		} else if(preg_match("/[αευοωι]ν[^αευοωι]ᾰ́νω$/u", $verb)){
			// 第9活用
			$future_stem = mb_substr($verb, 0, -4).mb_substr($verb, -4, -3).self::future_suffix;
		} else if(preg_match("/(λλω|σσω|ττω)$/u", $verb)){
			// 第4活用
			$future_stem = mb_substr($verb, 0, -1)."ξ".self::future_suffix;		
		} else if(preg_match("/σκω$/u", $verb)){
			// cch活用
			$future_stem = mb_substr($verb, 0, -3)."η".self::future_suffix;
		} else if(preg_match("/(α|ε)ω$/u", $verb)){
			// 第10活用1
			$future_stem = mb_substr($verb, 0, -2)."η".self::future_suffix;
		} else if(preg_match("/οω$/u", $verb)){
			// 第10活用2
			$future_stem = mb_substr($verb, 0, -2)."ω".self::future_suffix;
		} else {
			// それ以外
			$future_stem = $verb."σ";
		}

		// 結果を返す。
		return $future_stem;
	}

	// 使役動詞を作成
	protected function make_causative_stem(){
		// 動詞の種別ごとに分ける。
		if(preg_match("/(α|ε)ω$/u", $this->present_stem)){
			// 第10活用
			$this->causative_present_stem = mb_substr($this->present_stem, 0, -1)."ο";	// 現在相
			$this->causative_aorist_stem = $this->present_stem."ωσ";					// 完結相
		} else {
			// それ以外
			$this->causative_present_stem = $this->present_stem."έ";	// 現在相
			$this->causative_aorist_stem = $this->present_stem."ησ";	// 完結相
		}

		// それ以外の相
		$this->causative_inchoative_stem = $this->make_inchoative_stem($this->causative_present_stem."ω");	// 始動相
		$this->causative_perfect_stem = $this->make_perfect_stem($this->causative_present_stem."ω");		// 完了相
		$this->causative_future_stem = $this->make_future_stem($this->causative_present_stem."ω");		// 未来形

		// 分詞を作成
		$this->causative_present_participle_active = $this->causative_present_stem.self::active_participle_suffix;		// 現在能動
		$this->causative_present_participle_middle = $this->causative_present_stem.self::middle_participle_suffix;		// 現在中受動
		$this->causative_inchoative_participle_active = $this->causative_inchoative_stem.self::active_participle_suffix;	// 始動能動
		$this->causative_inchoative_participle_middle = $this->causative_inchoative_stem.self::middle_participle_suffix;	// 始動中受動
		$this->causative_aorist_participle_active = $this->causative_aorist_stem.self::active_participle_suffix2;		// 完結能動
		$this->causative_aorist_participle_middle = $this->causative_aorist_stem.self::middle_participle_suffix2;		// 完結中動
		$this->causative_aorist_participle_passive = $this->causative_aorist_stem.self::passive_suffix.self::middle_participle_suffix2;		// 完結受動
		$this->causative_perfect_participle_active = $this->causative_perfect_stem.self::active_participle_suffix;		// 完了能動
		$this->causative_perfect_participle_middle = $this->causative_perfect_stem.self::middle_participle_suffix;		// 完了中受動
		$this->causative_future_participle_active = $this->causative_aorist_stem.self::active_participle_suffix;		// 未来能動
		$this->causative_future_participle_middle = $this->causative_aorist_stem.self::middle_participle_suffix;		// 未来中動
		$this->causative_future_participle_passive = $this->causative_aorist_stem.self::passive_suffix.self::middle_participle_suffix;		// 未来受動

		// 不定詞を作成
		$this->causative_present_infinitive_active = $this->causative_present_stem.self::active_infinitive_suffix;		// 現在能動
		$this->causative_present_infinitive_middle = $this->causative_present_stem.self::middle_infinitive_suffix;		// 現在中受動
		$this->causative_inchoative_infinitive_active = $this->causative_inchoative_stem.self::active_infinitive_suffix;	// 始動能動
		$this->causative_inchoative_infinitive_middle = $this->causative_inchoative_stem.self::middle_infinitive_suffix;	// 始動中受動
		$this->causative_aorist_infinitive_active = $this->causative_aorist_stem.self::active_infinitive_suffix2;		// 完結能動
		$this->causative_aorist_infinitive_middle = $this->causative_aorist_stem.self::middle_infinitive_suffix;		// 完結中動
		$this->causative_aorist_infinitive_passive = $this->causative_aorist_stem.self::passive_suffix.self::middle_infinitive_suffix;		// 完結受動
		$this->causative_perfect_infinitive_active = $this->causative_perfect_stem.self::active_infinitive_suffix3;		// 完了能動
		$this->causative_perfect_infinitive_middle = $this->causative_perfect_stem.self::middle_infinitive_suffix2;		// 完了中受動
		$this->causative_future_infinitive_active = $this->causative_aorist_stem.self::active_infinitive_suffix;		// 未来能動
		$this->causative_future_infinitive_middle = $this->causative_aorist_stem.self::middle_infinitive_suffix;		// 未来中動
		$this->causative_future_infinitive_passive = $this->causative_aorist_stem.self::passive_suffix.self::middle_infinitive_suffix;		// 未来受動
	}

	// 強意動詞を作成
	protected function make_intensive_stem(){
		// 動詞の種別ごとに分ける。
		if(preg_match("/(α|ε|ο)ω$/u", $this->present_stem)){
			// 第10活用
			$this->intensive_present_stem = mb_substr($this->present_stem, 0, -1)."ᾰ́ζ";	// 現在相
			$this->intensive_aorist_stem = $this->present_stem."ᾰ́σ";					   	// 完結相
		} else {
			// それ以外
			$this->intensive_present_stem = $this->present_stem."ᾰ́ζ";	// 現在相
			$this->intensive_aorist_stem = $this->present_stem."ᾰ́σ";	// 完結相
		}

		// それ以外の相
		$this->intensive_inchoative_stem = $this->make_inchoative_stem($this->intensive_present_stem."ω");	    // 始動相
		$this->intensive_perfect_stem = $this->make_perfect_stem(mb_substr($this->present_stem, 0, -1)."κ");		// 完了相
		$this->intensive_future_stem = $this->make_future_stem(mb_substr($this->present_stem, 0, -1))."ᾰ́σ";	 // 未来形

		// 分詞を作成
		$this->intensive_present_participle_active = $this->intensive_present_stem.self::active_participle_suffix;		// 現在能動
		$this->intensive_present_participle_middle = $this->intensive_present_stem.self::middle_participle_suffix;		// 現在中受動
		$this->intensive_inchoative_participle_active = $this->intensive_inchoative_stem.self::active_participle_suffix;	// 始動能動
		$this->intensive_inchoative_participle_middle = $this->intensive_inchoative_stem.self::middle_participle_suffix;	// 始動中受動
		$this->intensive_aorist_participle_active = $this->intensive_aorist_stem.self::active_participle_suffix2;		// 完結能動
		$this->intensive_aorist_participle_middle = $this->intensive_aorist_stem.self::middle_participle_suffix2;		// 完結中動
		$this->intensive_aorist_participle_passive = $this->intensive_aorist_stem.self::passive_suffix.self::middle_participle_suffix2;		// 完結受動
		$this->intensive_perfect_participle_active = $this->intensive_perfect_stem.self::active_participle_suffix;		// 完了能動
		$this->intensive_perfect_participle_middle = $this->intensive_perfect_stem.self::middle_participle_suffix;		// 完了中受動
		$this->intensive_future_participle_active = $this->intensive_future_stem.self::active_participle_suffix;		// 未来能動
		$this->intensive_future_participle_middle = $this->intensive_future_stem.self::middle_participle_suffix;		// 未来中動
		$this->intensive_future_participle_passive = $this->intensive_future_stem.self::passive_suffix.self::middle_participle_suffix;		// 未来受動

		// 不定詞を作成
		$this->intensive_present_infinitive_active = $this->intensive_present_stem.self::active_infinitive_suffix;		// 現在能動
		$this->intensive_present_infinitive_middle = $this->intensive_present_stem.self::middle_infinitive_suffix;		// 現在中受動
		$this->intensive_inchoative_infinitive_active = $this->intensive_inchoative_stem.self::active_infinitive_suffix;	// 始動能動
		$this->intensive_inchoative_infinitive_middle = $this->intensive_inchoative_stem.self::middle_infinitive_suffix;	// 始動中受動
		$this->intensive_aorist_infinitive_active = $this->intensive_aorist_stem.self::active_infinitive_suffix2;		// 完結能動
		$this->intensive_aorist_infinitive_middle = $this->intensive_aorist_stem.self::middle_infinitive_suffix;		// 完結中動
		$this->intensive_aorist_infinitive_passive = $this->intensive_aorist_stem.self::passive_suffix.self::middle_infinitive_suffix;		// 完結受動
		$this->intensive_perfect_infinitive_active = $this->intensive_perfect_stem.self::active_infinitive_suffix3;		// 完了能動
		$this->intensive_perfect_infinitive_middle = $this->intensive_perfect_stem.self::middle_infinitive_suffix2;		// 完了中受動
		$this->intensive_future_infinitive_active = $this->intensive_future_stem.self::active_infinitive_suffix;		// 未来能動
		$this->intensive_future_infinitive_middle = $this->intensive_future_stem.self::middle_infinitive_suffix;		// 未来中動
		$this->intensive_future_infinitive_passive = $this->intensive_future_stem.self::passive_suffix.self::middle_infinitive_suffix;		// 未来受動
	}

	// 分詞の曲用表を返す。	
	protected function get_participle($participle_stem){
		// 読み込み
		$vedic_adjective = new Koine_Adjective($participle_stem, "participle");
		// 結果を取得
		$chart = $vedic_adjective->get_chart();
		// メモリを解放
		unset($vedic_adjective);
		// 結果を返す。
		return $chart;
	}
	
	// 動詞作成
	public function get_koine_verb($person, $voice, $tense_mood, $aspect){

		// 不適切な組み合わせのチェック
		if(!$this->deponent_check($voice, $aspect)){
			// ハイフンを返す。
			return "-";		
		}

		//動詞の語幹を取得
		$verb_stem = "";
		if($aspect == Commons::PRESENT_ASPECT && $this->deponent_present != Commons::$TRUE){
			// 不完了形
			$verb_stem = $this->present_stem;
		} else if($aspect == Commons::START_VERB && $this->deponent_present != Commons::$TRUE){
			// 始動相
			$verb_stem = $this->inchoative_stem;
		} else if($aspect == Commons::AORIST_ASPECT && $this->deponent_aorist != Commons::$TRUE){
			// 完了形
			$verb_stem = $this->aorist_stem;
		} else if($aspect == Commons::PERFECT_ASPECT && $this->deponent_perfect != Commons::$TRUE){
			// 状態動詞
			$verb_stem = $this->perfect_stem;
		} else if($aspect == Commons::FUTURE_TENSE && $this->deponent_future != Commons::$TRUE){
			// 未来形
			$verb_stem = $this->future_stem;			
		} else {
			// ハイフンを返す。
			return "-";
		} 

		// 受動態は専用の接尾辞を追加
		if($voice == Commons::PASSIVE_VOICE){
			// 受動態接尾辞
			$verb_stem = $verb_stem.self::passive_suffix;
			// 中動態に読み替え
			$voice = Commons::MEDIOPASSIVE_VOICE;
		}
		
		// 活用作成
		return $this->make_conjugation($person, $voice, $tense_mood, $aspect, $verb_stem);
	}

	// 使役動詞作成
	public function get_koine_causative_verb($person, $voice, $tense_mood, $aspect){
		//動詞の語幹を取得
		$verb_stem = "";
		if($aspect == Commons::PRESENT_ASPECT){
			// 不完了形
			$verb_stem = $this->causative_present_stem;
		} else if($aspect == Commons::START_VERB){
			// 始動相
			$verb_stem = $this->causative_inchoative_stem;
		} else if($aspect == Commons::AORIST_ASPECT){
			// 完了形
			$verb_stem = $this->causative_aorist_stem;
		} else if($aspect == Commons::PERFECT_ASPECT){
			// 状態動詞
			$verb_stem = $this->causative_perfect_stem;
		} else if($aspect == Commons::FUTURE_TENSE){
			// 未来形
			$verb_stem = $this->causative_future_stem;			
		} else {
			// ハイフンを返す。
			return "-";
		} 

		// 受動態は専用の接尾辞を追加
		if($voice == Commons::PASSIVE_VOICE){
			// 受動態接尾辞
			$verb_stem = $verb_stem.self::passive_suffix;
			// 中動態に読み替え
			$voice = Commons::MEDIOPASSIVE_VOICE;
		}
		
		// 活用作成
		return $this->make_conjugation($person, $voice, $tense_mood, $aspect, $verb_stem);
	}

	// 強意動詞作成
	public function get_koine_intensive_verb($person, $voice, $tense_mood, $aspect){
		//動詞の語幹を取得
		$verb_stem = "";
		if($aspect == Commons::PRESENT_ASPECT){
			// 不完了形
			$verb_stem = $this->intensive_present_stem;
		} else if($aspect == Commons::START_VERB){
			// 始動相
			$verb_stem = $this->intensive_inchoative_stem;
		} else if($aspect == Commons::AORIST_ASPECT){
			// 完了形
			$verb_stem = $this->intensive_aorist_stem;
		} else if($aspect == Commons::PERFECT_ASPECT){
			// 状態動詞
			$verb_stem = $this->intensive_perfect_stem;
		} else if($aspect == Commons::FUTURE_TENSE){
			// 未来形
			$verb_stem = $this->intensive_future_stem;			
		} else {
			// ハイフンを返す。
			return "-";
		} 

		// 受動態は専用の接尾辞を追加
		if($voice == Commons::PASSIVE_VOICE){
			// 受動態接尾辞
			$verb_stem = $verb_stem.self::passive_suffix;
			// 中動態に読み替え
			$voice = Commons::MEDIOPASSIVE_VOICE;
		}
		
		// 活用作成
		return $this->make_conjugation($person, $voice, $tense_mood, $aspect, $verb_stem);
	}

	// 活用作成
	public function make_conjugation($person, $voice, $tense_mood, $aspect, $verb_stem){
		// 直説法
		// 時制を分ける。
		if ($tense_mood == Commons::PRESENT_TENSE && ($aspect == Commons::PRESENT_ASPECT || $aspect == Commons::START_VERB || $aspect == Commons::FUTURE_TENSE)) {
			// 人称によって分ける
			if($person == "1sg" || $person == "1pl" || $person == "3pl"){
				$verb_stem = $verb_stem.$this->ind2;
			} else {
				$verb_stem = $verb_stem.$this->ind;
			}
			// 人称を付ける
			$verb_stem = $this->get_primary_suffix($verb_stem, $voice, $person);
		} else if(($aspect == Commons::PRESENT_TENSE || $aspect == Commons::START_VERB) && $tense_mood == Commons::PAST_TENSE){
			// 未完了過去
			// 態によって分ける。
			if($voice = Commons::ACTIVE_VOICE){
				// 能動態の場合
				// 人称によって分ける
				if($person == "1sg" || $person == "1pl" || $person == "3pl"){
					$verb_stem = $verb_stem.$this->ind2;
				} else {
					$verb_stem = $verb_stem.$this->ind;
				}
			} else if($voice = Commons::MEDIOPASSIVE_VOICE){
				// 中受動態の場合
				// 人称によって分ける
				if($person == "1sg" || $person == "2sg" || $person == "1pl" || $person == "3pl"){
					$verb_stem = $verb_stem.$this->ind2;
				} else {
					$verb_stem = $verb_stem.$this->ind;
				}
			} else {
				// ハイフンを返す。
				return "-";
			} 
			// 人称を付ける
			$verb_stem = $this->get_secondary_suffix($verb_stem, $voice, $person);
		} else if($aspect == Commons::PERFECT_ASPECT && $tense_mood == Commons::PAST_TENSE){
			// 大過去
			$verb_stem = $verb_stem.self::perf_past;
			// 人称を付ける
			$verb_stem = $this->get_secondary_suffix($verb_stem, $voice, $person);
		} else if($aspect == Commons::AORIST_ASPECT && $tense_mood == Commons::PAST_TENSE){
			// アオリスト
			// 人称を付ける
			$verb_stem = $this->get_greek_perfect_suffix($verb_stem, $voice, $person);
		} else if($aspect == Commons::PERFECT_ASPECT){
			// 完了形
			// 人称を付ける
			$verb_stem = $this->get_greek_perfect_suffix($verb_stem, $voice, $person);
		} else if($tense_mood == Commons::OPTATIVE){
			// 希求法
			// 態によって分ける。
			if($aspect == Commons::AORIST_ASPECT && $voice == Commons::PASSIVE_VOICE){
				// アオリストの受動態の場合
				if($person == "1sg" || $person == "2sg" || $person == "3sg"){
					$verb_stem = $verb_stem."ίη";
				} else {
					$verb_stem = $verb_stem."η";
				}
			} else {
				// それ以外
				$verb_stem = $verb_stem.$this->opt;
			}
			// 人称を付ける
			$verb_stem = $this->get_secondary_suffix($verb_stem, $voice, $person);
		} else if($tense_mood == Commons::SUBJUNCTIVE && $aspect != Commons::FUTURE_TENSE){
			// 接続法
			if($person == "1sg" || $person == "1pl" || $person == "3pl"){
				$verb_stem = $verb_stem.$this->subj2;
			} else {
				$verb_stem = $verb_stem.$this->subj;
			}
			// 人称を付ける
			$verb_stem = $this->get_greek_subjunctive_suffix($verb_stem, $voice, $person);
		} else if($tense_mood == Commons::IMPERATIVE && $aspect != Commons::FUTURE_TENSE){
			// 命令法
			$verb_stem = $verb_stem.$this->imper;
			// 人称を付ける
			$verb_stem = $this->get_imperative_suffix($verb_stem, $voice, $person);
		}
		
		// 結果を返す。
		return $verb_stem;
	}

    // 動詞のタイトルを取得
    protected function get_title($dic_form){

		// タイトルを作成
		$verb_script = $dic_form;

		// 英語訳がある場合は
		if ($this->english_translation != ""){
			// 訳を入れる。
			$verb_script = $verb_script." 英語：".$this->english_translation."";
		}
		
		// 日本語訳がある場合は
		if ($this->japanese_translation != ""){
			// 訳を入れる。
			$verb_script = $verb_script." 日本語：".$this->japanese_translation."";
		}

    	// 結果を返す。
    	return $verb_script;
	}

	// 接続法語尾
	protected function get_greek_subjunctive_suffix($verb_conjugation, $voice, $person){
		// 語尾を取得
		if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 能動態
			$verb_conjugation = $verb_conjugation.$this->subjunctive_number[$voice][$person];
		} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
			// 中受動態
			$verb_conjugation = $verb_conjugation.$this->subjunctive_number[$voice][$person];
		} else {
			// ハイフンを返す。
			return "-";
		}  
		// 結果を返す。
		return $verb_conjugation;
	}

	// 希求法語尾
	protected function get_greek_optative_suffix($verb_conjugation, $voice, $person){
		// 語尾を取得
		if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 能動態
			$verb_conjugation = $verb_conjugation.$this->optative_number[$voice][$person];
		} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
			// 中受動態
			$verb_conjugation = $verb_conjugation.$this->optative_number[$voice][$person];
		} else {
			// ハイフンを返す。
			return "-";
		}  
		// 結果を返す。
		return $verb_conjugation;
	}

	// 完了語尾
	protected function get_greek_perfect_suffix($verb_conjugation, $voice, $person){
		// 語尾を取得
		if($voice == Commons::ACTIVE_VOICE && $this->deponent_active != Commons::$TRUE){
			// 能動態
			$verb_conjugation = $verb_conjugation.$this->perfect_number[$voice][$person];
		} else if($voice == Commons::MEDIOPASSIVE_VOICE && $this->deponent_mediopassive != Commons::$TRUE){
			// 中受動態
			$verb_conjugation = $verb_conjugation.$this->perfect_number[$voice][$person];
		} else {
			// ハイフンを返す。
			return "-";
		}  
		// 結果を返す。
		return $verb_conjugation;
	}

	// 一次動詞の活用を作成する。
	protected function get_primary_verb_conjugation(){

		// 配列を作成
		$aspect_array = array(Commons::PRESENT_ASPECT, Commons::START_VERB, Commons::AORIST_ASPECT, Commons::PERFECT_ASPECT, Commons::FUTURE_TENSE);			// 相
		$voice_array = array(Commons::ACTIVE_VOICE, Commons::MEDIOPASSIVE_VOICE, Commons::PASSIVE_VOICE);								// 態
		$tense_mood_array = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE, Commons::SUBJUNCTIVE, Commons::OPTATIVE, Commons::IMPERATIVE);	//時制と法
		$person_array = array("1sg", "2sg", "3sg", "2du", "3du", "1pl", "2pl", "3pl");												// 人称

		// 初期化
		$conjugation = array();
		// 全ての法
		foreach ($aspect_array as $aspect){	
			// 全ての態			
			foreach ($voice_array as $voice){
				// 全ての法			
				foreach ($tense_mood_array as $tense_mood){
					// 全ての人称			
					foreach ($person_array as $person){
						// 態と人称で場合分けする。
						if($aspect == Commons::AORIST_ASPECT && $tense_mood == Commons::PRESENT_TENSE){
							// アオリストの現在時制は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";			
						} else if($aspect == Commons::FUTURE_TENSE && ($tense_mood != Commons::PRESENT_TENSE && $tense_mood != Commons::OPTATIVE)){
							// 現在形・希求法以外のの時制や法は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";					
						} else {
							// 態・時制・法・人称に応じて多次元配列を作成		
							$conjugation[$aspect][$voice][$tense_mood][$person] = $this->get_koine_verb($person, $voice, $tense_mood, $aspect);	
						}					
					}
				}

			}
		}
		// 分詞を入れる。
		// 現在分詞・不定詞
		$conjugation["participle"][Commons::PRESENT_ASPECT][Commons::ACTIVE_VOICE] = $this->get_participle($this->present_participle_active);			// 能動分詞
		$conjugation["participle"][Commons::PRESENT_ASPECT][Commons::MIDDLE_VOICE] = $this->get_participle($this->present_participle_middle);			// 中受動分詞
		$conjugation["participle"][Commons::PRESENT_ASPECT][Commons::PASSIVE_VOICE] = $this->get_participle($this->present_participle_middle);			// 中受動分詞
		$conjugation["infinitive"][Commons::PRESENT_ASPECT][Commons::ACTIVE_VOICE] = $this->present_infinitive_active;									// 能動不定詞
		$conjugation["infinitive"][Commons::PRESENT_ASPECT][Commons::MIDDLE_VOICE] = $this->present_infinitive_middle;									// 中受動不定詞
		$conjugation["infinitive"][Commons::PRESENT_ASPECT][Commons::PASSIVE_VOICE] = $this->present_infinitive_middle;									// 中受動不定詞

		// 始動分詞・不定詞
		$conjugation["participle"][Commons::START_VERB][Commons::ACTIVE_VOICE] = $this->get_participle($this->inchoative_participle_active);			// 能動分詞
		$conjugation["participle"][Commons::START_VERB][Commons::MIDDLE_VOICE] = $this->get_participle($this->inchoative_participle_middle);			// 中受動分詞
		$conjugation["participle"][Commons::START_VERB][Commons::PASSIVE_VOICE] = $this->get_participle($this->inchoative_participle_middle);			// 中受動分詞
		$conjugation["infinitive"][Commons::START_VERB][Commons::ACTIVE_VOICE] = $this->inchoative_infinitive_active;									// 能動不定詞
		$conjugation["infinitive"][Commons::START_VERB][Commons::MIDDLE_VOICE] = $this->inchoative_infinitive_middle;									// 中受動不定詞
		$conjugation["infinitive"][Commons::START_VERB][Commons::PASSIVE_VOICE] = $this->inchoative_infinitive_middle;									// 中受動不定詞

		// 完了体分詞
		$conjugation["participle"][Commons::AORIST_ASPECT][Commons::ACTIVE_VOICE] = $this->get_participle($this->aorist_participle_active);			// 能動分詞
		$conjugation["participle"][Commons::AORIST_ASPECT][Commons::MIDDLE_VOICE] = $this->get_participle($this->aorist_participle_middle);			// 中動分詞
		$conjugation["participle"][Commons::AORIST_ASPECT][Commons::PASSIVE_VOICE] = $this->get_participle($this->aorist_participle_passive);		// 受動分詞
		$conjugation["infinitive"][Commons::AORIST_ASPECT][Commons::ACTIVE_VOICE] = $this->aorist_infinitive_active;								// 能動不定詞
		$conjugation["infinitive"][Commons::AORIST_ASPECT][Commons::MIDDLE_VOICE] = $this->aorist_infinitive_middle;								// 中動不定詞
		$conjugation["infinitive"][Commons::AORIST_ASPECT][Commons::PASSIVE_VOICE] = $this->aorist_infinitive_passive;								// 受動不定詞

		// 完了形分詞
		$conjugation["participle"][Commons::PERFECT_ASPECT][Commons::ACTIVE_VOICE] = $this->get_participle($this->perfect_participle_active);		// 能動分詞
		$conjugation["participle"][Commons::PERFECT_ASPECT][Commons::MIDDLE_VOICE] = $this->get_participle($this->perfect_participle_middle);		// 中受動分詞
		$conjugation["participle"][Commons::PERFECT_ASPECT][Commons::PASSIVE_VOICE] = $this->get_participle($this->perfect_participle_middle);		// 中受動分詞
		$conjugation["infinitive"][Commons::PERFECT_ASPECT][Commons::ACTIVE_VOICE] = $this->perfect_infinitive_active;								// 能動不定詞
		$conjugation["infinitive"][Commons::PERFECT_ASPECT][Commons::MIDDLE_VOICE] = $this->perfect_infinitive_middle;								// 中受動不定詞
		$conjugation["infinitive"][Commons::PERFECT_ASPECT][Commons::PASSIVE_VOICE] = $this->perfect_infinitive_middle;								// 中受動不定詞

		// 未来分詞
		$conjugation["participle"][Commons::FUTURE_TENSE][Commons::ACTIVE_VOICE] = $this->get_participle($this->future_participle_active);			// 能動分詞
		$conjugation["participle"][Commons::FUTURE_TENSE][Commons::MIDDLE_VOICE] = $this->get_participle($this->future_participle_middle);			// 中動分詞
		$conjugation["participle"][Commons::FUTURE_TENSE][Commons::PASSIVE_VOICE] = $this->get_participle($this->future_participle_passive);		// 受動分詞
		$conjugation["infinitive"][Commons::FUTURE_TENSE][Commons::ACTIVE_VOICE] = $this->future_infinitive_active;									// 能動不定詞
		$conjugation["infinitive"][Commons::FUTURE_TENSE][Commons::MIDDLE_VOICE] = $this->future_infinitive_middle;									// 中動不定詞
		$conjugation["infinitive"][Commons::FUTURE_TENSE][Commons::PASSIVE_VOICE] = $this->future_infinitive_passive;								// 受動不定詞


		// 結果を返す。
		return $conjugation;
	}

	// 使役動詞の活用を作成する。
	protected function get_causative_verb_conjugation(){

		// 配列を作成
		$aspect_array = array(Commons::PRESENT_ASPECT, Commons::START_VERB, Commons::AORIST_ASPECT, Commons::PERFECT_ASPECT, Commons::FUTURE_TENSE);			// 相
		$voice_array = array(Commons::ACTIVE_VOICE, Commons::MEDIOPASSIVE_VOICE, Commons::PASSIVE_VOICE);								// 態
		$tense_mood_array = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE, Commons::SUBJUNCTIVE, Commons::OPTATIVE, Commons::IMPERATIVE);	//時制と法
		$person_array = array("1sg", "2sg", "3sg", "2du", "3du", "1pl", "2pl", "3pl");														// 人称

		// 初期化
		$conjugation = array();
		// 全ての法
		foreach ($aspect_array as $aspect){	
			// 全ての態			
			foreach ($voice_array as $voice){
				// 全ての法			
				foreach ($tense_mood_array as $tense_mood){
					// 全ての人称			
					foreach ($person_array as $person){
						// 態と人称で場合分けする。
						if($aspect == Commons::AORIST_ASPECT && $tense_mood == Commons::PRESENT_TENSE){
							// アオリストの現在時制は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
						} else if($aspect == Commons::FUTURE_TENSE && ($tense_mood != Commons::PRESENT_TENSE && $tense_mood != Commons::OPTATIVE)){
							// 現在形・希求法以外のの時制や法は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";							
						} else {
							// 態・時制・法・人称に応じて多次元配列を作成		
							$conjugation[$aspect][$voice][$tense_mood][$person] = $this->get_koine_causative_verb($person, $voice, $tense_mood, $aspect);	
						}					
					}
				}

			}
		}
		// 分詞を入れる。
		// 現在分詞・不定詞
		$conjugation["participle"][Commons::PRESENT_ASPECT][Commons::ACTIVE_VOICE] = $this->get_participle($this->causative_present_participle_active);			// 能動分詞
		$conjugation["participle"][Commons::PRESENT_ASPECT][Commons::MIDDLE_VOICE] = $this->get_participle($this->causative_present_participle_middle);			// 中受動分詞
		$conjugation["participle"][Commons::PRESENT_ASPECT][Commons::PASSIVE_VOICE] = $this->get_participle($this->causative_present_participle_middle);		// 中受動分詞
		$conjugation["infinitive"][Commons::PRESENT_ASPECT][Commons::ACTIVE_VOICE] = $this->causative_present_infinitive_active;								// 能動不定詞
		$conjugation["infinitive"][Commons::PRESENT_ASPECT][Commons::MIDDLE_VOICE] = $this->causative_present_infinitive_middle;								// 中動不定詞
		$conjugation["infinitive"][Commons::PRESENT_ASPECT][Commons::PASSIVE_VOICE] = $this->causative_present_infinitive_middle;								// 中動不定詞

		// 始動分詞・不定詞
		$conjugation["participle"][Commons::START_VERB][Commons::ACTIVE_VOICE] = $this->get_participle($this->causative_inchoative_participle_active);		// 能動分詞
		$conjugation["participle"][Commons::START_VERB][Commons::MIDDLE_VOICE] = $this->get_participle($this->causative_inchoative_participle_middle);		// 中受動分詞
		$conjugation["participle"][Commons::START_VERB][Commons::PASSIVE_VOICE] = $this->get_participle($this->causative_inchoative_participle_middle);		// 中受動分詞
		$conjugation["infinitive"][Commons::START_VERB][Commons::ACTIVE_VOICE] = $this->causative_inchoative_infinitive_active;								// 能動不定詞
		$conjugation["infinitive"][Commons::START_VERB][Commons::MIDDLE_VOICE] = $this->causative_inchoative_infinitive_middle;								// 中動不定詞
		$conjugation["infinitive"][Commons::START_VERB][Commons::PASSIVE_VOICE] = $this->causative_inchoative_infinitive_middle;							// 中動不定詞

		// 完了体分詞
		$conjugation["participle"][Commons::AORIST_ASPECT][Commons::ACTIVE_VOICE] = $this->get_participle($this->causative_aorist_participle_active);		// 能動分詞
		$conjugation["participle"][Commons::AORIST_ASPECT][Commons::MIDDLE_VOICE] = $this->get_participle($this->causative_aorist_participle_middle);		// 中動分詞
		$conjugation["participle"][Commons::AORIST_ASPECT][Commons::PASSIVE_VOICE] = $this->get_participle($this->causative_aorist_participle_passive);		// 受動分詞
		$conjugation["infinitive"][Commons::AORIST_ASPECT][Commons::ACTIVE_VOICE] = $this->causative_aorist_infinitive_active;								// 能動不定詞
		$conjugation["infinitive"][Commons::AORIST_ASPECT][Commons::MIDDLE_VOICE] = $this->causative_aorist_infinitive_middle;								// 中動不定詞
		$conjugation["infinitive"][Commons::AORIST_ASPECT][Commons::PASSIVE_VOICE] = $this->causative_aorist_infinitive_passive;							// 受動不定詞

		// 完了形分詞
		$conjugation["participle"][Commons::PERFECT_ASPECT][Commons::ACTIVE_VOICE] = $this->get_participle($this->causative_perfect_participle_active);		// 能動分詞
		$conjugation["participle"][Commons::PERFECT_ASPECT][Commons::MIDDLE_VOICE] = $this->get_participle($this->causative_perfect_participle_middle);		// 中受動分詞
		$conjugation["participle"][Commons::PERFECT_ASPECT][Commons::PASSIVE_VOICE] = $this->get_participle($this->causative_perfect_participle_middle);	// 中受動分詞
		$conjugation["infinitive"][Commons::PERFECT_ASPECT][Commons::ACTIVE_VOICE] = $this->causative_perfect_infinitive_active;							// 能動不定詞
		$conjugation["infinitive"][Commons::PERFECT_ASPECT][Commons::MIDDLE_VOICE] = $this->causative_perfect_infinitive_middle;							// 中動不定詞
		$conjugation["infinitive"][Commons::PERFECT_ASPECT][Commons::PASSIVE_VOICE] = $this->causative_perfect_infinitive_middle;							// 中動不定詞

		// 未来分詞
		$conjugation["participle"][Commons::FUTURE_TENSE][Commons::ACTIVE_VOICE] = $this->get_participle($this->causative_future_participle_active);		// 能動分詞
		$conjugation["participle"][Commons::FUTURE_TENSE][Commons::MIDDLE_VOICE] = $this->get_participle($this->causative_future_participle_middle);		// 中動分詞
		$conjugation["participle"][Commons::FUTURE_TENSE][Commons::PASSIVE_VOICE] = $this->get_participle($this->causative_future_participle_passive);		// 受動分詞
		$conjugation["infinitive"][Commons::FUTURE_TENSE][Commons::ACTIVE_VOICE] = $this->causative_future_infinitive_active;								// 能動不定詞
		$conjugation["infinitive"][Commons::FUTURE_TENSE][Commons::MIDDLE_VOICE] = $this->causative_future_infinitive_middle;								// 中動不定詞
		$conjugation["infinitive"][Commons::FUTURE_TENSE][Commons::PASSIVE_VOICE] = $this->causative_future_infinitive_passive;								// 受動不定詞

		// 結果を返す。
		return $conjugation;
	}

	// 強意動詞の活用を作成する。
	protected function get_intensive_verb_conjugation(){

		// 配列を作成
		$aspect_array = array(Commons::PRESENT_ASPECT, Commons::START_VERB, Commons::AORIST_ASPECT, Commons::PERFECT_ASPECT, Commons::FUTURE_TENSE);			// 相
		$voice_array = array(Commons::ACTIVE_VOICE, Commons::MEDIOPASSIVE_VOICE, Commons::PASSIVE_VOICE);								// 態
		$tense_mood_array = array(Commons::PRESENT_TENSE, Commons::PAST_TENSE, Commons::SUBJUNCTIVE, Commons::OPTATIVE, Commons::IMPERATIVE);	//時制と法
		$person_array = array("1sg", "2sg", "3sg", "2du", "3du", "1pl", "2pl", "3pl");														// 人称

		// 初期化
		$conjugation = array();
		// 全ての法
		foreach ($aspect_array as $aspect){	
			// 全ての態			
			foreach ($voice_array as $voice){
				// 全ての法			
				foreach ($tense_mood_array as $tense_mood){
					// 全ての人称			
					foreach ($person_array as $person){
						// 態と人称で場合分けする。
						if($aspect == Commons::AORIST_ASPECT && $tense_mood == Commons::PRESENT_TENSE){
							// アオリストの現在時制は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";
						} else if($aspect == Commons::FUTURE_TENSE && ($tense_mood != Commons::PRESENT_TENSE && $tense_mood != Commons::OPTATIVE)){
							// 現在形・希求法以外のの時制や法は存在しないため、ハイフンを入れる。
							$conjugation[$aspect][$voice][$tense_mood][$person] = "-";								
						} else {
							// 態・時制・法・人称に応じて多次元配列を作成		
							$conjugation[$aspect][$voice][$tense_mood][$person] = $this->get_koine_intensive_verb($person, $voice, $tense_mood, $aspect);	
						}					
					}
				}

			}
		}
		// 分詞を入れる。
		// 現在分詞・不定詞
		$conjugation["participle"][Commons::PRESENT_ASPECT][Commons::ACTIVE_VOICE] = $this->get_participle($this->intensive_present_participle_active);			// 能動分詞
		$conjugation["participle"][Commons::PRESENT_ASPECT][Commons::MIDDLE_VOICE] = $this->get_participle($this->intensive_present_participle_middle);			// 中受動分詞
		$conjugation["participle"][Commons::PRESENT_ASPECT][Commons::PASSIVE_VOICE] = $this->get_participle($this->intensive_present_participle_middle);		// 中受動分詞
		$conjugation["infinitive"][Commons::PRESENT_ASPECT][Commons::ACTIVE_VOICE] = $this->intensive_present_infinitive_active;								// 能動不定詞
		$conjugation["infinitive"][Commons::PRESENT_ASPECT][Commons::MIDDLE_VOICE] = $this->intensive_present_infinitive_middle;								// 中動不定詞
		$conjugation["infinitive"][Commons::PRESENT_ASPECT][Commons::PASSIVE_VOICE] = $this->intensive_present_infinitive_middle;								// 中動不定詞

		// 始動分詞・不定詞
		$conjugation["participle"][Commons::START_VERB][Commons::ACTIVE_VOICE] = $this->get_participle($this->intensive_inchoative_participle_active);		// 能動分詞
		$conjugation["participle"][Commons::START_VERB][Commons::MIDDLE_VOICE] = $this->get_participle($this->intensive_inchoative_participle_middle);		// 中受動分詞
		$conjugation["participle"][Commons::START_VERB][Commons::PASSIVE_VOICE] = $this->get_participle($this->intensive_inchoative_participle_middle);		// 中受動分詞
		$conjugation["infinitive"][Commons::START_VERB][Commons::ACTIVE_VOICE] = $this->intensive_inchoative_infinitive_active;								// 能動不定詞
		$conjugation["infinitive"][Commons::START_VERB][Commons::MIDDLE_VOICE] = $this->intensive_inchoative_infinitive_middle;								// 中動不定詞
		$conjugation["infinitive"][Commons::START_VERB][Commons::PASSIVE_VOICE] = $this->intensive_inchoative_infinitive_middle;							// 中動不定詞

		// 完了体分詞
		$conjugation["participle"][Commons::AORIST_ASPECT][Commons::ACTIVE_VOICE] = $this->get_participle($this->intensive_aorist_participle_active);		// 能動分詞
		$conjugation["participle"][Commons::AORIST_ASPECT][Commons::MIDDLE_VOICE] = $this->get_participle($this->intensive_aorist_participle_middle);		// 中動分詞
		$conjugation["participle"][Commons::AORIST_ASPECT][Commons::PASSIVE_VOICE] = $this->get_participle($this->intensive_aorist_participle_passive);		// 受動分詞
		$conjugation["infinitive"][Commons::AORIST_ASPECT][Commons::ACTIVE_VOICE] = $this->intensive_aorist_infinitive_active;								// 能動不定詞
		$conjugation["infinitive"][Commons::AORIST_ASPECT][Commons::MIDDLE_VOICE] = $this->intensive_aorist_infinitive_middle;								// 中動不定詞
		$conjugation["infinitive"][Commons::AORIST_ASPECT][Commons::PASSIVE_VOICE] = $this->intensive_aorist_infinitive_passive;							// 受動不定詞

		// 完了形分詞
		$conjugation["participle"][Commons::PERFECT_ASPECT][Commons::ACTIVE_VOICE] = $this->get_participle($this->intensive_perfect_participle_active);		// 能動分詞
		$conjugation["participle"][Commons::PERFECT_ASPECT][Commons::MIDDLE_VOICE] = $this->get_participle($this->intensive_perfect_participle_middle);		// 中受動分詞
		$conjugation["participle"][Commons::PERFECT_ASPECT][Commons::PASSIVE_VOICE] = $this->get_participle($this->intensive_perfect_participle_middle);	// 中受動分詞
		$conjugation["infinitive"][Commons::PERFECT_ASPECT][Commons::ACTIVE_VOICE] = $this->intensive_perfect_infinitive_active;							// 能動不定詞
		$conjugation["infinitive"][Commons::PERFECT_ASPECT][Commons::MIDDLE_VOICE] = $this->intensive_perfect_infinitive_middle;							// 中動不定詞
		$conjugation["infinitive"][Commons::PERFECT_ASPECT][Commons::PASSIVE_VOICE] = $this->intensive_perfect_infinitive_middle;							// 中動不定詞

		// 未来分詞
		$conjugation["participle"][Commons::FUTURE_TENSE][Commons::ACTIVE_VOICE] = $this->get_participle($this->intensive_future_participle_active);		// 能動分詞
		$conjugation["participle"][Commons::FUTURE_TENSE][Commons::MIDDLE_VOICE] = $this->get_participle($this->intensive_future_participle_middle);		// 中動分詞
		$conjugation["participle"][Commons::FUTURE_TENSE][Commons::PASSIVE_VOICE] = $this->get_participle($this->intensive_future_participle_passive);		// 受動分詞
		$conjugation["infinitive"][Commons::FUTURE_TENSE][Commons::ACTIVE_VOICE] = $this->intensive_future_infinitive_active;								// 能動不定詞
		$conjugation["infinitive"][Commons::FUTURE_TENSE][Commons::MIDDLE_VOICE] = $this->intensive_future_infinitive_middle;								// 中動不定詞
		$conjugation["infinitive"][Commons::FUTURE_TENSE][Commons::PASSIVE_VOICE] = $this->intensive_future_infinitive_passive;								// 受動不定詞

		// 結果を返す。
		return $conjugation;
	}

	// 活用表を取得する。
	public function get_chart(){

		// 初期化
		$conjugation = array();
		// タイトル情報を挿入
		$conjugation["title"] = $this->get_title($this->add_stem.$this->get_dic_stem());
		// 辞書見出しを入れる。
		$conjugation["dic_title"] = $this->get_dic_stem();
		// 種別を入れる。
		$conjugation["category"] = "動詞";
		// 活用種別
		$conjugation["type"] = $this->verb_type;	

		//echo date("H:i:s") . "." . substr(explode(".", (microtime(true) . ""))[1], 0, 3)."<br>";
		// 一次動詞
		$conjugation["primary"] = $this->get_primary_verb_conjugation(false);
		//echo date("H:i:s") . "." . substr(explode(".", (microtime(true) . ""))[1], 0, 3)."<br>";
		// 使役動詞
		$conjugation[Commons::MAKE_VERB] = $this->get_causative_verb_conjugation(false);
		//echo date("H:i:s") . "." . substr(explode(".", (microtime(true) . ""))[1], 0, 3)."<br>";
		// 強意動詞
		$conjugation[Commons::INTENSE_VERB] = $this->get_intensive_verb_conjugation(false);
		//echo date("H:i:s") . "." . substr(explode(".", (microtime(true) . ""))[1], 0, 3)."<br>";

		// 結果を返す。
		return $conjugation;
	}

	// 辞書形を取得
	public function get_dic_stem(){
		return $this->dictionary_stem;
	}

}

?>