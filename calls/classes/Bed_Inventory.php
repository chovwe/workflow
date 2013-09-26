<?php 
/**
 * Bed_inventory
 * 
 * @package HDI
 * @author HDI
 * @copyright 2013
 * @version $Id$
 * @access public
 */
class Bed_inventory {
    // Init
    private $database_obj = NULL;
    private static $table_name = 'bed_inventory';
    
    public $bed_inventory_id, $int_profile_id, $tittle, $units, $bed_type, $description, $date_created, $date_modified;
        
    
    /**
     * Bed_inventory::__construct()
     * 
     * @return void
     */
    public function __construct()
    {
            $this->database_obj = Database::obj();
    }
    
    /**
     * Bed_inventory::query()
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
     * Bed_inventory::set_bed_inventory_vars()
     * 
     * @param mixed $arr
     * @return void
     */
    public function set_bed_inventory_vars($arr = array())
    {
        if(isset($this->bed_inventory_id))
        {
            // Initialize class properties
            /*$this->bed_inventory_id = isset($arr['bed_inventory_id'])? $arr['bed_inventory_id']:$this->bed_inventory_id;
            $this->int_profile_id   = isset($arr['int_profile_id'])  ? $arr['int_profile_id']:  $this->int_profile_id;
            $this->tittle            = isset($arr['tittle'])           ? $arr['tittle']:           $this->tittle;
            $this->units            = isset($arr['units'])           ? $arr['units']:           $this->units;
            $this->bed_type         = isset($arr['bed_type'])        ? $arr['bed_type']:        $this->bed_type;
            $this->description      = isset($arr['description'])     ? $arr['description']:     $this->description;
            $this->date_created     = isset($arr['date_created'])    ? $arr['date_created']:    $this->date_created;
            $this->date_modified    = isset($arr['date_modified'])   ? $arr['date_modified']:   $this->date_modified;*/
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
            $this->bed_inventory_id = isset($arr['bed_inventory_id'])? $arr['bed_inventory_id']:'';
            $this->int_profile_id   = isset($arr['int_profile_id'])  ? $arr['int_profile_id']:  '';
            $this->tittle            = isset($arr['tittle'])           ? $arr['tittle']:           '';
            $this->units            = isset($arr['units'])           ? $arr['units']:           '';
            $this->bed_type         = isset($arr['bed_type'])        ? $arr['bed_type']:        '';
            $this->description      = isset($arr['description'])     ? $arr['description']:     '';
            $this->date_created   = isset($arr['date_created'])   ? $arr['date_created']:       '';
            $this->date_modified  = isset($arr['date_modified'])  ? $arr['date_modified']:      '';
        }
    }
    
    
    /**
     * Bed_inventory::fetch_all()
     * 
     * @return
     */
    public function fetch_all()
    {
        // Execute query
        $query = $this->query(array(
            'select' => "b.bed_inventory_id, b.tittle, b.units, b.date_created, o.option_name as bed_type",
            'from'   => self::$table_name.' b',
            'inner join' => 'options o',
            'on' => 'o.option_id=b.bed_type',
            'format' => 'Object'
        ));

        // Result
        return $query;
    }
    
    /**
     * Bed_inventory::fetch_by_bed_inventory_id()
     * 
     * @param mixed $bed_inventory_id
     * @return
     */
    public function fetch_by_bed_inventory_id($bed_inventory_id)
    {
        
        // Execute query
        $query = $this->query(array(
            'select' => "b.bed_inventory_id, b.tittle, b.units, b.description, b.date_created, b.date_modified, o.option_id, o.option_name as bed_type",
            'from'   => self::$table_name.' b',
            'inner join' => 'options o',
            'on' => 'o.option_id=b.bed_type',
            'where'  => "bed_inventory_id={$bed_inventory_id}",
            'limit'  => "1",
            'format' => 'Object'
        ));
        
        // Result
        return array_shift($query);
    }
    
    /**
     * Bed_inventory::initialize_result_vars()
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
     * Bed_inventory::insert_bed_inventory()
     * 
     * @return
     */
    public function insert_bed_inventory()
    {
        // SQL
        $sql = " INSERT INTO ".self::$table_name." (int_profile_id, tittle, units, bed_type, description, date_created, date_modified)
                     VALUES (:int_profile_id, :tittle, :units, :bed_type, :description, :date_created, :date_modified) ";
            
        // Bind
        $bind_array = array(
            ':int_profile_id'          => array($this->int_profile_id, PDO::PARAM_STR),
            ':tittle'                  => array($this->tittle, PDO::PARAM_STR),
            ':units'                   => array($this->units, PDO::PARAM_STR),
            ':bed_type'                => array($this->bed_type, PDO::PARAM_STR),
            ':description'             => array($this->description, PDO::PARAM_STR),
            ':date_created'            => array($this->date_created, PDO::PARAM_STR),
            ':date_modified'           => array($this->date_modified, PDO::PARAM_STR)
        );
            
        // Execute
        return  $this->database_obj->execute_query($sql,'',$bind_array);
    }
    
    public function update_bed_inventory()
    {
        // SQL
        $sql = " UPDATE ".self::$table_name." 
                 SET int_profile_id    = :int_profile_id,
                     tittle             = :tittle,
                     units             = :units,
                     bed_type          = :bed_type,
                     description       = :description, 
                     date_created      = :date_created, 
                     date_modified     = :date_modified 
                            
                     WHERE bed_id     =".$this->bed_inventory_id;
         
         // Bind
         $bind_array = array(
            ':int_profile_id'          => array($this->int_profile_id, PDO::PARAM_STR),
            ':tittle'                  => array($this->tittle, PDO::PARAM_STR),
            ':units'                   => array($this->units, PDO::PARAM_STR),
            ':bed_type'                => array($this->bed_type, PDO::PARAM_STR),
            ':description'             => array($this->description, PDO::PARAM_STR),
            ':date_created'            => array($this->date_created, PDO::PARAM_STR),
            ':date_modified'           => array($this->date_modified, PDO::PARAM_STR)
        );
         
         // Execute
         return  $this->database_obj->execute_query($sql,'',$bind_array); 
    }
    
}    
?>