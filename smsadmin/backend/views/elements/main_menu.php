<?php $node_id = $mt_menu->get_current_parent_id(); ?> 
<div id="topmenu">
    <ul id="top-navigation">
        <?php foreach ($mt_menu->get_full_menu() as $item): ?>
            <?php if ($item->is_visible): ?>
                <?php if ($item->id == $node_id): ?>
                    <li class="current"><a href='<?php echo site_url($item->url) ?>'  title="<?php echo ucwords($item->tips) ?>" >
                            <?php
                            $mt_menu->set_current_top_node($item);
                            echo ucwords($item->title)
                            ?></a></li>
                <?php else: ?>
                    <li><a href="<?php echo site_url($item->url) ?>" title="<?php echo ucwords($item->tips) ?>" ><?php echo ucwords($item->title) ?></a></li>
                <?php endif ?>
            <?php endif ?>    
        <?php endforeach ?>	
        <li><a href="<?php echo site_url('login/logout') ?>" title='Logout'>Logout</a></li>
    </ul>
</div>