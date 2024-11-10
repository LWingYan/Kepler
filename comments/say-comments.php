<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
//如果你想使用其他评论头像插件，请注释下面这行代码！
define('__TYPECHO_GRAVATAR_PREFIX__', 'https://cravatar.cn/avatar/');
?>
<?php function threadedComments($comments, $options){
    $commentClass = '';
        if ($comments->authorId) {
            if ($comments->authorId == $comments->ownerId) {
                $commentClass .= ' comment-by-author';
            } else {
                $commentClass .= ' comment-by-user';
            }
        }
        ?>
        <li itemscope itemtype="http://schema.org/UserComments" class="list-none comment-body<?php
        if ($comments->levels > 0) {
            echo ' comment-child';
            $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
        } else {
            echo ' comment-parent';
        }
        $comments->alt(' comment-odd', ' comment-even');
        echo $commentClass;
        ?>">
            <div class="comment-col p-5" id="<?php $comments->theId(); ?>">
                
                <div class="comment-author flex gap-2 <?php
        					if ($comments->authorId) {
        						if ($comments->authorId == $comments->ownerId) {
        							_e('comment-admin');
        						}
        					}
        					?> " itemprop="creator" itemscope itemtype="http://schema.org/Person">
                    <!-- 评论者头像 -->
                    <span
                        itemprop="image" class="-full">
                        <?php $comments->gravatar(40); ?>
                    </span>
                    
                    <div>
                    
                        <div class="comment-meta flex gap-2 text-xs text-slate-400 opacity-85 <?php
        					if ($comments->authorId) {
        						if ($comments->authorId == $comments->ownerId) {
        							_e('flex-reverse');
        						}
        					}
        					?>">
                            <!-- 评论名字 -->
                            <b class="fn" itemprop="name"><?php $comments->author(); ?></b>
                            <!-- 评论时间 -->
                            <a href="<?php $comments->permalink(); ?>">
                                <time itemprop="commentTime text-xs" 
                                      datetime="<?php $comments->date('c'); ?>">
                                      <?php echo human_time_diff($comments->created); ?></time>
                            </a>
                            <!-- 评论回复 -->
                            <div class="comment-reply text-xs">
                                <span class="comment-reply text-xs cp-<?php $comments->theId(); ?> text-muted comment-reply-link"><?php $comments->reply('回复'); ?></span><span id="cancel-comment-reply" class="text-xs cancel-comment-reply cl-<?php $comments->theId(); ?> text-muted comment-reply-link" style="display:none" ><?php $comments->cancelReply('取消'); ?></span>
                            </div>
                            <?php if ('waiting' == $comments->status) { ?>
                                <em class="comment-awaiting-moderation text-xs text-slate-400 opacity-85">您的评论正等待审核!</em>
                            <?php } ?>
                        </div>
                        
                        
                        <!-- 评论内容 -->
                        <div class="comment-say mb-3.5" itemprop="commentText">
                            <?php
                                $content = preg_replace('/<p>(.*)/', '<p>'.get_comment_at($comments->coid).'$1', $comments->content);
                                echo $content;
                            ?>
                        </div>
                    
                    </div>
                    
                </div>
            
            </div>
            <?php if ($comments->children) { ?>
                <div class="comment-children" itemprop="discusses">
                    <?php $comments->threadedComments(); ?>
                </div>
            <?php } ?>
        </li>
        <?php
    }
?>

<div id="comments">
    <?php $this->comments()->to($comments); ?>
    
<?php if ($comments->have()): ?>

<?php $comments->listComments(); ?>
        <div class=" comment-pagegroup flex w-full justify-between ">
<?php

$npattern = '/\<li.*?class=\"next\"><a.*?\shref\=\"(.*?)\"[^>]*>/i';
$ppattern = '/\<li.*?class=\"prev\"><a.*?\shref\=\"(.*?)\"[^>]*>/i';
ob_start();
$comments->pageNav();
$con = ob_get_clean();
$n=preg_match_all($npattern, $con, $nextlink);
$p=preg_match_all($ppattern, $con, $prevlink);
if($n){
$nextlink=$nextlink[1][0];
$nextlink=str_replace("#comments","?type=comments",$nextlink);
}else{
$nextlink=false;
}

if($p){
$prevlink=$prevlink[1][0];
$prevlink=str_replace("#comments","?type=comments",$prevlink);
}else{
$prevlink=false;
}
?>
<?php if($prevlink): ?>
    <span class="p-5">
        <a href="<?php echo $prevlink; ?>" class=" bg-sidebar rounded content-page text-xs text-left p-2 my-3">
            上页
        </a>
    </span>
<?php else: ?>
<div></div>
<?php endif; ?>
<?php if($nextlink): ?>
    <span class="p-5">
        <a href="<?php echo $nextlink; ?>" class=" bg-sidebar rounded content-page text-xs text-end p-2 my-3">
            下页
        </a>
    </span>
<?php endif; ?>

    </div>
<?php endif; ?>

