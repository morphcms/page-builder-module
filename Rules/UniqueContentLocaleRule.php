<?php

namespace Modules\PageBuilder\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\PageBuilder\Models\Content;

class UniqueContentLocaleRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(protected Content $model)
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if($this->model->exists && $value === $this->model->locale){
            return true;
        }

        return Content::query()
            ->where([
                'contentable_id' => $this->model->contentable_id,
                'contentable_type' => $this->model->contentable_type,
                'locale' => $value,
            ])
            ->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute already exists for this locale.';
    }
}
