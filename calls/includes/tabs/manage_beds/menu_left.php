<div>
    <ul class="bed_inventory_menu">
        <li><a href="#" id="bed_inventory_list">View Beds</a></li>
    </ul>
</div>
<script>
    $(document).ready(function()
    {
        $(".bed_inventory_menu li a").on('click', function(e)
        {
            e.preventDefault();
            $file_loader.load_middle_pane('manage_beds/' + $(this).attr("id"));
        });
    });
</script>