<?php

namespace BenConstable\Localize\Determiners;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * This determiner chains together other determiners and pulls the locale from
 * the first one that provides a match.
 */
class Stack extends Determiner
{
    /**
     * Underlying collection of determiners.
     *
     * @var  \Illuminate\Support\Collection
     */
    private $determiners;

    /**
     * Constructor.
     *
     * @param  \Illuminate\Support\Collection  $determiners
     * @return  void
     */
    public function __construct(Collection $determiners)
    {
        $this->determiners = $determiners;
    }

    /**
     * Determine the locale from the underlying determiner stack.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  string|null
     */
    public function determineLocale(Request $request)
    {
        return $this->determiners
            ->map(function ($determiner) use ($request) {
                return $determiner->determineLocale($request);
            })
            ->first(function ($locale, $index) {
                return $locale !== null;
            }, $this->fallback);
    }

    /**
     * Get the underlying determiner stack.
     *
     * @return  \Illuminate\Support\Collection
     */
    public function getDeterminers()
    {
        return $this->determiners;
    }
}
