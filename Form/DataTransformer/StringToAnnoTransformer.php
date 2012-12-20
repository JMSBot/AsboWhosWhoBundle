<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * String to anno transformer
 *
 * @todo Hum hum ! Revoir la manière de faire !
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class StringToAnnoTransformer implements DataTransformerInterface
{
    /**
     * Transforms an object ($date) to an array option
     *
     * @param  \Datetime|null $date
     * @return array
     */
    public function transform($date)
    {
        if ($date instanceof \DateTime) {
            return array('type' => (int) 1, 'date' => $date);
        } else {
            return array('type' => (int) 0, 'date' => $date);
        }
    }

    /**
     * Transforms an array options to an number|date
     *
     * @param  array          $anno
     * @return \DateTime|null
     */
    public function reverseTransform($anno)
    {
        if ($anno['type'] == 1) {
            return new \datetime($anno['date']);
        } else {
            return (int) $anno['date'];
        }
    }
}
