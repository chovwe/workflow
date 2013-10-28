<?php
    require_once( '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'init.php' );
    require_once( INCLUDES.DIRECTORY_SEPARATOR.'functions.php' );
    
    // Class instances
    $session      = new Session();
    $patient      = new Patient();
    $diagnosis    = new Diagnosis();
    $int_profile  = new Int_Profile();
    $option       = new Option();
    $patient_name = $patient->fetch_patient_name_by_id((int)$session->get_patient_id());
?>
    <div class="outter_pad">
        <div style="margin: 20px;">
            <h2 style="padding: 0px; margin: 0px; color: #2d2d2d;  font-size: 18px;">Diagnosis: (<?php echo $patient_name->name; ?>)</h2>
        </div>
    
        <div class="percent100">
            <div class="inner_pad">
                <div id="accordion">
                <?php
                    if($diagnosis instanceof Diagnosis)
                    {
                        $diag = $diagnosis->fetch_by_patient_id((int)$session->get_patient_id());
                        if($diag)
                        {
                            foreach($diag as $entry)
                            {
                                echo "<h3>".datetime_to_text($entry->entry_date)."</h3>";
                                echo "<div>";
                                echo '<table class="visible_table">';
                                echo '<tr><td class="bold">Diagnosis: </td>';
                                echo "<td>".$entry->diagnosis."</td>";
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
        $("#accordion").accordion({
            collapsible: true,
            heightStyle: "content"
        });
        
    });
</script>