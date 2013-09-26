<?php
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'init.php' );
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'functions.php' );
    
    // Class instances
    $session     = new Session();
    $int_profile = new Int_Profile();
    $option      = new Option();
    $document    = new Document();
    
    // Init.
    $title = $fname = $mname = $sname = $gender = $user_id = $last_login = $total_logins = $address = $email = $phone1 = $phone2 = $kin_fname = $kin_mname = $kin_sname = $kin_gender = $kin_address = $kin_email = $kin_phone1 = $kin_phone2 = $kin_relate = $dob = $marital = $religion = $qualification = $country = '';
    
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
            $kin_fname     = $profile_obj->kin_first_name;
            $kin_mname     = $profile_obj->kin_middle_name;
            $kin_sname     = $profile_obj->kin_surname;
            $kin_gender    = $profile_obj->kin_gender;
            $kin_address   = $profile_obj->kin_address;
            $kin_email     = $profile_obj->kin_email;
            $kin_phone1    = $profile_obj->kin_phone_1;
            $kin_phone2    = $profile_obj->kin_phone_2;
            $kin_relate    = $profile_obj->relationship;
        }
    }
?>

<div class="outter_pad">
    <div class="l_float percent50">
        <div class="inner_pad">
            <div class="fieldset">
                <div class="legend">Personal Details:</div>
                <table class="visible_table">
                    <tr>
                        <td class="percent35">Title:</td>
                        <td class="bold"><?php echo get_id_desc($title, 'title'); ?></td>
                    </tr>
                    <tr>
                        <td class="percent35">First Name:</td>
                        <td class="bold"><?php echo $fname; ?></td>
                    </tr>
                    <tr>
                        <td>Middle Name:</td>
                        <td class="bold"><?php echo $mname; ?></td>
                    </tr>
                    <tr>
                        <td>Surname:</td>
                        <td class="bold"><?php echo $sname; ?></td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <td class="bold"><?php echo get_id_desc($gender, 'gender'); ?></td>
                    </tr>
                </table>
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
                                <?php
                                    if($document instanceof Document)
                                    {
                                        $doc = $document->fetch_thumb_by_int_profile_id((int)$int_profile_id);
                                        if("" != $doc->filename)
                                        {
                                            echo '<img src="'.$doc->path.$doc->filename.'" class="rnd_oooo" width="100px" alt="" />';
                                        }else{
                                            echo '<img src="../calls/images/patients/sample.jpg" class="rnd_oooo" width="100px" alt="" />';
                                        }
                                    }
                                ?>
                            </div>
                        </td>
                        <td class="percent100" style="vertical-align:top;">
                            <table class="visible_table">
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
                        <td class="bold"><?php echo $address; ?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td class="bold"><?php echo $email; ?></td>
                    </tr>
                    <tr>
                        <td>Phone Number 1:</td>
                        <td class="bold"><?php echo $phone1; ?></td>
                    </tr>
                    <tr>
                        <td>Phone Number 2:</td>
                        <td class="bold"><?php echo $phone2; ?></td>
                    </tr>
                </table>
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
                            <table class="invisible_table">
                                <tr>
                                    <td class="percent70 bold" style="padding-left:0;padding-top:0;padding-bottom:0;">
                                        <?php
                                            // Init.
                                            $raw_date = $date = $age_date = $age_year = $age = '';
                                            
                                            if ($dob != '')
                                            {
                                                $raw_date = substr($dob, 0, 10);
                                                $date     = explode('-', $raw_date);
                                                $age_date = $date[2].'/'.$date[1].'/'.$date[0];
                                                $age_year = $date[0];
                                                $age      = date('Y') - $age_year;
                                                
                                                echo $age_date;
                                            }
                                        ?>
                                    </td>
                                    <td style="padding-right:0;padding-top:0;padding-bottom:0;">Age: <b><?php if ($age != '') echo $age; ?></b></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>Marital Status:</td>
                        <td class="bold"><?php echo get_id_desc($marital, 'marital_status'); ?></td>
                    </tr>
                    <tr>
                        <td>Religion:</td>
                        <td class="bold"><?php echo get_id_desc($religion, 'religion'); ?></td>
                    </tr>
                    <tr>
                        <td>Country:</td>
                        <td class="bold"><?php echo get_id_desc($country, 'country'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="percent100 clear"></div>
    
    <div class="l_float percent50">
        <div class="inner_pad">
            <div id="fieldset_nok" class="fieldset">
                <div class="legend">Next of Kin Details:</div>
                <table class="visible_table">
                    <tr>
                        <td class="percent35">First Name:</td>
                        <td class="bold"><?php echo $kin_fname; ?></td>
                    </tr>
                    <tr>
                        <td>Middle Name:</td>
                        <td class="bold"><?php echo $kin_mname; ?></td>
                    </tr>
                    <tr>
                        <td>Surname:</td>
                        <td class="bold"><?php echo $kin_sname; ?></td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <td class="bold"><?php echo get_id_desc($kin_gender, 'gender'); ?></td>
                    </tr>
                    <tr>
                        <td class="percent35" style="vertical-align:top;">Address:</td>
                        <td class="bold"><?php echo $kin_address; ?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td class="bold"><?php echo $kin_email; ?></td>
                    </tr>
                    <tr>
                        <td>Phone Number 1:</td>
                        <td class="bold"><?php echo $kin_phone1; ?></td>
                    </tr>
                    <tr>
                        <td>Phone Number 2:</td>
                        <td class="bold"><?php echo $kin_phone2; ?></td>
                    </tr>
                    <tr>
                        <td>Relationship:</td>
                        <td class="bold"><?php echo get_id_desc($kin_relate, 'relationship'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="l_float percent50">
        <div class="inner_pad">
            <div id="fieldset_qualification" class="fieldset">
                <div class="legend">Qualification Details:</div>
                <?php echo $qualification; ?>
            </div>
        </div>
    </div>
    
    
    <div class="clear"></div>
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        $init.equalize_heights(['#fieldset_contact','#fieldset_other']);
        $init.equalize_heights(['#fieldset_nok','#fieldset_qualification']);
    });
</script>