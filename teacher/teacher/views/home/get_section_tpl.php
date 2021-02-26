<?php
		echo '<select id="section_id">';
			foreach($get_section as $val){	  
				echo '<option value="'.$val['id'].'">'.$val['title'].'</option>';
			}
		echo '</select>';	
		
?>		

<script>
    $(document).ready(function() {
           $('#section_id').change(function(){
			var val = $(this).val();
			//alert(val);
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(); ?>/home/class_routine",
                data: "section_id=" + val,
                success: function(response) {
                    $('#routine').html(response);
                }
            });
            return false;
        });
    });
</script>