docker exec -it empty-project-php-container bash

#this should replace in docker/docker-compose.yaml file
#services:
#    empty-project-php-service:
#        volumes:
#            - ./../vendor:/var/www/empty-project/vendor
php -d memory_limit=-1 composer install --ignore-platform-reqs

php bin/console doctrine:database:create
