<?php namespace Mrdejong\Themer;

use Mrdejong\Themer\Model\Theme as ThemeModel;

abstract class Theme {
    /**
     * A human readable name of the theme.
     *
     * @var string
     */
    public $name = null;

    /**
     * The directory name of the theme, this is populated automatically.
     *
     * @var string
     */
    public $folder_name;

    /**
     * The location to the theme. This is populated automatically.
     *
     * @var string
     */
    public $location;

    /**
     * @deprecated
     * @var string?
     */
    protected $parent = null;

    /**
     * Description of the theme.
     *
     * @var string
     */
    protected $description = null;

    /**
     * Is the theme in development?
     *
     * @var bool
     */
    protected $inDevelopment = false;

    /**
     * Author details
     *
     * @var array|null
     */
    protected $author = null;

    /**
     * Initialize some initial data
     */
    public function __construct()
    {
        $reflection = new \ReflectionClass($this);
        $directory = dirname($reflection->getFileName());

        $this->folder_name = basename($directory);
        $this->location = realpath($directory);
    }

    /**
     * Installs the theme to the database
     *
     * @return void
     */
    public function install()
    {
        if (!$this->isInstalled())
        {
            $theme = new ThemeModel(array(
                'name'        => $this->name ?: ucfirst($this->folder_name),
                'folder_name' => $this->folder_name,
                'description' => $this->description ?: "";
            ));

            $theme->development = $this->inDevelopment;

            if ($this->author)
            {
                $theme->author_name = $this->author['name'];
                $theme->author_website = $this->author['url'];
                $theme->author_support_email = $this->author['email'];
                $theme->author_github = $this->author['github'];
            }

            $theme->save();
        }
    }

    /**
     * Check if the database knows about the theme
     *
     * @return bool true when installed
     */
    public function isInstalled()
    {
        $theme = ThemeModel::where('name', '=', $this->name)->first();

        if ($theme)
        {
            return true;
        }

        return false;
    }

    /**
     * Boot the theme, this is called before response.
     *
     * @return void
     */
    abstract public function boot();

    /**
     * Register any view composers needed for the view, if you need to register more
     * this is the place to do it.
     *
     * It is called round and about the same time as {@see boot}
     *
     * @return void
     */
    abstract public function register();
}
