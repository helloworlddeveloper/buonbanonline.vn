<?php

/**
 * @Project TMS HOLDINGS
 * @Author TMS HOLDINGS <contact@tms.vn>
 * @Copyright (C) 2021 TMS HOLDINGS. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 19 Feb 2021 09:03:30 GMT
 */

if (!defined('NV_IS_FILE_MODULES'))
    die('Stop!!!');

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_country";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_area";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_area_district";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_district";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_province";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_ward";

$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_country(
  countryid smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  code varchar(10) NOT NULL,
  title varchar(255) NOT NULL,
  alias varchar(255) NOT NULL,
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (countryid),
  UNIQUE KEY countryid (code)
) ENGINE=MyISAM";


$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_area(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  title_area varchar(255) NOT NULL COMMENT 'Tên khu vực',
  alias varchar(255) NOT NULL,
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (id)
) ENGINE=MyISAM";



$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_area_province(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  id_area int(11) DEFAULT NULL COMMENT 'Khu vực',
  districtid text NOT NULL COMMENT 'Danh sách tỉnh thành',
  PRIMARY KEY (id)
) ENGINE=MyISAM";



$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_district(
  districtid mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  vnpostid int(11) DEFAULT NULL,
  vtpid int(11) DEFAULT NULL,
  ghnid int(11) DEFAULT NULL,
  code varchar(5) NOT NULL,
  provinceid varchar(5) NOT NULL,
  ahamove int(11) DEFAULT NULL,
  ghtk int(11) DEFAULT NULL,
  ghn int(11) DEFAULT NULL,
  viettelpost int(11) DEFAULT NULL,
  vnpost int(11) DEFAULT NULL,
  title varchar(100) NOT NULL,
  alias varchar(100) NOT NULL,
  type varchar(30) NOT NULL,
  location varchar(30) NOT NULL,
  weight mediumint(8) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (districtid),
  KEY provinceid (provinceid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_province(
  provinceid mediumint(4) unsigned NOT NULL AUTO_INCREMENT,
  vnpostid int(11) DEFAULT NULL,
  vtpid int(11) DEFAULT NULL,
  ghnid int(11) DEFAULT NULL,
  code varchar(5) NOT NULL,
  countryid varchar(10) NOT NULL,
  ahamove int(11) DEFAULT NULL,
  ghtk int(11) DEFAULT NULL,
  ghn int(11) DEFAULT NULL,
  viettelpost int(11) DEFAULT NULL,
  vnpost int(11) DEFAULT NULL,
  title varchar(100) NOT NULL,
  alias varchar(100) NOT NULL,
  type varchar(30) NOT NULL,
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (provinceid),
  UNIQUE KEY provinceid (code,countryid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_ward(
  wardid mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  vnpostid int(11) DEFAULT NULL,
  vtpid int(11) DEFAULT NULL,
  ghnid varchar(250) DEFAULT NULL,
  districtid varchar(5) NOT NULL,
  ahamove int(11) DEFAULT NULL,
  ghtk int(11) DEFAULT NULL,
  ghn int(11) DEFAULT NULL,
  viettelpost int(11) DEFAULT NULL,
  vnpost int(11) DEFAULT NULL,
  lat varchar(250) DEFAULT NULL,
  lng varchar(250) DEFAULT NULL,
  title varchar(100) NOT NULL,
  alias varchar(100) NOT NULL,
  code varchar(250) DEFAULT NULL,
  type varchar(30) DEFAULT NULL,
  location varchar(30) DEFAULT NULL,
  status tinyint(1) unsigned NOT NULL DEFAULT '1',
  weight int(11) DEFAULT NULL,
  PRIMARY KEY (wardid),
  UNIQUE KEY alias (alias),
  KEY districtid (districtid)
) ENGINE=MyISAM";

$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . "(lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'allow_type', '1')";
