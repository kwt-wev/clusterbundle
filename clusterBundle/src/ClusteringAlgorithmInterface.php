<?php

 

namespace Symfony\UX\Map\Cluster;

use Symfony\UX\Map\Point;

 
interface ClusteringAlgorithmInterface
{
	 
	public function cluster(array $points, float $zoom): array;
}