# Ambiente de Desenvolvimento

Ambiente de desenvolvimento em docker contendo as seguintes configurações:

- PHP 7.0.*
  - XDebug
  - Composer
- Mailcatcher
- Redis
- MariaDB

# Requisitos

- Docker instalado https://www.docker.com/products/docker

# Configuração

Adicionar os seguintes endereços ao arquivo `/etc/hosts`:

```
127.0.0.1   mltools.develop
127.0.0.1   mltools.db
127.0.0.1   mltools.redis
127.0.0.1   mltools.mail
```

Configuração de IP dinâmico feita para MacOS, vide arquivo develop. Trocar pelo IP do host ou pelo comando que retorna o mesmo.

O ambiente esta configurado para mapear a aplicação contida no diretorio backend para `/var/www` e está o server php está direcionado para o diretório `/var/www/public`.

Esta configuração compreende somente o ambiente. É necessário que a aplicação seja configurada conforme necessário.

# Run

```
// docker-compose ps
./develop

// docker-compose x, onde x pode ser qualquer comando acessível através do docker-compose
// ex: Build do ambiente
./develop build

// Para subir as máquinas, basta rodar os seguintes comandos
./develop build
./develop up -d
```

# Acesso

Depois de subir os containers e configurar o arquivo de hosts basta acessar o endereço da aplicação. Seguindo este exemplo, o endereço seria `http://mltools.develop/`.
