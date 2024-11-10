<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>

        <section class="md:mt-80 bg-sidebar w-96 md:w-full p-w md:p-w h-screen fixed z-8 sidebar sidebar-big md:border-top overflow-auto bottom-0 top-0 "style="height: auto;">
            <div class="p-5">
                <div class="mb-3.5">
                    <a href="<?php $this->options->siteUrl(); ?>" title="<?php $this->options->title() ?>" class="mb-7">
                        <img src="<?php $this->options->logoUrl(); ?>" height="50px" class="mb-7">
                    </a>
                    <form method="get" action="<?php $this->options->siteUrl(); ?>" role="search" class="card bg-white p-2 w-full relative rounded">
                        
                        <button type="submit" class="tracking-1.8 border bg-transparent absolute" style="top:12px;"><i class="ri-search-eye-line"></i></button>
                        <input type="text" name="s" placeholder="Search..." class="tracking-1.8 border bg-transparent w-full" style="padding-left:18px;">
                        
                    </form>
                
                    <!-- index显示 -->
                    <?php if ($this->is('index')) : ?>
                    <div class="category_tab">
                    <?php if ($this->have()): ?>
                    <?php while ($this->next()):?>
                        <?php if($this->fields->article_type == "photos") { ?><!-- 相册样式 -->
                        
                        <?php } elseif ($this->fields->article_type == "book") { ?><!-- 书单样式 -->
                        <div class="card hover:border-primary border-white border-1 border-solid bg-white rounded my-3 flex gap-2 w-full index_links_tab" style="padding:15px;">
                            <div class="avatar rounded-full flex items-center justify-center ">
                                <span class="text-xs avatar flex items-center justify-center book"><i class="ri-book-open-line"></i></span>
                            </div>
                            <div class="ellipsis w-full tracking-1.8">
                                <div class="flex justify-between gap-2 w-full">
                                    <h6><a style="padding:5px 0;" href="<?php $this->permalink() ?>"><?php echo mb_substr($this->title, 0, 10, 'UTF-8') . (mb_strlen($this->title, 'UTF-8') > 10 ? '...' : ''); ?></a></h6>
                                    <span class="text-xs"><?php echo human_time_diff($this->created);?></span>
                                </div>
                                <p style="padding:5px 0;" class="ellipsis text-xs"><?php echo _getAbstract($this,50);?></p>
                            </div>
                        </div>
                        <?php } elseif ($this->fields->article_type == "say") { ?><!-- 说说样式 -->
                        <div class="card hover:border-primary border-white border-1 border-solid bg-white rounded my-3 flex gap-2 w-full index_links_tab" style="padding:15px;">
                            <div class="avatar rounded-full flex items-center justify-center <?php Viewlevel($this->cid); ?>">
                                <img src="<?php _getAvatarByMail($this->author->mail) ?>" class="rounded-full avatar">
                            </div>
                            <div class="tracking-1.8 ellipsis w-full">
                                <div class="flex justify-between gap-2 w-full">
                                    <h6><a style="padding:5px 0;" href="<?php $this->permalink() ?>"><?php echo mb_substr($this->title, 0, 10, 'UTF-8') . (mb_strlen($this->title, 'UTF-8') > 10 ? '...' : ''); ?></a></h6>
                                    <span class="text-xs"><?php echo human_time_diff($this->created);?></span>
                                </div>
                                <p style="padding:5px 0;" class="ellipsis text-xs"><?php echo _getAbstract($this,50);?></p>
                            </div>
                        </div>
                        <?php } else {?><!-- 默认样式 -->
                        <div class="card hover:border-primary border-white border-1 border-solid bg-white rounded my-3 flex gap-2 w-full index_links_tab" style="padding:15px;">
                            <div class="avatar rounded-full flex items-center justify-center <?php Viewlevel($this->cid); ?>">
                                <span class="text-xs avatar flex items-center justify-center">文</span>
                            </div>
                            <div class="tracking-1.8 ellipsis w-full">
                                <div class="flex justify-between gap-2 w-full">
                                    <h6><a style="padding:5px 0;" href="<?php $this->permalink() ?>"><?php echo mb_substr($this->title, 0, 10, 'UTF-8') . (mb_strlen($this->title, 'UTF-8') > 10 ? '...' : ''); ?></a></h6>
                                    <span class="text-xs"><?php echo human_time_diff($this->created);?></span>
                                </div>
                                <p style="padding:5px 0;" class="ellipsis text-xs"><?php echo _getAbstract($this,50);?></p>
                            </div>
                        </div>
                        <?php }?>
                    <?php endwhile; ?><!-- 输出文章结束 -->
                        <?php else: ?><!-- 没有文章的话显示 -->
                            <div class="tracking-1.8 my-3 block mr-auto ml-auto">
                                暂无文章
                            </div>
                    <?php endif; ?>
                    </div>
                    <center class="tracking-1.8 text-xs"><?php $this->pageLink('点击查看更多','next');?></center>
                    <?php endif; ?>
                </div>
                <!--这里放置你希望在非首页显示的内容-->
                <?php if (!$this->is('index')): ?>
                    <div class="tracking-1.8 card mb-7 bg-white flex flex-col mb-7 rounded p-5 items-center gap-2 ">
                        <img src="<?php _getAvatarByMail($this->author->mail) ?>" height="100px" width="100px" class="rounded-lg">
                        <div class="mt-4 flex flex-col items-center gap-2">
                            <h3><?php $this->author(); ?></h3>
                            <p style="padding:5px 0;" class="ellipsis text-xs">最后活跃：<?php get_last_login(1); ?></p>
                        </div>
                        
                    </div>
                    <!-- post显示 -->
                    <?php if ($this->is('post')) : ?>
                        <?php if($this->fields->article_type == "0") { ?><!-- 文章样式实现 -->
                        <!-- 目录 -->
                        <div class="tracking-1.8 card mb-7 p-5 bg-white">
                            <section class="widget toc" id="sticky">
                                <div class="widget-toc">
                                    <?php echo generateToc($this->content); ?>
                                </div>
                            </section>
                        </div>
                        <!-- tags -->
                        <div class="tracking-1.8 card mb-7 p-5 bg-white">
                            <section class="">
                                <?php if ($this->tags): ?>
                                    <div class="post-tags flex gap-2 flex-wrap ">
                                        <?php foreach ($this->tags as $tag): ?>
                                            <div class="article-tags text-xs">
                                                <?php $count = getTagCount($tag['mid']); ?>
                                                <a href="<?php echo $tag['permalink']; ?>">#<?php echo $tag['name']; ?></a> <span class="article-tags-num "><?php echo $count; ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </section>
                        </div>
                        <?php }?><!-- 文章样式实现结束 -->
                    <?php endif; ?><!-- post显示结束 -->
                <?php endif; ?><!-- 非首页显示结束 -->
                <!-- 版权 -->
                <div class="tracking-1.8 card mb-7 bg-white mb-7 rounded p-5">
                    <div class="text-xs opacity-85 text-slate-400">
                        
                        
                        <p class="py-1.5">&copy; <?php echo date('Y'); ?> Typecho Theme <?php echo '<a href="//ouyu.me/30/" target="_blank">' . __THEME_NAME__ . '</a>&nbsp;'  . __THEME_VERSION__; ?> by <a href="//ouyu.me" target="_blank">林厌</a> All rights reserved.</p>
                    </div>
                    <?php $this->options->Footer() ?>
                </div>
                
            </div>
            
            
        </section>