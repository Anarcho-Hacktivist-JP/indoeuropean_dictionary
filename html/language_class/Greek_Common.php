<?php
header('Content-Type: text/html; charset=UTF-8');

class Koine_Common extends Common_IE{

	public const DB_NOUN = "noun_greek";				// 名詞データベース名
	public const DB_ADJECTIVE = "adjective_greek";	// 形容詞データベース名
	public const DB_VERB = "verb_greek";				// 動詞データベース名
	public const DB_ADVERB = "adverb_greek";			// 副詞データベース名		

	// 名詞・形容詞情報取得
	public static function get_wordstem_from_DB($dic_stem, $table){
		// 英文字以外は考慮しない
		if(!Koine_Common::is_alphabet_or_not($dic_stem)){
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
		if($table == Koine_Common::DB_NOUN && $gender != ""){
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
		// 英文字以外は考慮しない
		if(!Koine_Common::is_alphabet_or_not($english_translation)){
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
		if($table == Koine_Common::DB_NOUN && $gender != ""){
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
	public static function get_koine_strong_stem($japanese_translation, $table, $gender = ""){
		// 英数字は考慮しない
		if(ctype_alnum($japanese_translation)){
			// 何も返さない。
			return null;
		}
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT `stem`  FROM `".$table."` WHERE (
				 `japanese_translation` LIKE '%、".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '%、".$japanese_translation."' OR 
				 `japanese_translation` = '".$japanese_translation."')";

		// 名詞の場合で性別の指定がある場合は追加する。
		if($table == Koine_Common::DB_NOUN && $gender != ""){
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
				array_push($new_table_data, $row_data["stem"]);
			}
		} else {
			// 何も返さない。
			return null;
		}
		
		//結果を返す。
		return $new_table_data;
	}

	// 副詞を取得
	public static function get_koine_adverb($japanese_translation){
		// 英数字は考慮しない
		if(ctype_alnum($japanese_translation)){
			// 何も返さない。
			return null;
		}
		// 形容詞の検索条件変更
		$japanese_translation = mb_ereg_replace("く\b", 'い', $japanese_translation);

		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT concat(REPLACE(`strong_stem`,'-',''), 'α') as `adverb` FROM `".Koine_Common::DB_ADJECTIVE."` WHERE ";
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
		// SQLを作成 
		$query = $query." UNION SELECT concat(REPLACE(`strong_stem`,'-',''), 'ᾰ́κῐς') as `adverb` FROM `".Koine_Common::DB_ADJECTIVE."` WHERE ";
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

		// SQLを作成 
		$query = $query." UNION SELECT concat(REPLACE(`strong_stem`,'-',''), 'ως') as `adverb` FROM `".Koine_Common::DB_ADJECTIVE."` WHERE ";
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

		$query = $query." UNION SELECT `adverb` FROM `".Koine_Common::DB_ADVERB."` WHERE ";
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
				array_push($new_table_data, $row_data["adverb"]);
			}
		} else {
			// 何も返さない。
			return null;
		}
		
		//結果を返す。
		return $new_table_data;
	}

	// 接頭辞を取得
	public static function get_koine_prefix($japanese_translation){
		// 英数字は考慮しない
		if(ctype_alnum($japanese_translation)){
			$new_database_info = array();
			array_push($new_database_info, $japanese_translation);
			return $new_database_info;
		}
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT `prefix` FROM `prefix_latin` WHERE";
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
				array_push($new_table_data, mb_substr($row_data["prefix"], 0, -1));
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
		$query = "SELECT * FROM `".Koine_Common::DB_VERB."` WHERE ";
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
				$verb_stem_array["dictionary_stem"] = $row_data["dictionary_stem"];
				$verb_stem_array["present_stem"] = $row_data["present_stem"];
				$verb_stem_array["aorist_stem"] = $row_data["aorist_stem"];
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
		$query = "SELECT * FROM `".Koine_Common::DB_VERB."` WHERE ";
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
				$verb_stem_array["dictionary_stem"] = $row_data["dictionary_stem"];
				$verb_stem_array["present_stem"] = $row_data["present_stem"];
				$verb_stem_array["aorist_stem"] = $row_data["aorist_stem"];
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
		$query = "SELECT * FROM `".Koine_Common::DB_VERB."` WHERE `dictionary_stem` = '".$dictionary_stem."'";
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
	public static function get_koine_denomitive_verb($japanese_translation, $table, $gender = ""){
		// 英数字は考慮しない
		if(ctype_alnum($japanese_translation)){
			// 何も返さない。
			return null;
		}
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT concat(REPLACE(`strong_stem`,'-',''), 'ᾰ́ω') as `strong_stem`  FROM `".$table."` WHERE (
				 `japanese_translation` LIKE '%、".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '%、".$japanese_translation."' OR 
				 `japanese_translation` = '".$japanese_translation."')";

		// 名詞の場合で性別の指定がある場合は追加する。
		if($table == Koine_Common::DB_NOUN && $gender != ""){
			$query = $query."AND `gender` LIKE '%".$gender."%'";
		} 

		// 動詞の条件と被らないようにする。
		$query = $query." AND NOT EXISTS(
							SELECT * FROM `".Koine_Common::DB_VERB."`
							WHERE `".Koine_Common::DB_VERB."`.`dictionary_stem`  = concat(REPLACE(`".$table."`.`strong_stem`,'-',''), 'ᾰ́ω') 
						  )";

		// SQLを作成 
		$query = $query." UNION SELECT
							`".Koine_Common::DB_VERB."`.`dictionary_stem` as `strong_stem` 
   						  FROM `".$table."`
   						  LEFT JOIN  `".Koine_Common::DB_VERB."`
   					      ON `".Koine_Common::DB_VERB."`.`dictionary_stem` = concat(REPLACE( `".$table."`.`strong_stem`,'-',''), 'ᾰ́ω')
   						  WHERE ( 
							`".$table."`. `japanese_translation` LIKE '%、".$japanese_translation."、%' OR
							`".$table."`.`japanese_translation` LIKE '".$japanese_translation."、%' OR
							`".$table."`.`japanese_translation` LIKE '%、".$japanese_translation."' OR
							`".$table."`.`japanese_translation` = '".$japanese_translation."')
   						  AND 
							 `".Koine_Common::DB_VERB."`.`dictionary_stem` is not null;";
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
	public static function get_koine_stative_verb($japanese_translation){
		// 英数字は考慮しない
		if(ctype_alnum($japanese_translation)){
			// 何も返さない。
			return null;
		}
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT concat(REPLACE(`strong_stem`,'-',''), 'έω') as `strong_stem`  FROM `".Koine_Common::DB_ADJECTIVE."` WHERE (
				 `japanese_translation` LIKE '%、".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '".$japanese_translation."、%' OR 
				 `japanese_translation` LIKE '%、".$japanese_translation."' OR 
				 `japanese_translation` = '".$japanese_translation."')";

		// 動詞の条件と被らないようにする。
		$query = $query." AND NOT EXISTS(
							SELECT * FROM `".Koine_Common::DB_VERB."`
							WHERE `".Koine_Common::DB_VERB."`.`dictionary_stem`  = concat(REPLACE(`".Koine_Common::DB_ADJECTIVE."`.`strong_stem`,'-',''), 'έω') 
						  )";

		// SQLを作成 
		$query = $query." UNION SELECT
							`".Koine_Common::DB_VERB."`.`dictionary_stem` as `strong_stem` 
   						  FROM `".Koine_Common::DB_ADJECTIVE."`
   						  LEFT JOIN  `".Koine_Common::DB_VERB."`
   					      ON `".Koine_Common::DB_VERB."`.`dictionary_stem` = concat(REPLACE( `".Koine_Common::DB_ADJECTIVE."`.`strong_stem`,'-',''), 'έω')
   						  WHERE ( 
							`".Koine_Common::DB_ADJECTIVE."`. `japanese_translation` LIKE '%、".$japanese_translation."、%' OR
							`".Koine_Common::DB_ADJECTIVE."`.`japanese_translation` LIKE '".$japanese_translation."、%' OR
							`".Koine_Common::DB_ADJECTIVE."`.`japanese_translation` LIKE '%、".$japanese_translation."' OR
							`".Koine_Common::DB_ADJECTIVE."`.`japanese_translation` = '".$japanese_translation."')
   						  AND 
							 `".Koine_Common::DB_VERB."`.`dictionary_stem` is not null;";
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

	// ランダムな名詞を取得
	public static function get_random_noun($gender = "", $noun_type = ""){
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `".Koine_Common::DB_NOUN."` WHERE `location_name` != '1'";
		// 名詞の場合で性別の指定がある場合は追加する。
		if($gender != ""){
			$query = $query."AND `gender` LIKE '%".$gender."%'";
		}
		// 活用種別
		if($noun_type != ""){
			$query = $query."AND `noun_type` LIKE '%".$noun_type."%'";
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
		$query = "SELECT * FROM `".Koine_Common::DB_ADJECTIVE."` WHERE `location_name` != '1'";
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
	public static function get_random_verb($verb_type = ""){
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `".Koine_Common::DB_VERB."` WHERE `deponent_personal` != '1'";
		// 活用種別
		if($verb_type != ""){
			$query = $query."AND `verb_type` LIKE '%".$verb_type."%'";
		} else {
			$query = $query."AND `verb_type` LIKE '%".$verb_type."%'";			
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
	
	// ギリシア語の動詞を取得
	public static function get_verb_conjugation($koine_verb){
		// 配列を初期化
		$conjugations = array();
		// 読み込み
		$verb_data = new koine_Verb($koine_verb["dictionary_stem"]);
		// 活用表生成、配列に格納
		$conjugations[$verb_data->get_dic_stem()] = $verb_data->get_chart();
		// メモリを解放
		unset($verb_data);
		// 結果を返す。	  
		return $conjugations;
	}
	
	// 複合語の活用表を作成
	public static function make_compound_chart($input_words, $word_category, $input_word, $gender = ""){
		// 初期化
		$charts = array();				
		// 既存の辞書にあるかチェックする。
		// 種別に応じて単語を生成
		if($word_category == "noun"){		
			// 名詞の情報を取得
			$koine_words = Koine_Common::get_dictionary_stem_by_japanese($input_word, Koine_Common::DB_NOUN, $gender);		
  			// 名詞の情報が取得できた場合は
  			if($koine_words){
				// 新しい配列に詰め替え
				foreach ($koine_words as $noun_word) {
					// 読み込み
					$koine_noun = new koine_Noun($noun_word);
					// 配列に格納
					$charts[$koine_noun->get_second_stem()] = $koine_noun->get_chart();
					// メモリを解放
					unset($koine_noun);
		  		}
			}
		} else if($word_category == "adjective"){
			// 形容詞の情報を取得
			$koine_words = Koine_Common::get_dictionary_stem_by_japanese($input_word, Koine_Common::DB_ADJECTIVE);		
  			// 形容詞の情報が取得できた場合は
  			if($koine_words){
				// 新しい配列に詰め替え
				foreach ($koine_words as $adjective_word) {
					// 読み込み
					$koine_adjective = new koine_Adjective($adjective_word);
					// 配列に格納
					$charts[$koine_adjective->get_second_stem()] = $koine_adjective->get_chart();
					// メモリを解放
					unset($koine_adjective);
		  		}
			}
		} else if($word_category == "verb"){
			// 動詞の情報を取得
			$koine_words = Koine_Common::get_verb_by_japanese($input_word);	
  			// 動詞の情報が取得できた場合は
  			if($koine_words){
				// 新しい配列に詰め替え
				foreach ($koine_words as $koine_verb) {
					$charts = array_merge(Koine_Common::get_verb_conjugation($koine_verb), $charts);
				}
  			} 
		}

		// 結果が取得できた場合は
		if(count($charts) > 0){
			//結果を返す。
			return $charts;			
		}

		// 複合語情報を取得
		$result_data = Koine_Common::get_compound_data($input_words, $word_category);
		//var_dump($result_data);
		// 単語が習得できない場合は
		if($result_data != null){
			if(count($result_data["koine_words"]) > 0 && count($charts) == 0){
				// 造語データを取得
				$compund_words = Koine_Common::make_compound($result_data["koine_words"], $result_data["last_words"]);
				//var_dump($compund_words);			
				// 配列から単語を作成
				for ($i = 0; $i < count($compund_words["compund"]); $i++) {
					// 種別に応じて単語を生成
					if($word_category == "noun"){
						// 読み込み
						$koine_noun = new koine_Noun($compund_words["compund"][$i], $compund_words["last_word"][$i], $result_data["japanese_translation"]." (".$compund_words["word_info"][$i].")");
						// 活用表生成
						$charts[$koine_noun->get_second_stem()] = $koine_noun->get_chart();
						// メモリを解放
						unset($koine_noun);
					} else if($word_category == "adjective"){
						// 読み込み
						$koine_adjective = new koine_Adjective($compund_words["compund"][$i], $compund_words["last_word"][$i], $result_data["japanese_translation"]." (".$compund_words["word_info"][$i].")");
						// 活用表生成
						$charts[$koine_adjective->get_second_stem()] = $koine_adjective->get_chart();
						// メモリを解放
						unset($koine_adjective);
					} else if($word_category == "verb"){
						// 読み込み
						$koine_verb = new koine_Verb($compund_words["compund"][$i], $result_data["japanese_translation"], $compund_words["last_word"][$i]);
						// 活用表生成、配列に格納
						$charts[$koine_verb->get_dic_stem()] = $koine_verb->get_chart();
						// メモリを解放
						unset($koine_verb);
					} 
				}
			}
		}

		//結果を返す。
		return $charts;
	}

	// 造語の情報を取得する。
	private static function get_compound_data($input_words, $word_category){
	
		// 初期化
		$last_words = array();			// 最後の単語(単語生成用)
		$koine_words = array();
		$japanese_translation = "";		// 日本語訳
		$remain_word = "";				// 保留中の単語

		$noun_compound_flag = "";       // 名詞複合化フラグ

		// 配列から造語を作る
		for ($i = 0; $i < count($input_words); $i++) {
			// 切り出し
			$input_word = $input_words[$i];

			// 初期化
			$table = "";			
			$word_type = $input_word[1];	// 品詞種別
			$target_word = $input_word[0];	// 単語
			// 品詞判定
			if($word_type == "名詞"){
				// 単語の種別と取得先を変更する。
				$table = Koine_Common::DB_NOUN;			// テーブル取得先
			} else if($word_type  == "形容詞" || $word_type  == "連体詞" || $word_type  == "形容動詞"){
				// 単語の種別と取得先を変更する。
				$table = Koine_Common::DB_ADJECTIVE;		// テーブル取得先
			} else if($word_type  == "動詞"){
				// 単語の種別と取得先を変更する。
				$table = Koine_Common::DB_VERB;			// テーブル取得先
			} else if($word_type  == "副詞"){
				// 単語の種別と取得先を変更する。
				$table = Koine_Common::DB_ADVERB;		// テーブル取得先
			} else if($word_type  == "助動詞"){
				// 日本語訳を入れる。
				$japanese_translation = $japanese_translation.$target_word;
				// それ以外は次に移動
				continue;
			} else if($word_type  == "助詞"){				
				// 日本語訳を入れる。
				$japanese_translation = $japanese_translation.$target_word;
				// 名詞複合化フラグがある場合は
				if($noun_compound_flag){
					// 単語を結合する。
					$target_word = $remain_word.$target_word;
					// データベースから接尾辞を取得する。
					$word_datas = Koine_Common::get_koine_prefix($target_word);	
					// データベースが取得できた場合は
					if($word_datas){
						// 挿入する。
						$koine_words[] = $word_datas;
						// フラグをfalseにする。
						$noun_compound_flag = false;
					}
					// 形容詞の単語を取得する(動詞の場合は副詞から)
					if((preg_match('/verb/', $word_category))){
						// データベースから訳語の語幹を取得する。
						$word_datas = Koine_Common::get_koine_adverb($target_word);
					} else {
						$word_datas = Koine_Common::get_koine_strong_stem($target_word, Koine_Common::DB_ADJECTIVE);
					}
					// データベースが取得できた場合は
					if($word_datas){
						// 挿入する。
						$koine_words[] = $word_datas;
						// フラグをfalseにする。
						$noun_compound_flag = false;
						// 次に移動
						continue;	
					}
				} else {
					// データベースから接尾辞を取得する。
					$word_datas = Koine_Common::get_koine_prefix($target_word);	
					// データベースが取得できた場合は
					if($word_datas){
						// 挿入する。
						$koine_words[] = $word_datas;
					}					
				}
				// 次に移動
				continue;				
			} else {
				// 日本語訳を入れる。
				$japanese_translation = $japanese_translation.$target_word;					
				// それ以外は次に移動
				continue;
			}
			
			// 最終列の場合
			if($i == count($input_words) - 1){
				// 名詞複合化フラグ
				if($noun_compound_flag){
					// 前の名詞とつなげる。
					$target_word = $remain_word.$target_word;
					// 助詞などの場合はさらに後ろにつなげる。
					if($input_words[$i - 1][1] != "名詞" &&
					   $input_words[$i - 1][1] != "形容詞"){							   
						$target_word = $input_words[$i - 2][0].$target_word;
					}
					$noun_compound_flag = false;
				}		
				// 動詞の場合
				if($table == Koine_Common::DB_VERB){
					// 「する」や派生動詞の場合は動詞接尾辞も追加
					if($target_word == "する" && preg_match('/化$/u', $input_words[$i - 1][0])){
						$last_words[] = "ᾰ́ζω";
					} else if($target_word == "なる" && $input_words[$i - 1][0] == "に"){
						$last_words[] = "ῐ́ζω";						
					} else if($target_word == "する" && $input_words[$i - 1][0] == "に"){
						$last_words[] = "ᾰ́ζω";				
					} else if($target_word == "する"){
						$last_words[] = "άω";
						$last_words[] = "εύω";	
					} else if($target_word == "始める" && $input_words[$i - 2][1] == "動詞"){
						$last_words[] = "σκω";
					} else if($target_word == "続ける" && $input_words[$i - 1][1] == "動詞"){
						$last_words[] = "ᾰ́ζω";
					} else if(($target_word == "させる" || $target_word == "せる") && $input_words[$i - 1][1] == "動詞"){
						$last_words[] = "έω";		
					} else if(($target_word == "させる" || $target_word == "せる") && $input_words[$i - 1][1] == "名詞"){
						$last_words[] = "όω";
					} else {
						// データベースから訳語の語幹を取得する。
						$last_words_data = Koine_Common::get_verb_by_japanese($target_word);
						// 新しい配列に詰め替え
						foreach ($last_words_data as $last_word_data){	
							// 最終単語
							$last_words[] = $last_word_data["infinitive_stem"];		
						}
					}
					// 名詞や形容詞の造語の場合は
					if(Commons::is_word_declensionable($word_category)){
						for ($j = 0; $j < count($last_words); $j++) {
							// 現在分詞に変更
							$last_words[$j] = mb_substr($last_words[$j], 0, -2)."ns";
						}
					}
				} else if($table == Koine_Common::DB_NOUN){				
					// 名詞
					// 動詞の造語の場合は
					if(preg_match('/verb/', $word_category)){
						// 名詞の語幹を取得
						$last_words = Koine_Common::get_koine_strong_stem($target_word, $table);
						// 全ての値に適用
						for ($j = 0; $j < count($last_words); $j++) {
							// 第一変化動詞に変更
							$last_words[$j] = $last_words[$j]."άω";
						}
					} else {
						// データベースから訳語の単語を取得する。
						$last_words = Koine_Common::get_dictionary_stem_by_japanese($target_word, $table);						
					}				
				} else if($table == Koine_Common::DB_ADJECTIVE){					
					// 形容詞
					// 動詞の造語の場合は
					if(preg_match('/verb/', $word_category)){
						$last_words = Koine_Common::get_koine_strong_stem($target_word, $table);
						// 全ての値に適用
						for ($j = 0; $j < count($last_words); $j++) {
							// 第二変化動詞に変更
							$last_words[$j] = $last_words[$j]."εύω";
						}						
					} else {
						// データベースから訳語の単語を取得する。
						$last_words = Koine_Common::get_dictionary_stem_by_japanese($target_word, $table);						
					}					
				}
				// 単語が取得できない場合は、日本語訳を入れて何も返さない。
				if(!$last_words && count($last_words) == 0){
					$result_data["japanese_translation"] = $japanese_translation;
					return $result_data;
				}		
			} else {
				if($table == Koine_Common::DB_VERB){
					// 動詞の場合
					// データベースから訳語の語幹を取得する。
					$verbs_data = Koine_Common::get_verb_by_japanese($target_word);
					// 新しい配列に詰め替え
					foreach ($verbs_data as $verb_data){
						// 語幹を配列に追加
						$koine_words[$i][] = mb_substr($verb_data["present_stem"], 0, -1);	
					}
					// 単語が取得できない場合は、何も返さない。
					if(!$koine_words[$i]){
						return null;
					}								
				} else if($table == Koine_Common::DB_ADVERB || 
				  (preg_match('/verb/', $word_category) && ($table == Koine_Common::DB_NOUN || $table == Koine_Common::DB_ADJECTIVE))){
					// 副詞または動詞複合語の場合
					// データベースから接尾辞を取得する。
					$adverb_array = Koine_Common::get_koine_prefix($target_word);			
					// 接尾辞がある場合はそちらを優先。
					if($adverb_array){
						$koine_words[$i] = $adverb_array;
						continue;
					}					
					// データベースから訳語の語幹を取得する。
					$adverb_array = Koine_Common::get_koine_adverb($target_word);
					// 単語が取得できない場合は、何も返さない。
					// 単語が取得できない場合は、何も返さない。
					if(!$adverb_array && $i == count($input_words) - 2 && count($koine_words) == 0){
						return null;								
					} else if(!$adverb_array){
						// 単語が取得できない場合は
						// 名詞複合化フラグをONにする。
						$noun_compound_flag = true;
						$remain_word = $remain_word.$input_word[0];
						// 次に移動															
						continue;
					} else {
						// 見つかったら初期化する。
						$remain_word = "";
					}
					// 副詞を入れる。
					$koine_words[$i] = $adverb_array;
				} else {
					// 一部の単語はここで処理を終了
					if(preg_match('/^化$/u', $target_word)){
						// 日本語訳を入れる。
						$japanese_translation = $japanese_translation.$target_word;
						// 次に移動							
						continue;
					} 					
					// 一部の単語は事前処理
					if(preg_match('/^.+化$/u', $target_word)){
						$target_word = mb_ereg_replace("化", "", $target_word);
					} 
					// 名詞複合化フラグ
					if($noun_compound_flag){
						// 前の名詞とつなげる。
						// 助詞などの場合はさらに後ろにつなげる。
						if($input_words[$i - 1][1] != "名詞" &&
						   $input_words[$i - 1][1] != "形容詞"){
							$target_word = $remain_word.$input_words[$i - 1][0].$target_word;
						} else {
							$target_word = $remain_word.$target_word;
						}
						// フラグをfalseにする。
						$noun_compound_flag = false;
					}
					// データベースから訳語の語幹を取得する。
					$word_datas = Koine_Common::get_koine_strong_stem($target_word, $table);
					// 単語が取得できない場合は、何も返さない。
					if(!$word_datas && $i == count($input_words) - 2 && count($koine_words) == 0){
						return null;								
					} else if(!$word_datas){
						// 単語が取得できない場合は
						// 名詞複合化フラグをONにする。
						$noun_compound_flag = true;
						$remain_word = $remain_word.$input_word[0];
						// 次に移動															
						continue;
					} else {
						// 見つかったら初期化する。
						$remain_word = "";
					}
					// 挿入配列を初期化
					$insert_words = array();
					// 後ろにiを付けて、配列に詰め替え
					foreach ($word_datas as $word_data) {
						// 母音が後ろにある場合はoに弱化する。
						if(Commons::is_vowel_or_not(mb_substr($word_data, -1, 1))){
							$insert_words[] = mb_substr($word_data, 0, -1)."ο";
						} else {
							// それ以外はoを付ける。
							$insert_words[] = $word_data."ο";
						}
					}
					// 挿入する。
					$koine_words[] = $insert_words;
				}
			}
			// 日本語訳を入れる。
			$japanese_translation = $japanese_translation.$target_word;			
		}

		// 必要なデータを格納する。
		$result_data = array();
		$result_data["last_words"] = $last_words;						// 最後の単語(単語生成用)
		$result_data["koine_words"] = $koine_words;						// 単語リスト
		$result_data["japanese_translation"] = $japanese_translation;			// 日本語訳

		// 結果を返す。
		return $result_data;
	}

	// 造語のデータを作成する。
	private static function make_compound($koine_words, $last_words){
		// 初期化する。
		$compund_words = array();
		// 新しい配列に詰め替え
		foreach ($koine_words[0] as $koine_word ) {			
			// 複合対象の単語数によって分ける。
			if(count($koine_words) == 5 && $last_words){
				// 5語の場合は
				// 新しい配列に詰め替え
				foreach ($koine_words[1] as $koine_word_2){
					// 新しい配列に詰め替え
					foreach ($koine_words[2] as $koine_word_3){
						// 新しい配列に詰め替え
						foreach ($koine_words[3] as $koine_word_4) {
							// 新しい配列に詰め替え
							foreach ($koine_words[4] as $koine_word_5) {
								// 新しい配列に詰め替え
								foreach ($last_words as $last_word ) {
									// 弱語幹と最後の要素を入れる。
									$compund_words["word_info"][] = $koine_word." + ".$koine_word_2." + ".$koine_word_3." + ".$koine_word_4." + ".$koine_word_5." + ".$last_word;	// 単語の情報	
									$compund_words["last_word"][] = $last_word;																					// 要素の最後
									// 強語幹を入れる。
									$compund_words["compund"][] = $koine_word.$koine_word_2.$koine_word_3.$koine_word_4.$koine_word_5;						
								}
							}
						}
					}
				}
			} else if(count($koine_words) == 4 && $last_words){
				// 5語の場合は
				// 新しい配列に詰め替え
				foreach ($koine_words[1] as $koine_word_2){
					// 新しい配列に詰め替え
					foreach ($koine_words[2] as $koine_word_3){
						// 新しい配列に詰め替え
						foreach ($koine_words[3] as $koine_word_4) {
							// 新しい配列に詰め替え
							foreach ($last_words as $last_word ) {
								// 弱語幹と最後の要素を入れる。
								$compund_words["word_info"][] = $koine_word." + ".$koine_word_2." + ".$koine_word_3." + ".$koine_word_4." + ".$last_word;	// 単語の情報	
								$compund_words["last_word"][] = $last_word;																					// 要素の最後
								// 強語幹を入れる。
								$compund_words["compund"][] = $koine_word.$koine_word_2.$koine_word_3.$koine_word_4;						
							}
						}
					}
				}
			} else if(count($koine_words) == 3 && $last_words){
				// 4語の場合は
				// 新しい配列に詰め替え
				foreach ($koine_words[1] as $koine_word_2 ) {
					// 新しい配列に詰め替え
					foreach ($koine_words[2] as $koine_word_3 ) {
						// 新しい配列に詰め替え
						foreach ($last_words as $last_word ) {
							// 弱語幹と最後の要素を入れる。
							$compund_words["word_info"][] = $koine_word." + ".$koine_word_2." + ".$koine_word_3." + ".$last_word;	// 単語の情報	
							$compund_words["last_word"][] = $last_word;																// 要素の最後
							// 強語幹を入れる。
							$compund_words["compund"][] = $koine_word.$koine_word_2.$koine_word_3;						
						}
					}
				}
			} else if(count($koine_words) == 2 && $last_words){
				// 3語の場合は
				// 新しい配列に詰め替え
				foreach ($koine_words[1] as $koine_word_2 ) {
					// 新しい配列に詰め替え
					foreach ($last_words as $last_word ) {
						// 弱語幹と最後の要素を入れる。
						$compund_words["word_info"][] = $koine_word." + ".$koine_word_2." + ".$last_word;	// 単語の情報	
						$compund_words["last_word"][] = $last_word;											// 要素の最後
						// 強語幹を入れる。
						$compund_words["compund"][] = $koine_word.$koine_word_2;						
					}
				}
			} else if(count($koine_words) == 1 && $last_words){
				// 2語の場合は
				// 新しい配列に詰め替え
				foreach ($last_words as $last_word ) {
					// 弱語幹と最後の要素を入れる。
					$compund_words["word_info"][] = $koine_word." + ".$last_word;	// 単語の情報					
					$compund_words["last_word"][] = $last_word;						// 要素の最後
					// 強語幹を入れる。
					$compund_words["compund"][] = $koine_word;						// 強語幹を入れる。					
				}
			} 
		}
	  
		// 結果を返す。
		return $compund_words;
	}	
	
	// 形容詞の活用表(タイトル)を作る。
	public static function make_adjective_column_chart($title = ""){

		// タイトルを入れて表を返す。
		return '
        <thead>
          <tr>
            <th class="text-center" scope="row" style="width:19%">'.$title.'</th>
            <th class="text-center" scope="col" colspan="3" style="width:27%">単数</th>
            <th class="text-center" scope="col" colspan="3" style="width:27%">双数</th>            
            <th class="text-center" scope="col" colspan="3" style="width:27%">複数</th>
          </tr>
          <tr>
            <th class="text-center" scope="row" style="width:19%">格</th>
            <th class="text-center" scope="col" style="width:9%">男性</th>
            <th class="text-center" scope="col" style="width:9%">女性</th>
            <th class="text-center" scope="col" style="width:9%">中性</th>
            <th class="text-center" scope="col" style="width:9%">男性</th>
            <th class="text-center" scope="col" style="width:9%">女性</th>
            <th class="text-center" scope="col" style="width:9%">中性</th>            
            <th class="text-center" scope="col" style="width:9%">男性</th>
            <th class="text-center" scope="col" style="width:9%">女性</th>
            <th class="text-center" scope="col" style="width:9%">中性</th>
          </tr>
        </thead>';
	}

	// 形容詞の活用表を作る。
	public static function make_adjective_chart(){

		// 表を返す。
		return '
		<tr><th class="text-center" scope="row" colspan="10">原級</th></tr>		
		<tr><th class="text-center" scope="row">主格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><th class="text-center" scope="row">属格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><th class="text-center" scope="row">与格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><th class="text-center" scope="row">対格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><th class="text-center" scope="row">呼格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><th class="text-center table-optional" scope="row">奪格</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td></tr>
		<tr><th class="text-center table-optional" scope="row">具格</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td></tr>
		<tr><th class="text-center table-optional" scope="row">地格</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td></tr>
		<tr><th class="text-center table-optional" scope="row">出格1(副詞)</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td colspan="6" class="table-optional"></td></tr>
		<tr><th class="text-center table-optional" scope="row">出格2(副詞)</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td colspan="6" class="table-optional"></td></tr>
		<tr><th class="text-center" scope="row" colspan="10">比較級</th></tr>
		<tr><th class="text-center" scope="row">主格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><th class="text-center" scope="row">属格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><th class="text-center" scope="row">与格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><th class="text-center" scope="row">対格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><th class="text-center" scope="row">呼格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><th class="text-center table-optional" scope="row">奪格</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td></tr>
		<tr><th class="text-center table-optional" scope="row">具格</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td></tr>
		<tr><th class="text-center table-optional" scope="row">地格</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td></tr>
		<tr><th class="text-center table-optional" scope="row">出格1(副詞)</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td colspan="6" class="table-optional"></td></tr>
		<tr><th class="text-center table-optional" scope="row">出格2(副詞)</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td colspan="6" class="table-optional"></td></tr>
		<tr><th class="text-center" scope="row" colspan="10">最上級</th></tr>
		<tr><th class="text-center" scope="row">主格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><th class="text-center" scope="row">属格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><th class="text-center" scope="row">与格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><th class="text-center" scope="row">対格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><th class="text-center" scope="row">呼格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr><th class="text-center table-optional" scope="row">奪格</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td></tr>
		<tr><th class="text-center table-optional" scope="row">具格</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td></tr>
		<tr><th class="text-center table-optional" scope="row">地格</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td></tr>
		<tr><th class="text-center table-optional" scope="row">出格1(副詞)</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td colspan="6" class="table-optional"></td></tr>
		<tr><th class="text-center table-optional" scope="row">出格2(副詞)</th><td class="table-optional"></td><td class="table-optional"></td><td class="table-optional"></td><td colspan="6" class="table-optional"></td></tr>
			';
	}	

	// アルファベット判定をする。
	public static function is_alphabet_or_not($word){
		// アルファベットの場合はtrue
		if(ctype_alnum($word) || preg_match('(α|β|γ|δ|ε|ζ|η|θ|ι|κ|λ|μ|ν|ξ|ο|π|ρ|σ|τ|υ|φ|χ|ψ|ω)',$word)){
			return true;		
		}

		// それ以外はfalse
		return false;
	}

	// アルファベット判定をする。
	public static function is_latin_alphabet_or_not($word){
		// アルファベットの場合はtrue
		if(ctype_alnum($word) || (preg_match("/[a-zA-Z]/", $word) || preg_match('(ā|ī|ū|ē|ō)',$word))){
			return true;		
		}

		// それ以外はfalse
		return false;
	}

	// 特殊文字入力ボタンを配置する。
	public static function input_special_button(){

		return '      
		<div class="d-grid gap-2 d-md-block">
        	<button class="btn btn-primary" type="button" id="button-a" value="α">α</button>
        	<button class="btn btn-primary" type="button" id="button-b" value="β">β</button>
        	<button class="btn btn-primary" type="button" id="button-g" value="γ">γ</button>			
        	<button class="btn btn-primary" type="button" id="button-d" value="δ">δ</button>
        	<button class="btn btn-primary" type="button" id="button-e" value="ε">ε</button>
        	<button class="btn btn-primary" type="button" id="button-z" value="ζ">ζ</button>
        	<button class="btn btn-primary" type="button" id="button-ee" value="η">η</button>
			<button class="btn btn-primary" type="button" id="button-th" value="θ">θ</button>
        	<button class="btn btn-primary" type="button" id="button-i" value="ι">ι</button>
        	<button class="btn btn-primary" type="button" id="button-k" value="κ">κ</button>	
        	<button class="btn btn-primary" type="button" id="button-l" value="λ">λ</button>	
        	<button class="btn btn-primary" type="button" id="button-m" value="μ">μ</button>	
        	<button class="btn btn-primary" type="button" id="button-n" value="ν">ν</button>	
        	<button class="btn btn-primary" type="button" id="button-ks" value="ξ">ξ</button>	
        	<button class="btn btn-primary" type="button" id="button-o" value="ο">ο</button>	
        	<button class="btn btn-primary" type="button" id="button-p" value="π">π</button>	
        	<button class="btn btn-primary" type="button" id="button-r" value="ρ">ρ</button>	
        	<button class="btn btn-primary" type="button" id="button-s" value="σ">σ</button>	
        	<button class="btn btn-primary" type="button" id="button-t" value="τ">τ</button>	
        	<button class="btn btn-primary" type="button" id="button-y" value="υ">υ</button>	
        	<button class="btn btn-primary" type="button" id="button-ph" value="φ">φ</button>	
        	<button class="btn btn-primary" type="button" id="button-kh" value="χ">χ</button>	
        	<button class="btn btn-primary" type="button" id="button-ps" value="ψ">ψ</button>	
        	<button class="btn btn-primary" type="button" id="button-oo" value="ω">ω</button>	
      	</div> ';
	}

	// 名詞活用種別ボタンの生成
	public static function noun_declension_type_selection_button(){
		return '
        <h3>変化種別</h3>
        <section class="row">
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-1" autocomplete="off" value="1a">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1">ā-変化名詞</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-1" autocomplete="off" value="1as">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1">ās-変化名詞</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-1" autocomplete="off" value="1e">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1">ē-変化名詞</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-1" autocomplete="off" value="1es">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1">es-変化名詞</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-2" autocomplete="off" value="2">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-2">os-変化名詞</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-2um" autocomplete="off" value="2on">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-2um">on-変化名詞</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3" autocomplete="off" value="root">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3">語根名詞</label>
          </div>        
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3con" autocomplete="off" value="3con">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3con">第三活用(子音語幹)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3r" autocomplete="off" value="3r">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3r">第三活用(r語幹)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3n" autocomplete="off" value="3n">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3n">第三活用(n語幹)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3i" autocomplete="off" value="3i">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3i">第三活用(i語幹)</label>
          </div>  
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-4" autocomplete="off" value="4u">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-4">第四活用</label>
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
        <h3>変化種別</h3>
        <section class="row">
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-1-2" autocomplete="off" value="1-2">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1-2">第一・第二活用</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3" autocomplete="off" value="root">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3">語根名詞</label>
          </div>        
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3con" autocomplete="off" value="3con">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3con">第三活用(子音語幹)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3r" autocomplete="off" value="3r">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3r">第三活用(r語幹)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3n" autocomplete="off" value="3n">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3n">第三活用(n語幹)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3i" autocomplete="off" value="3i">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3i">第三活用(i語幹)</label>
          </div>  
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-4" autocomplete="off" value="4u">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-4">第四活用</label>
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
		<h3>格</h3>
		<section class="row">
		  <div class="col-md-3">
			<input type="radio" name="case" class="btn-check" id="btn-nom" autocomplete="off" value="nom">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-nom">主格</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="case" class="btn-check" id="btn-gen" autocomplete="off" value="gen">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-gen">属格</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="case" class="btn-check" id="btn-dat" autocomplete="off" value="dat">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-dat">与格</label>
		  </div>         
		  <div class="col-md-3">
			<input type="radio" name="case" class="btn-check" id="btn-acc" autocomplete="off" value="acc">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-acc">対格</label>
		  </div>         
		  <div class="col-md-3">
			<input type="radio" name="case" class="btn-check" id="btn-voc" autocomplete="off" value="voc">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-voc">呼格</label>
		  </div>';

		// 全ての選択肢を入れる場合は、ボタンを追加
		if($all_flag){
			$button_html_code = $button_html_code.
			'<div class="col-md-3">
				<input type="radio" name="case" class="btn-check" id="btn-all-case" autocomplete="off" value="" checked="checked">
				<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-case">すべて</label>
		  	 </div>';
		}

		// 結果を返す。
		return $button_html_code.'</section>';
	}

	// 動詞の活用種別ボタンの生成
	public static function verb_type_type_selection_button(){
		return '
        <h3>変化種別</h3>
        <section class="row">
          <div class="col-md-3">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb1" autocomplete="off" value="1">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-verb1">o変化動詞</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb2" autocomplete="off" value="2">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-verb2">mi変化動詞</label>
          </div> 
          <div class="col-md-3">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb2" autocomplete="off" value="3">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-verb2">nemi変化動詞</label>
          </div>       
          <div class="col-md-3">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb3a" autocomplete="off" value="4">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-verb3a">numi変化動詞</label>
          </div>		  
          <div class="col-md-3">
            <input type="radio" name="verb-type" class="btn-check" id="btn-all-conjugation" autocomplete="off" value="" checked="checked">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-conjugation">すべて</label>
          </div>
        </section>';
	}

	// 人称ボタンの生成
	public static function person_selection_button($all_flag = false){

		// ボタンを生成
		$button_html_code = '
        <h3>人称</h3>
        <section class="row">
          <div class="col-md-3">
            <input type="radio" name="person" class="btn-check" id="btn-1sg" autocomplete="off" value="1sg">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1sg">1人称単数</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="person" class="btn-check" id="btn-2sg" autocomplete="off" value="2sg">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-2sg">2人称単数</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="person" class="btn-check" id="btn-3sg" autocomplete="off" value="3sg">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3sg">3人称単数</label>
          </div>	  
          <div class="col-md-3">
            <input type="radio" name="person" class="btn-check" id="btn-1pl" autocomplete="off" value="1pl">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1pl">1人称複数</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="person" class="btn-check" id="btn-2pl" autocomplete="off" value="2pl">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-2pl">2人称複数</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="person" class="btn-check" id="btn-3pl" autocomplete="off" value="3pl">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3pl">3人称複数</label>
          </div>';

		// 全ての選択肢を入れる場合は、ボタンを追加
		if($all_flag){
			$button_html_code = $button_html_code.
			'<div class="col-md-3">
            	<input type="radio" name="person" class="btn-check" id="btn-all-person" autocomplete="off" value="" checked="checked">
            	<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-person">すべて</label>
          	 </div>';
		}

		// 結果を返す。
		return $button_html_code.'</section>';
	}	

	// 態ボタンの生成
	public static function voice_selection_button($all_flag = false){

		// ボタンを生成
		$button_html_code = '
        <h3>態</h3>
        <section class="row">
          <div class="col-md-3">
            <input type="radio" name="voice" class="btn-check" id="btn-active" autocomplete="off" value="active">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-active">能動態</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="voice" class="btn-check" id="btn-mediopassive" autocomplete="off" value="mediopassive">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-mediopassive">中動態</label>
          </div>  		  
          <div class="col-md-3">
            <input type="radio" name="voice" class="btn-check" id="btn-passive" autocomplete="off" value="passive">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-passive">受動態</label>
          </div>';

		// 全ての選択肢を入れる場合は、ボタンを追加
		if($all_flag){
			$button_html_code = $button_html_code.
			'<div class="col-md-3">
            	<input type="radio" name="voice" class="btn-check" id="btn-all-voice" autocomplete="off" value="" checked="checked">
            	<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-voice">すべて</label>
          	 </div>';
		}

		// 結果を返す。
		return $button_html_code.'</section>';
	}	

	// 相ボタンの生成
	public static function aspect_selection_button($all_flag = false){

		// ボタンを生成
		$button_html_code = '
        <h3>相</h3>
        <section class="row">
          <div class="col-md-3">
            <input type="radio" name="aspect" class="btn-check" id="btn-aspect-present" autocomplete="off" value="present" onclick="click_aspect_button()">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-aspect-present">現在相</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="aspect" class="btn-check" id="btn-aspect-aorist" autocomplete="off" value="aorist" onclick="click_aspect_button()">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-aspect-aorist">完結相</label>
          </div>		  
          <div class="col-md-3">
            <input type="radio" name="aspect" class="btn-check" id="btn-aspect-perfect" autocomplete="off" value="perfect" onclick="click_aspect_button()">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-aspect-perfect">完了相</label>
          </div> 
          <div class="col-md-3">
            <input type="radio" name="aspect" class="btn-check" id="btn-aspect-future" autocomplete="off" value="future" onclick="click_aspect_button()">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-aspect-future">未来形</label>
          </div>';

		// 全ての選択肢を入れる場合は、ボタンを追加
		if($all_flag){
			$button_html_code = $button_html_code.
			'<div class="col-md-3">
            	<input type="radio" name="aspect" class="btn-check" id="btn-all-aspect" autocomplete="off" value="" checked="checked" onclick="click_aspect_button()">
            	<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-aspect">すべて</label>
          	 </div>';
		}

		// 結果を返す。
		return $button_html_code.'</section>';	  

	}

	// 法ボタンの生成
	public static function mood_selection_button($all_flag = false){

		// ボタンを生成
		$button_html_code = '
        <h3>法</h3>
        <section class="row">
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-tense-present" autocomplete="off" value="'.Commons::PRESENT_TENSE.'">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-tense-present">現在形</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-tense-past" autocomplete="off" value="'.Commons::PAST_TENSE.'">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-tense-past">過去形</label>
          </div>		
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-subj" autocomplete="off" value="'.Commons::SUBJUNCTIVE.'">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-subj">接続法</label>
          </div> 
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-opt" autocomplete="off" value="'.Commons::OPTATIVE.'">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-opt">希求法</label>
          </div>	  
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-imper" autocomplete="off" value="'.Commons::IMPERATIVE.'">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-imper">命令法</label>
          </div>';

		// 全ての選択肢を入れる場合は、ボタンを追加
		if($all_flag){
			$button_html_code = $button_html_code.
			'<div class="col-md-3">
            	<input type="radio" name="mood" class="btn-check" id="btn-all-mood" autocomplete="off" value="" checked="checked">
            	<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-mood">すべて</label>
          	 </div>';
		}

		// 結果を返す。
		return $button_html_code.'</section>';
	}

	// 動詞の活用表を作る
	public static function make_verbal_chart($title = ""){
		// タイトルを入れて表を返す。
		return '
        <thead>
          <tr>
            <th class="text-center" scope="row" style="width:10%">'.$title.'</th>
            <th class="text-center" scope="col" colspan="2" style="width:11%">進行相</th>
            <th class="text-center" scope="col" colspan="2" style="width:11%">始動相</th>	
            <th class="text-center" scope="col" colspan="3" style="width:22%">完結相</th>
            <th class="text-center" scope="col" colspan="2" style="width:11%">完了相</th>
            <th class="text-center" scope="col" colspan="3" style="width:22%">未来形</th>              
          </tr>
          <tr>
            <th class="text-center" scope="row" style="width:10%">態</th>
            <th class="text-center" scope="col" style="width:6%">能動</th>
            <th class="text-center" scope="col" style="width:6%">中受動</th>
            <th class="text-center" scope="col" style="width:6%">能動</th>
            <th class="text-center" scope="col" style="width:6%">中受動</th>
            <th class="text-center" scope="col" style="width:6%">能動</th>
            <th class="text-center" scope="col" style="width:6%">中動</th>               
            <th class="text-center" scope="col" style="width:6%">受動</th>
            <th class="text-center" scope="col" style="width:6%">能動</th>
            <th class="text-center" scope="col" style="width:6%">中受動</th>
            <th class="text-center" scope="col" style="width:6%">能動</th>
            <th class="text-center" scope="col" style="width:6%">中動</th>            
            <th class="text-center" scope="col" style="width:6%">受動</th>
          </tr>
        </thead>
        <tbody>
          <tr><th class="text-center" scope="row" colspan="13">現在時制</th></tr>
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row" colspan="13">過去時制</th></tr>
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row" colspan="13">接続法</th></tr>
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row" colspan="13">希求法</th></tr>
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>    
          <tr><th class="text-center" scope="row" colspan="13">命令法</th></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
        </tbody>';
	}

	// 不定詞の活用表を作る
	public static function make_infinitive_chart($title = ""){
		// タイトルを入れて表を返す。
		return '
        <thead>
          <tr>
            <th class="text-center" scope="row" style="width:20%">'.$title.'</th>
            <th class="text-center" scope="col" colspan="1" style="width:16%">進行相</th>
            <th class="text-center" scope="col" colspan="1" style="width:16%">始動相</th>
            <th class="text-center" scope="col" colspan="1" style="width:16%">完結相</th>
            <th class="text-center" scope="col" colspan="1" style="width:16%">完了相</th>
            <th class="text-center" scope="col" colspan="1" style="width:16%">未来形</th>              
          </tr>
        </thead>
        <tbody>
          <tr><th class="text-center" scope="row">能動</th><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">中動</th><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">受動</th><td></td><td></td><td></td><td></td><td></td></tr>
        </tbody>';
	}

	// 検索言語コンボボックスの精製
	public static function language_select_box(){
		// ボタンを生成
		$button_html_code = '
        <select class="form-select" name="input_search_lang"> 
			<option value="'.Commons::NIHONGO.'">日本語(Japanese)</option>
			<option value="'.Commons::EIGO.'">英語(English)</option>
        	<option value="'.Commons::GREEK.'">ギリシア語(Greek)</option>     
        </select> ';

		// 結果を返す。
		return $button_html_code;
	}

}