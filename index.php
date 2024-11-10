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
    
        <section class="md:mt-80 bg-white w-full p-5 h-screen post-article p-l md:p-l tracking-1.8" style="flex:1;">
            <div class="flex flex-col gap-2 items-center justify-center h-full overflow-hidden">
                <img src="<?php _getAvatarByMail($this->author->mail) ?>" width="60px" height="60px" class="rounded-full">
                <h5>Hey,<?php $this->author(); ?>!</h5>
                <p><?php $this->options->description() ?></p>
            </div>
        </section>
        
    </div> <!-- header flex end -->

<?php $this->need('footer.php'); ?>
