<?php
/**
 * Vital_Sign
 * 
 * @package HDI
 * @author HDI
 * @copyright 2013
 * @version $Id$
 * @access public
 */
class Vital_Sign
{
    // Init
    private $database_obj = NULL;
    private static $table_name = 'vital_signs';
    
    public $vital_sign_id, $patient_id, $user_id, $temp, $bp, $entry_date;
    
    /**
     * Vital_Sign::__construct()
     * 
     * @return void
     */
    public function __construct()
    {
        $this->database_obj = Database::obj();
    }
    
    /**
     * Vital_Sign::query()
     * 
     * @param mixed $args
     * @return
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
     * Vital_Sign::set_vital_sign_vars()
     * 
     * @param mixed $arr
     * @return void
     */
    public function set_vital_sign_vars($arr = array())
    {
        if(isset($this->document_id))
        {
            // Initialize class properties
            $this->document_id    = isset($arr['vital_sign_id'])  ? $arr['vital_sign_id']:  $this->vital_sign_id;
            $this->patient_id     = isset($arr['patient_id'])     ? $arr['patient_id']:     $this->patient_id ;
            $this->user_id        = isset($arr['user_id'])        ? $arr['user_id']:         $this->user_id;
            $this->temp           = isset($arr['temp'])           ? $arr['temp']:           $this->temp;
            $this->bp             = isset($arr['bp'])             ? $arr['bp']:             $this->bp;
            $this->entry_date     = isset($arr['entry_date'])     ? $arr['entry_date']:     $this->entry_date;
        } else {
            // Initialize class properties
            $this->document_id    = isset($arr['vital_sign_id'])  ? $arr['vital_sign_id']:  '';
            $this->patient_id     = isset($arr['patient_id'])     ? $arr['patient_id']:     '';
            $this->user_id        = isset($arr['user_id'])        ? $arr['user_id']:        '';
            $this->temp           = isset($arr['temp'])           ? $arr['temp']:           '';
            $this->bp             = isset($arr['bp'])             ? $arr['bp']:             '';
            $this->entry_date     = isset($arr['entry_date'])     ? $arr['entry_date']:     '';
        }
    }
    
    /**
     * Vital_Sign::initialize_result_vars()
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
     * Vital_Sign::insert_vital_sign()
     * 
     * Inserts a Vital Sign Entry
     * 
     * @return
     */
    public function insert_vital_sign()
    {
        // SQL
        $sql = " INSERT INTO ".self::$table_name." (patient_id, user_id, temp, bp, entry_date)
                     VALUES (:patient_id, :user_id, :temp, :bp, :entry_date) ";
            
        // Bind
        $bind_array = array(
            ':patient_id'     => array($this->patient_id, PDO::PARAM_STR),
            ':user_id'        => array($this->user_id, PDO::PARAM_STR),
            ':temp'           => array($this->temp, PDO::PARAM_STR),
            ':bp'             => array($this->bp, PDO::PARAM_STR),
            ':entry_date'     => array($this->entry_date, PDO::PARAM_STR)
        );
            
        // Execute
        return  $this->database_obj->execute_query($sql,'',$bind_array);
    }
    
    /**
     * Vital_Sign::update_vital_sign()
     * 
     * Updates a Vital Sign Entry
     * 
     * @return
     */
    public function update_vital_sign()
    {
        // SQL
        $sql = " UPDATE ".self::$table_name." 
                 SET patient_id    = :patient_id,
                 user_id           = :user_id, 
                 temp              = :temp, 
                 bp                = :bp, 
                 entry_date        = :entry_date 
                            
                 WHERE document_id =".$this->vital_sign_id;
        
       // Bind
        $bind_array = array(
            ':patient_id'     => array($this->patient_id, PDO::PARAM_STR),
            ':user_id'        => array($this->user_id, PDO::PARAM_STR),
            ':temp'           => array($this->temp, PDO::PARAM_STR),
            ':bp'             => array($this->bp, PDO::PARAM_STR),
            ':entry_date'     => array($this->entry_date, PDO::PARAM_STR)
        );
            
        // Execute
        return  $this->database_obj->execute_query($sql,'',$bind_array); 
    }
    
} ?>