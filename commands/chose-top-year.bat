::每年一月一号一晚上1点执行，获取前一年的赞排名前50名的视频
@echo off
cd C:\soft\WWW\yii\monbile
yii time/chose-top-year >>C:\soft\WWW\yii\monbile\commands\log.txt