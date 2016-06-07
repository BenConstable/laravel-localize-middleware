<?php

namespace BenConstable\Localize\Determiners;

/**
 * Base determiner class that provides some common methods.
 */
abstract class Determiner implements DeterminerInterface
{
    /**
     * The fallback locale to use if determiner can't determine a locale.
     *
     * @var  string|null
     */
    protected $fallback = null;

    /**
     * {@inheritdoc}
     */
    public function setFallback($fallback)
    {
        $this->fallback = $fallback;

        return $this;
    }
}
