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
?>
<?php if (JRequest::getInt('print') == 1) { ?>
	<a class="btn btn-block" rel="nofollow" href="#" onclick="window.print();">
		<?php echo JText::_('K2_PRINT_THIS_PAGE'); ?>
	</a>
<?php } ?>
<article id="item" class="item news<?php echo ($this->item->featured) ? ' featured' : ''; ?><?php if ($this->item->params->get('pageclass_sfx')) echo ' ' . $this->item->params->get('pageclass_sfx'); ?>" data-hits="<?php echo $this->item->hits; ?>" data-hits="<?php if ($this->item->params->get('itemDateModified') && intval($this->item->modified) != 0) { ?><?php echo JHTML::_('date', $this->item->modified, JText::_('K2_DATE_FORMAT_LC2')); ?><?php } ?>">
	<?php echo $this->item->event->BeforeDisplay; ?>
	<?php echo $this->item->event->K2BeforeDisplay; ?>
	<header class="item-header">
		<div class="row">
			<div class="col-xs-6  col-md-3 item-tools">
				<ul class="list-inline list-unstyled">
					<?php if ($this->item->params->get('itemPrintButton') && !JRequest::getInt('print')) { ?>
						<li>
							<a rel="nofollow" href="<?php echo $this->item->printLink; ?>" onclick="window.open(this.href, 'printWindow', 'width=900,height=600,location=no,menubar=no,resizable=yes,scrollbars=yes');
	                                return false;">
								<i class="icon-print"></i>
							</a>
						</li>
					<?php } ?>
					<li class="fb"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo JUri::current(); ?>" target="_blank"><i class="icon-facebook"></i></a></li>
					<li class="tw"><a href="https://twitter.com/home?status=<?php echo $this->item->title; ?> - <?php echo JUri::current(); ?>" target="_blank"><i class="icon-twitter"></i></a></li>
					<li class="gp"><a href="https://plus.google.com/share?url=<?php echo JUri::current(); ?>" target="_blank"><i class="icon-gplus"></i></a></li>
				</ul>
			</div>
			<?php if ($this->item->params->get('itemDateCreated')) { ?>
				<div class="col-xs-6 col-md-9 item-date">
					<time><?php echo JHTML::_('date', $this->item->created, JText::_('K2_DATE_FORMAT_LC2')); ?></time>
				</div>
			<?php } ?>
		</div>
		<?php if ($this->item->params->get('itemTitle')) { ?>
			<div class="page-title">
				<h2 class="item-title">
					<?php
					if (count($this->item->extra_fields)) {
						foreach ($this->item->extra_fields as $key => $extraField) {
							if ($extraField->alias == "kicker") {
								?>
								<small><?php echo $extraField->value; ?></small>
								<?php
							}
						}
					}
					?>
					<?php echo $this->item->title; ?>
				</h2>
			</div>
		<?php } ?>
		<?php if ($this->item->params->get('itemAuthor')) { ?>
			<div class="item-author">
				<?php echo K2HelperUtilities::writtenBy($this->item->author->profile->gender); ?>
				<?php if (empty($this->item->created_by_alias)) { ?>
					<a rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a>
				<?php } else { ?>
					<?php echo $this->item->author->name; ?>
				<?php } ?>
			</div>
		<?php } ?>
	</header>
	<?php echo $this->item->event->AfterDisplayTitle; ?>
	<?php echo $this->item->event->K2AfterDisplayTitle; ?>
	<div class="item-body">
		<?php echo $this->item->event->BeforeDisplayContent; ?>
		<?php echo $this->item->event->K2BeforeDisplayContent; ?>
		<?php if ($this->item->params->get('itemImage') && !empty($this->item->image)) { ?>
			<?php $video = ($this->item->params->get('itemVideo') && !empty($this->item->video)) ? $this->item->video : null; ?>
			<figure id="item-media" class="item-image"<?php echo ($video) ? ' data-video=' . $video : '' ?>>
				<a href="<?php echo $this->item->imageXLarge; ?>" title="<?php echo JText::_('K2_CLICK_TO_PREVIEW_IMAGE'); ?>">
					<img src="<?php echo $this->item->image; ?>" alt="<?php
					if (!empty($this->item->image_caption))
						echo K2HelperUtilities::cleanHtml($this->item->image_caption);
					else
						echo K2HelperUtilities::cleanHtml($this->item->title);
					?>" />
				</a>
				<?php if (!empty($this->item->image_caption) || !empty($this->item->image_credits)) { ?>
					<figcaption>
						<?php if ($this->item->params->get('itemImageMainCaption') && !empty($this->item->image_caption)) { ?>
							<div class="img-caption"><?php echo $this->item->image_caption; ?></div>
						<?php } ?>
						<?php if ($this->item->params->get('itemImageMainCredits') && !empty($this->item->image_credits)) { ?>
							<div class="img-credits"><?php echo $this->item->image_credits; ?></div>
						<?php } ?>
					</figcaption>
				<?php } ?>
			</figure>
		<?php } ?>
		<?php if (!empty($this->item->fulltext)) { ?>
			<?php if ($this->item->params->get('itemIntroText')) { ?>
				<div class="summary">
					<?php echo $this->item->introtext; ?>
				</div>
			<?php } ?>
			<?php if ($this->item->params->get('itemFullText')) { ?>
				<div class="item-text">
					<?php echo $this->item->fulltext; ?>
				</div>
			<?php } ?>
		<?php } else { ?>
			<div class="item-text">
				<?php echo $this->item->introtext; ?>
			</div>
		<?php } ?>
		<?php echo $this->item->event->AfterDisplayContent; ?>
		<?php echo $this->item->event->K2AfterDisplayContent; ?>
	</div>
	<div class="item-boxes">
		<?php if ($this->item->params->get('itemRelated') && isset($this->relatedItems)) { ?>
			<section class="box list">
				<header><h2><?php echo JText::_("K2_RELATED_ITEMS_BY_TAG"); ?></h2></header>
				<div>
					<ul>
						<?php foreach ($this->relatedItems as $key => $item) { ?>
							<li>
								<?php if ($this->item->params->get('itemRelatedTitle', 1)) { ?>
									<h3><a class="itemRelTitle" href="<?php echo $item->link ?>"><?php echo $item->title; ?></a></h3>
								<?php } ?>
							</li>
						<?php } ?>
					</ul>
				</div>
			</section>
		<?php } ?>
		<?php if ($this->item->params->get('itemImageGallery') && !empty($this->item->gallery)) { ?>
			<section class="box gallery">
				<header><h2>گالری</h2></header>
				<?php echo $this->item->gallery; ?>
			</section>
		<?php } ?>
	</div>
	<?php echo $this->item->event->AfterDisplay; ?>
	<?php echo $this->item->event->K2AfterDisplay; ?>

	<?php echo $this->item->event->K2CommentsBlock; ?>
	<?php if ($this->item->params->get('itemComments') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2')) && empty($this->item->event->K2CommentsBlock)) { ?>
		<div class="item-comments">
			<?php if ($this->item->params->get('commentsFormPosition') == 'above' && $this->item->params->get('itemComments') && !JRequest::getInt('print') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2' && K2HelperPermissions::canAddComment($this->item->catid)))) { ?>
				<?php echo $this->loadTemplate('comments_form'); ?>
			<?php } ?>

			<?php if ($this->item->numOfComments > 0 && $this->item->params->get('itemComments') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2'))) { ?>
				<?php include dirname(dirname(__FILE__)) . DS . '_comments' . DS . 'list.php'; ?>
			<?php } ?>
		</div>
	<?php } ?>
</article>