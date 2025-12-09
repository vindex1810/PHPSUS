# SUS Connect - Versão PHP

Sistema de Monitoramento da Saúde para Dourados/MS desenvolvido em PHP para uso com XAMPP.

## Requisitos

- XAMPP 8.2.12 ou superior
- PHP 8.2+
- MySQL/MariaDB 10.4+
- Apache 2.4+

## Instalação

### 1. Configurar XAMPP

1. Instale o XAMPP
2. Inicie os serviços Apache e MySQL
3. Acesse phpMyAdmin em `http://localhost/phpmyadmin`

### 2. Criar o Banco de Dados

1. No phpMyAdmin, vá em "SQL"
2. Copie e execute todo o conteúdo do arquivo `config/database.sql`
3. Isso criará o banco de dados `sus_connect` com as tabelas necessárias

### 3. Instalar os Arquivos

1. Copie todos os arquivos da pasta `php-version` para `C:\xampp\htdocs\susconnect\`
2. Crie a pasta `assets/images/` dentro de `htdocs/susconnect/`
3. Copie as imagens necessárias:
   - `profissionais-saude.jpg`
   - `prefeitura_negativo.png`
   - `sems-logo.png`

### 4. Configurar Permissões

Certifique-se de que o Apache tem permissão para ler os arquivos.

### 5. Acessar o Sistema

1. Abra o navegador e acesse: `http://localhost/susconnect/`
2. Você será redirecionado para a tela de login

## Credenciais Padrão

**IMPORTANTE: Altere estas credenciais após o primeiro login!**

- **Email**: admin@dourados.ms.gov.br
- **Senha**: admin123

## Estrutura do Projeto

```
susconnect/
├── config/
│   ├── Database.php          # Classe de conexão com banco de dados
│   └── database.sql          # Script SQL de criação das tabelas
├── includes/
│   └── auth.php              # Sistema de autenticação
├── assets/
│   └── images/               # Imagens do sistema
├── index.php                 # Página inicial (landing page)
├── login.php                 # Tela de login
├── logout.php                # Script de logout
├── dashboard.php             # Dashboard interno
├── powerbi.php               # Visualização de relatórios Power BI
├── .htaccess                 # Configurações do Apache
└── README.md                 # Este arquivo
```

## Funcionalidades

### Autenticação
- Login com email e senha
- Sessões seguras com tokens
- Logout automático após 24 horas
- Log de acessos

### Páginas Públicas
- Tela de login

### Páginas Protegidas (requerem autenticação)
- Landing page com links para Power BI
- Relatórios Power BI:
  - Atenção Primária
  - Vigilância em Saúde
  - Repasses Financeiros
- Links externos:
  - Arbo Notifica
  - Mapas CCZ
  - Mapa Territorial das UBSs

## Segurança

### Implementações de Segurança
- Senhas criptografadas com bcrypt
- Proteção contra SQL Injection (PDO com prepared statements)
- Proteção contra XSS (htmlspecialchars)
- Tokens de sessão seguros
- Cookies HttpOnly
- Headers de segurança configurados
- Proteção de arquivos sensíveis via .htaccess

### Recomendações Adicionais
1. Use HTTPS em produção
2. Altere as credenciais padrão
3. Configure backup automático do banco de dados
4. Monitore os logs de acesso

## Banco de Dados

### Tabelas

#### users
- Armazena informações dos usuários
- Senhas criptografadas com bcrypt

#### sessions
- Gerencia sessões ativas
- Expira automaticamente após 24 horas

#### access_logs
- Registra todos os acessos ao sistema
- Útil para auditoria

## Troubleshooting

### Erro de Conexão com Banco de Dados
- Verifique se o MySQL está rodando no XAMPP
- Confirme as credenciais em `config/Database.php`
- Certifique-se de que o banco de dados `sus_connect` foi criado

### Erro 404 nas URLs
- Verifique se o módulo `mod_rewrite` está ativado no Apache
- Confirme que o arquivo `.htaccess` está presente

### Imagens não aparecem
- Verifique se as imagens estão na pasta `assets/images/`
- Confirme as permissões de leitura dos arquivos

### Problemas com Sessão
- Limpe os cookies do navegador
- Verifique as permissões da pasta de sessões do PHP

## Desenvolvimento

### Adicionar Novo Usuário via SQL

```sql
INSERT INTO users (email, password_hash, name)
VALUES ('email@exemplo.com', '$2y$10$hash_aqui', 'Nome do Usuário');
```

Para gerar o hash da senha em PHP:
```php
echo password_hash('sua_senha', PASSWORD_DEFAULT);
```

### Estrutura de URLs

- `/` ou `/index.php` - Landing page (requer login)
- `/login.php` - Tela de login
- `/logout.php` - Logout
- `/dashboard.php` - Dashboard (futuro)
- `/powerbi.php?report=atencao` - Relatório Atenção Primária
- `/powerbi.php?report=vigilancia` - Relatório Vigilância
- `/powerbi.php?report=repasses` - Relatório Repasses

## Suporte

Para suporte técnico, entre em contato com a Coordenação de Saúde Digital & Inovação da SEMS.

## Licença

© 2025 Prefeitura Municipal de Dourados/MS
