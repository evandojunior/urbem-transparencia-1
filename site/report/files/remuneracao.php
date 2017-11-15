<?php

require_once __DIR__ . "/../../modules/site/site.controller.php";

$filename = __DIR__ . "/../../tmp/remuneracao.json";
getDataCache($filename);

$result = SiteController::listaRemuneracaoJson();

$data = [
    'mes_ano' => null,
    'bruto' => 0,
    'liquido' => 0,
];
$data['atualizacao'] = formatDateToPHP(ImportacaoBO::getUltimo()->data_limite_dado);
foreach ($result as $remuneracao) {
    $data['mes_ano'] = $remuneracao['mes_ano'];
    $data['bruto'] += $remuneracao['remuneracao_bruta'];
    $data['liquido'] += $remuneracao['remuneracao_apos_deducoes'];
}

$data['bruto'] = number_format($data['bruto'], 2, ',', '.');
$data['liquido'] = number_format($data['liquido'], 2, ',', '.');

ResponseJson($data, $filename);