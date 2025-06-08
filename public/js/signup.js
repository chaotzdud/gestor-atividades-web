document.getElementById("signup-form").addEventListener("submit", function (e) {
  e.preventDefault();

  const data = {
    fname: document.getElementById("fname").value,
    lname: document.getElementById("lname").value,
    dbirth: document.getElementById("dbirth").value,
    username: document.getElementById("username").value,
    password: document.getElementById("password").value
  };

  fetch("../api/register.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data)
  })
    .then(res => res.json())
    .then(response => {
      if (response.success) {
        alert("Cadastro realizado com sucesso!");
        window.location.href = "signin.html";
      } else {
        alert(response.message);
      }
    });
});
