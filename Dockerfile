# Use a imagem oficial PHP com Apache e extensões necessárias
FROM php:8.2-apache

# Instala dependências do sistema e extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

# Habilita o mod_rewrite do Apache (para URLs amigáveis do Laravel)
RUN a2enmod rewrite

# Copia o composer para dentro do container
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia o código da aplicação para dentro do container
COPY . .

# Instala dependências PHP do Laravel
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Permite escrita nas pastas storage e bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Ajusta DocumentRoot para public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

ADD https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh /wait-for-it.sh
RUN chmod +x /wait-for-it.sh


EXPOSE 80
