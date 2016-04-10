<?php

namespace gdarko\Tools;


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
    private $class_holder = '{class_lg} {class_md} {class_sm} {class_xs} {additional}';

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
     * This is custom number of columns per row, if this is set the builder will ignore the
     * column count that is contained in $row_columns_lg
     * @var null
     */
    private $custom_columns_per_row_number = null;

    /**
     * Number of columns on tablets and mobile screens
     */
    private $row_columns_xs = null;

    /**
     * Custom col-lg class, if this is set the builder will ignore the $row_columns_xs
     * @var string
     */
    private $custom_lg = null;

    /**
     * Custom col-md class, if this is set the builder will ignore the $row_columns_xs
     * @var string
     */
    private $custom_md = null;

    /**
     * Custom col-sm class, if this is set the builder will ignore the $row_columns_xs
     * @var string
     */
    private $custom_sm = null;

    /**
     * Custom col-xs class, if this is set the builder will ignore the $row_columns_xs
     * @var string
     */
    private $custom_xs = null;

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
        $this->row_columns_xs = 1;
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
     * Helper method for setting custom total columns per row. If this is
     * set the row will ignore the columns number contained in $row_col_lg
     * This is good if you building mobile-first grids, for example you have
     * six .col-sm-6 columns in one .row and you want three columns per row
     * on mobiles (.col-xs-3)
     *
     * @param $number
     */
    public function setCustomTotalRowColumns($number)
    {
        $this->custom_columns_per_row_number = $number;
    }

    /**
     * Helper method for a custom column class.
     * Using this you may build grid with offsets, mobile-first girds, etc.
     *
     * The default viewport is lg
     *
     * @param $class
     * @param string $viewport
     */
    public function setCustomColumnClass($class, $viewport = 'lg')
    {
        switch ($viewport)
        {
            case "md":
                $this->custom_md = $class;
                break;
            case "sm":
                $this->custom_sm = $class;
                break;
            case "xs":
                $this->custom_xs = $class;
                break;
            default:
                $this->custom_lg = $class;
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

        if( !is_null($this->custom_columns_per_row_number) ){
            $row_length = $this->custom_columns_per_row_number;
        }else{
            $row_length = $this->row_columns_lg;
        }

        if (count($this->columns) > 0) {
            foreach ($this->columns as $column) {
                if ($counter === 0) {
                    $output .= '<div class="' . $this->row_class . '">';
                }
                $output .= '<div class="' . $column_class . '">';
                $output .= $column;
                $output .= '</div>';
                $counter++;
                if ($counter === $row_length) {
                    $output .= '</div><!--/.' . $this->row_class . '-->';
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
        $col_lg = (int)$this->gridsize / $this->row_columns_lg;

        if(!is_null($this->custom_lg)){
            $columns = str_replace("{class_lg}", $this->custom_lg, $this->class_holder);
        }else{
            $columns = str_replace("{class_lg}", "col-lg-" . $col_lg, $this->class_holder);
        }

        if(!is_null($this->custom_md)) {
            $columns = str_replace("{class_md}", $this->custom_md, $columns);
        }else{
            if ($this->row_columns_md !== 0) {
                $col_md = $this->gridsize / (int)$this->row_columns_md;
                $columns = str_replace("{class_md}", "col-md-" . $col_md, $columns);
            } else {
                $columns = str_replace("{class_md}", "", $columns);
            }
        }

        if(!is_null($this->custom_sm)) {
            $columns = str_replace("{class_sm}", $this->custom_sm, $columns);
        }else{
            if ($this->row_columns_sm !== 0) {
                $col_sm = $this->gridsize / (int)$this->row_columns_sm;
                $columns = str_replace("{class_sm}", "col-sm-" . $col_sm, $columns);
            } else {
                $columns = str_replace("{class_sm}", "", $columns);
            }
        }

        if(!is_null($this->custom_xs)) {
            $columns = str_replace("{class_xs}", $this->custom_xs, $columns);
        }else{
            if ($this->row_columns_xs !== 0) {
                $col_xs = $this->gridsize / (int)$this->row_columns_xs;
                $columns = str_replace("{class_xs}", "col-xs-" . $col_xs, $columns);
            } else {
                $columns = str_replace("{class_xs}", "", $columns);
            }
        }

        if (!is_null($this->additional_class)) {
            $columns = str_replace("{additional}", $this->additional_class, $columns);
        } else {
            $columns = str_replace("{additional}", "", $columns);
        }

        return trim($columns);
    }
}