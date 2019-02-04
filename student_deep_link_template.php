<?php
require_once('client.php');

class StudentDeepLinkTemplate
{
    public $title;
    public $client;
    public $params = [];

    /**
     *
     */
    public function __construct($params = [])
    {
        $title = null;
        $url = null;
        $client = null;
        $form_params = [];

        extract($params, EXTR_IF_EXISTS);

        $this->url = $url;
        $this->client = $client;
        $this->title = $title;

        if ($this->url && $this->client) {
            $oauth = $client->getOauth($this->url, 'POST', $form_params);
            $this->params = $oauth->get_parameters();
        }
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
<h2>Student Deep Link</h2>
<hr>
<h5>Email: {$lis_person_contact_email_primary}</h5>
<hr>
HTML;

        if (!$this->params) {
            $html .= "No assessments at this time.<br>";
        } else {
            $html .= $this->getForm();
        }

        return $html;
    }


    /**
     *
     */
    public function getForm()
    {
        extract($this->params);

        $html = <<< HTML
<form
    action="{$this->url}"
    name="ltiLaunchForm"
    id="ltiLaunchForm"
    method="post"
    enctype="application/x-www-form-urlencoded"
    target="_blank"
>

<input type="hidden" name="custom_debug" value="{$custom_debug}">

<input type="hidden" name="lti_message_type" value="{$lti_message_type}">
<input type="hidden" name="lis_outcome_service_url" value="{$lis_outcome_service_url}">
<input type="hidden" name="lis_result_sourcedid" value="{$lis_result_sourcedid}">

lis_person_contact_email_primary
<input type="text" name="lis_person_contact_email_primary" value="{$lis_person_contact_email_primary}">
<br>

<input type="hidden" name="lti_version" value="{$lti_version}">

<input type="hidden" name="oauth_consumer_key" value="{$oauth_consumer_key}">
<input type="hidden" name="oauth_consumer_secret" value="{$oauth_consumer_secret}">
<input type="hidden" name="oauth_nonce" value="{$oauth_nonce}">
<input type="hidden" name="oauth_signature_method" value="{$oauth_signature_method}">
<input type="hidden" name="oauth_signature" value="{$oauth_signature}">
<input type="hidden" name="oauth_timestamp" value="{$oauth_timestamp}">

Assessment found: $this->title<br>
URL : $this->url<br>
Click 'Go' to take assessment: <input type="submit" name="submit_go" value="{$submit_go}">
<br>

</form>
<br>
<iframe height="400px" width="100%" name="tool_provider_content" frameBorder="0"></iframe>
HTML;

        return $html;
    }
}
