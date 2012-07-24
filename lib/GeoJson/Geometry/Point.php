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
 * A Point geometry.
 *
 * @copyright Camptocamp <info@camptocamp.com>
 * @author Filip Procházka <filip.prochazka@kdyby.org>
 */
class Point extends Geometry
{

	/**
	 * @var float
	 */
	private $x;

	/**
	 * @var float
	 */
	private $y;



	/**
	 * Constructor
	 *
	 * @param float $x The x coordinate (or longitude)
	 * @param float $y The y coordinate (or latitude)
	 *
	 * @throws \Kdyby\Extension\GeoJson\InvalidArgumentException
	 */
	public function __construct($x, $y)
	{
		if (!is_numeric($x)) {
			throw new InvalidArgumentException("Coordinate X (longitude) should be numeric.");
		}
		$this->x = $x;

		if (!is_numeric($y)) {
			throw new InvalidArgumentException("Coordinate Y (latitude) should be numeric.");
		}
		$this->y = $y;
	}



	/**
	 * An accessor method which returns the coordinates array
	 *
	 * @return array The coordinates array
	 */
	public function getCoordinates()
	{
		return array($this->x, $this->y);
	}



	/**
	 * Returns X coordinate of the point
	 *
	 * @return integer The X coordinate
	 */
	public function getX()
	{
		return $this->x;
	}



	/**
	 * Returns X coordinate of the point
	 *
	 * @return integer The X coordinate
	 */
	public function getY()
	{
		return $this->y;
	}

}

