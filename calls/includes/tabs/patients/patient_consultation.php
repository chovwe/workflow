<?php
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'init.php' );
    require_once( INCLUDES.DIRECTORY_SEPARATOR.'functions.php' );
    
    // Class instances
    $session      = new Session();
    $patient      = new Patient();
    $consultation = new Consultation();
    $int_profile  = new Int_Profile();
    $option       = new Option();$patient_name = $patient->fetch_patient_name_by_id((int)$session->get_patient_id());
?>
    <div class="outter_pad">
        <div style="margin: 20px;">
            <h2 style="padding: 0px; margin: 0px; color: #2d2d2d;  font-size: 18px;">Consultation: (<?php echo $patient_name->name; ?>)</h2>
        </div>
        <div id="extra_tools" style="margin: 20px;">
            <?php ?>
            <!--<button class="button" id="btn_consult" name="btn_consult" style="width: 120px;">Consultation</button>
            <button class="button" id="btn_note" name="btn_note" style="width: 120px;">Note</button>-->
            <span id="btn_consult">Consultation</span>
        </div>
        
        <div class="percent100">
            <div class="inner_pad">
                <div id="accordion">
                <?php
                    if($consultation instanceof Consultation)
                    {
                        $consultations = $consultation->fetch_by_patient_id((int)$session->get_patient_id());
                        if($consultations)
                        {
                            foreach($consultations as $entry)
                            {
                                echo "<h3>".datetime_to_text($entry->entry_date)."</h3>";
                                echo "<div>";
                                echo '<table class="visible_table">';
                                echo '<tr><td class="bold">Complaint: </td>';
                                echo "<td>".$entry->complaint."</td>";
                                echo "</tr>";
                                echo '<tr><td class="bold">Observation: </td>';
                                echo "<td>".$entry->observation."</td>";
                                echo "</tr>";
                                echo '<tr><td class="bold">Diagnosis: </td>';
                                echo "<td>".$entry->diagnosis."</td>";
                                echo "</tr>";
                                echo '<tr><td class="bold">Plan: </td>';
                                echo "<td>".$entry->plan."</td>";
                                echo "</tr>";
                                echo '<tr><td class="bold">Note: </td>';
                                echo "<td>".$entry->note."</td>";
                                echo "</tr>";
                                echo '</table>';
                                echo "<hr />";
                                echo '<p class="">Created by: '.$entry->doc_name.'</p>';
                                echo "</div>";
                            }
                            //var_dump($consultations);                            
                        }
                    }
                ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>

<script type="text/javascript">
    $(document).ready(function()
    {
        $("#btn_consult").button({icons: { primary: "ui-icon-plusthick" }});
        $("#accordion").accordion({
            collapsible: true,
            heightStyle: "content"
        });
        
        $("#btn_consult").on('click', function(){
           $file_loader.load_middle_pane('patients/patient_consult'); 
        });
    });
</script>