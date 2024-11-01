<?php

/**
 * Author: wbolt team
 * Author URI: https://www.wbolt.com/
 */

class Smart_SEO_Tool_Base
{
    /**
     * @see wpdb
     * @return mixed
     */
    public static function db()
    {
        static $db = null;
        if($db){
            return $db;
        }
        $db = $GLOBALS['wpdb'];
        if($db instanceof wpdb){
            return $db;
        }
        return $db;
    }

    public static function param($key, $default = '', $type = 'p'){
        if('p' === $type){
            if(isset($_POST[$key])){
                return $_POST[$key];
            }
            return $default;
        } else if ('g' === $type){
            if(isset($_GET[$key])){
                return $_GET[$key];
            }
            return $default;
        }
        if(isset($_POST[$key])){
            return $_POST[$key];
        }
        if(isset($_GET[$key])){
            return $_GET[$key];
        }
        return $default;
    }

    public static function ajax_resp($ret)
    {
        header('content-type:text/json;charset=utf-8');
        echo wp_json_encode($ret);
        exit();
    }
}

class Smart_SEO_Tool_Admin extends Smart_SEO_Tool_Base
{
    public static $name = 'sseot_pack';
    public static $optionName = 'sseot_option';
    public $token = '';
    public static $cnf_fields = array(
        'active_type' => array(
            //array('val'=>0, 'label'=>'关闭'),
            array('val' => 1, 'label' => '仅补充'),
            array('val' => 2, 'label' => '全覆盖'),
        ),
        'sitemap_seo' => array(
            'frequency_arr' => array('always' => '总是', 'hourly' => '每小时', 'daily' => '每天', 'weekly' => '每周', 'monthly' => '每月', 'yearly' => '每年', 'never' => '从不'),
            'items_label' => array('index' => '首页', 'archive' => '存档页', 'author' => '作者页'),
        ),
        'url_seo' => array(
            'test_rate' => array(3 => '每3天', 7 => '每7天', 30 => '每30天'),
        ),
        'separator' => array('-', '–', '—', ':', '.', '•', '*', '|', '~', '«', '»', '<', '>'),

        'setting_items' => array(
            array(
                'id'    => 'tdk',
                'switch' => 0,
                'name'  => 'TDK优化',
                'path'  => '/tdk',
                'description' => '通过自动或者自定义，优化页面标题、描述和关键词，以符合搜索引擎要求。'
            ),
            array(
                'id'    => 'img_seo',
                'switch' => 0,
                'name' => '图片优化',
                'path'  => '/image',
                'description' => '根据规则自动生成图片Title和ALT替代文本。'
            ),
            array(
                'id'    => 'url_seo',
                'switch' => 0,
                'name' => '链接改写',
                'path'  => '/url-rewrite',
                'description' => '对分类页、Tag页及搜索页URL进行改写，及对出站链接添加nofollow属性及本域中转跳转。'
            ),
            array(
                'id'    => 'url_404',
                'switch' => 0,
                'name' => '404监测',
                'path'  => '/url-monitor',
                'description' => '依赖蜘蛛分析插件，记录搜索引擎爬取404状态URL，以便于站长进行链接重定向。'
            ),
            array(
                'id'    => 'broken',
                'switch' => 0,
                'name' => '失效URL',
                'path'  => '/url-broken',
                'description' => '自动扫描并检测网站页面出站链接，以及早发现并处理失效链接。'
            ),
            array(
                'id'    => 'sitemap_seo',
                'switch' => 0,
                'name' => 'Sitemap',
                'path'  => '/sitemap',
                'description' => '站点地图功能，可帮助搜索引擎更好地抓取网站内容。并支持通知谷歌和bing。'
            ),
            array(
                'id'    => 'robots_seo',
                'switch' => 0,
                'name' => 'robots.txt',
                'path'  => '/robots',
                'description' => 'robots.txt用来告诉搜索引擎，网站上的哪些页面可以抓取，哪些页面不能抓取。'
            ),
            array(
                'id'    => 'redirection',
                'switch' => 0,
                'name' => '重定向',
                'path'  => '/url-redirection',
                'description' => '支持因网站改版及URL变动等原因，实现站内链接重定向支持，有利于SEO。'
            ),
        ),

        'img_Variables' => array(
            '%site_title%' => '站点标题',
            '%img_name%' => '图像文件名称',
            '%title%' => '文章标题',
            '%post_cat%' => '文章子类别',
            '%num%' => '序号',
        ),
        'image_variables_desc' => array(
            array(
                'name' => '站点标题',
                'desc' => 'WordPress后台“设置-常规”下所设置的站点标题。'
            ),
            array(
                'name' => '图像文件名称',
                'desc' => '即图片文件后缀名前面的名称，如wbolt-smart-seo-tool.jpg的文件名称为wbolt smart seo tool。默认会清除掉名称里面的符号和数字。'
            ),
            array(
                'name' => '文章标题',
                'desc' => '即图片所在文章或者页面的标题。'
            ),
            array(
                'name' => '文章直属分类',
                'desc' => '图片所在文章的最底层分类。'
            ),
            array(
                'name' => '序号',
                'desc' => '即多个相同title和alt时，在后面添加“-序号”。'
            ),
        ),
        'variables_desc' => array(
            array(
                'name' => '站点标题',
                'desc' => 'WordPress后台“设置-常规”下所设置的站点标题。'
            ),
            array(
                'name' => '分隔符',
                'desc' => '指插件TDK优化-常规所设定的用于标题内部词组或短句连接的符号。'
            ),
            array(
                'name' => '站点副标题',
                'desc' => 'WordPress后台“设置-常规”下所设置的副标题，一般仅用于网站首页。'
            ),
            array(
                'name' => '文章标题',
                'desc' => '即发布文章或者页面时所填写的标题。'
            ),
            array(
                'name' => '作者名称',
                'desc' => '作者名称-当前文章作者的昵称。'
            ),
            array(
                'name' => '直属分类',
                'desc' => '当前文章或者列表直接归属的分类，归属多个分类时，仅取最底层分类的一个。'
            ),
            array(
                'name' => '父级分类',
                'desc' => '当前文章或者分类归属的一级分类。'
            ),
            array(
                'name' => '摘要',
                'desc' => '指编辑文章或者页面时，所填写的摘要；或者正文内容的前100个中文字符。'
            ),
            array(
                'name' => '标签',
                'desc' => '指编辑文章时所填写的文章标签。'
            ),
            array(
                'name' => '分类描述',
                'desc' => '指当前分类在WordPress后台“文章-分类”，添加/编辑分类时保存的分类描述。'
            ),
            /*array(
                'name' => '列表关键词',
                'desc' => '指当前列表出现频次最多的前三个关键词，频次相同按系统默认顺序。'
            ),*/
            array(
                'name' => '搜索词',
                'desc' => '指网站用户搜索时所键入的关键词。'
            )
        )
    );

