<?php
    require_once( INCLUDES.DIRECTORY_SEPARATOR.'functions.php' );

/**
 * Int_Profile
 * 
 * @package HDI
 * @author HDI
 * @copyright 2013
 * @version $Id$
 * @access public
 */
class Int_Profile
{
    // Init.
    private $database_obj      = NULL;
    private $session_obj       = NULL;
    private $kinship_obj       = NULL;
    private static $table_name = 'int_profiles';
    
    public $int_profile_id, $user_id, $title, $first_name, $middle_name, $surname, $gender, $address, $email, 
           $phone_1, $phone_2, $date_of_birth, $marital_status, $religion, $qualification, $country, 
           $kin_first_name, $kin_middle_name, $kin_surname, $kin_gender, $kin_address, $kin_email, 
           $kin_phone_1, $kin_phone_2, $relationship;
    
    public function __construct()
    {
        $this->database_obj       = Database::obj();
        $this->session_obj        = new Session();
        $this->kinship_obj        = new Kinship();
    }
    
    /**
     * Documents::query()
     * 
     * Executes a specified query
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
    
    /**
     * Int_Profile::set_profile_vars()
     * 
     * @param mixed $arr
     * @return void
     */
    public function set_profile_vars($arr = array())
    {
        if(isset($this->int_profile_id))
        {
            // Initialize class properties
        $this->int_profile_id     = isset($arr['int_profile_id'])    ? $arr['int_profile_id']: $this->int_profile_id;
        $this->user_id            = isset($arr['user_id'])           ? $arr['user_id']:        $this->user_id;
        $this->title              = isset($arr['sel_title'])         ? $arr['sel_title']:      $this->title;
        $this->first_name         = isset($arr['txt_fname'])         ? $arr['txt_fname']:      $this->first_name;
        $this->middle_name        = isset($arr['txt_mname'])         ? $arr['txt_mname']:      $this->middle_name;
        $this->surname            = isset($arr['txt_sname'])         ? $arr['txt_sname']:      $this->surname;
        $this->gender             = isset($arr['sel_gender'])        ? $arr['sel_gender']:     $this->gender;
        $this->address            = isset($arr['txta_address'])      ? $arr['txta_address']:   $this->address;
        $this->email              = isset($arr['txt_email'])         ? $arr['txt_email']:      $this->email; 
        $this->phone_1            = isset($arr['txt_phone1'])        ? $arr['txt_phone1']:     $this->phone_1;
        $this->phone_2            = isset($arr['txt_phone2'])        ? $arr['txt_phone2']:     $this->phone_2;
        if(isset($arr['txt_dob']))
        {
            $this->date_of_birth  = standardize_date($arr['txt_dob'], '/');
        } else {
            $this->date_of_birth  = $this->date_of_birth;
        }
        $this->marital_status     = isset($arr['sel_marital'])       ? $arr['sel_marital']:    $this->marital_status;
        $this->religion           = isset($arr['sel_religion'])      ? $arr['sel_religion']:   $this->religion;
        $this->qualification      = isset($arr['qualification'])     ? $arr['qualification']:  $this->qualification;
        $this->country            = isset($arr['sel_country'])       ? $arr['sel_country']:    $this->country;
        }else{
            // Initialize class properties
        $this->int_profile_id     = isset($arr['int_profile_id'])    ? $arr['int_profile_id']: '';
        $this->user_id            = isset($arr['user_id'])           ? $arr['user_id']:        '';
        $this->title              = isset($arr['sel_title'])         ? $arr['sel_title']:      '';
        $this->first_name         = isset($arr['txt_fname'])         ? $arr['txt_fname']:      '';
        $this->middle_name        = isset($arr['txt_mname'])         ? $arr['txt_mname']:      '';
        $this->surname            = isset($arr['txt_sname'])         ? $arr['txt_sname']:      '';
        $this->gender             = isset($arr['sel_gender'])        ? $arr['sel_gender']:     '';
        $this->address            = isset($arr['txta_address'])      ? $arr['txta_address']:   '';
        $this->email              = isset($arr['txt_email'])         ? $arr['txt_email']:      ''; 
        $this->phone_1            = isset($arr['txt_phone1'])        ? $arr['txt_phone1']:     '';
        $this->phone_2            = isset($arr['txt_phone2'])        ? $arr['txt_phone2']:     '';
        if(isset($arr['txt_dob']))
        {
            $this->date_of_birth  = standardize_date($arr['txt_dob'], '/');
        } else {
            $this->date_of_birth  = '0000-00-00 00:00:00';
        }
        $this->marital_status     = isset($arr['sel_marital'])       ? $arr['sel_marital']:    '';
        $this->religion           = isset($arr['sel_religion'])      ? $arr['sel_religion']:   '';
        $this->qualification      = isset($arr['qualification'])     ? $arr['qualification']:  '';
        $this->country            = isset($arr['sel_country'])       ? $arr['sel_country']:    '';
        }
    }
    
