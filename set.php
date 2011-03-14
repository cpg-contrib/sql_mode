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
  $Source: /cvsroot/cpg-contrib/sql_mode/set.php,v $
  $Revision: 1.1 $
  $Author: donnoman $
  $Date: 2006/11/01 05:43:32 $
***************************************************/


require('include/init.inc.php');



if (!GALLERY_ADMIN_MODE) cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);

$sqlmodes=explode(",","ALLOW_INVALID_DATES,ANSI,ANSI_QUOTES,DB2,ERROR_FOR_DIVISION_BY_ZERO,HIGH_NOT_PRECEDENCE,IGNORE_SPACE,MAXDB,MSSQL,MYSQL323,MYSQL40,NO_AUTO_CREATE_USER,NO_AUTO_VALUE_ON_ZERO,NO_BACKSLASH_ESCAPES,NO_DIR_IN_CREATE,NO_ENGINE_SUBSTITUTION,NO_FIELD_OPTIONS,NO_KEY_OPTIONS,NO_TABLE_OPTIONS,NO_UNSIGNED_SUBTRACTION,NO_ZERO_DATE,NO_ZERO_IN_DATE,ONLY_FULL_GROUP_BY,ORACLE,PIPES_AS_CONCAT,POSTGRESQL,REAL_AS_FLOAT,STRICT_ALL_TABLES,STRICT_TRANS_TABLES,TRADITIONAL");

if(isset($_REQUEST['submit'])){
    foreach ($sqlmodes as $mode) {
        if (isset($_REQUEST[$mode]) && $_REQUEST[$mode]=='on' ) {
            $modes[]=$mode;       
        }
    }
    $modes=implode(',',$modes);
    $query = "UPDATE {$CONFIG['TABLE_CONFIG']} SET value='$modes' WHERE NAME='sqlmode';";
    $result = cpg_db_query($query);
    $CONFIG['sqlmode']=$modes;
    unset($modes);
    
    $host  = $_SERVER['HTTP_HOST'];
    $uri  = rtrim(dirname(str_replace("index.php?file=sql_mode",'',$_SERVER['REQUEST_URI'])), '/\\');
    $extra = 'pluginmgr.php';
    header("Location: http://$host$uri/$extra");
    exit;
}    

pageheader('Set Session SQLMode');
   
foreach ($sqlmodes as $mode) {
    $modes[$mode]=stristr($CONFIG['sqlmode'],$mode) ? 'checked="checked"' : '';       
}
echo <<<EOT
<form name="post" method="post" action="index.php?file=sql_mode/set">
<table border="0" width="100%">
    <tr>
        <td colspan="2" align="center">
            <h1>SQL Session Mode Status</h1> <a target="_blank" href="http://dev.mysql.com/doc/refman/5.0/en/server-sql-mode.html">[HELP]</a>
        </td>
   </tr>
   <tr class="tableh1">
            <th>Name</th>
            <th>Enabled</th>
       </tr>
EOT;
    
    foreach ($modes as $mode=>$enabled) {
        echo "<tr>\n";            
    echo "<th class=\"tableh2\">$mode</th>\n";
    echo "<td class=\"tableb\"><input type=\"checkbox\" name=\"$mode\" $enabled /></td>\n";
    echo "</tr>\n";
}
    
echo <<<EOT
</table>
<input value="{$lang_thumb_view['submit']}" class="mainoption" name="submit" type="submit">
    </form>
EOT;

pagefooter();
?>