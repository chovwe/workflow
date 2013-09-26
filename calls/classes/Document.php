<?php

/**
 * Document
 * 
 * Documents Class for handling all document related functions
 * 
 * @package HDI
 * @author HDI
 * @copyright 2013
 * @version $Id$
 * @access Public
 */
Class Document
{
    // Init.
    private $database_obj      = NULL;
    private static $table_name = 'documents';
    
    public $document_id, $patient_id, $int_profile_id, $ext_profile_id,
           $filename, $type, $size, $path, $date_created, $date_modified;
    
    
    /**
     * Document::__construct()
     * 
     * @param mixed $arr
     * @return void
     */
    public function __construct()
    {
        $this->database_obj   = Database::obj();
    }    
    
    /**
     * Documents::query()
     * 
     * Executes a specified query
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
     * Document::set_document_vars()
     * 
     * @param mixed $arr
     * @return void
     */
    public function set_document_vars($arr = array())
    {
        if(isset($this->document_id))
        {
            // Initialize class properties
            $this->document_id    = isset($arr['document_id'])    ? $arr['document_id']:    $this->document_id;
            $this->patient_id     = isset($arr['patient_id'])     ? $arr['patient_id']:     $this->patient_id ;
            $this->int_profile_id = isset($arr['int_profile_id']) ? $arr['int_profile_id']: $this->int_profile_id;
            $this->ext_profile_id = isset($arr['ext_profile_id']) ? $arr['ext_profile_id']: $this->ext_profile_id;
            $this->filename       = isset($arr['filename'])       ? $arr['filename']:       $this->filename;
            $this->type           = isset($arr['type'])           ? $arr['type']:           $this->type;
            $this->size           = isset($arr['size'])           ? $arr['size']:           $this->size ;
            $this->path           = isset($arr['path'])           ? $arr['path']:           $this->path;
            $this->date_created   = isset($arr['date_created'])   ? $arr['date_created']:   $this->date_created;
            $this->date_modified  = isset($arr['date_modified'])  ? $arr['date_modified']:  $this->date_modified;
        } else {
            // Initialize class properties
            $this->document_id    = isset($arr['document_id'])    ? $arr['document_id']:    '';
            $this->patient_id     = isset($arr['patient_id'])     ? $arr['patient_id']:     '';
            $this->int_profile_id = isset($arr['int_profile_id']) ? $arr['int_profile_id']: '';
            $this->ext_profile_id = isset($arr['ext_profile_id']) ? $arr['ext_profile_id']: '';
            $this->filename       = isset($arr['filename'])       ? $arr['filename']:       '';
            $this->type           = isset($arr['type'])           ? $arr['type']:           '';
            $this->size           = isset($arr['size'])           ? $arr['size']:           '';
            $this->path           = isset($arr['path'])           ? $arr['path']:           '';
            $this->date_created   = isset($arr['date_created'])   ? $arr['date_created']:   '';
            $this->date_modified  = isset($arr['date_modified'])  ? $arr['date_modified']:  '';
        }
    }
    
    /**
     * Document::upload()
     * 
     * Uploads a specified file
     * 
     * @param mixed $file
     * @return
     */
    public function upload($file)
    {
        return @move_uploaded_file($file);
    }
    
    /**
     * Document::delete_file()
     * 
     * Deletes a specified file from memmory and returns a boolean indicating whether the file was deleted or not
     * 
     * @param mixed $file
     * @return
     */
    public function delete_file($file)
    {
        return @unlink($file);
    }
    
    /**
     * Document::fetch_thumb_by_patient_id()
     * 
     * @param mixed $patient_id
     * @return Returns a thumbnail with a specified Patient ID
     */
    public function fetch_thumb_by_patient_id($patient_id)
    {
        // Execute query
        $query = $this->query(array(
            'select' => "*",
            'from'   => self::$table_name,
            'where'  => "patient_id={$patient_id}",
            'and'    => "type",
            'like'   => "'%image/%'",
            'limit'  => "1",
            'format' => 'Array'
        ));
        
        // Result
        return self::initialize_result_vars($query);
    }
    
    /**
     * Document::fetch_thumb_by_int_profile_id()
     * 
     * @param mixed $int_profile_id
     * @return Returns a thumbnail with a specified Internal Profile ID
     */
    public function fetch_thumb_by_int_profile_id($int_profile_id)
    {
        // Execute query
        $query = $this->query(array(
            'select' => "*",
            'from'   => self::$table_name,
            'where'  => "int_profile_id={$int_profile_id}",
            'and'    => "type",
            'like'   => "'%image/%'",
            'limit'  => "1",
            'format' => 'Array'
        ));
        
        // Result
        return self::initialize_result_vars($query);
    }
    
    /**
     * Document::fetch_thumb_by_ext_profile_id()
     * 
     * @param mixed $ext_profile_id
     * @return Returns a thumbnail with a specified External Profile ID
     */
    public function fetch_thumb_by_ext_profile_id($ext_profile_id)
    {
        // Execute query
        $query = $this->query(array(
            'select' => "*",
            'from'   => self::$table_name,
            'where'  => "ext_profile_id={$ext_profile_id}",
            'and'    => "type",
            'like'   => "'%image/%'",
            'limit'  => "1",
            'format' => 'Array'
        ));
        
        // Result
        return self::initialize_result_vars($query);
    }
    
    /**
     * Document::initialize_result_vars()
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
     * Documents::insert_document()
     * 
     * Inserts a document        
     * 
     * @return
     */                      
    public function insert_document()
    {  
            // SQL
            $sql = " INSERT INTO ".self::$table_name." (patient_id, int_profile_id, ext_profile_id, filename, type, size, path, date_created, date_modified)
                     VALUES (:patient_id, :int_profile_id, :ext_profile_id, :filename, :type, :size, :path, :date_created, :date_modified) ";
            
            // Bind
            $bind_array = array(
                ':patient_id'     => array($this->patient_id, PDO::PARAM_STR),
                ':int_profile_id' => array($this->int_profile_id, PDO::PARAM_STR),
                ':ext_profile_id' => array($this->ext_profile_id, PDO::PARAM_STR),
                ':filename'       => array($this->filename, PDO::PARAM_STR),
                ':type'           => array($this->type, PDO::PARAM_STR),
                ':size'           => array($this->size, PDO::PARAM_INT),
                ':path'           => array($this->path, PDO::PARAM_STR),
                ':date_created'   => array($this->date_created, PDO::PARAM_STR),
                ':date_modified'  => array($this->date_modified, PDO::PARAM_STR)
            );
            
            // Execute
            return  $this->database_obj->execute_query($sql,'',$bind_array);
    }
    
    /**
     * Document::update_document()
     * 
     * Updates a specified Document based on its ID
     * 
     * @return
     */
    public function update_document()
    {
            // SQL
            $sql = " UPDATE ".self::$table_name." 
                     SET patient_id        = :patient_id,
                         int_profile_id    = :int_profile_id,
                         ext_profile_id    = :ext_profile_id,
                         filename          = :filename,
                         type              = :type, 
                         size              = :size, 
                         path              = :path, 
                         date_created      = :date_created, 
                         date_modified     = :date_modified 
                            
                         WHERE document_id =".$this->document_id;
        
            // Bind
            $bind_array = array(
                ':patient_id'     => array($this->patient_id, PDO::PARAM_STR),
                ':int_profile_id' => array($this->int_profile_id, PDO::PARAM_STR),
                ':ext_profile_id' => array($this->ext_profile_id, PDO::PARAM_STR),
                ':filename'       => array($this->filename, PDO::PARAM_STR),
                ':type'           => array($this->type, PDO::PARAM_STR),
                ':size'           => array($this->size, PDO::PARAM_INT),
                ':path'           => array($this->path, PDO::PARAM_STR),
                ':date_created'   => array($this->date_created, PDO::PARAM_STR),
                ':date_modified'  => array($this->date_modified, PDO::PARAM_STR)
            );
            
            // Execute
            return  $this->database_obj->execute_query($sql,'',$bind_array);
    }
    
} 
?>