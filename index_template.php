<?php

require_once('Loader.php');

class IndexTemplate
{
    public $url;
    public $action;
    public $show_launch_button;
    public $params = [];

    /**
     *
     */
    public function __construct($params = [])
    {
        $form_params = [];
        $action = basename($_SERVER['PHP_SELF']);
        $url = null;

        extract($params, EXTR_IF_EXISTS);
        $this->action = $action;

        $this->params = $form_params;
    }


    /**
     *
     */
    public function toHtml()
    {
        $action = $this->action;
        $target = "_self";
        $button = '<input type="submit" name="submit_save" value="Save">';

        $html = "";

        if (isset($_POST['submit_save'])) {
            $html .= "Config saved.<br>";
        }

        $html .= <<< HTML
<h2>Configuration</h2>
<hr>
<form
    action="{$action}"
    name="ltiLaunchForm"
    id="ltiLaunchForm"
    method="post"
    enctype="application/x-www-form-urlencoded"
    target="{$target}"
>
HTML;

    foreach ($this->params as $key => $val) {
        if ($key != 'submit_lti_launch') {
        $html .= <<< HTML
$key
<input type="text" style="width: 500px" name="$key" value="{$val}">
<br>
HTML;
        }
    }

    $html .= <<< HTML
{$button}

</form>
HTML;

        return $html;
    }
}