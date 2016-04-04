<?php

namespace gdarko\tools;


class TwitterBootstrapGrid
{
    /**
     * The Grid columns array
     * @var null
     */
    private $columns = null;

    /**
     * Total grid size, the defautl is 12
     * @var int
     */
    private $gridsize = 12;

    /**
     * Keep the row class
     * @var string
     */
    private $row_class = 'row';

    /**
     * Keep the column class;
     */
    private $column_class = '{class_lg} {class_md} {class_sm} {class_xs} {additional}';

    /**
     * Number of columns on medium screens
     */
    private $row_columns_lg = null;

    /**
     * Number of columns on large screens
     */
    private $row_columns_md = null;

    /**
     * Number of columns on small screens
     */
    private $row_columns_sm = null;

    /**
     * Number of columns on tablets and mobile screens
     */
    private $row_columns_xs = null;

    /**
     * Additional Class
     */
    private $additional_class = "";

    /**
     * BootstrapGrid constructor.
     * @param $row_columns
     * @param null $columns
     */
    public function __construct($row_columns, $columns = null)
    {
        if (is_array($columns) && count($columns) > 0) {
            $this->columns = $columns;
        } else {
            $this->columns = array();
        }
        $this->row_columns_lg = $row_columns;
        $this->defaults();
    }

    /**
     * Set the default number of columns per row for each viewport.
     */
    public function defaults()
    {
        $this->row_columns_lg = 4;
        $this->row_columns_md = 4;
        $this->row_columns_sm = 2;
        $this->row_columns_xs = 2;
    }

    /**
     * Helper method for setting total columns per row for different viewports.
     * The default viewport is lg
     *
     * @param $number
     * @param string $viewport
     */
    public function setTotalRowColumns($number, $viewport = 'lg')
    {
        switch ($viewport)
        {
            case "md":
                $this->row_columns_md = $number;
                break;
            case "sm":
                $this->row_columns_sm = $number;
                break;
            case "xs":
                $this->row_columns_xs = $number;
                break;
            default:
                $this->row_columns_lg = $number;
        }
    }

    /**
     * Helper method for setting additional class to the columns
     * @param $class
     */
    public function setAdditionalColumnClass($class)
    {
        $this->additional_class = $class;
    }

    /**
     * Returns the total columns per row for a given viewport
     * @param string $viewport
     * @return integer
     */
    public function getColumnsPerRow( $viewport = 'lg' )
    {
        switch ($viewport)
        {
            case "md":
                return $this->row_columns_md;
                break;
            case "sm":
                return $this->row_columns_sm;
                break;
            case "xs":
                return $this->row_columns_xs;
                break;
            default:
                return $this->row_columns_lg;
        }
    }

    /**
     * Returns the number of columns added to the grid so far
     * @return mixed
     */
    public function getColumnsCount()
    {
        return count($this->columns);
    }

    /**
     * Insert a column to the grid. The column is a HTML string
     * @param $content
     */
    public function addColumn($content)
    {
        if (is_string($content)) {
            $this->columns[] = $content;
        }
    }

    /**
     * Insert array with with columns( column => string with content )
     * @param $columns
     */
    public function setColumns($columns)
    {
        if (is_array($columns) && count($columns) > 0) {
            $this->columns = $columns;
        }
    }

    /**
     * Build the Responsive Twitter Bootstrap Grid
     * @return string
     */
    public function build()
    {
        $output = "";
        $counter = 0;
        $column_class = $this->generateColumnClass();
        if (count($this->columns) > 0) {
            foreach ($this->columns as $column) {
                if ($counter === 0) {
                    $output .= '<div class="' . $this->row_class . '">';
                }
                $output .= '<div class="' . $column_class . '">';
                $output .= $column;
                $output .= '</div>';
                $counter++;
                if ($counter === $this->row_columns_lg) {
                    $output .= '</div><!--/.' . $this->row_class . '--><div class="clearfix"></div>';
                    $counter = 0;
                }
            }
        }
        return $output;
    }

    /**
     * Generate the column name that is used in the grid for each column
     * @return mixed
     */
    public function generateColumnClass()
    {
        $col_lg = $this->gridsize / $this->row_columns_lg;
        $columns = str_replace("{class_lg}", "col-lg-" . $col_lg, $this->column_class);
        if ($this->row_columns_md !== 0) {
            $col_md = $this->gridsize / $this->row_columns_md;
            $columns = str_replace("{class_md}", "col-md-" . $col_md, $columns);
        } else {
            $columns = str_replace("{class_md}", "", $columns);
        }

        if ($this->row_columns_sm !== 0) {
            $col_sm = $this->gridsize / $this->row_columns_sm;
            $columns = str_replace("{class_sm}", "col-sm-" . $col_sm, $columns);
        } else {
            $columns = str_replace("{class_sm}", "", $columns);
        }

        if ($this->row_columns_xs !== 0) {
            $col_xs = $this->gridsize / $this->row_columns_xs;
            $columns = str_replace("{class_xs}", "col-xs-" . $col_xs, $columns);
        } else {
            $columns = str_replace("{class_xs}", "", $columns);
        }

        if (!is_null($this->additional_class)) {
            $columns = str_replace("{additional}", $this->additional_class, $columns);
        } else {
            $columns = str_replace("{additional}", "", $columns);
        }

        return $columns;
    }
}