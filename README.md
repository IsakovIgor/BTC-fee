## PHP developer test case

### System requirements:

- Docker, docker-compose

### How to install:

- git pull https://github.com/IsakovIgor/BTC-fee.git
- cd ./BTC-fee
- cp .env.dist .env and change your params
- docker-compose up -d
- docker-compose exec btc_php sh -> composer install
- php ./vendor/bin/phpunit (optional)
- open your browser and got to http://127.0.0.1:{EXTERNAL_NGINX_PORT from .env}

App uses https://api.blockchair.com/
