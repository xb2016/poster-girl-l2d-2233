<?php
/*
Plugin Name: live2d看板娘(2233)
Plugin URI: https://github.com/xb2016/poster-girl-l2d-2233
Description: 2233娘的live2d看板娘插件(WordPress)，支持换人换装！如果觉得本插件还OK的话，请访问下面的插件主页，给我一个star，谢谢！
Author: 小白-白
Version: 1.7
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
        update_option('plugin_l2d_move',(isset($_POST['move'])&&$_POST['move']=='1'));
        update_option('plugin_l2d_r18',(isset($_POST['r18'])&&$_POST['r18']=='1'));
        update_option('plugin_l2d_mobile',(isset($_POST['mobile'])&&$_POST['mobile']=='1'));
        update_option('plugin_l2d_jq',(isset($_POST['jq'])&&$_POST['jq']=='1'));
        update_option('plugin_l2d_fa',(isset($_POST['fa'])&&$_POST['fa']=='1'));
        echo '<div id="message" class="updated fade"><p>设置已保存</p></div>';
    }
    $move_yes = get_option('plugin_l2d_move')?' checked ':'';
    $move_no = get_option('plugin_l2d_move')?'':' checked ';
    $r18_yes = get_option('plugin_l2d_r18')?' checked ':'';
    $r18_no = get_option('plugin_l2d_r18')?'':' checked ';
    $mobile_yes = get_option('plugin_l2d_mobile')?' checked ':'';
    $mobile_no = get_option('plugin_l2d_mobile')?'':' checked ';
    $jq_yes = get_option('plugin_l2d_jq')?' checked ':'';
    $jq_no = get_option('plugin_l2d_jq')?'':' checked ';
    $fa_yes = get_option('plugin_l2d_fa')?' checked ':'';
    $fa_no = get_option('plugin_l2d_fa')?'':' checked '; ?>
    <div class="wrap">
      <h1>L2D看板娘设置</h1>
      <form action="options-general.php?page=plugin-l2d" method="post">
		<style>h2{font-size:20px}h3{font-size:15px;font-weight:700}th{font-weight:200}</style>
        <?php wp_nonce_field('plugin-l2d-options'); ?>
        <h2>设置</h2>
          <h3>随机移动</h3>
            <table>
              <th>是否允许看板娘自动移动：</th>
              <td>
                <label><input type="radio" name="move" <?php echo $move_yes; ?> value="1" /> 是</label> <label><input type="radio" name="move" <?php echo $move_no; ?> value="0" /> 否</label>
              </td>
			</table>
          <h3>R18#嘿嘿嘿</h3>
            <table>
              <th>是否允许随机到全裸模型：</th>
              <td>
                <label><input type="radio" name="r18" <?php echo $r18_yes; ?> value="1" /> 是</label> <label><input type="radio" name="r18" <?php echo $r18_no; ?> value="0" /> 否</label>
              </td>
			</table>
          <h3>移动端加载(不建议)</h3>
            <table>
              <th>移动端是否加载：</th>
              <td>
                <label><input type="radio" name="mobile" <?php echo $mobile_yes; ?> value="1" /> 是</label> <label><input type="radio" name="mobile" <?php echo $mobile_no; ?> value="0" /> 否</label>
              </td>
            </table><br>
        <h2>环境</h2>
          <p>本插件需要 jQuery 库与 Font Awesome 4.7 支持，如果你的主题没有引用上述项目，请选择加载。</p>
          <p>关于提示语与监听对象的修改，请直接编辑 js/waifu-tips.js。</p>
          <h3>加载jQuery库</h3>
            <table>
              <th>配置是否加载JQ：</th>
              <td>
                <label><input type="radio" name="jq" <?php echo $jq_yes; ?> value="1" /> 是</label> <label><input type="radio" name="jq" <?php echo $jq_no; ?> value="0" /> 否</label>
              </td>
            </table>
          <h3>加载Font Awesome 4.7</h3>
            <table>
              <th>配置是否加载FA：</th>
              <td>
                <label><input type="radio" name="fa" <?php echo $fa_yes; ?> value="1" /> 是</label> <label><input type="radio" name="fa" <?php echo $fa_no; ?> value="0" /> 否</label>
              </td>
            </table><br>
            <p>emmm 最后 <a href="https://github.com/xb2016/poster-girl-l2d-2233" target="_blank">https://github.com/xb2016/poster-girl-l2d-2233</a> 求star！</p>
            <p class="submit"><input name="update_options" value="保存设置" type="submit"></p>
      </form>
    </div><?php        
}
//MAIN
if(!wp_is_mobile()||get_option('plugin_l2d_mobile')) add_action('wp_footer','l2d_main');
function l2d_main(){
    if(wp_is_mobile()) $l2d_w = 130; else $l2d_w = 220;
    if(wp_is_mobile()) $l2d_h = 150; else $l2d_h = 250;
    if(!wp_is_mobile()||!get_option('plugin_l2d_mobile')) $mobi = 1;
    wp_enqueue_style('waifu',l2d_URL.'/css/waifu.min.css',array(),'1.7');
    if(get_option('plugin_l2d_fa')) wp_enqueue_style('fontawe','https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css',array(),'4.7');
    wp_enqueue_script('waifu',l2d_URL.'/js/waifu-tips.js',array(),'1.7');
    $d2l2d = array('xb'=>l2d_URL,'move'=>get_option('plugin_l2d_move'),'mobile'=>$mobi,'r18'=>get_option('plugin_l2d_r18'));
    wp_localize_script('waifu','l2d',$d2l2d); ?>
    <div class="l2d_xb<?php if(!get_option('plugin_l2d_mobile')) echo ' mh';?>">
        <div class="waifu">
        <div class="waifu-tips"></div>
        <canvas id="live2d" width="<?php echo $l2d_w; ?>" height="<?php echo $l2d_h; ?>" class="live2d"></canvas>
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
        <?php if(get_option('plugin_l2d_jq')) echo '<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@2.1.4/dist/jquery.min.js"></script>'; ?>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/xb2016/kratos-pjax@0.3.6/static/js/live2d.js"></script>
	</div><?php
}