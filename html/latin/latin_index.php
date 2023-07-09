<?php
session_start();
header("Content-type: text/html; charset=utf-8");
?>
<!doctype html>
<html lang="ja">
  <head>
    <?php require_once("latin_including.php"); ?>
    <title>印欧語活用辞典 - ラテン語</title>
  </head>
  <body>
    <?php require_once("latin_header.php"); ?>
    <div class="container-fluid highlight">
      <section class="container">
        <h2 align="align1 mb-5"><span>本辞書の目的</span></h2>
        <p align="center"><br></p>
        <p align="center">このページはラテン語の辞書および学習ができるサイトです。</p>
        <p align="center">この辞書は造語や借用語にも対応しています。</p>
        <p align="center">日本人に論理的で正確なインドヨーロッパ語を手軽に学習できるように作りました。</p>
        <p align="center">全てのコンテンツは無料です。ぜひご自由にお使いください。</p>
      </section>
    </div>
    <section class="container-md">
      <section class="mb-5">
        <h3 class="c-small_headline c-center">文章例</h3>
        <div class="c-body c-center">
          <h4 align="center"><span>01</span>我々は勝つ(ラテン語版)</h4>
          <p align="center">Dē calumniā papistae</p>
          <p align="center">Vocēs hominum surgunt</p>
          <p align="center">Nigrum vexillum super horizōni advenit</p>
          <p align="center">Nunc mundī hōc carmen cantāmus</p>
          <p align="center"><br></p>
          <p align="center">Recordātīs dē cataloniā et rutheniā,</p>
          <p align="center">Nos excitāmus et armāmus</p>
          <p align="center">Nos mortem ēligēmus</p>
          <p align="center">Numquam neminibus oboedīmur</p>
          <p align="center"><br></p>
          <p align="center">Vincēmus vincēmus</p>
          <p align="center">Nigrā vexillā illōs pellēmus</p>
          <p align="center">Vincēmus vincēmus</p>
          <p align="center">Imperia papistae pellēre poterimus</p>
        </div>
      </section>
    </section>
  </body>
  <footer class="">
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>