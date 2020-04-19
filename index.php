<?php
$path = explode ('\\', __DIR__);
$toolsRootDirectory = end($path);
$config = '<?php ' . "\n"
        . 'namespace tools;' . "\n\n"
        . 'class config' . "\n"
        . '{' . "\n"
        . '    const TOOLS_ROOT_DIRECTORY = \'' . $toolsRootDirectory . '\';' . "\n"
        . '}' . "\n";
file_put_contents('config.php', $config);

header('Location: tools');
exit();
