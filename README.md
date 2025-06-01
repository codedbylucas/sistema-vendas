# 🛒 Sistema de Vendas e Gestão de Usuários

Sistema web desenvolvido em **PHP puro** com **MySQL**, voltado para a gestão de clientes, produtos, estoque e pedidos. Conta com controle de acesso por níveis de usuário (admin, funcionário e cliente) e uma interface moderna e responsiva.

## 👥 Tipos de Usuário

- **Admin**
  - Acesso total ao sistema
  - Gerencia usuários (funcionários e clientes)
  - Visualiza e edita todas as informações

- **Funcionário**
  - Pode cadastrar e gerenciar:
    - Clientes
    - Produtos
    - Estoque
    - Pedidos
    - Login de acesso para clientes vinculados

- **Cliente**
  - Pode:
    - Realizar pedidos
    - Visualizar seus próprios pedidos
    - Cancelar pedidos (com devolução automática ao estoque)

---

## 📦 Funcionalidades

### 🔐 Autenticação
- Login com validação de credenciais
- Sessão segura e redirecionamento por tipo de usuário

### 👤 Clientes
- Cadastro completo (nome, CPF, idade, endereço, etc)
- Vinculação com login de acesso (feito por funcionário)

### 📦 Produtos
- Cadastro e manutenção
- Atributos: descrição, cor, voltagem, situação (ativo/inativo)

### 🏪 Estoque
- Vinculado a produtos
- Controle de saldo, preço e descrição

### 🛍️ Pedidos
- Cliente pode realizar compras de produtos disponíveis
- Geração automática de total
- Validação de saldo e entrega
- Cancelamento com devolução do estoque

---

## 🧱 Tecnologias Utilizadas

- **PHP** (sem frameworks)
- **MySQL**
- **HTML5 + CSS3 (Flexbox e Grid)**
- **Font Awesome**
- **Google Fonts - Inter**
- **Padrão MVC simplificado**

---

## 📁 Estrutura de Pastas

