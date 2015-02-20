::每周一晚上1点执行，获取前一周的赞排名前50名的视频
@echo off
cd C:\soft\WWW\yii\monbile
yii time/chose-top-week >>C:\soft\WWW\yii\monbile\commands\log.txt