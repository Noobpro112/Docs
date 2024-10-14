function Salva_Conteudo() {
    var titulo = document.getElementById("Titulo").value;
    var id = document.getElementById("id").value;
    var tamanho_fonte = currentFontSize;
    var conteudo_pagina = document.getElementById("editor").innerHTML;

    var requisicao = new XMLHttpRequest();
    requisicao.open("POST", "../../functions/salvar.php", true);
    requisicao.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    requisicao.onreadystatechange = function() {
        if (requisicao.readyState == 4 && requisicao.status == 200) {
            console.log("Conteúdo salvo com sucesso!");
        }
    };

    requisicao.send("titulo=" + encodeURIComponent(titulo) + "&conteudo=" + encodeURIComponent(conteudo_pagina) + "&id=" + encodeURIComponent(id) + "&tamanho_fonte=" + encodeURIComponent(tamanho_fonte));
}
