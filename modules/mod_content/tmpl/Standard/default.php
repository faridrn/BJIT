<?php
/**
 * @version		$Id: default.php 1251 2011-10-19 17:50:13Z joomlaworks $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<?php if (count($items)) { ?>
	<ul>
		<?php foreach ($items as $key => $item) { ?>
			<li class="<?php echo $item->video ? 'video' : ''; ?>">
				<?php if ($params->get('itemImage')) { ?>
					<figure>
						<a href="<?php echo $item->link; ?>">
							<?php if ($params->get('itemImage') && isset($item->image)) { ?>
								<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
							<?php } ?>
						</a>
					</figure>
				<?php } ?>
				<div class="desc">
					<?php if ($params->get('itemCategory')): ?>
						<span class="category">
							<a href="<?php echo $item->categoryLink; ?>"><?php echo $item->categoryname; ?></a>
						</span>
					<?php endif; ?>
					<?php if ($params->get('itemTitle')) { ?>
						<h3><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h3>
					<?php } ?>
					<?php if ($params->get('itemIntroText')) { ?>
						<div class="introtext"><?php echo $item->introtext; ?></div>
					<?php } ?>
					<?php if ($params->get('itemAuthor')): ?>
						<div class="item-author">
							<?php if (isset($item->authorLink) && isset($item->author_id)): ?>
								<a rel="author" title="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" href="<?php echo JRoute::_('index.php?Itemid=150') . '/author/' . $item->author_id . '-' . $item->author; ?>">
									<!--<span class="avatar"></span>-->
									<?php echo $item->author; ?>
								</a>
								<?php // else: ?>
								<?php // echo $item->author; ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php if ($params->get('itemReadMore')) { ?>
						<a class="more" href="<?php echo $item->link; ?>">بیشتر</a>
					<?php } ?>
				</div>
			</li>
		<?php } ?>
	</ul>
<?php } ?>