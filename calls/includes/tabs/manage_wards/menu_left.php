<div>
    <ul class="profile_menu">
        <li><a href="#" id="ward_list">View Wards</a></li>
    </ul>
</div>
<script>
    $(document).ready(function()
    {
        $(".profile_menu li a").on('click', function(e)
        {
            e.preventDefault();
            $file_loader.load_middle_pane('manage_wards/' + $(this).attr("id"));
        });
    });
</script>