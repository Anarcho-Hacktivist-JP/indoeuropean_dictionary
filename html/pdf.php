<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//読み込み
include(dirname(__FILE__) . "/language_class/IndoEuropean_noun_class.php");
include(dirname(__FILE__) . "/language_class/Database_session.php");
include(dirname(__FILE__) . "/language_class/Commons.php");
include(dirname(__FILE__) . "/language_class/Latin_Common.php");
include(dirname(__FILE__) . "/language_class/php_others/tcpdf/tcpdf.php");
include(dirname(__FILE__) . "/language_class/php_others/tcpdf/fdpi/autoload.php");

function get_pdf_object($template_pass){
    // オブジェクトを読み込み
    $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
    // PDFの余白(上左右)を設定
    $pdf->SetMargins(0, 0, 0);
    // ヘッダーの出力を無効化
    $pdf->setPrintHeader(false);   
    // フッターの出力を無効化
    $pdf->setPrintFooter(false);
    // 改ページは無効
    $pdf->setAutoPageBreak(false);
    // テンプレートファイル読み込み
    $pdf->setSourceFile(dirname(__FILE__) . "/language_class/php_others/tcpdf/tpl/".$template_pass);
    // ページ追加
    $pdf->AddPage();
    // テンプレート読み込み
    $template_obj = $pdf->importPage(1);
    $pdf->useTemplate($template_obj);
    // フォント設定
    $pdf->setFont("kozminproregular", "", 11);
    // 結果を返す
    return $pdf;
}
// オブジェクト取得
$pdf = get_pdf_object("latin_verb_conjugations.pdf");
// 書き込みテスト
$pdf->Text(50, 100, "output_test");
$pdf->multiCell(50, 5, "output_test", 0, "J", false, 0, 50, 200);
$pdf->multiCell(50, 5, "output_test2", 0, "J", false, 0, 100, 200);
// 出力
$pdf->Output("conjugation.pdf", "I");