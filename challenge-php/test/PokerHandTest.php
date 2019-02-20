<?php
namespace PokerHand;

use PHPUnit\Framework\TestCase;

class PokerHandTest extends TestCase
{
    /**
     * @test
     */
    public function itCanRankARoyalFlush()
    {
        $hand = new PokerHand('As Ks Qs Js 10s');
        $this->assertEquals('Royal Flush', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankAStraightFlush()
    {
        $hand = new PokerHand('Ac 2c 3c 4c 5c');
        $this->assertEquals('Straight Flush', $hand->getRank());
    }

   /**
     * @test
     */
    public function itCanRankAFourOfAKind()
    {
        $hand = new PokerHand('5c 5d 5h 5s 2d');
        $this->assertEquals('Four of a Kind', $hand->getRank());
    }

   /**
     * @test
     */
    public function itCanRankAFullHouse()
    {
        $hand = new PokerHand('6s 6h 6d Kc Kh');
        $this->assertEquals('Full House', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankAFlush()
    {
        $hand = new PokerHand('Kh Qh 6h 2h 9h');
        $this->assertEquals('Flush', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankAStraight()
    {
        $hand = new PokerHand('10d 9s 8h 7d 6c');
        $this->assertEquals('Straight', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankAThreeOfAKind()
    {
        $hand = new PokerHand('Qs Qc Qh 9d 2s');
        $this->assertEquals('Three of a Kind', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankTwoPair()
    {
        $hand = new PokerHand('Kh Kc 3s 3h 2d');
        $this->assertEquals('Two Pair', $hand->getRank());
    }

    /*
    /*
     * @test
     */
    public function itCanRankAPair()
    {
        $hand = new PokerHand('Ah As 10c 7d 6s');
        $this->assertEquals('One Pair', $hand->getRank());
    }

    /*
    /*
     * @test
     */
    public function itCanRankHighCard()
    {
        $hand = new PokerHand('Kd Qd 7s 4s 3h');
        $this->assertEquals('High Card', $hand->getRank());
    }
}
