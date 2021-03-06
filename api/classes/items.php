<?php

abstract class Items {

	public static function getItems($app, $type, $catid = null, $searchQuery = null) {
		$o = 0;
		$l = 50;
		$r = false;
		$offset = $app->request->get('offset', null);
		if (!empty($offset)) {
			list($o, $l) = explode(',', $offset);
		}
		$query = $app->_db->getQuery(true);
		switch ($type) {
			default:
				$app->render(200, array('msg' => 'Empty response'));
				exit();
				break;
			case 'homepage':
				$query->select('i.*, c.id AS catid, c.name, c.alias AS categoryalias, c.image')
						->from($app->_db->quoteName('#__k2_items') . ' AS i')
						->join('LEFT', $app->_db->quoteName('#__k2_categories') . 'AS c ON i.catid = c.id')
						->where($app->_db->quoteName('featured') . ' = ' . $app->_db->quote('1'));
				$app->_db->setQuery($query);
//				$r = true;
				break;
			case 'items':
				$query->select('i.*, c.id AS catid, c.name, c.alias AS categoryalias, c.image')
						->from($app->_db->quoteName('#__k2_items') . ' AS i')
						->join('LEFT', $app->_db->quoteName('#__k2_categories') . 'AS c ON i.catid = c.id')
						->order('i.id DESC');
				$app->_db->setQuery($query, $o, $l);
				break;
			case 'byparentcategory':
				$query->select('i.*, c.id AS catid, c.name, c.alias AS categoryalias, c.image')
						->from($app->_db->quoteName('#__k2_items') . ' AS i')
						->join('LEFT', $app->_db->quoteName('#__k2_categories') . ' AS c ON i.catid = c.id')
						->where('i.catid in (select cc.id from #__k2_categories cc where cc.parent = ' . $app->_db->quote($catid) . ')', ' AND')
						->where('i.published = 1 AND i.trash = 0 AND i.access = 1')
						->order('i.id DESC');
				$app->_db->setQuery($query, $o, $l);
				break;
			case 'bycategory':
				$query->select('i.*, c.id AS catid, c.name, c.alias AS categoryalias, c.image')
						->from($app->_db->quoteName('#__k2_items') . ' AS i')
						->join('LEFT', $app->_db->quoteName('#__k2_categories') . 'AS c ON i.catid = c.id')
						->where($app->_db->quoteName('i.catid') . ' = ' . $app->_db->quote($catid), 'AND')
						->where('i.published = 1 AND i.trash = 0 and i.access = 1')
						->order('i.id DESC');
				$app->_db->setQuery($query, $o, $l);
				break;
			case 'search':
				$query->select('i.*, c.id AS catid, c.name, c.alias AS categoryalias, c.image')
						->from($app->_db->quoteName('#__k2_items') . ' AS i')
						->join('LEFT', $app->_db->quoteName('#__k2_categories') . ' AS c ON i.catid = c.id')
						->where('i.published = 1 AND i.trash = 0 AND i.access = 1', 'AND')
						->where('(i.title LIKE ' . $app->_db->quote('%' . $searchQuery . '%') . 'OR i.introtext LIKE ' . $app->_db->quote('%' . $searchQuery . '%') . ')')
						->order('i.id DESC');
				$app->_db->setQuery($query, $o, $l);
				break;
		}
		$app->_db->execute();
		$items = self::assignRef($app->_db->loadObjectList(), false, $r);
		self::render($app, $items);
	}

	public static function getProgramsList($app) {
		$query = $app->_db->getQuery(true);
		$query->select('c.id, c.name')
				->from($app->_db->quoteName('#__k2_categories') . ' AS c')
				->where($app->_db->quoteName('parent') . ' = ' . $app->_db->quote('2'))
				->order('c.id DESC');
		$app->_db->setQuery($query);
		$app->_db->execute();
		$items = $app->_db->loadObjectList();
		self::render($app, $items);
	}

	public static function getEpisodesList($app, $programId) {
		$query = $app->_db->getQuery(true);
		$query->select('i.id, i.title')
				->from($app->_db->quoteName('#__k2_items') . ' AS i')
				->where($app->_db->quoteName('catid') . ' = ' . $app->_db->quote($programId))
				->order('i.id DESC');
		$app->_db->setQuery($query);
		$app->_db->execute();
		$items = $app->_db->loadObjectList();
		self::render($app, $items);
	}

	public static function getItem($app, $id = null) {
		$query = $app->_db->getQuery(true);
		$query->select('i.*, c.id AS catid, c.name, c.alias AS categoryalias, c.image')
				->from($app->_db->quoteName('#__k2_items') . ' AS i')
				->join('LEFT', $app->_db->quoteName('#__k2_categories') . 'AS c ON i.catid = c.id')
				->where($app->_db->quoteName('i.id') . ' = ' . $app->_db->quote($id));
		$app->_db->setQuery($query);
		$app->_db->execute();
		$item = self::assignRef($app->_db->loadObjectList(), true);
		self::render($app, $item);
	}

	public static function render($app, $items, $type = 'items') {
		$app->render(200, array($type => $items,));
		return true;
	}

	public static function assignRef($items, $full = false, $reverse = false) {
		$output = [];
		foreach ($items as $item) {
			$o = new stdClass();
			$o->id = $item->id;
			$o->title = $item->title;
			$o->link = Route::item($item->id, $item->alias, $item->catid, $item->categoryalias);
			$o->category = $item->name;
			$o->categoryLink = Route::category($item->catid, $item->categoryalias);
			$o->state = $item->published;
			$o->introtext = strip_tags($item->introtext);
			$o->video = ($item->video) ? Route::video($item->video) : '';
			$o->created = $item->created;
			$o->img = Route::image($item->id);
			$o->thumb = Route::image($item->id, true);
			if ($full) {
				$o->fulltext = $item->fulltext;
//				$o->fulltext = strip_tags($item->fulltext);
			}
			$output[] = $o;
		}
		if ($reverse)
			$output = array_reverse($output);
		return $output;
	}

	public static function assignCatRef($items) {
		$output = [];
		foreach ($items as $item) {
			$o = new stdClass();
			$o->id = $item->id;
			$o->title = $item->name;
			$o->description = strip_tags($item->description);
			$o->parent = $item->parent;
			$o->image = ($item->image) ? str_replace('/api', '', JUri::base()) . 'media/k2/categories/' . $item->image : '';
			$o->itemsCount = $item->items_count;
			$output[] = $o;
		}
		return $output;
	}

	public static function getCategoriesByParent($app, $parent = null) {
		$o = 0;
		$l = 50;
		$offset = $app->request->get('offset', null);
		if (!empty($offset)) {
			list($o, $l) = explode(',', $offset);
		}
		$query = $app->_db->getQuery(true);
		$query->select('c.id, c.name, c.description, c.parent, c.image, count(i.id) AS items_count')
				->from($app->_db->quoteName('#__k2_categories') . ' AS c')
				->join('LEFT', $app->_db->quoteName('#__k2_items') . ' AS i ON c.id = i.catid');
		if (isset($parent))
			$query->where($app->_db->quoteName('c.parent') . ' = ' . $app->_db->quote($parent), ' AND');
		$query->where('c.published = 1 AND c.trash = 0 AND c.access = 1');
		$query->group($app->_db->quoteName('c.id'));
		$query->order('c.id DESC');
		$app->_db->setQuery($query, $o, $l);
		$app->_db->execute();
		$item = self::assignCatRef($app->_db->loadObjectList(), true);
		self::render($app, $item);
	}

}
