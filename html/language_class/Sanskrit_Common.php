<?php
set_time_limit(240);
header('Content-Type: text/html; charset=UTF-8');

class Sanskrit_Common extends Common_IE{

	public static $DB_NOUN = "noun_sanskrit";			// 名詞データベース名
	public static $DB_ADJECTIVE = "adjective_sanskrit";	// 形容詞データベース名
	public static $DB_VERB = "verb_sanskrit";			//動詞データベース名
	public static $DB_ADVERB = "adverb_sanskrit";		//副詞データベース名	

	public static $ZERO_GRADE = "weak";		// 弱語幹
	public static $GUNA = "middle";			// 中語幹
	public static $VRIDDHI = "strong";		// 強語幹

	// 名詞・形容詞情報取得
	public static function get_wordstem_from_DB($dictionary_stem, $table){
		// 英文字以外は考慮しない
		if(!Sanskrit_Common::is_alphabet_or_not($dictionary_stem)){
			return null;
		}
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT `dictionary_stem` FROM `".$table."` WHERE `dictionary_stem` = '".$dictionary_stem."'";
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
	
	// 訳語を取得
	public static function get_dictionary_stem_by_japanese($japanese_translation, $table, $gender = ""){
		// 英数字は考慮しない
		if(ctype_alnum($japanese_translation) || strpos($japanese_translation, "ā") || strpos($japanese_translation, "ī") || strpos($japanese_translation, "ū")){
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
		if($table == Sanskrit_Common::$DB_NOUN && $gender != ""){
			$query = $query."AND `gender` LIKE '%".$gender."%'";
		}		
		// SQLを取得
		//echo $query;
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
		if($table == Sanskrit_Common::$DB_NOUN && $gender != ""){
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

	// 語幹を取得
	public static function get_sanskrit_strong_stem($japanese_translation, $table, $gender = ""){
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
		if($table == Sanskrit_Common::$DB_NOUN && $gender != ""){
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

	// 動詞から名詞を生成
	public static function get_noun_from_verb($word){

		// 初期化
		$roots = array();

		// 語根を取得
		// 入力値で区別する。
		if(ctype_alnum($word)){
			// 語根で検索
			$roots = Sanskrit_Common::get_verb_by_english($word);
		} else {
			// 日本語で検索
			$roots = Sanskrit_Common::get_verb_by_japanese($word);
		}


		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `suffix_sanskrit` WHERE (`type` = 'krt' OR `type` = 'unadi') AND `genre` != 'adjective' ";
		// SQLを実行
		$stmt = $db_host->query($query);
		// 連想配列に整形
		$table_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// 配列を宣言
		$new_table_data = array();
		// 結果がある場合は
		if($table_data){
			// 全ての語根が対象
			foreach ($roots as $root) {
				// 読み込み
				$vedic_verb = new Vedic_Verb($root["dictionary_stem"]);
		  		// 活用表生成、配列に格納
		  		$new_table_data = array_merge($vedic_verb->make_derivative_noun_from_root($table_data), $new_table_data);
				// メモリを解放
				unset($vedic_verb);
			}					
		} else {
			// 何も返さない。
			return null;
		}
		
		//結果を返す。
		return $new_table_data;
	}

	// 動詞から形容詞を生成
	public static function get_adjective_from_verb($word){

		// 初期化
		$roots = array();

		// 語根を取得
		// 入力値で区別する。
		if(ctype_alnum($word)){
			// 語根で検索
			$roots = Sanskrit_Common::get_verb_by_english($word);
		} else {
			// 日本語で検索
			$roots = Sanskrit_Common::get_verb_by_japanese($word);
		}


		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `suffix_sanskrit` WHERE (`type` = 'krt' OR `type` = 'unadi') AND `genre` = 'adjective' ";
		// SQLを実行
		$stmt = $db_host->query($query);
		// 連想配列に整形
		$table_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// 配列を宣言
		$new_table_data = array();
		// 結果がある場合は
		if($table_data){
			// 全ての語根が対象
			foreach ($roots as $root) {
				// 読み込み
				$vedic_verb = new Vedic_Verb($root["dictionary_stem"]);
		  		// 活用表生成、配列に格納
		  		$new_table_data = array_merge($vedic_verb->make_derivative_adjective_from_root($table_data), $new_table_data);
				// メモリを解放
				unset($vedic_verb);
			}					
		} else {
			// 何も返さない。
			return null;
		}
		
		//結果を返す。
		return $new_table_data;
	}

	// 名詞接尾辞を生成
	public static function get_second_noun_suffix($suffix_word = ""){
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `suffix_sanskrit` WHERE (`type` = 'taddhita' OR `type` = 'taddhita-unadi') AND `genre` != 'adjective' ";
		// 条件がある場合は追加
		if($suffix_word != ""){
			$query = $query." AND (
				`mean` LIKE '%、".$suffix_word."、%' OR 
				`mean` LIKE '".$suffix_word."、%' OR 
				`mean` LIKE '%、".$suffix_word."' OR 
				`mean` = '".$suffix_word."')";
		}
		// SQLを実行
		$stmt = $db_host->query($query);
		// 連想配列に整形
		$table_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// 配列を宣言
		$new_table_data = array();
		// 結果がある場合は
		if($table_data){
			$new_table_data = $table_data;
		} else {
			// 何も返さない。
			return null;
		}
		
		//結果を返す。
		return $new_table_data;
	}

	// 形容詞接尾辞を生成
	public static function get_second_adjective_suffix($suffix_word = ""){
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `suffix_sanskrit` WHERE (`type` = 'taddhita' OR `type` = 'taddhita-unadi') AND `genre` = 'adjective' ";
		// 条件がある場合は追加
		if($suffix_word != ""){
			$query = $query." AND (
				`mean` LIKE '%、".$suffix_word."、%' OR 
				`mean` LIKE '".$suffix_word."、%' OR 
				`mean` LIKE '%、".$suffix_word."' OR 
				`mean` = '".$suffix_word."')";
		}
		// SQLを実行
		$stmt = $db_host->query($query);
		// 連想配列に整形
		$table_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// 配列を宣言
		$new_table_data = array();
		// 結果がある場合は
		if($table_data){
			$new_table_data = $table_data;
		} else {
			// 何も返さない。
			return null;
		}
		
		//結果を返す。
		return $new_table_data;
	}

	// 日本語から動詞の情報を取得する。
	public static function get_verb_by_japanese($japanese_translation){
		// 英数字は考慮しない
		if(ctype_alnum($japanese_translation)){
			return null;
		}
		//DBに接続
		$db_host = set_DB_session();

		// SQLを作成 
		$query = "SELECT * FROM `".Sanskrit_Common::$DB_VERB."` WHERE ";
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
				$verb_stem_array["root"] = $row_data["root"];
				$verb_stem_array["dictionary_stem"] = $row_data["dictionary_stem"];
				array_push($new_table_data, $verb_stem_array);
				// メモリを解放
				unset($verb_stem_array);
			}
		} else {
			return null;
		}

		//結果を返す。
		return $new_table_data;
	}

	// 英語から動詞の情報を取得する。
	public static function get_verb_by_english($english_translation){
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `".Sanskrit_Common::$DB_VERB."` WHERE ";
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
				$verb_stem_array["root"] = $row_data["root"];
				$verb_stem_array["dictionary_stem"] = $row_data["dictionary_stem"];						
				array_push($new_table_data, $verb_stem_array);
				// メモリを解放
				unset($verb_stem_array);
			}
		} else {
			return null;
		}

		//結果を返す。
		return $new_table_data;
	}

