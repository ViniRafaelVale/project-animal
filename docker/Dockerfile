# Usa a imagem oficial do PHP com Apache
FROM php:8.1-apache

# Instala as extensões necessárias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilita o módulo de reescrita do Apache (necessário para .htaccess)
RUN a2enmod rewrite

# Permite uso de .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Copia o código-fonte para o diretório padrão do Apache
COPY ./ParceriaAnimal /var/www/html

# Expõe a porta 80 (usada internamente pelo Apache)
EXPOSE 80