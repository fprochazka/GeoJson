<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008, 2012 Filip Procházka (filip.prochazka@kdyby.org)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Extension\GeoJson\Adapter;

use Nette;



/**
 * Adapter to implement for Dependency Injection in GeoJSON loader
 *
 * @copyright Camptocamp <info@camptocamp.com>
 * @author Filip Procházka <filip.prochazka@kdyby.org>
 */
interface Adapter
{

	/**
	 * Returns if a Feature or a FeatureCollection should be created
	 *
	 * @param $object
	 *
	 * @return boolean
	 */
	function isMultiple($object);



	/**
	 * Returns an iterable for multiple object
	 */
	function getIterable($object);



	/**
	 * Returns WKT string for passed object
	 *
	 * @param $object
	 *
	 * @return string
	 */
	function getObjectGeometry($object);



	/**
	 * Returns passed object identifier
	 *
	 * @param $object
	 *
	 * @return mixed
	 */
	function getObjectId($object);



	/**
	 * Returns passed object attributes
	 *
	 * @param $object
	 *
	 * @return array
	 */
	function getObjectProperties($object);

}
