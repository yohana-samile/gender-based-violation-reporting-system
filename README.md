# Project Name Gender-Based Violations Reporting System

pull project from
https://github.com/yohana-samile/gender-based-violation-reporting-system

![Screenshot from 2025-06-26 17-40-07](https://github.com/user-attachments/assets/0021d4cf-d2fa-4cb1-8553-706083e344de)


## how to run this project
1. you need to have Xampp server or ngnix server based on your choice
2. extract the zipped file you downloaded in the link above
3. install composer in your pc https://getcomposer.org/doc/00-intro.md#installation-windows
4. open project config .env file use mysql database
5. run composer install in the root of your project
6. create database with this name gsb_violation_system
7. start server by php artisan serve then open a browser using displayed url which is 127.0.0.1/8000
8. run migration using command below

    ## Database migration
    ### command used
    
    php artisan migrate --path=database/migrations/version100
    
    php artisan migrate --path=database/migrations/version101
    
9. run migration using command below

php artisan db:seed


## login via 
username = samileking9@gmail.com using (admin)
password = 12345678
username = amina@gmail.com using (admin)
password = 12345678

php artisan storage:link
npm install
npm install -D autoprefixer postcss
php artisan optimize:clear
npm run build
npm run dev


php -m | findstr gd // verify gd if yes

composer install

### if you have question ask via 0620350083 or y.samile@nextbyte.co.tz




## key terms to understand 
An anonymous report is a process where someone can report information, such as unethical behavior or violations, without revealing their identity. This process is designed to protect the reporter and encourage individuals to come forward with information they might otherwise withhold due to fear of
