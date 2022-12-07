<?php
session_start();

header("Content-type: text/html; charset=utf-8");

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
    <title>印欧語活用辞典</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
  <?php require_once("header.php"); ?>
  </head>
  <body>
    <div class="container item table-striped">
        <h1 align="center">更新履歴 </h1>
        <table border="1" align="center" class="table table-success table-bordered table-striped table-hover">
            <tbody>
                <tr>
                    <th>2022/12/03</th>
                    <th>Ver 1.00</th>
                    <td>・初版リリース<br>・サーバー環境に合わせて一部処理を修正<br>
                        ・ポーランド語のデータベースを更新<br>・更新履歴を作成
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
  </body>
  <footer class="">
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>