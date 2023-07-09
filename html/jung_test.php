<?php
session_start();
header("Content-type: text/html; charset=utf-8");

function set_question($question, $id){
  return '';
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
    <?php require_once("header.php"); ?>
    <script type="text/javascript">
      nn  = 8;
      num = new Array(nn+1);
      jun = new Array(nn+1);
      a_type = new Array(0,3,6,5,2,4,1,7,8,
                           6,4,8,1,3,7,2,5,
                           4,7,2,3,6,1,5,8,
                           1,7,4,3,5,6,8,2,
                           6,4,8,5,3,7,1,2 );

      str_type = new Array(":","外向的思考タイプ","内向的思考タイプ",
        "外向的感情タイプ","内向的感情タイプ","外向的感覚タイプ","内向的感覚タイプ",
        "外向的直観タイプ","内向的直観タイプ")


      function diag(this_form){
        for (var i=1; i<=nn; i++) {
          num[i] = 0;
          jun[i] = i;
        }
      
        with(this_form) {
          var chk = "\nchk_data:";
          for (var j=1; j<=40; j++) {
            var ename = "q" + j + "_v" ;
            var vv    =  parseInt( elements[ename].value );
            num[a_type[j] ] += vv;
            chk += ename + "=" + vv +"| ";
          }
          for (var i=1; i<=nn; i++) {
            var ename = "d" + i;
            elements[ename].value = num[i] ;
          }
        
          elements["dd"].value ="";
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
            t_str += "\n　" + str_type[mi];
          }
        
          elements["dd"].value = "最高点は、" +num[1]+  "でした。\nあなたの性格タイプの候補は、" +t_str+"\nと考えられます。";
        
      //     elements["dd"].value += chk;  // 設問check data
        }
      }
    
      function rbtn_clk(this_value,this_name,this_form){
        with(this_form) {
          var ename =   this_name + "_v" ;
          elements[ename].value =  this_value  ;
        }
      }
    
      function clr_v(this_form){
        with(this_form) {
          for (var j=1; j<=40; j++) {
            var ename = "q" + j + "_v" ;
            elements[ename].value = 0;
          }
        }
      }
    </script>
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
      <section class="row my-1">
        <div class="col-md-3">
          <li>社交的なフンイキにひかれ、人の中に入っていくのが好きな方だ。</li>
        </div>
        <div class="col-md-1">
          <input type="hidden" name="q1_v" value="0">
          <label><input name="q1" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
        </div>
        <div class="col-md-1">
          <label><input name="q1" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
        </div>
        <div class="col-md-1">
          <label><input name="q1" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
        </div>
        <div class="col-md-1">
          <label><input name="q1" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
        </div>
      </section>
      <li>強い心の中からまきおこる感覚をひきおこすものを重視するほうだ。
      <br>
      <input type="hidden" name="q2_v" value="0" >
      <label><input name="q2" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q2" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q2" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q2" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>まわりの出来事を理論よりも感覚でとらえるほうだ。
      <br>
      <input type="hidden" name="q3_v" value="0" >
      <label><input name="q3" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q3" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q3" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q3" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>親しい気の合った人とだけ議論しようとするほうだ。
      <br>
      <input type="hidden" name="q4_v" value="0" >
      <label><input name="q4" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q4" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q4" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q4" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>自分独自の価値基準をもとうとするほうだ。
      <br>
      <input type="hidden" name="q5_v" value="0" >
      <label><input name="q5" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q5" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q5" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q5" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>事実を重視し、ものごとをとことんまで考えようとするほうだ。
      <br>
      <input type="hidden" name="q6_v" value="0" >
      <label><input name="q6" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q6" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q6" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q6" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>ものごとそのものよりも、その可能性に注目するほうだ。
      <br>
      <input type="hidden" name="q7_v" value="0" >
      <label><input name="q7" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q7" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q7" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q7" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>自分のなかに沈みこみ、ある種の予感を大切にするほうだ
      <br>
      <input type="hidden" name="q8_v" value="0" >
      <label><input name="q8" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q8" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q8" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q8" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>感受性が強く、自分の世界に耽溺するほうだ。
      <br>
      <input type="hidden" name="q9_v" value="0" >
      <label><input name="q9" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q9" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q9" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q9" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>好き嫌いがはげしく、気の合った少数の人としかつき合わないほうだ。
      <br>
      <input type="hidden" name="q10_v" value="0" >
      <label><input name="q10" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q10" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q10" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q10" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>未来を自分の内にひらめくカンに頼って切り開いていくほうだ。
      <br>
      <input type="hidden" name="q11_v" value="0" >
      <label><input name="q11" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q11" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q11" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q11" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>大事な決定をするときは、周囲の状況を論理的に分析してきめるほうだ。
      <br>
      <input type="hidden" name="q12_v" value="0" >
      <label><input name="q12" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q12" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q12" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q12" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>自分の判断が、周りの人の判断とよく一致するほうだ。
      <br>
      <input type="hidden" name="q13_v" value="0" >
      <label><input name="q13" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q13" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q13" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q13" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>ものごとを理屈ではなく、直観によって見きわめようとするほうだ。
      <br>
      <input type="hidden" name="q14_v" value="0" >
      <label><input name="q14" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q14" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q14" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q14" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>まわりのできごとよりも、人間について理解を深めようとするほうだ。
      <br>
      <input type="hidden" name="q15_v" value="0" >
      <label><input name="q15" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q15" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q15" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q15" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>生活を楽しむために、まわりの刺激を求めるほうだ。
      <br>
      <input type="hidden" name="q16_v" value="0" >
      <label><input name="q16" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q16" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q16" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q16" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>自分の気持ちは心の中にそっととどめておくほうだ。
      <br>
      <input type="hidden" name="q17_v" value="0" >
      <label><input name="q17" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q17" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q17" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q17" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>理屈よりもカンに頼って、現実の問題を解決するほうだ。
      <br>
      <input type="hidden" name="q18_v" value="0" >
      <label><input name="q18" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q18" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q18" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q18" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>抽象的な概念や、考え方にひかれるほうだ。
      <br>
      <input type="hidden" name="q19_v" value="0" >
      <label><input name="q19" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q19" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q19" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q19" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>自分のしていることが、社会的に認められるかどうかが気になるほうだ。
      <br>
      <input type="hidden" name="q20_v" value="0" >
      <label><input name="q20" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q20" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q20" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q20" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>まわりのできごとよりも、自分の中におこる強い印象に喜びを感じるほうだ。
      <br>
      <input type="hidden" name="q21_v" value="0" >
      <label><input name="q21" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q21" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q21" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q21" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>感情よりも、理論を先にたてて行動するほうだ。
      <br>
      <input type="hidden" name="q22_v" value="0" >
      <label><input name="q22" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q22" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q22" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q22" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>まわりにあるものごとに、敏感なほうだ。
      <br>
      <input type="hidden" name="q23_v" value="0" >
      <label><input name="q23" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q23" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q23" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q23" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>心にひらめいたことを、他人に伝えるのがうまくないほうだ。
      <br>
      <input type="hidden" name="q24_v" value="0" >
      <label><input name="q24" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q24" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q24" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q24" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>自分自身のことよりも、まわりのできごとをよく考えるほうだ。
      <br>
      <input type="hidden" name="q25_v" value="0" >
      <label><input name="q25" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q25" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q25" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q25" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>難しい状況にであうと、理屈よりもカンに頼るほうだ。
      <br>
      <input type="hidden" name="q26_v" value="0" >
      <label><input name="q26" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q26" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q26" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q26" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>まわりのことは気にしないで、自分なりの見方を大切にするほうだ。
      <br>
      <input type="hidden" name="q27_v" value="0" >
      <label><input name="q27" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q27" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q27" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q27" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>一般的な判断にもとづいた、常識を重んじるほうだ。
      <br>
      <input type="hidden" name="q28_v" value="0" >
      <label><input name="q28" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q28" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q28" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q28" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>感受性が強く、まわりの刺激に影響されやすいほうだ。
      <br>
      <input type="hidden" name="q29_v" value="0" >
      <label><input name="q29" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q29" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q29" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q29" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>自分自身を理屈よりも、感覚でとらえようとするほうだ。
      <br>
      <input type="hidden" name="q30_v" value="0" >
      <label><input name="q30" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q30" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q30" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q30" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>まわりのできごとよりも、自分の心の中からでてくる可能性を求めるほうだ。
      <br>
      <input type="hidden" name="q31_v" value="0" >
      <label><input name="q31" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q31" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q31" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q31" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <br>
      <li>自分自身を哲学的にいろいろと考えようとするほうだ。
      <br>
      <input type="hidden" name="q32_v" value="0" >
      <label><input name="q32" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q32" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q32" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q32" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>心の中から湧きあがる強い印象に心奪われるほうだ。
      <br>
      <input type="hidden" name="q33_v" value="0" >
      <label><input name="q33" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q33" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q33" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q33" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>善・悪や美・醜の判断に、自分独特の考えをもつほうだ。
      <br>
      <input type="hidden" name="q34_v" value="0" >
      <label><input name="q34" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q34" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q34" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q34" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>心の中にひらめいたもので、自分の将来の夢を追うほうだ。
      <br>
      <input type="hidden" name="q35_v" value="0" >
      <label><input name="q35" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q35" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q35" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q35" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>行動のあり方が、感覚に訴えるものに左右されやすいほうだ。
      <br>
      <input type="hidden" name="q36_v" value="0" >
      <label><input name="q36" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q36" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q36" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q36" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>理屈っぽく考えないで、すぐに良いか悪いかをきめるほうだ。
      <br>
      <input type="hidden" name="q37_v" value="0" >
      <label><input name="q37" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q37" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q37" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q37" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>自分の心の内にひらめくものによって行動するほうだ。
      <br>
      <input type="hidden" name="q38_v" value="0" >
      <label><input name="q38" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q38" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q38" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q38" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>客観的な事実にもとづいて、論理的に考えようとするほうだ。
      <br>
      <input type="hidden" name="q39_v" value="0" >
      <label><input name="q39" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q39" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q39" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q39" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>
      <li>自分自身のことについて、理屈っぽく考えるほうだ。
      <br>
      <input type="hidden" name="q40_v" value="0" >
      <label><input name="q40" type="radio" value="2" onClick="rbtn_clk(this.value,this.name,this.form)">はい</label>
      <label><input name="q40" type="radio" value="1" onClick="rbtn_clk(this.value,this.name,this.form)">まあ</label>
      <label><input name="q40" type="radio" value="-1" onClick="rbtn_clk(this.value,this.name,this.form)">あまり</label>
      <label><input name="q40" type="radio" value="-2" onClick="rbtn_clk(this.value,this.name,this.form)">いいえ</label>

      </ul>
      <br>
      <input type="button" value="診断" name="b1" onclick="diag(this.form)">
      <input type="reset" value="すべてのチェックをはずす"  onclick="clr_v(this.form)">
      <hr>
      <h3>結果</h3>
      <table>
        <tr><td>外向的思考タイプ　<input name="d1" SIZE="5">；<td>内向的思考タイプ　<input name="d2" SIZE="5">；</tr>
        <tr><td>外向的感情タイプ　<input name="d3" SIZE="5">；<td>内向的感情タイプ　<input name="d4" SIZE="5">；</tr>
        <tr><td>外向的感覚タイプ　<input name="d5" SIZE="5">；<td>内向的感覚タイプ　<input name="d6" SIZE="5">；</tr>
        <tr><td>外向的直観タイプ　<input name="d7" SIZE="5">；<td>内向的直観タイプ　<input name="d8" SIZE="5">；</tr>
      </table>
      <br>
      <textarea name="dd" rows="3" cols="70"></textarea>
    </form>
    <h3>解説</h3>
    <ul>
