<?php
namespace Asbo\WhosWhoBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StringToAnnoTransformer implements DataTransformerInterface
{

    /**
     * Transforms an object (DateTime) to a string (number).
     *
     * @param  Issue|null $datetime
     * @return string
     */
    public function transform($date)
    {
        if($date instanceof \DateTime)
            return array('type' => (int) 1, 'date' => $date);
        else
            return array('type' => (int) 0, 'date' => $date);
    }

    /**
     * Transforms a string (number) to an object (DateTime).
     *
     * @param  string $anno
     * @return \DateTime|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($anno)
    {
        if($anno['type'] == 1)
        {
            $date = new \datetime($anno['date']);
            return $date;
        }
        else {
            return (int) $anno['date'];
        }
    }
}