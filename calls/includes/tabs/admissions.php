<?php require_once( '..'.DIRECTORY_SEPARATOR.'init.php' ); ?>
<div class="sub_wrapper">
    <div class="sub_menu">
        
        <div class="l_float percent15">
            <ul>
                <li class="percent100">
                    <a href="javascript:new_addmission();" title="Add Admission" style="padding-left: 25px;">
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
                <!--<li>
                    <a href="javascript:edit_profile();" title="Edit Profile">
                        <table class="inner_table">
                            <tr>
                                <td style="width:32px;">
                                    <span class="sub_menu32x32" style="background-position: 0 -96px;">&nbsp;</span>
                                </td>
                                <td>
                                    Edit Profile
                                </td>
                            </tr>
                        </table>
                    </a>
                </li>
                <li>
                    <table class="inner_table">
                        <tr>
                            <td style="width:2px;">
                                <span class="sub_menu32x32" style="background-position: center -256px; width: 2px;">&nbsp;</span>
                            </td>
                        </tr>
                    </table>
                </li>-->
            </ul>
        </div>
        
        <div class="clear"></div>
    </div>
    
    <div class="sub_content">
        <div class="left_pane">
            <div>
            </div>
        </div>
        <div class="middle_pane">
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
        $file_loader.load_middle_pane('admissions/admissions_display');
        $file_loader.load_right_pane('admissions/menu_right');
        
        // Balance the height
        $init.height_balance();
        
        // Set the interface to edit existing Profile details
    edit_admission = function()
    {
        $file_loader.load_middle_pane('admissions/admission_edit');
        $file_loader.load_left_pane('admissions/menu_left');
    }
    });
</script>