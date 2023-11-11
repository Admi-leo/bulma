-------------------
server: nginx
language: php | v7.4
Packs: fpm | v7.4
Database's driver: mysql

Additons:
Used composer_v2
Used components

Change files
Server options. type on terminal:
mv php.ini /etc/php/7.4/fpm/php.ini
-- it was set router

mv nginx.conf /etc/nginx/nginx.conf
-- it was set client_max_body_size 100M

dump database db.sql | database name - bulma
mysql -u [your user] -p bulma < db.sql
-------------------
