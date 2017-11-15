<?php

require_once __DIR__ . "/../../modules/site/site.controller.php";

$filename = __DIR__ . "/../../tmp/despesas-orgao.json";
getDataCache($filename);

$result = SiteController::listaBalanceteDespesaOrgaoToJson();
$data = [];
$data['atualizacao'] = formatDateToPHP(ImportacaoBO::getUltimo()->data_limite_dado);
$data['items'] = [];
foreach ($result->getObj() as $despesa) {
    $item = [
        "label" => "Descrição da Conta",
        "value" => utf8_encode($despesa['descricao']),
        "dotacao_inicial" => number_format($despesa['dotacao_inicial'], 2, ',', '.'),
        "empenhado" => number_format($despesa['valor_empenhado'], 2, ',', '.'),
        "liquidado" => number_format($despesa['valor_liquidado'], 2, ',', '.'),
        "pago" => number_format($despesa['valor_pago']     , 2, ',', '.'),
        "empenhos" => $despesa['id']
    ];

    array_push($data['items'], $item);
}

ResponseJson($data, $filename);