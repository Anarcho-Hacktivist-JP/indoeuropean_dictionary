<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/language_class/IndoEuropean_adjective_class.php");
include(dirname(__FILE__) . "/language_class/Database_session.php");
include(dirname(__FILE__) . "/language_class/Commons.php");
include(dirname(__FILE__) . "/language_class/Sanskrit_Common.php");

// 活用表を取得する。
function get_adjective_declension_chart($word){
	// 形容詞の情報を取得
	$adjective_words = Sanskrit_Common::get_dictionary_stem_by_japanese($word, Sanskrit_Common::$DB_ADJECTIVE, "");
  // 取得できない場合は
  if(!$adjective_words){
    // 英語で取得する。
    $adjective_words = Sanskrit_Common::get_dictionary_stem_by_english($word, Sanskrit_Common::$DB_ADJECTIVE);  
    if(!$adjective_words){
      // 取得できない場合は
      if(!$adjective_words && (!ctype_alpha($word) && 
                               !strpos($word, "ā") && 
                               !strpos($word, "ī") && 
                               !strpos($word, "ū") && 
                               !strpos($word, "ṛ") && 
                               !strpos($word, "ṝ") &&
                               !strpos($word, "ḷ") && 
                               !strpos($word, "ḹ") &&
                               !strpos($word, "ṭ") && 
                               !strpos($word, "ḍ") &&
                               !strpos($word, "ś") && 
                               !strpos($word, "ṣ"))){
        // 空を返す。
        return array();
      } else if(!ctype_alpha($word) && 
                !strpos($word, "ā") && 
                !strpos($word, "ī") && 
                !strpos($word, "ū") && 
                !strpos($word, "ṛ") && 
                !strpos($word, "ṝ") &&
                !strpos($word, "ḷ") && 
                !strpos($word, "ḹ") &&
                !strpos($word, "ṭ") && 
                !strpos($word, "ḍ") &&
                !strpos($word, "ś") && 
                !strpos($word, "ṣ")){
        $adjective_words[] = $word;
      }
    }
  }
	// 配列を宣言
	$declensions = array();  
	// 新しい配列に詰め替え
	foreach ($adjective_words as $adjective_word) {
		// 読み込み
		$vedic_adjective = new Vedic_Adjective($adjective_word);
		// 活用表生成
		$declensions[$vedic_adjective->get_second_stem()] = $vedic_adjective->get_chart();
	}
  // 結果を返す。
	return $declensions;
  
}

//造語対応
function get_compound_adjective_word($janome_result, $input_adjective)
{
  // データを取得
	$declensions = Sanskrit_Common::make_compound_chart(Commons::convert_compound_array($janome_result), "adjective", $input_adjective);
	// 結果を返す。
	return $declensions;
}

// 挿入データ－対象－
$input_adjective = Commons::cut_words(trim(filter_input(INPUT_POST, 'input_adjective')), 128);

// AIによる造語対応
$janome_result = Commons::get_multiple_words_detail($input_adjective);
var_dump($janome_result);

// 検索結果の配列
$declensions = array();

if(count($janome_result) > 1 && !ctype_alnum($input_adjective) && !strpos($input_adjective, Commons::$LIKE_MARK)){
  // 複合語の場合
  $declensions = get_compound_adjective_word($janome_result, $input_adjective);
} else if($input_adjective != ""){
  // 対象が入力されていれば処理を実行
	$declensions = get_adjective_declension_chart($input_adjective);
}

