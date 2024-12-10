###################
Aplikasi WEB Klinik
###################

Sistem informasi manajemen klinik

Username : admin 
Password : 1234

kode .htaccess di dalam folder aplication:
<IfModule authz_core_module>
    Require all denied
</IfModule>
<IfModule !authz_core_module>
    Deny from all
</IfModule>

kode .htaccess di root file/ diluar folder application:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?/$1 [L]
