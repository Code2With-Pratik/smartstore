<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<nav class="page-navigation" aria-label="<?=lang('Pager.pageNavigation')?>">
	<ul class="pagination">
		<?php if ($pager->hasPrevious()): ?>
			<li>
				<a href="<?=$pager->getFirst()?>" aria-label="<?=lang('Pager.first')?>">
					<span aria-hidden="true"><i class="fe fe-chevrons-left"></i></span>
				</a>
			</li>
			<li>
				<a href="<?=$pager->getPrevious()?>" aria-label="<?=lang('Pager.previous')?>">
					<span aria-hidden="true"><i class="fe fe-chevron-left"></i></span>
				</a>
			</li>
		<?php endif?>

		<?php foreach ($pager->links() as $link): ?>
			<li <?=$link['active'] ? 'class="page-item active"' : ''?>>
				<a <?=$link['active'] ? 'class="page-link"' : ''?> href="<?=$link['uri']?>">
					<?=$link['title']?>
				</a>
			</li>
		<?php endforeach?>

		<?php if ($pager->hasNext()): ?>
			<li>
				<a href="<?=$pager->getNext()?>" aria-label="<?=lang('Pager.next')?>">
					<span aria-hidden="true"><i class="fe fe-chevron-right"></i></span>
				</a>
			</li>
			<li>
				<a href="<?=$pager->getLast()?>" aria-label="<?=lang('Pager.last')?>">
					<span aria-hidden="true"><i class="fe fe-chevrons-right"></i></span>
				</a>
			</li>
		<?php endif?>
	</ul>
</nav>
