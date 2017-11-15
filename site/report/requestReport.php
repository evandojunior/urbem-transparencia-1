<?php

require_once __DIR__ . "/../modules/site/site.controller.php";

$uri = array_filter(explode(DIRECTORY_SEPARATOR, str_replace("report", "", $_SERVER['REQUEST_URI'])));
$reports = [
    'despesas-orgao' => 'despesas-orgao.php',
    'receitas-mes' => 'receitas-mes.php',
    'servidores' => 'servidores.php',
    'remuneracao' => 'remuneracao.php',
    'cargo' => 'cargo.php',
];

function ResponseJson(array $content, $filename = null) {
    saveFileCache($content, $filename);

    header('Content-Type: text/html; charset=utf-8');
    echo json_encode($content, JSON_UNESCAPED_UNICODE);
}

function saveFileCache($content, $filename) {
    file_put_contents($filename, json_encode($content, JSON_UNESCAPED_UNICODE));
}

function deleteOldFile($filename) {
    if (!file_exists($filename)) {
        return;
    }

    $datetime1 = new \DateTime(date("Y-m-d", filemtime($filename)));
    $datetime2 = new \DateTime(date("Y-m-d"));

    if ($datetime1->diff($datetime2)->days > 0) {
        unlink($filename);
    }
}

function getDataCache($filename) {
    deleteOldFile($filename);

    if (file_exists($filename)) {
        header('Content-Type: text/html; charset=utf-8');
        echo file_get_contents($filename);
        die;
    }
}

function ResponseError($content)
{
    return ResponseJson(['error' => true, 'content' => $content]);
}

$currentReport = current($uri);
if (!array_key_exists($currentReport, $reports)) {
    return ResponseError('Relatório solicitado não existe');
}

require_once sprintf("%s/files/%s", __DIR__, $reports[$currentReport]);