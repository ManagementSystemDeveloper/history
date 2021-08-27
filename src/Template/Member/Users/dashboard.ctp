<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $CurrentMonthDays
 * @var array $_SESSION
 * @var \App\Model\Entity\Announcement[]|\Cake\Collection\CollectionInterface $announcements
 * @var mixed $domains_auth_urls
 * @var object $logged_user_plan
 * @var mixed $newLinks
 * @var mixed $popularLinks
 * @var string $total_bundles
 * @var string $total_clicks
 * @var string $total_links
 * @var mixed $year_month
 */
$this->assign('title', __('Dashboard'));
$this->assign('description', '');
$this->assign('content_title', __('Dashboard'));
?>

<div class="text-center">
    <div style="display: inline-block;">
        <?=
        $this->Form->create(null, [
            'type' => 'get',
            'url' => ['controller' => 'Users', 'action' => 'dashboard'],
        ]);
        ?>

        <?=
        $this->Form->control('month', [
            'label' => false,
            'options' => $year_month,
            'value' => ($this->request->getQuery('month')) ? h($this->request->getQuery('month')) : '',
            'class' => 'form-control input-lg',
            'onchange' => 'this.form.submit();',
            'style' => 'width: 300px;',
        ]);
        ?>

        <?= $this->Form->button(__('Submit'), ['class' => 'hidden']); ?>

        <?= $this->Form->end(); ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?= $total_links; ?></h3>
                <p><?= __('Total Links') ?></p>
            </div>
            <div class="icon">
                <i class="fa fa-link"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?= $total_clicks; ?></h3>
                <p><?= __('Total Clicks') ?></p>
            </div>
            <div class="icon">
                <i class="fa fa-bar-chart-o"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?= $total_bundles ?></h3>
                <p><?= __('Total Bundles') ?></p>
            </div>
            <div class="icon">
                <i class="fa fa-tags"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?= h($logged_user_plan->title) ?></h3>
                <p><?= __('Plan') ?></p>
            </div>
            <div class="icon">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </div>
    <!-- ./col -->
</div>

<?php if (count($announcements) > 0) : ?>
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-bullhorn"></i>
            <h3 class="box-title"><?= __("Announcements") ?></h3>
        </div>
        <div class="box-body chat">
            <?php foreach ($announcements as $announcement) : ?>
                <div class="item">
                    <p class="announcement">
                            <span>
                                <small class="text-muted pull-right"><i class="fa fa-clock-o"></i>
                                    <?= h($announcement->created); ?></small>
                                <i class="fa fa-angle-double-right"></i> <b><?= h($announcement->title); ?></b>
                            </span>

                        <?= $announcement->content; ?>
                    </p>
                </div>
            <?php endforeach; ?>
            <?php unset($announcement) ?>
        </div>
    </div>
<?php endif; ?>

