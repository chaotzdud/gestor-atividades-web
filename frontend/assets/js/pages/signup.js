document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('signup-form');
  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    const data = {
      fname: document.getElementById('fname').value,
      lname: document.getElementById('lname').value,
      dbirth: document.getElementById('dbirth').value,
      username: document.getElementById('username').value,
      password: document.getElementById('password').value,
    };

    try {
      const response = await fetch('/gestor-atividades-web/api/users', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
      });

      const result = await response.json();

      if (response.ok) {
        alert('Usuário cadastrado com sucesso!');
        window.location.href = '/gestor-atividades-web/signup.html';
      } else {
        alert(result.message || 'Erro ao cadastrar');
      }
    } catch (error) {
      console.error(error);
      alert('Erro de conexão com o servidor');
    }
  });
});
