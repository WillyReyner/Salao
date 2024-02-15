
# Modelo padrão de utilização em aplicações

  

Modelo laravel + vuejs3 padrão já configurado para utilização com quasar e tailwind css configurados com Docker.

- Hyper-V (Linux ou Windows 10 (execeto versão HOME/Single Language))

- Laravel 10

- PHP 8.1

- Vuejs3

- Quasar

- Tailwind Css

- Node 18.0*

- Docker 20.0*

## Clone

  

```bash
git  clone  https://github.com/cettufg/docker-laravel-vuejs.git
```

  

## Instalação

- Instale as dependencias do Laravel com o composer e do Quasar/Vue com o NPM.

```bash
composer  install && npm  install
```

  

- Aguarde a instalação dos pacotes.

  

## Configuração

  

- Defina as variáveis .env do usando o .env.example
-- Os containeres serão montados utilizando os dados do .env.

## Iniciando o projeto
 Montar e iniciar os containers:
 1. Iniciar os containers:
 ```bash
docker compose --env-file src\.env up -d
```
2. Acessar o container do PHP para rodar as migrations e gerar a chave da aplicação, utilize o comando baixo para exibir os containers:
 ```bash
docker ps
```
3. o CONTAINER ID de apelido {nome-da-aplicação}-app será o container do php, e você precisará pelo menos 4 dos primeiros dígitos
4. Para acessar o container:
```bash 
docker exec -it container-id bash
```
5. Após acessar o container, definas as permissões para a pasta "/storage" (Caso esteja no Linux)
```bash 
chmod -R 777 /storage
```
6. Execute os comandos para gerar a chave e migrations
```bash
php artisan key:generate
php artisan migrate
```
7. Pronto, projeto configurado e executando.

## Acessando os serviços
A princípio coloquei algumas portas para acesso:
:8080 - Aplicação 
:8095 - PhpMyAdmin

#### Comandos úteis:
Para resetar todo o docker:
```bash
docker system prune -a
```
Para parar os containers e remover imagens:
```bash
docker-compose --env-file src\.env down --rmi all
```
# Salao
# Salao
# Salao