<div class="box box-primary">
    <div class="box-header with-border">
        <i class="fa fa-bar-chart"></i>
        <h3 class="box-title"><?= __('Statistics') ?></h3>
    </div>
    <div class="box-body no-padding">
        <div id="chart_div" style="position: relative; height: 300px; width: 100%;"></div>
        <div style="height: 300px;overflow: auto;">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th><?= __('Date') ?></th>
                    <th><?= __('Views') ?></th>
                </tr>
                </thead>
                <?php foreach ($CurrentMonthDays as $key => $value) : ?>
                    <tr>
                        <td><?= $key ?></td>
                        <td><?= $value['view'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="box box-solid box-primary">
            <div class="box-header">
                <span class="glyphicon glyphicon-link"></span>
                <h3 class="box-title"><?= __("New Short URLs") ?></h3>
            </div>
            <div class="box-body">
                <ul class="list-group" style="height: 300px; overflow: auto;">
                    <?php foreach ($newLinks as $newLink) : ?>
                        <?php
                        $short_url = get_short_url($newLink->alias, $newLink->domain);

                        $title = $newLink->alias;
                        if (!empty($newLink->title)) {
                            $title = $newLink->title;
                        }
                        ?>
                        <li class="list-group-item">
                            <h4 class="list-group-item-heading">
                                <a href="<?= h($newLink->url); ?>" target="_blank">
                                    <i class="fa fa-angle-double-right"></i> <?= h($title); ?>
                                </a>
                            </h4>
                            <div class="list-group-item-text">
                                <small class="text-muted">
                                    <i class="fa fa-calendar"></i> <?= display_date_timezone($newLink->created) ?> -
                                    <a target="_blank" href="<?= h($newLink->url); ?>"
                                       rel="nofollow noopener noreferrer">
                                        <?= strtoupper(parse_url(
                                            $newLink->url,
                                            PHP_URL_HOST
                                        )); ?>
                                    </a> -
                                    <i class="fa fa-hand-o-up"></i> <?= $newLink->clicks; ?> <?= __("Clicks") ?> -
                                    <i class="fa fa-user"></i> <?= $newLink->user->username; ?>
                                </small>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control input-sm" id=""
                                               value="<?= $short_url; ?>" readonly onfocus="javascript:this.select()">
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="text-right">
                                            <?=
                                            $this->Html->link(
                                                   '<i class="fa fa-edit"></i> ' . __("Edit"),
                                                   ['controller' => 'links', 'action' => 'edit', $newLink->alias],
                                                   ['escape' => false, 'class' => 'btn btn-primary btn-xs']
                                               );
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach;
                    unset($newLink); ?>
                </ul>
            </div><!-- /.box-body -->
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box box-solid box-success">
            <div class="box-header">
                <span class="glyphicon glyphicon-fire"></span>
                <h3 class="box-title"><?= __("Popular Short URLs") ?></h3>
            </div>
            <div class="box-body">
                <ul class="list-group" style="height: 300px; overflow: auto;">
                    <?php foreach ($popularLinks as $popularLink) : ?>
                        <?php
                        $short_url = get_short_url($popularLink->alias, $popularLink->domain);

                        $title = $popularLink->alias;
                        if (!empty($popularLink->title)) {
                            $title = $popularLink->title;
                        }
                        ?>
                        <li class="list-group-item">
                            <h4 class="list-group-item-heading">
                                <a href="<?= h($popularLink->url); ?>" target="_blank">
                                    <i class="fa fa-angle-double-right"></i> <?= h($title); ?>
                                </a>
                            </h4>
                            <div class="list-group-item-text">
                                <small class="text-muted">
                                    <i class="fa fa-calendar"></i> <?= display_date_timezone($popularLink->created) ?> -
                                    <a target="_blank" href="<?= h($popularLink->url); ?>"
                                       rel="nofollow noopener noreferrer">
                                        <?= strtoupper(parse_url(
                                            $popularLink->url,
                                            PHP_URL_HOST
                                        )); ?>
                                    </a> -
                                    <i class="fa fa-hand-o-up"></i> <?= $popularLink->clicks; ?> <?= __("Clicks") ?> -
                                    <i class="fa fa-user"></i> <?= $popularLink->user->username; ?>
                                </small>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control input-sm" id=""
                                               value="<?= $short_url; ?>" readonly onfocus="javascript:this.select()">
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="text-right">
                                            <?= $this->Html->link(
                                                   '<i class="fa fa-edit"></i> ' . __("Edit"),
                                                   ['controller' => 'links', 'action' => 'edit', $popularLink->alias],
                                                   ['escape' => false, 'class' => 'btn btn-primary btn-xs']
                                               ); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach;
                    unset($newLink); ?>
                </ul>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

<?php $this->start('scriptBottom'); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/almasaeed2010/AdminLTE@v2.3.11/plugins/morris/morris.css">
<script src="https://cdn.jsdelivr.net/gh/DmitryBaranovskiy/raphael@v2.1.0/raphael-min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/almasaeed2010/AdminLTE@v2.3.11/plugins/morris/morris.min.js"
        type="text/javascript"></script>

<script>
    jQuery(document).ready(function () {
        new Morris.Line({
            element: 'chart_div',
            resize: true,
            data: [
                <?php
                foreach ($CurrentMonthDays as $key => $value) {
                    $date = date("Y-m-d", strtotime($key));
                    echo '{date: "' . $date . '", views: ' . $value['view'] . '},';
                }

                ?>
            ],
            xkey: 'date',
            xLabels: 'day',
            ykeys: ['views'],
            labels: ['<?= __('Views') ?>'],
            lineColors: ['#3c8dbc'],
            lineWidth: 2,
            hideHover: 'auto',
            smooth: false
        });
    });
</script>


<?php $this->end(); ?>

