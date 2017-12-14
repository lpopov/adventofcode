<?php
class Day10_2 {
	private $inputArr;
	
	private $list;
	private $listSize;
	private $result;
	private $hash;
	
	public function __construct($input, $listSize = 256) {
		if($input == '') {
			$this->inputArr = [];
		} else {
			$this->inputArr = str_split($input);
		}
		
		array_walk($this->inputArr, function(&$item, $key){
			$item = ord($item);
		});

		$listEnd = [17, 31, 73, 47, 23];
		
		$this->inputArr = array_merge($this->inputArr, $listEnd);

		$this->list = array_keys(array_fill(0, $listSize, 1));
		$this->listSize = $listSize;
		$this->result = 0;
		$this->hash = '';
	}
	
	public function run() {
		$currentPosition = 0;
		$step = 0;
		for($round = 0; $round < 64; $round++) {
			foreach($this->inputArr as $length) {
				for($i=0; $i < floor($length/2); $i++) {
					$tmpChar = $this->list[($currentPosition + $i) % $this->listSize];
					$this->list[($currentPosition + $i) % $this->listSize] = $this->list[($currentPosition + $length - $i - 1) % $this->listSize];
					$this->list[($currentPosition + $length - $i - 1) % $this->listSize] = $tmpChar;
				}

				$currentPosition = ($currentPosition + $length + $step) % $this->listSize;
				$step += 1;
			}
		}

		for($sectionStart = 0; $sectionStart < 256; $sectionStart += 16) {
			$listSection = array_slice($this->list, $sectionStart, 16);
			$this->hash .= sprintf("%02s" ,dechex($this->xorArray($listSection)));
		}
	}
	
	private function xorArray($array) {
		$result = null;
		foreach($array as $element) {
			if($result === null) {
				$result = chr($element);
				continue;
			}
			$result ^= chr($element);
		}
		
		return ord($result);
	}
	
	public function getHash() {
		return $this->hash;
	}
}	

//$inputs = [
//	'',
//	'AoC 2017',
//	'1,2,3',
//	'1,2,4',
//	'83,0,193,1,254,237,187,40,88,27,2,255,149,29,42,100',
//];
//
//foreach($inputs as $input) {
//	$day = new Day10_2($input);
//	$day->run();
//	echo "Input: " . $input . "\n";
//	echo "Hash is: " . $day->getHash() . "\n";
//}