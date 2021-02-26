<ul class="system_messages">
    <?php if($msg = $this->session->flashdata('success')):?>
        <li class="green"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>
    <?php if($msg = $this->session->flashdata('error')):?>
        <li class="red"><span class="ico"></span><strong class="system_title"><?php echo $msg ?></strong></li>
    <?php endif ?>
</ul>
<div id="box">
    <h3 class='grid_title_bar'>Insert Result</h3>
    <table width='100%'>
            <thead>
                   <tr>
                      <th class="first">#</th>
                      <th class="first">Class</th>
                      <th class="first">Publish</th>                      
                      <th class="first">Action</th>
                   </tr>
            </thead>
            <tbody>
                <?php 
                    $i = 1;
                    foreach ($classes as $class):
                ?>
                <tr>
                    <td align="center"><?php echo $i; ?></td>
                    <td align="center"><?php echo $class['title'];   ?></td>
                    <td align="center"><?php if($class['is_result_publish'] == 1){ echo 'Published';}else{echo 'Unpublished';}   ?></td>
                    <td>
                        <a class="result_actn" title="Edit" href="<?php echo base_url(); ?>index.php/publish_result/edit_result_class/<?php echo $class['id']; ?>">
                            <img class="result-icon" alt="Edit" src="<?php echo base_url(); ?>/smsadmin/img/actn_result.png"></a>
                    </td>
                </tr>
                <?php   
                    $i++;
                endforeach;
                ?>
            </tbody>
    </table>
</div>