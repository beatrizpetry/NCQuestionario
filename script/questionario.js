
    const okButtons = document.querySelectorAll('input[type="radio"][value="OK"]');
    const descricaoInputs = document.querySelectorAll('input[name^="descricao"]');
    const responsavelInputs = document.querySelectorAll('input[name^="responsavel"]');

    okButtons.forEach((okButton, index) => {
        okButton.addEventListener("change", function () {
            if (okButton.checked) {
                descricaoInputs[index].value = "Não Aplicável";
                responsavelInputs[index].value = "Não Aplicável";
            }
        });
    });