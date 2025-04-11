const modal = document.getElementById('modal');
const openBtn = document.getElementById('openModalBtn');
const modalFinalizar = document.getElementById('modalFinalizar');
const finalizarBtn = document.getElementById('openFinalizarModal');
const listaPedidos = document.getElementById('lista-pedidos');
const totalElement = document.querySelector('.total');
const resumoPedido = document.getElementById('resumoPedido');
const urlParams = new URLSearchParams(window.location.search);
const mesa = urlParams.get("mesa");

let pedidos = [];

openBtn.onclick = () => modal.style.display = 'flex';
finalizarBtn.onclick = () => {
  mostrarResumo();
  modalFinalizar.style.display = 'flex';
};

function fecharModal() {
  modal.style.display = 'none';
}
function fecharModalFinalizar() {
  modalFinalizar.style.display = 'none';
}
window.onclick = (e) => {
  if (e.target === modal) fecharModal();
  if (e.target === modalFinalizar) fecharModalFinalizar();
};
document.getElementById('formRegistrar').onsubmit = (e) => {
  e.preventDefault();
  const produtoSelecionado = document.getElementById('produto').value;
  const quantidade = parseInt(document.getElementById('quantidade').value);
  const observacao = document.getElementById('observacao').value;

  if (!produtoSelecionado) return;

  const [id, nome, preco] = produtoSelecionado.split('|');
  const hora = new Date().toLocaleString();

  pedidos.push({ id, nome, preco, quantidade, observacao, hora });
  atualizarTabela();
  fecharModal();
  e.target.reset();
};

function atualizarTabela() {
  listaPedidos.innerHTML = "";
  let totalFinal = 0;
  pedidos.forEach(p => {
    totalFinal += parseFloat(p.preco) * p.quantidade;
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${p.id}</td>
      <td>${p.nome}</td>
      <td>${parseFloat(p.preco).toFixed(2)}</td>
      <td>${p.quantidade}</td>
      <td>🕒 ${p.hora}<br>${p.observacao ? "📝 " + p.observacao : ""}</td>
    `;
    listaPedidos.appendChild(tr);
  });
  totalElement.innerText = "Total: R$ " + totalFinal.toFixed(2);
}

function mostrarResumo() {
  resumoPedido.innerHTML = pedidos.map(p => `
    <p>• ${p.quantidade}x ${p.nome} (${(p.preco * p.quantidade).toFixed(2)})</p>
  `).join('');
}



if (mesa) {
    fetch(`php/obter_mesa.php?mesa=${mesa}`)
        .then(res => res.json())
        .then(dados => {
            document.getElementById("titulo-mesa").textContent = `Mesa ${mesa}`;
            document.getElementById("capacidade").textContent = dados.capacidade;
            document.getElementById("status-pedido").textContent = dados.status;
            document.getElementById("tempo-espera").textContent = dados.tempo_espera ?? '--';
        })
        .catch(err => {
            console.error("Erro ao carregar dados da mesa:", err);
        });
}

function finalizarPedido() {
    alert("Pedido finalizado com sucesso!");
    fetch(`php/liberar_mesa.php?mesa=${mesa}`)
        .then(res => res.text())
        .then(msg => {
            console.log(msg);
            window.location.href = 'garcom.html';
        })
        .catch(err => console.error("Erro ao liberar mesa:", err));
}