FROM debian:latest

ENV SERV_DIR /etc/apache2
ENV SITE_CONF sites-available/000-default.conf

COPY ./ /var/www/html

RUN mv /var/www/html/.vimrc /root/.vimrc

RUN apt-get update && apt-get upgrade && apt-get install -y \
	sendmail-bin \
	php \
	php7.0-mysql \
	mysql-server \
	apache2 \
	vim \
	git

RUN echo "camagru.com" > /etc/hostname && sendmailconfig

RUN cp $SERV_DIR/$SITE_CONF $SERV_DIR/$SITE_CONF.bk
RUN cp $SERV_DIR/apache2.conf $SERV_DIR/apache2.conf.bk

RUN cat $SERV_DIR/sites-available/000-default.conf | \
		sed 's/DocumentRoot.*/DocumentRoot \/var\/www\/html\/public/g' > \
		$SERV_DIR/$SITE_CONF.tmp

RUN mv $SERV_DIR/$SITE_CONF.tmp $SERV_DIR/$SITE_CONF
RUN sed -i '/Directory \/var\/www\//!b;n;n;c\\tAllowOverride All' $SERV_DIR/apache2.conf

RUN service mysql start && \
		mysqladmin -u root password camagru && \
		mysqladmin create camagru && \
		mysql -u root -e "$(cat /var/www/html/init.sql)"

RUN a2enmod rewrite

RUN chown -R www-data:www-data /var/www/html/ && chmod -R g+rw /var/www/html

ENTRYPOINT service apache2 start && service mysql start && bash
