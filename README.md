Plainbook CMS
=============

*A place for writers*

## The CMS
This is a **simple *markdown* flat-file CMS written in PHP**. 
Yes, I know: another CMS, the same PHP technology, markdown? what a news!, bla bla bla...
I perfectly know, but I chose to develop it for two reasons: 

* I wanted something simple and powerful at the same time, giving designers the possibility to do almost everything they want using simple PHP, and allowing writers to compose freely and manage pages as simple items. No logins, no strange codes, no learning curves: just a folder and some markdown files;
* **I do love CMSs, I'm addicted to them**. It's a passion I had since my first `html` site, in far 2006. I really wanted one created by me, based on my needs and designed taking care of the experience achieved during these years as a web designer.


## How it works
Copy the project in your server root folder, edit the `pb-config.php` with your specific configuration and put some files inside the `pb-contents` folder. Read below for further informations.


### .md files
Whenever you create a new file inside `pb-contents`, it potentially becomes a page. You can create folders too, and each of them must contain at least an `index.md` file as root. File system structure under `pb-contents` reflects the site map.
**Exceptions**: every file becomes a page, except for those in which the name starts with:

* `_` hidden file, publicly reachable by url and by API `$data->get(path)` specific method;
* `#` invisible file, not publicly reachable but readable using API `$data->get(path)` specific method. 
 
You can change the *extension* of your files (i.e. from `.md` to `.txt`) inside the `pb-config.php` file, setting `pb.contents.extension`.

 
#### Syntax and meta fields
You can write markdown files using *markdown* and *markdown extra* syntax (you don't say?). Furthermore, you can define special **meta fields** using this syntax (each one in a new line):
	
	@meta_field1_name: value of your first meta field
	@meta_field2_name: value, of, your, second, meta, field
	
	# Your content
	...

What is a *meta field*? Whatever you want. Use it as you wish: add a title, a menu label and/or a description; sort your pages; add tags; define the theme template you want to use; etc.

These *meta fields* are completely customisable and can be accessed using `$data->meta->field_name` API inside the theme. Only the `@template: template_name` *meta field* is "taken", but you can change the reserved keyword inside `pb-config.php` depending on your needs: style, language, or whatever you want.


### Themes
How about themes? Nothing simpler: create a folder inside `pb-themes`, add a `default.php` file (the only one that is required, used as *default* template and fallback template) inside of it, edit the html and integrate the APIs of *plainbook* to retrieve the page data. Change the value of the `pb.theme.name` setting inside the `pb-config.php` file with the name of your new theme folder, and *voilà*! You're ready to run!

### APIs
Let's take a look at the engine.
When you want to create a new theme, you can access 3 objects:
* `$site` containing the main global informations;
* `$data` containing the whole site data (pages);
* `$theme` containing the methods to create a new theme and manage partials files.
 

#### $site
* `$site->name`: returns the name of your site;
* `$site->url`: returns the base url of your site;
* `$site->config`: returns the `$config` array with the settings of your site. Take a look at `pb-config.php` and `pb-core/pb-init.php` to know the properties it contains.


#### $data
* `$data->current`: returns the `PlainbookInfos` object relative to the current file, addressed by the url;
* `$data->next`: returns the `PlainbookInfos` object relative to the next file, depending on the sorting order specified inside the `pb-config.php`;
* `$data->prev`: returns the `PlainbookInfos` object relative to the previous file, depending on the sorting order specified inside the `pb-config.php`;
* `$data->get(path)` returns the `PlainbookInfos` object addressed by the relative path passed to the method; 
* `$data->around(offset [, query])`: returns the `PlainbookInfos` object "located" at a specific distance (offset) from the current one; positive offset is for searching in next files, negative number is for searching in previous file, depending on the sorting order specified inside the `pb-config.php` or by the `query` array passed to the method (see below);
* `$data->all([query])`: returns a `PlainbookInfos` array (all files), optionally filtered by a `query` array:
	* `root`: root path for filtering: it returns all the files under this path (default: "/", site root);
	* `deep`: number of levels the tree must be navigate through, starting from root (default: "0", all levels);
	* `orderBy`: meta field used to sort the files (default: configuration settings - alphabetically by path);
	* `orderAsc`: sorting direction (default: configuration settings - ASC);
	* `exlude`: array of strings; if one of them is found inside the page path, the page is excluded (default: empty array).
 
Now let's take a look inside the `PlainbookInfos` class, assuming that you will use `$data->current` object:

* `$data->current->exists`: returns if this file exists;
* `$data->current->content`: returns a `PlainbookContent` object:
	* `$data->current->content`: if printed, returns the parsed content of the file;
	* `$data->current->content->raw`: returns the raw content of the file;
	* `$data->current->content->execerpt`: returns the excerpt of the content, depending on the length specified by the setting `pb.contents.excerpt_length` inside the `pb-confing.php` file;
* `$data->current->file`: returns the file absolute path;
* `$data->current->url`: returns the file url;
* `$data->current->path`: returns the file relative path;
* `$data->current->level`: returns the level (the distance from the root);
* `$data->current->isCurrent`: returns if the current url addresses this file;
* `$data->current->isParent`: returns if the this file is parent or ancestor of the current one;
* `$data->current->isFront`: returns if this file is the front page one;
* `$data->current->meta`: returns an object containings `PlainbookMeta` instances:
	* `$data->current->meta->field_name`: returns the content of the *meta field*;
	* `$data->current->meta->field_name->toList([separator])`: returns an array of string, splitter using a separator (default is ",") and trimmed;
	* `$data->current->meta->field_name->toJSON()`: returns an object or an array, decoded from string value JSON representation; the value must be a valid JSON string, or the method will returns `NULL`;
* `$data->current->tags`: returns the tags;
* `$data->current->template`: returns the template name for this file;


#### $theme
* `$theme->name`: returns the name of the current theme (folder name);
* `$theme->url`: returns the url of the current theme root folder;
* `$theme->dir`: returns the absolute path of the current theme root folder;
* `$theme->render(path[, httpcode])`: print to the response a specific partial file (i.e. including a `header.php`), addressed by its relative (to the theme root folder) path; `httpcode` is optional and represents the `http` code associated to the response (default is *200*). 


## Changelog
* **1.1.0 beta**: updated default theme, documentation
* 1.0.0 alpha: routing, sorting system, tags, file visibility, bugfixes
* 0.9 alpha: main core of the cms
 

## Requirements
You only need a server with PHP 5.3+. Nothing more.