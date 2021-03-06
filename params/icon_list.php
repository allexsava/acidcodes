<?php
$class = "span12";

if (isset($param['admin_class'])) $class = $param['admin_class'];
if (isset($param['required'])) $required = "required"; ?>


<span class="<?php echo $class; ?>">
    <label for="<?php echo $param['param_key'] ?>"><?php echo $param['name'] ?></label>
    <div class="acid_icon_list">
        <input <?php echo $required; ?> name="<?php echo $param['param_key'] ?>" class="selected_icon acidcode__select-hidden"/>
        <div class="row icon-container">
            <span class="col s12 icon__special-title">Solid icons</span>
            <ul>
        <?php foreach ($param["solid-icons"] as $icon) { ?>
            <li class="col s1 icon" data-icon="<?php echo $icon; ?>"><i class="<?php echo $icon; ?>"></i></li>
        <?php } ?>
            </ul>
        </div>
        <div class="row icon-container">
            <span class="col s12 icon__special-title">Regular icons</span>
            <ul>
        <?php foreach ($param["regular-icons"] as $icon) { ?>
            <li class="col s1 icon" data-icon="<?php echo $icon; ?>"><i class="<?php echo $icon; ?>"></i></li>
        <?php } ?>
                </ul>
        </div>
        <div class="row icon-container">
            <span class="col s12 icon__special-title">Brands icons</span>
            <ul>
        <?php foreach ($param["brands-icons"] as $icon) { ?>
            <li class="col s1 icon" data-icon="<?php echo $icon; ?>"><i class="<?php echo $icon; ?>"></i></li>
        <?php } ?>
                </ul>
        </div>
    </div>
</span>
