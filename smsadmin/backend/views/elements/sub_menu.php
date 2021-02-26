<?php if ($top_node = $mt_menu->get_current_top_node()): ?>
    <div id="top-panel">
        <div id="panel">
            <ul class="nav">
                <?php foreach ($top_node->get_children() as $item): ?>
                    <?php if ($item->is_visible): ?>
                        <?php if ($item->url == ($active_module.'/'.$active_action) OR $item->url == $active_module): ?>
                            <li  class="active-item" ><a class='<?php echo $item->alias ?>' href="<?php echo site_url($item->url) ?>"  title="<?php echo ucwords($item->tips) ?>"><?php echo ucwords($item->title) ?></a></li>
                        <?php else: ?>
                            <li><a  class='<?php echo $item->alias ?>' href="<?php echo site_url($item->url) ?>" title="<?php echo ucwords($item->tips) ?>"><?php echo ucwords($item->title) ?></a></li>	
                        <?php endif ?>	
                    <?php endif ?>	
                <?php endforeach ?>
            </ul>
        </div>
    </div>
    <?php
 endif ?>
 