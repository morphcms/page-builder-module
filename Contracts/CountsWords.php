<?php

namespace Modules\PageBuilder\Contracts;

/**
 * Counts the words inside your content.
 */
interface CountsWords
{
    public function countWords(): int;
}
