<?php

    // create id attribute
    $id = !empty($id) ? 'id="'.$id.'"' : '';

    // get needed classes
    $classes = 'acidcode acidcode__btn';
    $classes.= !empty($size) ? ' acidcode__btn--size-'.$size : '';
    $classes.= !empty($shape) ? ' acidcode__btn--shape-'.$shape : '';
    $classes.= !empty($alignment) ? ' acidcode__btn--alignment-'.$alignment : '';
    $classes.= !empty($hover_color) ? ' acidcode__btn--hover-'.$hover_color : '';
    $classes.= !empty($class) ? ' '.$class : '';
    $classes.=!empty($effect) ? ' ' .$effect : '';
    $classes.=!empty($waves_color) ? ' '.$waves_color : '';
    $classes.=!empty($background_color) ? ' '.$background_color : '';
    $classes.= !empty($label_color) ? ' '.$label_color : '';
    // create class attribute
    $classes = $classes !== '' ? 'class="'.$classes.'"' : '';

    // create href attribute
    $href = !empty($link) ? 'href="'.$link.'"' : '';

    // get content
    $content = !empty($content) ? $this->get_clean_content($content) : '';

    // get target
    $target = !empty($newtab) ? 'target="_blank"' : '';

    $validation = !empty($validation) ? $validation : ''; ?>
    <?php echo '<a '.$id.' '.$classes.' '.$href.' '.$target.'>'.$content.'</a>'; ?>
