<?php
declare(strict_types=1);

namespace FrontendForms;

/*
 * Class for creating field set opener
 *
 * Created by Jürgen K.
 * https://github.com/juergenweb
 * File name: FieldsetOpen.php
 * Created: 03.07.2022
 */

class FieldsetOpen extends Tag
{
    protected Legend $legend;

    public function __construct()
    {
        parent::__construct();
        $this->setTag('fieldset');
        $this->setCSSClass('fieldsetClass');
    }

    /**
     * Set the text for the legend
     * @param string $legendText
     * @return Legend
     */
    public function setLegend(string $legendText): Legend
    {
        $this->legend = new Legend(); // instantiate legend object
        $this->legend->setText($legendText);
        return $this->legend;
    }

    public function __toString(): string
    {
        return $this->___render();
    }

    /**
     * Render the fieldset open tag
     * @return string
     */
    public function ___render(): string
    {
        $this->append($this->legend->___render());
        return $this->renderSelfclosingTag($this->getTag());
    }
}
