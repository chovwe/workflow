<?php 
    require_once( '..'.DIRECTORY_SEPARATOR.'init.php' );
    require_once( '..'.DIRECTORY_SEPARATOR.'functions.php' );
    
    // Class instances
    $option      = new Option(); 
?>
<div class="sub_wrapper">
    <div class="sub_menu patient">
        
        <div class="l_float percent15">
            <ul>
                <li class="percent100">
                    <a href="javascript:new_patient();" title="Add Patient" style="padding-left: 25px;">
                        <table class="inner_table">
                            <tr>
                                <td style="width:32px;">
                                    <span class="sub_menu32x32" style="background-position: 0 -32px;">&nbsp;</span>
                                </td>
                                <td>
                                    Add Patient
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
                    <a href="javascript:edit_patient();" title="Edit Patient">
                        <table class="inner_table">
                            <tr>
                                <td style="width:32px;">
                                    <span class="sub_menu32x32" style="background-position: 0 -96px;">&nbsp;</span>
                                </td>
                                <td>
                                    Edit Patient
                                </td>
                            </tr>
                        </table>
                    </a>
                </li>
                <li>
                    <table class="inner_table">
                        <tr>
                            <td>
                                <a href="javascript:forward_patient();" title="Forward Patient">
                                    <table class="inner_table">
                                        <td style="width:32px;">
                                            <span class="sub_menu32x32" style="background-position: 0 -320px;">&nbsp;</span>
                                        </td>
                                        <td>
                                            Forward Patient
                                        </td>
                                    </table>
                                </a>
                            </td>
                            <td>
                                <?php Form::selectbox($option->dropdown_list('department'),'sel_pool', 'Select:'); ?>
                            </td>
                        </tr>
                    </table>
                </li>
                <li>
                    <a href="#" title="Delete Patient">
                        <table class="inner_table">
                            <tr>
                                <td style="width:32px;">
                                    <span class="sub_menu32x32" style="background-position: 0 -160px;">&nbsp;</span>
                                </td>
                                <td>
                                    Delete Patient
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
                </li>
                <li>
                    <table class="inner_table" style="padding: 0 10px;">
                        <tr>
                            <td>
                                <?php Form::textbox('alias_search'); ?>
                            </td>
                            <td style="width:32px;">
                                <a href="javascript:alias_search();" id="alias_search_btn" title="Search Patient" style="padding:0;">
                                    <span class="sub_menu32x32" style="background-position: 0 -224px;">&nbsp;</span>
                                </a>
                            </td>
                        </tr>
                    </table>
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
        // .sub_menu bar display
        $('.patient a').on('mouseover', function(){
            //$(this).css('color','#000');
            var $span   = $(this).find('span'),
                $bg_pos = $span.css('backgroundPosition').split(" "),
                $y_pos  = parseInt($bg_pos[1]) + 32;
                $span.css('background-position', $bg_pos[0] + ' ' + $y_pos + 'px');
        });
        $('.patient a').on('mouseout', function(){
            //$(this).css('color','#777');
            var $span   = $(this).find('span'),
                $bg_pos = $span.css('backgroundPosition').split(" "),
                $y_pos  = parseInt($bg_pos[1]) - 32;
                $span.css('background-position', $bg_pos[0] + ' ' + $y_pos + 'px');
        });
        
        // .sub_menu bar search
        $('#alias_search_btn').on('click', function()
        {
            // Init.
            var $search = $('#alias_search');
            
            if ($search.val() == '')
            {
                $search.focus().parent("div.outer_box").css({'border-color':'red'});
            } else {
                $search.focus().parent("div.outer_box").css({'border-color':'#ccc'});
            }
        })
        
        // Load the Left/Right Menu
        $file_loader.load_left_pane('patients/menu_left');
        $file_loader.load_right_pane('patients/menu_right');
        
        // Balance the height
        $init.height_balance();
    });
    
    var alias_search = function()
    {
        // Storing the content of the Patient Search box
        var $alias = $('#alias_search').val()
        
        // Fetch records based on the Patient search criteria
        if ('' != $alias)
        {
            $.ajax({
                url: "../calls/includes/switch.php",
                type: "POST",
                data: {'alias':$alias,'opt':'alias_search'},
                dataType: "json",
                success: function($json)
                {
                    if($json.status == "true")
                    {
                        //$ui_engine.block({title:'Alert!',file:'alert_successful',width:'200',height:'120',buttons:'NNY'});
                        $file_loader.load_middle_pane('patients/patient_display');
                        $file_loader.load_left_pane('patients/patient_menu');
                    }else{
                        $ui_engine.block({title:'Alert!',file:'alert_failure',width:'200',height:'120',buttons:'NNY'});
                    }
                },
                error: function(request, status, error)
                {
                    //alert(request.responseText);
                    $ui_engine.block({title:'Alert!',file:'alert_failure',width:'200',height:'120',buttons:'NNY'});
                }
            });
        }
    },
        
    // Set the interface to accept new Patient details
    new_patient = function()
    {
        $file_loader.load_middle_pane('patients/patient_add');
        $file_loader.load_left_pane('patients/menu_left');
    }
    
    // Set the interface to edit existing Patient details
    edit_patient = function()
    {
        $file_loader.load_middle_pane('patients/patient_edit');
        $file_loader.load_left_pane('patients/patient_menu');
    }
</script>