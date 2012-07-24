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
 * A Polygon geometry.
 *
 * @copyright Camptocamp <info@camptocamp.com>
 * @author Filip Procházka <filip.prochazka@kdyby.org>
 */
class Polygon extends Collection
{

	/**
	 * The first linestring is the outer ring
	 * The subsequent ones are holes
	 * All lineStrings should be linearRings
	 *
	 * @param array $lineStrings The LineString array
	 *
	 * @throws \Kdyby\Extension\GeoJson\InvalidArgumentException
	 */
	public function __construct(array $lineStrings)
	{
		if (count($lineStrings) < 1) {
			throw new InvalidArgumentException("Polygon have to have at least one line string.");
			// todo: the GeoJSON spec (http://geojson.org/geojson-spec.html) says nothing about linestring count.
		}

		parent::__construct($lineStrings);
	}



	/**
	 * @param Geometry $component
	 *
	 * @throws \Kdyby\Extension\GeoJson\InvalidArgumentException
	 */
	protected function add(Geometry $component)
	{
		if (!$component instanceof LineString) {
			throw new InvalidArgumentException('Polygon composes of LineStrings, ' . get_class($component) . ' given.');
		}

		parent::add($component);
	}

}

