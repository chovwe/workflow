<?php
    class Form
    {
        /**
         * Form::textbox()
         * 
         * e.g.
         * 
         * $form->textbox('txt_name','',array('onclick'=>'alert("I am very happy!")'));
         * 
         * @param mixed $name
         * @param string $value
         * @param mixed $action_arr
         * @return void
         */
        public static function textbox($name,$value='',$action_arr=array())
        {
            // Init.
            $textbox = '';
            
            $textbox  = "<div class='outer_box text_box'>";
            $textbox .= "<input type='text' name='$name' id='$name' value='$value' class='text'";
            
            if (!empty($action_arr))
            {                    
                foreach($action_arr as $action_key => $action_value)
                {
                    $textbox .= ' '.$action_key.'='.$action_value.' ';
                }
            }
            
            $textbox .= "/>";
            $textbox .= "</div>";
            
            echo $textbox;                        
        }
        
        /**
         * Form::file()
         * 
         * @param mixed $name
         * @param mixed $action_arr
         * @return void
         */
        public static function file($name,$action_arr=array())
        {
            // Init.
            $filebox = '';
            
            $filebox  = "<div class='outer_box file_box'>";
            $filebox .= "<input type='file' name='$name' id='$name' class='file'";
            
            if (!empty($action_arr))
            {                    
                foreach($action_arr as $action_key => $action_value)
                {
                    $filebox .= ' '.$action_key.'='.$action_value.' ';
                }
            }
            
            $filebox .= "/>";
            $filebox .= "</div>";
            
            echo $filebox;                        
        }
        
        public static function password($name,$value='',$action_arr=array())
        {
            // Init.
            $textbox = '';
            
            $textbox  = "<div class='outer_box text_box'>";
            $textbox .= "<input type='password' name='$name' id='$name' value='$value' class='text'";
            
            if (!empty($action_arr))
            {                    
                foreach($action_arr as $action_key => $action_value)
                {
                    $textbox .= ' '.$action_key.'='.$action_value.' ';
                }
            }
            
            $textbox .= "/>";
            $textbox .= "</div>";
            
            echo $textbox;                        
        }
        
        /**
         * Form::selectbox()
         * 
         * @param mixed $option_arr
         * @param mixed $name
         * @param string $value
         * @param mixed $action_arr
         * @param string $default
         * @return void
         */
        public static function selectbox($option_arr,$name,$value='',$action_arr=array(),$default='Select:')
        {
            // Init.
            $selectbox = '';
            
            $selectbox .= "<div class='outer_box select_box'>";
            $selectbox .= "<select name='$name' id='$name' class='select'";
        
            if (!empty($action_arr))
            {
                foreach($action_arr as $action_key => $action_value)
                {
                    $selectbox .= ' '.$action_key.'='.$action_value.' ';
                }
            }
            
            $selectbox .= ">";
        
            // Setting the optional first value of the dropdown list
            $selectbox .= "<option value=''>$default</option>";
            
            if (!empty($option_arr))
            {
                foreach ($option_arr as $option)
                {
                    $selected = '';
                    if ($option['id'] == $value) $selected="selected='true'";
                    $selectbox .= '<option value="'.$option['id'].'" '.$selected.'>'.$option['name'].'</option>';
                }
            }
            
            $selectbox .= "</select>";
            $selectbox .= "</div>";
            
            echo $selectbox;
        }
        
        /**
         * Form::textarea()
         * 
         * @param mixed $name
         * @param string $value
         * @param string $rows
         * @param mixed $action_arr
         * @return void
         */
        public static function textarea($name,$value='',$rows='5',$action_arr=array())
        {
            // Init.
            $textarea = '';
            
            $textarea .= "<div class='outer_box area_box'>";
            $textarea .= "<textarea name='$name' id='$name' rows='$rows' class='area'";
        
            if (!empty($action_arr))
            {
                foreach($action_arr as $action_key => $action_value)
                {
                    $textarea .= ' '.$action_key.'='.$action_value.' ';
                }
            }
            
            $textarea .= ">";
        
            // Setting the value of the textarea
            $textarea .= $value;
            
            $textarea .= "</textarea>";
            $textarea .= "</div>";
            
            echo $textarea;
        }
        
        /**
         * Form::button()
         * 
         * @param mixed $name
         * @param string $value
         * @param string $rows
         * @param mixed $action_arr
         * @return void
         */
        public static function button($name,$value='',$action_arr=array())
        {
            // Init.
            $button = '';
            
            $button .= "<div class='outer_box button_box'>";
            $button .= "<button name='$name' id='$name' class='button'";
        
            if (!empty($action_arr))
            {
                foreach($action_arr as $action_key => $action_value)
                {
                    $button .= ' '.$action_key.'='.$action_value.' ';
                }
            }
            
            $button .= ">";
        
            // Setting the value of the textarea
            $button .= $value;
            
            $button .= "</button>";
            $button .= "</div>";
            
            echo $button;
        }
        
        /**
         * Form::hidden_field()
         * 
         * @param mixed $name
         * @param string $value
         * @param mixed $action_arr
         * @return void
         */
        public static function hidden_field($name,$value='',$action_arr=array())
        {
            // Init.
            $textbox = '';
            
            $textbox .= "<input type='hidden' name='$name' id='$name' value='$value' class='text'";
            
            if (!empty($action_arr))
            {                    
                foreach($action_arr as $action_key => $action_value)
                {
                    $textbox .= ' '.$action_key.'='.$action_value.' ';
                }
            }
            
            $textbox .= "/>";
            
            echo $textbox;                        
        }
    }
?>