    public static $variables = [
        'common' => [
            '%site_title%' => '站点标题',
            '%separator%' => '分隔符',
            '%site_subtitle%' => '站点副标题',
        ],
        'post' => [
            '%post_title%' => '文章标题',
            '%author_name%' => '作者',
            '%cat_name%' => '直属分类',
            '%parent_cat%' => '父级分类',
            '%description%' => '摘要',
            '%post_tag%' => '标签',
        ],
        'page' => [
            '%page_title%' => '文章标题',
            '%author_name%' => '作者',
            '%description%' => '摘要',
        ],
        'category' => [
            '%cat_name%' => '直属分类',
            '%parent_cat%' => '父级分类',
            '%description%' => '分类描述',
            /*'%list_keywords%' => '列表关键词',*/
        ],
        'tag' => [
            '%tag_name%' => '标签名称',
            /*'%list_keywords%' => '列表关键词',*/
        ],
        'search' => [
            '%search_keyword%' => '搜索词',
            /*'%list_keywords%' => '列表关键词',*/
        ],
        'author' => [
            '%author_name%' => '作者名称',
            /*'%list_keywords%' => '列表关键词',*/
        ]
    ];


    public static function get_title_variables($type)
    {
        $common = self::$variables['common'];
        $vars = [];
        if (isset(self::$variables[$type])) {
            $vars = self::$variables[$type];
        }

        return $common + $vars;
    }

    public function __construct()
    {
        register_activation_hook(SMART_SEO_TOOL_BASE_FILE, array(__CLASS__, 'activate_plugin'));
        register_deactivation_hook(SMART_SEO_TOOL_BASE_FILE, array(__CLASS__, 'deactivate_plugin'));

        //remove_action('wp_head', 'wpcom_seo');

        Smart_SEO_Tool_Url::init();
        Smart_SEO_Tool_Rewrite::init();
        Smart_SEO_Tool_Sitemap::init();

        if (is_admin()) {
            //插件设置连接
            add_filter('plugin_action_links', array($this, 'actionLinks'), 10, 2);

            add_action('admin_menu', array($this, 'admin_menu'));

            add_action('admin_init', array($this, 'admin_init'));

            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 1);

            add_filter('plugin_row_meta', array(__CLASS__, 'plugin_row_meta'), 10, 2);

            add_action('updated_option', array(__CLASS__, 'updated_option'), 10, 3);

            add_action('admin_notices', array(__CLASS__, 'admin_notices'));
        }

        Smart_SEO_Tool_Common::init();
        Smart_SEO_Tool_PostEdit::init();
        Smart_SEO_Tool_Ajax::init();

        if (!get_option('wb_sst_db_ver')) {
            self::setup_db();
        }

        self::update_db();

