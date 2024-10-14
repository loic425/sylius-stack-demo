# Sylius Stack Demo

⚙️ Installation
---------------

```shell
docker compose up -d
composer install
symfony console doctrine:migrations:migrate -n
symfony console doctrine:fixtures:load -n 
```

▶️ Run project
--------------

```shell
symfony serve -d
symfony open:local
```
