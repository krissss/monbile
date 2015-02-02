/**
 * Created by kriss on 2015/2/2.
 */

$(document).ready(function () {

    /**
     * 字数控制
     * 使用charCount.js
     */
    //default usage
    //$("#video_message").charCount();

    //custom usage
    $("#video_message").charCount({
        allowed: 140,
        warning: 20,
        counterText: '剩余字数: '
    });


     /**
      *  表情
      *  使用jquery-sinaEmotion-2.1.0.js
      */
    //插入表情
    $('#add_face').bind({
        click: function (event) {
            if (!$('#sinaEmotion').is(':visible')) {
                $(this).sinaEmotion();
                event.stopPropagation();
            }
        }
    });
    //点击显示表情
    $('#show_face').bind({
        click: function () {
            var content = $(this).parents('form').find('#video_message').val();
            $('.has_face').html(content).parseEmotion();
        }
    });
    //网站加载完后加载表情,该页面没有has_face标签则不加载
    if($('.has_face').length>0){
        $('.has_face').parseEmotion();
    }


    /**
     * 标签云
     * 使用jquery.tagcanvas.js
     */
    if( ! $('#myCanvas').tagcanvas({
            outlineThickness : 2,
            maxSpeed : 0.08,
            depth : 0.8,
        })) {
        // TagCanvas failed to load
        $('#myCanvasContainer').hide();
    }

});
