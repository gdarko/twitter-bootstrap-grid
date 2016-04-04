<?php

use gdarko\tools\TwitterBootstrapGrid;

class TwitterBootstrapGridTest extends PHPUnit_Framework_TestCase {


    private $grid = null;

    public function __construct($name, array $data, $dataName)
    {
        parent::__construct($name, $data, $dataName);

        $this->grid = new TwitterBootstrapGrid(4);
        $this->grid->addColumn("Lorem ipsum dolor sit amet, consectetuer adipiscing elit.");
        $this->grid->addColumn("Integer vitae libero ac risus egestas placerat.");
        $this->grid->addColumn("Fusce lobortis lorem at ipsum semper sagittis.");
        $this->grid->addColumn("Lorem ipsum dolor sit amet, consectetuer adipiscing elit.");
        $this->grid->addColumn("Integer vitae libero ac risus egestas placerat.");
        $this->grid->addColumn("Fusce lobortis lorem at ipsum semper sagittis.");
        $this->grid->addColumn("Lorem ipsum dolor sit amet, consectetuer adipiscing elit.");
        $this->grid->addColumn("Integer vitae libero ac risus egestas placerat.");
        $this->grid->addColumn("Fusce lobortis lorem at ipsum semper sagittis.");
    }

    public function getColumnsCountTest()
    {
        $this->assertEquals(9, $$this->grid->getColumnsCount());
    }
}