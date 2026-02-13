# Lista de Tarefas PHP

Sistema de gerenciamento de tarefas desenvolvido em PHP com MySQL, implementando operações CRUD com foco em segurança e boas práticas.

## Funcionalidades

- ✅ Adicionar novas tarefas
- ✅ Listar todas as tarefas
- ✅ Excluir tarefas (com confirmação)
- ✅ Contador de tarefas
- ✅ Interface responsiva e moderna
- ✅ Proteção contra SQL Injection
- ✅ Validação de dados

## Tecnologias Utilizadas

- **PHP 7+**: Backend e lógica de negócio
- **MySQL**: Banco de dados relacional
- **HTML5**: Estrutura da aplicação
- **CSS3**: Estilização com gradientes e animações

### Pré-requisitos

- PHP 7.0 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache, Nginx) ou XAMPP/WAMP

### Instalação

1. **Clone o repositório:**
```bash
git clone https://github.com/SEU_USUARIO/lista-tarefas-php.git
cd lista-tarefas-php
```

2. **Configure o banco de dados:**

   Execute o script SQL no MySQL:
   ```bash
   mysql -u root -p < database.sql
   ```

   Ou importe manualmente via phpMyAdmin:
   - Acesse phpMyAdmin
   - Crie um novo banco chamado `lista_tarefas_db`
   - Importe o arquivo `database.sql`

3. **Configure as credenciais do banco:**

   Edite as linhas 2-5 do arquivo `index.php`:
   ```php
   $host = "localhost";
   $user = "root";          // Seu usuário MySQL
   $pass = "";              // Sua senha MySQL
   $dbname = "lista_tarefas_db";
   ```

4. **Inicie o servidor:**

   **Opção 1 - PHP Built-in Server:**
   ```bash
   php -S localhost:8000
   ```

   **Opção 2 - XAMPP/WAMP:**
   - Coloque os arquivos em `htdocs/lista-tarefas/`
   - Acesse: `http://localhost/lista-tarefas/`

5. **Abra no navegador:**
   ```
   http://localhost:8000
   ```

## Estrutura do Banco de Dados

```sql
CREATE TABLE tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    texto_tarefa VARCHAR(255) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Segurança Implementada

Este projeto segue boas práticas de segurança web:

### 1. **Proteção contra SQL Injection**

```php
// Uso de Prepared Statements
$stmt = $conn->prepare("INSERT INTO tarefas (texto_tarefa) VALUES (?)");
$stmt->bind_param("s", $texto);
$stmt->execute();
```

### 2. **Validação de Entrada**
```php
// Validar ID como número inteiro
$id = filter_input(INPUT_GET, 'deletar', FILTER_VALIDATE_INT);
```

### 3. **Proteção contra XSS**
```php
// Escapar dados antes de exibir
$texto = htmlspecialchars($linha['texto_tarefa']);
```

### 4. **Charset UTF-8**
```php
// Evitar problemas de encoding
$conn->set_charset("utf8mb4");
```

## Conceitos Aplicados

- **CRUD Completo**: Create (adicionar), Read (listar), Delete (excluir)
- **Prepared Statements**: Prevenção de SQL Injection
- **POST/Redirect/GET Pattern**: Evita reenvio de formulário
- **Sanitização de dados**: htmlspecialchars() e trim()
- **Design Responsivo**: Adapta-se a diferentes tamanhos de tela

## Melhorias Futuras

- [ ] Marcar tarefas como concluídas
- [ ] Editar tarefas existentes
- [ ] Filtros (concluídas/pendentes)
- [ ] Paginação para muitas tarefas
- [ ] Sistema de categorias/tags
- [ ] Autenticação de usuários


## Contribuições

Contribuições são bem-vindas! 


## Autor

Desenvolvido por **[Guilherme Afonso Carvalho]** durante o aprendizado de PHP e MySQL.

- GitHub: [GuilhermeAfonC](https://github.com/GuilhermeAfonC)
- LinkedIn: www.linkedin.com/in/guilhermeafonsocarvalho-tic
- Email: afonsocarvalhoguilherme@gmail.com