    /**
     * Int_Profile::who_am_i()
     * 
     * @param mixed $user_id
     * @return void
     */
    public static function who_am_i($user_id)
    {
        // Init.
        $result = array();
        
        if('' != $user_id)
        {
            // SQL
            $sql = "SELECT int_profile_id, CONCAT(o.option_name,' ',i.surname,', ',i.first_name) as name
                    FROM ".self::$table_name." i
                    INNER JOIN options o
                    ON o.option_id=i.title
                    WHERE i.user_id='$user_id'
                    LIMIT 1";
            
            // Execute
            $exec = Database::obj()->execute_query($sql,'Array');
            
            // Display the Logged in User
            if (!empty($exec)) $result = $exec[0];
        }
        
        return $result;
    }
    
    /**
     * Int_Profile::dropdown_list()
     * 
     * @param mixed $option_name
     * @return
     */
    public function dropdown_list($option_name)
    {
        if('' != $option_name)
        {
            // SQL
            $sql = "SELECT CONCAT(o.option_name,' ',i.surname,', ',i.first_name) as name, i.int_profile_id as id
                    FROM ".self::$table_name." i
                    INNER JOIN options o
                    ON o.option_id=i.title
                    WHERE i.user_id
                    IN (SELECT id FROM users WHERE user_type = (SELECT option_id FROM options WHERE option_name='{$option_name}' AND group_name='user'))
                    ORDER BY i.surname";
        
            // Execute
            return $this->database_obj->execute_query($sql,'Array');
        }
    }
    
    /**
     * Int_Profile::fetch_profile_by_user_id()
     * 
     * Fetches an internal Profile based on a specified User ID 
     * 
     * @param mixed $user_id
     * @return Returns an internal User Profile
     */
    public function fetch_profile_by_user_id($user_id)
    {
        // SQL
        $sql = "SELECT i.int_profile_id, i.title, i.first_name, i.middle_name, i.surname, i.gender, i.address, i.email, i.phone_1, i.phone_2,
                       i.date_of_birth, i.marital_status, i.religion, i.qualification, i.country, k.first_name AS kin_first_name,
                       k.middle_name AS kin_middle_name, k.surname AS kin_surname, k.gender AS kin_gender, k.address AS 
                       kin_address, k.email AS kin_email, k.phone_1 AS kin_phone_1, k.phone_2 AS kin_phone_2, k.relationship AS relationship
                FROM ".self::$table_name." i
                INNER JOIN kinships k
                ON i.int_profile_id=k.int_profile_id
                WHERE i.user_id={$user_id}
                LIMIT 1
                ";
        
        // Result
        return self::initialize_result_vars($this->database_obj->execute_query($sql,'A'));
    }
    
    /**
     * Int_Profile::initialize_result_vars()
     * 
     * Initializes class attributes with query result
     * 
     * @param mixed $args
     * @return void
     */
    private function initialize_result_vars($args = array())
    {
        // Retreive the first index $args[0] of the multi-dymensional array returned by PDO fetchAll(PDO::FETCH_ASSOC)   
        foreach($args as $index)
        {
            // Builds all indexes into their corresponding Class properties
            foreach($index as $key => $val)
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
        }
        // Returns initialied Class attributes with $this for possible method chaining
        return $this;
    }
    
