<?php

class Display
{
    public $content = [];

    /**
     *
     */
    public function add($var)
    {
        $this->content[] = $var;
    }

    /**
     *
     */
    public function toHtml()
    {
        $html = <<< HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<a href="index.php">Config</a> | 
<a href="teacher_deep_link.php">Teacher Deep Link</a> | 
<a href="student_deep_link.php">Student Deep Link</a> |
<a href="sso.php">SSO Launch</a> |
<a href="teacher_basic_link.php">Teacher Basic Link</a> |
<a href="student_basic_link.php">Student Basic Link</a> |
<a href="score_view.php">Score Log</a>
<hr>

HTML;
       
    $html .= implode("\n", $this->content);
    $html .= <<< HTML

</body>
</html>
HTML;
        return $html;
    }
}
