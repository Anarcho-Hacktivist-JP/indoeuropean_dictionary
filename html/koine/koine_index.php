<?php
session_start();
header("Content-type: text/html; charset=utf-8");
?>
<!doctype html>
<html lang="ja">
  <head>
    <?php require_once("koine_including.php"); ?>
    <title>印欧語活用辞典 - ギリシア語</title>
  </head>
  <body>
    <?php require_once("koine_header.php"); ?>
    <div class="container item table-striped">
        <h1 align="center">概要</h1>
        <p class="text-center">このページはギリシア語の辞書および学習ができるサイトです。</p>
        <p class="text-center">日本人に論理的で正確なインドヨーロッパ語を手軽に学習できるように作りました。</p>
        <p class="text-center">全てのコンテンツは無料です。ぜひご自由にお使いください。</p>
        <h1 align="center">文章例</h1>
    </div>
  </body>
  <footer class="">
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>