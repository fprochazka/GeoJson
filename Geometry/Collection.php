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
 * Abstract class which represents a collection of components.
 *
 * @copyright Camptocamp <info@camptocamp.com>
 * @author Filip Procházka <filip.prochazka@kdyby.org>
 */
abstract class Collection extends Geometry implements \IteratorAggregate
{

	/**
	 * @var array|Geometry[]
	 */
	private $components = array();



	/**
	 * @param array $components The components array
	 */
	public function __construct(array $components = array())
	{
		foreach ($components as $component) {
			$this->add($component);
		}
	}



	/**
	 * @param Geometry $component
	 */
	protected function add(Geometry $component)
	{
		$this->components[] = $component;
	}



	/**
	 * An accessor method which recursively calls itself to build the coordinates array
	 *
	 * @return array The coordinates array
	 */
	public function getCoordinates()
	{
		return array_map(function (Geometry $component) {
			return $component->getCoordinates();
		}, $this->components);
	}



	/**
	 * Returns Collection components
	 *
	 * @return array
	 */
	public function getComponents()
	{
		return $this->components;
	}



	/**
	 * @return \ArrayIterator|\Traversable
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->components);
	}

}

