<?php

defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Support\Facade\Url;

/** @var \Concrete\Core\Validation\CSRF\Token $token */
/** @var array $themeOptions */
/** @var string $selectedTheme */
/** @var bool $initializeHighlight */
?>

<div class="ccm-dashboard-content-inner">
    <form method="post" action="<?php echo $this->action('save'); ?>">
        <?php
        echo $token->output('a3020.ckeditor_codesnippet.settings');
        ?>

        <div class="alert alert-info">
            <p>
                <?php
                echo t('If you want to disable the CKEditor Codesnippet plugin, go to the %s page.',
                    '<a href="' . Url::to('/dashboard/system/basics/editor') . '">' . t('Rich Text Editor settings') . '</a>'
                );
                ?>
            </p>
        </div>

        <hr>

        <div class="form-group">
            <?php
            echo $form->label('theme', t('Theme'));
            echo $form->select('theme', $themeOptions, $selectedTheme);
            echo '<small class="help-block">'
                . t(
                    'See %s',
                    '<a href="https://highlightjs.org/static/demo/" target="_blank">https://highlightjs.org/static/demo/</a>'
                )
                . '</small>';
            ?>
        </div>

        <div class="form-group">
            <label class="control-label launch-tooltip"
                   title="<?php echo t('Disable this, if you want to initialize %s yourself.', t('Highlight.js')) ?>"
                   for="initializeHighlight">
                <?php
                echo $form->checkbox('initializeHighlight', 1, $initializeHighlight);
                ?>
                <?php echo t('Automatically initialize %s', t('Highlight.js')); ?>
            </label>
        </div>

        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <button class="pull-right btn btn-primary" type="submit">
                    <?php echo t('Save') ?>
                </button>
            </div>
        </div>
    </form>
</div>
