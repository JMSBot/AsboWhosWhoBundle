<?php
namespace Asbo\WhosWhoBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DateToAnnoTransformer implements DataTransformerInterface
{

    protected static $annos = array();

    /**
     * Construct
     */
    public function __construct()
    {
        if(empty(self::$annos))
            self::initializeAnnosList();
    }

    public static function initializeAnnosList()
    {
        $date        = new \DateTime('now');
        $anno        = $date->diff(new \DateTime('17-04-1987'))->format('%y') + 1;
        self::$annos = range(0, $anno);
    }

    public static function getAnnosList()
    {
        if(empty(self::$annos))
            self::initializeAnnosList();

        return self::$annos;
    }

    /**
     * Transforms an object (DateTime) to a string (number).
     *
     * @param  Issue|null $datetime
     * @return string
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
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($anno)
    {
        if (null === $anno) {
            throw new TransformationFailedException(sprintf(
                'L\'anno "%s" n\'existe pas à l\'ASBO',
                $anno
            ));
        }

        $date = new \DateTime('17-04-1987');

        return $date->add(new \DateInterval('P'."$anno".'Y'));
    }
}
