# Estrutura do Projeto SUS Connect - PHP

## Fluxo de Navegação

```
Homepage (/)
    ↓
Página de Login (index.php)
    ↓
Dashboard - Landing Page (dashboard.php) - PROTEGIDO
    ├→ Atenção Primária (/reports/atencao.php)
    ├→ Vigilância em Saúde (/reports/vigilancia.php)
    ├→ Repasses Financeiros (/reports/repasses.php)
    ├→ Arboviroses (link externo)
    └→ Logout (/logout.php)
```

## Estrutura de Arquivos

```
project/
├── index.php                 # Página de LOGIN (porta inicial)
├── dashboard.php             # Landing page SUS CONNECT (após autenticação)
├── logout.php                # Script de logout
├── package.json              # Metadata do projeto
├── .htaccess                 # Configurações Apache
│
├── config/
│   ├── Database.php          # Classe de conexão PDO
│   └── database.sql          # Script de criação BD
│
├── includes/
│   └── auth.php              # Sistema de autenticação
│
├── reports/
│   ├── atencao.php           # Relatório Atenção Primária (Power BI)
│   ├── vigilancia.php        # Relatório Vigilância (Power BI)
│   └── repasses.php          # Relatório Repasses (Power BI)
│
└── assets/
    ├── prefeitura_negativo.png
    ├── profissionais-saude.jpg
    └── sems-logo.png
```

## Usuário Padrão

- **Email**: admin@dourados.ms.gov.br
- **Senha**: admin123
- **IMPORTANTE**: Altere após o primeiro login!

## Fluxo de Autenticação

1. Usuário acessa `/` (raiz do site)
2. Carrega `index.php` - página de LOGIN com fundo de imagem
3. Após login bem-sucedido:
   - Cookie `session_token` é criado (válido por 24h)
   - Redireciona para `/dashboard.php`
4. Se já está logado e acessa `/`, redireciona para `/dashboard.php`
5. Dashboard está protegido - requer autenticação válida
6. Cada relatório em `/reports/` também está protegido

## Proteção de Páginas

Todas as páginas exceto `index.php` (login) estão protegidas com:

```php
$auth = new Auth();
$user = $auth->requireAuth(); // Redireciona para login se não autenticado
```

## Instalação no XAMPP

1. Copie todos os arquivos para `C:\xampp\htdocs\susconnect\`
2. Crie o banco de dados executando `config/database.sql`
3. Acesse: `http://localhost/susconnect/`

## Deployment

O projeto está configurado para deployment com:
- `package.json` mínimo (apenas para declarar que é projeto PHP)
- Script `npm run build` que não faz nada (PHP não precisa de build)
- Pronto para plataformas que suportam PHP (Heroku, Vercel, Netlify com buildpack PHP, etc)
