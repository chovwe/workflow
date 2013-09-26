<?php 
/**
 * Ward
 * 
 * @package HDI
 * @author HDI
 * @copyright 2013
 * @version $Id$
 * @access public
*/
class Ward {
    // Init
    private $database_obj = NULL;
    private static $table_name = 'wards';
    
    public $ward_id, $int_profile_id, $tittle, $nums_of_bed, $description, $ward_type, $date_created, $date_modified, $visibility;
        
    /**
     * Ward::__construct()
     * 
     * @return void
     */
    public function __construct()
    {
            $this->database_obj = Database::obj();
    }
        
    /**
     * Ward::query()
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
        $format = (isset($args['format']))       ? $args['format']                     : 'Object';
        
        // Return
        return $this->database_obj->execute_query($sql,$format);
    }
    
    /**
     * Ward::set_ward_vars()
     * 
     * @param mixed $arr
     * @return void
     */
    public function set_ward_vars($arr = array())
    {
        if(isset($this->ward_id))
        {
            // Initialize class properties
            /*$this->ward_id        = isset($arr['ward_id'])        ? $arr['ward_id']:        $this->ward_id;
            $this->int_profile_id        = isset($arr['int_profile_id'])        ? $arr['int_profile_id']:        $this->int_profile_id;
            $this->tittle         = isset($arr['tittle'])         ? $arr['tittle']:         $this->tittle;
            $this->nums_of_bed    = isset($arr['nums_of_bed'])    ? $arr['nums_of_bed']:    $this->nums_of_bed;
            $this->description    = isset($arr['description'])    ? $arr['description']:    $this->description ;
            $this->ward_type      = isset($arr['ward_type'])      ? $arr['ward_type']:      $this->ward_type;
            $this->date_created   = isset($arr['date_created'])   ? $arr['date_created']:   $this->date_created;
            $this->date_modified  = isset($arr['date_modified'])  ? $arr['date_modified']:  $this->date_modified;
            $this->visibility     = isset($arr['visibility'])     ? $arr['visibility']:     $this->visibility;*/
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
            $this->ward_id        = isset($arr['ward_id'])        ? $arr['ward_id']:        '';
            $this->int_profile_id        = isset($arr['int_profile_id'])        ? $arr['int_profile_id']:        '';
            $this->tittle         = isset($arr['tittle'])         ? $arr['tittle']:         '';
            $this->nums_of_bed    = isset($arr['nums_of_bed'])    ? $arr['nums_of_bed']:    '';
            $this->description    = isset($arr['description'])    ? $arr['description']:    '';
            $this->ward_type      = isset($arr['ward_type'])      ? $arr['ward_type']:      '';
            $this->date_created   = isset($arr['date_created'])   ? $arr['date_created']:   '';
            $this->date_modified  = isset($arr['date_modified'])  ? $arr['date_modified']:  '';
            $this->visibility     = isset($arr['visibility'])     ? $arr['visibility']:     '';
        }
    }
    
    /**
     * Ward::fetch_all()
     * 
     * Fetches all Ward entries
     * 
     * @return Returns the entire Ward entries
     */
    public function fetch_all()
    {
        // Execute query
        $query = $this->query(array(
            'select' => "w.ward_id, w.tittle, w.nums_of_bed, w.date_created, o.option_name as ward_type",
            'from'   => self::$table_name.' w',
            'inner join' => 'options o',
            'on' => 'o.option_id=w.ward_type',
            'format' => 'Object'
        ));

        // Result
        return $query;
    }
    
    /**
     * Ward::fetch_ward_by_id()
     * 
     * Fetches a specified Ward entry
     * 
     * @param mixed $ward_id
     * @return Returns a specified Ward entry
     */
    public function fetch_ward_by_id($ward_id)
    {
        // Execute query
        $query = $this->query(array(
            'select' => "w.ward_id, w.tittle, w.nums_of_bed, w.description, w.date_created, w.date_modified, o.option_id, o.option_name as ward_type",
            'from'   => self::$table_name.' w',
            'inner join' => 'options o',
            'on' => 'o.option_id=w.ward_type',
            'where'  => "ward_id={$ward_id}",
            'limit'  => "1",
            'format' => 'Object'
        ));
        
        // Result
        return array_shift($query);
    }
    
    /**
     * Ward::initialize_result_vars()
     * 
     * Initializes class attributes with query result
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
     * Ward::insert_ward()
     * 
     * Inserts a Ward entry
     * 
     * @return
     */
    public function insert_ward()
    {
        // SQL
        $sql = " INSERT INTO ".self::$table_name." (int_profile_id, tittle, nums_of_bed, description, ward_type, date_created, date_modified)
                     VALUES (:int_profile_id, :tittle, :nums_of_bed, :description, :ward_type, :date_created, :date_modified) ";
            
        // Bind
        $bind_array = array(
            ':int_profile_id'        => array($this->int_profile_id, PDO::PARAM_STR),
            ':tittle'         => array($this->tittle, PDO::PARAM_STR),
            ':nums_of_bed'    => array($this->nums_of_bed, PDO::PARAM_STR),
            ':description'    => array($this->description, PDO::PARAM_STR),
            ':ward_type'      => array($this->ward_type, PDO::PARAM_INT),
            ':date_created'   => array($this->date_created, PDO::PARAM_STR),
            ':date_modified'  => array($this->date_modified, PDO::PARAM_STR)
        );
            
        // Execute
        return  $this->database_obj->execute_query($sql,'',$bind_array);
    }
    
    /**
     * Ward::update_ward()
     * 
     * Updates a ward entry
     * 
     * @return
     */
    public function update_ward()
    {
        // SQL
        $sql = " UPDATE ".self::$table_name." 
                 SET int_profile_id           = :int_profile_id,
                     tittle            = :tittle,
                     nums_of_bed       = :nums_of_bed, 
                     description       = :description, 
                     ward_type         = :ward_type, 
                     date_created      = :date_created, 
                     date_modified     = :date_modified 
                            
                     WHERE ward_id     =".$this->ward_id;
         
         // Bind
         $bind_array = array(
            ':int_profile_id'        => array($this->int_profile_id, PDO::PARAM_STR),
            ':tittle'         => array($this->tittle, PDO::PARAM_STR),
            ':nums_of_bed'    => array($this->nums_of_bed, PDO::PARAM_STR),
            ':description'    => array($this->description, PDO::PARAM_STR),
            ':ward_type'      => array($this->ward_type, PDO::PARAM_INT),
            ':date_created'   => array($this->date_created, PDO::PARAM_STR),
            ':date_modified'  => array($this->date_modified, PDO::PARAM_STR)
         );
         
         // Execute
         return  $this->database_obj->execute_query($sql,'',$bind_array); 
    }
}
?>