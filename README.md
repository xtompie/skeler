# Skeler

## Setup

Each command below is for WSL

### Envoriment

#### 1. Windows 10

#### 2. WSL - Windows Subsystem for Linux (v1)

#### 3. Ubuntu 18.04 LTS, on WSL, from Microsoft Store, up to date 
- `sudo apt update && sudo apt upgrade -y`
- `printf "[automount]\noptions = \"metadata\"\n" | sudo tee -a /etc/wsl.conf`
- Register useful aliases for WSL, read attentively what does it do:
    - `echo "alias code=\"/mnt/c/Program\ Files/Microsoft\ VS\ Code/Code.exe\"" >> ~/.bash_aliases && exec $SHELL`
    - `echo "alias cmd=\"/mnt/c/Windows/System32/cmd.exe\"" >> ~/.bash_aliases && exec $SHELL`
    - `echo "alias cdp=\"cd /mnt/c/Users/tomek/projects\"" >> ~/.bash_aliases && exec $SHELL`
- Rebot host system (Windows)

#### 4. unzip
`sudo apt install -y unzip`

#### 5. php7.3
- `sudo apt install -y software-properties-common && sudo add-apt-repository -y ppa:ondrej/php && sudo apt install -y php7.3 && php -v`

#### 6. php7.3 extensions
`sudo apt install -y php7.3-zip php7.3-mysql php7.3-xml php7.3-curl php7.3-mbstring php7.3-bz2`

#### 6. nginx 
`sudo apt install -y nginx && sudo service nginx start`

#### 7. php7.3-fpm
`sudo apt install php7.3-fpm && sudo service php7.3-fpm start`

#### 8. mariadb (mysql)
- `sudo apt install -y mariadb-server && sudo service mysql start`
- `sudo mysql -e "CREATE USER 'user'@'localhost' IDENTIFIED BY 'pass';GRANT ALL PRIVILEGES ON *.* TO 'user'@'localhost';FLUSH PRIVILEGES;" && sudo service mysql restart`

#### 9. composer
- https://getcomposer.org linux instalation, globally,
- tl;dr
    - https://getcomposer.org/doc/faqs/how-to-install-composer-programmatically.md -> find `wget https...` -> run it
    - `sudo mv composer.phar /usr/local/bin/composer`

#### 10. node.js v14
`curl -sL https://deb.nodesource.com/setup_14.x | sudo bash - && sudo apt -y install nodejs && node  -v`

#### 11. phpmyadmin OPTIOANL
If u develop only frontend u dont need this
`cdp && mkdir phpmyadmin && cd phpmyadmin && composer create-project phpmyadmin/phpmyadmin .`
`sudo nano /etc/nginx/sites-enabled/phpmyadmin`
paste and adjust:
```
server {
    listen 80;
    server_name phpmyadmin.localhost;
    root /mnt/c/Users/tomek/projects/phpmyadmin;

    error_log /var/log/nginx/phpmyadmin.access_log;
    access_log /var/log/nginx/phpmyadmin.error_log;

    index index.php;

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    location ~* ^.+.(jpg|jpeg|gif|css|png|js|ico|xml)$ {
        access_log        off;
        expires           360d;
    }

    location ~ /\.ht {
        deny  all;
    }

    location ~ /(libraries|setup/frames|setup/libs) {
        deny all;
        return 404;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### Project

#### 1. Configure nginx vhost
- `sudo rm /etc/nginx/sites-enabled/default`
- `sudo nano /etc/nginx/sites-enabled/skeler`
paste, adjust and save:
```
server {
    listen 80;
    server_name skeler.localhost;
    root /mnt/c/Users/tomek/projects/skeler/public;

    error_log /var/log/nginx/skeler.access_log;
    access_log /var/log/nginx/skeler.error_log;

    charset utf-8;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```
- `sudo service nginx restart`

#### 2. Create database 
`mysql -u root -p -e "CREATE DATABASE skeler;"`

#### 3. Configure .env 
`cp .env.example .env && php artisan key:generate` (in project direcotry)

#### 4. Install composer packages
`composer install` (in project direcotry)

#### 5. Install node packages
`npm i` (in project direcotry)

#### 6. Database migration
`php artisan migrate`

#### 7. Database seed
`php artisan db:seed`

### 8. 
`php artisan storage:link`

### 9. 
`npm i`

## Daily usage

#### 1. Check status
`sudo service --status-all`

#### 2. Start what u need 
`sudo service cron start && sudo service mysql start && sudo service nginx start && sudo service php7.3-fpm start`

Feel free to create an alias for that:
`echo "alias startall=\"sudo service cron start && sudo service mysql start && sudo service nginx start && sudo service php7.3-fpm start\"" >> ~/.bash_aliases && exec $SHELL`
