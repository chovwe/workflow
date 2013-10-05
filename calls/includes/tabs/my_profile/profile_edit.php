<?php
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'init.php' );
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'functions.php' );
    
    // Class instances
    $session     = new Session();
    $int_profile = new Int_Profile();
    $option      = new Option();
    $document    = new Document();
    
    // Init.
    $int_profile_id = $title = $fname = $mname = $sname = $gender = $user_id = $last_login = $total_logins = $address = $email = $phone1 = $phone2 = $dob = $marital = $religion = $qualification = $country = '';
    
    if ($int_profile instanceof Int_Profile)
    {
        // Init.
        $pid = '';
        
        // Fetching the Patient ID from memory
        if ($session instanceof Session) $pid = (int)$session->user_id;
        
        $profile_obj = $int_profile->fetch_profile_by_user_id($pid);
        if(!empty($profile_obj))
        {
            $int_profile_id= $profile_obj->int_profile_id;
            $title         = $profile_obj->title;
            $fname         = $profile_obj->first_name;
            $mname         = $profile_obj->middle_name;
            $sname         = $profile_obj->surname;
            $gender        = $profile_obj->gender;
            $address       = $profile_obj->address;
            $email         = $profile_obj->email;
            $phone1        = $profile_obj->phone_1;
            $phone2        = $profile_obj->phone_2;
            $dob           = $profile_obj->date_of_birth;
            $marital       = $profile_obj->marital_status;
            $religion      = $profile_obj->religion;
            $qualification = $profile_obj->qualification;
            $country       = $profile_obj->country;
        }
    }
