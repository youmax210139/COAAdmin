# 農業產品產銷履歷區塊鏈資訊網

## 環境要求

-   PHP >= 7.1.3
-   Mbstring PHP Extension
-   XML PHP Extension
-   Composer
-   PHP PostgreSQL driver

## 部署

```shell
composer install --no-dev # --no-dev 僅正式境境需加入參數
sudo chgrp -R www-data storage bootstrap/cache # 修改storage權限
sudo chmod -R ug+rwx storage bootstrap/cache  # 修改storage權限
cp .env.example .env     # 修改.env設定
php artisan key:generate # 產生key
```

## Apache2 設定

在/etc/apache2/sites-available 目錄下新增 conf

conf 範例如下:

```shell
<VirtualHost *:80>
	DocumentRoot /var/www/taft/public # your project public folder path
	<Directory /var/www/taft>    # your project path
		AllowOverride All
	</Directory>
	ErrorLog ${APACHE_LOG_DIR}/error_taft.log   # custom error log path
	CustomLog ${APACHE_LOG_DIR}/access_taft.log combined # custom access log path
</VirtualHost>
```

執行 apache 指令

```shell
sudo a2ensite your.conf
sudo a2enmod rewrite
sudo service apache2 restart
```

## .ENV 設定

```shell
VALID_API_URL = 127.0.0.1 # 驗証作物調用的API地址
```
