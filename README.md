# Aplikasi Pendataan Kendaran dengan REST API

## Kebutuhan Sistem
1. PHP 8, saya menggunakan 8.1.9
2. MongoDB 4.2
3. Laravel 8
4. PHP MongoDB Extension bisa di download <a href="https://pecl.php.net/package/mongodb">disini</a>, silahkan download berdasarkan operating systemnya
5. Postman, untuk testing endpoint


## Instalasi
### Jika tidak memiliki Exension MongoDB di phpnya silahkan diinstall dahulu, caranya :

1. Download extension <a href="https://pecl.php.net/package/mongodb">disini</a> pilih sesuai OS, lalu versinya 1.13.0 karena kompatibel dengan mongodb 4.2
2. Setelah di download masukkan ke dalam folder instalasi PHP /ext, yang di paste php_mongodb.dll dan php_mongodb.pdb
3. Masuk ke php.ini pada direktori php nya, lalu pastekan kode berikut `extension=php_mongodb.dll` pada baris extension
4. Selanjutnya cek di phpinfo nya, pastikan ada tulisan mongodbnya, jika ada sudah terinstall di php teman-teman


### Jika sudah clone repository ini ke dalam server atau local komputernya dan lakukan langkah-langkah berikut

1. Duplikat file `.env-example` pada root directory dan beri nama `.env`
2. ketikkan `composer install` untuk menginstall package laravel dan library lainnya
3. ketikan `php artisan key:generate` pada terminal generate key app laravel
4. ketikkan `php artisan jwt:secret` pada terimal untuk mengenerate secret key JsonWebToken
5. Ubah sebagian kredential pada file `.env` berikut:
```
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=inventory
DB_USERNAME=
DB_PASSWORD= 

JWT_SHOW_BLACKLIST_EXCEPTION=true
JWT_ALGO=HS256
```

5. Selanjutnya buatlah nama database di mongodb shell atau di mongocompass sesuai pada file `.env`
6. Jalankan file migration

``` 
php artisan migrate
```
7. Jalankan seeder, untuk generate data awal

``` 
php artisan db:seed
```

8. Jalankan server

```
php artisan serve
```


Untuk contoh endpointnya silahkan kunjungi link <a href="https://www.postman.com/supply-pilot-63670956/workspace/inosoft">berikut</a>

## Menjalankan Endpoint
Agar dapat mengakses endpoint pastikan sudah menambahkan header sebagai berikut
```
Accept: application/json
Content-Type: application/json
```

Selain endpoint `api/auth/*` sudah terproteksi dengan middleware jwt yang mengharuskan mengirimkan token melalui header yang telah di didapatkan setelah login di endpoint `api/auth/login` dengan ketentuan header sebagai berikut

```
Authorization: Bearer {{token string}}
```

## Unit Test
agar lebih mudah jika menggunakan vscode menggunakan ekstensi PHPUnit