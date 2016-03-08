FROM debian:jessie

RUN apt-get update && apt-get install libapache2-mod-php5 php5 php5-cli php5-pgsql php5-mysql -y --force-yes

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
