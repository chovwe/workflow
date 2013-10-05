<?php require_once( '..'.DIRECTORY_SEPARATOR.'init.php' ); ?>
<?php 
    $session = new Session();
    $pid = $session->get_patient_id();
?>
<div class="sub_wrapper">
    <div class="sub_menu">
        
        <div class="l_float percent15">
            <ul>
                <li class="percent100">
                    <a href="javascript:new_admission();" id="new_admission" data="<?php echo $pid;?>" title="Add Admission" style="padding-left: 25px;">
                        <table class="inner_table">
                            <tr>
                                <td style="width:32px;">
                                    <span class="sub_menu32x32" style="background-position: 0 -32px;">&nbsp;</span>
                                </td>
                                <td>
                                    New Admission
                                </td>
                            </tr>
                        </table>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="l_float" style="margin-left: -1px;">
            <ul>
                <li>
                    <table class="inner_table">
                        <tr>
                            <td style="width:2px;">
                                <span class="sub_menu32x32" style="background-position: center -256px; width: 2px;">&nbsp;</span>
                            </td>
                        </tr>
                    </table>
                </li>
                <li>
                    <a href="#" title="Edit Admission" class="edit_admission">
                        <table class="inner_table">
                            <tr>
                                <td style="width:32px;">
                                    <span class="sub_menu32x32" style="background-position: 0 -96px;">&nbsp;</span>
                                </td>
                                <td>
                                    Edit Admission
                                </td>
                            </tr>
                        </table>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="clear"></div>
    </div>
    
    <div class="sub_content">
        <div class="left_pane">
            <div>
            </div>
        </div>
        <div class="middle_pane" id="admission_pane">
            <div class="outter_pad">
                <div class="inner_pad">
                     
                </div>
                
                <div class="clear"></div>
            </div>
        </div>
        <div class="right_pane">
            <div>
                &nbsp;
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        // Load the Left/Right Menu
        $file_loader.load_left_pane('admissions/menu_left');
        $file_loader.load_middle_pane('admissions/admission_list');
        //$file_loader.load_right_pane('admissions/menu_right');
        
        // Balance the height
        $init.height_balance();
        
        // Set the interface to edit existing Profile details
    new_admission = function()
    {
        pid = $("#new_admission").attr('data');
        if("" == pid)
        {
            
        }else{
            $file_loader.load_middle_pane('admissions/admission_add');
            $file_loader.load_left_pane('admissions/menu_left');
        }
    }
    });
</script>