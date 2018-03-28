<?php
/*
Plugin Name: live2d看板娘(2233)
Plugin URI: https://github.com/xb2016/poster-girl-l2d-2233
Description: 2233娘的live2d看板娘插件(WordPress)，支持换人换装！如果觉得本插件还OK的话，请访问下面的插件主页，给我一个star，谢谢！
Author: 小白-白
Version: 1.3
Author URI: https://www.fczbl.vip
*/

//PATH
define('l2d_URL',plugins_url('', __FILE__));
//SETTINGS
add_action('admin_menu','plugin_l2d');
function plugin_l2d(){
    add_options_page('live2d','L2D看板娘设置','manage_options','plugin-l2d','plugin_l2d_option_page');
}
function plugin_l2d_option_page(){
    if(!current_user_can('manage_options')) wp_die('抱歉，您没有权限来更改设置');
    if(isset($_POST['update_options'])){
        update_option('plugin_l2d_move',$_POST['move']);
        update_option('plugin_l2d_mobile',$_POST['mobile']);
        update_option('plugin_l2d_jq',$_POST['jq']);
        update_option('plugin_l2d_fa',$_POST['fa']);
        echo '<div id="message" class="updated fade"><p>设置已保存</p></div>';
    } ?>
    <div class="wrap">
        <h2>L2D看板娘设置</h2>
        <form action="options-general.php?page=plugin-l2d" method="post">
        <?php wp_nonce_field('plugin-l2d-options'); ?>
            <table class="form-table">
                <tr>
                <td>
                   <h3>设置</h3>
                   <h4>随机移动</h4>
                   <input type="text" size="3" maxlength="1" value="<?php echo(get_option('plugin_l2d_move')); ?>" name="move" />是否允许看板娘自动移动：1是，0否<br />
                   <h4>移动端加载</h4>
                   <input type="text" size="3" maxlength="1" value="<?php echo(get_option('plugin_l2d_mobile')); ?>" name="mobile" />移动端是否加载：1是，0否<br />
                   <h3>环境</h3>
                   <p>本插件需要 jQuery 库与 Font Awesome 4.7 支持，如果你的主题没有引用上述项目，请选择加载。</p><br />
                   <p>关于提示语与监听对象的修改，请直接编辑 js/waifu-tips.js。</p>
                   <h4>加载jQuery库</h4>
                   <input type="text" size="3" maxlength="1" value="<?php echo(get_option('plugin_l2d_jq')); ?>" name="jq" />配置是否加载JQ：1是，0否<br />
                   <h4>加载Font Awesome 4.7</h4>
                   <input type="text" size="3" maxlength="1" value="<?php echo(get_option('plugin_l2d_fa')); ?>" name="fa" />配置是否加载FA：1是，0否<br />
                   <br /><p>emmm 最后<a href="https://github.com/xb2016/poster-girl-l2d-2233" target="_blank"> https://github.com/xb2016/poster-girl-l2d-2233 </a>求star！</p>
                   </td>
                </tr>
            </table>
            <p class="submit"><input name="update_options" value="保存设置" type="submit" /></p>
        </form>
    </div><?php        
}
//MAIN
if(!wp_is_mobile()||get_option('plugin_l2d_mobile')) add_action('wp_footer','l2d_main');
function l2d_main(){
    if(wp_is_mobile()) $l2d_w = 130; else $l2d_w = 220;
    if(wp_is_mobile()) $l2d_h = 150; else $l2d_h = 250;
    if(!wp_is_mobile()||!get_option('plugin_l2d_mobile')) $mobi = 1;
    echo '<div class="l2d_xb">
    ';
    if(get_option(plugin_l2d_fa)==1) echo '<link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
    ';
    echo '<link rel="stylesheet" href="'.l2d_URL.'/css/waifu.min.css" type="text/css">
    <div class="waifu">
        <div class="waifu-tips"></div>
        <canvas id="live2d" width="'.$l2d_w.'" height="'.$l2d_h.'" class="live2d"></canvas>
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
    if(get_option(plugin_l2d_jq)==1) echo '<script type="text/javascript" src="https://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
    ';
    echo '<script type="text/javascript" src="'.l2d_URL.'/js/live2d.js"></script>
</div>
';
    wp_enqueue_script('waifu',l2d_URL.'/js/waifu-tips.js',array(),'1.1');
    $d2l2d = array('xb'=>l2d_URL,'move'=>get_option('plugin_l2d_move'),'mobile'=>$mobi);
    wp_localize_script('waifu','l2d',$d2l2d);
}