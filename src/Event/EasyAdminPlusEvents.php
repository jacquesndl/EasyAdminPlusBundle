<?php

namespace Jacquesndl\EasyAdminPlusBundle\Event;

/**
 * @author Jacques de Lamballerie <jndl@protonmail.com>
 */
final class EasyAdminPlusEvents
{
    /** @Event("Symfony\Component\EventDispatcher\GenericEvent") */
    const USER_PRE_CREATE = 'jacquesndl.easy_admin_plus.user_pre_create';

    /** @Event("Symfony\Component\EventDispatcher\GenericEvent") */
    const USER_POST_CREATE = 'jacquesndl.easy_admin_plus.user_post_create';

    /** @Event("Symfony\Component\EventDispatcher\GenericEvent") */
    const USER_PRE_REMOVE = 'jacquesndl.easy_admin_plus.user_pre_remove';

    /** @Event("Symfony\Component\EventDispatcher\GenericEvent") */
    const USER_POST_REMOVE = 'jacquesndl.easy_admin_plus.user_post_remove';

    /** @Event("Symfony\Component\EventDispatcher\GenericEvent") */
    const USER_PRE_ENABLE = 'jacquesndl.easy_admin_plus.user_pre_enable';

    /** @Event("Symfony\Component\EventDispatcher\GenericEvent") */
    const USER_POST_ENABLE = 'jacquesndl.easy_admin_plus.user_post_enable';

    /** @Event("Symfony\Component\EventDispatcher\GenericEvent") */
    const USER_PRE_DISABLE = 'jacquesndl.easy_admin_plus.user_pre_disable';

    /** @Event("Symfony\Component\EventDispatcher\GenericEvent") */
    const USER_POST_DISABLE = 'jacquesndl.easy_admin_plus.user_post_disable';

    /** @Event("Symfony\Component\EventDispatcher\GenericEvent") */
    const USER_PRE_UPDATE_ROLES = 'jacquesndl.easy_admin_plus.user_pre_update_roles';

    /** @Event("Symfony\Component\EventDispatcher\GenericEvent") */
    const USER_POST_UPDATE_ROLES = 'jacquesndl.easy_admin_plus.user_post_update_roles';

    /** @Event("Symfony\Component\EventDispatcher\GenericEvent") */
    const USER_PRE_CHANGE_PASSWORD = 'jacquesndl.easy_admin_plus.user_pre_update_password';

    /** @Event("Symfony\Component\EventDispatcher\GenericEvent") */
    const USER_POST_CHANGE_PASSWORD = 'jacquesndl.easy_admin_plus.user_post_update_password';
}
