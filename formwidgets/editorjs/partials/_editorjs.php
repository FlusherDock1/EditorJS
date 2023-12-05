<?php if ($this->previewMode): ?>

    <div class="form-control">
        <?= $value ?>
    </div>

<?php else: ?>

    <div
        class="editorjs-wrapper"
        data-control="reazzoneditorjs"
        id="<?= $this->getId() ?>"
        data-textarea="<?= $this->getId('input') ?>"
        data-settings="<?= $settings ?>"
        data-blocks="<?= $blocks ?>"
        data-tunes="<?= $tunes ?>"
        data-inlineToolbars="<?= $inlineToolbars ?>"></div>

    <textarea
        style="display: none"
        name="<?= $name ?>"
        id="<?= $this->getId('input') ?>"><?= $value ?></textarea>

<?php endif ?>
