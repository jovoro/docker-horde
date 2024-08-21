FROM alpine AS theme
RUN apk add -U git && \
    git clone https://github.com/pannal/horde-groupware-theme-x.git /theme

FROM php:7.4.33-apache
ARG HORDE_WEBMAIL_VERSION=5.2.22
WORKDIR /var/www/html

# Reqs de https://www.horde.org/apps/webmail/docs/INSTALL
# Modulos:
# ========
# gettext
# xml & domxml
# mysqli
# ldap
# mbstring
# imap
# iconv
# gd
# tidy
# openssl
# fileinfo
# intl
# curl
# ftp
#
# PEAR extensions
# ===============
# Date
# Net_DNS2
# Services_Weather
# Date_Holidays
# Net_Sieve
# 
# PECL extensions
# ===============
# fileinfo
# imagick
# horde_lz4
# memcache
# http
#
# Apps
# =====
# aspell
# FTP
# En php.ini 
# ============
# upload_max_filesize = 15M
# post

RUN apt-get update && \
    apt-get install -y \
      gettext \
      libxslt-dev \
      libldap-dev \
      libc-client2007e-dev \
      libkrb5-dev \
      libmcrypt-dev \
      libwebp-dev \
      libjpeg62-turbo-dev \
      libpng-dev \
      libxpm-dev \
      libfreetype6-dev \
      libtidy-dev \
      libtidy5deb1 \
      libcurl4-openssl-dev \
      libgeoip-dev \
      libmagick++-dev \
      libmemcached-dev \
      libonig-dev  && \
    docker-php-ext-install -j$(nproc) gettext && \
    docker-php-ext-install -j$(nproc) xsl && \
    docker-php-ext-install -j$(nproc) xml && \
    docker-php-ext-install -j$(nproc) mysqli && \
    docker-php-ext-install -j$(nproc) mbstring && \
    docker-php-ext-configure imap --with-imap --with-imap-ssl --with-kerberos && \
    docker-php-ext-install -j$(nproc) imap && \
    docker-php-ext-install -j$(nproc) iconv && \
    docker-php-ext-configure gd && \
    docker-php-ext-install -j$(nproc) gd && \
    docker-php-ext-install -j$(nproc) tidy && \
    docker-php-ext-install -j$(nproc) intl && \
    docker-php-ext-install -j$(nproc) curl && \
    docker-php-ext-install -j$(nproc) ftp && \
    pear channel-discover pear.horde.org && \
    pecl install -f horde/horde_lz4 && \
    echo extension=horde_lz4.so > /usr/local/etc/php/conf.d/docker-php-ext-pecl-horde_lz4.ini && \
    pecl install -f imagick && \
    echo extension=imagick.so > /usr/local/etc/php/conf.d/docker-php-ext-pecl-imagick.ini && \
    pecl install -f memcached-3.1.5 && \
    docker-php-ext-enable memcached && \
    pecl install mcrypt-1.0.5 && \
    docker-php-ext-enable mcrypt && \
    pear install horde/horde_role && \
    echo 'a:1:{s:10:"__channels";a:4:{s:12:"pecl.php.net";a:0:{}s:5:"__uri";a:0:{}s:11:"doc.php.net";a:0:{}s:14:"pear.horde.org";a:1:{s:9:"horde_dir";s:19:"/var/www/html/horde";}}}' > /root/.pearrc && \
    pear install -a -B -f horde/webmail-${HORDE_WEBMAIL_VERSION} && \
    sed '/bundle->configDb/d;/bundle->configAuth/d' /usr/local/bin/webmail-install > /usr/local/bin/webmail-migrateDb && \
    chmod +x /usr/local/bin/webmail-migrateDb && \
    rm -fr /tmp/pear && \
    a2enmod rewrite && \
    sed -i 's/ServerTokens OS/ServerTokens Prod/g;s/ServerSignature On/ServerSignature Off/g' /etc/apache2/conf-available/security.conf && \
    apt update && apt install -y locales && \
    sed -i -e 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/;s/# es_ES.UTF-8 UTF-8/es_ES.UTF-8 UTF-8/' /etc/locale.gen && locale-gen && \
    rm -rf /var/lib/apt/lists/* && \
    pear uninstall pear/Services_Weather

ENV HORDE_SQL_PORT=3306 \
    HORDE_SQL_DATABASE=horde
COPY templates/horde/*.php horde/config/
COPY templates /horde-templates
COPY --from=theme /theme/themes/knttheme horde/themes/knttheme
COPY --from=theme /theme/imp/themes/knttheme horde/imp/themes/knttheme
COPY --from=theme /theme/kronolith/themes/knttheme horde/kronolith/themes/knttheme
COPY start-horde /usr/local/bin/start-horde
RUN chown -R www-data horde/static && find . -type d -name config -exec chown -R www-data {} \; && \
    echo 'RewriteEngine On' > /var/www/html/.htaccess && \
    echo 'RewriteRule ^$ /horde [L]' >> /var/www/html/.htaccess && \
    echo 'SetEnvIf Request_URI "\.gif$|\.jpg|\.png|\.css|\.ico|\.js|\.jpeg$" is_static' > /etc/apache2/conf-enabled/horde.conf && \
    sed -i 's@CustomLog ${APACHE_LOG_DIR}/access.log combined@CustomLog ${APACHE_LOG_DIR}/access.log combined env=!is_static@' /etc/apache2/sites-available/000-default.conf && \
    mkdir -p /etc/horde-default-configurations && \
    find ./horde/ -maxdepth 3 -type d -name config -print0 | \
      tar cf - --null -T - | \
      tar -C /etc/horde-default-configurations --strip-components=2 -xf -
CMD ["start-horde"]

