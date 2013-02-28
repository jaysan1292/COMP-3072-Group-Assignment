<?php
class Line {
    public $p1, $p2;

    function __construct($a, $b) {
        $this->p1 = $a;
        $this->p2 = $b;
    }

    function midpoint() {
        $x = ($this->p1->x + $this->p2->x) / 2;
        $y = ($this->p1->y + $this->p2->y) / 2;

        return new Point($x, $y);
    }
}
