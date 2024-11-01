<?php

/**
 * 温馨提示内容
 * '{页面别名}' => array(
 *  'content' => {内容}  // 注1
 *  'title' => '温馨提示', // 选填
 *  'type'  =>  '', // 选填，图标class name
 * )
 * 
 * 注1  内容可以直接是html字符串('<dl><dd>提示a</dd><dd>提示b</dd><dd>提示c</dd></dl>；
 *      也可以是列出每项的数组(array('提示a', '提示b', '提示c'))
 */
$prompt_items = array(
  'tdk-base' => array(
    'content' => [
      'SEO本身不是一件容易的事情，但当您深入了解其中的所有要点，也没有想象中那么深奥。',
      '学习<a href="https://www.wbolt.com/learn/wp-seo?utm_source=sst" target="_blank">WordPress
      SEO</a>相关知识并实践(特别是<a href="https://www.wbolt.com/wordpress-seo-tips.html?utm_source=sst"
      target="_blank">WordPress SEO优化方案</a>)。',
      '一般情况下，不建议将搜索页、标签页和作者页添加至索引，但应该设置跟随（即follow）。',
      '推荐安装<a href="https://www.wbolt.com/plugins/skt?utm_source=sst" target="_blank">关键词推荐插件</a>，做好<a
      href="https://www.wbolt.com/keywords-seo-tips.html?utm_source=sst" target="_blank">TDK关键词布局和优化</a>工作。'
    ]
  ),
  'tdk-detail' => array(
    'content' => [
      'SEO本身不是一件容易的事情，但当您深入了解其中的所有要点，也没有想象中那么深奥。',
      '学习<a href="https://www.wbolt.com/learn/wp-seo?utm_source=sst" target="_blank">WordPress
      SEO</a>相关知识并实践(特别是<a href="https://www.wbolt.com/wordpress-seo-tips.html?utm_source=sst"
      target="_blank">WordPress SEO优化方案</a>)。',
      '一般情况下，不建议将搜索页、标签页和作者页添加至索引，但应该设置跟随（即follow）。',
      '推荐安装<a href="https://www.wbolt.com/plugins/skt?utm_source=sst" target="_blank">关键词推荐插件</a>，做好<a
      href="https://www.wbolt.com/keywords-seo-tips.html?utm_source=sst" target="_blank">TDK关键词布局和优化</a>工作。'
    ]
  ),
  'tdk-category' => array(
    'content' => [
      'SEO本身不是一件容易的事情，但当您深入了解其中的所有要点，也没有想象中那么深奥。',
      '学习<a href="https://www.wbolt.com/learn/wp-seo?utm_source=sst" target="_blank">WordPress
      SEO</a>相关知识并实践(特别是<a href="https://www.wbolt.com/wordpress-seo-tips.html?utm_source=sst"
      target="_blank">WordPress SEO优化方案</a>)。',
      '一般情况下，不建议将搜索页、标签页和作者页添加至索引，但应该设置跟随（即follow）。',
      '推荐安装<a href="https://www.wbolt.com/plugins/skt?utm_source=sst" target="_blank">关键词推荐插件</a>，做好<a
      href="https://www.wbolt.com/keywords-seo-tips.html?utm_source=sst" target="_blank">TDK关键词布局和优化</a>工作。'
    ]
  ),
  'tdk-more' => array(
    'content' => [
      'SEO本身不是一件容易的事情，但当您深入了解其中的所有要点，也没有想象中那么深奥。',
      '学习<a href="https://www.wbolt.com/learn/wp-seo?utm_source=sst" target="_blank">WordPress
      SEO</a>相关知识并实践(特别是<a href="https://www.wbolt.com/wordpress-seo-tips.html?utm_source=sst"
      target="_blank">WordPress SEO优化方案</a>)。',
      '一般情况下，不建议将搜索页、标签页和作者页添加至索引，但应该设置跟随（即follow）。',
      '推荐安装<a href="https://www.wbolt.com/plugins/skt?utm_source=sst" target="_blank">关键词推荐插件</a>，做好<a
      href="https://www.wbolt.com/keywords-seo-tips.html?utm_source=sst" target="_blank">TDK关键词布局和优化</a>工作。'
    ]
  ),
  'image' => array(
    'content' => [
      '<a href="https://www.wbolt.com/what-is-and-how-should-you-use-an-alt-tag.html?utm_source=sst"
    target="_blank">图片title和alt标签</a>尽可能<a
    href="https://www.wbolt.com/add-title-alt-to-images-in-wordpress.html?utm_source=sst"
    target="_blank">手动填写</a>，勿忽视其重要性。',
      '"仅补充"即无ALT和Title时应用优化规则，"全覆盖"则全部应用优化规则。'
    ]
  ),
  'robots' => array(
    'content' => [
      'robots.txt用于告知搜索引擎页面链接是否允许爬取或者索引。',
      '您可以通过<a href="https://www.wbolt.com/tools/robots-tester?utm_source=sst"
                    target="_blank">Robots在线工具</a>来校验robots.txt规则是否合规及检测URL是否拦截蜘蛛爬取。',
      '确保未激活其他robots.txt生成器，且需删除网站目录robots.txt文件，否则设置无法生效。',
      '参考教程：“<a href="https://www.wbolt.com/optimize-wordpress-robots-txt.html?utm_source=sst"
                    target="_blank">如何编写和优化WordPress网站的Robots.txt</a>”和”<a
                    href="https://www.wbolt.com/robots-txt.html?utm_source=sst"
                    target="_blank">深入了解Robots.txt及如何规范地编写</a>“'
    ]
  ),
  'other-verify' => array(
    'content' => [
      '各大搜索引擎的站长工具均可以通过多种方式进行验证，包括DNS解析、上传HTML文件及添加meta元描述。',
      '平日无需进行站长平台认证时，可关闭此模块。',
      '站长平台快速入口：<a href="https://ziyuan.baidu.com/" target="_blank">百度</a>、<a
                  href="https://search.google.com/search-console" target="_blank">谷歌GSC</a>、<a
                  href="https://www.bing.com/webmasters/about" target="_blank">Bing</a>、<a
                  href="https://zhanzhang.sogou.com/" target="_blank">搜狗</a>、<a href="https://zhanzhang.so.com/"
                  target="_blank">360搜索</a>、<a href="https://webmaster.yandex.com/" target="_blank">Yandex</a>、<a
                  href="https://zhanzhang.sm.cn/" target="_blank">神马搜索</a>、<a href="https://zhanzhang.toutiao.com/"
                  target="_blank">头条搜索</a>。'
    ]
  ),
  'sitemap' => array(
    'content' => [
      '百度、360搜索及头条搜索均不支持sitemap通知，但可以手动提交sitemap。',
      '不同搜索引擎Sitemap提交教程：<a href="https://www.wbolt.com/submit-sitemap-url-to-baidu.html?utm_source=sst"
                        target="_blank">百度搜索资源平台</a>，<a
                        href="https://www.wbolt.com/how-to-add-a-sitemap-to-bing-webmaster.html?utm_source=sst"
                        target="_blank">Bing网站管理工具</a>，<a
                        href="https://www.wbolt.com/google-search-console.html#how-to-add-a-sitemap-in-google-search-console?utm_source=sst"
                        target="_blank">谷歌搜索控制台</a>，<a
                        href="https://www.wbolt.com/how-to-add-a-sitemap-to-360-zhanzhang.html?utm_source=sst"
                        target="_blank">360站长平台</a>及<a
                        href="https://www.wbolt.com/how-to-set-a-sitemap-linksubmit-for-toutiao.html?utm_source=sst"
                        target="_blank">头条搜索站长平台</a>',
      '为了提升推送效果，建议安装<a href="https://www.wbolt.com/plugins/bsl-pro?utm_source=sst"
                        target="_blank">搜索推送插件</a>，以多种方式同时提交URL至搜索引擎。',
      '一般不建议将独立页面、标签页及作者页列入Sitemap，站长需结合自身情况取舍。'
    ]
  ),
  'url-rewrite' => array(
    'content' => [
      '<a href="https://www.wbolt.com/internal-links-optimization.html?utm_source=sst"
              target="_blank">内部链接优化</a>是SEO重要组成部分，也是<a href="https://www.wbolt.com/linkbait.html?utm_source=sst"
              target="_blank">链接诱饵</a>一种方式。',
      '外部链接应该<a href="https://www.wbolt.com/what-is-nofollow.html?utm_source=sst"
              target="_blank">添加Nofollow属性</a>，防止页面权重分发其他站点。',
      '站长可以查阅SEO优化技巧之<a href="https://www.wbolt.com/seo-link-building-tips.html?utm_source=sst"
              target="_blank">网站链接建设</a>，并加以实践。'
    ]
  ),
  'url-monitor' => array(
    'content' => [
      '<a href="https://www.wbolt.com/guide-to-wp-404-pages.html?utm_source=sst"
                target="_blank">404响应码</a>不代表网站一定存在该链接，可能是安全扫描、爬虫等程序导致。',
      '为协助您更好地判断404错误，建议安装<a href="https://www.wbolt.com/plugins/spider-analyser?utm_source=sst"
                target="_blank">蜘蛛分析插件</a>。',
      '对于真实的404状态链接，可以安装<a href="https://www.wbolt.com/plugins/bsl-pro?utm_source=sst"
                target="_blank">搜索推送插件</a>生成404链接集URL，提交通知搜索引擎。'
    ]
  ),
  'url-broken' => array(
    'content' => [
      '部分异常链接可能是国内无法访问该站点导致，建议将此类域添加至排除域名列表。',
      '对应<a href="https://www.wbolt.com/wordpress-redirect.html?utm_source=sst"
              target="_blank">重定向链接</a>，建议将该URL修改为最终URL。',
      '部分服务器会拒绝系统检测访问，返回<a href="https://www.wbolt.com/how-to-fix-a-403-forbidden-error.html?utm_source=sst"
              target="_blank">403</a>或者<a
              href="https://www.wbolt.com/how-to-fix-a-403-forbidden-error.html?utm_source=sst"
              target="_blank">503</a>状态，此种情况无需理会。'
    ]
  ),
  'url-redirection' => array(
    'content' => [
        '基于安全原因，不支持跨域重定向。',
      '<a href="https://www.wbolt.com/wordpress-redirect.html?utm_source=sst"
      target="_blank">WordPress重定向最佳实践</a>能够最大化SEO和提升页面速度。',
      '关于301永久重定向或者302临时重定向，可以阅读<a href="https://www.wbolt.com/301-redirects.html?utm_source=sst"
      target="_blank">301重定向与SEO优化间的关系</a>和<a
      href="https://www.wbolt.com/301-or-302-redirects.html?utm_source=sst"
      target="_blank">基于SEO角度应选301还是302重定向</a>。',
      '
    如果大量链接规则变更，建议添加规则进行匹配重定向，比如分类news改为blog，则可以添加301重定向规则：<code>/news/(*) 重定向至 /blog/$1</code>。
  '
    ]
  ),
  'url-redirection-detail' => array(
    'content' => '部分异常链接可能是国内无法访问该站点导致，建议将此类域添加至排除域名列表；'
  ),
);