<?php if ($this->allow('comment')): ?>
    <div id="<?php $this->respondId(); ?>" class="respond p-5 bg-sidebar sticky bottom-0">

            <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
                <div class="flex gap-2 flex-col">
                    <div class="flex gap-2 ">
                        <textarea  emoji="😺😸😹😻😼😽🙀😿😾🐵🙈🙉🙊💖💔💯💢👌✌️👍💪🤝🙏🧧🧨🎉👣😄😁😆🤣😂🙂🙃😍😘😋🤪🤭🤫🤔🤨😑😶😏🤕🤧😵🥳😎😕😟😯😳🥺😥😭😱😖😣😫🥱😡" placeholder="<?php _e('内容'); ?>" rows="8" cols="50" name="text" id="textarea" onkeydown="if((event.ctrlKey||event.metaKey)&&event.keyCode==13){document.getElementById('submitComment').click();return false};" class="textarea w-full text-slate-400 rounded border box-border Comment_Textarea outline-0 p-2"
                                  required><?php $this->remember('text'); ?></textarea>
                        <div type="submit" class="emoji-btn whitespace-pre bg-white rounded text-slate-400 border box-border outline-0 p-2" style="font-size:18px;"><?php _e('🥱'); ?></div>
    
                        <button type="submit" class="whitespace-pre bg-white rounded text-sm submit text-slate-400 border box-border outline-0 p-2"><?php _e('发表'); ?></button>
                    </div>
                        <div class=" grid comment_emoji_block gap-3 bg-white rounded" style="display:none;"><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😺')">😺</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😸')">😸</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😹')">😹</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😻')">😻</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😼')">😼</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😽')">😽</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🙀')">🙀</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😿')">😿</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😾')">😾</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🐵')">🐵</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🙈')">🙈</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🙉')">🙉</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🙊')">🙊</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '💖')">💖</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '💔')">💔</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '💯')">💯</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '💢')">💢</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '👌')">👌</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '✌️')">✌️</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '👍')">👍</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '💪')">💪</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤝')">🤝</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🙏')">🙏</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🧧')">🧧</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🧨')">🧨</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🎉')">🎉</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '👣')">👣</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😄')">😄</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😁')">😁</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😆')">😆</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤣')">🤣</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😂')">😂</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🙂')">🙂</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🙃')">🙃</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😍')">😍</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😘')">😘</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😋')">😋</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤪')">🤪</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤭')">🤭</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤫')">🤫</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤔')">🤔</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤨')">🤨</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😑')">😑</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😶')">😶</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😏')">😏</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤕')">🤕</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🤧')">🤧</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😵')">😵</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🥳')">🥳</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😎')">😎</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😕')">😕</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😟')">😟</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😯')">😯</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😳')">😳</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🥺')">🥺</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😥')">😥</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😭')">😭</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😱')">😱</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😖')">😖</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😣')">😣</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😫')">😫</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '🥱')">🥱</span><span onclick="$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '😡')">😡</span>
                    </div>
                    </div>
                
                <?php if (!$this->user->hasLogin()): ?>
                <div class="flex gap-2 my-3">
                    <div class="w-full">
                        <input placeholder="<?php _e('称呼'); ?>" type="text" name="author" id="author" class="w-full text text-slate-400 rounded border box-border outline-0 p-2 "
                               value="<?php $this->remember('author'); ?>" required/>
                    </div>
                    <div class="w-full">
                        <input placeholder="<?php _e('Email'); ?>" type="email" name="mail" id="mail" class="w-full text text-slate-400 rounded border box-border outline-0 p-2"
                               value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> />
                    </div>
                    <div class="w-full">
                        <input type="url" name="url" id="url" class="w-full text text-slate-400 rounded border box-border outline-0 p-2" placeholder="<?php _e('http://'); ?>"
                               value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
                    </div>
                </div>
                <?php endif; ?>
                
                
                
            </form>
        </div>
<?php else: ?>
        
    <h3 class="text-center"><?php _e('评论已关闭'); ?></h3>
        
<?php endif; ?>

</div>
<style>
#cancel-comment-reply-link {
    display: inline !important;
}
</style>
<script>
    function showhidediv(id){var sbtitle=document.getElementById(id);if(sbtitle){if(sbtitle.style.display=='flex'){sbtitle.style.display='none';}else{sbtitle.style.display='flex';}}}
(function(){window.TypechoComment={dom:function(id){return document.getElementById(id)},pom:function(id){return document.getElementsByClassName(id)[0]},iom:function(id,dis){var alist=document.getElementsByClassName(id);if(alist){for(var idx=0;idx<alist.length;idx++){var mya=alist[idx];mya.style.display=dis}}},create:function(tag,attr){var el=document.createElement(tag);for(var key in attr){el.setAttribute(key,attr[key])}return el},reply:function(cid,coid){var comment=this.dom(cid),parent=comment.parentNode,response=this.dom("<?php echo $this->respondId(); ?>"),input=this.dom("comment-parent"),form="form"==response.tagName?response:response.getElementsByTagName("form")[0],textarea=response.getElementsByTagName("textarea")[0];if(null==input){input=this.create("input",{"type":"hidden","name":"parent","id":"comment-parent"});form.appendChild(input)}input.setAttribute("value",coid);if(null==this.dom("comment-form-place-holder")){var holder=this.create("div",{"id":"comment-form-place-holder"});response.parentNode.insertBefore(holder,response)}comment.appendChild(response);this.iom("comment-reply","");this.pom("cp-"+cid).style.display="none";this.iom("cancel-comment-reply","none");this.pom("cl-"+cid).style.display="";if(null!=textarea&&"text"==textarea.name){textarea.focus()}return false},cancelReply:function(){var response=this.dom("<?php echo $this->respondId(); ?>"),holder=this.dom("comment-form-place-holder"),input=this.dom("comment-parent");if(null!=input){input.parentNode.removeChild(input)}if(null==holder){return true}this.iom("comment-reply","");this.iom("cancel-comment-reply","none");holder.parentNode.insertBefore(response,holder);return false}}})();
</script>