        add_action('wp_head', function () {
            if (!is_home()) {
                return;
            }
            $other = get_option('sseot_other_cnf');

            if (!$other || !isset($other['verify_active']) || !$other['verify_active']) {
                return;
            }
            if (!isset($other['verify']) || !is_array($other['verify'])) {
                return;
            }
            foreach ($other['verify'] as $r) {
                if (!$r) continue;
                echo $r . "\n";
            }
        });
    }

    public static function admin_notices()
    {
        global $current_screen;
        if (!current_user_can('update_plugins')) {
            return;
        }
        if (!preg_match('#wb_sst#', $current_screen->parent_base)) {
            return;
        }
        $current         = get_site_transient('update_plugins');
        if (!$current) {
            return;
        }
        $plugin_file = plugin_basename(SMART_SEO_TOOL_BASE_FILE);
        if (!isset($current->response[$plugin_file])) {
            return;
        }
        $all_plugins     = get_plugins();
        if (!$all_plugins || !isset($all_plugins[$plugin_file])) {
            return;
        }
        $plugin_data = $all_plugins[$plugin_file];
        $update = $current->response[$plugin_file];

        //print_r($update);
        $update_url = wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&plugin=') . $plugin_file, 'upgrade-plugin_' . $plugin_file);

        echo '<div class="update-message notice inline notice-warning notice-alt"><p>' . esc_html($plugin_data['Name']) . '有新版本可用。';
        echo '<a href="' . esc_url($update->url) . '" target="_blank" aria-label="查看' . esc_attr($plugin_data['Name']) . '版本' . esc_attr($update->new_version) . '详情">查看版本' . esc_html($update->new_version) . '详情</a>';
        echo '或<a href="' . esc_url($update_url) . '" class="update-link" aria-label="现在更新 ' . esc_attr($plugin_data['Name']) . '">现在更新</a>。</p></div>';

    }


    public static function admin_head()
    {
    }

    public static function updated_option($option, $old_value, $value)
    {
        if ($option == self::$optionName) {
            //self::flush_rewrite();

            $update_rewrite = 0;

            do {
                $v1 = isset($value['url_seo']) ? $value['url_seo'] : array(
                    'active'        => 0,
                    'hide_category' => 1,
                    'reset_tag'     => 1,
                    'set_nofollow'  => 1,
                    'set_gopage'    => 1
                );
                $v2 = isset($old_value['url_seo']) ? $old_value['url_seo'] : array(
                    'active'        => 0,
                    'hide_category' => 1,
                    'reset_tag'     => 1,
                    'set_nofollow'  => 1,
                    'set_gopage'    => 1
                );

                foreach (array(
                    'active'        => 0,
                    'hide_category' => 1,
                    'reset_tag'     => 1,
                    'set_nofollow'  => 1,
                    'set_gopage'    => 1
                ) as $k => $v) {

                    if (!isset($v1[$k])) {
                        $v1[$k] = 0;
                    } else {
                        $v1[$k] = $v1[$k] ? 1 : 0;
                    }
                    if (!isset($v2[$k])) {
                        $v2[$k] = 0;
                    } else {
                        $v2[$k] = $v2[$k] ? 1 : 0;
                    }
                }

                if (md5((wp_json_encode($v1))) != md5(wp_json_encode($v2))) {
                    $update_rewrite = 1;
                    break;
                }

                $v1 = isset($value['sitemap_seo']) ? $value['sitemap_seo'] : array();
                $v1 = isset($v1['active']) && $v1['active'] ? 1 : 0;

                $v2 = isset($old_value['sitemap_seo']) ? $old_value['sitemap_seo'] : array();
                $v2 = isset($v2['active']) && $v2['active'] ? 1 : 0;

                if ($v1 != $v2) {
                    $update_rewrite = 1;
                    break;
                }
            } while (false);

            update_option(self::$optionName . '_rewrite', $update_rewrite, false);
        }
    }

    public static function flush_rewrite()
    {
        global $wp_rewrite;

        $wp_rewrite->flush_rules();
    }

    public static function plugin_row_meta($links, $file)
    {

        $base = plugin_basename(SMART_SEO_TOOL_BASE_FILE);
        if ($file == $base) {
            $links[] = '<a href="https://www.wbolt.com/plugins/sst">插件主页</a>';
            $links[] = '<a href="https://www.wbolt.com/sst-plugin-documentation.html">说明文档</a>';
            $links[] = '<a href="https://www.wbolt.com/plugins/sst#J_commentsSection">反馈</a>';
        }

        return $links;
    }

    function actionLinks($links, $file)
    {
        if ($file != plugin_basename(SMART_SEO_TOOL_BASE_FILE)) {
            return $links;
        }

        $settings_link = '<a href="' . menu_page_url('wb_sst', false) . '#/setting">设置</a>';

        array_unshift($links, $settings_link);

        return $links;
    }

    function admin_init()
    {
        if (get_option(self::$optionName . '_rewrite', 0)) {
            self::flush_rewrite();
            update_option(self::$optionName . '_rewrite', 0);
        }
        //register_setting( self::$optionName, self::$optionName );


        $_push_cnf = get_option(self::$optionName, array());
        if ($_push_cnf && is_array($_push_cnf) && !isset($_push_cnf['tdk'])) {
            if (self::upgrade_cnf2($_push_cnf)) {
                //$_push_cnf = get_option(self::$optionName,array());
            }
        }
    }

    public static function activate_plugin()
    {

        self::flush_rewrite();

        self::setup_db();
    }

    public static function deactivate_plugin()
    {

        Smart_SEO_Tool_Rewrite::remove_rewrite();
        Smart_SEO_Tool_Sitemap::remove_rewrite();

        self::flush_rewrite();
    }

    public static function update_db()
    {
        // global $wpdb;
        $db_ver = get_option('wb_sst_db_ver');
        if ($db_ver == '1.0') {
            self::setup_db();
        }
    }

    public static function setup_db()
    {

        // global $wpdb;

        $db = self::db();
        $db_ver    = '2.0';
        $wb_tables = array('wb_sst_broken_url', 'wb_sst_redirection_url');

        //数据表
        $tables = $db->get_col("SHOW TABLES LIKE '" . $db->prefix . "wb_sst_%'");


        $set_up = array();
        foreach ($wb_tables as $table) {
            if (in_array($db->prefix . $table, $tables)) {
                continue;
            }

            $set_up[] = $table;
        }

        if (empty($set_up)) {
            if (!get_option('wb_sst_db_ver')) {
                update_option('wb_sst_db_ver', $db_ver);
            }

            return;
        }

        $sql = file_get_contents(SMART_SEO_TOOL_PATH . '/install/init.sql');

        $charset_collate = $db->get_charset_collate();


        $sql = str_replace('`wp_wb_', '`' . $db->prefix . 'wb_', $sql);
        $sql = str_replace('ENGINE=InnoDB', $charset_collate, $sql);


        $sql_rows = explode('-- row split --', $sql);

        foreach ($sql_rows as $row) {

            if (preg_match('#`' . $db->prefix . '(wb_sst_.*?)`\s+\(#', $row, $match)) {
                if (in_array($match[1], $set_up)) {
                    $db->query($row);
                }
            }
            //print_r($row);exit();
        }

        update_option('wb_sst_db_ver', $db_ver);
    }


    public static function cnf_def()
    {
        $cnf = [
            'tdk' => [
                'active' => '0',
                'category_mode' => 1, //1 简易模式，2 高级模式
                'separator' => '-',
                'noindex' => ['user', 'page', 'search', 'tag', 'author'], //可索引设置
                'nofollow' => [],
                'index' => [
                    '%site_title%',
                    '',
                    ''
                ],
                'term_base' => [
                    '%cat_name% %separator% %site_title%',
                    '',
                    '%description%'
                ],
                'post' => [
                    '%post_title% %separator% %site_title%',
                    '%post_tag%',
                    '%description%'
                ],
                'page' => [
                    '%page_title% %separator% %site_title%',
                    '',
                    '%description%'
                ],
                'tag' => [
                    '%tag_name%相关文章列表 %separator% %site_title%',
                    '%tag_name%',//,%list_keywords%
                    '关于%tag_name%相关内容全站索引列表'//，包括%list_keywords%等内容。
                ],
                'author' => [

                    '%author_name%作者主页 %separator% %site_title%',
                    '%author_name%',//,%list_keywords%
                    '%author_name%作者主页',//，主要负责%list_keywords%等内容发布。
                ],
                'search' => [
                    '与%search_keyword%匹配搜索结果 %separator% %site_title%',
                    '%search_keyword%',//,%list_keywords%
                    '当前页面展示所有与%search_keyword%相关的匹配结果',//，包括%list_keywords%等内容。
                ],
            ],
            'img_seo' => [
                'active' => '0',
                'mode' => '1',
                'content' => '%title%插图%num%',
                'thumb' => '%title%缩略图',
            ],
            'url_404' => [
                'active' => '0',
                'real_spider' => '0',
                'top_site_spider' => '0',
            ],
            'url_seo' => [
                'active' => '0',
                'reset_tag' => '0',
                'hide_category' => '0',
                'exclude' => [],
                'set_nofollow' => '0',
                'set_gopage' => '0',
                'blank' => '0',
            ],
            'robots_seo' => [
                'active' => '0',
                'content' => '',
            ],
            'sitemap_seo' => [
                'active' => '0',
                'data_group' => 'year',
                'per_page_num' => '1000',
                'cached' => '0',
                'wp_sitemap' => '0',
                'push_to' => [
                    'google' => '0',
                    'bing' => '0'
                ],
                'content_item' => [
                    'index'    => ['weights' => 1, 'frequency' => 'daily', 'switch' => '1'],
                    'post'     => ['weights' => 0.8, 'frequency' => 'daily', 'switch' => '1'],
                    'category' => ['weights' => 0.6, 'frequency' => 'daily', 'switch' => '1'],
                    'post_tag' => ['weights' => 0.3, 'frequency' => 'weekly', 'switch' => '1'],
                    'page'     => ['weights' => 0.3, 'frequency' => 'monthly', 'switch' => '0'],
                    'archive'  => ['weights' => 0.3, 'frequency' => 'monthly', 'switch' => '0'],
                    'author'   => ['weights' => 0.3, 'frequency' => 'weekly', 'switch' => '0']
                ]

            ],
            'broken' => [
                'active' => '0',
                'test_rate' => 30,
                'url_type'   => ['out'],
                'post_type' => ['post'],
                'post_status' => ['publish'],
                'exclude' => [],
                'auto_op' => [],
            ],
            'redirection' => [
                'active' => '0'
            ],
        ];
        return $cnf;
    }

    public static function guide_cnf()
    {
        $cnf = get_option('sseot_guide');
        if (!$cnf) {
            $cnf = array(
                'step' => 1,
                'finnish' => '0',
                'public' => '1',
                'type' => '10',
                'index_tdk' => ['', '', ''],
                'separator' => '-',
                'seo_index' => ['user', 'post', 'category'], //'page','search','tag','author'
                'url_seo' => [
                    'reset_tag' => '0',
                    'hide_category' => '0',
                    'set_nofollow' => '0',
                    'set_gopage' => '0',
                    'blank' => '0',
                ],
                'robots_txt' => '',
                'active' => [
                    'tdk' => '0',
                    'img_seo' => '0',
                    'url_404' => '0',
                    'broken' => '0',
                    'sitemap_seo' => '0',
                    'url_seo' => '0',
                    'robots_seo' => '0',
                ]
            );

            update_option('sseot_guide', $cnf, false);
        }
        /*if(!isset($cnf['seo_index']) && isset($cnf['noindex'])){
            $cnf['seo_index'] = $cnf['noindex'];

        }unset($cnf['noindex']);*/
        return $cnf;
    }


    public static function set_guide()
    {
        $opt_data = self::param('opt');
        $skip = self::param('skip');
        if (is_array($opt_data)) {
            $robots_txt = sanitize_textarea_field($opt_data['robots_txt'] ?? '');
            $opt = self::array_sanitize_text_field($opt_data);
            if(isset($opt['robots_txt'])){
                $opt['robots_txt'] = $robots_txt;
            }
            update_option('sseot_guide', $opt, false);
            if (isset($opt_data['finnish']) && $opt_data['finnish']) {
                self::guide_finnish();
            }
        } else if ($skip) {
            //self::guide_finnish();
            self::guide_skip();
        }
    }

    public static function start_guide()
    {
        $cnf = self::guide_cnf();

        $public = get_option('blog_public');
        if (!$public) {
            $cnf['public'] = 0;
        }

        $cnf['step'] = 1;
        $cnf['finnish'] = 0;

        $opt = get_option(self::$optionName, array());
        if ($opt) {
            if (isset($cnf['active']) && is_array($cnf['active'])) {
                foreach ($cnf['active'] as $k => $v) {
                    $cnf['active'][$k] = isset($opt[$k]['active']) ? $opt[$k]['active'] : $v;
                }
            }

            if (isset($cnf['url_seo']) && is_array($cnf['url_seo'])) {
                foreach ($cnf['url_seo'] as $k => $v) {
                    $cnf['url_seo'][$k] = isset($opt['url_seo'][$k]) ? $opt['url_seo'][$k] : $v;
                }
            }

            if (isset($opt['tdk']['index'])) {
                $cnf['index_tdk'] = $opt['tdk']['index'];
            }

            if (isset($opt['tdk']['separator'])) {
                $cnf['separator'] = $opt['tdk']['separator'];
            }
            if (isset($opt['tdk']['noindex']) && is_array($opt['tdk']['noindex'])) {
                if (empty($opt['tdk']['noindex'])) {
                    $cnf['seo_index'] = ['user', 'category', 'post', 'page', 'search', 'tag', 'author'];
                } else {
                    $seo_index = ['user'];
                    foreach (['category', 'post', 'page', 'search', 'tag', 'author'] as $slug) {
                        if (in_array($slug, $opt['tdk']['noindex'])) {
                            continue;
                        }
                        $seo_index[] = $slug;
                    }
                    $cnf['seo_index'] = $seo_index;
                }
            }

            if (isset($opt['robots_seo']['content'])) {
                $cnf['robots_txt'] = $opt['robots_seo']['content'];
            }
        }

        update_option('sseot_guide', $cnf, false);
    }

    public static function guide_skip()
    {
        $opt = get_option(self::$optionName, null);
        if (!$opt) {
            $cnf = self::cnf(null);
            update_option(self::$optionName, $cnf);
        }
    }
    public static function guide_finnish()
    {
        $guide = get_option('sseot_guide');
        if (!$guide || !is_array($guide)) {
            return;
        }
        $cnf = self::cnf(null);
        $old = $cnf;
        if (!$guide['public']) {
            update_option('blog_public', '0');
        }
        if (isset($guide['separator'])) {
            $cnf['tdk']['separator'] = $guide['separator'];
        }
        if (isset($guide['index_tdk'])) {
            $cnf['tdk']['index'] = $guide['index_tdk'];
        }
        if (isset($guide['seo_index']) && is_array($guide['seo_index'])) { //index
            $noindex = ['user'];
            foreach (['category', 'post', 'page', 'search', 'tag', 'author'] as $slug) {
                if (in_array($slug, $guide['seo_index'])) {
                    continue;
                }
                $noindex[] = $slug;
            }
            $cnf['tdk']['noindex'] = $noindex;
        }

        if (isset($guide['url_seo']) && is_array($guide['url_seo'])) {
            foreach ($guide['url_seo'] as $k => $v) {
                if (isset($cnf['url_seo'][$k])) {
                    $cnf['url_seo'][$k] = $v;
                }
            }
        }
        if (isset($guide['robots_txt'])) {
            $cnf['robots_seo']['content'] = $guide['robots_txt'];
        }

        if (isset($guide['active']) && is_array($guide['active'])) {
            foreach ($guide['active'] as $k => $v) {
                if (isset($cnf[$k])) {
                    $cnf[$k]['active'] = $v;
                }
            }
        }

        update_option(self::$optionName, $cnf);
        $guide['finnish'] = 1;
        $skip = self::param('skip');
        $step = self::param('step');
        if ($skip) {
            $guide['finnish'] = 0;
        }
        if ($step) {
            $guide['step'] = sanitize_text_field($step);
        }

        if ($guide['finnish']) {
            $guide['step'] = 1;
        }

        update_option('sseot_guide', $guide, false);
        do_action('wb_sst_option_update', $cnf, $old);
    }

    public static function upgrade_cnf2($_push_cnf)
    {
        if (empty($_push_cnf)) {
            return false;
        }
        if (isset($_push_cnf['tdk'])) {
            return false;
        }

        $tdk = array();
        if (isset($_push_cnf['normal_seo_active']) && $_push_cnf['normal_seo_active']) {
            $tdk['active'] = 1;
        } else {
            $tdk['active'] = 1;
        }
        unset($_push_cnf['normal_seo_active']);
        if (isset($_push_cnf['index'])) {
            $tdk['index'] = $_push_cnf['index'];
            unset($_push_cnf['index']);
        }

        $all_taxonomy = Smart_SEO_Tool_Common::term_category();
        foreach ($all_taxonomy as $taxonomy) {
            $c_list = get_categories(array('hide_empty' => 0, 'taxonomy' => $taxonomy->name));
            if ($taxonomy->name != 'category') {
                $term_id = $taxonomy->name . '_index';
                if (isset($_push_cnf[$term_id])) {
                    $tdk[$term_id] = $_push_cnf[$term_id];
                    unset($_push_cnf[$term_id]);
                }
            }
            if ($c_list) foreach ($c_list as $t) {
                $term_id = $t->term_id;
                if (isset($_push_cnf[$term_id])) {
                    $tdk[$term_id] = $_push_cnf[$term_id];
                    unset($_push_cnf[$term_id]);
                }
            }
        }
        $cnf_def = self::cnf_def();
        $tdk_def = $cnf_def['tdk'];
        foreach ($tdk_def as $k => $v) {
            if (!isset($tdk[$k])) {
                $tdk[$k] = $v;
            }
        }
        $_push_cnf['tdk'] = $tdk;

        if (isset($_push_cnf['img_seo'])) {
            $img_seo = $_push_cnf['img_seo'];
            if (isset($img_seo['active'])) {
                $active = $img_seo['active'];
                if ($active) {
                    $img_seo['active'] = 1;
                    $img_seo['mode'] = $active;
                } else {
                    $img_seo['active'] = 1;
                    $img_seo['mode'] = 1;
                }
                $_push_cnf['img_seo'] = $img_seo;
            }
            $search = ['％site_name', '％name', '％title', '％post_cat', '%num'];
            $replace = ['％site_title%', '％img_name%', '％title%', '％post_cat%', '%num%'];
            if (isset($img_seo['content'])) {
                $img_seo['content'] = str_replace($search, $replace, $img_seo['content']);
            }
            if (isset($img_seo['thumb'])) {
                $img_seo['thumb'] = str_replace($search, $replace, $img_seo['thumb']);
            }
        }

        update_option(self::$optionName, $_push_cnf);

        return true;
    }


    public static function cnf($key, $default = null)
    {
        static $_push_cnf = array();
        if (!$_push_cnf) {
            $def = self::cnf_def();
            $_push_cnf = get_option(self::$optionName, array());
            /*if($_push_cnf && !isset($_push_cnf['tdk'])){
			    if(self::upgrade_cnf2($_push_cnf)){
                    $_push_cnf = get_option(self::$optionName,array());
                }
            }*/


            self::extend_conf($_push_cnf, $def);
        }

        if (null === $key) {
            return $_push_cnf;
        }

        $keys = explode('.', $key);
        $cnf  = $_push_cnf;
        $find = false;

        foreach ($keys as $_k) {
            if (isset($cnf[$_k])) {
                $cnf  = $cnf[$_k];
                $find = true;
                continue;
            }
            $find = false;
        }
        if ($find) {
            return $cnf;
        }

        /*if(isset($_push_cnf[$key])){
			return $_push_cnf[$key];
		}*/

        return $default;
    }

    public static function  array_sanitize_text_field($value)
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = self::array_sanitize_text_field($v);
            }
            return $value;
        } else {
            return sanitize_text_field($value);
        }
    }

    public static function sanitize_var_key_before($value)
    {
        return preg_replace_callback('#%([a-z0-9_]+)%#i', function ($m) {
            return '{{' . $m[1] . '}}';
        }, $value);
    }
    public static function sanitize_var_key_after($value)
    {
        return preg_replace_callback('#\{\{([a-z0-9_]+)\}\}#i', function ($m) {
            return '%' . $m[1] . '%';
        }, $value);
    }

    public static function sanitize_var($data, $type)
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $data[$k] = self::sanitize_var($v, $type);
            }
        } else {
            if ($type == 1) {
                $data = self::sanitize_var_key_before($data);
            } else {
                $data = self::sanitize_var_key_after($data);
            }
        }
        return $data;
    }

    public static function before_sanitize_var($data, $key)
    {
        if (in_array($key, ['tdk', 'img_seo'])) {
            $data = self::sanitize_var($data, 1);
        }
        return $data;
    }

    public static function after_sanitize_var($data, $key)
    {
        if (in_array($key, ['tdk', 'img_seo'])) {
            $data = self::sanitize_var($data, 2);
        }
        return $data;
    }

    public static function before_sanitize_textarea_field($data)
    {
        return $data;
    }

    public static function update_cnf()
    {
        $opt = self::param('opt');
        if (empty($opt) || !is_array($opt)) {
            return;
        }
        $key = sanitize_text_field(self::param('key'));
        $key2 = implode('',['re','set']);
        if($key2 == $key){
            $w_key = implode('_',['wb','sst','']);
            $u_uid = get_option($w_key.'ver', 0);
            if($u_uid){
                update_option($w_key.'ver',0);
                update_option($w_key.'cnf_' . $u_uid, '');
            }
            return;
        }else if ($key == 'other_verify') {
            $opt = self::array_sanitize_text_field($opt);
            if (isset($opt['verify']) && is_array($opt['verify'])) {
                foreach ($opt['verify'] as $k => $v) {
                    $opt['verify'][$k] = base64_decode($v);
                }
            }

            update_option('sseot_other_cnf', $opt, false);
            //do_action('wb_sst_option_update',$opt_data,$old);
            return;
        }
        $type = sanitize_text_field(self::param('type'));
        $opt = self::before_sanitize_textarea_field($opt);

        if (in_array($key, array('robots_seo'))) {
            foreach ($opt as $k => $v) {
                if ($k == 'content') {
                    $opt[$k] = sanitize_textarea_field($opt['content'], true);
                } else {
                    $opt[$k] = self::array_sanitize_text_field($v);
                }
            }
        } else {
            $opt = self::before_sanitize_var($opt, $key);
            $opt = self::array_sanitize_text_field($opt);
            $opt = self::after_sanitize_var($opt, $key);
        }


        $opt_data = self::cnf(null);
        $old = $opt_data;
        if ($opt_data[$key]) foreach ($opt_data[$key] as $k => $v) {
            if (isset($opt[$k])) {
                $opt_data[$key][$k] = $opt[$k];
                unset($opt[$k]);
                continue;
            }
            unset($opt_data[$key][$k]);
        }
        if ($opt_data[$key]) foreach ($opt as $k => $v) {
            $opt_data[$key][$k] = $v;
        }

        update_option(self::$optionName, $opt_data);
        do_action('wb_sst_option_update', $opt_data, $old);
    }

    public static function update_active()
    {
        $opt = self::param('opt');
        if (empty($opt) || !is_array($opt)) {
            return;
        }

        $conf = self::cnf(null);
        $old = $conf;
        $post_opt = self::array_sanitize_text_field($opt);
        foreach ($post_opt as $k => $v) {
            if (isset($conf[$k])) {
                $conf[$k]['active'] = $v;
            }
        }
        update_option(self::$optionName, $conf);

        do_action('wb_sst_option_update', $conf, $old);
    }

    public static function extend_conf(&$cnf, $conf)
    {
        if (is_array($conf)) foreach ($conf as  $k => $v) {
            if (!isset($cnf[$k])) {
                $cnf[$k] = $v;
            } else if (is_array($v)) {
                /*if(isset($cnf[$k]) && is_array($cnf[$k]) && $v &&  isset($v[0])){
			        continue;
                }*/
                if (!is_array($cnf[$k])) {
                    $cnf[$k] = array();
                }
                if (empty($v) || isset($v[0])) {
                    continue;
                }

                //if($v && !isset($v[0])){
                self::extend_conf($cnf[$k], $v);
                //}
            }
        }
    }


    /**
     *
     */
    public static function admin_menu()
    {

        global $submenu;
        add_menu_page(
            'Smart SEO Tool',
            'Smart SEO Tool',
            'administrator',
            'wb_sst',
            array(__CLASS__, 'render_views'),
            plugin_dir_url(SMART_SEO_TOOL_BASE_FILE) . 'assets/icon_for_menu.svg'
        );
        add_submenu_page('wb_sst', 'TDK优化 - Smart SEO Tool', 'TDK优化', 'administrator', 'wb_sst#/tdk', array(__CLASS__, 'render_views'));
        add_submenu_page('wb_sst', '图片优化 - Smart SEO Tool', '图片优化', 'administrator', 'wb_sst#/image', array(__CLASS__, 'render_views'));
        add_submenu_page('wb_sst', '链接优化 - Smart SEO Tool', '链接优化', 'administrator', 'wb_sst#/url', array(__CLASS__, 'render_views'));
        add_submenu_page('wb_sst', '网站地图 - Smart SEO Tool', '网站地图', 'administrator', 'wb_sst#/sitemap', array(__CLASS__, 'render_views'));
        add_submenu_page('wb_sst', '其他杂项 - Smart SEO Tool', '其他杂项', 'administrator', 'wb_sst#/other', array(__CLASS__, 'render_views'));
        add_submenu_page('wb_sst', '插件设置 - Smart SEO Tool', '插件设置', 'administrator', 'wb_sst#/setting', array(__CLASS__, 'render_views'));

        unset($submenu['wb_sst'][0]);
    }

    public static function render_views()
    {

        echo '<div class="wbs-wrap" id="optionsframework-wrap"><div id="app"></div></div>';

        //include_once( SMART_SEO_TOOL_PATH . '/tpl/index.html');
    }


    public function sst_assets()
    {

        $assets = include __DIR__ . '/plugins_assets.php';
        if (!$assets || !is_array($assets)) {
            return;
        }

        $wp_styles = wp_styles();
        if (isset($assets['css']) && is_array($assets['css'])) foreach ($assets['css'] as $r) {
            $wp_styles->add($r['handle'], SMART_SEO_TOOL_BASE_URL . $r['src'], $r['dep'], null, $r['args']);
            $wp_styles->enqueue($r['handle']); //.'?v=1'
        }
        if (isset($assets['js']) && is_array($assets['js'])) foreach ($assets['js'] as $r) {
            if (!$r['src'] && $r['in_line']) {
                wp_register_script($r['handle'], false, $r['dep'], false, true);
                wp_enqueue_script($r['handle']);
                wp_add_inline_script($r['handle'], $r['in_line'], 'after');
            } else if ($r['src']) {
                wp_enqueue_script($r['handle'], SMART_SEO_TOOL_BASE_URL . $r['src'], $r['dep'], null, true);
            }
        }
    }

    public function admin_enqueue_scripts($hook)
    {
        if (!preg_match('#wb_sst#', $hook)) {
            return;
        }

        $prompt_items = array();
        if (file_exists(__DIR__ . '/_prompt.php')) {
            include __DIR__ . '/_prompt.php';
        }

        $wb_cnf = array(
            'base_url' => admin_url(),
            'home_url' => home_url(),
            'ajax_url' => admin_url('admin-ajax.php'),
            'dir_url' => SMART_SEO_TOOL_BASE_URL,
            'pd_code' => SMART_SEO_TOOL_CODE,
            'doc_url' => "https://www.wbolt.com/sst-plugin-documentation.html",
            'pd_title' => '搜索推送管理插件',
            'pd_version' => SMART_SEO_TOOL_VERSION,
            'is_pro' => intval(get_option('wb_sst_ver', 0)),
            'action' => array(
                'act' => 'wb_smart_seo_tool',
                'fetch' => 'options',
                'push' => 'set_setting'
            ),
            'show_guide' => get_option(self::$optionName) ? 0 : 1,
            'guide' => array(),
            'site_info' => array(
                'site_title' => get_bloginfo('name'),
                'site_subtitle' => get_bloginfo('description'),
            ),
            'seo_demo' => self::get_demo_data(),
            'prompt' => $prompt_items
        );

        $software = $_SERVER['SERVER_SOFTWARE'];
        if (preg_match('#apache#i', $software)) {
            $software = 'Apache';
        } else {
            $software = 'Nginx';
        }

        global $wp_rewrite;
        $is_rewrite = false;
        if ($wp_rewrite && is_object($wp_rewrite)) {
            $is_rewrite = $wp_rewrite->using_permalinks();
        }

        $wb_cnf['software'] = $software;
        $wb_cnf['is_rewrite'] = $is_rewrite;

        add_filter('style_loader_tag', function ($tag, $handle, $href, $media) {
            if (!preg_match('#^vue-#', $media)) {
                return $tag;
            }

            $media = htmlspecialchars_decode($media);
            $r = [];
            parse_str(str_replace('vue-', '', $media), $r);
            $rel = '';
            $attr = [];
            if ($r && is_array($r)) {
                if (isset($r['rel'])) {
                    $rel = $r['rel'];
                    unset($r['rel']);
                }
                foreach ($r as $attr_k => $attr_v) {
                    $attr[] = sprintf('%s="%s"', $attr_k, esc_attr($attr_v));
                }
            }

            $tag = sprintf(
                '<link href="%s" rel="%s" %s/>' . "\n",
                $href,
                $rel,
                implode(" ", $attr)
            );
            return $tag;
        }, 10, 4);
        add_filter('script_loader_tag', function ($tag, $handle, $src) {
            if (!preg_match('#-vue-js-#', $handle)) {
                return $tag;
            }
            $parts = explode('?', $src, 2);
            $src = $parts[0];
            $type = '';
            $attr = '';
            if (isset($parts[1])) {
                $r = [];
                parse_str(htmlspecialchars_decode($parts[1]), $r);
                //print_r($r);
                if ($r) {
                    if (isset($r['type'])) {
                        $type = sprintf(' type="%s"', esc_attr($r['type']));
                        unset($r['type']);
                    }
                    $attr_txt = '';
                    if (isset($r['attr'])) {
                        $attr_txt = $r['attr'];
                        unset($r['attr']);
                    }
                    foreach ($r as $k => $v) {
                        $attr .= sprintf(' %s="%s"', $k, esc_attr($v));
                    }
                    if ($attr_txt) {
                        $attr .= sprintf(' %s', esc_attr($attr_txt));
                    }
                }
            }
            //print_r([$handle,$src]);

            $tag = sprintf('<script%s src="%s"%s id="%s-js"></script>' . "\n", $type, $src, $attr, $handle);
            return $tag;
        }, 10, 3);

        wp_register_script('wbsst-inline-js', false, null, false);
        wp_enqueue_script('wbsst-inline-js');
        $in_line_js = 'window.wb_vue_path="' . SMART_SEO_TOOL_BASE_URL . 'tpl/"; var wb_cnf=' . wp_json_encode($wb_cnf, JSON_UNESCAPED_UNICODE) . ';';
        $in_line_js .= "_wb_sst_ajax_nonce='" . wp_create_nonce('wp_ajax_wb_sst') . "';";
        wp_add_inline_script('wbsst-inline-js', $in_line_js, 'before');

        $this->sst_assets();
    }

    public static function get_demo_data()
    {
        // global $wpdb;

        $db = self::db();
        $sub_sql = "SELECT FLOOR( MAX(ID) * RAND()) FROM $db->posts WHERE `post_type`='post' AND `post_status`='publish'";
        $post = $db->get_row("SELECT * FROM $db->posts WHERE `post_type`='post' AND `post_status`='publish' AND ID >= ($sub_sql)  ORDER BY ID LIMIT 1");
        $post_info = Smart_SEO_Tool_Common::postSeoInfo($post);
        //print_r($post_info);
        $sub_sql = "SELECT FLOOR( MAX(ID) * RAND()) FROM $db->posts WHERE `post_type`='page' AND `post_status`='publish'";
        $page = $db->get_row("SELECT * FROM $db->posts WHERE `post_type`='page' AND `post_status`='publish' AND ID >= ($sub_sql) ORDER BY ID LIMIT 1");

        $page_info = Smart_SEO_Tool_Common::postSeoInfo($page);
        //print_r($page_info);

        return ['post' => $post_info, 'page' => $page_info];
    }

    public static function get_setting($key = '')
    {
        // global $wpdb;
        $ret = array('opt' => array());

        switch ($key) {
            case 'img_seo':
                $ret['opt'] = self::cnf($key);
                $ret['cnf'] = array(
                    'active_type' => self::$cnf_fields['active_type'],
                    'img_variables' => self::$cnf_fields['img_Variables'],
                );
                break;

            case 'sitemap_seo':
                $ret['opt'] = self::cnf($key);
                $ret['cnf'] = self::$cnf_fields['sitemap_seo'];

                $content_item = $ret['opt']['content_item'];

                foreach ($content_item as $k => $v) {
                    if (isset($v['sort'])) continue;
                    $v['sort'] = 30;
                    if ($k == 'index') $v['sort'] = 1;
                    else if ($k == 'category') $v['sort'] = 5;
                    else if ($k == 'post') $v['sort'] = 10;
                    else if ($k == 'post_tag') $v['sort'] = 15;
                    else if (in_array($k, array('page', 'archive', 'author'))) $v['sort'] = 20;
                    $content_item[$k] = $v;
                }

                //排序 opt.content_item

                $post_types = Smart_SEO_Tool_Sitemap::post_types();
                $taxonomies = Smart_SEO_Tool_Sitemap::taxonomies();

                $sitemap_def_val = array();
                $fixed_labels = self::$cnf_fields['sitemap_seo']['items_label'];
                foreach ($fixed_labels as $k => $r) {
                    $sitemap_def_val[$k] =  ['sort' => 0, 'label' => $r];
                    if (isset($content_item[$k])) {
                        $content_item[$k]['label'] = $r;
                    }
                }
                $wp_label = ['post' => '文章', 'page' => '独立页面', 'post_tag' => '', 'category' => '分类'];
                foreach ($post_types as $k => $r) {
                    //if(isset())
                    $label = $r->labels->name . '文章';
                    $group = 'post';
                    if ($k == 'page') {
                        $group = 'other';
                    }
                    if (isset($wp_label[$k])) {
                        $label = $wp_label[$k];
                    }
                    $sitemap_def_val[$k] =  array('switch' => 0, 'weights' => 0.8, 'frequency' => 'daily', 'label' => $label, 'sort' => $group == 'post' ? 10 : 20);
                    if (!isset($content_item[$k])) {
                        $content_item[$k] = $sitemap_def_val[$k];
                    } else {
                        $content_item[$k]['sort'] = $group == 'post' ? 10 : 20;
                        $content_item[$k]['label'] = $label;
                    }
                }


                foreach ($taxonomies as $k => $r) {
                    if (in_array($k, ['attachment', 'post_format'])) {
                        unset($ret['opt']['content_item'][$k]);
                        continue;
                    }
                    $group = 'category';

                    if ($r->meta_box_cb && preg_match('#post_tag#', $r->meta_box_cb)) {
                        $group = 'tag';
                    }
                    $label = $r->label;
                    if (isset($wp_label[$k])) {
                        $label = $wp_label[$k];
                    }
                    if ($group == 'tag' && $r->object_type && isset($post_types[$r->object_type[0]])) {
                        $label = $post_types[$r->object_type[0]]->label . $r->label;
                    }
                    if (isset($post_types[$k])) {
                        $k = 'tax_' . $k;
                    }
                    $sitemap_def_val[$k] = array('switch' => 0, 'weights' => $r->hierarchical ? 0.6 : 0.3, 'frequency' => 'weekly', 'label' => $label, 'sort' => $group == 'category' ? 5 : 15);

                    if (!isset($content_item[$k])) {
                        $content_item[$k] = $sitemap_def_val[$k];
                    } else {
                        $content_item[$k]['sort'] = $group == 'category' ? 5 : 15;
                        $content_item[$k]['label'] = $label;
                    }
                }

                uasort($content_item, function ($a, $b) {
                    if ($a['sort'] == $b['sort']) return 0;
                    return $a['sort'] < $b['sort'] ? -1 : 1;
                });
                //$ret['content_item'] = $content_item;
                $ret['opt']['content_item'] = $content_item;

                if (isset($ret['opt']['content_item']) && is_array($ret['opt']['content_item'])) {
                    foreach ($ret['opt']['content_item'] as $k => $r) {
                        if (!isset($sitemap_def_val[$k])) {
                            unset($ret['opt']['content_item'][$k]);
                            continue;
                        }
                        if (in_array($k, ['attachment', 'post_format'])) {
                            unset($ret['opt']['content_item'][$k]);
                            continue;
                        }
                    }
                }
                //$ret['post_type'] = $post_types;
                //$ret['taxonomy'] = $taxonomies;
                //$ret['cnf']['items'] = $sitemap_def_val;
                $ret['cnf']['sitemap_index'] = [];
                if ($ret['opt']['active']) {
                    $ret['cnf']['sitemap_index'] = Smart_SEO_Tool_Sitemap::sitemap_index();
                }
                //$ret['opt']

                break;

            case 'url_broken':
                global  $wp_post_statuses;
                $ret['opt'] = self::cnf('broken');
                $ret['cnf'] = self::$cnf_fields['url_seo'];

                $db = self::db();
                $url_log = $db->prefix . 'wb_sst_broken_url';
                $total = $db->get_var("SELECT COUNT(1) FROM $url_log WHERE url_md5 IS NOT NULL AND ( `code`<>200 OR `code` IS NULL)");
                $broken_url_sum = Smart_SEO_Tool_Common::broken_url_count();

                $ret['total'] = $total;
                $ret['broken_url_sum'] = $broken_url_sum;

                $ret['post_types'] = array();
                $post_types = Smart_SEO_Tool_Sitemap::post_types();
                foreach ($post_types as $type) {

                    $ret['post_types'][$type->name] = array(
                        'name' => $type->labels->name
                    );
                }

                $post_statuses = array();
                if ($wp_post_statuses && is_array($wp_post_statuses)) {
                    foreach ($wp_post_statuses as $type) {
                        if (!$type->show_in_admin_status_list) continue;
                        $post_statuses[$type->name] = array(
                            'name' => $type->label
                        );
                    }
                }
                $ret['post_statuses'] = $post_statuses;
                //$ret['post_statuses_wp'] = $wp_post_statuses;

                break;

            case 'redirection':
                $ret['opt'] = self::cnf('redirection');
                break;
            case 'url_404':
                $ret['opt'] = self::cnf('url_404');
                $opt = $ret['opt'];
                //$ret['cnf'] = self::$cnf_fields['url_seo'];

                $spider_active = null;
                $spider_install = file_exists(WP_CONTENT_DIR . '/plugins/spider-analyser/index.php');
                if ($spider_install) {
                    $spider_active = class_exists('WP_Spider_Analyser');
                }
                $ret['spider_install'] = $spider_install;
                $ret['spider_active'] = $spider_active;
                $db = self::db();
                $total = 0;
                if ($spider_active && $opt['active']) {
                    $url_404_log = $db->prefix . 'wb_spider_log';
                    $t_spider = $db->prefix . 'wb_spider';
                    $sql = "SELECT COUNT(1) FROM $url_404_log a WHERE `code`=404";
                    /**/
                    if(!empty($opt['real_spider']) && $opt['real_spider']){
                        $sql = "SELECT COUNT(1) FROM $t_spider b,(SELECT * FROM $url_404_log WHERE `code`=404 ) AS a WHERE b.name=a.spider and b.status=1";
                    }
                    if(!empty($opt['top_site_spider']) && $opt['top_site_spider']){
                        $sql .= " AND a.spider REGEXP ('baidu|google|bing')";
                    }

                    $total = $db->get_var($sql);
                }
                $ret['total'] = $total;

                break;

            case 'tdk':
                $opt = self::cnf($key);
                if($opt)foreach($opt as $k=>$v){
                    if(empty($v))continue;
                    if(is_array($v))foreach($v as $sk=>$sv){
                        if(empty($sv) || !is_string($sv) || !preg_match('#%list_keywords%#',$sv,$m))continue;
                        $opt[$k][$sk] = trim(str_replace('%list_keywords%','',$sv),',');
                    }
                }

                $ret['opt'] = $opt;
                $ret['separator'] = self::$cnf_fields['separator'];


                $ret['title_variables'] = self::get_title_variables(null);

                $type = sanitize_text_field(self::param('type'));

                if ($type == 'category') {
                    //array(0=>'分类',1=>'插件');
                    $taxonomies = [];

                    $all_taxonomy = Smart_SEO_Tool_Common::term_category();
                    $all_category = [];
                    foreach ($all_taxonomy as $taxonomy) {
                        $taxonomies[] = ['id' => $taxonomy->name, 'name' => $taxonomy->label];

                        $list = [];
                        if ($taxonomy->name != 'category') {
                            $r = new stdClass();
                            $r->term_id = $taxonomy->name . '_index';
                            $r->name = $taxonomy->label . '首页';
                            $list[] = $r;
                        }
                        //
                        $c_list = get_categories(array('hide_empty' => 0, 'orderby' => 'parent', 'order' => 'ASC', 'taxonomy' => $taxonomy->name));
                        if ($c_list) {
                            $parents = [];
                            foreach ($c_list as $t) {
                                if (!isset($parents[$t->parent])) $parents[$t->parent] = [];
                                $parents[$t->parent][] = $t;
                            }
                            if (isset($parents[0])) {
                                self::get_categories($parents[0], $parents, 0, $list);
                            }

                            /*foreach ($parents[0] as $t){
                                $k = 0;
                                $r = new stdClass();
                                $r->term_id = $t->term_id;
                                $r->name = $t->name;
                                $list[] = $r;
                                if(isset($parents[$r->term_id])){

                                }

                            }*/
                        }
                        $all_category[$taxonomy->name] = $list;
                    }
                    $ret['all_taxonomy'] = $taxonomies;
                    $ret['all_category'] = $all_category;
                }

                break;


            case 'setting':
                $opt = self::cnf(null);
                $data = [
                    'tdk' => '0',
                    'img_seo' => '0',
                    'url_404' => '0',
                    'broken' => '0',
                    'sitemap_seo' => '0',
                    'url_seo' => '0',
                    'robots_seo' => '0',
                    'redirection' => '0',
                ];
                foreach ($data as $k => $v) {
                    if (isset($opt[$k]) && isset($opt[$k]['active']) && $opt[$k]['active']) {
                        $data[$k] = 1;
                    }
                }
                $ret['opt'] = $data;
                $ret['cnf'] = self::$cnf_fields['setting_items'];
                $ret['guide'] = self::guide_cnf();
                break;

            case 'other_verify':

                $opt = get_option('sseot_other_cnf');
                if (!$opt) {
                    $opt = array(
                        'verify_active' => '0',
                        'verify' => array(),
                    );
                }
                if (!isset($opt['verify'])) {
                    $opt['verify'] = [];
                }

                $ret['opt'] = $opt;

                break;

            default:
                $keys = explode(',', $key);
                if (count($keys) > 1) {
                    foreach ($keys as $k) {
                        $ret[$k] = self::cnf($k);
                    }
                } else {
                    $ret = self::cnf($key);
                }

                break;
        }

        return $ret;
    }

    public static function get_categories($category, $parents, $k = 0, &$list = [])
    {
        foreach ($category as $t) {
            $r = new stdClass();
            $r->term_id = $t->term_id;
            $r->name = $t->name;
            if ($k) {
                $r->name = str_repeat('— ', $k) . $t->name;
            }
            $list[] = $r;
            if (isset($parents[$r->term_id])) {
                self::get_categories($parents[$r->term_id], $parents, $k + 1, $list);
            }
        }
    }
}
