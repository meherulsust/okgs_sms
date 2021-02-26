<h1>Syllabus List</h1>
<form action="#" method="post">
<table class="list_table">
	<tr height="20">
		<td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;<b>Class </b></td>
		<td>
		<b><?php //echo $class; ?>
		
			<select class="textfield" id="class_id" name="class_id">
			<option value="">---Select Class--</option>
			  <?php foreach($get_class as $val){?>
			  <option value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>
			  <?php }?>
			</select>		
		</b>
	</tr>
</table>
</form>
<div id="syllabus_list">
<table width="80%" align="center" class="list_table">
	<tr>
		<th width="10%" align="center"><b>SL. No.</b></th>
		<th width="30%" align="center"><b>Syllabus Name</b></th>
		<th width="10%" align="center"><b>Action </b></th>	
	</tr>
	<tr>
		<td align="center" colspan='4'>No Syllabus found.</td>		
	</tr>
</table>
</div>


<body>
    <div id="pdfContainer" class = "pdf-content">
    </div>
</body>
<script>
	$(document).ready(function() {
           $('#class_id').change(function(){
			var val = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(); ?>/syllabus_list/get_syllabus",
                data: "class_id=" + val,
                success: function(response) {
                    $('#syllabus_list').html(response);
                }
            });
            return false;
        });
    }); 
</script>

