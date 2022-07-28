<?php

namespace Modules\PageBuilder\Contracts;

/**
 * Counts the words inside your content.
 */
interface ICountsWords
{
    public function countWords(): int;
}
