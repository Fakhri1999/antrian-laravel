# Antrian Laravel

1. Run `composer install` first
2. Then run `npm install`
3. Run `npm run dev` to compile the required assets in folder `resources/assets`.
4. If error happen, run `npm install --global cross-env` then run `npm install --no-bin-links`. This will download files about 100MB++ to node_modules folder
5. Then run `npm run dev` again and the error will be gone. Run `npm run watch` and it will watch all relevant files for changes so you don't need to run dev everytime you change your assets file in resources folder.
6. Change the .env file
7. Type `php artisan serve` then the app will run on port 8000
