<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008, 2012 Filip Procházka (filip.prochazka@kdyby.org)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Extension\GeoJson\Geometry;

use Nette;



/**
 * A GeometryCollection geometry.
 *
 * @copyright Camptocamp <info@camptocamp.com>
 * @author Filip Procházka <filip.prochazka@kdyby.org>
 */
class GeometryCollection extends Collection
{

	/**
	 * Returns an array suitable for serialization
	 *
	 * Overrides the one defined in parent class
	 *
	 * @return array
	 */
	public function getGeoInterface()
	{
		return array(
			'type' => $this->getGeomType(),
			'geometries' => array_map(function (Geometry $geometry) {
				return $geometry->getGeoInterface();
			}, $this->getComponents())
		);
	}

}

