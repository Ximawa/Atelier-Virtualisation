# Utilisez une image PHP récente
FROM php:8.3-apache

RUN docker-php-ext-install mysqli pdo_mysql

# Copiez les fichiers de votre application dans le conteneur
COPY www/ /var/www/html/

# Assurez-vous que le dossier uploads est accessible en lecture et écriture
RUN chmod -R 777 /var/www/html/uploads

# Exposez le port 80 (port par défaut pour Apache)
EXPOSE 80