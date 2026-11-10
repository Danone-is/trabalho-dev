
<?php

$arquivo = "tarefas.json";

// Criar arquivo caso não exista
if (!file_exists($arquivo)) {

    file_put_contents($arquivo, "[]");

}

// Carregar tarefas
$tarefas = json_decode(file_get_contents($arquivo), true);


// Receber informações do JavaScript
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dados = json_decode(file_get_contents("php://input"), true);

    $tipo = $dados["tipo"] ?? "";
    $valor = $dados["valor"] ?? "";


    // Adicionar tarefa
    if ($tipo == "adicionar" && trim($valor) != "") {

        $tarefas[] = [

            "id" => uniqid(),

            "nome" => trim($valor),

            "concluida" => false

        ];

    }


    // Concluir tarefa
    if ($tipo == "concluir") {

        foreach ($tarefas as &$t) {

            if ($t["id"] == $valor) {

                $t["concluida"] = !$t["concluida"];

            }

        }

        unset($t);

    }


    // Excluir tarefa
    if ($tipo == "excluir") {

        $tarefas = array_values(array_filter($tarefas, function($t) use ($valor) {

            return $t["id"] != $valor;

        }));

    }


    // Salvar tarefas
    file_put_contents(
        $arquivo,
        json_encode($tarefas, JSON_UNESCAPED_UNICODE)
    );

}


// Retornar tarefas
header("Content-Type: application/json; charset=utf-8");

echo json_encode($tarefas, JSON_UNESCAPED_UNICODE);

?>
