# Affiliate

Merupakan Project internship Smooeth

## Settings

Buka file ```.env``` dan setting seperti berikut ini

```env
DB_CONNECTION=mysql
DB_HOST=192.168.0.191
DB_PORT=3306
DB_DATABASE=internship_affiliate
DB_USERNAME=internship
DB_PASSWORD='JEK]_5U4x`P3@=4f'
DB_TABLE_PREFIX=affiliate_
```

## Package
Untuk install package yang ada, gunakan perintah
```bash
composer install
```

## Migrate
Migrasi tabel
```bash
php artisan migrate
```

## Seeding
Untuk mengisi default data affliate, gunakan perintah
```bash
php artisan db:seed
```

## Login
Gunakan akun berikut untuk login
### Admin
```bash
Username : admin@affiliate.com
Password : admin1234
```