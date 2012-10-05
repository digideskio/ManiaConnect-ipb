<?php
/**
 * @author Adam Lavin (Lavoaster)
 * @copyright 2012
 * @license http://opensource.org/licenses/mit-license.php The MIT License
 */
if ( ! defined( 'IN_IPB' ) )
{
    print "<h1>Incorrect access</h1>You cannot access this file directly. If you have recently upgraded, make sure you upgraded 'admin.php'.";
    exit();
}

class login_maniaconnect extends login_core implements interface_login
{
/**
*       Properties passed from database entry for this method
*       @access protected
*       @param  array
*/
protected $method_config        = array();
/**
*       Properties passed from conf.php for this method
*       @access protected
*       @param  array
*/
protected $external_conf        = array();

/**
*       Constructor
*       @access public
*       @param  object  ipsRegistry object
*       @param  array   DB entry array
*       @param  array   conf.php array
*/
public function __construct( ipsRegistry $registry, $method, $conf=array() )
{
        $this->method_config    = $method;
        $this->external_conf    = $conf;
        
        require_once( IPS_ROOT_PATH . 'sources/loginauth/maniaconnect/lib/autoload.php' );
                
        parent::__construct( $registry );
}

/**
*       Authenticate the member against your own system
*       @access  public
*       @param   string  Username
*       @param   string  Email Address
*       @param   string  Plain text password entered from log in form
*/
public function authenticate( $username, $email_address, $password )
{
    //Does the board use HTTPS For logins?
    $board_url = ipsRegistry::$settings['logins_over_https'] ? ipsRegistry::$settings['board_url_https'] : ipsRegistry::$settings['board_url'];

    //If the board uses HTTPS For logins and we are not using HTTPS get our butts onto HTTPS. Why? Because open id thinks the same website using http and https are actually different ones
    if(ipsRegistry::$settings['logins_over_https'] and !$_SERVER['HTTPS']) $this->registry->output->silentRedirect( ipsRegistry::$settings['base_url_https']."app=core&amp;module=global&amp;section=login&amp;do=process&amp;use_maniaconnect=1&amp;auth_key=".ipsRegistry::instance()->member()->form_hash );

    $maniaconnect_url = new \Maniaplanet\WebServices\ManiaConnect\Player('cerovan', 'apimp1337');
    $player = '';
    
    // I say, Does this user be who he claims to be?

    if($this->request['use_maniaconnect'])
    {
        $player = $this->registry->output->silentRedirect( $maniaconnect_url->getLoginURL(basic email) );
    }
    
    
    //Passport Please
    if ( $player )
    {
        //We have validated the Identity
        $localMember = $this->DB->buildAndFetch(array('select' => 'member_id', 'from' => 'members', 'where' => "maniaconnectid='".$player->login."'"));
        
        //Have you been here before?        
        if ( $localMember['member_id'] )
        {
            //Welcome Back lets just log you in here
            $this->member_data = IPSMember::load( $localMember['member_id'], 'extendedProfile,groups' );
            $this->return_code = 'SUCCESS';
        }
        else
        {
            //Welcome, lets just set you up a temporary account you can fill in the details in a second
            $email = $name = '';
            
            $this->member_data = $this->createLocalMember( array( 'members'            => array(
                                                                                         'email'                    => $player->email,
                                                                                         'name'                     => $player->player,
                                                                                         'members_l_username'       => strtolower($player->player),
                                                                                         'members_display_name'     => $player->player,
                                                                                         'members_l_display_name'   => strtolower($player->player),
                                                                                         'joined'                   => time(),
                                                                                         'members_created_remote'   => 1,
                                                                                         'maniaconnectid'           => $player,
                                                                                        ),
                                                                                        ) );
            $this->return_code = 'SUCCESS';
        }
        $this->request['rememberMe'] = TRUE;
        return true;
    }
}
}