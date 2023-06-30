<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/../language_class/IndoEuropean_adjective_class.php");
include(dirname(__FILE__) . "/../language_class/Database_session.php");
include(dirname(__FILE__) . "/../language_class/Commons.php");
include(dirname(__FILE__) . "/../language_class/Polish_Common.php");

// 活用表を取得する。
function get_adjective_declension_chart($word){
	// 形容詞の情報を取得
	$adjective_words = Polish_Common::get_dictionary_stem_by_japanese($word, Polish_Common::DB_ADJECTIVE, "");
  // 取得できない場合は
  if(!$adjective_words){
    // 英語で取得する。
    $adjective_words = Polish_Common::get_dictionary_stem_by_english($word, Polish_Common::DB_ADJECTIVE);  
    if(!$adjective_words){
      // 取得できない場合は
      if(!$adjective_words && !Polish_Common::is_alphabet_or_not($word)){
        // 空を返す。
        return array();
      } else if(Polish_Common::is_alphabet_or_not($word)){
        $adjective_words[] = $word;
      }
    }
  }
	// 配列を宣言
	$declensions = array();  
	// 新しい配列に詰め替え
	foreach ($adjective_words as $adjective_word) {
		// 読み込み
		$polish_adjective = new Polish_Adjective($adjective_word);
		// 活用表生成
		$declensions[$polish_adjective->get_first_stem()] = $polish_adjective->get_chart();
	}
  // 結果を返す。
	return $declensions;
}

// 活用表を取得する。
function get_adjective_declension_chart_by_english($word){
	// 形容詞の情報を取得
  // 英語で取得する。
  $adjective_words = Polish_Common::get_dictionary_stem_by_english($word, Polish_Common::DB_ADJECTIVE);  
  if(!$adjective_words){
    // 取得できない場合は
    if(Polish_Common::is_alphabet_or_not($word)){
      $adjective_words[] = $word;
    }
  }
	// 配列を宣言
	$declensions = array();  
	// 新しい配列に詰め替え
	foreach ($adjective_words as $adjective_word) {
		// 読み込み
		$polish_adjective = new Polish_Adjective($adjective_word);
		// 活用表生成
		$declensions[$polish_adjective->get_first_stem()] = $polish_adjective->get_chart();
	}
  // 結果を返す。
	return $declensions;
}

// 活用表を取得する。
function get_adjective_declension_chart_by_polish($word){
	// 形容詞の情報を取得
  // 英語で取得する。
  $adjective_words = Polish_Common::get_wordstem_from_DB($word, Polish_Common::DB_ADJECTIVE);  
  if(!$adjective_words){
    // 取得できない場合は
    if(Polish_Common::is_alphabet_or_not($word)){
      $adjective_words[] = $word;
    }
  }
	// 配列を宣言
	$declensions = array();  
	// 新しい配列に詰め替え
	foreach ($adjective_words as $adjective_word) {
		// 読み込み
		$polish_adjective = new Polish_Adjective($adjective_word);
		// 活用表生成
		$declensions[$polish_adjective->get_first_stem()] = $polish_adjective->get_chart();
	}
  // 結果を返す。
	return $declensions;
}

// 名詞から形容詞の活用表を取得する。
function get_noun_declension_chart($word){
	// 名詞の情報を取得
	$noun_words = Polish_Common::get_dictionary_stem_by_japanese($word, Polish_Common::DB_NOUN, "");
  // 取得できない場合は
  if(!$noun_words){
    // 英語で取得する。
    $noun_words = Polish_Common::get_dictionary_stem_by_english($word, Polish_Common::DB_NOUN);    
    // 取得できない場合は
    if(!$noun_words){    
      // 単語から直接取得する
      $noun_words = Polish_Common::get_wordstem_from_DB($word, Polish_Common::DB_NOUN);
      // 取得できない場合は
      if(!$noun_words && !Polish_Common::is_alphabet_or_not($word)){
        // 空を返す。
        return array();
      } else if(Polish_Common::is_alphabet_or_not($word)){
        $noun_words[] = $word;
      }
    }
  }

  // 形容詞化配列を生成
  $adjective_suffix = array("owy", "ny");
 	// 配列を宣言
  $declensions = array(); 
	// 新しい配列に詰め替え
	foreach ($noun_words as $noun_word) {
    // 形容詞化
    foreach($adjective_suffix as $suffix){
		  // 読み込み
		  $polish_noun = new Polish_Adjective($noun_word.$suffix);
		  // 配列に格納
		  $declensions[$polish_noun->get_first_stem()] = $polish_noun->get_chart();
    }
	}
  // 結果を返す。
	return $declensions;
}

