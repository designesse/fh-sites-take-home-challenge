<?php

namespace PokerHand;

class PokerHand
{
    public $cards = array();

    public function __construct($hand)
    {
        $cards = explode(' ', $hand);
        for ( $i=0; $i<count($cards); $i++ ) {
            $card['suit'] = substr($cards[$i], -1);
            $num = substr($cards[$i], 0, -1);
            if ( '1'<$num && $num<='10') {
                $num = (int) $num;
            }
            else {
                switch ($num) {
                    case 'J': $num = 11; break;
                    case 'Q': $num = 12; break;
                    case 'K': $num = 13; break;
                    case 'A': $num = 14; break;
                }
            }
            $card['num'] = $num;
            $this->cards[] = $card;
        }
    }

    private function isFlush() {
        $suit = $this->cards[0]['suit'];
        for ( $i=1; $i<count($this->cards); $i++ ) {
            if ( $this->cards[$i]['suit'] != $suit ) {
                return false;
            }
        }
        return true;
    }

    private function isRoyal() {
        $totalNum = 0;
        for ( $i=0; $i<count($this->cards); $i++ ) {
            $totalNum += $this->cards[$i]['num'];
        }
        if ( $totalNum == (14+13+12+11+10) ) {
            return true;
        }
        return false;
    }

    private function getNumFrequency() {
        $frequencies[$this->cards[0]['num']] = 1;
        for ( $i=1; $i<count($this->cards); $i++ ) {
            foreach ( $frequencies as $num => $frequency ) {
                if ( $this->cards[$i]['num'] == $num ) {
                    $frequencies[$num]++;
                }
                else {
                    $frequencies[$this->cards[$i]['num']] = 1;
                }
            }
        }

        $kind4 = 0;
        $kind3 = 0;
        $couple = 0;
        foreach ( $frequencies as $num => $frequency ) {
            switch ($frequency) {
                case 4: $kind4++; break;
                case 3: $kind3++; break;
                case 2: $couple++; break;
            }
        }
        return array('kind4' => $kind4, 'kind3' => $kind3, 'couple' => $couple);
    }

    private function isSequential() {
        $nums = [];
        for ( $i=0; $i<count($this->cards); $i++ ) {
            $nums[] = $this->cards[$i]['num'];
        }
        sort($nums);

        if ( $nums[0] == 2 && $nums[count($nums)-1] == 14 ) {
            array_pop($nums);
            array_unshift($nums, 1);
        }
        for ( $j=0; $j<count($nums)-1; $j++ ) {
            if ( $nums[$j] != $nums[$j+1]-1 ) {
                return false;
            }
        }
        return true;
    }

    public function getRank()
    {
        $isFlush = $this->isFlush();
        $isSequential = $this->isSequential();
        if (  $isFlush ) {
            if ( $this->isRoyal() ) {
                return 'Royal Flush';
            }
            elseif ( $isSequential ) {
                return 'Straight Flush';
            }
        }

        $numOfAKind = $this->getNumFrequency();
        if ( $numOfAKind['kind4'] == 1 ) {
            return 'Four of a Kind';
        }

        if ( $numOfAKind['kind3'] == 1 && $numOfAKind['couple'] == 1 ) {
            return 'Full House';
        }

        if ( $isFlush ) {
            return 'Flush';
        }

        if ( $isSequential ) {
            return 'Straight';
        }

        if ( $numOfAKind['kind3'] == 1 ) {
            return 'Three of a Kind';
        }

        if ( $numOfAKind['couple'] == 2 ) {
            return 'Two Pair';
        }

        if ( $numOfAKind['couple'] == 1 ) {
            return 'One Pair';
        }

        return 'High Card';
    }
}
