<?php
header('Content-Type: text/html; charset=UTF-8');

class Polish_Common extends Common_IE{

	public const DB_NOUN = "noun_polish";				// 名詞データベース名
	public const DB_ADJECTIVE = "adjective_polish";	// 形容詞データベース名
	public const DB_VERB = "verb_polish";				// 動詞データベース名
	public const DB_ADVERB = "adverb_polish";			// 副詞データベース名		

	// 名詞・形容詞情報取得
	public static function get_wordstem_from_DB($dic_stem, $table){
		// 英文字以外は考慮しない
		if(!ctype_alpha($dic_stem)){
			return null;
		}
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT `dictionary_stem` FROM `".$table."` WHERE `dictionary_stem` = '".$dic_stem."'";
		// SQLを実行
		$stmt = $db_host->query($query);
		// 連想配列に整形
		$table_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// 配列を宣言
		$new_table_data = array();
		// 結果がある場合は
		if($table_data){
			// 新しい配列に詰め替え
			foreach ($table_data as $row_data ) {
				array_push($new_table_data, $row_data["dictionary_stem"]);
			}
		} else {
			// 固有語の場合は何も返さない。
			return null;
		}
		
		//結果を返す。
		return $new_table_data;
	}
	
	// 名詞・形容詞の訳語を取得
	public static function get_dictionary_stem_by_japanese($japanese_translation, $table, $gender = ""){	
		// 英数字は考慮しない
		if(ctype_alnum($japanese_translation)){
			// 何も返さない。
			return null;
		}
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT `dictionary_stem` FROM `".$table."` WHERE";
		// 検索条件に*を含む場合は
		if(strpos($japanese_translation, Commons::$LIKE_MARK)){
			$query = $query." `japanese_translation` LIKE '%".str_replace(Commons::$LIKE_MARK, "", $japanese_translation)."%'";
		} else {
			// それ以外は
			$query = $query." ( `japanese_translation` LIKE '%、".$japanese_translation."、%' OR 
			`japanese_translation` LIKE '".$japanese_translation."、%' OR 
			`japanese_translation` LIKE '%、".$japanese_translation."' OR 
			`japanese_translation` = '".$japanese_translation."')";
		}

		// 名詞の場合で性別の指定がある場合は追加する。
		if($table == Polish_Common::DB_NOUN && $gender != ""){
			$query = $query."AND `gender` LIKE '%".$gender."%'";
		}
		// SQLを実行
		$stmt = $db_host->query($query);
		// 連想配列に整形
		$table_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// 配列を宣言
		$new_table_data = array();		
		// 結果がある場合は
		if($table_data){
			// 新しい配列に詰め替え
			foreach ($table_data as $row_data ) {
				//検索結果を追加
				array_push($new_table_data, $row_data["dictionary_stem"]);
			}
		} else {
			// 何も返さない。
			return null;
		}
		
