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
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Date to anno transformer
 *
 * @todo A supprimer
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class DateToAnnoTransformer implements DataTransformerInterface
{

    /**
     * Array of allowed annos
     *
     * @var array
     */
    protected static $annos = array();

    public function __construct()
    {
        if (empty(self::$annos)) {
            self::initializeAnnosList();
        }
    }

    /**
     * Initialise the allowed annos
     */
    public static function initializeAnnosList()
    {
        $date        = new \DateTime('now');
        $anno        = $date->diff(new \DateTime('17-04-1987'))->format('%y') + 1;
        self::$annos = range(0, $anno);
    }

    /**
     * Get annos
     *
     * @return array
     */
    public static function getAnnosList()
    {
        if (empty(self::$annos)) {
            self::initializeAnnosList();
        }

        return self::$annos;
    }

    /**
     * Transforms an object (DateTime) to a string (number).
     *
     * @param  \Datetime|null $datetime
     * @return string
     * @todo  Vérifier se comportement ou tout du moins le commenter
     */
    public function transform($date)
    {

        $annos = self::$annos;

        if (null === $date) {
            return end($annos);
        }

        $anno = $date->diff(new \DateTime('17-04-1987'))->format('%y');

        return $anno;
    }

    /**
     * Transforms a string (number) to an object (DateTime).
     *
     * @param  string                        $anno
     * @return \DateTime|null
     * @throws TransformationFailedException if $anno is not defined
     */
    public function reverseTransform($anno)
    {
        if (null === $anno) {
            throw new TransformationFailedException(sprintf('L\'anno "%s" n\'existe pas à l\'ASBO', $anno));
        }

        $date = new \DateTime('17-04-1987');

        return $date->add(new \DateInterval('P'."$anno".'Y'));
    }
}
