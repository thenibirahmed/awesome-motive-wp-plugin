<?php 

namespace AwesomeMotive;

use AwesomeMotive\Frontend\TableBlock;

class Frontend {

    /**
     * Load all fronend classes
     */
    public function __construct() {
        new TableBlock();
    }
}