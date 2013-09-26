<?php
/**
 * Kinship
 * 
 * @package HDI
 * @author lolkittens
 * @copyright 2013
 * @version $Id$
 * @access public
 */
class Kinship
{
    private $database_obj = NULL;
    private static $table_name = 'kinships';
    public $kinship_id, $patient_id, $int_profile_id ,$first_name, $middle_name, $surname, 
           $gender, $address, $email, $phone_1, $phone_2, $relationship;
    
    /**
     * Kinship::__construct()
     * 
     * @return void
     */
    public function __construct()
    {
        $this->database_obj = Database::obj();
    }
    
    /**
     * Kinship::query()
     * 
     * @param mixed $args
     * @return Returns a database query execution
     */
    public function query($args=array())
    {
        // SQL
        $sql    = (isset($args['select'])) ? " SELECT {$args['select']} "  : '';
        $sql   .= (isset($args['from']))   ? " FROM {$args['from']} "      : '';
        $sql   .= (isset($args['where']))  ? " WHERE {$args['where']} "    : '';
        $sql   .= (isset($args['and']))    ? " AND {$args['and']} "        : '';
        $sql   .= (isset($args['like']))   ? " LIKE {$args['like']} "      : '';
        $sql   .= (isset($args['group']))  ? " GROUP BY {$args['group']} " : '';
        $sql   .= (isset($args['order']))  ? " ORDER BY {$args['order']} " : '';
        $sql   .= (isset($args['limit']))  ? " LIMIT {$args['limit']} "    : '';
        
        // Format
        $format = (isset($args['format'])) ? $args['format'] : 'Object';
        
        // Return
        return $this->database_obj->execute_query($sql,$format);
    }
    
    /**
     * Kinship::set_kinship_vars()
     * 
     * @param mixed $arr
     * @return void
     */
    public function set_kinship_vars($arr = array())
    {
        if(isset($this->kinship_id))
        {
            // Initialize class properties
            $this->kinship_id         = isset($arr['kinship_id'])            ? $arr['kinship_id']:         $this->kinship_id;
            $this->patient_id         = isset($arr['patient_id'])            ? $arr['patient_id']:         $this->patient_id ;
            $this->int_profile_id     = isset($arr['int_profile_id'])        ? $arr['int_profile_id']:     $this->int_profile_id;
            $this->first_name         = isset($arr['txt_kin_fname'])         ? $arr['txt_kin_fname']:      $this->first_name;
            $this->middle_name        = isset($arr['txt_kin_mname'])         ? $arr['txt_kin_mname']:      $this->middle_name;
            $this->surname            = isset($arr['txt_kin_sname'])         ? $arr['txt_kin_sname']:      $this->surname;
            $this->gender             = isset($arr['sel_kin_gender'])        ? $arr['sel_kin_gender']:     $this->gender;
            $this->address            = isset($arr['txta_kin_address'])      ? $arr['txta_kin_address']:   $this->gender;
            $this->email              = isset($arr['tx_kint_email'])         ? $arr['txt_kin_email']:      $this->address; 
            $this->phone_1            = isset($arr['txt_kin_phone1'])        ? $arr['txt_kin_phone1']:     $this->phone_1;
            $this->phone_2            = isset($arr['txt_kin_phone2'])        ? $arr['txt_kin_phone2']:     $this->phone_2;
            $this->relationship       = isset($arr['sel_kin_relate'])        ? $arr['sel_kin_relate']:     $this->relationship;
        } else {
            // Initialize class properties
            $this->kinship_id         = isset($arr['kinship_id'])            ? $arr['kinship_id']:         '';
            $this->patient_id         = isset($arr['patient_id'])            ? $arr['patient_id']:         '';
            $this->int_profile_id     = isset($arr['int_profile_id'])        ? $arr['int_profile_id']:     '';
            $this->first_name         = isset($arr['txt_kin_fname'])         ? $arr['txt_kin_fname']:      '';
            $this->middle_name        = isset($arr['txt_kin_mname'])         ? $arr['txt_kin_mname']:      '';
            $this->surname            = isset($arr['txt_kin_sname'])         ? $arr['txt_kin_sname']:      '';
            $this->gender             = isset($arr['sel_kin_gender'])        ? $arr['sel_kin_gender']:     '';
            $this->address            = isset($arr['txta_kin_address'])      ? $arr['txta_kin_address']:   '';
            $this->email              = isset($arr['tx_kint_email'])         ? $arr['txt_kin_email']:      ''; 
            $this->phone_1            = isset($arr['txt_kin_phone1'])        ? $arr['txt_kin_phone1']:     '';
            $this->phone_2            = isset($arr['txt_kin_phone2'])        ? $arr['txt_kin_phone2']:     '';
            $this->relationship       = isset($arr['sel_kin_relate'])        ? $arr['sel_kin_relate']:     '';
        }
    }
    
