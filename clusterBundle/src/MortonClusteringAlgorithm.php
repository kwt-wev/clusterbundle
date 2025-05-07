<?php

 

namespace Symfony\UX\Map\Cluster;

use Symfony\UX\Map\Point;

 
final   class MortonClusteringAlgorithm implements ClusteringAlgorithmInterface
{
	/**
	 * @param Point[] $points
	 *
	 * @return Cluster[]
	 */
	public function cluster(iterable $points, float $zoom): array
	{
		$resolution = 1 << (int) $zoom;
		$clustersMap = [];

		foreach ($points as $point) {
			$xNorm = ($point->getLatitude() + 180) / 360;
			$yNorm = ($point->getLongitude() + 90) / 180;

			$x = (int) floor($xNorm * $resolution);
			$y = (int) floor($yNorm * $resolution);

			$x &= 0xFFFF;
			$y &= 0xFFFF;

			$x = ($x | ($x << 8)) & 0x00FF00FF;
			$x = ($x | ($x << 4)) & 0x0F0F0F0F;
			$x = ($x | ($x << 2)) & 0x33333333;
			$x = ($x | ($x << 1)) & 0x55555555;

			$y = ($y | ($y << 8)) & 0x00FF00FF;
			$y = ($y | ($y << 4)) & 0x0F0F0F0F;
			$y = ($y | ($y << 2)) & 0x33333333;
			$y = ($y | ($y << 1)) & 0x55555555;

			$code = ($y << 1) | $x;

			if (!isset($clustersMap[$code])) {
				$clustersMap[$code] = new Cluster($point);
			} else {
				$clustersMap[$code]->addPoint($point);
			}
		}

		return array_values($clustersMap);
	}
}