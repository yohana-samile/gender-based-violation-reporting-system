<?php
Breadcrumbs::for('gbv.user', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Incident'), route('gbv.incident.index'));
});

Breadcrumbs::for('gbv.incident.create',function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Incident' ), route('gbv.incident.index'));
    $breadcrumbs->push(__('Create Incident' ), route('gbv.incident.create'));
});

Breadcrumbs::for('gbv.show.incident', function ($breadcrumbs, $incident) {
    $breadcrumbs->parent('gbv.incident.index');
    $breadcrumbs->push(__('Show Incident'), route('gbv.incident.show', $incident));
});
Breadcrumbs::for('gbv.edit.incident', function ($breadcrumbs, $incident) {
    $breadcrumbs->parent('gbv.incident.index');
    $breadcrumbs->push(__('Edit incident'), route('gbv.incident.edit', $incident));
});

