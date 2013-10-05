<?php
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'init.php' );
    require_once( INCLUDES.DIRECTORY_SEPARATOR.'functions.php' );
    
    // Class instances
    $session      = new Session();
    $note = new Note();
    $int_profile  = new Int_Profile();
    $option       = new Option();
?>
    <div class="outter_pad">
        <div style="margin: 20px;">
            <h2 style="padding: 0px; margin: 0px; color: #2d2d2d;  font-size: 18px;">Notes: (Patient Name)</h2>
        </div>
        
    <div id="extra_tools" style="margin: 20px;">
        <?php ?>
        <!--<button class="button" id="btn_consult" name="btn_consult" style="width: 120px;">Consultation</button>
        <button class="button" id="btn_note" name="btn_note" style="width: 120px;">Note</button>-->
        <span id="btn_note">New Note</span>
    </div>
        <div class="percent100">
            <div class="inner_pad">
                <div id="accordion">
                <?php
                    if($note instanceof Note)
                    {
                        $notes = $note->fetch_by_patient_id((int)$session->get_patient_id());
                        if($notes)
                        {
                            foreach($notes as $entry)
                            {
                                echo "<h3>".datetime_to_text($entry->entry_date)."</h3>";
                                echo "<div>";
                                echo '<table class="visible_table">';
                                echo '<tr><td class="bold">Note: </td>';
                                echo "<td>".$entry->note."</td>";
                                echo "</tr>";
                                echo '</table>';
                                echo "<hr />";
                                echo '<p class="">Created by: '.$entry->profile_name.'</p>';
                                echo "</div>";
                            }
                        }
                    }
                ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>

<script type="text/javascript">
    $(document).ready(function()
    {
        $("#btn_note").button({icons: { primary: "ui-icon-plusthick" }});
        
        $("#accordion").accordion({
            collapsible: true,
            heightStyle: "content"
        });
        
        $("#btn_note").on('click', function(){
           $file_loader.load_middle_pane('patients/patient_nurse_notes'); 
        });
    });
</script>