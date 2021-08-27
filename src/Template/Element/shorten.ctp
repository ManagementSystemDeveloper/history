<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?=
$this->Form->create(null, [
    'url' => ['controller' => 'Links', 'action' => 'shorten', 'prefix' => false],
    'id' => 'shorten',
    'class' => 'form-inline'
]);

?>

<?php
$this->Form->setTemplates([
    'inputContainer' => '{{content}}',
    'error' => '{{content}}',
    'inputContainerError' => '{{content}}'
]);

?>
<div class="form-group">
    <?=
    $this->Form->control('url', [
        'label' => false,
        'type' => 'text',
        'placeholder' => __('Your URL Here'),
        'required' => 'required',
        'class' => 'form-control input-lg'
    ]);

    ?>

    <?php
    $type = get_option('anonymous_default_redirect', 1);

    if (null !== $this->request->getSession()->read('Auth.User.id')) {
        $type = $this->request->getSession()->read('Auth.User.redirect_type');
    }
    ?>

    <?= $this->Form->hidden('type', ['value' => $type]); ?>

    <?= $this->Form->button($this->Assets->image('Right-Arrow.png'), [
        'class' => 'btn-captcha',
        'id' => 'invisibleCaptchaShort'
    ]); ?>
</div>

<?php if (!$this->request->getSession()->read('Auth.User.id') &&
    (bool)get_option('enable_captcha_shortlink_anonymous', false) && isset_captcha()
) : ?>
    <div class="form-group captcha" style="display: none">
        <div id="captchaShort" style="display: inline-block;"></div>
    </div>
    <?php
    $this->Form->unlockField('g-recaptcha-response');
    $this->Form->unlockField('adcopy_challenge');
    $this->Form->unlockField('adcopy_response');
    ?>
<?php endif; ?>

<?= $this->Form->end(); ?>

<div class="shorten add-link-result"></div>
