<?php
/**
 * Table Definition for user_username
 */
require_once INSTALLDIR.'/classes/Memcached_DataObject.php';

class User_username extends Managed_DataObject
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'user_username';                     // table name
    public $user_id;                        // int(4)  not_null
    public $provider_name;                  // varchar(255)  primary_key not_null
    public $username;                       // varchar(255)  primary_key not_null
    public $created;                        // datetime()   not_null
    public $modified;                       // timestamp()   not_null default_CURRENT_TIMESTAMP

    /* Static get */
    function staticGet($k,$v=null)
    {
        return Memcached_DataObject::staticGet('User_username',$k,$v);
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
    * Register a user with a username on a given provider
    * @param User User object
    * @param string username on the given provider
    * @param provider_name string name of the provider
    * @return mixed User_username instance if the registration succeeded, false if it did not
    */
    static function register($user, $username, $provider_name)
    {
        $user_username = new User_username();
        $user_username->user_id = $user->id;
        $user_username->provider_name = $provider_name;
        $user_username->username = $username;
        $user_username->created = DB_DataObject_Cast::dateTime();

        if($user_username->insert()){
            return $user_username;
        }else{
            return false;
        }
    }

    function table() {
        return array(
            'user_id'     => DB_DATAOBJECT_INT,
            'username'   => DB_DATAOBJECT_STR,
            'provider_name'   => DB_DATAOBJECT_STR ,
            'created'   => DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME
        );
    }

    // now define the keys.
    function keys() {
        return array('provider_name' => 'K', 'username' => 'K');
    
	}


    public static function schemaDef()
    {
	return array(
		'description' => 'local users',
		'fields' => array(
		'id' => array('type' => 'int', 'not null' => true, 'description' => 'foreign key to profile table'),
		'nickname' => array('type' => 'varchar', 'length' => 64, 'description' => 'nickname or username, duped in profile'),
	
                'password' => array('type' => 'varchar', 'length' => 255, 'description' => 'salted password, can be null for OpenID users'),
	
                'email' => array('type' => 'varchar', 'length' => 255, 'description' => 'email address for password recovery etc.'),
	
                'incomingemail' => array('type' => 'varchar', 'length' => 255, 'description' => 'email address for post-by-email'),
	
                'emailnotifysub' => array('type' => 'int', 'size' => 'tiny', 'default' => 1, 'description' => 'Notify by email of subscriptions'),
	
                'emailnotifyfav' => array('type' => 'int', 'size' => 'tiny', 'default' => 1, 'description' => 'Notify by email of favorites'),
	
                'emailnotifynudge' => array('type' => 'int', 'size' => 'tiny', 'default' => 1, 'description' => 'Notify by email of nudges'),
	
                'emailnotifymsg' => array('type' => 'int', 'size' => 'tiny', 'default' => 1, 'description' => 'Notify by email of direct messages'),
	
                'emailnotifyattn' => array('type' => 'int', 'size' => 'tiny', 'default' => 1, 'description' => 'Notify by email of @-replies'),
	
                'emailmicroid' => array('type' => 'int', 'size' => 'tiny', 'default' => 1, 'description' => 'whether to publish email microid'),
	
                'language' => array('type' => 'varchar', 'length' => 50, 'description' => 'preferred language'),
	
                'timezone' => array('type' => 'varchar', 'length' => 50, 'description' => 'timezone'),
	
                'emailpost' => array('type' => 'int', 'size' => 'tiny', 'default' => 1, 'description' => 'Post by email'),
	
                'sms' => array('type' => 'varchar', 'length' => 64, 'description' => 'sms phone number'),
	
                'carrier' => array('type' => 'int', 'description' => 'foreign key to sms_carrier'),
	
                'smsnotify' => array('type' => 'int', 'size' => 'tiny', 'default' => 0, 'description' => 'whether to send notices to SMS'),
	
                'smsreplies' => array('type' => 'int', 'size' => 'tiny', 'default' => 0, 'description' => 'whether to send notices to SMS on replies'),
	
                'smsemail' => array('type' => 'varchar', 'length' => 255, 'description' => 'built from sms and carrier'),
	
                'uri' => array('type' => 'varchar', 'length' => 255, 'description' => 'universally unique identifier, usually a tag URI'),
	
                'autosubscribe' => array('type' => 'int', 'size' => 'tiny', 'default' => 0, 'description' => 'automatically subscribe to users who subscribe to us'),
	
                'subscribe_policy' => array('type' => 'int', 'size' => 'tiny', 'default' => 0, 'description' => '0 = anybody can subscribe; 1 = require approval'),
	
                'urlshorteningservice' => array('type' => 'varchar', 'length' => 50, 'default' => 'internal', 'description' => 'service to use for auto-shortening URLs'),
	
                'inboxed' => array('type' => 'int', 'size' => 'tiny', 'default' => 0, 'description' => 'has an inbox been created for this user?'),
	
                'private_stream' => array('type' => 'int', 'size' => 'tiny', 'default' => 0, 'description' => 'whether to limit all notices to followers only'),
	
	
                'created' => array('type' => 'datetime', 'not null' => true, 'description' => 'date this record was created'),
	
                'modified' => array('type' => 'timestamp', 'not null' => true, 'description' => 'date this record was modified'),
	
            ),
	
            'primary key' => array('id'),
	
            'unique keys' => array(
	
                'user_nickname_key' => array('nickname'),
	
                'user_email_key' => array('email'),
	
                'user_incomingemail_key' => array('incomingemail'),
	
                'user_sms_key' => array('sms'),
	
                'user_uri_key' => array('uri'),
	
            ),
	
            'foreign keys' => array(
	
                'user_id_fkey' => array('profile', array('id' => 'id')),
	
                'user_carrier_fkey' => array('sms_carrier', array('carrier' => 'id')),
	
            ),
	
            'indexes' => array(
	
                'user_smsemail_idx' => array('smsemail'),
	
            ),
	
        );
	}
}
