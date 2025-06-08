
# **Gestor de Atividades Web**

Este projeto consiste no desenvolvimento de um sistema de gestão de atividades, semelhante a um TODO App, para a disciplina de **Programação Web**, lecionada pelo prof. **Luis Felipe Feres**, no curso de **Análise e Desenvolvimento de Sistemas**, da **Faculdade de Tecnologia de Taubaté**.

---

## **Fluxo de Desenvolvimento do Projeto**

- Levantamento de Requisitos (com base nas instruções fornecidas pelo professor)
- Modelagem de Dados
- Definição da Arquitetura de Software e Design Patterns
- Criação da Interface de Usuário

## **Levantamento de Requisitos**

| ID  | Descrição                                                                                                                                 | Tipo |
|-----|-------------------------------------------------------------------------------------------------------------------------------------------|------|
| 1   | O sistema deve permitir que um usuário se cadastre informando seu nome, sobrenome, data de nascimento, nome de usuário e senha.          | F    |
| 2   | O sistema deve permitir que um usuário faça login com seu nome de usuário e senha.                                                       | F    |
| 3   | O sistema deve permitir que um usuário faça logout de sua conta.                                                                         | F    |
| 4   | O sistema deve permitir que um usuário crie uma atividade, informando título, descrição e data de conclusão.                             | F    |
| 5   | O sistema deve registrar automaticamente a data de criação de uma atividade.                                                             | NF   |
| 6   | O sistema deve definir o status inicial de uma atividade como "Em aberto".                                                               | F    |
| 7   | O sistema deve permitir que um usuário edite os dados de uma atividade.                                                                  | F    |
| 8   | O sistema deve permitir que um usuário altere o status de uma atividade para "Concluída".                                                | F    |
| 9   | O sistema deve permitir que apenas usuários autenticados acessem e editem seus próprios dados.                                           | NF   |
| 10  | O sistema deve garantir que as atividades só possam ser acessadas por seus respectivos autores.                                          | F    |

---

## **Modelagem de Dados**

### **Usuário**
- Nome
- Sobrenome
- Data de Nascimento
- Nome de Usuário
- Senha

### **Atividade**
- Título
- Descrição
- Autor
- Data de Conclusão (definida pelo usuário)
- Data de Criação (gerada automaticamente)
- Status ("Em aberto" / "Concluída")

### **Diagrama Entidade-Relacionamento**

![DER](./db/der.png)

---

## **Arquitetura de Software**

### **Tecnologias Utilizadas**

- **Backend:** PHP puro (sem frameworks)
- **Frontend:** HTML, CSS e JavaScript 
- **Banco de Dados:** MySQL (via XAMPP)
- **Comunicação:** Requisições AJAX utilizando o formato **JSON**
- **Autenticação:** Web Auth (BASIC ou JWT)
- **Sessões:** O uso ou não será definido com base na abordagem escolhida, considerando a segurança e a simplicidade da implementação.
