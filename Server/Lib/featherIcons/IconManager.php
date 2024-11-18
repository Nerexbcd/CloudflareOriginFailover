<?php

namespace Feather;

use Feather\Exception\AliasDefinedException;
use Feather\Exception\IconNotFoundException;

class IconManager
{
    use SvgAttributesTrait;

    private static $icons;

    private $aliases = [];

    public function __construct()
    {
        $this->attributes = require ($_SERVER['DOCUMENT_ROOT'] . '/Resources/php/attributes.php');

        if ($this::$icons === null) {
            $this::$icons = require ($_SERVER['DOCUMENT_ROOT'] . '/Resources/php/icons.php');
        }
    }

    public function getIconNames(): array
    {
        return \array_keys($this::$icons);
    }

    public function getIcon(string $name, array $attributes = [], ?string $altText = null): Icon
    {
        $name = $this->normalizeIconName($name);

        if (!isset($this::$icons[$name])) {
            throw new IconNotFoundException(\sprintf('Icon `%s` not found', $name));
        }

        return new Icon($name, $this::$icons[$name], \array_merge($this->attributes, $attributes), $altText);
    }

    public function addAlias(string $alias, string $iconName): self
    {
        if (isset($this->aliases[$alias])) {
            throw new AliasDefinedException(\sprintf('Alias `%s` already defined', $alias));
        }

        if (!isset($this::$icons[$iconName])) {
            throw new IconNotFoundException(\sprintf('Icon `%s` not found', $iconName));
        }

        $this->aliases[$alias] = $iconName;

        return $this;
    }

    public function getIconAliases(): array
    {
        return $this->aliases;
    }

    private function normalizeIconName(string $name): string
    {
        return $this->aliases[$name] ?? $name;
    }
}
