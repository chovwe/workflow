<?php 
/**
 * Note
 * 
 * @package HDI
 * @author HDI
 * @copyright 2013
 * @version $Id$
 * @access public
 */
class Note {
    // Init
    private $database_obj = NULL;
    private static $table_name = 'notes';
    
    public $note_id, $consultation_id, $admission_id, $int_profile_id, $patient_id, $note, $entry_date;
        
    
    /**
     * Note::__construct()
     * 
     * @return void
     */
    public function __construct()
    {
            $this->database_obj = Database::obj();
    }
    
    /**
     * Note::query()
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
     * Note::set_note_vars()
     * 
     * @param mixed $arr
     * @return void
     */
    public function set_note_vars($arr = array())
    {
        if(isset($this->note_id))
        {
            // Initialize class properties
            /*$this->note_id         = isset($arr['note_id'])         ? $arr['note_id']:         $this->note_id;
            $this->consultation_id = isset($arr['consultation_id']) ? $arr['consultation_id']: $this->consultation_id;
            $this->admission_id    = isset($arr['admission_id'])    ? $arr['admission_id']:    $this->admission_id;
            $this->int_profile_id  = isset($arr['int_profile_id'])  ? $arr['int_profile_id']:  $this->int_profile_id;
            $this->patient_id      = isset($arr['patient_id'])      ? $arr['patient_id']:      $this->patient_id;
            $this->note            = isset($arr['note'])            ? $arr['note']:            $this->note;
            $this->entry_date      = isset($arr['entry_date'])      ? $arr['entry_date']:      $this->entry_date;*/
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
            $this->consultation_id = isset($arr['consultation_id']) ? $arr['consultation_id']: '';
            $this->admission_id    = isset($arr['admission_id'])    ? $arr['admission_id']:    '';
            $this->int_profile_id  = isset($arr['int_profile_id'])  ? $arr['int_profile_id']:  '';
            $this->patient_id      = isset($arr['patient_id'])      ? $arr['patient_id']:      '';
            $this->note            = isset($arr['note'])            ? $arr['note']:            '';
            $this->entry_date      = isset($arr['entry_date'])      ? $arr['entry_date']:      '';
        }
    }
    
    public function fetch_all()
    {
        
    }
    
    public function fetch_by_patient_id($patient_id)
    {
        // SQL
        $sql = "SELECT n.note_id, n.consultation_id, n.int_profile_id, n.patient_id, n.note, n.entry_date, 
                       CONCAT(ip.surname,' ',ip.first_name) as profile_name
                FROM ".self::$table_name." n
                INNER JOIN int_profiles ip
                ON ip.int_profile_id=n.int_profile_id
                WHERE n.patient_id=".(int)$patient_id." 
                ORDER BY n.note_id DESC";
                
        // Execute query
        return $this->database_obj->execute_query($sql, "O");
    }
    
    /**
     * Note::initialize_result_vars()
     * 
     * @param mixed $args
     * @return
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
     * Note::insert_note()
     * 
     * @return
     */
    public function insert_note()
    {
        // SQL
        $sql = " INSERT INTO ".self::$table_name." (consultation_id, admission_id, int_profile_id, patient_id, note, entry_date)
                     VALUES (:consultation_id, :admission_id, :int_profile_id, :patient_id, :note, :entry_date) ";
            
        // Bind
        $bind_array = array(
            ':consultation_id' => array($this->consultation_id, PDO::PARAM_STR),
            ':admission_id' => array($this->admission_id, PDO::PARAM_STR),
            ':int_profile_id'  => array($this->int_profile_id, PDO::PARAM_STR),
            ':patient_id'      => array($this->patient_id, PDO::PARAM_STR),
            ':note'            => array($this->note, PDO::PARAM_STR),
            ':entry_date'      => array($this->entry_date, PDO::PARAM_STR)
        );
        
        // Execute
        return $this->database_obj->execute_query($sql,'',$bind_array);
    }
    
    /**
     * Note::update_note()
     * 
     * @return
     */
    public function update_note()
    {
        // SQL
        $sql = " UPDATE ".self::$table_name." 
                 SET consultation_id= :consultation_id,
                     admission_id   = :admission_id,
                     int_profile_id = :int_profile_id,
                     patient_id     = :patient_id,
                     note           = :note,
                     entry_date     = :entry_date
                            
                     WHERE note_id  =".$this->note_id;
        
        // Bind
        $bind_array = array(
            ':consultation_id' => array($this->consultation_id, PDO::PARAM_STR),
            ':admission_id' => array($this->admission_id, PDO::PARAM_STR),
            ':int_profile_id'  => array($this->int_profile_id, PDO::PARAM_STR),
            ':patient_id'      => array($this->patient_id, PDO::PARAM_STR),
            ':note'            => array($this->note, PDO::PARAM_STR),
            ':entry_date'      => array($this->entry_date, PDO::PARAM_STR)
        );
        
        // Execute
        return $this->database_obj->execute_query($sql,'',$bind_array);
    }
}    
?>