<li>集計　＆　判定法
<br>
　各設問の「はい</label>」２点、「まあ</label>」１点、「あまり</label>」－１点、「いいえ</label>」－２点
として、タイプ別に以下の設問群で合計します。
 <ul>
 <li>外向的思考タイプ：６，１２，２２，２５，３９
 <li>内向的思考タイプ：４，１５，１９，３２，４０
 <li>外向的感情タイプ：１，１３，２０，２８，３７
 <li>内向的感情タイプ：５，１０，１７，２７，３４
 <li>外向的感覚タイプ：３，１６，２３，２９，３６
 <li>内向的感覚タイプ：２，９，２１，３０，３３
 <li>外向的直観タイプ：７，１４，１８，２６，３８
 <li>内向的直観タイプ：８，１１，２４，３１，３５
 </ul>
　最高得点のタイプを貴方の性格タイプとします。
最高点に同点がいくつかある人、または、最高点に近い高得点タイプが
いくつかある人は、それらのタイプの傾向を持ち合わせている人か、または、
その中間のタイプの人です。
<br><br>
<li>各タイプの簡単な解説
<br>ごくおおざっぱに表現しているので、詳しくは、ユング心理学の入門書、解説書などを
ご覧下さい。
 <ul>
 <li>外向的思考タイプ：客観的な事実を重要視して、それに基づいて筋道をたてて
