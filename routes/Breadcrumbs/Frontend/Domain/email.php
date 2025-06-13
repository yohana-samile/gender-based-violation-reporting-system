<?php
Breadcrumbs::for('frontend.domain.index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('label.domains'), route('frontend.domain.index'));
});

