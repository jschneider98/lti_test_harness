<?php

require_once('Loader.php');

class TeacherDeepLinkTemplate
{
    public $url;
    public $show_launch_button;
    public $params = [];

    /**
     *
     */
    public function __construct($params = [])
    {
        $form_params = [];

        extract($params, EXTR_IF_EXISTS);

        $this->action = $action;
        $this->params = $form_params;
        $this->url = $form_params['custom_deep_link_url'];

        $client = Loader::loadClient($form_params);

        $oauth = $client->getOauth($this->url, 'POST', $form_params);
        $this->params = $oauth->get_parameters();
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
<h2>Teacher Deep Link</h2>
<hr>
<h5>Email: {$lis_person_contact_email_primary}</h5>
<hr>
<form
    action="{$this->url}"
    name="ltiLaunchForm"
    id="ltiLaunchForm"
    method="post"
    enctype="application/x-www-form-urlencoded"
    target="tool_provider_content"
>
HTML;

    foreach ($this->params as $key => $val) {
        if ($key != 'submit_lti_launch') {
        $html .= <<< HTML
<b>$key:</b> $val
<hr>
<input type="hidden" name="$key" value="{$val}">
HTML;
        }
    }

    $html .= <<< HTML

    <input type="submit" name="submit_lti_launch" value="LTI Launch">

</form>
<br>
<iframe height="500px" width="100%" name="tool_provider_content" frameBorder="0"></iframe>
HTML;

        return $html;
    }
}
