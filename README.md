# Desafio OneRPM

## Backend

### Começando

Dentro da raiz do projeto no terminal rodar

```
cp .env.example .env
# preencha as keys do Spotify

# iniciar o container
docker compose up -d --build

# instalar as dependências
docker compose exec app composer install

# gerar key
docker compose exec app php artisan key:generate

# criar as tabelas no banco de dados
docker compose exec app php artisan migrate

```

### Testando

Crie o env de teste

```
cp .env.example .env.testing
```

Mude as seguintes variáveis

```
APP_ENV=testing
DB_DATABASE=challenge_test
# preencha também as keys do spotify
```

### Decisões técnicas

- Utilizei Redis como cache para armazenar o token de autenticação do Spotify
- Por se tratar de uma importação simples e como não estava especificado no desafio, não utilizei filas, mas seria o ideal caso houvesse importação em massa
- Parece que o Spotify removeu o preview_url, por isso provavelmente não irá aparecer no front
