# Parceria Animal

Este projeto é uma API REST desenvolvida em PHP para gerenciamento de animais, veterinários e consultas. O ambiente é totalmente configurado via Docker, utilizando Apache + PHP e MariaDB, com acesso via Postman.

## Pré-requisitos

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [Postman](https://www.postman.com/)

## Como Executar o Projeto

- **Execute o projeto com o Docker Compose**

```bash
docker compose up --build
```

Este comando irá:

* Construir a imagem com PHP + Apache
* Subir o banco de dados MariaDB com o script `parceriaanimal.sql`
* Disponibilizar a API localmente em `http://localhost:8080`

## Testando com Postman

* **URL base**:

  ```
  http://localhost:8080/ParceriaAnimal/
  ```

* **Exemplos de endpoints disponíveis**:

  * `animal.php`
  * `consulta.php`
  * `veterinario.php`

* **Métodos suportados**: utilize `GET`, `POST`, `PUT` ou `DELETE`, dependendo do endpoint e da ação desejada.

## Banco de Dados

* **Host**: `db`
* **Usuário**: `root`
* **Senha**: `root`
* **Banco**: `parceriaanimal`

O banco é criado automaticamente na primeira execução a partir do script:

```
./parceriaanimal.sql
```

## Parar os serviços

```bash
docker compose down
```

## Estrutura do Projeto

```
project-animal/
├── ParceriaAnimal/         # Código-fonte PHP da API
├── docker/                 # Dockerfile para configurar Apache + PHP
├── parceriaanimal.sql      # Script SQL de criação do banco
├── docker-compose.yml      # Orquestração dos containers
└── README.md               # Instruções do projeto
```