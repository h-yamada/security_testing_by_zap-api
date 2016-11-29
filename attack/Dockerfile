FROM php:7.0.13-cli

RUN apt-get update
RUN apt-get install -y zip unzip curl git
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

RUN useradd -m attacker
USER attacker
WORKDIR /home/attacker/
COPY ./ /home/attacker/
RUN ./composer.phar install
RUN mkdir ./report
