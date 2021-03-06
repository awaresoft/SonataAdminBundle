<?php

namespace Awaresoft\Sonata\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class LanguageController extends Controller
{
    /**
     * @Route("change/{locale}", name="sonata_admin_language_change")
     * @param Request $request
     * @param $locale
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changeAction(Request $request, $locale)
    {
        $siteSelector = $this->get('sonata.page.site.selector');
        $siteManager = $this->get('sonata.page.manager.site');
        $site = $siteManager->findOneBy([
            'locale' => $locale,
        ]);

        if (!$site) {
            $this->createAccessDeniedException('Language not found');
        }

        $request->getSession()->set('_locale', $locale);
        $request->setLocale($locale);

        return $this->redirect($siteSelector->getRequestContext()->getBaseUrl() . $request->headers->get('referer'));
    }
}