?>
<form name="frm_new_patient" id="frm_new_patient" method="post">
    <div class="outter_pad">
        <div class="l_float percent50">
            <div class="inner_pad">
                <div class="fieldset">
                    <div class="legend">Personal Details:</div>
                    <table class="visible_table">
                        <tr>
                            <td class="percent35">Title:</td>
                            <td><?php Form::selectbox($option->dropdown_list('title'),'sel_title',$title); ?></td>
                        </tr>
                        <tr>
                            <td class="percent35">First Name:</td>
                            <td><?php Form::textbox('txt_fname',$fname); ?></td>
                        </tr>
                        <tr>
                            <td>Middle Name:</td>
                            <td><?php Form::textbox('txt_mname',$mname); ?></td>
                        </tr>
                        <tr>
                            <td>Surname:</td>
                            <td><?php Form::textbox('txt_sname',$sname); ?></td>
                        </tr>
                        <tr>
                            <td>Gender:</td>
                            <td><?php Form::selectbox(item_array('gender'),'sel_gender',$gender); ?></td>
                        </tr>
                    </table>
                    <!-- Tooltip -->
                    <div class="tooltip"><span class="dark_gray"></span><div class="tail"></div></div>
                </div>
            </div>
        </div>
            
        <div class="l_float percent50">
            <div class="inner_pad">
                <div class="fieldset" style="border:none;padding:0;">
                    <table class="percent100">
                        <tr>
                            <td style="padding-right:15px;">
                                <div>
                                    <div style='height:0px;width:0px;overflow:hidden;'><input type="file" name="fil_patient_pix" id="fil_patient_pix" onchange="javascript:$process_uploader();" accept="image/*" /></div>
                                    <button type="button" name="btn_patient_pix" id="btn_patient_pix" class="btn_pix rnd_oooo">
                                        <?php
                                            if($document instanceof Document)
                                            {
                                                $doc = $document->fetch_thumb_by_int_profile_id((int)$int_profile_id);
                                                if("" != $doc->filename)
                                                {
                                                    echo '<img id="pix_display" src="'.$doc->path.$doc->filename.'" class="rnd_oooo" width="100px" alt="" />';
                                                }else{
                                                    echo '<img id="pix_display" src="../calls/images/patients/sample.jpg" class="rnd_oooo" width="100px" alt="" />';
                                                }
                                            }
                                        ?>
                                    </button>     
                                    <input type="hidden" name="int_profile_id" value="<?php echo $int_profile_id; ?>" />
                            </td>
                            <td class="percent100" style="vertical-align:top;">
                                <table class="visible_table">
                                    <tr>
                                        <tr>
                                    <td>User&nbsp;ID:</td><td class="bold"><?php //echo $pid_alias; ?></td>
                                </tr>
                                <tr>
                                    <td>Last&nbsp;Login:</td>
                                    <td class="bold">
                                        <?php ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total&nbsp;Logins:</td>
                                    <td class="bold">
                                        <?php ?>
                                    </td>
                                </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <!-- Tooltip -->
                    <!-- <div class="tooltip"><span class="dark_gray"></span><div class="tail"></div></div> -->
                </div>
            </div>
        </div>
        
        <div class="percent100 clear"></div>
            
        <div class="l_float percent50">
            <div class="inner_pad">
                <div id="fieldset_contact" class="fieldset">
                    <div class="legend">Contact Details:</div>
                    <table class="visible_table">
                        <tr>
                            <td class="percent35" style="vertical-align:top;">Address:</td>
                            <td><?php Form::textarea('txta_address',$address); ?></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><?php Form::textbox('txt_email',$email); ?></td>
                        </tr>
                        <tr>
                            <td>Phone Number 1:</td>
                            <td><?php Form::textbox('txt_phone1',$phone1); ?></td>
                        </tr>
                        <tr>
                            <td>Phone Number 2:</td>
                            <td><?php Form::textbox('txt_phone2',$phone2); ?></td>
                        </tr>
                    </table>
                    <!-- Tooltip -->
                    <div class="tooltip"><span class="dark_gray"></span><div class="tail"></div></div>
                </div>
            </div>
        </div>
        
        <div class="l_float percent50">
            <div class="inner_pad">
                <div id="fieldset_other" class="fieldset">
                    <div class="legend">Other Details:</div>
                    <table class="visible_table">
                        <tr>
                            <td class="percent35">Date of Birth:</td>
                            <td>
                                <table class="inner_table">
                                    <tr>
                                        <td class="percent60">
                                            <?php
                                                // Init.
                                                $raw_date = $date = $age_date = $age_year = $age = '';
                                                
                                                if ('' != $dob)
                                                {
                                                    $raw_date = substr($dob, 0, 10);
                                                    $date     = explode('-', $raw_date);
                                                    $age_date = $date[2].'/'.$date[1].'/'.$date[0];
                                                    $age_year = $date[0];
                                                    $age      = date('Y') - $age_year;
                                                }
                                                
                                                Form::textbox('txt_dob',$age_date,array(
                                                    'onchange' => "javascript:\$date_engine.get_age(this.value,'#txt_age');",
                                                    'readonly' => 'true'                                                    
                                                ));
                                            ?>
                                        </td>
                                        <td class="r_align">Age:</td>                                        
                                        <td class="r_align percent15">
                                            <?php
                                                Form::textbox('txt_age',$age,array(
                                                    'onkeyup'  => "javascript:\$date_engine.get_dob(this.value,'#txt_dob');"
                                                ));
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>Marital Status:</td>
                            <td><?php Form::selectbox($option->dropdown_list('marital_status'),'sel_marital',$marital); ?></td>
                        </tr>
                        <tr>
                            <td>Religion:</td>
                            <td><?php Form::selectbox($option->dropdown_list('religion'),'sel_religion',$religion); ?></td>
                        </tr>
                        <tr>
                            <td>Country:</td>
                            <td><?php Form::selectbox($option->dropdown_list('country'),'sel_country',$country); ?></td>
                        </tr>
                    </table>
                    <!-- Tooltip -->
                    <div class="tooltip"><span class="dark_gray"></span><div class="tail"></div></div>
                </div>
            </div>
        </div>
        
        <div class="percent100 clear"></div>
        
        <div class="percent100">
            <div class="inner_pad">
                <div id="fieldset_qualification" class="fieldset">
                    <div class="legend">Qualification Details:</div>
                    <table class="visible_table">
                        <tr>
                            <td class="percent35">
                                <?php Form::textarea('qualification',$qualification); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="percent100 clear"></div>
        
        <div class="l_float percent100">
            <div class="inner_pad">
                <div class="fieldset">
                    <div class="legend">Controls:</div>
                    <table class="visible_table">
                        <tr>
                            <td colspan="2"><button type="submit">Save</button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="clear"></div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
        $init.equalize_heights(['#fieldset_contact','#fieldset_other']);
        
        // File uploader
        $('#btn_patient_pix').on('click', function()
        {
            $('#fil_patient_pix').trigger('click');
        });
        
        // Jquery date picker
        $( "#txt_dob" ).datepicker({ dateFormat: "dd/mm/yy", changeMonth: true, changeYear: true });
        
        // Switch on validator for certain form fields
        $validator.activate([
            {'name':'#sel_title','type':'select'},   // Title
            {'name':'#txt_fname','type':'text'},     // First Name
            {'name':'#txt_sname','type':'text'},     // Surname
            {'name':'#sel_gender','type':'select'},  // Gender
            {'name':'#txta_address','type':'text'},  // Address
            {'name':'#txt_phone1','type':'text'},    // Phone 1
            //{'name':'#txt_pid_alias','type':'text'}, // Patient ID
            {'name':'#sel_ptype','type':'select'},   // Patient Type
            {'name':'#sel_intdoc','type':'select'},  // Assigned Doctor
            {'name':'#sel_status','type':'select'},  // Patient Status
            {'name':'#txt_age','type':'text'}        // Age
        ]);
        
        // Reset the form field appearance
        $("input, textarea").on('keyup', function()
        {
            $(this).parent("div.outer_box").css({"border":"#CCC solid 1px"});
            
            // Switch-off the tooltip
            $validator.hide_tooltip();
        });
        $("input, textarea").on('change', function()
        {
            $(this).parent("div.outer_box").css({"border":"#CCC solid 1px"});
            
            // Switch-off the tooltip
            $validator.hide_tooltip();
        });
        $("select").on('change', function()
        {
            $(this).parent("div.outer_box").css({"border":"#CCC solid 1px"});
            
            // Switch-off the tooltip
            $validator.hide_tooltip();
        });
        
        // Form        
        $("#frm_new_patient").on('submit', function($this)
        {
            // Prevent the form from submitting
            $this.preventDefault();
            tinymce.triggerSave();
            // Return all input controls to their default color
            //$(this).find("input, textarea, select").css({"border":"#CCC solid 1px"});
                    
            // Error flag
            var $no_error = true;
            
            // Serialize the form values
            var $form       = $(this).serializeArray();
            
            // Loop through the form values
            $.each($form, function( e, $form )
            {
                //alert($form.name + ' => ' + $form.value);
                var $div = $("#"+$form.name);
                
                if (($div.prop("validate") == "text") && ($div.prop("value") == ""))
                {
                    $div.focus().css({"border":"red solid 2px"});
                    
                    var $div_top  = $div.position().top + $div.height() + 18,
                        $div_left = $div.position().left - 100;
                    
                    // Positioning the tooltip
                    $validator.show_tooltip([{
                        'caller':$div,
                        'top':$div_top,
                        'left':$div_left,
                        'msg':'Please,&nbsp;fill&nbsp;out&nbsp;this&nbsp;field.'
                    }]);
                    
                    // Error flag
                    $no_error = false;
                    
                    return false;
                }
                
                else if (($div.prop("validate") == "select") && ($div.prop("value") == ""))
                {
                    $div.focus().css({"border":"red solid 2px"});
                    
                    var $div_top  = $div.position().top + $div.height() + 18,
                        $div_left = $div.position().left - 100;
                    
                    // Positioning the tooltip
                    $validator.show_tooltip([{
                        'caller':$div,
                        'top':$div_top,
                        'left':$div_left,
                        'msg':'Please,&nbsp;select&nbsp;this&nbsp;field.'
                    }]);
                    
                    // Error flag
                    $no_error = false;
                    
                    return false;
                }
            });
            
            if ($no_error)
            {
                // Create an instance of the FormData() object to assemble form elements
                var formData = new FormData($("#frm_new_patient")[0]);
                formData.append('opt', 'update_profile');
                $.ajax({
                    url: "../calls/includes/switch.php",
                    type: "POST",
                    data: formData,
                    dataType: "json",                
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function($json)
                    {
                        if($json.status == "true")
                        {
                            $ui_engine.block({title:'Alert!',file:'alert_successful',width:'200',height:'120',buttons:'NNY'});
                            $file_loader.load_middle_pane('my_profile/profile_display');
                            $file_loader.load_left_pane('my_profile/menu_left');
                        }
                        else
                        {
                            $ui_engine.block({title:'Alert!',file:'alert_failure',width:'200',height:'120',buttons:'NNY'});
                        }
                    },
                    error: function(request, status, error)
                    {
                        //alert(request.responseText);
                        $ui_engine.block({title:'Alert!',file:'alert_connection',width:'200',height:'120',buttons:'NNY'});
                    }
                });
            }
        });
    });
    
    // Process file upload
    var $process_uploader = function()
    {
        var pix = $('#fil_patient_pix');
        if(pix.val() === "")
        {
            $ui_engine.block({title:'Alert!',file:'alert_failure',width:'200',height:'120',buttons:'NNY'});
        } else {
            // Create an instance of the FileReader object
            reader = new FileReader();
            var file = $('#fil_patient_pix').prop("files")[0];
            
            reader.onload = function(event)
            {
                imgUrl = event.target.result;
                $("#pix_display").attr({
                    src: imgUrl,
                    width: 100,
                    height: 100
                });
            }
            
            reader.onerror = function(event) 
            {
                console.error("File could not be read! Code " + event.target.error.code);
            };
            
            reader.readAsDataURL(file);
        }
    }
</script>

<script type="text/javascript">
tinymce.init({
    selector: "textarea#qualification",
    height: 200,    
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime table contextmenu paste"
    ],
    toolbar: "undo redo styleselect bold italic alignleft aligncenter alignright alignjustify bullist numlist",    
    menubar: "file format view edit table"
 });
</script>