<?php

namespace Wikidot\DB;


use Illuminate\Support\Facades\Cache;
use Wikidot\Utils\GlobalProperties;
use Ozone\Framework\Ozone;
use Wikidot\Utils\WDRenderUtils;
use Wikijump\Models\User;

/**
 * Object Model Class.
 *
 */
class Notification extends NotificationBase
{

    /**
     * Generates notification title based on the type
     */
    public function getTitle()
    {
        $title = null;
        $type = $this->getType();
        $title = match ($type) {
            'new_private_message' => _("New private message"),
            'new_membership_invitation' => _("New membership invitation"),
            'removed_from_members' => _("Membership removal"),
            'added_to_moderators' => _("Added to moderators"),
            'removed_from_moderators' => _("Removed from moderators"),
            'added_to_administrators' => _("Added to administrators"),
            'removed_from_administrators' => _("Removed from administrators"),
            'membership_application_accepted' => _("Membership application accepted"),
            'membership_application_declined' => _("Membership application declined"),
            default => $title,
        };

        return $title;
    }

    public function setExtra($data, $raw = false)
    {
        parent::setExtra(serialize($data));
    }

    public function getExtra()
    {
        return unserialize(pg_unescape_bytea(parent::getExtra()));
    }

    public function save()
    {
        $key = "notificationsfeed..".$this->getUserId();
        Cache::forget($key);
        return parent::save();
    }

    public function getBody()
    {

        $body = null;
        if (parent::getBody() != "") {
            return parent::getBody();
        }

        $type = $this->getType();
        $extra = $this->getExtra();
        $lang = OZONE::getRunData()->getLanguage();

        switch ($type) {
            case 'new_private_message':
                $fromUser = User::find($extra['from_user_id']);
                $body = _('You have a new private message in your <a href="'.GlobalProperties::$HTTP_SCHEMA . "://" . GlobalProperties::$URL_HOST . '/account:you/start/messages">Inbox</a>.').'<br/>';
                $body .= _("From").": ".WDRenderUtils::renderUser($fromUser)."<br/>";
                $body .= _('Subject').': <a href="'.GlobalProperties::$HTTP_SCHEMA . "://" . GlobalProperties::$URL_HOST . '/account:you/start/messages/inboxmessage/'.$extra['message_id'].'">'.htmlspecialchars($extra['subject']).'</a><br/>';
                $body .= _('Preview (first few words)').': '.$extra['preview'];
                break;
            case 'new_membership_invitation':
                $body = _('You have received an invitation to join members of the site').' <a href="'.GlobalProperties::$HTTP_SCHEMA . "://" . $extra['site_domain'].'">"'.htmlspecialchars($extra['site_name']).'"</a>.';
                break;
            case 'removed_from_members':
                $body = _('You have been removed from members of the site').' <a href="'.GlobalProperties::$HTTP_SCHEMA . "://" . $extra['site_domain'].'">"'.htmlspecialchars($extra['site_name']).'"</a>.';
                break;
            case 'added_to_moderators':
                $body = _('You have been added to moderators of the site').' <a href="'.GlobalProperties::$HTTP_SCHEMA . "://" . $extra['site_domain'].'">"'.htmlspecialchars($extra['site_name']).'"</a>.';
                break;
            case 'removed_from_moderators':
                $body = _('You have been removed from moderators of the site').' <a href="'.GlobalProperties::$HTTP_SCHEMA . "://" . $extra['site_domain'].'">"'.htmlspecialchars($extra['site_name']).'"</a>.';
                break;
            case 'added_to_administrators':
                $body = _('You have been added to administrators of the site').' <a href="'.GlobalProperties::$HTTP_SCHEMA . "://" . $extra['site_domain'].'">"'.htmlspecialchars($extra['site_name']).'"</a>.';
                break;
            case 'removed_from_administrators':
                $body = _('You have been removed from administrators of the site').' <a href="'.GlobalProperties::$HTTP_SCHEMA . "://" . $extra['site_domain'].'">"'.htmlspecialchars($extra['site_name']).'"</a>.';
                break;
            case 'membership_application_accepted':
                $body = _('Your membership application to the site').' <a href="'.GlobalProperties::$HTTP_SCHEMA . "://" . $extra['site_domain'].'">"'.htmlspecialchars($extra['site_name']).'"</a>.'.
                    'has been accepted. You are now a member of this site.';
                break;
            case 'membership_application_declined':
                $body = _('Your membership application to the site').' <a href="'.GlobalProperties::$HTTP_SCHEMA . "://" . $extra['site_domain'].'">"'.htmlspecialchars($extra['site_name']).'"</a>.'.
                    'has been declined.';
                break;
        }
        return $body;
    }

    public function getUrls()
    {
        $urls = null;
        $type = $this->getType();
        $extra = $this->getExtra();
        if ($extra['urls']) {
            return  $extra['urls'];
        }

        $lang = OZONE::getRunData()->getLanguage();

        $urls = match ($type) {
            'new_private_message' => array(  array(_('read the message'),GlobalProperties::$HTTP_SCHEMA . "://" . GlobalProperties::$URL_HOST . '/account:you/start/messages/inboxmessage/'.$extra['message_id']),
                            array(_('inbox folder'), GlobalProperties::$HTTP_SCHEMA . "://" . GlobalProperties::$URL_HOST . '/account:you/start/messages')),
            'new_membership_invitation' => array(array(_('view invitation'), GlobalProperties::$HTTP_SCHEMA . "://" . GlobalProperties::$URL_HOST . '/account:you/start/invitations')),
            'removed_from_members' => array(array(_('sites you are a member of'), GlobalProperties::$HTTP_SCHEMA . "://" . GlobalProperties::$URL_HOST . '/account:you/start/memberof')),
            'added_to_moderators' => array(array(_('sites you moderate'), GlobalProperties::$HTTP_SCHEMA . "://" . GlobalProperties::$URL_HOST . '/account:you/start/moderatorof')),
            'removed_from_moderators' => array(array(_('sites you moderate'), GlobalProperties::$HTTP_SCHEMA . "://" . GlobalProperties::$URL_HOST . '/account:you/start/moderatorof')),
            'added_to_administrators' => array(array(_('sites you administer'), GlobalProperties::$HTTP_SCHEMA . "://" . GlobalProperties::$URL_HOST . '/account:you/start/adminof')),
            'removed_from_administrators' => array(array(_('sites you administer'), GlobalProperties::$HTTP_SCHEMA . "://" . GlobalProperties::$URL_HOST . '/account:you/start/adminof')),
            'membership_application_accepted' => array(  array(_('your applications'), GlobalProperties::$HTTP_SCHEMA . "://" . GlobalProperties::$URL_HOST . '/account:you/start/applications'),
                    array(_('sites you are a member of'), GlobalProperties::$HTTP_SCHEMA . "://" . GlobalProperties::$URL_HOST . '/account:you/start/memberof')),
            'membership_application_declined' => array(  array(_('your applications'), GlobalProperties::$HTTP_SCHEMA . "://" . GlobalProperties::$URL_HOST . '/account:you/start/applications'),
                    array(_('sites you are a member of'), GlobalProperties::$HTTP_SCHEMA . "://" . GlobalProperties::$URL_HOST . '/account:you/start/memberof')),
            default => $urls,
        };
        return $urls;
    }

    public function getLocalizedExtra()
    {
        $extra =    unserialize(parent::getExtra());
        // ???
    }
}
