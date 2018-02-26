<?php
/*
Plugin Name: live2d看板娘(2233)
Plugin URI: https://github.com/xb2016/poster-girl-l2d-2233
Description: 2233娘的live2d看板娘插件(WordPress)，支持换人换装！如果觉得本插件还OK的话，请访问下面的插件主页，给我一个star，谢谢！
Author: 小白-白
Version: 1.1
Author URI: https://www.fczbl.vip
*/

//PATH
define('l2d_URL',plugins_url('', __FILE__));
//SETTINGS
add_action('admin_menu','plugin_l2d');
function plugin_l2d(){
    add_options_page('live2d','L2D看板娘设置','manage_options','plugin-l2d','plugin_l2d_option_page');
}
function plugin_l2d_option($option_name){
    global $plugin_l2d_options;
    if(isset($plugin_l2d_options[$option_name])){
        return $plugin_l2d_options[$option_name];
    }else{
        return null;
    }
}
function plugin_l2d_update_options(){
    update_option('plugin_l2d_jq',plugin_l2d_option('jq'));
    update_option('plugin_l2d_fa',plugin_l2d_option('fa'));
}
function plugin_l2d_option_page(){
    if(!current_user_can('manage_options')) wp_die('抱歉，您没有权限来更改设置');
    if(isset($_POST['update_options'])){
        global $plugin_l2d_options;
        $plugin_l2d_options['jq'] = $_POST['jq'];
        $plugin_l2d_options['fa'] = $_POST['fa'];
        plugin_l2d_update_options();
        echo '<div id="message" class="updated fade"><p>设置已保存</p></div>';
    } ?>
    <div class="wrap">
        <h2>L2D看板娘设置</h2>
        <form action="options-general.php?page=plugin-l2d" method="post">
        <?php wp_nonce_field('plugin-l2d-options'); ?>
            <table class="form-table">
                <tr>
                <td>
                   <h3>加载jQuery库</h3>
                   <input type="text" size="3" maxlength="1" value="<?php echo(get_option('plugin_l2d_jq')); ?>" name="jq" />配置是否加载JQ：1是，0否<br />
                   <h3>加载Font Awesome</h3>
                   <input type="text" size="3" maxlength="1" value="<?php echo(get_option('plugin_l2d_fa')); ?>" name="fa" />配置是否加载FA：1是，0否<br />
                   <br /><p>本插件需要加载jQuery库与Font Awesome支持，如果你的主题没有引用上述项目，请选择加载。</p><br />
                   <p>关于提示语的修改，请直接编辑js/waifu-tips.js。</p><br />
                   <p>emmm 最后 https://github.com/xb2016/poster-girl-l2d-2233 求star！</p>
                   </td>
                </tr>
            </table>
            <p class="submit"><input name="update_options" value="保存设置" type="submit" /></p>
        </form>
    </div><?php        
}
//MAIN
add_action('wp_footer','l2d_main');
function l2d_main(){
    echo '
    <div class="waifu">
        <div class="waifu-tips"></div>
        <canvas id="live2d" width="230" height="250" class="live2d"></canvas>
        <div class="waifu-tool">
            <span class="fa fa-home"></span>
            <span class="fa fa-comments"></span>
            <span class="fa fa-drivers-license-o"></span>
            <span class="fa fa-street-view"></span>
            <span class="fa fa-camera"></span>
            <span class="fa fa-info-circle"></span>
            <span class="fa fa-close"></span>
        </div>
    </div>
    ';
}
add_action('wp_enqueue_scripts','l2d_scripts');
function l2d_scripts(){
    if(!is_admin()){
        if(get_option(plugin_l2d_fa)==1) wp_enqueue_style('awesome',l2d_URL.'/css/font-awesome.min.css',array(),'4.7.1');
        wp_enqueue_style('waifu',l2d_URL.'/css/waifu.min.css',array(),'1.1');
        if(get_option(plugin_l2d_jq)==1) wp_enqueue_script('jquery',l2d_URL.'/js/jquery.min.js',array(),'2.1.4');
        wp_enqueue_script('live2d',l2d_URL.'/js/live2d.js',array(),'r3');
        wp_enqueue_script('waifu',l2d_URL.'/js/waifu-tips.js',array(),'1.1');
    }
    $d2l2d = array('xb'=>l2d_URL);
    wp_localize_script('waifu','l2d',$d2l2d);
}