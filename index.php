<?php
/* Parte de conexão com banco de daod(neste caso MYSQL) e partir da utilização de PHP 
Neste caso meu BD, foi nomeado como lista_tarefas_db;  
$conn = new mysqli("localhost", "root", "", "lista_tarefas_db") -- Linha inicial para ser possível linkar um BD
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
} -- Condicional para o que deve acontecer caso dê errado, ou seja, o que deve aparecer na tela
    */

$conn = new mysqli("localhost", "root", "", "lista_tarefas_db");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

// --- AÇÃO 1: CADASTRAR TAREFA ---
if (isset($_POST['tarefa'])) {
    $texto = $_POST['tarefa'];
    
    if (!empty($texto)) {
        // CORREÇÃO: Nome da tabela 'tarefas'
        $stmt = $conn->prepare("INSERT INTO tarefas (texto_tarefa) VALUES (?)");   //Maneira feita anteriormente, mas insegura: $sql = "INSERT INTO tarefas (texto_tarefa) VALUES ('$texto')";
        $stmt->bind_param("s", $texto);                                            //Todo código ao lado faz a mesma coisa que a unica linha acima, masssss era de forma insegura.
        $stmt->execute();                                                              
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// --- AÇÃO 2: EXCLUIR TAREFA ---
if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    // CORREÇÃO: Nome da tabela 'tarefas'
    $conn->query("DELETE FROM tarefas WHERE id = $id");
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Tarefas</title>

    <style>
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #00FFFF; 
            color: #333; 
            display: flex;
            justify-content: center; 
            padding: 100px 50px 50px 100px;
            margin: 0;
            min-height: 100pv;
        }

   
        .container {
            background-color: whitesmoke;
            width: 800px;
            padding: 50px;
            border-radius: 50px;
            box-shadow: rgba(173, 157, 157, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
        }

        h2 { 
            text-align: center; 
            color: #444; 
            justify-content: center;
        }
  
    </style>
</head>
<body>

    <div class="container">
        <h2>📝 Lista de Tarefas</h2>

        <form method="POST">
            <input type="text" name="tarefa" placeholder="O que preciso fazer?" required autofocus>
            <button type="submit">Adicionar</button>
        </form>

        <ul>
            <?php
            // SELECT na tabela 'tarefas', não no banco de dados
            $resultado = $conn->query("SELECT * FROM tarefas ORDER BY id DESC");

            if($resultado) {
                while ($linha = $resultado->fetch_assoc()) {
                    echo "<li>";
                        echo $linha['texto_tarefa'];
                        echo "<a href='?deletar=" . $linha['id'] . "' class='btn-excluir'>&times;</a>";
                    echo "</li>";
                }
            } else {
                echo "Erro no banco: " . $conn->error;
            }
            ?>
        </ul>
    </div>

</body>
</html>
