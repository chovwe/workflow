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
    <div class="percent100">
        <div class="inner_pad">
            <div class="fieldset">
                <div class="legend">List of Wards:</div>
                <table class="datatable visible_table">
                    <tr class="header">
                        <th style="padding: 10px 10px 5px;font-weight: bold; border-top-left-radius: 4px; ">Ward Name</th>
                        <th style="padding: 5px; font-weight: bold;" width="15%">Ward Type</th>
                        <th style="padding: 10px 5px; font-weight: bold;" width="10%">Bed Units</th>
                        <th style="padding: 10px 5px; font-weight: bold; border-top-right-radius: 4px;" width="25%">Entry Date</th>
                    </tr>
                    <?php
                        if($ward instanceof Ward)
                        {
                            $wards = $ward->fetch_all();
                            if($wards)
                            {
                                foreach($wards as $entry)
                                {
                                    echo "<tr>";
                                    echo "<td><a href='#' data='".$entry->ward_id."' class='ward'>".ucwords($entry->tittle)."</a></td>";
                                    echo "<td>".$entry->ward_type."</td>";
                                    echo "<td>".$entry->nums_of_bed."</td>";
                                    echo "<td>".datetime_to_text($entry->date_created)."</td>";
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
        $(".datatable tr td a.ward").on('click', function(e){
           e.preventDefault();
           //alert("html");
           ward_id = $(this).attr('data');
           $file_loader.load_middle_pane('manage_wards/ward_display', {ward_id:ward_id} )
        });
        // disable the edit button
        //$(document).find(".edit_ward").attr("href", "#");
        
    });
</script>