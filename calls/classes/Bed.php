<?php 
/**
 * Bed
 * 
 * @package HDI
 * @author HDI
 * @copyright 2013
 * @version $Id$
 * @access public
 */
class Bed {
    // Init
    private $database_obj = NULL;
    private static $table_name = 'beds';
    
    public $bed_id, $bed_inventory_id, $ward_id, $int_profile_id, $title, $status, $date_created, $date_modified;
        
    
    /**
     * Bed::__construct()
     * 
     * @return void
     */
    public function __construct()
    {
            $this->database_obj = Database::obj();
    }
    
    /**
     * Bed::query()
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
     * Bed::set_bed_vars()
     * 
     * @param mixed $arr
     * @return void
     */
    public function set_bed_vars($arr = array())
    {
        if(isset($this->bed_id))
        {
            // Initialize class properties
            /*$this->bed_id         = isset($arr['bed_id'])          ? $arr['bed_id']:          $this->bed_id;
            $this->bed_inventory_id = isset($arr['bed_inventory_id'])? $arr['bed_inventory_id']:$this->bed_inventory_id;
            $this->ward_id          = isset($arr['ward_id'])         ? $arr['ward_id']:         $this->ward_id;
            $this->int_profile_id   = isset($arr['int_profile_id'])  ? $arr['int_profile_id']:  $this->int_profile_id;
            $this->title            = isset($arr['title'])           ? $arr['title']:           $this->title;
            $this->status           = isset($arr['status'])          ? $arr['status']:          $this->status;
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
            $this->bed_id         = isset($arr['bed_id'])         ? $arr['bed_id']:         '';
            $this->bed_inventory_id = isset($arr['bed_inventory_id'])? $arr['bed_inventory_id']: '';
            $this->ward_id        = isset($arr['ward_id'])        ? $arr['ward_id']:        '';
            $this->int_profile_id = isset($arr['int_profile_id']) ? $arr['int_profile_id']: '';
            $this->title          = isset($arr['title'])          ? $arr['title']:          '';
            $this->status         = isset($arr['status'])         ? $arr['status']:         '';
            $this->bed_type       = isset($arr['bed_type'])       ? $arr['bed_type']:       '';
            $this->date_created   = isset($arr['date_created'])   ? $arr['date_created']:   '';
            $this->date_modified  = isset($arr['date_modified'])  ? $arr['date_modified']:  '';
        }
    }
    
    /**
     * Bed::fetch_all()
     * 
     * Fetches the entire Bed entries
     * 
     * @return Returns the entire Bed entries
     */
    public function fetch_all()
    {
        // Execute query
        $query = $this->query(array(
            'select' => "*",
            'from'   => self::$table_name,
            'format' => 'Array'
        ));
        
        // Result
        return self::initialize_result_vars($query);
    }
    
    /**
     * Bed::fetch_by_bed_id()
     * 
     * Fetches a specified Bed entry
     * 
     * @param mixed $bed_id
     * @return Returns a specified Bed entry
     */
    public function fetch_by_bed_id($bed_id)
    {
        // Execute query
        $query = $this->query(array(
            'select' => "*",
            'from'   => self::$table_name,
            'where'  => "bed_id={$bed_id}",
            'limit'  => "1",
            'format' => 'Array'
        ));
        
        // Result
        return self::initialize_result_vars($query);
    }
    
    public function fetch_by_ward_id($ward_id)
    {
        // Execute query
        $query = $this->query(array(
            'select' => "*",
            'from'   => self::$table_name,
            'where'  => "ward_id={$ward_id}",
            'limit'  => "1",
            'format' => 'Array'
        ));
    }
    
    /**
     * Bed::dropdown_list()
     * 
     * @return
     */
    public function dropdown_list($ward_id)
    {
        // SQL
        $sql = "SELECT b.bed_id as id , CONCAT(bi.tittle, ' (', o.option_name, ')') as name
                FROM ".self::$table_name." b
                INNER JOIN bed_inventory bi
                ON bi.bed_inventory_id=b.bed_inventory_id
                INNER JOIN options o
                ON o.option_id=bi.bed_type
                WHERE b.ward_id=$ward_id
                ORDER BY bi.tittle ASC";
        
        // Execute
        return $this->database_obj->execute_query($sql,'Array');
    }
    
    /**
     * Bed::initialize_result_vars()
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
     * Bed::insert_bed()
     * 
     * Inserts a Bed entry
     * 
     * @return
     */
    public function insert_bed()
    {
        // SQL
        $sql = " INSERT INTO ".self::$table_name." (bed_inventory_id, ward_id, int_profile_id, title, status, date_created, date_modified)
                     VALUES (:bed_inventory_id, :ward_id, :int_profile_id, :title, :status, :date_created, :date_modified) ";
            
        // Bind
        $bind_array = array(
            ':bed_inventory_id'        => array($this->bed_inventory_id, PDO::PARAM_STR),
            ':ward_id'                 => array($this->ward_id, PDO::PARAM_STR),
            ':int_profile_id'          => array($this->int_profile_id, PDO::PARAM_STR),
            ':title'                   => array($this->title, PDO::PARAM_STR),
            ':status'                  => array($this->status, PDO::PARAM_STR),
            ':date_created'            => array($this->date_created, PDO::PARAM_STR),
            ':date_modified'           => array($this->date_modified, PDO::PARAM_STR)
        );
            
        // Execute
        return  $this->database_obj->execute_query($sql,'',$bind_array);
    }
    
    /**
     * Bed::update_bed()
     * 
     * Updates  a Bed entry
     * 
     * @return
     */
    public function update_bed()
    {
        // SQL
        $sql = " UPDATE ".self::$table_name." 
                 SET bed_inventory_id  = :bed_inventory_id,
                     ward_id           = :ward_id,
                     int_profile_id    = :int_profile_id,
                     title             = :title,
                     status            = :status, 
                     date_created      = :date_created, 
                     date_modified     = :date_modified 
                            
                     WHERE bed_id     =".$this->bed_id;
         
         // Bind
         $bind_array = array(
            ':bed_inventory_id'        => array($this->bed_inventory_id, PDO::PARAM_STR),
            ':ward_id'                 => array($this->ward_id, PDO::PARAM_STR),
            ':int_profile_id'          => array($this->int_profile_id, PDO::PARAM_STR),
            ':title'                   => array($this->title, PDO::PARAM_STR),
            ':status'                  => array($this->status, PDO::PARAM_STR),
            ':date_created'            => array($this->date_created, PDO::PARAM_STR),
            ':date_modified'           => array($this->date_modified, PDO::PARAM_STR)
        );
         
         // Execute
         return  $this->database_obj->execute_query($sql,'',$bind_array); 
    }
    
}    
?>