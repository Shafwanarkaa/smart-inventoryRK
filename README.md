# 1. Clone
git clone https://github.com/Shafwanarkaa/smart-inventoryRK.git Remaja_Kuring
cd Remaja_Kuring

# 2. Install
composer install

# 3. Setup .env
copy .env.example .env
php artisan key:generate

# 4. Buat database "spk_remaja_kuring" di phpMyAdmin

# 5. Migrate & isi data
php artisan migrate:fresh --seed

# 6. Jalankan
php artisan serve
