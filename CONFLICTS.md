# CONFLICTS

This document explains why certain conflicts were added to `composer.json` and
references related issues.

- `lexik/jwt-authentication-bundle: ^2.18`

  After bumping to this version ApiBundle starts failing due to requesting a non-existing `api_platform.openapi.factory.legacy` service.
  As we are not using this service across the ApiBundle we added this conflict to unlock the builds, until we investigate the problem.

- `symfony/validator:5.4.25`

  This version introduced a bug, causing validation constraints to not work.
  References: https://github.com/symfony/symfony/issues/50780

- `stof/doctrine-extensions-bundle:1.8.0`

  This version introduced configuring the metadata cache for the extensions, what breaks the `Timestampable` behaviour.
  This package is not exactly the root of the problem, but it started using a bugged feature of the `gedmo/doctrine-extensions` package.

  References:

    - https://github.com/stof/StofDoctrineExtensionsBundle/issues/455
    - https://github.com/doctrine-extensions/DoctrineExtensions/issues/2600

- `api-platform/core:2.7.17`:

  This version introduced class aliases, which lead to a fatal error:
  `The autoloader expected class "ApiPlatform\Core\Bridge\Symfony\Bundle\DependencyInjection\ApiPlatformExtension" to be defined in file ".../vendor/api-platform/core/src/Core/Bridge/Symfony/Bundle/DependencyInjection/ApiPlatformExtension.php". The file was found but the class was not in it, the class name or namespace probably has a typo.`

- `twig/twig:3.9.0`:

  This version has a bug, which lead to a fatal error:
  `An exception has been thrown during the rendering of a template ("Warning: Undefined variable $blocks").`

- `behat/gherkin:^4.13.0`:

  This version moved files to flatten paths into a PSR-4 structure, which lead to a fatal error:
  `PHP Fatal error:  Uncaught Error: Failed opening required '/home/runner/work/Sylius/Sylius/vendor/behat/gherkin/src/../../../i18n.php' (include_path='.:/usr/share/php') in /home/runner/work/Sylius/Sylius/vendor/behat/gherkin/src/Keywords/CachedArrayKeywords.php:34`

- `symfony/serializer:^6.4.23`:

  This version introduces a change in method signature that is not compatible with API Platform 2.7 and leads to a fatal error:
  `PHP Fatal error:  Declaration of ApiPlatform\Serializer\AbstractItemNormalizer::getAllowedAttributes($classOrObject, array $context, $attributesAsString = false) must be compatible with Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer::getAllowedAttributes(object|string $classOrObject, array $context, bool $attributesAsString = false): array|bool in /home/runner/work/Sylius/Sylius/vendor/api-platform/core/src/Serializer/AbstractItemNormalizer.php on line 493`
