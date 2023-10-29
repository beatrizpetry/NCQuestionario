<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/nConformidade.css">
    <title>Não Conformidades</title>
</head>

<?php
$servername = "localhost";
$username = "questionario";
$password = "123";
$database = "questionariofinal";

$connectbd = mysqli_connect($servername, $username, $password, $database);
if (!$connectbd) {
    die('Erro de conexão: ' . mysqli_connect_error());
}

$result = mysqli_query($connectbd, "SELECT * FROM Questionário");

?>


<body>

    <div class="cabecalho">
        <h1>Não Conformidades</h1>
    </div>
    <form method="post" action="nconformidades.php">
        <div class="main">
            <div class="ncs">
                <ul>
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        $nc = 1; // Inicialize o contador NC

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<div class='nc'>";
                            echo "<label for='nc-" . $row['Pergunta'] . "'>NC  $nc  </label>";
                            echo "</div>";

                            echo "<div class='descricao'>";
                            echo "<label for='descricao-" . $row['Pergunta'] . "'>Descrição</label>";
                            echo "<p>" . $row['Descrição_nc'] . "</p>";
                            echo "</div>";

                            echo "<div class='responsavel'>";
                            echo "<label for='responsavel-" . $row['Pergunta'] . "'>Responsável</label>";
                            echo "<p>" . $row['Responsável_nc'] . "</p>";
                            echo "</div>";

                            echo "<div class='classificacao'>";
                            echo "<label for='classificacao-" . $row['Pergunta'] . "'>Classificação</label>";
                            echo "<p>" . $row['Classificação_nc'] . "</p>";
                            echo "</div>";

                            echo "<div class='data-inicio'>";
                            echo "<label for='data-inicio-" . $row['Pergunta'] . "'>Data Início</label>";
                            echo "<input type='date' name='data-inicio[" . $row['Pergunta'] . "]' id='data-inicio-" . $row['Pergunta'] . "'>";
                            echo "</div>";

                            echo "<div class='data-fim'>";
                            echo "<label for 'data-fim-" . $row['Pergunta'] . "'>Data Fim</label>";
                            echo "<input type='date' name='data-fim[" . $row['Pergunta'] . "]' id='data-fim-" . $row['Pergunta'] . "'>";
                            echo "</div>";

                            echo "<div class='resolvido'>";
                            echo "<label for='resolvido-" . $row['Pergunta'] . "'>Resolvido</label>";
                            echo "<select name='resolvido[" . $row['Pergunta'] . "]' id='resolvido-" . $row['Pergunta'] . "'>";
                            echo "<option value='Sim'>Sim</option>";
                            echo "<option value='Não'>Não</option>";
                            echo "</select>";
                            echo "</div>";

                            $nc++; 
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <input type="submit" value="Enviar Respostas" style="background-color: rgb(10, 151, 97); color: #fff;">
    </form>

</body>

</html>

