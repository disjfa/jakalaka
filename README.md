Glynn-admin-symfony
===================

Symfony implementation for the [glynn-admin](https://github.com/disjfa/glynn-admin) template.

# Instalation

```
git clone git@github.com:disjfa/glynn-admin-symfony.git
composer install
```

# Setup the easy way
The base package uses a sqlite database, located in ```%kernel.root_dir%/glynn-admin.db3```.
So the easy way, on the commandline:
```
./bin/console doctrine:database:create
./bin/console doctrine:schema:update --force
./bin/console server:start
```
And visit [localhost:8000](http://localhost:8000/)

# Bundles i used:

[FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle) for the users

[KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle) for the menu

[GravatarBundle](https://github.com/henrikbjorn/GravatarBundle) for the user icon

# Extend

#### Creating menu items:
```
app_bundle.configure_menu_listener:
    class: AppBundle\Menu\ConfigureMenuListener
    tags:
      - { name: 'kernel.event_listener', event: 'glynn_admin.menu_configure', method: 'onMenuConfigure' }
```
[example](https://github.com/disjfa/glynn-admin-symfony/blob/master/src/GlyynnAdminBundle/Menu/ConfigureMenuListener.php)

For more information you can check the knp menu bundle

#### Adding dashboard items:
```
app_bundle.dashboard_item_listener:
    class: AppBundle\Dashboard\DashboardExample
    tags:
      - { name: 'kernel.event_listener', event: 'glynn_admin.dashboard_items', method: 'get' }
```
[example](https://github.com/disjfa/glynn-admin-symfony/blob/master/src/GlyynnAdminBundle/Dashboard/DashboardExample.php)

Just add a rendered template in the items.

#### More

Just add more bundles and extend the template as you wish, and enjoy.