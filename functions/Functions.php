<?php
/**
 * Created by PhpStorm.
 * User: kriss
 * Date: 2015/2/11
 * Time: 19:40
 */

namespace app\functions;


use app\models\Hero;

class Functions {
    /**
     * 创建随机名字
     */
    public static function createRandName(){
        return md5(uniqid(rand()));
    }

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

    /**
     * 截取视频第一帧
     * @param string $video_name
     * @param int $startTime
     * @param string $size
     */
    public static function cutFrame($video_name='b',$startTime=1,$size='350*240'){
        $root = $_SERVER['DOCUMENT_ROOT'];
        $ffpmeg = $root.'\ffmpeg.exe';
        $video = $root.'\videos\\';
        $thumbnail = $root.'\thumbnail\\';
        exec('start '.$ffpmeg.' -i '.$video.$video_name.'.mp4 -y -f image2 -ss '.$startTime.' -t 0.001 -s '.$size.' '.$thumbnail.$video_name.'.jpg');
    }

    /**
     * 合成英雄形象到一张背景图,并把一份对应的坐标文件复制过去
     * @param $heroId ::英雄id
     * @param $thumbnailName    ::生成的缩略图名称,不需要后缀
     */
    public static function createHeroToBackground($heroId,$thumbnailName){
        $dst_im = imagecreatefrompng('./imgs/bg/bg_'.rand(1,10).'.png');
        imagesavealpha($dst_im, true);
        $hero_name_py = Hero::findOne($heroId)->hero_name_py;
        $src_im = imagecreatefrompng('./imgs/hero/hero_'.$hero_name_py.'.png');
        imagesavealpha($src_im, true);
        if(imagecopy($dst_im,$src_im,250,150,0,0,imagesx($src_im),imagesy($src_im))){
            imagepng($dst_im,'./imgs/thumbnail/'.$thumbnailName.'.png');
        }
        imagedestroy($dst_im);
        copy('./imgs/xy','./imgs/thumbnail/'.$thumbnailName);
    }

    public static function createNicknameImage($nickname,$user_id){
        $im = imagecreatefrompng('./imgs/nickname_bg.png');
        imagesavealpha($im, true);
        $color = imagecolorallocate($im, 114, 21, 32);
        $font = 'msyhl.ttc';
        $srcw=imagesx($im);
        $srch=imagesy($im);
        $fontSize = 20;
        $fontWidth = imagefontwidth ($fontSize);
        $fontHeight = imagefontheight ($fontSize);
        $textWidth = $fontWidth * mb_strlen ($nickname);
        $x = ceil (($srcw - $textWidth) / 2);//计算文字的水平位置
        $textHeight = $fontHeight;
        $y = ceil(($srch - $textHeight) / 2)+$textHeight;//计算文字的垂直位置
        imagettftext($im, $fontSize, 0, $x, $y, $color, $font, $nickname);
        if(!file_exists('./imgs/seal/'.$user_id)){
            mkdir('./imgs/seal/'.$user_id);
        }
        imagepng($im,'./imgs/seal/'.$user_id.'/nickname.png');
        imagedestroy($im);
    }

    /**
     * 根据用户的nicknam和id生成印章
     * @param $nickname
     * @param $user_id
     */
    public static function createSealWithNickName($nickname,$user_id){
        for($i=1; $i<5; $i++){
            $dst_im = imagecreatefrompng('./imgs/seal/seal_'.$i.'.png');
            imagesavealpha($dst_im, true);
            if(!file_exists('./imgs/seal/'.$user_id.'/nickname.png')){
                self::createNicknameImage($nickname,$user_id);
            }
            $src_im = imagecreatefrompng('./imgs/seal/'.$user_id.'/nickname.png');
            if(imagecopy($dst_im,$src_im,00,175,0,0,242,35)){
                imagepng($dst_im,'./imgs/seal/'.$user_id.'/seal_'.$i.'.png');
            }
            imagedestroy($dst_im);
        }
    }

    /**
     * 盖章，给图片盖章
     * @param $seal
     * @param $background
     * @param $generateImgName
     */
    public static function signToImage($user_id,$seal,$seal_size,$thumbnailName,$x,$y){
        $dst_im = imagecreatefrompng('./imgs/thumbnail/'.$thumbnailName.'.png');
        imagesavealpha($dst_im, true);
        $tempImg='./imgs/temp/'.$thumbnailName.'.png';
        self::resizeImage('./imgs/seal/'.$user_id.'/'.$seal.'.png',$seal_size,$tempImg);
        $src_im = imagecreatefrompng($tempImg);
        imagesavealpha($src_im, true);
        $src_w = imagesx($src_im);
        $src_h = imagesy($src_im);
        if(imagecopy($dst_im,$src_im,$x,$y,0,0,$src_w,$src_h)){
            imagepng($dst_im,'./imgs/thumbnail/'.$thumbnailName.'.png');
        }
        imagedestroy($dst_im);
        unlink($tempImg);
    }

    /**
     * 等比例缩放图片
     * @param $image
     * @param $max
     * @param $imageName
     */
    public static function resizeImage($seal,$max,$tempImg){
        $im=imagecreatefrompng($seal);
        imagesavealpha($im, true);
        $size_src=getimagesize($seal);
        $w=$size_src['0'];
        $h=$size_src['1'];
        if($w > $h){
            $w=$max;
            $h=$h*($max/$size_src['0']);
        }else{
            $h=$max;
            $w=$w*($max/$size_src['1']);
        }
        //生成透明背景
        $image=imagecreatetruecolor($w, $h);
        imagealphablending($image, true);
        imagesavealpha($image, true);
        $trans_colour = imagecolorallocatealpha($image, 0, 0, 0, 127);
        imagefill($image, 0, 0, $trans_colour);
        //将图片复制到透明背景上
        imagecopyresampled($image, $im, 0, 0, 0, 0, $w, $h, $size_src['0'], $size_src['1']);
        imagepng($image,$tempImg);
        imagedestroy($image);
    }

    /**
     * 随机获取一个坐标
     * @param $thumbnailName ::缩略图名
     * @return null/String  ::返回坐标【格式：x,y】或者null
     */
    public static function getXY($thumbnailName){
        if(!file_exists('./imgs/thumbnail/'.$thumbnailName)){
            return null;
        }
        $content = file_get_contents('./imgs/thumbnail/'.$thumbnailName);
        $array = explode(';',$content);
        $length = count($array);
        if($length==2){
            $i=0;
        }else{
            $i=rand(0,$length-2);
        }
        $str="";
        for($j=0;$j<$length;$j++){
            if($j == $i){
                continue;
            }elseif($j==$length-1){
                $str .= $array[$j];
            }else{
                $str .= $array[$j].";";
            }
        }
        if($str == ""){
            unlink('./imgs/thumbnail/'.$thumbnailName);
        }
        file_put_contents('./imgs/thumbnail/'.$thumbnailName,$str);
        return $array[$i];
    }

}