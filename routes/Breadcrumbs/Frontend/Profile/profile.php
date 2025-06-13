<?php
Breadcrumbs::for('frontend.profile.show', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('label.action_crud.profile'), route('frontend.profile.show'));
});