		//結果を返す。
		return $new_table_data;
	}

	// 英語で名詞・形容詞の訳語を取得
	public static function get_dictionary_stem_by_english($english_translation, $table, $gender = ""){
		// 英数字以外は考慮しない
		if(!ctype_alnum($english_translation)){
			// 何も返さない。
			return null;
		}
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT `dictionary_stem` FROM `".$table."` WHERE";
		// 検索条件に*を含む場合は
		if(strpos($english_translation, Commons::$LIKE_MARK)){
			$query = $query." `english_translation` LIKE '%".str_replace(Commons::$LIKE_MARK, "", $english_translation)."%'";
		} else {
			// それ以外は
			$query = $query." ( `english_translation` LIKE '%,".$english_translation.",%' OR 
			`english_translation` LIKE '".$english_translation.",%' OR 
			`english_translation` LIKE '%,".$english_translation."' OR 
			`english_translation` = '".$english_translation."')";
		}

		// 名詞の場合で性別の指定がある場合は追加する。
		if($table == Polish_Common::DB_NOUN && $gender != ""){
			$query = $query."AND `gender` LIKE '%".$gender."%'";
		}
		// SQLを実行
		$stmt = $db_host->query($query);
		// 連想配列に整形
		$table_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// 配列を宣言
		$new_table_data = array();
		// 結果がある場合は
		if($table_data){
			// 新しい配列に詰め替え
			foreach ($table_data as $row_data ) {
				//検索結果を追加
				array_push($new_table_data, $row_data["dictionary_stem"]);
			}
		} else {
			// 何も返さない。
			return null;
		}
		
		//結果を返す。
		return $new_table_data;
	}	

	// 名詞・形容詞の語幹を取得
	public static function get_polish_strong_stem($japanese_translation, $table, $gender = ""){
		// 英数字は考慮しない
		if(ctype_alnum($japanese_translation)){
			$new_database_info = array();
			array_push($new_database_info, $japanese_translation);
			return $new_database_info;
		}
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT `strong_stem`  FROM `".$table."` WHERE (
				 `japanese_translation` LIKE '%、".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '%、".$japanese_translation."' OR 
				 `japanese_translation` = '".$japanese_translation."')";

		// 名詞の場合で性別の指定がある場合は追加する。
		if($table == Polish_Common::DB_NOUN && $gender != ""){
			$query = $query."AND `gender` LIKE '%".$gender."%'";
		}
		// SQLを実行
		$stmt = $db_host->query($query);
		// 連想配列に整形
		$table_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// 配列を宣言
		$new_table_data = array();
		// 結果がある場合は
		if($table_data){
			// 新しい配列に詰め替え
			foreach ($table_data as $row_data ) {
				array_push($new_table_data, substr($row_data["strong_stem"], 0, -1));
			}
		} else {
			// 何も返さない。
			return null;
		}
		
		//結果を返す。
		return $new_table_data;
	}

	// 動詞の情報を取得する。
	public static function get_verb_by_japanese($japanese_translation){
		// 英数字は考慮しない
		if(ctype_alnum($japanese_translation)){
			return null;
		}
		//DBに接続
		$db_host = set_DB_session();

		// SQLを作成 
		$query = "SELECT * FROM `".Polish_Common::DB_VERB."` WHERE ";
		// 検索条件に*を含む場合は
		if(strpos($japanese_translation, Commons::$LIKE_MARK)){
			$query = $query." `japanese_translation` LIKE '%".str_replace(Commons::$LIKE_MARK, "", $japanese_translation)."%'";
		} else {
			// それ以外は
			$query = $query." (
				`japanese_translation` LIKE '%、".$japanese_translation."、%' OR 
				`japanese_translation` LIKE '".$japanese_translation."、%' OR 
				`japanese_translation` LIKE '%、".$japanese_translation."' OR 
				`japanese_translation` = '".$japanese_translation."')";
		}
		// SQLを実行
		$stmt = $db_host->query($query);
		// 連想配列に整形
		$table_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// 配列を宣言
		$new_table_data = array();
		// 結果がある場合は
		if($table_data){
			// 新しい配列に詰め替え
			foreach ($table_data as $row_data ) {
				// 動詞の語幹格納配列
				$verb_stem_array = array();
				$verb_stem_array["infinitive_stem"] = $row_data["infinitive_stem"];
				$verb_stem_array["verb_type"] = $row_data["verb_type"];							
				array_push($new_table_data, $verb_stem_array);
			}
		} else {
			return null;
		}

		//結果を返す。
		return $new_table_data;
	}

	// 動詞の情報を取得する。
	public static function get_verb_by_english($english_translation){	
		//DBに接続
		$db_host = set_DB_session();

		// SQLを作成 
		$query = "SELECT * FROM `".Polish_Common::DB_VERB."` WHERE ";
		// 検索条件に*を含む場合は
		if(strpos($english_translation, Commons::$LIKE_MARK)){
			$query = $query." `english_translation` LIKE '%".str_replace(Commons::$LIKE_MARK, "", $english_translation)."%'";
		} else {
			// それ以外は
			$query = $query." ( `english_translation` LIKE '%,".$english_translation.",%' OR 
			`english_translation` LIKE '".$english_translation.",%' OR 
			`english_translation` LIKE '%,".$english_translation."' OR 
			`english_translation` = '".$english_translation."')";
		}
		// SQLを実行
		$stmt = $db_host->query($query);
		// 連想配列に整形
		$table_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// 配列を宣言
		$new_table_data = array();
		// 結果がある場合は
		if($table_data){
			// 新しい配列に詰め替え
			foreach ($table_data as $row_data ) {
				// 動詞の語幹格納配列
				$verb_stem_array = array();
				$verb_stem_array["present_stem"] = $row_data["present_stem"];
				$verb_stem_array["infinitive_stem"] = $row_data["infinitive_stem"];
				$verb_stem_array["perfect_stem"] = $row_data["perfect_stem"];
				$verb_stem_array["perfect_participle"] = $row_data["perfect_participle"];
				$verb_stem_array["verb_type"] = $row_data["verb_type"];							
				array_push($new_table_data, $verb_stem_array);
			}
		} else {
			return null;
		}

		//結果を返す。
		return $new_table_data;
	}

	// 動詞の情報を取得する。
	public static function get_verb_from_DB($dictionary_stem){	
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `".Polish_Common::DB_VERB."` WHERE `dictionary_stem` = '".$dictionary_stem."'";
		// SQLを実行
		$stmt = $db_host->query($query);
		// 連想配列に整形
		$row_data = $stmt->fetchAll(PDO::FETCH_BOTH);
		// 結果がある場合は
		if($row_data){
			//結果を返す。			
			return $row_data;				
		} else {
			return null;
		}
	}

	// 名詞・形容詞起源動詞を取得
	public static function get_polish_denomitive_verb($japanese_translation, $table, $gender = ""){
		// 英数字は考慮しない
		if(ctype_alnum($japanese_translation)){
			// 何も返さない。
			return null;
		}
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT concat(REPLACE(`strong_stem`,'-',''), 'ować') as `strong_stem`  FROM `".$table."` WHERE (
				 `japanese_translation` LIKE '%、".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '%、".$japanese_translation."' OR 
				 `japanese_translation` = '".$japanese_translation."')";

		// 名詞の場合で性別の指定がある場合は追加する。
		if($table == Polish_Common::DB_NOUN && $gender != ""){
			$query = $query."AND `gender` LIKE '%".$gender."%'";
		}

		// 動詞の条件と被らないようにする。
		$query = $query." AND NOT EXISTS(
							SELECT * FROM `".Polish_Common::DB_VERB."`
							WHERE `".Polish_Common::DB_VERB."`.`dictionary_stem`  = concat(REPLACE(`".$table."`.`strong_stem`,'-',''), 'ować') 
						  )";

		// SQLを作成 
		$query = $query." UNION SELECT
							`".Polish_Common::DB_VERB."`.`dictionary_stem` as `strong_stem` 
   						  FROM `".$table."`
   						  LEFT JOIN  `".Polish_Common::DB_VERB."`
   					      ON `".Polish_Common::DB_VERB."`.`dictionary_stem` = concat(REPLACE( `".$table."`.`strong_stem`,'-',''), 'ować')
   						  WHERE ( 
							`".$table."`. `japanese_translation` LIKE '%、".$japanese_translation."、%' OR
							`".$table."`.`japanese_translation` LIKE '".$japanese_translation."、%' OR
							`".$table."`.`japanese_translation` LIKE '%、".$japanese_translation."' OR
							`".$table."`.`japanese_translation` = '".$japanese_translation."')
   						  AND 
							 `".Polish_Common::DB_VERB."`.`dictionary_stem` is not null";

		// SQLを作成 
		$query = $query." UNION SELECT concat(REPLACE(`strong_stem`,'-',''), 'ać') as `strong_stem`  FROM `".$table."` WHERE (
				 `japanese_translation` LIKE '%、".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '%、".$japanese_translation."' OR 
				 `japanese_translation` = '".$japanese_translation."')";

		// 名詞の場合で性別の指定がある場合は追加する。
		if($table == Polish_Common::DB_NOUN && $gender != ""){
			$query = $query."AND `gender` LIKE '%".$gender."%'";
		}

		// 動詞の条件と被らないようにする。
		$query = $query." AND NOT EXISTS(
							SELECT * FROM `".Polish_Common::DB_VERB."`
							WHERE `".Polish_Common::DB_VERB."`.`dictionary_stem`  = concat(REPLACE(`".$table."`.`strong_stem`,'-',''), 'ać') 
						  )";

		// SQLを作成 
		$query = $query." UNION SELECT
							`".Polish_Common::DB_VERB."`.`dictionary_stem` as `strong_stem` 
   						  FROM `".$table."`
   						  LEFT JOIN  `".Polish_Common::DB_VERB."`
   					      ON `".Polish_Common::DB_VERB."`.`dictionary_stem` = concat(REPLACE( `".$table."`.`strong_stem`,'-',''), 'ać')
   						  WHERE ( 
							`".$table."`. `japanese_translation` LIKE '%、".$japanese_translation."、%' OR
							`".$table."`.`japanese_translation` LIKE '".$japanese_translation."、%' OR
							`".$table."`.`japanese_translation` LIKE '%、".$japanese_translation."' OR
							`".$table."`.`japanese_translation` = '".$japanese_translation."')
   						  AND 
							 `".Polish_Common::DB_VERB."`.`dictionary_stem` is not null";
							 
		// SQLを作成 
		$query = $query." UNION SELECT concat(REPLACE(`strong_stem`,'-',''), 'nąć') as `strong_stem`  FROM `".$table."` WHERE (
				 `japanese_translation` LIKE '%、".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '%、".$japanese_translation."' OR 
				 `japanese_translation` = '".$japanese_translation."')";

		// 名詞の場合で性別の指定がある場合は追加する。
		if($table == Polish_Common::DB_NOUN && $gender != ""){
			$query = $query."AND `gender` LIKE '%".$gender."%'";
		}

		// 動詞の条件と被らないようにする。
		$query = $query." AND NOT EXISTS(
							SELECT * FROM `".Polish_Common::DB_VERB."`
							WHERE `".Polish_Common::DB_VERB."`.`dictionary_stem`  = concat(REPLACE(`".$table."`.`strong_stem`,'-',''), 'nąć') 
						  )";

		// SQLを作成 
		$query = $query." UNION SELECT
							`".Polish_Common::DB_VERB."`.`dictionary_stem` as `strong_stem` 
   						  FROM `".$table."`
   						  LEFT JOIN  `".Polish_Common::DB_VERB."`
   					      ON `".Polish_Common::DB_VERB."`.`dictionary_stem` = concat(REPLACE( `".$table."`.`strong_stem`,'-',''), 'nąć')
   						  WHERE ( 
							`".$table."`. `japanese_translation` LIKE '%、".$japanese_translation."、%' OR
							`".$table."`.`japanese_translation` LIKE '".$japanese_translation."、%' OR
							`".$table."`.`japanese_translation` LIKE '%、".$japanese_translation."' OR
							`".$table."`.`japanese_translation` = '".$japanese_translation."')
   						  AND 
							 `".Polish_Common::DB_VERB."`.`dictionary_stem` is not null;";	


		// SQLを実行
		$stmt = $db_host->query($query);
		// 連想配列に整形
		$table_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// 配列を宣言
		$new_table_data = array();
		// 結果がある場合は
		if($table_data){
			// 新しい配列に詰め替え
			foreach ($table_data as $row_data ) {
				array_push($new_table_data, $row_data["strong_stem"]);
			}
		} else {
			// 何も返さない。
			return null;
		}
		
		//結果を返す。
		return $new_table_data;
	}

	// 形容詞起源動詞を取得
	public static function get_polish_stative_verb($japanese_translation){
		// 英数字は考慮しない
		if(ctype_alnum($japanese_translation)){
			// 何も返さない。
			return null;
		}
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT concat(REPLACE(`strong_stem`,'-',''), 'eć') as `strong_stem`  FROM `".Polish_Common::DB_ADJECTIVE."` WHERE (
				 `japanese_translation` LIKE '%、".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '%、".$japanese_translation."' OR 
				 `japanese_translation` = '".$japanese_translation."')";

		// 動詞の条件と被らないようにする。
		$query = $query." AND NOT EXISTS(
							SELECT * FROM `".Polish_Common::DB_VERB."`
							WHERE `".Polish_Common::DB_VERB."`.`dictionary_stem`  = concat(REPLACE(`".Polish_Common::DB_ADJECTIVE."`.`strong_stem`,'-',''), 'eć') 
						  )";

		$query = $query." UNION SELECT concat(REPLACE(`strong_stem`,'-',''), 'yć') as `strong_stem`  FROM `".Polish_Common::DB_ADJECTIVE."` WHERE (
				 `japanese_translation` LIKE '%、".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '%、".$japanese_translation."' OR 
				 `japanese_translation` = '".$japanese_translation."')";

		// 動詞の条件と被らないようにする。
		$query = $query." AND NOT EXISTS(
							SELECT * FROM `".Polish_Common::DB_VERB."`
							WHERE `".Polish_Common::DB_VERB."`.`dictionary_stem`  = concat(REPLACE(`".Polish_Common::DB_ADJECTIVE."`.`strong_stem`,'-',''), 'yć') 
						  )";

		// SQLを作成 
		$query = $query." UNION SELECT
							`".Polish_Common::DB_VERB."`.`dictionary_stem` as `strong_stem` 
   						  FROM `".Polish_Common::DB_ADJECTIVE."`
   						  LEFT JOIN  `".Polish_Common::DB_VERB."`
   					      ON `".Polish_Common::DB_VERB."`.`dictionary_stem` = concat(REPLACE( `".Polish_Common::DB_ADJECTIVE."`.`strong_stem`,'-',''), 'eć')
   						  WHERE ( 
							`".Polish_Common::DB_ADJECTIVE."`. `japanese_translation` LIKE '%、".$japanese_translation."、%' OR
							`".Polish_Common::DB_ADJECTIVE."`.`japanese_translation` LIKE '".$japanese_translation."、%' OR
							`".Polish_Common::DB_ADJECTIVE."`.`japanese_translation` LIKE '%、".$japanese_translation."' OR
							`".Polish_Common::DB_ADJECTIVE."`.`japanese_translation` = '".$japanese_translation."')
   						  AND 
							 `".Polish_Common::DB_VERB."`.`dictionary_stem` is not null;";
		// SQLを実行
		$stmt = $db_host->query($query);
		// 連想配列に整形
		$table_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// 配列を宣言
		$new_table_data = array();
		// 結果がある場合は
		if($table_data){
			// 新しい配列に詰め替え
			foreach ($table_data as $row_data ) {
				// 動詞を宣言
				$verb_stem = $row_data["strong_stem"];
				// 置換処理を実行
				$verb_stem = preg_replace("/oweć$/", "owieć", $verb_stem);
				$verb_stem = preg_replace("/neć$/", "nieć", $verb_stem);
				$verb_stem = preg_replace("/deć$/", "dzieć", $verb_stem);
				$verb_stem = preg_replace("/skeć$/", "szczeć", $verb_stem);
				// 動詞語幹を配列に入れる。
				array_push($new_table_data, $row_data["strong_stem"]);
			}
		} else {
			// 何も返さない。
			return null;
		}
		
		//結果を返す。
		return $new_table_data;
	}

	// ポーランド語の動詞を取得
	public static function get_verb_conjugation($polish_verb){

		// 配列を初期化
		$conjugations = array();
		// 活用種別で分ける。
		if($polish_verb["verb_type"] == "5byc"){
		    // 読み込み
		    $verb_data = new Polish_Verb_Byc();
        	$verb_data->add_stem($polish_verb["infinitive_stem"]);
		    // 活用表生成、配列に格納
		    $conjugations[$verb_data->get_infinitive()] = $verb_data->get_chart();
		} else if($polish_verb["verb_type"] == "5isc"){
		    // 読み込み
		    $verb_data = new Polish_Verb_Isc();
        	$verb_data->add_stem($polish_verb["infinitive_stem"]);
		    // 活用表生成、配列に格納
		    $conjugations[$verb_data->get_infinitive()] = $verb_data->get_chart();
		} else if($polish_verb["verb_type"] == "5brac"){
		    // 読み込み
		    $verb_data = new Polish_Verb_Brac();
        	$verb_data->add_stem($polish_verb["infinitive_stem"]);
		    // 活用表生成、配列に格納
		    $conjugations[$verb_data->get_infinitive()] = $verb_data->get_chart();
		} else if($polish_verb["verb_type"] == "5miec"){
		    // 読み込み
		    $verb_data = new Polish_Verb_Miec();
        	$verb_data->add_stem($polish_verb["infinitive_stem"]);
		    // 活用表生成、配列に格納
		    $conjugations[$verb_data->get_infinitive()] = $verb_data->get_chart();
		} else if($polish_verb["verb_type"] == "3root"){
		    // 読み込み
		    $verb_data = new Polish_Verb_Root($polish_verb["infinitive_stem"]);
		    // 活用表生成、配列に格納
		    $conjugations[$verb_data->get_infinitive()] = $verb_data->get_chart();
		} else if($polish_verb["verb_type"] == "3root2"){
		    // 読み込み
		    $verb_data = new Polish_Verb_Root2($polish_verb["infinitive_stem"]);
		    // 活用表生成、配列に格納
		    $conjugations[$verb_data->get_infinitive()] = $verb_data->get_chart();
		} else if($polish_verb["verb_type"] == "3root3"){
		    // 読み込み
		    $verb_data = new Polish_Verb_Root3($polish_verb["infinitive_stem"]);
		    // 活用表生成、配列に格納
		    $conjugations[$verb_data->get_infinitive()] = $verb_data->get_chart();
      	} else {
		    // 読み込み
		    $verb_data = new Polish_Verb($polish_verb["infinitive_stem"]);
		    // 活用表生成、配列に格納
		    $conjugations[$verb_data->get_infinitive()] = $verb_data->get_chart();     
      	}

		// 結果を返す。	  
		return $conjugations;
	}

	// ランダムな名詞を取得
	public static function get_random_noun($gender = "", $noun_type = ""){
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `".Polish_Common::DB_NOUN."` WHERE `location_name` != '1'";
		// 名詞の場合で性別の指定がある場合は追加する。
		if($gender != ""){
			$query = $query."AND `gender` LIKE '%".$gender."%'";
		}
		// 活用種別
		if($noun_type != ""){
			$query = $query."AND `noun_type` LIKE '%".$noun_type."%'";
		} else {
			$query = $query."AND `noun_type` != '0'";			
		}

		// ランダムで1単語
		$query = $query."ORDER BY RAND() LIMIT 1";

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

	// ランダムな形容詞を取得
	public static function get_random_adjective($adjective_type = ""){
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `".Polish_Common::DB_ADJECTIVE."` WHERE `location_name` != '1'";
		// 活用種別
		if($adjective_type != ""){
			$query = $query."AND `adjective_type` LIKE '%".$adjective_type."%'";
		}

		// ランダムで1単語
		$query = $query."ORDER BY RAND() LIMIT 1";

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
	
	// ランダムな動詞を取得
	public static function get_random_verb($verb_type = "", $verb_aspect = ""){
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `".Polish_Common::DB_VERB."` WHERE `deponent_personal` != '1'";
		// 活用種別
		if($verb_type != ""){
			$query = $query."AND `verb_type` LIKE '%".$verb_type."%'";
		} else {
			$query = $query."AND `verb_type` LIKE '%".$verb_type."%'";			
		}
		// 動詞の体
		if($verb_aspect != ""){
			$query = $query."AND `verb_aspect` LIKE '%".$verb_aspect."%'";
		} else {
			$query = $query."AND `verb_aspect` LIKE '%".$verb_aspect."%'";			
		}

		// ランダムで1単語
		$query = $query."ORDER BY RAND() LIMIT 1";

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
	
	// 形容詞の活用表(タイトル)を作る。
	public static function make_adjective_column_chart($title = ""){

		// タイトルを入れて表を返す。
		return '
        <thead>
          <tr>
            <th scope="row" class="text-center" style="width:10%">'.$title.'</th>
            <th scope="col" class="text-center" colspan="3" style="width:30%">単数(Pojedyncza)</th>
            <th scope="col" class="table-archaic text-center" colspan="3" style="width:30%">双数(Podwójna)</th>            
            <th scope="col" class="text-center" colspan="3" style="width:30%">複数(Mnoga)</th>
          </tr>
          <tr>
            <th scope="row" class="text-center" style="width:10%">格(Przypadek)</th>
            <th scope="col" class="text-center" style="width:10%">男性(Męski)</th>
            <th scope="col" class="text-center" style="width:10%">女性(Żeński)</th>
            <th scope="col" class="text-center" style="width:10%">中性(Nijaki)</th>
            <th scope="col" class="table-archaic text-center" style="width:10%">男性(Męski)</th>
            <th scope="col" class="table-archaic text-center" style="width:10%">女性(Żeński)</th>
            <th scope="col" class="table-archaic text-center" style="width:10%">中性(Nijaki)</th>
            <th scope="col" class="text-center" style="width:10%">男性(Męski)</th>
            <th scope="col" class="text-center" style="width:10%">女性(Żeński)</th>
            <th scope="col" class="text-center" style="width:10%">中性(Nijaki)</th>
          </tr>
        </thead>';
	}

	// 形容詞の活用表を作る。
	public static function make_adjective_chart(){

		// 表を返す。
		return '
			<tr><th class="text-center" scope="row" colspan="10">原級</th></tr>		
			<tr><th class="text-center" scope="row">主格(Mianownik)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">属格(Dopełniacz)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">与格(Celownik)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">対格(Biernik)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">具格(Narzędnik)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">地格(Miejscownik)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">呼格(Wołacz)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row" colspan="10">比較級(Stopień Wyższy)</th></tr>
			<tr><th class="text-center" scope="row">主格(Mianownik)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">属格(Dopełniacz)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">与格(Celownik)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">対格(Biernik)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">具格(Narzędnik)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">地格(Miejscownik)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">呼格(Wołacz)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row" colspan="10">最上級(Najwyższy Stopień)</th></tr>
			<tr><th class="text-center" scope="row">主格(Mianownik)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">属格(Dopełniacz)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">与格(Celownik)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">対格(Biernik)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">具格(Narzędnik)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">地格(Miejscownik)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">呼格(Wołacz)</th><td></td><td></td><td></td><td class="table-archaic"></td><td class="table-archaic"></td><td class="table-archaic"></td><td></td><td></td><td></td></tr>					
			';
	}

	// 名詞の活用表(タイトル)を作る。
	public static function make_noun_column_chart(){
		// タイトルを入れて表を返す。
		return '
		<thead>
			<tr><th scope="row" class="text-center" style="width:10%">格(Przypadek)</th>
		  		<th scope="col" class="text-center" style="width:30%">単数(Pojedyncza)</th>
		  		<th scope="col" class="table-archaic text-center" style="width:30%">双数(Podwójna)</th>
		  		<th scope="col" class="text-center" style="width:30%">複数(Mnoga)</th>
			</tr>
	  	</thead>';
	}

	// 名詞の活用表を作る。
	public static function make_noun_chart(){

		// 表を返す。
		return '
		<tbody>
			<tr><th class="text-center" scope="row">主格(Mianownik)</th><td></td><td class="table-archaic"></td><td></td></tr>
			<tr><th class="text-center" scope="row">属格(Dopełniacz)</th><td></td><td class="table-archaic"></td><td></td></tr>
			<tr><th class="text-center" scope="row">与格(Celownik)</th><td></td><td class="table-archaic"></td><td></td></tr>
			<tr><th class="text-center" scope="row">対格(Biernik)</th><td></td><td class="table-archaic"></td><td></td></tr>
			<tr><th class="text-center" scope="row">具格(Narzędnik)</th><td></td><td class="table-archaic"></td><td></td></tr>
			<tr><th class="text-center" scope="row">地格(Miejscownik)</th><td></td><td class="table-archaic"></td><td></td></tr>
			<tr><th class="text-center" scope="row">呼格(Wołacz)</th><td></td><td class="table-archaic"></td><td></td></tr>
	  	</tbody>';
	}

	// 特殊文字入力ボタンを配置する。
	public static function input_special_button(){

		return '      
		<div class="d-grid gap-2 d-md-block mb-2">
        	<button class="btn btn-primary" type="button" id="button-a" value="ą">ą</button>
        	<button class="btn btn-primary" type="button" id="button-c" value="ć">ć</button>			
        	<button class="btn btn-primary" type="button" id="button-e" value="ę">ę</button>
        	<button class="btn btn-primary" type="button" id="button-l" value="ł">ł</button>
        	<button class="btn btn-primary" type="button" id="button-n" value="ń">ń</button>
        	<button class="btn btn-primary" type="button" id="button-o" value="ó">ó</button>
        	<button class="btn btn-primary" type="button" id="button-s" value="ś">ś</button> 
        	<button class="btn btn-primary" type="button" id="button-z1" value="ź">ź</button> 
        	<button class="btn btn-primary" type="button" id="button-z2" value="ż">ż</button> 			
      	</div> ';
	}

	// アルファベット判定をする。
	public static function is_alphabet_or_not($word){
		// アルファベットの場合はtrue
		if(ctype_alnum($word) || (preg_match("/[a-zA-Z]/", $word) || preg_match('(ą|ć|ę|ł|ń|ó|ś|ź|ż)',$word))){
			return true;		
		}

		// それ以外はfalse
		return false;
	}

	// 性別選択ボタンの生成
	public static function noun_gender_selection_button($all_flag = false){
		// ボタンを生成
		$button_html_code = '
		<section class="row textBox3 my-3">
		  <div class="col-md-3">
			<input type="radio" name="gender" class="btn-check" id="btn-masculine-animate" autocomplete="off" value="Masculine-Animate">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-masculine-animate">男性生物<br>(Męskoosobowe)</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="gender" class="btn-check" id="btn-masculine-inanimate" autocomplete="off" value="Masculine-Inanimate">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-masculine-inanimate">男性無生物<br>(Męskonieżywotne)</label>
		  </div>
		  <div class="col-md-2">
			<input type="radio" name="gender" class="btn-check" id="btn-femine" autocomplete="off" value="Feminine">
			<label class="btn btn-primary w-100 mb-2 fs-3" for="btn-femine">女性<br>(Żeński)</label>
		  </div>
		  <div class="col-md-2">
			<input type="radio" name="gender" class="btn-check" id="btn-neuter" autocomplete="off" value="Neuter">
			<label class="btn btn-primary w-100 mb-2 fs-3" for="btn-neuter">中性<br>(Nijaki)</label>
		  </div>';

		// 全ての選択肢を入れる場合は、ボタンを追加
		if($all_flag){
			$button_html_code = $button_html_code.
			'<div class="col-md-2">
				<input type="radio" name="gender" class="btn-check" id="btn-all-gender" autocomplete="off" value="" checked="checked">
				<label class="btn btn-primary w-100 mb-2 fs-3" for="btn-all-gender">すべて<br>(Wszystko)</label>
		  	 </div>';
		}

		// 結果を返す。
		return $button_html_code.'</section>';


	}

	// 名詞活用種別ボタンの生成
	public static function noun_declension_type_selection_button(){
		return '
		<section class="row textBox7 my-3">
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-1" autocomplete="off" value="1">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1">第一活用</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-1i" autocomplete="off" value="1i">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1i">第一活用i</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-1ia" autocomplete="off" value="1ia">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1ia">第一活用ia</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-2" autocomplete="off" value="2">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-2">子音変化名詞</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-2p" autocomplete="off" value="2p">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-2p">子音変化名詞(軟音)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-2k" autocomplete="off" value="2k">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-2k">子音変化名詞(硬音)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-2o" autocomplete="off" value="2o">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-2o">o-変化名詞</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-2e" autocomplete="off" value="2e">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-2e">e-変化名詞</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-all-declension" autocomplete="off" value="" checked="checked">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-declension">すべて</label>
          </div>
        </section>';
	}

	// 形容詞活用種別ボタンの生成
	public static function adjective_declension_type_selection_button(){
		return '
		<section class="row textBox7 my-3">
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-1-2" autocomplete="off" value="1-2">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1-2">第一・第二活用</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-1-2i" autocomplete="off" value="1-2i">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1-2i">第一・第二活用(i語幹)</label>
          </div>       
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-all-declension" autocomplete="off" value="" checked="checked">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-declension">すべて</label>
          </div>
        </section>';
	}

	// 格選択ボタンの生成
	public static function case_selection_button($all_flag = false){
		// ボタンを生成
		$button_html_code = '
		<section class="row textBox5 my-3">
		  <div class="col-md-3">
			<input type="radio" name="case" class="btn-check" id="btn-nom" autocomplete="off" value="'.Commons::NOMINATIVE.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-nom">主格(Mianownik)</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="case" class="btn-check" id="btn-gen" autocomplete="off" value="'.Commons::GENETIVE.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-gen">属格(Dopełniacz)</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="case" class="btn-check" id="btn-dat" autocomplete="off" value="'.Commons::DATIVE.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-dat">与格(Celownik)</label>
		  </div>         
		  <div class="col-md-3">
			<input type="radio" name="case" class="btn-check" id="btn-acc" autocomplete="off" value="'.Commons::ACCUSATIVE.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-acc">対格(Biernik)</label>
		  </div>         
		  <div class="col-md-3">
			<input type="radio" name="case" class="btn-check" id="btn-ins" autocomplete="off" value="'.Commons::INSTRUMENTAL.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-ins">具格(Narzędnik)</label>
		  </div>		  
		  <div class="col-md-3">
			<input type="radio" name="case" class="btn-check" id="btn-loc" autocomplete="off" value="'.Commons::LOCATIVE.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-loc">地格(Miejscownik)</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="case" class="btn-check" id="btn-voc" autocomplete="off" value="'.Commons::VOCATIVE.'">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-voc">呼格(Wołacz)</label>
		  </div>';

		// 全ての選択肢を入れる場合は、ボタンを追加
		if($all_flag){
			$button_html_code = $button_html_code.
			'<div class="col-md-3">
				<input type="radio" name="case" class="btn-check" id="btn-all-case" autocomplete="off" value="" checked="checked">
				<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-case">すべて(Wszystko)</label>
		 	 </div>';
		}

		// 結果を返す。
		return $button_html_code.'</section>';

	}

	// 動詞の活用種別ボタンの生成
	public static function verb_type_selection_button(){
		return '
		<section class="row textBox9 my-3">
          <div class="col-md-2">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb1" autocomplete="off" value="1">
            <label class="btn btn-primary w-100 mb-2 fs-3" for="btn-verb1">ać動詞</label>
          </div>
          <div class="col-md-2">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb2" autocomplete="off" value="2">
            <label class="btn btn-primary w-100 mb-2 fs-3" for="btn-verb2">eć動詞</label>
          </div>       
          <div class="col-md-2">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb3" autocomplete="off" value="3">
            <label class="btn btn-primary w-100 mb-2 fs-3" for="btn-verb3">ąć動詞</label>
          </div>
          <div class="col-md-2">
            <input type="radio" name="verb-type" class="btn-check" id="btn-3root" autocomplete="off" value="3root">
            <label class="btn btn-primary w-100 mb-2 fs-3" for="btn-3root">語根動詞1</label>
          </div>
          <div class="col-md-2">
            <input type="radio" name="verb-type" class="btn-check" id="btn-3root2" autocomplete="off" value="3root2">
            <label class="btn btn-primary w-100 mb-2 fs-3" for="btn-3root2">語根動詞2</label>
          </div>
          <div class="col-md-2">
            <input type="radio" name="verb-type" class="btn-check" id="btn-3root3" autocomplete="off" value="3root3">
            <label class="btn btn-primary w-100 mb-2 fs-3" for="btn-3root3">語根動詞3</label>
          </div>
          <div class="col-md-2">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb4" autocomplete="off" value="4">
            <label class="btn btn-primary w-100 mb-2 fs-3" for="btn-verb4">ić動詞</label>
          </div>
          <div class="col-md-2">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb4y" autocomplete="off" value="4y">
            <label class="btn btn-primary w-100 mb-2 fs-3" for="btn-verb4y">yć動詞</label>
          </div>
          <div class="col-md-2">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb-denomitive" autocomplete="off" value="denomitive">
            <label class="btn btn-primary w-100 mb-2 fs-3" for="btn-verb-denomitive">ować動詞</label>
          </div>
          <div class="col-md-2">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb-denomitive2" autocomplete="off" value="denomitive2">
            <label class="btn btn-primary w-100 mb-2 fs-3" for="btn-verb-denomitive2">uć動詞</label>
          </div>
          <div class="col-md-2">
            <input type="radio" name="verb-type" class="btn-check" id="btn-all-conjugation" autocomplete="off" value="" checked="checked">
            <label class="btn btn-primary w-100 mb-2 fs-3" for="btn-all-conjugation">すべて</label>
          </div>
        </section>';
	}
	
	// 相ボタンの生成
	public static function aspect_selection_button(){
		return '
		<section class="row textBox11 my-3">
          <div class="col-md-3">
            <input type="radio" name="aspect" class="btn-check" id="btn-aspect-present" autocomplete="off" value="'.Commons::PRESENT_ASPECT.'" onclick="click_aspect_button()">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-aspect-present">不完了体(Niedokonane)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="aspect" class="btn-check" id="btn-aspect-aorist" autocomplete="off" value="'.Commons::AORIST_ASPECT.'" onclick="click_aspect_button()">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-aspect-aorist">完了体(Dokonane)</label>
          </div>		     	  
          <div class="col-md-3">
            <input type="radio" name="aspect" class="btn-check" id="btn-all-aspect" autocomplete="off" value="" checked="checked" onclick="click_aspect_button()">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-aspect">すべて(Wszystko)</label>
          </div>
        </section>';
	}

	// 法ボタンの生成
	public static function mood_selection_button($all_flag = false){
		// ボタンを生成
		$button_html_code = '
		<section class="row textBox13 my-3">
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-tense-present" autocomplete="off" value="'.Commons::PRESENT_TENSE.'">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-tense-present">現在形(Teraźniejszy)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-tense-past" autocomplete="off" value="'.Commons::PERFECT_ASPECT.'">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-tense-past">過去形(Przeszły)</label>
          </div>		
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-future" autocomplete="off" value="'.Commons::FUTURE_TENSE.'">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-future">未来形1(Przyszły-1)</label>
          </div> 
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-future2" autocomplete="off" value="future_perfect">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-future2">未来形2(Przyszły-2)</label>
          </div> 
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-subj" autocomplete="off" value="'.Commons::SUBJUNCTIVE.'">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-subj">仮定法(Przypuszczający)</label>
          </div>	  
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-imper" autocomplete="off" value="'.Commons::IMPERATIVE.'">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-imper">命令法(Rozkazujący)</label>
          </div>';

		// 全ての選択肢を入れる場合は、ボタンを追加
		if($all_flag){
			$button_html_code = $button_html_code.
			'<div class="col-md-3">
            	<input type="radio" name="mood" class="btn-check" id="btn-all-mood" autocomplete="off" value="" checked="checked">
            	<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-mood">すべて(Wszystko)</label>
         	 </div>';
		}

		// 結果を返す。
		return $button_html_code.'</section>';

	}

	// ポーランド語の連音変化
	public static function polish_sandhi($word){

		// 変換
		$word = mb_ereg_replace("([bcfhlłmnprswz])k\b", "\\1ek", $word);
		$word = mb_ereg_replace("([dgkt])k\b", "\\1iek", $word);

		$word = mb_ereg_replace("([^y])ni\b", "\\1ń", $word);
		$word = preg_replace("/szi$/", "szy", $word);
		$word = preg_replace("/rzi$/", "rzy", $word);
		$word = preg_replace("/si$/", "s", $word);
		$word = preg_replace("/zi$/", "ź", $word);
		$word = preg_replace("/l$/", "ł", $word);				
		$word = preg_replace("/di$/", "dzi", $word);
		$word = preg_replace("/ti$/", "ci", $word);
		$word = preg_replace("/ri$/", "rzy", $word);
		$word = preg_replace("/pi$/", "py", $word);
		$word = preg_replace("/bi$/", "by", $word);
		$word = preg_replace("/chi$/", "chy", $word);

		$word = preg_replace("/be$/", "bie", $word);
		$word = preg_replace("/pe$/", "pie", $word);	
		$word = preg_replace("/me$/", "mie", $word);
		$word = preg_replace("/ne$/", "nie", $word);
		$word = preg_replace("/re$/", "rze", $word);
		$word = preg_replace("/tie$/", "cie", $word);
		$word = preg_replace("/te$/", "cie", $word);
		$word = preg_replace("/de$/", "dzie", $word);
		$word = preg_replace("/ke$/", "ce", $word);
		$word = preg_replace("/kem$/", "kiem", $word);		
		$word = preg_replace("/ge$/", "dze", $word);
		$word = preg_replace("/gie$/", "dze", $word);
		$word = preg_replace("/che$/", "sze", $word);

		$word = preg_replace("/ry$/", "rzy", $word);
		$word = preg_replace("/dy$/", "dzy", $word);
		$word = preg_replace("/ky$/", "cy", $word);
		$word = preg_replace("/gy$/", "dzy", $word);

		// 最後の音節のoは短音になる。但し単音節の単語は除く
		$word = mb_ereg_replace("(.{2})o([^aiueoąęóm])\b", "\\1ó\\2", $word);

		// 結果を返す。
		return $word;
	}

	// 検索言語コンボボックスの精製
	public static function language_select_box(){
		// ボタンを生成
		$button_html_code = '
		<section class="row textBox2 mb-3">
        	<select class="form-select" name="input_search_lang"> 
				<option value="'.Commons::NIHONGO.'">日本語(Japanese)</option>
				<option value="'.Commons::EIGO.'">英語(English)</option>
          		<option value="'.Commons::POLISH.'">ポーランド語(Polish)</option>     
			</select>
		</section>';

		// 結果を返す。
		return $button_html_code;
	}

}