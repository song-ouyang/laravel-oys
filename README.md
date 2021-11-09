#### 1.登录注册修改密码（超管，管理员，学生）

对应的controller层和model里面封装好了

#### 2.邮箱验证

在.env里面配置 邮箱和对应的授权码即可（修改默认在config/mail.php)里面

#### 3.oss文件上传

1.直接上传到我的oss， config/filesystems.php 里面

 2.在env里面设置 对应的参数，在config/filesystems.php里面设置 对应的路径