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



/**
 * Represents a feature.
 *
 * @copyright Camptocamp <info@camptocamp.com>
 * @author Filip Procházka <filip.prochazka@kdyby.org>
 */
class Feature extends Nette\Object implements Serializable
{

	/**
	 * The feature id
	 */
	public $id;

	/**
	 * The Geometry object
	 */
	public $geometry;

	/**
	 * The properties array
	 */
	public $properties = array();

	/**
	 * The bbox
	 */
	public $bbox;



	/**
	 * @param string $id The feature id
	 * @param Geometry\Geometry $geometry The feature geometry
	 * @param array $properties The feature properties
	 * @param array $bbox
	 */
	public function __construct($id = NULL, Geometry\Geometry $geometry = NULL, array $properties = array(), array $bbox = NULL)
	{
		$this->id = $id;
		$this->geometry = $geometry;
		$this->properties = $properties;
		$this->bbox = $bbox ?: NULL;
	}



	/**
	 * Returns an array suitable for serialization
	 *
	 * @return array
	 */
	public function getGeoInterface()
	{
		$geo = array(
			'type' => 'Feature',
			'geometry' => $this->geometry !== NULL ? $this->geometry->getGeoInterface() : NULL,
			'properties' => $this->properties
		);

		if ($this->id !== NULL) {
			$geo['id'] = $this->id;
		}

		if ($this->bbox !== NULL) {
			$geo['bbox'] = $this->bbox;
		}

		return $geo;
	}

}

