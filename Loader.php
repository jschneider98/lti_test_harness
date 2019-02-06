<?php

require_once('client.php');

class Loader
{
    /**
     *
     */
    public static function loadFormParams($params = [])
    {
        $teacher_context = true;

        extract($params, EXTR_IF_EXISTS);

        if ($teacher_context) {
            $lis_person_contact_email_primary = self::loadParam('custom_teacher_email', 'teacher@school.org');
            $roles = 'Instructor';
        } else {
            $lis_person_contact_email_primary = self::loadParam('custom_student_email', 'student@school.org');
            $roles = 'Learner';
        }

        $form_params = [
            'custom_basic_link_url'            => self::loadParam('custom_basic_linkurl', 'http://atd.v.com/master/rest_server.php/Lti/Context'),
            'custom_debug'                     => self::loadParam('custom_debug', '1'),
            'custom_deep_link_url'             => self::loadParam('custom_deep_link_url', 'http://atd.v.com/master/rest_server.php/Lti/Assessment'),
            'custom_teacher_email'             => self::loadParam('custom_teacher_email', 'teacher@school.org'),
            'custom_sso_url'                   => self::loadParam('custom_sso_url', 'http://atd.v.com/master/rest_server.php/Lti/SSO'),
            'custom_student_email'             => self::loadParam('custom_student_email', 'student@school.org'),
            'ext_content_return_types'         => self::loadParam('ext_content_return_types', 'lti_launch_url'),
            'ext_content_return_url'           => self::loadParam('ext_content_return_url', 'http://localhost:8081/deep_link_return.php'),
            'lis_person_contact_email_primary' => $lis_person_contact_email_primary,
            'lis_outcome_service_url'          => self::loadParam('lis_outcome_service_url', 'http://localhost:8081/score_add.php'),
            'lis_result_sourcedid'             => self::loadParam('lis_result_sourcedid', 1),
            'lti_message_type'                 => self::loadParam('lti_message_type', 'basic-lti-launch-request'),
            'lti_version'                      => self::loadParam('lti_version', 'LTI-1p0'),
            'resource_link_id'                 => self::loadParam('resource_link_id', 1),
            'resource_link_title'              => self::loadParam('resource_link_title', 'Resource Link Title'),
            'roles'                            => $roles,
            'oauth_consumer_key'               => self::loadParam('oauth_consumer_key'),
            'oauth_consumer_secret'            => self::loadParam('oauth_consumer_secret'),
            'submit_lti_launch'                => 'LTI Launch',
            
        ];

        // update session
        foreach ($form_params as $key => $value) {
            $_SESSION[$key] = $value;
        }

        return $form_params;
    }

    /**
     * Simpler loader method
     */
    public static function loadParam($key = '', $default = '')
    {
        if (!$key) {
            return null;
        }

        $value = $default;

        if (array_key_exists($key, $_SESSION)) {
            $value = $_SESSION[$key];
        }

        if (array_key_exists($key, $_POST)) {
            $value = $_POST[$key];
        }

        return $value;
    }

    /**
     *
     */
    public static function loadClient($params = [])
    {
        $consumer = new StdClass();
        $consumer->key256 = $params['oauth_consumer_key'];
        $consumer->secret = $params['oauth_consumer_secret'];

        $client = new Client($consumer);

        return $client;
    }
}
