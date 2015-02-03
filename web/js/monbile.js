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
        //$("#video_message").charCount();

        //custom usage
    $("#video_message").charCount({
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
            var content = $(this).parents('form').find('#video_message').val();
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
                    $('body').append('<div id="tag_popover"><span class="glyphicon glyphicon-remove pull-right popover_close" aria-hidden="true"></span><div id="tag_popover_inner"></div><span class="glyphicon glyphicon-ok pull-right popover_ok btn btn-primary" aria-hidden="true"></span></div>');

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

                    var content = $('#video_message').val();
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
        click: function (event) {
            $("#classify").attr("value",$(this).attr("data-gid"));
            $("#change_classify").html($(this).text()+" <span class=\"caret\"></span>").addClass('btn-primary');
        }
    });


    //绑定动态事件
    $("body").on("click", function () {
        $("#tag_popover").hide();
    }).on("click", "#tag_popover", function (event) {
        event.stopPropagation();
    }).on("click", ".popover_close", function () {
        $("#tag_popover").hide();
    }).on("click", ".popover_ok", function () {
        var spans = $(".tag-this").children('span');
        var value = "";
        $.each(spans, function (key, val) {
            value += $(val).children('span').text() + '#';
        });
        $("input[name='tag']").attr("value", value);
        $("#tag_popover").hide();
        $('#add_tag').addClass('btn-primary');
    });


});
