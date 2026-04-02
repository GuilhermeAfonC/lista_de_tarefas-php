<?php
// Conectando ao banco de dados 
$conn = new mysqli("localhost", "root", "", "lista_tarefas_db");
if ($conn->connect_error) die("Erro: " . $conn->connect_error);
 
// Se o formulário foi enviado e o campo não está vazio, insere a tarefa
if (!empty($_POST['tarefa'])) {
    $stmt = $conn->prepare("INSERT INTO tarefas (texto_tarefa) VALUES (?)");
    $stmt->bind_param("s", $_POST['tarefa']); // "s" = string
    $stmt->execute();

    // Redireciona para a própria página, assim não ocorre reenvio do formulário no refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
 
// Se foi solicitada uma exclusão via URL (?deletar=ID), remove a tarefa
if (isset($_GET['deletar'])) {
    $conn->query("DELETE FROM tarefas WHERE id = " . (int)$_GET['deletar']); // (int) evita SQL injection
    
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
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@500;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <style> 
        body {
            font-family: 'Inter', sans-serif;
            background-color: #077272;
            display: flex;
            min-height: 300px;
            justify-content: center;
            padding: 60px 20px;
        }
 
        /* Cartão central que contém tudo */
        .card {
            background: #faf9f7;
            width: 100%;
            max-width: 560px;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }
 
        h2 {
            font-family: 'Lora', serif;
            font-size: 1.7rem;
            color: #1a1a1a;
            text-align: center;
            margin-bottom: 28px;
        }
 
        form {
            display: flex;
            gap: 8px;
            margin-bottom: 28px;
        }
 
        input[type="text"] {
            flex: 1; /* ocupa todo o espaço disponível ao lado do botão */
            padding: 10px 14px;
            border: 1.5px solid #ccc;
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color .2s;
        }
 
        input[type="text"]:focus { 
            border-color: #077272; 
        }
 
        button[type="submit"] {
            padding: 10px 18px;
            background: #770f0f;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background .2s;
            white-space: nowrap; /* impede o texto do botão de quebrar linha */
        }
 
        button[type="submit"]:hover { background: #9e1515; }
 
        ol {
            padding-left: 22px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
 
        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.97rem;
            color: #333;
            padding: 10px 12px;
            background: white;
            border-radius: 8px;
            border: 1px solid #e8e8e8;
        }
 
        li a {
            color: #999;
            text-decoration: none;
            font-size: 1.1rem;
            line-height: 1;
            padding: 2px 6px;
            border-radius: 4px;
            transition: background .15s, color .15s;
        }
 
        li a:hover { background: #770f0f; color: white; }
 
        /* Mensagem exibida quando não há nenhuma tarefa cadastrada */
        .empty {
            text-align: center;
            color: #aaa;
            font-size: 0.9rem;
            padding: 20px 0;
        }
    </style>
</head>
<body>
<div class="card">
    <h2>📝 Lista de Tarefas</h2>
 
    <form method="POST">
        <input type="text" name="tarefa" placeholder="Escreva uma nova tarefa" autofocus>
        <button type="submit">Adicionar</button>
    </form>
 
    <?php
    // Busca todas as tarefas em ordem crescente de ID (das mais antigas a nais recentes, como ordem de prioridade)
    $resultado = $conn->query("SELECT * FROM tarefas ORDER BY id ASC");
    if ($resultado->num_rows > 0) {
    ?>
        <ol>
            <?php while ($linha = $resultado->fetch_assoc()){?>
                <li>
                    <?php echo htmlspecialchars($linha['texto_tarefa']) /* htmlspecialchars força que: para ser aceito deve ser em caracteres intendiveis pro HTML */ ?>
                    <a href="?deletar=<?php echo $linha['id'] ?>" title="Remover">&#x2715;</a> <!-- DELETE -->
                </li>
            <?php } ?>
        </ol>
    <?php } ?>
</div>
</body>
</html>
 
