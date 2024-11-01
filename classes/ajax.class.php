<?php
/**
 * Author: wbolt team
 * Author URI: https://www.wbolt.com/
 */

class Smart_SEO_Tool_Ajax extends Smart_SEO_Tool_Base
{

    public static function init()
    {
        add_action('wp_ajax_wb_smart_seo_tool', array(__CLASS__, 'wp_ajax_update_data'));
        add_action('wp_ajax_wb_smart_seo_tool', array(__CLASS__, 'wp_ajax_wb_smart_seo_tool'));
    }



    public static function wp_ajax_update_data()
    {
        $op = isset($_REQUEST['op'])?sanitize_text_field($_REQUEST['op']):null;
        if(!$op){
            return;
        }
        $allow = [
            'options', 'verify', 'options',
            'remove_404', 'refresh_404', 'mark_broken_url',
            'remove_broken','check_broken', 'clear_broken_url',
            'broken_url_batch', 'update_options','update_active',
            'set_guide', 'start_guide', 'redirection-save',
            'redirection-state'
        ];
        if(!in_array($op, $allow)){
            return;
        }

        $ret = array('code'=>1,'desc'=>'fail');

        if(!current_user_can('manage_options')){
            if($op === 'options'){
                $ret = ['o'=>''];
            }
            self::ajax_resp($ret);
        }

        if( !wp_verify_nonce(sanitize_text_field(self::param('_ajax_nonce')), 'wp_ajax_wb_sst')) {
            if($op === 'options'){
                $ret = ['o'=>''];
            }
            self::ajax_resp($ret);
        }
        switch ($op) {

            case 'remove_404':
                $id = self::param('id');
                if(empty($id)){
                    break;
                }
                if(is_array($id)){
                    $id_list = $id;
                }else{
                    $id_list = [$id];
                }

                $db = self::db();
                $t = $db->prefix.'wb_spider_log';
                $result = [];
                foreach ($id_list as $id){
                    $result[$id] = [0,'fail'];
                    $id = intval($id);
                    if(!$id)continue;
                    $row = $db->get_row($db->prepare("SELECT * FROM $t WHERE id=%d",$id));
                    if(!$row){
                        ///$ret['data'] = 'error';
                        $result[$id] = [0,'404'];
                        continue;
                    }
                    //$ret['d'] = array('code'=>404,'url_md5'=>$row->url_md5);
                    $db->delete($t,array('code'=>404,'url_md5'=>$row->url_md5));
                    $result[$id] = [1,'success'];
                }
                $ret['code'] = 0;
                $ret['desc'] = 'success';
                $ret['data'] = $result;

                break;
            case 'refresh_404':
                $ret['success'] = 0;
                $id = self::param('id');
                if(empty($id)){
                    break;
                }
                if(is_array($id)){
                    $id_list = $id;
                }else{
                    $id_list = [$id];
                }
                $db = self::db();
                $t = $db->prefix.'wb_spider_log';
                $result = [];
                foreach($id_list as $id){
                    $result[$id] = [0,'fail'];
                    $id = intval($id);
                    if(!$id)continue;
                    $row = $db->get_row($db->prepare("SELECT * FROM $t WHERE id=%d",$id));
                    if(!$row){
                        //$ret['data'] = 'error';
                        $result[$id] = [0,'404'];
                        continue;
                    }

                    $req_url = home_url($row->url);
                    $http = wp_remote_head($req_url,['timeout' => 5, 'sslverify' => false]);
                    if(is_wp_error($http)){
                        $result[$id] = [0,$http->get_error_message()];
                        //$ret['data'] = $http->get_error_message();
                        continue;
                    }

                    $http_code = wp_remote_retrieve_response_code($http);
                    //$ret['data'] = $http_code;
                    $result[$id] = [1,$http_code];
                    if($http_code && $row->code != $http_code){
                        $db->update($db->prefix.'wb_spider_log',['visit_date'=>current_time('mysql'),'code'=>$http_code],['id'=>$row->id]);
                        $db->update($db->prefix.'wb_spider_log',['code'=>$http_code],['url_md5'=>$row->url_md5]);
                    }
                }
                $ret['code'] = 0;
                $ret['desc'] = 'success';
                $ret['data'] = $result;
                $ret['success'] = 1;
                break;
            case 'mark_broken_url':
                $id = intval(self::param('id',0));
                if(!$id){
                    break;
                }
                $ret['code'] = 0;
                $ret['desc'] = 'success';
                $ret['data'] = Smart_SEO_Tool_Common::mark_broken_url($id);
                break;
            case 'remove_broken':
                $id = intval(self::param('id',0));
                if(!$id){
                    break;
                }
                $ret['code'] = 0;
                $ret['desc'] = 'success';
                $ret['data'] = Smart_SEO_Tool_Common::remove_broken_url($id);

                break;
            case 'check_broken':
                $id = intval(self::param('id',0));
                if(!$id){
                    break;
                }
                $row = Smart_SEO_Tool_Common::detect_url($id);
                if(!$row){
                    break;
                }
                $ret['code'] = 0;
                $ret['desc'] = 'success';
                $ret['row'] = $row;
                $ret['data'] = $row->code;

                break;
            case 'clear_broken_url':
                Smart_SEO_Tool_Common::clear_broken_url();
                $ret = ['code'=>0,'desc'=>'success'];
                break;
            case 'broken_url_batch':
                $ret['success'] = 0;
                $ids = sanitize_text_field(self::param('ids',''));
                $type = sanitize_text_field(self::param('type',''));
                if(!$ids || !$type){
                    break;
                }
                $ret['code'] = 0;
                $ret['desc'] = 'success';
                $db = self::db();
                $t = $db->prefix.'wb_sst_broken_url';
                $id_list = wp_parse_id_list($ids);
                $ids = implode(',',$id_list);
                //$ids = preg_replace('#[^\d,]#','',$ids);
                if($type == 'update'){
                    $db->query("UPDATE $t SET check_date = null,code= null WHERE id IN($ids)");
                    $ret['success'] = 1;
                }else if($type == 'ok'){
                    $db->query("UPDATE $t SET check_date = '2025-10-01 10:00:00',code= 200,memo='mark as ok' WHERE id IN($ids)");
                    $ret['success'] = 1;
                }else if($type == 'cancel'){
                    $result = [];
                    foreach($id_list as $id){
                        $id = intval($id);
                        if(!$id){
                            continue;
                        }
                        $result['data'] = Smart_SEO_Tool_Common::remove_broken_url($id);
                    }
                    $ret['data'] = $result;
                    $ret['success'] = 1;
                }

                break;
            case 'update_options':
                $key = self::param('key', null);
                $opt = self::param('opt', null);
                if( null !== $key && null !== $opt ){
                    Smart_SEO_Tool_Admin::update_cnf();
                    $ret = ['code'=>0,'desc'=>'success'];
                }
                break;
            case 'update_active':
                $opt = self::param('opt', null);
                if( null !== $opt ){
                    Smart_SEO_Tool_Admin::update_active();
                    $ret = ['code'=>0,'desc'=>'success'];
                }
                break;
            case 'set_guide':
                Smart_SEO_Tool_Admin::set_guide();
                $ret = ['code'=>0,'desc'=>'success'];
                break;
            case 'start_guide':
                Smart_SEO_Tool_Admin::start_guide();
                $ret = ['code'=>0,'desc'=>'success'];
                break;
            case 'redirection-save':
                $ret = Smart_SEO_Tool_Url::saveRedirectUrl();
                break;
            case 'redirection-state':
                $ret = Smart_SEO_Tool_Url::setRedirectUrlState();
                break;
            case 'verify':
                $param = array(
                    'code'=>sanitize_text_field(self::param('key')),
                    'host'=>sanitize_text_field(self::param('host')),
                    'ver'=>'sst',
                );
                $err = '';
                do{
                    $http = wp_remote_post('https://www.wbolt.com/wb-api/v1/verify',array('sslverify'=>false,'body'=>$param,'headers'=>array('referer'=>home_url()),));
                    if(is_wp_error($http)){
                        $err = '校验失败，请稍后再试（错误代码001['.$http->get_error_message().'])';
                        break;
                    }

                    if($http['response']['code']!=200){
                        $err = '校验失败，请稍后再试（错误代码001['.$http['response']['code'].'])';
                        break;
                    }

                    $body = $http['body'];

                    if(empty($body)){
                        $err = '发生异常错误，联系<a href="https://www.wbolt.com/?wb=member#/contact" target="_blank">技术支持</a>（错误代码 010）';
                        break;
                    }

                    $data = json_decode($body,true);

                    if(empty($data)){
                        $err = '发生异常错误，联系<a href="https://www.wbolt.com/?wb=member#/contact" target="_blank">技术支持</a>（错误代码011）';
                        break;
                    }
                    if(empty($data['data'])){
                        $err = '校验失败，请稍后再试（错误代码004)';
                        break;
                    }
                    if($data['code']){
                        $err_code = $data['data'];
                        switch ($err_code){
                            case 100:
                            case 101:
                            case 102:
                            case 103:
                                $err = '插件配置参数错误，联系<a href="https://www.wbolt.com/?wb=member#/contact" target="_blank">技术支持</a>（错误代码'.$err_code.'）';
                                break;
                            case 200:
                                $err = '输入key无效，请输入正确key（错误代码200）';
                                break;
                            case 201:
                                $err = 'key使用次数超出限制范围（错误代码201）';
                                break;
                            case 202:
                            case 203:
                            case 204:
                                $err = '校验服务器异常，联系<a href="https://www.wbolt.com/?wb=member#/contact" target="_blank">技术支持</a>（错误代码'.$err_code.'）';
                                break;
                            default:
                                $err = '发生异常错误，联系<a href="https://www.wbolt.com/?wb=member#/contact" target="_blank">技术支持</a>（错误代码'.$err_code.'）';
                        }

                        break;
                    }

                    update_option('wb_sst_ver',$data['v'],false);
                    update_option('wb_sst_cnf_'.$data['v'],$data['data'],false);

                    self::ajax_resp(['code'=>0,'desc'=>'success']);
                }while(false);

                $ret = ['code'=>1,'desc'=>$err];

                break;
            case 'options':
                $ver = intval(get_option('wb_sst_ver',0));
                $cnf = '';
                if($ver){
                    $cnf = get_option('wb_sst_cnf_'.$ver,'');
                }
                $ret = ['o'=>$cnf];
                break;
        }
        self::ajax_resp($ret);
    }

