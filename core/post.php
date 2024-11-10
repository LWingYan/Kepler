<?php

use Widget\Archive;

function human_time_diff($from, $to = '') {
    if (empty($to)) {
        $to = time();
    }
    $diff = abs($to - $from);
    $day_diff = floor($diff / 86400);
    if ($day_diff >= 1) {
        if ($day_diff == 1) {
            return '昨天';
        }
        return ' ' . $day_diff . ' 天前';
    }
    $hour_diff = floor(($diff - $day_diff * 86400) / 3600);
    if ($hour_diff >= 1) {
        if ($hour_diff == 1) {
            return ' 1 小时前';
        }
        return ' ' . $hour_diff . ' 小时前';
    }
    $minute_diff = floor(($diff - $day_diff * 86400 - $hour_diff * 3600) / 60);
    if ($minute_diff >= 1) {
        if ($minute_diff == 1) {
            return ' 1 分钟前';
        }
        return ' ' . $minute_diff . ' 分钟前';
    }
    return ' 刚刚';
}

function get_last_login($user){
    $user   = '1'; // 这里的 '1' 是博主的用户ID，你需要根据实际情况来设置
    $now = time();
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $row = $db->fetchRow($db->select('activated')->from('table.users')->where('uid = ?', $user));
    if ($row) {
        echo Typecho_I18n::dateWord($row['activated'], $now);
    } else {
        echo '博主一直在这里';
    }
}

function Viewlevel($cid) {
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    // 确保字段名称与数据库中的名称一致
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    $views = $row ? (int) $row['views'] : 0;
    if (!isset($views)) {
        // 如果查询失败或字段不存在，返回一个默认值或错误信息
        echo 'default-post';
    }

    if ($views < 100) {
        echo 'new-post';
    } elseif ($views >= 100 && $views < 300) {
        echo 'good-post';
    } elseif ($views >= 300 && $views < 1000) {
        echo 'recommended-post';
    } elseif ($views >= 1000 && $views < 5000) {
        echo 'hot-post';
    } elseif ($views >= 5000 && $views < 10000) {
        echo 'headline-post';
    } elseif ($views >= 10000 && $views < 30000) {
        echo 'explosive-post';
    } elseif ($views >= 30000) {
        echo 'god-post';
    }
}

function getPostView($archive): void {
    $cid = $archive->cid;
    $db = \Typecho\Db::get();
    $prefix = $db->getPrefix();
    // 获取当前文章的浏览量
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    $views = $row ? (int) $row['views'] : 0;
    // 如果是单篇文章页面，则增加浏览量
    if ($archive->is('single')) {
        $cookieViews = \Typecho\Cookie::get('__post_views');
        $viewedPosts = $cookieViews ? explode(',', $cookieViews) : [];
        if (!in_array($cid, $viewedPosts)) {
            $db->query($db->update('table.contents')->rows(array('views' => $views + 1))->where('cid = ?', $cid));
            $viewedPosts[] = $cid;
            \Typecho\Cookie::set('__post_views', implode(',', $viewedPosts)); // 记录查看cookie
            $views++; // 更新本次显示的浏览量
        }
    }
    // 格式化浏览量
    if ($views >= 10000) {
        $formattedViews = number_format($views / 10000, 1) . 'w';
    } elseif ($views >= 1000){
        $formattedViews = number_format($views / 1000, 1) . 'k';
    } else {
        $formattedViews = $views;
    }
    echo $formattedViews;
}

// 生成文章目录树
function generateToc($content): string {
    $idCounter = 1;
    $matches = array();
    preg_match_all('/<h([1-5])(?![^>]*class=)([^>]*)>(.*?)<\/h\1>/', $content, $matches, PREG_SET_ORDER);
    if (!$matches) {
        return '暂无目录';
    }
    $toc = '<ul class="ul-toc list-none">';
    $currentLevel = 0;
    foreach ($matches as $match) {
        $level = (int)$match[1];
        $attributes = $match[2];
        $title = strip_tags($match[3]);
        $anchor = 'header-' . $idCounter++;
        // 生成新的标题标签并添加 id
        $content = str_replace($match[0], '<h' . $level . ' id="' . $anchor . '"' . $attributes . '>' . $match[3] . '</h' . $level . '>', $content);
        // 调整目录层级
        if ($currentLevel == 0) {
            $currentLevel = $level;
        }
        while ($currentLevel < $level) {
            $toc .= '<ul>';
            $currentLevel++;
        }
        while ($currentLevel > $level) {
            $toc .= '</ul></li>';
            $currentLevel--;
        }
        $toc .= '<li><a href="#' . $anchor . '" class="toc-link">' . $title . '</a>';
        // 添加闭合标签
        $toc .= '</li>';
    }
    // 关闭所有未闭合的 ul 标签
    while ($currentLevel > 0) {
        $toc .= '</ul>';
        $currentLevel--;
    }
    $toc .= '</ul>';
    return $toc;
}

function getTagCount($mid) {
    $db = Typecho_Db::get();
    // 构建查询，排除 typecho_fields 表中存在 'say' 类型的文章
    $query = $db->select(array('COUNT(DISTINCT table.relationships.cid)' => 'num'))
        ->from('table.relationships')
        ->join('table.contents', 'table.relationships.cid = table.contents.cid', Typecho_Db::LEFT_JOIN)
        ->join('table.fields', 'table.contents.cid = table.fields.cid', Typecho_Db::LEFT_JOIN)
        ->where('table.relationships.mid = ?', $mid)
        ->where('table.contents.type = ?', 'post')
        ->where('table.fields.name = ?', 'article_type')
        ->where('table.fields.str_value != ?', 'say')
        ->group('table.relationships.mid');
    $result = $db->fetchObject($query);
    return $result ? $result->num : 0;
}

