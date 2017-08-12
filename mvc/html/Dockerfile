FROM debian:latest

COPY ./ /var/www/

RUN mv /var/www/.vimrc /root/.vimrc

RUN apt-get update && apt-get upgrade && apt-get install -y \
	sendmail \
	php \
	apache2 \
	mysql-server \
	vim

RUN a2enmod rewrite

