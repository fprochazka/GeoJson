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
use Nette\Utils\Strings;
use Nette\Utils\Validators;
use Nette\Utils\AssertionException;



/**
 * A GeoJSON reader/writer.
 *
 * @copyright Camptocamp <info@camptocamp.com>
 * @author Filip Procházka <filip.prochazka@kdyby.org>
 */
class GeoJSON extends Nette\Object
{

	/**
	 * Serializes an object into a geojson string
	 *
	 * @param Serializable $obj
	 *
	 * @return string The GeoJSON string
	 */
	static public function encode(Serializable $obj)
	{
		return Json::encode($obj->getGeoInterface());
	}



	/**
	 * Deserializes a geojson string into an object
	 *
	 * @param string $string The GeoJSON string
	 *
	 * @throws GeoJsonException
	 * @return Serializable
	 */
	static public function decode($string)
	{
		try {
			$structure = Json::decode($string, Json::FORCE_ARRAY);
			$decoder = new static();
			return $decoder->toInstance($structure);

		} catch (\Exception $e) {
			throw new GeoJsonException($e->getMessage(), 0, $e);
		}
	}



	/**
	 * Converts an stdClass object into a Feature or a FeatureCollection or a Geometry, based on its 'type' property
	 *
	 * @param array $obj Object resulting from json decoding a GeoJSON string
	 *
	 * @return object Object from class: Feature, FeatureCollection or Geometry
	 */
	private function toInstance(array $obj)
	{
		Validators::assertField($obj, 'type');

		if ($obj['type'] === 'featurecollection') {
			Validators::assertField($obj, 'features', 'array');

			$features = array();
			foreach ($obj['features'] as $feature) {
				$features[] = $this->toFeatureInstance($feature);
			}

			return new FeatureCollection($features);

		} elseif ($obj['type'] === 'feature') {
			return $this->toFeatureInstance($obj);
		}

		return $this->toGeomInstance($obj);
	}



	/**
	 * Converts an stdClass object into a Feature
	 *
	 * @param array $obj Object to convert
	 *
	 * @throws \Nette\Utils\AssertionException
	 * @return \Kdyby\Extension\GeoJson\Feature
	 */
	private function toFeatureInstance(array $obj)
	{
		Validators::assertField($obj, 'type');
		if ($obj['type'] !== 'Feature') {
			throw new AssertionException("The type expects to be 'Feature', '{$obj['type']}' given.");
		}

		Validators::assertField($obj, 'id');
		Validators::assertField($obj, 'geometry');
		Validators::assertField($obj, 'properties');

		return new Feature(
			$obj['id'],
			$this->toGeomInstance($obj['geometry']),
			(array)$obj['properties'],
			isset($obj['bbox']) ? (array)$obj['bbox'] : array()
		);
	}



	/**
	 * Converts an stdClass object into a Geometry based on its 'type' property
	 *
	 * @param array $obj Object resulting from json decoding a GeoJSON string
	 * @param boolean $allowGeometryCollection Do we allow $obj to be a GeometryCollection ?
	 *
	 * @throws InvalidArgumentException
	 * @return \Kdyby\Extension\GeoJson\Geometry\Geometry
	 */
	private function toGeomInstance(array $obj, $allowGeometryCollection = TRUE)
	{
		if ($obj === NULL) {
			return NULL;
		}

		Validators::assertField($obj, 'type');
		if (Strings::startsWith($obj['type'], 'Feature')) {
			return $this->toInstance($obj);
		}

		switch ($obj['type']) {
			case 'Point':
			case 'LineString':
			case 'Polygon':
				Validators::assertField($obj, 'coordinates', 'array');
				return $this->{'to' . $obj['type']}($obj['coordinates']);

			case 'MultiPoint':
			case 'MultiLineString':
			case 'MultiPolygon':
				Validators::assertField($obj, 'coordinates', 'array');
				$items = array();
				foreach ($obj['coordinates'] as $item) {
					$items[] = $this->{'to' . substr($obj['type'], 5)}($item);
				}
				$class = __NAMESPACE__ . '\\Geometry\\' . $obj['type'];
				return new $class($items);

			case 'GeometryCollection':
				if ($allowGeometryCollection !== TRUE) {
					throw new InvalidArgumentException("A GeometryCollection should not contain another GeometryCollection");
				}

				Validators::assertField($obj, 'geometries', 'array');
				$geometries = array();
				foreach ($obj['geometries'] as $geometry) {
					$geometries[] = self::toGeomInstance($geometry, FALSE);
				}
				return new Geometry\GeometryCollection($geometries);

			default:
				throw new InvalidArgumentException("Unsupported object type");
		}
	}



	/**
	 * Converts an array of coordinates into a Point Feature
	 *
	 * @param array $coordinates The X/Y coordinates
	 *
	 * @return \Kdyby\Extension\GeoJson\Geometry\Point
	 */
	static private function toPoint(array $coordinates)
	{
		Validators::assert($coordinates, 'list:2');
		list($x, $y) = $coordinates;
		return new Geometry\Point($x, $y);
	}



	/**
	 * Converts an array of coordinate arrays into a LineString Feature
	 *
	 * @param array $coordinates The array of coordinates arrays (aka positions)
	 *
	 * @return \Kdyby\Extension\GeoJson\Geometry\LineString
	 */
	static private function toLineString(array $coordinates)
	{
		$positions = array();
		foreach ($coordinates as $position) {
			$positions[] = self::toPoint($position);
		}
		return new Geometry\LineString($positions);
	}



	/**
	 * Converts an array of linestring coordinates into a Polygon Feature
	 *
	 * @param array $coordinates The linestring coordinates
	 *
	 * @return \Kdyby\Extension\GeoJson\Geometry\Polygon
	 */
	static private function toPolygon(array $coordinates)
	{
		$lineStrings = array();
		foreach ($coordinates as $linestring) {
			$lineStrings[] = self::toLineString($linestring);
		}
		return new Geometry\Polygon($lineStrings);
	}

}


