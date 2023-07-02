<?php
session_start();
header("Content-type: text/html; charset=utf-8");
?>
<!doctype html>
<html lang="ja">
  <head>
    <?php require_once("sanskrit_including.php"); ?>
    <title>印欧語活用辞典 - ヴェーダ語・梵語</title>
  </head>
  <body>
    <?php require_once("sanskrit_header.php"); ?>
    <div class="container-fluid highlight">
      <section class="container">
        <h2 align="align1 mb-5"><span>本辞書の目的</span></h2>
          <p align="center"><br></p>
          <p align="center">このページはヴェーダ語・梵語の辞書および学習ができるサイトです。</p>
          <p align="center">この辞書は造語や借用語にも対応しています。</p>
          <p align="center">日本人に論理的で正確なインドヨーロッパ語を手軽に学習できるように作りました。</p>
          <p align="center">全てのコンテンツは無料です。ぜひご自由にお使いください。</p>
        </div>
      </section>
    </div>
    <section class="container-md">
      <section class="mb-5">
        <h3 class="c-small_headline c-center">文章例</h3>
        <div class="c-body c-center">
          <h4 align="center"><span>01</span>国際歌(ヴェーダ語版)</h4>
          <p class="text-center">Udihi, baddha nāgara!</p>
          <p class="text-center">Udihi, pīḍita jana!</p>
          <p class="text-center">Kraudha sarvāya śāsitrai</p>
          <p class="text-center">Jvālāmukhīvat nirvāpayiṣyati</p>
          <p class="text-center">Sarvān śāsitrn nibarbṛhāma</p>
          <p class="text-center">Janāsaḥ, yāyāvarāsaḥ, uttiṣṭhāma!</p>
          <p class="text-center">Lauka tadīyam ādhāram vikāriṣyātāi</p>
          <p class="text-center">Asmadiyāyāvarātmanā vinā nipuṇaina</p>
          <p class="text-center"><br></p>
          <p class="text-center">Antimaḥ saṅgharṣaḥ asati</p>
          <p class="text-center">Bandhāma, Āryāsaḥ!</p>
          <p class="text-center">Sahakārī samāja vinā nipuṇaina</p>
          <p class="text-center">Vāibhavaina pūrṇa bhūyāt</p>
          <p class="text-center"><br></p>
          <p class="text-center">Rāṣṭrīyaḥ śūraḥ rājyam</p>
          <p class="text-center">Rāṣṭrapatiḥ ca rājānaḥ nāsānti</p>
          <p class="text-center">Janāsaḥ rājāmahāi</p>
          <p class="text-center">Asmatkalyāņam Saṃvidhāmahāi</p>
          <p class="text-center">Cauraḥ vilupam upajagāmāti iti</p>
          <p class="text-center">Kārāgṛhāsya ātman apajagāmāti iti</p>
          <p class="text-center">Asmadyantraśālām kārayiṣyāma</p>
          <p class="text-center">Ayam tudāma kadā uṣṇayāti</p>
          <p class="text-center"><br></p>
          <p class="text-center">Antimaḥ saṅgharṣaḥ asati</p>
          <p class="text-center">Bandhāma, Āryāsaḥ!</p>
          <p class="text-center">Sahakārī samāja vinā nipuṇaina</p>
          <p class="text-center">Vāibhavaina pūrṇa bhūyāt</p>
          <p class="text-center"><br></p>
          <p class="text-center">Rājyam haṭhīt, adhiniyama vañkīt</p>
          <p class="text-center">Karaina asmat caurayanti</p>
          <p class="text-center">kṣatriyaḥ ca dhanikaḥ ucitām asanti</p>
          <p class="text-center">kintu sarvam ucitām nasāmaḥ</p>
          <p class="text-center">rājam ca śīṣaņam daidviṣmaḥ</p>
          <p class="text-center">navavidhim apaikṣiṣāmahāi</p>
          <p class="text-center">ucitā kartavyasya asatu</p>
          <p class="text-center">kartavyam ucitāyāḥ asatu</p>
          <p class="text-center"><br></p>
          <p class="text-center">Antimaḥ saṅgharṣaḥ asati</p>
          <p class="text-center">Bandhāma, Āryāsaḥ!</p>
          <p class="text-center">Sahakārī samāja vinā nipuṇaina</p>
          <p class="text-center">Vāibhavaina pūrṇa bhūyāt</p>
          <p class="text-center"><br></p>
          <p class="text-center">Bahulaubhātmanaḥ</p>
          <p class="text-center">śāsitāraḥ pradhānāsaḥ</p>
          <p class="text-center">Kām cakruḥ vinā</p>
          <p class="text-center">Asmadkāryam vidoghantam</p>
          <p class="text-center">Sampattim dadhān iti</p>
          <p class="text-center">Racanā vyadudruvat</p>
          <p class="text-center">Samadiśādhikāram lūtvā</p>
          <p class="text-center">Amūn vayam jaiṣāma</p>
          <p class="text-center"><br></p>
          <p class="text-center">Antimaḥ saṅgharṣaḥ asati</p>
          <p class="text-center">Bandhāma, Āryāsaḥ!</p>
          <p class="text-center">Sahakārī samāja vinā nipuṇaina</p>
          <p class="text-center">Vāibhavaina pūrṇa bhūyāt</p>
          <p class="text-center"><br></p>
          <p class="text-center">Sandhyais asāma</p>
          <p class="text-center">Yuddhasya asantu</p>
          <p class="text-center">Yaudhitum nirākarāmahai</p>
          <p class="text-center">Asmadkāryam vidoghantam</p>
          <p class="text-center">Yadi attāraḥ kiñcit pṛcchān,</p>
          <p class="text-center">Laukyai kṛṣṇadhvajaḥ viyamatai</p>
          <p class="text-center">Tvadgṛhai aṇvastrā akṣipṣama iti</p>
          <p class="text-center">Śīghram jajñān</p>
          <p class="text-center"><br></p>
          <p class="text-center">Antimaḥ saṅgharṣaḥ asati</p>
          <p class="text-center">Bandhāma, Āryāsaḥ!</p>
          <p class="text-center">Sahakārī samāja vinā nipuṇaina</p>
          <p class="text-center">Vāibhavaina pūrṇa bhūyāt</p>
          <p class="text-center"><br></p>
          <p class="text-center">Yāyāvara, abhiyantā, cāitta,</p>
          <p class="text-center">Vayam āryāsaḥ āṣima</p>
          <p class="text-center">Bhūmi sīmāḥ nāastu</p>
          <p class="text-center">Śāsana navdbhāviṣntām</p>
          <p class="text-center">Yadi balínaḥ dadāma,</p>
          <p class="text-center">Yadā lubdhasaḥ śāsanā</p>
          <p class="text-center">Ca prabhavaḥ nirgamāti,</p>
          <p class="text-center">Sūrya sarvadā asmān dīpyāti!</p>
          <p class="text-center"><br></p>
          <p class="text-center">Antimaḥ saṅgharṣaḥ asati</p>
          <p class="text-center">Bandhāma, Āryāsaḥ!</p>
          <p class="text-center">Sahakārī samāja vinā nipuṇaina</p>
          <p class="text-center">Vāibhavaina pūrṇa bhūyāt</p>
        </div>
      </section>
    </section>
  </body>
  <footer class="">
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>