// 挿入データ－対象－
$input_adjective = Commons::cut_words(trim(filter_input(INPUT_POST, 'input_adjective')), 128);
// 挿入データ－言語－
$search_lang = trim(filter_input(INPUT_POST, 'input_search_lang'));

// 検索結果の配列
$declensions = array();

// AIによる造語対応
$janome_result = Commons::get_multiple_words_detail($input_adjective);
$janome_result = Commons::convert_compound_array($janome_result);

// 対象が入力されていれば処理を実行
if($input_adjective != "" && count($janome_result) == 1 && $janome_result[0][1] == "名詞" && $search_lang == Commons::NIHONGO && !Polish_Common::is_alphabet_or_not($input_adjective)){
  // 名詞の場合は名詞で形容詞を取得
	$declensions = get_noun_declension_chart($input_adjective);
} else if($input_adjective != "" && $search_lang == Commons::POLISH && Polish_Common::is_alphabet_or_not($input_adjective)){
  // ポーランド語で取得
	$declensions = get_adjective_declension_chart($input_adjective);
} else if($input_adjective != "" && $search_lang == Commons::EIGO && Polish_Common::is_alphabet_or_not($input_adjective)){
  // 英語で取得
	$declensions = get_adjective_declension_chart($input_adjective);
} else if($input_adjective != "" && $search_lang == Commons::NIHONGO && !Polish_Common::is_alphabet_or_not($input_adjective)){
  // 日本語で取得
	$declensions = get_adjective_declension_chart($input_adjective);
}

