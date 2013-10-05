<?php
/**
 * Session
 * 
 * @package HDI 
 * @author HDI
 * @copyright 2013
 * @version $Id$
 * @access public
 */
class Session
{
    private $logged_in  = false;
    private $patient_id = '';
    public  $user_id;
    public $user_type;
    public  $message;
    
    
    /**
     * Session::__construct()
     * 
     * @return void
     */
    function __construct()
    {
        if(session_id() == '')
        {
            // Start Session
            session_start();
        }
        
        // House keeping                
        $this->check_login();
                
        if($this->logged_in)
        {
            // actions to take right away if user is logged in
            //echo 'User is logged in';
        } else {
            // actions to take right away if user is not logged in
            //echo 'User is not logged in';
        }
    }
    
    /**
     * Session::is_logged_in()
     * 
     * @return Returns true or false
     */
    public function is_logged_in()
    {
        return $this->logged_in;
    }
    
    /**
     * Session::login()
     * 
     * Sets Session variables for the logged in user
     * 
     * @param mixed $user
     * @return void
     */
    public function login($user)
    {
        // database should find user based on username/password
        if($user)
        {
            $this->user_id   = $_SESSION['user_id'] = $user->user_id;
            $this->logged_in = true;
        }
    }
    
    /**
     * Session::set_patient_id()
     * 
     * @param mixed $id
     * @return void
     */
    public function set_patient_id($id)
    {
        $this->patient_id = $_SESSION['patient_id'] = $id;
    }
    
    /**
     * Session::get_patient_id()
     * 
     * @return Returns a Patient ID from the Session Object
     */
    public function get_patient_id()
    {
        if ($this->patient_id == '' && isset($_SESSION['patient_id'])) $this->patient_id = $_SESSION['patient_id'];
        return $this->patient_id;
    }
    
    public function set_session_message($message)
    {
        $this->message = $_SESSION['message'] = $message;
    }
    
    /**
     * Session::get_session_message()
     * 
     * @return Returns a message stored in the session object
     */
    public function get_session_message()
    {
        if ($this->message == '' && isset($_SESSION['message'])) $this->message = $_SESSION['message'];
        return $this->message;
    }
    
    /**
     * Session::logout()
     * 
     * Logs out the currently logged in User
     * 
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['user_id'], $_SESSION['patient_id'], $_SESSION['message']);
        unset($this->user_id, $this->patient_id, $this->message);
        $this->logged_in = false;
        //session_destroy();
        // Redirect
        //redirect_to();
    }
    
    /**
     * Session::check_login()
     * 
     * Checks if a User is logged in or not
     * 
     * @return void
     */
    private function check_login()
    {
        if(isset($_SESSION['user_id']))
        {
            $this->user_id   = $_SESSION['user_id'];
            $this->logged_in = true;
        } else {
            unset($this->user_id);
            $this->logged_in = false;
        }
    }
    
    /**
     * Session::redirect_to()
     * 
     * @param mixed $location
     * @return void
     */
    public function redirect_to( $location = NULL )
    {
        if ($location != NULL)
        {
            header("Location: {$location}");
            exit;
        }
    }
} ?>