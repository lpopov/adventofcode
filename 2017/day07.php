<?php

class WrongWeightException extends Exception {
	
}

class Day07 {
	private $inputArr;
	
	private $bottomElement;
	private $correctWeight;
	private $tree;
	
	public function __construct($input) {
		$this->inputArr = explode("\n", $input);
		
		$this->bottomElement = '';
		$this->correctWeight = 0;
		$this->tree = [];
	}
	
	public function run() {
		$allChildren = [];
		foreach($this->inputArr as $element) {
			$elementArr = $this->getElementArr($element);
			
			$this->tree[$elementArr['name']] = [
				'weight'   => $elementArr['weight'],
				'children' => $elementArr['children'],
			];
			
			$allChildren = array_merge($allChildren, $elementArr['children']);
		}
		
		$this->findBottomElement($allChildren);
		$this->findCorrectWeight();
	}
	
	public function getBottomElement() {
		return $this->bottomElement;
	}
	
	public function getCorrectWeight() {
		return $this->correctWeight;
	}

	private function getElementArr($line) {
		$elementArr = [];
		$tmpArr = explode(' (', $line);
		$elementArr['name'] = $tmpArr[0];
		
		$tmpArr = explode(')', $tmpArr[1]);
		$elementArr['weight'] = $tmpArr[0];
		
		$elementArr['children'] = [];
		
		if(strlen($tmpArr[1]) > 2) {
			$tmpArr = explode(' -> ', $tmpArr[1]);
			$elementArr['children'] = explode(', ', $tmpArr[1]);
		}
		
		return $elementArr;
	}
	
	private function findBottomElement($allChildren) {
		foreach($this->tree as $element => $children) {
			if(!in_array($element, $allChildren)) {
				$this->bottomElement = $element;
				break;
			}
		}
	}
	private function findCorrectWeight() {
		try {
			$this->findElementWeight($this->tree[$this->bottomElement]);
		} catch(WrongWeightException $e) {
			$weightsNamesArr = unserialize($e->getMessage());
			$weightsArr = array_keys($weightsNamesArr);
			
			if(sizeof($weightsNamesArr[$weightsArr[0]]) < sizeof($weightsNamesArr[$weightsArr[1]])) {
				$weightDifference = $weightsArr[0] - $weightsArr[1];
				$this->correctWeight = $this->tree[$weightsNamesArr[$weightsArr[0]][0]]['weight'] - $weightDifference;
			} else {
				$weightDifference = $weightsArr[1] - $weightsArr[0];
				$this->correctWeight = $this->tree[$weightsNamesArr[$weightsArr[1]][0]]['weight'] - $weightDifference;
			}
		}
	}
	
	private function findElementWeight($element) {
		if(empty($element['children'])) {
			return $element['weight'];
		}
		
		$weights = [];
		$weightsNames = [];
		$doesChildrenHaveChildren = false;
		foreach($element['children'] as $child) {
			$childWeight = $this->findElementWeight($this->tree[$child]);
			
			if(sizeof($this->tree[$child]['children']) > 0) {
				$doesChildrenHaveChildren = true;
			}
			
			if(!isset($weights[$childWeight])) {
				$weights[$childWeight] = 0;
			}
			
			$weights[$childWeight]++;
			$weightsNames[$childWeight][] = $child;
		}
		
		if($doesChildrenHaveChildren && sizeof($weights) > 1) {
			throw new WrongWeightException(serialize($weightsNames));
		}
		
		$elementWeight = $element['weight'];
		foreach($weights as $weight => $times) {
			$elementWeight += $weight * $times;
		}
		
		return $elementWeight;
	}
}

$inputs = [
	"pbga (66)
xhth (57)
ebii (61)
havc (66)
ktlj (57)
fwft (72) -> ktlj, cntj, xhth
qoyq (66)
padx (45) -> pbga, havc, qoyq
tknk (41) -> ugml, padx, fwft
jptl (61)
ugml (68) -> gyxo, ebii, jptl
gyxo (61)
cntj (57)",
];

foreach($inputs as $input) {
	$day = new Day07($input);
	$day->run();
	echo "Bottom element: " . $day->getBottomElement() . "\n";
	echo "Correct weight: " . $day->getCorrectWeight() . "\n";
}

$day = new Day07(file_get_contents("input.day07.txt"));
$day->run();
echo "-------------\n";
echo "Bottom element: " . $day->getBottomElement() . "\n";
echo "Correct weight: " . $day->getCorrectWeight() . "\n";