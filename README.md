# Glamanate.com

This is the repository and CI/CD for my personal site [glamanate.com](glamanate.com).

It's also here to show a reference to some tricks I had to do for migrating my entire site from Drupal 7 to Drupal 8 
fairless seamlessly (aside from adding missing text filters.)

I have been randomly testing this since 8.1. The port was much more seamless by 8.3.

## Drupal 7 -> Drupal 8 Migration

Here's some info on how I tested and worked on my migration.

* I used Docker for easy teardown and set up for importing legacy database.
* I placed my Drupal 7 database into the `db-seeds` directory so it'd import on database container creation
* I patched Drupal to allow profiles to import config so I could preserve manually migrated Views and theme tweaks.
* The `glamanate_filters` module provides my shiv for Drupal 7 based filters
* Running `scripts/migrate.sh` ran the whole thing!


### Notes

Here's some notes from along the way.

#### Database import

I had to alter my database dump from Drupal 7 to include a `CREATE DATABASE` statement.

```sql
DROP DATABASE IF EXISTS `glamanate_d7`;
CREATE DATABASE `glamanate_d7`;
USE `glamanate_d7`;
```
