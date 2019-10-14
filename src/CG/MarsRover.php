<?php

namespace CG;



class MarsRover
{
    protected $moveVector = [
        "N" => [0, 1],
        "S" => [0, -1],
        "E" => [1, 0],
        "W" => [-1, 0],
    ];
    protected $leftTurnsMap = [
        "N" => "W",
        "W" => "S",
        "S" => "E",
        "E" => "N"
    ];
    protected $rightTurnsMap = [
        "N" => "E",
        "E" => "S",
        "S" => "W",
        "W" => "N"
    ];

    protected $data;

    public function __construct($data) {
        $this->data = explode("\n", $data);
    }


    public function runMission()
    {
        $upperBounds['X'] = explode(" ", $this->data[0])[0];
        $upperBounds['Y'] = explode(" ", $this->data[0])[1];

        array_shift($this->data);
        $rovers = [];

        $count = 0;

        foreach($this->data as $index => $datum) {
            if ($index % 2 === 0) {
                $rovers[$count]['start'] = $this->data[$index];
                $rovers[$count]['moves'] = $this->data[$index+1];
                $count++;
            }
        }

        $endPositions = [];

        foreach($rovers as $rover) {

            $start = explode(" ", $rover['start']);

            $roverPosition = ['X' => $start[0], 'Y' => $start[1], 'direction' => $start[2]];


            $moves = str_split($rover['moves']);

            foreach($moves as $move) {

                if ($move == 'L') {
                    $roverPosition['direction'] = $this->leftTurnsMap[$roverPosition['direction']];

                } else if ($move == 'R') {
                    $roverPosition['direction'] = $this->rightTurnsMap[$roverPosition['direction']];

                } else if ($move == 'M') {

                    if ($roverPosition['direction'] == 'N') {
                        $roverPosition['Y'] += $this->moveVector['N'][1];

                    } else if ($roverPosition['direction'] == 'S') {
                        $roverPosition['Y'] += $this->moveVector['S'][1];

                    } else if ($roverPosition['direction'] == 'E') {
                        $roverPosition['X'] += $this->moveVector['E'][0];

                    } else if ($roverPosition['direction'] == 'W') {
                        $roverPosition['X'] += $this->moveVector['W'][0];
                    }

                    if ($roverPosition['X'] < 0 ||
                        $roverPosition['Y'] < 0 ||
                        $roverPosition['X'] > $upperBounds['X'] ||
                        $roverPosition['Y'] > $upperBounds['Y']
                    ) {
                        throw new \Exception('Out of bounds');
                    }
                }

            }
            $endPositions[] = $roverPosition;
        }

        return $endPositions;
    }
}