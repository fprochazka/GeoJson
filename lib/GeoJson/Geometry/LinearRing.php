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
 * A LineString geometry.
 *
 * @copyright Camptocamp <info@camptocamp.com>
 * @author Filip Procházka <filip.prochazka@kdyby.org>
 */
class LinearRing extends LineString
{

	/**
	 * @param array $positions The Point array
	 *
	 * @throws \Kdyby\Extension\GeoJson\InvalidArgumentException
	 */
	public function __construct(array $positions)
	{
		if (count($positions) <= 1) {
			throw new InvalidArgumentException('LineString have to have at least two points.');
		}

		parent::__construct($positions);
	}

}

