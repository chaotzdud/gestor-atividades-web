fetch('/gestor-atividades-web/backend/auth/check_auth.php')
  .then(res => res.json())
  .then(data => {
    if (!data.authenticated) {
      window.location.href = 'signin.html';
    } else {
      loadActivities();
    }
  });

const tabs = document.querySelectorAll('.tab');
const form = document.querySelector('.content > form');
const listContainer = document.querySelector('.content > .list');

tabs.forEach((tab, i) => {
  tab.addEventListener('click', () => {
    tabs.forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
    if (i === 0) {
      form.style.display = 'block';
      listContainer.style.display = 'none';
    } else {
      form.style.display = 'none';
      listContainer.style.display = 'block';
      loadActivities();
    }
  });
});

tabs[0].classList.add('active');
form.style.display = 'block';
listContainer.style.display = 'none';

form.addEventListener('submit', (e) => {
  e.preventDefault();

  const data = {
    title: form.title.value.trim(),
    due_date: form.due_date.value,
    description: form.description.value.trim()
  };

  if (!data.title || !data.due_date || !data.description) {
    alert('Por favor, preencha todos os campos');
    return;
  }

  fetch('/gestor-atividades-web/backend/activities/create_activity.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  }).then(res => res.json())
    .then(response => {
      if (response.success) {
        alert('Atividade criada com sucesso!');
        form.reset();
      } else {
        alert(response.message || 'Erro ao criar atividade');
      }
    });
});

function loadActivities() {
  fetch('/gestor-atividades-web/backend/activities/activities.php')
    .then(res => res.json())
    .then(response => {
      if (!response.success) {
        alert(response.message || 'Erro ao carregar atividades');
        return;
      }
      renderActivities(response.activities);
    });
}

function renderActivities(activities) {
  listContainer.innerHTML = '';

  if (activities.length === 0) {
    listContainer.innerHTML = '<p>Você não tem atividades cadastradas.</p>';
    return;
  }

  activities.forEach(activity => {
    const div = document.createElement('div');
    div.classList.add('activity');

    // Checkbox
    const checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.checked = activity.status === 'done';

    checkbox.addEventListener('change', () => {
    const newStatus = checkbox.checked ? 'done' : 'pending';

    fetch('/gestor-atividades-web/backend/activities/update_activity_status.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id: activity.id, status: newStatus })
    }).then(res => res.json())
      .then(resp => {
        if (!resp.success) {
          alert(resp.message || 'Erro ao atualizar status');
          checkbox.checked = !checkbox.checked;
        } else {
          activity.status = newStatus;
          titleSpan.classList.toggle('done', newStatus === 'done');
        }
      });
  });


    const infoDiv = document.createElement('div');
    infoDiv.classList.add('activity-info', 'tooltip');

    const titleSpan = document.createElement('span');
    titleSpan.textContent = activity.title;
    if (activity.status === 'done') {
      titleSpan.classList.add('done');
    }


    const tooltipText = document.createElement('div');
    tooltipText.classList.add('tooltip-text');
    tooltipText.innerHTML = `${activity.description}<br><small>${formatDate(activity.due_date)}</small>`;

    infoDiv.appendChild(titleSpan);
    infoDiv.appendChild(tooltipText);

    // Buttons delete e edit
    const buttonsDiv = document.createElement('div');
    buttonsDiv.classList.add('buttons-activity');

    const btnDelete = document.createElement('button');
    btnDelete.classList.add('delete');
    btnDelete.innerHTML = '&#x2716;';
    btnDelete.title = "Deletar atividade";

    btnDelete.addEventListener('click', () => {
      if (confirm('Tem certeza que deseja deletar esta atividade?')) {
        fetch('/gestor-atividades-web/backend/activities/delete_activity.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: activity.id })
        }).then(res => res.json())
          .then(resp => {
            if (resp.success) {
              alert('Atividade deletada');
              loadActivities();
            } else {
              alert(resp.message || 'Erro ao deletar atividade');
            }
          });
      }
    });

    const btnEdit = document.createElement('button');
    btnEdit.classList.add('edit');
    btnEdit.innerHTML = '&#x270E;';
    btnEdit.title = "Editar atividade";

    btnEdit.addEventListener('click', () => {
      window.location.href = `edit-activity.html?id=${activity.id}`;
    });

    buttonsDiv.appendChild(btnDelete);
    buttonsDiv.appendChild(btnEdit);

    div.appendChild(checkbox);
    div.appendChild(infoDiv);
    div.appendChild(buttonsDiv);

    listContainer.appendChild(div);
  });
}

function formatDate(dateStr) {
  const d = new Date(dateStr);
  return d.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' });
}

document.querySelector('.credits').addEventListener('click', () => {
  window.location.href = 'credits.html';
});

document.querySelector('.exit').addEventListener('click', () => {
  fetch('/gestor-atividades-web/backend/auth/logout.php', { method: 'POST' })
    .then(res => res.json())
    .then(response => {
      if (response.success) {
        window.location.href = 'signin.html';
      }
    });
});
