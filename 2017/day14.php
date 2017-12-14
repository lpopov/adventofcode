<?php
require_once 'day10_2.php';

use Day10_2 as HashGenerator;

class Day14 {
	private $inputArr;
	private $grid;
	
	private $usedSquares;
	private $regions;
	
	public function __construct($input) {
		for($i = 0; $i < 128; $i++) {
			$this->inputArr[] = $input . '-' . $i;

			$hashGenerator = new HashGenerator($input . '-' . $i);
			$hashGenerator->run();
			$hash = $hashGenerator->getHash();
			
			$binary = hex2bin($hash);
			$gridRow = '';
			for($j=0;$j<16;$j++) {
				$gridRow .= sprintf( "%08b", ord($binary[$j]));
			}
			$gridRow = str_replace('1', '#', $gridRow);
			$gridRow = str_replace('0', '.', $gridRow);
			$gridRow = str_split($gridRow);
			$this->grid[] = $gridRow;
		}
		
		$this->usedSquares = 0;
		$this->regions = 0;
	}
	
	public function run() {
		foreach($this->grid as $gridRow) {
			for($i = 0; $i < sizeof($gridRow); $i++) {
				if($gridRow[$i] == '#') {
					$this->usedSquares++;
				}
			}
		}
		$regionNumber = 1;
		for($row = 0; $row < sizeof($this->grid); $row++) {
			for($column = 0; $column < sizeof($this->grid[$row]); $column++) {
				if($this->markRegion($regionNumber, $row, $column)) {
					$regionNumber++;
				}
				
			}
		}
		
		$this->regions = --$regionNumber;
	}
	
	private function markRegion($regionNumber, $row, $column) {
		if(!isset($this->grid[$row][$column]) 
			|| $this->grid[$row][$column] != '#') {
			return false;
		}
		
		$this->grid[$row][$column] = $regionNumber;
		
		$this->markRegion($regionNumber, $row, $column + 1);
		$this->markRegion($regionNumber, $row, $column - 1);
		$this->markRegion($regionNumber, $row + 1, $column);
		$this->markRegion($regionNumber, $row - 1, $column);
		
		return true;
	}
	
	public function getUsedSquares() {
		return $this->usedSquares;
	}
	
	public function getRegions() {
		return $this->regions;
	}
}

$inputs = [
	"flqrgnkx",
	"amgozmfv"
];

foreach($inputs as $input) {
	$day = new Day14($input);
	$day->run();
	echo "Input: " . $input . "\n";
	echo "Used squares: " . $day->getUsedSquares() . "\n";
	echo "Regions: " . $day->getRegions() . "\n";
	echo "-----------\n";
}