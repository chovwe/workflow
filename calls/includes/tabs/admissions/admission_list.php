<?php
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'init.php' );
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'functions.php' );
    
    // Class instances
    $session        = new Session();
    $int_profile    = new Int_Profile();
    $option         = new Option();
    $admission     = new Admission()  
    ?>
<div class="outter_pad">
    <div class="percent100">
        <div class="inner_pad">
            <div class="fieldset">
                <div class="legend">List of Admissions:</div>
                <table class="datatable visible_table">
                    <tr class="header">
                        <th style="padding: 10px 10px 5px;font-weight: bold; border-top-left-radius: 4px; ">Patient Name</th>
                        <th style="padding: 5px; font-weight: bold;" width="20%">Ward</th>
                        <th style="padding: 10px 5px; font-weight: bold;" width="15%">Bed</th>
                        <th style="padding: 10px 5px; font-weight: bold;" width="15%">Start Date</th>
                        <th style="padding: 10px 5px; font-weight: bold; border-top-right-radius: 4px;" width="15%">End Date</th>
                    </tr>
                    <?php
                        if($admission instanceof Admission)
                        {
                            $admissions = $admission->fetch_all();
                            if($admissions)
                            {
                                foreach($admissions as $entry)
                                {
                                    echo "<tr>";
                                    echo "<td><a href='#' data='".$entry->admission_id."' class='admission'>".ucwords("$entry->name")."</a></td>";
                                    echo "<td>".$entry->ward."</td>";
                                    echo "<td>".$entry->title."</td>";
                                    echo "<td>".$entry->start_date."</td>";
                                    echo "<td>".$entry->end_date."</td>";
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
        $(".datatable tr td a.admission").on('click', function(e){
           e.preventDefault();
           admission_id = $(this).attr('data');
           //$file_loader.load_generic_content("admissions/admission_display", "admission_id=" + admission_id , "admission_pane");
        });
        
    });
</script>