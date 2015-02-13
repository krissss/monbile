/**
 * Created by kriss on 2015/2/2.
 */

$(document).ready(function () {
    /**
     * 标签云
     * 使用jquery.tagcanvas.js
     */
    if (!$('#myCanvas').tagcanvas({
            textFont: 'Impact,Arial Black,sans-serif',
            textColour: '#00f',
            textHeight: 16,
            shadow: '#ccf',
            shadowBlur: 3,
            outlineMethod: 'block',
            outlineColour: '#acf',
            outlineThickness: 2,
            initial: [0.1, 0.05],
            maxSpeed: 0.1,
            decel: 0.99,
            depth: 0.8,
            fadeIn: 1000
        })) {
        // TagCanvas failed to load
        $('.hot-tag').hide();
    }

    /**
     * 字数控制
     * 使用charCount.js
     */
        //default usage
        //$("#videosendform-video_title").charCount();

        //custom usage
    $("#videosendform-video_title").charCount({
        allowed: 100,
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
            var content = $(this).parents('form').find('#videosendform-video_title').val();
            $('.has_face').html(content).parseEmotion();
        }
    });
    //网站加载完后加载表情,该页面没有has_face标签则不加载
    if ($('.has_face').length > 0) {
        $('.has_face').parseEmotion();
    }

    /**
     * 添加标签
     */
    $('#add_tag').bind({
        click: function (event) {
            event.stopPropagation();

            if (!$("#tag_popover").is(':visible')) {
                //如果tags不存在  创建
                if ($("#tag_popover").length < 1) {
                    $('body').append('<div id="tag_popover" class="popover_div"><span id="tag_popover_close" class="glyphicon glyphicon-remove pull-right popover_close" aria-hidden="true"></span><div id="tag_popover_inner" class="popover_inner"></div><span id="tag_popover_ok" class="glyphicon glyphicon-ok pull-right popover_ok btn btn-primary" aria-hidden="true"></span></div>');

                    function tagAdded(data) {
                        var val = data.addedInput.text;
                        var input = data.context[0].id + ' input';
                    }

                    $('#tag_popover_inner').removeTag();

                    $('#tag_popover_inner').tagThis({
                        defaultText: '+标签',
                        maxChars: 10,
                        maxTags: 5,
                        width: '100%',
                        height: 'auto',
                        regex: /^(?!_)(?!.*?_$)[a-zA-Z0-9_\u4e00-\u9fa5]+$/,    //只允许数字 字母 汉字 下划线 且不以下划线开头和结尾
                        noDuplicates: true,
                        callbacks: {
                            afterAddTag: tagAdded
                        }
                    });

                    var content = $('#videosendform-video_title').val();
                    var tags = ["三杀", "四杀", "五杀", "还有谁"];
                    $.each(tags, function (key, val) {
                        if (content.indexOf(val) > -1) {
                            $('#tag_popover_inner').addTag(val);
                        }
                    });
                }
                //显示弹出框
                var offset = $(this).offset();
                $('#tag_popover').css({
                    top: offset.top + $(this).outerHeight() + 5,
                    left: offset.left
                }).show();

            } else {
                $("#tag_popover").hide();
            }
        }
    });

    /**
     * 选择分类
     */
    $("#change_classify_ul>li").bind({
        click: function () {
            $("#classify").attr("value", $(this).attr("data-gid"));
            $("#change_classify").html($(this).text() + " <span class=\"caret\"></span>").addClass('btn-primary');
        }
    });

    /**
     * 添加视频
     */
    $('#upload_file').parent().removeClass('col-xs-12').addClass('uploader white').end()
        .after('<input type="text" class="filename" readonly/><input type="button" name="file" class="uploader_button" value="选择视频"/>')
    $("input[type=file]").change(function () {
        $(this).parents(".uploader").find(".filename").val($(this).val());
        $(this).parents(".uploader").removeClass("white").addClass("blue").find(".uploader_button").val("已选择");
    }).each(function () {
        if ($(this).val() == "") {
            $(this).parents(".uploader").find(".filename").val("请选择文件...");
        }
    });

    //绑定动态事件
    $("body").on("click", function () {
        $("#tag_popover").hide();
    }).on("click", "#tag_popover", function (event) {
        event.stopPropagation();
    }).on("click", "#tag_popover_close", function () {
        $("#tag_popover").hide();
    }).on("click", "#tag_popover_ok", function () {
        var spans = $(".tag-this").children('span');
        var value = "";
        $.each(spans, function (key, val) {
            value += $(val).children('span').text() + '#';
        });
        $("#tags").attr("value", value);
        $("#tag_popover").hide();
        if ($("#tags").val()) {
            $('#add_tag').removeClass('btn-default').addClass('btn-primary');
        } else {
            $('#add_tag').removeClass('btn-primary').addClass('btn-default');
        }
    });

    /**
     * video_send表单提交出错
     */
    var value = "";
    $.each($('.error_hide'), function (key) {
        if ($(this).text()) {
            $('#send_video').addClass('in');
            value += $(this).text() + '<br/>';
        }
        if (key == $('.error_hide').length - 1 && value) {
            $('#error_message').removeClass('display_none').append(value);
        }
    });

    /**
     * 用户头像上传
     */
    if(!(typeof(swfobject) == "undefined")){
        swfobject.addDomLoadEvent(function () {
            var swf = new fullAvatarEditor("fullAvatarEditor.swf", "expressInstall.swf", "swfContainer",{
                    id: 'swf',
                    upload_url: 'upload.php?headcookie=2135',	//上传接口
                    method: 'post',	//传递到上传接口中的查询参数的提交方式。更改该值时，请注意更改上传接口中的查询参数的接收方式
                    //src_url: $("#oldHead").val(), //默认加载的原图片的url
                    src_upload: 0,		//是否上传原图片的选项，有以下值：0-不上传；1-上传；2-显示复选框由用户选择
                    tab_visible: false,  //是否显示选项卡
                    avatar_intro: '最终会使用以下尺寸的头像，请注意是否清晰',    //头像简介，默认：最终会生成以下尺寸的头像，请注意是否清晰
                    avatar_box_border_width: 0, //头像框的边框宽度
                    avatar_sizes: '150*150|80*80|35*35',  //表示一组或多组头像的尺寸。其间用"|"号分隔。
                    avatar_sizes_desc: '150*150像素|80*80像素|35*35像素'  //头像尺寸的提示文本。多个用"|"号分隔，与上一项对应。
                }, function (msg) {
                    switch (msg.code) {
                        case 1 :
                            //alert("页面成功加载了组件！");
                            break;
                        case 2 :
                            //alert("已成功加载图片到编辑面板。");
                            document.getElementById("upload").style.display = "inline";
                            break;
                        case 5 :
                            switch (msg.type) {
                                //表示图片上传成功。
                                case 0:
                                    //成功修改跳转到其他页面
                                    window.location.href="index.php?r=user/default/updatehead&head="+msg.content.avatarUrls.join(',');
                                    break;
                                case 1:
                                    alert('头像上传失败，原因：' + msg.content.msg);//will output:头像上传失败，原因：上传的原图文件大小超出限值了！
                                    break;
                                case 2:
                                    alert('头像上传失败，原因：指定的上传地址不存在或有问题！');
                                    break;
                                case 3:
                                    alert('头像上传失败，原因：发生了安全性错误！请联系站长添加crossdomain.xml到网站根目录。');
                                    break;
                            }
                    }
                }
            );
        });
    }

    /**
     * 弹出框
     */
    var success_message;
    var warning_message;
    var success_go_url;
    var warning_go_url;
    if(success_message = $('.success_message').val()) {
        swal({
            title: success_message,
            type: 'success'
        },function(){
            if(success_go_url = $('.success_go_url').val()){
                window.location.href = success_go_url;
            }
        });
    }
    if(warning_message = $('.warning_message').val()){
        swal({
            //获取到的字符串以‘#’分割，前半部为title，后面为text
            title:warning_message.split('#')[0],
            text:warning_message.split('#')[1],
            type: 'warning',
            showCancelButton: true
        },function(isConfirm){
            if(isConfirm){
                if(warning_go_url = $('.warning_go_url').val()){
                    window.location.href = warning_go_url;
                }
            }
        });
    }

    /**
     * 获取并设置comments
     * @param video_id
     */
    function getAndSetComments(video_id){
        $(".comment_content").val('');
        $.ajax({
            type: "post",
            url: "index.php?r=user/default/showcomments",
            data: {video_id:video_id},
            dataType: "json",
            success: function(data){
                var html = '';
                var count = data.length;
                $.each(data, function(index, content){
                    /*comments原型
                     <div class="comments_item">
                     <div class="media">
                     <div class="media-left">
                     <a href="#">
                     <img class="media-object img-circle img-responsiv img_height_35" src="heads/head (1).jpg" alt="飒沓" title="飒沓">
                     </a>
                     </div>
                     <div class="media-body">
                     <p><span class="text-danger">飒沓</span> : 哈哈哈</p>
                     <h5><small>2015-12-12 10:10:20</small></h5>
                     </div>
                     </div>
                     </div>
                     */
                    html += '<div class="comments_item"><div class="media"><div class="media-left">' +
                    '<a href="index.php?r=user/default/index&id='+content.uid+'">' +
                    '<img class="media-object img-circle img-responsiv img_height_35" src="heads/'+content.head+'" alt="'+content.nickname+'" title="'+content.nickname+'">' +
                    '</a> </div> <div class="media-body">' +
                    '<p><span class="text-danger">'+content.nickname+'</span> :'+content.comment_content+'</p> <h5><small>'+content.comment_date+'</small></h5></div></div></div>';
                });
                if(!html){
                    html = '<div class="comments_item"><p>暂无评论</p></div>';
                }
                $('.comment_count_'+video_id).text(count);
                $('.comments_list').empty().html(html);
            },
            complete : function(XMLHttpRequest,status){
                if(status != 'success'){
                    swal({
                        title:'出现问题，请稍后再试',
                        type:'error'
                    });
                }
            }
        });
    }

    /**
     * ajax获取评论
     */
    $('.show_comments').click(function(){
        var obj =  $('.comment_video_id');
        obj .val($(this).parent().attr('data-video-id'));
        var video_id = obj.val();
        var html = '<div class="load"><div class="loader">Loading...</div></div>';
        $('.comments_list').empty().html(html);
        getAndSetComments(video_id);
    });

    /**
     * ajax提交评论
     */
    $('.comment_send').click(function() {
        var comment_content = $(".comment_content").val();
        var comment_video_id = $(".comment_video_id").val();
        if (!comment_content || !comment_video_id) {
            swal('评论内容未填写');
        } else {
            var html = '<div class="load"><div class="loader">Loading...</div></div>';
            $('.comments_list').empty().html(html);
            $.ajax({
                type: "post",
                url: "index.php?r=user/default/sendcomment",
                data: {comment_content: comment_content, video_id: comment_video_id},
                dataType: "text",
                success: function ($date) {
                    if($date == 'error'){
                        alert('字数超出范围');
                    }
                    var video_id = $('.comment_video_id').val();
                    getAndSetComments(video_id);
                },
                complete : function(XMLHttpRequest,status){
                    if(status != 'success'){
                        swal({
                            title:'出现问题，请稍后再试',
                            type:'error'
                        });
                    }
                }
            });
        }
    });


    /**
     * ajax评论刷新
     */
    $('.comments_refresh').click(function(){
        var video_id = $('.comment_video_id').val();
        var html = '<div class="load"><div class="loader">Loading...</div></div>';
        $('.comments_list').empty().html(html);
        getAndSetComments(video_id);
    });

    /**
     * ajax赞
     */
    $('.give_praise').click(function() {
        var video_id = $(this).parent().attr('data-video-id');
        if (video_id) {
            swal({
                title: '<div class="load"><div class="loader">Loading...</div></div>',
                html: true
            });
            var praise_count = $(this).find('.praise_count');
            $.ajax({
                type: "post",
                url: "index.php?r=user/default/praise",
                data: {video_id: video_id},
                dataType: "text",
                success: function ($date) {
                    if($date == 'ok'){
                        praise_count.text(Number(praise_count.text())+1);
                        swal({
                            title:'谢谢您的赞',
                            type:'success'
                        });
                    }else{
                        swal({
                            title:$date,
                            type:'error'
                        });
                    }
                },
                complete : function(XMLHttpRequest,status){
                    if(status != 'success'){
                        swal({
                            title:'出现问题，请稍后再试',
                            type:'error'
                        });
                    }
                }
            });
        }
    });

    /**
     * ajax收藏
     */
    $('.add_collection').click(function() {
        var video_id = $(this).parent().attr('data-video-id');
        if (video_id) {
            swal({
                title: '<div class="load"><div class="loader">Loading...</div></div>',
                html: true
            });
            var collect_html = '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>收藏';
            var collected_html = '<span class="glyphicon glyphicon-star glyphicon-inverse" aria-hidden="true"></span>已收藏';
            var collect_success = $(this);
            $.ajax({
                type: "post",
                url: "index.php?r=user/default/collect",
                data: {video_id: video_id},
                dataType: "text",
                success: function ($date) {
                    if($date == 'ok'){
                        collect_success.html(collected_html);
                        swal({
                            title:'收藏成功',
                            type:'success'
                        });
                    }else if($date == 'ok_delete'){
                        collect_success.html(collect_html);
                        swal({
                            title:'取消收藏成功',
                            type:'success'
                        });
                    }else{
                        swal({
                            title:$date,
                            type:'error'
                        });
                    }
                },
                complete : function(XMLHttpRequest,status){
                    if(status != 'success'){
                        swal({
                            title:'出现问题，请稍后再试',
                            type:'error'
                        });
                    }
                }
            });
        }
    });

    /**
     * ajax删除视频
     */
    $('.delete_video').click(function(){
        var $this = $(this);
        var video_id = $this.attr('data-video-id');
        if (video_id) {
            swal({
                title: "确定删除此条视频吗？",
                text: "删除后将无法恢复此视频",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                cancelButtonText: "取消",
                confirmButtonText: "确定删除",
                closeOnConfirm: false
            }, function(){
                swal({
                    title: '<div class="load"><div class="loader">Loading...</div></div>',
                    html: true
                });
                $.ajax({
                    type: "post",
                    url: "index.php?r=user/default/delete-video",
                    data: {video_id: video_id},
                    dataType: "text",
                    success: function ($date) {
                        if($date == 'ok'){
                            swal({
                                title:'删除成功',
                                type:'success'
                            });
                            $this.closest('.panel').fadeOut("slow", function (){
                                $(this).remove();
                            });
                        }else{
                            swal({
                                title:$date,
                                type:'error'
                            });
                        }
                    },
                    complete : function(XMLHttpRequest,status){
                        if(status != 'success'){
                            swal({
                                title:'出现问题，请稍后再试',
                                type:'error'
                            });
                        }
                    }
                });
            });
        }
    });
});
