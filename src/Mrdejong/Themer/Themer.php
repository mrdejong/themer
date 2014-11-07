<?php namespace Mrdejong\Themer;

use Mrdejong\Themer\Model\ThemerActiveList;
use Illuminate\Foundation\Application;

class Themer {
    /**
     * Contains the path to the themes folder.
     *
     * @var string
     */
    private $path;

    /**
     * Reader: Why is this declared?
     * Code: The themes variable is declared to keep an list of all the themes
     *       installed in the themes folder.
     *
     * @var array
     */
    private $themes;

    /**
     * Laravel Application
     *
     * @var Illuminate\Foundation\Application
     */
    private $app;

    /**
     * Reader: Shouldn't this be an array?
     * Code: Yes, but for now it is a string.
     * Reader: Uhm why...?
     * Code: Read the doc over at getActiveThemeViewFolde method.
     * Reader: In this class?
     * Code: Did I provide you with an other class name?
     * Reader: No!
     * Code: Then where is it?
     * Reader: Here...
     * Code: Good kid!
     *
     * @var string
     */
    private $active = 'default';

    /**
     * Declare important information
     *
     * @param string $path The location the themes folder
     */
    public function __construct(Application $app, $path)
    {
        $this->path = $path;
        $this->themes = $this->listThemes();
        $this->app = $app;
    }

    public function initiateOrGet($theme)
    {
        if (!isset($this->app['theme.' . $theme]))
        {
            require_once $this->themes[$theme] . '/theme.php';

            $class = ucfirst($theme) . 'Theme';

            $instance = new $class;

            $this->app->instance('theme' . $theme, $instance);
        }

        return $this->app['theme.' . $theme];
    }

    /**
     * Reader: Oke, what is this doing here.
     * Code: It is here to test things out, and get the basics working.
     * Reader: But but but...
     * Code: No buts, just ignore it for now!
     *
     * @ignore
     */
    public function getActiveThemeViewFolder()
    {
        return array($this->themes[$this->active] . '/views');
    }

    /**
     * This function will install the theme to the database.
     * If it is installed already it'll return false.
     *
     * @param  string|int  $theme  The name or id of the theme.
     * @return bool        true on success, false on fail
     */
    public function install($theme)
    {
        if (is_int($theme))
        {
            // we got an id value, this means we have to use the database
            // in other to get the theme it self.
            //
        }

        // Lets check on the existance of the theme.
        // If it doesn't exist throw an exception!
        if (!isset($this->themes[$theme]))
        {
            // @todo Replace this exception with its own.
            throw new \Exception("ThemeNotFound");
        }

        $instance = $this->initiateOrGet($theme);

        return $instance->install(); // This method will directly
    }

    /**
     * @ignore
     */
    public function activate($name)
    {
        $latest = ThemerActiveList::find(ThemerActiveList::max('order'));

        // dd($latest);

        $new = new ThemerActiveList();
        $new->name = $name;

        if ($latest)
        {
            $new->order = $latest->order + 1;
        }
        else
        {
            $new->order = 1;
        }
    }

    /**
     * Glob into the themes directory and get all the themes.
     *
     * @return array
     */
    protected function listThemes()
    {
        $folders = array_map("realpath", glob($this->path . '/*', GLOB_ONLYDIR));
        $results = array();

        foreach ($folders as $folder)
        {
            $results[basename($folder)] = $folder;
        }

        return $results;
    }
}
