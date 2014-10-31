<?php namespace Mrdejong\Themer\Finder;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\FileViewFinder;

/**
 * Reader: Why did you create this file, while you could just use FileViewFinder
 * Code: Well I don't know what the feature holds for me.
 * Reader: Nobody knows there feature, so why?
 * Code: Well the author is planning to do more then only setting different paths.
 *       For this reason he has decided to already create this object so it he doesn't have to do this later.
 * Reader: Still sick you can do this when needed...
 * Code: Don't complain to me, but to my author!
 * Reader: ...
 */
class ThemeViewFinder extends FileViewFinder {
    
}
