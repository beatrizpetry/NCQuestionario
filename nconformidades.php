<!DOCTYPE html>
<html>

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

        // Verifique se o campo Resolvido é "Sim" e atualize o campo Solução para "OK"
        if ($resolvido === 'Sim') {
            // Atualize o campo Solução para "OK" na tabela Questionário
            $updatesql = "UPDATE Questionário SET AçãoCorretiva = '$acaoCorretiva', Data_inicio = '$dataInicio', Data_fim = '$dataFim', Escalonamento = '$escalonamento', Resolvido_nc = '$resolvido', Situação = 'OK' WHERE Pergunta = '$pergunta'";
        } else {
            // Caso contrário, atualize sem alterar o campo Solução
            $updatesql = "UPDATE Questionário SET AçãoCorretiva = '$acaoCorretiva', Data_inicio = '$dataFim', Data_fim = '$dataFim', Escalonamento = '$escalonamento', Resolvido_nc = '$resolvido' WHERE Pergunta = '$pergunta'";
        }

        // Verifique se a consulta SQL não está vazia
        if (!empty($updatesql)) {
            if (mysqli_query($connectbd, $updatesql)) {

            } else {
                echo "Erro de atualização das Perguntas: " . mysqli_error($connectbd);
            }
        }
    }
}

// Consulta SQL para contar o total de perguntas na tabela Questionário
$totalPerguntasQuery = mysqli_query($connectbd, "SELECT COUNT(*) AS total FROM Questionário");
$totalPerguntasAssoc = mysqli_fetch_assoc($totalPerguntasQuery);
$totalPerguntas = $totalPerguntasAssoc["total"];

// Consulta SQL para contar o número de perguntas marcadas como "NOK"
$perguntasNOKQuery = mysqli_query($connectbd, "SELECT COUNT(*) AS total FROM Questionário WHERE Situação = 'NOK'");
$perguntasNOKAssoc = mysqli_fetch_assoc($perguntasNOKQuery);
$perguntasNOK = $perguntasNOKAssoc["total"];

// Cálculo da taxa de aderência
$taxaAderencia = (($totalPerguntas - $perguntasNOK) / $totalPerguntas) * 100;

// Arredonde a taxa de aderência para duas casas decimais
$taxaAderencia = number_format($taxaAderencia, 2);
?>

<body>
    <?php
    if (isset($taxaAderencia)) {
        echo "<div class='cabecalho'>";
        echo "<h1>Não Conformidades - Taxa de Aderência: $taxaAderencia%</h1>";
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
                            echo "<input type='text' name='acao-corretiva[" . $row['Pergunta'] . "]' id='acao-corretiva-" . $row['Pergunta'] . "' value='" . $row['AçãoCorretiva'] . "'>";
                            echo "</div>";

                            echo "<div class='data-inicio'>";
                            echo "<label for='data-inicio-" . $row['Pergunta'] . "'>Data Início</label>";
                            echo "<input type='date' name='data-inicio[" . $row['Pergunta'] . "]' id='data-inicio-" . $row['Pergunta'] . "' value='" . $row['Data_inicio'] . "'>";
                            echo "</div>";

                            echo "<div class='data-fim'>";
                            echo "<label for 'data-fim-" . $row['Pergunta'] . "'>Data Fim</label>";
                            echo "<input type='date' name='data-fim[" . $row['Pergunta'] . "]' id='data-fim-" . $row['Pergunta'] . "' value='" . $row['Data_fim'] . "'>";
                            echo "</div>";

                            echo "<div class='resolvido'>";
                            echo "<label for='resolvido-" . $row['Pergunta'] . "'>Resolvido</label>";
                            echo "<select name='resolvido[" . $row['Pergunta'] . "]' id='resolvido-" . $row['Pergunta'] . "'>";
                            echo "<option value='Não' " . ($row['Resolvido_nc'] == 'Não' ? 'selected' : '') . ">Não</option>";
                            echo "<option value='Sim' " . ($row['Resolvido_nc'] == 'Sim' ? 'selected' : '') . ">Sim</option>";
                            echo "</select>";
                            echo "</div>";

                            echo "<div class='escalonamento'>";
                            echo "<label class='escalonamento' for='escalonamento-" . $row['Pergunta'] . "'>Escalonamento</label>";
                            echo "<select name='escalonamento[" . $row['Pergunta'] . "]' id='escalonamento-" . $row['Pergunta'] . "'>";
                            echo "<option value='Não Aplicado' " . ($row['Escalonamento'] == 'Não Aplicado' ? 'selected' : '') . ">Não Aplicado</option>";
                            echo "<option value='1' " . ($row['Escalonamento'] == '1' ? 'selected' : '') . ">1</option>";
                            echo "<option value='2' " . ($row['Escalonamento'] == '2' ? 'selected' : '') . ">2</option>";
                            echo "<option value='3' " . ($row['Escalonamento'] == '3' ? 'selected' : '') . ">3</option>";
                            echo "</select>";
                            echo "</div>";

                            $nc++;
                        }
                    }
                    ?>

                    <?php
                    if ($taxaAderencia != 100) {
                        echo '<input type="submit" name="submit" value="Enviar Respostas">';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </form>
    <script>
    </script>
</body>
</html>