<?php
class Ext_Profile
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
    
    public function dropdown_list($id)
    {
        // SQL
        $sql = "SELECT CONCAT(o.option_name,' ',e.surname,', ',e.first_name) as name, e.ext_profile_id as id
                FROM ext_profiles e
                INNER JOIN options o
                ON o.option_id=e.title
                WHERE e.hospital_id='$id'
                ORDER BY e.surname";
        
        // Execute
        return $this->database_obj->execute_query($sql,'Array');
    }
} 
?>