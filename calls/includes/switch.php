<?php
    include_once('init.php');
    include_once('functions.php');
    require_once( PLUGINS.DIRECTORY_SEPARATOR.'ThumbLib.inc.php' );
    
    // Switch
    if(isset($_POST['opt']))
    {
        switch($_POST['opt'])
        {
            case 'auth':
                // Init.
                $json = array();
                
                // User instance
                $user = new User();
                
                if ($user instanceof User)
                {
                    // Security check
                    $this_user = NULL;
                    $login_id  = trim($_POST['login_id']);
                    $passcode  = trim($_POST['passcode']);
                    
                    // Authentication message
                    $user_obj = $user->query(array(
                        'select' => 'user_id, passcode',
                        'from'   => 'users',
                        'where'  => "login_id='$login_id'",
                        'limit'  => '1',
                        'format' => 'Object'
                    ));
                    
                    if (!empty($user_obj))
                    {
                        foreach ($user_obj as $each_user)
                        {
                            if ($each_user->passcode == $passcode)
                            {
                                // Found user
                                $this_user = $each_user;
                                
                                // Exit loop
                                break;
                            }
                        }
                    }
                    
                    // Status message
                    if ( $this_user !== NULL )
                    {
                        // Session instance
                        $session = new Session();
                
                        if ($session instanceof Session)
                        {
                            $session->login($this_user);
                            
                            $json['status'] = 'true';
                            $json['msg']    = 'Authenticated!';
                        }
                        else
                        {
                            $json['status'] = 'false';
                            $json['msg']    = '<b>SESSION ERROR:</b> Please, Try Again.';
                        }
                    }
                    else
                    {
                        $json['status'] = 'false';
                        $json['msg']    = '<b>ERROR:</b> Invalid Login Details';
                        
                        // Session instance
                        $session = new Session();
                
                        // Logout
                        if ($session instanceof Session) $session->logout();
                    }
                } else {
                    $json['status'] = 'false';
                    $json['msg']    = '<b>ERROR:</b> Database Access Denied.';
                    
                    // Session instance
                    $session = new Session();
                    
                    // Logout
                    if ($session instanceof Session) $session->logout();
                }
                
                echo json_encode($json);
            break;
            case 'exit':
                // Init.
                $json = array();
                
                // Session instance
                $session = new Session();
                
                if ($session instanceof Session)
                {
                    // Logout
                    $session->logout();
                    
                    $json['status'] = 'true';
                    $json['msg']    = 'Logout!';
                }
                else
                {
                    $json['status'] = 'false';
                    $json['msg']    = '<b>SESSION ERROR:</b> Please, Try Again.';
                }
                
                echo json_encode($json);
            break;
            case 'ref_doc':
                // Init.
                $value = $_POST['value'];
                
                if (isset($value))
                {
                    // Doctor instance
                    $ext_profile = new Ext_Profile();
    
                    // Doctors associated with a specific Hospital
                    $refdoc_arr = array();
                    
                    if($ext_profile instanceof Ext_Profile)
                    {
                        $refdoc_arr = $ext_profile->dropdown_list($value);
                    }
                    
                    if (!empty($refdoc_arr))
                    {
                        Form::selectbox($refdoc_arr,'sel_extdoc');
                    }
                    else
                    {
                        Form::selectbox(array(),'sel_extdoc');
                    }
                }
            break;
            case 'insert_patient':
                // Init.
                $json = array();
                
                // Patient instance
                $patient = new Patient();
                
                if ($patient instanceof Patient)
                {
                    $status = $patient->insert_patient($_POST);
                    
                    if($status)
                    {
                        if(!empty($_FILES['fil_patient_pix']['name']))
                        {
                            if ($_FILES['fil_patient_pix']['error'] === UPLOAD_ERR_OK)
                            {
                                // Session instance
                                $session                  = new Session();
                                // Document instance
                                $document                 = new Document();
                                if($document instanceof Document)
                                {
                                    $thumb                    = "";
                                    $upload_path              = UPLOADS.DIRECTORY_SEPARATOR."pictures".DIRECTORY_SEPARATOR."thumbs".DIRECTORY_SEPARATOR;
                                    $extension                = pathinfo(basename($_FILES['fil_patient_pix']['name']), PATHINFO_EXTENSION);
                                    $new_name                 = str_replace('/', '-', $_POST['txt_pid_alias']);
                                    $doc_arr['patient_id']    = $session->get_patient_id();
                                    $doc_arr['filename']      = $new_name.'.'.$extension;
                                    $doc_arr['type']          = $_FILES['fil_patient_pix']['type'];
                                    $doc_arr['size']          = $_FILES['fil_patient_pix']['size'];
                                    $doc_arr['path']          = THUMB_PATH;
                                    $doc_arr['date_created']  = get_current_date();
                                    $doc_arr['date_modified'] = get_current_date();
                                    try
                                    {
                                        $thumb = PhpThumbFactory::create($_FILES['fil_patient_pix']['tmp_name']);
                                    }
                                    catch (Exception $e)
                                    {
                                        //handle errors
                                        $json['error']    = $e->getMessage();
                                    }
                                    // Resize thumbnail
                                    $thumb->adaptiveResize(100, 100);
                                    // Save thumbnail
                                    $thumb->save($upload_path.$doc_arr['filename']);
                                    // Set document vars
                                    $document->set_document_vars($doc_arr);
                                    // Insert record
                                    $document->insert_document();
                                }
                            }
                        }
                        $json['status'] = 'true';
                    }
                    else
                    {
                        $json['status'] = 'false';
                    }
                }
                
                echo json_encode($json);
            break;
            case 'update_patient':
                // Init.
                $json    = array();
                
                // Patient instance
                $patient = new Patient();
                
                if (('' != $_POST['txt_pid_alias']) && ($patient instanceof Patient))
                {
                    $status = $patient->update_patient($_POST);
                    
                    if($status)
                    {
                        if(!empty($_FILES['fil_patient_pix']['name']))
                        {
                            if ($_FILES['fil_patient_pix']['error'] === UPLOAD_ERR_OK)
                            {
                                // Session instance
                                $session                      = new Session();
                                // Document instance
                                $document                     = new Document();
                                if($document instanceof Document)
                                {
                                    $thumb                    = "";
                                    $upload_path              = UPLOADS.DIRECTORY_SEPARATOR."pictures".DIRECTORY_SEPARATOR."thumbs".DIRECTORY_SEPARATOR;
                                    $extension                = get_file_extension($_FILES['fil_patient_pix']);
                                    $new_name                 = str_replace('/', '-', $_POST['txt_pid_alias']);
                                    $doc_arr['filename']      = $new_name.'.'.$extension;
                                    $doc_arr['type']          = $_FILES['fil_patient_pix']['type'];
                                    $doc_arr['size']          = $_FILES['fil_patient_pix']['size'];
                                    $doc_arr['path']          = THUMB_PATH;
                                    $doc_arr['date_modified'] = get_current_date();
                                    // Check if a document with this Patient ID exists
                                    $doc                      = $document->fetch_thumb_by_patient_id((int)$session->get_patient_id());
                                        
                                    if(isset($doc->document_id))
                                    {                                        
                                        try
                                        {
                                            $thumb            = PhpThumbFactory::create($_FILES['fil_patient_pix']['tmp_name']);
                                        }
                                        catch (Exception $e)
                                        {
                                            //handle errors
                                            $json['error']    = $e->getMessage();
                                        }
                                        // Resize thumbnail
                                        $thumb->adaptiveResize(100, 100);
                                        // Save thumbnail
                                        $thumb->save($upload_path.$doc->filename);
                                        // Set document vars
                                        $doc->set_document_vars($doc_arr);
                                        // Update record
                                        $doc->update_document();
                                    }else{
                                        $doc_arr['patient_id']    = $session->get_patient_id();
                                        $doc_arr['date_created']  = get_current_date();
                                        // Set document vars
                                        $doc->set_document_vars($doc_arr);
                                        // Insert record
                                        $doc->insert_document();
                                    }
                                }
                            }
                        }
                        $json['status'] = 'true';
                        $session->set_session_message("The specified Record has been updated successfully.");
                    }
                    else
                    {
                        $json['status'] = 'false';
                    }
                }
                
                echo json_encode($json);
            break;
            case 'alias_search':
                // Init.
                $pid            = '';
                $alias          = trim($_POST['alias']);
                $json['status'] = 'false';
                
                
                if ('' != $alias)
                {
                    // Patient instance
                    $patient = new Patient();
                    
                    if ($patient instanceof Patient)
                    {
                        $pid = $patient->alias2id($alias);
                        
                        // Session instance
                        $session = new Session();
                        
                        if(('' != $pid) && ($session instanceof Session))
                        {
                            $session->set_patient_id($pid);
                            
                            $json['status'] = 'true';
                        }
                    }
                }
                
                echo json_encode($json);
            break;
            case 'access':
                switch($_POST['access_opt'])
                {
                    case 'form':
                        echo
                        "
                        <form name='frm_getaccess' id='frm_getaccess' method='post'>
                            <div id='access_msg' class='center gray'>(You are allowed to select multiple User types.)</div>
                            
                            <p class='bold pad15px'>How would you like to test this System?</p>
                            
                            <table class='invisible_table'>
                                <tr>
                                    <td class='gray percent1'><input name='chk_agtbro' id='chk_agtbro' type='checkbox' ".$_GET['chk_agtbro']." class='l_float' /></td>
                                    <td style='vertical-align: middle;'><label class='cursor_pointer blue' for='chk_agtbro'>As an Agent / Broker</label></td>
                                </tr>
                                <tr>
                                    <td class='gray'><input name='chk_staff' id='chk_staff' type='checkbox' ".$_GET['chk_staff']." class='l_float' /></td>
                                    <td style='vertical-align: middle;'><label class='cursor_pointer blue' for='chk_staff'>As Staff</label></td>
                                </tr>
                                <tr>
                                    <td class='gray'><input name='chk_client' id='chk_client' type='checkbox' ".$_GET['chk_client']." class='l_float' /></td>
                                    <td style='vertical-align: middle;'><label class='cursor_pointer blue' for='chk_client'>As a Client</label></td>
                                </tr>
                                <tr>
                                    <td class='gray'><input name='chk_mgt' id='chk_mgt' type='checkbox' ".$_GET['chk_mgt']." class='l_float' /></td>
                                    <td style='vertical-align: middle;'><label class='cursor_pointer blue' for='chk_mgt'>As Management</label></td>
                                </tr>
                            </table>
                            
                            <p class='bold pad15px'>Other details:</p>
                            
                            <table class='visible_table'>
                                <tr>
                                    <td class='percent30'>Surname:</td>
                                    <td><input name='csurname' id='csurname' value='".$_GET['csurname']."' class='txtbox' /></td>
                                </tr>
                                <tr>
                                    <td>Other Names:</td>
                                    <td><input name='cothname' id='cothname'  value='".$_GET['cothname']."' class='txtbox' /></td>
                                </tr>
                                <tr>
                                    <td>Company:</td>
                                    <td><input name='ccompany' id='ccompany' value='".$_GET['ccompany']."' class='txtbox' /></td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td><input name='cemail' id='cemail' value='".$_GET['cemail']."' class='txtbox' /></td>
                                </tr>
                                <tr>
                                    <td>Phone:</td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td class='l_align' style='padding: 0 6px 0 0'><input name='cgsm' id='cgsm' value='".$_GET['cgsm']."' class='txtbox' /></td>
                                                <td class='r_align dark_gray' style='padding: 0 0 0 6px;'> <b>e.g:</b>&nbsp;23480xxxxxxxx</td>
                                            </tr>
                                        </table>
                                </tr>
                                <tr>
                                    <td class='l_align'>&nbsp;</td>
                                    <td class='r_align'><button name='getaccess_btn' id='getaccess_btn' type='button' onclick=\"javascript:\$get_access(document.forms.frm_getaccess,'preview');\">&nbsp; Preview &#9658;</button></td>
                                </tr>
                                <tr>
                                    <td class='l_align' colspan='2'>
                                        <div class='font11 dark_gray'>Already have your Login details? <a href='#get_access' onclick='javascript:login_blocker();' class='orange bold'>Click here</a> to Login</div>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        ";
                    break;
                    case 'preview':
                        echo
                        "
                        <form name='frm_getaccess' id='frm_getaccess' method='post'>
                            <div id='access_msg' class='center gray'>(<span class='coy_color'>Please, confirm your Selections.</span>)</div>
                            
                            <p class='bold pad15px'>You like to test the System:</p>
                            
                            <table class='invisible_table'>
                                <input type='hidden' name='chk_agtbro' id='chk_agtbro' value='".$_GET['chk_agtbro']."' />
                                <input type='hidden' name='chk_staff' id='chk_staff' value='".$_GET['chk_staff']."' />
                                <input type='hidden' name='chk_client' id='chk_client' value='".$_GET['chk_client']."' />
                                <input type='hidden' name='chk_mgt' id='chk_mgt' value='".$_GET['chk_mgt']."' />
                                ";
                            
                                if ($_GET['chk_agtbro'] == 'checked')
                                {
                                    echo " <tr>
                                                <td class='gray percent1'><img src='images/interface/prelogin/checkbox.png' /></td>
                                                <td style='vertical-align: middle;'>
                                                    <label class='blue'>As an Agent / Broker</label>
                                                </td>
                                            </tr>";
                                }
                            
                                if ($_GET['chk_staff'] == 'checked')
                                {
                                    echo " <tr>
                                                <td class='gray percent1'><img src='images/interface/prelogin/checkbox.png' /></td>
                                                <td style='vertical-align: middle;'>
                                                    <label class='blue'>As Staff</label>
                                                </td>
                                            </tr>";
                                }
                            
                                if ($_GET['chk_client'] == 'checked')
                                {
                                    echo " <tr>
                                                <td class='gray percent1'><img src='images/interface/prelogin/checkbox.png' /></td>
                                                <td style='vertical-align: middle;'>
                                                    <label class='blue'>As a Client</label>
                                                </td>
                                            </tr>";
                                }
                            
                                if ($_GET['chk_mgt'] == 'checked')
                                {
                                    echo " <tr>
                                                <td class='gray percent1'><img src='images/interface/prelogin/checkbox.png' /></td>
                                                <td style='vertical-align: middle;'>
                                                    <label class='blue'>As Management</label>
                                                </td>
                                            </tr>";
                                }
                                
                            echo "
                            </table>
                            
                            <p class='bold pad15px'>Other details:</p>
                            
                            <table class='visible_table'>
                                <tr>
                                    <td class='percent30'>Surname:</td>
                                    <td class='bold'>
                                        ".ucwords($_GET['csurname'])."
                                        <input type='hidden' name='csurname' id='csurname' value='".ucwords($_GET['csurname'])."' class='txtbox' />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Other Names:</td>
                                    <td class='bold'>
                                        ".ucwords($_GET['cothname'])."
                                        <input type='hidden' name='cothname' id='cothname' value='".ucwords($_GET['cothname'])."' class='txtbox' />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Company:</td>
                                    <td class='bold'>
                                        ".ucwords($_GET['ccompany'])."
                                        <input type='hidden' name='ccompany' id='ccompany' value='".ucwords($_GET['ccompany'])."' class='txtbox' />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td class='bold'>
                                        ".strtolower($_GET['cemail'])."
                                        <input type='hidden' name='cemail' id='cemail' value='".strtolower($_GET['cemail'])."' class='txtbox' />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Phone:</td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td class='l_align bold' style='padding-left: 0;'>
                                                    ".$_GET['cgsm']."                                                
                                                    <input type='hidden' name='cgsm' id='cgsm' value='".$_GET['cgsm']."' class='txtbox' />
                                                </td>
                                                <td class='r_align dark_gray'>&nbsp;</td>
                                            </tr>
                                        </table>
                                </tr>
                                <tr>
                                    <td class='l_align'><button name='getaccess_btn' id='getaccess_btn' type='button' onclick=\"javascript:\$get_access(document.forms.frm_getaccess,'form');\">&#9668; Edit &nbsp;</button></td>
                                    <td class='r_align'><button name='getaccess_btn' id='getaccess_btn' type='button' onclick=\"javascript:\$get_access(document.forms.frm_getaccess,'preview');\">&nbsp; Confirm &#9658;</button></td>
                                </tr>
                                <tr>
                                    <td class='l_align' colspan='2'>
                                        <div class='font11 dark_gray'>Already have your Login details? <a href='#get_access' onclick='javascript:login_blocker();' class='orange bold'>Click here</a> to Login</div>
                                    </td>
                                </tr>
                            </table>
                        </form>";
                    break;
                }
            break;
            case 'update_profile':
                // Init.
                $json = array();
                
                // Session instance
                $session = new Session();
                       
                // Int_Profile instance
                $int_profile = new Int_Profile();
                
                if($int_profile instanceof Int_Profile)
                {
                    $profile_obj = $int_profile->fetch_profile_by_user_id((int)$session->user_id);
                    if("" != $profile_obj->int_profile_id)
                    {
                        $int_profile->set_profile_vars($_POST);
                        $status = $int_profile->update_profile();
                        
                        if($status)
                        {
                            if(!empty($_FILES['fil_patient_pix']['name']))
                            {
                                if ($_FILES['fil_patient_pix']['error'] === UPLOAD_ERR_OK)
                                {
                                    // Session instance
                                    $session                  = new Session();
                                    //
                                    $document = new Document();
                                    if($document instanceof Document)
                                    {
                                        $thumb                    = "";
                                        $upload_path              = UPLOADS.DIRECTORY_SEPARATOR."pictures".DIRECTORY_SEPARATOR."thumbs".DIRECTORY_SEPARATOR;
                                        $extension                = get_file_extension($_FILES['fil_patient_pix']);
                                        $new_name                 = "Thumb".$session->user_id;
                                        $doc_arr['filename']      = $new_name.'.'.$extension;
                                        $doc_arr['type']          = $_FILES['fil_patient_pix']['type'];
                                        $doc_arr['size']          = $_FILES['fil_patient_pix']['size'];
                                        $doc_arr['path']          = THUMB_PATH;
                                        $doc_arr['date_modified'] = get_current_date();
                                                                                                                                                    
                                        // Check if a document with this Profile ID exist
                                        $doc                = $document->fetch_thumb_by_int_profile_id((int)$_POST['int_profile_id']);
                                        
                                        if(isset($doc->document_id))
                                        {                                        
                                            try
                                            {
                                                $thumb         = PhpThumbFactory::create($_FILES['fil_patient_pix']['tmp_name']);
                                            }
                                            catch (Exception $e)
                                            {
                                                //handle errors
                                                $json['error'] = $e->getMessage();
                                            }
                                            // Resize thumbnail
                                            $thumb->adaptiveResize(100, 100);
                                            // Save thumbnail
                                            $thumb->save($upload_path.$doc->filename);
                                            // Set document vars
                                            $doc->set_document_vars($doc_arr);
                                            // Update record
                                            $doc->update_document();
                                        }else{
                                            $doc_arr['int_profile_id']    = (int)$_POST['int_profile_id'];
                                            $doc_arr['date_created']  = get_current_date();
                                            // Set document vars
                                            $doc->set_document_vars($doc_arr);
                                            // Insert record
                                            $doc->insert_document();
                                        }
                                    }
                                }
                            }
                            
                            $json['status'] = 'true';
                        $session->set_session_message("The specified Record has been updated successfully.");
                        }else{
                            $json['status'] = 'false';
                        }
                    }
                }
                echo json_encode($json);
            break;
            case "update_kin":
                // Init.
                $json = array();
                
                // Session instance
                $session = new Session();
                       
                // Int_Profile instance
                $kin = new Kinship();
                
                if($kin instanceof Kinship)
                {
                    // Fetch kin by profile ID
                    $kin_id = $kin->fetch_kin_by_int_profile_id($_POST['int_profile_id']);
                    if("" != $kin_id->int_profile_id)
                    {
                        // Set Kinship vars
                        $kin->set_kinship_vars($_POST);
                        $status = $kin->update_kinship();
                        if($status)
                        {
                            $json['status'] = 'true';
                        $session->set_session_message("The specified Record has been updated successfully.");
                        }else{
                            $json['status'] = 'false';
                        }
                    }
                }
                echo json_encode($json);
            break;
            case "update_password":
                
                $json['status'] = 'true';
                echo json_encode($json);
            break;
            case "insert_vitals":
                 // Init.
                $json = array();
                
                // Session instance
                $session = new Session();
                
                // Vital_Sign Instance
                $vital_sign = new Vital_Sign();
                
                if($vital_sign instanceof Vital_Sign)
                {
                    $vitals_arr['patient_id'] = $session->get_patient_id();
                    $vitals_arr['user_id']    = $session->user_id;
                    $vitals_arr['temp']       = $_POST['txt_tmp'];
                    $vitals_arr['bp']         = $_POST['txt_bp'];
                    $vitals_arr['entry_date'] = get_current_date();
                    // Set Vital Sign vars
                    $vital_sign->set_vital_sign_vars($vitals_arr);
                    
                    // Insert Vital Sign                    
                    if($vital_sign->insert_vital_sign())
                    {
                        $json['status'] = 'true';
                        $session->set_session_message("The record has been saved successfully.");
                    }else{
                        $json['status'] = 'false';
                    }
                }
                echo json_encode($json);
            break;
            case "insert_admission":
                // Init.
                $json = array();
                
                // Session instance
                $session   = new Session();
                // Profile instance
                $profile   = new Int_Profile();
                // Admission instance
                $admission = new Admission();
                
                if($admission instanceof Admission)
                {
                    $admission_arr                   = $_POST;
                    $int_profile_id                  = ($profile->fetch_profile_by_user_id((int)$session->user_id))? $profile->int_profile_id : "";
                    $admission_arr['int_profile_id'] = $int_profile_id;
                    $admission_arr['entry_date']     = get_current_date();
                    // Set up POST vars
                    $admission->set_admission_vars($admission_arr);
                    if($admission->insert_admission())
                    {
                        $json['status'] = 'true'; 
                        $session->set_session_message("The specified Admission has been created successfully.");
                    }else{
                        $json['status'] = 'false';
                    }
                }
                echo json_encode($json);
            break;
            case "update_admission":
                
                // Init.
                $json = array();
                
                // Session instance
                $session   = new Session();
                // Profile instance
                $profile   = new Int_Profile();
                // Admission instance
                $admission = new Admission();
                
                if($admission instanceof Admission)
                {
                    
                    if($admission->update_admission())
                    {
                        $json['status'] = 'true'; 
                        $session->set_session_message("The specified record has been updated successfully.");
                    }else{
                        $json['status'] = 'false';
                    }
                }
                echo json_encode($json);
            break;
            case "ward":
                // Sub option for grouping related actions
                switch($_POST['sub_opt'])
                {
                    case "insert_ward":
                        // Init.
                        $json = array();
                        
                        // Session instance
                        $session = new Session();
                        // Profile instance
                        $profile = new Int_Profile();
                        // Ward instance
                        $ward    = new Ward();
                        
                        if($ward instanceof Ward)
                        {
                            $ward_arr            = $_POST;
                            $int_profile_id      = ($profile->fetch_profile_by_user_id((int)$session->user_id))? $profile->int_profile_id : "";
                            $ward_arr['int_profile_id'] = $int_profile_id;
                            $ward_arr['date_created'] = get_current_date();
                            $ward_arr['date_modified'] = get_current_date();
                            // Setup POST vars
                            $ward->set_ward_vars($ward_arr);
                            if($ward->insert_ward())
                            {
                                $json['status'] = 'true'; 
                                $session->set_session_message("The specified Ward has been created successfully.");
                            }else{
                                $json['status'] = 'false';
                            }
                        }
                        echo json_encode($json);
                    break;
                    case "update_ward":
                        // Init.
                        $json = array();
                        
                        // Session instance
                        $session = new Session();
                        // Profile instance
                        $profile = new Int_Profile();
                        // Ward instance
                        $ward    = new Ward();
                        
                        if($ward instanceof Ward)
                        {
                            $ward_arr            = $_POST;
                            $int_profile_id      = ($profile->fetch_profile_by_user_id((int)$session->user_id))? $profile->int_profile_id : "";
                            $ward_arr['int_profile_id'] = $int_profile_id;
                            $ward_arr['date_modified'] = get_current_date();
                            // Setup POST vars
                            $ward->set_ward_vars($ward_arr);
                            if($ward->update_ward())
                            {
                                $json['status'] = 'true'; 
                                $session->set_session_message("The specified Record has been updated successfully.");
                            }else{
                                $json['status'] = 'false';
                            }
                        }
                        echo json_encode($json);
                    break;
                    case "ward_bed";
                        // Init.
                        $ward_id = $_POST['ward_id'];
                        
                        if (isset($ward_id))
                        {
                            // Bed instance
                            $ward_bed         = new Bed();
            
                            // Beds associated with a specific Ward
                            $ward_bed_arr     = array();
                            
                            if($ward_bed instanceof Bed)
                            {
                                $ward_bed_arr = $ward_bed->dropdown_list($ward_id);
                            }
                            
                            if (!empty($ward_bed_arr))
                            {
                                Form::selectbox($ward_bed_arr,'bed_id');
                            }
                            else
                            {
                                Form::selectbox(array(),'sel_extdoc');
                            }
                        }
                    break;
                }
            break;
            case "bed_inventory":
                switch($_POST['sub_opt'])
                {
                    case "insert_bed_inventory":
                        // Init.
                        $json = array();
                        
                        // Session instance
                        $session = new Session();
                        // Profile instance
                        $profile = new Int_Profile();
                        // Bed_inventory instance
                        $bed_inventory = new Bed_inventory();
                        
                        if($bed_inventory instanceof Bed_inventory)
                        { 
                            $bed_inventory_arr                   = $_POST;
                            $profile_id                          = ($profile->fetch_profile_by_user_id((int)$session->user_id))? $profile->int_profile_id : "";
                            $bed_inventory_arr['int_profile_id'] = $profile_id;
                            $bed_inventory_arr['date_created']   = get_current_date();
                            $bed_inventory_arr['date_modified']  = get_current_date();
                            $bed_inventory->set_bed_inventory_vars($bed_inventory_arr);
                            if($bed_inventory->insert_bed_inventory())
                            {
                                $json['status'] = 'true'; 
                                $session->set_session_message("The specified Record has been updated successfully.");
                            }else{
                                $json['status'] = 'false';
                            }
                        }
                        echo json_encode($json);
                    break;
                    case "update_bed_inventory":
                        // Init.
                        $json = array();
                        
                        // Session instance
                        $session = new Session();
                        // Profile instance
                        $profile = new Int_Profile();
                        // Bed_inventory instance
                        $bed_inventory = new Bed_inventory();
                        if($bed_inventory instanceof Bed_inventory)
                        {
                            $bed_inventory_arr                   = $_POST;
                            $profile_id                          = ($profile->fetch_profile_by_user_id((int)$session->user_id))? $profile->int_profile_id : "";
                            $bed_inventory_arr['int_profile_id'] = $profile_id;
                            $bed_inventory_arr['date_modified']  = get_current_date();
                            $bed_inventory->set_bed_inventory_vars($bed_inventory_arr);
                            if($bed_inventory->update_bed_inventory())
                            {
                                $json['status'] = 'true'; 
                                $session->set_session_message("The specified Record has been updated successfully.");
                            }else{
                                $json['status'] = 'false';
                                $session->set_session_message("The specified Record has not been updated.");
                            }
                            
                        }
                        echo json_encode($json);
                    break;
                }
            break;
            case "insert_bed":
                // Init.
                $json = array();
                
                // Session instance
                $session = new Session();
                // Profile instance
                $profile = new Int_Profile();
                // bed instance
                $bed    = new Bed();
                
                if($bed instanceof Bed)
                {
                    $bed_arr = $_POST;
                    $bed_arr['user_id'] = $session->user_id;
                    $bed_arr['date_created'] = get_current_date();
                    $bed_arr['date_modified'] = get_current_date();
                    // Set up POST vars
                    $bed->set_bed_vars($bed_arr);
                    if($bed->insert_bed())
                    {
                        $json['status'] = 'true'; 
                        $session->set_session_message("The record has been saved successfully.");
                    }else{
                        $json['status'] = 'false';
                    }
                }
                echo json_encode($json);
            break;
            case "update_bed":
                // Init.
                $json = array();
                
                // Session instance
                $session = new Session();
                // Profile instance
                $profile = new Int_Profile();
                // Ward bed
                $bed     = new Bed();
                
                if($bed instanceof Bed)
                {
                    $bed_arr = $_POST;
                    $bed_arr['user_id'] = $session->user_id;
                    $bed_arr['date_modified'] = get_current_date();
                    // Set up POST vars
                    $bed->set_bed_vars($bed_arr);
                    if($bed->update_bed())
                    {
                        $json['status'] = 'true'; 
                        $session->set_session_message("The specified Record has been updated successfully.");
                    }else{
                        $json['status'] = 'false';
                    }
                }
                echo json_encode($json);
            break;            
            case "consultation":
                // Session instance
                $session = new Session();
                // Profile instance
                $profile = new Int_Profile();
                // Consultation instance
                $consult = new Consultation();
                
                if($consult instanceof Consultation)
                {
                    $consult_arr                   = $_POST;
                    $profile_id                    = ($profile->fetch_profile_by_user_id((int)$session->user_id))? $profile->int_profile_id : "";
                    $consult_arr['int_profile_id'] = $profile_id;
                    $consult_arr['entry_date']     = get_current_date();
                    $consult->set_consultation_vars($consult_arr);
                    
                    if($consult->insert_consultation($consult_arr))
                    {
                        $json['status'] = 'true'; 
                        $session->set_session_message("The record has been saved successfully.");
                    }else{
                        $json['status'] = 'false';
                    }
                }
                echo json_encode($json);
            break;
            case "note";
                // Init.
                $json = array();
                
                // Session instance
                $session = new Session();
                // Profile instance
                $profile = new Int_Profile();
                // Note instance
                $note    = new Note();
                if($note instanceof Note)
                {
                    $note_arr                   = $_POST;
                    $profile_id                 = ($profile->fetch_profile_by_user_id((int)$session->user_id))? $profile->int_profile_id : "";
                    $note_arr['int_profile_id'] = $profile_id;
                    $note_arr['entry_date']     = get_current_date();
                    $note->set_note_vars($note_arr);
                    if($note->insert_note())
                    {
                        $json['status'] = 'true';
                    }else{
                        $json['status'] = 'false';
                        $session->set_session_message($note_arr['note'] );
                    }
                }
                echo json_encode($json);
            break;
            case "reviews":
                
                $json['status'] = 'true';
                echo json_encode($json);
            break;
            
        }
    }
?>