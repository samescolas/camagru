FROM debian:latest

COPY ./ /var/www/html

RUN mv /var/www/html/.vimrc /root/.vimrc

RUN apt-get update && apt-get upgrade && apt-get install -y \
	sendmail \
	php \
	php7.0-mysql \
	mysql-server \
	apache2 \
	vim

RUN cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf.bk

RUN cat /etc/apache2/sites-available/000-default.conf | \
		sed 's/\/var\/www\/html/\/var\/www\/html\/public/g' > \
		/etc/apache2/sites-available/000-default.conf.tmp

RUN mv /etc/apache2/sites-available/000-default.conf.tmp /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

ENTRYPOINT service apache2 start && service mysql start && bash
