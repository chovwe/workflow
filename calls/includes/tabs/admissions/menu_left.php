<div>
    <ul class="profile_menu">
        <li><a href="#" id="admission_list">View Admissions</a></li>
    </ul>
</div>
<script>
    $(document).ready(function()
    {
        $(".profile_menu li a").on('click', function(e)
        {
            e.preventDefault();
            $file_loader.load_middle_pane('admissions/' + $(this).attr("id"));
        });
    });
</script>