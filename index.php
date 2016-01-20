<?php
$pattern = "/^(\/admin)(\/)*((.)*)*/";
if (preg_match($pattern, $_SERVER["REQUEST_URI"])) {
    $templateDir = getcwd() . '/app/backend/views';

    // Cau hinh Twig de load view cho phan fontend , tao thu muc cache view
    $loader = new Twig_Loader_Filesystem($templateDir);
    $twig = new Twig_Environment ($loader, array('debug' => true));
    $twig->getExtension(new MyTwig());

    include_once(getcwd() . '/app/backend/router.php');
} else {
    include(getcwd() . '/app/frontend/index.php');
}
?>
