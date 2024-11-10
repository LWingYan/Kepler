/* ———————————————————————————————— 
    书籍          
 ———————————————————————————————— */
 
 $(document).ready(function(){
    // 获取 <book> 元素
    var $book = $('book');
    var doubanId = $book.data('doubanid');
    // 检查是否存在 <book> 标签以及是否有豆瓣 ID
    if ($book.length && doubanId) {
        // 在 <book> 元素后面插入一个新的 <div> 用于显示书籍信息
        $book.after('<div id="book-info" class="flex gap-2"><p>正在加载书籍信息...</p></div>');

        // 发起 AJAX 请求，获取书籍信息
        $.ajax({
            url: themeUrl+'core/fetch-douban-info.php',  // 替换为你的 PHP 脚本路径
            type: 'GET',
            data: {
                info_type: 'book',
                book_id: doubanId
            },
            dataType: 'json',
            success: function(response) {
                // 根据返回的 JSON 数据更新页面内容
                if (response.title) {
                    $('#book-info').html(
                        '<img height="150px" width="150px" src="' + response.image + '" alt="' + response.title + '" referrerpolicy="no-referrer" />' +
                        '<div style="max-height:150px;overflow:auto;"><h2>' + response.title + '</h2>' +
                        '<p>作者: ' + response.author + '</p>' +
                        '<p>出版日期: ' + response.pubdate + '</p>' +
                        '<p class="summary">简介: ' + response.summary + '</p></div>'
                    );
                } else {
                    $('#book-info').html('<p>无法获取书籍信息</p>');
                }
            },
            error: function() {
                $('#book-info').html('<p>获取书籍信息失败</p>');
            }
        });
    }
});

/* ———————————————————————————————— 
    评论表情按钮          
 ———————————————————————————————— */

$(document).ready(function() {
    $('.emoji-btn').click(function() {
        // 检查 .comment_emoji_block 是否是可见的
        if ($('.comment_emoji_block').is(':visible')) {
            // 如果是可见的，使用 slideUp 添加向上滑动隐藏效果
            $('.comment_emoji_block').slideUp();
        } else {
            // 如果是不可见的，使用 slideDown 添加向下滑动显示效果
            $('.comment_emoji_block').slideDown();
        }
    });
});

/* ———————————————————————————————— 
    昼夜替换            
 ———————————————————————————————— */

$(document)
  .ready(function() {
    // 检查是否存在夜间模式的 cookie
    let isNightMode;
    try {
      isNightMode = Cookies.get('nightMode') === 'true';
    } catch (error) {
      console.error('Error getting night mode from cookies:', error);
      // 可以在这里添加一个默认的模式或者提示用户
      isNightMode = false;
    }
    if (isNightMode) {
      $('html')
        .addClass('night-mode');
      $('#toggle-night-mode ')
        .addClass('active');
    }
    $('#toggle-night-mode')
      .click(function() {
        const html = $('html');
        const button = $('#toggle-night-mode');
        if (html.hasClass('night-mode')) {
          // 当前是夜间模式，切换为白天模式
          html.removeClass('night-mode');
          button.removeClass('active');
          Cookies.set('nightMode', 'false');
        } else {
          // 当前是白天模式，切换为夜间模式
          html.addClass('night-mode');
          button.addClass('active');
          Cookies.set('nightMode', 'true');
        }
      });
  });

/* ———————————————————————————————— 
    文章目录
 ———————————————————————————————— */

