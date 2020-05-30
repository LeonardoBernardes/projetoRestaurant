cd projetoRestaurant
composer install
Copiar arquivo .env.example e renomeie a copia para .env

Configurar o dados para acesso ao banco como o exemplo abaixo:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_restaurante
DB_USERNAME=root 
DB_PASSWORD=Password

OBS: o banco de dados deve estar criado no mysql

php artisan migrate
php artisan key:generate
php artisan config:clear

php artisan serv

Ao acessar o site no endereço 127.0.0.1:8000
Realizar o cadastro de um usuário e depois fazer login.
