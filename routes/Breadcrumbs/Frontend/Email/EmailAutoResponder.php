<?php

Breadcrumbs::for('backend.email_auto_responder.index', function ($breadcrumbs) {
    $breadcrumbs->parent('backend.dashboard');
    $breadcrumbs->push(__('label.email_auto_responder'), route('backend.email_auto_responder.index'));
});

/*Create*/
Breadcrumbs::for('backend.email_auto_responder.create', function ($breadcrumbs) {
    $breadcrumbs->parent('backend.email_auto_responder.index');
    $breadcrumbs->push(__('label.crud.create'), route('backend.email_auto_responder.create'));
});

/*Edit*/
Breadcrumbs::for('backend.email_auto_responder.edit', function ($breadcrumbs, $EmailAutoResponder) {
    $breadcrumbs->parent('backend.email_auto_responder.index');
    $breadcrumbs->push(__('label.crud.edit'), route('backend.email_auto_responder.edit', $EmailAutoResponder));
});

/*Profile*/
Breadcrumbs::for('backend.email_auto_responder.profile', function ($breadcrumbs, $EmailAutoResponder) {
    $breadcrumbs->parent('backend.email_auto_responder.index');
    $breadcrumbs->push(__('label.crud.profile'), route('backend.email_auto_responder.profile', $EmailAutoResponder));
});
