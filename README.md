# Desafio OneRPM

## Começando

Dentro da raiz do projeto no terminal rodar

```
cp .env.example .env

# iniciar o container
docker compose up -d --build

# instalar as dependências
docker compose exec app composer install

# gerar key
docker compose exec app php artisan key:generate

# criar as tabelas no banco de dados
docker compose exec app php artisan migrate

```