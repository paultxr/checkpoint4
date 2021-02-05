<?php

namespace App\Data;

use App\Entity\Job;
use App\Entity\Techno;

class SearchData 
{

    /**
     * @var int
     */
    public $page = 1;
    
    /**
     * @var string
     */
    public $q = "";

    /**
     * @var Job[]
     */
    public $job = [];

    /**
     * @var Techno[]
     */
    public $techno = [];

}