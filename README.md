# pcr-calendar
超異域公主連結！ReDive Google活动日历（台服）

找遍了网络都找不到台服的活动日历，于是自己做了一个。

> 订阅地址: https://calendar.google.com/calendar?cid=ZGYzYXQzbmI5aGpqaGZndmplMjZhYTBmcmNAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ



也可以使用本程序来制作自己的日历，这个程序用来自动从蘭德索爾圖書館同步活动日历。

由于Google Calendar使用OAuth协议。所以没有办法做成全自动,需要每次手动更新的时候自行授权。

使用方法：
`https://developers.google.cn/calendar/quickstart/php`

先根据示例开启google calendar api，下载credentials.json，将credentials.json放入根目录

自行创建一个谷歌日历，用日历ID替换代码中的`$calendarId`
 
 ```bash
 cd $PATH
 php index.php
 ```
 根据提示获取验证码输入：
```bash
Open the following link in your browser:
https://accounts.google.com/o/oauth2/auth?response_type=code&access_type=offline&client_id=697486582975-odlk27skmi5n203s7122rv6sgv0ccncb.apps.googleusercontent.com&redirect_uri=urn%3Aietf%3Awg%3Aoauth%3A2.0%3Aoob&state&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fcalendar.events&prompt=select_account%20consent
Enter verification code: 4/vAHwKhzVnKkOY_3B_I0H8H-aLbk3b3HItYmB7B88rPB1-bRqI9Hum64
Update events:
2019 GAMESTAR 遊戲之星票選 (2019-12-10T14:00:00+08:00) (2020-01-10T14:00:00+08:00)
「探索」 2倍掉落 (2020-01-01T05:00:00+08:00) (2020-01-10T04:59:00+08:00)
劇情活動 碧/流夏 (2020-01-02T16:00:00+08:00) (2020-01-16T15:59:00+08:00)
★3必中白金轉蛋 (2020-01-02T16:00:00+08:00) (2020-01-10T15:59:00+08:00)
精選轉蛋 ★3碧(插班生) (2020-01-02T16:00:00+08:00) (2020-01-10T15:59:00+08:00)
「地下城」 2倍掉落(預測) (2020-01-10T05:00:00+08:00) (2020-01-20T04:59:00+08:00)
精選轉蛋 ★3克蘿依(預測) (2020-01-10T16:00:00+08:00) (2020-01-21T15:59:00+08:00)
「Normal」 2倍掉落(預測) (2020-01-13T05:00:00+08:00) (2020-01-26T04:59:00+08:00)
等級/裝備/地圖開放(預測) (2020-01-15T16:00:00+08:00) (2020-01-15T16:10:00+08:00)
第12波專武開放(預測) (2020-01-15T16:00:00+08:00) (2020-01-15T16:10:00+08:00)
復刻劇情活動(預測) (2020-01-16T16:00:00+08:00) (2020-01-24T15:59:00+08:00)
「露娜之塔」 登場(預測) (2020-01-17T16:00:00+08:00) (2020-01-23T15:59:00+08:00)
獎勵轉蛋 ★3吉塔/亞里沙(預測) (2020-01-21T16:00:00+08:00) (2020-01-24T15:59:00+08:00)
一月戰隊競賽(預測) (2020-01-24T05:00:00+08:00) (2020-01-31T23:59:00+08:00)
公主祭典 ★3似似花(預測) (2020-01-24T16:00:00+08:00) (2020-01-27T15:59:00+08:00)
精選轉蛋 ★3鏡華(萬聖節)(預測) (2020-01-27T16:00:00+08:00) (2020-02-03T15:59:00+08:00)
```

授权后程序会在根目录下生成token.json文件，在token过期前就不用再授权了




