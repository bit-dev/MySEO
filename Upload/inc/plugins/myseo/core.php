<?php

class Core
{
    private $language;
    private $howToInstall;
    public $description;

    public function getLanguageID()
    {
        global $mybb;
        if ($mybb->settings['bblanguage'] == 'espanol') {
            return 'es';
        } else {
            return 'en';
        }
    }

    public function getDescription()
    {
        global $mybb, $db, $lang;

        $this->description = $lang->pluginDescription.'<br/>';

        $this->description .= '<a target="_blank" href="https://github.com/bit-dev/MySEO/">'.$lang->howToInstall.'</a></span>';
        $this->description .= ' | <a target="_blank" href="index.php?module=config&action=change&search=myseo">'.$lang->settingsLink.'</a> |';

        $this->description .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" style="display: inline;">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="FEC8RBQ2DJUCW">
            <input type="hidden" name="os0" value="Donacion 1">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="on0" value="Donaciones">
            <input alt="'.$lang->Cafe.'" title="'.$lang->Cafe.'" style="max-height: 20px; vertical-align: -5px; margin-left: 10px;" type="image" src="'.$mybb->settings['bburl'].'/inc/plugins/myseo/images/donar.'.$this->getLanguageID().'.gif" border="0" name="submit" alt="Donar">
            <img border="0" src="https://www.paypalobjects.com/es_ES/i/scr/pixel.gif" width="1" height="1">
        </form>';

        return $this->description;
    }

