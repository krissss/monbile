/**
 * Created by kriss on 2015/2/2.
 */

//videojs.options.flash.swf = "video-js.swf";

$(document).ready(function () {
    var body = $("body");
    /**
     * 打开赞的popover
     */
    $('.praise').popover({
        html: true,
        content: $("#popoverContent").html(),
        container: 'body',
        placement: 'top',
        trigger: 'click'
    }).click(function(){
        $(".popover-content").attr("data-video",$(this).data('video'));
    });

    /**
     * 英雄选择的单选按钮样式
     */
    $('.dowebok :input').labelauty();

    /**
     * 选择英雄后把英雄名字放到button上，把value传给hero input
     */
    $("input[name='hero_radio']").click(function(){
        var heroName = $(this).parent('li').find('span.labelauty-unchecked').text();
        var heroId = $(this).val();
        $('.heroChose').html(heroName).removeClass('btn-default').addClass('btn-primary');
        $('#videosendform-hero_id').val(heroId);
    });

    /**
     * 返回顶部
     */
    $(window).scroll(function() {
        if($(window).scrollTop() >= 100){
            $('.actGoTop').fadeIn(300);
        }else{
            $('.actGoTop').fadeOut(300);
        }
    });
    $('.actGoTop').click(function(){
        $('html,body').animate({scrollTop: '0px'}, 800);
    });

    /**
     * 视频播放按钮的位置定位
     */
    function playButtonPosition(){
        var video_thumbnail_bg = $(".video_thumbnail_bg");
        var video_play_button = $(".video_play_button");
        var bg_width = video_thumbnail_bg.width();
        var bg_height  = video_thumbnail_bg.height();
        var btn_width  = video_play_button.width();
        var btn_height  = video_play_button.height();
        video_play_button.css({"margin-top":bg_height/2-btn_height/2,"margin-left":bg_width/2-btn_width/2});
    }
    $(window).load(function(){
        playButtonPosition();
    }).resize(function(){
        playButtonPosition();
    });
    $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
        playButtonPosition();
    });

    /**
     * 视频播放按钮的hover样子改变
     */
    $(".video_play_button").hover(function(){
        $(this).attr('src','./imgs/play_hover.png');
    },function(){
        $(this).attr('src','./imgs/play.png');
    });

    /**
     * 标签云
     * 使用jquery.tagcanvas.js
     */
    if (!$('#myCanvas').tagcanvas({
            freezeActive: true,
            textFont: 'Impact,Arial Black,sans-serif',
            textColour: '#00f',
            textHeight: 16,
            shadow: '#ccf',
            shadowBlur: 3,
            outlineMethod: 'block',
            outlineColour: '#acf',
            outlineThickness: 2,
            initial: [0.1, 0.05],
            maxSpeed: 0.05,
            decel: 0.9999,
            depth: 0.9,
            fadeIn: 1000
        })) {
        // TagCanvas failed to load
        $('.hot-tag').hide();
    }

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
                                    window.location.href="index.php?r=user/default/update-head&head="+msg.content.avatarUrls.join(',');
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
    var wrong_message;
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
    if(wrong_message = $('.wrong_message').val()){
        swal({
            title: wrong_message,
            type: 'error'
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
            url: "index.php?r=user/default/show-comments",
            data: {video_id:video_id},
            dataType: "json",
            success: function(data){
                var html = '';
                var count = data.length;
                $.each(data, function(index, content){
                    if(content.parent_id!=0){
                        return true;
                    }
                    html += '<div class="comments_item"><div class="media"><div class="media-left">' +
                    '<a href="index.php?r=user/default/index&id='+content.uid+'">' +
                    '<img class="media-object img-circle img-responsiv img_height_35" src="heads/'+content.head+'" alt="'+content.nickname+'" title="'+content.nickname+'">' +
                    '</a> </div> <div class="media-body">' +
                    '<p><span class="text-danger">'+content.nickname+'</span> :'+content.comment_content+'</p>' +
                    '<h5><small>'+content.comment_date+'<a class="pull-right" data-toggle="collapse" href="#collapseExample_'+content.cid+'">回复</a>' +
                    '<a class="pull-right margin_right_20" href="index.php?r=site/video&id='+ video_id +'" target="_blank">查看回复</a></small></h5>';

                    html+='<div class="collapse" id="collapseExample_'+content.cid+'"> <form class="form form-group">' +
                    ' <div class="input-group"> <span class="input-group-addon" id="basic-addon1">@'+content.nickname+'</span>' +
                    ' <input type="text" class="form-control comment_content" placeholder="30字以内" maxlength="30" ' +
                    'data-comment-video-id="'+video_id+'" data-comment-to-user-id="'+content.uid+'" data-comment-parent-id="'+content.cid+'"> ' +
                    '<span class="input-group-btn"> <button class="btn btn-primary comment_send" type="button">回复</button> </span> </div> </form> </div>';

                    html+='</div></div>';
                    html+='</div>';
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
     * 将所有有关于video_info的操作绑定到document上，并且可以动态绑定操作
     */
    $(document)
    /**
     * ajax获取评论
     */
        .on('click','.show_comments',function(){
            $('.comment_content').attr({'data-comment-video-id':$(this).parent().attr('data-video-id'),'data-comment-to-user-id':$(this).parent().attr('data-video-user-id')});
            var html = '<div class="load"><div class="loader">Loading...</div></div>';
            $('.comments_list').empty().html(html);
            getAndSetComments($(this).parent().attr('data-video-id'));
        })
    /**
     * ajax提交评论
     */
        .on('click','.comment_send',function() {
            var comment_content_obj = $(this).parent('.input-group-btn').prev(".comment_content");
            var comment_content = comment_content_obj.val();
            var comment_video_id = comment_content_obj.attr('data-comment-video-id');
            var to_user_id = comment_content_obj.attr('data-comment-to-user-id');
            var parent_id = comment_content_obj.attr('data-comment-parent-id');
            if (!comment_content || !comment_video_id || !to_user_id || !parent_id) {
                swal('评论内容未填写');
            } else {
                var html = '<div class="load"><div class="loader">Loading...</div></div>';
                $('.comments_list').empty().html(html);
                $.ajax({
                    type: "post",
                    url: "index.php?r=user/default/send-comment",
                    data: {comment_content: comment_content, video_id: comment_video_id, to_user_id: to_user_id, parent_id: parent_id},
                    dataType: "text",
                    success: function ($date) {
                        if($date == 'error'){
                            alert('字数超出范围');
                        }
                        getAndSetComments(comment_video_id);
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
        })
    /**
     * ajax评论刷新
     */
        .on('click','.comments_refresh',function(){
            var video_id = $('.comment_content').attr('data-comment-video-id');
            var html = '<div class="load"><div class="loader">Loading...</div></div>';
            $('.comments_list').empty().html(html);
            getAndSetComments(video_id);
        })
    /**
     * ajax盖章,点赞
     */
        .on("click", ".seal_button", function () {
            var $this = $(this);
            var seal = $this.data("seal");
            if(seal){
                var video_id = $this.parent('.row').parent('.popover-content').data('video');
                var praise_count = $(".praise_count_"+video_id);
                var video_bg = $(".video_"+video_id);
                swal({
                    title: '<div class="load"><div class="loader">Loading...</div></div>',
                    html: true
                });
                $.ajax({
                    type: "post",
                    url: "?r=user/ajax/sign-seal",
                    data: { seal: seal, video_id: video_id},
                    dataType: "text",
                    success: function ($data) {
                        if($data == 'ok'){
                            swal({title:'点赞成功,因为您不是前20点赞，所以不能给您盖上章，下次加油！',type:'success'});
                            praise_count.text(Number(praise_count.text())+1);
                        }else if($data == ('ok_sign')){
                            swal({title:'点赞成功，因为您是前20点赞，所以特此为您盖上章，谢谢您的支持！',type:'success'});
                            video_bg = video_bg.attr("src",function(){return this.src+"?"});
                            praise_count.text(Number(praise_count.text())+1);
                        }else{
                            swal({title:$data,type:'warning'});
                        }
                        $('[data-toggle="popover"]').popover('hide');
                    },
                    complete : function(XMLHttpRequest,status){
                        if(status != 'success'){
                            swal({
                                title:'网络出现问题，请稍后再试',
                                type:'error'
                            });
                        }
                    }
                });
            }else{
                swal({
                    title: "您还没有登录",
                    text: "登录后才能进行相应操作，需要现在登录吗？",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    cancelButtonText: "取消",
                    confirmButtonText: "去登录",
                    closeOnConfirm: false
                }, function(){
                    window.location.href='index.php?r=site/login';
                });
            }
        })
    /**
     * ajax收藏
     */
        .on('click','.add_collection',function() {
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
                        }else if($date == 'no_login'){
                            swal({
                                title: "您还没有登录",
                                text: "登录后才能进行相应操作，需要现在登录吗？",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                cancelButtonText: "取消",
                                confirmButtonText: "去登录",
                                closeOnConfirm: false
                            }, function(){
                                window.location.href='index.php?r=site/login';
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
        })
    /**
     * ajax删除视频
     */
        .on('click','.delete_video',function(){
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
        })
    /**
     * ajax增删关注
     */
        .on('click','.add_follow',function(){
            var $this = $(this);
            var user_id = $this.attr('data-user-id');
            var fans = $('.fans_'+user_id);
            if (user_id) {
                swal({
                    title: '<div class="load"><div class="loader">Loading...</div></div>',
                    html: true
                });
                var follow_html = '<small><span class="label label-primary"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>关注</span></small>';
                var followed_html = '<small><span class="label label-warning"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>已关注</span></small>';
                $.ajax({
                    type: "post",
                    url: "index.php?r=user/default/follow",
                    data: {user_id: user_id},
                    dataType: "text",
                    success: function ($date) {
                        if($date == 'ok'){
                            $this.html(followed_html);
                            fans.text(Number(fans.text())+1);
                            swal({
                                title:'关注成功',
                                type:'success'
                            });
                        }else if($date == 'ok_delete'){
                            $this.html(follow_html);
                            fans.text(Number(fans.text())-1);
                            swal({
                                title:'取消关注成功',
                                type:'success'
                            });
                        }else if($date == 'no_login'){
                            swal({
                                title: "您还没有登录",
                                text: "登录后才能进行相应操作，需要现在登录吗？",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                cancelButtonText: "取消",
                                confirmButtonText: "去登录",
                                closeOnConfirm: false
                            }, function(){
                                window.location.href='index.php?r=site/login';
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
            }else{
                swal({
                    title:'不能添加自己为关注',
                    type:'error'
                });
            }
        })
    /**
     * 动态加载更多视频信息
     */
        .on("click",'.get_more', function () {
            swal({
                title: '<div class="load"><div class="loader">Loading...</div></div>',
                html: true
            });
            var type = $(this).attr('data-type');
            var offset = parseInt($(this).attr('data-count-num'));
            var date_start = $(this).attr('data-date-start');
            var date_end = $(this).attr('data-date-end');
            var search_type = parseInt($(this).attr('data-search-type'));
            var search_content = $(this).attr('data-search-content');
            var tag_id = parseInt($(this).attr('data-tag-id'));
            $(this).parent('div').load('index.php?r=site/get-more&type='+type+'&offset='+offset+'&date_start='+date_start+'&date_end='+date_end+'&search_type='+search_type+'&search_content='+search_content+'&tag_id='+tag_id,
                function() {
                    swal.close();
                }
            );
        });

    /**
     * ajax审核单个视频
     */
    $('.pass_video').on('click',function(){
        var $this = $(this);
        var top_id = $this.attr('data-top-id');
        if (top_id) {
            swal({
                title: '<div class="load"><div class="loader">Loading...</div></div>',
                html: true
            });
            var passed_html = '通过';
            var pass_html = '未通过';
            $.ajax({
                type: "post",
                url: "index.php?r=superAdmin/default/pass-video",
                data: {top_id: top_id},
                dataType: "text",
                success: function ($date) {
                    if($date == 'ok_passed'){
                        $this.removeClass('btn-danger').addClass('btn-primary').html(passed_html);
                        swal({
                            title:'该视频获得展示的权限',
                            type:'success'
                        });
                    }else if($date == 'ok_pass'){
                        $this.removeClass('btn-primary').addClass('btn-danger').html(pass_html);
                        swal({
                            title:'取消该视频的展示权限成功',
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
     * ajax审核视频完成
     */
    $('.end_video_pass').on('click',function(){
        var $this = $(this);
        var top_type = $this.attr('data-top-type');
        var top_date = $this.attr('data-top-date');
        if (top_type && top_date) {
            swal({
                title: '<div class="load"><div class="loader">Loading...</div></div>',
                html: true
            });
            $.ajax({
                type: "post",
                url: "index.php?r=superAdmin/default/end-pass-video",
                data: {top_type: top_type,top_date:top_date},
                dataType: "text",
                success: function ($date) {
                    if($date == 'ok_passed'){
                        swal({
                            title:top_date+'期视频审核完成',
                            type:'success'
                        }, function(){
                            window.location.href='index.php?r=superAdmin/default/index';
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

});