?>
<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>印欧語活用辞典：梵語辞書</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
  </head>
  <?php require_once("header.php"); ?>
  <body>
    <div class="container item table-striped">   
      <p>あいまい検索は+</p>
      <form action="" method="post" class="mt-4 mb-4" id="form-search">
        <input type="text" name="input_adjective" class="">
        <input type="submit" class="btn-check" id="btn-search">
        <label class="btn" for="btn-search">検索</label>
        <select class="" id="adjective-selection" aria-label="Default select example">
          <option selected>単語を選んでください</option>
          <?php echo Commons::select_option($declensions); ?>
        </select>
      </form>
      <table class="table-bordered" id="adjective-table">
        <?php echo Sanskrit_Common::make_adjective_column_chart("形容詞"); ?>
        <tbody>
          <?php echo Sanskrit_Common::make_adjective_chart(); ?>     
        </tbody>
      </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
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
            [positive_masc_sg["nom"], positive_fem_sg["nom"], positive_neu_sg["nom"], positive_masc_du["nom"], positive_fem_du["nom"], positive_neu_du["nom"], positive_masc_pl["nom"], positive_fem_pl["nom"], positive_neu_pl["nom"]],
            [positive_masc_sg["gen"], positive_fem_sg["gen"], positive_neu_sg["gen"], positive_masc_du["gen"], positive_fem_du["gen"], positive_neu_du["gen"], positive_masc_pl["gen"], positive_fem_pl["gen"], positive_neu_pl["gen"]],
            [positive_masc_sg["dat"], positive_fem_sg["dat"], positive_neu_sg["dat"], positive_masc_du["dat"], positive_fem_du["dat"], positive_neu_du["dat"], positive_masc_pl["dat"], positive_fem_pl["dat"], positive_neu_pl["dat"]],
            [positive_masc_sg["acc"], positive_fem_sg["acc"], positive_neu_sg["acc"], positive_masc_du["acc"], positive_fem_du["acc"], positive_neu_du["acc"], positive_masc_pl["acc"], positive_fem_pl["acc"], positive_neu_pl["acc"]],
            [positive_masc_sg["abl"], positive_fem_sg["abl"], positive_neu_sg["abl"], positive_masc_du["abl"], positive_fem_du["abl"], positive_neu_du["abl"], positive_masc_pl["abl"], positive_fem_pl["abl"], positive_neu_pl["abl"]],
            [positive_masc_sg["ins"], positive_fem_sg["ins"], positive_neu_sg["ins"], positive_masc_du["ins"], positive_fem_du["ins"], positive_neu_du["ins"], positive_masc_pl["ins"], positive_fem_pl["ins"], positive_neu_pl["ins"]],            
            [positive_masc_sg["loc"], positive_fem_sg["loc"], positive_neu_sg["loc"], positive_masc_du["loc"], positive_fem_du["loc"], positive_neu_du["loc"], positive_masc_pl["loc"], positive_fem_pl["loc"], positive_neu_pl["loc"]],
            [positive_masc_sg["voc"], positive_fem_sg["voc"], positive_neu_sg["voc"], positive_masc_du["voc"], positive_fem_du["voc"], positive_neu_du["voc"], positive_masc_pl["voc"], positive_fem_pl["voc"], positive_neu_pl["voc"]],
            [positive_masc_sg["elative"], positive_fem_sg["elative"], positive_neu_sg["elative"], "", "", "", ""],
            [positive_masc_sg["inessive1"], positive_fem_sg["inessive1"], positive_neu_sg["inessive1"], "", "", "", ""],
            [positive_masc_sg["inessive2"], positive_fem_sg["inessive2"], positive_neu_sg["inessive2"], "", "", "", ""],  
            [positive_masc_sg["comitative"], positive_fem_sg["comitative"], positive_neu_sg["comitative"], "", "", "", ""],
            [positive_masc_sg["multiplicative"], positive_fem_sg["multiplicative"], positive_neu_sg["multiplicative"], "", "", "", ""],
            [positive_masc_sg["essive"], positive_fem_sg["essive"], positive_neu_sg["essive"], "", "", "", ""], 
            [positive_masc_sg["translative"], positive_fem_sg["translative"], positive_neu_sg["translative"], "", "", "", ""],
            [positive_masc_sg["temporal"], positive_fem_sg["temporal"], positive_neu_sg["temporal"], "", "", "", ""],
            [positive_masc_sg["illative"], positive_fem_sg["illative"], positive_neu_sg["illative"], "", "", "", ""],
            [positive_masc_sg["distributive"], positive_fem_sg["distributive"], positive_neu_sg["distributive"], "", "", "", ""],
            ["", "", "", "", "", "", ""],
            [comp_masc_sg["nom"], comp_fem_sg["nom"], comp_neu_sg["nom"], comp_masc_du["nom"], comp_fem_du["nom"], comp_neu_du["nom"], comp_masc_pl["nom"], comp_fem_pl["nom"], comp_neu_pl["nom"]],
            [comp_masc_sg["gen"], comp_fem_sg["gen"], comp_neu_sg["gen"], comp_masc_du["gen"], comp_fem_du["gen"], comp_neu_du["gen"], comp_masc_pl["gen"], comp_fem_pl["gen"], comp_neu_pl["gen"]],
            [comp_masc_sg["dat"], comp_fem_sg["dat"], comp_neu_sg["dat"], comp_masc_du["dat"], comp_fem_du["dat"], comp_neu_du["dat"], comp_masc_pl["dat"], comp_fem_pl["dat"], comp_neu_pl["dat"]],
            [comp_masc_sg["acc"], comp_fem_sg["acc"], comp_neu_sg["acc"], comp_masc_du["acc"], comp_fem_du["acc"], comp_neu_du["acc"], comp_masc_pl["acc"], comp_fem_pl["acc"], comp_neu_pl["acc"]],
            [comp_masc_sg["abl"], comp_fem_sg["abl"], comp_neu_sg["abl"], comp_masc_du["abl"], comp_fem_du["abl"], comp_neu_du["abl"], comp_masc_pl["abl"], comp_fem_pl["abl"], comp_neu_pl["abl"]],
            [comp_masc_sg["ins"], comp_fem_sg["ins"], comp_neu_sg["ins"], comp_masc_du["ins"], comp_fem_du["ins"], comp_neu_du["ins"], comp_masc_pl["ins"], comp_fem_pl["ins"], comp_neu_pl["ins"]],
            [comp_masc_sg["loc"], comp_fem_sg["loc"], comp_neu_sg["loc"], comp_masc_du["loc"], comp_fem_du["loc"], comp_neu_du["loc"], comp_masc_pl["loc"], comp_fem_pl["loc"], comp_neu_pl["loc"]],
            [comp_masc_sg["voc"], comp_fem_sg["voc"], comp_neu_sg["voc"], comp_masc_du["voc"], comp_fem_du["voc"], comp_neu_du["voc"], comp_masc_pl["voc"], comp_fem_pl["voc"], comp_neu_pl["voc"]],
            [comp_masc_sg["elative"], comp_fem_sg["elative"], comp_neu_sg["elative"], "", "", "", ""],
            [comp_masc_sg["inessive1"], comp_fem_sg["inessive1"], comp_neu_sg["inessive1"], "", "", "", ""],
            [comp_masc_sg["inessive2"], comp_fem_sg["inessive2"], comp_neu_sg["inessive2"], "", "", "", ""],  
            [comp_masc_sg["comitative"], comp_fem_sg["comitative"], comp_neu_sg["comitative"], "", "", "", ""],
            [comp_masc_sg["multiplicative"], comp_fem_sg["multiplicative"], comp_neu_sg["multiplicative"], "", "", "", ""],
            [comp_masc_sg["essive"], comp_fem_sg["essive"], comp_neu_sg["essive"], "", "", "", ""], 
            [comp_masc_sg["translative"], comp_fem_sg["translative"], comp_neu_sg["translative"], "", "", "", ""],
            [comp_masc_sg["temporal"], comp_fem_sg["temporal"], comp_neu_sg["temporal"], "", "", "", ""],
            [comp_masc_sg["illative"], comp_fem_sg["illative"], comp_neu_sg["illative"], "", "", "", ""],
            [comp_masc_sg["distributive"], comp_fem_sg["distributive"], comp_neu_sg["distributive"], "", "", "", ""],         
            ["", "", "", "", "", "", ""],
            [super_masc_sg["nom"], super_fem_sg["nom"], super_neu_sg["nom"], super_masc_du["nom"], super_fem_du["nom"], super_neu_du["nom"], super_masc_pl["nom"], super_fem_pl["nom"], super_neu_pl["nom"]],
            [super_masc_sg["gen"], super_fem_sg["gen"], super_neu_sg["gen"], super_masc_du["gen"], super_fem_du["gen"], super_neu_du["gen"], super_masc_pl["gen"], super_fem_pl["gen"], super_neu_pl["gen"]],
            [super_masc_sg["dat"], super_fem_sg["dat"], super_neu_sg["dat"], super_masc_du["dat"], super_fem_du["dat"], super_neu_du["dat"], super_masc_pl["dat"], super_fem_pl["dat"], super_neu_pl["dat"]],
            [super_masc_sg["acc"], super_fem_sg["acc"], super_neu_sg["acc"], super_masc_du["acc"], super_fem_du["acc"], super_neu_du["acc"], super_masc_pl["acc"], super_fem_pl["acc"], super_neu_pl["acc"]],
            [super_masc_sg["abl"], super_fem_sg["abl"], super_neu_sg["abl"], super_masc_du["abl"], super_fem_du["abl"], super_neu_du["abl"], super_masc_pl["abl"], super_fem_pl["abl"], super_neu_pl["abl"]],
            [super_masc_sg["ins"], super_fem_sg["ins"], super_neu_sg["ins"], super_masc_du["ins"], super_fem_du["ins"], super_neu_du["ins"], super_masc_pl["ins"], super_fem_pl["ins"], super_neu_pl["ins"]],            
            [super_masc_sg["loc"], super_fem_sg["loc"], super_neu_sg["loc"], super_masc_du["loc"], super_fem_du["loc"], super_neu_du["loc"], super_masc_pl["loc"], super_fem_pl["loc"], super_neu_pl["loc"]],
            [super_masc_sg["voc"], super_fem_sg["voc"], super_neu_sg["voc"], super_masc_du["voc"], super_fem_du["voc"], super_neu_du["voc"], super_masc_pl["voc"], super_fem_pl["voc"], super_neu_pl["voc"]],
            [super_masc_sg["elative"], super_fem_sg["elative"], super_neu_sg["elative"], "", "", "", ""],
            [super_masc_sg["inessive1"], super_fem_sg["inessive1"], super_neu_sg["inessive1"], "", "", "", ""],
            [super_masc_sg["inessive2"], super_fem_sg["inessive2"], super_neu_sg["inessive2"], "", "", "", ""],  
            [super_masc_sg["comitative"], super_fem_sg["comitative"], super_neu_sg["comitative"], "", "", "", ""],
            [super_masc_sg["multiplicative"], super_fem_sg["multiplicative"], super_neu_sg["multiplicative"], "", "", "", ""],
            [super_masc_sg["essive"], super_fem_sg["essive"], super_neu_sg["essive"], "", "", "", ""], 
            [super_masc_sg["translative"], super_fem_sg["translative"], super_neu_sg["translative"], "", "", "", ""],
            [super_masc_sg["temporal"], super_fem_sg["temporal"], super_neu_sg["temporal"], "", "", "", ""],
            [super_masc_sg["illative"], super_fem_sg["illative"], super_neu_sg["illative"], "", "", "", ""],
            [super_masc_sg["distributive"], super_fem_sg["distributive"], super_neu_sg["distributive"], "", "", "", ""],                    
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
                rows[i].cells[0].innerText = "原級 " + $('#adjective-selection').val();
              } else if(i == 20){
                rows[i].cells[0].innerText = "比較級 " + $('#adjective-selection').val();
              } else if(i == 38){
                rows[i].cells[0].innerText = "最上級 " + $('#adjective-selection').val();
              }
              // 説明行も除外
              return true;
            } else if(rows[i].cells[5] == undefined){
              rows[i].cells[1].innerText = adjective_decl_data[i - 2][0]; // 副詞列
              rows[i].cells[2].innerText = adjective_decl_data[i - 2][1]; // 副詞列
              rows[i].cells[3].innerText = adjective_decl_data[i - 2][2]; // 副詞列
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
        }

    </script>
  <footer class="">
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>