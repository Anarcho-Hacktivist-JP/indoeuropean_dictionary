<?php
header('Content-Type: text/html; charset=UTF-8');

class Polish_Common {

	public static $DB_NOUN = "noun_polish";				// 名詞データベース名
	public static $DB_ADJECTIVE = "adjective_polish";	// 形容詞データベース名
	public static $DB_VERB = "verb_polish";				// 動詞データベース名
	public static $DB_ADVERB = "adverb_polish";			// 副詞データベース名		

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
		if($table == Polish_Common::$DB_NOUN && $gender != ""){
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
		if($table == Polish_Common::$DB_NOUN && $gender != ""){
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
		if($table == Polish_Common::$DB_NOUN && $gender != ""){
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
		$query = "SELECT * FROM `".Polish_Common::$DB_VERB."` WHERE ";
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
		// 英数字以外は考慮しない
		if(!ctype_alnum($english_translation)){
			return null;
		}
		//DBに接続
		$db_host = set_DB_session();

		// SQLを作成 
		$query = "SELECT * FROM `".Polish_Common::$DB_VERB."` WHERE ";
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
		return null;	
		//DBに接続
		$db_host = set_DB_session();
		// SQLを作成 
		$query = "SELECT * FROM `".Polish_Common::$DB_VERB."` WHERE `dictionary_stem` = '".$dictionary_stem."'";
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

	// ラテン語の動詞を取得
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
		$query = "SELECT * FROM `".Polish_Common::$DB_NOUN."` WHERE `location_name` != '1'";
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
		$query = "SELECT * FROM `".Polish_Common::$DB_ADJECTIVE."` WHERE `location_name` != '1'";
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
		$query = "SELECT * FROM `".Polish_Common::$DB_VERB."` WHERE `deponent_personal` != '1'";
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
	
	// 形容詞の活用表(タイトル)を作る。
	public static function make_adjective_column_chart($title = ""){

		// タイトルを入れて表を返す。
		return '
        <thead>
          <tr>
            <th scope="row" style="width:19%">'.$title.'</th>
            <th scope="col" colspan="3" style="width:27%">単数</th>
            <th scope="col" colspan="3" style="width:27%">双数</th>            
            <th scope="col" colspan="3" style="width:27%">複数</th>
          </tr>
          <tr>
            <th scope="row" style="width:19%">格</th>
            <th scope="col" style="width:9%">男性</th>
            <th scope="col" style="width:9%">女性</th>
            <th scope="col" style="width:9%">中性</th>
            <th scope="col" style="width:9%">男性</th>
            <th scope="col" style="width:9%">女性</th>
            <th scope="col" style="width:9%">中性</th>            
            <th scope="col" style="width:9%">男性</th>
            <th scope="col" style="width:9%">女性</th>
            <th scope="col" style="width:9%">中性</th>
          </tr>
        </thead>';
	}

	// 形容詞の活用表を作る。
	public static function make_adjective_chart(){

		// 表を返す。
		// 表を返す。
		return '
			<tr><th scope="row" colspan="10">原級</th></tr>		
			<tr><th scope="row">主格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">属格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">与格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">対格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">具格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">地格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">呼格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row" colspan="10">比較級</th></tr>
			<tr><th scope="row">主格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">属格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">与格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">対格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">具格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">地格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">呼格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row" colspan="10">最上級</th></tr>
			<tr><th scope="row">主格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">属格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">与格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">対格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">具格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">地格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><th scope="row">呼格</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>								
			';
	}	

	// 特殊文字入力ボタンを配置する。
	public static function input_special_button(){

		return '      
		<div class="d-grid gap-2 d-md-block">
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
		if(ctype_alnum($word) || preg_match('(ą|ć|ę|ł|ń|ó|ś|ź|ż)',$word)){
			return true;		
		}

		// それ以外はfalse
		return false;
	}


}