#### 1.登录注册修改密码（超管，管理员，学生）

对应的controller层和model里面封装好了

#### 2.邮箱验证

在.env里面配置 邮箱和对应的授权码即可（修改默认在config/mail.php)里面

#### 3.oss文件上传

 .在env里面设置 对应的参数，

#### 4.分片上传大文件到OSS

1.首先得导入Oss的laravel包

```
composer require aliyuncs/oss-sdk-php
```

2.在.env里面配置自己的参数

3.在services/OSS.php下更改自己的参数

#### 5.分片上传到框架

1.安装依赖包

```
composer require peinhu/aetherupload-laravel ~1.0
```

2.发布一些文件和目录

```
php artisan aetherupload:publish
```

3.在浏览器访问`http://域名/aetherupload`可到达示例页面

4.也可调用了本人的页面 可通过resource里面视图查看

#### 6.导Excel

1.导出excel

 在app/Exports/TestExport.php 设置导出的参数在

2.导入excel

在app/Imports/UsersImport.php里面配置导入参数