    public static function wp_ajax_wb_smart_seo_tool()
    {
        // global $wpdb;
        $ret = array('code'=>0,'desc'=>'success');

        $op = isset($_REQUEST['op'])?sanitize_text_field($_REQUEST['op']):null;

        if(!$op){
            return;
        }
        $allow = [
            'chk_ver','doc','404_url',
            'broken_url','robots_txt','get_options',
            'get_guide','redirection-detail','redirection-list'
        ];
        if(!in_array($op, $allow)){
            return;
        }

        switch ($op) {

            case 'chk_ver':
                if( !current_user_can('manage_options')) {
                    exit();
                }
                $api = 'https://www.wbolt.com/wb-api/v1/themes/checkver?code=' . SMART_SEO_TOOL_CODE . '&ver=' . SMART_SEO_TOOL_VERSION . '&chk=1';
                $http = wp_remote_get($api, array('sslverify' => false, 'headers' => array('referer' => home_url()),));
                if (wp_remote_retrieve_response_code($http) == 200) {
                    echo esc_html(wp_remote_retrieve_body($http));
                }
                exit();
                break;

            case 'doc':
                $ret['data'] = [];
                if( !current_user_can('manage_options')) {
                    break;
                }
                $type = self::param('type', null);
                if($type == 'image'){
                    $ret['data'] = Smart_SEO_Tool_Admin::$cnf_fields['image_variables_desc'];
                }else{
                    $ret['data'] = Smart_SEO_Tool_Admin::$cnf_fields['variables_desc'];
                }

                break;

            case '404_url':
                if( !current_user_can('manage_options')) {
                    $ret['success'] = 1;
                    $ret['data'] = [];
                    break;
                }
                $opt = Smart_SEO_Tool_Admin::cnf('url_404');
                if(empty($opt['active'])){
                    $ret['success'] = 1;
                    $ret['data'] = [];
                    break;
                }
                $num = 30;

                $offset = 0;
                if(isset($_GET['page'])){
                    $page = intval(($_GET['page']));
                    $page = max(1,$page);
                    $offset = ($page - 1 ) * $num;
                }else if(isset($_GET['offset'])){
                    $offset = intval(($_GET['offset']));
                }

                /*$offset = isset($_GET['offset'])?intval(sanitize_text_field($_GET['offset'])):0;
                $offset = max(0,$offset);
                $num = 30;*/
            $db = self::db();
                $url_log = $db->prefix.'wb_spider_log';
                $t_spider = $db->prefix . 'wb_spider';
                $sql = "SELECT a.* FROM $url_log a WHERE `code`=404";


                if(!empty($opt['real_spider']) && $opt['real_spider']){
                    $sql = "SELECT a.* FROM $t_spider b,(SELECT * FROM $url_log WHERE `code`=404 ) AS a WHERE b.name=a.spider and b.status=1";
                }
                if(!empty($opt['top_site_spider']) && $opt['top_site_spider']){
                    $sql .= " AND a.spider REGEXP ('baidu|google|bing')";
                }


                $list = $db->get_results($sql." ORDER BY a.id DESC LIMIT $offset,$num");

                $ret['success'] = 1;
                $ret['data'] = $list;

                break;

            case 'broken_url':
                if( !current_user_can('manage_options')) {
                    $ret['success'] = 1;
                    $ret['data'] = [];
                    break;
                }
                $num = 30;

                $offset = 0;
                if(isset($_GET['page'])){
                    $page = intval(sanitize_text_field($_GET['page']));
                    $page = max(1,$page);
                    $offset = ($page - 1 ) * $num;
                }else if(isset($_GET['offset'])){
                    $offset = intval(sanitize_text_field($_GET['offset']));
                }

                $type = isset($_GET['type'])?intval(sanitize_text_field($_GET['type'])):0;
                $offset = max(0,$offset);

                $db = self::db();
                $url_log = $db->prefix.'wb_sst_broken_url';
                $where = '';
                if($type==2){
                    $where = " AND `code` REGEXP '^30'";
                }else if($type == 1){
                    $where = " AND `code` REGEXP '^(5|4|error)'";
                }else if($type == 3){
                    $where = " AND `code` REGEXP '^2'";
                }else if($type == 4){
                    $where = " AND (`code` IS NULL OR `code` = '') ";
                }else{
                    $where = " AND (`code` IS NULL OR `code` <> '200')";
                }
                $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $url_log WHERE url_md5 IS NOT NULL $where ORDER BY id DESC LIMIT $offset,$num";
                $list = $db->get_results($sql);
                $record_total = $db->get_var("SELECT FOUND_ROWS()");
                if($list)foreach($list as $r){
                    if(!$r->code){
                        $r->code = '待检测';
                    }
                    $post = get_post($r->post_id);
                    $r->post_title = $post->post_title;
                    $r->post_url = get_permalink($post);
                    $r->edit_url = get_edit_post_link($post,'');
                }

                //$ret['sql'] = $sql;
                $ret['success'] = 1;
                $ret['data'] = $list;
                $ret['page_num'] = $num;
                $ret['record_total'] = $record_total;

                break;
            case 'robots_txt':
                $ret['data'] = array();
                if( !current_user_can('manage_options')) {
                    break;
                }
                //$ret['data'] = array();
                $output = "User-agent: *".PHP_EOL;
                $site_url = wp_parse_url(site_url());
                $path = (!empty($site_url['path'])) ? $site_url['path'] : '';
                $output .= "Disallow: $path/wp-admin/".PHP_EOL;
                $output .= "Disallow: $path/wp-include/".PHP_EOL;
                $output .= "Disallow: $path/wp-login.php?redirect_to=*".PHP_EOL;
                $output .= "Disallow: $path/go?_=*".PHP_EOL;
                $output .= "Allow: $path/wp-admin/admin-ajax.php".PHP_EOL;

                $ret['data'] = $output;

                break;

	        case 'get_options':
                $ret['data'] = array();
                if( !current_user_can('manage_options')) {
                    break;
                }
                $key = self::param('key',null);
		        if( null !== $key ){
			        $ret['data'] = Smart_SEO_Tool_Admin::get_setting(sanitize_text_field($key));

                    if($key == 'sitemap_seo'){
                        $ret['sitemap_state'] = Smart_SEO_Tool_Sitemap::sitemap_url();
                    }
		        }
                $type = self::param('type',null);
		        if( null !== $type ){
			        $keys = explode(',', sanitize_text_field($type));
			        $ret['data']['title_variables'] = array();

			        if(count($keys)>1){
				        foreach ($keys as $k){
					        $ret['data']['title_variables'][$k] = Smart_SEO_Tool_Admin::get_title_variables($k);
				        }
			        }else{
			        	$key = sanitize_text_field($type);
				        $ret['data']['title_variables'][$key] = Smart_SEO_Tool_Admin::get_title_variables($key);
			        }
		        }
		        $ret['type'] = $type ? sanitize_text_field($type) : '';


	        	break;

            case 'get_guide':
                $ret['data'] = array();
                if( !current_user_can('manage_options')) {
                    break;
                }

                $cnf = Smart_SEO_Tool_Admin::guide_cnf();

                $ret['data'] = $cnf;
                $ret['cnf'] = [
                    'separator'=>Smart_SEO_Tool_Admin::$cnf_fields['separator'],
                    'title_variables'=>Smart_SEO_Tool_Admin::get_title_variables('common'),
                ];


                break;

            case 'redirection-detail':

                $ret = Smart_SEO_Tool_Url::redirectUrlDetail();

                break;

            case 'redirection-list':
                $ret = Smart_SEO_Tool_Url::redirectUrlList();
                break;

        }
        self::ajax_resp($ret);

    }


}