<?php

namespace App\MlyExtends;

use App\MlyExtends\Traits\HasBlockCategory;
use Log1x\AcfComposer\Block;

abstract class MlyBlock extends Block
{
    use HasBlockCategory;

    /**
     * The block category.
     *
     * @var string
     */
    public $category = self::CATEGORY;

    /**
     * The block keywords.
     *
     * @var array
     */
    public $keywords = [];

    /**
     * The block post type allow list.
     *
     * @var array
     */
    public $post_types = [];

    /**
     * The parent block type allow list.
     *
     * @var array
     */
    public $parent = [];

    /**
     * The ancestor block type allow list.
     *
     * @var array
     */
    public $ancestor = [];

    /**
     * The default block mode.
     *
     * @var string
     */
    public $mode = 'edit';

    /**
     * The default block alignment.
     *
     * @var string
     */
    public $align = '';

    /**
     * The default block text alignment.
     *
     * @var string
     */
    public $align_text = '';

    /**
     * The default block content alignment.
     *
     * @var string
     */
    public $align_content = '';

    /**
     * The supported block features.
     *
     * @var array
     */
    public $supports = [
        'align' => true,
        'align_text' => false,
        'align_content' => false,
        'full_height' => false,
        'anchor' => false,
        'mode' => false,
        'multiple' => true,
        'jsx' => true,
        'color' => [
            'background' => true,
            'text' => true,
            'gradient' => true,
        ],
    ];

    /**
     * The block styles.
     *
     * @var array
     */
    public $styles = ['light', 'dark'];

    protected function get_field_with_context($selector)
    {
        $field = null;
        $from_context = get_field('from_context');

        if (is_archive()) {
            $group_prefix_name = get_field('group_prefix_name');
            $group_prefix = $group_prefix_name ? get_field($group_prefix_name, 'product_cat_' . get_queried_object_id()) : null;

            $field = $group_prefix ? $group_prefix[$selector] : get_field($selector, 'product_cat_' . get_queried_object_id());
        } elseif (isset($from_context) && isset($this->context['postId'])) {
            $group_prefix_name = get_field('group_prefix_name');
            $group_prefix = $group_prefix_name ? get_field($group_prefix_name, $this->context['postId']) : null;

            $field = $group_prefix ? $group_prefix[$selector] : get_field($selector, $this->context['postId']);

            if (empty($field) && isset($group_prefix['use_default_value']) && $group_prefix['use_default_value'] == 'true') {
                if ($selector === 'show_block' && isset($group_prefix['show_block'])) {
                    $field = $group_prefix['show_block'];
                } else {
                    $field = get_field($selector);
                }
            }
        }

        if (!isset($field)) {
            return get_field($selector);
        }

        if ($field === 'false') {
            $field = false;
        }
        if ($field === 'true') {
            $field = true;
        }

        return $field;
    }
}
