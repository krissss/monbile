::每月1号晚上1点执行，获取前一月的赞排名前50名的视频
@echo off
cd C:\soft\WWW\yii\monbile
yii time/chose-top-month >>C:\soft\WWW\yii\monbile\commands\log.txt