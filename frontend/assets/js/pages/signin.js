document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('signin-form');
    form.addEventListener('submit', async function (e) {
      e.preventDefault();
  
      const data = {
        username: document.getElementById('username').value,
        password: document.getElementById('password').value,
      };
  
      try {
        console.log(data)
        const response = await fetch('/gestor-atividades-web/api/login', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(data),
        });
  
        const result = await response.json();
        
        console.log(response)

        if (response.ok) {
          alert('Usuário autenticado com sucesso!');
          window.location.href = '/gestor-atividades-web/frontend/pages/home.html';
        } else {
          alert(result.message || 'Erro ao cadastrar');
        }
      } catch (error) {
        console.error(error);
        alert('Erro de conexão com o servidor');
      }
    });
  });
  