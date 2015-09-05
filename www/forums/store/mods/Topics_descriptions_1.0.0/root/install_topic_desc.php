<?php
/** 
*
* @package phpBB3
* @version $Id: install_topic_desc.php, v1.0.0 2009-12-31 00mohgta7 $
* @copyright (c) 2005 phpBB Group 
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
* @ignore
*/
define('IN_PHPBB', true);
$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/acp/auth.' . $phpEx);
include($phpbb_root_path . 'includes/db/db_tools.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

// only admins or founders can install topic descriptions
if (!$auth->acl_get('a_') && !$user->data['user_type'] != USER_FOUNDER)
{
	trigger_error($user->lang['NOT_AUTHORISED']);
}

$db_tools = new phpbb_db_tools($db);

// Add new column 'topic_desc' if not already exists in topics table
if (!$db_tools->sql_column_exists(TOPICS_TABLE, 'topic_desc'))
{
	$db_tools->sql_column_add(TOPICS_TABLE, 'topic_desc', array('VCHAR_UNI', ''));
}

$auth_admin = new auth_admin();

// Add local permission for describe topics
$auth_admin->acl_add_option(array(
    'local'        => array('f_topic_desc')
));

// update default roles (full/standard/polls access)
$roles = array('ROLE_FORUM_FULL', 'ROLE_FORUM_STANDARD', 'ROLE_FORUM_POLLS');
foreach ($roles as $role_name)
{
	update_role_permissions('grant', $role_name, array('f_topic_desc'), ACL_YES);
}
														  
$return = sprintf($user->lang['RETURN_INDEX'], '<a href="' . append_sid("{$phpbb_root_path}index.$phpEx") . '">', '</a>');
trigger_error('Topics descriptions is now installed. Please delete this file from your FTP.<br /><br />' . $return);


/**
* Update role-specific ACL options. Function can grant or remove options. If option already granted it will NOT be updated.
*
* @param grant|remove $mode defines whether roles are granted to removed
* @param strong $role_name role name to update
* @param mixed $options auth_options to grant (a auth_option has to be specified)
* @param ACL_YES|ACL_NO|ACL_NEVER $auth_setting defines the mode acl_options are getting set with
*
* Function from http://www.phpbb.com/kb/article/permission-system-overview-for-mod-authors-part-two/
*/
function update_role_permissions($mode = 'grant', $role_name, $options = array(), $auth_setting = ACL_YES)
{
	global $db, $auth, $cache;

	//First We Get Role ID
	$sql = "SELECT r.role_id
		FROM " . ACL_ROLES_TABLE . " r
		WHERE role_name = '$role_name'";
	$result = $db->sql_query($sql);
	$role_id = (int) $db->sql_fetchfield('role_id');
	$db->sql_freeresult($result);

	//Now Lets Get All Current Options For Role
	$role_options = array();
	$sql = "SELECT auth_option_id
		FROM " . ACL_ROLES_DATA_TABLE . "
		WHERE role_id = " . (int) $role_id . "
		GROUP BY auth_option_id";
	$result = $db->sql_query($sql);
	while ($row = $db->sql_fetchrow($result))
	{
		$role_options[] = $row;
	}
	$db->sql_freeresult($result);

	//Get Option ID Values For Options Granting Or Removing
	$acl_options_ids = array();
	$sql = "SELECT auth_option_id
		FROM " . ACL_OPTIONS_TABLE . "
		WHERE " . $db->sql_in_set('auth_option', $options) . "
		GROUP BY auth_option_id";
	$result = $db->sql_query($sql);
	while ($row = $db->sql_fetchrow($result))
	{
		$acl_options_ids[] = $row;
	}
	$db->sql_freeresult($result);


	//If Granting Permissions
	if ($mode == 'grant')
	{
		//Make Sure We Have Option IDs
		if (empty($acl_options_ids))
		{
			return false;
		}
		
		//Build SQL Array For Query
		$sql_ary = array();
		for ($i = 0, $count = sizeof($acl_options_ids);$i < $count; $i++)
		{

			//If Option Already Granted To Role Then Skip It
			if (in_array($acl_options_ids[$i]['auth_option_id'], $role_options))
			{
				continue;
			}
			$sql_ary[] = array(
				'role_id'        => (int) $role_id,
				'auth_option_id'    => (int) $acl_options_ids[$i]['auth_option_id'],
				'auth_setting'        => $auth_setting,
			);
		}

		$db->sql_multi_insert(ACL_ROLES_DATA_TABLE, $sql_ary);
		$cache->destroy('acl_options');
		$auth->acl_clear_prefetch();
	}

	//If Removing Permissions
	if ($mode == 'remove')
	{
		//Make Sure We Have Option IDs
		if (empty($acl_options_ids))
		{
			return false;
		}
		
		//Process Each Option To Remove
		for ($i = 0, $count = sizeof($acl_options_ids);$i < $count; $i++)
		{
			$sql = "DELETE
				FROM " . ACL_ROLES_DATA_TABLE . "
				WHERE auth_option_id = " . $acl_options_ids[$i]['auth_option_id'];

			$db->sql_query($sql);
		}

		$cache->destroy('acl_options');
		$auth->acl_clear_prefetch();
	}

	return;
}

?>