
## Project Setup:

Setup timezone from config/App.php as 'Asia/Dhaka'

### 1. Clone the repo to htdocs or www folder

git clone gslgit@192.168.10.63:/home/gslgit/socialHub-v2.0.git

### 2. go to the directory 

cd socialHub-v2.0

### 3. Install Composer

composer install

### 4. Create .env File

copy .env.example .env

### 5. Generate Key

php artisan key:generate

### 6. Enable Permission (for Linux User)

sudo chmod -R 777 storage

### 7. All seeder

php artisan db:seed --class=AllSeeder

## 8. From Browser

http://localhost/socialHub-v2.0/public

body: 
    username: root
    password: welcome2244