$(document)
  .ready(function() {
    let $stickyModule = $('#sticky');
    if ($stickyModule.length) {
      var stickyModuleOffset = $stickyModule.offset()
        .top;
      var isSticky = false;

      function checkSticky() {
        var moduleRect = $stickyModule[0].getBoundingClientRect();
        var moduleWidth = moduleRect.width;
        if ($(window)
          .scrollTop() > stickyModuleOffset) {
          if (!isSticky) {
            $stickyModule.css('width', moduleWidth)
              .addClass('sticky');
            isSticky = true;
          }
        } else {
          if (isSticky) {
            $stickyModule.css('width', '')
              .removeClass('sticky');
            isSticky = false;
          }
        }
      }
      $(window)
        .on('scroll', function() {
          requestAnimationFrame(checkSticky);
        });
      // 监听滚动事件，更新目录项样式
      var $tocLinks = $('.toc-link');
      var $headers = $('.post-content h1, .post-content h2, .post-content h3, .post-content h4, .post-content h5');

      function scrollCheck() {
        var scrollTop = $(window)
          .scrollTop();
        var activeIndex = -1;
        $headers.each(function(index) {
          if ($(this)
            .offset()
            .top - scrollTop < 40) {
            activeIndex = index;
          }
        });
        $tocLinks.removeClass('active');
        if (activeIndex >= 0) {
          $tocLinks.eq(activeIndex)
            .addClass('active');
        } else {
          // 当没有找到高亮的标题时，默认高亮第一个目录项
          $tocLinks.eq(0)
            .addClass('active');
        }
      }
      scrollCheck();
      $(window)
        .on('scroll', function() {
          scrollCheck();
        });
    }
  });

/* ———————————————————————————————— 
    侧栏显示与隐藏
 ———————————————————————————————— */

$(document)
  .ready(function() {
    // 绑定点击事件到 sidebar-toggle
    $('.sidebar-toggle').click(function() {
      // 切换 body 的 open-sidebar-menu 类
      $('body').toggleClass('open-sidebar-menu');
      // 如果 open-isShowNav 类存在，则移除它
      if ($('body').hasClass('open-isShowNav')) {
        $('body').removeClass('open-isShowNav');
      }
    });
    $('.isShowNav-toggle').click(function() {
      // 切换 body 的 open-isShowNav 类
      $('body').toggleClass('open-isShowNav');
      // 如果 open-sidebar-menu 类存在，则移除它
      if ($('body').hasClass('open-sidebar-menu')) {
        $('body').removeClass('open-sidebar-menu');
      }
    });
  });

/* ———————————————————————————————— 
    实现返回顶部
 ———————————————————————————————— */
$(document)
  .ready(function() {
    // 当文档滚动时，更新返回顶部按钮上的数字
    $(window)
      .scroll(function() {
        var scrollTop = $(this).scrollTop(); // 获取当前滚动条的位置
        var maxHeight = $(document).height() - $(window).height(); // 获取最大滚动高度
        var percentage = (scrollTop / maxHeight) * 100; // 计算下滑的百分比

        // 限制百分比的最大值为100
        percentage = Math.min(percentage, 100);

        if (scrollTop > 100) { // 如果用户滚动超过100px，则显示按钮
          $('#back-to-top')
            .fadeIn()
            .text(percentage.toFixed(0) + '%'); // 在按钮上显示下滑的百分比
        } else {
          $('#back-to-top')
            .fadeOut();
        }
      });

    // 点击返回顶部按钮，平滑滚动到页面顶部
    $('#back-to-top')
      .click(function() {
        $('html, body')
          .animate({
            scrollTop: 0
          }, 800); // 800ms内滚动到顶部
        return false; // 阻止默认的跳转行为
      });
  });
/* ———————————————————————————————— 
    实现加载更多
 ———————————————————————————————— */
jQuery(document)
  .ready(function($) {
    // 点击下一页的链接(即那个a标签)
    $('.next')
      .click(function() {
        $this = $(this);
        $this.addClass('loading')
          .text('正在努力加载'); //给a标签加载一个loading的class属性，用来添加加载效果
        var href = $this.attr('href'); //获取下一页的链接地址
        if (href != undefined) { //如果地址存在
          $.ajax({ //发起ajax请求
            url: href,
            type: 'get',
            error: function(request) {
              //如果发生错误怎么处理
            },
            success: function(data) { //请求成功
              $this.removeClass('loading')
                .text('点击查看更多'); //移除loading属性
              var $res = $(data)
                .find('.category_tab'); //从数据中挑出文章数据，请根据实际情况更改
              $('.next')
                .before($res.fadeIn(500)); //将数据加载加进posts-loop的标签中。
              var newhref = $(data)
                .find('.next')
                .attr('href'); //找出新的下一页链接
              if (newhref != undefined) {
                $('.next')
                  .attr('href', newhref);
              } else {
                $('.next')
                  .after('<p class="text-xs" style="text-align: center;">没有了</p>');
                $('.next')
                  .remove(); //如果没有下一页了，隐藏
              }
            }
          });
        }
        return false;
      });
  });