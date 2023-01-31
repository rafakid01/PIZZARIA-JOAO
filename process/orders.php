<?php

include_once("conn.php");

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {

    $pedidosQuery = $conn->query("SELECT * FROM pedidos");
    $pedidos = $pedidosQuery->fetchAll();

    $pizzas = [];

    // MONTANDO PIZZA
    foreach ($pedidos as $pedido) {
        $pizza = [];

        // DEFINIR ARRAY PARA A PIZZA
        $pizza["id"] = $pedido["pizza_id"];

        // RESGATANDO A PIZZA
        $pizzaQuery = $conn->prepare("SELECT * FROM pizzas WHERE id = :pizza_id");

        $pizzaQuery->bindParam(":pizza_id", $pizza["id"]);

        $pizzaQuery->execute();

        $pizzaData = $pizzaQuery->fetch(PDO::FETCH_ASSOC);

        // RESGATANDO A BORDA DA PIZZA

        $bordaQuery = $conn->prepare("SELECT * FROM bordas WHERE id = :borda_id");

        $bordaQuery->bindParam(":borda_id", $pizzaData["borda_id"]);

        $bordaQuery->execute();

        $borda = $bordaQuery->fetch(PDO::FETCH_ASSOC);

        $pizza["borda"] = $borda["tipo_borda"];

        // RESGATANDO A massa DA PIZZA

        $massaQuery = $conn->prepare("SELECT * FROM massas WHERE id = :massa_id");

        $massaQuery->bindParam(":massa_id", $pizzaData["massa_id"]);

        $massaQuery->execute();

        $massa = $massaQuery->fetch(PDO::FETCH_ASSOC);

        $pizza["massa"] = $massa["tipo"];

        //  RESGATANDO SABORES DA PIZZA

        $saboresQuery = $conn->prepare("SELECT * FROM pizza_sabor WHERE pizza_id = :pizza_id");

        $saboresQuery->bindParam(":pizza_id", $pizza["id"]);

        $saboresQuery->execute();

        $sabores = $saboresQuery->fetchAll(PDO::FETCH_ASSOC);

        // RESGATANDO O NOME DOS SABORES
        $nomeSabores = [];

        $saborQuery = $conn->prepare("SELECT * FROM sabores WHERE id = :sabor_id");

        foreach ($sabores as $sabor) {

            $saborQuery->bindParam(":sabor_id", $sabor["sabor_id"]);

            $saborQuery->execute();

            $saborPizza = $saborQuery->fetch(PDO::FETCH_ASSOC);

            array_push($nomeSabores, $saborPizza["nome"]);
        }

        $pizza["sabores"] = $nomeSabores;

        // ADICIONAR O STATUS

        $pizza["status"] = $pedido["status_id"];

        // Adicionar o array de pizza, ao array de pizzas

        array_push($pizzas, $pizza);
    }

    // RESGATANDO OS STATUS

    $statusQuery = $conn->query("SELECT * FROM status");
    $status = $statusQuery->fetchAll();
} else if ($method === "POST") {

    // VERIFICANDO O TIPO DE POST 
    $type = $_POST["type"];

    // DELETAR PEDIDO
    if ($type === "delete") {
        $pizzaId = $_POST["id"];

        $deleteQuery = $conn->prepare("DELETE FROM pedidos WHERE pizza_id = :pizza_id");

        $deleteQuery->bindParam(":pizza_id", $pizzaId, PDO::PARAM_INT);

        $deleteQuery->execute();

        $_SESSION["msg"] = "Pedido removido com sucesso";
        $_SESSION["status"] = "success";

    // ATUALIZAR STATUS
    } else if ($type === "update") {

        $pizzaId = $_POST["id"];

        $statusId = $_POST["status"];

        $updateQuery = $conn->prepare("UPDATE pedidos SET status_id = :status_id WHERE pizza_id = :pizza_id");

        $updateQuery->bindParam(":status_id", $statusId, PDO::PARAM_INT);
        $updateQuery->bindParam(":pizza_id", $pizzaId, PDO::PARAM_INT);
        
        $updateQuery->execute();

        $_SESSION["msg"] = "Status do pedido atualizado com sucesso";
        $_SESSION["status"] = "success";

    }

    // RETORNO AO DASHBOARD
    header("Location: ../dashboard.php");
}
