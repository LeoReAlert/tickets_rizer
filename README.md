# Projeto Laravel

Este é um projeto Laravel totalmente open source não venda sem autorização!

## Requisitos

- PHP >= 8.1 (Ou superior)
- Composer
- Banco de dados (MySQL, PostgreSQL, SQLite, etc.)
- [Node.js e NPM](https://nodejs.org/)

## Instalação

   0. **Roda composer instalar pacotes**

   No terminal rodar o camando para instalar pacotes:

   ```bash
     composer install --no-dev
   ```

   1. **Clone o repositório**

   Primeiro, clone o repositório do GitHub para a sua máquina local:

   ```bash
   git clone https://github.com/LeoReAlert/tickets_rizer

   ```

   2. **Gerar key DB**

   No terminal gerar a key:

   ```bash
    php artisan key:generate
   ```

   3. **Gerar migration**

   No terminal rodar migration:

   ```bash
    php artisan migrate
   ```

   4. **Popular banco com seeed**

   No terminal rodar seeders isso vai criar as permissões e usuários:

   ```bash
    php artisan db:seed
   ```


   
