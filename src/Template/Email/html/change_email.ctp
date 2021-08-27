<?php
/**
 * @var \App\View\AppView $this
 * @var string $activation_key
 * @var string $username
 */
?>
<p><?= __('Hello') ?> <b><?= $username; ?></b>,</p>

<p><?= __('To change your email click on the following link or copy-paste it in your browser:') ?></p>

<?php
$url = $this->Url->build('/', true) . 'member/users/change-email/' . $username . '/' . $activation_key;
?>

<p>
    <a href="<?= $url ?>"><?= $url ?></a>
</p>

<p>
    <?= __('Thanks,') ?><br>
    <?= h(get_option('site_name')) ?>
</p>
