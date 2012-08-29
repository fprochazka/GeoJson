<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008, 2012 Filip Procházka (filip.prochazka@kdyby.org)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Extension\GeoJson;

use Nette;
use Nette\Utils\Json;



/**
 * Represents a collection of features.
 *
 * @copyright Camptocamp <info@camptocamp.com>
 * @author Filip Procházka <filip.prochazka@kdyby.org>
 */

class FeatureCollection extends Nette\Object implements Serializable, \IteratorAggregate
{

	/**
	 * @var array|Feature[]
	 */
	private $features = array();



	/**
	 * @param array $features The features used to build the collection
	 */
	public function __construct(array $features = array())
	{
		foreach ($features as $feature) {
			$this->addFeature($feature);
		}
	}



	/**
	 * Add a feature to collection
	 */
	public function addFeature(Feature $f)
	{
		$this->features[] = $f;
	}



	/**
	 * Returns an array suitable for serialization
	 *
	 * @return array
	 */
	public function getGeoInterface()
	{
		$features = array();

		foreach ($this->features as $feature) {
			$features[] = $feature->getGeoInterface();
		}

		return array(
			'type' => 'FeatureCollection',
			'features' => $features
		);
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
	 * @return \ArrayIterator|\Traversable
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->features);
	}

}

