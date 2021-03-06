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
if (count($items)) {
	?>
	<div class="box header-programs">
		<div class="container">
			<ul>
				<?php foreach ($items as $key => $item) { ?>
					<li<?php echo ($key === 0) ? ' class="featured"' : ''; ?>>
						<?php if ($key === 0 && isset($item->image)) { ?>
							<figure>
								<a href="<?php echo $item->link; ?>">
									<img src="<?php echo JUri::base() . 'media/k2/categories/' . $item->image; ?>" alt="<?php echo $item->categoryname; ?>" />
								</a>
							</figure>
						<?php } ?>
						<h3>
							<a href="<?php echo $item->link; ?>"><?php echo $item->categoryname; ?></a>
						</h3>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<?php
}