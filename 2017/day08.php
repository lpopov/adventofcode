<?php

class WrongWeightException extends Exception {
	
}

class Day08 {
	private $inputArr;
	
	private $registers;
	private $highestValueEver;
	
	const INSTRUCTION_REGISTER_INDEX = 0;
	const INSTRUCTION_INDEX = 1;
	const INSTRUCTION_VALUE_INDEX = 2;
	
	const CONDITION_REGISTER_INDEX = 4;
	const CONDITION_INDEX = 5;
	const CONDITION_VALUE_INDEX = 6;
	
	public function __construct($input) {
		$this->inputArr = explode("\n", $input);
		
		$this->registers = [];
		$this->highestValue = 0;
	}
	
	public function run() {
		
		foreach($this->inputArr as $instruction) {
			
			$instructionArr = $this->decodeInstruction($instruction);
			
			$this->initRegisters($instructionArr);
			
			if($this->isConditionMet($instructionArr)) {
				$this->applyInstruction($instructionArr);
			}
			
		}
		
	}
	
	public function getBottomElement() {
		return $this->bottomElement;
	}
	
	public function getCorrectWeight() {
		return $this->correctWeight;
	}

	private function decodeInstruction($instruction) {
		return explode(' ', $instruction);
	}
	
	private function initRegisters($instructionArr) {
		if(!isset($this->registers[$instructionArr[self::INSTRUCTION_REGISTER_INDEX]])) {
			$this->registers[$instructionArr[self::INSTRUCTION_REGISTER_INDEX]] = 0;
		}
		
		if(!isset($this->registers[$instructionArr[self::CONDITION_REGISTER_INDEX]])) {
			$this->registers[$instructionArr[self::CONDITION_REGISTER_INDEX]] = 0;
		}
	}
	
	private function isConditionMet($instructionArr) {
		$conditionRegisterValue = $this->registers[$instructionArr[self::CONDITION_REGISTER_INDEX]];
		$conditionValue = $instructionArr[self::CONDITION_VALUE_INDEX];
		$contidion = $instructionArr[self::CONDITION_INDEX];
		
		switch($contidion) {
			case '>':	return $conditionRegisterValue > $conditionValue;
			case '>=':	return $conditionRegisterValue >= $conditionValue;
			case '<':	return $conditionRegisterValue < $conditionValue;
			case '<=':	return $conditionRegisterValue <= $conditionValue;
			case '!=':	return $conditionRegisterValue != $conditionValue;
			case '==':	return $conditionRegisterValue == $conditionValue;
		}
	}
	
	private function applyInstruction($instructionArr) {
		switch($instructionArr[self::INSTRUCTION_INDEX]) {
			case "inc":
				$this->registers[$instructionArr[self::INSTRUCTION_REGISTER_INDEX]] += $instructionArr[self::INSTRUCTION_VALUE_INDEX];
				break;
			
			case "dec":
				$this->registers[$instructionArr[self::INSTRUCTION_REGISTER_INDEX]] -= $instructionArr[self::INSTRUCTION_VALUE_INDEX];
				break;
		}
		
		if($this->registers[$instructionArr[self::INSTRUCTION_REGISTER_INDEX]] > $this->highestValueEver) {
			$this->highestValueEver = $this->registers[$instructionArr[self::INSTRUCTION_REGISTER_INDEX]];
		}
	}
	
	public function getHighestRegisterValue() {
		$sortedRegisters = $this->registers;
		rsort($sortedRegisters);
		
		return $sortedRegisters[0];
	}
	
	public function getHighestValueEver() {
		return $this->highestValueEver;
	}
}

$inputs = [
	"b inc 5 if a > 1
a inc 1 if b < 5
c dec -10 if a >= 1
c inc -20 if c == 10",
];

foreach($inputs as $input) {
	$day = new Day08($input);
	$day->run();
	echo "Highest value: " . $day->getHighestRegisterValue() . "\n";
	echo "Highest value ever: " . $day->getHighestValueEver() . "\n";
}

$day = new Day08(file_get_contents("input.day08.txt"));
$day->run();
echo "-------------\n";
echo "Highest value: " . $day->getHighestRegisterValue() . "\n";
echo "Highest value ever: " . $day->getHighestValueEver() . "\n";