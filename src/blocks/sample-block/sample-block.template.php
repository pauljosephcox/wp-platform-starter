<?php

/**
 * Testimonial Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Load values and assign defaults.
$title = get_field('sample_block_title') ?: 'Your testimonial here...';
?>
<div id="<?php echo \ASOTA\SampleBlock::id($block); ?>" class="<?php echo \ASOTA\SampleBlock::classes($block);?>">
    <blockquote class="testimonial-blockquote">
       <?php echo $title; ?>
       <h1>OUR CUSTOM BLOCK</h1>
    </blockquote>
    <style type="text/css">
        #<?php echo $id; ?> {
            /* Block CSS Here */
        }
    </style>
</div>