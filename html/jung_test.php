<?php
session_start();
header("Content-type: text/html; charset=utf-8");

function set_question($question, $id, $type){
  return '
  <section class="row my-1">
    <div class="col-md-4">
      <li>'.$question.'</li>
    </div>
    <input type="hidden" name="'.$id.'_v" id="'.$id.'_v" value="0">
    <input type="hidden" name="'.$id.'_type" id="'.$id.'_type" value="'.$type.'">
    <div class="col-md-1">   
      <label><input name="'.$id.'" type="radio" value="3" onClick="rbtn_clk(this.value,this.name)">強く</label>
    </div>
    <div class="col-md-1">   
      <label><input name="'.$id.'" type="radio" value="2" onClick="rbtn_clk(this.value,this.name)">はい</label>
    </div>
    <div class="col-md-1">
      <label><input name="'.$id.'" type="radio" value="1" onClick="rbtn_clk(this.value,this.name)">まあ</label>
    </div>
    <div class="col-md-1">
      <label><input name="'.$id.'" type="radio" value="0" onClick="rbtn_clk(this.value,this.name)">特に</label>
    </div>
    <div class="col-md-1">
      <label><input name="'.$id.'" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name)">あまり</label>
    </div>
    <div class="col-md-1">
      <label><input name="'.$id.'" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name)">いいえ</label>
    </div>
    <div class="col-md-1">
      <label><input name="'.$id.'" type="radio" value="-3" onClick="rbtn_clk(this.value,this.name)">全く</label>
    </div>
  </section>';
}

