<?php
class Day12 {
	private $inputArr;
	
	private $programsArr;
	private $programsGroupsArr;
	
	public function __construct($input) {
		$tmpArr = explode("\n", $input);
		foreach($tmpArr as $inputStr) {
			$tmpArr = explode(' <-> ', $inputStr);
			$this->inputArr[(int) $tmpArr[0]] = explode(', ',$tmpArr[1]);
			
			foreach($this->inputArr as $key => $valueArr) {
				foreach($valueArr as $valueKey => $value) {
					$this->inputArr[$key][$valueKey] = (int) $value;
				}
			}
		}
		
		$this->programsArr = [];
		$this->programsGroupsArr = [];
	}
	
	public function run() {
		foreach($this->inputArr as $program => $connectedPrograms) {
			$loopArr = [];
			
			if($this->isConnectedWithZero($program, $loopArr)) {
				$this->programsArr[] = $program;
			}
			
			if(empty($loopArr)) {
				continue;
			}
			
			sort($loopArr);
			
			if(!in_array($loopArr, $this->programsGroupsArr)) {
				$this->programsGroupsArr[] = $loopArr;
			}
			
			$isLoopArrMerged = false;
			foreach($this->programsGroupsArr as $programsGroupId => $programsGroup) {
				if(!empty(array_intersect($loopArr, $programsGroup))) {
					$this->programsGroupsArr[$programsGroupId] = array_unique(array_merge($programsGroup, $loopArr));
					$isLoopArrMerged = true;
					break;
				}
			}
			
			if(!$isLoopArrMerged) {
				$this->programsGroupsArr[] = $loopArr;
			}
		}
		
		$this->compactProgramsArr();
	}
	
	private function compactProgramsArr() {
		$priogramsArrSize = count($this->programsGroupsArr);
		
		for($i=0; $i < $priogramsArrSize; $i++){
			if(!isset($this->programsGroupsArr[$i])) {
				continue;
			}
			
			for($j=$i+1; $j < $priogramsArrSize; $j++){
				if(!isset($this->programsGroupsArr[$j])) {
					continue;
				}
				if(!empty(array_intersect($this->programsGroupsArr[$i], $this->programsGroupsArr[$j]))) {
					$this->programsGroupsArr[$i] = array_unique(array_merge($this->programsGroupsArr[$i], $this->programsGroupsArr[$j]));
					unset($this->programsGroupsArr[$j]);
				}
			}
		}
	}
	
	private function isConnectedWithZero($program, &$loopArr) {
		if($program === 0) {
			return true;
		} elseif (in_array($program, $loopArr)) {
			$loopArr[] = $program;
			return false;
		} else {
			$loopArr[] = $program;
		}
		
		foreach($this->inputArr[$program] as $connectedProgram) {
			if($this->isConnectedWithZero($connectedProgram, $loopArr)) {
				return true;
			}
		}
		
		return false;
	}
	
	public function getProgramsCount() {
		return count($this->programsArr);
	}
	
	public function getProgramGroupsCount() {
		return count($this->programsGroupsArr);
	}
}

$inputs = [
	"0 <-> 2
1 <-> 1
2 <-> 0, 3, 4
3 <-> 2, 4
4 <-> 2, 3, 6
5 <-> 6
6 <-> 4, 5"
];

foreach($inputs as $input) {
	$day = new Day12($input);
	$day->run();
	echo "Input: \n" . $input . "\n";
	echo "Programs count: " . $day->getProgramsCount() . "\n";
	echo "Program groups count: " . $day->getProgramGroupsCount() . "\n";
}

$day = new Day12(file_get_contents("input.day12.txt"));
$day->run();
echo "-------------\n";
echo "Programs count: " . $day->getProgramsCount() . "\n";
echo "Program groups count: " . $day->getProgramGroupsCount() . "\n";