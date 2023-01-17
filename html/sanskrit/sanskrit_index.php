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
    <link href="/../css/style.css" rel="stylesheet">
    <script type="text/javascript" src="/../js/input_button.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">
    <title>印欧語活用辞典 - ヴェーダ語・梵語</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
    <?php require_once("sanskrit_header.php"); ?>
  </head>
  <body>
    <div class="container item table-striped">
        <h1 align="center">概要</h1>
        <p class="text-center">このページはヴェーダ語・梵語の辞書および学習ができるサイトです。</p>
        <p class="text-center">この辞書は造語や借用語にも対応しています。</p>
        <p class="text-center">日本人に論理的で正確なインドヨーロッパ語を手軽に学習できるように作りました。</p>
        <p class="text-center">全てのコンテンツは無料です。ぜひご自由にお使いください。</p>
        <h1 align="center">文章例</h1>
        <h5 align="center">国際歌(ヴェーダ語版)</h5>
        <p class="text-center">Udihi, baddha nāgara!</p>
        <p class="text-center">Udihi, pīḍita jana!</p>
        <p class="text-center">Kraudha sarvāya śāsitrai</p>
        <p class="text-center">Jvālāmukhīvat nirvāpayiṣyati</p>
        <p class="text-center">Sarvān śāsitrn nibarbṛhāma</p>
        <p class="text-center">Janāsaḥ, yāyāvarāsaḥ, uttiṣṭhāma!</p>
        <p class="text-center">Lauka tadīyam ādhāram vikāriṣyātāi</p>
        <p class="text-center">Asmadiyāyāvarātmanā vinā nipuṇaina</p>
        <p class="text-center"></p>
        <p class="text-center">Antimaḥ saṅgharṣaḥ asati</p>
        <p class="text-center">Bandhāma, Āryāsaḥ!</p>
        <p class="text-center">Sahakārī samāja vinā nipuṇaina</p>
        <p class="text-center">Vāibhavaina pūrṇa bhūyāt</p>
        <p class="text-center"></p>
        <p class="text-center">Rāṣṭrīyaḥ śūraḥ rājyam</p>
        <p class="text-center">Rāṣṭrapatiḥ ca rājānaḥ nāsānti</p>
        <p class="text-center">Janāsaḥ rājāmahāi</p>
        <p class="text-center">Asmatkalyāņam Saṃvidhāmahāi</p>
        <p class="text-center">Cauraḥ vilupam upajagāmāti iti</p>
        <p class="text-center">Kārāgṛhāsya ātman apajagāmāti iti</p>
        <p class="text-center">Asmadyantraśālām kārayiṣyāma</p>
        <p class="text-center">Ayam tudāma kadā uṣṇayāti</p>
        <p class="text-center"></p>
        <p class="text-center">Antimaḥ saṅgharṣaḥ asati</p>
        <p class="text-center">Bandhāma, Āryāsaḥ!</p>
        <p class="text-center">Sahakārī samāja vinā nipuṇaina</p>
        <p class="text-center">Vāibhavaina pūrṇa bhūyāt</p>
        <p class="text-center"></p>
        <p class="text-center">Rājyam haṭhīt, adhiniyama vañkīt</p>
        <p class="text-center">Karaina asmat caurayanti</p>
        <p class="text-center">kṣatriyaḥ ca dhanikaḥ ucitām asanti</p>
        <p class="text-center">kintu sarvam ucitām nasāmaḥ</p>
        <p class="text-center">rājam ca śīṣaņam daidviṣmaḥ</p>
        <p class="text-center">navavidhim apaikṣiṣāmahāi</p>
        <p class="text-center">ucitā kartavyasya asatu</p>
        <p class="text-center">kartavyam ucitāyāḥ asatu</p>
        <p class="text-center"></p>
        <p class="text-center">Antimaḥ saṅgharṣaḥ asati</p>
        <p class="text-center">Bandhāma, Āryāsaḥ!</p>
        <p class="text-center">Sahakārī samāja vinā nipuṇaina</p>
        <p class="text-center">Vāibhavaina pūrṇa bhūyāt</p>
    </div>
  </body>
  <footer class="">
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>