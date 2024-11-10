<?php
/**
 *  藏着众多孤星之中还是找得到你 
 *
 * @package Kepler
 * @author 林厌
 * @version 1.2
 * @link //ouyu.me
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
$this->need('sidebar.php');
?>
    
        <section class="tracking-1.8 md:mt-80 bg-white w-full post-article p-l md:p-l" style="flex:1;">
            <div class="p-5 card border-bottom bg-white rounded my-3 flex gap-2 w-full items-center">
                <div class="avatar rounded-full flex items-center justify-center">
                    <img src="<?php _getAvatarByMail($this->author->mail) ?>" width="40px" height="40px" class="rounded">
                </div>
                <div class="ellipsis w-full">
                    <div class="flex justify-between gap-2 w-full items-center">
                        <h3><?php $this->title() ?></h3>
                        <span class="text-xs"><?php echo human_time_diff($this->created);?></span>
                    </div>
                </div>
            </div>
            <div class="border-bottom p-5 card bg-white my-3 w-full post-content">
                <?php article_changetext($this, $this->user->hasLogin()) ?>
            </div>
            
            <div class="mt-9 mb-7 post relative card p-5 my-3 w-ful article-comments" >
                <?php $this->need('comments/article-comments.php'); ?>
            </div>
            
        </section>
        
        
        
    </div> <!-- header flex end -->

<?php $this->need('footer.php'); ?>