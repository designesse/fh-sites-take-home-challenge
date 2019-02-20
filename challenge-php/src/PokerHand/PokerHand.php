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

    private function countNumFrequency() {
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
        return $frequencies;
    }

    private function getNumPair() {
        $frequencies = $this->countNumFrequency();
        $npair = 0;
        foreach ( $frequencies as $num => $frequency) {
            if ( $frequency == 2) {
                $npair++;
            }
        }

        return $npair;
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
        if ( $this->isFlush() ) {
            if ( $this->isRoyal() ) {
                return 'Royal Flush';
            }
            elseif ( $this->isSequential() ) {
                return 'Straight Flush';
            }
            else {
                return 'Flush';
            }
        }

        $npair = $this->getNumPair();
        if ( $npair == 2 ) {
            return 'Two Pair';
        }
        elseif ( $npair == 1 ) {
            return 'One Pair';
        }

        return 'Not a Flush and not two pair';

    }
}
