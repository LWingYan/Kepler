<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
    
    
</body>
    <!-- 全靠jquery -->
    <script src="<?php _getAssets('assets/js/jquery.min.js'); ?>"></script>
    <!-- 灯箱 -->
    <script src="<?php _getAssets('assets/js/view-image.min.js'); ?>"></script>
    <!-- 懒加载 -->
    <script src="<?php _getAssets('assets/js/lazysizes.js'); ?>"></script>
    <!-- 配置灯箱 -->
    <script>
        window.ViewImage && ViewImage.init('.post-content img , .comment-content img , .commentText img' );
    </script>
    <!-- 访客优化 -->
    <script src="//instant.page/5.2.0" type="module" integrity="sha384-jnZyxPjiipYXnSU0ygqeac2q7CVYMbh84q0uHVRRxEtvFPiQYbXWUorga2aqZJ0z"></script>
    <!-- 代码块 -->
    <script src="<?php _getAssets('assets/prism/prism.js'); ?>"></script>
    <!-- cookie -->
    <script src="<?php _getAssets('assets/js/js.cookie.min.js'); ?>"></script>
    <!-- 全局 -->
    <script src="<?php _getAssets('assets/js/script.js'); ?>"></script>
    <script>
        const themeUrl = '<?php $this->options->themeUrl(); ?>';
        <?php $this->options->CustomScript() ?>
    </script>
    
    <?php $this->options->CustomBodyEnd() ?>
    
<?php $this->footer(); ?>