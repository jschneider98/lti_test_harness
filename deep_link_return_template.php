<?php

class DeepLinkReturnTemplate
{
    public $params = [];

    /**
     *
     */
    public function __construct($params = [])
    {

        $this->params = $params;
    }

    /**
     *
     */
    public function set($key, $value)
    {
        $this->params[$key] = $value;
    }

    /**
     *
     */
    public function toHtml()
    {
        extract($this->params);

        $html = <<< HTML
<h2>Deep Link Return</h2>
<hr>
<p>Saved the following data</p>
<hr>
$data
HTML;
        return $html;
    }
}