?>
<!doctype html>
<html lang="ja">
  <head>
    <title>印欧語活用辞典：ポーランド辞書</title>
    <?php require_once("polish_including.php"); ?>
  </head>
  <body>
    <?php require_once("polish_header.php"); ?>
    <div class="container item table-striped">
      <h1>ポーランド辞書（形容詞）</h1>
      <form action="" method="post" class="mt-4 mb-4" id="form-search">
        <section class="row">
          <div class="col-md-6 mb-2 textBox1">
            <input type="text" name="input_adjective" id="input_adjective" class="form-control" placeholder="検索語句(日本語・英語・ポーランド語)、名詞も可 あいまい検索は+">
            <?php echo Polish_Common::input_special_button(); ?>
          </div>
          <div class="col-md-4 mb-2">
            <?php echo Polish_Common::language_select_box(); ?> 
          </div>
          <div class="col-md-2 mb-2">
            <input type="submit" class="btn-check" id="btn-search">
            <label class="btn btn-primary w-100 mb-3 fs-3" for="btn-search">検索</label>
          </div>
        </section>
        <select class="form-select" id="adjective-selection" aria-label="Default select example">
          <option selected>単語を選んでください</option>
          <?php echo Commons::select_option($declensions); ?>
        </select>
      </form>
      <?php echo Commons::archaic_button(); ?>   
      <table class="table table-success table-bordered table-striped table-hover text-nowrap" id="adjective-table" style="overflow: auto;">
        <?php echo Polish_Common::make_adjective_column_chart("形容詞"); ?>
        <tbody>
          <?php echo Polish_Common::make_adjective_chart(); ?>     
        </tbody>
      </table>
    </div>
    <script>
        var adj_table_data = '<?php echo json_encode($declensions, JSON_UNESCAPED_UNICODE); ?>';
    </script>
    <script>
        $(function(){
          // イベントを設定
          setEvents();
        });

        // 配列をテーブル用に変換にする。
        function arrange_table_data(table_data, word){

          // JSONに書き換え
          var json_adjective = JSON.parse(table_data)[word];

          // 原級形容詞の格変化情報を取得
          var positive_masc_sg = json_adjective["positive"]["masc"]["sg"];   //単数男性
          var positive_fem_sg = json_adjective["positive"]["fem"]["sg"];     //単数女性
          var positive_neu_sg = json_adjective["positive"]["neu"]["sg"];   	//単数中性
          var positive_masc_du = json_adjective["positive"]["masc"]["du"];   //双数男性
          var positive_fem_du = json_adjective["positive"]["fem"]["du"];     //双数女性
          var positive_neu_du = json_adjective["positive"]["neu"]["du"];   	//双数中性          
          var positive_masc_pl = json_adjective["positive"]["masc"]["pl"]; 	//複数男性
          var positive_fem_pl = json_adjective["positive"]["fem"]["pl"];   	//複数女性
          var positive_neu_pl = json_adjective["positive"]["neu"]["pl"];   	//複数中性
          
          // 比較級形容詞の格変化情報を取得
          var comp_masc_sg = json_adjective["comp"]["masc"]["sg"]; 	        //単数男性
          var comp_fem_sg = json_adjective["comp"]["fem"]["sg"];   	        //単数女性
          var comp_neu_sg = json_adjective["comp"]["neu"]["sg"];   	        //単数中性
          var comp_masc_du = json_adjective["comp"]["masc"]["du"];           //双数男性
          var comp_fem_du = json_adjective["comp"]["fem"]["du"];             //双数女性
          var comp_neu_du = json_adjective["comp"]["neu"]["du"];   	        //双数中性           
          var comp_masc_pl = json_adjective["comp"]["masc"]["pl"]; 		      //複数男性
          var comp_fem_pl = json_adjective["comp"]["fem"]["pl"];   		      //複数女性
          var comp_neu_pl = json_adjective["comp"]["neu"]["pl"];   		      //複数中性
          
          // 最上級形容詞の格変化情報を取得
          var super_masc_sg = json_adjective["super"]["masc"]["sg"]; 	      //単数男性
          var super_fem_sg = json_adjective["super"]["fem"]["sg"];   	      //単数女性
          var super_neu_sg = json_adjective["super"]["neu"]["sg"];   	      //単数中性
          var super_masc_du = json_adjective["super"]["masc"]["du"];         //双数男性
          var super_fem_du = json_adjective["super"]["fem"]["du"];           //双数女性
          var super_neu_du = json_adjective["super"]["neu"]["du"];   	      //双数中性            
          var super_masc_pl = json_adjective["super"]["masc"]["pl"]; 		    //複数男性
          var super_fem_pl = json_adjective["super"]["fem"]["pl"];   		    //複数女性
          var super_neu_pl = json_adjective["super"]["neu"]["pl"];   		    //複数中性
          
          // 格納データを作成
          var adj_table = [
            ["", "", "", "", "", "", ""],
            [positive_masc_sg["nom"], positive_fem_sg["nom"], positive_neu_sg["nom"], "*" + positive_masc_du["nom"], "*" + positive_fem_du["nom"], "*" + positive_neu_du["nom"], positive_masc_pl["nom"], positive_fem_pl["nom"], positive_neu_pl["nom"]],
            [positive_masc_sg["gen"], positive_fem_sg["gen"], positive_neu_sg["gen"], "*" + positive_masc_du["gen"], "*" + positive_fem_du["gen"], "*" + positive_neu_du["gen"], positive_masc_pl["gen"], positive_fem_pl["gen"], positive_neu_pl["gen"]],
            [positive_masc_sg["dat"], positive_fem_sg["dat"], positive_neu_sg["dat"], "*" + positive_masc_du["dat"], "*" + positive_fem_du["dat"], "*" + positive_neu_du["dat"], positive_masc_pl["dat"], positive_fem_pl["dat"], positive_neu_pl["dat"]],
            [positive_masc_sg["acc"], positive_fem_sg["acc"], positive_neu_sg["acc"], "*" + positive_masc_du["acc"], "*" + positive_fem_du["acc"], "*" + positive_neu_du["acc"], positive_masc_pl["acc"], positive_fem_pl["acc"], positive_neu_pl["acc"]],
            [positive_masc_sg["ins"], positive_fem_sg["ins"], positive_neu_sg["ins"], "*" + positive_masc_du["ins"], "*" + positive_fem_du["ins"], "*" + positive_neu_du["ins"], positive_masc_pl["ins"], positive_fem_pl["ins"], positive_neu_pl["ins"]],            
            [positive_masc_sg["loc"], positive_fem_sg["loc"], positive_neu_sg["loc"], "*" + positive_masc_du["loc"], "*" + positive_fem_du["loc"], "*" + positive_neu_du["loc"], positive_masc_pl["loc"], positive_fem_pl["loc"], positive_neu_pl["loc"]],
            [positive_masc_sg["voc"], positive_fem_sg["voc"], positive_neu_sg["voc"], "*" + positive_masc_du["voc"], "*" + positive_fem_du["voc"], "*" + positive_neu_du["voc"], positive_masc_pl["voc"], positive_fem_pl["voc"], positive_neu_pl["voc"]],
            ["", "", "", "", "", "", ""],
            [comp_masc_sg["nom"], comp_fem_sg["nom"], comp_neu_sg["nom"], "*" + comp_masc_du["nom"], "*" + comp_fem_du["nom"], "*" + comp_neu_du["nom"], comp_masc_pl["nom"], comp_fem_pl["nom"], comp_neu_pl["nom"]],
            [comp_masc_sg["gen"], comp_fem_sg["gen"], comp_neu_sg["gen"], "*" + comp_masc_du["gen"], "*" + comp_fem_du["gen"], "*" + comp_neu_du["gen"], comp_masc_pl["gen"], comp_fem_pl["gen"], comp_neu_pl["gen"]],
            [comp_masc_sg["dat"], comp_fem_sg["dat"], comp_neu_sg["dat"], "*" + comp_masc_du["dat"], "*" + comp_fem_du["dat"], "*" + comp_neu_du["dat"], comp_masc_pl["dat"], comp_fem_pl["dat"], comp_neu_pl["dat"]],
            [comp_masc_sg["acc"], comp_fem_sg["acc"], comp_neu_sg["acc"], "*" + comp_masc_du["acc"], "*" + comp_fem_du["acc"], "*" + comp_neu_du["acc"], comp_masc_pl["acc"], comp_fem_pl["acc"], comp_neu_pl["acc"]],
            [comp_masc_sg["ins"], comp_fem_sg["ins"], comp_neu_sg["ins"], "*" + comp_masc_du["ins"], "*" + comp_fem_du["ins"], "*" + comp_neu_du["ins"], comp_masc_pl["ins"], comp_fem_pl["ins"], comp_neu_pl["ins"]],
            [comp_masc_sg["loc"], comp_fem_sg["loc"], comp_neu_sg["loc"], "*" + comp_masc_du["loc"], "*" + comp_fem_du["loc"], "*" + comp_neu_du["loc"], comp_masc_pl["loc"], comp_fem_pl["loc"], comp_neu_pl["loc"]],
            [comp_masc_sg["voc"], comp_fem_sg["voc"], comp_neu_sg["voc"], "*" + comp_masc_du["voc"], "*" + comp_fem_du["voc"], "*" + comp_neu_du["voc"], comp_masc_pl["voc"], comp_fem_pl["voc"], comp_neu_pl["voc"]],  
            ["", "", "", "", "", "", ""],
            [super_masc_sg["nom"], super_fem_sg["nom"], super_neu_sg["nom"], "*" + super_masc_du["nom"], "*" + super_fem_du["nom"], "*" + super_neu_du["nom"], super_masc_pl["nom"], super_fem_pl["nom"], super_neu_pl["nom"]],
            [super_masc_sg["gen"], super_fem_sg["gen"], super_neu_sg["gen"], "*" + super_masc_du["gen"], "*" + super_fem_du["gen"], "*" + super_neu_du["gen"], super_masc_pl["gen"], super_fem_pl["gen"], super_neu_pl["gen"]],
            [super_masc_sg["dat"], super_fem_sg["dat"], super_neu_sg["dat"], "*" + super_masc_du["dat"], "*" + super_fem_du["dat"], "*" + super_neu_du["dat"], super_masc_pl["dat"], super_fem_pl["dat"], super_neu_pl["dat"]],
            [super_masc_sg["acc"], super_fem_sg["acc"], super_neu_sg["acc"], "*" + super_masc_du["acc"], "*" + super_fem_du["acc"], "*" + super_neu_du["acc"], super_masc_pl["acc"], super_fem_pl["acc"], super_neu_pl["acc"]],
            [super_masc_sg["ins"], super_fem_sg["ins"], super_neu_sg["ins"], "*" + super_masc_du["ins"], "*" + super_fem_du["ins"], "*" + super_neu_du["ins"], super_masc_pl["ins"], super_fem_pl["ins"], super_neu_pl["ins"]],            
            [super_masc_sg["loc"], super_fem_sg["loc"], super_neu_sg["loc"], "*" + super_masc_du["loc"], "*" + super_fem_du["loc"], "*" + super_neu_du["loc"], super_masc_pl["loc"], super_fem_pl["loc"], super_neu_pl["loc"]],
            [super_masc_sg["voc"], super_fem_sg["voc"], super_neu_sg["voc"], "*" + super_masc_du["voc"], "*" + super_fem_du["voc"], "*" + super_neu_du["voc"], super_masc_pl["voc"], super_fem_pl["voc"], super_neu_pl["voc"]],             
          ];
          
          // 結果を返す。
          return adj_table;
        }

        // 単語選択後の処理
        function output_table_data(){
          // 格変化表を取得 
          const adjective_decl_data = arrange_table_data(adj_table_data, $('#adjective-selection').val());

          // 行オブジェクトの取得
          var rows = $('#adjective-table')[0].rows;
          // 各行をループ処理
          $.each(rows, function(i){
            // タイトル行は除外する。
            if(i == 0 || i == 1){
              return true;
            } else if(adjective_decl_data[i - 2][0] == ""){
              if(i == 2){
                //rows[i].cells[0].innerText = "原級 " + $('#adjective-selection').val();
              } else if(i == 20){
                //rows[i].cells[0].innerText = "比較級 " + $('#adjective-selection').val();
              } else if(i == 38){
                //rows[i].cells[0].innerText = "最上級 " + $('#adjective-selection').val();
              }
              // 説明行も除外
              return true;
            } else {
              // 格変化を挿入
              rows[i].cells[1].innerText = adjective_decl_data[i - 2][0]; // 単数男性(1行目)
              rows[i].cells[2].innerText = adjective_decl_data[i - 2][1]; // 単数女性(2行目)
              rows[i].cells[3].innerText = adjective_decl_data[i - 2][2]; // 単数中性(3行目)
              rows[i].cells[4].innerText = adjective_decl_data[i - 2][3]; // 双数男性(4行目)
              rows[i].cells[5].innerText = adjective_decl_data[i - 2][4]; // 双数女性(5行目)
              rows[i].cells[6].innerText = adjective_decl_data[i - 2][5]; // 双数中性(6行目)  
              rows[i].cells[7].innerText = adjective_decl_data[i - 2][6]; // 複数男性(4行目)
              rows[i].cells[8].innerText = adjective_decl_data[i - 2][7]; // 複数女性(5行目)
              rows[i].cells[9].innerText = adjective_decl_data[i - 2][8]; // 複数中性(6行目)       
            }
              
          });
        }

        //イベントを設定
        function setEvents(){
	        // セレクトボックス選択時
	        $('#adjective-selection').change( function(){
            output_table_data();
	        });
          // ボタンにイベントを設定
          Input_Botton.PolishBotton('#input_adjective'); 
          // 古形隠しボタン
          Input_Botton.HiddenArchaicBotton();
          // 初期状態は古形の表示を隠す。
          $(".table-archaic").css("display", "none");
          // オブジェクト呼び出し
          //var cyber_punish_kacap = new Cyber_Punish_Kacap(500);
          // 実行
          //cyber_punish_kacap.attack_start();
        }
    </script>
  <footer class="">
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>