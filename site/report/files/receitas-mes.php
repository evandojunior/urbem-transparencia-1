<?php

require_once __DIR__ . "/../../modules/site/site.controller.php";

$filename = __DIR__ . "/../../tmp/receita-mes.json";
getDataCache($filename);

list($result, $total, $mes) = SiteController::listaBalanceteReceitaMesJson();

$totalOrcado       = $total['receita_orcada'];
$totalRealizado    = $total['receita_realizado'];
$totalRealizadoMes = $total['receita_realizado_mes'];

$i = 0;
$data = [];
$data['atualizacao'] = formatDateToPHP(ImportacaoBO::getUltimo()->data_limite_dado);
$data['exercicio'] = ImportacaoBO::getUltimo()->getExercicio();
$data['totais'] = [
    "mes" => $mes,
    "receita_orcada" => number_format($totalOrcado, 2, ',', '.'),
    "receita_realizado" => number_format($totalRealizado, 2, ',', '.'),
    "receita_realizado_mes" => number_format($totalRealizadoMes, 2, ',', '.'),
    "percentual" => ($totalRealizado > 0) ? number_format(($totalRealizado/$totalOrcado)*100, 8, ',', '.') : 0
];

ResponseJson($data, $filename);