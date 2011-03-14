<?php
/**************************************************
  SQL_Mode Plugin for Coppermine Photo Gallery
  *************************************************
  SQL_Mode version 1.0
  Copyright (c) 2005-2006 Donovan Bray <donnoman@donovanbray.com>
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.
  *************************************************
  Coppermine version: 1.4.9
  $Source: /cvsroot/cpg-contrib/sql_mode/codebase.php,v $
  $Revision: 1.1 $
  $Author: donnoman $
  $Date: 2006/11/01 05:43:31 $
***************************************************/


if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$thisplugin->add_action('plugin_install','sqlmode_install');
$thisplugin->add_action('plugin_wakeup','sqlmode_wakeup');
$thisplugin->add_action('plugin_configure','sqlmode_configure');
$thisplugin->add_action('plugin_uninstall','sqlmode_uninstall');

function sqlmode_wakeup() {
      global $CONFIG;
      $query = "SET sql_mode = '{$CONFIG['sqlmode']}';";
      $result = cpg_db_query($query);
      return true;
}

function sqlmode_install() {
    global $CONFIG;

    sqlmode_uninstall();
        
    $query = "SELECT @@global.sql_mode;";
    $result = cpg_db_query($query);
    $global_sql_mode = cpg_db_fetch_rowset($result);
    $global_sql_mode=empty($global_sql_mode[0][0]) ? '' : $global_sql_mode[0][0];
    
    $query = "INSERT INTO {$CONFIG['TABLE_CONFIG']} (name,value) VALUES ('sqlmode','$global_sql_mode') ;";
    $result = cpg_db_query($query);
    $query = "UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '1' WHERE name = 'debug_mode';";
    $result = cpg_db_query($query);
    $query = "UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '1' WHERE name = 'debug_notice';";
    $result = cpg_db_query($query);

    // Install
    if ($_POST['submit']=="Go!") {

        return true;

    // Loop again
    } else {

        return 1;
    }
}

function sqlmode_configure() {
    $query = "SELECT @@global.sql_mode;";
    $result = cpg_db_query($query);
    $global_sql_mode = cpg_db_fetch_rowset($result);
    $global_sql_mode=empty($global_sql_mode[0][0]) ? 'NULL' : $global_sql_mode[0][0];
        
    echo <<< EOT
        <p>Current GLOBAL SQL MODE: $global_sql_mode</p>
        <p>Coppermine Debug modes automatically turned on during install.</p>    
    <form action="{$_SERVER['REQUEST_URI']}" method="post">
        <input type="submit" name="submit" value="Go!" />
    </form>
EOT;
}

function sqlmode_uninstall() {
    global $CONFIG;
    $query = "DELETE FROM {$CONFIG['TABLE_CONFIG']} WHERE name = 'sqlmode';";
    $result = cpg_db_query($query);    
    return true;
}
?>
