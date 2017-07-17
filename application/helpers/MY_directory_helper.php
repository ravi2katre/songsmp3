<?php

function mkdir_if_not_exist($path, $mode = 0777, $recursive = TRUE)
{
	if (!is_dir($path))
	{
		// Reference: http://stackoverflow.com/questions/3997641/why-cant-php-create-a-directory-with-777-permissions
		$oldmask = umask(0);
		mkdir($path, $mode, $recursive);
		umask($oldmask);
	}
}

// Function to remove folders and files
function rrmdir($dir) {
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file)
            if ($file != "." && $file != "..") rrmdir("$dir/$file");
        rmdir($dir);
    }
    else if (file_exists($dir)) unlink($dir);

}

// Function to Copy folders and files
function rcopy($src, $dst) {

    if (is_dir ( $src )) {
        mkdir_if_not_exist ( $dst );
        $files = scandir ( $src );
        foreach ( $files as $file )
            if ($file != "." && $file != "..")
                rcopy ( "$src/$file", "$dst/$file" );
    } else if (file_exists ( $src ))
        copy ( $src, $dst );
}

if ( ! function_exists('glob_recursive')) {

// Does not support flag GLOB_BRACE
    function glob_recursive($pattern, $flags = 0) {
        $root = $pattern;
        $iter = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST,
            RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
        );

        $paths = array($root);
        foreach ($iter as $path => $dir) {
            if ($dir->isDir()) {
                $paths[] = $path;
            }
        }

        return $paths;
    }

}