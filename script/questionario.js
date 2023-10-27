// Obtém os elementos do DOM
const nok = document.getElementById("nok");
const ok = document.getElementById("ok");
const inputOculto = document.getElementById("inputOculto");
const inputOculto2 = document.getElementById("inputOculto2");

// Adiciona um event listener para o radio "Sim"
nok.addEventListener("change", function() {
    if (nok.checked) {
        inputOculto.style.display = "inline-block";
        inputOculto2.style.display = "inline-block"; // Mostra o input se "Sim" for selecionado
    } else {
        inputOculto.style.display = "none";
        inputOculto2.style.display = "none"; // Oculta o input se "Sim" não estiver selecionado
    }
});

// Adiciona um event listener para o radio "Não"
ok.addEventListener("change", function() {
    if (ok.checked) {
        inputOculto.style.display = "none";
        inputOculto2.style.display = "none"; // Oculta o input se "Não" for selecionado
    }
});
