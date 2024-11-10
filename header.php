<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta name="renderer" content="webkit" />
    <meta name="format-detection" content="email=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, shrink-to-fit=no, viewport-fit=cover">
    <link rel="shortcut icon" href="<?php $this->options->Favicon() ?>" />
    <title><?php $this->archiveTitle(array('category' => '分类 %s 下的文章', 'search' => '包含关键字 %s 的文章', 'tag' => '标签 %s 下的文章', 'author' => '%s 发布的文章'), '', ' - '); ?><?php $this->options->title(); ?></title>
    <?php if ($this->is('single')) : ?>
      <meta name="keywords" content="<?php echo $this->fields->keywords ? $this->fields->keywords : htmlspecialchars($this->_keywords); ?>" />
      <meta name="description" content="<?php echo $this->fields->description ? $this->fields->description : htmlspecialchars($this->_description); ?>" />
      <?php $this->header('keywords=&description='); ?>
    <?php else : ?>
      <?php $this->header(); ?>
    <?php endif; ?>
    
    <?php
        $fontUrl = $this->options->CustomFont ?? ''; // 使用空字符串作为默认值
        $fontFormat = '';
        
        if (strpos($fontUrl, 'woff2') !== false) {
            $fontFormat = 'woff2';
        } elseif (strpos($fontUrl, 'woff') !== false) {
            $fontFormat = 'woff';
        } elseif (strpos($fontUrl, 'ttf') !== false) {
            $fontFormat = 'truetype';
        } elseif (strpos($fontUrl, 'eot') !== false) {
            $fontFormat = 'embedded-opentype';
        } elseif (strpos($fontUrl, 'svg') !== false) {
            $fontFormat = 'svg';
        }
        
    ?>
    <style>
      @font-face {
        font-family: 'wodeziti';
        font-weight: 400;
        font-style: normal;
        font-display: swap;
        src: url('<?php echo $fontUrl ?>');
        <?php if ($fontFormat) : ?>src: url('<?php echo $fontUrl ?>') format('<?php echo $fontFormat ?>');
        <?php endif; ?>
      }
      @font-face{
        font-family: 'zql Font';
        src:  url('//jsd.cdn.zzko.cn/gh/LWingYan/photos@latest/zql.woff');
        src:  url('//jsd.cdn.zzko.cn/gh/LWingYan/photos@latest/zql.woff2');
        }
        
      body {
        <?php if ($fontUrl) : ?>
        font-family: 'wodeziti';
        <?php else : ?>
        font-family: 'zql Font','Helvetica Neue', Helvetica, 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', '微软雅黑', Arial, sans-serif;
        <?php endif; ?>
      }
      <?php $this->options->CustomCSS() ?>
    </style>
    <?php if ($this->options->Favicon()) : ?>
    <link rel="shortcut icon" href="<?php $this->options->Favicon() ?>" />
    <?php else : ?>
    <link rel="shortcut icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text x=%22-0.125em%22 y=%22.9em%22 font-size=%2290%22>💤</text></svg>" />
    <?php endif; ?>
    <!-- 全局 -->
    <link href="<?php _getAssets('assets/css/style.css'); ?>" rel="stylesheet" />
    <!-- 幻灯片 -->
    <link rel="stylesheet" href="<?php _getAssets('assets/swiper/swiper-bundle.min.css'); ?>"/>
    <!-- 代码块 -->
    <link href="<?php _getAssets('assets/prism/prism.min.css'); ?>" rel="stylesheet" />
    <!-- 音乐 -->
    <link href="<?php _getAssets('assets/aplayer/APlayer.min.css'); ?>" rel="stylesheet" />
    <!-- icon -->
    <link href="https://jsd.onmicrosoft.cn/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
    <?php $this->options->CustomHeadEnd() ?>
</head>
<body>
    <div class="flex container">
        <section class="md:px-3 md:h-80 md:p fixed bg-sidebar w-16 md:w-full top-0 bottom-0 md:bottom left-0 border-right md:border-right p-2 relative z-9">
            
            <div class="flex flex-col md:flex-row gap-3 items-center justify-between md:inherit">
                <a class="nav-link mt-4 md:mb md:mt" href="<?php $this->options->siteUrl(); ?>">
                    <img src="<?php _getAvatarByMail($this->author->mail) ?>" width="36px" height="36px" class="rounded-full">
                </a>
                <nav id="nav-menu" class="md:hidden md:flex-row clearfix flex flex-col gap-3 items-center" role="navigation">
                    
                    <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                    <?php while($pages->next()): ?>
                    <a class="nav-link <?php if($this->is('page', $pages->slug)): ?> active <?php endif; ?>" href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->fields->page_icon(); ?></a>
                    <?php endwhile; ?>
                </nav>
                
                <div class="flex flex-col md:flex-row gap-2 md:gap-6 items-center absolute md:right-3 bottom-2.5">
                    <a class="nav-link" id="toggle-night-mode"><i class="ri-contrast-2-line"></i></a>
                    <a class="nav-link hidden md:block isShowNav-toggle"><i class="ri-menu-fold-3-fill"></i></a>
                    <!-- 返回顶部 -->
                    <a href="javascript:;" id="back-to-top" class="nav-link text-xs" title="返回顶部" style="display:none;"></a>
                </div>
            </div>
            
            <button type="submit" class="border text-white bg-primary fixed md:block hidden sidebar-toggle menu:bg-primary" style="top:65px;left:45px;z-index:99;padding:5px;height:28px;width:28px;line-height:12px;border-radius:50px;text-align:-webkit-right;"><i class="ri-menu-unfold-4-fill"></i></button>
            <!-- 手机端导航 -->
            <div class="sidebar sidebar-s p-2 bg-sidebar w-16 md:mt-80 md:border-top hidden md:block fixed top-0 bottom-0 left-0">
                <nav id="nav-menu" class="clearfix flex flex-col gap-3 items-center" role="navigation">
                    <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                    <?php while($pages->next()): ?>
                    <a class="nav-link <?php if($this->is('page', $pages->slug)): ?> active <?php endif; ?>" href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->fields->page_icon(); ?></a>
                    <?php endwhile; ?>
                </nav>
            </div>
            
        </section>
        
        
        
        
    