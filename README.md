# Easy Admin Drag 'n Drop Sort
This bundle aims to add drag 'n drop sorting to Easy Admin list views, utilizing the sortable doctrine extensions.

## Getting Started
### Installation
Because this bundle is still under development and yet lacks testing, it is not on Packagist at this time, so you'll need to add the repository to your composer.json file:
```
// composer.json
{
"repositories": [
        {
            "url": "git@gitlab.com:devmax-bundles/easyadmin-dragndrop-sort.git",
            "type": "vcs"
        }
    ]
}
```

Next install the bundle via composer:

```
composer require devmax/easyadmin-dragndrop-sort
```

Install Assets
```
bin/console assets:install --symlink
```

### Configure Gedmo Extensions
You'll need to set up the [Gedmo Doctrine Extension](https://github.com/Atlantic18/DoctrineExtensions/blob/master/doc/symfony2.md) for Sortable.

### Add Routing
```
easyadmin_dragndrop_sort:
  resource: "@EasyadminDragndropSortBundle/Controller"
  type:     annotation
  prefix: /manage
```

### Add Template To EasyAdmin Entity
```
easy_admin:
  entities:
    Entity:
      templates:
        list: '@EasyadminDragndropSort/sortable_list.html.twig'
```
### Javascript and CSS
Ensure that the JS and CSS files are inlcuded in your template via your EasyAdmin Config:
```
//config/packages/easy_admin.yml
easy_admin:
  design:
      form_theme:
          - '@EasyAdmin/form/bootstrap_4.html.twig'
      assets:
          css:
              - '/bundles/easyadmindragndropsort/stylesheets/easyadmin-dragndrop-sort.css'
          js:
              - '/bundles/easyadmindragndropsort/javascripts/easyadmin-dragndrop-sort.js'
```

### Configure your Entities
All entities should have a `$position` property which is used as the primary sort method.  This property is annotated as a Gedmo SortablePosition property.
```
<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

class Page
{
    ...

    /**
     * @var integer $position
     *
     * @Gedmo\SortablePosition()
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @return int
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }
    /**
     * @param int $position
     */
    public function setPosition(?int $position)
    {
        $this->position = $position;
    }
}
```

#### To Do
- Set up a flex recipe that will automatically configure the bundle, add routes, add to the kernel and install assets.
- Extend the configuration to be able to specify which Entity's list views have this functionality.
- Explore better integration into the Easy Admin bundle by way of extension.
- Make the admin prefix more dynamic (currently set to "manage")
- Make the fully qualified class name in the JS more dynamic (currently "App\Entity\{Entity}")
- Test with mobile views
- Integrate testing
- Docs
