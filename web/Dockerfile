FROM nginx:1.22.1-perl AS app

#RUN #mkdir -p /var/www/html/magento

COPY ./default.conf /etc/nginx/conf.d/default.conf
COPY ./magento_es_auth.conf /etc/nginx/conf.d/magento_es_auth.conf