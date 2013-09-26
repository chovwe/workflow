<div>
    <ul class="profile_menu">
        <li><a href="#" id="profile_display">View Profile</a></li>
        <li><a href="#" id="profile_edit_kin">Update Next Of Kin</a></li>
        <li><a href="#" id="profile_edit_password">Change Password</a></li>
    </ul>
</div>
<script>
    $(document).ready(function()
    {
        $(".profile_menu li a").on('click', function(e)
        {
            e.preventDefault();
            $file_loader.load_middle_pane('my_profile/' + $(this).attr("id"));
            //alert($(this).attr("id"));
        });
    });
</script>