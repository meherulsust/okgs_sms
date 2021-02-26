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
  $config['auth_table'] = 'student st';
  
/*
|--------------------------------------------------------------------------
| Authentication user group/role/responsibility table and relation
|--------------------------------------------------------------------------
|
|
| Table name where user goup is defined and there will be a one to
| many relation with the user table.
*/
  $config['auth_group_table'] = 'personal_details pd';
  $config['auth_goup_relation'] = 'personal_details_id = pd.id';
  
/*
|--------------------------------------------------------------------------
| Login information available in auth
|--------------------------------------------------------------------------
|
| Login information available to display in auth
| 
*/
  $config['auth_display_fields'] = 'st.id id,student_number,CONCAT(first_name," ",last_name) as full_name,pd.email,pd.mobile';
 

/*
|--------------------------------------------------------------------------
| Authentication session variable mapping
|--------------------------------------------------------------------------
|
|
|this will be set as session session variables and auth table column mapping
|in case of successful login.  
*/
  $config['auth_session_vars'] = array('user_id'=>'id','student_number'=>'student_number');
  

  /*
   * DB table fields which will be used to authenticate the user. 
   */
  $config['credential_fields'] = array('st.student_number','passwd','st.status_id'); 
  
?>