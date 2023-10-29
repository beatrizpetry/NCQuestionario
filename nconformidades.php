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

$result = mysqli_query($connectbd, "SELECT * FROM Questionário WHERE Situação = 'NOK'");

if (isset($_POST['submit'])) {
    foreach ($_POST['acao-corretiva'] as $pergunta => $acaoCorretiva) {
        $dataInicio = mysqli_real_escape_string($connectbd, $_POST['data-inicio'][$pergunta]);
        $dataFim = mysqli_real_escape_string($connectbd, $_POST['data-fim'][$pergunta]);
        $escalonamento = mysqli_real_escape_string($connectbd, $_POST['escalonamento'][$pergunta]);
        $acaoCorretiva = mysqli_real_escape_string($connectbd, $acaoCorretiva);
        $resolvido = mysqli_real_escape_string($connectbd, $_POST['resolvido'][$pergunta]);


        $updatesql = "UPDATE Questionário SET AçãoCorretiva = '$acaoCorretiva', Data_inicio = '$dataInicio', Data_fim = '$dataFim', Escalonamento = '$escalonamento', Resolvido_nc = '$resolvido' WHERE Pergunta = '$pergunta'";

        // Verifique se a consulta SQL não está vazia
        if (!empty($updatesql)) {
            if (mysqli_query($connectbd, $updatesql)) {
                $successMessage = "Dados atualizados com sucesso!";
            } else {
                $errorMessage = "Erro de atualização das Perguntas: " . mysqli_error($connectbd);
            }
        }
    }
    // Consulta SQL para contar o número total de perguntas
    $totalPerguntas = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Questionário");
    $totalPerguntas = mysqli_fetch_assoc($totalPerguntas)["total"];

    // Consulta SQL para contar o número de perguntas marcadas como "NOK"
    $perguntasNOK = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Questionário WHERE Situação = 'NOK'");
    $perguntasNOK = mysqli_fetch_assoc($perguntasNOK)["total"];

    var_dump($totalPerguntas);
    var_dump($perguntasNOK);

    // Cálculo da taxa de aderência
    $taxaAderencia = (($totalPerguntas - $perguntasNOK) / $totalPerguntas) * 100;

    // Arredonde a taxa de aderência para duas casas decimais
    $taxaAderencia = number_format($taxaAderencia, 2);
}
?>

<body>
<?php
    if (isset($taxaAderencia)) {
        echo "<div class='cabecalho'>";
        echo "<h1>Não Conformidades</h1>";
        echo "<p>Taxa de Aderência: $taxaAderencia%</p>";
        echo "</div>";
    } else {
        echo "<div class='cabecalho'>";
        echo "<h1>Não Conformidades</h1>";
        echo "<p>Taxa de Aderência não disponível</p>";
        echo "</div>";
    }
    ?>
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

                            echo "<div class='acao-corretiva'>";
                            echo "<label class='acao-corretiva' for='acao-corretiva-" . $row['Pergunta'] . "'>Ação Corretiva</label>";
                            echo "<input type='text' name='acao-corretiva[" . $row['Pergunta'] . "]' id='acao-corretiva-" . $row['Pergunta'] . "'>";
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
                            echo "<option value='Não' selected>Não</option>";
                            echo "<option value='Sim'>Sim</option>";
                            echo "</select>";
                            echo "</div>";

                            echo "<div class='escalonamento'>";
                            echo "<label class='escalonamento' for='escalonamento-" . $row['Pergunta'] . "'>Escalonamento</label>";
                            echo "<input type='text' name='escalonamento[" . $row['Pergunta'] . "]' id='escalonamento-" . $row['Pergunta'] . "'>";
                            echo "</div>";

                            $nc++;
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <input type="submit" name="submit" value="Enviar Respostas" style="background-color: rgb(10, 151, 97); color: #fff;">
    </form>
    <script>
        <?php
        if (isset($successMessage)) {
            echo "alert('$successMessage');";
        }

        if (isset($errorMessage)) {
            echo "alert('$errorMessage');";
        }
        ?>
    </script>
</body>
</html>