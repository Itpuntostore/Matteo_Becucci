<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 function freeradius_disconnectuser($username, $radiuscommand, $radiusserver, $radiussecret){
	$ci =& get_instance();
	$result = exec('echo "User-Name=\''.$username.'\'" | '.$radiuscommand.' '.$radiusserver.' disconnect '.$radiussecret);
	$ci->db->query("UPDATE radacct SET acctstoptime=now(), acctterminatecause='Force Disconnect' WHERE username = '$username' and acctstoptime is NULL");
 }
?>
