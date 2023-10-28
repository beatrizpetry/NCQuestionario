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
    include_once('bd/conexao.php');
    
    ?>
    <div class="cabecalho">
        <h1>Questionário de Medição</h1>
    </div>
    <div class="main">
        <div class="perguntas">
            <h3>Perguntas</h3>
            <ul >
                <?php 
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<li>";
                        echo "<td>" . $row["Pergunta"] . "</td";
                        echo "</li>";
                        }
                        
                    }?> 
                </ul> 

        </div>
        <div class="ok">
            <h3>OK</h3>
            <input type="radio" name="opcao" id="ok">
        </div>
        <div class="nok">
            <h3>NOK</h3>
            <input type="radio" name="opcao" id="nok">
        </div>
        <div class="descricao" id="inputOculto" style="display: none;">
            <h3>Descrição</h3>
            <input type="text" name="descricao" id="descricao">
        </div>
        <div class="responsavel" id="inputOculto2" style="display: none;">
            <h3>Responsável</h3>
            <input type="text" name="responsavel" id="responsavel">
        </div>
        <div class="classificacao">
            <h3>Classificação</h3>
            <select name="classificacao">
                <option value="alt"> Alto </option>
                <option value="med"> Médio </option>
                <option value="bai"> Baixo </option>
            </select>
        </div>
        </div>
    </div>
    <script src="script/questionario.js"></script>
</body>
</html>