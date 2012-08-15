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
 * A MultiPoint geometry.
 *
 * @copyright Camptocamp <info@camptocamp.com>
 * @author Filip Procházka <filip.prochazka@kdyby.org>
 */
class MultiPoint extends Collection
{

	/**
	 * Constructor
	 *
	 * @param array $points The Point array
	 */
	public function __construct(array $points)
	{
		parent::__construct($points);
	}



	/**
	 * @param Geometry $component
	 *
	 * @throws \Kdyby\Extension\GeoJson\InvalidArgumentException
	 */
	protected function add(Geometry $component)
	{
		if (!$component instanceof Point) {
			throw new InvalidArgumentException('MultiPoint composes of Points, ' . get_class($component) . ' given.');
		}

		parent::add($component);
	}

}

