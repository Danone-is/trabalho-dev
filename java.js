
const lista = document.getElementById("lista");
const campo = document.getElementById("tarefa");

// Carregar tarefas
function carregar() {

    fetch("tarefas.php")
    .then(res => res.json())
    .then(tarefas => {

        lista.innerHTML = "";

        tarefas.forEach(t => {

            lista.innerHTML += `
                <li>

                    <span onclick="acao('concluir', '${t.id}')"
                    class="${t.concluida ? 'concluida' : ''}">
                    ${t.nome}
                    </span>

                    <button onclick="acao('excluir', '${t.id}')">
                        X
                    </button>

                </li>
            `;

        });

    });

}


// Enviar informações para o PHP
function enviar(tipo, valor) {

    fetch("tarefas.php", {

        method: "POST",

        headers: {
            "Content-Type": "application/json"
        },

        body: JSON.stringify({
            tipo: tipo,
            valor: valor
        })

    })

    .then(res => res.json())

    .then(dados => {
        carregar();
    });

}


// Adicionar tarefa
function adicionar() {

    if (campo.value.trim() == "") {
        return;
    }

    enviar("adicionar", campo.value);

    campo.value = "";

}


// Concluir ou excluir
function acao(tipo, id) {

    enviar(tipo, id);

}


// Iniciar o site
carregar();
