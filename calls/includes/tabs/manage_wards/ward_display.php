<?php
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'init.php' );
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'functions.php' );
    
    // Class instances
    $session     = new Session();
    $int_profile = new Int_Profile();
    $option      = new Option();
    $ward   = new ward();
    ?>
<div class="outter_pad">
    <div class="percent50">
        <div class="inner_pad">
            <div class="fieldset">
                <div class="legend">Wards Details:</div>
                <table class="visible_table">
                    <?php
                        if($ward instanceof Ward)
                        {
                            if(isset($_POST['ward_id']))
                            {
                                $ward = $ward->fetch_ward_by_id((int)$_POST['ward_id']);
                                if($ward)
                                {
                                    echo "<tr>";
                                    echo "<td class='bold'>Ward Name:</td><td>".ucwords($ward->tittle)."</td>";
                                    Form::hidden_field('ward_id', $ward->ward_id);
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td class='bold'>Ward Type:</td><td>".$ward->ward_type."</td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td class='bold'>Units of Bed:</td><td>".$ward->nums_of_bed."</td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td class='bold'>Description:</td><td>".nl2br($ward->description)."</td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td class='bold'>Created:</td><td>".datetime_to_text($ward->date_created)."</td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td class='bold'>Last Modified:</td><td>".datetime_to_text($ward->date_modified)."</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
    
    
    <div class="clear"></div>
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        /*$init.equalize_heights(['#fieldset_contact','#fieldset_other']);
        $init.equalize_heights(['#fieldset_nok','#fieldset_qualification']);*/
        $(".datatable tr").each(function(){
            $(this).addClass("ui-widget-content");
        });
        $(".datatable tr").hover(function(){
              $(this).children("td").addClass("ui-state-hover");
             },
             function(){
              $(this).children("td").removeClass("ui-state-hover");
             }
        );
        $(".datatable tr").click(function(){
            $(this).children("td").toggleClass("ui-state-highlight");
        });
        // enable the edit button
        //$(document).find(".edit_ward").attr("href", "javascript:edit_ward()");
        
        $(document).find(".edit_ward").on('click', function()
        {
            ward_id = $(document).find("#ward_id").attr("value");
            if(!ward_id)
            {
                //
            }else{
                $file_loader.load_middle_pane('manage_wards/ward_edit', {ward_id:ward_id} )
            }
        });
    });
</script>