    /**
     * Kinship::fetch_kin_by_patient_id()
     * 
     * @param mixed $patient_id
     * @return Returns a next of kin associated with a specified Patient ID
     */
    public function fetch_kin_by_patient_id($patient_id)
    {
        // Execute query
        $query = $this->query(array(
            'select' => "*",
            'from'   => self::$table_name,
            'where'  => "patient_id={$patient_id}",
            'limit'  => "1",
            'format' => 'Array'
        ));
        // Result
        return self::initialize_result_vars($query);
    }
    
    /**
     * Kinship::fetch_kin_by_int_profile_id()
     * 
     * @param mixed $int_profile_id
     * @return Returns a next of kin associated with a specified Internal Profile ID
     */
    public function fetch_kin_by_int_profile_id($int_profile_id)
    {
        // Execute query
        $query = $this->query(array(
            'select' => "*",
            'from'   => self::$table_name,
            'where'  => "int_profile_id={$int_profile_id}",
            'limit'  => "1",
            'format' => 'Array'
        ));
        // Result
        return self::initialize_result_vars($query);
    }
    
    /**
     * Kinship::initialize_result_vars()
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
     * Kinship::insert_kinship()
     * 
     * Inserts a next of kin record
     * 
     * @return
     */
    public function insert_kinship()
    {
            // SQL
            $sql = " INSERT INTO ".self::$table_name." (patient_id, int_profile_id, first_name, middle_name, surname, gender, address, email, phone_1, phone_2, relationship)
                     VALUES (:patient_id, :int_profile_id, :first_name, :middle_name, :surname, :gender, :address, :email, :phone_1, :phone_2, :relationship) ";
            
            // Bind
            $bind_array = array(
                ':patient_id'       => array($this->patient_id, PDO::PARAM_STR),
                ':int_profile_id'   => array($this->int_profile_id, PDO::PARAM_STR),
                ':first_name'       => array($this->first_name, PDO::PARAM_STR),
                ':middle_name'      => array($this->middle_name, PDO::PARAM_STR),
                ':surname'          => array($this->surname, PDO::PARAM_STR),
                ':gender'           => array($this->gender, PDO::PARAM_STR),
                ':address'          => array($this->address, PDO::PARAM_STR),
                ':email'            => array($this->email, PDO::PARAM_STR),
                ':phone_1'          => array($this->phone_1, PDO::PARAM_STR),
                ':phone_2'          => array($this->phone_2, PDO::PARAM_STR),
                ':relationship'     => array($this->relationship, PDO::PARAM_INT)
            );
            
            // Execute
            return $this->database_obj->execute_query($sql,'',$bind_array);
    }
    
    /**
     * Kinship::update_kinship()
     * 
     * Updates a next of kin record
     * 
     * @return
     */
    public function update_kinship()
    {
            // SQL
            $sql = " UPDATE ".self::$table_name." 
            
                     SET patient_id        = :patient_id,
                         int_profile_id    = :int_profile_id,
                         first_name   = :first_name,
                         middle_name  = :middle_name,
                         surname      = :surname,
                         gender       = :gender,
                         address      = :address,
                         email        = :email,
                         phone_1      = :phone_1,
                         phone_2      = :phone_2,
                         relationship = :relationship
                         
                     WHERE kinship_id =".$this->kinship_id;
            
            // Bind
            $bind_array = array(
                ':patient_id'       => array($this->patient_id, PDO::PARAM_STR),
                ':int_profile_id'   => array($this->int_profile_id, PDO::PARAM_STR),
                ':first_name'       => array($this->first_name, PDO::PARAM_STR),
                ':middle_name'      => array($this->middle_name, PDO::PARAM_STR),
                ':surname'          => array($this->surname, PDO::PARAM_STR),
                ':gender'           => array($this->gender, PDO::PARAM_STR),
                ':address'          => array($this->address, PDO::PARAM_STR),
                ':email'            => array($this->email, PDO::PARAM_STR),
                ':phone_1'          => array($this->phone_1, PDO::PARAM_STR),
                ':phone_2'          => array($this->phone_2, PDO::PARAM_STR),
                ':relationship'     => array($this->relationship, PDO::PARAM_INT)
            );
            
            // Execute
            return $this->database_obj->execute_query($sql,'',$bind_array);
    }
}
?>