    /**
     * Int_Profile::insert_profile()
     * 
     * Creates an Internal User Profile
     * 
     * @return
     */
    public function insert_profile()
    {
        // Start transaction
        $this->database_obj->begin_transaction();
        
        // SQL
        $sql = "INSERT INTO ".self::$table_name." (title, first_name, middle_name, surname, gender, address, email, phone_1, phone_2, date_of_birth, marital_status, religion, qualification, country)
                VALUES (:title, :first_name, :middle_name, :surname, :gender, :address, :email, :phone_1, :phone_2, :date_of_birth, :marital_status, :religion, :qualification, :country)";
        
        // Bind
        $bind_array = array(
            ':int_profile_id'     => array($this->int_profile_id, PDO::PARAM_INT),
            ':title'              => array($this->title, PDO::PARAM_INT),
            ':first_name'         => array($this->first_name, PDO::PARAM_STR),
            ':middle_name'        => array($this->middle_name, PDO::PARAM_STR),
            ':surname'            => array($this->surname, PDO::PARAM_STR),
            ':gender'             => array($this->gender, PDO::PARAM_STR),
            ':address'            => array($this->address, PDO::PARAM_STR),
            ':email'              => array($this->email, PDO::PARAM_STR),
            ':phone_1'            => array($this->phone_1, PDO::PARAM_STR),
            ':phone_2'            => array($this->phone_2, PDO::PARAM_STR),
            ':date_of_birth'      => array($this->date_of_birth, PDO::PARAM_STR),
            ':marital_status'     => array($this->marital_status, PDO::PARAM_INT),
            ':religion'           => array($this->religion, PDO::PARAM_INT),
            ':qualification'      => array($this->qualification, PDO::PARAM_STR),
            ':country'            => array($this->country, PDO::PARAM_INT)
        );
        
        $status = $this->database_obj->execute_query($sql,'',$bind_array);
        
        // Transaction status
        if ($status === true)
        {
            if ($this->kinship_obj instanceof Kinship)
            {
                // Insert the Kinship (Next of Kin)
                
            }
            else
            {
                $status = false;
            }
               
        }else{
             // Roll back transaction
            $this->database_obj->roll_back();
        }
        return $status;
    }
    
    /**
     * Int_Profile::update_profile()
     * 
     * Updates an Internal User Profile
     * 
     * @return Returns update status
     */
    public function update_profile()
    {
        // Start transaction
        //$this->database_obj->begin_transaction();
        
        // SQL
        $sql = "UPDATE ".self::$table_name." 
        
                SET title                = :title,
                    first_name           = :first_name,
                    middle_name          = :middle_name,
                    surname              = :surname,
                    gender               = :gender,
                    address              = :address,
                    email                = :email,
                    phone_1              = :phone_1,
                    phone_2              = :phone_2,
                    date_of_birth        = :date_of_birth,
                    marital_status       = :marital_status,
                    religion             = :religion,
                    qualification        = :qualification,
                    country              = :country
                    
                    WHERE int_profile_id = :int_profile_id";
                    
        // Bind
        $bind_array = array(
            ':int_profile_id'     => array($this->int_profile_id, PDO::PARAM_INT),
            ':title'              => array($this->title, PDO::PARAM_INT),
            ':first_name'         => array($this->first_name, PDO::PARAM_STR),
            ':middle_name'        => array($this->middle_name, PDO::PARAM_STR),
            ':surname'            => array($this->surname, PDO::PARAM_STR),
            ':gender'             => array($this->gender, PDO::PARAM_STR),
            ':address'            => array($this->address, PDO::PARAM_STR),
            ':email'              => array($this->email, PDO::PARAM_STR),
            ':phone_1'            => array($this->phone_1, PDO::PARAM_STR),
            ':phone_2'            => array($this->phone_2, PDO::PARAM_STR),
            ':date_of_birth'      => array($this->date_of_birth, PDO::PARAM_STR),
            ':marital_status'     => array($this->marital_status, PDO::PARAM_INT),
            ':religion'           => array($this->religion, PDO::PARAM_INT),
            ':qualification'      => array($this->qualification, PDO::PARAM_STR),
            ':country'            => array($this->country, PDO::PARAM_INT)
        );            
        
        // Execute
        $status = $this->database_obj->execute_query($sql,'',$bind_array);
        
        // Transaction status
        /*if ($status === true)
        {
            if ($this->kinship_obj instanceof Kinship)
            {
                // Insert the Kinship (Next of Kin)
                $status = $this->kinship_obj->update_kinship($post, $this->session_obj->user_id);
            }
            else
            {
                $status = false;
            }
               
        }else{
             // Roll back transaction
            $this->database_obj->roll_back();
        }*/
        
        return $status;
    }
    

} ?>

