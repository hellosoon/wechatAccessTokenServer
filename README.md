# wechatAccessTokenServer

微信获取accesstoken的中控服务器代码

请在config文件中填写AppId，AppSecret和Token保存路径

一定记得不要放在外网可以访问的目录中，单独设置目录并只允许本地或者局域网特定IP段访问

比如放在192.168.1.111虚拟站点的wechatAccessTokenServer文件夹

获取accesstoken：
192.168.1.111/wechatAccessTokenServer/?type=get

刷新accesstoken：
192.168.1.111/wechatAccessTokenServer/?type=refresh

获取web授权需要的accesstoken：
192.168.1.111/wechatAccessTokenServer/web.php?code=