<?php

require_once __DIR__ . "/../../modules/site/site.controller.php";

$filename = __DIR__ . "/../../tmp/cargos.json";
getDataCache($filename);

list($result, $competencia) = SiteController::listaCargoJson();
$data = [
    "competencia_mes_ano" => $competencia,
    "atualizacao" => formatDateToPHP(ImportacaoBO::getUltimo()->data_limite_dado)
];
$data['items'] = [];
foreach ($result as $cargo) {
    $descricaoCargo = trim(utf8_encode($cargo->descricao_cargo));
    $lei = trim($cargo->lei);
    $vigencia = trim($cargo->vigencia);
    $criado = $cargo->vagas_criadas;
    $ocupado = $cargo->vagas_ocupadas;
    $disponivel = $cargo->vagas_disponiveis;

    $chaveCargo = sprintf("%s_%s_%s", $descricaoCargo, $lei, $vigencia);
    if (!array_key_exists($chaveCargo, $data['items'])) {
        $data['items'][$chaveCargo] = [
            'cargo' => $descricaoCargo,
            'lei' => $lei,
            'vigencia' => $vigencia,
            'vagas_criadas' => $criado,
            'vagas_ocupadas' => $ocupado,
            'vagas_disponiveis' => $disponivel,
        ];
        continue;
    }

    $data['items'][$chaveCargo]['vagas_criadas'] += $criado;
    $data['items'][$chaveCargo]['vagas_ocupadas'] += $ocupado;
    $data['items'][$chaveCargo]['vagas_disponiveis'] += $disponivel;
}

ResponseJson($data, $filename);