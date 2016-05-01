<?php
/**
 * @version    2.7.x
 * @package    K2
 * @author     JoomlaWorks http://www.joomlaworks.net
 * @copyright  Copyright (c) 2006 - 2016 JoomlaWorks Ltd. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die;

$request = JFactory::getApplication()->input;
$limitstart = $request->getInt('limitstart', null);
if ($limitstart && $limitstart > 0) {
	$itemlist = array();
	if (isset($this->leading) && count($this->leading)) {
		foreach ($this->leading as $k => $v) {
			$itemlist[] = $v;
		}
		$this->leading = null;
	}
	if (isset($this->primary) && count($this->primary)) {
		foreach ($this->primary as $k => $v) {
			$itemlist[] = $v;
		}
		$this->primary = null;
	}
	if (isset($this->secondary) && count($this->secondary)) {
		foreach ($this->secondary as $k => $v) {
			$itemlist[] = $v;
		}
		$this->secondary = $itemlist;
	}
}
?>
<div class="box-wrapper programs">
	<div id="category" class="itemlist<?php if ($this->params->get('pageclass_sfx')) echo ' ' . $this->params->get('pageclass_sfx'); ?>">
		<div class="page-tools">
			<ul class="list-unstyled list-inline order-style">
				<li>نحوه نمایش:</li>
				<li><span class="clickable" data-style="list"><i class="icon-list"></i></span></li>
				<li class="active"><span class="clickable" data-style="grid"><i class="icon-th"></i></span></li>
			</ul>
		</div>
		<?php if (isset($this->category) && ($this->params->get('catImage') || $this->params->get('catTitle') || $this->params->get('catDescription') || $this->category->event->K2CategoryDisplay )) { ?>
			<?php if ($this->category->image && $this->params->get('catTitle')) { ?>
				<section class="box category-desc">
					<div>
						<?php if ($this->params->get('catImage') && $this->category->image) { ?>
							<figure id="item-media" class="img cat-img">
								<img src="<?php echo $this->category->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($this->category->name); ?>" />
							</figure>
						<?php } ?>
						<div class="desc">
							<?php if ($this->params->get('catTitle')) { ?>
								<h2 class="cat-title"><?php echo $this->category->name; ?></h2>
							<?php } ?>
							<?php if ($this->params->get('catDescription')) { ?>
								<div class="cat-text"><?php echo $this->category->description; ?></div>
							<?php } ?>
							<?php if ($this->params->get('catTitleItemCounter') && $this->pagination->total > 1) { ?>
								<div class="items-count"><span><?php echo $this->pagination->total; ?></span> قسمت پخش شده</div>
							<?php } ?>
						</div>
						<?php echo $this->category->event->K2CategoryDisplay; ?>
					</div>
				</section>
			<?php } ?>
		<?php } ?>
		<?php if (isset($this->category) || ( $this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories) )) { ?>
			<?php if ($this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories)) { ?>
				<section class="box subcategories grid">
					<div>
						<?php foreach ($this->subCategories as $key => $subCategory) { ?>
							<?php if ($key === 0) { ?>
								<article data-count="<?php echo $subCategory->numOfItems; ?>">
									<?php if ($this->params->get('subCatImage') && $subCategory->image) { ?>
										<figure class="img cat-img">
											<a class="subCategoryImage" href="<?php echo $subCategory->link; ?>">
												<img alt="<?php echo K2HelperUtilities::cleanHtml($subCategory->name); ?>" src="<?php echo $subCategory->image; ?>" />
											</a>
										</figure>
									<?php } ?>
									<?php if ($this->params->get('subCatTitle') || $this->params->get('subCatDescription')) { ?>
										<div class="desc">
											<?php if ($this->params->get('subCatTitle')) { ?>
												<h2>
													<a href="<?php echo $subCategory->link; ?>">
														<a href="<?php echo $subCategory->link; ?>"><?php echo $subCategory->name; ?></a>
													</a>
												</h2>
											<?php } ?>
											<?php if ($this->params->get('subCatDescription')) { ?>
												<div class="cat-text"><?php echo $subCategory->description; ?></div>
											<?php } ?>
										</div>
									<?php } ?>
								</article>
							<?php } ?>
						<?php } ?>
						<ul>
							<?php foreach ($this->subCategories as $key => $subCategory) { ?>
								<?php if ($key > 0) { ?>
									<li data-count="<?php echo $subCategory->numOfItems; ?>">
										<?php if ($this->params->get('subCatImage') && $subCategory->image) { ?>
											<figure class="img cat-img">
												<a class="subCategoryImage" href="<?php echo $subCategory->link; ?>">
													<img alt="<?php echo K2HelperUtilities::cleanHtml($subCategory->name); ?>" src="<?php echo $subCategory->image; ?>" />
												</a>
											</figure>
										<?php } ?>
										<?php if ($this->params->get('subCatTitle') || $this->params->get('subCatDescription')) { ?>
											<div class="desc">
												<?php if ($this->params->get('subCatTitle')) { ?>
													<h2>
														<a href="<?php echo $subCategory->link; ?>"><?php echo $subCategory->name; ?></a>
													</h2>
												<?php } ?>
												<?php if ($this->params->get('subCatDescription')) { ?>
													<div class="cat-text"><?php echo $subCategory->description; ?></div>
												<?php } ?>
											</div>
										<?php } ?>
									</li>
								<?php } ?>
							<?php } ?>
						</ul>
					</div>
				</section>
			<?php } ?>
		<?php } ?>
	</div>
	<?php if (isset($this->secondary) && count($this->secondary)) { ?>
		<section class="box episodes tiles highlights grid">
			<div>
				<ul>
					<?php
					foreach ($this->secondary as $key => $item) {
						$media = !empty($item->video) ? ' video' : '';
						$media .=!empty($item->gallery) ? ' gallery' : '';
						$modified = ($item->modified != $this->nullDate && $item->modified != $item->created) ? JHTML::_('date', $item->modified, JText::_('K2_DATE_FORMAT_LC2')) : '';
						?>
						<li class="item<?php $media; ?><?php echo ($item->featured) ? ' featured' : ''; ?><?php if ($item->params->get('pageclass_sfx')) echo ' ' . $item->params->get('pageclass_sfx'); ?>" data-hits="<?php echo $item->hits; ?>">
							<?php
							$this->item = $item;
							echo $this->loadTemplate('item');
							?>
						</li>
					<?php } ?>
				</ul>
			</div>
		</section>
	<?php } ?>
</div>