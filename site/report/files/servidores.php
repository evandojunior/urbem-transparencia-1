<?php

require_once __DIR__ . "/../../modules/site/site.controller.php";

$filename = __DIR__ . "/../../tmp/servidores.json";
getDataCache($filename);

$result = SiteController::listaServidorJson();

$data = [];
$data['atualizacao'] = formatDateToPHP(ImportacaoBO::getUltimo()->data_limite_dado);
$data['items'] = [];
foreach ($result as $servidor) {
    $situacao = trim(utf8_encode($servidor['situacao']));
    if (array_key_exists($situacao, $data['items'])) {
        $data['items'][$situacao] += 1;
        continue;
    }

    $data['items'][$situacao] = 1;
}

ResponseJson($data, $filename);