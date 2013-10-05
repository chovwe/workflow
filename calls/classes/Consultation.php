<?php 
/**
 * Consultation
 * 
 * @package HDI
 * @author HDI
 * @copyright 2013
 * @version $Id$
 * @access public
 */
class Consultation {
    // Init
    private $database_obj = NULL;
    private $complaint_obj;
    private $observation_obj;
    private $diagnosis_obj;
    private $plan_obj;
    private $note_obj;
    private static $table_name = 'consultation';
    
    public $consultation_id, $int_profile_id, $patient_id, $entry_date;
        
    
    /**
     * Consultation::__construct()
     * 
     * @return void
     */
    public function __construct()
    {
            $this->database_obj    = Database::obj();
            $this->complaint_obj   = new Complaint();
            $this->observation_obj = new Observation();
            $this->diagnosis_obj   = new Diagnosis();
            $this->plan_obj        = new Plan();
            $this->note_obj        = new Note();
    }
    
    /**
     * Consultation::query()
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
     * Consultation::set_consultation_vars()
     * 
     * @param mixed $arr
     * @return void
     */
    public function set_consultation_vars($arr = array())
    {
        if(isset($this->consultation_id))
        {
            // Initialize class properties
            /*$this->consultation_id     = isset($arr['consultation_id'])    ? $arr['consultation_id']:    $this->consultation_id;
            $this->int_profile_id   = isset($arr['int_profile_id'])  ? $arr['int_profile_id']:  $this->int_profile_id;
            $this->patient_id       = isset($arr['patient_id'])      ? $arr['patient_id']:      $this->patient_id;
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
            $this->entry_date      = isset($arr['entry_date'])      ? $arr['entry_date']:      '';
        }
    }
    
    public function fetch_all()
    {
        
    }
    
    public function fetch_by_patient_id($patient_id)
    {
        // SQL
        $sql = "SELECT c.consultation_id, c.int_profile_id, c.entry_date, CONCAT(p.surname,', ',p.first_name) as name, 
                       CONCAT(ip.surname,' ',ip.first_name) as doc_name, cp.complaint, o.observation, d.diagnosis, pl.plan, n.note 
                FROM ".self::$table_name." c 
                INNER JOIN patients p
                ON p.patient_id=c.patient_id
                INNER JOIN int_profiles ip
                ON ip.int_profile_id=c.int_profile_id
                INNER JOIN complaints cp
                ON cp.consultation_id=c.consultation_id
                INNER JOIN observations o
                ON o.consultation_id=c.consultation_id
                INNER JOIN diagnosis d
                ON d.consultation_id=c.consultation_id
                INNER JOIN plans pl
                ON pl.consultation_id=c.consultation_id
                INNER JOIN notes n
                ON n.consultation_id=c.consultation_id
                WHERE c.patient_id=".(int)$patient_id." 
                ORDER BY c.consultation_id DESC";
                
        // Execute query
        return $this->database_obj->execute_query($sql, "O");
    }
    
    /**
     * Consultation::initialize_result_vars()
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
    
    public function insert_consultation($post)
    {
        // Start transaction
        $this->database_obj->begin_transaction();
        // SQL
        $sql = " INSERT INTO ".self::$table_name." (int_profile_id, patient_id, entry_date)
                     VALUES (:int_profile_id, :patient_id, :entry_date) ";
            
        // Bind
        $bind_array = array(
            ':int_profile_id'     => array($this->int_profile_id, PDO::PARAM_STR),
            ':patient_id'         => array($this->patient_id, PDO::PARAM_STR),
            ':entry_date'         => array($this->entry_date, PDO::PARAM_STR)
        );
            
        // Execute
        $status =  $this->database_obj->execute_query($sql,'',$bind_array);
        
        if($status === true)
        {
            // Fetch the last inserted Consultation ID
            $post['consultation_id'] = $this->database_obj->last_insert_id();
            if($this->complaint_obj instanceof Complaint)
            {
                $this->complaint_obj->set_complaint_vars($post);
                $status = $this->complaint_obj->insert_complaint();
            }else{
                $status = false;
            }
            
            if($this->observation_obj instanceof Observation)
            {
                $this->observation_obj->set_observation_vars($post);
                $status = $this->observation_obj->insert_observation();
            }else{
                $status = false;
            }
            
            if($this->diagnosis_obj instanceof Diagnosis)
            {
                $this->diagnosis_obj->set_diagnosis_vars($post);
                $status = $this->diagnosis_obj->insert_diagnosis();
            }else{
                $status = false;
            }
            
            if($this->plan_obj instanceof Plan)
            {
                $this->plan_obj->set_plan_vars($post);
                $status = $this->plan_obj->insert_plan();
            }else{
                $status = false;
            }
            
            if($this->note_obj instanceof Note)
            {
                $this->note_obj->set_note_vars($post);
                $status = $this->note_obj->insert_note();
            }else{
                $status = false;
            }
            
            if ($status === true)
            {   
                // Commit transaction
                $this->database_obj->commit_transaction();
                
            }
            else
            {
                // Roll back transaction
                $this->database_obj->roll_back();
            }
            
        }else
        {
            // Roll back transaction
            $this->database_obj->roll_back();
        }
        
        // Return
        return $status;
    }
    
    
}    
?>