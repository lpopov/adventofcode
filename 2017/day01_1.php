<?php
class Day01_1 {
	private $inputArr;
	private $sum;
	private $length;
	
	public function __construct($input) {
		$this->inputArr = str_split($input);
		
		$this->sum = 0;
		$this->length = strlen($input);
	}
	
	
	public function run() {
		foreach($this->inputArr as $key => $number) {
			$secondNumberKey = $key + 1;
			if($secondNumberKey == $this->length) {
				$secondNumberKey = 0;
			}
			
			if($number == $this->inputArr[$secondNumberKey]) {
				$this->sum += $number;
			}
		}
		
	}

	public function getSum() {
		return $this->sum;
	}
	
	
}

$inputs = [
	'1122',
	'1111',
	'1234',
	'91212129',
];

foreach($inputs as $input) {
	$day = new Day01_1($input);
	$day->run();
	echo "The input is: ". $input . "\n";
	echo "The sum is: " . $day->getSum() . "\n";
}

$day = new Day01_1(file_get_contents("input.day01.txt"));
$day->run();
echo "-------------\n";
echo "The sum is: " . $day->getSum() . "\n";