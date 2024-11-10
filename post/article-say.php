            <div class=" p-5 card bg-white rounded my-3 flex gap-2 w-full">
            
                <div class="avatar rounded-full flex items-center justify-center" style="margin-top:0.75rem;">
                    <img src="<?php _getAvatarByMail($this->author->mail) ?>" class="rounded-full avatar">
                </div>
                    
                <div class="bg-white w-full post-content say-content relative">
                    <?php article_changetext($this, $this->user->hasLogin()) ?>
                    <span class="text-xs text-slate-400">
                        <?php echo human_time_diff($this->created);?> · <?php getPostView($this) ?>阅读
                    </span>
                    
                </div>
            
            </div>
            
            <div class="flex relative divider justify-center">
                <small class="text-end text-slate-400 text-xs">End</small>
            </div>
            
            <div class="mt-9 post relative card w-ful say-comments" >
                <?php $this->need('comments/say-comments.php'); ?>
            </div>