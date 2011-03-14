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
  $Source: /cvsroot/cpg-contrib/sql_mode/query.php,v $
  $Revision: 1.1 $
  $Author: donnoman $
  $Date: 2006/11/01 05:43:32 $
***************************************************/

require('include/init.inc.php');

pageheader('Query SQLMode');

    if (!GALLERY_ADMIN_MODE) cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);
    
    $query = "SELECT @@global.sql_mode;";
    $result = cpg_db_query($query);
    $global_sql_mode = cpg_db_fetch_rowset($result);
    $global_sql_mode=empty($global_sql_mode[0][0]) ? 'NULL' : $global_sql_mode[0][0];
    
    $query = "SELECT @@session.sql_mode;";
    $result = cpg_db_query($query);
    $session_sql_mode = cpg_db_fetch_rowset($result);
    $session_sql_mode=empty($session_sql_mode[0][0]) ? 'NULL' : $session_sql_mode[0][0];
    
    echo <<<EOT
    <table border="0" width="100%">
        <tr>
            <td colspan="2" align="center">
                <h1>SQL Mode Status</h1>
            </td>
       </tr>
       <tr class="tableh1">
            <th>Name</th>
            <th>Value</th>
       </tr>
       <tr>
            <th class="tableh2">Global SQL Mode</th>
            <td class="tablehb">$global_sql_mode</td>
       </tr>
       <tr>
            <th class="tableh2">Session SQL Mode</th>
            <td class="tablehb">$session_sql_mode</td>
       </tr>
    </table>
EOT;
    
    $query = "SHOW STATUS;";
    $result = cpg_db_query($query);
    $status = cpg_db_fetch_rowset($result);
    
    $entries=count($status)/3;

    $columns[0]=array_slice($status,0,$entries);
    $columns[1]=array_slice($status,$entries,$entries);
    $columns[2]=array_slice($status,2*$entries);

    echo <<<EOT
    <table border="0" width="100%">
        <tr>
            <td colspan="6" align="center">
                <h1>SQL Status</h1>
            </td>
       </tr>
       <tr class="tableh1">
            <th>Name</th>
            <th>Value</th>
            <th>Name</th>
            <th>Value</th>
            <th>Name</th>
            <th>Value</th>
       </tr>
EOT;
    for ($entry=0;$entry<$entries;$entry++) {
        echo "<tr>\n";
        for ($column=0;$column<3;$column++) {
            echo "<th class=\"tableh2\">{$columns[$column][$entry]['Variable_name']}</th>\n";
            echo "<td class=\"tableb\">{$columns[$column][$entry]['Value']}</td>\n";
        }
        echo "</tr>\n";
    }
    echo "</table>\n";
echo <<<EOT
    <form action="pluginmgr.php" method="post">
        <input type="submit" name="submit" value="$lang_continue" />
    </form>
EOT;
pagefooter();

?>