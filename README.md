# Key-Game
Real time Keyboard typing Game

First Install Laravel and dependencies using compose.
```
composer install
```

Then migrate tables and seed database
```
php artisan migrate
php artisan db:seed
```

Then run the Ratchet websocket server (by default it will run on 8008)
```
php artisan server:run
```
