<?php
    //require_once('..'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'Utility.php');
    
    /**
     * pad()
     * 
     * Does all kinds of padding
     * 
     * e.g:
     * 
     * $x = '45';
     * pad($x, 5, 'x', 'right'); // '45xxx'
     * 
     * @param mixed $value
     * @param mixed $pad_len
     * @param string $pad_with
     * @param string $pad_pos
     * @return
     */
    function pad($value, $pad_len, $pad_with='0', $pad_pos='left')
    {
        // Padding position
        // STR_PAD_RIGHT, STR_PAD_LEFT, or STR_PAD_BOTH
        if (($pad_pos == 'l') || ($pad_pos == 'left'))
        {
            $pad_pos = STR_PAD_LEFT;
        }
        else if (($pad_pos == 'r') || ($pad_pos == 'right'))
        {
            $pad_pos = STR_PAD_RIGHT;
        }
        else if (($pad_pos == 'b') || ($pad_pos == 'both'))
        {
            $pad_pos = STR_PAD_BOTH;
        }
        
        return str_pad($value, $pad_len, $pad_with, $pad_pos);
    }
    
    /**
     * standardize_date()
     * 
     * Reformat a date
     * 
     * @return void
     */
    function standardize_date($date, $separator, $order='reverse')
    {
        // Explode the incoming date
        $dob_arr       = explode($separator, $date);
        
        // Reverse the ordering
        if ($order == 'reverse')
        {
            $date = $dob_arr[2] . '-' . $dob_arr[1] . '-' . $dob_arr[0] . ' 00:00:00';
        }
        
        return $date;
    }
    
    function dropdown($array,$name,$even_handler,$action,$class,$selected='',$first='')
    {
        // Init. return variable
        $build = '';
        
        if (!empty($array)) {
            // Start the selection drop-down menu build
            $build = '<select id="'.$name.'" name="'.$name.'" class="'.$class.'" '.$even_handler.'="'.$action.'">';
            
            // Setting the optional first value of the dropdown list
            if ($first != '') $build .= "<option value=''>$first</option>";
            
            foreach ($array as $each_instance)
            {
                $select = '';
                if ($each_instance['id'] == $selected) $select='SELECTED';
                $build .= '<option value="'.$each_instance['id'].'" '.$select.'>'.$each_instance['name'].'</option>';
            }
            
            // End the selection drop-down menu build
            $build .= '</select>';
        }
        else
        {
            $build  = '<select id="'.$name.'" name="'.$name.'" class="'.$class.'" '.$even_handler.'="'.$action.'">';
            $build .= '<option value="" >Select:</option>';
            $build .= '</select>';
        }
        
        //sleep(2);
        echo $build;
    }
    
    /**
     * get_id_desc()
     * 
     * This function is used to fetch the description for:
     * doctor, hospital, occupation, relationship, religion
     * 
     * @param mixed $id
     * @param mixed $handle
     * @return
     */
    function get_id_desc($id, $handle)
    {
        // Switch
        switch($handle)
        {
            case 'account_status':
                if ($obj = new Utility())
                {
                    $result_arr = $obj->query(array(
                        'select' => "option_name as name, option_id as id",
                        'from'   => 'options',
                        'where'  => "group_name='account_status' AND option_id='$id'",
                        'limit'  => '1',
                        'format' => 'Array'
                    ));
                    
                    if (!empty($result_arr)) return $result_arr[0]['name'];
                }
            break;
            case 'country':
                if ($obj = new Utility())
                {
                    $result_arr = $obj->query(array(
                        'select' => "option_name as name, option_id as id",
                        'from'   => 'options',
                        'where'  => "group_name='country' AND option_id='$id'",
                        'limit'  => '1',
                        'format' => 'Array'
                    ));
                    
                    if (!empty($result_arr)) return $result_arr[0]['name'];
                }
            break;
            case 'doctor':
                if ($obj = new Utility())
                {
                    $result_arr = $obj->query(array(
                        'select' => "CONCAT('Dr. ',surname,', ',first_name) as name",
                        'from'   => 'doctors',
                        'where'  => "doctor_id='$id'",
                        'limit'  => '1',
                        'format' => 'Array'
                    ));
                    
                    if (!empty($result_arr)) return $result_arr[0]['name'];
                }
            break;
            case 'hospital':
                if ($obj = new Utility())
                {
                    $result_arr = $obj->query(array(
                        'select' => "hospital_name as name, hospital_id as id",
                        'from'   => 'hospitals',
                        'where'  => "hospital_id='$id'",
                        'limit'  => '1',
                        'format' => 'Array'
                    ));
                    
                    if (!empty($result_arr)) return $result_arr[0]['name'];
                }
            break;
            case 'marital_status':
                if ($obj = new Utility())
                {
                    $result_arr = $obj->query(array(
                        'select' => "option_name as name, option_id as id",
                        'from'   => 'options',
                        'where'  => "group_name='marital_status' AND option_id='$id'",
                        'limit'  => '1',
                        'format' => 'Array'
                    ));
                    
                    if (!empty($result_arr)) return $result_arr[0]['name'];
                }
            break;
            case 'occupation':
                if ($obj = new Utility())
                {
                    $result_arr = $obj->query(array(
                        'select' => "option_name as name, option_id as id",
                        'from'   => 'options',
                        'where'  => "group_name='occupation' AND option_id='$id'",
                        'limit'  => '1',
                        'format' => 'Array'
                    ));
                    
                    if (!empty($result_arr)) return $result_arr[0]['name'];
                }
            break;
            case 'patient_type':
                if ($obj = new Utility())
                {
                    $result_arr = $obj->query(array(
                        'select' => "option_name as name, option_id as id",
                        'from'   => 'options',
                        'where'  => "group_name='patient_type' AND option_id='$id'",
                        'limit'  => '1',
                        'format' => 'Array'
                    ));
                    
                    if (!empty($result_arr)) return $result_arr[0]['name'];
                }
            break;
            case 'relationship':
                if ($obj = new Utility())
                {
                    $result_arr = $obj->query(array(
                        'select' => "option_name as name, option_id as id",
                        'from'   => 'options',
                        'where'  => "group_name='relationship' AND option_id='$id'",
                        'limit'  => '1',
                        'format' => 'Array'
                    ));
                    
                    if (!empty($result_arr)) return $result_arr[0]['name'];
                }
            break;
            case 'religion':
                if ($obj = new Utility())
                {
                    $result_arr = $obj->query(array(
                        'select' => "option_name as name, option_id as id",
                        'from'   => 'options',
                        'where'  => "group_name='religion' AND option_id='$id'",
                        'limit'  => '1',
                        'format' => 'Array'
                    ));
                    
                    if (!empty($result_arr)) return $result_arr[0]['name'];
                }
            break;
            case 'title':
                if ($obj = new Utility())
                {
                    $result_arr = $obj->query(array(
                        'select' => "option_name as name, option_id as id",
                        'from'   => 'options',
                        'where'  => "group_name='title' AND option_id='$id'",
                        'limit'  => '1',
                        'format' => 'Array'
                    ));
                    
                    if (!empty($result_arr)) return $result_arr[0]['name'];
                }
            break;
            // If $handle is not found, try to pull data from the item_array() function
            default:
                if (isset($handle) && ($handle != ''))
                {
                    $item_array = item_array($handle);
                    
                    if (!empty($item_array))
                    {
                        foreach ($item_array as $each_item)
                        {
                            if (isset($id) && ($id != '') && ($id == $each_item['id']))
                            {
                                return $each_item['name'];
                            }
                        }
                    }
                }
            break;
        }
    }
    
    function item_array($item)
    {
        // Init.
        $arr = array();
        
        // Switch
        switch($item)
        {
            case 'blood_type':
                $arr = array(
                    array('id' => 'O','name' => 'O'),
                    array('id' => 'A','name' => 'A'),
                    array('id' => 'B','name' => 'B'),
                    array('id' => 'AB','name' => 'AB')
                );
            break;
            case 'gender':
                $arr = array(
                    array('id' => 'F','name' => 'Female'),
                    array('id' => 'M','name' => 'Male')
                );
            break;
            case 'rh':
                $arr = array(
                    array('id' => 'P','name' => '+'),
                    array('id' => 'N','name' => '-')
                );
            break;
        }
        
        // Return
        return $arr;
    }
    
     /**
     * get_file_extension()
     * 
     * @param mixed $file
     * @return Returns a file extension
     */
    function get_file_extension($file)
    {
        return pathinfo(basename($file['name']), PATHINFO_EXTENSION);
    }
    
    /**
     * checkUploadErrors()
     * 
     * Checks file upload errors and returns a string representing an error code
     * 
     * @param mixed $error
     * @return Returns an Error message
     */
    function check_upload_errors($error) 
    { 
        $message = "";
        switch ($error) { 
            case UPLOAD_ERR_INI_SIZE: 
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini"; 
                break; 
            case UPLOAD_ERR_FORM_SIZE: 
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form"; 
                break; 
            case UPLOAD_ERR_PARTIAL: 
                $message = "The uploaded file was only partially uploaded"; 
                break; 
            case UPLOAD_ERR_NO_FILE: 
                $message = "No file was uploaded"; 
                break; 
            case UPLOAD_ERR_NO_TMP_DIR: 
                $message = "Missing a temporary folder"; 
                break; 
            case UPLOAD_ERR_CANT_WRITE: 
                $message = "Failed to write file to disk"; 
                break; 
            case UPLOAD_ERR_EXTENSION: 
                $message = "File upload stopped by extension"; 
                break; 

            default: 
                $message = "Unknown upload error"; 
                break; 
        } 
        return $message; 
    } 
    
    /**
     * get_current_date()
     * 
     * Gets and returns the current date/time
     * 
     * @return Returns the current date/time
     */
    function get_current_date()
    {
        return strftime("%Y-%m-%d %H:%M:%S", time());
    }
    
    /**
     * datetime_to_text()
     * 
     * @param string $datetime
     * @return Returns String representation of a given date and time
     */
    function datetime_to_text($datetime="") {
      $unixdatetime = strtotime($datetime);
      return strftime("%a, %b %d, %Y at %I:%M %p", $unixdatetime);
    }
?>