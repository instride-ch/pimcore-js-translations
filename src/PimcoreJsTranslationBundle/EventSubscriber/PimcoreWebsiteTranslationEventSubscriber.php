<?php
/**
 * Pimcore JavaScript Translations.
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2016-2019 w-vision AG (https://www.w-vision.ch)
 * @license    https://github.com/w-vision/PimcoreJsTranslationBundle/blob/master/LICENSE GNU General Public License version 3 (GPLv3)
 */

namespace Wvision\Bundle\PimcoreJsTranslationBundle\EventSubscriber;

use Pimcore\Event\Model\TranslationEvent;
use Pimcore\Event\TranslationEvents;
use Pimcore\Model\Translation;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Wvision\Bundle\PimcoreJsTranslationBundle\Filesystem\PimcoreTranslationGeneratorInterface;

class PimcoreWebsiteTranslationEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var PimcoreTranslationGeneratorInterface
     */
    private $translationGenerator;

    /**
     * @param PimcoreTranslationGeneratorInterface $translationGenerator
     */
    public function __construct(PimcoreTranslationGeneratorInterface $translationGenerator)
    {
        $this->translationGenerator = $translationGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            TranslationEvents::PRE_SAVE => 'onPreSave',
            TranslationEvents::PRE_DELETE => 'onPreDelete',
        ];
    }

    /**
     * @param TranslationEvent $event
     */
    public function onPreSave(TranslationEvent $event): void
    {
        $translation = $event->getTranslation();

        if (!$translation instanceof Translation\Website) {
            return;
        }

        $this->translationGenerator->update($translation);
    }

    /**
     * @param TranslationEvent $event
     */
    public function onPreDelete(TranslationEvent $event): void
    {
        $translation = $event->getTranslation();

        if (!$translation instanceof Translation\Website) {
            return;
        }

        $this->translationGenerator->remove($translation);
    }
}
