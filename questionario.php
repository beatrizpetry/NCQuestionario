<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/questionario.css">
    <title>Questionário de Medição</title>
</head>
<body>
    <?php
    global $servername;
    global $username;
    global $password;
    global $database;

    $servername = "localhost";
    $username = "questionario";
    $password = "123";
    $database = "questionariofinal";

    $connectbd = mysqli_connect($servername, $username, $password, $database);
    if (!$connectbd) {
        die('Erro de conexão: ' . mysqli_connect_error());
    }

    // Consulta SQL para obter as perguntas
    $sql = "SELECT * FROM Questionário";
    $result = mysqli_query($connectbd, $sql);

    if (!$result) {
        die("Erro na consulta: " . mysqli_error($connectbd));
    }
    ?>

    <div class="cabecalho">
        <h1>Questionário de Medição</h1>
    </div>
    <form method="post" action="processar_respostas.php">
        <div class="main">
            <div class="perguntas">
                <h3>Perguntas</h3>
                <ul>
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<li class='pergunta'>";
                            echo "<span class='pergunta-text'>" . $row["Pergunta"] . "</span>";
                            echo "<div class='resposta'>";
                            echo "<div class='ok-nok'>";
                            echo "<input type='radio' name='resposta[" . $row['Pergunta'] . "]' value='OK'> OK";
                            echo "<input type='radio' name='resposta[" . $row['Pergunta'] . "]' value='NOK'> NOK";
                            echo "</div>";
                            echo "<div class='descricao'>";
                            echo "<label for='descricao'>Descrição</label>";
                            echo "<input type='text' name='descricao[" . $row['Pergunta'] . "]' id='descricao'>";
                            echo "</div>";
                            echo "<div class='responsavel'>";
                            echo "<label for='responsavel'>Responsável</label>";
                            echo "<input type='text' name='responsavel[" . $row['Pergunta'] . "]' id='responsavel'>";
                            echo "</div>";
                            echo "<div class='classificacao'>";
                            echo "<label for='classificacao'>Classificação</label>";
                            echo "<select name='classificacao[" . $row['Pergunta'] . "]'>";
                            echo "<option value='Alto'>Alto</option>";
                            echo "<option value='Médio'>Médio</option>";
                            echo "<option value='Baixo'>Baixo</option>";
                            echo "</select>";
                            echo "</div>";
                            echo "</div>";
                            echo "</li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <input type="submit" value="Enviar Respostas" style="background-color: rgb(10, 151, 97); color: #fff;">
    </form>

    <script src="script/questionario.js"></script>
</body>
</html>