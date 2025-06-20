<?php
Breadcrumbs::for('gbv.report.reports', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Reports'), route('gbv.report.reports'));
});


