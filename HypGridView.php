<?php

Yii::import('zii.widgets.grid.CGridView');

class HypGridView extends CGridView
{
    /**
     * Номера колонок, по которым переносится строка
     */
    public $hyphenationColumns=array();
    /**
     * Переносить каждые n столбцов
    */
    public $hyphenationOnCount=null;

    /**
     * Проверка на переносить/нетЪ
    */
    public function isHyphenation($num)
    {
        if (!empty($this->hyphenationOnCount))
            return !($num % $this->hyphenationOnCount);
        else
        if(!empty($this->hyphenationColumns)){
            if(!$this->hyphenationColumns instanceof Traversable && !is_array($this->hyphenationColumns))
                $this->hyphenationColumns=(array)$this->hyphenationColumns;
            $hyp=false;
            foreach($this->hyphenationColumns as $item)
                if($num==$item)
                    $hyp=true;
            return $hyp;
        }
        else
            return false;
    }
    
    /**
     * Renders the table header.
     */
    public function renderTableHeader() {
        if (!$this->hideHeader) {
            echo "<thead>\n";

            if ($this->filterPosition === self::FILTER_POS_HEADER)
                $this->renderFilter();

            echo "<tr>\n";
            $i = 0;
            foreach ($this->columns as $column){
                if ($this->isHyphenation($i++))
                     echo "</tr>\n<tr>\n";
                $column->renderHeaderCell();
            }
            echo "</tr>\n";

            if ($this->filterPosition === self::FILTER_POS_BODY)
                $this->renderFilter();

            echo "</thead>\n";
        }
        elseif ($this->filter !== null && ($this->filterPosition === self::FILTER_POS_HEADER || $this->filterPosition === self::FILTER_POS_BODY)) {
            echo "<thead>\n";
            $this->renderFilter();
            echo "</thead>\n";
        }
    }

    /**
     * Renders the filter.
     * @since 1.1.1
     */
    public function renderFilter() {
        if ($this->filter !== null) {
            echo "<tr class=\"{$this->filterCssClass}\">\n";
            $i = 0;
            foreach ($this->columns as $column){
                if ($this->isHyphenation($i++))
                     echo "</tr>\n<tr class=\"{$this->filterCssClass}\">\n";
                $column->renderFilterCell();
            }
            echo "</tr>\n";
        }
    }

    /**
     * Renders the table footer.
     */
    public function renderTableFooter() {
        $hasFilter = $this->filter !== null && $this->filterPosition === self::FILTER_POS_FOOTER;
        $hasFooter = $this->getHasFooter();
        if ($hasFilter || $hasFooter) {
            echo "<tfoot>\n";
            if ($hasFooter) {
                echo "<tr>\n";
                $i = 0;
                foreach ($this->columns as $column){
                    if ($this->isHyphenation($i++))
                        echo "</tr>\n<tr>\n";
                    $column->renderFooterCell();
                }
                echo "</tr>\n";
            }
            if ($hasFilter)
                $this->renderFilter();
            echo "</tfoot>\n";
        }
    }

    /**
     * Renders a table body row.
     * @param integer $row the row number (zero-based).
     */
    public function renderTableRow($row)
    {
        $htmlOptions=array();
        if($this->rowHtmlOptionsExpression!==null)
        {
            $data=$this->dataProvider->data[$row];
            $options=$this->evaluateExpression($this->rowHtmlOptionsExpression,array('row'=>$row,'data'=>$data));
            if(is_array($options))
                $htmlOptions = $options;
        }

        if($this->rowCssClassExpression!==null)
        {
            $data=$this->dataProvider->data[$row];
            $class=$this->evaluateExpression($this->rowCssClassExpression,array('row'=>$row,'data'=>$data));
        }
        elseif(is_array($this->rowCssClass) && ($n=count($this->rowCssClass))>0)
            $class=$this->rowCssClass[$row%$n];

        if(!empty($class))
        {
            if(isset($htmlOptions['class']))
                $htmlOptions['class'].=' '.$class;
            else
                $htmlOptions['class']=$class;
        }

        echo CHtml::openTag('tr', $htmlOptions)."\n";
        $i=0;
        foreach($this->columns as $column){
            if($this->isHyphenation($i++))
                echo "</tr>\n".CHtml::openTag('tr', $htmlOptions)."\n";
            $column->renderDataCell($row);
        }
        echo "</tr>\n";
    }
}
