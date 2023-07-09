<?php
session_start();
header("Content-type: text/html; charset=utf-8");
?>
<!doctype html>
<html lang="ja">
  <head>
    <?php require_once("polish_including.php"); ?>
    <title>印欧語活用辞典 - ポーランド語</title>
  </head>
  <body>
    <?php require_once("polish_header.php"); ?>
    <div class="container item table-striped">
    <div class="container-fluid highlight">
      <section class="container">
        <h2 align="align1 mb-5"><span>本辞書の目的</span></h2>
        <p align="center"><br></p>
        <p align="center">このページはポーランド語の辞書および学習ができるサイトです。</p>
        <p align="center">この辞書は造語や借用語にも一部対応しています。</p>
        <p align="center">日本人に論理的で正確なインドヨーロッパ語を手軽に学習できるように作りました。</p>
        <p align="center">全てのコンテンツは無料です。ぜひご自由にお使いください。</p>
      </section>
    </div>
    <section class="container-md">
      <section class="mb-5">
        <h3 class="c-small_headline c-center">文章例</h3>
      </section>
    </section>
  </body>
  <footer class="">
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>