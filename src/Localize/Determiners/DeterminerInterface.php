<?php

namespace BenConstable\Localize\Determiners;

use Illuminate\Http\Request;

/**
 * A determiner is used to fetch the current locale using information
 * from the request.
 */
interface DeterminerInterface
{
    /**
     * Use the given request to determine what the application locale should be.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string                            Locale name (en, es etc)
     */
    public function determineLocale(Request $request);

    /**
     * Set the fallback locale for this determiner.
     *
     * @param  string  $locale
     * @return \BenConstable\Localize\Determiners\DeterminerInterface
     */
    public function setFallback($locale);
}
