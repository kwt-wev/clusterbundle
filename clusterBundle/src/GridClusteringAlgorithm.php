<?php

 
namespace Symfony\UX\Map\Cluster;

use Symfony\UX\Map\Point;

 
final  class GridClusteringAlgorithm implements ClusteringAlgorithmInterface
{
	 
	public function cluster(iterable $points, float $zoom): array
	{
		$gridResolution = 1 << (int) $zoom;
		$gridSize = 360 / $gridResolution;
		$invGridSize = 1 / $gridSize;

		$cells = [];

		foreach ($points as $point) {
			$lng = $point->getLongitude();
			$lat = $point->getLatitude();
			$gridX = (int) (($lng + 180) * $invGridSize);
			$gridY = (int) (($lat + 90) * $invGridSize);
			$key = ($gridX << 16) | $gridY;

			if (!isset($cells[$key])) {
				$cells[$key] = new Cluster($point);
			} else {
				$cells[$key]->addPoint($point);
			}
		}

		return array_values($cells);
	}
}