<?php

namespace App\MlyExtends;

class MlyBlockWithTitle extends MlyBlock
{
    public const MAIN_TITLE_TITLE = 'main-title paragraph-title';
    public const SUB_TITLE_TITLE = 'sub-title paragraph-sub-title';

    protected function getTitle(): string
    {
        $title = $this->get_field_with_context('main_title');
        $hTag = $this->get_field_with_context('main_title_tag');

        if (!empty($title) && !empty($hTag)) {
            return sprintf('<%1$s class="%2$s"> %3$s </%1$s>', $hTag, self::MAIN_TITLE_TITLE, $title);
        }

        return '';
    }

    protected function getSubTitle(): string
    {
        $title = $this->get_field_with_context('sub_title');
        $hTag = $this->get_field_with_context('sub_title_tag');

        if (!empty($title) && !empty($hTag)) {
            return sprintf('<%1$s class="%2$s"> %3$s </%1$s>', $hTag, self::SUB_TITLE_TITLE, $title);
        }

        return '';
    }

    protected function getAlignmentClass(): string
    {
        return match ($this->get_field_with_context('btn_alignment')) {
            'side' => '',
            default => 'text-center',
        };
    }
    /**
     * @inheritDoc
     */
    public function with()
    {
        // TODO: Implement with() method.
    }

    /**
     * @inheritDoc
     */
    public function fields()
    {
        // TODO: Implement fields() method.
    }
}
