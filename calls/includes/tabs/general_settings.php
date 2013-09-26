<?php require_once( '..'.DIRECTORY_SEPARATOR.'init.php' ); ?>
<div class="sub_wrapper">
    <div class="sub_menu">
        
        <div class="l_float percent15">
            <ul>
                <li class="percent100">
                    &nbsp;
                </li>
            </ul>
        </div>
        
        <div class="l_float" style="margin-left: -1px;">
            <ul>
                <li>
                    <table>
                        <tr>
                            <td style="vertical-align: middle;">
                                <span class="sub_menu32x32" style="background-position: center -256px; width: 2px;">&nbsp;</span>
                            </td>
                        </tr>
                    </table>
                </li>
                <li>
                    &nbsp;
                </li>
            </ul>
        </div>
        
        <div class="clear"></div>
    </div>
    
    <div class="sub_content">
        <div class="left_pane">
            <div>
                <ul>
                    <li><a href="#">Today</a></li>
                    <li><a href="#">This Week</a></li>
                    <li><a href="#">This Month</a></li>
                    <li><a href="#">This Quarter</a></li>
                    <li><a href="#">This Year</a></li>
                </ul>
            </div>
        </div>
        <div class="middle_pane">
            <div class="outter_pad">
                <div class="inner_pad">
                     This is the Sample Interface
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
        // Load the Side kick
        $file_loader.load_left_pane('general_settings/default_side_menu');
        
        // Balance the height
        $init.height_balance();
    });
</script>