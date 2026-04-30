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
   ```

2. **Instalar as dependências do Composer:**
   ```bash
   composer install
   ```

3. **Configurar as variáveis de ambiente:**
   * Faz uma cópia do ficheiro `.env.example` e renomeia para `.env`.
   
4. **Gerar a chave da aplicação:**
   ```bash
   php artisan key:generate
   ```

5. **Preparar a Base de Dados (Migrações e Seeders):**
   ```bash
   php artisan migrate --seed
   ```
   *Nota: O comando `--seed` irá popular a base de dados com categorias, pratos, e dois utilizadores de teste.*

6. **Iniciar o servidor local:**
   ```bash
   php artisan serve
   ```
   A API ficará a correr em: `http://127.0.0.1:8000/api`

---

## 🧪 Dados de Teste (Seeders)

Após correres as migrações com o seeder, podes usar estas credenciais para gerar os teus Tokens de acesso no endpoint `/login`:

| Perfil | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@restaurante.pt` | `password123` |
| **Cliente** | `maria@email.com` | `password123` |

---

## 📚 Endpoints da API

### Autenticação e Perfil
| Método | Endpoint | Acesso | Descrição |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/register` | Público | Registo de novo cliente |
| `POST` | `/api/login` | Público | Login (devolve Token) |
| `GET` | `/api/me` | Autenticado | Ver perfil do utilizador logado |
| `PUT` | `/api/me` | Autenticado | Atualizar dados do perfil |
| `POST` | `/api/logout` | Autenticado | Invalidar o token atual |

### Menu (Categorias e Pratos)
| Método | Endpoint | Acesso | Descrição |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/categories` | Público | Listar categorias ativas |
| `GET` | `/api/categories/{id}` | Público | Detalhes da categoria e seus pratos |
| `POST` | `/api/categories` | **Admin** | Criar nova categoria |
| `PUT` | `/api/categories/{id}` | **Admin** | Editar categoria |
| `DELETE` | `/api/categories/{id}` | **Admin** | Apagar categoria |
| `GET` | `/api/dishes` | Público | Listar pratos (com filtros) |
| `POST` | `/api/dishes` | **Admin** | Criar novo prato |
| `PUT` | `/api/dishes/{id}` | **Admin** | Editar prato |
| `DELETE` | `/api/dishes/{id}` | **Admin** | Apagar prato |

### Reservas
| Método | Endpoint | Acesso | Descrição |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/reservations` | Autenticado | Listar reservas (Admin vê todas, Cliente vê as suas) |
| `POST` | `/api/reservations` | Autenticado | Criar nova reserva (com pratos opcionais) |
| `GET` | `/api/reservations/{id}`| Autenticado | Ver detalhes da reserva |
| `PUT` | `/api/reservations/{id}`| Autenticado | Editar reserva (apenas se `pending`) |
| `PATCH`| `/api/reservations/{id}/cancel` | Autenticado | Cliente cancela a própria reserva |
| `PATCH`| `/api/reservations/{id}/status` | **Admin** | Admin altera estado (`confirmed`/`cancelled`) |
| `DELETE`| `/api/reservations/{id}` | **Admin** | Eliminar reserva do sistema |

---
*Projeto desenvolvido para a disciplina de Programação Backend.*
   