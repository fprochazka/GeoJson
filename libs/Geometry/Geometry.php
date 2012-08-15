<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008, 2012 Filip Procházka (filip.prochazka@kdyby.org)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Extension\GeoJson\Geometry;

use Kdyby\Extension\GeoJson\Serializable;
use Nette;
use Nette\Utils\Json;



/**
 * Abstract class which represents a geometry.
 *
 * @copyright Camptocamp <info@camptocamp.com>
 * @author Filip Procházka <filip.prochazka@kdyby.org>
 */
abstract class Geometry extends Nette\Object implements Serializable
{

	/**
	 * @return mixed
	 */
	abstract public function getCoordinates();



	/**
	 * Accessor for the geometry type
	 *
	 * @return string The Geometry type.
	 */
	public function getGeomType()
	{
		$class = get_class($this);
		if (strrpos($class, '\\') !== FALSE) {
			return substr($class, strrpos($class, '\\') + 1);
		}
		return $class;
	}



	/**
	 * Returns an array suitable for serialization
	 *
	 * @return array
	 */
	public function getGeoInterface()
	{
		return array(
			'type' => $this->getGeomType(),
			'coordinates' => $this->getCoordinates()
		);
	}



	/**
	 * Dumps Geometry as GeoJSON
	 *
	 * @return string The GeoJSON representation of the geometry
	 */
	public function toGeoJSON()
	{
		return Json::encode($this->getGeoInterface());
	}



	/**
	 * Shortcut to dump geometry as GeoJSON
	 *
	 * @return string The GeoJSON representation of the geometry
	 */
	public function __toString()
	{
		return $this->toGeoJSON();
	}

}

