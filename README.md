# StaticSquish!

StaticSquish is a static site generator specially meant for providing a browsable interface over a directory of data.

The format of the directory of data should be relatively flexible, so new fields and ways of organising data can emerge organically (or squishily) as several people add data.

## Status

Work in Progress

## Sample data

See the demo folders.

## Installing

Get php, composer and this repository. Run

```
composer install
```

## To use

To build a site, run

```
php run/StaticSquish.php --build --site demo1 --out out --baseurl XXX
```