    public function installTemplates(){
        global $db, $lang;

        $insertarray = array(
            'title' => 'seo_forumdisplay',
            'template' => $db->escape_string("<meta content=\"index,follow\" name=\"robots\"/>
    <meta property=\"og:type\" content=\"forum\"/>
    <meta property=\"og:image\" content=\"{\$mybb->settings['urlLogoFB']}\"/>
    <meta name=\"twitter:site\" content=\"{\$mybb->settings['sitioTwitter']}\">
    <meta name=\"twitter:image\" content=\"{\$mybb->settings['urlLogoTW']}\">"),
            'sid' => -1,
            'dateline' => TIME_NOW,
        );
        $db->insert_query('templates', $insertarray);

        $insertarray = array(
            'title' => 'seo_index',
            'template' => $db->escape_string("<title>{\$mybb->settings['bbname']} | {\$mybb->settings['miniDescripcion']}</title>
    <meta name=\"description\" content=\"{\$mybb->settings['meta_descripcion']}\"/>
    <meta content=\"index,follow\" name=\"robots\"/>
    <meta property=\"og:type\" content=\"forum\"/>
    <meta property=\"og:description\" content=\"{\$mybb->settings['meta_descripcion']}\"/>
    <meta property='og:image' content=\"{\$mybb->settings['urlLogoFB']}\"/>
    <meta property=\"og:title\" content=\"{\$mybb->settings['bbname']} | {\$mybb->settings['miniDescripcion']}\" />
    <meta name=\"twitter:title\" content=\"{\$mybb->settings['bbname']} | {\$mybb->settings['miniDescripcion']}\">
    <meta name=\"twitter:description\" content=\"{\$mybb->settings['meta_descripcion']}\">
    <meta name=\"twitter:image\" content=\"{\$mybb->settings['urlLogoTW']}\">"),
            'sid' => -1,
            'dateline' => TIME_NOW,
        );
        $db->insert_query('templates', $insertarray);

        $insertarray = array(
            'title' => 'seo_member',
            'template' => $db->escape_string('<meta content="noindex,nofollow" name="robots"/>'),
            'sid' => -1,
            'dateline' => TIME_NOW,
        );
        $db->insert_query('templates', $insertarray);

        $insertarray = array(
            'title' => 'seo_footer',
            'template' => $db->escape_string("<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', '{\$mybb->settings['idAnalytics']}', 'auto');
      ga('send', 'pageview');

    </script>"),
            'sid' => -1,
            'dateline' => TIME_NOW,
        );
        $db->insert_query('templates', $insertarray);
    }

    public function installSettings(){
        global $db, $lang;

        // General SEO OnPage.
        $settings_group = array(
            'gid' => 'NULL',
            'name' => 'myseo',
            'title' => $lang->settingsSEOOnpage,
            'description' => $lang->settingsSEOOnpageDescription,
            'disporder' => '0',
            'isdefault' => 'no',
        );
        $gid = $db->insert_query('settinggroups', $settings_group);

        $setting = array(
            'sid' => 'NULL',
            'name' => 'slogan',
            'title' => $lang->slogan,
            'description' => $lang->sloganDescription,
            'optionscode' => 'textarea',
            'disporder' => '0',
            'gid' => intval($gid),
        );
        $db->insert_query('settings', $setting);

        $setting = array(
            'sid' => 'NULL',
            'name' => 'metaDescription',
            'title' => $lang->metaDescription,
            'description' => $lang->metaDescriptionDescription,
            'optionscode' => 'textarea',
            'disporder' => '1',
            'gid' => intval($gid),
        );
        $db->insert_query('settings', $setting);

        $setting = array(
            'sid' => 'NULL',
            'name' => 'keywords',
            'title' => $lang->keywords,
            'description' => $lang->keywordsDescription,
            'optionscode' => 'text',
            'disporder' => '2',
            'gid' => intval($gid),
        );
        $db->insert_query('settings', $setting);

        $setting = array(
            'sid' => 'NULL',
            'name' => 'googleVerification',
            'title' => $lang->googleVerification,
            'description' => $lang->googleVerificationDescription.'<br/><br/> <b style="font-size:16px;color:#27AE60;">'.$lang->good.'</b> <span style="background:#FFF;padding:0px 5px;border:1px solid #D9D9D9;border-radius:5px;font-family:Courier;" >6NO94briBMDv6s_mJCx9lJpPYWfl$oXGmEBSGVX3PaY </span><br/> <b style="font-size:16px;color:#c0392b;">'.$lang->bad.'</b> <span style="background:#FFF;padding:0px 5px;border:1px solid #D9D9D9;border-radius:5px;font-family:Courier;" >&lt;meta name=&quot;google-site-verification&quot; content=&quot;6NO94briBMDv6s_mJCx9lJpPYWfl$oXGmEBSGVX3PaY&quot;/&gt; </span>',
            'optionscode' => 'text',
            'disporder' => '3',
            'gid' => intval($gid),
        );
        $db->insert_query('settings', $setting);

        $setting = array(
            'sid' => 'NULL',
            'name' => 'bingYahooVerification',
            'title' => $lang->bingYahooVerification,
            'description' => $lang->bingYahooVerificationDescription.'<br/><br/> <b style="font-size:16px;color:#27AE60;">'.$lang->good.'</b> <span style="background:#FFF;padding:0px 5px;border:1px solid #D9D9D9;border-radius:5px;font-family:Courier;" >11498CA0879048F6A573982A8F59D89 </span><br/> <b style="font-size:16px;color:#c0392b;">'.$lang->bad.'</b> <span style="background:#FFF;padding:0px 5px;border:1px solid #D9D9D9;border-radius:5px;font-family:Courier;" >&lt;meta name=&quot;msvalidate.01&quot; content=&quot;11498CA0879048F6A573982A8F59D89&quot;/&gt; </span>',
            'optionscode' => 'text',
            'disporder' => '4',
            'gid' => intval($gid),
        );
        $db->insert_query('settings', $setting);

        $setting = array(
            'sid' => 'NULL',
            'name' => 'alexaVerification',
            'title' => $lang->alexaVerification,
            'description' => $lang->alexaVerificationDescription.'<br/><br/> <b style="font-size:16px;color:#27AE60;">'.$lang->good.'</b> <span style="background:#FFF;padding:0px 5px;border:1px solid #D9D9D9;border-radius:5px;font-family:Courier;" >KzZWFeVVKe2I1saGWy-IPAKNiY1E </span><br/> <b style="font-size:16px;color:#c0392b;">'.$lang->bad.'</b> <span style="background:#FFF;padding:0px 5px;border:1px solid #D9D9D9;border-radius:5px;font-family:Courier;" >&lt;meta name=&quot;alexaVerifyID&quot; content=&quot;KzsaWFeVVKe2I1xGWy-IPAKNiY1E&quot;/&gt; </span>',
            'optionscode' => 'text',
            'disporder' => '5',
            'gid' => intval($gid),
        );
        $db->insert_query('settings', $setting);

        $setting = array(
            'sid' => 'NULL',
            'name' => 'usersFollow',
            'title' => $lang->usersFollow,
            'description' => $lang->usersFollowDescrition,
            'optionscode' => 'onoff',
            'value' => '1',
            'disporder' => '6',
            'gid' => intval($gid),
        );
        $db->insert_query('settings', $setting);

        $setting = array(
            'sid' => 'NULL',
            'name' => 'idAnalytics',
            'title' => $lang->idAnalytics,
            'description' => $lang->idAnalyticsDescription,
            'optionscode' => 'text',
            'disporder' => '7',
            'gid' => intval($gid),
        );
        $db->insert_query('settings', $setting);

        $setting = array(
                'sid' => 'NULL',
                'name' => 'sitemapChangeFrequency',
                'title' => $lang->sitemapChangeFrequency,
                'description' => $lang->sitemapChangeFrequencyDescription,
                'optionscode' => 'radio \nalways='.$lang->Siempre.' \nhourly='.$lang->Horario.' \ndaily='.$lang->Diario.' \nweekly='.$lang->Semanal.' \nmonthly='.$lang->Mensual.' \nyearly='.$lang->Anual.' \nnever='.$lang->Nunca.'',
                'disporder' => '8',
                'gid' => intval($gid),
            );
        $db->insert_query('settings', $setting);

        $setting = array(
                'sid' => 'NULL',
                'name' => 'sitemapPriority',
                'title' => $lang->sitemapPriority,
                'description' => $lang->sitemapPriorityDescription,
                'optionscode' => 'select \n0.9=90% \n0.8=80% \n0.7=70% \n0.6=60% \n0.5=50% \n0.4=40% \n0.3=30% \n0.2=20% \n0.1=10%',
                'disporder' => '9',
                'gid' => intval($gid),
            );
        $db->insert_query('settings', $setting);

        // NoFollow
        $settings_group = array(
            'gid' => 'NULL',
            'name' => 'myseonf',
            'title' => $lang->settingsMySEONoFollow,
            'description' => $lang->settingsMySEONoFollowDescription,
            'disporder' => '1',
            'isdefault' => 'no',
        );
        $gid = $db->insert_query('settinggroups', $settings_group);

        $setting = array(
            'sid' => 'NULL',
            'name' => 'activarNofollow',
            'title' => $lang->activarNofollow,
            'description' => $lang->activarNofollow_descripcion,
            'optionscode' => 'onoff',
            'value' => 1,
            'disporder' => '1',
            'gid' => intval($gid),
        );
        $db->insert_query('settings', $setting);

        $setting = array(
            'sid' => 'NULL',
            'name' => 'quitarNofollow',
            'title' => $lang->quitarNofollow,
            'description' => $lang->quitarNofollow_descripcion,
            'optionscode' => 'textarea',
            'value' => 'wikipedia.org\ngoogle.com',
            'disporder' => '2',
            'gid' => intval($gid),
        );
        $db->insert_query('settings', $setting);

        // Social Networks Integration
        $settings_group = array(
            'gid' => 'NULL',
            'name' => 'myseosm',
            'title' => $lang->settingsSocialMedia,
            'description' => $lang->settingsSocialMediaDescription,
            'disporder' => '2',
            'isdefault' => 'no',
        );
        $gid = $db->insert_query('settinggroups', $settings_group);

        $setting = array(
            'sid' => 'NULL',
            'name' => 'urlLogoSM',
            'title' => $lang->urlLogoSM,
            'description' => $lang->urlLogoSMDescription,
            'optionscode' => 'text',
            'disporder' => '0',
            'gid' => intval($gid),
        );
        $db->insert_query('settings', $setting);

        $setting = array(
            'sid' => 'NULL',
            'name' => 'facebookPage',
            'title' => $lang->facebookPage,
            'description' => $lang->facebookPageDescription,
            'optionscode' => 'text',
            'disporder' => '1',
            'gid' => intval($gid),
        );
        $db->insert_query('settings', $setting);

        $setting = array(
            'sid' => 'NULL',
            'name' => 'twitterUser',
            'title' => $lang->twitterUser,
            'description' => $lang->twitterUserDescription,
            'optionscode' => 'text',
            'disporder' => '2',
            'gid' => intval($gid),
        );
        $db->insert_query('settings', $setting);

        $setting = array(
            'sid' => 'NULL',
            'name' => 'googlePage',
            'title' => $lang->googlePage,
            'description' => $lang->googlePageDescription,
            'optionscode' => 'text',
            'disporder' => '4',
            'gid' => intval($gid),
        );
        $db->insert_query('settings', $setting);

        $setting = array(
            'sid' => 'NULL',
            'name' => 'pinterestProfile',
            'title' => $lang->pinterestProfile,
            'description' => $lang->pinterestProfile.'<br/><br/> <b style="font-size:16px;color:#27AE60;">'.$lang->good.'</b> <span style="background:#FFF;padding:0px 5px;border:1px solid #D9D9D9;border-radius:5px;font-family:Courier;" >8819237419234-h1j23k4h </span><br/> <b style="font-size:16px;color:#c0392b;">'.$lang->bad.'</b> <span style="background:#FFF;padding:0px 5px;border:1px solid #D9D9D9;border-radius:5px;font-family:Courier;" >&lt;meta name=&quot;p:domain_verify&quot; content=&quot;8819237419234-h1j23k4h&quot;/&gt; </span><br/>  ',
            'optionscode' => 'text',
            'disporder' => '5',
            'gid' => intval($gid),
        );
        $db->insert_query('settings', $setting);
    }
}