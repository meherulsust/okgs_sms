<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Authentication user table
|--------------------------------------------------------------------------
|
|
| Table name from where user will be selected to authenticate
| id, useranme, passwd is mandatory field for authentication
*/
  $config['auth_table'] = 'user u';
  
/*
|--------------------------------------------------------------------------
| Authentication user group/role/responsibility table and relation
|--------------------------------------------------------------------------
|
|
| Table name where user goup is defined and there will be a one to
| many relation with the user table.
*/
  $config['auth_group_table'] = 'user_group g';
  $config['auth_goup_relation'] = 'user_group_id = g.id';
  
/*
|--------------------------------------------------------------------------
| Login information available in auth
|--------------------------------------------------------------------------
|
| Login information available to display in auth
| 
*/
  $config['auth_display_fields'] = 'u.id id,username,full_name,mobile_no,email,user_group_id,g.title group_title';
  


  /*
   * DB table fields which will be used to authenticate the user. 
   */
  $config['credential_fields'] = array('username','passwd','u.status'); 
?>