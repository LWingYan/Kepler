            <div class=" p-5 card bg-white rounded my-3 w-full">
                
                <book data-doubanId="<?php $this->fields->doubanId() ?>"></book>
                    
                <div class="bg-white w-full post-content book-content relative">
                    <?php article_changetext($this, $this->user->hasLogin()) ?>
                </div>
            
            </div>
            
            <div class="flex relative divider justify-center">
                <small class="text-end text-slate-400 text-xs">End</small>
            </div>
            
            <div class="mt-9 post relative card w-ful say-comments" >
                <?php $this->need('comments/say-comments.php'); ?>
            </div>