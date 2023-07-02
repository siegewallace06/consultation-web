# Ex-teknom-konsulting-app
Project Teknom Konsulting
## DB Diagram
https://dbdiagram.io/d/636ca125c9abfc61117199a7
## Menjalankan Project
1. Install Composer `composer install` di dalam project
2. install NPM `npm install` & run NPM `npm run build`
3. link storage agar image bisa diakses `php artisan storage:link`
3. set `.env` sesuai dengan `.env.example`
4. lakukan migrate `php artisan migrate`
5. run `php artisan serve`

<br><i>revisi menjalankan sistem chat perlu menggunakan pusher (sudah ditambahkan ke `.env.example`)</i>

## Menjalankan Project di CodeSpaces
1. Install Composer `composer install` atau `composer update` di dalam project
2. install NPM `npm install` & run NPM `npm run build`
3. set `.env` sesuai dengan `.env.example`
4. install sail `composer require laravel/sail --dev` and `php artisan sail:install` pilih `mysql`
5. set agar sail terbaca `alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'`
6. lakukan migrate `sail artisan migrate`
7. link storage agar image bisa diakses `sail artisan storage:link`
8. jalankan server `sail up`

<img src="https://user-images.githubusercontent.com/57318667/212461066-4f5a82dd-b187-4f5d-94bd-18f83c75de0e.png" alt="Flow">
![Flow]
(https://user-images.githubusercontent.com/57318667/212461066-4f5a82dd-b187-4f5d-94bd-18f83c75de0e.png)
