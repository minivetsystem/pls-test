FROM php:5.6-apache

RUN apt-get update && apt-get install php5-pgsql -y --force-yes