<?php
/**
 * Created by PhpStorm.
 * User: kriss
 * Date: 2015/2/11
 * Time: 19:40
 */

namespace app\functions;


class Functions {

    /**
     * 格式化时间显示方式
     * @param $date
     * @return string
     */
    public static function formatTime($date) {
        $timer = strtotime($date);
        $diff = $_SERVER['REQUEST_TIME'] - $timer;
        $day = floor($diff / 86400);
        $free = $diff % 86400;
        if($day > 0) {
            if($day>7){
                return $date;
            }
            return $day."天前";
        }else{
            if($free>0){
                $hour = floor($free / 3600);
                $free = $free % 3600;
                if($hour>0){
                    return $hour."小时前";
                }else{
                    if($free>0){
                        $min = floor($free / 60);
                        $free = $free % 60;
                        if($min>0){
                            return $min."分钟前";
                        }else{
                            if($free>0){
                                return $free."秒前";
                            }else{
                                return '刚刚';
                            }
                        }
                    }else{
                        return '刚刚';
                    }
                }
            }else{
                return '刚刚';
            }
        }
    }

    public static function cutFrame($video_name='b',$startTime=1,$size='350*240'){
        $root = $_SERVER['DOCUMENT_ROOT'];
        $ffpmeg = $root.'\ffmpeg.exe';
        $video = $root.'\videos\\';
        $thumbnail = $root.'\thumbnail\\';
        exec('start '.$ffpmeg.' -i '.$video.$video_name.'.mp4 -y -f image2 -ss '.$startTime.' -t 0.001 -s '.$size.' '.$thumbnail.$video_name.'.jpg');
    }

}