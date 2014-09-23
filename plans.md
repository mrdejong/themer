## Basic idea

The idea for themer is is to have a simple way of adding themes to laravel. This in such a way that it doesn't require a different way to present view files. You can just present a view file like you always do in laravel, themer adds the theme's view folder on top of the paths stack within the laravel view finder therefor you don't have to do anything but create a theme in other to show a theme's view file.

I also would like to have a very very very easy way to serve up assets, but also to integrate bower to get frameworks like jQuery and Bootstrap. The reason there for is is that you as a developer/designer only has to invest time into creating a theme then getting all it's depencies (yes it would require a bit of configuration).

## Why this file

This file is just to get some ideas that I have on my mind and lay them out in here. It is nothing important for you.

## Goal for the 1.0-stable release

- [x] Creation of themes through commands
- [x] Providing basic options to find themes and view files
- [ ] Provide a way to activate and deactivate themes
- [ ] If there is no activated theme fallback to the configurated one
- [ ] If there is no configurated default theme fallback to laravel views system.
- [ ] If an activated theme doesn't exist, fallback to the configurated one


## Theme folder structure

- laravel root
    + app/
        * themes/
            - (themename)/ 
                + views/ # All the views for your project will go in here
                + assets/ # All of your assets goes in to here
                + helpers/ # Custom helpers that your theme requires.
        * views/ # The laravel way of applying views.

I know that the folder structure of laravel will change comming the 5.0 update, really this wouldn't change the basic `themes` folder structure only it's location e.g. `root/resources/themes`

The assets will be compiled live in development mode each request.
The assets won't be compiled live in development if an configuration option is set.
The assets won't be compiled live in production, only ones if the cache is empty for the project.

## Themer class structure `Mrdejong\Themer\Themer()`

Just a basic mockup idea for this class, I want it to keep it clean and simple.

- Themer
    + get(string $name)
        * Finds the theme and puts it in a Theme wrapper class.
    + create(string $name, bool $includeOptional)
        * Creates the folder structure for the theme.
    + delete(string $name)
        * Removes a theme folder
    + active()
        * Gets the current active theme (won't work on router enabled themes)
    + activate(string $name)
        * Activates a theme, this will make a record in `app/storage/meta/themer.json`

