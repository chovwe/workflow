<?php 
/**
 * Admission
 * 
 * @package HDI
 * @author HDI
 * @copyright 2013
 * @version $Id$
 * @access public
 */
class Admission {
    // Init
    private $database_obj = NULL;
    private static $table_name = 'admissions';
    
    public $admission_id, $int_profile_id, $patient_id, $ward_id, $bed_id, $admission_status, $discharge_date, $start_date, $end_date, $entry_date;
        
    
    /**
     * Admission::__construct()
     * 
     * @return void
     */
    public function __construct()
    {
            $this->database_obj = Database::obj();
    }
    
    /**
     * Admission::query()
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
     * Admission::set_admission_vars()
     * 
     * @param mixed $arr
     * @return void
     */
    public function set_admission_vars($arr = array())
    {
        if(isset($this->admission_id))
        {
            // Initialize class properties
            /*$this->admission_id     = isset($arr['admission_id'])    ? $arr['admission_id']:    $this->admission_id;
            $this->int_profile_id   = isset($arr['int_profile_id'])  ? $arr['int_profile_id']:  $this->int_profile_id;
            $this->patient_id       = isset($arr['patient_id'])      ? $arr['patient_id']:      $this->unipatient_idts;
            $this->ward_id          = isset($arr['ward_id'])         ? $arr['ward_id']:         $this->ward_id;
            $this->bed_id           = isset($arr['bed_id'])          ? $arr['bed_id']:          $this->bed_id;
            $this->admission_status = isset($arr['admission_status'])? $arr['admission_status']:$this->admission_status;
            $this->discharge_date   = isset($arr['discharge_date'])  ? $arr['discharge_date']:  $this->discharge_date;
            $this->start_date       = isset($arr['start_date'])      ? $arr['start_date']:      $this->start_date;
            $this->end_date         = isset($arr['end_date'])        ? $arr['end_date']:        $this->end_date;
            $this->entry_date       = isset($arr['entry_date'])      ? $arr['entry_date']:      $this->entry_date;*/
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
            $this->int_profile_id  = isset($arr['int_profile_id'])  ? $arr['int_profile_id']:  '';
            $this->patient_id      = isset($arr['patient_id'])      ? $arr['patient_id']:      '';
            $this->ward_id         = isset($arr['ward_id'])         ? $arr['ward_id']:         '';
            $this->bed_id          = isset($arr['bed_id'])          ? $arr['bed_id']:          '';
            $this->admission_status= isset($arr['admission_status'])? $arr['admission_status']:'';
            $this->discharge_date  = isset($arr['discharge_date'])  ? $arr['discharge_date']:  '';
            $this->start_date      = isset($arr['start_date'])      ? $arr['start_date']:      '';
            $this->end_date        = isset($arr['end_date'])        ? $arr['end_date']:        '';
            $this->entry_date      = isset($arr['entry_date'])      ? $arr['entry_date']:      '';
        }
    }
    
    /**
     * Admission::fetch_all()
     * 
     * @return
     */
    public function fetch_all()
    {
        //SQL
        $sql = "SELECT a.admission_id, CONCAT(p.surname,' ',p.first_name) as name, 
                       CONCAT(w.tittle, ' (', o.option_name, ')') as ward, b.title, a.start_date, a.end_date 
                FROM ".self::$table_name." a
                INNER JOIN patients p
                ON p.patient_id=a.patient_id
                INNER JOIN wards w
                ON w.ward_id=a.ward_id
                INNER JOIN options o
                ON o.option_id=w.ward_type
                INNER JOIN beds b
                ON b.bed_id=a.bed_id";
        // Execute query
        return $this->database_obj->execute_query($sql, "O");
    }
    
    /**
     * Admission::fetch_by_admission_id()
     * 
     * @param mixed $admission_id
     * @return
     */
    public function fetch_by_admission_id($admission_id)
    {
        // Result
        return $query;
    }
    
    /**
     * Admission::fetch_by_patient_id()
     * 
     * @param mixed $patient_id
     * @return
     */
    public function fetch_by_patient_id($patient_id)
    {
        // Result
        return $query;
    }
    
    /**
     * Admission::fetch_by_ward_id()
     * 
     * @param mixed $ward_id
     * @return
     */
    public function fetch_by_ward_id($ward_id)
    {
        // Result
        return $query;
    }
    
    /**
     * Admission::fetch_by_bed_id()
     * 
     * @param mixed $bed_id
     * @return
     */
    public function fetch_by_bed_id($bed_id)
    {
        // Result
        return $query;
    }
    
    /**
     * Admission::initialize_result_vars()
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
    
    public function insert_admission()
    {
        // SQL
        $sql = " INSERT INTO ".self::$table_name." (int_profile_id, patient_id, ward_id, bed_id, admission_status, discharge_date, start_date, end_date, entry_date)
                     VALUES (:int_profile_id, :patient_id, :ward_id, :bed_id, :admission_status, :discharge_date, :start_date, :end_date, :entry_date) ";
            
        // Bind
        $bind_array = array(
            ':int_profile_id'     => array($this->int_profile_id, PDO::PARAM_STR),
            ':patient_id'         => array($this->patient_id, PDO::PARAM_STR),
            ':ward_id'            => array($this->ward_id, PDO::PARAM_STR),
            ':bed_id'             => array($this->bed_id, PDO::PARAM_STR),
            ':admission_status'   => array($this->admission_status, PDO::PARAM_STR),
            ':discharge_date'     => array($this->discharge_date, PDO::PARAM_STR),
            ':start_date'         => array($this->start_date, PDO::PARAM_STR),
            ':end_date'           => array($this->end_date, PDO::PARAM_STR),
            ':entry_date'         => array($this->entry_date, PDO::PARAM_STR)
        );
            
        // Execute
        return  $this->database_obj->execute_query($sql,'',$bind_array);
    }
    
    public function update_admission()
    {
        // SQL
        $sql = " UPDATE ".self::$table_name." 
                 SET int_profile_id    = :int_profile_id,
                     patient_id        = :patient_id,
                     ward_id           = :ward_id,
                     bed_id            = :bed_id,
                     admission_status  = :admission_status,
                     discharge_date    = :discharge_date,
                     start_date        = :start_date,
                     end_date          = :end_date,
                     entry_date        = :entry_date
                            
                     WHERE admission_id     =".$this->admission_id;
                     
         // Bind
        $bind_array = array(
            ':int_profile_id'     => array($this->int_profile_id, PDO::PARAM_STR),
            ':patient_id'         => array($this->patient_id, PDO::PARAM_STR),
            ':ward_id'            => array($this->ward_id, PDO::PARAM_STR),
            ':bed_id'             => array($this->bed_id, PDO::PARAM_STR),
            ':admission_status'   => array($this->admission_status, PDO::PARAM_STR),
            ':discharge_date'     => array($this->discharge_date, PDO::PARAM_STR),
            ':start_date'         => array($this->start_date, PDO::PARAM_STR),
            ':end_date'           => array($this->end_date, PDO::PARAM_STR),
            ':entry_date'         => array($this->entry_date, PDO::PARAM_STR)
        );
            
        // Execute
        return  $this->database_obj->execute_query($sql,'',$bind_array);
    }
}    
?>