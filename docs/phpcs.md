# PHPCS

## Preparations

At first, you must set up the [Magento 2 project](./magento.md).

And add current module into this project.

## How to run

From the project root directory (where you installed Magento 2 project) you can run the command:

```bash
./vendor/bin/phpcs --standard=Magento2 path/to/current/module/in/vendor/folder
```

The command use default Magento 2 ruleset for PHPCS.

How to add Magento 2 standards [read here](https://courses.m.academy/courses/set-up-magento-2-development-environment-docker/lectures/36974633)

## Requirements

In the composer.json you can find all requirements in `require-dev` section.

Also, the Magento 2 version specified in [README.md](../README.md#Magento-2-version).