?>
<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">   
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">
    <title>ユング心理学、性格タイプ</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
    <script defer src="https://pyscript.net/alpha/pyscript.js"></script>
    <?php require_once("header.php"); ?>
    <script type="text/javascript">
  
      var str_type = new Array(":","外向的思考タイプ","内向的思考タイプ",
        "外向的感情タイプ","内向的感情タイプ","外向的感覚タイプ","内向的感覚タイプ",
        "外向的直観タイプ","内向的直観タイプ");

      var nn  = str_type.length - 1;    // 配列の長さ
      var num = new Array(nn+1);        // 得点
      var jun = new Array(nn+1);        // 順位
      var question_count = 88;
      
      // 得点を入れる。
      function set_points(){
        // 初期化処理
        for (var i=1; i<=nn; i++) {
          num[i] = 0;
          jun[i] = i;
        }
      
        // 各設問の値を入れる。
        for (var j=1; j<=question_count; j++) {
          // 設問の値
          var val    =  parseInt( $('#q' + j + "_v").val());
          // 集計対象の項目
          var type    =  parseInt( $('#q' + j + "_type").val());
          // 項目に値を加える。
          num[type] += val;
        }

        for (var i=1; i<=nn; i++) {
          var ename = "d" + i;
          $('#' + ename).val(num[i]);
        }
      }

      // 計算をする。
      function calculation(){
        var max,mi;
        for (var i=1; i<nn; i++) {
          max=num[i];
          mi = i;
          for (var j=i+1; j<=nn; j++) {
            if(num[j]>max) {
              max=num[j];
              mi  = j;
            }
          }
          jun[mi]= i;         jun[i] = mi;
          num[mi]= num[i];    num[i] = max;
        }
      
        var doten = 1;
        for (var i=2; i<=nn; i++) {
          if (num[i]==num[i-1]) {
            doten = i;
          }else {
            break;
          }
        }
        var t_str = "";
        for (var i=1; i<=doten; i++) {
          mi = jun[i];
          if(i != 1){
            t_str += "、" ;
          }
          t_str += str_type[mi];
        }

        // 結果を返す。
        return t_str;
      }

      // 集計を行う。
      function diag(this_form){
        // 得点を入れる。
        set_points();

        // 初期化
        $('#dd').val("");

        // 計算をする。
        var t_str = calculation();
      
        // 診断結果を出力
        $('#dd').val("最高点は" +num[1]+  "でした。\nあなたの性格タイプの候補は" + t_str +"と考えられます。");
      }
    
      // ボタン押下字時の動作
      function rbtn_clk(this_value,this_name){
        $('#' + this_name + '_v').val(this_value);
      }
    
      // クリアボタン押下時の動作
      function clr_v(this_form){
        $(this_form).find("textarea, :text, select, hidden, radio").val("").end().find(":checked").prop("checked", false);
        for (var j=1; j<=question_count; j++) {
          $('#q' + j + '_v').val(0);
        }
      }

      $(function(){
        // イベントを設定
        setEvents();
      });
      
      function setEvents(){
	      // 診断ボタン
	      $('#btn-check').click( function(){
          diag(this.form);
	      });

	      // クリアボタン
	      $('#btn-clear').click( function(){
          clr_v(this.form);
	      });
      }
    </script>
    <py-script>
    # ローカルストレージの関数
    from js import localStorage, document
    from datetime import date
    import datetime

    # 格納変数
    class Jung_Function(object):

      # 心理機能の関数
      _ex_sensive: int      
      _in_sensive: int
      _ex_intuition: int
      _in_intuition: int
      _ex_feeling: int
      _in_feeling: int
      _ex_thinking: int
      _in_thinking: int

      # ユーザ情報
      _name: str            # 名前
      _reg_time: datetime   # 日付

      # コンストラクタ
      def __init__(self,
                   ex_sensive: int = 0,
                   in_sensive: int = 0,
                   ex_intuition: int = 0,
                   in_intuition: int = 0,
                   ex_feeling: int = 0,
                   in_feeling: int = 0,
                   ex_thinking: int = 0,
                   in_thinking: int = 0,
                   name: str = "",
                   reg_time = datetime.datetime.now()) -> None:
        # 値を格納
        self._ex_sensive = ex_sensive
        self._in_sensive = in_sensive
        self._ex_intuition = ex_intuition
        self._in_intuition = in_intuition
        self._ex_feeling = ex_feeling
        self._in_feeling = in_feeling
        self._ex_thinking = ex_thinking
        self._in_thinking = in_thinking

        # 基本情報をセット
        self._name = name
        self._reg_time = reg_time

      # 文字列化
      def __str__(self):
        return "外向的感覚：" + str(self._ex_sensive) + "内向的感覚：" + str(self._in_sensive) + \
               "外向的直観：" + str(self._ex_intuition) + "内向的直観：" + str(self._in_intuition) + \
               "外向的感情：" + str(self._ex_feeling)  + "内向的感情：" + str(self._in_feeling) + \
               "外向的思考：" + str(self._ex_thinking)  + "内向的思考：" + str(self._in_thinking)

      # 等号
      def __eq__(self, other):
        # クラスチェック
        if isinstance(other, self.__class__):
          if self._ex_sensive == other._ex_sensive and self._in_sensive == other._in_sensive and \
             self._ex_intuition == other._ex_intuition and self._in_intuition == other._in_intuition and \
             self._ex_feeling == other._ex_feeling and self._in_feeling == other.in_feeling and \
             self._ex_thinking == other._ex_thinking and self._in_thinking == other._in_thinking:
            return true
          else:
            return false
        else:
          # 違うクラスの場合は
          kls = other.__class__.__name__
          raise NotImplementedError(f'comparison between Jung_Function and {kls} is not supported')

      # 不一致
      def __ne__(self, other):
        # クラスチェック
        if isinstance(other, self.__class__):
          if self._ex_sensive == other._ex_sensive and self._in_sensive == other._in_sensive and \
             self._ex_intuition == other._ex_intuition and self._in_intuition == other._in_intuition and \
             self._ex_feeling == other._ex_feeling and self._in_feeling == other.in_feeling and \
             self._ex_thinking == other._ex_thinking and self._in_thinking == other._in_thinking:
            return false
          else:
            return true
        else:
          # 違うクラスの場合は
          kls = other.__class__.__name__
          raise NotImplementedError(f'comparison between Jung_Function and {kls} is not supported')

      # 小なり
      def __lt__(self, other):
        # 値ではなく、メソッドの結果を返す。
        return self.good_person_calc() < other.good_person_calc()

      # 大なり
      def __lt__(self, other):
        # 値ではなく、メソッドの結果を返す。
        return self.good_person_calc() > other.good_person_calc()

      # コピー
      def __copy__(self):
        # クラスチェック
        if isinstance(other, self.__class__):
          # 結果を返す。
          return Jung_Function(self._ex_sensive, 
                               self._in_sensive,
                               self._ex_intuition,
                               self._in_intuition,
                               self._ex_feeling,
                               self._in_feeling,
                               self._ex_thinking,
                               self._in_thinking,
                               self._name,
                               self.reg_time)
        else:
          # 違うクラスの場合は
          kls = other.__class__.__name__
          raise NotImplementedError(f'comparison between Jung_Function and {kls} is not supported')

      # 性格の良い(=会話可能な)人判定
      def good_person_calc(self):
        # 初期化
        value: int = 0

        # 知覚機能を加算
        value = value + self._ex_sensive * 0 + self._in_sensive * 1
        value = value + self._ex_intuition * 1.5 + self._in_intuition * 2

        # 認知機能を加算
        value = value + self._ex_feeling * 1 + self._in_feeling * 0 
        value = value + self._ex_thinking * 2 + self._in_thinking * 1

        # 結果を返す
        return value

    # ローカルストレージに保存する。
    def save(*args, **kwargs):
      console.log("save by python")
    </py-script>
  </head>
  <body>
    <div class="container-fluid highlight">
      <section class="container">
        <h2 align="align1 mb-5">性格タイプ診断　from　ユング心理学</h2>
        <p align="center"><br></p>
        <p align="center">思考型、感情型、感覚型、直観型のそれぞれに外向的、内向的に分けた８つのタイプ診断です。</p>
        <p align="center">以下の設問を読み、当てはまると思うところにチェックをして下さい。</p>
      </section>
    </div>
    <form class="container-fluid item table-striped" name="yung" method="get" action="#" onsubmit="return false">
      <ul style="list-style-type:decimal">
        <?php echo set_question("社交的なフンイキにひかれ、人の中に入っていくのが好きな方だ。", "q1", 3); ?>
        <?php echo set_question("強い心の中からまきおこる感覚をひきおこすものを重視するほうだ。", "q2", 6); ?>
        <?php echo set_question("まわりの出来事を理論よりも感覚でとらえるほうだ。", "q3", 5); ?>
        <?php echo set_question("親しい気の合った人とだけ議論しようとするほうだ。", "q4",2); ?>
        <?php echo set_question("自分独自の価値基準をもとうとするほうだ。", "q5", 4); ?>
        <?php echo set_question("事実を重視し、ものごとをとことんまで考えようとするほうだ。", "q6", 1); ?>
        <?php echo set_question("ものごとそのものよりも、その可能性に注目するほうだ。", "q7", 7); ?>
        <?php echo set_question("自分のなかに沈みこみ、ある種の予感を大切にするほうだ。", "q8", 8); ?>
        <?php echo set_question("感受性が強く、自分の世界に耽溺するほうだ。", "q9", 6); ?>
        <?php echo set_question("好き嫌いがはげしく、気の合った少数の人としかつき合わないほうだ。", "q10", 4); ?>
        <?php echo set_question("未来を自分の内にひらめくカンに頼って切り開いていくほうだ。", "q11", 8); ?>
        <?php echo set_question("大事な決定をするときは、周囲の状況を論理的に分析してきめるほうだ。", "q12", 1); ?>
        <?php echo set_question("自分の判断が、周りの人の判断とよく一致するほうだ。", "q13", 3); ?>
        <?php echo set_question("ものごとを理屈ではなく、直観によって見きわめようとするほうだ。", "q14", 7); ?>
        <?php echo set_question("まわりのできごとよりも、人間について理解を深めようとするほうだ。", "q15", 2); ?>
        <?php echo set_question("生活を楽しむために、まわりの刺激を求めるほうだ。", "q16", 5); ?>
        <?php echo set_question("自分の気持ちは心の中にそっととどめておくほうだ。", "q17", 4); ?>
        <?php echo set_question("理屈よりもカンに頼って、現実の問題を解決するほうだ。", "q18", 7); ?>
        <?php echo set_question("抽象的な概念や、考え方にひかれるほうだ。", "q19", 2); ?>
        <?php echo set_question("自分のしていることが、社会的に認められるかどうかが気になるほうだ。", "q20", 3); ?>
        <?php echo set_question("まわりのできごとよりも、自分の中におこる強い印象に喜びを感じるほうだ。", "q21", 6); ?>
        <?php echo set_question("感情よりも、理論を先にたてて行動するほうだ。", "q22", 1); ?>
        <?php echo set_question("まわりにあるものごとに、敏感なほうだ。", "q23", 5); ?>
        <?php echo set_question("心にひらめいたことを、他人に伝えるのがうまくないほうだ。", "q24", 8); ?>
        <?php echo set_question("自分自身のことよりも、まわりのできごとをよく考えるほうだ。", "q25", 1); ?>
        <?php echo set_question("難しい状況にであうと、理屈よりもカンに頼るほうだ。", "q26", 7); ?>
        <?php echo set_question("まわりのことは気にしないで、自分なりの見方を大切にするほうだ。", "q27", 4); ?>
        <?php echo set_question("一般的な判断にもとづいた、常識を重んじるほうだ。", "q28", 3); ?>
        <?php echo set_question("感受性が強く、まわりの刺激に影響されやすいほうだ。", "q29", 5); ?>
        <?php echo set_question("自分自身を理屈よりも、感覚でとらえようとするほうだ。", "q30", 6); ?>
        <?php echo set_question("まわりのできごとよりも、自分の心の中からでてくる可能性を求めるほうだ。", "q31", 8); ?>
        <?php echo set_question("自分自身を哲学的にいろいろと考えようとするほうだ。", "q32", 2); ?>
        <?php echo set_question("心の中から湧きあがる強い印象に心奪われるほうだ。", "q33", 6); ?>
        <?php echo set_question("善・悪や美・醜の判断に、自分独特の考えをもつほうだ。", "q34", 4); ?>
        <?php echo set_question("心の中にひらめいたもので、自分の将来の夢を追うほうだ。", "q35", 8); ?>
        <?php echo set_question("行動のあり方が、感覚に訴えるものに左右されやすいほうだ。", "q36", 5); ?>
        <?php echo set_question("理屈っぽく考えないで、すぐに良いか悪いかをきめるほうだ。", "q37", 3); ?>
        <?php echo set_question("自分の心の内にひらめくものによって行動するほうだ。", "q38", 7); ?>
        <?php echo set_question("客観的な事実にもとづいて、論理的に考えようとするほうだ。", "q39", 1); ?>
        <?php echo set_question("自分自身のことについて、理屈っぽく考えるほうだ。", "q40", 2); ?>
        <br>
        <?php echo set_question("より個性に合わせた対応が求められるような場合でも、厳格で機械的な態度を崩さない傾向にある。", "q41", 1); ?>
        <?php echo set_question("人が求める言葉や対応を適切なタイミングで投げかけることに長けており、彼らのたどった過程がどんなものか考慮して寄り添うことが得意だ。", "q42", 3); ?>
        <?php echo set_question("自分自身に正直であり、本当の自分を周囲に知ってもらうのはとても大事なことだ。", "q43", 4); ?>
        <?php echo set_question("相手の意見に反対を表明するとき、常に相手の意見に対しては敬意を示す。", "q44", 3); ?>
        <?php echo set_question("自分ほど内省的ではない人を表面的に見抜くことができる。", "q45", 8); ?>
        <?php echo set_question("すべてを捨てて、まったく新しい生活を違う国で新しい仕事と共に新規スタートを切る自分を容易に想像できる。", "q46", 7); ?>
        <?php echo set_question("目下の仕事だけに集中することができずにいつも新しい物事に目移りしてしまい、中途半端に物事をやりくりしてしまう。", "q47", 7); ?>
        <?php echo set_question("多くの場合において、他人よりも独創的で大胆であることで成功を掴んでいる。", "q48", 7); ?>
        <?php echo set_question("人が団結しないで非効率に行動しているのを目にすると非常にイライラする。", "q49", 3); ?>
        <?php echo set_question("私は物事を大袈裟に解釈するタイプではない。", "q50", 5); ?>
        <?php echo set_question("自分オリジナルのスタイル感覚を持つことは私にとって重要であり、私のスタイルは通常の美しさの基準とは異なっている。", "q51", 6); ?>
        <?php echo set_question("他人に共感的で親切であることは、人生で最も重要なことの一つだ。", "q52", 3); ?>
        <?php echo set_question("私は、人の価値観や道徳性は、彼等の理性と同等に重要視している。", "q53", 4); ?>
        <?php echo set_question("ある特定の話題に一時夢中になるが、熱意が急激に冷めると、もはや目新しさがなくなり興味が失せていく。", "q54", 7); ?>
        <?php echo set_question("私は常に問題の本質について思い詰める傾向にあり、憑かれたように考え込んでしまう。", "q55", 5); ?>
        <?php echo set_question("人生における大概の出来事は既に起きたことの延長であり、実際には目新しいことではないのだということを考えるとき、気が休まらない。", "q56", 7); ?>
        <?php echo set_question("私は通常礼儀正しさや社会的規範に従い順守する方だ。", "q57", 6); ?>
        <?php echo set_question("人の短所よりも長所に自然に目が行く方だ。", "q58", 3); ?>
        <?php echo set_question("私は大抵、風変わりで厄介な発言をすることを考えている。", "q59", 7); ?>
        <?php echo set_question("すべてを合理的に処理できると考える。", "q60", 2); ?>
        <?php echo set_question("私はよく、争いになったとき無意識に弱い者の味方をする傾向にある。", "q61", 4); ?>
        <?php echo set_question("休暇中やパーティーゲームのようなレジャーの一時にでさえ、ルールや規律を要するタスクに変えてしまうことがあります。", "q62", 1); ?>
        <?php echo set_question("ヒエラルキーや権力といったものに対して自分がどう対応すればいいのか迷ってしまう。これといって意識的に反対しているわけではなく、対処の方法がよくわからない。", "q63", 2); ?>
        <?php echo set_question("職場でのやりとりや、朝9時に始まり午後5時に終業する仕事のルーチンについて不満不平を並べるような人はさっさと別の仕事を見つけるべきだ。", "q64", 1); ?>
        <?php echo set_question("私は自分の信念や表現方法を、聴衆や一緒にいる人々に合わせて調整するようなことはしない。", "q65", 4); ?>
        <?php echo set_question("過去の出来事について考えるとき、頭の中が様々な映像の洪水で溢れかえるようになる。", "q66", 6); ?>
        <?php echo set_question("洞察力に富んだ優れた分析を披露することは大いに結構だが、行動の原動力になるような代物でなければその価値は浅いと思う。", "q67", 5); ?>
        <?php echo set_question("重要な書類などをどこに置いたかを忘れがちだ。適切な保管場所を決めるのは私の得意とすることろではない。", "q68", 8); ?>
        <?php echo set_question("目標を達成することは、順調な経過を介するよりもより重要だ。", "q69", 1); ?>
        <?php echo set_question("私は通常、始めた主要な仕事は終わらせる方だ。", "q70", 1); ?>
        <?php echo set_question("私は自分の主張を、部分的にではなく、定まった確固たるものとして掲示する傾向にある。", "q71", 4); ?>
        <?php echo set_question("他人を評価することに興味はないし、自分が周りからどう見られているかということにも興味はない。人は人、自分は自分だ。", "q72", 2); ?>
        <?php echo set_question("私は周囲の人よりも際立った現実主義者だ。", "q73", 5); ?>
        <?php echo set_question("必要に迫られなくても、お金の節約と無駄の回避に気を配れる方だ。", "q74", 1); ?>
        <?php echo set_question("慎重な態度を維持するよりも、定義や概念や手法を見直すことに時間を費やす方だ。", "q75", 2); ?>
        <?php echo set_question("人の発言が公正で正しいかどうかを評価することは、彼らのたどった過程がどんなものか考慮するよりも重要だ。", "q76", 4); ?>
        <?php echo set_question("チャンスが来たら逃さないということは、念密な計画を練るより有効だ。", "q77", 5); ?>
        <?php echo set_question("自分にとって何が最善かということを見つけ出すことに最も興味があり、その理解を他の人の事柄に適用するようなことは二の次でいいと思う。", "q78", 8); ?>
        <?php echo set_question("何時間でも議論を交わすことができる。学問的な議論内容である限り延々と続けていられる。", "q79", 2); ?>
        <?php echo set_question("私は郊外の生活の適合性や慣習には特に悩まされていない。", "q80", 6); ?>
        <?php echo set_question("私は物事を型どおり適切に行うこととで知られている。", "q81", 6); ?>
        <?php echo set_question("自己の内省や瞑想に何時間でも費やすことができる。", "q82", 8); ?>
        <?php echo set_question("ただ目立ちたい為に派手な服装をしたり、おかしな言動を行う人を見ると苛立つ。", "q83", 3); ?>
        <?php echo set_question("結果を出せるならば手段を選ばない、といった概念には大いに賛成する方だ。", "q84", 2); ?>
        <?php echo set_question("物事はあるがままではなく、私達の言うことには重要性がある。", "q85", 8); ?>
        <?php echo set_question("身の回りの出来事に鈍感で、何か起きた場合には見逃してしまう。", "q86", 8); ?>
        <?php echo set_question("私たちが受け継いだ社会と同等あるいはそれ以上により良い社会を次世代に委ねることが重要だ。", "q87", 6); ?>
        <?php echo set_question("全て計画して行動しないと気が治らないような人は順応性に欠けていると思う。", "q88", 5); ?>
      </ul>
      <br>
      <button type="button" class="btn btn-primary" name="b1" id="btn-check">診断</button>
      <button type="button" class="btn btn-primary" name="b2" id="btn-clear">すべてのチェックをはずす</button>
      <button type="button" class="btn btn-primary" name="b3" id="btn-save" pys-onClick="save">保存(工事中)</button>
      <hr>
      <h3>結果</h3>
      <p>各設問の「強く」３点、「はい」２点、「まあ」１点、「あまり」－１点、「いいえ」－２点、「全く」－３点として、タイプ別に以下の設問群で合計します。</p>
      <p>最高得点のタイプを貴方の性格タイプとします。最高点に同点がいくつかある人、または、最高点に近い高得点タイプがいくつかある人は、それらのタイプの傾向を持ち合わせている人か、または、その中間のタイプの人です。</p>
      <p>ごくおおざっぱに表現しているので、詳しくは、ユング心理学の入門書、解説書などをご覧下さい。</p>      
      <table class="table table-success table-bordered table-striped table-hover text-nowrap" >
        <thead>
          <tr>
            <th class="text-center" scope="col">結果</th>
            <th class="text-center" scope="col">解説</th>
            <th class="text-center" scope="col">設問箇所</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>外向的思考タイプ　<input name="d1" id="d1" SIZE="5" readonly="readonly"></td>
            <td>客観的な事実を重要視して、それに基づいて筋道をたてて考えるタイプの人。<br>自分の考えよりも客観的事実の方が大事で、感情表現が苦手。<br>男性に多い。女性ではごくわずか。</td>
            <td>６、１２、２２、２５、３９、４１、６２、６４、６９、７０、７４</td>
          </tr>
          <tr>
            <td>内向的思考タイプ　<input name="d2" id="d2" SIZE="5" readonly="readonly"></td>
            <td>自分自身の心の中に浮かび上がる考えを筋道立てて追うのが得意な人。<br>新しい事実の発見よりも新しい考え方の発明の方が大事。<br>感情面が未発達のことが多い。男性に多い。</td>
            <td>４、１５、１９、３２、４０、６０、６３、７２、７５、７９、８４</td>
          </tr>
          <tr>
            <td>外向的感情タイプ　<input name="d3" id="d3" SIZE="5" readonly="readonly"></td>
            <td>どこでどういう感情を使ったらよいかよく知っており、自分の感情をよくコントロールする。<br>周囲の状況をよく理解して、他人と良い関係を保つことが得意な人。社交上手。<br>しかし、哲学など理屈を考えるのは全く苦手。女性に多い。男性にも見かける。</td>
            <td>１、１３、２０、２８、３７、４２、４４、４９、５２、５８、８３</td>
          </tr>
          <tr>
            <td>内向的感情タイプ　<input name="d4" id="d4" SIZE="5" readonly="readonly"></td>
            <td>心の中に好き嫌いの判断を持っていて、自分の心の中に描いた心像に忠実である。<br>一方で、それと関係ない人たちを全く無視してしまうので、自己中心的で、時に傲慢な印象を与える。<br>感情面にすばらしい判断力を持っているが、その表現力が不十分で、周囲に誤解されやすいといえる。<br>思考面が未発達のことがおおい。</td>
            <td>５、１０、１７、２７、３４、４３、５３、６１、６５、７１、７６</td>
          </tr>
          <tr>
            <td>外向的感覚タイプ　<input name="d5" id="d5" SIZE="5" readonly="readonly"></td>
            <td>現実の人や物事に対して、具体的に身体的感覚で感じ取ることが得意な人。<br>色や形によいセンスを持っている。しかし、直感的総合力には欠ける。<br>男性にも女性にもいる。</td>
            <td>３、１６、２３、２９、３６、５０、５５、６７、７３、７７、８８</td>
          </tr>
          <tr>
            <td>内向的感覚タイプ　<input name="d6" id="d6" SIZE="5" readonly="readonly"></td>
            <td>外からの刺激をじっくりと自分の感覚に吸収し取り込むが、すぐには表現しない。<br>またそれがその人自身の主観的印象が主体となってしまうので、誤解を受けやすい。<br>直観による将来的見通しが全く苦手で、概して方向音痴。</td>
            <td>２、９、２１、３０、３３、５１、５７、６６、８０、８１、８７</td>
          </tr>
          <tr>
            <td>外向的直観タイプ　<input name="d7" id="d7" SIZE="5" readonly="readonly"></td>
            <td>直観は、直接無意識に根ざしている心機能で、周囲の人やものや将来の見通しなどにカンが働く。<br>流行に敏感。感覚が未発達なので、周囲のものごとをじっくり捕らえることが出来ない。<br>どちらかというと女性に多くみられる。</td>
            <td>７、１４、１８、２６、３８、４６、４７、４８、５４、５６、５９</td>
          </tr>
          <tr>
            <td>内向的直観タイプ　<input name="d8" id="d8" SIZE="5" readonly="readonly"></td>
            <td>カンがよく将来の見通しなどもよく見えるが、そのカンは外の社会には向けられず、もっぱら心の内に向かっている。<br>弱点は感覚で、まわりの状況や事実をよく見ようとしない。<br>「特定」や「オシント」ではこの機能を使って情報収集する</td>
            <td>８、１１、２４、３１、３５、４５、６８、７８、８２、８５、８６</td>
          </tr>
        </tbody>
      </table>
      <br>
      <textarea class="form-control" name="dd" id="dd" rows="3" cols="70" readonly="readonly"></textarea>
      <p>この診断結果は、梵語の練習問題のレイアウトや辞書の検索処理に使うことを想定しています。<p> 
    </form>
    <h3>解説</h3>
    <p>こちらのサイトを改良して作りました。<p>   
    <p>http://miztools.so.land.to/js-tools/diag/Jung.html<p>
    <p>ごくおおざっぱに表現しているので、詳しくは、ユング心理学の入門書、解説書などをご覧下さい。</p>
    <p>参考文献：ここでは、<cite>「別冊宝島６　性格の本」あなたはどのタイプか－秋山さと子著（1977年初版、JICC出版局）</cite>に載っている性格診断表で作りました。</p>
    <p>参考ページ：<cite>https://www.idrlabs.com/jp/cognitive-function/test.php</cite>(40-88問)</p>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>

