// Função para pegar parâmetro da URL
function getQueryParam(param) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(param);
}

const activityId = getQueryParam('id');

if (!activityId) {
  alert('ID da atividade não informado');
  window.location.href = 'home.html';
}

const form = document.querySelector('.form');

// Carrega dados da atividade para editar
fetch(`/gestor-atividades-web/api/get_activity.php?id=${activityId}`)
  .then(res => res.json())
  .then(data => {
    if (!data.success) {
      alert(data.message || 'Erro ao carregar atividade');
      window.location.href = 'home.html';
      return;
    }
    const activity = data.activity;
    form.title.value = activity.title;
    form.due_date.value = activity.due_date;
    form.description.value = activity.description;
  });

// Aplica alterações
form.addEventListener('submit', (e) => {
  e.preventDefault();

  // Detecta se cancelou (botão cancel tem type submit, para facilitar)
  if (document.activeElement.classList.contains('btn-cancel')) {
    window.location.href = 'home.html';
    return;
  }

  const data = {
    id: parseInt(activityId),
    title: form.title.value.trim(),
    due_date: form.due_date.value,
    description: form.description.value.trim()
  };

  if (!data.title || !data.due_date || !data.description) {
    alert('Preencha todos os campos');
    return;
  }

  fetch('../api/update_activity.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  }).then(res => res.json())
    .then(resp => {
      if (resp.success) {
        alert('Atividade atualizada com sucesso!');
        window.location.href = 'home.html';
      } else {
        alert(resp.message || 'Erro ao atualizar atividade');
      }
    });
});
