<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (isset($arResult) && !empty($arResult)):?>
    <ul class="navbar-nav mr-auto">
        <?php foreach ($arResult as $item): ?>
            <li class="nav-item <?php if ($item['SELECTED']): ?>active<?php endif; ?>">
                <a class="nav-link" href="<?= $item['LINK']; ?>"><?= $item['TEXT']; ?></a>
            </li>
        <?php endforeach; ?>

    </ul>
<?php endif;
