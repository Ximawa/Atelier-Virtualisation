# Etape 1


## Creation img application php
```
docker build -t app_php -f Dockerfile.php .
```

## Creation img bdd mysql
```
docker build -t bdd_sql -f Dockerfile.mysql .
```

## Creation du reseau qui sera utilise par nos container
```
docker network create app_bdd_network
```

## Lancement du container base sur l'img php
```
docker run -d -p 80:80 --network app_bdd_network --name container_php app_php
```

## Lancement du container base sur l'img sql 
(Besoin de rajouter les variables d'environnment directement dans l'intrustion car soucis sans)
```
docker run -d -p 3306:3306 --network app_bdd_network -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=gestion_produits --name container_sql bdd_sql
```