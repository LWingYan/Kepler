<?php
/**
 *  藏着众多孤星之中还是找得到你 
 *
 * 24/10/24
 * 
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
$this->need('sidebar.php');
?>
        <section class="tracking-1.8 md:mt-80 bg-white w-full post-article p-l md:p-l" style="flex:1;">
            
            <?php if($this->fields->article_type == "photos") { ?><!-- 相册样式 -->
                    
            <?php } elseif ($this->fields->article_type == "book") { ?><!-- 书单样式 -->
            <?php $this->need('post/article-book.php'); ?>
            <?php } elseif ($this->fields->article_type == "say") { ?><!-- 说说样式 -->
            <?php $this->need('post/article-say.php'); ?>
            <?php } else {?><!-- 默认样式 -->
            <?php $this->need('post/article-post.php'); ?>
            <?php }?>
            
        </section>
        
        
        
    </div> <!-- header flex end -->

<?php $this->need('footer.php'); ?>