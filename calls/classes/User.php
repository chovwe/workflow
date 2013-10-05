<?php
/**
 * User
 * 
 * @package HDI
 * @author HDI
 * @copyright 2013
 * @version $Id$
 * @access public
 */
class User
{
    private $database_obj      = NULL;
    private static $table_name = "users";
    
    public $user_id, $login_id, $passcode, $user_type, $date_created;
    
    /**
     * User::__construct()
     * 
     * @return void
     */
    public function __construct()
    {
        $this->database_obj = Database::obj();
    }
    
    /**
     * User::query()
     * 
     * @param mixed $args
     * @return
     */
    public function query($args=array())
    {
        // SQL
        $sql    = (isset($args['select']))       ? " SELECT {$args['select']} "        : '';
        $sql   .= (isset($args['from']))         ? " FROM {$args['from']} "            : '';
        $sql   .= (isset($args['join']))         ? " JOIN {$args['join']} "            : '';
        $sql   .= (isset($args['inner join']))   ? " INNER JOIN {$args['inner join']} ": '';
        $sql   .= (isset($args['on']))           ? " ON {$args['on']} "                : '';
        $sql   .= (isset($args['where']))        ? " WHERE {$args['where']} "          : '';
        $sql   .= (isset($args['and']))          ? " AND {$args['and']} "              : '';
        $sql   .= (isset($args['or']))           ? " OR {$args['or']} "                : '';
        $sql   .= (isset($args['like']))         ? " LIKE {$args['like']} "            : '';
        $sql   .= (isset($args['group']))        ? " GROUP BY {$args['group']} "       : '';
        $sql   .= (isset($args['order']))        ? " ORDER BY {$args['order']} "       : '';
        $sql   .= (isset($args['limit']))        ? " LIMIT {$args['limit']} "          : '';
        
        // Format
        $format = (isset($args['format'])) ? $args['format'] : 'Object';
        
        // Return
        return $this->database_obj->execute_query($sql,$format);
    }
    
     public function set_user_vars($arr = array())
    {
        if(isset($this->user_id))
        {
            // Initialize class properties
            /*$this->user_id          = isset($arr['user_id'])      ? $arr['user_id']:       $this->user_id;
            $this->login_id         = isset($arr['login_id'])    ? $arr['login_id']:    $this->login_id;
            $this->passcode         = isset($arr['passcode'])    ? $arr['passcode']:     $this->passcode;
            $this->user_type        = isset($arr['user_type'])   ? $arr['user_type']:    $this->user_type;
            $this->date_created     = isset($arr['date_created'])? $arr['date_created']: $this->date_created;*/
            // Builds all indexes into their corresponding Class properties
            foreach($arr as $key => $val)
            {
                // Will only accept keys that have been explicitly defined as Class property
                if(property_exists($this, $key))
                {
                    // Will only assign values to Class attributes if the specified key is set
                    if(isset($key))
                    {
                        $this->{$key} = $val;
                    }
                }
            }
        }else{
            $this->login_id         = isset($arr['login_id'])    ? $arr['login_id']:    '';
            $this->passcode         = isset($arr['passcode'])    ? $arr['passcode']:    '';
            $this->user_type        = isset($arr['user_type'])   ? $arr['user_type']:   '';
            $this->date_created     = isset($arr['date_created'])? $arr['date_created']:'';
        }
    }
    
    public function fetch_user_type_by_id($user_id)
    {
        
    }
}
?>