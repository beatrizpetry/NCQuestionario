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
    $servername = "localhost";
    $username = "questionario";
    $password = "123";
    $database = "questionariofinal";

    $connectbd = mysqli_connect($servername, $username, $password, $database);
    if (!$connectbd) {
        die('Erro de conexão: ' . mysqli_connect_error());
    }

    $result = mysqli_query($connectbd, "SELECT * FROM Questionário");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        foreach ($_POST["resposta"] as $pergunta => $resposta) {
            $descricao = mysqli_real_escape_string($connectbd, $_POST["descricao"][$pergunta]);
            $responsavel = mysqli_real_escape_string($connectbd, $_POST["responsavel"][$pergunta]);
            $classificacao = $_POST["classificacao"][$pergunta];

            $updateSql = "UPDATE Questionário SET Situação = '$resposta', Descrição_nc = '$descricao', Responsável_nc = '$responsavel', Classificação_nc = '$classificacao' WHERE Pergunta = '$pergunta'";

            if (mysqli_query($connectbd, $updateSql)) {
                $successMessage = "Dados atualizados com sucesso!";
            } else {
                $errorMessage = "Erro de atualização das Perguntas: " . mysqli_error($connectbd);
            }
        }
    }
    ?>

    <div class="cabecalho">
        <h1>Questionário de Medição</h1>
    </div>
    <form method="post" action="questionario.php">
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
                            echo "<label for='ok-".$row['Pergunta']."'><b>OK</b></label>";
                            echo "<input type='radio' name='resposta[" . $row['Pergunta'] . "]' value='OK' id='ok-".$row['Pergunta']."'>";
                            echo "<label for='nok-".$row['Pergunta']."'><b>NOK</b></label>";
                            echo "<input type='radio' name='resposta[" . $row['Pergunta'] . "]' value='NOK' id='nok-".$row['Pergunta']."'>";
                            echo "</div>";
                            echo "<div class='descricao'>";
                            echo "<label for='descricao-".$row['Pergunta']."'>Descrição</label>";
                            echo "<input type='text' name='descricao[" . $row['Pergunta'] . "]' id='descricao-".$row['Pergunta']."'>";
                            echo "</div>";
                            echo "<div class='responsavel'>";
                            echo "<label for='responsavel-".$row['Pergunta']."'>Responsável</label>";
                            echo "<input type='text' name='responsavel[" . $row['Pergunta'] . "]' id='responsavel-".$row['Pergunta']."'>";
                            echo "</div>";
                            echo "<div class='classificacao'>";
                            echo "<label for='classificacao-".$row['Pergunta']."'>Classificação</label>";
                            echo "<select name='classificacao[" . $row['Pergunta'] . "]' id='classificacao-".$row['Pergunta']."'>
                                      <option value='Não Aplicável'>Não Aplicável</option>
                                      <option value='Alto'>Alto - 5 dias</option>
                                      <option value='Médio'>Médio - 3 dias</option>
                                      <option value='Baixo'>Baixo - 1 dia</option>
                                  </select>";
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

    <script>
        const okButtons = document.querySelectorAll('input[type="radio"][value="OK"]');
        const descricaoInputs = document.querySelectorAll('input[name^="descricao"]');
        const responsavelInputs = document.querySelectorAll('input[name^="responsavel"]');
        const classificacaoSelects = document.querySelectorAll('select[name^="classificacao"]');

        okButtons.forEach((okButton, index) => {
            okButton.addEventListener("change", function () {
                if (okButton.checked) {
                    descricaoInputs[index].value = "Não Aplicável";
                    responsavelInputs[index].value = "Não Aplicável";
                    classificacaoSelects[index].value = "Não Aplicável";
                }
            });
        });

        const nokButtons = document.querySelectorAll('input[type="radio"][value="NOK"]');
        nokButtons.forEach((nokButton, index) => {
            nokButton.addEventListener("change", function () {
                if (nokButton.checked) {
                    descricaoInputs[index].value = "";
                    responsavelInputs[index].value = "";
                }
            });
        });

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
