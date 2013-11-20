<?php
header('content-type:text/htm;charset=utf8');

require('Grep.class.php');

$content = file_get_contents('http://www.test.com/');

$obj = new Grep();
$obj->set($content);

$url = $obj->get('url', 0);
$email = $obj->get('email', 1);
$image = $obj->get('image', 1);

print_r($url);
print_r($email);
print_r($image);

$url_new = $obj->replace('url', 'replace_url');
echo $url_new;

function replace_url($matches){
    return isset($matches[1])? '[url]'.$matches[1].'[/url]' : '';
}
?>