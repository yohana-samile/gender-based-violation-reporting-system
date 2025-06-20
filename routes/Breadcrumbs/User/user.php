<?php
Breadcrumbs::for('backend.user', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Reporter'), route('backend.user'));
});

/*create admin */
Breadcrumbs::for('backend.create.user',function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Admins' ), route('backend.user'));
    $breadcrumbs->push(__('Create admin' ), route('backend.create.user'));
});

Breadcrumbs::for('backend.admin.domain',function($breadcrumbs, $user){
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('Admins' ), route('backend.user'));
    $breadcrumbs->push(__('label.admin_domains' ), route('backend.admin.domain', $user));
});

Breadcrumbs::for('backend.admin.email',function($breadcrumbs, $user){
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('label.admins' ), route('backend.user'));
    $breadcrumbs->push(__('label.admin_emails' ), route('backend.admin.email', $user));
});

/* view role user */
Breadcrumbs::for('backend.show.user', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('backend.role.index');
    $breadcrumbs->push(__('label.role_user'), route('backend.show.user', $user));
});
/* edit role user */
Breadcrumbs::for('backend.edit.user', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('backend.role.index');
    $breadcrumbs->push(__('label.edit_user'), route('backend.edit.user', $user));
});
/* activity role user */
Breadcrumbs::for('backend.user.activity', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('backend.role.index');
    $breadcrumbs->push(__('label.administrator.system.audits.caused_activity'), route('backend.user.activity', $user));
});
