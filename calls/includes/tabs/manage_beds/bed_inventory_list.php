<?php
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'init.php' );
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'functions.php' );
    
    // Class instances
    $session        = new Session();
    $int_profile    = new Int_Profile();
    $option         = new Option();
    $bed_inventory  = new Bed_inventory();
    ?>
<div class="outter_pad">
    <div class="percent100">
        <div class="inner_pad">
            <div class="fieldset">
                <div class="legend">List of Beds:</div>
                <table class="datatable visible_table">
                    <tr class="header">
                        <th style="padding: 10px 10px 5px;font-weight: bold; border-top-left-radius: 4px; ">Title</th>
                        <th style="padding: 5px; font-weight: bold;" width="15%">Bed Type</th>
                        <th style="padding: 10px 5px; font-weight: bold;" width="10%">Units</th>
                        <th style="padding: 10px 5px; font-weight: bold; border-top-right-radius: 4px;" width="25%">Entry Date</th>
                    </tr>
                    <?php
                        if($bed_inventory instanceof Bed_inventory)
                        {
                            $bed_inventory = $bed_inventory->fetch_all();
                            if($bed_inventory)
                            {
                                foreach($bed_inventory as $entry)
                                {
                                    echo "<tr>";
                                    echo "<td><a href='#' data='".$entry->bed_inventory_id."' class='bed_inventory'>".ucwords($entry->tittle)."</a></td>";
                                    echo "<td>".$entry->bed_type."</td>";
                                    echo "<td>".$entry->units."</td>";
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
        $(".datatable tr td a.bed_inventory").on('click', function(e){
           e.preventDefault();
           bed_inventory_id = $(this).attr('data');
           $file_loader.load_generic_content("manage_beds/bed_inventory_display", "bed_inventory_id=" + bed_inventory_id , "manage_beds_pane");
        });
        
    });
</script>