<?php
	
	
// xử lý lưu session danh mục sản phẩm

if ($nv_Request->isset_request('id_dm', 'get,post')) {
    $id_dm = $nv_Request->get_int('id_dm', 'get,post');
	
	$_SESSION['danhmuc_sp'] = $id_dm;
	print_r($id_dm);die;
	
}

function get_html_catid_all($array, $level, $ul_cap2, $li_cap1, $session_dm)
{
	global $html_catid;
	//$li_cap1 = true;
	//$ul_cap2 = true;
	$level++;
	
	$html_catid .= '<ul class="ul_cap'. $level .' ">';
	
		foreach($array as $item)
		{	
			
			$html_catid .= '<li id_dm="'. $item['id'] .'" class="li_cap' . $level . '';
			
			if(isset($session_dm) and $session_dm and $item['id'] == $session_dm)
			{
				$html_catid .= ' active_li_cap1"';
			}
			elseif($level == 1 and $li_cap1 == true and !$session_dm){
				$html_catid .= ' active_li_cap1"';
				$li_cap1 = false;
			}
			$html_catid .= ' ">';
					
					
					if($level >1){
						$html_catid .= '<a  href="' . $item['link'] . '" class="">';
					}
					if($item['parrent_id'] == 0)
					{
						$html_catid .= '<image src='. $item['image'] .' >';
					}
					
					$html_catid .= $item['name'];
					if($level >1){
						$html_catid .= '</a>';
					}
					
					
				
				if($item['sub'] and $level  == 2)
				{	
					$html_catid .= '<a id="" href="#" class="icon_right">';
					$html_catid .= '<i  class="fa fa-angle-right" aria-hidden="true "></i>';
					$html_catid .= '</a>';
				}
				
				
				if($item['sub'])
				{
					get_html_catid_all($item['sub'], $level, $ul_cap2, $li_cap1, $session_dm);
				}
			$html_catid .= '</li>';
			
		}
	$html_catid .= '</ul>';
	
	
	
	return $html_catid;
}



$xtpl = new XTemplate('catalogy.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);

if(!$redis->exists('catalogy_main_all_lev'))
{
	$catalogys = get_categories_all_lev(0);
	$redis->set('catalogy_main_all_lev', json_encode($catalogys));	
}
$global_categories = json_decode($redis->get('catalogy_main_all_lev'),true);
//print_r($global_categories);
$html = get_html_catid_all($global_categories, 0, true, true, $_SESSION['danhmuc_sp']);
$xtpl->assign('html', $html);




$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = 'Danh mục';

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';