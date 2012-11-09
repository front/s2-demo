Steps To Build The App
======================

1. Download & Install
	Get the standard edition here: http://symfony.com/download

	Unzip file, create virtual host pointing to `/web` directory and change `.htaccess` located at `/web`:

    <IfModule mod_rewrite.c>
        Options +FollowSymlinks
        RewriteEngine On

        # Explicitly disable rewriting for front controllers
        RewriteRule ^app_dev.php - [L]
        RewriteRule ^app.php - [L]

        RewriteCond %{REQUEST_FILENAME} !-f

        # Change below before deploying to production
        #RewriteRule ^(.*)$ app.php [QSA,L]
        RewriteRule ^(.*)$ app_dev.php [QSA,L]
    </IfModule>

2. Configuration
	Check if anything's missing on apache or php by running:

	http://[symphony-local-url]/config.php

	Change database settings on `app/config/parameters.yml` or go to:

	http://[symphony-local-url]/_configurator

3. Development of StrategyMaker App
	3.1. Create bundle:

    php app/console generate:bundle --namespace=Fk/StrategyMakerBundle

	3.2. Create data models:

		php app/console doctrine:generate:entity --entity="FkStrategyMakerBundle:Strategy" --fields="title:string(100) vision:string(255)"
		php app/console doctrine:generate:entity --entity="FkStrategyMakerBundle:Goal" --fields="title:string(100)"
		php app/console doctrine:generate:entity --entity="FkStrategyMakerBundle:Action" --fields="title:string(100) challenge:text start_date:datetime"

	3.3. Define database parameters on parameters.yml and create database:

		php app/console doctrine:database:create
		php app/console doctrine:schema:update --force

	3.4. Add relationships mappings on entities classes:
		See: http://symfony.com/doc/current/book/doctrine.html#relationship-mapping-metadata

		Don't forget to place:

      use Doctrine\Common\Collections\ArrayCollection;

		on top of each entity file.

		And update entities getters and setters and update database:

      php app/console doctrine:generate:entities Fk
      php app/console doctrine:schema:update --force

	3.5. Create CRUD views & controllers for each entity:
    php app/console doctrine:generate:crud --entity=FkStrategyMakerBundle:Strategy --route-prefix=strategy --with-write
    php app/console doctrine:generate:crud --entity=FkStrategyMakerBundle:Goal --route-prefix=goal --with-write
    php app/console doctrine:generate:crud --entity=FkStrategyMakerBundle:Action --route-prefix=action --with-write

		Note: These commands also generates routing through annotation.

		Also a quick fix: Add `__toString()` function to models - necessary when displaying relations. Ex:

      public function __toString()
      {
          return $this->title;
      }

4. Templating (using Twitter Bootstrap http://twitter.github.com/bootstrap/ )
	Add the Bootstrap files on `/src/Fk/StrategyMakerBundle/Resources/public/`;
	
	Create the layout file `/src/Fk/StrategyMakerBundle/views/layout.html.twig`;
	
	Add `{% extends "FkStrategyMakerBundle::layout.html.twig" %}` on every view - could use a technique to use layout as base for every view in the bundle but some work had to be done on some controllers if the layout needs to be overrided. S2 guys said it is supposed to work like this and I agree :). In PHP, for example we don't have "magic" extending :);

	Note: The assets are placed inside the "secured" area (remember, we're pointing to `/web`) so everytime we change our assets we must execute:

		php app/console assets:install web

	This will update the assets on `/web/bundles/fkstrategymaker/`

5. Comments 
	Routing can be configured in several ways. I choosed to use annotation on controllers (mainly because it was generated by CRUD generation :) ) and it looks like this:

    /**
     * Lists all Goal entities.
     *
     * @Route("/", name="goal")
     * @Template()
     */

     but for larger applications with lots of controllers this could be a bit problematic to manage despite the fact we can access all routes configuration on the profiler. We can use a mix of annotation and configuration files (yml, xml or php).

     The standard distribution comes with a demo bundle and several routes configured. So it can be necessary to edit the `/app/config/routing.yml` or `routing_dev.yml`.

     Generating the bundle will add a routing setting on `routing.yml`.