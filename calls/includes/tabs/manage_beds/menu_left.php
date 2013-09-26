<div>
    <ul class="profile_menu">
        <li><a href="#" id="bed_invetory_list">View Beds</a></li>
    </ul>
</div>
<script>
    $(document).ready(function()
    {
        $(".profile_menu li a").on('click', function(e)
        {
            e.preventDefault();
            $file_loader.load_middle_pane('manage_beds/' + $(this).attr("id"));
            //alert($(this).attr("id"));
        });
    });
</script>