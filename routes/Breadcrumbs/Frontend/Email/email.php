<?php
Breadcrumbs::for('frontend.email.managers', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('label.emails'), route('frontend.email.managers'));
});