考えるタイプの人。自分の考えよりも客観的事実の方が大事で、感情表現が苦手。
男性に多い。女性ではごくわずか。
<br><br>
 <li>内向的思考タイプ：自分自身の心の中に浮かび上がる考えを
筋道立てて追うのが得意な人。
新しい事実の発見よりも新しい考え方の発明の方が大事。感情面が未発達のことが多い。
男性に多い。
<br><br>
 <li>外向的感情タイプ：どこでどういう感情を使ったらよいかよく知っており、
自分の感情をよくコントロールし、周囲の状況をよく理解して、
他人と良い関係を保つことが得意な人。社交上手。
しかし、哲学など理屈を考えるのは全く苦手。
女性に多い。男性にも見かける。
<br><br>
 <li>内向的感情タイプ：心の中に好き嫌いの判断を持っていて、
自分の心の中に描いた心像に忠実であるが、それと関係ない人たちを
全く無視してしまうので、自己中心的で、時に傲慢な印象を与える。
感情面にすばらしい判断力を持っているが、その表現力が不十分で、周囲に誤解されやすいといえる。
思考面が未発達のことがおおい。
女性に多い。
<br><br>
 <li>外向的感覚タイプ：現実の人や物事に対して、具体的に身体的感覚で
感じ取ることが得意な人。色や形によいセンスを持っている。
しかし、直感的総合力には欠ける。
男性にも女性にもいる。
<br><br>
 <li>内向的感覚タイプ：外からの刺激をじっくりと自分の感覚に吸収し、取り込むが、
それを、すぐには表現しない、または、その人自身の主観的印象が主体となってしまう
ので、誤解を受けやすい。直観による将来的見通しが全く苦手で、概して方向音痴。
<br><br>
 <li>外向的直観タイプ：直観は、直接無意識に根ざしている心機能で、
周囲の人やものや将来の見通しなどにカンが働く。流行に敏感。
感覚が未発達なので、周囲のものごとをじっくり捕らえることが出来ない。
どちらかというと女性に多くみられる。
<br><br>
 <li>内向的直観タイプ：カンがよく将来の見通しなどもよく見えるが、そのカンは外の社会には向けられず、もっぱら心の内に向かっている。
弱点は感覚で、まわりの状況や事実をよく見ようとしない。
 </ul>
<br>
<li>参考文献：ここでは、
<cite>
「別冊宝島６　性格の本」あなたはどのタイプか－秋山さと子著
（1977年初版、JICC出版局）
</cite>
に載っている性格診断表で作りました。
    </ul>
  </body>
</html>
