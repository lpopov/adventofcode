<?php
class Day01_2 {
	private $inputArr;
	private $sum;
	private $step;
	private $inputLength;
	
	public function __construct($input) {
		$this->inputArr = str_split($input);
		
		$this->sum = 0;
		$this->inputLength = strlen($input);
		$this->step = $this->inputLength / 2;
	}
	
	public function run() {
		foreach($this->inputArr as $key => $number) {
			$secondNumberKey = $key + $this->step;
			
			if($secondNumberKey >= $this->inputLength) {
				$secondNumberKey -= $this->inputLength;
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
	'1212',
	'1221',
	'123425',
	'123123',
	'12131415',
];

foreach($inputs as $input) {
	$day = new Day01_2($input);
	$day->run();
	echo "The input is: ". $input . "\n";
	echo "The sum is: " . $day->getSum() . "\n";
}

$day = new Day01_2(file_get_contents("input.day01.txt"));
$day->run();
echo "-------------\n";
echo "The sum is: " . $day->getSum() . "\n";