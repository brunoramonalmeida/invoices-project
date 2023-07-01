# Invoices Project

Este projeto, chamado **Invoices Project**, foi criado por Bruno Ramon Almeida.

## Descrição

O Invoices Project é um sistema de gerenciamento de cobranças que permite a geração de boletos e envio de e-mails para cobrança de débitos. Ele foi desenvolvido usando o framework Laravel com PHP e segue os princípios do SOLID para garantir uma arquitetura limpa e modular.

O sistema recebe uma lista de débitos por meio de uma API, na forma de um arquivo CSV contendo informações como nome, CPF, e-mail, valor da dívida, vencimento da dívida e código da dívida. Com base nessas informações, o sistema gera boletos periodicamente e envia e-mails para cobrança.

Além disso, o sistema foi projetado de forma modular, utilizando o conceito de repositories e services, permitindo uma maior flexibilidade e facilidade de manutenção.

## Funcionalidades

- Receber lista de débitos via API no formato CSV.
- Gerar boletos para cobrança dos débitos.
- Enviar e-mails de cobrança para os devedores.
- Arquitetura baseada em repositories e services, seguindo os princípios do SOLID.
- Testes unitários e de integração para garantir a qualidade do código.
- Executar o comando `php artisan schedule:work` para rodar a job que envia os boletos rotineiramente.

## Requisitos de Instalação

- PHP 7.4 ou superior
- Composer
- Banco de dados (MySQL, PostgreSQL, SQLite, etc.)
- Extensões PHP necessárias (consulte o arquivo `composer.json` para obter a lista completa)

## Instalação

1. Faça o clone deste repositório para o diretório desejado.
2. Acesse o diretório do projeto: `cd invoices-project`.
3. Execute o comando `composer install` para instalar as dependências do projeto.
4. Renomeie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente, como conexão com o banco de dados.
5. Execute o comando `php artisan key:generate` para gerar a chave do aplicativo.
6. Execute o comando `php artisan migrate` para executar as migrações do banco de dados.
7. O sistema está pronto para uso!

## Uso

Para iniciar o servidor local do Laravel, execute o comando `php artisan serve`. O sistema estará acessível em `http://localhost:8000`.

Você pode configurar as rotas e controladores em `routes/web.php` e `app/Http/Controllers` para definir as funcionalidades do sistema de acordo com suas necessidades.

Além disso, você pode executar os testes unitários e de integração com o comando `php artisan test` para garantir a qualidade do código.

Para que a job responsável por enviar os boletos seja executada periodicamente, é necessário rodar o comando `php artisan schedule:work`. Isso garante que as cobranças sejam enviadas regularmente de acordo com a configuração de agendamento definida no arquivo `app/Console/Kernel.php`.

## Autor

Bruno Ramon de Almeida e Silva

## Licença

Este projeto está licenciado sob a [MIT License](LICENSE).