	// 辞書形から動詞の情報を取得する。
	public static function get_root_from_DB($dictionary_stem){
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `".Sanskrit_Common::$DB_VERB."` WHERE `dictionary_stem` = '".$dictionary_stem."'";
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

	// 語根から動詞の情報を取得する。
	public static function get_root_from_root($root){
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `".Sanskrit_Common::$DB_VERB."` WHERE `root` = '".$root."'";
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
				$verb_stem_array["root"] = $row_data["root"];
				$verb_stem_array["dictionary_stem"] = $row_data["dictionary_stem"];
				array_push($new_table_data, $verb_stem_array);
				// メモリを解放
				unset($verb_stem_array);
			}
		} else {
			return null;
		}

		//結果を返す。
		return $new_table_data;
	}
	
	// 副詞を取得
	public static function get_sanskrit_adverb($japanese_translation){
		// 英数字は考慮しない
		if(ctype_alnum($japanese_translation)){
			$new_database_info = array();
			array_push($new_database_info, $japanese_translation);
			return $new_database_info;
		}
		// 形容詞の検索条件変更
		$japanese_translation = mb_ereg_replace("く\b", 'い', $japanese_translation);

		//DBに接続
		$db_host = set_DB_session();

		// SQLを作成 
		$query = "SELECT
					case
		  			 when `noun_type` = '1' then CONCAT(`stem`, 'm')
					 when `noun_type` = '2' then CONCAT(`stem`, 'm')
					 when `noun_type` = '3i' then CONCAT(`stem`, 'm')
					 when `noun_type` = '3ilong' then CONCAT(`stem`, 'm')
					 when `noun_type` = '4u' then CONCAT(`stem`, 'm')
					 when `noun_type` = '4ulong' then CONCAT(`stem`, 'm')
					 when `noun_type` = '3n' then CONCAT(`stem`, 'am')
		  			 else CONCAT(`stem`, 'am')
					end as `adverb` 
					FROM `".Sanskrit_Common::$DB_NOUN."` WHERE ";
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
		$query = $query." UNION SELECT
							case
							 when `adjective_type` = '1' then CONCAT(`stem`, 'm')
							 when `adjective_type` = '2' then CONCAT(`stem`, 'm')
							 when `adjective_type` = '3i' then CONCAT(`stem`, 'm')
							 when `adjective_type` = '4u' then CONCAT(`stem`, 'm')
							 when `adjective_type` = '3n' then CONCAT(`stem`, 'am')
							 else CONCAT(`stem`, 'am')
							end as `adverb` 
							FROM `".Sanskrit_Common::$DB_ADJECTIVE."` WHERE ";
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

		$query = $query." UNION SELECT `adverb` FROM `adverb_sanskrit` WHERE ";
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
	public static function get_sanskrit_prefix($japanese_translation){
		// 英数字は考慮しない
		if(ctype_alnum($japanese_translation)){
			$new_database_info = array();
			array_push($new_database_info, $japanese_translation);
			return $new_database_info;
		}
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT `prefix` FROM `prefix_sanskrit` WHERE";
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

	// ランダムな名詞を取得
	public static function get_random_noun($gender = "", $noun_type = ""){
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `".Sanskrit_Common::$DB_NOUN."` WHERE 1 = '1' ";
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
		$query = "SELECT * FROM `".Sanskrit_Common::$DB_ADJECTIVE."` WHERE 1 = '1' ";
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
	public static function get_random_verb($verb_type = "", $root_type = "", $laryngeal_type = ""){
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `".Sanskrit_Common::$DB_VERB."` WHERE `root_type` != 'denomitive'";

		// 未完成データ除く
		$query = $query."AND `dictionary_stem` != ''";
		$query = $query."AND `japanese_translation` != ''";
		$query = $query."AND `english_translation` != ''";

		// 活用種別
		if($verb_type != ""){
			$query = $query."AND `conjugation_present_type` = '".$verb_type."' ";
		} else {
			$query = $query."AND `conjugation_present_type` != '' ";			
		}

		// 語根種別
		if($root_type != ""){
			$query = $query."AND `root_type` = '".$root_type."' ";
		} else {
			$query = $query."AND `root_type` != '' ";			
		}
		
		// 喉音有無
		if($laryngeal_type != ""){
			$query = $query."AND `root_laryngeal_flag` = '".$laryngeal_type."' ";
		} else {
			$query = $query."AND `root_laryngeal_flag` != '' ";			
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
	
	// 複合語の活用表を作成
	public static function make_compound_chart($input_words, $word_category, $input_word){
		// 初期化
		$charts = array();		
		// 既存の辞書にあるかチェックする。
		// 種別に応じて単語を生成
		if($word_category == "noun"){		
			// 名詞の情報を取得
			$sanskrit_words = Sanskrit_Common::get_dictionary_stem_by_japanese($input_word, Sanskrit_Common::$DB_NOUN);		
  			// 名詞の情報が取得できた場合は
  			if($sanskrit_words){
				// 新しい配列に詰め替え
				foreach ($sanskrit_words as $noun_word) {
					// 読み込み
					$sanskrit_noun = new Vedic_Noun($noun_word);
					// 配列に格納
					$charts[$sanskrit_noun->get_second_stem()] = $sanskrit_noun->get_chart();
					// メモリを解放
					unset($sanskrit_noun);
		  		}
			}
		} else if($word_category == "adjective"){
			// 形容詞の情報を取得
			$sanskrit_words = Sanskrit_Common::get_dictionary_stem_by_japanese($input_word, Sanskrit_Common::$DB_ADJECTIVE);		
  			// 形容詞の情報が取得できた場合は
  			if($sanskrit_words){
				// 新しい配列に詰め替え
				foreach ($sanskrit_words as $adjective_word) {
					// 読み込み
					$sanskrit_adjective = new Vedic_Adjective($adjective_word);
					// 配列に格納
					$charts[$sanskrit_adjective->get_second_stem()] = $sanskrit_adjective->get_chart();
					// メモリを解放
					unset($sanskrit_adjective);
		  		}
			}
		} else if($word_category == "verb"){
			// 動詞の情報を取得
			$sanskrit_words = Sanskrit_Common::get_verb_by_japanese($input_word);		
  			// 動詞の情報が取得できた場合は
  			if($sanskrit_words){
				// 新しい配列に詰め替え
				foreach ($sanskrit_words as $verb_word) {
		 			// 読み込み
		 			$sanskrit_verb = new Vedic_Verb($verb_word["dictionary_stem"]);
		  			// 活用表生成、配列に格納
		  			$charts[$sanskrit_verb->get_root()] = $sanskrit_verb->get_chart();
					// メモリを解放
					unset($sanskrit_verb);
		  		}
			}
		}

		// 結果が取得できた場合は
		if(count($charts) > 0){
			//結果を返す。
			return $charts;			
		}

		// 複合語情報を取得
		$result_data = Sanskrit_Common::get_compound_data($input_words, $word_category);
		// 単語が習得できない場合は
		if($result_data != null && count($result_data["sanskrit_words"]) > 0){
			// 造語データを取得
			$compund_words = Sanskrit_Common::make_compound_word_data($result_data["sanskrit_words"], $result_data["last_words"]);
			// 配列から単語を作成
			for ($i = 0; $i < count($compund_words["stem"]); $i++) {
				// 種別に応じて単語を生成
				if($word_category == "noun"){
					// 読み込み
					$sanskrit_noun = new Vedic_Noun($compund_words["stem"][$i], $compund_words["last_word"][$i], $result_data["japanese_translation"]." (".$compund_words["word_info"][$i].")");
					// 活用表生成
					$charts[$sanskrit_noun->get_second_stem()] = $sanskrit_noun->get_chart();
					// メモリを解放
					unset($sanskrit_noun);
				} else if($word_category == "adjective"){
					// 読み込み
					$sanskrit_adjective = new Vedic_Adjective($compund_words["stem"][$i], $compund_words["last_word"][$i], $result_data["japanese_translation"]." (".$compund_words["word_info"][$i].")");
					// 活用表生成
					$charts[$sanskrit_adjective->get_second_stem()] = $sanskrit_adjective->get_chart();
					// メモリを解放
					unset($sanskrit_adjective);
				} else if($word_category == "verb"){
					// 読み込み
					$sanskrit_verb = new Vedic_Verb($compund_words["last_word"][$i], $compund_words["stem"][$i], $result_data["japanese_translation"]." (".$compund_words["word_info"][$i].")");
					// 活用表生成
					$charts[$sanskrit_verb->get_root()] = $sanskrit_verb->get_chart();
					// メモリを解放
					unset($sanskrit_verb);
				} 
			}
		}

		//結果を返す。
		return $charts;
	}

	// 造語の情報を取得する。
	private static function get_compound_data($input_words,  $word_category){
	
		// 初期化
		$last_words = array();			// 最後の単語(単語生成用)
		$sanskrit_words = array();
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
				$table = Sanskrit_Common::$DB_NOUN;			// テーブル取得先
			} else if($word_type  == "形容詞" || $word_type  == "連体詞" || $word_type  == "形容動詞"){
				// 単語の種別と取得先を変更する。
				$table = Sanskrit_Common::$DB_ADJECTIVE;		// テーブル取得先
			} else if($word_type  == "動詞"){
				// 単語の種別と取得先を変更する。
				$table = Sanskrit_Common::$DB_VERB;			// テーブル取得先
			} else if($word_type  == "副詞"){
				// 単語の種別と取得先を変更する。
				$table = Sanskrit_Common::$DB_ADVERB;		// テーブル取得先
			} else if($word_type  == "助詞"){				
				// 日本語訳を入れる。
				$japanese_translation = $japanese_translation.$target_word;
				// 単語を結合する。
				$target_word = $remain_word.$target_word;
				// 最終行の場合は
				if($i == count($input_words) - 1){
					// 形容詞
					// データベースから訳語の単語を取得する。
					$last_words_adjective = Sanskrit_Common::get_dictionary_stem_by_japanese($target_word, Sanskrit_Common::$DB_ADJECTIVE, "");
					// 形容詞が取得できた場合は追加する。
					if($last_words_adjective){
						// 最終単語
						$last_words = array_merge($last_words, $last_words_adjective);
					}
					// 次に移動
					continue;
				}
				// 名詞複合化フラグがある場合は
				if($noun_compound_flag){
					// データベースから接頭辞を取得する。
					$word_datas = Sanskrit_Common::get_sanskrit_prefix($target_word);	
					// データベースが取得できた場合は
					if($word_datas){
						// 挿入する。
						$sanskrit_words[] = $word_datas;
						// フラグをfalseにする。
						$noun_compound_flag = false;
						// 次に移動
						continue;	
					}
					// 形容詞の単語を取得する(動詞の場合は副詞から)
					if((preg_match('/verb/', $word_category))){
						// データベースから訳語の語幹を取得する。
						$word_datas = Sanskrit_Common::get_sanskrit_adverb($target_word);
					} else {
						// 形容詞の単語を取得する
						$word_datas = Sanskrit_Common::get_sanskrit_strong_stem($target_word, Sanskrit_Common::$DB_ADJECTIVE);
					}
					// データベースが取得できた場合は
					if($word_datas){
						// 挿入する。
						$sanskrit_words[] = $word_datas;
						// フラグをfalseにする。
						$noun_compound_flag = false;
						// 次に移動
						continue;	
					}
				} else {
					// データベースから接尾辞を取得する。
					$word_datas = Sanskrit_Common::get_sanskrit_prefix($target_word);	
					// データベースが取得できた場合は
					if($word_datas){
						// 挿入する。
						$sanskrit_words[] = $word_datas;
					}					
				}
				// 次に移動
				continue;	
			} else {
				// 日本語訳を入れる。
				$japanese_translation = $japanese_translation.$target_word;					
				// 次に移動
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
					// フラグをfalseにする。
					$noun_compound_flag = false;
				}				
				// 動詞の場合
				if($table == Sanskrit_Common::$DB_VERB){
					// 「する」や派生動詞の場合は動詞接尾辞も追加
					if($target_word == "する" && preg_match('/化$/u', $input_words[$i - 1][0])){
						// 動詞を結合する。
						$sanskrit_words[count($sanskrit_words) - 1][0] = $sanskrit_words[count($sanskrit_words) - 1][0]."sāt"; 
						// 最終単語
						if(preg_match('(noun|adjective)', $word_category)){
							// 名詞や形容詞の場合は語根
							$last_words[] = "bhū";
							$last_words[] = "gam";
							$last_words[] = "i";
							$last_words[] = "ya";
							$last_words[] = "nī";
						} else {
							// それ以外は辞書形
							$last_words[] = "asati";						
							$last_words[] = "bhavati";
							$last_words[] = "eti";
							$last_words[] = "yāti";
							$last_words[] = "nayati";
							$last_words[] = "gacchati";	
							$last_words[] = "ganti";
						}
					} else if($target_word == "なる" && $input_words[$i - 1][0] == "と"){
						// 最終単語
						if(preg_match('(noun|adjective)', $word_category)){
							// 名詞や形容詞の場合は語根
							$last_words[] = "bhū";
							$last_words[] = "gam";
							$last_words[] = "i";
							$last_words[] = "ya";
							$last_words[] = "nī";
						} else {
							// それ以外は辞書形
							$last_words[] = "asati";
							$last_words[] = "bhavati";
							$last_words[] = "eti";
							$last_words[] = "yāti";
							$last_words[] = "nayati";
							$last_words[] = "gacchati";	
						}																		
					} else if($target_word == "なる" && $input_words[$i - 1][0] == "に"){
						// 最終単語
						if(preg_match('(noun|adjective)', $word_category)){
							// 名詞や形容詞の場合は語根
							$last_words[] = "bhū";
							$last_words[] = "i";
							$last_words[] = "ya";
							$last_words[] = "nī";
						} else {
							// それ以外は辞書形
							$last_words[] = "bhavati";
							$last_words[] = "eti";	
							$last_words[] = "yāti";
							$last_words[] = "nayati";
						}
					} else if($target_word == "なる" && $input_words[$i - 1][0] == "く"){
						// 最終単語
						if(preg_match('(noun|adjective)', $word_category)){
							// 名詞や形容詞の場合は語根
							$last_words[] = "bhū";
							$last_words[] = "i";	
						} else {
							// それ以外は辞書形
							$last_words[] = "bhavati";
							$last_words[] = "eti";	
						}									
					} else if($target_word == "する" && $input_words[$i - 1][0] == "に"){
						// 最終単語
						if(preg_match('(noun|adjective)', $word_category)){
							// 名詞や形容詞の場合は語根
							$last_words[] = "kṛ";	
						} else {
							// それ以外は辞書形
							$last_words[] = "kṛṇoti";	
						}
					} else if($target_word == "びる"){
						// 最終単語
						if(preg_match('(noun|adjective)', $word_category)){
							// 名詞や形容詞の場合は語根
							$last_words[] = "kṛ";
							$last_words[] = "bhū";
						} else {
							// それ以外は辞書形
							$last_words[] = "bhavati";
							$last_words[] = "kṛṇoti";	
						}
					} else if($target_word == "ある"){
						// 最終単語
						if(preg_match('(noun|adjective)', $word_category)){
							// 名詞や形容詞の場合は語根
							$last_words[] = "as";
						} else {
							// それ以外は辞書形
							$last_words[] = "ati";
							$last_words[] = "asyati";
							$last_words[] = "ayati";
							$last_words[] = "asati";
						}				
					} else if($target_word == "する"){
						// 最終単語
						if(preg_match('(noun|adjective)', $word_category)){
							// 名詞や形容詞の場合は語根
							$last_words[] = "kṛ";
							$last_words[] = "dhā";
						} else {
							// それ以外は辞書形
							$last_words[] = "ati";
							$last_words[] = "asyati";
							$last_words[] = "ayati";
							$last_words[] = "kṛṇoti";
							$last_words[] = "dadhāti";
						}	
					} else {
						// データベースから訳語の語幹を取得する。
						$last_words_data = Sanskrit_Common::get_verb_by_japanese($target_word);
						// 単語が取得できない場合は、何も返さない。
						if(!$last_words_data){
							return null;
						}
						// 新しい配列に詰め替え
						foreach ($last_words_data as $last_word_data){	
							// 最終単語
							if(preg_match('(noun|adjective)', $word_category)){
								// 名詞や形容詞の場合は語根
								$last_words[] = $last_word_data["root"];	
							} else {
								// それ以外は辞書形
								$last_words[] = $last_word_data["dictionary_stem"];	
							}
						}
					}
				} else {
					// 品詞判定
					if($word_category == "noun"){
						// データベースから名詞接頭辞を取得する。
						$suffix_datas = Sanskrit_Common::get_second_noun_suffix($target_word);
					} else if($word_category == "adjective"){
						// データベースから形容詞接頭辞を取得する。
						$suffix_datas = Sanskrit_Common::get_second_adjective_suffix($target_word);
					}
					// データベースが取得できた場合は
					if($suffix_datas){
						// 新しい配列に詰め替え
						foreach ($suffix_datas as $suffix_data){	
							$last_words[] = $suffix_data["suffix"];	
						}
					} else {
						// それ以外の場合は
						// 名詞
						// データベースから訳語の単語を取得する。
						$last_words_noun = Sanskrit_Common::get_dictionary_stem_by_japanese($target_word, Sanskrit_Common::$DB_NOUN, "");			
						// 名詞が取得できた場合は追加する。
						if($last_words_noun){
							// 最終単語
							$last_words = array_merge($last_words, $last_words_noun);
						}
						// 形容詞
						// データベースから訳語の単語を取得する。
						$last_words_adjective = Sanskrit_Common::get_dictionary_stem_by_japanese($target_word, Sanskrit_Common::$DB_ADJECTIVE, "");
						// 形容詞が取得できた場合は追加する。
						if($last_words_adjective){
							// 最終単語
							$last_words = array_merge($last_words, $last_words_adjective);
						}
					}
				}
				// 単語が取得できない場合は、日本語訳を入れて何も返さない。
				if(count($last_words) == 0){
					$result_data["japanese_translation"] = $japanese_translation.$target_word;
					return $result_data;
				}		
			} else {
				// 名詞複合化フラグ
				if($noun_compound_flag){
					// 前の名詞とつなげる。
					if($input_words[$i - 1][1] != "名詞" &&
					   $input_words[$i - 1][1] != "形容詞"){
						// 助詞などの場合はさらに後ろにつなげる。								   
						$target_word = $remain_word.$input_words[$i - 1][0].$target_word;
					} else {
						$target_word = $remain_word.$target_word;
					}
					// フラグをfalseにする。
					$noun_compound_flag = false;
				}
				// 品詞ごとに分ける。
				if($table == Sanskrit_Common::$DB_VERB){
					// 動詞の場合
					// データベースから訳語の語幹を取得する。
					$verbs_data = Sanskrit_Common::get_verb_by_japanese($target_word);
					// 新しい配列に詰め替え
					$word_datas = array();
					foreach ($verbs_data as $verb_data ) {
						// 語根のみ配列に挿入
						$word_datas[] = $verb_data["root"];	
					}			
				} else if($table == Sanskrit_Common::$DB_ADVERB || 
				          (preg_match('/verb/', $word_category) && 
						  ($table == Sanskrit_Common::$DB_NOUN || $table == Sanskrit_Common::$DB_ADJECTIVE) && 
						  $input_words[count($input_words) - 1][0] != "する")){
					// 動詞造語および副詞の場合
					// データベースから訳語の語幹を取得する。
					$word_datas = Sanskrit_Common::get_sanskrit_adverb($target_word);	
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
					// データベースから訳語の語幹を取得する。
					$word_datas = Sanskrit_Common::get_sanskrit_strong_stem($target_word, $table);				
				}

				// 単語が取得できない場合は、何も返さない。
				if(!$word_datas && $i == count($input_words) - 2 && count($sanskrit_words) == 0){
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
				// 挿入する。
				$sanskrit_words[] = $word_datas;	
			}
			// 日本語訳を入れる。
			$japanese_translation = $japanese_translation.$target_word;			
		}

		// 必要なデータを格納する。
		$result_data = array();
		$result_data["last_words"] = $last_words;						// 最後の単語(単語生成用)
		$result_data["sanskrit_words"] = $sanskrit_words;						// 単語リスト
		$result_data["japanese_translation"] = $japanese_translation;			// 日本語訳

		// 結果を返す。
		return $result_data;
	}

	// 造語のデータを作成する。
	private static function make_compound_word_data($sanskrit_word_list, $list_last_word){
		// 初期化する。
		$list_compund_word = array();
		// 新しい配列に詰め替え
		foreach ($sanskrit_word_list[0] as $sanskrit_word ) {
			// 3語以上の場合は
			if(count($sanskrit_word_list) == 2){
				// 新しい配列に詰め替え
				foreach ($sanskrit_word_list[1] as $sanskrit_word_2 ) {
					// 4語以上の場合は
					if(count($sanskrit_word_list) == 3){
						// 新しい配列に詰め替え
						foreach ($sanskrit_word_list[2] as $sanskrit_word_3 ) {
							// 新しい配列に詰め替え
							foreach ($list_last_word as $last_word ) {
								// 弱語幹と最後の要素を入れる。
								$list_compund_word["stem"][] = Sanskrit_Common::sandhi_engine(Sanskrit_Common::sandhi_engine($sanskrit_word, $sanskrit_word_2, false, false), $sanskrit_word_3, false, false);
								$list_compund_word["word_info"][] = $sanskrit_word." + ".$sanskrit_word_2." + ".$sanskrit_word_3." + ".$last_word;	// 単語の情報							
								$list_compund_word["last_word"][] = $last_word;
							}						
						}
					} else {
						// 新しい配列に詰め替え
						foreach ($list_last_word as $last_word ) {
							// 弱語幹と最後の要素を入れる。
							$list_compund_word["stem"][] = Sanskrit_Common::sandhi_engine($sanskrit_word, $sanskrit_word_2, false, false);
							$list_compund_word["word_info"][] = $sanskrit_word." + ".$sanskrit_word_2." + ".$last_word;	// 単語の情報							
							$list_compund_word["last_word"][] = $last_word;
						}
					}
				}
			} else {
				// 新しい配列に詰め替え
				foreach ($list_last_word as $last_word ) {
					// 弱語幹と最後の要素を入れる。
					$list_compund_word["stem"][] = $sanskrit_word;							// 弱語幹を入れる。
					$list_compund_word["word_info"][] = $sanskrit_word." + ".$last_word;	// 単語の情報	
					$list_compund_word["last_word"][] = $last_word;							// 要素の最後
				}
			}
		}

		// 結果を返す。
		return $list_compund_word;
	}	
	
	// 音階変更
	public static function change_vowel_grade($script, $sound_grade){	

		switch($sound_grade){
			case Sanskrit_Common::$ZERO_GRADE:
				// 文字を変換(na, ṅa, ña, ṇa, ma, ra, ya, va)
				$script = preg_replace("/([aā])([nṅṇmṃ])/u", "\\1\\2", $script);		//an, aṅ, añ, am	
				$script = preg_replace("/y([aā])/u", "i", $script);		// ya	
				$script = preg_replace("/v([aā])/u", "u", $script);		// va
				$script = preg_replace("/r([aā])/u", "ṛ", $script);		// ra
				$script = preg_replace("/l([aā])/u", "ḷ", $script);		// la

				// 文字を変換(ai, au)
				$script = str_replace("e", "i", $script);		//ai
				$script = str_replace("o", "u", $script);		//au
				$script = str_replace("ai", "i", $script);		//ai
				$script = str_replace("au", "u", $script);		//au		

				// 文字を変換(ay, av, ar, al)
				$script = preg_replace("/([aā])r/u", "ṛ", $script);		// ar
				$script = preg_replace("/([aā])l/u", "ḷ", $script);		// al
				$script = preg_replace("/([aā])y/u", "i", $script);		// ay
				$script = preg_replace("/([aā])v/u", "u", $script);		// av
				$script = str_replace("ā", "a", $script);		//al									
				break;
			case Sanskrit_Common::$GUNA:
				// 文字を変換(na, ṅa, ña, ṇa, ma, ra, ya, va)
				$script = preg_replace("/([bcdghjklmnpst])([nṅṇmṃ])/u", "\\1a\\2", $script);		//an, aṅ, añ, am				

				// 文字を変換(ai, au)
				$script = str_replace("i", "e", $script);		//ai
				$script = str_replace("u", "o", $script);		//au
				$script = str_replace("ī", "e", $script);		//ai
				$script = str_replace("ū", "o", $script);		//au				
				$script = str_replace("ai", "e", $script);		//ai
				$script = str_replace("au", "o", $script);		//au		

				// 文字を変換(ay, av, ar, al)
				$script = str_replace("ṛ", "ar", $script);		//ra
				$script = str_replace("ḷ", "al", $script);		//al

				$script = str_replace("ā", "a", $script);		//ā

				break;
			case Sanskrit_Common::$VRIDDHI:
				// 文字を変換(na, ṅa, ña, ṇa, ma, ra, ya, va)
				$script = preg_replace("/([bcdghjklmnpst])([nṅṇmṃ])/u", "\\1ā\\2", $script);		//an, aṅ, añ, am				

				// 文字を変換(ai, au)
				$script = str_replace("i", "ai", $script);		//ai
				$script = str_replace("u", "au", $script);		//au
				$script = str_replace("ī", "ai", $script);		//ai
				$script = str_replace("ū", "au", $script);		//au					
				$script = str_replace("e", "ai", $script);		//ai
				$script = str_replace("o", "au", $script);		//au			

				// 文字を変換(ay, av, ar, al)
				$script = str_replace("ṛ", "ār", $script);		//ra
				$script = str_replace("ḷ", "āl", $script);		//al

				$script = preg_replace("/a([lrvy])/u", "ā\\1", $script);		//al, ar, av, ay
				$script = str_replace("a", "ā", $script);		//ā
				break;	
			default:
				break;				
		}
		// 結果を返す。
		return $script;
	}

	// 連音対応
	public static function sandhi_engine($word1, $word2, $vedic_flag = false, $word_flag = false){

		// 結合先なし、母音 + 子音の組み合わせ以外は
		if($word2 != "" && 1 != 1 &&
		   !(preg_match("/[aiueoṛāīūṝ]$/", $word1) && preg_match("/^[bpkghcjlrtdḍṭmnṅñṃṇśṣsyv]/", $word2)) &&
		   !(preg_match("/[bpkghcjlrtdḍṭmnṅñṃṇśṣsyv]$/", $word1) && preg_match("/^[aiueoṛḷāīūṝḹ]/", $word2)) &&
		   !(preg_match("/[bpkghcjlrtdḍṭśṣs]$/", $word1) && preg_match("/^[yv]/", $word2)) &&
		   !(preg_match("/[aā]$/", $word1) && preg_match("/^[aā]/", $word2)) &&
		   !(preg_match("/[iī]$/", $word1) && preg_match("/^[iī]/", $word2)) &&
		   !(preg_match("/[uū]$/", $word1) && preg_match("/^[uū]/", $word2)) &&
		   !(preg_match("/[aā]$/", $word1) && preg_match("/^[iī]/", $word2)) &&
		   !(preg_match("/[aā]$/", $word1) && preg_match("/^[uū]/", $word2)) &&
		   !(preg_match("/[iī]$/", $word1) && preg_match("/^[aāuūeoṛṝḷḹ]/", $word2)) &&
		   !(preg_match("/[uū]$/", $word1) && preg_match("/^[aāiīeoṛṝḷḹ]/", $word2)) &&
		   !(preg_match("/[ṛṝ]$/", $word1) && preg_match("/^[aāiīuūeo]/", $word2))){
			//echo "done"."</br>";
			// 実行先を指定
			$command = "python3 /var/www/html/python/sandhi-engine-master/sandhi_engine.py $word1 $word2";
			// 実行し、その結果を取得する。
			exec($command , $result);
			// 結果を文字列で取得、余計な文字を除く
			$script = str_replace(",", "", $result[0]);
			$script = str_replace("[", "", $script);
			$script = str_replace("]", "", $script);
			$script = str_replace("'", "", $script);
			//echo $script."<br>";		
			// 一度配列に戻して、余分なデータを削除する。
			$scripts = explode(" ", $script);
			if(count($scripts) > 3){
				// 連音が起きた場合
				if($scripts[1] == $word2){
					// 単語が分離している場合
					$script = $scripts[2];
				} else {
					// 単語が分離していない場合
					$script = $scripts[0];
				}
			} else {
				// 連音が起きない場合
				$script = $scripts[0].$scripts[1];			
			}
		} else {
			//echo "ok"."</br>";			
			//echo "no sandhi";
			$script = $word1.$word2;
		}	

		// 内連声対応
		$script = preg_replace("/(ṃ|ḥ)s/u", "\\1ṣ", $script);	
		$script = preg_replace("/([bp]|[bp]h)s/u", "pṣ", $script);			
		$script = preg_replace("/([dt]|[dt]h)s/u", "tṣ", $script);		
		$script = preg_replace("/([śṣsjkgc]|[jkgc]h)s/u", "kṣ", $script);
		$script = preg_replace("/([iīuūeoṛṝ])s([bpkghcjlrtdḍṭmnṅñṃṇśṣsyvaāiīuūeo])/u", "\\1ṣ\\2", $script);
		$script = preg_replace("/([aāiīuūeoṛṝ])ch([aāiīuūeoṛṝ])/u", "\\1cch\\2", $script);

		// バルトロマエの法則
		$script = preg_replace("/([ṭtpkc]|[dḍbgj])h([ṭtpkc]|[dḍbgj])/u", "\\1\\2h", $script);
		$script = preg_replace("/hh/u", "h", $script);

		// 子音同化
		$script = preg_replace("/t([ḍdgbj])/u", "d\\1", $script);
		$script = preg_replace("/ṭ([ḍdgbj])/u", "ḍ\\1", $script);
		$script = preg_replace("/p([ḍdgbj])/u", "b\\1", $script);
		$script = preg_replace("/c([ḍdgbj])/u", "j\\1", $script);		
		$script = preg_replace("/k([ḍdgbj])/u", "g\\1", $script);

		$script = preg_replace("/d([ṭtpck])/u", "t\\1", $script);
		$script = preg_replace("/ḍ([ṭtpck])/u", "ṭ\\1", $script);
		$script = preg_replace("/b([ṭtpck])/u", "p\\1", $script);
		$script = preg_replace("/j([ṭtpck])/u", "c\\1", $script);		
		$script = preg_replace("/g([ṭtpck])/u", "k\\1", $script);

		// m対応
		$script = preg_replace("/([ñṅn])([pb]|[pb]h)/u", "m\\2", $script);				
		$script = preg_replace("/([ñmn])([kg]|[kg]h)/u", "ṅ\\2", $script);
		$script = preg_replace("/([ṅmn])([cj]|[cj]h)/u", "ñ\\2", $script);
		$script = preg_replace("/([mṅñ])([td]|[td]h)/u", "n\\2", $script);

		// 最後の子音が連続する場合は
		if($word_flag){		
			$script = preg_replace("/([bpkghcjtdḍṭmnṅñṃṇśṣs])([bpkghcjtdḍṭmnṅñṃṇśṣs])\b/u", '\\1', $script);
			$script = preg_replace("/([bpkghcjtdḍṭmnṅñṃṇśṣs])([bpkghcjtdḍṭmnṅñṃṇśṣs])\b/u", '\\1', $script);			
		}
		
		// n対応
		$script = preg_replace("/([bpkghcjlrtdḍṭv])n/u", "\\1ñ", $script);
		$script = preg_replace("/([bpkghcjlrtdḍṭv])m/u", "\\1n", $script);
		$script = preg_replace("/([śṣs])([mn])/u", "\\1n", $script);
		$script = preg_replace("/([mn])([bpkghcjlrtdḍṭmnṅñṃṇśṣs])/u", "n\\2", $script);

		// r対応
		$script = preg_replace("/([kghcjlrtdḍṭśṣsy])ṝ([a-z])/u", "\\1īr\\2", $script);
		$script = preg_replace("/([bpmnṅñṃṇv])ṝ([a-z])/u", "\\1ūr\\2", $script);

		// rl対応
		$script = preg_replace("/([[bpkghcjlrtdḍṭmnṅñṃṇśṣsyv]])r([[bpkghcjlrtdḍṭmnṅñṃṇśṣsyv]])/u", "\\1ṛ\\2", $script);
		$script = preg_replace("/([[bpkghcjlrtdḍṭmnṅñṃṇśṣsyv]])l([[bpkghcjlrtdḍṭmnṅñṃṇśṣsyv]])/u", "\\1ḷ\\2", $script);	

		// 母音の統合
		$script = preg_replace("/(a|ā)(a|ā)/u", "ā", $script);
		$script = preg_replace("/(i|ī)(i|ī)/u", "ī", $script);
		$script = preg_replace("/(u|ū)(u|ū)/u", "ū", $script);

		$script = preg_replace("/([iī])([aāuūeoṛṝ])/u", "y\\2", $script);
		$script = preg_replace("/([uū])([aāiīeoṛṝ])/u", "v\\2", $script);
		$script = preg_replace("/([ṛṝ])([aāiīuūeo])/u", "r\\2", $script);

		// 文字を変換(ヴェーダ対応)
		if($vedic_flag){
			$script = preg_replace("/(ai|aī|āī)/u", "āi", $script);		//ai
			$script = preg_replace("/(aū|āū)/u", "āu", $script);		//au
			$script = preg_replace("/au/u", "āu", $script);		//au			
			$script = preg_replace("/e/u", "ai", $script);		//e
			$script = preg_replace("/o/u", "au", $script);		//o	
			$script = preg_replace("/aa/u", "ā", $script);				
		} else {
			$script = preg_replace("/([ā])([ī])/u", "e", $script);
			$script = preg_replace("/([ā])([ū])/u", "o", $script);
			$script = preg_replace("/([a])([ī])/u", "e", $script);
			$script = preg_replace("/([a])([ū])/u", "o", $script);			
		}

		// 母音の子音化
		$script = preg_replace("/([uū])([aā])/u", "v\\2", $script);
		$script = preg_replace("/([iī])([aā])/u", "y\\2", $script);

		// 結果を返す。
		return $script;
	} 

	// 形容詞の曲用表(タイトル)を作る。
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

	// 形容詞の曲用表を作る。
	public static function make_adjective_chart(){

		// 表を返す。
		return '
			<tr><th class="text-center" scope="row" colspan="10">原級</th></tr>		
			<tr><th class="text-center" scope="row">主格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">属格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">与格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">対格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">奪格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">具格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">地格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">呼格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">出格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">内格1(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">内格2(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">共格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">乗法格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">様格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">変格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">時格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">入格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr> 
			<tr><th class="text-center" scope="row">分配格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row" colspan="10">比較級</th></tr>
			<tr><th class="text-center" scope="row">主格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">属格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">与格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">対格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">奪格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">具格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">地格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">呼格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">出格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">内格1(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">内格2(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">共格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">乗法格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">様格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">変格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">時格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">入格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr> 
			<tr><th class="text-center" scope="row">分配格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row" colspan="10">最上級</th></tr>
			<tr><th class="text-center" scope="row">主格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">属格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">与格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">対格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">奪格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">具格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">地格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">呼格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th class="text-center" scope="row">出格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">内格1(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">内格2(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">共格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">乗法格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">様格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">変格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">時格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>
			<tr><th class="text-center" scope="row">入格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr> 
			<tr><th class="text-center" scope="row">分配格(副詞)</th><td></td><td></td><td></td><td colspan="6"></td></tr>									
			';
	}

	// 動詞の活用表を作る
	public static function make_verbal_chart($title = ""){
		// タイトルを入れて表を返す。
		return '
        <thead>
          <tr>
            <th class="text-center" scope="row" style="width:15%">'.$title.'</th>
            <th class="text-center" scope="col" colspan="3" style="width:15%">進行相</th>
            <th class="text-center" scope="col" colspan="3" style="width:15%">始動相</th>
            <th class="text-center" scope="col" colspan="3" style="width:15%">結果相</th>					
            <th class="text-center" scope="col" colspan="3" style="width:15%">完結相</th>
            <th class="text-center" scope="col" colspan="2" style="width:10%">完了相</th>
            <th class="text-center" scope="col" colspan="3" style="width:15%">未来形</th>              
          </tr>
          <tr>
            <th class="text-center" scope="row" style="width:15%">態</th>
            <th class="text-center" scope="col" style="width:5%">能動</th>
            <th class="text-center" scope="col" style="width:5%">中動</th>
            <th class="text-center" scope="col" style="width:5%">受動</th>
            <th class="text-center" scope="col" style="width:5%">能動</th>
            <th class="text-center" scope="col" style="width:5%">中動</th>
            <th class="text-center" scope="col" style="width:5%">受動</th>
            <th class="text-center" scope="col" style="width:5%">能動</th>
            <th class="text-center" scope="col" style="width:5%">中動</th>
            <th class="text-center" scope="col" style="width:5%">受動</th>
            <th class="text-center" scope="col" style="width:5%">能動</th>
            <th class="text-center" scope="col" style="width:5%">中動</th>               
            <th class="text-center" scope="col" style="width:5%">受動</th>
            <th class="text-center" scope="col" style="width:5%">能動</th>
            <th class="text-center" scope="col" style="width:5%">中受動</th>
            <th class="text-center" scope="col" style="width:5%">能動</th>
            <th class="text-center" scope="col" style="width:5%">中動</th>            
            <th class="text-center" scope="col" style="width:5%">受動</th>
          </tr>
        </thead>
        <tbody>
          <tr><th class="text-center" scope="row" colspan="18">現在時制</th></tr>
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row" colspan="18">過去時制</th></tr>
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row" colspan="18">指令法(不定仮定法)</th></tr
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row" colspan="18">接続法/未来時制</th></tr>
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row" colspan="18">仮定法/希求法</th></tr>
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row" colspan="18">仮定法/祈願法</th></tr>
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>           
          <tr><th class="text-center" scope="row" colspan="18">命令法</th></tr>
          <tr><th class="text-center" scope="row">1人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称単数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称双数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">1人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">2人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
          <tr><th class="text-center" scope="row">3人称複数</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr> 
        </tbody>';
	}
	
	// 三次動詞の不定形の活用表を作る。
	public static function make_third_verb_infinitive_chart($title = ""){

		// 表を返す。
		return '
		<thead>
		  <tr>
		    <th scope="row" style="width:12%">'.$title.'不定詞</th>
		    <th scope="col" style="width:11%">語根tu不定詞</th>
		    <th scope="col" style="width:11%">不完了体tu不定詞</th>          
		  </tr>
	    </thead>
	    <tbody>
	  	  <tr><th scope="row">主格</th><td></td><td></td></tr>
	  	  <tr><th scope="row">属格</th><td></td><td></td></tr>
	  	  <tr><th scope="row">与格</th><td></td><td></td></tr>
	  	  <tr><th scope="row">対格</th><td></td><td></td></tr>
	  	  <tr><th scope="row">奪格</th><td></td><td></td></tr>
	  	  <tr><th scope="row">具格</th><td></td><td></td></tr>          
	  	  <tr><th scope="row">地格</th><td></td><td></td></tr>
	  	  <tr><th scope="row">呼格</th><td></td><td></td></tr>
	  	  <tr><th scope="row">出格(副詞)</th><td></td><td></td></tr>
	  	  <tr><th scope="row">内格1(副詞)</th><td></td><td></td></tr>
	  	  <tr><th scope="row">内格2(副詞)</th><td></td><td></td></tr>
	  	  <tr><th scope="row">共格(副詞)</th><td></td><td></td></tr>
	  	  <tr><th scope="row">乗法格(副詞)</th><td></td><td></td></tr>
	  	  <tr><th scope="row">様格(副詞)</th><td></td><td></td></tr>
	  	  <tr><th scope="row">変格(副詞)</th><td></td><td></td></tr>
	  	  <tr><th scope="row">時格(副詞)</th><td></td><td></td></tr>
	  	  <tr><th scope="row">入格(副詞)</th><td></td><td></td></tr> 
	  	  <tr><th scope="row">分配格(副詞)</th><td></td><td></td></tr>   
	    </tbody>						
		';
	}

	// 特殊文字入力ボタンを配置する。
	public static function input_special_button(){

		return '      
		<div class="d-grid gap-2 d-md-block">
        	<button class="btn btn-primary" type="button" id="button-a" value="ā">ā</button>
        	<button class="btn btn-primary" type="button" id="button-i" value="ī">ī</button>
        	<button class="btn btn-primary" type="button" id="button-u" value="ū">ū</button>
        	<button class="btn btn-primary" type="button" id="button-r" value="ṛ">ṛ</button> 
        	<button class="btn btn-primary" type="button" id="button-R" value="ṝ">ṝ</button>
        	<button class="btn btn-primary" type="button" id="button-l" value="ḷ">ḷ</button>
        	<button class="btn btn-primary" type="button" id="button-L" value="ḹ">ḹ</button>
        	<button class="btn btn-primary" type="button" id="button-G" value="ṅ">ṅ</button> 
        	<button class="btn btn-primary" type="button" id="button-J" value="ñ">ñ</button>
        	<button class="btn btn-primary" type="button" id="button-M" value="ṃ">ṃ</button>
        	<button class="btn btn-primary" type="button" id="button-N" value="ṇ">ṇ</button>			
        	<button class="btn btn-primary" type="button" id="button-t" value="ṭ">ṭ</button>
        	<button class="btn btn-primary" type="button" id="button-d" value="ḍ">ḍ</button>
        	<button class="btn btn-primary" type="button" id="button-z" value="ś">ś</button>
        	<button class="btn btn-primary" type="button" id="button-s" value="ṣ">ṣ</button>
      	</div> ';
	}

	// アルファベット判定をする。
	public static function is_alphabet_or_not($word){
		// アルファベットの場合はtrue
		if(ctype_alnum($word) || preg_match('(ā|ī|ū|ṛ|ṝ|ḷ|ḹ|ṅ|ñ|ṃ|ṇ|ṭ|ḍ|ś|ṣ)',$word)){
			return true;		
		}

		// それ以外はfalse
		return false;
	}

	// 数選択ボタンの生成
	public static function number_selection_button($all_flag = false){

		// ボタンを生成
		$button_html_code = '
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

	// 名詞活用種別ボタンの生成
	public static function noun_declension_type_selection_button(){
		return '
        <h3>変化種別</h3>
        <section class="row">
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-1" autocomplete="off" value="1">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1">a活用(長音)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-2" autocomplete="off" value="2">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-2">a活用</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3i" autocomplete="off" value="3i">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3i">i活用</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3ilong" autocomplete="off" value="3ilong">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3ilong">i活用(長音)</label>
          </div>           
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3con" autocomplete="off" value="3con">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3con">子音活用</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3r" autocomplete="off" value="3r">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3r">r活用</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3n" autocomplete="off" value="3n">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3n">n活用</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3s" autocomplete="off" value="3s">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3s">語幹活用</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-4u" autocomplete="off" value="4u">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-4u">u活用</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-4ulong" autocomplete="off" value="4ulong">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-4ulong">u活用(長音)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-double" autocomplete="off" value="double">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-double">二重母音活用</label>
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
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1-2">a活用</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3i" autocomplete="off" value="3i">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3i">i活用</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-double" autocomplete="off" value="double">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-double">二重母音活用</label>
          </div>           
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3con" autocomplete="off" value="3con">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3con">子音活用</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3r" autocomplete="off" value="3r">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3r">r活用</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3n" autocomplete="off" value="3n">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3n">n活用</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="declension" class="btn-check" id="btn-3s" autocomplete="off" value="3s">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3s">語根活用</label>
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
			<input type="radio" name="case" class="btn-check" id="btn-abl" autocomplete="off" value="abl">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-abl">奪格</label>
		  </div>
		  <div class="col-md-3">
			<input type="radio" name="case" class="btn-check" id="btn-ins" autocomplete="off" value="ins">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-ins">具格</label>
		  </div>		  
		  <div class="col-md-3">
			<input type="radio" name="case" class="btn-check" id="btn-loc" autocomplete="off" value="loc">
			<label class="btn btn-primary w-100 mb-3 fs-3" for="btn-loc">地格</label>
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

	// 語根の種別ボタンの生成
	public static function root_type_selection_button(){
		return '
        <h3>語根種別</h3>
        <section class="row">
          <div class="col-md-3">
            <input type="radio" name="root-type" class="btn-check" id="btn-present" autocomplete="off" value="present" onclick="click_root_button()">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-present">不完了体語根</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="root-type" class="btn-check" id="btn-aorist" autocomplete="off" value="aorist" onclick="click_root_button()">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-aorist">完了体語根</label>
          </div>       
          <div class="col-md-3">
            <input type="radio" name="root-type" class="btn-check" id="btn-all-root" autocomplete="off" value="" checked="checked" onclick="click_root_button()">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-root">すべて</label>
          </div>
        </section>';
	}

	// 語根の種別ボタンの生成2
	public static function laryngeal_type_selection_button(){
		return '
        <h3>語根種別</h3>
        <section class="row">
          <div class="col-md-3">
            <input type="radio" name="laryngeal-type" class="btn-check" id="btn-sat" autocomplete="off" value="1">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-sat">sat語根</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="laryngeal-type" class="btn-check" id="btn->anit" autocomplete="off" value="0">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn->anit">anit語根</label>
          </div>       
          <div class="col-md-3">
            <input type="radio" name="laryngeal-type" class="btn-check" id="btn-all-laryngeal" autocomplete="off" value="" checked="checked">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-all-laryngeal">すべて</label>
          </div>
        </section>';
	}

	// 動詞の活用種別ボタンの生成
	public static function verb_type_selection_button(){
		return '
        <h3>変化種別</h3>
        <section class="row">
          <div class="col-md-3">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb1" autocomplete="off" value="1">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-verb1">第一活用</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb2" autocomplete="off" value="2">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-verb2">第二活用(語根)</label>
          </div>       
          <div class="col-md-3">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb3" autocomplete="off" value="3">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-verb3">第三活用(重複)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb4" autocomplete="off" value="4">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-verb4">第四活用(ya接辞)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb5" autocomplete="off" value="5">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-verb5">第五活用(no接辞)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb6" autocomplete="off" value="6">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-verb6">第六活用</label>
          </div>		  
          <div class="col-md-3">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb7" autocomplete="off" value="7">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-verb7">第七活用(n接辞)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb8" autocomplete="off" value="8">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-verb8">第八活用(o接辞)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb9" autocomplete="off" value="9">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-verb9">第九活用(n接辞)</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="verb-type" class="btn-check" id="btn-verb10" autocomplete="off" value="10">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-verb10">第十活用(aya接辞)</label>
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
            <input type="radio" name="person" class="btn-check" id="btn-1du" autocomplete="off" value="1du">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-1du">1人称双数</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="person" class="btn-check" id="btn-2du" autocomplete="off" value="2du">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-2du">2人称双数</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="person" class="btn-check" id="btn-3du" autocomplete="off" value="3du">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-3du">3人称双数</label>
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
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-aspect-future">未然相</label>
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
            <input type="radio" name="mood" class="btn-check" id="btn-tense-present" autocomplete="off" value="present">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-tense-present">現在形</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-tense-past" autocomplete="off" value="past">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-tense-past">過去形</label>
          </div>		
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-injunc" autocomplete="off" value="injunc">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-injunc">指令法</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-subj" autocomplete="off" value="subj">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-subj">接続法/未来形</label>
          </div> 
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-opt" autocomplete="off" value="opt">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-opt">希求法</label>
          </div>
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-bend" autocomplete="off" value="bend">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-bend">祈願法</label>
          </div>		  
          <div class="col-md-3">
            <input type="radio" name="mood" class="btn-check" id="btn-imper" autocomplete="off" value="imper">
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

}