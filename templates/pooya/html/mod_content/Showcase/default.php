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
	<div class="box-wrapper showcase">
		<section class="box showcase<?php if ($params->get('moduleclass_sfx')) echo ' ' . $params->get('moduleclass_sfx'); ?>">
			<div>
				<ul>
					<?php foreach ($items as $key => $item) { ?>
						<li>
							<?php if ($params->get('itemImage') || $params->get('itemIntroText')) { ?>
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
										<div class="introtext"><?php echo $item->introtext; ?></div>
									<?php } ?>
									<?php if ($params->get('itemReadMore')) { ?>
										<a class="more" href="<?php echo $item->link; ?>">بیشتر</a>
									<?php } ?>
								</div>
							<?php } ?>
						</li>
					<?php } ?>
				</ul>
			</div>
		</section>
	</div>
<?php } ?>