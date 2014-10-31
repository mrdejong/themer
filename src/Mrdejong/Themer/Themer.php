<?php namespace Mrdejong\Themer;

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
    public function __construct($path)
    {
        $this->path = $path;
        $this->themes = $this->listThemes();
    }

    /**
     * Reader: Oke, what is this doing here.
     * Code: It is here to test things out, and get the basics working.
     * Reader: But but but...
     * Code: No buts, just ignore it for now!
     */
    public function getActiveThemeViewFolder()
    {
        return array($this->themes[$this->active] . '/views');
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
