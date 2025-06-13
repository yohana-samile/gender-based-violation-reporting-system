<?php
Breadcrumbs::for('frontend.my_logs.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('label.administrator.system.audits.my_logs'), route('frontend.my_logs.index'));
});

/*Profile*/
Breadcrumbs::for('frontend.my_logs.profile', function ($breadcrumbs, $audit) {
    $breadcrumbs->parent('frontend.my_logs.index');
    $breadcrumbs->push(__('label.action_crud.profile'), route('frontend.my_logs.profile', $audit));
});
