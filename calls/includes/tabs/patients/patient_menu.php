<div>
    <ul class="patient_menu">
        <li><a href="#" id="patient_display">General Information</a></li>
        <!--<li><a href="#">Employer</a></li>
        <li><a href="#" id="patient_drug_history">Drug History</a></li>-->
        <li><a href="#" id="patient_history">History</a></li>
        <li><a href="#" id="patient_visits">Visits</a></li>
        <li><a href="#" id="patient_complains">Complaints</a></li>
        <li><a href="#" id="patient_oe">Other Obsevations</a></li>
        <li><a href="#" id="patient_diagnosis">Diagnosis</a></li>
        <li><a href="#" id="patient_plans">Plans</a></li>
        <li><a href="#" id="patient_notes">Extra Notes</a></li>
        <li><a href="#" id="patient_prescriptions">Prescriptions</a></li>
        <li><a href="#" id="patient_consultations">Consultations</a></li>
        <li><a href="#" id="patient_admissions">Admissions</a></li>
        <!--
        <li><a href="#">Charges</a></li>
        <li><a href="#">Bills</a></li>
        <li><a href="#">Paymensts</a></li>
        <li><a href="#">Adjustments</a></li>
        <li><a href="#">Refunds</a></li>
        <li><a href="#">Documents</a></li>
        <li><a href="#">Referrals</a></li>
        <li><a href="#">Correspondence</a></li>
        <li><a href="#">Recalls</a></li>
        -->
    </ul>
</div>
<script>
    $(document).ready(function()
    {
        $(".patient_menu li a").on('click', function(e)
        {
            e.preventDefault();
            $file_loader.load_middle_pane('patients/' + $(this).attr("id"));
            //alert($(this).attr("id"));
        });
    });
</script>