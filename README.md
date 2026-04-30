# 🍽️ Restaurante API

Uma API RESTful desenvolvida em **Laravel 11** para a gestão completa de um restaurante. Este projeto permite gerir utilizadores, categorias de ementa, pratos e o ciclo de vida de reservas de mesas, implementando segurança com tokens e diferentes níveis de acesso (Clientes e Administrador).

## 🚀 Tecnologias Utilizadas
* **Linguagem:** PHP 8.x
* **Framework:** Laravel 11
* **Base de Dados:** SQLite
* **Autenticação:** Laravel Sanctum
* **Testes de API:** Postman

## ✨ Funcionalidades Principais

### 🔒 Autenticação e Autorização (Sanctum)
* Registo e Login de utilizadores com emissão de tokens seguros.
* Diferenciação de permissões através de um Middleware `is_admin` customizado.
* Utilizadores comuns (clientes) vs. Proprietário (Admin).

### 🍕 Gestão de Menu (CRUD)
* **Público:** Visualização de categorias ativas e pratos disponíveis. Suporta filtros via *query string* (ex: `?category_id=1&max_price=15`).
* **Privado (Admin):** Acesso total para criar, editar (atualizar preços/disponibilidade) e remover categorias ou pratos.

### 📅 Sistema de Reservas
* **Clientes:** Podem efetuar reservas (data, pessoas, notas) e associar os pratos desejados antecipadamente. Têm acesso apenas ao seu próprio histórico.
* **Ciclo de Vida:** 
  * As reservas iniciam no estado `pending` (pendente).
  * O cliente pode editar ou cancelar *apenas* enquanto estiver pendente.
  * O Administrador gere as reservas aprovando (`confirmed`) ou rejeitando (`cancelled`).
  * Reservas confirmadas ficam bloqueadas para edição pelo cliente.

---

## ⚙️ Instalação e Configuração Local

Para testares este projeto na tua máquina local, segue estes passos:

1. **Clonar o repositório:**
   
```bash
   git clone [https://github.com/o-teu-username/restaurante-api.git](https://github.com/o-teu-username/restaurante-api.git)
   cd restaurante-api
   