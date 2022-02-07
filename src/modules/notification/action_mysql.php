<?php

/**
 * @Project TMS HOLDINGS
 * @Author TMS HOLDINGS <contact@tms.vn>
 * @Copyright (C) 2021 TMS HOLDINGS. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 19 Feb 2021 09:02:49 GMT
 */

if (!defined('NV_IS_FILE_MODULES'))
    die('Stop!!!');

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_register";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_shop";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_user";

$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_register(
  userid mediumint(8) unsigned NOT NULL,
  endpoint varchar(100) NOT NULL,
  UNIQUE KEY userid (userid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "(
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  admin_view_allowed tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Cấp quản trị được xem: 0,1,2',
  logic_mode tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Cấp trên xem được cấp dưới, 1: chỉ cấp hoặc người được chỉ định',
  send_to varchar(250) NOT NULL DEFAULT '' COMMENT 'Danh sách id người nhận, phân cách bởi dấu phảy',
  send_from mediumint(8) unsigned NOT NULL DEFAULT '0',
  area tinyint(1) unsigned NOT NULL,
  language char(3) NOT NULL,
  module varchar(50) NOT NULL,
  obid int(11) unsigned NOT NULL DEFAULT '0',
  type varchar(255) NOT NULL,
  content text NOT NULL,
  add_time int(11) unsigned NOT NULL,
  view tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY send_to (send_to),
  KEY admin_view_allowed (admin_view_allowed),
  KEY logic_mode (logic_mode)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_shop(
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  admin_view_allowed tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Cấp quản trị được xem: 0,1,2',
  logic_mode tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Cấp trên xem được cấp dưới, 1: chỉ cấp hoặc người được chỉ định',
  send_to varchar(250) NOT NULL DEFAULT '' COMMENT 'Danh sách id người nhận, phân cách bởi dấu phảy',
  send_from mediumint(8) unsigned NOT NULL DEFAULT '0',
  area tinyint(1) unsigned NOT NULL,
  language char(3) NOT NULL,
  module varchar(50) NOT NULL,
  obid int(11) unsigned NOT NULL DEFAULT '0',
  type varchar(255) NOT NULL,
  content text NOT NULL,
  add_time int(11) unsigned NOT NULL,
  view tinyint(1) unsigned NOT NULL DEFAULT '0',
  product_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY send_to (send_to),
  KEY admin_view_allowed (admin_view_allowed),
  KEY logic_mode (logic_mode)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_user(
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  admin_view_allowed tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Cấp quản trị được xem: 0,1,2',
  logic_mode tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Cấp trên xem được cấp dưới, 1: chỉ cấp hoặc người được chỉ định',
  send_to varchar(250) NOT NULL DEFAULT '' COMMENT 'Danh sách id người nhận, phân cách bởi dấu phảy',
  send_from mediumint(8) unsigned NOT NULL DEFAULT '0',
  area tinyint(1) unsigned NOT NULL,
  language char(3) NOT NULL,
  module varchar(50) NOT NULL,
  obid int(11) unsigned NOT NULL DEFAULT '0',
  type varchar(255) NOT NULL,
  content text NOT NULL,
  add_time int(11) unsigned NOT NULL,
  view tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY send_to (send_to),
  KEY admin_view_allowed (admin_view_allowed),
  KEY logic_mode (logic_mode)
) ENGINE=MyISAM";

$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'onesignal_appid', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'slack_tocken', '')";
