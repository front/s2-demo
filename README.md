How to do it :)
===============

1. Unzip file + create vhost + change `.htaccess`
2. Create bundle:

    php app/console generate:bundle --namespace=Fk/StrategyMakerBundle

3. Create data models

    php app/console doctrine:generate:entity --entity="FkStrategyMakerBundle:Strategy" --fields="title:string(100) vision:string(255)"

    php app/console doctrine:generate:entity --entity="FkStrategyMakerBundle:Goal" --fields="title:string(100)"

    php app/console doctrine:generate:entity --entity="FkStrategyMakerBundle:Action" --fields="title:string(100) challenge:text start_date:datetime"

4. Define database parameters on parameters.yml and create database:

    php app/console doctrine:database:create

    php app/console doctrine:schema:update --force

5. Add relationships mappings on entities files, update entities getters and setters and update database:

    php app/console doctrine:generate:entities Fk

    php app/console doctrine:schema:update --force

6. Add `use Doctrine\Common\Collections\ArrayCollection;` on entity files
7. Create CRUD views:

    php app/console doctrine:generate:crud --entity=FkStrategyMakerBundle:Strategy --route-prefix=strategy --with-write

    php app/console doctrine:generate:crud --entity=FkStrategyMakerBundle:Goal --route-prefix=goal --with-write

    php app/console doctrine:generate:crud --entity=FkStrategyMakerBundle:Action --route-prefix=action --with-write

	Also a quick fix: Added `__toString()` function to models - necessary when displaying relations
8. Add Twitter Bootstrap and copy assets to public dir:

    php app/console assets:install web

9. Do the web developer magic!