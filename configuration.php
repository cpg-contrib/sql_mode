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
  $Source: /cvsroot/cpg-contrib/sql_mode/configuration.php,v $
  $Revision: 1.1 $
  $Author: donnoman $
  $Date: 2006/11/01 05:43:32 $
***************************************************/


$name='SQL_MODE';
$description='Plugin Developer tool to enumerate and set different MySQL query modes';
$author='Donnoman@donovanbray.com from <a href="http://cpg-contrib.org" target="_blank">cpg-contrib.org</a>';
$version='1.0';

$install_info=<<<EOT
    <table border="0" cellspacing="0" cellpadding="0"> 
    <tr>
        <td class="admin_menu"><a target="_blank" href="plugins/sql_mode/README" title="Readme">ReadMe</a></td>    
        <td class="admin_menu"><a href="index.php?file=sql_mode/query" title="Query">Query</a></td>
        <td class="admin_menu"><a href="index.php?file=sql_mode/set" title="Set Query Mode">Set</a></td>
    </tr>
    </table>
EOT;

$extra_info = <<<EOT
    <table border="0" cellspacing="0" cellpadding="0"> 
    <tr>
        <td class="admin_menu"><a target="_blank" href="plugins/sql_mode/README" title="Readme">ReadMe</a></td>    
        <td class="admin_menu"><a href="index.php?file=sql_mode/query" title="Query">Query</a></td>
    </tr>
    </table>
EOT;
?>
