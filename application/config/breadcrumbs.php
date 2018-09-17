<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| BREADCRUMB CONFIG
| -------------------------------------------------------------------
| This file will contain some breadcrumbs' settings.
|
| $config['crumb_divider']		The string used to divide the crumbs
| $config['tag_open'] 			The opening tag for breadcrumb's holder.
| $config['tag_close'] 			The closing tag for breadcrumb's holder.
| $config['crumb_open'] 		The opening tag for breadcrumb's holder.
| $config['crumb_close'] 		The closing tag for breadcrumb's holder.
|
| Defaults provided for twitter bootstrap 2.0
 * 
 * <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Forms
                            </li>
   </ol>
 * 
 * 
*/

$config['crumb_divider'] = '';
$config['tag_open'] = '<ol class="breadcrumb">';
$config['tag_close'] = '</ol>';
$config['crumb_open'] = '<li>';
$config['crumb_last_open'] = '<li class="active">';
$config['crumb_close'] = '</li>';


/* End of file breadcrumbs.php */
/* Location: ./application/config/breadcrumbs.php */