<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008, 2012 Filip Procházka (filip.prochazka@kdyby.org)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Extension\GeoJson\Geometry;

use Kdyby\Extension\GeoJson\InvalidArgumentException;
use Nette;



/**
 * A MultiPolygon geometry.
 *
 * @copyright Camptocamp <info@camptocamp.com>
 * @author Filip Procházka <filip.prochazka@kdyby.org>
 */
class MultiPolygon extends Collection
{

	/**
	 * Constructor
	 *
	 * @param array $polygons The Polygon array
	 */
	public function __construct(array $polygons)
	{
		parent::__construct($polygons);
	}



	/**
	 * @param Geometry $component
	 *
	 * @throws \Kdyby\Extension\GeoJson\InvalidArgumentException
	 */
	protected function add(Geometry $component)
	{
		if (!$component instanceof Polygon) {
			throw new InvalidArgumentException('MultiPolygon composes of Polygons, ' . get_class($component) . ' given.');
		}

		parent::add($component);
	}

}

