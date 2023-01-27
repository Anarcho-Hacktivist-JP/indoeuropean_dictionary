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
                    <th style="width:10%" class="text-center">2023/1/27</th>
                    <th style="width:10%" class="text-center">Ver 1.27</th>
                    <td>・梵語の名詞を修正<br>・ラテン語、梵語、ポーランド語の名詞に名詞種別の選択を追加</td>
                </tr>
                <tr>
                    <th style="width:10%" class="text-center">2023/1/26</th>
                    <th style="width:10%" class="text-center">Ver 1.26</th>
                    <td>・ラテン語の動詞・ポーランド語の名詞を修正<br>・梵語の連音処理を修正</td>
                </tr>             
                <tr>
                    <th style="width:10%" class="text-center">2023/1/25</th>
                    <th style="width:10%" class="text-center">Ver 1.25</th>
                    <td>・ギリシア語の処理を修正<br>・ギリシア語の名詞の単語を追加</td>
                </tr>
                <tr>
                    <th style="width:10%" class="text-center">2023/1/23</th>
                    <th style="width:10%" class="text-center">Ver 1.24</th>
                    <td>・ギリシア語の処理を修正<br>・ギリシア語の名詞と形容詞の単語を追加</td>
                </tr>
                <tr>
                    <th style="width:10%" class="text-center">2023/1/19</th>
                    <th style="width:10%" class="text-center">Ver 1.23</th>
                    <td>・古形切り替えボタンを設置<br>・練習問題の表示を修正</td>
                </tr>
                <tr>
                    <th style="width:10%" class="text-center">2023/1/19</th>
                    <th style="width:10%" class="text-center">Ver 1.23</th>
                    <td>・ヴェーダ語、ラテン語の造語処理を修正</td>
                </tr>
                <tr>
                    <th style="width:10%" class="text-center">2023/1/16</th>
                    <th style="width:10%" class="text-center">Ver 1.22</th>
                    <td>・ポーランド語の動詞のデータベースを更新</td>
                </tr> 
                <tr>
                    <th style="width:10%" class="text-center">2023/1/16</th>
                    <th style="width:10%" class="text-center">Ver 1.21</th>
                    <td>・サイトの構造を大幅変更</td>
                </tr>
                <tr>
                    <th style="width:10%" class="text-center">2023/1/14</th>
                    <th style="width:10%" class="text-center">Ver 1.20</th>
                    <td>・梵語のデータベースを更新</td>
                </tr>
                <tr>
                    <th style="width:10%" class="text-center">2023/1/7</th>
                    <th style="width:10%" class="text-center">Ver 1.19</th>
                    <td>・梵語の動詞の表を修正</td>
                </tr>       
                <tr>
                    <th style="width:10%" class="text-center">2023/1/4</th>
                    <th style="width:10%" class="text-center">Ver 1.18</th>
                    <td>・サイトの構造を大幅変更</td>
                </tr>
                <tr>
                    <th style="width:10%" class="text-center">2023/12/30</th>
                    <th style="width:10%" class="text-center">Ver 1.17</th>
                    <td>・複合語の検索処理を日本語のみに限定<br>・梵語のデータベースを更新</td>
                </tr>
                <tr>
                    <th style="width:10%" class="text-center">2023/12/29</th>
                    <th style="width:10%" class="text-center">Ver 1.16</th>
                    <td>・梵語の表レイアウトを更新</td>
                </tr>
                <tr>
                    <th style="width:10%" class="text-center">2023/12/28</th>
                    <th style="width:10%" class="text-center">Ver 1.15</th>
                    <td>・すべての言語に言語別の検索処理を実装(英語・日本語・固有語)</td>
                </tr>
                <tr>
                    <th style="width:10%" class="text-center">2023/12/26</th>
                    <th style="width:10%" class="text-center">Ver 1.14</th>
                    <td>・ポーランド語の検索処理を修正</td>
                </tr> 
                <tr>
                    <th style="width:10%" class="text-center">2022/12/23</th>
                    <th style="width:10%" class="text-center">Ver 1.13</th>
                    <td>・ギリシア語の名詞と形容詞の表レイアウトを修正<br>・ギリシア語の動詞の処理を修正<br>・ラテン語の動詞の検索処理を修正</td>
                </tr> 
                <tr>
                    <th style="width:10%" class="text-center">2022/12/22</th>
                    <th style="width:10%" class="text-center">Ver 1.12</th>
                    <td>・ラテン語の動詞データベースを更新</td>
                </tr> 
                <tr>
                    <th style="width:10%" class="text-center">2022/12/21</th>
                    <th style="width:10%" class="text-center">Ver 1.10</th>
                    <td>・梵語の動詞データベースを更新<br>・梵語の欠如動詞の出力を修正<br>・梵語の名詞起源動詞の処理を修正</td>
                </tr> 
                <tr>
                    <th style="width:10%" class="text-center">2022/12/20</th>
                    <th style="width:10%" class="text-center">Ver 1.09</th>
                    <td>・梵語の動詞データベースを更新<br>・梵語とラテン語の欠如動詞の出力を修正</td>
                </tr> 
                <tr>
                    <th style="width:10%" class="text-center">2022/12/19</th>
                    <th style="width:10%" class="text-center">Ver 1.08</th>
                    <td>・梵語の動詞データベースを更新<br>・梵語の欠如動詞の出力を修正<br>・梵語の形容詞で語幹がない場合の処理を修正</td>
                </tr>     
                <tr>
                    <th style="width:10%" class="text-center">2022/12/17</th>
                    <th style="width:10%" class="text-center">Ver 1.07</th>
                    <td>・動詞の練習問題の処理を修正</td>
                </tr>  
                <tr>
                    <th style="width:10%" class="text-center">2022/12/15</th>
                    <th style="width:10%" class="text-center">Ver 1.06</th>
                    <td>・ギリシア語の動詞処理を修正<br>・ギリシア語の文字変換処理を修正</td>
                </tr>    
                <tr>
                    <th style="width:10%" class="text-center">2022/12/15</th>
                    <th style="width:10%" class="text-center">Ver 1.05</th>
                    <td>・英語検索の処理を修正</td>
                </tr>                
                <tr>
                    <th style="width:10%" class="text-center">2022/12/12</th>
                    <th style="width:10%" class="text-center">Ver 1.04</th>
                    <td>・入力欄に入力内容の説明を記載</td>
                </tr>
                <tr>
                    <th style="width:10%" class="text-center">2022/12/08</th>
                    <th style="width:10%" class="text-center">Ver 1.03</th>
                    <td>・ポーランド語で古い形式の活用をグレーアウト<br>・ポーランド語で比較級の生成方法を修正</td>
                </tr>
                <tr>
                    <th style="width:10%" class="text-center">2022/12/07</th>
                    <th style="width:10%" class="text-center">Ver 1.02</th>
                    <td>・ラテン語の形容詞に英訳を追加<br>・その他指摘を受けて修正</td>
                </tr>
                <tr>
                    <th style="width:10%" class="text-center">2022/12/04</th>
                    <th style="width:10%" class="text-center">Ver 1.01</th>
                    <td>・ポーランド語に新しい名詞活用区分を作成</td>
                </tr>
                <tr>
                    <th style="width:10%" class="text-center">2022/12/03</th>
                    <th style="width:10%" class="text-center">Ver 1.00</th>
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