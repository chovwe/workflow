<?php
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'init.php' );
    require_once( INCLUDES.DIRECTORY_SEPARATOR.'functions.php' );
    
    // Class instances
    $session      = new Session();
    $int_profile  = new Int_Profile();
    $option       = new Option();
    $bed_inventory  = new Bed_inventory();
   if($bed_inventory instanceof Bed_inventory)
   {
        if(isset($_POST['bed_inventory_id']))
        {
            $bed_inventory = $bed_inventory->fetch_by_bed_inventory_id((int)$_POST['bed_inventory_id']);
            /*if($bed_inventory)
            {
                var_dump($bed_inventory);
            }*/
        }
   }
?>
    
<form name="frm_new_bed" id="frm_new_bed" method="post" action="../calls/includes/test.php">
    <div class="outter_pad">
        <div class="l_float percent50">
            <div class="inner_pad">
                <div class="fieldset">
                    <div class="legend">Edit Bed Details:</div>
                    <table class="visible_table">
                        <tr>
                            <td class="percent35">Title:</td>
                            <td>
                                <?php Form::textbox('tittle', $bed_inventory->tittle); ?>
                                <?php Form::hidden_field('bed_inventory_id', $bed_inventory->bed_inventory_id); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="percent35">Units of Beds:</td>
                            <td><?php Form::textbox('units', $bed_inventory->units); ?></td>
                        </tr>
                        <tr>
                            <td  style="vertical-align:top;">Description:</td>
                            <td><?php Form::textarea("description", $bed_inventory->description); ?></td>
                        </tr>
                        <tr>
                            <td>Bed Type:</td>
                            <td><?php Form::selectbox($option->dropdown_list('bed_type'),'bed_type', $bed_inventory->option_id); ?></td>
                        </tr>
                    </table>
                    <!-- Tooltip -->
                    <div class="tooltip"><span class="dark_gray"></span><div class="tail"></div></div>
                </div>
            </div>
        </div>
            
        <div class="percent100 clear"></div>
        
        <div class="l_float percent50">
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
        
        // Switch on validator for certain form fields
        $validator.activate([
            {'name':'#tittle','type':'text'},   // Tittle
            {'name':'#units','type':'text'},     // Units
            {'name':'#bed_type','type':'select'},  // Bed Type
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
        $("#frm_new_beds").on('submit', function($this)
        {
            // Prevent the form from submitting
            $this.preventDefault();
            
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
                var formData = new FormData($("#frm_new_bed")[0]);
                formData.append('opt', 'bed_inventory');
                formData.append('sub_opt', 'update_bed_inventory');
                
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
                            bed_inventory_id = $(document).find("#bed_inventory_id").attr("value");
                            $ui_engine.block({title:'Alert!',file:'alert_successful',width:'200',height:'120',buttons:'NNY'});
                            $file_loader.load_generic_content("manage_beds/bed_inventory_display", "bed_inventory_id=" + bed_inventory_id , "manage_beds_pane");
                            $file_loader.load_left_pane('manage_beds/menu_left');
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
</script>