<?php
class Hospital
{
    private $database_obj = NULL;
    
    public function __construct()
    {
        $this->database_obj = Database::obj();
    }
    
    public function query($args=array())
    {
        // SQL
        $sql    = (isset($args['select'])) ? " SELECT {$args['select']} "  : '';
        $sql   .= (isset($args['from']))   ? " FROM {$args['from']} "      : '';
        $sql   .= (isset($args['where']))  ? " WHERE {$args['where']} "    : '';
        $sql   .= (isset($args['group']))  ? " GROUP BY {$args['group']} " : '';
        $sql   .= (isset($args['order']))  ? " ORDER BY {$args['order']} " : '';
        $sql   .= (isset($args['limit']))  ? " LIMIT {$args['limit']} "    : '';
        
        // Format
        $format = (isset($args['format'])) ? $args['format'] : 'Object';
        
        // Return
        return $this->database_obj->execute_query($sql,$format);
    }
    
    public function dropdown_list($hopital_type)
    {
        $query = $this->query(array(
            'select' => "hospital_name as name, hospital_id as id",
            'from'   => 'hospitals',
            'order'  => 'hospital_name',
            'where'  => "hospital_type='$hopital_type'",
            'format' => 'Array'
        ));
        
        // Return
        return $query;
    }
}
?>