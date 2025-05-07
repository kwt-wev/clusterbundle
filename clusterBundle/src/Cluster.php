<?php



namespace Symfony\UX\Map\Cluster;

use Symfony\UX\Map\Point;

final class Cluster
{
	 
	private array $points = [];

	private float $sumLat = 0.0;
	private float $sumLng = 0.0;
	private int $count = 0;

	public function __construct(Point $initialPoint)
	{
		$this->addPoint($initialPoint);
	}

	public function addPoint(Point $point): void
	{
		$this->points[] = $point;
		$this->sumLat += $point->getLatitude();
		$this->sumLng += $point->getLongitude();
		++$this->count;
	}

	public function getCenterLat(): float
	{
		return $this->count > 0 ? $this->sumLat / $this->count : 0.0;
	}

	public function getCenterLng(): float
	{
		return $this->count > 0 ? $this->sumLng / $this->count : 0.0;
	}

	/**
	 * @return Point[]
	 */
	public function getPoints(): array
	{
		return $this->points;
	}
}