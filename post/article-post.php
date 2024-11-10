            <div class="p-5 card border-bottom bg-white rounded my-3 flex gap-2 w-full items-center">
                <div class="avatar rounded-full flex items-center justify-center <?php Viewlevel($this->cid); ?>">
                    <span class="text-xs avatar flex items-center justify-center">文</span>
                </div>
                <div class="ellipsis w-full">
                    <div class="flex justify-between gap-2 w-full items-center">
                        <h3><?php $this->title() ?></h3>
                        <span class="text-xs"><?php echo human_time_diff($this->created);?></span>
                    </div>
                        <div class="text-xs gap-2 flex" style="padding:5px 0;">
                            <?php getPostView($this) ?>阅读
                            <?php $this->commentsNum('%d评论'); ?>
                        </div>
                </div>
            </div>
            <div class="p-5 card bg-white my-3 w-full post-content">
                <?php article_changetext($this, $this->user->hasLogin()) ?>
            </div>
            
            <div class="flex relative divider justify-center">
                <small class="text-end text-slate-400 text-xs">End</small>
            </div>
            
            <div class="mt-9 mb-7 post relative card p-5 my-3 w-ful article-comments" >
                <?php $this->need('comments/article-comments.php'); ?>
            </div>