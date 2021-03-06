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
	<?php if ($params->get('category_link') && $params->get('mymenu_id')) { ?>
		<a href="<?php echo JRoute::_('index.php?option=com_k2&Itemid=' . $params->get('mymenu_id')); ?>" class="btn btn-default category-link">بیشتر</a>
	<?php } ?>
	<ul>
		<?php
		foreach ($items as $key => $item) {
			$isProduct = false;
			if ($item->plugins !== "") {
				$item->plugins = json_decode($item->plugins);
				if (isset($item->plugins->j2storej2data->enabled) && $item->plugins->j2storej2data->enabled) {
					$isProduct = true;
				}
			}
			?>
			<li<?php echo $isProduct ? ' class="product"' : ''; ?>>
				<?php if ($params->get('itemImage') || $params->get('itemIntroText')) { ?>
					<?php if ($isProduct) { ?><span class="available"><i class="icon-basket"></i></span><?php } ?>
					<figure>
						<a href="<?php echo $item->link; ?>">
							<?php if ($params->get('itemImage') && isset($item->image)) { ?>
								<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
							<?php } ?>
						</a>
					</figure>
					<div class="desc">
						<?php if ($params->get('itemTitle')) { ?>
							<h3><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h3>
						<?php } ?>
						<?php if ($params->get('itemIntroText')) { ?>
							<p><?php echo $item->introtext; ?></p>
						<?php } ?>
					</div>
				<?php } ?>
			</li>
		<?php } ?>
	</ul>
	<?php
}