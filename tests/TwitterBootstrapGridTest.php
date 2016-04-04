<?php

use gdarko\Tools\TwitterBootstrapGrid;

class TwitterBootstrapGridTest extends PHPUnit_Framework_TestCase {


    private $grid = null;

    public function test_get_columns_count()
    {
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
        $this->assertEquals(9, $this->grid->getColumnsCount());
        $this->grid->addColumn("Fusce lobortis lorem at ipsum semper sagittis.");
        $this->assertEquals(10, $this->grid->getColumnsCount());
    }

    public function test_generate_column_class()
    {
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
        $this->assertEquals("col-lg-3 col-md-3 col-sm-6 col-xs-12", $this->grid->generateColumnClass());
        $this->grid->setTotalRowColumns(2, "xs");
        $this->assertEquals("col-lg-3 col-md-3 col-sm-6 col-xs-6", $this->grid->generateColumnClass());
        $this->grid->setTotalRowColumns(2, "lg");
        $this->assertEquals("col-lg-6 col-md-3 col-sm-6 col-xs-6", $this->grid->generateColumnClass());
        $this->grid->setTotalRowColumns(3);
        $this->assertEquals("col-lg-4 col-md-3 col-sm-6 col-xs-6", $this->grid->generateColumnClass());
        $this->grid->setTotalRowColumns(4, "sm");
        $this->grid->setTotalRowColumns(1, "xs");
        $this->assertEquals("col-lg-4 col-md-3 col-sm-3 col-xs-12", $this->grid->generateColumnClass());
    }

}