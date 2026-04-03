<?php

namespace App\Blocks;

use App\MlyExtends\MlyBlock;
use Log1x\AcfComposer\Builder;

class Recipe extends MlyBlock
{
    /**
     * The block slug.
     *
     * @var string
     */
    public $slug = 'recipe';

    /**
     * The block category.
     *
     * @var string
     */

    /**
     * The block icon.
     *
     * @var string|array
     */
    public $icon = 'editor-ul';

    /**
     * The block preview example data.
     *
     * @var array
     */
//    public $example = [
//        'items' => [
//            ['item' => 'Item one'],
//            ['item' => 'Item two'],
//            ['item' => 'Item three'],
//        ],
//    ];

    /**
     * The block template.
     *
     * @var array
     */
    public $template = [
//        'core/heading' => ['placeholder' => 'Hello World'],
//        'core/paragraph' => ['placeholder' => 'Welcome to the Recipe block.'],
    ];

    /**
     * The block name.
     */
    public function getName(): string
    {
        return __('Recipe', 'sage');
    }

    /**
     * The block description.
     */
    public function getDescription(): string
    {
        return __('Yummy Recipe Block', 'sage');
    }

    /**
     * Data to be passed to the block before rendering.
     */
    public function with(): array
    {
        return [
            'fields' => $this->getBlockFields(),
        ];
    }

    /**
     * The block field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('recipe');
        $fields->addText('title', [
            'label' => 'Block Title',
        ]);
        $fields->addPostObject("post_object_field", [
            'post_type' => [RECIPE_POST_TYPE],
            'label' => 'Select Recipe',
            'return_format' => 'object',
            'ui' => 1,
            'multiple' => true,

        ]);
        $banner_group = $fields->addGroup('banner_group', [
            'label' => 'Banner',
            'layout' => 'block',
        ]);
        $banner_group->addText("title", [
            'label' => 'Banner Title',
        ]);
        $banner_group->addImage("image", [
            'label' => 'Banner Image',
        ]);
        $banner_group->addLink("link", [
            'label' => 'Link',
            'return_format' => 'array',
        ]);
        return $fields->build();
    }

    /**
     * Retrieve the all content fields.
     *
     * @return array
     */
    public function getBlockFields()
    {
//        return get_field('items') ?: $this->example['items'];
        $title = get_field("title");
        $post_object_field = get_field("post_object_field");
        $post_objects = [];
        if(!empty($post_object_field)) {
            foreach ($post_object_field as $field) {

                $post_id = $field->ID;
                $image_url = esc_url(get_the_post_thumbnail_url($post_id, 'large'));
                $post_title = $field->post_title;
                $excerpt = $field->post_excerpt;
                $prep_time = esc_html(get_field("prep_time", $post_id));
                $episode_length = esc_html(get_field("episode_length", $post_id));
                $post_url = esc_url(get_permalink($post_id));
                $post_objects[] = array(
                    'id' => $post_id,
                    'title' => $post_title,
                    'excerpt' => $excerpt,
                    'prep_time' => $prep_time,
                    'episode_length' => $episode_length,
                    'post_url' => $post_url,
                    'image_url' => $image_url,
                );
            }
        }
        $banner_group = get_field("banner_group");
        return [
            "title" => $title,
            "post_object_field" => $post_objects,
            "banner_group" => $banner_group,
        ];
    }

    /**
     * Assets enqueued with 'enqueue_block_assets' when rendering the block.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/enqueueing-assets-in-the-editor/#editor-content-scripts-and-styles
     */
    public function assets(array $block): void
    {
        //
    }
}
