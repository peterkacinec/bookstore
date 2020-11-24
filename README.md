## Postup spustenia aplikacie

- `composer update`
- `npm install && npm run dev`
- vytvorenie .env suboru ako kopiu .env.sample a nastavenie DB connection
- vygenerovanie kluca: `php artisan key:generate`
- vytvorenie tabuliek v DB: `php artisan migrate`
- vytvorenie usera: `php artisan user:create`. spusti sa wizard
- pravdepodobne bude nevyhnutne spustit aj prikazy `chmod -R 777 storage` a `chmod -R 777 bootstrap/cache` na nastavenie prav ku priecinkom
